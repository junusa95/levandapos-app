<?php

namespace App\Http\Controllers\Apps;

use App\CustomerDebt;
use App\DailySale;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProductController;
use App\Product;
use App\Sale;
use App\SalePayment;
use App\ShopExpense;
use App\ShopProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\CarbonPeriod;


class SaleController extends Controller
{

    public function makeSale(Request $request){
        $validator = Validator::make($request->all(), [
            'productId' => 'required|array',
            'prises' => 'required|array',
            'quantities' => 'required|array',
            'shopId' => 'required',
            'totalAmount' => 'required',
            'sell_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }


        $productIds = $request->input('productId');
        $shop_id =  $request->input('shopId');
        $quantities =  $request->input('quantities');
        $prices =  $request->input('prises');

        try {

            DB::beginTransaction();

            foreach ($productIds as $key => $product_id) {
                $product = Product::where('id', $product_id)
                    ->where('company_id', Auth::user()->company_id)
                    ->first();

                $productRaw = DB::connection('tenant')->table('shop_products')
                    ->where('shop_id', $shop_id)
                    ->where('product_id', $product_id)
                    ->where('active', 'yes')
                    ->first();

                if (!empty($productRaw)) {

                    if ($quantities[$key] > $productRaw->quantity) {
                        return response()->json([
                            'status' => 0,
                            'message' => 'product ' . ($product ? $product->name : 'Unknown Product') . ' not enough quantity',
                        ]);
                    }

                }else{
                     return response()->json([
                        'status' => 0,
                       'message' => 'product ' . ($product ? $product->name : 'Unknown Product') . ' not belong to our shop',
                    ]);
                }
            }

            $check = Sale::where('status', '!=', 'draft')
                ->where('company_id', Auth::user()->company_id)
                ->orderBy('sale_val', 'desc')
                ->first();

            $val = $check ? ($check->sale_val + 1) : 1;
            $valStr = str_pad($val, 2, '0', STR_PAD_LEFT);
            $s_no = "SLN" . Auth::user()->id . $valStr;

            // $submitted_at = date('Y-m-d H:i:s');
            $submitted_at = $request->input('sell_date');
            $totalAmount = 0;
            $totalQuantity = 0;

            foreach ($productIds as $key => $product_id) {
                $product = Product::where('id', $product_id)
                    ->where('company_id', Auth::user()->company_id)
                    ->first();

                $sale =  Sale::create([
                    'shop_id' => $shop_id,
                    'product_id' => $product_id,
                    'quantity' => $quantities[$key],
                    'buying_price' => $product->buying_price,
                    'total_buying' => $product->buying_price,
                    'company_id' => Auth::user()->company_id,
                    'selling_price' => $prices[$key],
                    'sub_total' => $prices[$key] * $quantities[$key],
                    'user_id' => Auth::user()->id,
                    'sale_type' => 'retail',
                    'status' => 'sold',
                    'submitted_at' => $submitted_at,
                    'created_at' => $submitted_at,
                    'updated_at' => $submitted_at,
                    'sale_val' => $val,
                    'customer_id' => $request->customer_id,
                    'sale_no' => $s_no,
                ]);

                $totalAmount += $sale->sub_total;
                $totalQuantity += $sale->quantity;

                $q = DB::connection('tenant')->table('shop_products')->where('product_id',$product_id)->where('shop_id', $shop_id)->where('active', 'yes');
                if ($q->first()) {
                    $quantity = ($q->first()->quantity - $sale->quantity);
                    $q->update(['quantity'=>$quantity]);
                }

                if(Auth::user()->company->isCheckingStockLevel()){
                    $pro = Product::find($product_id);
                    if($pro->min_stock_level >=  $sale->quantity) {
                        ProductController::insertMSL($pro->id,'shop',$shop_id,$pro->min_stock_level);
                    }
                }
            }

            // if(!empty($request->input('totalAmount'))){
            //     $payment = new SalePayment();
            //     $payment->sale_no = $s_no;
            //     $payment->customer_id = $request->customer_id;
            //     $payment->total_amount = $totalAmount;
            //     $payment->paid_amount = $request->input('totalAmount');
            //     $payment->save();
            // }

            $amount = $request->input('totalAmount');

            if(!empty($request->input('customer_id'))){
                $check3 = Sale::where('sale_no',$s_no)->where('company_id',Auth::user()->company_id)->first();
                if ($check3->customer_id) {
                    $subtotal = Sale::where('sale_no',$s_no)->where('company_id',Auth::user()->company_id)->sum('sub_total');
                    if ($amount != "-") {
                        $debt = $subtotal - $amount;
                        CustomerDebt::create([
                            'shop_id'=>$check3->shop_id,
                            'customer_id'=>$check3->customer_id,
                            'debt_amount'=>$debt,
                            'status'=>"buy stock",
                            'stock_value'=>$subtotal,
                            'amount_paid'=>$amount,
                            'reference'=>$check3->sale_no,
                            'company_id'=>Auth::user()->company_id,
                            'user_id'=>Auth::user()->id,
                            'updated_at'=>$submitted_at
                        ]);
                    }
                }
            }

            if (!empty($request->input('sell_date'))) {
                $sale_date = $request->input('sell_date');
                if( Carbon::now()->toDateString() != $sale_date){
                    $this->recordDailySales($shop_id, $sale_date);
                }
            }

            DB::commit();
            $sale = Sale::select(DB::raw('SUM(quantity) as squantity, SUM(sub_total) as sprice'))->where('user_id', Auth::user()->id)->where('company_id', Auth::user()->company_id)->where('shop_id', $shop_id)->where('status', 'sold')->get();
            return response()->json([
                'status'=> 1,
                'message'=> 'success',
                'data' => $sale,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }

    }

    // public function sales($shop_id, $startDate, $endDate){
    public function sales_stat($shop_id){
        $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $endDate   = Carbon::now()->endOfMonth()->format('Y-m-d');

        $sales = Sale::where('shop_id',$shop_id)
            ->where('company_id',Auth::user()->company_id)
            ->where('status','sold')
            ->whereBetween(DB::raw('DATE(updated_at)'), [$startDate, $endDate])
            // ->with('product')
            // ->with('customer')
            ->orderBy('updated_at','desc')
            ->get();

        $expenses = ShopExpense::where('company_id', Auth::user()->company_id)
            ->where('shop_id', $shop_id)
            ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
            ->get();

        // $data['sales'] = $sales->count();
        $data['total_quantity'] = $sales->sum('quantity');
        $data['total_sub_total'] = $sales->sum('sub_total');
        $data['total_expenses'] = $expenses->sum('amount');;

        return response()->json([
            'status' => 1,
            'message'=> 'success',
            'data' => $data
        ]);
    }
    public function sales($shop_id, $startDate, $endDate){
        $sales = Sale::with(['product:id,name'])
            ->select('id','product_id','quantity','selling_price','sub_total','updated_at', 'status', 'company_id','shop_id', 'customer_id')
            ->where('shop_id',$shop_id)
            ->where('company_id',Auth::user()->company_id)
            ->where('status','sold')
            ->whereBetween(DB::raw('DATE(updated_at)'), [$startDate, $endDate])
            // ->with('product')
            // ->with('customer')
            ->orderBy('id','desc')
            ->get();

        $customer_ids = $sales->pluck('customer_id')->unique()->filter();
        $customers_deposit = DB::connection('tenant')->table('customer_debts')
            // ->whereIn('customer_id', [176])
            // ->whereIn('customer_id', $customer_ids)
            ->where('shop_id',$shop_id)
            ->where('company_id', Auth::user()->company_id)
            ->where('status','weka pesa')
            ->whereBetween(DB::raw('DATE(updated_at)'), [$startDate, $endDate])
            // ->get();
            ->sum('amount_paid');

            // $customers_deposit = CustomerDebt::where('customer_id', 174)->whereBetween(DB::raw('DATE(updated_at)'), [$startDate, $endDate])->orderBy('updated_at', 'desc')->get();



            // return $sales;

        $customers_debt = DB::connection('tenant')->table('customer_debts')
            ->whereIn('customer_id', $customer_ids)
            ->where('shop_id',$shop_id)
            ->where('status','<>','weka pesa')
            ->where('status','<>','buy stock')
            ->where('status','<>','deleted')
            ->where('company_id', Auth::user()->company_id)
            ->whereBetween(DB::raw('DATE(updated_at)'), [$startDate, $endDate])
            ->sum('debt_amount');

        $negative_buy_stock = DB::connection('tenant')->table('customer_debts')
            ->whereIn('customer_id', $customer_ids)
            ->where('shop_id',$shop_id)
            ->where('status','buy stock')
            ->where('company_id', Auth::user()->company_id)
            ->whereBetween(DB::raw('DATE(updated_at)'), [$startDate, $endDate])
            ->where('debt_amount', '<', 0)
            // ->sum('debt_amount');
            ->select(DB::raw('ABS(SUM(debt_amount)) as total'))
            ->value('total');

        $positive_buy_stock = DB::connection('tenant')->table('customer_debts')
            ->whereIn('customer_id', $customer_ids)
            ->where('shop_id',$shop_id)
            ->where('status','buy stock')
            ->where('company_id', Auth::user()->company_id)
            ->whereBetween(DB::raw('DATE(updated_at)'), [$startDate, $endDate])
            ->where('debt_amount', '>', 0)
            ->sum('debt_amount');

            // return $customers_deposit;

        $total_expenses= ShopExpense::where('company_id',Auth::user()->company_id)
        ->where('shop_id',$shop_id)
        ->whereBetween(DB::raw('DATE(created_at)'), [Carbon::parse($startDate),Carbon::parse($endDate)])
        ->sum('amount');

        $data['sales'] = $sales;
        $data['total_quantity'] = $sales->sum('quantity');
        $data['total_sub_total'] = $sales->sum('sub_total');
        $data['total_available_cash'] = ($sales->sum('sub_total')+$customers_deposit+$negative_buy_stock) - ($total_expenses+$customers_debt+$positive_buy_stock);
        $data['total_expenses'] = $total_expenses;
        $data['customers_debt'] = $customers_debt;
        $data['customers_deposit'] = $customers_deposit;
        $data['negative_buy_stock'] = $negative_buy_stock;
        $data['positive_buy_stock'] = $positive_buy_stock;

        return response()->json([
            'status' => 1,
            'message'=> 'success',
            'data' => $data
        ]);
    }
    public function sales_update(Request $request){
        $data = array();
        $id = $request->input('id');
        $qty = $request->input('quantity');
        $price = $request->input('amount');
        $row = Sale::where('id',$id)->where('company_id',Auth::user()->company_id)->first();
        if ($row) {
            if ($row->quantity == $qty && $row->selling_price == $price) {
                return response()->json(['success'=>'Nothing edited']);
            } else {
                $solddate = date("d-m-Y", strtotime($row->updated_at));
                $q = DB::connection('tenant')->table('shop_products')->where('shop_id',$row->shop_id)->where('product_id',$row->product_id)->where('active','yes');
                if ($q->first()) {
                    $edited_at = date('Y-m-d H:i:s');
                    $total_buying = ($qty * $row->buying_price);
                    $subtotal = $qty*$price;
                    $diffQ = $row->quantity - $qty;
                    $update = DB::connection('tenant')->table('sales')->where('id',$id)->where('company_id',Auth::user()->company_id)->update(['status'=>'edited']);
                    if ($update) {
                        $data = $row->replicate();
                        $data = $data->toArray();
                        $create = Sale::create($data);
                        $create->update(['quantity'=>$qty,'selling_price'=>$price,'total_buying'=>$total_buying,'sub_total'=>$subtotal,'edited_at'=>$edited_at,'edited_by'=>Auth::user()->id,'status'=>'sold','created_at'=>$row->created_at,'updated_at'=>$row->updated_at]);
                        $quantity = ($q->first()->quantity + $diffQ);
                        $q->update(['quantity'=>$quantity]);
                        $deni = CustomerDebt::where('reference',$row->sale_no)->where('company_id',Auth::user()->company_id)->first();
                        if ($deni) {
                            $stock_val = Sale::where('sale_no',$row->sale_no)->where('company_id',Auth::user()->company_id)->where('status','sold')->sum('sub_total');
                            $amount_paid = $deni->amount_paid;
                            $newdeni = $stock_val - $amount_paid;
                            $deni->update(['debt_amount'=>$newdeni,'stock_value'=>$stock_val]);
                        }
                    }
                }

                $data['predate'] = "no";
                if ($solddate != date("d-m-Y")) { //check if deleting today sold item OR previous date
                    $data['predate'] = $solddate;
                }

                // return response()->json(['success'=>'edited','data'=>$data]);

                return response()->json([
                    'status' => 1,
                    'message'=> 'success',
                    // 'data' => $data
                ]);
            }
        }

    }

   public function sales_top_sold_product($shop_id, $startDate, $endDate)
{
    $sales = Sale::query()
        ->select([
            'products.name as pname',
            DB::raw("SUM(sales.quantity) as total_qty"),
            DB::raw("SUM(sales.sub_total) as total_sales"),
            DB::raw("SUM(sales.total_buying) as total_buying"),
            DB::raw("(SUM(sales.sub_total) - SUM(sales.total_buying)) as profit")
        ])
        ->join('products', 'products.id', '=', 'sales.product_id')
        ->where('sales.status', 'sold')
        ->where('sales.company_id', Auth::user()->company_id)
        ->where('sales.shop_id', $shop_id)
        ->whereBetween('sales.updated_at', [
            Carbon::parse($startDate)->startOfDay(),
            Carbon::parse($endDate)->endOfDay()
        ])
        ->groupBy('sales.product_id', 'products.name')
        ->orderByDesc('total_qty') // top selling products
        ->get();

        return response()->json([
            'status' => 1,
            'message' => 'success',
            'data' => [
                'sales' => $sales
            ]
        ]);
    }

    public function sales_and_profit($shop_id, $startDate, $endDate){

        $sales = Sale::query()
            ->select([
                DB::raw("DATE(updated_at) as sales_date"),
                DB::raw("COALESCE(SUM(quantity), 0) as total_qty"),
                DB::raw("COALESCE(SUM(sub_total), 0) as total_sales"),
                DB::raw("COALESCE(SUM(total_buying), 0) as total_buying_price"),
                DB::raw("(COALESCE(SUM(sub_total), 0) - COALESCE(SUM(total_buying), 0)) as profit"),
            ])
            ->where('status', 'sold')
            ->where('company_id', Auth::user()->company_id)
            ->where('shop_id', $shop_id)
            ->whereBetween(DB::raw('DATE(updated_at)'), [$startDate, $endDate])
            ->groupBy(DB::raw("sales_date"))
            ->get();

        $expenses = ShopExpense::select([
                DB::raw("DATE(created_at) as expense_date"),
                DB::raw("COALESCE(SUM(amount), 0) as total_expense_amount")
            ])
            ->where('company_id', Auth::user()->company_id)
            ->where('shop_id', $shop_id)
            ->whereBetween(DB::raw("DATE(created_at)"), [
                Carbon::parse($startDate),
                Carbon::parse($endDate)
            ])
            ->groupBy(DB::raw("DATE(created_at)"))
            ->get();

            // return $expenses;

            $sales_map = $sales->keyBy('sales_date');
        $expense_map = $expenses->pluck('total_expense_amount', 'expense_date');


        $period = CarbonPeriod::create($startDate, $endDate);

        $final = collect();

        foreach ($period as $date) {
            $d = $date->format('Y-m-d');

            $sale = $sales_map[$d] ?? null;

            $final->push([
                'date' => $d,
                'total_qty' => $sale->total_qty ?? 0,
                'total_sales' => $sale->total_sales ?? 0,
                'total_buying_price' => $sale->total_buying_price ?? 0,
                'profit' => $sale->profit ?? 0,

                // expenses default to 0 even if sales is missing
                'total_expense_amount' => $expense_map[$d] ?? 0,
                'net_profit' => ($sale->profit ?? 0) - ($expense_map[$d] ?? 0),

            ]);
        }

        $final = $final->reverse()->values();

        $totalEX = ShopExpense::where('company_id',Auth::user()->company_id)
        ->where('shop_id',$shop_id)
        ->whereBetween(DB::raw("DATE(created_at)"), [Carbon::parse($startDate),Carbon::parse($endDate)])
        ->sum('amount');

        // return response()->json(['sales'=>$sales,'totalEX'=>$totalEX]);

        $data['totals'] = [
            'total_qty'        => $final->sum('total_qty'),
            'total_sales'      => $final->sum('total_sales'),
            // 'total_buying'     => $final->sum('total_buying_price'),
            'total_profit'     => $final->sum('profit'),
            'total_expenses'   => $final->sum('total_expense_amount'),
            'total_net_profit' => $final->sum('net_profit'),
        ];

        $data['sales'] = $final;
        $data['total_expenses'] = $totalEX;

        return response()->json([
            'status' => 1,
            'message'=> 'success',
            'data' => $data
        ]);
    }

    public function sales_delete($sale_id){
        $row = Sale::where('id',$sale_id)->where('company_id',Auth::user()->company_id)->first();
            if ($row) {
                $edited_at = date('Y-m-d H:i:s');
                $solddate = date("d-m-Y", strtotime($row->updated_at));
                $q = DB::connection('tenant')->table('shop_products')->where('shop_id',$row->shop_id)->where('product_id',$row->product_id)->where('active','yes');
                if ($q->first()) {
                    $update = $row->update(['status'=>'deleted','edited_at'=>$edited_at,'edited_by'=>Auth::user()->id]);
                    if ($update) {
                        $quantity = ($q->first()->quantity + $row->quantity);
                        $q->update(['quantity'=>$quantity]);
                        $deni = CustomerDebt::where('reference',$row->sale_no)->where('company_id',Auth::user()->company_id)->first();
                        if ($deni) {
                            $stock_val = Sale::where('sale_no',$row->sale_no)->where('status','sold')->where('company_id',Auth::user()->company_id)->sum('sub_total');
                            if ($stock_val) {
                                $amount_paid = $deni->amount_paid;
                                $newdeni = $stock_val - $amount_paid;
                                $deni->update(['debt_amount'=>$newdeni,'stock_value'=>$stock_val]);
                            } else {
                                $deni->delete();
                            }
                        }

                        $data['predate'] = "no";
                        if ($solddate != date("d-m-Y")) { //check if deleting today sold item OR previous date
                            $data['predate'] = $solddate;
                        }

                        // return response()->json(['success'=>'deleted','data'=>$data]);
                        return response()->json([
            'status' => 1,
            'message'=> 'success',
            // 'data' => $data
        ]);
                    }
                } else {
                    $update = $row->update(['status'=>'deleted','edited_at'=>$edited_at,'edited_by'=>Auth::user()->id]);
                    if($update) {
                        $deni = CustomerDebt::where('reference',$row->sale_no)->where('company_id',Auth::user()->company_id)->first();
                        if ($deni) {
                            $stock_val = Sale::where('sale_no',$row->sale_no)->where('status','sold')->where('company_id',Auth::user()->company_id)->sum('sub_total');
                            if ($stock_val) {
                                $amount_paid = $deni->amount_paid;
                                $newdeni = $stock_val - $amount_paid;
                                $deni->update(['debt_amount'=>$newdeni,'stock_value'=>$stock_val]);
                            } else {
                                $deni->delete();
                            }
                        }

                        $data['predate'] = "no";
                        if ($solddate != date("d-m-Y")) { //check if deleting today sold item OR previous date
                            $data['predate'] = $solddate;
                        }

                        // return response()->json(['success'=>'deleted','data'=>$data]);
                        return response()->json([
            'status' => 1,
            'message'=> 'success',
            // 'data' => $data
        ]);
                    }
                }
            } else {
                // return response()->json(['error'=>'error']);
                return response()->json([
            'status' => 1,
            'message'=> 'error',
            // 'data' => $data
        ]);
            }
    }

    public function sales_and_profit_view($shop_id, $date){

        $sales = Sale::query()
            ->select([
                DB::raw("DATE(updated_at) as sales_date"),
                DB::raw("COALESCE(SUM(quantity), 0) as total_qty"),
                DB::raw("COALESCE(SUM(sub_total), 0) as total_sales"),
                DB::raw("COALESCE(SUM(total_buying), 0) as total_buying_price"),
                DB::raw("(COALESCE(SUM(sub_total), 0) - COALESCE(SUM(total_buying), 0)) as profit"),
            ])
            ->where('status', 'sold')
            ->where('company_id', Auth::user()->company_id)
            ->where('shop_id', $shop_id)
            ->whereDate(DB::raw('DATE(updated_at)'), $date)
            ->groupBy(DB::raw("sales_date"))
            ->get();

        $expenses = ShopExpense::select([
                DB::raw("DATE(created_at) as expense_date"),
                DB::raw("COALESCE(SUM(amount), 0) as total_expense_amount")
            ])
            ->where('company_id', Auth::user()->company_id)
            ->where('shop_id', $shop_id)
            ->whereDate('created_at',
                Carbon::parse($date)
            )
            ->groupBy(DB::raw("DATE(created_at)"))
            ->get();

            $sales_map = $sales->keyBy('sales_date');
        $expense_map = $expenses->pluck('total_expense_amount', 'expense_date');


        // $period = CarbonPeriod::create($startDate, $endDate);

        $final = collect();

        // foreach ($period as $date) {
            $d = $date;

            $sale = $sales_map[$d] ?? null;

            $final->push([
                'date' => $d,
                'total_qty' => $sale->total_qty ?? 0,
                'total_sales' => $sale->total_sales ?? 0,
                'total_buying_price' => $sale->total_buying_price ?? 0,
                'profit' => $sale->profit ?? 0,

                // expenses default to 0 even if sales is missing
                'total_expense_amount' => $expense_map[$d] ?? 0,
                'net_profit' => ($sale->profit ?? 0) - ($expense_map[$d] ?? 0),

            ]);
        // }

        $totalEX = ShopExpense::where('company_id',Auth::user()->company_id)
        ->where('shop_id',$shop_id)
        // ->whereBetween('created_at', [Carbon::parse($startDate),Carbon::parse($endDate)])
            ->whereDate('created_at',
                Carbon::parse($date)
            )
        ->sum('amount');

        // return response()->json(['sales'=>$sales,'totalEX'=>$totalEX]);

        $data['totals'] = [
            'total_qty'        => $final->sum('total_qty'),
            'total_sales'      => $final->sum('total_sales'),
            // 'total_buying'     => $final->sum('total_buying_price'),
            'total_profit'     => $final->sum('profit'),
            'total_expenses'   => $final->sum('total_expense_amount'),
            'total_net_profit' => $final->sum('net_profit'),
        ];

        $sales_products = Sale::with(['product:id,name,image'])
            ->select([
                'id',
                'product_id',
                'quantity',
                'sub_total',
                'selling_price',
                'buying_price',
                'updated_at',
                'status',
                'company_id',
                'shop_id'
            ])
            ->where('status', 'sold')
            ->where('company_id', Auth::user()->company_id)
            ->where('shop_id', $shop_id)
            ->whereDate(DB::raw('DATE(updated_at)'), Carbon::parse($date))
            ->get();

        // $data['sales'] = $final;
        $data['sales'] = $sales_products;
        $data['total_expenses'] = $totalEX;

        return response()->json([
            'status' => 1,
            'message'=> 'success',
            'data' => $data
        ]);
    }

    public function sales_more_details($shop_id, $date){

        $allStatuses = ['buy stock', 'weka pesa', 'refund', 'lend money'];
        $date = Carbon::parse($date)->toDateString();

        $debts = CustomerDebt::select([
                'customers.id as customer_id',
                'customers.name as customer_name',
                DB::raw("COALESCE(customer_debts.status, 'no_status') as status"),
                DB::raw('SUM(customer_debts.debt_amount) as total_amount')
            ])
            ->join('customers', 'customers.id', '=', 'customer_debts.customer_id')
            ->where('customer_debts.shop_id', $shop_id)
            ->where('customer_debts.company_id', Auth::user()->company_id)
            ->where('customer_debts.status', '<>', 'deleted')
            ->whereDate('customer_debts.updated_at', Carbon::parse($date))
            ->groupBy('customers.id', 'customers.name', 'customer_debts.status')
            ->orderBy('customers.id')
            ->get();

        // $grouped = $debts->groupBy('customer_id')->map(function ($rows) use ($allStatuses) {
        //     $customer = $rows->first();
        //     $statusMap = $rows->pluck('total_amount', 'status');

        //     // Ensure all statuses exist, fill missing ones with 0
        //     $filledStatuses = collect($allStatuses)->map(function ($status) use ($statusMap) {
        //         return [
        //             'status' => $status,
        //             'total_amount' => $statusMap[$status] ?? 0,
        //         ];
        //     });

        //     return [
        //         'customer_id' => $customer->customer_id,
        //         'customer_name' => $customer->customer_name,
        //         'statuses' => $filledStatuses
        //     ];
        // })->values();

        $grouped = $debts->groupBy('customer_id')->map(function ($rows) use ($allStatuses) {
            $customer = $rows->first();
            $statusMap = $rows->pluck('total_amount', 'status');

            $filled = [];
            foreach ($allStatuses as $status) {
                $filled[$status] = [
                    'status' => $status,
                    'total_amount' => $statusMap[$status] ?? 0,
                ];
            }

            if ($filled['buy stock']['total_amount'] < 0) {
                $positive = abs($filled['buy stock']['total_amount']);

                $filled['weka pesa']['total_amount'] += $positive;

                $filled['buy stock']['total_amount'] = 0;
            }

            $finalStatuses = collect($filled)->values();

            return [
                'customer_id' => $customer->customer_id,
                'customer_name' => $customer->customer_name,
                'statuses' => $finalStatuses
            ];
        })->values();


        $expenses = ShopExpense::select([
                DB::raw("DATE(created_at) as expense_date"),
                DB::raw("COALESCE(SUM(amount), 0) as total_expense_amount")
            ])
            ->where('company_id', Auth::user()->company_id)
            ->where('shop_id', $shop_id)
            ->whereDate('created_at', Carbon::parse($date))
            ->groupBy(DB::raw("DATE(created_at)"))
            ->get();



        $data['sales'] = $grouped;
        $data['total_expenses'] = $expenses->sum('total_expense_amount');

        return response()->json([
            'status' => 1,
            'message'=> 'success',
            'data' => $data
        ]);
    }

    public function sales_sold_by($shop_id, $date){
         $sales = Sale::with([
            'soldBy:id,name',
            'customer:id,name',
            'product:id,name,image'
        ])
        ->select([
            'id as rid',
            'customer_id',
            'product_id',
            'quantity',
            'selling_price',
            'sub_total',
            DB::raw('DATE(updated_at) as updated'),
            'user_id'
        ])
        ->whereNotNull('customer_id')
        ->whereDate('updated_at', $date)
        ->where('shop_id', $shop_id)
        ->where('status', 'sold')
        ->where('company_id', Auth::user()->company_id)
        ->orderBy('customer_id', 'desc')
        ->get()
        // ->groupBy('customer_id');
        ->groupBy(function ($sale) {
            return $sale->soldBy->name;
        });

        $customer_ids = $sales->pluck('customer_id')->unique()->filter();
        $customers_deposit = DB::connection('tenant')->table('customer_debts')
            ->whereIn('customer_id', $customer_ids)
            ->where('shop_id',$shop_id)
            ->where('status','weka pesa')
            ->where('company_id', Auth::user()->company_id)
            ->whereBetween(DB::raw('DATE(updated_at)'), [$date, $date])
            ->sum('amount_paid');

        $customers_debt = DB::connection('tenant')->table('customer_debts')
            ->whereIn('customer_id', $customer_ids)
            ->where('shop_id',$shop_id)
            ->where('status','<>','weka pesa')
            ->where('status','<>','deleted')
            ->where('company_id', Auth::user()->company_id)
            ->whereBetween(DB::raw('DATE(updated_at)'), [$date, $date])
            ->sum('debt_amount');

        $total_expenses= ShopExpense::where('company_id',Auth::user()->company_id)
        ->where('shop_id',$shop_id)
        ->whereBetween('created_at', [Carbon::parse($date),Carbon::parse($date)])
        ->sum('amount');

        $data['sales'] = $sales;
        $data['total_quantity'] = $sales->flatten()->sum('quantity');
        $data['total_sub_total'] = $sales->flatten()->sum('sub_total');
        $data['total_available_cash'] = ($sales->sum('sub_total')+$customers_deposit) - ($total_expenses+$customers_debt);

        return response()->json([
            'status' => 1,
            'message'=> 'success',
            'data' => $data
        ]);
    }

    public function sales_by_customer($shop_id, $date){
        // $sales = Sale::where('shop_id',$shop_id)
        //     ->where('company_id',Auth::user()->company_id)
        //     ->where('status','sold')
        //     ->whereNotNull('customer_id')
        //     ->whereBetween(DB::raw('DATE(submitted_at)'), [$startDate, $endDate])
        //     ->with(['customer'])
        //     // ->with('customer')
        //     ->orderBy('id','desc')
        //     ->get();

        // $data['sales'] = $sales;
        // $data['total_quantity'] = $sales->sum('quantity');
        // $data['total_sub_total'] = $sales->sum('sub_total');
        // return 123;
        $sales = Sale::with([
            'customer:id,name',
            'product:id,name,image'
        ])
        ->select([
            'id as rid',
            'customer_id',
            'product_id',
            'quantity',
            'selling_price',
            'sub_total',
            DB::raw('DATE(updated_at) as updated'),
            'user_id'
        ])
        ->whereNotNull('customer_id')
        ->whereDate('updated_at', $date)
        ->where('shop_id', $shop_id)
        ->where('status', 'sold')
        ->where('company_id', Auth::user()->company_id)
        ->orderBy('customer_id', 'desc')
        ->get()
        // ->groupBy('customer_id');
        ->groupBy(function ($sale) {
            return $sale->customer->name;
        });

        $customer_ids = $sales->pluck('customer_id')->unique()->filter();
        $customers_deposit = DB::connection('tenant')->table('customer_debts')
            ->whereIn('customer_id', $customer_ids)
            ->where('shop_id',$shop_id)
            ->where('status','weka pesa')
            ->where('company_id', Auth::user()->company_id)
            ->whereBetween(DB::raw('DATE(updated_at)'), [$date, $date])
            ->sum('amount_paid');

        $customers_debt = DB::connection('tenant')->table('customer_debts')
            ->whereIn('id', $customer_ids)
            ->where('shop_id',$shop_id)
            ->where('status','<>','weka pesa')
            ->where('status','<>','deleted')
            ->where('company_id', Auth::user()->company_id)
            ->whereBetween(DB::raw('DATE(updated_at)'), [$date, $date])
            ->sum('debt_amount');

        $total_expenses= ShopExpense::where('company_id',Auth::user()->company_id)
        ->where('shop_id',$shop_id)
        ->whereBetween('created_at', [Carbon::parse($date),Carbon::parse($date)])
        ->sum('amount');

        $data['sales'] = $sales;
        $data['total_quantity'] = $sales->flatten()->sum('quantity');
        $data['total_sub_total'] = $sales->flatten()->sum('sub_total');
        $data['total_available_cash'] = ($sales->sum('sub_total')+$customers_deposit) - ($total_expenses+$customers_debt);

        return response()->json([
            'status' => 1,
            'message'=> 'success',
            'data' => $data
        ]);
    }
    public function sales_by_number($shop_id, $date){
        $sales = Sale::with([
            'customer:id,name',
            'product:id,name,image'
        ])
        ->select([
            'id as rid',
            'customer_id',
            'product_id',
            'quantity',
            'selling_price',
            'sub_total',
            'sale_no',
            DB::raw('DATE(updated_at) as updated'),
            'user_id'
        ])
        ->whereNotNull('customer_id')
        ->whereDate('updated_at', $date)
        ->where('shop_id', $shop_id)
        ->where('status', 'sold')
        ->where('company_id', Auth::user()->company_id)
        ->orderBy('customer_id', 'desc')
        ->get()
        ->groupBy('sale_no');
        // ->groupBy(function ($sale) {
        //     return $sale->customer->name;
        // });

        $customer_ids = $sales->pluck('customer_id')->unique()->filter();
        $customers_deposit = DB::connection('tenant')->table('customer_debts')
            ->whereIn('customer_id', $customer_ids)
            ->where('shop_id',$shop_id)
            ->where('status','weka pesa')
            ->where('company_id', Auth::user()->company_id)
            ->whereBetween(DB::raw('DATE(updated_at)'), [$date, $date])
            ->sum('amount_paid');

        $customers_debt = DB::connection('tenant')->table('customer_debts')
            ->whereIn('id', $customer_ids)
            ->where('shop_id',$shop_id)
            ->where('status','<>','weka pesa')
            ->where('status','<>','deleted')
            ->where('company_id', Auth::user()->company_id)
            ->whereBetween(DB::raw('DATE(updated_at)'), [$date, $date])
            ->sum('debt_amount');

        $total_expenses= ShopExpense::where('company_id',Auth::user()->company_id)
        ->where('shop_id',$shop_id)
        ->whereBetween('created_at', [Carbon::parse($date),Carbon::parse($date)])
        ->sum('amount');

        $data['sales'] = $sales;
        $data['total_quantity'] = $sales->flatten()->sum('quantity');
        $data['total_sub_total'] = $sales->flatten()->sum('sub_total');
        $data['total_available_cash'] = ($sales->sum('sub_total')+$customers_deposit) - ($total_expenses+$customers_debt);

        return response()->json([
            'status' => 1,
            'message'=> 'success',
            'data' => $data
        ]);
    }

    public function sales_top_item($shop_id, $date){
        // return $date;
        // bado kutafuta profit
       $data['topItem'] = Sale::select(
            'product_id',
            DB::raw('COUNT(*) as times_sold'),      // how many sales entries
            DB::raw('SUM(quantity) as total_quantity'), // total items sold
            DB::raw('SUM(sub_total) as total_sub_total')
        )
        ->where('shop_id', $shop_id)
        ->where('company_id', Auth::user()->company_id)
        ->where('status', 'sold')
        ->whereNotNull('product_id')
        ->whereBetween(DB::raw('DATE(submitted_at)'), [$startDate, $endDate])
        ->groupBy('product_id')
        ->orderByDesc('times_sold') // or orderByDesc('times_sold')
        ->with('product:id,name,image') // make sure Sale model has product() relation
        ->get(); // top item only

        return response()->json([
            'status' => 1,
            'message'=> 'success',
            'data' => $data
        ]);

        // $sales = Sale::with([
        //     'soldBy:id,name',
        //     'customer:id,name',
        //     'product:id,name'
        // ])
        // ->select([
        //     'id as rid',
        //     'customer_id',
        //     'product_id',
        //     'quantity',
        //     'selling_price',
        //     'sub_total',
        //     DB::raw('DATE(updated_at) as updated'),
        //     'user_id'
        // ])
        // ->whereNotNull('customer_id')
        // ->whereDate('updated_at', $date)
        // ->where('shop_id', $shop_id)
        // ->where('status', 'sold')
        // ->where('company_id', Auth::user()->company_id)
        // ->orderBy('customer_id', 'desc')
        // ->get()
        // // ->groupBy('customer_id');
        // ->groupBy(function ($sale) {
        //     return $sale->soldBy->name;
        // });


        // $data['sales'] = $sales;
        // $data['total_quantity'] = $sales->flatten()->sum('quantity');
        // $data['total_sub_total'] = $sales->flatten()->sum('sub_total');

        // return response()->json([
        //     'status' => 1,
        //     'message'=> 'success',
        //     'data' => $data
        // ]);
    }

    private function recordDailySales($shop_id, $date){
        $date = date("Y-m-d", strtotime($date));
        $sales = Sale::where('shop_id',$shop_id)->where('status','sold')->whereDate('updated_at', $date)->get();

        if ($sales->isNotEmpty()){

            $t_sales = $sales->sum('sub_total');
            $quantities = $sales->sum('quantity');
            $profit = $sales->sum('sub_total') - $sales->sum('total_buying');

            $dsale = DailySale::where('date',$date)->where('shop_id',$shop_id)->first();
            if($dsale) {
                $dsale->update(['total_sales'=>$t_sales,'quantities'=>$quantities,'profit'=>$profit]);
            } else {
               DailySale::create(['date'=>$date, 'shop_id'=>$shop_id,'company_id'=>Auth::user()->company_id,'total_sales'=>$t_sales,'quantities'=>$quantities,'profit'=>$profit]);
            }


        }
    }

    public function monthlySales($shop_id){
        // return $shop_id;
        $currentYear = Carbon::now()->year;

        $sales = Sale::where('shop_id', $shop_id)
            ->selectRaw('DATE_FORMAT(submitted_at, "%M %Y") as month, SUM(sub_total) as total_sales')
            ->groupBy(DB::raw('DATE_FORMAT(submitted_at, "%M %Y")'))
            ->orderByRaw('MIN(submitted_at) DESC')
            ->get();

        $data['total_revenue'] = $sales->sum('total_sales');
        $data['sales'] = $sales;
        // $data['total_sub_total'] = $sales->sum('sub_total');

        return response()->json([
            'status' => 1,
            'message'=> 'success',
            'data' => $data
        ]);
    }

    public function editSale(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

        $id = $request->input('id');
        $qty = $request->input('quantity');
        $price = $request->input('price');

        $row = Sale::where('id',$id)->where('company_id',Auth::user()->company_id)->first();
        if (!$row) {
           return response()->json(['status' => 0, 'message' => 'item not found']);
        }

        $solddate = date("d-m-Y", strtotime($row->updated_at));
        $q = ShopProduct::where('shop_id',$row->shop_id)->where('product_id',$row->product_id)->where('active','yes')->first();


        if (!$q) {
            return response()->json(['status' => 0, 'message' => 'product not found']);
        }

        $edited_at = date('Y-m-d H:i:s');
        $total_buying = ($qty * $row->buying_price);

        $subtotal = $qty*$price;
        $diffQ = $row->quantity - $qty;

        $update = Sale::where('id',$id)->where('company_id',Auth::user()->company_id)->update([
                'status'=>'sold',
                'quantity'=>$qty,
                'selling_price'=>$price,
                'total_buying'=>$total_buying,
                'sub_total'=>$subtotal,
                'edited_at'=>$edited_at,
                'edited_by'=>Auth::user()->id,
                'updated_at' => DB::raw('updated_at'),
        ]);

        $quantity = ($q->quantity + $diffQ);

        $q->quantity = $quantity;
        $q->save();


        $deni = CustomerDebt::where('reference',$row->sale_no)->where('company_id',Auth::user()->company_id)->first();
        if ($deni) {
            $stock_val = Sale::where('sale_no',$row->sale_no)->where('company_id',Auth::user()->company_id)->where('status','sold')->sum('sub_total');
            $amount_paid = $deni->amount_paid;
            $newdeni = $stock_val - $amount_paid;
            $deni->update(['debt_amount'=>$newdeni,'stock_value'=>$stock_val]);
        }


         return response()->json([
            'status' => 1,
            'message'=> 'success',
        ]);

    }


}
