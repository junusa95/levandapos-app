<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BroadcastSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $message = $this->details['message'];
        $br_group = $this->details['br_group'];

        $api_key='shariff';
        $secret_key = 'ShariffPOS@91';

        // $accounts = \App\Company::all();
        $accounts = \App\Company::where('id',2)->get();
        $output = array();
        $recipients = array();
        foreach($accounts as $account) { 
            // get business owners            
            if ($account->companyOwners()) {
                $rid = 1;
                foreach ($account->companyOwners() as $owner) {
                    $recipients[] = $owner->phonecode.''.str_replace(' ', '', $owner->phone);
                    $rid++;
                }
            }
        }        

        $recipients = array_unique($recipients); // remove redundancy

        $postData = array(
            'from' => 'Levanda POS',
            'to' => $recipients,
            'text' => $message,
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
            echo $response;
        
            die(curl_error($ch));
        }
        $output[] = $response;

    }
}
