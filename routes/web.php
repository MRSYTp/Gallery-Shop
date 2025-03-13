<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('frontend.index');
});

Route::get('admin/index', function () {
    return view('admin.index');
});
