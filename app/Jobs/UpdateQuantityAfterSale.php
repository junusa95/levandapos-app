<?php

namespace App\Jobs; 

use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateQuantityAfterSale implements ShouldQueue
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
        $saleno = $this->details['saleno'];
        $shop_id = $this->details['shop_id'];

        $sales = \App\Sale::where('sale_no',$saleno)->where('shop_id',$shop_id)->where('status','sold')->get();
        if ($sales->isNotEmpty()) {
            foreach ($sales as $sale) {

                $customer_id = $sale->customer_id;
            }
        }

        if ($customer_id != null) {
            $check3 = \App\Sale::where('sale_no',$saleno)->first();
            if ($check3->customer_id) {
                $subtotal = \App\Sale::where('sale_no',$saleno)->sum('sub_total');
                $paidamount = $check3->paid_amount;
                $debt = $subtotal - $paidamount;
                \App\CustomerDebt::create(['shop_id'=>$check3->shop_id,'customer_id'=>$check3->customer_id,'debt_amount'=>$debt,'status'=>"buy stock",'stock_value'=>$subtotal,'amount_paid'=>$paidamount,'reference'=>$check3->sale_no,'company_id'=>$check3->company_id,'user_id'=>$check3->user_id,'updated_at'=>$check3->updated_at]);                
            }
        }

    }
}
