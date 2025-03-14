<?php

use App\Http\Controllers\admin\CategoriesController;
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

    // Route::get('/', function () {
    //     return view('admin.index');
    // });
});

