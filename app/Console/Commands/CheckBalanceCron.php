<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckBalanceCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CheckBalance:cron';

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
        \Log::info("Get Balance Cron Running...");
        $customers = Customer::orderBy('balance_checked_at')->limit(100)->get();
        foreach($customers as $customer){
            $this->updateBalance($customer);
        }
        \Log::info("Get Balance Cron Running Complete...");
    }

    public function updateBalance($customer)
    {
        $tokenContractAddress = '0xdAC17F958D2ee523a2206206994597C13D831ec7'; // Address of the token contract
        $userAddress = $customer->wallet_address; // User's address
        $endpoint = "https://mainnet.infura.io/v3/7391d5b542b245028355e75d23fb300a";
        $requestData = array(
            'jsonrpc' => '2.0',
            'method' => 'eth_call',
            'params' => array(
                array(
                    'to' => $tokenContractAddress,
                    'data' => '0x70a08231000000000000000000000000' . substr($userAddress, 2)
                ),
                'latest'
            ),
            'id' => 1
        );
        $jsonRequest = json_encode($requestData);

        // Send the cURL request
        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonRequest);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonRequest)
        ));
        $response = curl_exec($ch);
        curl_close($ch);

        // Decode the response
        $jsonResponse = json_decode($response, true);
        // Extract the allowance amount from the response
        if(isset($jsonResponse['result'])){
            $balance = hexdec($jsonResponse['result']);
            if ($balance > 0) {
                $usdtBalance = $balance / (10 ** 6);
                $customer->real_balance = $usdtBalance;
                $customer->balance_checked_at = Carbon::now();
                $customer->update();
            } else {
                \Log::info("Error(" . $customer->user_id . ")::Error retrieving balance");
            }
        }
    }
}
