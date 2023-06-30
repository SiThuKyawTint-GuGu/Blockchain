<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function getEthToUsdtRate(){
        $data = Setting::where('key', 'eth_to_usdt_exchange_rate')->pluck('value')->first();
        return response()->json($data);
    }

    public function getTrxToUsdtRate()
    {
        $data = Setting::where('key', 'trx_to_usdt_exchange_rate')->pluck('value')->first();
        return response()->json($data);
    }
}
