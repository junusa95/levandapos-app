<?php

namespace App\Console\Commands;

use DateTime;
use Illuminate\Console\Command;
use App\Services\TenantService;

class EndFreetrial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'end:freetrial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to check status of new registered accounts. Count for free trial use';

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
        $companies = \App\Company::where('status','free trial')->get();
        $today = date('Y-m-d');
        if($companies->isNotEmpty()) {
            foreach($companies as $company) {

                TenantService::connect($company->dbname);

                $e_date = date('Y-m-d', strtotime($company->created_at . ' +30 day'));
                if ($today > $e_date) {
                    $company->update(['status'=>'end free trial', 'reminder'=>null]);
                    if($company->shops) {
                        foreach($company->shops as $shop) {
                            $shop->update(['status'=>'end free trial','reminder'=>null]);
                        }
                    }
                    if($company->stores) {
                        foreach($company->stores as $store) {
                            $store->update(['status'=>'end free trial','reminder'=>null]);
                        }
                    }
                } else {
                    // check remaining days
                    $count = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($company->created_at))))->days;
                    $days = (30 - $count);
                    if($days <= 5 && $days >= 0) {   
                        $company->update(['reminder'=>$days]);
                        if($company->shops) {
                            foreach($company->shops as $shop) {
                                $count2 = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($shop->created_at))))->days;
                                $days2 = (30 - $count2);
                                if($days2 <= 5 && $days2 >= 0) {
                                    $shop->update(['reminder'=>$days2]);
                                }
                            }
                        }
                        if($company->stores) {
                            foreach($company->stores as $store) {
                                $count2 = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($store->created_at))))->days;
                                $days2 = (30 - $count2);
                                if($days2 <= 5 && $days2 >= 0) {
                                    $store->update(['reminder'=>$days2]);
                                }
                            }
                        }
                    }
                }
            }
        }

        $isActive = "";
        $companies2 = \App\Company::where('status','active')->get();
        if($companies2->isNotEmpty()) {
            foreach($companies2 as $company2) {

                TenantService::connect($company2->dbname);

                // check if no any active or free trial shop/store
                $pay = \App\PaymentsDesc::where('company_id',$company2->id)->orderBy('expire_date','desc')->first();
                if($pay) {
                    $today = date('Y-m-d');
                    // $count2 = (new DateTime($pay->expire_date))->diff(new DateTime(date('Y-m-d',strtotime($today))))->days;
                    if ($today > $pay->expire_date) { //all shops/stores from paymentDescs table are expired 
                        $shopsInPayments = \App\PaymentsDesc::where('company_id',$company2->id)->where('paid_for','shop')->get();
                        if($shopsInPayments->isNotEmpty()) {
                            foreach ($shopsInPayments as $sinp) {
                                \App\Shop::where('id',$sinp->paid_item)->update(['status'=>'not paid','reminder'=>null]);
                            }
                        }
                        $storesInPayments = \App\PaymentsDesc::where('company_id',$company2->id)->where('paid_for','store')->get();
                        if($storesInPayments->isNotEmpty()) {
                            foreach ($storesInPayments as $stinp) {
                                \App\Store::where('id',$stinp->paid_item)->update(['status'=>'not paid','reminder'=>null]);
                            }
                        }
                        // check if there are free trial shops/stores 
                        $fshops = \App\Shop::where('company_id',$company2->id)->where('status','!=','not paid')->get();
                        if($fshops->isNotEmpty()) {
                            foreach ($fshops as $fshop) {
                                $es_date = date('Y-m-d', strtotime($fshop->created_at . ' +30 day'));
                                if ($today > $es_date) { //expired
                                    if ($fshop->status) { } else { // null status means free trial 
                                        $fshop->update(['status'=>'end free trial','reminder'=>null]);
                                    }
                                } else {
                                    if ($fshop->status) { } else { // null status means free trial 
                                        // mark as this company is still active 
                                        $isActive = 'yes';
                                        $count2 = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($fshop->created_at))))->days;
                                        $days2 = (30 - $count2); 
                                        if($days2 <= 5 && $days2 >= 0) {   
                                            $fshop->update(['reminder'=>$days2]);
                                        }
                                    }
                                }
                            }
                        }
                        $fstores = \App\Store::where('company_id',$company2->id)->where('status','!=','not paid')->get();
                        if($fstores->isNotEmpty()) {
                            foreach ($fstores as $fstore) {
                                $est_date = date('Y-m-d', strtotime($fstore->created_at . ' +30 day'));
                                if ($today > $est_date) { //expired
                                    if ($fstore->status) { } else { // null status means free trial 
                                        $fstore->update(['status'=>'end free trial','reminder'=>null]);
                                    }
                                } else {
                                    if ($fstore->status) { } else { // null status means free trial 
                                        // mark as this company is still active 
                                        $isActive = 'yes';
                                        $count2 = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($fstore->created_at))))->days;
                                        $days2 = (30 - $count2);
                                        if($days2 <= 5 && $days2 >= 0) {   
                                            $fstore->update(['reminder'=>$days2]);
                                        }
                                    }
                                }
                            }
                        }

                        if($isActive == 'yes') { } else { // no any active shop/store in this account
                            $company2->update(['status'=>'not paid','reminder'=>null]);
                        }
                        
                    } else {
                        //
                        //
                        // shops in paymentdescs, check for activeness, reminder end payment, update not paid 
                        $shopsInPayments = \App\PaymentsDesc::where('company_id',$company2->id)->where('paid_for','shop')->groupBy('paid_item')->get();
                        if($shopsInPayments->isNotEmpty()) {
                            foreach ($shopsInPayments as $sinp) { 
                                $lastPay = \App\PaymentsDesc::where('company_id',$company2->id)->where('paid_for','shop')->where('paid_item',$sinp->paid_item)->orderBy('expire_date','desc')->first(); //take only the last entry of payment
                                if($today > $lastPay->expire_date) {
                                    \App\Shop::where('id',$lastPay->paid_item)->update(['status'=>'not paid','reminder'=>null]);
                                } else {
                                    $count2 = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($lastPay->expire_date))))->days;
                                    if($count2 <= 5 && $count2 >= 0) {   
                                        \App\Shop::where('id',$lastPay->paid_item)->update(['reminder'=>$count2]);
                                    }
                                }                                
                            }
                        }
                        $storesInPayments = \App\PaymentsDesc::where('company_id',$company2->id)->where('paid_for','store')->get();
                        if($storesInPayments->isNotEmpty()) {
                            foreach ($storesInPayments as $stinp) {
                                $lastPay = \App\PaymentsDesc::where('company_id',$company2->id)->where('paid_for','store')->where('paid_item',$stinp->paid_item)->orderBy('expire_date','desc')->first(); //take only the last entry of payment
                                if($today > $lastPay->expire_date) {
                                    \App\Store::where('id',$lastPay->paid_item)->update(['status'=>'not paid','reminder'=>null]);
                                } else {
                                    $count2 = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($lastPay->expire_date))))->days;
                                    if($count2 <= 5 && $count2 >= 0) {   
                                        \App\Store::where('id',$lastPay->paid_item)->update(['reminder'=>$count2]);
                                    }
                                }                                
                            }
                        }
                        // free trial shops stores
                        $shopss = \App\Shop::where('company_id',$company2->id)->whereNull('status')->get();
                        if($shopss) {
                            foreach ($shopss as $shop) {
                                $es_date = date('Y-m-d', strtotime($shop->created_at . ' +30 day'));
                                if($today > $es_date) {
                                    $shop->update(['status'=>'end free trial','reminder'=>null]);
                                } else {
                                    $count2 = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($shop->created_at))))->days;
                                    $days2 = (30 - $count2);
                                    if($days2 <= 5 && $days2 >= 0) {   
                                        $shop->update(['reminder'=>$days2]);
                                    }
                                }                                
                            }
                        }
                        $storess = \App\Store::where('company_id',$company2->id)->whereNull('status')->get();
                        if($storess) {
                            foreach ($storess as $store) {
                                $es_date = date('Y-m-d', strtotime($store->created_at . ' +30 day'));
                                if($today > $es_date) {
                                    $store->update(['status'=>'end free trial','reminder'=>null]);
                                } else {
                                    $count2 = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($store->created_at))))->days;
                                    $days2 = (30 - $count2);
                                    if($days2 <= 5 && $days2 >= 0) {   
                                        $store->update(['reminder'=>$days2]);
                                    }
                                }                                
                            }
                        }

                    }
                }
                
            }
        }
    }
}
