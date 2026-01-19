<?php

namespace App\Jobs;

use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class UpdateMinimumStockLevel2 implements ShouldQueue
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
        $ids = $this->details['ids'];
        $shop_id = $this->details['shop_id'];
        $company_id = Auth::user()->company_id;

        foreach ($ids as $value) {
            $product = \App\Product::query()->select([
                    DB::raw('products.id as pid, products.name as pname, products.min_stock_level, shop_products.quantity as quantity')
                ])
                ->leftJoin('shop_products', function ($join) {
                    $join->on('shop_products.product_id','=','products.id')->where('shop_products.active','yes');
                })
                ->where('products.id',$value)->where('shop_products.shop_id',$shop_id)->first();

            if($product["min_stock_level"] >= $product["quantity"]) {
                $check = \App\Notification::where('shop_id',$shop_id)->where('product_id',$product["pid"])->first();
                if ($check) { } else {
                    $sname = \App\Shop::where('id', $shop_id)->first()->name;
                    $sub_title = $product["pname"].' is below the required stock level';
                    $desc = '<h5>Minimum Stock Level</h5><p>'.$product["pname"].' is below the required stock level in '.$sname.'. <br> The minimum stock level is '.($product["min_stock_level"] + 0).'</p>';

                    \App\Notification::create(['company_id'=>$company_id,'title'=>'Minimum Stock Level','sub_title'=>$sub_title,'description'=>$desc,'type'=>'minimum stock level','shop_id'=>$shop_id,'store_id'=>null,'product_id'=>$product["pid"]]);
                }
            }
        }
    }
}
