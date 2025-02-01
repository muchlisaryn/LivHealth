<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return route('admin/login');
});

require __DIR__.'/auth.php';
