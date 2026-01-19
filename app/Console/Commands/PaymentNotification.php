<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TenantService; 

class PaymentNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is for sending sms to inform that the shop is gonna end freetrial or payment';

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
        $api_key='shariff';
        $secret_key = 'ShariffPOS@91';

        $accounts = \App\Company::whereIn('status',['active','free trial'])->get(); 
        foreach($accounts as $account) {

            TenantService::connect($account->dbname);

            $shops = \App\Shop::where('reminder',0)->get();
            $output = array();
            
            if ($shops->isNotEmpty()) {
                foreach ($shops as $shop) {
                    $account = \App\Company::find($shop->company_id);
                    if ($account) {                
                        // get business owners
                        $recipients = array();
                        if ($account->companyOwners()) {
                            $rid = 1;
                            foreach ($account->companyOwners() as $owner) {
                                $recipients[] = $owner->phonecode.''.preg_replace("/[^0-9]/", "", $owner->phone);
                                $rid++;
                            }
                        }

                        // faida au hasara
                        if ($shop->status == "active") {
                            $text = 'Malipo duka la '.$shop->name.' yanaisha leo. Tafadhali lipia mapema ili duka lisifungiwe.';
                        } else {
                            $text = 'Duka la '.$shop->name.' linaisha matumizi ya bure leo. Tafadhali lipia mapema ili duka lisifungiwe.';
                        }

                        $postData = array(
                            'from' => 'Levanda POS',
                            'to' => $recipients,
                            'text' => $text,
                            'reference' => 'xyz',
                        );

                        $Url = 'https://messaging-service.co.tz/api/sms/v1/text/single';

                        $ch = curl_init($Url);
                        error_reporting(E_ALL);
                        ini_set('display_errors', 1);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                        curl_setopt_array($ch, array(
                            CURLOPT_POST => TRUE,
                            CURLOPT_RETURNTRANSFER => TRUE,
                            CURLOPT_HTTPHEADER => array(
                                'Authorization:Basic ' . base64_encode("$api_key:$secret_key"),
                                'Content-Type: application/json',
                                'Accept: application/json'
                            ),
                            CURLOPT_POSTFIELDS => json_encode($postData)
                        ));

                        $response = curl_exec($ch);

                        if($response === FALSE){
                            //     echo $response;

                            // die(curl_error($ch));
                        }
                        $output[] = $response;
                    } else {
                        $output[] = 'no data';
                    }  
                }  
            }
        }
    }
}
