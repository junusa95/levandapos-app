<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Supplier;
use App\Shop;
use App\Product;
use App\NewStock;
use App\ShopStoreSupplier;
use Carbon\Carbon;
use App\StockAdjustment;
use App\Http\Controllers\ProductController;

class SupplierController extends Controller
{
    public function suppliers($shop_id, $seach = null){
        $suppliers = Supplier::where('shop_id',$shop_id)->where('company_id',Auth::user()->company_id)->where('user_id',Auth::user()->id)->where('status','active')

        ->when($seach, function($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
            ->orWhere('phone', 'like', "%{$search}%")
            ->orWhere('location', 'like', "%{$search}%");
        })

        ->limit(10)->get();

        $new_year_balance = 0;
        $thisyear = date('Y');

        $supplierData = [];

        foreach ($suppliers as $supplier){
            $deposits = ShopStoreSupplier::where('shop_id',$shop_id)->where('supplier_id',$supplier->id)->where('status','deposit')->whereYear('added_at', $thisyear)->sum('amount');
            $new_year_balance = ShopStoreSupplier::where('shop_id',$shop_id)->where('supplier_id',$supplier->id)->where('status',$thisyear)->first();

            $totalq = ShopStoreSupplier::where('status','purchase')->where('shop_id',$shop_id)->where('supplier_id',$supplier->id)->whereYear('added_at', $thisyear)->sum('quantity');
            $totalp = ShopStoreSupplier::where('status','purchase')->where('shop_id',$shop_id)->where('supplier_id',$supplier->id)->whereYear('added_at', $thisyear)->sum('total_buying');
            if($new_year_balance) {
                $new_year_balance = $new_year_balance->amount;
            }
            $balance = $deposits - $totalp;
            $balance = $balance + $new_year_balance;

            $supplierData [] = (object)[
                'supplier' => $supplier,
                'balance' => $balance
            ];

        }

        return response()->json([
            'status'=> 1,
            'message'=> 'success',
            'data' => $supplierData,
        ]);


    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'shop_id' => 'required',
            'name' => 'required|max:25',
            'phone' => 'required',
            'location' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

        try {

             $supplier = Supplier::create([
                'name'=>$request->name,
                'phone'=>$request->phone,
                'location'=>$request->location,
                'status'=>'active',
                'company_id'=>Auth::user()->company_id,
                'shop_id'=>$request->shop_id,
                'store_id'=>null,
                'user_id'=>Auth::user()->id
            ]);

            return response()->json([
                'status'=> 1,
                'message'=> 'success',
                'data' => $supplier,
            ]);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function update(Request $request){

         $validator = Validator::make($request->all(), [
            'supplier_id' => 'required',
            'name' => 'required|max:25',
            'phone' => 'required',
            'location' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }


        try {

            $supplier = Supplier::find($request->supplier_id);
            if ($supplier) {

                $supplier->update([
                    'name'=>$request->name,
                    'phone'=>$request->phone,
                    'location'=>$request->location
                ]);

                return response()->json([
                    'status'=> 1,
                    'message'=> 'success',
                    'data' => $supplier,
                ]);
            }else{
                return response()->json([
                    'status'=> 0,
                    'message'=> 'supplier not found',
                ]);
            }

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }

    }

    public function delete(Request $request){

        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

        $supplier = Supplier::where('company_id',Auth::user()->company_id)->where('id',$request->supplier_id)->first();

        if($supplier) {

            $supplier->update(['status'=>'deleted']);

            return response()->json([
                'status'=> 1,
                'message'=> 'success deleted',
            ]);

        }
    }

    public function supplier($supplier_id,$year = null){

        $supplier = Supplier::find($supplier_id);

        $new_year_balance = 0;
        if ($year) {
           $thisyear = $year;
        }else{
             $thisyear = date('Y');
        }

        $deposits = ShopStoreSupplier::where('shop_id',$supplier->shop_id)->where('supplier_id',$supplier->id)->where('status','deposit')->whereYear('added_at', $thisyear)->sum('amount');
        $borrow = ShopStoreSupplier::where('shop_id',$supplier->shop_id)->where('supplier_id',$supplier->id)->where('status','borrow')->whereYear('added_at', $thisyear)->sum('amount');
        $new_year_balance = ShopStoreSupplier::where('shop_id',$supplier->shop_id)->where('supplier_id',$supplier->id)->where('status',$thisyear)->first();
        $totalq = ShopStoreSupplier::where('status','purchase')->where('shop_id',$supplier->shop_id)->where('supplier_id',$supplier->id)->whereYear('added_at', $thisyear)->sum('quantity');
        $totalp = ShopStoreSupplier::where('status','purchase')->where('shop_id',$supplier->shop_id)->where('supplier_id',$supplier->id)->whereYear('added_at', $thisyear)->sum('total_buying');

        if($new_year_balance) {
            $new_year_balance = $new_year_balance->amount;
        }

        $data['payment_made'] = number_format($deposits);
        $data['borrow'] = number_format($borrow);
        $data['purchaased_products'] = $totalq + 0;
        $data['products_amount'] = number_format($totalp);
        $balance = $deposits - $totalp - $borrow;
        $balance = $balance + $new_year_balance;
        $data['balance'] = number_format($balance);


        //reords of purchases
        $dataRecords = [];
        $records = ShopStoreSupplier::select(
        DB::raw('DATE(added_at) as date'),
        DB::raw('MAX(id) as id'),
        DB::raw('MAX(created_at) as created_at')
    )->where('shop_id',$supplier->shop_id)->where('supplier_id',$supplier->id)->whereYear('added_at', $thisyear)->groupBy(DB::raw('Date(added_at)'))->orderBy('created_at','desc')->get();
        if($records->isNotEmpty()){
            foreach($records as $h) {
                $date = date('d/m/Y', strtotime($h->date));
                $date_2 = date('Y-m-d', strtotime($h->date));
                $from = date('Y-m-d 00:00:00', strtotime($h->date));
                $to = date('Y-m-d 23:59:59', strtotime($h->date));

                $totalq = ShopStoreSupplier::where('status','purchase')->where('shop_id',$supplier->shop_id)->where('supplier_id',$supplier->id)->whereBetween('added_at', [Carbon::parse($from),Carbon::parse($to)])->sum('quantity');
                $totalp = ShopStoreSupplier::where('status','purchase')->where('shop_id',$supplier->shop_id)->where('supplier_id',$supplier->id)->whereBetween('added_at', [Carbon::parse($from),Carbon::parse($to)])->sum('total_buying');
                $deposits = ShopStoreSupplier::where('shop_id',$supplier->shop_id)->where('supplier_id',$supplier->id)->where('status','deposit')->whereBetween('added_at', [Carbon::parse($from),Carbon::parse($to)])->sum('amount');
                $borrow = ShopStoreSupplier::where('shop_id',$supplier->shop_id)->where('supplier_id',$supplier->id)->where('status','borrow')->whereBetween('added_at', [Carbon::parse($from),Carbon::parse($to)])->sum('amount');
                $totalq = $totalq + 0;

                $dataRecords [] = (object)[
                    'date' => $date,
                    'product_bought' => $totalq,
                    'purchase_value' => $totalp,
                    'deposit_amount' => $deposits,
                ];

            }
        }
        $data['records'] = $dataRecords;
        $data['supplier'] = $supplier;

         return response()->json([
            'status'=> 1,
            'message'=> 'success',
            'data' => $data
        ]);
    }

    public function products($shop_id){
        $shop = Shop::find($shop_id)->products()->orderBy('products.name','asc')->get();

        return response()->json([
            'status'=> 1,
            'message'=> 'success',
            'data' => $shop
        ]);
    }

    public function buyProduct(Request $request){

        $validator = Validator::make($request->all(), [
            'shop_id' => 'required',
            'supplier_id' => 'required',
            'product_ids' => 'required|array',
            'quantities' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

        try {

            DB::beginTransaction();

           $shop_id = $request->shop_id;
            $supplier_id = $request->supplier_id;
            $productIds = $request->input('product_ids');
            $quantites = $request->input('quantities');
            $amounts = $request->input('amounts');


            foreach($productIds as $key => $prod){
                $product = Product::find($prod);

                if(Auth::user()->company->isCheckingStockLevel()){ $min_stock = "yes"; } else { $min_stock = "no"; }

                $add =ShopStoreSupplier::create([
                    'product_id'=>$product->id,
                    'shop_id'=>$shop_id,
                    'supplier_id'=>$supplier_id,
                    'quantity'=>$quantites[$key],
                    'buying_price'=>$product->buying_price,
                    'total_buying'=>$quantites[$key] * $product->buying_price,
                    'user_id'=>Auth::user()->id,
                    'status'=>'purchase',
                    'company_id'=>Auth::user()->company_id,
                    'added_at'=>date('Y-m-d H:i:s')
                ]);

                $existQuantity = DB::connection('tenant')->table('shop_products')->where('shop_id',$shop_id)->where('product_id',$product->id)->where('active','yes');
                if($existQuantity->first()) {
                    $av_q = $existQuantity->first()->quantity;
                } else {
                    $av_q = 0;
                }
                $new_q = $av_q + $quantites[$key];

                $insert = NewStock::create([
                    'product_id'=>$add->product_id,
                    'shop_id'=>$shop_id,
                    'supplier_id'=>$supplier_id,
                    'available_quantity'=>$av_q,
                    'added_quantity'=>$add->quantity,
                    'new_quantity'=>$new_q,
                    'buying_price'=>$add->buying_price,
                    'total_buying'=>$add->total_buying,
                    'sent_at'=>date('Y-m-d H:i:s'),
                    'received_by'=>$add->user_id,
                    'received_at'=>date('Y-m-d H:i:s'),
                    'user_id'=>$add->user_id,
                    'status'=>'updated',
                    'company_id'=>$add->company_id
                ]);

                if ($insert) {
                    if ($existQuantity->first()) {
                        $existQuantity->update(['quantity'=>$new_q]);
                    } else {
                        $add = DB::connection('tenant')->table('shop_products')->insert(['shop_id' => $shop_id, 'product_id'=>$add->product_id, 'quantity'=>$add->quantity, 'active'=>'yes', 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' =>  \Carbon\Carbon::now()]);
                    }

                    if($min_stock == "yes") {
                        $pro = \App\Product::find($add->product_id);
                        if($pro->min_stock_level >= $new_q) {
                            ProductController::insertMSL($pro->id,'shop',$shop_id,$pro->min_stock_level);
                        } else {
                            $check = \App\Notification::where('shop_id',$shop_id)->where('product_id',$pro->id)->first();
                            if($check) {
                                $check->update(['product_id'=>null]);
                            }
                        }
                    }

                }

            }

            DB::commit();

            return response()->json([
                'status'=> 1,
                'message'=> 'success',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }




    }

    public function paySupplierDebt(Request $request){
        $validator = Validator::make($request->all(), [
            'shop_id' => 'required',
            'supplier_id' => 'required',
            'amount' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

        try {
           $deposit = ShopStoreSupplier::create([
                'supplier_id'=>$request->supplier_id,
                'shop_id'=>$request->shop_id,
                'amount'=>$request->amount,
                'user_id'=>Auth::user()->id,
                'status'=>'deposit',
                'company_id'=>Auth::user()->company_id,
                'added_at'=>date('Y-m-d H:i:s')
            ]);


            return response()->json([
                'status'=> 1,
                'message'=> 'success',
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function getSupplierTransaction($shop_id,$supplier_id,$date){

        $from = date('Y-m-d 00:00:00', strtotime($date));
        $to = date('Y-m-d 23:59:59', strtotime($date));

        $items = ShopStoreSupplier::where('status','purchase')->where('shop_id',$shop_id)->where('supplier_id',$supplier_id)->whereBetween('added_at', [Carbon::parse($from),Carbon::parse($to)])->get();
        $totalp = ShopStoreSupplier::where('status','purchase')->where('shop_id',$shop_id)->where('supplier_id',$supplier_id)->whereBetween('added_at', [Carbon::parse($from),Carbon::parse($to)])->sum('total_buying');
        $deposits = ShopStoreSupplier::where('shop_id',$shop_id)->where('supplier_id',$supplier_id)->where('status','deposit')->whereBetween('added_at', [Carbon::parse($from),Carbon::parse($to)])->get();

        $buyingProducts = [];
        $depositAmount = 0;

        if($items->isNotEmpty()){
            foreach($items as $item){
                $buyingProducts [] = (object)[
                    "id" => $item->id,
                    "name" => $item->product->name,
                    "quantity" => $item->quantity + 0,
                    "buying" => $item->buying_price,
                    "total_buying" => $item->total_buying,
                ];
            }
        }

        if ($deposits->isNotEmpty()) {
           foreach ($deposits as $key => $deposit) {
                $depositAmount = $depositAmount + $deposit->amount;
           }
        }

        $data['items'] = $buyingProducts;
        $data['deposit_amount'] = $depositAmount;
        $data['total_buying'] = $totalp;

        return response()->json([
            'status'=> 1,
            'message'=> 'success',
            'data' => $data
        ]);

    }

    public function updateTransaction(Request $request){
         $validator = Validator::make($request->all(), [
            'shop_id' => 'required',
            'supplier_id' => 'required',
            'date' => 'required',
            'quantities' => 'required|array',
            'items_ids' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

        $from = date('Y-m-d 00:00:00', strtotime($request->date));
        $to = date('Y-m-d 23:59:59', strtotime($request->date));

        $itemsIds = $request->items_ids;
        $quantities = $request->quantities;

        $items = ShopStoreSupplier::whereIn('id',$itemsIds)->where('status','purchase')->where('shop_id',$request->shop_id)->where('supplier_id',$request->supplier_id)->whereBetween('added_at', [Carbon::parse($from),Carbon::parse($to)])->get();
         if(Auth::user()->company->isCheckingStockLevel()){ $min_stock = "yes"; } else { $min_stock = "no"; }

         if (count($items) > 0) {
           foreach ($items as $key => $item) {
                if ($item->id == $itemsIds[$key]) {
                    if ($item->quantity != $quantities[$key]) {
                        $newqty = $quantities[$key];
                        $diff = $newqty - $item->quantity;
                        $tb = $newqty * $item->buying_price;

                        $item->update(['quantity'=>$newqty,'total_buying'=>$tb,'user_id'=>Auth::user()->id]);

                        $row = DB::connection('tenant')->table('shop_products')->where('shop_id',$item->shop_id)->where('product_id',$item->product_id)->where('active','yes');

                        if ($row->first()) {
                            $new_q = $row->first()->quantity + $diff;
                            $insert = \App\StockAdjustment::create(['from'=>'shop','from_id'=>$row->first()->shop_id,'product_id'=>$row->first()->product_id,'av_quantity'=>$row->first()->quantity,'company_id'=>Auth::user()->company_id, 'new_quantity'=>$new_q,'status'=>'stock adjustment','user_id'=>Auth::user()->id]);
                            if ($insert) {
                                $update = $row->update(['quantity'=>$new_q]);

                                if($min_stock == "yes") {
                                    $pro = \App\Product::find($item->product_id);
                                    if($pro->min_stock_level >= $new_q) {
                                        ProductController::insertMSL($pro->id,'shop',$request->shopid,$pro->min_stock_level);
                                    } else {
                                        $check = \App\Notification::where('shop_id',$request->shopid)->where('product_id',$pro->id)->first();
                                        if($check) {
                                            $check->update(['product_id'=>null]);
                                        }
                                    }
                                }
                            }
                        }

                    }
                }
            }
         }


        return response()->json([
            'status'=> 1,
            'message'=> 'success'
        ]);


    }

    public function deleteItem(Request $request){
         $validator = Validator::make($request->all(), [
            'item_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

        $stock = ShopStoreSupplier::where('id',$request->item_id)->where('company_id',Auth::user()->company_id)->first();

        if ($stock) {

            $stock->update(['status'=>'deleted']);
            $quantity = $stock->quantity;

            $row = DB::connection('tenant')->table('shop_products')->where('shop_id',$stock->shop_id)->where('product_id',$stock->product_id)->where('active','yes');
            if ($row->first()) {
                $new_q = $row->first()->quantity - $quantity;
                $insert = StockAdjustment::create(['from'=>'shop','from_id'=>$row->first()->shop_id,'product_id'=>$row->first()->product_id,'av_quantity'=>$row->first()->quantity,'company_id'=>Auth::user()->company_id, 'new_quantity'=>$new_q,'status'=>'stock adjustment','user_id'=>Auth::user()->id]);
                if ($insert) {
                    $update = $row->update(['quantity'=>$new_q]);
                }
            }
        }

        return response()->json([
            'status'=> 1,
            'message'=> 'success'
        ]);
    }

}
