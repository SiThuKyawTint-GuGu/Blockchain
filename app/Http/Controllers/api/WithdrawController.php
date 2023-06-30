<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Withdraw;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'withdrawal_address' => 'required'
        ]);

        $user = $request->user();
        $withdraw = new Withdraw();
        $withdraw->customer_id = $user->id;
        $withdraw->amount = $request->amount;
        $withdraw->withdraw_address = $request->withdraw_address;
        $withdraw->save();

        return response()->json([
            'success' => true,
            'message' => 'Withdraw Submitted Successfully!'
        ]);
    }
}
