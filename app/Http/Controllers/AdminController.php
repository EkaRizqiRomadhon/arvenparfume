<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Checkout;
use App\Models\ContactMessage;
use App\Models\Product;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_orders'    => Checkout::count(),
            'pending_orders'  => Checkout::where('status', 'pending')->count(),
            'total_brands'    => Brand::count(),
            'total_products'  => Product::count(),
            'unread_contacts' => ContactMessage::unread()->count(),
            'total_users'     => User::where('role', 'user')->count(),
            'active_users'    => User::where('role', 'user')->where('is_active', true)->count(),
            'recent_orders'   => Checkout::with('user')->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
