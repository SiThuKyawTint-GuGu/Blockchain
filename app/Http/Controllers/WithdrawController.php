<?php

namespace App\Http\Controllers;

use App\Models\Withdraw;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $withdraws = Withdraw::latest()->paginate(10);
        return view('withdraw.index',compact('withdraws'));
    }
    public function approve(Withdraw $withdraw)
    {

        if ($withdraw->status == Withdraw::PENDING) {
            $customer = $withdraw->customer;
            try {
                $customer->balance -= $withdraw->amount;
                $customer->update();

                $withdraw->status = Withdraw::SUCCESS;
                $withdraw->update();
            } catch (Exception $e) {
                Session::flash('error', 'Something went wrong!');
            }
        }

        Session::flash('success', 'Withdraw approved successfully!');
        return redirect()->route('withdraw.index');
    }

    public function reject(Withdraw $withdraw)
    {

        if ($withdraw->status == Withdraw::PENDING) {
            try {
                $withdraw->status = Withdraw::REJECT;
                $withdraw->update();
            } catch (Exception $e) {
                Session::flash('error', 'Something went wrong!');
            }
        }

        Session::flash('success', 'Withdraw rejected successfully!');
        return redirect()->route('withdraw.index');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function show(Withdraw $withdraw)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function edit(Withdraw $withdraw)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Withdraw $withdraw)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function destroy(Withdraw $withdraw)
    {
        //
    }
}
