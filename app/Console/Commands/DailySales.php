<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TenantService;
use Carbon\Carbon;

class DailySales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:sales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is for updating daily sales and expenses of all shops everyday';

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
     * @return mixed
     */
    public function handle()
    {
        //
        $yesterday = date("Y-m-d", time() - 60 * 60 * 24);
        $fromdate = date("Y-m-d 00:00:00", strtotime($yesterday));
        $todate = date("Y-m-d 23:59:59", strtotime($yesterday));
        $accounts = \App\Company::whereIn('status',['active','free trial'])->get(); 
        foreach($accounts as $account) {

            TenantService::connect($account->dbname);

            if ($account->shops) {
                foreach ($account->shops as $shop) {
                    $sales = \App\Sale::where('shop_id',$shop->id)->where('status','sold')->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->get();
                    $expenses = \App\ShopExpense::where('shop_id',$shop->id)->whereBetween('created_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->get();
                    if ($sales->isNotEmpty() || $expenses->isNotEmpty()) {
                        $t_sales = $sales->sum('sub_total');
                        $quantities = $sales->sum('quantity');
                        $t_expenses = $expenses->sum('amount');
                        $profit = $sales->sum('sub_total') - $sales->sum('total_buying');
                        \App\DailySale::create(['date'=>$yesterday, 'shop_id'=>$shop->id,'company_id'=>$account->id,'total_sales'=>$t_sales,'quantities'=>$quantities,'total_expenses'=>$t_expenses,'profit'=>$profit]);
                    }                    
                }                
            }            
        }         

        // check if it is monday for weekly report        
        $today = time();
        if(date('D', $today) === 'Mon') {
            if($this->update_weekly_report() == true) {
                $this->send_sms_report();
            }
        } 

        // check if it is first day of month    
        if(date('d') == 1) {
            if($this->update_monthly_report() == true) {
                $this->send_monthly_sms_report();
            }
        }       

        // check if it is first day of January    
        if(date('d') == 1 && date('m') == 1) {
            if($this->update_yearly_report() == true) {
                $this->send_yearly_sms_report();
            }
        }       
    }

    public function update_weekly_report() {
        $seven = \Carbon\Carbon::now()->subDays(7);
        $fromdate = date("Y-m-d 00:00:00", strtotime($seven));

        $yesterday = date("Y-m-d", time() - 60 * 60 * 24);
        $todate = date("Y-m-d 23:59:59", strtotime($yesterday));
        
        $fdate = date("d/m/Y", strtotime($fromdate));
        $tdate = date("d/m/Y", strtotime($todate));
        $from_to = $fdate.' to '.$tdate;        

        $accounts = \App\Company::whereIn('status',['active','free trial'])->get();
        foreach($accounts as $account) {

            TenantService::connect($account->dbname);

            if ($account->shops) {
                foreach ($account->shops as $shop) {
                    $sales = \App\Sale::where('shop_id',$shop->id)->where('status','sold')->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->get();
                    $expenses = \App\ShopExpense::where('shop_id',$shop->id)->whereBetween('created_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->get();
                    if ($sales->isNotEmpty() || $expenses->isNotEmpty()) {
                        $t_sales = $sales->sum('sub_total');
                        $quantities = $sales->sum('quantity');
                        $t_expenses = $expenses->sum('amount');
                        $profit = $sales->sum('sub_total') - $sales->sum('total_buying');
                        \App\WeeklySale::create(['from_to'=>$from_to, 'shop_id'=>$shop->id,'company_id'=>$account->id,'total_sales'=>$t_sales,'quantities'=>$quantities,'total_expenses'=>$t_expenses,'profit'=>$profit]);
                    }                    
                }                
            }            
        }
        return true;
    }

    public function update_monthly_report() {
        $from = \Carbon\Carbon::now()->startOfMonth()->subMonthsNoOverflow()->toDateString();
        $fromdate = date("Y-m-d 00:00:00", strtotime($from));

        $todate = \Carbon\Carbon::now()->subMonthsNoOverflow()->endOfMonth()->toDateString();
        $todate = date("Y-m-d 23:59:59", strtotime($todate));
        
        $fdate = date("d/m/Y", strtotime($fromdate));
        $tdate = date("d/m/Y", strtotime($todate));
        $from_to = $fdate.' to '.$tdate;        

        $accounts = \App\Company::whereIn('status',['active','free trial','end free trial'])->get();
        foreach($accounts as $account) {

            TenantService::connect($account->dbname);

            if ($account->shops) {
                foreach ($account->shops as $shop) {
                    $sales = \App\Sale::where('shop_id',$shop->id)->where('status','sold')->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->get();
                    $expenses = \App\ShopExpense::where('shop_id',$shop->id)->whereBetween('created_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->get();
                    if ($sales->isNotEmpty() || $expenses->isNotEmpty()) {
                        $t_sales = $sales->sum('sub_total');
                        $quantities = $sales->sum('quantity');
                        $t_expenses = $expenses->sum('amount');
                        $profit = $sales->sum('sub_total') - $sales->sum('total_buying');
                        \App\MonthlySale::create(['from_to'=>$from_to, 'shop_id'=>$shop->id,'company_id'=>$account->id,'total_sales'=>$t_sales,'quantities'=>$quantities,'total_expenses'=>$t_expenses,'profit'=>$profit]);
                    }                    
                }                
            }            
        }
        return true;
    }

    public function update_yearly_report() {
        $lastyear = date("Y",strtotime("-1 year"));
        $from = $lastyear."-1-1";
        $fromdate = date("Y-m-d 00:00:00", strtotime($from));

        $todate = \Carbon\Carbon::yesterday()->toDateString();
        $todate = date("Y-m-d 23:59:59", strtotime($todate));
        
        $fdate = date("d/m/Y", strtotime($fromdate));
        $tdate = date("d/m/Y", strtotime($todate));
        $from_to = $fdate.' to '.$tdate;        
        
        $accounts = \App\Company::all();
        foreach($accounts as $account) {

            TenantService::connect($account->dbname);

            if ($account->shops) {
                foreach ($account->shops as $shop) {
                    $sales = \App\Sale::where('shop_id',$shop->id)->where('status','sold')->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->get();
                    $expenses = \App\ShopExpense::where('shop_id',$shop->id)->whereBetween('created_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->get();
                    if ($sales->isNotEmpty() || $expenses->isNotEmpty()) {
                        $t_sales = $sales->sum('sub_total');
                        $quantities = $sales->sum('quantity');
                        $t_expenses = $expenses->sum('amount');
                        $profit = $sales->sum('sub_total') - $sales->sum('total_buying');
                        \App\YearlySale::create(['from_to'=>$from_to, 'shop_id'=>$shop->id,'company_id'=>$account->id,'total_sales'=>$t_sales,'quantities'=>$quantities,'total_expenses'=>$t_expenses,'profit'=>$profit]);
                    }                    
                }                
            }            
        }
        return true;
    }

    public function send_sms_report() {
        $api_key='shariff';
        $secret_key = 'ShariffPOS@91';

        $accounts = \App\Company::whereIn('status',['active','free trial'])->get(); 
        $output = array();
        foreach($accounts as $account) {

            TenantService::connect($account->dbname);

            if ($account->shops) {
                foreach ($account->shops as $shop) {
                    $report = \App\WeeklySale::whereDate('created_at',Carbon::today())->where('shop_id',$shop->id)->orderBy('id','desc')->first();
                    if($report) {
                        // get business owners
                        $recipients = array();
                        if ($account->companyOwners()) {
                            $rid = 1;
                            foreach ($account->companyOwners() as $owner) {
                                $recipients[] = $owner->phonecode.''.str_replace(' ', '', $owner->phone);
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
                            'text' => 'Ripoti ya wiki Monday - Sunday duka la '.$shop->name.'. Jumla mauzo: '.number_format($report->total_sales, 0).'. Idadi bidhaa zilizouzwa: '.$quantity.'. '.$profitloss.'. Matumizi: '.number_format($report->total_expenses, 0).'',
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

    public function send_monthly_sms_report() {               
        $api_key='shariff';
        $secret_key = 'ShariffPOS@91';

        $lastMonth = date('m', strtotime('last month'));
        $lastMonthYear = date('Y', strtotime('last month'));

        $accounts = \App\Company::whereIn('status',['active','free trial'])->get();
        $output = array();
        foreach($accounts as $account) {

            TenantService::connect($account->dbname);

            if ($account->shops) {
                foreach ($account->shops as $shop) {
                    $report = \App\MonthlySale::whereDate('created_at',Carbon::today())->where('shop_id',$shop->id)->orderBy('id','desc')->first();
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
                            'text' => 'Ripoti ya Mwezi wa '.$lastMonth.'.'.$lastMonthYear.' duka la '.$shop->name.'. Jumla mauzo: '.number_format($report->total_sales, 0).'. Idadi bidhaa zilizouzwa: '.$quantity.'. '.$profitloss.'. Matumizi: '.number_format($report->total_expenses, 0).'',
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

    public function send_yearly_sms_report() {             
        $api_key='shariff';
        $secret_key = 'ShariffPOS@91';

        $accounts = \App\Company::all();
        $output = array();
        foreach($accounts as $account) {

            TenantService::connect($account->dbname);

            if ($account->shops) {
                foreach ($account->shops as $shop) {
                    $report = \App\YearlySale::whereDate('created_at',Carbon::today())->where('shop_id',$shop->id)->orderBy('id','desc')->first();
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
                        $lastyear = date("Y",strtotime("-1 year"));

                        $postData = array(
                            'from' => 'Levanda POS',
                            'to' => $recipients,
                            'text' => 'Ripoti ya Mwaka '.$lastyear.' duka la '.$shop->name.'. Jumla mauzo: '.number_format($report->total_sales, 0).'. Idadi bidhaa zilizouzwa: '.$quantity.'. '.$profitloss.'. Matumizi: '.number_format($report->total_expenses, 0).'',
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
