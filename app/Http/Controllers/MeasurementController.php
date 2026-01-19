<?php

namespace App\Http\Controllers;

use Session;
use App\Measurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeasurementController extends Controller
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
        $measurement = Measurement::create(['name' => $request->name, 'symbol' => $request->symbol, 'company_id'=>Auth::user()->company_id, 'user_id' => Auth::user()->id]);
        if (!$measurement) {
            return response()->json(['error'=>'Error! Measurement not created.']);
        } 
        return response()->json(['success'=>'Success! Measurement created successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Measurement  $measurement
     * @return \Illuminate\Http\Response
     */
    public function show(Measurement $measurement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Measurement  $measurement
     * @return \Illuminate\Http\Response
     */
    public function edit(Measurement $measurement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Measurement  $measurement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        $measurement = Measurement::where('id',$request->measurement)->where('company_id',Auth::user()->company_id)->first();
        if ($measurement) {
            $update = $measurement->update(['name' => $request->name, 'symbol' => $request->symbol, 'user_id' => Auth::user()->id]);
            if ($update) {
                return response()->json(['success'=>'Success! Measurement updated successfully.']);
            }
        }
        return response()->json(['error'=>'Error! Something went wrong. Please try again.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Measurement  $measurement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Measurement $measurement)
    {
        //
    }

    public function measurements($check) {
        if ($check == 'admin') {
            Session::put('role','Admin');
        } elseif ($check == 'ceo') {
            Session::put('role','CEO');
        }
        $data['measurements'] = Measurement::where('company_id',Auth::user()->company_id)->get();
        return view('measurements',compact('data'));
    }
}
