<?php

use App\Http\Controllers\API\AccountController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BannerController;
use App\Http\Controllers\API\ContactMessageController;
use App\Http\Controllers\API\FasilitasController;
use App\Http\Controllers\API\FasilitasGaleriController;
use App\Http\Controllers\API\GaleryFilesController;
use App\Http\Controllers\API\GenericCodeController;
use App\Http\Controllers\API\GaleryController;
use App\Http\Controllers\API\OurTeamController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\PpdbAlurPendaftaranController;
use App\Http\Controllers\API\PpdbBrosurController;
use App\Http\Controllers\API\StatisticTeacherStudent;
use App\Http\Controllers\API\TestimonialController;
use App\Http\Controllers\API\WebVisitorController;
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
Route::get('/', function () {
    return response()->json([
        'statusCode' => 200,
        'statusMessage' => "OK",
        'message' => 'Success',
        'success' => true,
        'data' => [
            'api_version' => '1.0.0',
            'api_name' => 'Insan Mandiri Cendekia API',
        ]
    ], 200);
});


Route::middleware('bearerToken')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::controller(BannerController::class)
        ->name('banner')
        ->group(function () {
            Route::get('/banner', 'index')->name('index')->withoutMiddleware('bearerToken');
            Route::put('/banner/{id}', 'update')->name('update');
        });
    Route::controller(GenericCodeController::class)
        ->name('generic-code.')
        ->group(function () {
            Route::get('/generic-code', 'index')->name('index')->withoutMiddleware('bearerToken');
            Route::get('/generic-code/{id}', 'show')->name('show')->withoutMiddleware('bearerToken');
            Route::post('/generic-code', 'store')->name('store');
            Route::put('/generic-code/{id}', 'update')->name('update');
            Route::delete('/generic-code/{id}', 'destroy')->name('destroy');
        });
    Route::controller(FasilitasController::class)
        ->name('fasilitas.')
        ->group(function () {
            Route::get('/fasilitas', 'index')->name('index')->withoutMiddleware('bearerToken');
            Route::get('/fasilitas/{id}', 'show')->name('show')->withoutMiddleware('bearerToken');
            Route::post('/fasilitas', 'store')->name('store');
            Route::put('/fasilitas/{id}', 'update')->name('update');
            Route::delete('/fasilitas/{id}', 'destroy')->name('destroy');
        });
    Route::controller(FasilitasGaleriController::class)
        ->name('fasilitas-galeri.')
        ->group(function () {
            Route::get('/fasilitas-galeri', 'index')->name('index')->withoutMiddleware('bearerToken');
            Route::get('/fasilitas-galeri/{id}', 'show')->name('show')->withoutMiddleware('bearerToken');
            Route::post('/fasilitas-galeri', 'store')->name('store');
            // Route::put('/fasilitas-galeri/{id}', 'update')->name('update');
            Route::patch('/fasilitas-galeri/{id}/thumbnail', 'setThumbnail')->name('thumbnail');
            Route::delete('/fasilitas-galeri/{id}', 'destroy')->name('destroy');
            Route::get('/fasilitas-galeri/{id}/total', 'countTotalByFasilitasId')
                ->name('countTotalByFasilitasId')->withoutMiddleware('bearerToken');
        });
    Route::controller(GaleryController::class)
        ->name('galeri.')
        ->group(function () {
            Route::get('/galeri', 'index')->name('index')->withoutMiddleware('bearerToken');
            Route::get('/galeri/{id}', 'show')->name('show')->withoutMiddleware('bearerToken');
            Route::post('/galeri', 'store')->name('store');
            Route::put('/galeri/{id}', 'update')->name('update');
            Route::delete('/galeri/{id}', 'destroy')->name('destroy');
            Route::get('/galeri/{id}/total', 'countTotalByGaleryId')
                ->name('countTotalByGaleryId')->withoutMiddleware('bearerToken');
        });
    Route::controller(GaleryFilesController::class)
        ->name('fasilitas-galeri.')
        ->group(function () {
            Route::get('/galeri-files', 'index')->name('index')->withoutMiddleware('bearerToken');
            Route::get('/galeri-files/{id}', 'show')->name('show')->withoutMiddleware('bearerToken');
            Route::post('/galeri-files', 'store')->name('store');
            Route::put('/galeri-files/{id}', 'update')->name('update');
            Route::delete('/galeri-files/{id}', 'destroy')->name('destroy');
            Route::get('/galeri-files/{id}/total', 'countTotalByGaleryId')
                ->name('countTotalByGaleryId')->withoutMiddleware('bearerToken');
        });
    Route::controller(TestimonialController::class)
        ->name('testimoni.')
        ->group(function () {
            Route::get('/testimoni', 'index')->name('index')->withoutMiddleware('bearerToken');
            Route::get('/testimoni/{id}', 'show')->name('show')->withoutMiddleware('bearerToken');
            Route::post('/testimoni', 'store')->name('store');
            Route::put('/testimoni/{id}', 'update')->name('update');
            Route::delete('/testimoni/{id}', 'destroy')->name('destroy');
            Route::delete('/testimoni/{id}/avatar', 'deleteImageTestimonial')->name('destroy-avatar');
        });

    Route::controller(PostController::class)
        ->name('post.')
        ->group(function () {
            Route::get('/post', 'index')->name('index')->withoutMiddleware('bearerToken');
            Route::get('/post/{id}', 'show')->name('show')->withoutMiddleware('bearerToken');
            Route::get('/post/{slug}/read', 'read')->name('read')->withoutMiddleware('bearerToken');
            Route::post('/post', 'store')->name('store');
            Route::put('/post/{id}', 'update')->name('update');
            Route::delete('/post/{id}', 'destroy')->name('destroy');
            Route::post('/post/{id}/publish', 'publish')->name('publish');
        });
    Route::prefix('ppdb')
        ->name('ppdb.')
        ->group(function () {
            Route::controller(PpdbAlurPendaftaranController::class)
                ->name('alur-pendaftaran.')
                ->group(function () {
                    Route::get('/alur-pendaftaran', 'index')->name('index')->withoutMiddleware('bearerToken');
                    Route::get('/alur-pendaftaran/{id}', 'show')->name('show')->withoutMiddleware('bearerToken');
                    Route::post('/alur-pendaftaran', 'store')->name('store');
                    Route::put('/alur-pendaftaran/{id}', 'update')->name('update');
                    Route::delete('/alur-pendaftaran/{id}', 'destroy')->name('destroy');
                });
            Route::controller(PpdbBrosurController::class)
                ->name('brosur.')
                ->group(function () {
                    Route::get('/brosur', 'index')->name('index')->withoutMiddleware('bearerToken');
                    Route::get('/brosur/{id}', 'show')->name('show')->withoutMiddleware('bearerToken');
                    Route::post('/brosur', 'store')->name('store');
                    Route::put('/brosur/{id}', 'update')->name('update');
                    Route::delete('/brosur/{id}', 'destroy')->name('destroy');
                });
        });
    Route::controller(AccountController::class)
        ->prefix('account')
        ->name('account.')
        ->group(function () {
            Route::patch('/{id}/update-password', 'updatePassword')->name('update-password');
            Route::patch('/{id}/update-profile', 'updateProfile')->name('update-profile');
        });
    Route::controller(ContactMessageController::class)
        ->prefix('contact-message')
        ->name('contact-message.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store')->withoutMiddleware('bearerToken');
            Route::patch('/{id}/status', 'status')->name('read');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });
    Route::prefix('statistik')
        ->name('statistik.')
        ->group(function () {
            Route::controller(StatisticTeacherStudent::class)
                ->name('teacher-student.')
                ->group(function () {
                    Route::get('/teacher-student', 'index')->name('index')->withoutMiddleware('bearerToken');
                    Route::get('/teacher-student/{id}', 'show')->name('show')->withoutMiddleware('bearerToken');
                    Route::post('/teacher-student', 'store')->name('store');
                    Route::put('/teacher-student/{id}', 'update')->name('update');
                    Route::delete('/teacher-student/{id}', 'destroy')->name('destroy');
                });
        });
    Route::controller(OurTeamController::class)
        ->name('our-team.')
        ->prefix('our-team')
        ->group(function () {
            Route::get('/', 'index')->name('index')->withoutMiddleware('bearerToken');
            Route::get('/{id}', 'show')->name('show')->withoutMiddleware('bearerToken');
            Route::post('/', 'store')->name('store');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
            Route::delete('/{id}/avatar', 'deleteImageOurTeam')->name('destroy-avatar');
        });
});
Route::prefix('statistik')
    ->name('statistik.')
    ->group(function () {
        Route::get('/fasilitas', [FasilitasController::class, 'statistic'])->name('fasilitas');
        Route::get('/galeri', [GaleryController::class, 'statistic'])->name('galery');
        Route::get('/testimoni', [TestimonialController::class, 'statistic'])->name('testimoni');
        Route::prefix('post')
            ->name('post.')
            ->controller(PostController::class)
            ->group(function () {
                Route::get('/', 'statistic')->name('index');
                Route::get('/kategori', 'statisticByCategory')->name('category');
                Route::get('/by-month-year', 'statisticByMonthYear')->name('month-year');
                Route::get('total-by-date', 'statisticTotalByDateRange')->name('total-by-date');
            });
        Route::controller(WebVisitorController::class)
            ->name('web-visitor.')
            ->prefix('web-visitor')
            ->group(function () {
                Route::get('/', 'index')->name('index')->withoutMiddleware('bearerToken');
                Route::get('/{id}', 'show')->name('show')->withoutMiddleware('bearerToken');
                Route::post('/', 'store')->name('store')->withoutMiddleware('bearerToken');
                Route::delete('/{id}', 'destroy')->name('destroy');
                Route::get('/total/visit', 'statistic')->name('statistic');
            });
    });
