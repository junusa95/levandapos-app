<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\ProductCategory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller
{
    public function categories(){
        $user = Auth::user();
        $categories = ProductCategory::withCount('products')
        ->where('company_id',$user->company_id)
        // ->where('user_id',$user->id)
        ->where('status',null)
        ->get();
        return response()->json([
            'status' => 1,
            'categories' => $categories
        ]);
    }

    public function create(Request $request){
         $validator = Validator::make($request->all(), [
            'name' => 'required|max:25',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

       $user = Auth::user();

        if ($user) {
            $category = ProductCategory::create([
                'name' => $request->name,
                'product_category_group_id' => $request->group_id,
                'company_id'=>$user->company_id,
                'user_id' => $user->id
            ]);
            return response()->json([
                'status' => 1,
                'message' => "Category created successfully",
                'category' => $category
            ]);
        }else{
            return response()->json([
                'status' => 0,
                'message' => "User not found"
            ]);
        }
    }

    public function update(Request $request){
         $validator = Validator::make($request->all(), [
            'name' => 'required|max:25',
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

       $user = Auth::user();

        if ($user) {
            $category = ProductCategory::where('id', $request->category_id)
            ->update([
                'name' => $request->name,
                'product_category_group_id' => $request->group_id,
                'company_id'=>$user->company_id,
                'user_id' => $user->id
            ]);

            return response()->json([
                'status' => 1,
                'message' => "Category updated successfully",
                'category' => $category
            ]);
        }else{
            return response()->json([
                'status' => 0,
                'message' => "User not found"
            ]);
        }
    }

    public function delete($category_id){
       $user = Auth::user();

        if ($user) {
            $category = ProductCategory::where('id', $category_id)
            ->where('company_id',$user->company_id)
            ->update([
                'status' => 'deleted'
            ]);

            return response()->json([
                'status' => 1,
                'message' => "Category deleted successfully",
                'category' => $category
            ]);
        }else{
            return response()->json([
                'status' => 0,
                'message' => "User not found"
            ]);
        }
    }

    public function restore($category_id){
       $user = Auth::user();

        if ($user) {
            $category = ProductCategory::where('id', $category_id)
            ->where('company_id',$user->company_id)
            ->update([
                'status' => null
            ]);

            return response()->json([
                'status' => 1,
                'message' => "Category restored successfully",
                'category' => $category
            ]);
        }else{
            return response()->json([
                'status' => 0,
                'message' => "User not found"
            ]);
        }
    }
}
