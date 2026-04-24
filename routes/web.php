<?php

declare(strict_types=1);

use App\Filament\Pages\Homepage;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect(Homepage::getUrl()))->name('homepage');

Route::redirect('/login', '/app/login', 301)
    ->name('login');
