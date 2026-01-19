<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProductController;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Transfer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    public function makeTransfer(Request $request){

        $validator = Validator::make($request->all(), [
            'from' => 'required',
            'from_id' => 'required',
            'product_ids' => 'required|array',
            'quantities' => 'required|array',
            'destination_id' => 'required',
            'destination' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

        try {
            DB::beginTransaction();

                 $check = Transfer::where('status','!=','draft')->where('company_id',Auth::user()->company_id)->groupBy('transfer_val')->orderBy('transfer_val','desc')->latest()->first();
                if ($check) {
                    $val = ($check->transfer_val + 1);
                    $val = "0".$val;
                    $t_no = "TRN".Auth::user()->id.$val;
                } else {
                    $val = "01";
                    $t_no = "TRN".Auth::user()->id.$val;
                }

                $sent_at = date('Y-m-d H:i:s');
                $q = null;

                foreach($request->input('product_ids') as $key => $product){

                        // check total quantity

                        $productRaw = Product::where('id', $product)->where('company_id', Auth::user()->company_id)->first();

                        $query = DB::connection('tenant')->table('shop_products')->where('shop_id',$request['from_id'] )->where('product_id', $product)->where('active', 'yes')->first();
                        if (!empty($query)){
                            if ($request['quantities'][$key] > $query->quantity) {
                                return response()->json([
                                            'status' => 0,
                                            'message' => 'product ' . ($productRaw ? $productRaw->name : 'Unknown Product') . ' not enough quantity',
                                ]);
                            }else{

                                $transfer = new Transfer();
                                $transfer->transfer_no = $t_no;
                                $transfer->transfer_val = $val;
                                $transfer->from = strtolower($request->input('from'));
                                $transfer->destination = $request->input('destination');
                                $transfer->from_id = $request->input('from_id');
                                $transfer->destination_id = $request->input('destination_id');
                                $transfer->product_id = $product;
                                $transfer->quantity = $request['quantities'][$key];
                                $transfer->company_id = Auth::user()->company_id;
                                $transfer->sender_id = Auth::user()->id;
                                $transfer->shipper_id = $request->input('shipper_id');
                                $transfer->status = 'sent';
                                $transfer->sent_at = $sent_at;
                                $transfer->save();


                                if ($request['from'] == 'store') {
                                    $q = DB::connection('tenant')->table('store_products')->where('store_id',$request['from_id'])->where('product_id',$product)->where('active','yes');
                                    $ssid = $transfer->fstore->id;
                                }
                                if ($request['from'] == 'shop') {
                                    $q = DB::connection('tenant')->table('shop_products')->where('shop_id',$request['from_id'])->where('product_id',$product)->where('active','yes');
                                    $ssid = $transfer->fshop->id;
                                }

                                if ($q->first()) {
                                    $quantity = ($q->first()->quantity - $request['quantities'][$key]);
                                    $q->update(['quantity'=>$quantity]);
                                }

                                if(Auth::user()->company->isCheckingStockLevel()){ $min_stock = "yes"; } else { $min_stock = "no"; }

                                if($min_stock == "yes") {
                                    $pro = \App\Product::find($product);
                                    if($pro) {
                                        if ($pro->min_stock_level >= $quantity) {
                                            ProductController::insertMSL($pro->id,$request['from'],$ssid,$pro->min_stock_level);
                                        }

                                    }
                                }
                            }
                        }else{
                             return response()->json([
                                    'status' => 0,
                                    'message' => 'product ' . ($productRaw ? $productRaw->name : 'Unknown Product') . ' not belong to our shop',
                                ]);
                        }



                }


                return response()->json([
                    'status'=> 1,
                    'message'=> 'success',
                ]);

            DB::commit();
        } catch (\Exception $e) {
             DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }

    }

    public function getShippers(){
        $shipper = DB::connection('tenant')->table('users')
            ->where('company_id', Auth::user()->company_id)
            ->where('status', 'active')
            ->select('id', 'name')
            ->get();

        return response()->json([
            'status' => 1,
            'message'=> 'success',
            'data' => $shipper
        ]);
    }

    public function transferDash($shop_id){

        //OVERALL STATUS
        $overol_baseQuery = Transfer::where('company_id', Auth::user()->company_id)
            // ->where('status', 'sent')
            ->where(function ($query) use ($shop_id) {
                $query->where(function ($q) use ($shop_id) {
                    $q->where('from', 'shop')
                    ->where('from_id', $shop_id);
                })
                ->orWhere(function ($q) use ($shop_id) {
                    $q->where('destination', 'shop')
                    ->where('destination_id', $shop_id);
                });
            });

        $data['transfer_total'] = (clone $overol_baseQuery)->count();

        $data['transfer_monthly'] = (clone $overol_baseQuery)
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();

        //PENDING STATUS
        $pending_baseQuery = Transfer::where('company_id', Auth::user()->company_id)
            ->where('status', 'sent')
            ->where(function ($query) use ($shop_id) {
                $query->where(function ($q) use ($shop_id) {
                    $q->where('from', 'shop')
                    ->where('from_id', $shop_id);
                })
                ->orWhere(function ($q) use ($shop_id) {
                    $q->where('destination', 'shop')
                    ->where('destination_id', $shop_id);
                });
            });

        $dataRaw['transfer_pending'] = (clone $pending_baseQuery)
            ->with([
                'shipper:id,name',
                'sender:id,name',
                'dshop:id,name',
                'product:id,name'
            ])
            // ->addSelect('*', DB::raw("'pending' as front_status"))
            ->addSelect(
                '*',
                DB::raw("'pending' as front_status"),
                DB::raw("
                    CASE
                        WHEN `from` = 'shop' AND `from_id` = {$shop_id} THEN 'in'
                        WHEN `destination` = 'shop' AND `destination_id` = {$shop_id} THEN 'out'
                        ELSE 'unknown'
                    END AS flag
                ")
            )
            ->get();

        // $data['pending_total'] = (clone $pending_baseQuery)->count();

        // $data['pending_monthly'] = (clone $pending_baseQuery)
        //     ->whereMonth('created_at', date('m'))
        //     ->whereYear('created_at', date('Y'))
        //     ->count();


        //RECEIVED STATUS
        $received_baseQuery = Transfer::where('company_id', Auth::user()->company_id)
            ->where('status', 'received')
            ->where(function ($query) use ($shop_id) {
                $query->where('destination', 'shop')
                    ->where('destination_id', $shop_id);
            });

        $dataRaw['transfer_received'] = (clone $received_baseQuery)
            ->with([
                'shipper:id,name',
                'sender:id,name',
                'dshop:id,name',
                'product:id,name'
            ])
            ->addSelect('*', DB::raw("'received' as front_status"))
            ->get();

        // $data['received_total'] = (clone $received_baseQuery)->count();

        // $data['received_monthly'] = (clone $received_baseQuery)
        //     ->whereMonth('created_at', date('m'))
        //     ->whereYear('created_at', date('Y'))
        //     ->count();



        //SENT STATUS
        $sent_baseQuery = Transfer::where('company_id', Auth::user()->company_id)
            ->where('status', 'received')
            ->where(function ($query) use ($shop_id) {
                $query->where(function ($q) use ($shop_id) {
                    $q->where('from', 'shop')
                    ->where('from_id', $shop_id);
                });
            });

        // $data['sent_total'] = (clone $sent_baseQuery)->count();

        // $data['sent_monthly'] = (clone $sent_baseQuery)
        //     ->whereMonth('created_at', date('m'))
        //     ->whereYear('created_at', date('Y'))
        //     ->count();

        $dataRaw['transfer_sent'] = (clone $sent_baseQuery)
            ->with([
                'shipper:id,name',
                'sender:id,name',
                'dshop:id,name',
                'product:id,name'
            ])
            ->addSelect('*', DB::raw("'sent' as front_status"))
            ->get();

        $data['transfer_products'] = collect([
            $dataRaw['transfer_pending'],
            $dataRaw['transfer_received'],
            $dataRaw['transfer_sent'],
        ])->collapse()->values();


        return response()->json([
            'status' => 1,
            'message'=> 'success',
            'data' => $data
        ]);
    }

    public function transfer_callback($transfer_id){

        $baseQuery = Transfer::where('id', $transfer_id)
            ->where('company_id', Auth::user()->company_id)
            ->where('status', 'sent')
            ->first();

        if (!$baseQuery) {
            $baseQuery->update([
                'status' => 'received',
                'received_at' => date('Y-m-d H:i:s'),
            ]);

            return response()->json([
                'status' => 1,
                'message'=> 'success',
                'data' => $baseQuery
            ]);
        };

        return response()->json([
            'status' => 0,
            'message'=> 'not found',
            'data' => $baseQuery
        ]);
    }
}
