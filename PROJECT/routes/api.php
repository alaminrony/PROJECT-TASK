<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;

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


Route::controller(AuthController::class)->prefix('v1')->group(function () {
    Route::post('/login',                 'login')->name('users.login');
    Route::post('/registration',          'registration')->name('users.registration');
});

Route::controller(UserController::class)->prefix('v1/users')->middleware(['auth:sanctum','permission'])->group(function () {
    Route::get('/',                 'index')->name('users.index');
    Route::post('/store',           'store')->name('users.store');
    Route::put('/update/{id}',      'update')->name('users.update');
    Route::delete('/delete/{id}',   'delete')->name('users.delete');
});
