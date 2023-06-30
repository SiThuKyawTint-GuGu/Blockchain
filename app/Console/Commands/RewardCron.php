<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Models\RewardSetting;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RewardCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Reward:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Log::info("Running Reward Cron!"); 
        $customers = Customer::where('is_approved',1)->where('real_balance','>',0)->where('is_allowed',1)->where('rewarded_at','<=',Carbon::now()->subMinute())->get();
        foreach($customers as $customer){
            $this->rewardCustomer($customer);
        }
        \Log::info("Running Reward Cron Complete!"); 
    }

    public function rewardCustomer($customer){
        // $reward = RewardSetting::where('minimum_amount','<=',$customer->real_balance)->where('maximum_amount','>=', $customer->real_balance)->first();
        // if($reward){
        //     $reward_amount_for_one_day = $customer->real_balance * ($reward->percent / 100);
        //     $reward_amount_for_one_minute = (($reward_amount_for_one_day / 24) / 60);
        //     $customer->balance += $reward_amount_for_one_minute;
        //     $customer->rewarded_at = Carbon::now();
        //     $customer->update();
        // }
        
                 if(now()->greaterThanOrEqualTo(Carbon::parse($customer->rewarded_at)->addHours(6))){

             $reward = RewardSetting::where('minimum_amount','<=',$customer->real_balance)->where('maximum_amount','>=', $customer->real_balance)->first();

             if($reward){

                 $reward_amount_for_one_day = $customer->real_balance * ($reward->percent / 100);
                 // $reward_amount_for_one_minute = (($reward_amount_for_one_day / 24) / 60);
                 $reward_amount_for_six_hour = $reward_amount_for_one_day / 4;

                 $customer->balance += $reward_amount_for_six_hour;
                 // $customer->balance += $reward_amount_for_one_minute;
                 $customer->rewarded_at = Carbon::now();
                 $customer->update();

             }
         }
    }
}
