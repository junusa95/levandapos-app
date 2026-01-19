<?php

namespace App\Http\Controllers\Apps;

use App\Company;
use App\Http\Controllers\Controller;
use App\NewStock;
use App\Product;
use App\Shop;
use App\User;
use App\Measurement;
use App\ReturnSoldItem;
use App\Sale;
use App\ShopProduct;
use App\StockAdjustment;
use App\Transfer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;
use Maestroerror\HeicToJpg;

class ProductController extends Controller
{
    // public function products($shopId){
    //     $productRaw = DB::table('shop_products')->where('shop_id', $shopId)->orderBy('product_id','desc')->where('active', 'yes')->get();

    //     $user = Auth::user();
    //     $products = [];
    //     $picture = '/images/product.jpg';
    //     foreach($productRaw as $raw){
    //         $product = Product::where('id',$raw->product_id)->first();
    //         $shop = Shop::where('id',$raw->shop_id)->first();
    //         if ($product->image != null){
    //             $picture = '/images/companies/'.$user->company->folder.'/products/'.$product->image;
    //         }
    //         $products [] = [
    //             'id' => $product->id,
    //             'name' => $product->name,
    //             'quantity' => $raw->quantity,
    //             'image' => $picture,
    //             'buying_price' => $product->buying_price,
    //             'wholesale_price' => $product->wholesale_price,
    //             'retail_price' => $product->retail_price,
    //             'shop' => $shop?->name,
    //              'product_category_id' => $product->product_category_id,
    //         ];
    //     }


    //     $data['products'] = $products;

    //     // $data['transfer']->load('transfer');


    //     return response()->json([
    //         'status'=> 1,
    //         'message'=> 'success',
    //         'data' => $data
    //     ]);
    // }

    public function products($shopId)
{
    $user = Auth::user();

    // Single query with joins to get all data at once
    $productData = DB::connection('tenant')->table('shop_products as sp')
        ->join('products as p', 'sp.product_id', '=', 'p.id')
        ->join('shops as s', 'sp.shop_id', '=', 's.id')
        ->where('sp.shop_id', $shopId)
        ->where('sp.active', 'yes')
        ->orderBy('sp.product_id', 'desc')
        ->select([
            'p.id',
            'p.name',
            'p.image',
            'p.buying_price',
            'p.wholesale_price',
            'p.retail_price',
            'p.product_category_id',
            's.name as shop_name',
            'sp.quantity'
        ])
        ->get();

    $products = $productData->map(function ($item) use ($user) {
        $picture = $item->image
            ? '/images/companies/' . $user->company->folder . '/products/' . $item->image
            : '/images/product.jpg';

        return [
            'id' => $item->id,
            'name' => $item->name,
            'quantity' => $item->quantity,
            'image' => $picture,
            'buying_price' => $item->buying_price,
            'wholesale_price' => $item->wholesale_price,
            'retail_price' => $item->retail_price,
            'shop' => $item->shop_name,
            'product_category_id' => $item->product_category_id,
        ];
    });

    return response()->json([
        'status' => 1,
        'message' => 'success',
        'data' => ['products' => $products]
    ]);
}

