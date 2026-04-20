<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/app', 301)
    ->name('redirectHome');

Route::redirect('/login', '/app/login', 301)
    ->name('login');
