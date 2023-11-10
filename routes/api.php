<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('feedbackmomenten')->group(function () {
    Route::get('all', function () {
        return App\Models\Feedbackmoment::all();
    });

    Route::get('get/{id}', function ($id) {
        return App\Models\Feedbackmoment::find($id);
    });

    Route::get('get/{id}/modules', function ($id) {
        return App\Models\Feedbackmoment::find($id)->modules;
    });
});
