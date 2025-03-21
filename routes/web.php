<?php

use App\Http\Controllers\admin\CategoriesController;
use App\Http\Controllers\admin\OrdersController;
use App\Http\Controllers\admin\PaymentsController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\admin\UsersController;
use App\Http\Controllers\front\BasketController;
use App\Http\Controllers\front\CheckoutController;
use App\Http\Controllers\front\ProductsController as FrontProductsController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {

    Route::prefix('categories')->group(function () {

        Route::get('', [CategoriesController::class, 'all'])->name('admin.categories.all');
        Route::get('add', [CategoriesController::class, 'add'])->name('admin.categories.add');
        Route::get('edit/{id}', [CategoriesController::class, 'edit'])->name('admin.categories.edit');
        Route::post('store', [CategoriesController::class, 'store'])->name('admin.categories.store');
        Route::delete('delete/{id}', [CategoriesController::class, 'delete'])->name('admin.categories.delete');
        Route::put('update/{id}', [CategoriesController::class, 'update'])->name('admin.categories.update');
    });


    Route::prefix('products')->group(function () {


        Route::get('add', [ProductsController::class, 'add'])->name('admin.products.add');
        Route::get('', [ProductsController::class, 'all'])->name('admin.products.all');
        Route::get('edit/{id}' , [ProductsController::class , 'edit'])->name('admin.products.edit');
        Route::get('download/demo/{id}', [ProductsController::class , 'downloadDemo'])->name('admin.products.downloadDemo');
        Route::get('download/source/{id}', [ProductsController::class , 'downloadSource'])->name('admin.products.downloadSource');
        Route::post('store', [ProductsController::class, 'store'])->name('admin.products.store');
        Route::delete('delete/{id}',[ProductsController::class , 'delete'])->name('admin.products.delete');
        Route::put('update/{id}' , [ProductsController::class , 'update'])->name('admin.products.update');
    });

    Route::prefix('users')->group(function () {

        Route::get('', [UsersController::class, 'all'])->name('admin.users.all');
        Route::get('add', [UsersController::class, 'add'])->name('admin.users.add');
        Route::get('edit/{id}', [UsersController::class, 'edit'])->name('admin.users.edit');
        Route::post('store', [UsersController::class, 'store'])->name('admin.users.store');
        Route::delete('delete/{id}', [UsersController::class, 'delete'])->name('admin.users.delete');
        Route::put('update/{id}', [UsersController::class, 'update'])->name('admin.users.update');
        
    });


    Route::prefix('orders')->group(function () {

        Route::get('', [OrdersController::class, 'all'])->name('admin.orders.all');
    });

    Route::prefix('payments')->group(function () {

        Route::get('', [PaymentsController::class, 'all'])->name('admin.payments.all');
    });
});


Route::prefix('')->group(function () {

    Route::get('', [FrontProductsController::class, 'index'])->name('frontend.index');
    Route::get('product/{id}', [FrontProductsController::class, 'show'])->name('frontend.product.show');
    Route::get('checkout' , [CheckoutController::class , 'index'])->name('frontend.checkout');
    Route::post('basket/add/{id}', [BasketController::class, 'add'])->name('frontend.basket.add');
    Route::delete('basket/remove/{id}', [BasketController::class, 'remove'])->name('frontend.basket.remove');
});

