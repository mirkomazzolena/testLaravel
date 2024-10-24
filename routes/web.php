<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KxpoController;

Route::get('/', function () {
    return view('calcolatore');
});

Route::post('/api/calcola-kxpo', [KxpoController::class, 'calcolaKxpo']);
