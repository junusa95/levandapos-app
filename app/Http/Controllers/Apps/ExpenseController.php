<?php

namespace App\Http\Controllers\Apps;

use DB;
use App\Expense;
use App\Http\Controllers\Controller;
use App\ShopExpense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    public function store(Request $request)
    {
        // return $request;
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=> 0,
                'message' => 'validation failled',
                'data' => $validator->errors(),
            ]);

        } else {
            $data['expense'] = Expense::create([
                'name' => $request->name,
                'status' => 'active',
                'company_id' => Auth::user()->company_id,
                'user_id' => Auth::user()->id
            ]);

            if ($data['expense']) {
                return response()->json([
                    'status' =>  1,
                    'message' => 'Expense created successfully',
                    'data' =>$data
                ]);
            }
            return response()->json([
                'status' =>  0,
                'message' => 'Expense not created'
            ]);
        }
    }

    public function update(Request $request)
    {
        $expense = Expense::where('id', $request->expense_id)
                            ->where('company_id', Auth::user()->company_id)
                            ->first();
        if ($expense) {
            $data['update'] = $expense->update([
                'name' => $request->name,
                'user_id' => Auth::user()->id
            ]);

            if ($data['update']) {
                return response()->json([
                    'status' =>  1,
                    'message' => 'Expense updated successfully',
                    'data' =>$data
                ]);
            }
        }

        return response()->json([
            'status' =>  0,
            'message' => 'Expense not updated'
        ]);
    }

    public function expenses()
    {
        $data['expenses'] = Expense::where('company_id', Auth::user()->company_id)->where('status', 'active')->get();
        // if ($data['expenses']) {
            return response()->json([
                'status' =>  1,
                'message' => 'Expense data',
                'data' =>$data
            ]);
        // }
    }

    public function delete_expense(Request $request) {
        $data = array();
        $row = Expense::where('id',$request->expense_id)->where('company_id',Auth::user()->company_id)->first();
        if ($row) {

            $solddate = date("d-m-Y", strtotime($row->created_at));
            $data['predate'] = "no";
            if ($solddate != date("d-m-Y")) { //check if deleting today sold item OR previous date
                $data['predate'] = $solddate;
            }

            // $row->delete();
            $row->update(['status'=>'deleted']);
        }
        // return response()->json(['success'=>'success','data'=>$data]);

            return response()->json([
                'status' =>  0,
                'message' => 'Expense deleted successfully',
            ]);
    }


    // public function shop_expenses($shop_id, $from_date, $to_date)
    // {
    //     $data['expenses'] = ShopExpense::with('expense:id,name')->where('company_id', Auth::user()->company_id)
    //     ->where('shop_id',$shop_id)
    //     // ->whereBetween('created_at', [$fom_date." 00:00:00", $to_date." 23:59:59"])
    //     ->whereBetween('created_at', [Carbon::parse($from_date),Carbon::parse($to_date)])
    //     ->get();

    //     $data['total_expenses'] = $data['expenses']->sum('amount');

    //     return response()->json([
    //         'status' =>  1,
    //         'message' => 'Expense data',
    //         'data' =>$data
    //     ]);
    // }

    public function shop_expenses($shop_id, $from_date, $to_date)
{
    $expenses = ShopExpense::with('expense:id,name')
        ->where('company_id', Auth::user()->company_id)
        ->where('shop_id', $shop_id)
        ->whereBetween('created_at', [
            Carbon::parse($from_date)->startOfDay(),
            Carbon::parse($to_date)->endOfDay()
        ])
        ->get();

    // Group by date (only Y-m-d part of created_at)
    $grouped = $expenses->groupBy(function ($item) {
        return Carbon::parse($item->created_at)->format('Y-m-d');
    });

    // Build structured response with total per date
    $data = $grouped->map(function ($items, $date) {
        return [
            'date' => $date,
            'total' => $items->sum('amount'),
            'expenses' => $items->map(function ($exp) {
                return [
                    'id' => $exp->id,
                    'shop_id' => $exp->shop_id,
                    'expense_id' => $exp->expense_id,
                    'expense_name' => $exp->expense->name ?? null,
                    'amount' => $exp->amount,
                    'description' => $exp->description,
                    'created_at' => $exp->created_at->format('Y-m-d H:i:s'),
                ];
            })->values()
        ];
    })->values();

    $total_expenses = $expenses->sum('amount');

    return response()->json([
        'status' => 1,
        'message' => 'Expense data grouped by date',
        'total_expenses' => $total_expenses,
        'data' => $data,
    ]);
}

    public function shop_expenses_on_sales($shop_id, $from_date, $to_date)
{
    $expenses = ShopExpense::with('expense:id,name')
        ->where('company_id', Auth::user()->company_id)
        ->where('shop_id', $shop_id)
        ->whereBetween(DB::raw("DATE(created_at)"), [
            Carbon::parse($from_date),
            Carbon::parse($to_date)
        ])
        ->get();

    // Group by date (only Y-m-d part of created_at)
    $grouped = $expenses->groupBy(function ($item) {
        return Carbon::parse($item->created_at)->format('Y-m-d');
    });

    // Build structured response with total per date
    $data = $grouped->map(function ($items, $date) {
        return [
            'date' => $date,
            'total' => $items->sum('amount'),
            'expenses' => $items->map(function ($exp) {
                return [
                    'id' => $exp->id,
                    'shop_id' => $exp->shop_id,
                    'expense_id' => $exp->expense_id,
                    'expense_name' => $exp->expense->name ?? null,
                    'amount' => $exp->amount,
                    'description' => $exp->description,
                    'created_at' => $exp->created_at->format('Y-m-d H:i:s'),
                ];
            })->values()
        ];
    })->values();

    $total_expenses = $expenses->sum('amount');

    return response()->json([
        'status' => 1,
        'message' => 'Expense data grouped by date',
        'total_expenses' => $total_expenses,
        'data' => $data,
    ]);
}


    public function shop_expense_create(Request $request) {


        $validator = Validator::make($request->all(), [
            'expense_date' => ['required'],
            'shop_id' => ['required'],
            'expense_id' => ['required'],
            'amount' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=> 0,
                'message' => 'validation failled',
                'data' => $validator->errors(),
            ]);

        } else {
            $data = array();
            $curtime = date('H:i:s');
            $expdate =  str_replace("/", "-", $request->expense_date);
            $expdate = date("Y-m-d H:i:s", strtotime($expdate.$curtime));

            $data['expense'] = ShopExpense::create([
                'shop_id' => $request->shop_id,
                'expense_id' => $request->expense_id,
                'amount' => $request->amount,
                'description' => $request->description,
                'company_id'=>Auth::user()->company_id,
                'user_id' => Auth::user()->id,
                'created_at'=>$expdate
            ]);

            if ($data['expense']) {

                // $solddate = date("d-m-Y", strtotime($data['expense']->created_at));
                // $data['predate'] = "no";
                // if ($solddate != date("d-m-Y")) { //check if deleting today sold item OR previous date
                //     $data['predate'] = $solddate;
                // }

                return response()->json([
                    'status' =>  1,
                    'message' => 'Shop Expense created successfully',
                    'data' =>$data
                ]);
                // return response()->json([
                //     'status'=>'success',
                //     'val'=>$request->shop_id,
                //     'data'=>$data
                // ]);
            } else {
                return response()->json([
                    'status' =>  0,
                    'message' => 'Shop Expense not created'
                ]);
            }
        }
    }

    public function shop_expense_update(Request $request) {


        $validator = Validator::make($request->all(), [
            'shop_expense_id' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=> 0,
                'message' => 'validation failled',
                'data' => $validator->errors(),
            ]);

        } else {
            $data = array();

            $data['expense'] = ShopExpense::where('id',$request->shop_expense_id)
            ->where('company_id',Auth::user()
            ->company_id)->first();

            if ($data['expense']) {
                $update = $data['expense']->update([
                    'shop_id' => $request->shop_id,
                    'expense_id' => $request->expense_id,
                    'amount' => $request->amount,
                    'description' => $request->description,
                    'user_id' => Auth::user()->id
                ]);
                if($update) {
                    // $solddate = date("d-m-Y", strtotime($data['expense']->created_at));
                    // $data['predate'] = "no";
                    // if ($solddate != date("d-m-Y")) { //check if deleting today sold item OR previous date
                    //     $data['predate'] = $solddate;
                    // }

                    // return response()->json(['status'=>'success','data'=>$data]);
                    return response()->json([
                    'status' =>  1,
                    'message' => 'Shop Expense updated successfully',
                    'data' =>$data
                ]);
                }
            }
            return response()->json([
                'status' =>  0,
                'message' => 'Shop Expense not updated'
            ]);
        }
    }


    public function shop_expense_delete(Request $request) {
        $data = array();
        $row = ShopExpense::where('id',$request->shop_expense_id)
        ->where('company_id',Auth::user()
        ->company_id)->first();

        if ($row) {

            $solddate = date("d-m-Y", strtotime($row->created_at));
            $data['predate'] = "no";
            if ($solddate != date("d-m-Y")) { //check if deleting today sold item OR previous date
                $data['predate'] = $solddate;
            }

            $row->delete();
            return response()->json([
                'status' =>  0,
                'message' => 'Shop Expense deleted successfully',
            ]);
        }
        // return response()->json(['success'=>'success','data'=>$data]);


    }


}
