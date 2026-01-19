<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\ProductCategoryGroup;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductCategoryGroupController extends Controller
{
    public function groups() {
        $user = Auth::user();
        if ($user) {
            $groups = ProductCategoryGroup::where('company_id',$user->company_id)->get();
            return response()->json([
                'status' =>  1,
                'groups' => $groups,
            ]);

        }else{
            return response()->json([
                'status' =>  0,
                'message' => 'not found',
            ]);
        }
    }

    public function groupsTest(){

        $user = Auth::user();
         if ($user) {
            $groups = ProductCategoryGroup::where('company_id',$user->company_id)->get();
            return response()->json([
                'status' =>  1,
                'groups' => $groups,
            ]);

        }else{
            return response()->json([
                'status' =>  0,
                'message' => 'not found',
            ]);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:25',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

        $user = Auth::user();

        $group = ProductCategoryGroup::create([
                'name' => $request->name,
                'company_id'=>$user->company_id,
                'user_id' => $user->id

            ]);

        if (!$group) {
            return response()->json(
                ['status'=> 0,'message'=>'Group not created.']
            );
        }else{
            return response()->json(
                ['status'=> 1,'message'=>'Group created successfully.']
            );
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:25',
            'id'=>'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

        $group = ProductCategoryGroup::where('id',$request->group_id)->update([
            'name',$request->name
        ]);
        if (!$group) {
            return response()->json(
                ['status'=> 0,'message'=>'Group not updated.']
            );
        }else{
            return response()->json(
                ['status'=> 1,'message'=>'Group updated successfully.']
            );
        }
    }

    public function delete($group_id)
    {
        $group = ProductCategoryGroup::where('id',$group_id)
        ->update(['status','deleted']);
        if (!$group) {
            return response()->json(
                ['status'=> 0,'message'=>'Group not deleted.']
            );
        }else{
            return response()->json(
                ['status'=> 1,'message'=>'Group deleted successfully.']
            );
        }
    }

    public function restore($group_id)
    {
        $group = ProductCategoryGroup::where('id',$group_id)
        ->update(['status',null]);
        if (!$group) {
            return response()->json(
                ['status'=> 0,'message'=>'Group not restored.']
            );
        }else{
            return response()->json(
                ['status'=> 1,'message'=>'Group restored successfully.']
            );
        }
    }
}
