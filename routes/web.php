<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('products',       [ProductController::class, 'productList']);



// Route::controller(UserController::class)->prefix('users')->group(function () {
//     Route::get('/',                 'index')->name('users.index')->middleware('PermissionCheck:user_read');
//     Route::get('/create',           'create')->name('users.create')->middleware('PermissionCheck:user_create');
//     Route::post('/store',           'store')->name('users.store')->middleware('PermissionCheck:user_create');
//     Route::get('/edit/{id}',        'edit')->name('users.edit')->middleware('PermissionCheck:user_update');
//     Route::put('/update/{id}',      'update')->name('users.update')->middleware('PermissionCheck:user_update');
//     Route::get('/delete/{id}',   'delete')->name('users.delete')->middleware('PermissionCheck:user_delete');

//     Route::get('/change-role',      'changeRole')->name('change.role');
//     Route::post('/status',      'status')->name('users.status');
//     Route::delete('/{id}',      'deletes')->name('users.deletes');
// });
