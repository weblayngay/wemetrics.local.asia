<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\LoginGoogleController;
use App\Http\Controllers\Frontend\LoginFacebookController;
use App\Http\Controllers\General\GetLocationController;

if (!defined('FRONTEND_ROUTE')) {
    define('FRONTEND_ROUTE', 'release');
}

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

/*
|--------------------------------------------------------------------------
| HOME PAGE
|--------------------------------------------------------------------------
 */
Route::get('/', [IndexController::class, 'index'])->name(FRONTEND_ROUTE . '.homepage')->name('home');
Route::get('/index.html', function () { return redirect('/'); });

/*
|--------------------------------------------------------------------------
| SOCIAL
|--------------------------------------------------------------------------
 */
Route::get('/social/login-google.html', [LoginGoogleController::class, 'redirectToGoogle'])->name('social.login.google');
Route::get('/social/login-google-callback.html', [LoginGoogleController::class, 'handleGoogleCallback']);
Route::get('/social/login-facebook.html', [LoginFacebookController::class, 'redirectToFacebook'])->name('social.login.facebook');
Route::get('/social/login-facebook-callback.html', [LoginFacebookController::class, 'handleFacebookCallback']);

/*
|--------------------------------------------------------------------------
| DISTRICT - WARD
|--------------------------------------------------------------------------
 */
Route::get('/get-district', [GetLocationController::class, 'getDistrict'])->name('get-district');
Route::get('/get-ward', [GetLocationController::class, 'getWard'])->name('get-ward');

