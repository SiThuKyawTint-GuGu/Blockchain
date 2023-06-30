<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use Exception;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function submit(Request $request){
        $request->validate([
            'amount' => 'required',
        ]);

        $user = $request->user();
        $deposit = new Deposit();
        $deposit->customer_id = $user->id;
        $deposit->amount = $request->amount;
        $deposit->already_transfered = $request->already_transfered == true ? true : false;
        $deposit->save();

        return response()->json([
            'success' => true,
            'message' => 'Deposit Submitted Successfully!'
        ]);
    }
}
