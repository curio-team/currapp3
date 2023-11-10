<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OpleidingController;
use App\Http\Controllers\UitvoerController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\RapportController;
use App\Http\Livewire\Blokken;
use App\Http\Livewire\Leerlijnen;
use App\Http\Livewire\Vakken;
use App\Http\Livewire\Modules;
use App\Http\Livewire\Cohorten;
use App\Http\Livewire\CohortShow;
use Illuminate\Http\Request;

Route::middleware('auth')->group(function () {
    Route::get('/tokens/create', function (Request $request) {
        $token = $request->user()->createToken(strval(time()));

        return <<<HTML
            <div>
                <p>API Token: <input value="{$token->plainTextToken}" /></p>
                <p>You'll never see this token again, so make sure to copy it now!</p>
            </div>
        HTML;
    });

    Route::get('/', [HomeController::class, 'show'])->name('home');
    Route::post('/standaard', [HomeController::class, 'store'])->name('standaard.store');

    Route::resource('opleidingen', OpleidingController::class)->parameter('opleidingen', 'opleiding');

    Route::get('opleidingen/{opleiding}/blokken',  Blokken::class )->name('opleidingen.blokken');
    Route::get('opleidingen/{opleiding}/leerlijnen',  Leerlijnen::class )->name('opleidingen.leerlijnen');
    Route::get('opleidingen/{opleiding}/vakken',   Vakken::class  )->name('opleidingen.vakken' );
    Route::get('opleidingen/{opleiding}/modules', Modules::class)->name('opleidingen.modules');
    Route::get('opleidingen/{opleiding}/modules/{module}', [ModuleController::class, 'show'])->name('opleidingen.modules.show');
    Route::get('opleidingen/{opleiding}/modules/{module}/v/{versie}', [ModuleController::class, 'show_versie'])->name('opleidingen.modules.show.versie');
    Route::post('opleidingen/{opleiding}/modules/{module}/v/{versie}/fbm', [ModuleController::class, 'create_fbm'])->name('opleidingen.modules.fbm.create');
    Route::post('opleidingen/{opleiding}/modules/{module}/update', [ModuleController::class, 'update'])->name('opleidingen.modules.update');
    Route::post('opleidingen/{opleiding}/modules/{module}/create', [ModuleController::class, 'create_version'])->name('opleidingen.modules.versie.create');
    Route::get('opleidingen/{opleiding}/cohorten', Cohorten::class)->name('opleidingen.cohorten');
    Route::get('opleidingen/{opleiding}/cohorten/{cohort}', CohortShow::class)->name('opleidingen.cohorten.show');

    Route::get('opleidingen/{opleiding}/uitvoeren/{uitvoer}', [UitvoerController::class, 'show'])->name('opleidingen.uitvoeren.show');
    Route::post('uitvoeren/{uitvoer}/vak/preview', [UitvoerController::class, 'link_vak_preview'])->name('uitvoeren.link.vak.preview');
    Route::post('uitvoeren/{uitvoer}/vak', [UitvoerController::class, 'link_vak'])->name('uitvoeren.link.vak');
    Route::post('uitvoeren/{uitvoer}/module/preview', [UitvoerController::class, 'link_module_preview'])->name('uitvoeren.link.module.preview');
    Route::post('uitvoeren/{uitvoer}/module', [UitvoerController::class, 'link_module'])->name('uitvoeren.link.module');
    Route::post('uitvoeren/{uitvoer}/points/preview', [UitvoerController::class, 'edit_points_preview'])->name('uitvoeren.edit.points.preview');
    Route::post('uitvoeren/{uitvoer}/points', [UitvoerController::class, 'edit_points'])->name('uitvoeren.edit.points');
    Route::post('uitvoeren/{uitvoer}/weeks/preview', [UitvoerController::class, 'edit_weeks_preview'])->name('uitvoeren.edit.weeks.preview');
    Route::post('uitvoeren/{uitvoer}/weeks', [UitvoerController::class, 'edit_weeks'])->name('uitvoeren.edit.weeks');

    Route::get('studiepuntenplan/uitvoer/{uitvoer}', [UitvoerController::class, 'studiepuntenplan_uitvoer'])->name('studiepuntenplan.uitvoer.show');
    Route::get('studiepuntenplan/vak/{vak}', [UitvoerController::class, 'studiepuntenplan_vak'])->name('studiepuntenplan.vak.show');

    Route::get('opleidingen/{opleiding}/rapportage/llc', [RapportController::class, 'llc'])->name('opleidingen.rapportage.llc');
    Route::get('opleidingen/{opleiding}/rapportage/llc/2', [RapportController::class, 'llc2'])->name('opleidingen.rapportage.llc.2');

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        // TODO
    });

});

Route::redirect('/login', '/amoclient/redirect')->name('login');
Route::get('/amoclient/ready', function(){
	return redirect()->route('home');
});
