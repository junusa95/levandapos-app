<?php

namespace App\Http\Controllers;

use DB;
use Cookie;
use Session;
use DateTime;
use DatePeriod;
use DateInterval;
use App\Shop;
use App\Store;
use App\User;
use App\Company;
use App\Currency;
use App\Customer;
use App\CustomerDebt;
use App\Sale;
use App\DailySale;
use App\Product;
use App\Transfer;
use App\ClosureSale;
use App\ReturnSoldItem;
use App\NewStock;
use App\ProductCategory;
use App\ProductCategoryGroup;
use App\Expense;
use App\Measurement;
use App\StockAdjustment;
use App\ShopExpense;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\TenantService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    private function getCookies() {
        return Cookie::get("language");
    }

    public function __construct()
    {
        
    }

    // public function sales() {
    //     $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
    //     $data['items'] = Product::where('status','!=','deleted')->where('company_id',Auth::user()->company_id)->get();
    //     return view('business-owner.sales', compact('data'));
    // }

    // public function stock() {
    //     $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
    //     $data['stores'] = Store::where('company_id',Auth::user()->company_id)->get();
    //     $data['products'] = Product::where('status','published')->where('company_id',Auth::user()->company_id)->get();
    //     return view('business-owner.stock', compact('data'));
    // }

    public function report_by_date_range($check,$fromdate,$todate,$shop_id) {
        // this function affects on cashier only for now
        if($this->getCookies() == 'en') {
            $_GET['refund'] = "Refund";
            $_GET['pay-debt'] = "Pay debt";
        } else {
            $_GET['refund'] = "Amerudishiwa pesa";
            $_GET['pay-debt'] = "Amelipwa deni";
        }
        $output = array();
        $totalSQ = 0;
        $totalSP = 0;
        $totalBP = 0;
        $totalEX = 0;
        $i = 1;
        $data['totalorders'] = 0;
        $begin = new \DateTime($fromdate);
        $end = new \DateTime($todate);
        $fromdate = date("Y-m-d 00:00:00", strtotime($fromdate));
        $todate = date("Y-m-d 23:59:59", strtotime($todate));

        // daily sales
        if($check == "daily-sales") {
            $dates = $d_dates = $d_sales = array();                      
            $start_date = date_create($fromdate);
            $end_date = date_create($todate);
            $interval = new DateInterval('P1D');
            $date_range = new DatePeriod($start_date, $interval, $end_date);
            $date_range = array_reverse(iterator_to_array($date_range));
            if ($shop_id == "all") {      
                foreach ($date_range as $date) {
                    $total_qty = Sale::where('company_id',Auth::user()->company_id)->whereDate('updated_at', $date)->where('status','sold')->sum('quantity');
                    $total_sales = Sale::where('company_id',Auth::user()->company_id)->whereDate('updated_at', $date)->where('status','sold')->sum('sub_total');
                    $total_buying_price = Sale::where('company_id',Auth::user()->company_id)->whereDate('updated_at', $date)->where('status','sold')->sum('total_buying');
                    $expenses = ShopExpense::where('company_id',Auth::user()->company_id)->whereDate('created_at', $date)->sum('amount');
                    $profit = $total_sales - $total_buying_price;
                    $net_profit = $profit - $expenses;
                    // total
                    $this_date = $date->format('Y-m-d');
                    $totalSQ = $totalSQ + $total_qty;
                    $totalSP = $totalSP + $total_sales;
                    $totalBP = $totalBP + $total_buying_price;
                    $totalEX = $totalEX + $expenses;
                    $gprofit = $nprofit = "";
                    if(Auth::user()->isBusinessOwner()){
                        $gprofit = '<td>'.number_format($profit, 0).'</td>';
                        $nprofit = '<td>'.number_format($net_profit, 0).'</td>';
                    }
                    $dates[] = "<tr><td>".$date->format('Y-m-d')."</td><td>".sprintf('%g',$total_qty)."</td><td>".number_format($total_sales, 0)."</td>".$gprofit."<td>".number_format($expenses, 0)."</td>".$nprofit."<td style='width:50px;'><span class='view-sales' date='".$this_date."'><i class='fa fa-eye'></i></span></td></tr>";
                    $d_dates[] = $date->format('d/m/Y');
                    $d_sales[] = $total_sales;
                }
            } else {
                foreach ($date_range as $date) {
                    $total_qty = Sale::where('company_id',Auth::user()->company_id)->whereDate('updated_at', $date)->where('shop_id',$shop_id)->where('status','sold')->sum('quantity');
                    $total_sales = Sale::where('company_id',Auth::user()->company_id)->whereDate('updated_at', $date)->where('shop_id',$shop_id)->where('status','sold')->sum('sub_total');
                    $total_buying_price = Sale::where('company_id',Auth::user()->company_id)->whereDate('updated_at', $date)->where('shop_id',$shop_id)->where('status','sold')->sum('total_buying');
                    $expenses = ShopExpense::where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->whereDate('created_at', $date)->sum('amount');
                    $profit = $total_sales - $total_buying_price;
                    $net_profit = $profit - $expenses;
                    // total
                    $this_date = $date->format('Y-m-d');
                    $totalSQ = $totalSQ + $total_qty;
                    $totalSP = $totalSP + $total_sales;
                    $totalBP = $totalBP + $total_buying_price;
                    $totalEX = $totalEX + $expenses;
                    $gprofit = $nprofit = "";
                    if(Auth::user()->isBusinessOwner()){
                        $gprofit = '<td>'.number_format($profit, 0).'</td>';
                        $nprofit = '<td>'.number_format($net_profit, 0).'</td>';
                    }
                    $dates[] = "<tr><td>".$date->format('Y-m-d')."</td><td>".sprintf('%g',$total_qty)."</td><td>".number_format($total_sales, 0)."</td>".$gprofit."<td>".number_format($expenses, 0)."</td>".$nprofit."<td style='width:50px;'><span class='view-sales' date='".$this_date."'><i class='fa fa-eye'></i></span></td></tr>";
                    $d_dates[] = $date->format('d/m/Y');
                    $d_sales[] = $total_sales;
                }
            }
            $data['sale'] = Sale::where('company_id',Auth::user()->company_id)->where('status','sold')->orderBy('id','desc')->first();
            return response()->json(['data'=>$data,'dates'=>$dates,'d_dates'=>$d_dates,'d_sales'=>$d_sales,'totalSQ'=>$totalSQ,'totalSP'=>$totalSP,'totalEX'=>$totalEX,'profit'=>$totalSP-$totalBP]);
        }

        if($check == "sales-with-profit-summary") {
            $sales = Sale::query()->select([
                DB::raw("SUM(quantity) as total_qty"),
                DB::raw("SUM(sub_total) as total_sales"),
                DB::raw("SUM(total_buying) as total_buying_price")
            ])
            ->where('company_id',Auth::user()->company_id)
            ->where('shop_id',$shop_id)
            ->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])
            ->where('status','sold')
            ->get();
            $totalEX = ShopExpense::where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->whereBetween('created_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->sum('amount');

            return response()->json(['sales'=>$sales,'totalEX'=>$totalEX]);
        }

        if($check == "sales-with-profit-details") {    
            $sales = Sale::query()->select([
                DB::raw("DATE(updated_at), SUM(quantity) as total_qty, SUM(sub_total) as total_sales, SUM(total_buying) as total_buying_price"),
            ])
            ->where('status','sold')
            ->where('company_id', Auth::user()->company_id)
            ->whereBetween('updated_at', [Carbon::parse($fromdate)->startOfMonth(),Carbon::parse($todate)->endOfMonth()])
            ->where('shop_id',$shop_id)
            ->groupBy(DB::raw('DATE(updated_at)'))->get();

            return response()->json(['sales'=>$sales]);
        }

        if($check == "sales-with-profit-details-2") { // this is pprocessing show more button ... IT IS NOT USED ANYMORE
            
            $sales = Sale::query()->select([
                DB::raw("SUM(quantity) as total_qty"),
                DB::raw("SUM(sub_total) as total_sales"),
                DB::raw("SUM(total_buying) as total_buying_price")
            ])
            ->where('status','sold')
            ->where('company_id', Auth::user()->company_id)
            ->whereDate('updated_at', Carbon::parse($fromdate))
            ->where('shop_id',$shop_id)->get();
            $expenses = ShopExpense::where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->whereDate('created_at', Carbon::parse($fromdate))->sum('amount');
            $data['rowdate'] = date('d', strtotime($fromdate));
            $data['this_date'] = date('Y-m-d', strtotime($fromdate)); 

            return response()->json(['sales'=>$sales,'data'=>$data,'expenses'=>$expenses]);                       
        }

        if ($check == "daily-expenses") {
            $expenses = ShopExpense::query()->select([
                DB::raw("DATE(created_at), SUM(amount) as amount"),
            ])->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)
            ->whereBetween('created_at',  [Carbon::parse($fromdate)->startOfMonth(),Carbon::parse($todate)->endOfMonth()])
            ->groupBy(DB::raw('DATE(created_at)'))->get();
            
            return response()->json(['expenses'=>$expenses]);
        }

        // sales report
        if ($check == "sales") {
            if ($shop_id == 'all') {
                $items = Sale::whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('status','sold')->orderBy('updated_at')->where('company_id',Auth::user()->company_id)->get(); 
                $data['sum'] = ShopExpense::where('company_id',Auth::user()->company_id)->whereBetween('created_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->sum('amount');
            } else {
                $items = Sale::whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('shop_id',$shop_id)->where('status','sold')->orderBy('updated_at')->where('company_id',Auth::user()->company_id)->get(); 
                $data['sum'] = ShopExpense::where('company_id',Auth::user()->company_id)->whereBetween('created_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('shop_id',$shop_id)->sum('amount');
            }
            // only items with sold status: ignore edited,draft and deleted statuses 
            if ($items->isNotEmpty()) {
                foreach ($items as $value) {
                    $totalSQ = $totalSQ + $value->quantity;
                    $totalSP = $totalSP + $value->sub_total;
                    $totalBP = $totalBP + ($value->buying_price * $value->quantity);
                    $profit = ($value->selling_price - $value->buying_price) * $value->quantity;
                    $time = $value->updated_at->format('g:i a');
                    $protd = "";
                    if(Auth::user()->isBusinessOwner()){
                        $protd = '<td>'.number_format($profit, 0).'</td>';
                    }
                    $output[] = '<tr class="sr-'.$value->id.'"><td>'.$i.'</td><td>'.$value->product->name.'</td>'
                        .'<td>'.sprintf('%g',$value->quantity).'</td>'
                        .'<td>'.number_format($value->selling_price, 0).'</td>'
                        .'<td>'.number_format($value->sub_total, 0).'</td>'.
                        $protd
                        .'<td>'.$time.'</td></tr>';
                    $i++;
                }    
            } else {
                $output[] = '<tr><td colspan="6" align="center"><i>-- No Sales --</i></td></tr>';
            }    
            $data['sum'] = number_format($data['sum'], 0);
            return response()->json(['data'=>$data,'items'=>$output,'totalSQ'=>$totalSQ,'totalSP'=>$totalSP,'profit'=>$totalSP-$totalBP]);
        }
        // previous stock records
        if ($check == "previous-stock-records") {
            $shopstore = "";
            $status = $sender = $receiver = "";
            $items = NewStock::whereBetween('sent_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('company_id',Auth::user()->company_id)->where('status','updated')->orderBy('id','desc')->limit(25)->get();
            if ($items->isNotEmpty()) {
                foreach($items as $value) {    
                    if ($value->status == "updated") {
                         $status = "Received";
                    }     
                    if ($value->shop) {
                        $shopstore = $value->shop->name;
                    }
                    if ($value->store) {
                        $shopstore = $value->store->name;
                    }
                    if ($value->sender) {
                        $sender = $value->sender->name;
                    }
                    if ($value->receiver) {
                        $receiver = $value->receiver->name;
                    }
                    $output[] = '<tr><td>'.$value->product->name.'</td>'
                        .'<td>'.sprintf('%g',$value->added_quantity).'</td>'
                        .'<td>'.$shopstore.'</td>'
                        .'<td><span class="badge badge-success">'.$status.'</span></td>'
                        .'<td class="table-details"><b>Sender: </b>'.$sender.'<br><b>Sent at: </b>'.$value->sent_at.'<br><b>Receiver: </b>'.$receiver.'<br><b>Received at: </b>'.$value->received_at.'</td>'
                        .'</tr>';
                    $status = $sender = $receiver = "";
                }
            } else {
                $output[] = '<tr class="empty-row"><td colspan="7" align="center"><i>-- No items --</i></td></tr>';
            }
            return response()->json(['items'=>$output]);
        }
        if ($check == "previous-stock-records-in-shop") {
            $shopstore = "";
            $status = $sender = $receiver = "";
            $sum = NewStock::query()->select([
                DB::raw('DATE(sent_at) as date, sum(total_buying) as total_price, sum(added_quantity) as quantity')
            ])
            ->whereBetween('sent_at', [Carbon::parse($fromdate),Carbon::parse($todate)])
            ->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('status','updated')
            ->groupBy('date')->orderBy('date','desc')->get();

            $items = NewStock::query()->select([
                DB::raw('new_stocks.id as nid, products.name as pname, users.name as sent_by, DATE_FORMAT(new_stocks.sent_at, "%H:%i") as sent_at, u.name as received_by, DATE_FORMAT(new_stocks.received_at, "%H:%i") as received_at, new_stocks.added_quantity as quantity, new_stocks.buying_price as price, new_stocks.total_buying as total, DATE(new_stocks.sent_at) as date')
            ])
            ->join('products','products.id','new_stocks.product_id')
            ->join('users','users.id','new_stocks.user_id')
            ->join('users as u','u.id','new_stocks.received_by')
            ->whereBetween('new_stocks.sent_at', [Carbon::parse($fromdate),Carbon::parse($todate)])
            ->where('new_stocks.company_id',Auth::user()->company_id)->where('new_stocks.shop_id',$shop_id)->where('new_stocks.status','updated')
            ->orderBy('new_stocks.id','desc')->get();

            return response()->json(['items'=>$items,'sum'=>$sum]);

            // $items = NewStock::whereBetween('sent_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('status','updated')->orderBy('id','desc')->get();
            // if ($items->isNotEmpty()) {
            //     foreach($items as $value) {   
            //         if ($value->sender) {
            //             $sender = $value->sender->name;
            //         }
            //         if ($value->receiver) {
            //             $receiver = $value->receiver->name;
            //         }
            //         $sent_at = date('d/m/Y H:i', strtotime($value->sent_at));
            //         $received_at = date('d/m/Y H:i', strtotime($value->received_at));
            //         $total = $value->added_quantity * $value->buying_price;
            //         $total_p = number_format($total);
            //         if(Auth::user()->isCEOorAdminorBusinessOwner()) {
            //             $idadi = '<div class="mt-1"><b class="b_q" style="font-weight: bolder;">'.sprintf("%g",$value->added_quantity).'</b><span>x</span><span>'.number_format($value->buying_price).'</span><span>=</span><span>'.$total_p.'</span></div>';
            //         } else {
            //             $idadi = '<span class="px-1 ml-1 pq-'.$value->id.'" style="background-color: aqua;font-weight: bolder;">'.sprintf("%g",$value->added_quantity).'</span>';
            //         }
                    
            //         $output[] = '<tr><td>'.$value->product->name.' '.$idadi.'</td>'
            //             .'<td class="table-details"><b>Added By: </b>'.$sender.' <small>('.$sent_at.')</small><br><b>Received By: </b>'.$receiver.' <small>('.$received_at.')</small></td>'
            //             .'</tr>';
            //     }
            // } else {
            //     $output[] = '<tr class="empty-row"><td colspan="2" align="center"><i>-- No received items --</i></td></tr>';
            // }
            // return response()->json(['items'=>$output]);
        }
        if ($check == "previous-stock-records-in-store") {
            $shopstore = "";
            $status = $sender = $receiver = "";
            $store_id = $shop_id; // $shop_id == store id 
            $sum = NewStock::query()->select([
                DB::raw('DATE(sent_at) as date, sum(total_buying) as total_price, sum(added_quantity) as quantity')
            ])
            ->whereBetween('sent_at', [Carbon::parse($fromdate),Carbon::parse($todate)])
            ->where('company_id',Auth::user()->company_id)->where('store_id',$store_id)->where('status','updated')
            ->groupBy('date')->orderBy('date','desc')->get();

            $items = NewStock::query()->select([
                DB::raw('new_stocks.id as nid, products.name as pname, users.name as sent_by, DATE_FORMAT(new_stocks.sent_at, "%H:%i") as sent_at, u.name as received_by, DATE_FORMAT(new_stocks.received_at, "%H:%i") as received_at, new_stocks.added_quantity as quantity, new_stocks.buying_price as price, new_stocks.total_buying as total, DATE(new_stocks.sent_at) as date')
            ])
            ->join('products','products.id','new_stocks.product_id')
            ->join('users','users.id','new_stocks.user_id')
            ->join('users as u','u.id','new_stocks.received_by')
            ->whereBetween('new_stocks.sent_at', [Carbon::parse($fromdate),Carbon::parse($todate)])
            ->where('new_stocks.company_id',Auth::user()->company_id)->where('new_stocks.store_id',$store_id)->where('new_stocks.status','updated')
            ->orderBy('new_stocks.id','desc')->get();

            return response()->json(['items'=>$items,'sum'=>$sum]);
        }
        // expenses report
        if ($check == "expenses") {
            // ignore the data date and today but dont remove them
            $data['date'] = "";
            $data['today'] = "-";
            if ($shop_id == 'all') {
                $data['shopExpenses'] = ShopExpense::where('company_id',Auth::user()->company_id)->whereBetween('created_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->get();
                $data['sum'] = ShopExpense::where('company_id',Auth::user()->company_id)->whereBetween('created_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->sum('amount');
            } else {
                $data['shopExpenses'] = ShopExpense::where('company_id',Auth::user()->company_id)->whereBetween('created_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('shop_id',$shop_id)->get();
                $data['sum'] = ShopExpense::where('company_id',Auth::user()->company_id)->whereBetween('created_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('shop_id',$shop_id)->sum('amount');
            }
            $view = view('partials.expenses-cost', compact('data'))->render();   

            $data['sum'] = number_format($data['sum'], 0);
            return response()->json(['view'=>$view, 'data'=>$data]); 
        }
        if ($check == "expenses-2") { // this report is for a single  date.. not for interval
            $output = array();
            $expenses = ShopExpense::where('company_id',Auth::user()->company_id)->whereDate('created_at', $fromdate)->where('shop_id',$shop_id)->get();
            $data['sum'] = ShopExpense::where('company_id',Auth::user()->company_id)->whereDate('created_at', $fromdate)->where('shop_id',$shop_id)->sum('amount');
            if($expenses->isNotEmpty()) {
                $num = 1;
                foreach($expenses as $e) {
                    $output[] = '<tr><td>'.$num.'</td><td>'.$e->expense->name.'</td><td>'.number_format($e->amount, 0).'</td><td>'.$e->description.'</td></tr>';
                    $num++;
                }
                $output[] = '<tr><td colspan="2"><b>Total</b></td><td><b>'.number_format($data['sum'], 0).'</b></td></tr>';
            } else {
                $output[] = '<tr><td colspan="4">- No Expenses -</td></tr>';
            }
            return response()->json(['output'=>$output]);
        }
        // sales by order
        if ($check == "orders") {
            $users = array();
            $list = array();
            if ($shop_id == 'all') {
                $sy = "!=";
            } else {
                $sy = "=";
            }
            $orders = Sale::where('company_id',Auth::user()->company_id)->where('shop_id',$sy,$shop_id)->where('status','sold')->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('is_order','yes')->groupBy('sale_no')->orderBy('updated_at','desc')->selectRaw('*, sum(quantity) as sumQ, sum(sub_total) as sumP')->get();
            if ($orders->isNotEmpty()) {
                foreach($orders as $value) {
                    if (in_array($value->ordered_by, $users)) {
                        
                    } else {
                        $users[] = $value->ordered_by;
                        $total = Sale::where('company_id',Auth::user()->company_id)->where('shop_id',$sy,$shop_id)->where('status','sold')->where('ordered_by',$value->ordered_by)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('is_order','yes')->groupBy('sale_no')->get()->count('id');
                        $list[] = '<li><b>'.$total.'</b> orders by <b>'.$value->orderedBy->name.'</b></li>';
                    }                    
                    
                    $output[] = '<tr><td><b><a href="#" class="order-items" order="'.$value->sale_no.'">'.$value->sale_no.'</a></b></td><td>'.sprintf('%g',$value->sumQ).'</td><td>'.number_format($value->sumP).'</td><td>'.$value->orderedBy->name.'</td><td>'.$value->soldBy->name.'</td><td>'.$value->shop->name.'</td></tr>';
                    $data['totalorders']++;
                }
            }
            return response()->json(['items'=>$output,'data'=>$data,'list'=>$list]);
        }
        // sale by item 
        if ($check == "by-item") {
            // $shop_id contains shop value and item value
            $vals = explode("-",$shop_id);
            $shop_id = $vals[0];
            $item_id = $vals[1];
            if ($shop_id == 'all') {
                $sy = "!=";
            } else {
                $sy = "=";
            }
            $data['totalIQ'] = $data['totalIA'] = $data['totalIP'] = 0;


            if ($item_id != "null") {


                $begin = new \DateTime( date("Y-m-d", strtotime($fromdate)) );
                $end   = new \DateTime( date("Y-m-d 23:59:59", strtotime($todate)) );
                
                for($i = $end; $i >= $begin; $i->modify('-1 day')){
                    $fromdate2 = date("Y-m-d 00:00:00", strtotime($i->format("Y-m-d")));
                    $todate2 = date("Y-m-d 23:59:59", strtotime($i->format("Y-m-d")));
                    $sale = Sale::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate2),Carbon::parse($todate2)])->where('shop_id',$sy,$shop_id)->where('status','sold')->where('product_id',$item_id)->first();
                    if($sale) {
                        $sumQ = Sale::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate2),Carbon::parse($todate2)])->where('shop_id',$sy,$shop_id)->where('status','sold')->where('product_id',$item_id)->sum('quantity');
                        $sumP = Sale::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate2),Carbon::parse($todate2)])->where('shop_id',$sy,$shop_id)->where('status','sold')->where('product_id',$item_id)->sum('sub_total');
                        $sumB = Sale::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate2),Carbon::parse($todate2)])->where('shop_id',$sy,$shop_id)->where('status','sold')->where('product_id',$item_id)->sum('total_buying');
                        $profit = $sumP - $sumB;
                        $data['totalIQ'] = $data['totalIQ'] + $sumQ;   
                        $data['totalIA'] = $data['totalIA'] + $sumP;
                        $data['totalIP'] = $data['totalIP'] + $profit;    
                             
                        $output[] = '<tr><td>'.date('d/m/Y', strtotime($sale->updated_at)).'</td><td>'.$sale->product->name.'</td><td>'.sprintf('%g',$sumQ).'</td><td>'.number_format($sumP).'</td><td>'.number_format($profit).'</td></tr>';
                        // echo $i->format("Y-m-d");
                    }
                }
                
                $data['totalIA'] = number_format($data['totalIA']);
                $data['totalIP'] = number_format($data['totalIP']);

            } 
            return response()->json(['items'=>$output,'data'=>$data]);
        }
        // sale by top sale 
        if ($check == "top-sale") {
            $list = array();
            if ($shop_id == 'all') {
                $sy = "!=";
            } else {
                $sy = "=";
            }
            
            $sales = Sale::query()->select([
                DB::raw("products.name as pname"),
                DB::raw("SUM(sales.quantity) as sumQ"),
                DB::raw("SUM(sales.sub_total) as sumP"),
                DB::raw("SUM(sales.total_buying) as sumB")
            ])
            ->join('products', 'products.id','sales.product_id')
            ->where('sales.status','sold')
            ->where('sales.company_id', Auth::user()->company_id)
            ->where('sales.shop_id',$sy,$shop_id)
            ->whereBetween('sales.updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])
            ->groupBy('sales.product_id')
            ->get();

            return response()->json(['sales'=>$sales]);
        }
        // item activities
        if ($check == "product-activities") {
            // shop_id imebeba shop/store + item_id
            $ssi = explode("~",$shop_id);
            $shopstore = $ssi[0];
            $product_id = $ssi[1]; 
            $interval = \DateInterval::createFromDateString('1 day');
            $period = new \DatePeriod($begin, $interval, $end);

            if ($shopstore == "all") {
                if ($product_id != "select") {
                    $totalQty = \DB::connection('tenant')->table('shop_products')->where('product_id',$product_id)->where('active','yes')->sum('quantity');
                    $totalQty2 = \DB::connection('tenant')->table('store_products')->where('product_id',$product_id)->where('active','yes')->sum('quantity');
                    $data['av_quantity'] = $totalQty + $totalQty2;
                    for($i = $end; $i >= $begin; $i->modify('-1 day')) {
                        $fromdate = date("Y-m-d 00:00:00", strtotime($i->format("Y-m-d")));
                        $todate = date("Y-m-d 23:59:59", strtotime($i->format("Y-m-d")));
                        $soldQ = $returnQ = $newstock = $diffA = $diff2A = "";
                        $sumQ = Sale::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])
                            ->where('status','sold')->where('product_id',$product_id)->sum("quantity");
                        $returnedQ = ReturnSoldItem::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('product_id',$product_id)->where('status','received')->sum('quantity');
                        $newstockQ = NewStock::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('product_id',$product_id)->where('status','updated')->sum('added_quantity');
                        $adjust = StockAdjustment::query()
                                ->selectRaw('SUM(av_quantity) as sumaQ, sum(new_quantity) as sumnQ')
                                ->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])
                                ->where('company_id',Auth::user()->company_id)
                                ->where('status','stock adjustment')->where('product_id',$product_id)->first();
                        $staking = StockAdjustment::query()
                                ->selectRaw('SUM(av_quantity) as sumaQ, sum(new_quantity) as sumnQ')
                                ->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])
                                ->where('company_id',Auth::user()->company_id)
                                ->where('status','stock taking')->where('product_id',$product_id)->first();
                        
                        if ($sumQ) {
                            $soldQ = "<b>Sold Quantities: ".sprintf('%g',$sumQ)."</b><br>";        
                        }
                        if ($returnedQ) {
                            $returnQ = "<b>Returned Quantities: ".sprintf('%g',$returnedQ)."</b><br>"; 
                        }
                        if ($newstockQ) {
                            $newstock = "<b>New Stock: ".sprintf('%g',$newstockQ)."</b><br>"; 
                        }
                        $adjust2 = 0;
                        if ($adjust) {
                            $adjust2 = $adjust->sumnQ - $adjust->sumaQ;
                            if ($adjust2 < 0) {
                                $diffA = "<b>Negative Adjustment: ".sprintf('%g',$adjust2)."</b><br>";
                            }
                            if ($adjust2 > 0) {
                                $diffA = "<b>Positive Adjustment: ".sprintf('%g',$adjust2)."</b><br>";
                            }
                        }
                        $staking2 = 0;
                        if ($staking) {
                            $staking2 = $staking->sumnQ - $staking->sumaQ;
                            if ($staking2 < 0) {
                                $diff2A = "<b>Stock Taking: ".sprintf('%g',$staking2)."</b><br>";
                            }
                            if ($staking2 > 0) {
                                $diff2A = "<b>Stock Taking: ".sprintf('%g',$staking2)."</b><br>";
                            }
                        }
                        if ($sumQ || $returnedQ || $newstockQ || $adjust2 || $staking2) {
                            $output[] = '<tr><td>'.$i->format("d/m/Y").'</td><td>'.$soldQ."".$returnQ."".$newstock."".$diffA."".$diff2A.'</td><td>'.sprintf('%g',$data["av_quantity"]).'</td></tr>';
                        }                
                        
                        $data["av_quantity"] = $data["av_quantity"] + $sumQ - $returnedQ - $newstockQ - $adjust2 - $staking2;
                    }                    
                }
                return response()->json(['data'=>$data,'output'=>$output]);
            } else {
                // for specific shop or store
                if ($product_id != "select") {
                    
                    $shopstore = explode("-",$shopstore);
                    $shopstore1 = $shopstore[0];
                    $shopstore2 = $shopstore[1];
                    if ($shopstore1 == "shop") {
                        $shop_id = $shopstore2;
                        $totalQty = \DB::connection('tenant')->table('shop_products')->where('shop_id',$shop_id)->where('product_id',$product_id)->where('active','yes')->sum('quantity');
                        $data['av_quantity'] = $totalQty;
                        for($i = $end; $i >= $begin; $i->modify('-1 day')) {
                            $fromdate = date("Y-m-d 00:00:00", strtotime($i->format("Y-m-d")));
                            $todate = date("Y-m-d 23:59:59", strtotime($i->format("Y-m-d")));
                            $soldQ = $returnQ = $newstock = $diffA = $diff2A = $tout = $tin = "";
                            $sumQ = Sale::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])
                                ->where('status','sold')->where('shop_id',$shop_id)->where('product_id',$product_id)->sum("quantity");
                            $returnedQ = ReturnSoldItem::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('shop_id',$shop_id)->where('product_id',$product_id)->where('status','received')->sum('quantity');
                            $newstockQ = NewStock::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('shop_id',$shop_id)->where('product_id',$product_id)->where('status','updated')->sum('added_quantity');
                            $adjust = StockAdjustment::query()
                                    ->selectRaw('SUM(av_quantity) as sumaQ, sum(new_quantity) as sumnQ')
                                    ->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])
                                    ->where('status','stock adjustment')->where('company_id',Auth::user()->company_id)->where('from','shop')->where('from_id',$shop_id)->where('product_id',$product_id)->first();
                            $staking = StockAdjustment::query()
                                    ->selectRaw('SUM(av_quantity) as sumaQ, sum(new_quantity) as sumnQ')
                                    ->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])
                                    ->where('status','stock taking')->where('from','shop')->where('company_id',Auth::user()->company_id)->where('from_id',$shop_id)->where('product_id',$product_id)->first();
                            $trout = Transfer::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('from','shop')->where('from_id',$shop_id)->where('product_id',$product_id)->where('status','received')->sum('quantity');
                            $trin = Transfer::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('destination','shop')->where('destination_id',$shop_id)->where('product_id',$product_id)->where('status','received')->sum('quantity');
                            
                            if ($sumQ) {
                                $soldQ = "<b>Sold Quantities: ".sprintf('%g',$sumQ)."</b><br>";        
                            }
                            if ($returnedQ) {
                                $returnQ = "<b>Returned Quantities: ".sprintf('%g',$returnedQ)."</b><br>"; 
                            }
                            if ($newstockQ) {
                                $newstock = "<b>New Stock: ".sprintf('%g',$newstockQ)."</b><br>"; 
                            }
                            if ($trout) {
                                $tout = "<b>Transfer Out: ".sprintf('%g',$trout)."</b><br>"; 
                            }
                            if ($trin) {
                                $tin = "<b>Transfer In: ".sprintf('%g',$trin)."</b><br>"; 
                            }
                            $adjust2 = 0;
                            if ($adjust) {
                                $adjust2 = $adjust->sumnQ - $adjust->sumaQ;
                                if ($adjust2 < 0) {
                                    $diffA = "<b>Negative Adjustment: ".sprintf('%g',$adjust2)."</b><br>";
                                }
                                if ($adjust2 > 0) {
                                    $diffA = "<b>Positive Adjustment: ".sprintf('%g',$adjust2)."</b><br>";
                                }
                            }
                            $staking2 = 0;
                            if ($staking) {
                                $staking2 = $staking->sumnQ - $staking->sumaQ;
                                if ($staking2 < 0) {
                                    $diff2A = "<b>Stock Taking: ".sprintf('%g',$staking2)."</b><br>";
                                }
                                if ($staking2 > 0) {
                                    $diff2A = "<b>Stock Taking: ".sprintf('%g',$staking2)."</b><br>";
                                }
                            }
                            if ($sumQ || $returnedQ || $newstockQ || $adjust2 || $staking2 || $trout || $trin) {
                                $output[] = '<tr><td>'.$i->format("d/m/Y").'</td><td>'.$soldQ."".$returnQ."".$newstock."".$diffA."".$diff2A."".$tin."".$tout.'</td><td>'.sprintf('%g',$data["av_quantity"]).'</td></tr>';
                            }                        
                            
                            $data["av_quantity"] = $data["av_quantity"] + $sumQ - $returnedQ - $newstockQ - $adjust2 - $staking2 + $trout - $trin;
                        }        
                    }            
                    if ($shopstore1 == "store") {
                        $store_id = $shopstore2;
                        $totalQty = \DB::connection('tenant')->table('store_products')->where('store_id',$store_id)->where('product_id',$product_id)->where('active','yes')->sum('quantity');
                        $data['av_quantity'] = $totalQty;
                        for($i = $end; $i >= $begin; $i->modify('-1 day')) {
                            $fromdate = date("Y-m-d 00:00:00", strtotime($i->format("Y-m-d")));
                            $todate = date("Y-m-d 23:59:59", strtotime($i->format("Y-m-d")));
                            $soldQ = $returnQ = $newstock = $diffA = $diff2A = $tout = $tin = "";
                            $sumQ = 0;
                            $returnedQ = 0;
                            $newstockQ = NewStock::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('store_id',$store_id)->where('product_id',$product_id)->where('status','updated')->sum('added_quantity');
                            $adjust = StockAdjustment::query()
                                    ->selectRaw('SUM(av_quantity) as sumaQ, sum(new_quantity) as sumnQ')
                                    ->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])
                                    ->where('status','stock adjustment')->where('company_id',Auth::user()->company_id)->where('from','shop')->where('from_id',$store_id)->where('product_id',$product_id)->first();
                            $staking = StockAdjustment::query()
                                    ->selectRaw('SUM(av_quantity) as sumaQ, sum(new_quantity) as sumnQ')
                                    ->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])
                                    ->where('status','stock taking')->where('from','shop')->where('company_id',Auth::user()->company_id)->where('from_id',$store_id)->where('product_id',$product_id)->first();
                            $trout = Transfer::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('from','store')->where('from_id',$store_id)->where('product_id',$product_id)->where('status','received')->sum('quantity');
                            $trin = Transfer::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('destination','store')->where('destination_id',$store_id)->where('product_id',$product_id)->where('status','received')->sum('quantity');
                            
                            if ($sumQ) {
                                $soldQ = "<b>Sold Quantities: ".sprintf('%g',$sumQ)."</b><br>";        
                            }
                            if ($returnedQ) {
                                $returnQ = "<b>Returned Quantities: ".sprintf('%g',$returnedQ)."</b><br>"; 
                            }
                            if ($newstockQ) {
                                $newstock = "<b>New Stock: ".sprintf('%g',$newstockQ)."</b><br>"; 
                            }
                            if ($trout) {
                                $tout = "<b>Transfer Out: ".sprintf('%g',$trout)."</b><br>"; 
                            }
                            if ($trin) {
                                $tin = "<b>Transfer In: ".sprintf('%g',$trin)."</b><br>"; 
                            }
                            $adjust2 = 0;
                            if ($adjust) {
                                $adjust2 = $adjust->sumnQ - $adjust->sumaQ;
                                if ($adjust2 < 0) {
                                    $diffA = "<b>Negative Adjustment: ".sprintf('%g',$adjust2)."</b><br>";
                                }
                                if ($adjust2 > 0) {
                                    $diffA = "<b>Positive Adjustment: ".sprintf('%g',$adjust2)."</b><br>";
                                }
                            }
                            $staking2 = 0;
                            if ($staking) {
                                $staking2 = $staking->sumnQ - $staking->sumaQ;
                                if ($staking2 < 0) {
                                    $diff2A = "<b>Stock Taking: ".sprintf('%g',$staking2)."</b><br>";
                                }
                                if ($staking2 > 0) {
                                    $diff2A = "<b>Stock Taking: ".sprintf('%g',$staking2)."</b><br>";
                                }
                            }
                            if ($sumQ || $returnedQ || $newstockQ || $adjust2 || $staking2 || $trout || $trin) {
                                $output[] = '<tr><td>'.$i->format("d/m/Y").'</td><td>'.$soldQ."".$returnQ."".$newstock."".$diffA."".$diff2A."".$tin."".$tout.'</td><td>'.sprintf('%g',$data["av_quantity"]).'</td></tr>';
                            }                        
                            
                            $data["av_quantity"] = $data["av_quantity"] + $sumQ - $returnedQ - $newstockQ - $adjust2 - $staking2 + $trout - $trin;
                        }        
                    }            
                }
                return response()->json(['data'=>$data,'output'=>$output]);
            }
        }
        // customer debts
        if ($check == "debts") {
            if ($shop_id == 'all') {
                $sy = "!=";
            } else {
                $sy = "=";
            }
            $totald = 0;
            $debts = CustomerDebt::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('shop_id',$sy,$shop_id)->where('status','buy stock')->where('debt_amount','>',0)->get();
            if ($debts->isNotEmpty()) {
                foreach($debts as $debt) {
                    $totald = $totald + $debt->debt_amount;
                    $output[] = '<tr><td>'.$debt->customer->name.'</td><td>'.number_format($debt->stock_value).'</td><td><input type="number" class="form-control paida paida-'.$debt->id.'" name="paida" value="'.round($debt->amount_paid, 0).'" amount="'.round($debt->amount_paid, 0).'"><button class="btn btn-info btn-sm paida-b p-0 px-1" rid="'.$debt->id.'">Update</button></td><td class="debta-'.$debt->id.'">'.number_format($debt->debt_amount).'</td></tr>';
                }
            }            
            $totald = number_format($totald);
            return response()->json(['items'=>$output,'totald'=>$totald]);
        }      
        // customer anatudai
        if ($check == "ongezeko") {
            if ($shop_id == 'all') {
                $sy = "!=";
            } else {
                $sy = "=";
            }
            $totald = 0;
            $debts = CustomerDebt::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('shop_id',$sy,$shop_id)->where('status','buy stock')->where('debt_amount','<',0)->get();
            if ($debts->isNotEmpty()) {
                foreach($debts as $debt) {
                    $totald = $totald + $debt->debt_amount;
                    $output[] = '<tr><td>'.$debt->customer->name.'</td><td>'.number_format($debt->stock_value).'</td><td><input type="number" class="form-control paida paida-'.$debt->id.'" name="paida" value="'.round($debt->amount_paid, 0).'" amount="'.round($debt->amount_paid, 0).'"><button class="btn btn-info btn-sm paida-b p-0 px-1" rid="'.$debt->id.'">Update</button></td><td class="debta-'.$debt->id.'">'.number_format(abs($debt->debt_amount)).'</td></tr>';
                }
            }            
            $totald = number_format(abs($totald));
            return response()->json(['items'=>$output,'totald'=>$totald]);
        }      
        // customer tumemkopesha
        if ($check == "kopesha") {
            if ($shop_id == 'all') {
                $sy = "!=";
            } else {
                $sy = "=";
            }
            $totald = 0;
            $debts = CustomerDebt::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('shop_id',$sy,$shop_id)->where('status','lend money')->where('debt_amount','>',0)->get();
            if ($debts->isNotEmpty()) {
                foreach($debts as $debt) {
                    $totald = $totald + $debt->debt_amount;
                    $output[] = '<tr><td>'.$debt->customer->name.'</td><td><div><input type="number" class="form-control paida paida-'.$debt->id.'" name="paida" value="'.round($debt->debt_amount, 0).'" amount="'.round($debt->debt_amount, 0).'"><button class="btn btn-info btn-sm paida-b p-0 px-1" rid="'.$debt->id.'">Update</button></div></td></tr>';
                }
            }            
            $totald = number_format(abs($totald));
            return response()->json(['items'=>$output,'totald'=>$totald]);
        }      
        // customer anatudai
        if ($check == "ameweka") {
            if ($shop_id == 'all') {
                $sy = "!=";
            } else {
                $sy = "=";
            }
            $totald = 0;
            $debts = CustomerDebt::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('shop_id',$sy,$shop_id)->where('status','weka pesa')->where('debt_amount','<',0)->get();
            if ($debts->isNotEmpty()) {
                foreach($debts as $debt) {
                    $totald = $totald + $debt->debt_amount;
                    $output[] = '<tr><td>'.$debt->customer->name.'</td><td><div><input type="number" class="form-control paida paida-'.$debt->id.'" name="paida" value="'.round($debt->amount_paid, 0).'" amount="'.round($debt->amount_paid, 0).'"><button class="btn btn-info btn-sm paida-b p-0 px-1" rid="'.$debt->id.'">Update</button></div></td></tr>';
                }
            }            
            $totald = number_format(abs($totald));
            return response()->json(['items'=>$output,'totald'=>$totald]);
        }      
        // tumelipa madeni / refund
        if ($check == "cash-out") {
            if ($shop_id == 'all') {
                $sy = "!=";
            } else {
                $sy = "=";
            }
            $totald = 0;
            $debts = CustomerDebt::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('shop_id',$sy,$shop_id)->whereIn('status',['refund','pay debt'])->where('debt_amount','>',0)->get();
            if ($debts->isNotEmpty()) {
                foreach($debts as $debt) {
                    $status = "";
                    if ($debt->status == "refund") {
                        $status = $_GET['refund'];
                    } 
                    if ($debt->status == "pay debt") {
                        $status = $_GET['pay-debt'];
                    }
                    $totald = $totald + $debt->debt_amount;
                    $output[] = '<tr><td>'.$debt->customer->name.'</td><td><div><input type="number" class="form-control paida paida-'.$debt->id.'" name="paida" value="'.round($debt->debt_amount, 0).'" amount="'.round($debt->debt_amount, 0).'"><button class="btn btn-info btn-sm paida-b p-0 px-1" rid="'.$debt->id.'">Update</button></div></td><td>'.$status.'</td></tr>';
                }
            }            
            $totald = number_format(abs($totald));
            return response()->json(['items'=>$output,'totald'=>$totald]);
        }  
        // pending transfers
        if ($check == "pending-transfers") { // in pending, we are not consider from - to dates
            $items = Transfer::where('company_id',Auth::user()->company_id)->where('status','sent')->groupBy('transfer_no')->orderBy('transfer_no','desc')->get(); 
            if ($items->isNotEmpty()) {
                foreach($items as $value) {
                    $items2 = Transfer::where('company_id',Auth::user()->company_id)->where('transfer_no',$value->transfer_no)->get();
                    if ($items2->isNotEmpty()) {
                        foreach($items2 as $value2) {
                            $to = "";
                            $from = "";
                            if ($value2->from == "shop") {
                                $from = Shop::find($value2->from_id)->name;
                            }
                            if ($value2->from == "store") {
                                $from = Store::find($value2->from_id)->name;
                            }
                            if ($value2->destination == "shop") {
                                $to = Shop::find($value2->destination_id)->name;
                            }
                            if ($value2->destination == "store") {
                                $to = Store::find($value2->destination_id)->name;
                            }
                            $sender = $shipper = $receiver = $received_at = $datetime = "";
                            if ($value2->sender) {
                                $sender = $value2->sender->name;
                            }
                            if ($value2->shipper) {
                                $shipper = $value2->shipper->name;
                            }
                            $today = date('Y-m-d');
                            $now = date('Y-m-d H:i:s');
                            if ($today == $value2->updated_at->format('Y-m-d')) {
                                $startT = new \DateTime($value2->updated_at);
                                $now = new \DateTime($now);
                                $interval = $startT->diff($now);
                                $datetime = $interval->format('%h')."h ".$interval->format('%i')."m";
                            } else {
                                $today = strtotime($today);
                                $date2 = strtotime($value2->updated_at->format('Y-m-d'));
                                $diff = $today - $date2;
                                $datetime =  round($diff / (60 * 60 * 24))." days ago";
                            }
                            $output[] = "<tr><td>".$value2->transfer_no."</td><td>".$value2->product->name."</td><td>".sprintf('%g',$value2->quantity)."</td>
                                <td><p class='m-0'><b>".$from."</b></p><p class='m-0'>".date('d/m/Y H:i', strtotime($value2->sent_at))."</p></td>
                                <td><p class='m-0'><b>".$to."</b></p><p class='m-0'>".$received_at."</p></td>
                                <td><span class='bg-warning px-1'>Pending</span></td>
                                <td>".$datetime."</td>
                                <td><p class='m-0'><b>Sender:</b> ".$sender."</p><p class='m-0'><b>Shipper:</b> ".$shipper."</p><p class='m-0'><b>Receiver:</b> ".$receiver."</p></td></tr>";
                        }
                    }                    
                }
            } else {
                $output[] = '<tr><td colspan="8" align="center"><i>-- No transfers --</i></td></tr>';
            }
            return response()->json(['items'=>$output]);
        }  
        // received transfers
        if ($check == "received-transfers") {             
            $items = Transfer::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('status','received')->groupBy('transfer_no')->orderBy('transfer_no','desc')->get();
            if ($items->isNotEmpty()) {
                foreach($items as $value) {
                    $items2 = Transfer::where('company_id',Auth::user()->company_id)->where('transfer_no',$value->transfer_no)->get();
                    if ($items2->isNotEmpty()) {
                        foreach($items2 as $value2) {
                            if ($value2->from == "shop") {
                                $from = Shop::find($value2->from_id)->name;
                            }
                            if ($value2->from == "store") {
                                $from = Store::find($value2->from_id)->name;
                            }
                            if ($value2->destination == "shop") {
                                $to = Shop::find($value2->destination_id)->name;
                            }
                            if ($value2->destination == "store") {
                                $to = Store::find($value2->destination_id)->name;
                            }
                            $sender = $shipper = $receiver = $received_at = $datetime = "";
                            if ($value2->sender) {
                                $sender = $value2->sender->name;
                            }
                            if ($value2->shipper) {
                                $shipper = $value2->shipper->name;
                            }
                            if ($value2->receiver) {
                                $receiver = $value2->receiver->name;
                            }
                            if($value2->received_at){
                                $received_at = date('d/m/Y H:i', strtotime($value2->received_at));
                            }
                            $today = date('Y-m-d');                                
                            if (date("Y-m-d", strtotime($value2->received_at)) == date("Y-m-d", strtotime($value2->sent_at))) {
                                $startT = new \DateTime(date("Y-m-d H:i:s", strtotime($value2->sent_at)));
                                $toT = new \DateTime(date("Y-m-d H:i:s", strtotime($value2->received_at)));
                                $interval = $startT->diff($toT);
                                $datetime = $interval->format('%h')."h ".$interval->format('%i')."m";
                            } else {
                                $date1 = strtotime(date("Y-m-d", strtotime($value2->sent_at)));
                                $date2 = strtotime(date("Y-m-d", strtotime($value2->received_at)));
                                $diff = $date2 - $date1;
                                $datetime =  round($diff / (60 * 60 * 24))."d";
                            }
                            $output[] = "<tr><td>".$value2->transfer_no."</td><td>".$value2->product->name."</td><td>".sprintf('%g',$value2->quantity)."</td>
                                <td><p class='m-0'><b>".$from."</b></p><p class='m-0'>".date('d/m/Y H:i', strtotime($value2->sent_at))."</p></td>
                                <td><p class='m-0'><b>".$to."</b></p><p class='m-0'>".$received_at."</p></td>
                                <td><span class='bg-success px-1 text-light'>Received</span></td>
                                <td>".$datetime."</td>
                                <td><p class='m-0'><b>Sender:</b> ".$sender."</p><p class='m-0'><b>Shipper:</b> ".$shipper."</p><p class='m-0'><b>Receiver:</b> ".$receiver."</p></td></tr>";
                        }
                    }                    
                }
            } else {
                $output[] = '<tr><td colspan="8" align="center"><i>-- No transfers --</i></td></tr>';
            }
            return response()->json(['items'=>$output]);
        }  
    }

    public function reports($check,$check2){
        if ($check == "shops" || $check == "stores") {
            $data['totalQty'] = \DB::connection('tenant')->table('shop_products')->join('shops','shops.id','shop_products.shop_id')->where('shops.company_id',Auth::user()->company_id)->where('shop_products.active','yes')->sum('quantity');
            $data['totalQty2'] = \DB::connection('tenant')->table('store_products')->join('stores','stores.id','store_products.store_id')->where('stores.company_id',Auth::user()->company_id)->where('store_products.active','yes')->sum('quantity');
            $data['totalQty'] = $data['totalQty'] + $data['totalQty2'];
        }
        if ($check == "shops") {
            $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
            return response()->json(['data'=>$data]);
        }
        if ($check == "stores") {
            $data['stores'] = Store::where('company_id',Auth::user()->company_id)->get();
            return response()->json(['data'=>$data]);
        }
        if ($check == "sales") {
            $data['today_quantity'] = Sale::where('company_id',Auth::user()->company_id)->whereDate('updated_at', Carbon::today())->where('status','sold')->sum('quantity');
            $today_price = Sale::where('company_id',Auth::user()->company_id)->whereDate('updated_at', Carbon::today())->where('status','sold')->sum('sub_total');
            $data['week_quantity'] = Sale::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status','sold')->sum('quantity');
            $week_price = Sale::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status','sold')->sum('sub_total');
            $data['month_quantity'] = Sale::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->where('status','sold')->sum('quantity');
            $month_price = Sale::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->where('status','sold')->sum('sub_total');
            $data['today_price'] = number_format($today_price);
            $data['week_price'] = number_format($week_price);
            $data['month_price'] = number_format($month_price);
            return response()->json(['data'=>$data]);
        }
        if ($check == "sales-n-days") {
            // get for past 10 days 
            if($check2 == 'all') {
                $data['total_quantity'] = Sale::where('company_id',Auth::user()->company_id)->where('updated_at', '>', Carbon::now()->subDays(10))->where('status','sold')->sum('quantity');
                $total_price = Sale::where('company_id',Auth::user()->company_id)->where('updated_at', '>', Carbon::now()->subDays(10))->where('status','sold')->sum('sub_total');
                $total_buying = Sale::where('company_id',Auth::user()->company_id)->where('updated_at', '>', Carbon::now()->subDays(10))->where('status','sold')->sum('total_buying');
                $data['total_price'] = number_format($total_price);
                $profit = ($total_price - $total_buying);
                $data['profit'] = number_format($profit);
                return response()->json(['data'=>$data]);
            } else {
                $sid = $check2; // $check2 == shop_id
                $total_price = Sale::where('company_id',Auth::user()->company_id)->where('shop_id',$sid)->where('updated_at', '>', Carbon::now()->subDays(10))->where('status','sold')->sum('sub_total');
                $total_buying = Sale::where('company_id',Auth::user()->company_id)->where('shop_id',$sid)->where('updated_at', '>', Carbon::now()->subDays(10))->where('status','sold')->sum('total_buying');
                $data['ten_sales'] = number_format($total_price);
                $profit = ($total_price - $total_buying);
                $data['ten_profit'] = number_format($profit);
                return response()->json(['data'=>$data]);
            }
        }
        if ($check == "shop-home-data") {
            $shop_id = $check2;
            $sales = Sale::query()->select([
                DB::raw('SUM(quantity) as tquantity, SUM(total_buying) as tbuying, SUM(sub_total) as tsales')
            ])->where('shop_id',$shop_id)
            ->where('status','sold')->where('updated_at', '>', Carbon::now()->subDays(10))->get();
            $expenses = ShopExpense::where('shop_id',$shop_id)->where('created_at', '>', Carbon::now()->subDays(10))->sum('amount');
            $products = \DB::connection('tenant')->table('shop_products')->where('shop_id',$shop_id)->where('active','yes')->sum('quantity');
            return response()->json(['sales'=>$sales,'expenses'=>$expenses,'products'=>$products]);
        }
        if($check == "today-sales") {
            $sid = $check2; // $check2 == shop_id
            $today_sales = Sale::where('company_id',Auth::user()->company_id)->where('shop_id',$sid)->whereDate('updated_at', Carbon::today())->where('status','sold')->sum('sub_total');
            $total_buying = Sale::where('company_id',Auth::user()->company_id)->where('shop_id',$sid)->whereDate('updated_at', Carbon::today())->where('status','sold')->sum('total_buying');
            $data['today_sales'] = number_format($today_sales);
            $profit = ($today_sales - $total_buying);
            $data['today_profit'] = number_format($profit);
            return response()->json(['data'=>$data]);
        }
        if ($check == "expenses") {
            $data['today_expenses'] = ShopExpense::where('company_id',Auth::user()->company_id)->whereDate('created_at', Carbon::today())->sum('amount');
            $data['week_expenses'] = ShopExpense::where('company_id',Auth::user()->company_id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('amount');
            $data['month_expenses'] = ShopExpense::where('company_id',Auth::user()->company_id)->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->sum('amount');
            $data['today_expenses'] = number_format($data['today_expenses']);
            $data['week_expenses'] = number_format($data['week_expenses']);
            $data['month_expenses'] = number_format($data['month_expenses']);
            return response()->json(['data'=>$data]);
        }
        if ($check == "expenses-n-days") {
            if($check2 == 'all') {
                $data['total_expenses'] = ShopExpense::where('company_id',Auth::user()->company_id)->where('created_at', '>', Carbon::now()->subDays(10))->sum('amount');
                $data['total_expenses'] = number_format($data['total_expenses']);
                return response()->json(['data'=>$data]);
            } else {
                $sid = $check2; // $check2 == shop_id
                $data['total_expenses'] = ShopExpense::where('company_id',Auth::user()->company_id)->where('shop_id',$sid)->where('created_at', '>', Carbon::now()->subDays(10))->sum('amount');
                $data['total_expenses'] = number_format($data['total_expenses']);
                return response()->json(['data'=>$data]);
            }
        }
        if($check == "products-in-shop") {
            $totalproducts = \DB::connection('tenant')->table('shop_products')->where('shop_id',$check2)->where('active','yes')->sum('quantity');
            
            $products = Product::query()->select([
                DB::raw('products.id as pid, products.name as pname, products.buying_price as bprice, products.retail_price as rprice, shop_products.quantity as quantity, product_categories.name as cname, products.image as pimage, products.min_stock_level as msl')
            ])
            ->join('shop_products', 'shop_products.product_id', 'products.id')
            ->join('product_categories', 'product_categories.id', 'products.product_category_id')
            ->where('shop_products.shop_id',$check2)->where('shop_products.active','yes')
            ->where('products.status','published')->orderBy('products.name','asc')->get();
            
            return response()->json(['totalproducts'=>$totalproducts,'products'=>$products]);
        }
        if($check == "products-in-store") {
            $totalproducts = \DB::connection('tenant')->table('store_products')->where('store_id',$check2)->where('active','yes')->sum('quantity');
            
            $products = Product::query()->select([
                DB::raw('products.id as pid, products.name as pname, products.buying_price as bprice, products.retail_price as rprice, store_products.quantity as quantity, product_categories.name as cname, products.image as pimage, products.min_stock_level as msl')
            ])
            ->join('store_products', 'store_products.product_id', 'products.id')
            ->join('product_categories', 'product_categories.id', 'products.product_category_id')
            ->where('store_products.store_id',$check2)->where('store_products.active','yes')
            ->where('products.status','published')->orderBy('products.name','asc')->get();
            
            return response()->json(['totalproducts'=>$totalproducts,'products'=>$products]);
        }
        if($check == "total-products-in-shop") { //not used 
            $data['total_products'] = $quantity = \DB::connection('tenant')->table('shop_products')->where('shop_id',$check2)->where('active','yes')->sum('quantity');
            $data['total_products'] = number_format($data['total_products']);
            return response()->json(['data'=>$data]);
        }
        if($check == "products-n-days-in-store") {
            $data['total_products'] = $quantity = \DB::connection('tenant')->table('store_products')->where('store_id',$check2)->where('active','yes')->sum('quantity');
            $data['total_products'] = number_format($data['total_products']);
            $today_s_in = NewStock::where('company_id',Auth::user()->company_id)->where('store_id',$check2)->where('status','updated')->whereDate('received_at', Carbon::today())->sum('added_quantity');
            $today_t_in = Transfer::where('destination','store')->where('destination_id',$check2)->where('company_id',Auth::user()->company_id)->where('status','received')->whereDate('received_at', Carbon::today())->sum('quantity');
            $data['total_today_pin'] = $today_s_in + $today_t_in;
            $ten_s_in = NewStock::where('company_id',Auth::user()->company_id)->where('store_id',$check2)->where('status','updated')->where('received_at', '>', Carbon::now()->subDays(10))->sum('added_quantity');
            $ten_t_in = Transfer::where('destination','store')->where('destination_id',$check2)->where('company_id',Auth::user()->company_id)->where('status','received')->where('received_at', '>', Carbon::now()->subDays(10))->sum('quantity');
            $data['total_ten_pin'] = $ten_s_in + $ten_t_in;
            $today_t_out = Transfer::where('from','store')->where('from_id',$check2)->where('company_id',Auth::user()->company_id)->whereIn('status',['sent','received'])->whereDate('updated_at', Carbon::today())->sum('quantity');
            $data['total_today_pout'] = $today_t_out + 0;
            $ten_t_out = Transfer::where('from','store')->where('from_id',$check2)->where('company_id',Auth::user()->company_id)->whereIn('status',['sent','received'])->where('updated_at', '>', Carbon::now()->subDays(10))->sum('quantity');
            $data['total_ten_pout'] = $ten_t_out + 0;
            return response()->json(['data'=>$data]);
        }
        if($check == "total-products-in-store") {
            $data['total_products'] = $quantity = \DB::connection('tenant')->table('store_products')->where('store_id',$check2)->where('active','yes')->sum('quantity');
            $data['total_products'] = number_format($data['total_products']);
            return response()->json(['data'=>$data]);
        }
        if ($check == "closure-sale") {
            $output = array();
            $status = "";
            // $check2 == fromdate to todate
            $date = explode("~",$check2);
            $shop_id = $date[0];
            $fromdate = date("Y-m-d 00:00:00", strtotime($date[1]));
            $todate = date("Y-m-d 23:59:59", strtotime($date[2]));
            if($shop_id == "all") {
                $items = ClosureSale::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->get();
            } else {
                $items = ClosureSale::where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->get();
            }
            
            if ($items->isNotEmpty()) {
                foreach($items as $value) {
                    if ($value->difference == 0) {
                        $status = "<span class='badge badge-success pb-1'>Balanced</span>";
                    }
                    if ($value->difference < 0) {
                        $status = "<span class='badge badge-danger pb-1'>Loss</span>";
                    }
                    if ($value->difference > 0) {
                        $status = "<span class='badge badge-info pb-1'>Exceed</span>";
                    }
                    $output[] = "<tr><td>".number_format($value->expected_cash)."</td><td>".number_format($value->submitted_cash)."</td><td>".number_format($value->difference)." ".$status."</td><td>".$value->user->name."</td><td>".$value->updated_at->format('g:i a')."</td><td>".$value->shop->name."</td></tr>";
                }            
            }
            return response()->json(['items'=>$output]);
        }
        if ($check == '10-users') {
            $data['total_users'] = User::where('company_id',Auth::user()->company_id)->where('status','!=','deleted')->count();
            if ($check2 == '10') {
                $data['users'] = User::where('company_id',Auth::user()->company_id)->where('status','!=','deleted')->orderBy('id')->limit(10)->get();
                return response()->json(['data'=>$data]);
            }
        }
    }

    public function reports1($check) {
        if ($check == "sales") {
            if(Auth::user()->isCEOorAdminorBusinessOwner()){
                $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
                $data['items'] = Product::where('status','!=','deleted')->where('company_id',Auth::user()->company_id)->get();
                return view('business-owner.sales', compact('data'));
            }
        }
    }

    public function reports2($check,$check2,$check3){
        if ($check == "stock" && $check2 == "shop") {
            $data['shop'] = Shop::where('id',$check3)->where('company_id',Auth::user()->company_id)->first();
            $data['quantity'] = $quantity = \DB::connection('tenant')->table('shop_products')->where('shop_id',$check3)->where('active','yes')->sum('quantity');
            // today
            $data['addedT'] = Transfer::where('company_id',Auth::user()->company_id)->whereDate('updated_at', Carbon::today())->where('destination','shop')->where('destination_id',$check3)->where('status','received')->sum('quantity');
            $data['added2T'] = NewStock::where('company_id',Auth::user()->company_id)->whereDate('updated_at', Carbon::today())->where('shop_id',$check3)->where('status','updated')->sum('added_quantity');
            $data['added3T'] = ReturnSoldItem::where('company_id',Auth::user()->company_id)->whereDate('updated_at', Carbon::today())->where('shop_id',$check3)->where('status','received')->sum('quantity');
            $data['addedT'] = $data['addedT'] + $data['added2T'] + $data['added3T'];
            $data['reducedT'] = Transfer::where('company_id',Auth::user()->company_id)->whereDate('updated_at', Carbon::today())->where('from','shop')->where('from_id',$check3)->where('status','received')->sum('quantity');
            $data['reduced2T'] = Sale::where('company_id',Auth::user()->company_id)->whereDate('updated_at', Carbon::today())->where('shop_id',$check3)->where('status','sold')->sum('quantity');
            $data['reducedT'] = $data['reducedT'] + $data['reduced2T'];
            // end today, start week
            $data['addedW'] = Transfer::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('destination','shop')->where('destination_id',$check3)->where('status','received')->sum('quantity');
            $data['added2W'] = NewStock::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('shop_id',$check3)->where('status','updated')->sum('added_quantity');
            $data['added3W'] = ReturnSoldItem::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('shop_id',$check3)->where('status','received')->sum('quantity');
            $data['addedW'] = $data['addedW'] + $data['added2W'] + $data['added3W'];
            $data['reducedW'] = Transfer::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('from','shop')->where('from_id',$check3)->where('status','received')->sum('quantity');
            $data['reduced2W'] = Sale::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('shop_id',$check3)->where('status','sold')->sum('quantity');
            $data['reducedW'] = $data['reducedW'] + $data['reduced2W'];
            // end week, start month
            $data['addedM'] = Transfer::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->where('destination','shop')->where('destination_id',$check3)->where('status','received')->sum('quantity');
            $data['added2M'] = NewStock::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->where('shop_id',$check3)->where('status','updated')->sum('added_quantity');
            $data['added3M'] = ReturnSoldItem::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->where('shop_id',$check3)->where('status','received')->sum('quantity');
            $data['addedM'] = $data['addedM'] + $data['added2M'] + $data['added3M'];
            $data['reducedM'] = Transfer::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->where('from','shop')->where('from_id',$check3)->where('status','received')->sum('quantity');
            $data['reduced2M'] = Sale::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->where('shop_id',$check3)->where('status','sold')->sum('quantity');
            $data['reducedM'] = $data['reducedM'] + $data['reduced2M'];
            // end month
            $view = view('partials.stock-report', compact('data'))->render();
            return response()->json(['view'=>$view,'quantity'=>$quantity]);
        }

        if ($check == "stock" && $check2 == "store") {
            $data['last'] = Store::where('company_id',Auth::user()->company_id)->orderBy('id','desc')->first();
            $data['store'] = Store::where('id',$check3)->where('company_id',Auth::user()->company_id)->first();
            $data['quantity'] = $quantity = \DB::connection('tenant')->table('store_products')->where('store_id',$check3)->where('active','yes')->sum('quantity');
            // today
            $data['addedT'] = Transfer::where('company_id',Auth::user()->company_id)->whereDate('updated_at', Carbon::today())->where('destination','store')->where('destination_id',$check3)->where('status','received')->sum('quantity');
            $data['added2T'] = NewStock::where('company_id',Auth::user()->company_id)->whereDate('updated_at', Carbon::today())->where('store_id',$check3)->where('status','updated')->sum('added_quantity');
            $data['addedT'] = $data['addedT'] + $data['added2T'];
            $data['reducedT'] = Transfer::where('company_id',Auth::user()->company_id)->whereDate('updated_at', Carbon::today())->where('from','store')->where('from_id',$check3)->where('status','received')->sum('quantity');
            // end today, start week
            $data['addedW'] = Transfer::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('destination','store')->where('destination_id',$check3)->where('status','received')->sum('quantity');
            $data['added2W'] = NewStock::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('store_id',$check3)->where('status','updated')->sum('added_quantity');
            $data['addedW'] = $data['addedW'] + $data['added2W'];
            $data['reducedW'] = Transfer::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('from','store')->where('from_id',$check3)->where('status','received')->sum('quantity');
            // end week, start month
            $data['addedM'] = Transfer::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->where('destination','store')->where('destination_id',$check3)->where('status','received')->sum('quantity');
            $data['added2M'] = NewStock::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->where('store_id',$check3)->where('status','updated')->sum('added_quantity');
            $data['addedM'] = $data['addedM'] + $data['added2M'];
            $data['reducedM'] = Transfer::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->where('from','store')->where('from_id',$check3)->where('status','received')->sum('quantity');
            // end month
            $view = view('partials.stock-report', compact('data'))->render();
            return response()->json(['view'=>$view, 'data'=>$data, 'quantity'=>$quantity]);
        }

        if ($check == "stockR") {
            $quantities = array();
            if ($check2 != "all") {                
                $shopstore = explode('-', $check2);
                $data['shopstore'] = $shopstore[0];
                if ($shopstore[0] == "shop") {
                    $shop_id = $shopstore[1];
                    $data['shop'] = Shop::where('id',$shop_id)->where('company_id',Auth::user()->company_id)->first();
                    $data['totalQty'] = \DB::connection('tenant')->table('shop_products')->where('shop_id',$shop_id)->where('active','yes')->sum('quantity');
                    // products
                    $data['products'] = Product::where('company_id',Auth::user()->company_id)->get();
                    foreach($data['products'] as $value) {
                        $q1 = \DB::connection('tenant')->table('shop_products')->where('product_id',$value->id)->where('shop_id',$shop_id)->where('active','yes')->first();
                        if ($q1) {
                            if ($value->status == "deleted" && $q1->quantity == 0) {
                            } else {
                                $sum = $q1->quantity;
                                $quantities[$value->name] = $sum;
                            }                           
                        }
                    }

                    return response()->json(['data'=>$data,'quantities'=>$quantities]);
                }
                if ($shopstore[0] == "store") {
                    $store_id = $shopstore[1];
                    $data['store'] = Store::where('id',$store_id)->where('company_id',Auth::user()->company_id)->first();
                    $data['totalQty'] = \DB::connection('tenant')->table('store_products')->where('store_id',$store_id)->where('active','yes')->sum('quantity');
                    // products
                    $data['products'] = Product::where('company_id',Auth::user()->company_id)->get();
                    foreach($data['products'] as $value) {
                        $q1 = \DB::connection('tenant')->table('store_products')->where('product_id',$value->id)->where('store_id',$store_id)->where('active','yes')->first();
                        if ($q1) {
                            if ($value->status == "deleted" && $q1->quantity == 0) {
                            } else {
                                $sum = $q1->quantity;
                                $quantities[$value->name] = $sum;
                            }                           
                        }
                    }

                    return response()->json(['data'=>$data,'quantities'=>$quantities]);
                }
            } else {
                $data['totalQty'] = \DB::connection('tenant')->table('shop_products')->join('shops','shops.id','shop_products.shop_id')->where('shops.company_id',Auth::user()->company_id)->where('shop_products.active','yes')->sum('quantity');
                $data['totalQty2'] = \DB::connection('tenant')->table('store_products')->join('stores','stores.id','store_products.store_id')->where('stores.company_id',Auth::user()->company_id)->where('store_products.active','yes')->sum('quantity');
                $data['totalQty'] = $data['totalQty'] + $data['totalQty2'];
                // products
                $data['products'] = Product::where('company_id',Auth::user()->company_id)->get();
                foreach($data['products'] as $value) {
                    $q1 = \DB::connection('tenant')->table('shop_products')->where('product_id',$value->id)->where('active','yes')->sum('quantity');
                    $q2 = \DB::connection('tenant')->table('store_products')->where('product_id',$value->id)->where('active','yes')->sum('quantity');
                    $sum = $q1 + $q2;
                    $quantities[$value->name] = $sum;
                }

                return response()->json(['data'=>$data,'quantities'=>$quantities]);
            }
        }

        if ($check == "transferR") {
            $output = array();
            $date = $check3;
            $fromdate = date("Y-m-d 00:00:00", strtotime($date));
            $todate = date("Y-m-d 23:59:59", strtotime($date));
            
            if ($check2) {
                // sent / pending
                $from = "";
                $to = "";
                $items = Transfer::where('company_id',Auth::user()->company_id)->where('status','sent')->groupBy('transfer_no')->get(); 
                if ($items->isNotEmpty()) {
                    foreach($items as $value) {
                        $items2 = Transfer::where('company_id',Auth::user()->company_id)->where('transfer_no',$value->transfer_no)->get();
                        if ($items2->isNotEmpty()) {
                            foreach($items2 as $value2) {
                                if ($value2->from == "shop") {
                                    $from = Shop::find($value2->from_id)->name;
                                }
                                if ($value2->from == "store") {
                                    $from = Store::find($value2->from_id)->name;
                                }
                                if ($value2->destination == "shop") {
                                    $to = Shop::find($value2->destination_id)->name;
                                }
                                if ($value2->destination == "store") {
                                    $to = Store::find($value2->destination_id)->name;
                                }
                                $sender = $shipper = $receiver = $received_at = $datetime = "";
                                if ($value2->sender) {
                                    $sender = $value2->sender->name;
                                }
                                if ($value2->shipper) {
                                    $shipper = $value2->shipper->name;
                                }
                                $today = date('Y-m-d');
                                $now = date('Y-m-d H:i:s');
                                if ($today == $value2->updated_at->format('Y-m-d')) {
                                    $startT = new \DateTime($value2->updated_at);
                                    $now = new \DateTime($now);
                                    $interval = $startT->diff($now);
                                    $datetime = $interval->format('%h')."h ".$interval->format('%i')."m";
                                } else {
                                    $today = strtotime($today);
                                    $date2 = strtotime($value2->updated_at->format('Y-m-d'));
                                    $diff = $today - $date2;
                                    $datetime =  round($diff / (60 * 60 * 24))." days ago";
                                }
                                $output[] = "<tr><td>".$value2->transfer_no."</td><td>".$value2->product->name."</td><td>".$value2->quantity."</td>
                                    <td><p class='m-0'><b>".$from."</b></p><p class='m-0'>".date('d/m/Y H:i', strtotime($value2->sent_at))."</p></td>
                                    <td><p class='m-0'><b>".$to."</b></p><p class='m-0'>".$received_at."</p></td>
                                    <td><span class='badge badge-info'>Pending</span></td>
                                    <td>".$datetime."</td>
                                    <td><p class='m-0'><b>Sender:</b> ".$sender."</p><p class='m-0'><b>Shipper:</b> ".$shipper."</p><p class='m-0'><b>Receiver:</b> ".$receiver."</p></td></tr>";
                            }
                        }                    
                    }
                } 
                // received 
                $items = Transfer::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('status','received')->groupBy('transfer_no')->get();
                if ($items->isNotEmpty()) {
                    foreach($items as $value) {
                        $items2 = Transfer::where('company_id',Auth::user()->company_id)->where('transfer_no',$value->transfer_no)->get();
                        if ($items2->isNotEmpty()) {
                            foreach($items2 as $value2) {
                                if ($value2->from == "shop") {
                                    $from = Shop::find($value2->from_id)->name;
                                }
                                if ($value2->from == "store") {
                                    $from = Store::find($value2->from_id)->name;
                                }
                                if ($value2->destination == "shop") {
                                    $to = Shop::find($value2->destination_id)->name;
                                }
                                if ($value2->destination == "store") {
                                    $to = Store::find($value2->destination_id)->name;
                                }
                                $sender = $shipper = $receiver = $received_at = $datetime = "";
                                if ($value2->sender) {
                                    $sender = $value2->sender->name;
                                }
                                if ($value2->shipper) {
                                    $shipper = $value2->shipper->name;
                                }
                                if ($value2->receiver) {
                                    $receiver = $value2->receiver->name;
                                }
                                if($value2->received_at){
                                    $received_at = date('d/m/Y H:i', strtotime($value2->received_at));
                                }
                                $today = date('Y-m-d');                                
                                if (date("Y-m-d", strtotime($value2->received_at)) == date("Y-m-d", strtotime($value2->sent_at))) {
                                    $startT = new \DateTime(date("Y-m-d H:i:s", strtotime($value2->sent_at)));
                                    $toT = new \DateTime(date("Y-m-d H:i:s", strtotime($value2->received_at)));
                                    $interval = $startT->diff($toT);
                                    $datetime = $interval->format('%h')."h ".$interval->format('%i')."m";
                                } else {
                                    $date1 = strtotime(date("Y-m-d", strtotime($value2->sent_at)));
                                    $date2 = strtotime(date("Y-m-d", strtotime($value2->received_at)));
                                    $diff = $date2 - $date1;
                                    $datetime =  round($diff / (60 * 60 * 24))."d";
                                }
                                $output[] = "<tr><td>".$value2->transfer_no."</td><td>".$value2->product->name."</td><td>".$value2->quantity."</td>
                                    <td><p class='m-0'><b>".$from."</b></p><p class='m-0'>".date('d/m/Y H:i', strtotime($value2->sent_at))."</p></td>
                                    <td><p class='m-0'><b>".$to."</b></p><p class='m-0'>".$received_at."</p></td>
                                    <td><span class='badge badge-success'>Received</span></td>
                                    <td>".$datetime."</td>
                                    <td><p class='m-0'><b>Sender:</b> ".$sender."</p><p class='m-0'><b>Shipper:</b> ".$shipper."</p><p class='m-0'><b>Receiver:</b> ".$receiver."</p></td></tr>";
                            }
                        }                    
                    }
                } 
                return response()->json(['items'=>$output]);
            } else {

            }
        }
        
        if ($check == "new-account-created") {
            $cid = $check2;
            $password = $check3;

            $api_key='8ec40e250b20855c';
            $secret_key = 'NzdiZTQyMzAzNGJlZDE4ZjE4NzhjMjcyYjA0NDEyOGY5YTRlMmZmODBmZGRkMTQwOTc5OTZkNzY4NTU1OGQzZg==';

            ////////////////////////////////
            $acc = \App\Company::find($cid);
            if($acc) {
                $user = \App\User::where('company_id',$cid)->first();
                $phone = $user->phonecode.''.str_replace(' ', '', $user->phone);
                $postData = array(
                    'source_addr' => 'LevandaPOS',
                    'encoding'=>0,
                    'schedule_time' => '',
                    'message' => 'Akaunti ya '.$acc->name.' imetengenezwa -- USERNAME: '.$user->username.', PASSWORD: '.$password.' -- kumbuka kubadili password utakapologin kwa mara ya kwanza. Tembelea: https://pos.levanda.co.tz/',
                    'recipients' => [array('recipient_id' => '1','dest_addr'=>$phone)],
                );
                
                $Url ='https://apisms.beem.africa/v1/send';
                
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
                        'Content-Type: application/json'
                    ),
                    CURLOPT_POSTFIELDS => json_encode($postData)
                ));
    
                $response = curl_exec($ch);
                
                if($response === FALSE){
                    echo $response;
                
                    die(curl_error($ch));
                }
                $output[] = $response;
                // var_dump($response);
                return response()->json(['output'=>$output]);
            }            
        }
    }

    public function reports3($check,$check2) {
        if ($check == 'admin') {
            Session::put('role','Admin');
        } elseif ($check == 'ceo') {
            Session::put('role','CEO');
        } elseif ($check == 'business-owner') {
            Session::put('role','Business Owner');
        } 
        if ($check2 == "sales") {
            $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
            $data['items'] = Product::where('status','!=','deleted')->where('company_id',Auth::user()->company_id)->get();
            return view('business-owner.sales', compact('data'));
        }
        if ($check2 == 'stock') {
            $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
            $data['stores'] = Store::where('company_id',Auth::user()->company_id)->get();
            $data['products'] = Product::where('status','published')->where('company_id',Auth::user()->company_id)->get();
            return view('business-owner.stock', compact('data'));
        }
        if ($check2 == "pending-stock") {
            $output = array();
            $totalStQ = 0;
            $whereto = "";
            $destid = "";
            $items = NewStock::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('status','request')->get();
            if ($items->isNotEmpty()) {
                foreach($items as $value) {
                    $totalStQ = $totalStQ + $value->added_quantity;  
                    if ($value->shop_id) {
                        $whereto = $value->shop->name." (shop)";
                        $destid = "shop-".$value->shop_id;
                    }              
                    if ($value->store_id) {
                        $whereto = $value->store->name." (store)";
                        $destid = "store-".$value->store_id;
                    }              
                    $output[] = '<tr class="str-'.$value->id.'"><td>'.$value->product->name.'</td>'
                        .'<td><input type="number" class="form-control form-control-sm st-quantity" placeholder="Q" name="quantity" value="'.sprintf('%g',$value->added_quantity).'" sid="'.$value->id.'" style="width:80px"></td>'
                        .'<td><span class="p-1 text-danger remove-str" val="'.$value->id.'" style="cursor: pointer;"><i class="fa fa-times"></i></span></td></tr>';
                }
            } else {
                $output[] = '<tr class="empty-row"><td colspan="3" align="center"><i>-- No items --</i></td></tr>';
            }
            return response()->json(['items'=>$output,'totalStQ'=>$totalStQ,'whereto'=>$whereto,'destid'=>$destid]);
        }
        if ($check2 == "pending-stock-2") {
            $data['pendingstock'] = NewStock::where('company_id',Auth::user()->company_id)->where('status','sent')->groupBy('shop_id')->groupBy('store_id')->get();
            $view = view('partials.pending-stock',compact('data'))->render();
            return response()->json(['view'=>$view]);
        }
        if ($check2 == "received-stock") {
            $shopstore = "";
            $status = $sender = $receiver = "";
            $items = NewStock::where('company_id',Auth::user()->company_id)->where('status','updated')->orderBy('id','desc')->limit(25)->get();
            if ($items->isNotEmpty()) {
                foreach($items as $value) {    
                    if ($value->status == "updated") {
                         $status = "Received";
                    }     
                    if ($value->shop) {
                        $shopstore = $value->shop->name;
                    }
                    if ($value->store) {
                        $shopstore = $value->store->name;
                    }
                    if ($value->sender) {
                        $sender = $value->sender->name;
                    }
                    if ($value->receiver) {
                        $receiver = $value->receiver->name;
                    }
                    $output[] = '<tr><td>'.$value->product->name.'</td>'
                        .'<td>'.sprintf('%g',$value->added_quantity).'</td>'
                        .'<td>'.$shopstore.'</td>'
                        .'<td><span class="badge badge-success">'.$status.'</span></td>'
                        .'<td>'.$value->sent_at.'</td>'
                        .'<td>'.$sender.'</td>'
                        .'<td>'.$value->received_at.'</td>'
                        .'<td>'.$receiver.'</td>'
                        .'</tr>';
                    $status = $sender = $receiver = "";
                }
            } else {
                $output[] = '<tr class="empty-row"><td colspan="7" align="center"><i>-- No items --</i></td></tr>';
            }
            return response()->json(['items'=>$output]);
        }
        if ($check2 == "item-activities") {
            $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
            $data['stores'] = Store::where('company_id',Auth::user()->company_id)->get();
            $data['products'] = Product::where('status','!=','deleted')->where('company_id',Auth::user()->company_id)->orderBy('name')->get();
            $data['item'] = Sale::where('status','sold')->orderBy('updated_at','desc')->where('company_id',Auth::user()->company_id)->first();
            $view = view('partials.item-activities',compact('data'))->render();
            return response()->json(['view'=>$view]);
        }
        
    }

    public function get_data($check, $conditions) {
        $output = array();
        $data = array();
        $data['total'] = 0;

        // company/account details 
        if ($check == "companies") {
            if($conditions == "summary") {
                $data['total_accounts'] = Company::all()->count();
                $data['total_f'] = Company::where('status','free trial')->get()->count();
                $data['total_e_f'] = Company::where('status','end free trial')->get()->count();
                $data['total_a'] = Company::where('status','active')->get()->count();
                $data['total_n_p'] = Company::where('status','not paid')->get()->count();

                return response()->json(['data'=>$data]);
            }
            if ($conditions == "active-summary") {
                $companies = Company::where('status','active')->orderBy('created_at','desc')->limit(7)->get();
                if($companies->isNotEmpty()) {
                    $data['total'] = Company::where('status','active')->get()->count();
                    foreach($companies as $company) {

                        $last_day_to_sale = "A: --";
                        $today = date('Y-m-d');
                        $cdate = new DateTime($company->created_at);
                        $last_sale = Sale::where('company_id',$company->id)->orderBy('updated_at', 'desc')->first();
                        if ($last_sale) {
                            $last_day_to_sale = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($last_sale->updated_at))))->days;
                            $last_day_to_sale = "<span>A: </span><b>".$last_day_to_sale."</b><small>d, sale</small>";
                        }
                        
                        $activeness = $last_day_to_sale;

                        $output[] = "<tr><td><a href='/admin/accounts/".$company->id."'>".$company->name."</a></td><td>C: ".$cdate->format('d/m/Y')."<br>".$activeness."</td></tr>";
                    }
                }
                return response()->json(['output'=>$output,'data'=>$data]);

            }
            if($conditions == "active") {
                $companies = Company::where('status','active')->orderBy('created_at','desc')->limit(20)->get();
                if($companies->isNotEmpty()) {
                    $num = 1;
                    $data['total'] = Company::where('status','active')->count();
                    $data['totalp'] = $companies->count();
                    foreach($companies as $company) {
                        $data['last_id'] = $company->id;
                        $last_day_to_sale = "---";
                        $today = date('Y-m-d');
                        $cdate = new DateTime($company->created_at);
                        $last_sale = Sale::where('company_id',$company->id)->orderBy('updated_at', 'desc')->first();
                        if ($last_sale) {
                            $last_day_to_sale = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($last_sale->updated_at))))->days;
                            $last_day_to_sale = "<b>".$last_day_to_sale." </b><small>Days ago to sale</small>";
                        }
                        
                        $activeness = $last_day_to_sale;

                        $output[] = "<tr><td><a href='/admin/accounts/".$company->id."'>".$company->name."</a></td><td>".$cdate->format('d-m-Y')."</td><td>".$activeness."</td><td align='center'><span class='view-company-btn cid='".$company->id."'><i class='fa fa-eye'></i></span><span class='action-company-btn company-btn".$company->id."' cid='".$company->id."'><i class='fa fa-angle-right'></i></span><div class='drop-action-outer'><div class='drop-action view-drop".$company->id."'><span class='edit-company-btn' cid='".$company->id."'>Edit</span><!--<span>Block</span>--></div></div></td></tr>";
                        $num++;
                    }                    
                }
                return response()->json(['output'=>$output,'data'=>$data]);
            }
            if($conditions == "active-bkp") {
                $date = \Carbon\Carbon::today()->subDays(7); //past 7 days
                $acs = DailySale::where('updated_at','>=',$date)->groupBy('company_id')->orderBy('id','desc')->get();
                if($acs->isNotEmpty()) {
                    $num = 1;
                    foreach($acs as $ac) {
                        $company = Company::find($ac->company_id);
                        if($company) {
                            $status = "";
    
                            $last_day_to_sale = "---";
                            $today = date('Y-m-d');
                            $cdate = new DateTime($company->created_at);
                            $last_sale = Sale::where('company_id',$company->id)->orderBy('updated_at', 'desc')->first();
                            if ($last_sale) {
                                $last_day_to_sale = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($last_sale->updated_at))))->days;
                                $last_day_to_sale = "<b>".$last_day_to_sale." </b><small>Days ago to sale</small>";
                            }
                            
                            if ($company->status == "new") { $status = "<span class='badge badge-info'>New</span>"; }
                            if ($company->status == "free trial") { $status = "<span class='badge badge-default'>Free Trial</span>"; }
                            if ($company->status == "active") { $status = "<span class='badge badge-success'>Active</span>"; }
                            if ($company->status == "blocked") { $status = "<span class='badge badge-danger'>Blocked</span>"; }
                            $activeness = $last_day_to_sale;
    
                            $output[] = "<tr><td>".$num."</td><td><a href='/admin/accounts/".$company->id."'>".$company->name."</a></td><td>".$status."</td><td>".$cdate->format('d-m-Y')."</td><td>".$activeness."</td><td align='center'><span class='view-company-btn cid='".$company->id."'><i class='fa fa-eye'></i></span><span class='action-company-btn company-btn".$company->id."' cid='".$company->id."'><i class='fa fa-angle-right'></i></span><div class='drop-action-outer'><div class='drop-action view-drop".$company->id."'><span class='edit-company-btn' cid='".$company->id."'>Edit</span><!--<span>Block</span>--></div></div></td></tr>";
                            $num++;
                        }
                    }
                }
                return response()->json(['output'=>$output]);
            }
            if ($conditions == "free-trial-summary") { 

                $companies = Company::with(['sales' => function ($query) {
                    $query->orderBy('updated_at', 'desc')->limit(1);
                }])->where('companies.status','free trial')->orderBy('updated_at', 'desc')->limit(7)->get();

                if($companies->isNotEmpty()) {
                    $data['total'] = Company::where('status','free trial')->get()->count();
                    foreach ($companies as $company) {
                        $last_day_to_sale = "A: --";
                        $today = date('Y-m-d');
                        
                        if ($company->sales) {
                            foreach ($company->sales as $sale) {
                                $last_day_to_sale = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($sale->updated_at))))->days;
                                $last_day_to_sale = "<span>A: </span><b>".$last_day_to_sale."</b><small>d, sale</small>";
                            }
                        }

                        $activeness = $last_day_to_sale;

                        $cdate = new DateTime($company->created_at);
                        $output[] = "<tr><td><a href='/admin/accounts/".$company->id."'>".$company->name."</a></td><td>C: ".$cdate->format('d/m/Y')."<br>".$activeness."</td></tr>";
                    }
                }
                return response()->json(['output'=>$output,'data'=>$data]);

            }
            if ($conditions == "free-trial") {
                $companies = Company::where('status','free trial')->orderBy('created_at','desc')->limit(20)->get();
                if($companies->isNotEmpty()) {
                    $num = 1;
                    $data['total'] = Company::where('status','free trial')->count();
                    $data['totalp'] = $companies->count();
                    foreach($companies as $company) {
                        $data['last_id'] = $company->id;
                        $last_day_to_sale = "---";
                        $today = date('Y-m-d');
                        $cdate = new DateTime($company->created_at);
                        $last_sale = Sale::where('company_id',$company->id)->orderBy('updated_at', 'desc')->first();
                        if ($last_sale) {
                            $last_day_to_sale = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($last_sale->updated_at))))->days;
                            $last_day_to_sale = "<b>".$last_day_to_sale." </b><small>Days ago to sale</small>";
                        }
                        
                        $activeness = $last_day_to_sale;

                        $output[] = "<tr><td><a href='/admin/accounts/".$company->id."'>".$company->name."</a></td><td>".$cdate->format('d-m-Y')."</td><td>".$activeness."</td><td align='center'><span class='view-company-btn cid='".$company->id."'><i class='fa fa-eye'></i></span><span class='action-company-btn company-btn".$company->id."' cid='".$company->id."'><i class='fa fa-angle-right'></i></span><div class='drop-action-outer'><div class='drop-action view-drop".$company->id."'><span class='edit-company-btn' cid='".$company->id."'>Edit</span><!--<span>Block</span>--></div></div></td></tr>";
                        $num++;
                    }
                }
                return response()->json(['output'=>$output,'data'=>$data]);

            }
            if ($conditions == "not-paid-summary") {
                $companies = Company::where('status','not paid')->orderBy('created_at','desc')->limit(7)->get();
                if($companies->isNotEmpty()) {
                    $data['total'] = Company::where('status','not paid')->get()->count();
                    foreach($companies as $company) {

                        $last_day_to_sale = "A: --";
                        $today = date('Y-m-d');
                        $cdate = new DateTime($company->created_at);
                        $last_sale = Sale::where('company_id',$company->id)->orderBy('updated_at', 'desc')->first();
                        if ($last_sale) {
                            $last_day_to_sale = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($last_sale->updated_at))))->days;
                            $last_day_to_sale = "<span>A: </span><b>".$last_day_to_sale."</b><small>d, sale</small>";
                        }
                        
                        $activeness = $last_day_to_sale;

                        $output[] = "<tr><td><a href='/admin/accounts/".$company->id."'>".$company->name."</a></td><td>C: ".$cdate->format('d/m/Y')."<br>".$activeness."</td></tr>";
                    }
                }
                return response()->json(['output'=>$output,'data'=>$data]);

            }
            if ($conditions == "not-paid") {
                $companies = Company::where('status','not paid')->orderBy('created_at','desc')->limit(20)->get();
                if($companies->isNotEmpty()) {
                    $num = 1;
                    $data['total'] = Company::where('status','not paid')->count();
                    $data['totalp'] = $companies->count();
                    foreach($companies as $company) {
                        $data['last_id'] = $company->id;
                        $last_day_to_sale = "---";
                        $today = date('Y-m-d');
                        $cdate = new DateTime($company->created_at);
                        $last_sale = Sale::where('company_id',$company->id)->orderBy('updated_at', 'desc')->first();
                        if ($last_sale) {
                            $last_day_to_sale = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($last_sale->updated_at))))->days;
                            $last_day_to_sale = "<b>".$last_day_to_sale." </b><small>Days ago to sale</small>";
                        }
                        
                        $activeness = $last_day_to_sale;

                        $output[] = "<tr><td><a href='/admin/accounts/".$company->id."'>".$company->name."</a></td><td>".$cdate->format('d-m-Y')."</td><td>".$activeness."</td><td align='center'><span class='view-company-btn cid='".$company->id."'><i class='fa fa-eye'></i></span><span class='action-company-btn company-btn".$company->id."' cid='".$company->id."'><i class='fa fa-angle-right'></i></span><div class='drop-action-outer'><div class='drop-action view-drop".$company->id."'><span class='edit-company-btn' cid='".$company->id."'>Edit</span><!--<span>Block</span>--></div></div></td></tr>";
                        $num++;
                    }                    
                }
                return response()->json(['output'=>$output,'data'=>$data]);
            }
            
            if ($conditions == "end-free-trial-summary") {
                $companies = Company::where('status','end free trial')->orderBy('created_at','desc')->limit(7)->get();
                if($companies->isNotEmpty()) {
                    $data['total'] = Company::where('status','end free trial')->get()->count();
                    foreach($companies as $company) {

                        $last_day_to_sale = "A: --";
                        $today = date('Y-m-d');
                        $cdate = new DateTime($company->created_at);
                        $last_sale = Sale::where('company_id',$company->id)->orderBy('updated_at', 'desc')->first();
                        if ($last_sale) {
                            $last_day_to_sale = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($last_sale->updated_at))))->days;
                            $last_day_to_sale = "<span>A: </span><b>".$last_day_to_sale."</b><small>d, sale</small>";
                        }
                        
                        $activeness = $last_day_to_sale;

                        $output[] = "<tr><td><a href='/admin/accounts/".$company->id."'>".$company->name."</a></td><td>C: ".$cdate->format('d/m/Y')."<br>".$activeness."</td></tr>";
                    }
                }
                return response()->json(['output'=>$output,'data'=>$data]);

            }
            if ($conditions == "end-free-trial") {
                $companies = Company::where('status','end free trial')->orderBy('created_at','desc')->limit(20)->get();
                if($companies->isNotEmpty()) {
                    $num = 1;
                    $data['total'] = Company::where('status','end free trial')->count();
                    $data['totalp'] = $companies->count();
                    foreach($companies as $company) {
                        $data['last_id'] = $company->id;
                        $last_day_to_sale = "---";
                        $today = date('Y-m-d');
                        $cdate = new DateTime($company->created_at);
                        $last_sale = Sale::where('company_id',$company->id)->orderBy('updated_at', 'desc')->first();
                        if ($last_sale) {
                            $last_day_to_sale = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($last_sale->updated_at))))->days;
                            $last_day_to_sale = "<b>".$last_day_to_sale." </b><small>Days ago to sale</small>";
                        }
                        
                        $activeness = $last_day_to_sale;

                        $output[] = "<tr><td><a href='/admin/accounts/".$company->id."'>".$company->name."</a></td><td>".$cdate->format('d-m-Y')."</td><td>".$activeness."</td><td align='center'><span class='view-company-btn cid='".$company->id."'><i class='fa fa-eye'></i></span><span class='action-company-btn company-btn".$company->id."' cid='".$company->id."'><i class='fa fa-angle-right'></i></span><div class='drop-action-outer'><div class='drop-action view-drop".$company->id."'><span class='edit-company-btn' cid='".$company->id."'>Edit</span><!--<span>Block</span>--></div></div></td></tr>";
                        $num++;
                    }                    
                }
                return response()->json(['output'=>$output,'data'=>$data]);
            }
            
            if($conditions == "detailed-report") {
                $numbers = Company::select(
                    DB::raw("count(*) AS total_accounts"),
                    DB::raw("sum(status = 'active') AS total_active"),
                    DB::raw("sum(status = 'free trial') AS total_free_trial"),
                    DB::raw("sum(status = 'end free trial') AS total_end_free_trial"),
                    DB::raw("sum(status = 'not paid') AS total_not_paid")
                )->get();
                return response()->json(['numbers'=>$numbers]);
            }
            if($conditions == "detailed-shops-report") {
                $numbers = \App\Shop::select(
                    DB::raw("count(*) AS total_shops"),
                    DB::raw("sum(status = 'active') AS total_active"),
                    DB::raw("sum(status IS NULL) AS total_free_trial"),
                    DB::raw("sum(status = 'end free trial') AS total_end_free_trial"),
                    DB::raw("sum(status = 'not paid') AS total_not_paid")
                )->get();
                return response()->json(['numbers'=>$numbers]);
            }
            if($conditions == "detailed-stores-report") {
                $numbers = \App\Store::select(
                    DB::raw("count(*) AS total_stores"),
                    DB::raw("sum(status = 'active') AS total_active"),
                    DB::raw("sum(status IS NULL) AS total_free_trial"),
                    DB::raw("sum(status = 'end free trial') AS total_end_free_trial"),
                    DB::raw("sum(status = 'not paid') AS total_not_paid")
                )->get();
                return response()->json(['numbers'=>$numbers]);
            }
        }

        if ($check == "accounts-monthly-registrations") {
            $numbers = array();
            $monthyear = explode('-', $conditions);
            $month = $monthyear[0];
            $year = $monthyear[1];
            $date = \Carbon\Carbon::parse($year."-".$month."-01");
            $start = $date->startOfMonth()->format('Y-m-d H:i:s');
            $end = $date->endOfMonth()->format('Y-m-d H:i:s');
            $numbers[] = Company::select(
                DB::raw("count(*) AS total_accounts"),
                DB::raw("sum(status = 'active') AS total_active"),
                DB::raw("sum(status = 'free trial') AS total_free_trial"),
                DB::raw("sum(status = 'end free trial') AS total_end_free_trial"),
                DB::raw("sum(status = 'not paid') AS total_not_paid")
            )->whereBetween('created_at', [$start, $end])->get();
            $numbers[] = \App\Shop::select(
                DB::raw("count(*) AS total_shops"),
                DB::raw("sum(status = 'active') AS total_active2"),
                DB::raw("sum(status IS NULL) AS total_free_trial2"),
                DB::raw("sum(status = 'end free trial') AS total_end_free_trial2"),
                DB::raw("sum(status = 'not paid') AS total_not_paid2")
            )->whereBetween('created_at', [$start, $end])->get();
            $numbers[] = \App\Store::select(
                DB::raw("count(*) AS total_stores"),
                DB::raw("sum(status = 'active') AS total_active3"),
                DB::raw("sum(status IS NULL) AS total_free_trial3"),
                DB::raw("sum(status = 'end free trial') AS total_end_free_trial3"),
                DB::raw("sum(status = 'not paid') AS total_not_paid3")
            )->whereBetween('created_at', [$start, $end])->get();
            return response()->json(['numbers'=>$numbers,'monthyear'=>$conditions]);
        }
        
        if ($check == "accounts-monthly-revenues") {
            $monthyear = explode('-', $conditions);
            $month = $monthyear[0];
            $year = $monthyear[1];
            $date = \Carbon\Carbon::parse($year."-".$month."-01");
            $start = $date->startOfMonth()->format('Y-m-d H:i:s');
            $end = $date->endOfMonth()->format('Y-m-d H:i:s');
            $numbers = \App\Payment::query()->select([
                DB::raw("count(*) AS total_accounts"),
                DB::raw("sum(paid_amount) AS paid_amount")
            ])->where('status','paid')->whereBetween('created_at', [$start, $end])->get();
            return response()->json(['numbers'=>$numbers,'monthyear'=>$conditions]);
        }

        if($check == "more-companies") {
            $status_cid = explode('~', $conditions);
            $status = $status_cid[0];
            $lid = $status_cid[1];
            if($status == "e-f-t") {
                $companies = Company::where('status','end free trial')->where('id','<',$lid)->orderBy('created_at','desc')->limit(20)->get();
            }
            if($status == "f-t") {
                $companies = Company::where('status','free trial')->where('id','<',$lid)->orderBy('created_at','desc')->limit(20)->get();
            }
            if($status == "n-p") {
                $companies = Company::where('status','not paid')->where('id','<',$lid)->orderBy('created_at','desc')->limit(20)->get();
            }
            if($status == "active") {
                $companies = Company::where('status','active')->where('id','<',$lid)->orderBy('created_at','desc')->limit(20)->get();
            }
            if($companies->isNotEmpty()) {
                $num = 1;
                $data['totalp'] = $companies->count();
                foreach($companies as $company) {
                    $data['last_id'] = $company->id;
                    $last_day_to_sale = "---";
                    $today = date('Y-m-d');
                    $cdate = new DateTime($company->created_at);
                    $last_sale = Sale::where('company_id',$company->id)->orderBy('updated_at', 'desc')->first();
                    if ($last_sale) {
                        $last_day_to_sale = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($last_sale->updated_at))))->days;
                        $last_day_to_sale = "<b>".$last_day_to_sale." </b><small>Days ago to sale</small>";
                    }
                    
                    $activeness = $last_day_to_sale;

                    $output[] = "<tr><td><a href='/admin/accounts/".$company->id."'>".$company->name."</a></td><td>".$cdate->format('d-m-Y')."</td><td>".$activeness."</td><td align='center'><span class='view-company-btn cid='".$company->id."'><i class='fa fa-eye'></i></span><span class='action-company-btn company-btn".$company->id."' cid='".$company->id."'><i class='fa fa-angle-right'></i></span><div class='drop-action-outer'><div class='drop-action view-drop".$company->id."'><span class='edit-company-btn' cid='".$company->id."'>Edit</span><!--<span>Block</span>--></div></div></td></tr>";
                    $num++;
                }                    
            }
            return response()->json(['output'=>$output,'data'=>$data]);
        }

        if ($check == "installations") {
            if ($conditions == "count") {
                $count = \App\AppInstallation::count();
                return response()->json(['output'=>$count]);
            }
        }

        if ($check == "payment-methods") {
                $payments = \App\PaymentOption::all();
                return response()->json(['payments'=>$payments]);
        }

        if ($check == "bo-numbers") {
            $date = explode('-', $conditions);
            $date = $date[2]."-".$date[1]."-".$date[0];
            $owners = User::query()->select([
                    DB::raw('users.phone as phone, companies.name as cname, shops.location as location, regions.name as rname, districts.name as dname')
                ])
                ->join('companies','companies.id','users.company_id')
                ->join('user_roles','user_roles.user_id','users.id')
                ->join('shops','shops.company_id','companies.id')
                ->leftJoin('regions','regions.id','shops.region_id')
                ->leftJoin('districts','districts.id','shops.district_id')
                ->where('user_roles.role_id',2)->whereDate('companies.created_at',Carbon::parse($date))->get();
            return response()->json(['owners'=>$owners]);
        }

        if ($check == "regions-by-cid") {
            $cid = $conditions;
            $data['regions'] = \App\Region::query()->select([
                    DB::raw('id, name')
                ])->where('country_id',$cid)->get();
            return response()->json(['data'=>$data]);
        }

        if ($check == "districts-by-rid") {
            $rid = $conditions;
            $data['districts'] = \App\District::query()->select([
                    DB::raw('id, name')
                ])->where('region_id',$rid)->get();
            return response()->json(['data'=>$data]);
        }

        if ($check == "wards-by-did") {
            $did = $conditions;
            $wards = \App\Ward::query()->select([
                    DB::raw('id, name')
                ])->where('district_id',$did)->get();
            return response()->json(['wards'=>$wards]);
        }

        if ($check == "shop-details") {
            $sid = $conditions;
            $shop = Shop::query()->select([
                    DB::raw('shops.name as sname, shops.location as location, countries.name as cname, regions.name as rname, districts.name as dname, wards.name as wname')
                ])
                ->leftJoin('countries','countries.id','shops.country_id')
                ->leftJoin('regions','regions.id','shops.region_id')
                ->leftJoin('districts','districts.id','shops.district_id')
                ->leftJoin('wards','wards.id','shops.ward_id')
                ->where('shops.id',$sid)->get();
            $cashiers = User::query()->select([
                    DB::raw('users.username as uname')
                ])
                ->join('user_shops','user_shops.user_id','users.id')
                ->join('shops','shops.id','user_shops.shop_id')
                ->where('user_shops.shop_id',$sid)->where('user_shops.who','cashier')->where('users.status','active')->get();
            $sperson = User::query()->select([
                    DB::raw('users.username as uname')
                ])
                ->join('user_shops','user_shops.user_id','users.id')
                ->join('shops','shops.id','user_shops.shop_id')
                ->where('user_shops.shop_id',$sid)->where('user_shops.who','sale person')->where('users.status','active')->get();
            return response()->json(['shop'=>$shop,'cashiers'=>$cashiers,'sperson'=>$sperson]);
        }

        if ($check == "preview-product") {
            $pid = preg_replace("/[^0-9]/","",$conditions);
            $data['product'] = Product::where('id',$pid)->where('company_id',Auth::user()->company_id)->first();
            $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
            $data['stores'] = Store::where('company_id',Auth::user()->company_id)->get();
            $data['totalQty'] = \DB::connection('tenant')->table('shop_products')->join('shops','shops.id','shop_products.shop_id')->where('shops.company_id',Auth::user()->company_id)->where('shop_products.product_id',$pid)->where('shop_products.active','yes')->sum('quantity');
            $data['totalQty2'] = \DB::connection('tenant')->table('store_products')->join('stores','stores.id','store_products.store_id')->where('stores.company_id',Auth::user()->company_id)->where('store_products.product_id',$pid)->where('store_products.active','yes')->sum('quantity');
            $totalQty = $data['totalQty'] + $data['totalQty2'];
            if($data['product']) {
                if(Auth::user()->isCEOorAdminorBusinessOwner()) {
                        
                    $view = view('tabs.product-preview', compact('data'))->render();
                    return response()->json(['view'=>$view,'product'=>$data]);
                }
            }
        }
        
        if ($check == "edit-product") {
            $pro_pid = explode('~', $conditions);
            if(count($pro_pid) > 1) {
                $data['check'] = $pro_pid[0]; // check if this request is from shop/products tabs
                $pid = preg_replace("/[^0-9]/","",$pro_pid[1]);
            } else {
                $data['check'] = 'from products tab';
                $pid = preg_replace("/[^0-9]/","",$conditions);
            }
            
            
            $data['product'] = Product::where('id',$pid)->where('company_id',Auth::user()->company_id)->first();
            if($data['product']) {
                if(Auth::user()->isCEOorAdmin()) {
                    
                    $data['product-category'] = $data['product']->productcategory;
                    if($data['product']->product_category_id == 0) { // there is a problem where some products are registered with 0 on p_cate_id field... i just hide error by assigning any pro_cate_id from registered cats
                        $cat = ProductCategory::where('status','!=','deleted')->orWhereNull('status')->where('company_id',Auth::user()->company_id)->first();
                        $update = $data['product']->update(['product_category_id'=>$cat->id]);
                        if($update) {
                            $data['product'] = Product::where('id',$pid)->where('company_id',Auth::user()->company_id)->first();
                            $data['product-category'] = $data['product']->productcategory;
                        }
                    }
                    $data['categories'] = ProductCategory::where('status','!=','deleted')->orWhereNull('status')->where('company_id',Auth::user()->company_id)->orderBy('name')->get();
                    $data['status'] = ['published','unpublished'];
                    $data['category-group'] = $data['product-category']->categorygroup;
                    $data['cgroups'] = ProductCategoryGroup::where('company_id',Auth::user()->company_id)->get();
                    $view = view('tabs.product-edit', compact('data'))->render();
                    return response()->json(['view'=>$view,'product'=>$data]);
                }
            }
        }

        if ($check == "company") { // encrypt company_id
            $cid = $conditions;
            $company = Company::find($cid);
            $enc_id = Crypt::encrypt($company->id);
            return response()->json(['company'=>$company,'enc_id'=>$enc_id]);
        }

        if ($check == "load-more-sales") {            
            $condition = explode('~', $conditions);
            $lastid = $condition[0];
            $sdate = $condition[1];
            $stype = $condition[2];
            $shop_id = $condition[3];
            $date = date("Y-m-d", strtotime($sdate));
            $today = date("Y-m-d");
            $output = $data = array();
            $from = "";

            if ($stype == "non-customer") {
                $items = Sale::whereDate('updated_at', $date)->whereNull('customer_id')->where('shop_id',$shop_id)->where('status','sold')->where('company_id',Auth::user()->company_id)->where('id','>',$lastid)->orderBy('updated_at')->limit(15)->get();
            } else {
                $items = Sale::whereDate('updated_at', $date)->where('shop_id',$shop_id)->where('status','sold')->where('company_id',Auth::user()->company_id)->where('id','>',$lastid)->orderBy('updated_at')->limit(15)->get();
            }
            $data['last_l_r'] = Sale::whereDate('updated_at', $date)->where('shop_id',$shop_id)->where('status','sold')->where('company_id',Auth::user()->company_id)->where('id','>',$lastid)->orderBy('id','desc')->first();   
            $i = Sale::whereDate('updated_at', $date)->whereNull('customer_id')->where('shop_id',$shop_id)->where('status','sold')->where('company_id',Auth::user()->company_id)->where('id','<=',$lastid)->count('id');
            $i = $i + 1;
            if ($items->isNotEmpty()) {
                foreach ($items as $value) {
                    if ($from == 'business-owner') {
                        $tr = '<td>'.$value->shop->name.'</td>';
                    } else {
                        if(Auth::user()->isCEOorAdmin()) {
                            $tr = '<span class="p-1 pull-right text-danger edit-sr" val="'.$value->id.'" style="cursor: pointer;"><i class="fa fa-pencil-square-o" style="font-size:1.5rem;"></i></span>';
                        } else {
                            if ($date == $today && Auth::user()->id == $value->user_id) {
                                $tr = '<span class="p-1 pull-right text-danger edit-sr" val="'.$value->id.'" style="cursor: pointer;"><i class="fa fa-pencil-square-o" style="font-size:1.5rem;"></i></span>';
                            } else { 
                                $tr = '';                  
                            }
                        }
                    }

                    $data['last_r'] = $value->id;
                    $output[] = '<tr class="sr-'.$value->id.'"><td><div class="row py-1">'
                    .'<div class="col-12 r-name">'.$i.'). '.$value->product->name.''.$tr.'</div>'
                    .'<div class="col-12" style="font-size:1rem" align="right"> <span>'.sprintf('%g',$value->quantity).'</span> <span><i class="fa fa-times"></i></span> <span>'.str_replace(".00", "", number_format($value->selling_price, 2)).'</span> <span>=</span><span><b>'.str_replace(".00", "", number_format($value->sub_total, 2)).'</b></span></div>'
                    .'</div></td></tr>';
                    $i++;
                }    

            } 
            return response()->json(['items'=>$output,'data'=>$data]);
        }
        
        if ($check == "load-more-lb") {            
            $condition = explode('~', $conditions);
            $lastid = $condition[0];
            $sdate = $condition[1];
            $stype = $condition[2];
            $shop_id = $condition[3];
            $user_id = $condition[4];
            $date = date("Y-m-d", strtotime($sdate));
            $today = date("Y-m-d");
            $output = $data = array();
            $from = "";

            $items = Sale::whereDate('updated_at', $date)->where('shop_id',$shop_id)->where('user_id',$user_id)->where('status','sold')->where('company_id',Auth::user()->company_id)->where('id','>',$lastid)->orderBy('updated_at')->limit(15)->get();
            
            $data['last_l_r'] = Sale::whereDate('updated_at', $date)->where('shop_id',$shop_id)->where('user_id',$user_id)->where('status','sold')->where('company_id',Auth::user()->company_id)->where('id','>',$lastid)->orderBy('id','desc')->first();   
            $i = Sale::whereDate('updated_at', $date)->where('shop_id',$shop_id)->where('user_id',$user_id)->where('status','sold')->where('company_id',Auth::user()->company_id)->where('id','<=',$lastid)->count('id');
            $last = $i = $i + 1;
            if ($items->isNotEmpty()) {
                foreach ($items as $value) {
                    if ($date == $today && Auth::user()->id == $value->user_id) {
                        $tr = '<span class="p-1 pull-right text-danger edit-sr" val="'.$value->id.'" style="cursor: pointer;"><i class="fa fa-pencil-square-o" style="font-size:1.5rem;"></i></span>';
                    } else { 
                        $tr = '';                  
                    }

                    $last = $value->id;
                    $output[] = '<tr style="display:block" class="sr-'.$value->id.'"><td style="display:block"><div class="row py-1">'
                    .'<div class="col-12 r-name">'.$i.'). '.$value->product->name.''.$tr.'</div>'
                    .'<div class="col-12" style="font-size:1rem" align="right"> <span>'.sprintf('%g',$value->quantity).'</span> <span><i class="fa fa-times"></i></span> <span>'.str_replace(".00", "", number_format($value->selling_price, 2)).'</span> <span>=</span><span><b>'.str_replace(".00", "", number_format($value->sub_total, 2)).'</b></span></div>'
                    .'</div></td></tr>';
                    $i++;
                }    

                if($last < $data['last_l_r']->id) {
                    $output[] = '<tr style="display:block" class="show-lb-'.$user_id.'"><td style="display:block" align="center" class="pt-3 pb-4"><button class="btn btn-outline-info load-more-lb" uid="'.$user_id.'" last="'.$last.'">Show more</button></td></tr>';
                }
            } 
            return response()->json(['items'=>$output,'data'=>$data]);
        }

        if ($check == "return-sold-items") {
            $shop_id = $conditions;            
            $products = Product::query()->select([
                DB::raw("products.id as pid, products.name as pname, shop_products.quantity as quantity, products.retail_price as rprice")
            ])
            ->join('shop_products','shop_products.product_id','products.id')
            ->where('products.status','published')->where('products.company_id',Auth::user()->company_id)
            ->where('shop_products.shop_id',$shop_id)->where('shop_products.active','yes')->get();

            return response()->json(['products'=>$products]);
        }
        
        // if ($check == "customer-sales") {            
        //     $condition = explode('~', $conditions);
        //     $customer_id = $condition[0];
        //     $sdate = $condition[1];
        //     $shop_id = $condition[2];
        //     $date = date("Y-m-d", strtotime($sdate));
        //     $today = date("Y-m-d");
        //     $output = $data = array();
        //     $i = 1;

        //     $items2 = Sale::whereDate('updated_at', $date)->where('customer_id',$customer_id)->where('shop_id',$shop_id)->where('status','sold')->where('company_id',Auth::user()->company_id)->orderBy('updated_at')->get();
        //     if ($items2->isNotEmpty()) {
        //         foreach ($items2 as $value) {
        //             if ($date == $today && Auth::user()->id == $value->user_id) {
        //                 $tr = '<span class="p-1 pull-right text-danger edit-sr" val="'.$value->id.'" style="cursor: pointer;"><i class="fa fa-pencil-square-o" style="font-size:1.5rem;"></i></span>';
        //             } else { 
        //                 $tr = '';                  
        //             }
    
        //             $output[] = '<tr style="display:block" class="sr-'.$value->id.'"><td style="display:block"><div class="row">'
        //             .'<div class="col-12 r-name">'.$i.'). '.$value->product->name.''.$tr.'</div>'
        //             .'<div class="col-12" style="font-size:1rem" align="right"> <span>'.sprintf('%g',$value->quantity).'</span> <span><i class="fa fa-times"></i></span> <span>'.str_replace(".00", "", number_format($value->selling_price, 2)).'</span> <span>=</span><span><b>'.str_replace(".00", "", number_format($value->sub_total, 2)).'</b></span></div>'
        //             .'</div></td></tr>';
        //             $i++;
        //         }    
    
        //     } else {
        //         $output[] = '<tr><td colspan="6" align="center"><i>-- No Sales --</i></td></tr>';
        //     }
        //     return response()->json(['items'=>$output,'data'=>$data]);
        // }
        
        // if ($check == "sellers-sales") {            
        //     $condition = explode('~', $conditions);
        //     $user_id = $condition[0];
        //     $sdate = $condition[1];
        //     $shop_id = $condition[2];
        //     $date = date("Y-m-d", strtotime($sdate));
        //     $today = date("Y-m-d");
        //     $output = $data = array();
        //     $i = 1;

        //     $items2 = Sale::whereDate('updated_at', $date)->where('user_id',$user_id)->where('shop_id',$shop_id)->where('status','sold')->where('company_id',Auth::user()->company_id)->orderBy('updated_at')->limit(15)->get();
        //     if ($items2->isNotEmpty()) {
        //         $last = 0;
        //         $data['last_l_r'] = Sale::whereDate('updated_at', $date)->where('user_id',$user_id)->where('shop_id',$shop_id)->where('status','sold')->where('company_id',Auth::user()->company_id)->orderBy('id','desc')->first(); 
        //         foreach ($items2 as $value) {
        //             if ($date == $today && Auth::user()->id == $value->user_id) {
        //                 $tr = '<span class="p-1 pull-right text-danger edit-sr" val="'.$value->id.'" style="cursor: pointer;"><i class="fa fa-pencil-square-o" style="font-size:1.5rem;"></i></span>';
        //             } else { 
        //                 $tr = '';                  
        //             }
    
        //             $last = $value->id;
        //             $output[] = '<tr style="display:block" class="sr-'.$value->id.'"><td style="display:block"><div class="row">'
        //             .'<div class="col-12 r-name">'.$i.'). '.$value->product->name.''.$tr.'</div>'
        //             .'<div class="col-12" style="font-size:1rem" align="right"> <span>'.sprintf('%g',$value->quantity).'</span> <span><i class="fa fa-times"></i></span> <span>'.str_replace(".00", "", number_format($value->selling_price, 2)).'</span> <span>=</span><span><b>'.str_replace(".00", "", number_format($value->sub_total, 2)).'</b></span></div>'
        //             .'</div></td></tr>';
        //             $i++;
        //         }    

        //         if($last < $data['last_l_r']->id) {
        //             $output[] = '<tr style="display:block" class="show-lb-'.$user_id.'"><td style="display:block" align="center" class="pt-3 pb-4"><button class="btn btn-outline-info load-more-lb" uid="'.$user_id.'" last="'.$last.'">Show more</button></td></tr>';
        //         }
    
        //     } else {
        //         $output[] = '<tr><td colspan="6" align="center"><i>-- No Sales --</i></td></tr>';
        //     }
        //     return response()->json(['items'=>$output,'data'=>$data]);
        // }
        
        // if ($check == "sales-saleno") {            
        //     $condition = explode('~', $conditions);
        //     $sno = $condition[0];
        //     $sdate = $condition[1];
        //     $shop_id = $condition[2];
        //     $date = date("Y-m-d", strtotime($sdate));
        //     $today = date("Y-m-d");
        //     $output = $data = array();
        //     $i = 1;

        //     $items2 = Sale::whereDate('updated_at', $date)->where('sale_no',$sno)->where('shop_id',$shop_id)->where('status','sold')->where('company_id',Auth::user()->company_id)->orderBy('updated_at')->get();
        //     if ($items2->isNotEmpty()) {
        //         foreach ($items2 as $value) {
        //             if (Auth::user()->isCEOorAdmin()) {
        //                 $tr = '<span class="p-1 pull-right text-danger edit-sr" val="'.$value->id.'" style="cursor: pointer;"><i class="fa fa-pencil-square-o" style="font-size:1.5rem;"></i></span>';
        //             } else {
        //                 if ($date == $today && Auth::user()->id == $value->user_id) { 
        //                     $tr = '<span class="p-1 pull-right text-danger edit-sr" val="'.$value->id.'" style="cursor: pointer;"><i class="fa fa-pencil-square-o" style="font-size:1.5rem;"></i></span>';
        //                 } else { 
        //                     $tr = '';                  
        //                 }
        //             }
    
        //             $output[] = '<tr style="display:block" class="sr-'.$value->id.'"><td style="display:block"><div class="row">'
        //             .'<div class="col-12 r-name">'.$i.'). '.$value->product->name.''.$tr.'</div>'
        //             .'<div class="col-12" style="font-size:1rem" align="right"> <span>'.sprintf('%g',$value->quantity).'</span> <span><i class="fa fa-times"></i></span> <span>'.str_replace(".00", "", number_format($value->selling_price, 2)).'</span> <span>=</span><span><b>'.str_replace(".00", "", number_format($value->sub_total, 2)).'</b></span></div>'
        //             .'</div></td></tr>';
        //             $i++;
        //         }    

    
        //     } else {
        //         $output[] = '<tr><td colspan="6" align="center"><i>-- No Sales --</i></td></tr>';
        //     }
        //     return response()->json(['items'=>$output,'data'=>$data]);
        // }

        // if ($check == "buying-cost") {
        //     $sales = Sale::where('id','>=',1)->where('id','<',1000)->get();
        //     foreach ($sales as $value) {
        //         $created_at = $value->created_at;
        //         Sale::where('id',$value->id)->update(['updated_at'=>$created_at]);
        //     }
        //     return response()->json(['output'=>'done']); 
        // }

        // if ($check == "buying-cost") {
        //     $sales = Sale::where('id','>=',1)->where('id','<',1000)->get();
        //     foreach ($sales as $value) {
        //         $q = $value->quantity;
        //         $bp = $value->buying_price;
        //         $tbp = ($q * $bp);
        //         Sale::where('id',$value->id)->update(['total_buying'=>$tbp]);
        //     }
        //     return response()->json(['output'=>'done']);
        // }

        if ($check == "currencies") {
            if ($conditions == "all") {
                $currencies = Currency::orderBy('name')->get();
                if ($currencies->isNotEmpty()) {
                    foreach($currencies as $currency) {
                        $output[] = "<tr><td>".$currency->name." - ".$currency->code."</td><td class='align-right'><i class='fa fa-arrow-right'></i></td></tr>";
                    }
                }
                return response()->json(['output'=>$output]);
            }
        }
        
        if ($check == "settings") {
            if ($conditions == "all") {
                $settings = \App\Setting::all();
                if ($settings->isNotEmpty()) {
                    foreach($settings as $setting) {
                        $output[] = "<tr><td>".$setting->name."</td><td>".$setting->description."</td></tr>";
                    }
                }
                return response()->json(['output'=>$output]);
            }
        }

        if($check == "daily-sales") { // this is not used anymore
            if ($conditions == "test") {
                $yesterday = date("Y-m-d", time() - 60 * 60 * 24);
                $fromdate = date("Y-m-d 00:00:00", strtotime($yesterday));
                $todate = date("Y-m-d 23:59:59", strtotime($yesterday));
                $accounts = \App\Company::whereIn('status',['active','free trial'])->where('id',2)->get();
                foreach($accounts as $account) {
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
                return response()->json(['output'=>'done']);
            }
        }
        
        if ($check == "send-sms") {
            if ($conditions == "yesterday-report") {
                $api_key='shariff';
                $secret_key = 'ShariffPOS@91';

                $accounts = \App\Company::whereIn('status',['active','free trial'])->where('id',2)->get();
                $yesterday = date("Y-m-d", time() - 60 * 60 * 24);
                $yesterday_2 = date("d.m.Y", time() - 60 * 60 * 24);
                $output = array();
                foreach($accounts as $account) {
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
                                        echo $response;
                
                                    die(curl_error($ch));
                                }
                                $output[] = $response;
                                
                            } else {
                                $output[] = 'no data';
                            }  
                        }       
                    }            
                }
                // var_dump($response);
                return response()->json(['output'=>$output]);
            }    

            if($conditions == "yearly-report") {
                if (date('d') == 1 && date('m') == 1) { // this is first date of January
                    $lastyear = date("Y",strtotime("-1 year"));
                    $from = $lastyear."-1-1";
                    $fromdate = date("Y-m-d 00:00:00", strtotime($from));
            
                    $todate = \Carbon\Carbon::yesterday()->toDateString();
                    $todate = date("Y-m-d 23:59:59", strtotime($todate));
                    
                    $fdate = date("d/m/Y", strtotime($fromdate));
                    $tdate = date("d/m/Y", strtotime($todate));
                    $from_to = $fdate.' to '.$tdate;        
                    
                    $accounts = \App\Company::where('id',1)->get();
                    foreach($accounts as $account) {
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
                    // return true;
                    return response()->json(['output'=>'success']);
                }
            }        
        }

        if($check == "count-orders") {
            $sid = $conditions; 
            $total_o = Sale::where('shop_id',$sid)->where('company_id',Auth::user()->company_id)->where('status','order')->groupBy('sale_no')->get()->count();
            return response()->json(['total'=>$total_o]);
        }

        if ($check == "today-total-sales") {
            $sid = $conditions;
            $date = date("Y-m-d");
            $total = Sale::query()->select([
                    DB::raw('SUM(sub_total) as totalS')
                ])
                ->whereDate('updated_at', $date)->where('shop_id',$sid)->where('status','sold')
                ->get(); 
            
            return response()->json(['total'=>$total]);
        }
        
        if ($check == "account-shops") {
            $account_id = $conditions; 
            $data['shops'] = Shop::where('company_id',$account_id)->get();
            $view = view('admin.tables.shops', compact('data'))->render();
            return response()->json(['shops'=>$view]);
        }
        
        if ($check == "account-stores") {
            $account_id = $conditions; 
            $data['stores'] = Store::where('company_id',$account_id)->get();
            $view = view('admin.tables.stores', compact('data'))->render();
            return response()->json(['stores'=>$view]);
        }

        if ($check == "measurements") {
            $data['measurements'] = Measurement::where('company_id',Auth::user()->company_id)->get();
            $view = view('partials.measurements', compact('data'))->render();
            return response()->json(['measurements'=>$view]);
        }

        if($check == "this-month-sales") {
            $sid = $conditions;            
            $month_price = Sale::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->where('shop_id',$sid)->where('status','sold')->sum('sub_total');
            $quantity = Sale::where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->where('shop_id',$sid)->where('status','sold')->sum('quantity');
            $expenses = ShopExpense::where('company_id',Auth::user()->company_id)->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->where('shop_id',$sid)->sum('amount');
            $data['month_price'] = number_format($month_price);
            $data['month_quantity'] = $quantity + 0;
            $data['month_expenses'] = number_format($expenses);
            return response()->json(['data'=>$data]);
        }

        if ($check == "p-categories") {
            // $data['groups'] = ProductCategoryGroup::where('company_id',Auth::user()->company_id)->get(); // mwanzo nilikua nachukua category groups ili nidisplay sub-cats basing on cat-group, now sub-cats zote nataka ziwe under main cat group
            $data['main-cat'] = ProductCategoryGroup::where('company_id',Auth::user()->company_id)->where('name','main')->first();
            $data['ten-cats'] = ProductCategory::where('status','!=','deleted')->orWhereNull('status')->where('company_id',Auth::user()->company_id)->orderBy('name')->limit(10)->get();
            $data['cats'] = ProductCategory::where('status','!=','deleted')->orWhereNull('status')->where('company_id',Auth::user()->company_id)->orderBy('name')->get();
            $data['counts'] = count($data['cats']);
            if($data['main-cat']) { } else {
                $create = ProductCategoryGroup::create(['name'=>'main','company_id'=>Auth::user()->company_id,'user_id'=>Auth::user()->id]);
                if($create) {
                    $data['main-cat'] = ProductCategoryGroup::find($create->id);
                }
            }
            $view = view('partials.p-categories',compact('data'))->render();
            return response()->json(['pcategories'=>$view]);
        }
        
        if ($check == "view-more-cats") {
            $cats = ProductCategory::where('status','!=','deleted')->orWhereNull('status')->where('company_id',Auth::user()->company_id)->orderBy('name')->get();
            $data = array();
            $num = 1;
            foreach($cats as $cat) {
                $data[] = '<div class="col-6 mb-1 cats-ss"><div class="row c-outer"><div class="col-9 c-name-outer"><div class="c-name"><b>'.$num.'.</b> '.$cat->name.'</div></div> <div class="col-3 c-action"><span class="edit-pcategory-btn" valid="'.$cat->id.'"><i class="icon-pencil"></i></span> <span class="delete-p-category" val="'.$cat->id.'" name="'.$cat->name.'" gid="'.$cat->product_category_group_id.'"><i class="fa fa-times"></i></span></div></div></div>';
                $num++;
            }
            $data[] = '<div class="col-12"><button class="btn btn-outline-info btn-sm done-edit mt-2">Show less</button></div>';
            return response()->json(['cats'=>$data]);
        }
        
        if ($check == "count-account-p-cats") {
            $account_id = $conditions; 
            $total = ProductCategoryGroup::where('company_id',$account_id)->count();
            return response()->json(['total'=>$total]);
        }

        if ($check == "p-categories-form") {
            $data['category'] = ProductCategory::find($conditions); //conditions === category_id
            $view = view('partials.p-categories-edit-form',compact('data'))->render();
            return response()->json(['p_categories_form'=>$view]);
        }

        if ($check == "products") {
            $data['ten-products'] = Product::where('status','!=','deleted')->where('company_id',Auth::user()->company_id)->orderBy('name')->limit(10)->get();
            $data['products'] = Product::where('status','!=','deleted')->where('company_id',Auth::user()->company_id)->orderBy('name')->get();
            $data['counts'] = count($data['products']);
            $view = view('tables.products',compact('data'))->render();
            return response()->json(['products'=>$view]);
        }
        
        if ($check == "products-2") {
            $data['from'] = $conditions;
            if($conditions == 'all') {
                $data['shopstore'] = $conditions;
                $data['ten-products'] = Product::where('status','!=','deleted')->where('company_id',Auth::user()->company_id)->orderBy('name')->limit(10)->get();
                $data['products'] = Product::where('status','!=','deleted')->where('company_id',Auth::user()->company_id)->orderBy('name')->get();
                $data['counts'] = count($data['products']);
                
                $data['totalQty'] = \DB::connection('tenant')->table('shop_products')->join('shops','shops.id','shop_products.shop_id')->where('shops.company_id',Auth::user()->company_id)->where('shop_products.active','yes')->sum('quantity');
                $data['totalQty2'] = \DB::connection('tenant')->table('store_products')->join('stores','stores.id','store_products.store_id')->where('stores.company_id',Auth::user()->company_id)->where('store_products.active','yes')->sum('quantity');
                $totalQty = $data['totalQty'] + $data['totalQty2'];
    
                $view = view('tables.products',compact('data'))->render();
                return response()->json(['products'=>$view, 'totalQty'=>$totalQty]);
            } else {            
                $shopstore = explode('-', $conditions);
                $data['shopstore'] = $shopstore[0];
                if ($shopstore[0] == "shop") {
                    $shop_id = $shopstore[1];
                    $data['shop'] = Shop::where('id',$shop_id)->where('company_id',Auth::user()->company_id)->first();
                    $totalQty = \DB::connection('tenant')->table('shop_products')->where('shop_id',$shop_id)->where('active','yes')->sum('quantity');
                    // products
                    $data['ten-products'] = $data['shop']->products()->orderBy('products.name')->limit(10)->get();
                    $data['products'] = $data['shop']->products()->orderBy('products.name')->get();
                    $data['counts'] = count($data['products']);
                    
                    $view = view('tables.products',compact('data'))->render();
                    return response()->json(['products'=>$view, 'totalQty'=>$totalQty]);
                }
                if ($shopstore[0] == "store") {
                    $store_id = $shopstore[1];
                    $data['store'] = Store::where('id',$store_id)->where('company_id',Auth::user()->company_id)->first();
                    $totalQty = \DB::connection('tenant')->table('store_products')->where('store_id',$store_id)->where('active','yes')->sum('quantity');
                    // products
                    $data['ten-products'] = $data['store']->products()->orderBy('products.name')->limit(10)->get();
                    $data['products'] = $data['store']->products()->orderBy('products.name')->get();
                    $data['counts'] = count($data['products']);
                    
                    $view = view('tables.products',compact('data'))->render();
                    return response()->json(['products'=>$view, 'totalQty'=>$totalQty]);
                }
            }
        }
        
        if ($check == "view-more-products") {
            if($conditions == 'all') {
                $products = Product::where('status','!=','deleted')->where('company_id',Auth::user()->company_id)->orderBy('name')->get();
                $data = array();
                $num = 1;
                foreach($products as $value) {
                    if($value->image) {
                        $src = "/images/companies/".Auth::user()->company->folder."/products/". $value->image; 
                    } else {
                        $src = "/images/product.jpg"; 
                    }
                    if ($value->productcategory) {
                        $cat_n = "(".$value->productcategory->name.")";
                    } else {
                        $cat_n = "";
                    }
                    $quantity = app(\App\Http\Controllers\ProductController::class)->totalQuantity($value->id);
                    $data[] = '<tr class="pr-'.$value->id.'">'.
                                '<td class="first-td"><span class="outer-span"><img src="'. $src .'" class="avatar mr-2" alt=""> <span> <a href="/products?opt=preview-product&pid='.$value->id.'"> <svg class="w-6 h-6 text-gray-800 dark:text-white" style="width:15px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"> <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/> </svg> '.$value->name.'</a> <br> <small>'.$cat_n.'</small> </span></span></td>'. 
                                '<td><small>Ya kununulia: </small>'.str_replace(".00", "", number_format($value->buying_price, 2)).' <br> <small>Ya kuuzia: </small>'.str_replace(".00", "", number_format($value->retail_price, 2)).'</td>'.
                                '<td>'.$quantity.'</td>'.
                                '<td class="last-td"><a href="/products?opt=edit-product&pid='. $value->id .'" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a> <a href="#" class="btn btn-danger btn-sm deleteProduct" val="'.$value->id.'" name="'.$value->name.'"><i class="fa fa-times"></i></a></td>'.
                              '</tr>';
                    $num++;
                }
                $data[] = '<tr><td colspan="4"><button class="btn btn-outline-info btn-sm products-tab mt-2">Show less</button></td></tr>';
                return response()->json(['products'=>$data]);
            } else {
                $shopstore = explode('-', $conditions);
                $data['shopstore'] = $shopstore[0];
                if ($shopstore[0] == "shop") {
                    $shop_id = $shopstore[1];
                    $data['shop'] = Shop::where('id',$shop_id)->where('company_id',Auth::user()->company_id)->first();
                    $products = $data['shop']->products()->orderBy('products.name')->get();
                    $data = array();
                    $num = 1;
                    foreach($products as $value) {
                        if($value->image) {
                            $src = "/images/companies/".Auth::user()->company->folder."/products/". $value->image; 
                        } else {
                            $src = "/images/product.jpg"; 
                        }
                        if ($value->productcategory) {
                            $cat_n = "(".$value->productcategory->name.")";
                        } else {
                            $cat_n = "";
                        }
                        // $quantity = app(\App\Http\Controllers\ProductController::class)->totalQuantity($value->id);
                        $quantity = sprintf('%g',$value->shopProductRelation($shop_id)->quantity);
                        $data[] = '<tr class="pr-'.$value->id.'">'.
                        '<td class="first-td"><span class="outer-span"><img src="'. $src .'" class="avatar mr-2" alt=""> <span> <a href="/products?opt=preview-product&pid='.$value->id.'"> <svg class="w-6 h-6 text-gray-800 dark:text-white" style="width:15px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"> <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/> </svg> '.$value->name.'</a> <br> <small>'.$cat_n.'</small> </span></span></td>'. 
                                    '<td><small>Ya kununulia: </small>'.str_replace(".00", "", number_format($value->buying_price, 2)).' <br> <small>Ya kuuzia: </small>'.str_replace(".00", "", number_format($value->retail_price, 2)).'</td>'.
                                    '<td>'.$quantity.'</td>'.
                                    '<td class="last-td"><a href="/products?opt=edit-product&pid='. $value->id .'" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a> <a href="#" class="btn btn-danger btn-sm deleteProduct" val="'.$value->id.'" name="'.$value->name.'"><i class="fa fa-times"></i></a></td>'.
                                  '</tr>';
                        $num++;
                    }
                    $data[] = '<tr><td colspan="4"><button class="btn btn-outline-info btn-sm products-tab mt-2">Show less</button></td></tr>';
                    return response()->json(['products'=>$data]);
                }
                if ($shopstore[0] == "store") {
                    $store_id = $shopstore[1];
                    $data['store'] = Store::where('id',$store_id)->where('company_id',Auth::user()->company_id)->first();
                    $products = $data['store']->products()->orderBy('products.name')->get();
                    $data = array();
                    $num = 1;
                    foreach($products as $value) {
                        if($value->image) {
                            $src = "/images/companies/".Auth::user()->company->folder."/products/". $value->image; 
                        } else {
                            $src = "/images/product.jpg"; 
                        }
                        if ($value->productcategory) {
                            $cat_n = "(".$value->productcategory->name.")";
                        } else {
                            $cat_n = "";
                        }
                        // $quantity = app(\App\Http\Controllers\ProductController::class)->totalQuantity($value->id);
                        $quantity = sprintf('%g',$value->storeProductRelation($store_id)->quantity);
                        $data[] = '<tr class="pr-'.$value->id.'">'.
                        '<td class="first-td"><span class="outer-span"><img src="'. $src .'" class="avatar mr-2" alt=""> <span> <a href="/products?opt=preview-product&pid='.$value->id.'"> <svg class="w-6 h-6 text-gray-800 dark:text-white" style="width:15px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"> <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/> </svg> '.$value->name.'</a> <br> <small>'.$cat_n.'</small> </span></span></td>'. 
                                    '<td><small>Ya kununulia: </small>'.str_replace(".00", "", number_format($value->buying_price, 2)).' <br> <small>Ya kuuzia: </small>'.str_replace(".00", "", number_format($value->retail_price, 2)).'</td>'.
                                    '<td>'.$quantity.'</td>'.
                                    '<td class="last-td"><a href="/products?opt=edit-product&pid='. $value->id .'" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a> <a href="#" class="btn btn-danger btn-sm deleteProduct" val="'.$value->id.'" name="'.$value->name.'"><i class="fa fa-times"></i></a></td>'.
                                  '</tr>';
                        $num++;
                    }
                    $data[] = '<tr><td colspan="4"><button class="btn btn-outline-info btn-sm products-tab mt-2">Show less</button></td></tr>';
                    return response()->json(['products'=>$data]);
                }
            }
        }
        
        if ($check == "count-account-products") {
            $account_id = $conditions; 
            $total = Product::where('status','!=','deleted')->where('company_id',$account_id)->count();
            return response()->json(['total'=>$total]);
        }
        
        if ($check == "count-account-customers") {
            $account_id = $conditions; 
            $total = Customer::where('status','!=','deleted')->where('company_id',$account_id)->count();
            return response()->json(['total'=>$total]);
        }

        if ($check == 'user-roles') {
            $user_id = $conditions;
            $user = User::find($user_id);
            $uroles = $user->roles;
            return response()->json(['roles'=>$uroles]);
        }
        
        if($check == "update-payments-test") {
            $companies = \App\Company::where('status','free trial')->get();
            $today = date('Y-m-d');
            if($companies->isNotEmpty()) {
                foreach($companies as $company) {
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

        if ($check == "shops-stores-payments") {
            $account_id = $conditions; 
            $data['account'] = Company::find($account_id);
            $data['shops'] = Shop::where('company_id',$account_id)->get();
            $data['stores'] = Store::where('company_id',$account_id)->get();
            $view = view('admin.partials.shops-stores-payments', compact('data'))->render();
            return response()->json(['view'=>$view]);
        }
        
        if ($check == "company-prev-payments") {
            $account_id = $conditions; 
            $data['payments'] = \App\Payment::where('company_id',$account_id)->orderBy('id','desc')->get();
            $view = view('tables.company-prev-payments', compact('data'))->render();
            return response()->json(['view'=>$view]);
        }

        if ($check == "sms-report-data") {
            $account_id = $conditions; 
            $data = array();
            $data['shops'] = \App\Shop::query()->select([
                    DB::raw('id, name')
                ])
                ->where('company_id',$account_id)->orderBy('name')->get();
            $data['bowners'] = \App\User::query()->select([
                    DB::raw('users.id as uid, users.username as uname')
                ])
                ->join('user_roles','user_roles.user_id','users.id')
                ->where('user_roles.role_id',2)->where('users.company_id',$account_id)->where('users.status','active')
                ->get();
            
            return response()->json(['data'=>$data]);
        }
        // end company/account details 
        
        if ($check == "account-last-activity") {
            $cid = $conditions; 
            $last_activity = "-";
            $l_c_debt = $l_sales = $l_expenses = $l_n_stock = $l_s_adjust = $l_transfers = null;
            $today = date('Y-m-d');
            $company = \App\Company::find($cid);
            if($company) {
                $since_company_created = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($company->created_at))))->days;
                $customer_debt = CustomerDebt::where('company_id',$company->id)->orderBy('id','desc')->first();
                if($customer_debt) {
                    $l_c_debt = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($customer_debt->updated_at))))->days;
                }
                $sales_record = Sale::where('company_id',$company->id)->orderBy('id','desc')->first();
                if($sales_record) {
                    $l_sales = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($sales_record->updated_at))))->days;
                }
                $expenses = ShopExpense::where('company_id',$company->id)->orderBy('id','desc')->first();
                if($expenses) {
                    $l_expenses = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($expenses->updated_at))))->days;
                }
                $new_stock = NewStock::where('company_id',$company->id)->orderBy('id','desc')->first();
                if($new_stock) {
                    $l_n_stock = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($new_stock->updated_at))))->days;
                }
                $stock_adjustment = StockAdjustment::where('company_id',$company->id)->orderBy('id','desc')->first();
                if($stock_adjustment) {
                    $l_s_adjust = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($stock_adjustment->updated_at))))->days;
                }
                $transfers = Transfer::where('company_id',$company->id)->orderBy('id','desc')->first();
                if($transfers) {
                    $l_transfers = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($transfers->updated_at))))->days;
                }
                if($l_c_debt == null && $l_sales == null && $l_expenses == null && $l_n_stock == null && $l_s_adjust == null && $l_transfers == null) {
                    $last_activity = $since_company_created." days ago <br> <small> (account created) </small>";
                } else {
                    $arr = array( 'Customer debt'=>$l_c_debt, 'Sale product'=>$l_sales, 'Expenses'=>$l_expenses, 'New stock'=>$l_n_stock, 'Stock adjustment'=>$l_s_adjust, 'Transfer items'=>$l_transfers);
                    $arr = array_filter($arr,'strlen'); // remove empty values
                    asort($arr);
                    $a_v = array_values($arr)[0];
                    $a_k = array_keys($arr)[0];
                    $last_activity = $a_v." days ago <br> <small>(".$a_k.")</small>";
                }     

            }
            return response()->json(['cid'=>$cid, 'last_activity'=>$last_activity]);
        }

        if ($check == "shop-last-activity") {
            $last_activity = "-";
            $l_c_debt = $l_sales = $l_expenses = $l_n_stock = $l_s_adjust = $l_transfers = $l_r_transfers = null;
            $shop_id = $conditions; 
            $today = date('Y-m-d');
            $shop = Shop::find($shop_id);
            if($shop) {
                $since_shop_created = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($shop->created_at))))->days;
                $customer_debt = CustomerDebt::where('shop_id',$shop->id)->orderBy('id','desc')->first();
                if($customer_debt) {
                    $l_c_debt = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($customer_debt->updated_at))))->days;
                }
                $sales_record = Sale::where('shop_id',$shop->id)->orderBy('id','desc')->first();
                if($sales_record) {
                    $l_sales = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($sales_record->updated_at))))->days;
                }
                $expenses = ShopExpense::where('shop_id',$shop->id)->orderBy('id','desc')->first();
                if($expenses) {
                    $l_expenses = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($expenses->updated_at))))->days;
                }
                $new_stock = NewStock::where('shop_id',$shop->id)->orderBy('id','desc')->first();
                if($new_stock) {
                    $l_n_stock = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($new_stock->updated_at))))->days;
                }
                $stock_adjustment = StockAdjustment::where('from','shop')->where('from_id',$shop->id)->orderBy('id','desc')->first();
                if($stock_adjustment) {
                    $l_s_adjust = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($stock_adjustment->updated_at))))->days;
                }
                $transfers = Transfer::where('from','shop')->where('from_id',$shop->id)->orderBy('id','desc')->first();
                if($transfers) {
                    $l_transfers = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($transfers->updated_at))))->days;
                }
                $r_transfers = Transfer::where('destination','shop')->where('destination_id',$shop->id)->where('status','received')->orderBy('id','desc')->first();
                if($r_transfers) {
                    $l_r_transfers = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($r_transfers->updated_at))))->days;
                }
                if($l_c_debt == null && $l_sales == null && $l_expenses == null && $l_n_stock == null && $l_s_adjust == null && $l_transfers == null && $l_r_transfers == null) {
                    $last_activity = $since_shop_created." days ago <br> <small> (shop created) </small>";
                } else {
                    $arr = array( 'Customer debt'=>$l_c_debt, 'Sale product'=>$l_sales, 'Expenses'=>$l_expenses, 'New stock'=>$l_n_stock, 'Stock adjustment'=>$l_s_adjust, 'Transfer items'=>$l_transfers, 'Received transfer'=>$l_r_transfers);
                    $arr = array_filter($arr,'strlen'); // remove empty values
                    asort($arr);
                    $a_v = array_values($arr)[0];
                    $a_k = array_keys($arr)[0];
                    $last_activity = $a_v." days ago <br> <small>(".$a_k.")</small>";
                }               
                
                // check payment status 
                $payment_status = "--";
                $payment = \App\PaymentsDesc::where('paid_for','shop')->where('paid_item',$shop->id)->orderBy('id','desc')->first();
                if ($payment) {
                    $e_days = (new DateTime($payment->expire_date))->diff(new DateTime(date('Y-m-d',strtotime($today))))->days;
                    $edate = new DateTime($payment->expire_date);
                    if($today > $payment->expire_date) {
                        $payment_status = "<span class='badge badge-danger'>Expired</span> <br> ".$edate->format('d/m/Y');
                    } else {
                        if($e_days <= 10) {
                            $payment_status = "<span class='badge badge-warning'>About to expire</span> <br> ".$edate->format('d/m/Y');
                        } else {
                            $payment_status = "<span class='badge badge-success'>Active</span> <br> ".$edate->format('d/m/Y');
                        }     
                    }               
                } else {
                    $est_date = date('Y-m-d', strtotime($shop->created_at . ' +30 day'));
                    if ($today > $est_date) { //expired 
                        if ($shop->status) { } else { // null status means free trial 
                            $payment_status = "<span class='badge badge-danger'>End Free Trial</span>";
                        }
                    } else {
                        if(strlen($shop->reminder) >= 1) {
                            $payment_status = "<span class='badge badge-warning'>".$shop->reminder." days to end Free Trial</span>";
                        } else {
                            $payment_status = "<span class='badge badge-seconday'>Free Trial</span>";
                        }
                    }
                }
            }
            return response()->json(['id'=>$shop_id, 'last_activity'=>$last_activity, 'payment_status'=>$payment_status]);
        }
        
        if ($check == "store-last-activity") {
            $last_activity = "-";
            $l_n_stock = $l_s_adjust = $l_transfers = $l_r_transfers = null;
            $store_id = $conditions; 
            $today = date('Y-m-d');
            $store = Store::find($store_id);
            if($store) {
                $since_store_created = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($store->created_at))))->days;
                $new_stock = NewStock::where('store_id',$store->id)->orderBy('id','desc')->first();
                if($new_stock) {
                    $l_n_stock = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($new_stock->updated_at))))->days;
                }
                $stock_adjustment = StockAdjustment::where('from','store')->where('from_id',$store->id)->orderBy('id','desc')->first();
                if($stock_adjustment) {
                    $l_s_adjust = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($stock_adjustment->updated_at))))->days;
                }
                $transfers = Transfer::where('from','store')->where('from_id',$store->id)->orderBy('id','desc')->first();
                if($transfers) {
                    $l_transfers = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($transfers->updated_at))))->days;
                }
                $r_transfers = Transfer::where('destination','store')->where('destination_id',$store->id)->where('status','received')->orderBy('id','desc')->first();
                if($r_transfers) {
                    $l_r_transfers = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($r_transfers->updated_at))))->days;
                }
                if($l_n_stock == null || $l_s_adjust == null || $l_transfers == null || $l_r_transfers == null) {
                    $last_activity = $since_store_created." days ago <br> <small> (store created) </small>";
                } else {
                    $arr = array( 'New stock'=>$l_n_stock, 'Stock adjustment'=>$l_s_adjust, 'Transfer items'=>$l_transfers, 'Received transfer'=>$l_r_transfers);
                    $arr = array_filter($arr,'strlen'); // remove empty values
                    asort($arr);
                    $a_v = array_values($arr)[0];
                    $a_k = array_keys($arr)[0];
                    $last_activity = $a_v." days ago <br> <small>(".$a_k.")</small>";
                }                
                
                // check payment status 
                $payment_status = "--";
                $payment = \App\PaymentsDesc::where('paid_for','store')->where('paid_item',$store->id)->orderBy('id','desc')->first();
                if ($payment) {
                    $e_days = (new DateTime($payment->expire_date))->diff(new DateTime(date('Y-m-d',strtotime($today))))->days;
                    $edate = new DateTime($payment->expire_date);
                    if($e_days <= 10) {
                        $payment_status = "<span class='badge badge-warning'>About to expire</span> <br> ".$edate->format('d/m/Y');
                    } elseif ($e_days < 0) {
                        $payment_status = "<span class='badge badge-danger'>Expired</span> <br> ".$edate->format('d/m/Y');
                    } elseif ($e_days > 10) {
                        $payment_status = "<span class='badge badge-success'>Active</span> <br> ".$edate->format('d/m/Y');
                    }                    
                } else {
                    $est_date = date('Y-m-d', strtotime($store->created_at . ' +30 day'));
                    if ($today > $est_date) { //expired 
                        if ($fstore->status) { } else { // null status means free trial 
                            $payment_status = "<span class='badge badge-danger'>End Free Trial</span>";
                        }
                    } else {
                        if(strlen($store->reminder) >= 1) {
                            $payment_status = "<span class='badge badge-warning'>".$store->reminder." days to end Free Trial</span>";
                        } else {
                            $payment_status = "<span class='badge badge-seconday'>Free Trial</span>";
                        }
                    }
                }
            }
            return response()->json(['id'=>$store_id, 'last_activity'=>$last_activity, 'payment_status'=>$payment_status]);
        }

        if($check == "not-paid-shops-stores") {
            $company_id = $conditions;
            $output = array();
            // not paid shops
            $shops = Shop::query()->select([
                    DB::raw('shops.name as sname, shops.status as sstatus')
                ])
                ->where('company_id',$company_id)->orderBy('name')
                ->get();

            $stores = Store::query()->select([
                    DB::raw('stores.name as sname, stores.status as sstatus')
                ])
                ->where('company_id',$company_id)->orderBy('name')
                ->get();

            return response()->json(['shops'=>$shops,'stores'=>$stores]);

            // $shops = Shop::where('company_id',Auth::user()->company_id)->get();
            // if ($shops->isNotEmpty()) {
            //     foreach ($shops as $shop) { 
            //         $pay = \App\PaymentsDesc::where('paid_for','shop')->where('paid_item',$shop->id)->orderBy('id','desc')->first();
            //         $today = date('Y-m-d');
            //         if($pay) { 
            //             if($pay->expire_date < $today) {
            //                 $shop->update(['status'=>'not paid']);
            //                 $exdate = new DateTime($pay->expire_date);
            //                 $output[] = "<tr><td>".$shop->name."</td><td>Payment ends since: ".$exdate->format('d/m/Y')."</td></tr>";
            //             }
            //         } else {
            //             $e_date = "";
            //             if($shop->status == null) { //update end of free trial 
            //                 $cdays = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($shop->created_at))))->days;
            //                 if($cdays < 30) {
            //                     $e_date = "Free trial itaisha: ".date('d/m/Y', strtotime($shop->created_at . ' +30 day'));
            //                 } else {
            //                     // $e_date = "Free trial itaisha: ".date('d/m/Y', strtotime($today . ' +3 day'));
            //                     $shop->update(['status'=>'end free trial']);
            //                     $e_date = "Muda wa Free Trial umeisha <br> Tafadhali lipia uendelee kutumia hili duka ";
            //                 }
            //             } else if($shop->status == "end free trial") {
            //                 $e_date = "Muda wa Free Trial umeisha <br> Tafadhali lipia uendelee kutumia hili duka ";
            //             }
            //             $output[] = "<tr><td>".$shop->name."</td><td>".$e_date."</td></tr>";
            //         }                    
            //     }
            // }
            // // not paid stores 
            // $stores = Store::where('company_id',Auth::user()->company_id)->get();
            // if ($stores) {
            //     foreach ($stores as $store) {
            //         $pay = \App\PaymentsDesc::where('paid_for','store')->where('paid_item',$store->id)->orderBy('id','desc')->first();
            //         $today = date('Y-m-d');
            //         if($pay) { 
            //             if($pay->expire_date < $today) {
            //                 $store->update(['status'=>'not paid']);
            //                 $exdate = new DateTime($pay->expire_date);
            //                 $output[] = "<tr><td>".$store->name."</td><td>Payment ends since: ".$exdate->format('d/m/Y')."</td></tr>";
            //             }                        
            //         } else {
            //             $e_date = "";
            //             if($store->status == null) { //update end of free trial
            //                 $cdays = (new DateTime($today))->diff(new DateTime(date('Y-m-d',strtotime($store->created_at))))->days;
            //                 if($cdays < 30) {
            //                     $e_date = "Free trial itaisha: ".date('d/m/Y', strtotime($store->created_at . ' +30 day'));
            //                 } else {
            //                     // $e_date = "Free trial itaisha: ".date('d/m/Y', strtotime($today . ' +3 day'));
            //                     $store->update(['status'=>'end free trial']);
            //                     $e_date = "Muda wa Free Trial umeisha <br> Tafadhali lipia uendelee kutumia hii stoo";
            //                 }
            //             } else if($store->status == "end free trial") {
            //                 $e_date = "Muda wa Free Trial umeisha <br> Tafadhali lipia uendelee kutumia hili duka ";
            //             }
            //             $output[] = "<tr><td>".$store->name."</td><td>".$e_date."</td></tr>";
            //         }                    
            //     }
            // }
            // return response()->json(['output'=>$output]);
        }

        if ($check == "sell-products") {
            if ($conditions == 'null') {
                if(Auth::user()->isCashier()) {
                    $user_shops = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id);
                    if ($user_shops->count() == 1) {
                        $shop_id = $user_shops->first()->shop_id;
                        return response()->json(['status'=>'single-shop','shop'=>$shop_id]);
                    } elseif ($user_shops->count() > 1) {
                        $shops = DB::connection('tenant')->table('user_shops')->join('shops','shops.id','user_shops.shop_id')->where('user_shops.user_id',Auth::user()->id)->get();
                        return response()->json(['status'=>'multi-shops','shops'=>$shops]);
                    } else {

                    }              
                } else {
                    return response()->json(['status'=>'not-cashier']);
                }
            } else {
                $sid = $conditions; // conditions == shop_id
                $shop = Shop::find($sid);
                if ($shop->is_cashier(Auth::user()->id) || $shop->is_saleperson(Auth::user()->id)) {
                    $data['shop'] = Shop::where('id',$sid)->where('company_id',Auth::user()->company_id)->first();
                    $view = view('tabs.sell-products',compact('data'))->render();
                    return response()->json(['view'=>$view]);
                } else {
                    return response()->json(['status'=>'not have access']);
                }
            }
        }
        
        if ($check == "shop-orders") {
            $sid = $conditions; // conditions == shop_id
            $shop = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('shop_id',$sid)->whereIn('who',['cashier','sale person'])->first(); // check cashier
            if ($shop) {
                $data['shop'] = Shop::where('id',$sid)->where('company_id',Auth::user()->company_id)->first();
                $data['who'] = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('shop_id',$sid)->first()->who;
                $view = view('tabs.shop-orders',compact('data'))->render();
                return response()->json(['view'=>$view]);
            } else {
                return response()->json(['status'=>'not have access']);
            }
        }

        if ($check == "sell-products-tab") {
            $ssid = $conditions; // conditions == shop_id and screen size
            $ssid = explode("~",$ssid);
            $sid = $ssid[0];
            $screen = $ssid[1]; 
            $total = 0;
            $customer = "";
            if ($screen == "small") {
                $pcats = null;
                $products = null;
            } else {
                $pcats = ProductCategory::where('company_id',Auth::user()->company_id)->where('status',null)->get();

                // $products = Product::query()->select([
                //     DB::raw('products.id as pid, products.retail_price as pprice, products.name as pname, products.image as pimage, shop_products.quantity as pquantity')
                // ])
                // ->join('sales','sales.product_id','products.id')
                // ->join('shop_products','shop_products.product_id','products.id')
                // ->where('shop_products.shop_id',$sid)
                // ->where('sales.status','sold')->where('shop_products.active','yes')
                // ->groupBy('sales.product_id')->orderBy('sales.id','desc')->limit(12)
                // ->get();

                $products = null;
            }
            $customers = Customer::where('status','active')->where('company_id',Auth::user()->company_id)->where('shop_id',$sid)->orderBy('name')->get();            
            $sh_products = Product::query()->select([
                DB::raw("products.id as pid, products.name as pname, shop_products.quantity as quantity, products.retail_price as rprice, products.image as pimage")
            ])
            ->join('shop_products','shop_products.product_id','products.id')
            ->where('products.status','published')->where('products.company_id',Auth::user()->company_id)
            ->where('shop_products.shop_id',$sid)->where('shop_products.active','yes')->orderBy('products.name','asc')->get();
            
            // Sale::where('user_id',Auth::user()->id)->where('shop_id',$sid)->where('status','draft')->delete();

            // $items = Sale::query()->select([
            //     DB::raw("sales.id as rawid, products.name as pname, sales.quantity as sqty, sales.selling_price as sprice, sales.sub_total as tsales")
            // ])
            // ->join('products','products.id','sales.product_id')
            // ->where('sales.user_id',Auth::user()->id)->where('sales.company_id',Auth::user()->company_id)->where('sales.shop_id',$sid)->where('sales.status','draft')
            // ->get();
            // if($items->isNotEmpty()) {                
            //     $total = Sale::query()->select([
            //         DB::raw("SUM(quantity) as tqty, SUM(sub_total) as tsales")
            //     ])
            //     ->where('sales.user_id',Auth::user()->id)->where('sales.company_id',Auth::user()->company_id)->where('sales.shop_id',$sid)->where('sales.status','draft')
            //     ->get();
            //     $customer = Sale::query()->select([
            //         DB::raw('customers.id as cid, customers.name as cname')
            //     ])
            //     ->join('customers','customers.id','sales.customer_id')
            //     ->where('sales.user_id',Auth::user()->id)->where('sales.company_id',Auth::user()->company_id)->where('sales.shop_id',$sid)->where('sales.status','draft')->first();
            // }
            
            return response()->json(['products'=>$products,'pcats'=>$pcats,'customers'=>$customers,'customer'=>$customer,'sh_products'=>$sh_products,'total'=>$total]);
        }

        if ($check == "sales-report") {
            $sid = $conditions; // conditions == shop_id
            $shop = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('shop_id',$sid)->where('who','cashier')->first(); // check cashier
            if ($shop || Auth::user()->isCEOorAdminorBusinessOwner()) {
                $data['customers'] = Customer::where('status','active')->where('company_id',Auth::user()->company_id)->orderBy('name')->get();
                $data['shop'] = Shop::where('id',$sid)->where('company_id',Auth::user()->company_id)->first();
                $data['categories'] = ProductCategory::where('company_id',Auth::user()->company_id)->where('status',null)->get();
                // $data['recent'] = Sale::where('shop_id',$sid)->where('status','sold')->groupBy('product_id')->orderBy('id','desc')->limit(12)->get();
                // $data['products'] = $data['shop']->products()->limit(10)->get();
                // Session::put('role','Cashier');
                // Session::put('shoid',$sid);
                $view = view('tabs.sales-report',compact('data'))->render();
                return response()->json(['view'=>$view]);
            } else {
                $shop = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('shop_id',$sid)->where('who','sale person')->first(); // check sale person
                if ($shop) {
                    $data['customers'] = Customer::where('status','active')->where('company_id',Auth::user()->company_id)->orderBy('name')->get();
                    $data['shop'] = Shop::where('id',$sid)->where('company_id',Auth::user()->company_id)->first();
                    $data['categories'] = ProductCategory::where('company_id',Auth::user()->company_id)->where('status',null)->get();
                    // Session::put('role','Sales Person');
                    // Session::put('shoid',$sid);
                    $view = view('tabs.sales-report',compact('data'))->render();
                    return response()->json(['view'=>$view]);
                } else {
                    return response()->json(['status'=>'not have access']);
                }
            }
        }

        if($check == "render-products-tab") {
            $sid = $conditions; // conditions == shop_id
            $data['shopstore'] = "single";
            $data['shop'] = Shop::find($sid); 

            $countshops = Shop::where('company_id',Auth::user()->company_id)->count();
            if($countshops > 1) { // check if this company has one shop or more
                $data['shopstore'] = "many";
            } else {
                $store = Store::where('company_id',Auth::user()->company_id)->first();
                if($store) {
                    $data['shopstore'] = "many";
                }                    
            }

            $view = view('tabs.products',compact('data'))->render();
            return response()->json(['view'=>$view]);
        }
        if($check == "products-report") {
            $spid = $conditions; // conditions == shop_id & last pro id
            $spid = explode("~",$spid);
            $sid = $spid[0];
            $pid = $spid[1]; 
            $shop = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('shop_id',$sid)->where('who','cashier')->first();
            if ($shop || Auth::user()->isCEOorAdminorBusinessOwner()) {
                $data['from'] = "shop";
                $data['shop'] = Shop::find($sid);
                $data['products'] = $data['shop']->products()->where('products.id','>',$pid)->orderBy('products.id','asc')->limit(15)->get();
                $data['allproducts'] = $data['shop']->products()->where('products.id','>',$pid)->orderBy('products.id','asc')->get();
                
                $view = view('tables.products-in-shop-store',compact('data'))->render();
                return response()->json(['view'=>$view, 'data'=>$data]); 
            } else {
                return response()->json(['status'=>'not have access']);
            }
        }
        
        if($check == "stock-value") {
            $sid = $conditions; // conditions == shop_id 
            if(Auth::user()->isCEOorAdminorBusinessOwner()) {
                $data['shop'] = Shop::where('id',$sid)->where('company_id',Auth::user()->company_id)->first();
                if($data['shop']) {
                    $products = DB::connection('tenant')->table('shop_products')->where('shop_id',$sid)->where('active','yes')->get();
                    $tp = $tc = 0;
                    if($products->isNotEmpty()) {
                        foreach($products as $p) {
                            $product = Product::find($p->product_id);
                            if($product) {
                                $tp = $tp + ($p->quantity*$product->retail_price);
                                $tc = $tc + ($p->quantity*$product->buying_price);
                            }
                        }
                    }
                    $profit = $tp - $tc;
                    $tp = number_format($tp);
                    $tc = number_format($tc);
                    $profit = number_format($profit);
                    return response()->json(['tc'=>$tc,'tp'=>$tp,'profit'=>$profit]);
                }
            } else {
                return response()->json(['status'=>'not have access']);
            }
        }
        
        if($check == "stock-value-in-store") {
            $sid = $conditions; // conditions == store_id 
            if(Auth::user()->isCEOorAdminorBusinessOwner()) {
                $data['store'] = Store::where('id',$sid)->where('company_id',Auth::user()->company_id)->first();
                if($data['store']) {
                    $products = DB::connection('tenant')->table('store_products')->where('store_id',$sid)->where('active','yes')->get();
                    $tp = $tc = 0;
                    if($products->isNotEmpty()) {
                        foreach($products as $p) {
                            $product = Product::find($p->product_id);
                            if($product) {
                                $tp = $tp + ($p->quantity*$product->retail_price);
                                $tc = $tc + ($p->quantity*$product->buying_price);
                            }
                        }
                    }
                    $profit = $tp - $tc;
                    $tp = number_format($tp);
                    $tc = number_format($tc);
                    $profit = number_format($profit);
                    return response()->json(['tc'=>$tc,'tp'=>$tp,'profit'=>$profit]);
                }
            } else {
                return response()->json(['status'=>'not have access']);
            }
        }

        if($check == "manage-products-in-shop") {
            $pid = $conditions; // conditions == last_product_id
            $data['from'] = "shop";
            $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
            $data['products'] = Product::where('company_id',Auth::user()->company_id)->where('status','published')->where('id','>',$pid)->limit(15)->get();
            $view = view('tables.manage-products',compact('data'))->render();
            return response()->json(['products'=>$view]);
        }
        if($check == "manage-products-in-store") {
            $pid = $conditions; // conditions == last_product_id
            $data['from'] = "store";
            $data['stores'] = Store::where('company_id',Auth::user()->company_id)->get();
            $data['products'] = Product::where('company_id',Auth::user()->company_id)->where('status','published')->where('id','>',$pid)->limit(15)->get();
            $view = view('tables.manage-products',compact('data'))->render();
            return response()->json(['products'=>$view]);
        }

        if($check == "product-details-tab") {
            $spid = $conditions; // conditions == product_id & shop_id
            $spid = explode("~",$spid);
            $sid = $spid[0];
            $pid = $spid[1]; 
            $currentYear = date('Y');

            $product = Product::query()->select([
                DB::raw('products.id as pid, products.name as pname, shop_products.id as spid, shop_products.quantity as quantity, products.buying_price as bprice, products.retail_price as sprice, product_categories.name as pcname, products.image as image, products.expire_date as exp, products.min_stock_level as msl')
            ])
            ->join('shop_products','shop_products.product_id','products.id')
            ->join('product_categories','product_categories.id','products.product_category_id')
            ->where('products.id',$pid)->where('shop_products.shop_id',$sid)->where('shop_products.active','yes')->where('products.company_id',Auth::user()->company_id)
            ->get();
            
            $products = Product::query()->select([
                DB::raw('products.id as pid, products.name as pname')
            ])
            ->join('shop_products','shop_products.product_id','products.id')
            ->where('shop_products.shop_id',$sid)->where('shop_products.active','yes')->where('products.company_id',Auth::user()->company_id)
            ->get();

            $sales = Sale::query()->select([
                DB::raw('SUM(quantity) as quantity, SUM(sub_total) as tsales, SUM(total_buying) as tbuying')
            ])
            ->where('company_id',Auth::user()->company_id)->whereYear('updated_at', $currentYear)
            ->where('shop_id',$sid)->where('product_id',$pid)->where('status','sold')
            ->get();
            
            $qin = NewStock::where('company_id',Auth::user()->company_id)->whereYear('updated_at', $currentYear)->where('shop_id',$sid)->where('product_id',$pid)->where('status','updated')->sum('added_quantity');
            $returnedQ = ReturnSoldItem::where('company_id',Auth::user()->company_id)->whereYear('updated_at', $currentYear)->where('shop_id',$sid)->where('product_id',$pid)->where('status','received')->sum('quantity');
            $trin = Transfer::where('company_id',Auth::user()->company_id)->whereYear('updated_at', $currentYear)->where('destination','shop')->where('destination_id',$sid)->where('product_id',$pid)->where('status','received')->sum('quantity');
            $quantityIn = $qin + $returnedQ + $trin;

            return response()->json(['product'=>$product, 'products'=>$products,'sales'=>$sales,'quantityIn'=>$quantityIn]);
            
        }
        if($check == "product-details-tab-store") {
            $spid = $conditions; // conditions == product_id & store_id
            $spid = explode("~",$spid);
            $sid = $spid[0];
            $pid = $spid[1]; 

            $currentYear = date('Y');

            $product = Product::query()->select([
                DB::raw('products.id as pid, products.name as pname, store_products.id as spid, store_products.quantity as quantity, products.buying_price as bprice, products.retail_price as sprice, product_categories.name as pcname, products.image as image, products.expire_date as exp, products.min_stock_level as msl')
            ])
            ->join('store_products','store_products.product_id','products.id')
            ->join('product_categories','product_categories.id','products.product_category_id')
            ->where('products.id',$pid)->where('store_products.store_id',$sid)->where('products.company_id',Auth::user()->company_id)
            ->get();
            
            $products = Product::query()->select([
                DB::raw('products.id as pid, products.name as pname')
            ])
            ->join('store_products','store_products.product_id','products.id')
            ->where('store_products.store_id',$sid)->where('products.company_id',Auth::user()->company_id)
            ->get();
            
            $qin = NewStock::where('company_id',Auth::user()->company_id)->whereYear('updated_at', $currentYear)->where('store_id',$sid)->where('product_id',$pid)->where('status','updated')->sum('added_quantity');
            $trin = Transfer::where('company_id',Auth::user()->company_id)->whereYear('updated_at', $currentYear)->where('destination','shop')->where('destination_id',$sid)->where('product_id',$pid)->where('status','received')->sum('quantity');
            $quantityIn = $qin + $trin;
            $trout = Transfer::where('company_id',Auth::user()->company_id)->whereYear('updated_at', $currentYear)->where('from','store')->where('from_id',$sid)->where('product_id',$pid)->whereIn('status',['sent','received'])->sum('quantity');

            return response()->json(['product'=>$product, 'products'=>$products,'quantityIn'=>$quantityIn,'trout'=>$trout]);

            // $data['store'] = Store::where('id',$sid)->where('company_id',Auth::user()->company_id)->first();
            // $data['product'] = Product::find($pid);
            // $data['products'] = $data['store']->products()->orderBy('products.name')->get();
            
            // $view = view('tabs.product-details-store-tab',compact('data'))->render();
            // return response()->json(['view'=>$view]);
        }

        if($check == "product-details-report") { // not in use
            $spid = $conditions; // conditions == product_id & shop_id
            $spid = explode("~",$spid);
            $sid = $spid[0];
            $pid = $spid[1]; 
            $currentYear = date('Y');
            $data['shopstore'] = "single";

            $shop = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('shop_id',$sid)->where('who','cashier')->first();
            if ($shop || Auth::user()->isCEOorAdminorBusinessOwner()) {
                $data['from'] = "shop";
                $data['shop'] = Shop::find($sid);
                $data['product'] = Product::find($pid);
                $data['products'] = $data['shop']->products()->orderBy('products.name')->get();
                $data['shop_product'] = \DB::connection('tenant')->table('shop_products')->where('shop_id',$sid)->where('product_id',$pid)->where('active','yes')->first();
                $data['av_quantity'] = $data['shop_product']->quantity + 0; //remove decimal places

                $data['qsold'] = Sale::where('company_id',Auth::user()->company_id)->whereYear('updated_at', $currentYear)->where('shop_id',$sid)->where('product_id',$pid)->where('status','sold')->sum('quantity');
                $total_sales = Sale::where('company_id',Auth::user()->company_id)->whereYear('updated_at', $currentYear)->where('shop_id',$sid)->where('product_id',$pid)->where('status','sold')->sum('sub_total');
                $total_buying_price = Sale::where('company_id',Auth::user()->company_id)->whereYear('updated_at', $currentYear)->where('shop_id',$sid)->where('product_id',$pid)->where('status','sold')->sum('total_buying');
                $data['profit'] = $total_sales - $total_buying_price;
                $data['profit'] = str_replace(".00", "", number_format($data['profit'], 2));
                $data['qsold'] = sprintf('%g',$data['qsold']);
                
                $qin = NewStock::where('company_id',Auth::user()->company_id)->whereYear('updated_at', $currentYear)->where('shop_id',$sid)->where('product_id',$pid)->where('status','updated')->sum('added_quantity');
                $returnedQ = ReturnSoldItem::where('company_id',Auth::user()->company_id)->whereYear('updated_at', $currentYear)->where('shop_id',$sid)->where('product_id',$pid)->where('status','received')->sum('quantity');
                $trin = Transfer::where('company_id',Auth::user()->company_id)->whereYear('updated_at', $currentYear)->where('destination','shop')->where('destination_id',$sid)->where('product_id',$pid)->where('status','received')->sum('quantity');
                $data['qin'] = $qin + $returnedQ + $trin;
                
                $countshops = Shop::where('company_id',Auth::user()->company_id)->count();
                if($countshops > 1) { // check if this company has one shop or more
                    $data['shopstore'] = "many";
                } else {
                    $store = Store::where('company_id',Auth::user()->company_id)->first();
                    if($store) {
                        $data['shopstore'] = "many";
                    }                    
                }

                $view = view('partials.product-details',compact('data'))->render();
                return response()->json(['view'=>$view]);
            } else {
                return response()->json(['status'=>'not have access']);
            }
        }
        if($check == "product-details-report-store") {
            $spid = $conditions; // conditions == product_id & store_id
            $spid = explode("~",$spid);
            $sid = $spid[0];
            $pid = $spid[1]; 
            $currentYear = date('Y');
            $data['shopstore'] = "single";

            $store = DB::connection('tenant')->table('user_stores')->where('user_id',Auth::user()->id)->where('store_id',$sid)->where('who','store master')->first();
            if ($store || Auth::user()->isCEOorAdminorBusinessOwner()) {
                $data['from'] = "store";
                $data['store'] = Store::find($sid);
                $data['product'] = Product::find($pid);
                $data['products'] = $data['store']->products()->orderBy('products.name')->get();
                $data['store_product'] = \DB::connection('tenant')->table('store_products')->where('store_id',$sid)->where('product_id',$pid)->where('active','yes')->first();
                $data['av_quantity'] = $data['store_product']->quantity + 0; //remove decimal places
                
                $qin = NewStock::where('company_id',Auth::user()->company_id)->whereYear('updated_at', $currentYear)->where('store_id',$sid)->where('product_id',$pid)->where('status','updated')->sum('added_quantity');
                $trin = Transfer::where('company_id',Auth::user()->company_id)->whereYear('updated_at', $currentYear)->where('destination','store')->where('destination_id',$sid)->where('product_id',$pid)->where('status','received')->sum('quantity');
                $data['qin'] = $qin + $trin;
                $trout = Transfer::where('company_id',Auth::user()->company_id)->whereYear('updated_at', $currentYear)->where('from','store')->where('from_id',$sid)->where('product_id',$pid)->whereIn('status',['sent','received'])->sum('quantity');
                $data['qout'] = $trout + 0; // remove decimal places with zeros 

                $countstores = Store::where('company_id',Auth::user()->company_id)->count();
                if($countstores > 1) { // check if this company has one store or more
                    $data['shopstore'] = "many";
                } else {
                    $shop = Shop::where('company_id',Auth::user()->company_id)->first();
                    if($shop) {
                        $data['shopstore'] = "many";
                    }                    
                }

                $view = view('partials.product-details-store',compact('data'))->render();
                return response()->json(['view'=>$view]);
            } else {
                return response()->json(['status'=>'not have access']);
            }
        }
        if($check == "product-in-out-tab") {
            $spid = $conditions; // conditions == product_id & shop_id
            $spid = explode("~",$spid);
            $sid = $spid[0];
            $pid = $spid[1]; 
            
            $data['shop'] = Shop::find($sid);
            $data['product'] = Product::find($pid);
            
            $view = view('tabs.product-in-out-tab',compact('data'))->render();
            return response()->json(['view'=>$view]);
        }
        if($check == "product-in-out-store-tab") {
            $spid = $conditions; // conditions == product_id & shop_id
            $spid = explode("~",$spid);
            $sid = $spid[0];
            $pid = $spid[1]; 
            
            $data['store'] = Store::find($sid);
            $data['product'] = Product::find($pid);
            
            $view = view('tabs.product-in-out-store-tab',compact('data'))->render();
            return response()->json(['view'=>$view]);
        }
        if($check == "shop-product-activities") {            
            $spid = $conditions; // conditions == product_id & shop_id & dates
            $spid = explode("~",$spid);
            $shop_id = $spid[0];
            $product_id = $spid[1]; 
            $fromdate = $spid[2]; 
            $todate = $spid[3]; 
            $begin = new \DateTime($fromdate);
            $end = new \DateTime($todate);
            $fromdate = date("Y-m-d 00:00:00", strtotime($fromdate));
            $todate = date("Y-m-d 23:59:59", strtotime($todate));

            $availableQ = \DB::connection('tenant')->table('shop_products')->where('shop_id',$shop_id)->where('product_id',$product_id)->where('active','yes')->sum('quantity');

            $sumQ = Sale::query()->select([
                    DB::raw('DATE(updated_at) as date, SUM(quantity) as quantity')
                ])
                ->where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])
                ->where('status','sold')->where('shop_id',$shop_id)->where('product_id',$product_id)
                ->groupBy('date')->get();
            $returnedQ = ReturnSoldItem::query()->select([
                    DB::raw('DATE(updated_at) as date, SUM(quantity) as quantity')
                ])
                ->where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])
                ->where('shop_id',$shop_id)->where('product_id',$product_id)->where('status','received')
                ->groupBy('date')->get();
            $newstockQ = NewStock::query()->select([
                    DB::raw('DATE(updated_at) as date, SUM(added_quantity) as quantity')
                ])
                ->where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])
                ->where('shop_id',$shop_id)->where('product_id',$product_id)->where('status','updated')
                ->groupBy('date')->get();
            $adjust = StockAdjustment::query()->select([
                    DB::raw('DATE(updated_at) as date, SUM(av_quantity) as sumaQ, sum(new_quantity) as sumnQ')
                ])
                ->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])
                ->where('status','stock adjustment')->where('company_id',Auth::user()->company_id)->where('from','shop')->where('from_id',$shop_id)->where('product_id',$product_id)
                ->groupBy('date')->get();
            $trout = Transfer::query()->select([
                    DB::raw('DATE(updated_at) as date, sum(quantity) as quantity')
                ])
                ->where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])
                ->where('from','shop')->where('from_id',$shop_id)->where('product_id',$product_id)->whereIn('status',['sent','received'])
                ->groupBy('date')->get();
            $trin = Transfer::query()->select([
                    DB::raw('DATE(updated_at) as date, sum(quantity) as quantity')
                ])
                ->where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])
                ->where('destination','shop')->where('destination_id',$shop_id)->where('product_id',$product_id)->where('status','received')
                ->groupBy('date')->get();
        
            return response()->json(['availableQ'=>$availableQ,'sumQ'=>$sumQ,'returnedQ'=>$returnedQ,'newstockQ'=>$newstockQ,'adjust'=>$adjust,'trout'=>$trout,'trin'=>$trin]);
        }
        if($check == "store-product-activities") {            
            $spid = $conditions; // conditions == product_id & shop_id & dates
            $spid = explode("~",$spid);
            $store_id = $spid[0];
            $product_id = $spid[1]; 
            $fromdate = $spid[2]; 
            $todate = $spid[3]; 
            $begin = new \DateTime($fromdate);
            $end = new \DateTime($todate);
            $fromdate = date("Y-m-d 00:00:00", strtotime($fromdate));
            $todate = date("Y-m-d 23:59:59", strtotime($todate));
            
            $availableQ = \DB::connection('tenant')->table('store_products')->where('store_id',$store_id)->where('product_id',$product_id)->where('active','yes')->sum('quantity');

            $newstockQ = NewStock::query()->select([
                    DB::raw('DATE(updated_at) as date, SUM(added_quantity) as quantity')
                ])
                ->where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])
                ->where('store_id',$store_id)->where('product_id',$product_id)->where('status','updated')
                ->groupBy('date')->get();
            $adjust = StockAdjustment::query()->select([
                    DB::raw('DATE(updated_at) as date, SUM(av_quantity) as sumaQ, sum(new_quantity) as sumnQ')
                ])
                ->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])
                ->where('status','stock adjustment')->where('company_id',Auth::user()->company_id)->where('from','store')->where('from_id',$store_id)->where('product_id',$product_id)
                ->groupBy('date')->get();
            $trout = Transfer::query()->select([
                    DB::raw('DATE(updated_at) as date, sum(quantity) as quantity')
                ])
                ->where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])
                ->where('from','store')->where('from_id',$store_id)->where('product_id',$product_id)->whereIn('status',['sent','received'])
                ->groupBy('date')->get();
            $trin = Transfer::query()->select([
                    DB::raw('DATE(updated_at) as date, sum(quantity) as quantity')
                ])
                ->where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])
                ->where('destination','store')->where('destination_id',$store_id)->where('product_id',$product_id)->where('status','received')
                ->groupBy('date')->get();
        
            return response()->json(['availableQ'=>$availableQ,'newstockQ'=>$newstockQ,'adjust'=>$adjust,'trout'=>$trout,'trin'=>$trin]);
        }
        if($check == "product-sales-tab") {
            $spid = $conditions; // conditions == product_id & shop_id
            $spid = explode("~",$spid);
            $sid = $spid[0];
            $pid = $spid[1]; 
            
            $data['shop'] = Shop::find($sid);
            $data['product'] = Product::find($pid);
            
            $view = view('tabs.product-sales-tab',compact('data'))->render();
            return response()->json(['view'=>$view]);
        }
        if($check == "shop-product-sales") {
            $spid = $conditions; // conditions == product_id & shop_id & dates
            $spid = explode("~",$spid);
            $shop_id = $spid[0];
            $item_id = $spid[1]; 
            $fromdate = $spid[2]; 
            $todate = $spid[3]; 
            $begin = new \DateTime($fromdate);
            $end = new \DateTime($todate);
            $fromdate = date("Y-m-d 00:00:00", strtotime($fromdate));
            $todate = date("Y-m-d 23:59:59", strtotime($todate));

            $sales = Sale::query()->select([
                DB::raw('DATE(updated_at) as date, SUM(quantity) as quantity, SUM(total_buying) as tbuying, SUM(sub_total) as tsales')
            ])
            ->where('company_id',Auth::user()->company_id)
            ->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])
            ->where('shop_id',$shop_id)->where('status','sold')->where('product_id',$item_id)
            ->groupBy('date')->orderBy('date','desc')->get();
            $total = Sale::query()->select([
                DB::raw('SUM(quantity) as quantity, SUM(total_buying) as tbuying, SUM(sub_total) as tsales')
            ])
            ->where('company_id',Auth::user()->company_id)
            ->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])
            ->where('shop_id',$shop_id)->where('status','sold')->where('product_id',$item_id)
            ->get();

            return response()->json(['sales'=>$sales,'total'=>$total]);
        }
        if($check == "render-products-tab-store") {
            $sid = $conditions; // conditions == store_id
            $data['shopstore'] = "single";
            $data['store'] = Store::find($sid);
            
            $countshops = Shop::where('company_id',Auth::user()->company_id)->count();
            if($countshops > 1) { // check if this company has one shop or more
                $data['shopstore'] = "many";
            } else {
                $store = Store::where('company_id',Auth::user()->company_id)->first();
                if($store) {
                    $data['shopstore'] = "many";
                }                    
            }

            $view = view('tabs.products',compact('data'))->render();
            return response()->json(['view'=>$view]);
        }
        if($check == "products-report-store") {
            $spid = $conditions; // conditions == store_id & last pro id
            $spid = explode("~",$spid);
            $sid = $spid[0];
            $pid = $spid[1]; 
            $store = DB::connection('tenant')->table('user_stores')->where('user_id',Auth::user()->id)->where('store_id',$sid)->where('who','store master')->first();
            if ($store || Auth::user()->isCEOorAdminorBusinessOwner()) {
                $data['from'] = "store";
                $data['store'] = Store::find($sid);
                $data['products'] = $data['store']->products()->where('products.id','>',$pid)->orderBy('products.id','asc')->limit(15)->get();

                $view = view('tables.products-in-shop-store',compact('data'))->render();
                return response()->json(['view'=>$view, 'data'=>$data]);
            } else {
                return response()->json(['status'=>'not have access']);
            }
        }

        if($check == "customer-bought-items") {
            $scd = explode("~",$conditions);
            $sid = $scd[0];
            $cid = $scd[1];
            $date = $scd[2];
            $fromdate = date("Y-m-d 00:00:00", strtotime($date));
            $todate = date("Y-m-d 23:59:59", strtotime($date));
            $output = array();

            $sales = Sale::where('company_id',Auth::user()->company_id)->where('shop_id',$sid)->where('customer_id',$cid)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('status','sold')->get();
            if($sales->isNotEmpty()) {
                $totalp = 0;
                foreach($sales as $s) {
                    $totalp = $totalp + $s->sub_total;
                    $output[] = "<li> ".$s->product->name.": <b>".sprintf('%g',$s->quantity)." x ".number_format($s->selling_price, 0)." = ".number_format($s->sub_total, 0)."</b></li>";
                }
                $output[] = "<li class='nostyle pt-2'><b style='font-size:18px'>Total: ".number_format($totalp, 0)."</b></li>";
            }
            return response()->json(['output'=>$output]);
        }

        if($check == "product-categories-tab") {
            $view = view('tabs.product-categories')->render();
            return response()->json(['pcategories'=>$view]);
        }        
        if($check == "product-categories") {
            $data['main-cat'] = ProductCategoryGroup::where('company_id',Auth::user()->company_id)->where('name','main')->first();
            $data['cats'] = ProductCategory::where('status','!=','deleted')->orWhereNull('status')->where('company_id',Auth::user()->company_id)->orderBy('name')->get();
            $data['counts'] = count($data['cats']);
            if($data['main-cat']) { } else {
                $create = ProductCategoryGroup::create(['name'=>'main','company_id'=>Auth::user()->company_id,'user_id'=>Auth::user()->id]);
                if($create) {
                    $data['main-cat'] = ProductCategoryGroup::find($create->id);
                }
            }
            $view = view('tables.product-categories',compact('data'))->render();
            return response()->json(['pcategories'=>$view]);
        }

        if($check == "get-products-in-tab") { 
            $sid = $conditions; // conditions == shop_id
            $data['shop'] = Shop::find($sid);
            $view = view('tabs.products-in-records',compact('data'))->render();
            return response()->json(['view'=>$view]);
        }
        if($check == "get-products-in-store-tab") { 
            $sid = $conditions; // conditions == store_id
            $data['store'] = Store::find($sid);
            $view = view('tabs.products-in-records-store',compact('data'))->render();
            return response()->json(['view'=>$view]);
        }
        if($check == "pending-products-in") { // this is from shop
            $sid = $conditions; // conditions == shop_id
            $data['from'] = "shop";
            $data['pendingstock'] = NewStock::where('company_id',Auth::user()->company_id)->where('status','sent')->where('shop_id',$sid)->get();
            $view = view('tables.pending-products-in',compact('data'))->render();
            return response()->json(['products'=>$view]);
        }
        if($check == "pending-products-in-store") { // this is from shop
            $sid = $conditions; // conditions == store_id
            $data['from'] = "store";
            $data['pendingstock'] = NewStock::where('company_id',Auth::user()->company_id)->where('status','sent')->where('store_id',$sid)->get();
            $view = view('tables.pending-products-in',compact('data'))->render();
            return response()->json(['products'=>$view]);
        }
        
        if($check == "products-of-category") {
            $cid = $conditions; // category id
            $products = Product::where('product_category_id',$cid)->where('company_id',Auth::user()->company_id)->where('status','!=','deleted')->get();
            if($products->isNotEmpty()) {
                foreach($products as $p) {
                    $output[] = "<li>".$p->name."</li>";
                }
                return response()->json(['status'=>'available','items'=>$output]);
            }            
        }

        if ($check == "stock-report") {
            $sid = $conditions; // conditions == shop_id
            $shop = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('shop_id',$sid)->where('who','cashier')->first();
            if ($shop) {
                $data['from'] = "shop";
                $data['shop'] = Shop::find($sid);
                $data['products'] = $data['shop']->products()->orderBy('products.name')->get();
                $data['pendingstock'] = NewStock::where('shop_id',$sid)->where('status','sent')->get();
                if(Auth::user()->isCEOorAdminorBusinessOwner()) {
                    $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
                    $data['stores'] = Store::where('company_id',Auth::user()->company_id)->get();
                }
                $view = view('tabs.available-stock',compact('data'))->render();
                return response()->json(['view'=>$view]);
            } else {
                return response()->json(['status'=>'not have access']);
            }
        }        
        if ($check == "stock-report-store") {
            $sid = $conditions; // conditions == store_id
            $store = DB::connection('tenant')->table('user_stores')->where('user_id',Auth::user()->id)->where('store_id',$sid)->where('who','store master')->first();
            if ($store) {
                $data['from'] = "store";
                $data['store'] = Store::find($sid);
                $data['products'] = $data['store']->products()->orderBy('products.name')->get();
                $data['pendingstock'] = NewStock::where('store_id',$sid)->where('status','sent')->get();
                if(Auth::user()->isCEOorAdminorBusinessOwner()) {
                    $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
                    $data['stores'] = Store::where('company_id',Auth::user()->company_id)->get();
                }
                $view = view('tabs.available-stock',compact('data'))->render();
                return response()->json(['view'=>$view]);
            } else {
                return response()->json(['status'=>'not have access']);
            }
        }

        if ($check == "shop-expenses") {
            $sid = $conditions; // conditions == shop_id
            $shop = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('shop_id',$sid)->where('who','cashier')->first();
            if ($shop || Auth::user()->isCEOorAdminorBusinessOwner()) {
                $data['otherroles'] = Auth::user()->roles()->where('name','!=','Cashier')->get();
                $data['shop'] = Shop::find($sid);
                $data['expenses'] = Expense::where('company_id',Auth::user()->company_id)->where('status','active')->get();
                if($data['expenses']->isEmpty()){
                    $d = [
                        ['name'=>'Umeme','status'=>'active','company_id'=>Auth::user()->company_id,'user_id'=>Auth::user()->id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
                        ['name'=>'Chakula','status'=>'active','company_id'=>Auth::user()->company_id,'user_id'=>Auth::user()->id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
                        ['name'=>'Posho','status'=>'active','company_id'=>Auth::user()->company_id,'user_id'=>Auth::user()->id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
                    ];
                    $i = Expense::insert($d);
                    if($i) {
                        $data['expenses'] = Expense::where('company_id',Auth::user()->company_id)->where('status','active')->get();
                    }
                }
                $data['shopExpenses'] = ShopExpense::whereDate('created_at', Carbon::today())->where('shop_id',$sid)->where('company_id',Auth::user()->company_id)->get();
                $view = view('tabs.expenses',compact('data'))->render();
                return response()->json(['view'=>$view]);
            } else {
                return response()->json(['status'=>'not have access']);
            }        
        }
        if($check == "registered-expenses") {
            $output = array();
            $total = 0;
            $expenses = Expense::where('company_id',Auth::user()->company_id)->where('status','active')->get();
            if($expenses->isNotEmpty()){
                $total = $expenses->count();
                foreach($expenses as $e){
                    $output[] = '<div class="list"><div class="name">'.$e->name.'</div>'
                                .'<div style="float: right;">'
                                .'<span class="bg-warning edit-expense px-1" eid="'.$e->id.'" ename="'.$e->name.'"><i class="fa fa-pencil"></i></span>'
                                .'<span style="margin-left: .15rem;" class="bg-danger delete-expense text-white px-1" eid="'.$e->id.'" ename="'.$e->name.'"><i class="fa fa-times"></i></span></div>'
                                .'</div>';
                }
            } else {
                $output[] = '<div><small><i>-No Expenses Regirstered-</i></small></div>';
            }
            return response()->json(['expenses'=>$output,'total'=>$total]);
        }
        
        if($check == "recorded-expenses") {
            $ssi = explode("~",$conditions); // conditions contains shop_id, fromdate and todate
            $sid = $ssi[0]; 
            $fromdate = $ssi[1]; 
            $todate = $ssi[2]; 
            $fromdate = date("Y-m-d 00:00:00", strtotime($fromdate));
            $todate = date("Y-m-d 23:59:59", strtotime($todate));
            $expenses = array();
            $today = date('Y-m-d');
                                
            $start_date = date_create($fromdate);
            $end_date = date_create($todate);
            $interval = new DateInterval('P1D');
            $date_range = new DatePeriod($start_date, $interval, $end_date);
            $date_range = array_reverse(iterator_to_array($date_range));

            $shop = Shop::find($sid);
            $bdays = 0;
            if($shop->checkSaleBackDate()) { 
                $bdays = $shop->checkSaleBackDate()->sale_days_back; 
            } 

            $te = ShopExpense::where('company_id',Auth::user()->company_id)->where('shop_id',$sid)->whereBetween('created_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->sum('amount');
            $data['total_ex'] = number_format($te, 0);
            foreach ($date_range as $date) {
                $action = "";
                $sum = ShopExpense::whereDate('created_at', $date->format('Y-m-d'))->where('company_id',Auth::user()->company_id)->where('shop_id',$sid)->sum('amount');

                $expenses[] = "<tr style='background:#f9f6f2'><td class='pb-1 pt-4' colspan='4'>".$date->format('d/m/Y')." <b class='bg-dark text-light px-1 ml-2'>".number_format($sum, 0)."</b></td></tr>";
                $exp = ShopExpense::whereDate('created_at', $date->format('Y-m-d'))->where('company_id',Auth::user()->company_id)->where('shop_id',$sid)->get();
                if($exp->isNotEmpty()) {
                    foreach($exp as $e) {
                        if(date('Y-m-d', strtotime('-'.$bdays.' days')) <= $date->format('Y-m-d')) {
                        $action = '<a href="#" class="btn btn-info btn-sm editExpense" val="'.$e->id.'"><i class="fa fa-edit"></i></a>'.
                                  ' <a href="#" class="btn btn-danger btn-sm deleteExpense" val="'.$e->id.'"><i class="fa fa-times"></i></a>';
                        }
                        $expenses[] = "<tr><td>".$e->expense->name."</td><td>".number_format($e->amount, 0)."</td><td class='desc-td'>".$e->description."</td><td>".$action."</td></tr>";
                    }
                } else {
                    $expenses[] = "<tr><td colspan='4'><small><i>No expenses</i></small></td></tr>";
                }
            }
            return response()->json(['data'=>$data,'expenses'=>$expenses]);
        }
        if($check == "update-sales-date") {
            $sales = \App\Sale::where('shop_id',610)->where('updated_at','<','2000-01-01')->get();
            // $sales = \App\Sale::where('shop_id',2)->where('updated_at','>','2024-10-29')->get();
            // foreach($sales as $s) {
            //     $s->update(['updated_at'=>$s->submitted_at]);
            // }
            return response()->json(['status'=>'not done','sales'=>$sales]);
        }

        if($check == "shop-customers") {
            $sid = $conditions; // conditions == shop_id 
            $shop = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('shop_id',$sid)->where('who','cashier')->first();
            if ($shop || Auth::user()->isCEOorAdminorBusinessOwner()) {
                $data['shop'] = Shop::find($sid);

                $view = view('tabs.customers',compact('data'))->render();
                return response()->json(['view'=>$view]);
            } else {
                return response()->json(['status'=>'not have access']);
            }        
        }
        if ($check == "deleted-customers") {
            $shop_id = $conditions;
            $customers = Customer::query()->select([
                    DB::raw('id, name, phone, location')
                ])
                ->where('shop_id',$shop_id)->where('status','deleted')
                ->get();
            return response()->json(['customers'=>$customers]);
        }
        if ($check == "deleted-products") {
            $shop_id = $conditions;
            $products = Product::query()->select([
                    DB::raw('products.id as pid, name, buying_price, retail_price')
                ])
                ->join('shop_products','shop_products.product_id','products.id')
                ->where('shop_products.shop_id',$shop_id)->where('products.status','deleted')
                ->get();
            return response()->json(['products'=>$products]);
        }
        if ($check == "deleted-products-store") {
            $shop_id = $conditions;
            $products = Product::query()->select([
                    DB::raw('products.id as pid, name, buying_price, retail_price')
                ])
                ->join('store_products','store_products.product_id','products.id')
                ->where('store_products.store_id',$shop_id)->where('products.status','deleted')
                ->get();
            return response()->json(['products'=>$products]);
        }
        if ($check == "restore-customer") {
            $cid = $conditions;
            Customer::find($cid)->update(['status'=>'active']);
            return response()->json(['status'=>'success']);
        }
        if ($check == "restore-product") {
            $scid = explode('~',$conditions);
            $pid = $scid[0];
            $sid = $scid[1];
            Product::find($pid)->update(['status'=>'published']);
            $sp = DB::connection('tenant')->table('shop_products')->where('product_id',$pid)->where('shop_id',$sid)->orderBy('id','desc');
            if ($sp->first()) {
                $sp->update(['active'=>'yes']);

                Log::channel('custom')->info('PID: '.$pid.', newQ = '.$sp->first()->quantity.' .. Restored from deletion');
            } 
            return response()->json(['status'=>'success']);
        }
        if ($check == "restore-product-store") {
            $scid = explode('~',$conditions);
            $pid = $scid[0];
            $sid = $scid[1];
            Product::find($pid)->update(['status'=>'published']);
            $sp = DB::connection('tenant')->table('store_products')->where('product_id',$pid)->where('store_id',$sid)->orderBy('id','desc');
            if ($sp->first()) {
                $sp->update(['active'=>'yes']);
            } 
            return response()->json(['status'=>'success']);
        }
        if($check == "more-shop-customers") {
            $scid = explode('~',$conditions);
            $sid = $scid[0];
            $lastid = $scid[1];
            $data['shop'] = Shop::find($sid);
            $data['customers'] = Customer::where('status','active')->where('company_id',Auth::user()->company_id)->where('shop_id',$sid)->where('id','<',$lastid)->orderBy('id','desc')->limit(5)->get();
            $data['count'] = Customer::where('status','active')->where('company_id',Auth::user()->company_id)->where('shop_id',$sid)->where('id','<',$lastid)->count();
            $view = view('tables.more-customers',compact('data'))->render();
            return response()->json(['view'=>$view,'data'=>$data]);
        }

        if($check == "shop-transfers") {
            $sid = $conditions; // conditions == shop_id
            $data['from'] = "shop";
            $data['shop'] = Shop::where('id',$sid)->where('company_id',Auth::user()->company_id)->first();
            if ($data['shop']) {
                $view = view('tabs.transfers',compact('data'))->render();
                return response()->json(['view'=>$view]);
            } else {
                return response()->json(['status'=>'not have access']);
            }        
        }
        
        if($check == "store-transfers") {
            $sid = $conditions; // conditions == store_id
            $data['from'] = "store";
            $data['store'] = Store::where('id',$sid)->where('company_id',Auth::user()->company_id)->first();
            if ($data['store']) {
                $view = view('tabs.transfers',compact('data'))->render();
                return response()->json(['view'=>$view]);
            } else {
                return response()->json(['status'=>'not have access']);
            }        
        }
        
        if($check == "transfer-items") {
            $sid = $conditions; // conditions == shop_id
            $data['from'] = "shop";
            $shop = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('shop_id',$sid)->where('who','cashier')->first();
            if ($shop) {
                $data['shops'] = Shop::where('id','!=',$sid)->where('company_id',Auth::user()->company_id)->get();
                $data['stores'] = Store::where('company_id',Auth::user()->company_id)->get();
                $data['shop'] = Shop::where('id',$sid)->where('company_id',Auth::user()->company_id)->first();
                $data['products'] = $data['shop']->products()->get();
                $data['users'] = User::where('company_id',Auth::user()->company_id)->where('status','!=','deleted')->get();
                $view = view('tabs.transfer-items',compact('data'))->render();
                return response()->json(['view'=>$view]);
            } else {
                return response()->json(['status'=>'not have access']);
            }
        }
        
        if($check == "shop-settings") {
            $sid = $conditions; // conditions == shop_id
            $data['from'] = "shop";
            $shop = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('shop_id',$sid)->where('who','cashier')->first();
            if ($shop) {
                $data['shop'] = Shop::where('id',$sid)->where('company_id',Auth::user()->company_id)->first();
                $view = view('tabs.shop-settings',compact('data'))->render();
                return response()->json(['view'=>$view]);
            } else {
                return response()->json(['status'=>'not have access']);
            }
        }
        
        if($check == "transfer-items-store") {
            $sid = $conditions; // conditions == store_id
            $data['from'] = "store";
            $store = DB::connection('tenant')->table('user_stores')->where('user_id',Auth::user()->id)->where('store_id',$sid)->where('who','store master')->first();
            if ($store) {
                $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
                $data['stores'] = Store::where('id','!=',$sid)->where('company_id',Auth::user()->company_id)->get();
                $data['store'] = Store::where('id',$sid)->where('company_id',Auth::user()->company_id)->first();
                $data['products'] = $data['store']->products()->get();
                $data['users'] = User::where('company_id',Auth::user()->company_id)->where('status','!=','deleted')->get();
                $view = view('tabs.transfer-items',compact('data'))->render();
                return response()->json(['view'=>$view]);
            } else {
                return response()->json(['status'=>'not have access']);
            }
        }
        
        if ($check == "pending-stock") {
            $output = array();
            $totalStQ = 0;
            $whereto = "";
            $destid = "";
            $items = NewStock::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('status','request')->get();
            if ($items->isNotEmpty()) {
                foreach($items as $value) {
                    $totalStQ = $totalStQ + $value->added_quantity;  
                    if ($value->shop_id) {
                        $whereto = $value->shop->name." (shop)";
                        $destid = "shop-".$value->shop_id;
                    }              
                    if ($value->store_id) {
                        $whereto = $value->store->name." (store)";
                        $destid = "store-".$value->store_id;
                    }              
                    $output[] = '<tr class="str-'.$value->id.'"><td>'.$value->product->name.'</td>'
                        .'<td><input type="number" class="form-control form-control-sm st-quantity" placeholder="Q" name="quantity" value="'.sprintf('%g',$value->added_quantity).'" sid="'.$value->id.'" style="width:80px"></td>'
                        .'<td><span class="p-1 text-danger remove-str" val="'.$value->id.'" style="cursor: pointer;"><i class="fa fa-times"></i></span></td></tr>';
                }
            } else {
                $output[] = '<tr class="empty-row"><td colspan="3" align="center"><i>-- No items --</i></td></tr>';
            }
            return response()->json(['items'=>$output,'totalStQ'=>$totalStQ,'whereto'=>$whereto,'destid'=>$destid]);
        }

        if($check == "products-overview-tab") {
            $data['company_id'] = $conditions;
            $view = view('tabs.products-overview-tab',compact('data'))->render();
            return response()->json(['view'=>$view]);
        }

        if($check == "stock-overview-tab") {
            $data['company_id'] = $conditions;
            $view = view('tabs.stock-overview-tab',compact('data'))->render();
            return response()->json(['view'=>$view]);
        }
        
        if($check == "available-stock-tab") {
            $data['company_id'] = $c_id = $conditions;
            $data['shops'] = Shop::where('company_id',$c_id)->get();
            $data['stores'] = Store::where('company_id',$c_id)->get();
            $view = view('tabs.available-stock-tab',compact('data'))->render();
            return response()->json(['view'=>$view]);
        }

        if($check == "add-stock-tab") {
            $data['company_id'] = $c_id = $conditions;
            $data['shops'] = Shop::where('company_id',$c_id)->get();
            $data['stores'] = Store::where('company_id',$c_id)->get();
            $view = view('forms.new-stock',compact('data'))->render();
            return response()->json(['view'=>$view]);
        }

        if($check == "previous-stock-records-tab") {
            $data['company_id'] = $c_id = $conditions;
            $view = view('tabs.previous-stock-records',compact('data'))->render();
            return response()->json(['view'=>$view]);
        }
        
        if($check == "transfer-records-tab") {
            $data['company_id'] = $c_id = $conditions;
            $view = view('tabs.transfer-records',compact('data'))->render();
            return response()->json(['view'=>$view]);
        }
        
        if($check == "stock-adjustment-tab") {
            $data['company_id'] = $c_id = $conditions;
            $data['shops'] = Shop::where('company_id',$c_id)->get();
            $data['stores'] = Store::where('company_id',$c_id)->get();
            $view = view('tabs.stock-adjustment',compact('data'))->render();
            return response()->json(['view'=>$view]);
        }
        
        if($check == "stock-taking-tab") {
            $data['company_id'] = $c_id = $conditions;
            $data['shops'] = Shop::where('company_id',$c_id)->get();
            $data['stores'] = Store::where('company_id',$c_id)->get();
            $view = view('tabs.stock-taking',compact('data'))->render();
            return response()->json(['view'=>$view]);
        }
        
        if($check == "cashier-stock-approval") {
            $val = $conditions;
            $data['company'] = Company::find(Auth::user()->company_id);
            if($data['company']) {
                $data['company']->update(['cashier_stock_approval'=>$val]);
                return response()->json(['status'=>'success','val'=>$val]);
            }
        }
        
        if($check == "change-transfer-products-status") {
            $val = $conditions;
            $data['company'] = Company::find(Auth::user()->company_id);
            if($data['company']) {
                $data['company']->update(['can_transfer_items'=>$val]);
                return response()->json(['status'=>'success','val'=>$val]);
            }
        }
        
        if($check == "change-product-categories-status") {
            $val = $conditions;
            $data['company'] = Company::find(Auth::user()->company_id);
            if($data['company']) {
                $data['company']->update(['has_product_categories'=>$val]);
                return response()->json(['status'=>'success','val'=>$val]);
            }
        }
        
        if($check == "change-customer-on-sales-status") {
            $val = $conditions;
            $data['company'] = Company::find(Auth::user()->company_id);
            if($data['company']) {
                $data['company']->update(['customer_on_sales'=>$val]);
                return response()->json(['status'=>'success','val'=>$val]);
            }
        }

        if($check == "get-sale-cart") {
            $sid = $conditions;
            $totalp = Sale::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('shop_id',$sid)->where('status','draft')->sum('sub_total');
            $totalp = $totalp+0; // helps to remove 00 decimal places
            return response()->json(['totalp'=>$totalp]);
        }
        
        if($check == "check-sale-p-availability") {
            $sid = $conditions;
            $sales = Sale::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('shop_id',$sid)->where('status','draft')->get();
            if($sales->isNotEmpty()) {
                foreach($sales as $s) {         
                    $q = 0;           
                    $sp = \DB::connection('tenant')->table('shop_products')->where('shop_id',$sid)->where('product_id',$s->product_id)->where('active','yes')->first();
                    if($sp) {
                        $q = $sp->quantity;
                    }
                    if($s->quantity > $q) {
                        return response()->json(['status'=>'not enough','sid'=>$s->id,'pname'=>$s->product->name,'aq'=>$q+0]);
                    }
                }
            }
        }
        
        if($check == "get-shop-settings") {
            $sid = $conditions;
            $shop = Shop::find($sid);
            if($shop) {
                $ssettings = \App\CompanySetting::where('shop_id',$sid)->get();
                return response()->json(['shop'=>$shop,'ssettings'=>$ssettings]);
            }
        }

        if($check == "cashier-change-price") {
            $sid_val = explode("~",$conditions);
            $sid = $sid_val[0];
            $val = $sid_val[1];
            $shop = Shop::find($sid);
            if($shop) {
                $shop->update(['change_s_price'=>$val]);
                return response()->json(['status'=>'success','val'=>$val]);
            }
        }
        
        if($check == "record-prev-sales") {
            $sid_val = explode("~",$conditions);
            $sid = $sid_val[0];
            $val = $sid_val[1];
            $shop = Shop::find($sid);
            if($shop) {
                $shop->update(['record_prev_sales'=>$val]);
                return response()->json(['status'=>'success','val'=>$val]);
            }
        }
        
        if($check == "change-receipt-orders") {
            $sid_val = explode("~",$conditions);
            $sid = $sid_val[0];
            $val = $sid_val[1];
            $shop = Shop::find($sid);
            if($shop) {
                $shop->update(['sell_order'=>$val]);
                return response()->json(['status'=>'success','val'=>$val]);
            }
        }
        
        if($check == "cus-paid-amount") {
            $ssi = explode("~",$conditions);
            $shop_id = $ssi[0]; 
            $date = $ssi[1];
            $customer_id = $ssi[2]; 
            $data['cus_desc'] = CustomerDebt::where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->whereDate('updated_at', $date)->where('customer_id',$customer_id)->where('status','weka pesa')->get();
            
            return response()->json(['data'=>$data]);
        }
        if($check == "cus-paid-debt") {
            $ssi = explode("~",$conditions);
            $shop_id = $ssi[0]; 
            $date = $ssi[1];
            $customer_id = $ssi[2]; 
            $data['cus_desc'] = CustomerDebt::where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->whereDate('updated_at', $date)->where('customer_id',$customer_id)->where('status','pay debt')->get();
            
            return response()->json(['data'=>$data]);
        }
        if($check == "cus-refund") {
            $ssi = explode("~",$conditions);
            $shop_id = $ssi[0]; 
            $date = $ssi[1];
            $customer_id = $ssi[2]; 
            $data['cus_desc'] = CustomerDebt::where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->whereDate('updated_at', $date)->where('customer_id',$customer_id)->where('status','refund')->get();
            
            return response()->json(['data'=>$data]);
        }

    }

    public function getMax($array) {
        $max = 0;
        foreach( $array as $k => $v )
        {
            $max = max( array( $max, $v['val'] ) );
        }
        return $max;
    }

    public function get_data2($check, $condition1, $condition2) {
        if($check == "get-customer") {
            $sid = $condition1;
            $cid = $condition2;
            $data['customer'] = Customer::where('id',$cid)->where('status','active')->where('company_id', Auth::user()->company_id)->first();
            if ($data['customer']) {
                $data['shop'] = Shop::where('id',$sid)->where('company_id',Auth::user()->company_id)->first();
                $view = view('tabs.customer',compact('data'))->render();
                return response()->json(['view'=>$view]);
            }
        }
            
        // customer debt records
        if($check == "debt-records") {
            // shop_id imebeba shop + customer
            $ssi = explode("~",$condition1);
            $shop_id = $ssi[0];
            $customer_id = $ssi[1]; 
            $customer = Customer::find($customer_id);

            $fd = CustomerDebt::where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->whereDate('updated_at','<=',Carbon::today())->where('customer_id',$customer_id)->where('status','!=','deleted')->where('interest',null)->sum('debt_amount');
            $sd = CustomerDebt::where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->whereDate('updated_at','<=',Carbon::today())->where('status','!=','deleted')->where('customer_id',$customer_id)->sum('amount_with_interest');
            $totald = $fd + $sd;
            $data["av_deni"] = $data['curr_deni'] = $totald;

            $sum = CustomerDebt::query()->select([
                DB::raw('
                    customer_debts.customer_id as cid,
                    DATE(updated_at) as ddate, 
                    SUM(CASE WHEN status = "buy stock" THEN debt_amount ELSE 0 END) as debt_amount,
                    SUM(CASE WHEN status = "buy stock" THEN stock_value ELSE 0 END) as stock_value,
                    SUM(CASE WHEN status = "buy stock" THEN amount_paid ELSE 0 END) as amount_paid,
                    SUM(CASE WHEN status = "weka pesa" THEN amount_paid ELSE 0 END) as amount_paid2,
                    SUM(CASE WHEN status = "lend money" THEN debt_amount ELSE 0 END) as debt_amount2,
                    SUM(CASE WHEN status = "lend money" THEN interest_amount ELSE 0 END) as total_interest,
                    SUM(CASE WHEN status = "lend money" THEN interest ELSE 0 END) as interest,
                    SUM(CASE WHEN status = "pay debt" THEN debt_amount ELSE 0 END) as pay_debt,
                    SUM(CASE WHEN status = "refund" THEN debt_amount ELSE 0 END) as refund
                ')
            ])
            ->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)
            ->where('customer_id',$customer_id)
            ->groupBy('ddate')->orderBy('ddate','desc')
            ->get();

            return response()->json(['sum'=>$sum,'data'=>$data,'customer'=>$customer]);

            // $interval = \DateInterval::createFromDateString('1 day');
            // $period = new \DatePeriod($begin, $interval, $end);
            // $enddate = date("Y-m-d 23:59:59", strtotime($end->format("Y-m-d")));
            // $totalD = $totalAP = $totalAS = "";
            // for($i = $end; $i >= $begin; $i->modify('-1 day')) {
            //     $fromdate = date("Y-m-d 00:00:00", strtotime($i->format("Y-m-d")));
            //     $todate = date("Y-m-d 23:59:59", strtotime($i->format("Y-m-d")));
            //     $debtA = $soldA = $borrowA = $paidA = $paidAL = $lendM = $payD = $refund = "";

            //     $totalD = CustomerDebt::where('company_id',Auth::user()->company_id)->where('shop_id',$sy,$shop_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('customer_id',$customer_id)->where('status','buy stock')->sum('debt_amount');
            //     $totalAS = CustomerDebt::where('company_id',Auth::user()->company_id)->where('shop_id',$sy,$shop_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('customer_id',$customer_id)->where('status','buy stock')->sum('stock_value');
            //     $totalAP = CustomerDebt::where('company_id',Auth::user()->company_id)->where('shop_id',$sy,$shop_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('customer_id',$customer_id)->where('status','buy stock')->sum('amount_paid');
            //     $totalAPL = CustomerDebt::where('company_id',Auth::user()->company_id)->where('shop_id',$sy,$shop_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('customer_id',$customer_id)->where('status','weka pesa')->sum('amount_paid');
            //     $totalLM = CustomerDebt::where('company_id',Auth::user()->company_id)->where('shop_id',$sy,$shop_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('customer_id',$customer_id)->where('status','lend money')->sum('debt_amount');
            //     $totalDP = CustomerDebt::where('company_id',Auth::user()->company_id)->where('shop_id',$sy,$shop_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('customer_id',$customer_id)->where('status','pay debt')->sum('debt_amount');
            //     $totalR = CustomerDebt::where('company_id',Auth::user()->company_id)->where('shop_id',$sy,$shop_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('customer_id',$customer_id)->where('status','refund')->sum('debt_amount');
            //     if ($totalAS) {
            //         $soldA = "<b> Alinunua bidhaa: ".number_format($totalAS)." <span class='view-bought-items' cid='".$customer_id."' cname='".$customer->name."' sdate='".$i->format("Y-m-d")."'><i class='fa fa-eye'></i></span></b><br>";
            //         if ($totalAP) {
            //             $paidA = "<b> Alilipa: ".number_format($totalAP)."</b><br>";
            //         }
            //         if ($totalD) {
            //             if ($totalD < 0) {
            //                 $debtA = "<b> Anadai: ".number_format(abs($totalD))."</b><br>";
            //             }
            //             if ($totalD > 0) {
            //                 $debtA = "<b> Anadaiwa: ".number_format($totalD)."</b><br>";
            //             }
            //         }
            //         $soldA = '<div class="xl-turquoise p-1">'.$soldA."".$paidA."".$debtA.'</div>';
            //     }
            //     if ($totalAPL) {
            //         $paidAL = '<div class="xl-turquoise p-1 mt-1"><b> Aliweka pesa: '.number_format($totalAPL).'</b> <span class="ml-1 px-2 py-1 edit edit-aliweka" sdate="'.$i->format("Y-m-d").'" amount="'.$totalAPL.'" customer="'.$customer_id.'"><i class="fa fa-edit"></i></span></div>';
            //     }
            //     if ($totalLM) {
            //         $interest = CustomerDebt::where('company_id',Auth::user()->company_id)->where('shop_id',$sy,$shop_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('customer_id',$customer_id)->where('status','lend money')->sum('interest');
            //         if($interest) {
            //             $fd = CustomerDebt::where('company_id',Auth::user()->company_id)->where('shop_id',$sy,$shop_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('customer_id',$customer_id)->where('status','lend money')->sum('amount_with_interest');
            //             $sd = CustomerDebt::where('company_id',Auth::user()->company_id)->where('shop_id',$sy,$shop_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('customer_id',$customer_id)->where('status','lend money')->where('interest',null)->sum('debt_amount');
            //             $total_w_i = $fd + $sd;
            //             $lendM = '<div class="xl-turquoise p-1 mt-1"> Alikopa: <b>'.number_format($totalLM).'</b> Riba: <b>'.number_format($interest).'%</b> Total: <b>'.number_format($total_w_i).'</b></div>';
            //         } else {
            //             $lendM = '<div class="xl-turquoise p-1 mt-1"><b> Alikopa: '.number_format($totalLM).'</b></div>';
            //         }                    
            //     }
            //     if ($totalDP) {
            //         $payD = '<div class="xl-turquoise p-1 mt-1"><b> Alilipwa: '.number_format($totalDP).'</b> <span class="ml-1 px-2 py-1 edit edit-alilipwa" sdate="'.$i->format("Y-m-d").'" amount="'.$totalDP.'" customer="'.$customer_id.'"><i class="fa fa-edit"></i></span></div>';
            //     }
            //     if ($totalR) {
            //         $refund = '<div class="xl-turquoise p-1 mt-1"><b> Alirudishiwa pesa: '.number_format($totalR).'</b> <span class="ml-1 px-2 py-1 edit edit-alirudishiwa" sdate="'.$i->format("Y-m-d").'" amount="'.$totalR.'" customer="'.$customer_id.'"><i class="fa fa-edit"></i></span></div>';
            //     }
            //     $deni = '<b>0</b>';
            //     if ($data['av_deni'] > 0) {
            //         $deni = '<b class="text-danger">'.number_format($data['av_deni']).'</b>';
            //     }
            //     if ($data['av_deni'] < 0) {
            //         $deni = '<b class="text-success">'.number_format(abs($data['av_deni'])).'</b>';
            //     }
            //     if ($totalAS || $totalAPL || $totalLM || $totalDP || $totalR) {
            //         $output[] = '<tr><td>'.$i->format("d/m/Y").'</td><td>'.$soldA.''.$paidAL.''.$lendM.''.$payD.''.$refund.'</td><td>'.$deni.'</td></tr>';
            //     } 
            //     $data["av_deni"] = $data["av_deni"] - $totalD + $totalAPL - $totalLM - $totalDP - $totalR;
            // }
            // if (!$totald) {
            //     $output[] = '<tr><td colspan="3" align="center"><i>-- No Debt Records --</i></td></tr>';
            // } 
            // return response()->json(['data'=>$data,'output'=>$output,'check'=>$fromdate]);
        }

        if($check == "update-shop-product") {
            $sid = $condition1;
            $pid = $condition2;
            $row = \DB::connection('tenant')->table('shop_products')->where('product_id',$pid)->where('shop_id',$sid)->where('active','yes');
            if($row->first()) {
                $pid = $row->first()->product_id;
                StockAdjustment::create(['from'=>'shop','from_id'=>$row->first()->shop_id,'product_id'=>$pid,'av_quantity'=>$row->first()->quantity,'company_id'=>Auth::user()->company_id, 'new_quantity'=>0,'status'=>'stock adjustment','description'=>'Unlink product and shop', 'user_id'=>Auth::user()->id]);
                $update = $row->update(['active'=>'no']);

                Log::channel('custom')->info('PID: '.$pid.', RemovingFromShop');
                
                if($update) {
                    $data['totalQty'] = \DB::connection('tenant')->table('shop_products')->join('shops','shops.id','shop_products.shop_id')->where('shops.company_id',Auth::user()->company_id)->where('shop_products.product_id',$pid)->where('shop_products.active','yes')->sum('quantity');
                    $data['totalQty2'] = \DB::connection('tenant')->table('store_products')->join('stores','stores.id','store_products.store_id')->where('stores.company_id',Auth::user()->company_id)->where('store_products.product_id',$pid)->where('store_products.active','yes')->sum('quantity');
                    $totalQty = $data['totalQty'] + $data['totalQty2'];
                    return response()->json(['status'=>'updated','totalq'=>$totalQty,'sid'=>$sid]);
                } else {
                    return response()->json(['status'=>'not updated']);
                }            
            } else {
                return response()->json(['status'=>'not updated']);
            }
        }
        
        if($check == "update-store-product") {
            $sid = $condition1;
            $pid = $condition2;
            $row = \DB::connection('tenant')->table('store_products')->where('product_id',$pid)->where('store_id',$sid)->where('active','yes');
            if($row->first()) {
                StockAdjustment::create(['from'=>'store','company_id'=>Auth::user()->company_id,'from_id'=>$row->first()->store_id,'product_id'=>$row->first()->product_id,'av_quantity'=>$row->first()->quantity,'new_quantity'=>0,'status'=>'stock adjustment','description'=>'Unlink product and store', 'user_id'=>Auth::user()->id]);
                $update = $row->update(['active'=>'no']);

                if($update) {
                    $data['totalQty'] = \DB::connection('tenant')->table('shop_products')->join('shops','shops.id','shop_products.shop_id')->where('shops.company_id',Auth::user()->company_id)->where('shop_products.product_id',$pid)->where('shop_products.active','yes')->sum('quantity');
                    $data['totalQty2'] = \DB::connection('tenant')->table('store_products')->join('stores','stores.id','store_products.store_id')->where('stores.company_id',Auth::user()->company_id)->where('store_products.product_id',$pid)->where('store_products.active','yes')->sum('quantity');
                    $totalQty = $data['totalQty'] + $data['totalQty2'];
                    return response()->json(['status'=>'updated','totalq'=>$totalQty,'sid'=>$sid]);
                } else {
                    return response()->json(['status'=>'not updated']);
                }            
            } else {
                return response()->json(['status'=>'not updated']);
            }
        }

        if($check == "change-sell-order") {
            $sid = $condition1;
            $val = $condition2;
            $data['shop'] = Shop::where('id',$sid)->where('company_id',Auth::user()->company_id)->first();
            if($data['shop']) {
                $data['shop']->update(['sell_order'=>$val]);
                return response()->json(['status'=>'success','val'=>$val]);
            }
        }
        
    }

    public function get_form($check, $conditions) { 
        if ($check == "new-product") {
            $data['from'] = $conditions;
            if($data['from'] == "0") { // this is from products section, NOT from shop / store
            } else {
                $ssi = explode("~",$data['from']);
                $data['from'] = $ssi[0];
                if($data['from'] == "shop") {
                    $data['shop_id'] = $ssi[1]; 
                }
                if($data['from'] == "store") {
                    $data['store_id'] = $ssi[1]; 
                }
            }
            $data['groups'] = ProductCategoryGroup::where('company_id',Auth::user()->company_id)->get();
            $data['cats'] = ProductCategory::where('status','!=','deleted')->orWhereNull('status')->where('company_id',Auth::user()->company_id)->orderBy('name')->get();
            if($data['cats']->isEmpty()) {
                $pcg = ProductCategoryGroup::where('company_id',Auth::user()->company_id)->first();
                $add = ProductCategory::create(['name'=>'un-categorized','product_category_group_id'=>$pcg->id,'company_id'=>Auth::user()->company_id, 'user_id' => Auth::user()->id]);
                if($add) {
                    $data['cats'] = ProductCategory::where('status','!=','deleted')->orWhereNull('status')->where('company_id',Auth::user()->company_id)->orderBy('name')->get();
                }
            }
            $data['measurements'] = Measurement::where('company_id',Auth::user()->company_id)->get();
            $view = view('forms.new-product',compact('data'))->render();
            return response()->json(['form'=>$view]);
        }

        if ($check == "new-sub-category") {
            $data['main-cat'] = ProductCategoryGroup::where('company_id',Auth::user()->company_id)->where('name','main')->first();
            if($data['main-cat']) { } else {
                $create = ProductCategoryGroup::create(['name'=>'main','company_id'=>Auth::user()->company_id,'user_id'=>Auth::user()->id]);
                if($create) {
                    $data['main-cat'] = ProductCategoryGroup::find($create->id);
                }
            }
            $view = view('forms.new-sub-category',compact('data'))->render();
            return response()->json(['form'=>$view]);
        }

        if ($check == "new-stock") {
            $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
            $data['stores'] = Store::where('company_id',Auth::user()->company_id)->get();
            $view = view('forms.new-stock',compact('data'))->render();
            return response()->json(['form'=>$view]);
        }
    }

}
 