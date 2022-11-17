<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OpleidingController;
use App\Http\Controllers\VakController;
use App\Http\Livewire\Vakken;
use App\Http\Livewire\Blokken;
use Illuminate\Support\Facades\Route;

Route::middleware(["auth"])->group(function () {

    Route::get('/', [HomeController::class, 'show'])->name('home');
    Route::post('/standaard', [HomeController::class, 'store'])->name('standaard.store');

    Route::resource('opleidingen', OpleidingController::class)->parameter('opleidingen', 'opleiding');
    Route::get('opleidingen/{opleiding}/vakken',  Vakken::class )->name('opleidingen.vakken' );
    Route::get('opleidingen/{opleiding}/blokken', Blokken::class)->name('opleidingen.blokken');

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    });
});

Route::redirect('/login', '/amoclient/redirect')->name('login');
Route::get('/amoclient/ready', function(){
	return redirect()->route('home');
});
