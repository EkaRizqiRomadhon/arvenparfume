<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CheckoutController;

// Autentikasi
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])
    ->middleware('throttle:5,1')
    ->name('register.attempt');

// Kontak
Route::post('/contact/send', [ContactController::class, 'store'])->name('contact.send');

// Halaman publik
Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/koleksi', function () {
    $brands = \App\Models\Brand::withCount('products')->get();
    return view('koleksi', compact('brands'));
})->name('koleksi');

Route::get('/koleksi/{brand}', function ($brand) {
    $brandModel = \App\Models\Brand::where('slug', $brand)->with('products')->first();

    abort_unless($brandModel, 404);

    return view('brand_page.dynamic', [
        'brand'    => $brandModel,
        'products' => $brandModel->products,
    ]);
})->name('brand.show');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

// Route yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    Route::get('/checkout/history', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.history');
    Route::post('/checkout/process', [\App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');

    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
});

Route::post('/checkout/notification', [CheckoutController::class, 'notification'])->name('checkout.notification');

// Route admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('brands', \App\Http\Controllers\Admin\BrandController::class);
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);

    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show']);
    Route::patch('orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');

    Route::resource('contacts', \App\Http\Controllers\Admin\ContactController::class)->only(['index', 'show']);
    Route::patch('contacts/{contact}/reply', [\App\Http\Controllers\Admin\ContactController::class, 'reply'])->name('contacts.reply');

    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->only(['index', 'show', 'destroy']);
    Route::patch('users/{user}/toggle-active', [\App\Http\Controllers\Admin\UserController::class, 'toggleActive'])->name('users.toggle-active');
    Route::patch('users/{user}/reset-password', [\App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('users.reset-password');
});