<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    includeRouteFiles(__DIR__ . '/admin');
});

Route::get('/', function () {
    return redirect('/login');
});

Route::group(['middleware' => 'auth'], function () {
    // Authentication
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

Route::group(['middleware' => 'guest'], function () {
    // Authentication
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});