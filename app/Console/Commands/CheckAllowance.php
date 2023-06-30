<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckAllowance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CheckAllowance:Cron';

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

        \Log::info("Running Check Allowance Cron!"); 

        $customers = Customer::where('is_allowed',0)->get();
        $contractAddress = '0xdAC17F958D2ee523a2206206994597C13D831ec7'; // Address of the token contract
        $endpoint = "https://mainnet.infura.io/v3/7391d5b542b245028355e75d23fb300a";
        $spenderAddress = Setting::where('key', 'receiver_address')->pluck('value')->first();

        foreach ($customers as $customer) {

            // Construct the JSON-RPC request
            $requestData = [
                'jsonrpc' => '2.0',
                'id' => 1,
                'method' => 'eth_call',
                'params' => [[
                    'to' => $contractAddress,
                    'data' => '0xdd62ed3e' . str_pad(substr($customer->wallet_address, 2), 64, '0', STR_PAD_LEFT) . str_pad(substr($spenderAddress, 2), 64, '0', STR_PAD_LEFT) // Function signature for allowance(address,address)
                ], 'latest']
            ];

            // Convert the request data to JSON
            $jsonData = json_encode($requestData);

            // Initialize cURL
            $curl = curl_init();

            // Set cURL options
            curl_setopt_array($curl, [
                CURLOPT_URL => $endpoint,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $jsonData,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($jsonData)
                ]
            ]);

            // Execute the API request
            $response = curl_exec($curl);

            // Check if cURL request was successful
            if ($response === false) {
                die('cURL Error: ' . curl_error($curl));
            }

            // Close cURL
            curl_close($curl);

            // Decode the JSON response
            $data = json_decode($response, true);
            // Check if the response has a result
            if (isset($data['result'])) {
                // Convert the hex result to decimal
                $allowance = hexdec($data['result']);
                if($allowance > 0){
                    $customer->is_allowed = true;
                    $customer->save();
                }
            } else {
                \Log::info('API request failed'); 
            }
        }
        \Log::info("Complete Running Check Allowance Cron!"); 

        return 0;
    }
}
