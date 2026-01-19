<?php

namespace App\Http\Controllers;

use Session;
use App\ProductCategory;
use App\ProductCategoryGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductCategoryController extends Controller
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
        $max = $request->check;
        for ($i=1; $i <= $max; $i++) { 
            $name = $request->input('name'.$i);
            $category = ProductCategory::create(['name' => $name, 'product_category_group_id' => $request->group,'company_id'=>Auth::user()->company_id, 'user_id' => Auth::user()->id]);
        }        
        if (!$category) {
            return response()->json(['error'=>'Error! Category not created.']);
        } 
        return response()->json(['success'=>'Success! Category created successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        $cat = ProductCategory::where('id',$request->id)->where('company_id',Auth::user()->company_id)->first();
        if ($cat) {
            if(isset($request->check)) { // it is from shop form
                $update = $cat->update(['name' => $request->name, 'user_id' => Auth::user()->id]);
            } else {
                $update = $cat->update(['name' => $request->name, 'product_category_group_id' => $request->group, 'user_id' => Auth::user()->id]);
            }
            if ($update) {
                return response()->json(['success'=>'Success! Product Category updated successfully.']);
            }
        }
        return response()->json(['error'=>'Error! Something went wrong. Please try again.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $productCategory)
    {
        //
    }

    public function categories($check) {
        if ($check == 'admin') {
            Session::put('role','Admin');
        } elseif ($check == 'ceo') {
            Session::put('role','CEO');
        }
        $data['groups'] = ProductCategoryGroup::where('company_id',Auth::user()->company_id)->get();
        return view('product-categories',compact('data'));
    }
}