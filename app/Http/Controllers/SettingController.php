<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
   public function index(){
   
      $setting = Setting::whereIn('key',['fast_forex_api_key', 'eth_to_usdt_exchange_rate', 'trx_to_usdt_exchange_rate', 'receiver_address'])->pluck('value','key');

      return view('setting',compact('setting'));
   }

   public function update(Request $request){
      if($value = $request->fast_forex_api_key){
         Setting::where('key', 'fast_forex_api_key')->update([
            'value' => $value
         ]);
      }

      // if ($value = $request->receiver_address) {
      //    Setting::where('key', 'receiver_address')->update([
      //       'value' => $value
      //    ]);
      // }
      return redirect()->route('setting.index');

   }
}
