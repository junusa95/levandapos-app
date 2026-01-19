<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class UpdateMinimumStockLevel implements ShouldQueue
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
        $pid = $this->details['pid'];
        $shopstore = $this->details['shopstore'];
        $sid = $this->details['sid'];
        $mlevel = $this->details['mlevel'];

        $shop_id = $store_id = null;
        $p = \App\Product::find($pid);
        $sub_title = $p->name.' is below the required stock level';
        if($shopstore == "shop") {
            $s = \App\Shop::find($sid);
            $shop_id = $s->id;
            $check = \App\Notification::where('shop_id',$sid)->where('product_id',$pid)->first();
        }
        if($shopstore == "store") {
            $s = \App\Store::find($sid);
            $store_id = $s->id;
            $check = \App\Notification::where('store_id',$sid)->where('product_id',$pid)->first();
        }
        $desc = '<h5>Minimus Stock Level</h5><p>'.$p->name.' is below the required stock level in '.$s->name.'. <br> The minimum stock level is '.($mlevel + 0).'</p>';
        
        if($check) {} else {
            \App\Notification::create(['company_id'=>Auth::user()->company_id,'title'=>'Minimum Stock Level','sub_title'=>$sub_title,'description'=>$desc,'type'=>'minimum stock level','shop_id'=>$shop_id,'store_id'=>$store_id,'product_id'=>$p->id]);
        }
    }
}
