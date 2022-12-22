<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\Camp\Coupon202208\Page\Coupon202208Controller;

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
| COUPON 2022-08
|--------------------------------------------------------------------------
 */
Route::get('/campaign-coupon-2022-08', [Coupon202208Controller::class, 'index'])->name('campaign-coupon-2022-08');
Route::post('/get-voucher-by-phone-coupon-2022-08', [Coupon202208Controller::class, 'getVoucher'])->name('get-voucher-by-phone-coupon-2022-08');