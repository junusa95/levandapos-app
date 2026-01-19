<?php

namespace App\Http\Controllers;

use DB;
use App\Country;
use App\Currency;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentController extends Controller
{
    public function get_data($check) {
        if(Auth::user()->isAgent()) {
            if($check == "register-account") {
                $data['countries'] = Country::all();
                $data['currencies'] = Currency::all();
                return view('agent.register-account', compact('data'));
            }
            
            if($check == "accounts-you-registered") {
                return view('agent.accounts-you-registered');
            }
        } else {
            return redirect()->back()->with('error','Sorry! It seems like you dont have permission in this page.');
        }
    }
    
    public function get_data2($check,$check2) {
        $output = array();
        $data = array();
        if($check == "agent-accounts") { // this if condition is used by agent and admin
            $aid = $check2;
            $agent = \App\User::find($aid);
            $no_of_shops = $no_of_stores = $agent_c = 0;
            $data['total_accounts'] = $data['total_active'] = $data['total_free'] = $data['total_e_free'] = $data['total_e_payments'] = 0;
            $a_c = DB::table('agent_companies')->where('user_id',$aid)->get();
            if($agent->agentAccounts()->get()->isNotEmpty()) {
                $data['total_accounts'] = $agent->agentAccounts()->count();
                $data['total_active'] = $agent->agentAccounts()->where('status','active')->count();
                $data['total_free'] = $agent->agentAccounts()->where('status','free trial')->count();
                $data['total_e_free'] = $agent->agentAccounts()->where('status','end free trial')->count();
                $data['total_e_payments'] = $agent->agentAccounts()->where('status','not paid')->count();
                $i = 1;
                foreach($agent->agentAccounts()->get() as $ac) {
                    // check payment status 
                    $payment_status = "--";
                    if($ac->status == "active") {
                        $payment_status = "<span class='badge badge-success'>Active</span>";
                    } elseif ($ac->status == "not paid") {
                        $payment_status = "<span class='badge badge-danger'>End payment</span>";
                    } elseif ($ac->status == "free trial") {
                        $payment_status = "<span class='badge badge-info'>Free trial</span>";
                    } elseif ($ac->status == "end free trial") {
                        $payment_status = "<span class='badge badge-danger'>End free trial</span>";
                    }

                    if($ac->shops()) {
                        $no_of_shops = $ac->shops()->count();
                    }
                    if($ac->stores()) {
                        $no_of_stores = $ac->stores()->count();
                    }
                    $output[] = '<tr><td>'.$i.'</td>'
                    .'<td>'.$ac->name.'</td>'
                    .'<td><small>No of shops:</small> <b>'.$no_of_shops.'</b><br><small>No of stores:</small> <b>'.$no_of_stores.'</b></td>'
                    .'<td>'.date('d/m/Y', strtotime($ac->created_at)).'</td>'
                    .'<td class="last-a-'.$ac->id.'"><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i></td>'
                    .'<td>'.$payment_status.'</td>'
                    .'</tr>';
                        $i++;
                }
                $agent_c = DB::table('agent_payments')->where('user_id',$aid)->whereMonth('date',Carbon::now()->month)->sum('amount');
            } else {
                $output[] = '<tr class="empty-row"><td colspan="6" align="center"><i>-- No account registered --</i></td></tr>';
            }
            
            return response()->json(['accounts'=>$output,'data'=>$data,'agent_commission'=>number_format($agent_c, 0)]);
        }

        if($check == "agent-accounts-count") {
            $aid = $check2;
            $data['total_accounts'] = $data['total_active'] = $data['total_free'] = $data['total_e_free'] = $data['total_e_payments'] = 0;
            $agent = \App\User::find($aid);
            if($agent->agentAccounts()->get()->isNotEmpty()) {
                $data['total_accounts'] = $agent->agentAccounts()->count();
                $data['total_active'] = $agent->agentAccounts()->where('status','active')->count();
                $data['total_free'] = $agent->agentAccounts()->where('status','free trial')->count();
                $data['total_e_free'] = $agent->agentAccounts()->where('status','end free trial')->count();
                $data['total_e_payments'] = $agent->agentAccounts()->where('status','not paid')->count();
            }
            return response()->json(['data'=>$data,'aid'=>$aid]);
        }
        
        if($check == "agent-accounts-sh-st") {
            $aid = $check2;
            $data['total_shops'] = $data['total_stores'] = 0;
            $agent = \App\User::find($aid);
            if($agent->agentAccounts()->get()->isNotEmpty()) { // check if he/she already create account
                $data['total_shops'] = DB::table('shops')->join('companies','companies.id','shops.company_id')->join('agent_companies','agent_companies.company_id','companies.id')->where('agent_companies.user_id',$aid)->get('shops.id')->count();
                $data['total_stores'] = DB::table('stores')->join('companies','companies.id','stores.company_id')->join('agent_companies','agent_companies.company_id','companies.id')->where('agent_companies.user_id',$aid)->get('stores.id')->count();
                
            }
            return response()->json(['data'=>$data,'aid'=>$aid]);
        }
        
        if($check == "agent-active-shops") {
            $aid = $check2;
            $data = array();
            $data['total_shops'] = 0;
            $agent = \App\User::find($aid);
                $shops = DB::table('shops')->join('companies','companies.id','shops.company_id')
                            ->join('agent_companies','agent_companies.company_id','companies.id')
                            ->where('agent_companies.user_id',$aid)->where('shops.status','active')
                            ->select('*','shops.name as sname','companies.name as cname','shops.created_at as sdate')->get();
                if($shops->isNotEmpty()) {
                    $data['total_shops'] = $shops->count();
                    $i = 1;
                    foreach($shops as $shop) {
                        $output[] = '<tr><td>'.$i.'</td>'
                        .'<td>'.$shop->sname.'<br><small>('.$shop->cname.')</small></td>'
                        .'<td>'.date('d/m/Y', strtotime($shop->sdate)).'</td>'
                        .'</tr>';
                            $i++;
                    }
                } else {
                    $output[] = "<tr><td colspan='3' align='center'><i>No Active Shops yet</i></td></tr>";
                }
            return response()->json(['data'=>$data,'aid'=>$aid,'shops'=>$output]);
        }
        
        if($check == "agent-active-stores") {
            $aid = $check2;
            $data = array();
            $data['total_stores'] = 0;
            $agent = \App\User::find($aid);
                $stores = DB::table('stores')->join('companies','companies.id','stores.company_id')
                            ->join('agent_companies','agent_companies.company_id','companies.id')
                            ->where('agent_companies.user_id',$aid)->where('stores.status','active')
                            ->select('*','stores.name as sname','companies.name as cname','stores.created_at as sdate')->get();
                if($stores->isNotEmpty()) {
                    $data['total_stores'] = $stores->count();
                    $i = 1;
                    foreach($stores as $store) {
                        $output[] = '<tr><td>'.$i.'</td>'
                        .'<td>'.$store->sname.'<br><small>('.$store->cname.')</small></td>'
                        .'<td>'.date('d/m/Y', strtotime($store->sdate)).'</td>'
                        .'</tr>';
                            $i++;
                    }
                } else {
                    $output[] = "<tr><td colspan='3' align='center'><i>No Active Stores yet</i></td></tr>";
                }
            return response()->json(['data'=>$data,'aid'=>$aid,'stores'=>$output]);
        }
        
        if($check == "get-agents") {
            $total_agents = 0;
            if($check2 == "all") {
                $data['agents'] = \App\User::whereHas('roles', function ($q){
                        return $q->where('roles.id', 11);
                    })->orderBy('id','desc')->get();
                $data['total_agents'] = \App\User::whereHas('roles', function ($q){
                        return $q->where('roles.id', 11);
                    })->get()->count();

                $view = view('admin.tables.agents', compact('data'))->render();
                return response()->json(['agents'=>$view,'data'=>$data]);
            }
            if($check2 == "7") {
                $agents = \App\User::whereHas('roles', function ($q){
                        return $q->where('roles.id', 11);
                    })->orderBy('id','desc')->limit(7)->get();
                $total_agents = \App\User::whereHas('roles', function ($q){
                        return $q->where('roles.id', 11);
                    })->get()->count();

                if($agents->isNotEmpty()) {
                    foreach($agents as $agent) {    
    
                        $output[] = "<tr class='agent-row'><td><a href='/admin/agents/".$agent->id."'>".$agent->name."</a><br>".$agent->address."</td><td>".date('d/m/Y', strtotime($agent->created_at))."</td></tr>";
                    }
                }
                return response()->json(['output'=>$output,'total'=>$total_agents]);
            }
        }
        
        if($check == "five-previous-payments") {
            $aid = $check2;
            
            for($i = 0; $i >= -4; $i--) {
                $dmonth = date('m-Y', strtotime('first day of '.$i.' month'));
                $dmonth = explode("-", $dmonth);
                $month = $dmonth[0];
                $year = $dmonth[1];
                $newMonthY = date('M Y', strtotime($year."-".$month));
                $monthyear = $month.'-'.$year;
                $status = "-";
                $agent_commission = 0;
                $image = "";
                $agent_p = DB::table('agent_payments')->where('user_id',$aid)->whereMonth('date',$month)->whereYear('date',$year);
                if($agent_p->first()) {
                    $agent_commission = number_format($agent_p->sum('amount'))." TZS";
                    if($agent_p->first()->status == "paid"){
                        $amp = \App\AgentMonthlyPayment::where('user_id',$aid)->where('month',$monthyear)->orderBy('id','desc')->first();
                        if($amp) {
                            $image = $amp->reference;
                        }
                        $status = "<span class='badge badge-success'>Paid </span> <a href='#' class='view-reference' img='".$image."'><i class='fa fa-eye'></i></a>";
                    }
                    if($agent_p->first()->status == "not paid"){
                        $status = "<span class='badge badge-danger'>Not paid</span>";
                    }
                }
                
                $output[] = "<tr><td>".$newMonthY."</td><td>".$agent_commission."</td><td>".$status."</td></tr>";                 
            }            
            return response()->json(['payments'=>$output]);
        }
    }
}
