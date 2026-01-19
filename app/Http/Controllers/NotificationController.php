<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Notification;
use App\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        //
    }

    public function check_get_data($check,$conditions) {    
        $data = array();
        if($check == "check-unread-notifications") {
            $cuser = explode("~",$conditions); // company id and user_id
            $company = $cuser[0];
            $user = $cuser[1];

            $ids = \DB::connection('tenant')->table('user_notifications')->where('user_id',$user)->pluck('notification_id');
            $nots = \App\Notification::whereNotIn('id',$ids)->where('company_id',Auth::user()->company_id)->orderBy('id','desc')->limit(4)->get();

            if($nots->isNotEmpty()) {
                foreach($nots as $n) { 
                    $date = date('d/m/Y', strtotime($n->created_at));
                    $data[] = '<li class="preview-not not-id-'.$n->id.'" nid="'.$n->id.'"><a href="javascript:void(0);"><div class="media"><div class="media-left"><i class="icon-info text-warning"></i></div><div class="media-body text-white"><p class="text">'.$n->sub_title.'</p><span class="timestamp">'.$date.'</span></div></div></a></li>';
                }
            }
            return response()->json(['nots'=>$data]);            
        }

        if($check == "get-all-user-notifications") {
            $cuser = explode("~",$conditions); // company id and user_id
            $company = $cuser[0];
            $user = $cuser[1];
            $nots = \App\Notification::where('company_id',$company)->orderBy('id','desc')->limit(10)->get();

            if($nots->isNotEmpty()) {
                foreach($nots as $n) {
                    $check = \App\UserNotification::where('user_id',$user)->where('notification_id',$n->id)->first();
                    if($check) {
                        $seen = "seen";
                    } else {
                        $seen = "not-seen";
                    }
                    $date = date('d/m/Y', strtotime($n->created_at));
                    $data[] = '<div><div class="card-header '.$seen.' open-notification" nid="'.$n->id.'" id="heading'.$n->id.'"><h5 class="mb-0"><button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse'.$n->id.'" aria-expanded="false" aria-controls="collapse'.$n->id.'">'.
                                $n->sub_title.            
                                '<span class="date">'.$date.'</span>'.
                                '</button></h5></div><div id="collapse'.$n->id.'" class="collapse" aria-labelledby="heading'.$n->id.'" data-parent="#accordion"><div class="card-body">'.
                                $n->description.
                                '</div></div></div>';
                }
            } 

            return response()->json(['status'=>'success','nots'=>$data]);
        }

        if($check == "open-notification") {
            $cuser = explode("~",$conditions); // notification id and user_id
            $user = $cuser[0];
            $notification = $cuser[1];

            $check = \App\UserNotification::where('user_id',$user)->where('notification_id',$notification)->first();
            if($check) {
                // already checked
            } else {
                \App\UserNotification::create(['user_id'=>$user,'notification_id'=>$notification,'status'=>'seen']);
            }
            return response()->json(['status'=>'success']);
        }
        
        if($check == "preview-notification") {
            $cuser = explode("~",$conditions); // notification id and user_id
            $user = $cuser[0];
            $notification = $cuser[1];

            $check = \App\UserNotification::where('user_id',$user)->where('notification_id',$notification)->first();
            if($check) {
                // already seen
            } else {
                \App\UserNotification::create(['user_id'=>$user,'notification_id'=>$notification,'status'=>'seen']);
            }            
            $n = \App\Notification::find($notification);
            $not_blade = '<div><div class="card-header" style="background:#fff" id="heading'.$n->id.'"><h5 class="mb-0"><button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse'.$n->id.'" aria-expanded="false" aria-controls="collapse'.$n->id.'">'.
                            $n->sub_title.            
                            '</button></h5></div><div id="collapse'.$n->id.'" class="collapse show" aria-labelledby="heading'.$n->id.'" data-parent="#accordion"><div class="card-body">'.
                            $n->description.
                            '</div></div></div>';
            return response()->json(['status'=>'success','not'=>$not_blade]);
        }
    }

    public function notifications() {
        return view('notifications');
    }

}
