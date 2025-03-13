<?php

use Illuminate\Support\Facades\Route;
use App\Models\Category;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    Category::where('id', 1)->delete();
});
