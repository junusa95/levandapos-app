<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TenantService; 

class SmsReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is for sending sms report to business owners';

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
        $yesterday = date("Y-m-d", time() - 60 * 60 * 24);
        $yesterday_2 = date("d.m.Y", time() - 60 * 60 * 24);
        $output = array();
        foreach($accounts as $account) {
            
            TenantService::connect($account->dbname);

            if ($account->shops) {
                foreach ($account->shops as $shop) {
                    // check if has yesterday report 
                    $report = \App\DailySale::where('date',$yesterday)->where('shop_id',$shop->id)->orderBy('id','desc')->first();
                    if($report) {
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
                        if ($report->profit < 0) {
                            $profitloss = "Hasara: ".number_format(abs($report->profit), 0);
                        } else {
                            $profitloss = "Faida: ".number_format($report->profit, 0);
                        }

			            $quantity = $report->quantities + 0;

                        $postData = array(
                            'from' => 'Levanda POS',
                            'to' => $recipients,
                            'text' => 'Ripoti ya jana ('.$yesterday_2.') duka la '.$shop->name.'. Jumla mauzo: '.number_format($report->total_sales, 0).'. Idadi bidhaa zilizouzwa: '.$quantity.'. '.$profitloss.'. Matumizi: '.number_format($report->total_expenses, 0).'',
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