    public function create(Request $request){
        // return $request;

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'buying_price' => 'required',
            'quantity' => 'required',
            'shop_id' => 'required',
            'retail_price' => 'required',
            'product_category_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }


        $expire_date = null;
        if($request->expire_date) {
            $ex_date = str_replace('/', '-', $request->expire_date);
            $expire_date = date("Y-m-d", strtotime($ex_date));
        }

         $user = Auth::user();


        $product = Product::create([
            'name'=>$request->name,
            'buying_price'=>$request->buying_price,
            'wholesale_price'=>$request->wholesale_price,
            'retail_price'=>$request->retail_price,
            'company_id'=> Auth::user()->company_id,
            'measurement_id'=>$request->measurement,
            'product_category_id'=>$request->product_category_id,
            'status'=>'published',
            'user_id' => Auth::user()->id,
            'expire_date'=>$expire_date,
            'min_stock_level'=>$request->min_stock_level
        ]);

        if ($product) {
            $shop = Shop::find($request->shop_id);
            $total_buying = $request->quantity * $product->buying_price;

            $insert = NewStock::create([
                'product_id'=>$product->id,'shop_id'=>$shop->id,'store_id'=>null,
                'added_quantity'=>$request->quantity,'buying_price'=>$product->buying_price,'total_buying'=>$total_buying,'company_id'=>$user->company_id,
                'user_id'=>$user->id,'status'=>'updated','sent_at'=>date('Y-m-d H:i:s')
            ]);

            if($insert) {
                $pro = DB::connection('tenant')->table('shop_products')->where('shop_id',$shop->id)->where('product_id',$product->id)->where('active','yes');
                if ($pro->first()) {
                    $av_qty = $pro->first()->quantity;
                    $new_qty = $av_qty + $request->quantity;
                    $update = $insert->update(['available_quantity'=>$av_qty,'new_quantity'=>$new_qty,'received_by'=>$user->id,'received_at'=>date('Y-m-d H:i:s')]);
                    if($update) {
                        $pro->update(['quantity'=>$new_qty]);
                    }
                } else {
                    $add = DB::connection('tenant')->table('shop_products')->insert(['shop_id' => $shop->id, 'product_id'=>$product->id, 'quantity'=>$request->quantity, 'active'=>'yes', 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' =>  \Carbon\Carbon::now()]);
                    if ($add) {
                        $insert->update(['available_quantity'=>0,'new_quantity'=>$request->quantity,'received_by'=>$user->id,'received_at'=>date('Y-m-d H:i:s')]);
                    }
                }
            }

            if($request->hasFile('image')) {

                $f = $request->file('image');

                if (HeicToJpg::isHeic($f)) { // heic format used by iphone users
                    $f = HeicToJpg::convert($f)->get();
                }

                $manager = new ImageManager(new Driver());
                $image = $manager->read($f);
                $image->scaleDown(width: 540);

                $cfolder = $user->company->folder;
                if (! $cfolder) {
                    $fname = $user->company->name;
                    $fname = preg_replace("/\.[^.]+$/", "", $fname);
                    $fname = preg_replace("/[^a-zA-Z0-9]+/", "_", $fname);
                    $cfolder = $user->company->id.'_'.$fname;
                    Company::find($user->company_id)->update(['folder'=>$cfolder]);
                }
                $main_path = public_path().'/images/companies/'.$cfolder;
                if (! File::exists($main_path)) {
                    File::makeDirectory($main_path, $mode = 0777, true, true);
                }
                $products_path = public_path().'/images/companies/'.$cfolder.'/products';
                if (! File::exists($products_path)) {
                    File::makeDirectory($products_path, $mode = 0777, true, true);
                }

                // Main Image Upload on Folder Code
                $ext = $request->file('image')->getClientOriginalExtension();
                $orig_name = preg_replace("/\.[^.]+$/", "", $request->file('image')->getClientOriginalName());
                $orig_name = preg_replace("/[^a-zA-Z0-9]+/", "_", $orig_name);
                $imageName = time().'-'.$orig_name.'.jpg'; // convert all images to jpg
                $destinationPath = public_path('images/companies/'.$cfolder.'/products/');

                if ($image->save($destinationPath.$imageName)) {
                    $product->update(['image'=>$imageName]);
                }
            }

            $picture = '';
            if ($product->image != null){
                $picture = '/images/companies/'.$user->company->folder.'/products/'.$product->image;
            }

            $productData = (object)[
                'name' => $product->name,
                'buying_price' => $product->buying_price,
                'wholesale_price' => $product->wholesale_price,
                'retail_price' => $product->retail_price,
                'company_id' => $user->company_id,
                'measurement_id' => $product->measurement,
                'product_category_id' => $product->product_category_id,
                'status' => $product->status,
                'user_id' => $product->user_id,
                'expire_date' => $product->expire_date,
                'min_stock_level '=> $product->min_stock_level,
                'image '=> $picture
            ];

            return response()->json([
                'status'=> 1,
                'message'=> 'success',
                'data' => $productData
            ]);

        }
    }

    public function update(Request $request){
        \Log::info('Flutter Payload (all):', $request->all());
// \Log::info('Flutter Payload (raw):', [$request->getContent()]);
// \Log::info('Flutter Headers:', $request->headers->all());

        $expire_date = null;
        if($request->expire_date) {
            $ex_date = str_replace('/', '-', $request->expire_date);
            $expire_date = date("Y-m-d", strtotime($ex_date));
        }

        $user = Auth::user();

        $product = Product::where('id',$request->product_id)->where('company_id',$user->company_id)->first();

        \Log::info('controller product (raw):', [$product]);

        if ($product){
            // $update = $product->update([
            //     'name'=>$request->name,
            //     'buying_price'=>$request->buying_price,
            //     'wholesale_price'=>$request->wholesale_price,
            //     'retail_price'=>$request->retail_price,
            //     'measurement_id'=>$request->measurement,
            //     'product_category_id'=>$request->product_category_id,
            //     'status'=>$request->status,
            //     'user_id' => $user->id,
            //     'expire_date'=>$expire_date,
            //     'min_stock_level'=>$request->min_stock_level
            // ]);

            $product->name = $request->name;
            $product->buying_price = $request->buying_price;
            $product->wholesale_price = $request->wholesale_price;
            $product->retail_price = $request->retail_price;
            $product->measurement_id = $request->measurement_id;
            $product->product_category_id = $request->product_category_id;
            $product->status = 'published'; //get from request
            $product->user_id = $user->id;
            $product->expire_date = $expire_date;
            $product->min_stock_level = $request->min_stock_level;
            // $product->save();
            $update = $product->save();

        \Log::info('controller product (updated):', [$update]);
            if ($update){
                $product = Product::where('id',$request->product_id)->where('company_id',$user->company_id)->first();

        \Log::info('controller product (new):', [$product]);
                if($request->hasFile('image')) {

                    $f = $request->file('image');

                    if (HeicToJpg::isHeic($f)) { // heic format used by iphone users

                        $f = HeicToJpg::convert($f)->get();
                    }

                    $manager = new ImageManager(new Driver());
                    $image = $manager->read($f);
                    $image->scaleDown(width: 540);

                    // check for directory availability
                    $cfolder = $user->company->folder;
                    if (! $cfolder) {
                        $fname = $user->company->name;
                        $fname = preg_replace("/\.[^.]+$/", "", $fname);
                        $fname = preg_replace("/[^a-zA-Z0-9]+/", "_", $fname);
                        $cfolder = $user->company->id.'_'.$fname;
                        Company::find($user->company_id)->update(['folder'=>$cfolder]);
                    }
                    $main_path = public_path().'/images/companies/'.$cfolder;
                    if (! File::exists($main_path)) {
                        File::makeDirectory($main_path, $mode = 0777, true, true);
                    }
                    $products_path = public_path().'/images/companies/'.$cfolder.'/products';
                    if (! File::exists($products_path)) {
                        File::makeDirectory($products_path, $mode = 0777, true, true);
                    }

                    // Main Image Upload to Folder Code
                    $ext = $request->file('image')->getClientOriginalExtension();
                    $orig_name = preg_replace("/\.[^.]+$/", "", $request->file('image')->getClientOriginalName());
                    $orig_name = preg_replace("/[^a-zA-Z0-9]+/", "_", $orig_name);
                    $imageName = time().'-'.$orig_name.'.jpg'; // convert all images to jpg
                    $destinationPath = public_path('images/companies/'.$cfolder.'/products/');

                    if ($image->save($destinationPath.$imageName)) {
                        $product->update(['image'=>$imageName]);
                    }
                }

                return response()->json([
                    'status'=> 1,
                    'message'=> 'success',
                    'data' => $product
                ]);
            }

        }
    }

    public function delete($id) {
         $user = Auth::user();
        $row = Product::where('id',$id)->where('company_id',$user->company_id)->first();
        if ($row) {
            $delete = $row->update(['status'=>'deleted','user_id'=>$user->id]);
            if ($delete) {
                $rows = DB::connection('tenant')->table("shop_products")->where("product_id",$row->id)->where('active','yes')->update(['active'=>'no']);

                $rows2 = DB::connection('tenant')->table("store_products")->where("product_id",$row->id)->where('active','yes')->update(['active'=>'no']);

                NewStock::where('product_id',$row->id)->where('company_id',$user->company_id)->where('status','sent')->update(['status'=>'deleted']);

                \App\Sale::where('company_id',$user->company_id)->where('product_id',$row->id)->where('status','draft')->update(['status'=>'deleted']);
            }
            return response()->json(['status'=>1,'message'=>'product deleted']);
        }
    }

    public function measurements(){
        $user = Auth::user();
        $measurements = Measurement::where('user_id',$user->id)->where('company_id',$user->company_id)->get();
        $data['measurement'] = $measurements;

        return response()->json([
            'status'=> 1,
            'message'=> 'success',
            'data' => $data
        ]);
    }

    public function productByCategory($categoryId, $shopId){
        $user = Auth::user();

        // Single query to get products by category that are available in the shop
        $products = DB::connection('tenant')->table('products as p')
            ->join('shop_products as sp', 'p.id', '=', 'sp.product_id')
            ->where('p.product_category_id', $categoryId)
            ->where('p.status', 'published')
            ->where('sp.shop_id', $shopId)
            ->where('sp.active', 'yes')
            ->orderBy('p.id', 'desc')
            ->select([
                'p.id',
                'p.name',
                'p.image',
                'p.buying_price',
                'p.wholesale_price',
                'p.retail_price',
                'sp.quantity'
            ])
            ->get()
            ->map(function ($product) use ($user) {
                $picture = $product->image
                    ? '/images/companies/' . $user->company->folder . '/products/' . $product->image
                    : '/images/product.jpg';

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'quantity' => $product->quantity,
                    'image' => $picture,
                    'buying_price' => $product->buying_price,
                    'wholesale_price' => $product->wholesale_price,
                    'retail_price' => $product->retail_price,
                ];
            });

        return response()->json([
            'status' => 1,
            'message' => 'success',
            'data' => ['products' => $products]
        ]);
    }

    public function addQuntity(Request $request){
        $validator = Validator::make($request->all(), [
            'productId' => 'required',
            'shopId' => 'required',
            'quantity' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

        $product = Product::find($request->productId);

        $tbuy = $request->quantity * $product->buying_price;

         $insert = NewStock::create([
                        'product_id'=>$request->productId,
                        'shop_id'=>$request->shopId,
                        'store_id'=>null,
                        'added_quantity'=>$request->quantity,
                        'buying_price'=>$product->buying_price,
                        'total_buying'=>$tbuy,
                        'company_id'=>Auth::user()->company_id,
                        'user_id'=>Auth::user()->id,
                        'status'=> 'updated',
                        'sent_at'=>date('Y-m-d H:i:s')
                    ]);

        if ($insert) {
            $pro = DB::connection('tenant')->table('shop_products')->where('shop_id',$request->shopId)->where('product_id',$request->productId)->where('active','yes')->first();
            if ($pro) {
                $av_qty = $pro->quantity;
                $new_qty = $av_qty + $request->quantity;
                $update = $insert->update(['available_quantity'=>$av_qty,'new_quantity'=>$new_qty,'received_by'=>Auth::user()->id,'received_at'=>date('Y-m-d H:i:s')]);
                if($update) {
                    DB::connection('tenant')->table('shop_products')->where('id',$pro->id)->update(['quantity'=>$new_qty]);
                }
            }
        }else{
            $add = DB::connection('tenant')->table('shop_products')->insert(['shop_id' => $request->shopId, 'product_id'=>$request->productId, 'quantity'=>$request->quantity, 'active'=>'yes', 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' =>  \Carbon\Carbon::now()]);
            if ($add) {
                $insert->update(['available_quantity'=>0,'new_quantity'=>$request->quantity,'received_by'=>Auth::user()->id,'received_at'=>date('Y-m-d H:i:s')]);
            }
        }

        return response()->json([
            'status'=> 1,
            'message'=> 'success',
        ]);
    }

    public function getDeletedProduct(Request $request){
        $query = Product::where('company_id',Auth::user()->company_id)->where('status','deleted');

        if($request->input('input')){
            $keyword = $request->input('input');
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        $products = $query->get();
        // return response()->json($products);

        return response()->json([
            'status'=> 1,
            'message'=> 'success',
            'data'=> $products
        ]);
    }

    public function restoreProduct($product_id){
        $product = Product::where('id',$product_id)->where('company_id',Auth::user()->company_id)->first();
        if($product){
            $restore = $product->update(['status'=>'published','user_id'=>Auth::user()->id]);
            if($restore){
               DB::connection('tenant')->table("shop_products")->where("product_id",$product_id)->update(['active'=>'yes']);
               DB::connection('tenant')->table("store_products")->where("product_id",$product_id)->update(['active'=>'yes']);
               NewStock::where('product_id',$product_id)->where('company_id',Auth::user()->company_id)->update(['status'=>'sent']);
            //    \App\Sale::where('company_id',Auth::user()->company_id)->where('product_id',$product_id)->update(['status'=>'t']);
            }
            // return response()->json(['status'=>'success']);

            return response()->json([
                'status'=> 1,
                'message'=> 'success'
            ]);
        }

    }

    public function ProductAvailabilityt($shop_id){
        $shop_ids = Shop::where('company_id', Auth::user()->company_id)->pluck('id')->toArray();

        if (!in_array($shop_id, $shop_ids)) {
            return collect(); // empty collection if not valid
        }

        // Get products for this shop, eager load product + otherShops + their Shop
        $products = ShopProduct::with([
                'product:id,name,retail_price',
                // 'otherShops.shop:id,name' // eager load the shop for otherShops
                'otherShops' => function ($q) use ($shop_id) {
                    $q->where('shop_id', '<>', $shop_id)->with('shop:id,name');
                }
            ])
            ->where('shop_id', $shop_id)
            ->where('active', 'yes')
            ->select('id', 'shop_id', 'product_id', 'active')
            ->get();


        // $product = Product::where('id',$shop_id,$product_id)->where('company_id',Auth::user()->company_id)->first();
        // if($product){
        //     $restore = $product->update(['status'=>'published','user_id'=>Auth::user()->id]);
        //     if($restore){
        //        DB::table("shop_products")->where("product_id",$product_id)->update(['active'=>'yes']);
        //        DB::table("store_products")->where("product_id",$product_id)->update(['active'=>'yes']);
        //        NewStock::where('product_id',$product_id)->where('company_id',Auth::user()->company_id)->update(['status'=>'sent']);
        //     //    \App\Sale::where('company_id',Auth::user()->company_id)->where('product_id',$product_id)->update(['status'=>'t']);
        //     }
        //     // return response()->json(['status'=>'success']);

            return response()->json([
                'status'=> 1,
                'message'=> 'success',
                'data'=> $products
            ]);

    }

    public function ProductValue($shop_id){
        $shop_ids = Shop::where('company_id', Auth::user()->company_id)->pluck('id')->toArray();

        if (!in_array($shop_id, $shop_ids)) {
            return collect(); // empty collection if not valid
        }

        // Get products for this shop, eager load product + otherShops + their Shop
        $products = ShopProduct::with([
                'product:id,name,buying_price,wholesale_price,retail_price',
            ])
            ->where('shop_id', $shop_id)
            ->where('active', 'yes')
            ->select('id', 'shop_id', 'product_id', 'quantity','active')
            ->get();

        $data['total_cost'] = 0;
        $data['total_price'] = 0;
        $data['total_profit'] = 0;

        foreach($products as $p){
            $data['total_cost'] += ($p->quantity * $p->product->buying_price);
            $data['total_price'] += ($p->quantity * $p->product->retail_price);
        }
        $data['total_profit'] += ($data['total_price'] - $data['total_cost']);

        return response()->json([
            'status'=> 1,
            'message'=> 'success',
            'data'=> $data
        ]);

    }

    public function change_quantity(Request $request){
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'shop_id' => 'required',
            'new_quantity' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

        $shop_id = $request->input('shop_id');
        $product_id = $request->input('product_id');
        $new_quantity = $request->input('new_quantity');


        $shopProduct = ShopProduct::where('shop_id', $shop_id)
            ->where('product_id', $product_id)
            ->where('active', 'yes')
            ->firstOrFail(); // safer than ->first()

        $old_quantity = $shopProduct->quantity;


        $change_qty =StockAdjustment::create([
            'from'=>'shop',
            'from_id'=>$shop_id,
            'product_id'=>$product_id,
            'av_quantity'=>$old_quantity,
            'new_quantity'=>$new_quantity,
            'status'=>'stock adjustment',
            'user_id'=>Auth::user()->id,
            'company_id'=>Auth::user()->company_id,
        ]);

        $shopProduct->quantity = $new_quantity;
        $shopProduct->save();


        return response()->json([
            'status'=> 1,
            'message'=> 'success',
        ]);
    }

    public function product_history(Request $request){

        $shop_id = $request->input('shop_id');
        $product_id = $request->input('product_id');
        $fromdate = $request->input('fromdate');
        $todate = $request->input('todate');

        $fromdate = Carbon::parse($fromdate)->startOfDay();
        $todate = Carbon::parse($todate)->endOfDay();

        // return $request;
        $company_id = Auth::user()->company_id;

        // base available stock
        $availableQ = DB::connection('tenant')->table('shop_products')
            ->where('shop_id',$shop_id)
            ->where('product_id',$product_id)
            ->where('active','yes')
            ->sum('quantity');

        // collect grouped results
        $sumQ = Sale::select(DB::raw('DATE(updated_at) as date, SUM(quantity) as quantity'))
            ->where('company_id',$company_id)->whereBetween('updated_at', [$fromdate,$todate])
            ->where('status','sold')->where('shop_id',$shop_id)->where('product_id',$product_id)
            ->groupBy('date')->pluck('quantity','date');

        $returnedQ = ReturnSoldItem::select(DB::raw('DATE(updated_at) as date, SUM(quantity) as quantity'))
            ->where('company_id',$company_id)->whereBetween('updated_at', [$fromdate,$todate])
            ->where('shop_id',$shop_id)->where('product_id',$product_id)->where('status','received')
            ->groupBy('date')->pluck('quantity','date');

        $newstockQ = NewStock::select(DB::raw('DATE(updated_at) as date, SUM(added_quantity) as quantity'))
            ->where('company_id',$company_id)->whereBetween('updated_at', [$fromdate,$todate])
            ->where('shop_id',$shop_id)->where('product_id',$product_id)->where('status','updated')
            ->groupBy('date')->pluck('quantity','date');

        $adjust = StockAdjustment::select(DB::raw('DATE(updated_at) as date, SUM(av_quantity) as sumaQ, SUM(new_quantity) as sumnQ'))
            ->whereBetween('updated_at', [$fromdate,$todate])
            ->where('status','stock adjustment')->where('company_id',$company_id)
            ->where('from','shop')->where('from_id',$shop_id)->where('product_id',$product_id)
            ->groupBy('date')->get()->keyBy('date');

        $trout = Transfer::select(DB::raw('DATE(updated_at) as date, SUM(quantity) as quantity'))
            ->where('company_id',$company_id)->whereBetween('updated_at', [$fromdate,$todate])
            ->where('from','shop')->where('from_id',$shop_id)->where('product_id',$product_id)
            ->whereIn('status',['sent','received'])->groupBy('date')->pluck('quantity','date');

        $trin = Transfer::select(DB::raw('DATE(updated_at) as date, SUM(quantity) as quantity'))
            ->where('company_id',$company_id)->whereBetween('updated_at', [$fromdate,$todate])
            ->where('destination','shop')->where('destination_id',$shop_id)->where('product_id',$product_id)
            ->where('status','received')->groupBy('date')->pluck('quantity','date');

        // build daily results
        $results = [];
        $runningBalance = $availableQ;

        for ($date = $todate->copy(); $date >= $fromdate; $date->subDay()) {
            $key = $date->toDateString();

            $daily = [
                'date' => $key,
                'newstock' => $newstockQ[$key] ?? 0,
                'sold' => $sumQ[$key] ?? 0,
                'returned' => $returnedQ[$key] ?? 0,
                'trin' => $trin[$key] ?? 0,
                'trout' => $trout[$key] ?? 0,
                'adjust' => $adjust[$key] ?? 0,
                'balance' => $runningBalance
            ];

            if (isset($adjust[$key])) {
                $diff = (int)$adjust[$key]->sumnQ - (int)$adjust[$key]->sumaQ;
                $daily['adjust'] = $diff;
            }

            // record before balance changes
            if ($daily['sold'] > 0 || $daily['returned'] > 0 || $daily['newstock'] > 0 || $daily['trin'] > 0 || $daily['trout'] > 0 || $daily['adjust'] != 0) {
                # code...
                $results[] = $daily;
            }

            // update running balance (follow same formula from JS)
            $runningBalance = $runningBalance
                + $daily['sold']
                - $daily['returned']
                - $daily['newstock']
                - $daily['adjust']
                + $daily['trout']
                - $daily['trin'];
        }

        return response()->json([
            'availableQ' => $availableQ,
            'runningBalance' => $runningBalance,
            'history' => $results
        ]);


    }

    public function productInReport(Request $request){
        //
        $validator = Validator::make($request->all(), [
            'shop_id' => 'required',
            'from' => 'required|date|before:to',
            'to' => 'required|date|after:from',
        ]);
        $mainDb = config('database.connections.mysql.database');

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

        $fromdate = $request->input('from');
        $todate = $request->input('to');
        $shop_id = $request->input('shop_id');

        $sum = NewStock::query()->select([
            DB::raw('DATE(sent_at) as date, sum(total_buying) as total_price, sum(added_quantity) as quantity')
        ])
        ->whereBetween('sent_at', [Carbon::parse($fromdate)->startOfDay(),Carbon::parse($todate)->endOfDay()])
        ->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('status','updated')
        ->groupBy('date')->orderBy('date','desc')->get();

        $items = NewStock::query()->select([
            DB::raw('new_stocks.id as nid, products.name as pname, sender.name as sent_by, DATE_FORMAT(new_stocks.sent_at, "%H:%i") as sent_at, receiver.name as received_by, DATE_FORMAT(new_stocks.received_at, "%H:%i") as received_at, new_stocks.added_quantity as quantity, new_stocks.buying_price as price, new_stocks.total_buying as total, DATE(new_stocks.sent_at) as date')
        ])
        ->join('products','products.id','new_stocks.product_id')
        ->join(DB::raw("$mainDb.users as sender"), 'sender.id', '=', 'new_stocks.user_id')
        ->join(DB::raw("$mainDb.users as receiver"), 'receiver.id', '=', 'new_stocks.received_by')
        ->whereBetween('new_stocks.sent_at', [Carbon::parse($fromdate)->startOfDay(),Carbon::parse($todate)->endOfDay()])
        ->where('new_stocks.company_id',Auth::user()->company_id)->where('new_stocks.shop_id',$shop_id)->where('new_stocks.status','updated')
        ->orderBy('new_stocks.id','desc')->get(); 


        $grouped = $items->groupBy('date')->map(function ($rows, $date) use ($sum) {

            $daySum = $sum->firstWhere('date', $date);

            return [
                'date' => $date,
                'total_quantity' => $daySum->quantity ?? 0,
                'total_price' => $daySum->total_price ?? 0,
                'items' => $rows->values(), // reset keys
            ];
        })->values();

        return response()->json([
            'status' => 1,
            'data'=>$grouped
        ]);
    }

    public function productInout(Request $request){
        $validator = Validator::make($request->all(), [
            'shop_id' => 'required',
            'product_id' => 'required',
            'from' => 'required|date|before:to',
            'to' => 'required|date|after:from',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

        $data = [];

        $fromdate = date("Y-m-d 00:00:00", strtotime($request->from));
        $todate = date("Y-m-d 23:59:59", strtotime($request->to));

        $adjusts = StockAdjustment::query()->selectRaw('av_quantity, new_quantity, updated_at')
                                    ->whereBetween('updated_at', [Carbon::parse($fromdate)->startOfDay(),Carbon::parse($todate)->endOfDay()])
                                    ->where('status','stock adjustment')->where('company_id',Auth::user()->company_id)->where('from','shop')->where('from_id',$request->shop_id)->where('product_id',$request->product_id)->get();

        $newStocks = NewStock::query()->selectRaw('DATE(updated_at) as date, SUM(added_quantity) as total_added')->whereBetween('updated_at', [Carbon::parse($fromdate)->startOfDay(), Carbon::parse($todate)->endOfDay()])->where('company_id', Auth::user()->company_id)
                    ->where('shop_id', $request->shop_id)
                    ->where('product_id', $request->product_id)
                    ->where('status', 'updated')
                    ->groupBy('date')
                    ->get()
                    ->keyBy('date');

        $sales = Sale::query()->selectRaw('DATE(updated_at) as date, SUM(quantity) as total_added')
                    ->where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate)->startOfDay(),Carbon::parse($todate)->endOfDay()])
                    ->where('status','sold')->where('shop_id',$request->shop_id)
                    ->where('product_id',$request->product_id)
                    ->groupBy('date')
                    ->get()
                    ->keyBy('date');

        $transferIns = Transfer::query()->selectRaw('DATE(updated_at) as date, SUM(quantity) as total_added')
                    ->where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])
                    ->where('destination','shop')->where('destination_id',$request->shop_id)->where('product_id',$request->product_id)->where('status','received')
                    ->groupBy('date')
                    ->get()
                    ->keyBy('date');


        $transferOuts = Transfer::query()->selectRaw('DATE(updated_at) as date, SUM(quantity) as total_added')
                        ->where('company_id',Auth::user()->company_id)->whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])
                        ->where('from','shop')->where('from_id',$request->shop_id)->where('product_id',$request->product_id)->whereIn('status',['received','sent'])
                        ->groupBy('date')
                        ->get()
                        ->keyBy('date');

        $groupedData = [];

        foreach ($adjusts as $adjust) {
            $date = date('Y-m-d', strtotime($adjust->updated_at));
            $diff = $adjust->new_quantity - $adjust->av_quantity;

            if (!isset($groupedData[$date])) {
                $groupedData[$date] = [
                    'date' => $date,
                    'total_product_out' => 0,
                    'total_product_in' => 0,
                ];
            }

            if ($diff > 0) {
                $groupedData[$date]['total_product_in'] += $diff;
            } else {
                $groupedData[$date]['total_product_out'] += abs($diff);
            }
        }

        foreach ($newStocks as $date => $stock) {
            if (!isset($groupedData[$date])) {
                $groupedData[$date] = [
                    'date' => $date,
                    'total_product_out' => 0,
                    'total_product_in' => 0,
                ];
            }

            $groupedData[$date]['total_product_in'] += $stock->total_added;
        }


        foreach ($sales as $date => $sale) {
            if (!isset($groupedData[$date])) {
                $groupedData[$date] = [
                    'date' => $date,
                    'total_product_out' => 0,
                    'total_product_in' => 0,
                ];
            }

            $groupedData[$date]['total_product_out'] += $sale->total_added;
        }

        foreach ($transferIns as $date => $transfer) {
            if (!isset($groupedData[$date])) {
                $groupedData[$date] = [
                    'date' => $date,
                    'total_product_out' => 0,
                    'total_product_in' => 0,
                ];
            }

            $groupedData[$date]['total_product_in'] += $transfer->total_added;
        }

        foreach ($transferOuts as $date => $transfer) {
            if (!isset($groupedData[$date])) {
                $groupedData[$date] = [
                    'date' => $date,
                    'total_product_out' => 0,
                    'total_product_in' => 0,
                ];
            }

            $groupedData[$date]['total_product_out'] += $transfer->total_added;
        }

        $data = array_values(array_map(function($item) {
            return (object) $item;
        }, $groupedData));

        return response()->json([
            'status' => 1,
            'data'=>$data,
        ]);
    }

}
