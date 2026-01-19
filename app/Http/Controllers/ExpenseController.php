<?php

namespace App\Http\Controllers;

use Session;
use App\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $expense = Expense::create(['name' => $request->name,'status'=>'active','company_id'=>Auth::user()->company_id,'user_id' => Auth::user()->id]);
        if ($expense) {
            return response()->json(['success'=>'Success! Expense created successfully.','id'=>$expense->id,'name'=>$request->name]);
        } 
        return response()->json(['error'=>'Error! Expense not created.']);        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        $expense = Expense::where('id',$request->expense)->where('company_id', Auth::user()->company_id)->first();
        if ($expense) {
            $update = $expense->update(['name' => $request->name, 'user_id' => Auth::user()->id]);
            if ($update) {
                return response()->json(['success'=>'Success! Expense updated successfully.']);
            }
        }
        return response()->json(['error'=>'Error! Something went wrong. Please try again.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        //
    }

    public function expenses($check) {
        if ($check == 'admin') {
            Session::put('role','Admin');
        } elseif ($check == 'ceo') {
            Session::put('role','CEO');
        }
        $data['expenses'] = Expense::where('company_id', Auth::user()->company_id)->get();
        return view('expenses',compact('data'));
    }
}
