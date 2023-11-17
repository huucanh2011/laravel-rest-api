<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\User\UserController;
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

require __DIR__ . '/auth.php';

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::apiResource('/users', UserController::class)->parameter('users', 'id');
    Route::post('/image', ImageController::class);
});
