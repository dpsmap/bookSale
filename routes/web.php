<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [OrderController::class, 'index'])->name('home');
Route::get('/order', [OrderController::class, 'create'])->name('order.create');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/check-order', [OrderController::class, 'checkOrder'])->name('order.check');
Route::get('/order/{receiptCode}', [OrderController::class, 'showByCode'])->name('order.show');
Route::get('/order/magic/{token}', [OrderController::class, 'showByMagicToken'])->name('order.magic');
Route::get('/orders/{receiptCode}/download/{format}', [OrderController::class, 'download'])->name('order.download');
Route::get('/order/magic/{token}/download/{format}', [OrderController::class, 'downloadByMagicToken'])->name('order.magic.download');

// Admin login (public)
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'authenticate'])->name('admin.authenticate');
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
});

// Admin dashboard (protected by cookie check in controller)
Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/settings', [SettingController::class, 'index'])->name('admin.settings');

// API routes
Route::prefix('api')->group(function () {
    Route::get('/settings/book-status', [SettingController::class, 'bookStatus']);
    Route::get('/orders/stats/count', [OrderController::class, 'stats']);
    Route::post('/admin/logout', [AdminController::class, 'logout']);
    Route::get('/admin/orders', [AdminController::class, 'orders']);
    Route::patch('/admin/orders/{order}', [AdminController::class, 'updateOrder']);
    Route::post('/admin/orders/{order}/read', [AdminController::class, 'markAsRead']);
    Route::delete('/admin/orders/{order}', [AdminController::class, 'deleteOrder']);
    Route::get('/admin/stats', [AdminController::class, 'stats']);
    Route::patch('/settings', [SettingController::class, 'update']);
});
