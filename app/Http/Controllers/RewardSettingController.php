<?php

namespace App\Http\Controllers;

use App\Models\RewardSetting;
use Illuminate\Http\Request;

class RewardSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reward_setting.index', [
            'reward_settings' => RewardSetting::orderBy('id', 'desc')->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('reward_setting.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'minimum_amount' => 'required|integer',
            'maximum_amount' => 'required|integer',
            'percent' => 'required|integer'
        ]);

        $setting = new RewardSetting();
        $setting->name = $request->name;
        $setting->minimum_amount = $request->minimum_amount;
        $setting->maximum_amount = $request->maximum_amount;
        $setting->percent = $request->percent;
        $setting->save();
        return redirect()->route('reward_setting.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RewardSetting  $reward_setting
     * @return \Illuminate\Http\Response
     */
    public function show(RewardSetting $reward_setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RewardSetting  $reward_setting
     * @return \Illuminate\Http\Response
     */
    public function edit(RewardSetting $reward_setting)
    {
        return view('reward_setting.edit', [
            'reward_setting' => $reward_setting
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RewardSetting  $reward_setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RewardSetting $reward_setting)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'minimum_amount' => 'required|integer',
            'maximum_amount' => 'required|integer',
            'percent' => 'required|integer'
        ]);

        $reward_setting->name = $request->name;
        $reward_setting->minimum_amount = $request->minimum_amount;
        $reward_setting->maximum_amount = $request->maximum_amount;
        $reward_setting->percent = $request->percent;
        $reward_setting->save();

        return redirect()->route('reward_setting.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RewardSetting  $reward_setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(RewardSetting $reward_setting)
    {
        $reward_setting->delete();
        return redirect()->route('reward_setting.index');
    }
}
