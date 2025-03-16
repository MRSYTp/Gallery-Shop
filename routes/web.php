<?php

use App\Http\Controllers\admin\CategoriesController;
use App\Http\Controllers\Admin\ProductsController;
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

    // Route::get('/', function () {
    //     return view('admin.index');
    // });
});

