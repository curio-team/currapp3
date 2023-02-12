<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OpleidingController;
use App\Http\Controllers\UitvoerController;
use App\Http\Livewire\Vakken;
use App\Http\Livewire\Blokken;
use App\Http\Livewire\Cohorten;
use App\Http\Livewire\CohortShow;

Route::middleware('auth')->group(function () {

    Route::get('/', [HomeController::class, 'show'])->name('home');
    Route::post('/standaard', [HomeController::class, 'store'])->name('standaard.store');

    Route::resource('opleidingen', OpleidingController::class)->parameter('opleidingen', 'opleiding');

    Route::get('opleidingen/{opleiding}/vakken',   Vakken::class  )->name('opleidingen.vakken' );
    Route::get('opleidingen/{opleiding}/blokken',  Blokken::class )->name('opleidingen.blokken');
    Route::get('opleidingen/{opleiding}/cohorten', Cohorten::class)->name('opleidingen.cohorten');
    Route::get('opleidingen/{opleiding}/cohorten/{cohort}', CohortShow::class)->name('opleidingen.cohorten.show');
    
    Route::get('opleidingen/{opleiding}/uitvoeren/{uitvoer}', [UitvoerController::class, 'show'])->name('opleidingen.uitvoeren.show');
    Route::post('uitvoeren/{uitvoer}/vak/preview', [UitvoerController::class, 'link_vak_preview'])->name('uitvoeren.link.vak.preview');
    Route::post('uitvoeren/{uitvoer}/vak', [UitvoerController::class, 'link_vak'])->name('uitvoeren.link.vak');
    Route::post('uitvoeren/{uitvoer}/module/preview', [UitvoerController::class, 'link_module_preview'])->name('uitvoeren.link.module.preview');
    Route::post('uitvoeren/{uitvoer}/module', [UitvoerController::class, 'link_module'])->name('uitvoeren.link.module');

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        // TODO
    });

});

Route::redirect('/login', '/amoclient/redirect')->name('login');
Route::get('/amoclient/ready', function(){
	return redirect()->route('home');
});
