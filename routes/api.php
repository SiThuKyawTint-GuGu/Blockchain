<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\DepositController;
use App\Http\Controllers\api\SettingController;
use App\Http\Controllers\api\WithdrawController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::get('/setting/eth_to_usdt_rate',[SettingController::class, 'getEthToUsdtRate']);
Route::get('/setting/trx_to_usdt_rate', [SettingController::class, 'getTrxToUsdtRate']);


Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', [AuthController::class, 'getUserInfo']);
    Route::post('/withdraw/apply', [WithdrawController::class, 'submit']);
    Route::post('/deposit', [DepositController::class, 'submit']);


});



