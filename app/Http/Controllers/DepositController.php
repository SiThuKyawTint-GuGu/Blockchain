<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deposits = Deposit::latest()->paginate(10);
        return view('deposit.index',compact('deposits'));
    }

    public function approve(Deposit $deposit){

        if($deposit->status == Deposit::PENDING){
            $customer = $deposit->customer;
            try {
                $customer->balance += $deposit->amount;
                $customer->update();

                $deposit->status = Deposit::SUCCESS;
                $deposit->update();
            } catch (Exception $e) {
                Session::flash('error', 'Something went wrong!');
            }
        }

        Session::flash('success', 'Deposit approved successfully!');
        return redirect()->route('deposit.index');
    }

    public function reject(Deposit $deposit)
    {

        if ($deposit->status == Deposit::PENDING) {
            $customer = $deposit->customer;
            try {
                $deposit->status = Deposit::REJECT;
                $deposit->update();
            } catch (Exception $e) {
                Session::flash('error', 'Something went wrong!');
            }
        }

        Session::flash('success', 'Deposit rejected successfully!');
        return redirect()->route('deposit.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function show(Deposit $deposit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function edit(Deposit $deposit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Deposit $deposit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deposit $deposit)
    {
        //
    }
}
