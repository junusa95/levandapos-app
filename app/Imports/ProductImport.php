<?php

namespace App\Imports;

use DB;
use Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Auth;

class ProductImport implements ToCollection, WithHeadingRow, WithValidation
{
    
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
            ],
            'buying_price' => [
                'required',
                'numeric',
                'gte:0',
            ],
            'selling_price' => [
                'required',
                'numeric',
                'gt:0',
            ],
            'quantity' => [
                'required',
                'numeric',
                'gte:0',
            ],
        ];
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $measurement = \App\Measurement::where('company_id',Auth::user()->company_id)->first();
        $pcat = \App\ProductCategory::where('company_id',Auth::user()->company_id)->first();
        foreach($rows as $row) {
            $product = \App\Product::create(['name'=>$row['name'], 'buying_price'=>$row['buying_price'], 'wholesale_price'=>0, 'retail_price'=>$row['selling_price'], 'measurement_id'=>$measurement->id, 'product_category_id'=>$pcat->id, 'company_id'=>Auth::user()->company_id, 'status'=>'published','user_id'=>Auth::user()->id]);
            if($product) {
                if(Session::get('shopstore') == "shop") {
                    $shop = \App\Shop::find(Session::get('sid'));
                    $total_buying = $row['quantity'] * $row['buying_price'];
                    $insert = \App\NewStock::create([
                        'product_id'=>$product->id,'shop_id'=>$shop->id,'store_id'=>null, 
                        'added_quantity'=>$row['quantity'],'buying_price'=>$row['buying_price'],'total_buying'=>$total_buying,'company_id'=>Auth::user()->company_id,
                        'user_id'=>Auth::user()->id,'status'=>'updated','sent_at'=>date('Y-m-d H:i:s')
                        ]);
                    if($insert) {
                        $pro = \DB::connection('tenant')->table('shop_products')->where('shop_id',$shop->id)->where('product_id',$product->id)->where('active','yes'); 
                        if ($pro->first()) {
                            $av_qty = $pro->first()->quantity;
                            $new_qty = $av_qty + $row['quantity'];
                            $update = $insert->update(['available_quantity'=>$av_qty,'new_quantity'=>$new_qty,'received_by'=>Auth::user()->id,'received_at'=>date('Y-m-d H:i:s')]);
                            if($update) {
                                $pro->update(['quantity'=>$new_qty]);
                            }
                        } else {
                            $add = DB::connection('tenant')->table('shop_products')->insert(['shop_id' => $shop->id, 'product_id'=>$product->id, 'quantity'=>$row['quantity'], 'active'=>'yes', 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' =>  \Carbon\Carbon::now()]);
                            if ($add) {
                                $insert->update(['available_quantity'=>0,'new_quantity'=>$row['quantity'],'received_by'=>Auth::user()->id,'received_at'=>date('Y-m-d H:i:s')]);
                            }
                        }
                        // check for minimum stock level 
                    }
                }
                if(Session::get('shopstore') == "store") {
                    $store = \App\Store::find(Session::get('sid'));
                    $total_buying = $row['quantity'] * $row['buying_price'];
                    $insert = \App\NewStock::create([
                        'product_id'=>$product->id,'store_id'=>null,'store_id'=>$store->id, 
                        'added_quantity'=>$row['quantity'],'buying_price'=>$row['buying_price'],'total_buying'=>$total_buying,'company_id'=>Auth::user()->company_id,
                        'user_id'=>Auth::user()->id,'status'=>'updated','sent_at'=>date('Y-m-d H:i:s')
                        ]);
                    if($insert) {
                        $pro = \DB::connection('tenant')->table('store_products')->where('store_id',$store->id)->where('product_id',$product->id)->where('active','yes'); 
                        if ($pro->first()) {
                            $av_qty = $pro->first()->quantity;
                            $new_qty = $av_qty + $row['quantity'];
                            $update = $insert->update(['available_quantity'=>$av_qty,'new_quantity'=>$new_qty,'received_by'=>Auth::user()->id,'received_at'=>date('Y-m-d H:i:s')]);
                            if($update) {
                                $pro->update(['quantity'=>$new_qty]);
                            }
                        } else {
                            $add = DB::connection('tenant')->table('store_products')->insert(['store_id' => $store->id, 'product_id'=>$product->id, 'quantity'=>$row['quantity'], 'active'=>'yes', 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' =>  \Carbon\Carbon::now()]);
                            if ($add) {
                                $insert->update(['available_quantity'=>0,'new_quantity'=>$row['quantity'],'received_by'=>Auth::user()->id,'received_at'=>date('Y-m-d H:i:s')]);
                            }
                        }
                        // check for minimum stock level 
                    }
                }
            }
        }
    }
    
}
