<?php

namespace App\Jobs;

use DateTime;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Auth;

class UpdateDailySales implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($shop_id,$date)
    {
        $this->shopid = $shop_id;
        $this->date = $date;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $shop_id = $this->shopid;
        $saledate = $this->date;
        
        $date = date("Y-m-d", strtotime($saledate));

        $sales = \App\Sale::where('shop_id',$shop_id)->where('status','sold')->whereDate('updated_at', $date)->get();
        $expenses = \App\ShopExpense::where('shop_id',$shop_id)->whereDate('created_at', $date)->get();
        if ($sales->isNotEmpty() || $expenses->isNotEmpty()) {
            $t_sales = $sales->sum('sub_total');
            $quantities = $sales->sum('quantity');
            $t_expenses = $expenses->sum('amount');
            $profit = $sales->sum('sub_total') - $sales->sum('total_buying');

            $dsale = \App\DailySale::where('date',$date)->where('shop_id',$shop_id)->first();
            if($dsale) {
                $dsale->update(['total_sales'=>$t_sales,'quantities'=>$quantities,'total_expenses'=>$t_expenses,'profit'=>$profit]);
            } else {
                \App\DailySale::create(['date'=>$date, 'shop_id'=>$shop_id,'company_id'=>Auth::user()->company_id,'total_sales'=>$t_sales,'quantities'=>$quantities,'total_expenses'=>$t_expenses,'profit'=>$profit]);
            }
        }                    
    }
}
