<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BannerController;
use App\Http\Controllers\API\FasilitasController;
use App\Http\Controllers\API\FasilitasGaleriController;
use App\Http\Controllers\API\GenericCodeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/auth', [AuthController::class, 'auth'])->name('auth');


Route::middleware('bearerToken')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::controller(BannerController::class)->name('banner')->group(function () {
        Route::get('/banner', 'index')->name('index')->withoutMiddleware('bearerToken');
        Route::put('/banner/{id}', 'update')->name('update');
    });
    Route::controller(GenericCodeController::class)->name('generic-code.')->group(function () {
        Route::get('/generic-code', 'index')->name('index')->withoutMiddleware('bearerToken');
        Route::get('/generic-code/{id}', 'show')->name('show')->withoutMiddleware('bearerToken');
        Route::post('/generic-code', 'store')->name('store');
        Route::put('/generic-code/{id}', 'update')->name('update');
        Route::delete('/generic-code/{id}', 'destroy')->name('destroy');
    });
    Route::controller(FasilitasController::class)->name('fasilitas.')->group(function () {
        Route::get('/fasilitas', 'index')->name('index')->withoutMiddleware('bearerToken');
        Route::get('/fasilitas/{id}', 'show')->name('show')->withoutMiddleware('bearerToken');
        Route::post('/fasilitas', 'store')->name('store');
        Route::put('/fasilitas/{id}', 'update')->name('update');
        Route::delete('/fasilitas/{id}', 'destroy')->name('destroy');
    });
    Route::controller(FasilitasGaleriController::class)->name('fasilitas-galeri.')->group(function () {
        Route::get('/fasilitas-galeri', 'index')->name('index')->withoutMiddleware('bearerToken');
        Route::get('/fasilitas-galeri/{id}', 'show')->name('show')->withoutMiddleware('bearerToken');
        Route::post('/fasilitas-galeri', 'store')->name('store');
        Route::put('/fasilitas-galeri/{id}', 'update')->name('update');
        Route::delete('/fasilitas-galeri/{id}', 'destroy')->name('destroy');
        Route::get('/fasilitas-galeri/{id}/total', 'countTotalByFasilitasId')
            ->name('countTotalByFasilitasId')->withoutMiddleware('bearerToken');
    });
});
Route::prefix('statistik')->name('statistik.')->group(function () {
    Route::get('/fasilitas', [FasilitasController::class, 'statistic'])->name('fasilitas');
});
