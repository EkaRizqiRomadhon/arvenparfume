<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\CheckoutItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $checkouts = Checkout::with('items')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return $request->wantsJson()
            ? response()->json($checkouts)
            : view('checkout.history', compact('checkouts'));
    }

    public function process(Request $request)
    {
        $cart = $request->input('cart');

        if (empty($cart)) {
            return response()->json(['error' => 'Keranjang kosong'], 400);
        }

        $dbItems     = array_filter($cart, fn($item) => is_numeric($item['id']));
        $orderId     = 'INV-' . strtoupper(Str::random(10));
        $grossAmount = 0;

        DB::beginTransaction();
        try {
            // Pessimistic lock — mencegah overselling saat checkout bersamaan.
            $outOfStock = [];
            foreach ($dbItems as $item) {
                $qty     = (int) ($item['qty'] ?? $item['quantity'] ?? 1);
                $product = Product::lockForUpdate()->find($item['id']);

                if (!$product) continue;

                if ($product->stock <= 0) {
                    $outOfStock[] = "{$product->name} (stok habis)";
                } elseif ($product->stock < $qty) {
                    $outOfStock[] = "{$product->name} (tersisa {$product->stock}, diminta {$qty})";
                }
            }

            if (!empty($outOfStock)) {
                DB::rollBack();
                return response()->json([
                    'error'        => 'Beberapa produk tidak tersedia: ' . implode(', ', $outOfStock),
                    'out_of_stock' => $outOfStock,
                ], 422);
            }

            foreach ($cart as $item) {
                $qty          = (int) ($item['qty'] ?? $item['quantity'] ?? 0);
                $grossAmount += $item['price'] * $qty;

                if (is_numeric($item['id'])) {
                    Product::where('id', $item['id'])->decrement('stock', $qty);
                }
            }

            $checkout = Checkout::create([
                'user_id'      => auth()->id(),
                'order_id'     => $orderId,
                'gross_amount' => $grossAmount,
                'status'       => 'success',
                'snap_token'   => 'SIMULATION-' . Str::random(20),
                'payment_type' => 'simulation',
            ]);

            foreach ($cart as $item) {
                $qty = (int) ($item['qty'] ?? $item['quantity'] ?? 0);
                CheckoutItem::create([
                    'checkout_id' => $checkout->id,
                    'product_id'  => is_numeric($item['id']) ? $item['id'] : null,
                    'name'        => $item['name'],
                    'price'       => $item['price'],
                    'quantity'    => $qty,
                    'subtotal'    => $item['price'] * $qty,
                ]);
            }

            DB::commit();
            Log::info('Checkout success', ['order_id' => $orderId, 'user_id' => auth()->id()]);

            return response()->json([
                'success'   => true,
                'message'   => 'Pesanan berhasil dibuat',
                'orderId'   => $orderId,
                'snapToken' => $checkout->snap_token,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Terjadi kesalahan saat memproses pesanan.'], 500);
        }
    }

    public function notification(Request $request)
    {
        return response()->json(['status' => 'simulation_mode_active']);
    }
}
