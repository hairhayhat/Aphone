<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\OrdersController as AdminOrdersController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\FavoriteController;
use App\Http\Controllers\User\OrdersController;
use App\Http\Controllers\User\CommentController;
use App\Models\Order;



Route::get('/', [HomeController::class, 'index'])->name('welcome');
Route::get('/categories', [HomeController::class, 'categories'])
    ->name('categories.list');
Route::get('/products', [HomeController::class, 'products'])
    ->name('products.list');
Route::get('/oderby', [HomeController::class, 'orderIndex'])
    ->name('user.products.index');
Route::get('/products/{product}', [HomeController::class, 'detail'])
    ->name('user.products.detail');
Route::get('/search/products', [HomeController::class, 'search'])->name('user.products.search');


Route::middleware(['auth', 'role:admin', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    Route::prefix('admin/user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/', [UserController::class, 'store'])->name('user.store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::patch('/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::post('/confirm-password', [UserController::class, 'confirmPassword'])->name('user.confirmPassword');
        Route::get('/search', [UserController::class, 'search'])->name('user.search');
        Route::get('/orderby', [UserController::class, 'orderby'])->name('user.orderby');
    });
    Route::prefix('admin/categories')->group(function () {
        Route::get('/', [CategoriesController::class, 'index'])->name('categories.index');
        Route::get('/create', [CategoriesController::class, 'create'])->name('categories.create');
        Route::post('/', [CategoriesController::class, 'store'])->name('categories.store');
        Route::get('/{categories}/edit', [CategoriesController::class, 'edit'])->name('categories.edit');
        Route::patch('/{categories}', [CategoriesController::class, 'update'])->name('categories.update');
        Route::delete('/{categories}', [CategoriesController::class, 'destroy'])->name('categories.destroy');
        Route::get('/search', [CategoriesController::class, 'search'])->name('categories.search');
        Route::get('/orderby', [CategoriesController::class, 'orderby'])->name('categories.orderby');
    });
    Route::prefix('admin/products')->group(function () {
        Route::get('/', [ProductsController::class, 'index'])->name('products.index');
        Route::get('/create', [ProductsController::class, 'create'])->name('products.create');
        Route::post('/', [ProductsController::class, 'store'])->name('products.store');
        Route::get('/{product}/edit', [ProductsController::class, 'edit'])->name('products.edit');
        Route::patch('/{product}', [ProductsController::class, 'update'])->name('products.update');
        Route::delete('/{product}', [ProductsController::class, 'destroy'])->name('products.destroy');
        Route::get('/search', [ProductsController::class, 'search'])->name('products.search');
        Route::get('/orderby', [ProductsController::class, 'orderBy'])->name('products.orderby');
        Route::delete('products/variants/{id}', [ProductsController::class, 'destroy_variant'])
            ->name('products.destroy_variant');
    });
    Route::prefix('admin/orders')->group(function () {
        Route::get('/', [AdminOrdersController::class, 'index'])->name('orders.index');
        Route::get('/orderby', [AdminOrdersController::class, 'orderIndex'])->name('orders.orderIndex');
        Route::patch('/{order}/change-status', [AdminOrdersController::class, 'changeStatus'])
            ->name('orders.changeStatus');
    });
    Route::prefix('admin/comments')->group(function () {
        Route::get('/{comment}/showComment', [AdminOrdersController::class, 'showComment'])->name('admin.comments.showComment');
        Route::patch('/{comment}/approve', [AdminOrdersController::class, 'approveComment'])
            ->name('admin.comments.approve');
        Route::patch('/{comment}/reject', [AdminOrdersController::class, 'rejectComment'])
            ->name('admin.comments.reject');
    });
});

Route::middleware(['auth', 'role:user', 'verified'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::post('/products/{product}/favorite', [FavoriteController::class, 'toggleFavorite'])
            ->name('favorite.toggle');
        Route::prefix('orders')->group(function () {
            Route::post('/create', [OrdersController::class, 'create'])->name('orders.create');
            Route::post('/', [OrdersController::class, 'store'])->name('orders.store');
            Route::get('/success', function () {
                return view('user.orders.success');
            })->name('orders.success');
            Route::get('/', [OrdersController::class, 'index'])->name('user.orders.index');
            Route::get('/orderby', [OrdersController::class, 'orderIndex'])->name('user.orders.orderIndex');
            Route::get('/{order}', [OrdersController::class, 'show'])->name('user.orders.show');
            Route::patch('/{order}/cancel', [OrdersController::class, 'cancelOrder'])->name('user.orders.cancel');
            Route::patch('/{order}/confirm', [OrdersController::class, 'confirmOrder'])->name('user.orders.confirm');
            Route::get('/success-confirm/{order}', function ($orderId) {
                $order = Order::findOrFail($orderId);
                return view('user.orders.success-confirm', compact('order'));
            })->name('user.orders.success-confirm');

        });
        Route::prefix('comments')->group(function () {
            Route::get('/create/{id}', [CommentController::class, 'create'])
                ->name('user.comments.create');
            Route::post('/', [CommentController::class, 'store'])
                ->name('user.comments.store');
        });
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/avatar', [ProfileController::class, 'changeAvatar'])->name('profile.avatar');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
