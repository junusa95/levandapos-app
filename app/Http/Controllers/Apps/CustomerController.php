<?php

namespace App\Http\Controllers\Apps;

use App\Customer;
use App\CustomerDebt;
use App\Http\Controllers\Controller;
use App\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{


    public function customers($shop_id){
        $data['customer_total'] = Customer::with('shop:id,name')
                            // ->where('status','active')
                            ->where('shop_id',$shop_id)
                            ->where('company_id',Auth::user()->company_id)
                            ->count();

                            $companyId = Auth::user()->company_id;
                            $today = Carbon::today();


            $data['customer'] = Customer::with('shop:id,name')
                                ->withSum(['debt as total_debt' => function ($query) use ($today, $companyId) {
                                    $query->where('status', '!=', 'deleted')
                                        // ->whereDate('updated_at', '<=', $today)
                                        ->where('company_id', $companyId)
                                        ->select(DB::raw('SUM(
                                            CASE
                                                WHEN interest IS NULL THEN debt_amount
                                                ELSE amount_with_interest
                                            END
                                        )'));
                                }], 'total_debt')
                                ->where('status', 'active')
                                ->where('shop_id', $shop_id)
                                ->where('company_id', $companyId)
                                ->orderBy('id', 'desc')
                                ->get();


        // $data['customer'] = Customer::with('shop:id,name')
        //             ->withSum(['debt as total_debt' => function ($query) {
        //                 $query->where('status', '<>', 'deleted');
        //             }], 'debt_amount')
        //                     ->where('status','active')
        //                     ->where('shop_id',$shop_id)
        //                     ->where('company_id',Auth::user()->company_id)
        //                     ->orderBy('id','desc')
        //                     ->get();

        // $data['debt'] = $data['customer']->debt->sum('debt_amount');
    //   $data['customer'] = $customers->map(function ($customer) {
    //     $customer->total_debt = $customer->debt->sum('debt_amount');
    //     return $customer;
    // });

        if ($data['customer']->isNotEmpty()) {
           return response()->json([
                'status' => 1,
                'message'=> 'success',
                'data' => $data
                // 'data' => $data['customer']
            ]);
        }
    }

    public function getCustomer($customer_id,$shop_id){ 
        $customer = Customer::with('shop:id,name')
            ->where('id', $customer_id)
            ->where('company_id', Auth::user()->company_id)
            ->first();

        if (!$customer) {
            return response()->json([
                'status'  => 0,
                'message' => 'Customer not found',
                'data'    => null,
            ], 404);
        }

        $debtQuery = \App\CustomerDebt::where('customer_id', $customer_id)
            ->where('status', '!=', 'deleted');

        $data = [
            'customer'     => $customer,
            'debt'         => (float) $debtQuery->sum('debt_amount'),
            'interest'     => (float) $debtQuery->sum('interest_amount'),
            'total_debt'   => (float) (
                $debtQuery->sum('debt_amount') +
                $debtQuery->sum('interest_amount')
            ),
            'activities'   => $this->customerActivities($shop_id, $customer_id),
        ];

        return response()->json([
            'status'  => 1,
            'message' => 'Success',
            'data'    => $data,
        ]);
    }


    public function store(Request $request)
    {

        $data['customer'] = Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'location' => $request->location,
            'company_id' => Auth::user()->company_id,
            'shop_id'=>$request->shopId,
            'user_id' => Auth::user()->id,
            'status'=>'active'
        ]);

        if ($data['customer']) {
            return response()->json([
                'status' => 1,
                'message'=> 'success',
                'data' => $data
            ]);
        }else{
            return response()->json([
                'status' => 0,
                'message'=> 'failed',
                'data' => $data
            ]);
        }
    }

    public function update(Request $request) {
        $customer = Customer::where('id',$request->customer)
                            ->where('company_id', Auth::user()->company_id)->first();
        if ($customer) {
            $update = $customer->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'location' => $request->location
            ]);
            if ($update) {
                return response()->json([
                    'status' => 1,
                    'message'=> 'Success',
                    'data' => $customer
                ]);
            }else{
                return response()->json([
                    'status' => 0,
                    'message'=> 'Error! Customer not updated.',
                    'data' => []
                ]);
            }
        }else{

            return response()->json([
                'status' => 0,
                'message'=> 'Error! Customer not found.',
                'data' => []
            ]);
        }
    }

    public function getDeletedCustomers(Request $request){
        $query = Customer::where('company_id', Auth::user()->company_id)
        ->where('status','deleted');

        if (!empty($request->input('name')) && $request->input('name') != 'null') {

            $keyword = $request->input('name');
            $query->where('name', 'like', '%' . $keyword . '%');

        }

        $customers = $query->get();


        // return response()->json($customers);
        return response()->json([
                'status' => 1,
                'message'=> 'success',
                'data' => $customers
            ]);
    }

    public function restoreCustomer($cusromer_id){
        $customer = Customer::where('id',$cusromer_id)
                            ->where('company_id',Auth::user()->company_id)
                            ->update(['status' => 'active']);
        if ($customer) {
        //    return response()->json(['status' => 'success']);
           return response()->json([
                'status' => 1,
                'message'=> 'success',
                'data' => $customer
            ]);
        }
    }

    public function delete_customer($cusromer_id){
        // return 123;
        $customer = Customer::where('id',$cusromer_id)
                            ->where('company_id',Auth::user()->company_id)
                            ->first();
                            // ->update(['status' => 'deleted']);

        // $customer->status = 'deleted';
        // $customer->save();

        $find = Customer::where('id',$cusromer_id)->where('company_id',Auth::user()->company_id)->first();
            if ($find) {
                $find->update(['status'=>'deleted','user_id'=>Auth::user()->id]);

        // if ($customer) {
        //    return response()->json(['status' => 'success']);
           return response()->json([
                'status' => 1,
                'message'=> 'success',
                'data' => ""
            ]);
        }
    }

    private function customerActivities($shop_id,$customer_id){

        $fd = CustomerDebt::where('company_id',Auth::user()->company_id)
        ->where('shop_id',$shop_id)
        // ->whereDate('updated_at','<=',Carbon::today())
        ->where('customer_id',$customer_id)
        ->where('status','!=','deleted')
        ->where('interest',null)
        ->sum('debt_amount');

        $sd = CustomerDebt::where('company_id',Auth::user()->company_id)
        ->where('shop_id',$shop_id)
        // ->whereDate('updated_at','<=',Carbon::today())
        ->where('status','!=','deleted')
        ->where('customer_id',$customer_id)
        ->sum('amount_with_interest');

        $totald = $fd + $sd;
        $data["available_bebt"] = $data['curr_deni'] = $totald;

         $sum = CustomerDebt::query()
            ->select([
                DB::raw('
                    customer_debts.customer_id as customer_id,
                    DATE(updated_at) as ddate,
                    SUM(CASE WHEN status = "buy stock" THEN debt_amount ELSE 0 END) as debt_amount,
                    SUM(CASE WHEN status = "buy stock" THEN stock_value ELSE 0 END) as purchase_amount,
                    SUM(CASE WHEN status = "buy stock" THEN amount_paid ELSE 0 END) as amount_paid,
                    SUM(CASE WHEN status = "weka pesa" THEN amount_paid ELSE 0 END) as deposit_amount,
                    SUM(CASE WHEN status = "lend money" THEN debt_amount ELSE 0 END) as loan,
                    SUM(CASE WHEN status = "lend money" THEN interest_amount ELSE 0 END) as total_interest,
                    SUM(CASE WHEN status = "lend money" THEN interest ELSE 0 END) as interest,
                    SUM(CASE WHEN status = "pay debt" THEN debt_amount ELSE 0 END) as pay_debt,
                    SUM(CASE WHEN status = "refund" THEN debt_amount ELSE 0 END) as refund
                ')
            ])
            ->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)
            ->where('customer_id',$customer_id)
            ->where('status','!=','deleted')            
            ->groupBy(
                'customer_debts.customer_id',
                DB::raw('DATE(updated_at)')
            )->orderBy('ddate','desc')
            ->get();

            $data["activities"] = $sum;

        return $sum;
    }

    public function payAmount(Request $request){

        $validator = Validator::make($request->all(), [
            'shop_id' => 'required',
            'customer_id' => 'required',
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

            $shop_id = $request->shop_id;
            $customer_id = $request->customer_id;
            $amount = $request->amount;
            $debt_amount = 0 - $amount;
            $payment = CustomerDebt::create([
                'shop_id'=>$shop_id,
                'customer_id'=>$customer_id,
                'debt_amount'=>$debt_amount,
                'status'=>'weka pesa',
                'amount_paid'=>$amount,
                'company_id'=>Auth::user()->company_id,
                'user_id'=>Auth::user()->id
            ]);

        return response()->json([
            'status' => 1,
            'message'=> 'success paid',
            'data' => $payment
        ]);

    }

    public function updatePaymentAmount(Request $request){

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'amount' => 'required',
            'status' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

        $row = CustomerDebt::where('company_id',Auth::user()->company_id)->where('id',$request->id)->where('status',$request->status)->first();

        if ($row) {


            if ($row->status == 'weka pesa') {
                $neg_amount = '-'.$request->amount;

                $row->debt_amount = $neg_amount;
                $row->amount_paid = $request->amount;
                $row->timestamps = false;
            }elseif ($row->status == 'lend money') {

                $interest = $row->interest;
                $interest_amount = $request->amount * ($interest / 100);
                $amount_w_interest = $request->amount + $interest_amount;


                $row->debt_amount = $request->amount;
                $row->interest_amount = $request->$interest_amount;
                $row->amount_with_interest = $amount_w_interest;
                $row->timestamps = false;

            }else{
                $debt_amount = $request->amount;
                $interest = $interest_amount = $amount_w_interest = null;

                $row->debt_amount = $debt_amount;
                $row->interest_amount = $request->$interest_amount;
                $row->amount_with_interest = $amount_w_interest;
                $row->timestamps = false;
            }

            $row->save();

            return response()->json([
                'status' => 1,
                'message'=> 'success paid',
                'data' => $row
            ]);

        }else{
            return response()->json([
                'status' => 0,
                'message'=> 'dept never found',
                'data' => []
            ]);
        }

    }

    public function deletePaymentAmount($id){
            // $row = CustomerDebt::where('company_id',Auth::user()->company_id)->where('id',$id)->where('status','weka pesa')->first();
            $row = CustomerDebt::where('company_id',Auth::user()->company_id)->where('id',$id)->first();
            if ($row) {
                $row->status2 = $row->status;
                $row->status = "deleted";
                $row->timestamps = false;
                $row->save();

                return response()->json([
                    'status' => 1,
                    'message'=> 'success deleted'
                ]);
            }else{
                 return response()->json([
                    'status' => 0,
                    'message'=> 'no data where found'
                ]);
            }
    }

    public function LendMoney(Request $request){
         $validator = Validator::make($request->all(), [
            'shop_id' => 'required',
            'amount' => 'required|numeric',
            'purpose' => 'required',
            'customer_id' => 'required',
            // 'interest' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

        $debt_amount = $request->amount;
        $interest = $interest_amount = $amount_w_interest = null;
        if($request->purpose == "lend money") {
            if($request->interest && $request->interest != 0) {
                $interest = $request->interest;
                $interest_amount = $debt_amount * ($request->interest / 100);
                $amount_w_interest = $debt_amount + $interest_amount;
            }
        }

        $payment = CustomerDebt::create([
            'shop_id'=>$request->shop_id,
            'customer_id'=>$request->customer_id,
            'debt_amount'=>$debt_amount,
            'status'=>$request->purpose,
            'interest'=>$interest,
            'interest_amount'=>$interest_amount,
            'amount_with_interest'=>$amount_w_interest,
            'company_id'=>Auth::user()->company_id,
            'user_id'=>Auth::user()->id
        ]);


        return response()->json([
            'status' => 1,
            'message'=> 'success paid',
            'data' => $payment
        ]);

    }


    public function purchases($shop_id, $customer_id){
        $sales = Sale::with('product')->where('shop_id',$shop_id)->where('customer_id',$customer_id)->where('company_id', Auth::user()->company_id)->get();
         return response()->json([
            'status' => 1,
            'message'=> 'success paid',
            'data' => $sales
        ]);
    }

    public function getActivityDetails($shop_id,$date,$customer_id,$status){
        $data = CustomerDebt::where('company_id',Auth::user()->company_id)
                            ->where('shop_id',$shop_id)
                            ->whereDate('updated_at', $date)->where('customer_id',$customer_id)->where('status', $status)->get();

        return response()->json([
            'status' => 1,
            'message'=> 'success',
            'data' => $data
        ]);
    }

}
