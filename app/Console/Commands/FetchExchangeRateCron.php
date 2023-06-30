<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;

class FetchExchangeRateCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'FetchExchangeRate:cron';

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
        \Log::info("Exhchange Rate Cron Running...");
       

        //eth to usdt
        $response = $this->fetchExchangeRate('ETH','USDT');
        if(isset($response->error)){
            \Log::info('Error::'.$response->error);
        }else{
            $exchange_rate = $response->result->USDT ?? null;
            \Log::info($exchange_rate);

            if($exchange_rate){
                Setting::where('key', 'eth_to_usdt_exchange_rate')->update([
                    'value' => $exchange_rate
                ]);
            }
        }


        //trx to usdt
        $response = $this->fetchExchangeRate('TRX', 'USDT');
        if (isset($response->error)) {
            \Log::info('Error::' . $response->error);
        } else {
            $exchange_rate = $response->result->USDT ?? null;
            \Log::info($exchange_rate);

            if ($exchange_rate) {
                Setting::where('key', 'trx_to_usdt_exchange_rate')->update([
                    'value' => $exchange_rate
                ]);
            }
        }

        \Log::info("Exhchange Rate Cron Running Complete...");

        return 0;
    }

    public function fetchExchangeRate($from,$to){
        $curl = curl_init();
        $api_key = Setting::where('key', 'fast_forex_api_key')->pluck('value')->first();
        $url = 'https://api.fastforex.io/convert?from='.$from.'&to='.$to.'&amount=1&api_key=' . $api_key;
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "Content-Type: application/json",
            ),
        ));
        $response = curl_exec($curl);
        $response = json_decode($response);
        return $response;
    }
}
