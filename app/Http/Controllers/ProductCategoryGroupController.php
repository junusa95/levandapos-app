<?php

namespace App\Http\Controllers;

use App\ProductCategoryGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductCategoryGroupController extends Controller
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
        $group = ProductCategoryGroup::create(['name' => $request->name,'company_id'=>Auth::user()->company_id, 'user_id' => Auth::user()->id]);
        if (!$group) {
            return response()->json(['error'=>'Error! Group not created.']);
        } 
        return response()->json(['success'=>'Success! Group created successfully.','group'=>$group]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductCategoryGroup  $productCategoryGroup
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCategoryGroup $productCategoryGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductCategoryGroup  $productCategoryGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCategoryGroup $productCategoryGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductCategoryGroup  $productCategoryGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        $group = ProductCategoryGroup::where('id',$request->id)->where('company_id',Auth::user()->company_id)->first();
        if ($group) {
            $update = $group->update(['name' => $request->name, 'user_id' => Auth::user()->id]);
            if ($update) {
                return response()->json(['success'=>'Success! Category Group updated successfully.']);
            }
        }
        return response()->json(['error'=>'Error! Something went wrong. Please try again.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductCategoryGroup  $productCategoryGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategoryGroup $productCategoryGroup)
    {
        //
    }
}
