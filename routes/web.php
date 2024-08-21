<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    sleep(2);
    return Inertia:: render('Home');
});

Route::inertia('/about', 'About', ['smth' => 'ДЛИННОЕ СТРАШНОЕ СЛОВО']);
