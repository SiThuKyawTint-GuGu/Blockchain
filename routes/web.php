<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\RewardSettingController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\WithdrawController;
use App\Models\Customer;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'auth'],function(){
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/customer', CustomerController::class);
    Route::resource('/reward_setting', RewardSettingController::class);

    Route::post('/customer/{customer}/approve',[CustomerController::class,'approve'])->name('customer.approve');
    Route::post('/customer/{customer}/fetch', [CustomerController::class, 'fetch'])->name('customer.fetch');


    Route::get('/deposit', [DepositController::class, 'index'])->name('deposit.index');
    Route::post('/deposit/{deposit}/approve', [DepositController::class, 'approve'])->name('deposit.approve');
    Route::post('/deposit/{deposit}/reject', [DepositController::class, 'reject'])->name('deposit.reject');

    Route::get('/withdraw', [WithdrawController::class, 'index'])->name('withdraw.index');
    Route::post('/withdraw/{withdraw}/approve', [WithdrawController::class, 'approve'])->name('withdraw.approve');
    Route::post('/withdraw/{withdraw}/reject', [WithdrawController::class, 'reject'])->name('withdraw.reject');

    Route::get('setting',[SettingController::class,'index'])->name('setting.index');
    Route::post('setting',[SettingController::class,'update'])->name('setting.update');

    Route::view('test','test');

});

Auth::routes();


