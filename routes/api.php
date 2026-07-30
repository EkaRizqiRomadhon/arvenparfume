<?php

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Cek stok produk (publik, tanpa autentikasi)
Route::get('/stock/{product}', function (Product $product) {
    return response()->json([
        'id'    => $product->id,
        'name'  => $product->name,
        'stock' => $product->stock,
    ]);
});
