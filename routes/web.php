<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ProductsController;

Route::get('/', function () {
    return view('welcome');
});

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
    });
    Route::prefix('admin/categories')->group(function () {
        Route::get('/', [CategoriesController::class, 'index'])->name('categories.index');
        Route::get('/create', [CategoriesController::class, 'create'])->name('categories.create');
        Route::post('/', [CategoriesController::class, 'store'])->name('categories.store');
        Route::get('/{categories}/edit', [CategoriesController::class, 'edit'])->name('categories.edit');
        Route::patch('/{categories}', [CategoriesController::class, 'update'])->name('categories.update');
        Route::delete('/{categories}', [CategoriesController::class, 'destroy'])->name('categories.destroy');
        Route::get('/search', [CategoriesController::class, 'search'])->name('categories.search');
    });
    Route::prefix('admin/products')->group(function () {
        Route::get('/', [ProductsController::class, 'index'])->name('products.index');
        Route::get('/create', [ProductsController::class, 'create'])->name('products.create');
        Route::post('/', [ProductsController::class, 'store'])->name('products.store');
        Route::get('/{product}/edit', [ProductsController::class, 'edit'])->name('products.edit');
        Route::patch('/{product}', [ProductsController::class, 'update'])->name('products.update');
        Route::delete('/{product}', [ProductsController::class, 'destroy'])->name('products.destroy');
        Route::get('/search', [ProductsController::class, 'search'])->name('products.search');
        Route::get('/orderby', [ProductsController::class,'orderBy'])->name('products.orderby');
    });
});

Route::middleware(['auth', 'role:user', 'verified'])->group(function () {
    Route::get('/home', function () {
        return view('user.dashboard'); // Trang dành cho user
    })->name('home');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/avatar', [ProfileController::class, 'changeAvatar'])->name('profile.avatar');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
