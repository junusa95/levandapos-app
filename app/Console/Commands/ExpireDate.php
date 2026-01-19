<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TenantService;

class ExpireDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expire:date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checking for expire date and add to notification table';

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
        //
        // get expired products in 30 days from today
        $today = \Carbon\Carbon::today();
        $thirty = \Carbon\Carbon::now()->subDays(-30);

        $accounts = \App\Company::whereIn('status',['active','free trial'])->get(); 
        foreach($accounts as $account) {

            TenantService::connect($account->dbname);

            $products = \App\Product::whereBetween('expire_date', [\Carbon\Carbon::parse($today),\Carbon\Carbon::parse($thirty)])->where('status','published')->get();
            if($products->isNotEmpty()) { 
                foreach($products as $p) {
                    // count days 
                    $startT = new \DateTime($p->expire_date);
                    $today = new \DateTime($today);
                    $interval = $startT->diff($today);
                    $interval = $interval->format('%d');
                    if($interval == 0) {
                        $title = "Product Expired"; 
                        $sub_title = $p->name.' has expired';
                        $desc = "<h5>Expire Date</h5><p>Product has expired <br> <span>Product name: </span><b>".$p->name."</b><br> <span>Expire date: </span><b>".date('d/m/Y', strtotime($p->expire_date))."</b><br></p>";
                    } else {
                        $title = "Expire Date";
                        $sub_title = $interval.' days left '.$p->name.' to expire';
                        $desc = "<h5>Expire Date</h5><p>Product is about to expire <br> <span>Product name: </span><b>".$p->name."</b><br> <span>Expire date: </span><b>".date('d/m/Y', strtotime($p->expire_date))."</b><br></p>";
                    }
                    \App\Notification::create(['company_id'=>$p->company_id,'title'=>$title,'sub_title'=>$sub_title,'description'=>$desc,'type'=>'expire date']);
                }
            }
        }
    }
}
