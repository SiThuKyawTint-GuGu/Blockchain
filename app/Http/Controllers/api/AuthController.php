<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function getUserId(Request $request){
        if($id = $request->session()->get('user_id')){
            return $id;
        }

        $user_id =  Customer::generateUserId();
        $request->session()->put('user_id',$user_id);
        return $user_id;
    }

    public function register(Request $request)
    {
        $customer = Customer::where('wallet_address',$request->address)->first();
        if(!$customer){
            $customer = new Customer();
            $customer->user_id = Customer::generateUserId();
            $customer->wallet_address = $request->address;
            $customer->spender_address = 
            $customer->save();
        }

        return response()->json([
            'data' => new CustomerResource($customer),
            'token' => $customer->createToken('auth')->plainTextToken,
        ]);
    }

    public function getUserInfo(Request $request)
    {
        return response()->json([
            'data' => new CustomerResource($request->user())
        ]);
    }

    
}
