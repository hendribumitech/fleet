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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();    
});

Route::group(['prefix' => 'fleet'], function () {
    Route::resource('tools', Fleet\ToolAPIController::class);
    Route::resource('spareparts', Fleet\SparepartAPIController::class);
    Route::resource('vehicles', Fleet\VehicleAPIController::class);
    Route::resource('drivers', Fleet\DriverAPIController::class);
    Route::resource('maintenances', Fleet\MaintenanceAPIController::class);
    Route::resource('documents', Fleet\DocumentAPIController::class);
    Route::resource('vehicle_documents', Fleet\VehicleDocumentAPIController::class);
});


Route::group(['prefix' => 'base'], function () {
    Route::resource('settings', App\Http\Controllers\API\Base\Base\SettingAPIController::class);
});


Route::group(['prefix' => 'fleet'], function () {
    Route::resource('categories', App\Http\Controllers\API\Fleet\Fleet\CategoryAPIController::class);
});
