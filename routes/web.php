<?php

use App\Http\Controllers\InformeController;
use App\Http\Controllers\PdfController;
use App\Http\Livewire\InformeIndex;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/home', function () {
        return view('home.index');
    })->name('home');
});

Route::get('informe/index',[InformeController::class, 'index'])->name('informe.index');