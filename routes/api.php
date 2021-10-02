<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookOrderController;
use App\Http\Controllers\GenreController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/', [BookController::class, 'index']);
Route::get('/search', [BookController::class, 'search']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/librarian/{id}', [AuthController::class, 'makeLibrarian'])->middleware('isAdmin');
    Route::group(['middleware' => ['isLibrarianOrAdmin']], function () {
        Route::apiResources([
            'books' => BookController::class,
            'genres' => GenreController::class
        ]);
        Route::post('/orders/give', [BookOrderController::class, 'giveBook']);
        Route::post('/orders/accept', [BookOrderController::class, 'acceptBook']);
    });
    Route::apiResources(['orders' => BookOrderController::class]);

    Route::post('/logout', [AuthController::class, 'logout']);
});
