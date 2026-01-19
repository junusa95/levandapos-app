<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\User;
use App\Store;
use App\Cashier;
use App\Customer;
use App\Shop;
use App\Sale;
use App\Product;
use App\NewStock;
use App\Transfer;
use App\ProductCategory;
use App\Expense;
use App\ShopExpense;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CashierController extends Controller
{
    public function index() {
        if (Session::get('role') == 'Cashier') {
            $data['shops'] = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('who','cashier')->get();
            
            return view('cashier.index',compact('data'));
        } else {
            $toprole = Auth::user()->roles()->orderBy('id','asc')->first();
            if (!$toprole) { //check if has assigned to any role
                return redirect('/home');
            } else {
                if ($toprole->name == "Cashier") { // chack if has cashier role
                    Session::put('role','Cashier');
                    return redirect('/cashier');
                } else {
                    return redirect()->back()->with('error','Sorry! It seems like you dont have a cashier role in this account.');
                }
            }            
        }            
    }
    
    public function index_bkp() {
        if (Session::get('role') == 'Cashier') {
            return redirect('/cashier/'.Session::get('shoid'));
        }
        $data['shops'] = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('who','cashier')->get();
        
        if (count($data['shops']) == 1) {
            $shop = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('who','cashier')->first();
            return redirect('/cashier/'.$shop->shop_id);
        }
        return view('cashier.choose-shop',compact('data'));             
    }

    public function sales_person() {
        if (Session::get('role') == 'Sales Person') {
            $data['shops'] = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('who','sale person')->get();
            
            return view('sales-person.index',compact('data'));
        } else {
            $toprole = Auth::user()->roles()->orderBy('id','asc')->first();
            if (!$toprole) { //check if has assigned to any role
                return redirect('/home');
            } else {
                if ($toprole->name == "Sales Person") { // chack if has sales person role
                    Session::put('role','Sales Person');
                    return redirect('/sales-person');
                } else {
                    return redirect()->back()->with('error','Sorry! It seems like you dont have a sales person role in this account.');
                }
            }            
        }   
    }

    public function get_user_shop() { 
        $shops = '';
        $count = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('who','cashier')->get()->count('id');
        if ($count > 1) {
            $shops = DB::connection('tenant')->table('shops')->join('user_shops','user_shops.shop_id','shops.id')->where('user_shops.user_id',Auth::user()->id)->where('user_shops.who','cashier')->get();
        } elseif ($count == 1) {
            $shops = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('who','cashier')->first();
        }
        return response()->json(['total'=>$count,'shops'=>$shops]);
    }

    public function get_user_shop_s() { 
        $shops = '';
        $count = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('who','sale person')->get()->count('id');
        if ($count > 1) {
            $shops = DB::connection('tenant')->table('shops')->join('user_shops','user_shops.shop_id','shops.id')->where('user_shops.user_id',Auth::user()->id)->where('user_shops.who','sale person')->get();
        } elseif ($count == 1) {
            $shops = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('who','sale person')->first();
        }
        return response()->json(['total'=>$count,'shops'=>$shops]);
    }

    public function check($sid,$check) {
        if ($check == "stock") {
            $shop = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('shop_id',$sid)->where('who','cashier')->first();
            if ($shop) {
                $data['otherroles'] = Auth::user()->roles()->where('name','!=','Cashier')->get();
                $data['shop'] = Shop::find($sid);
                $data['products'] = $data['shop']->products()->orderBy('products.name')->get();
                $data['pendingstock'] = NewStock::where('shop_id',$sid)->where('status','sent')->get();
                if(Auth::user()->isCEOorAdmin()) {
                    $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
                    $data['stores'] = Store::where('company_id',Auth::user()->company_id)->get();
                }
                return view('cashier.stock',compact('data'));
            } else {
                return redirect()->back()->with('error','Sorry! It seems like you dont have permission in this shop.');
            }
        }
        if ($check == "products") { 
            $shop = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('shop_id',$sid)->where('who','cashier')->first();
            if ($shop) {
                $data['otherroles'] = Auth::user()->roles()->where('name','!=','Cashier')->get();
                $data['shop'] = Shop::find($sid);
                $data['products'] = $data['shop']->products()->orderBy('products.name')->get();
                return view('cashier.products',compact('data'));
            } else {
                return redirect()->back()->with('error','Sorry! It seems like you dont have permission in this shop.');
            }
        }
        if ($check == "products-by-cat") {
            // sid = shop_id + cat_id
            $vals = explode("-",$sid);
            $shop_id = $vals[0];
            $cat_id = $vals[1];
            if($cat_id == 0) { //recently products
                $products = Sale::query()->select([
                    DB::raw('products.id as pid, products.retail_price as pprice, products.name as pname, products.image as pimage')
                ])
                ->join('products','products.id','sales.product_id')
                ->where('sales.shop_id',$sid)
                ->where('sales.status','sold')
                ->groupBy('sales.product_id')->orderBy('sales.id','desc')->limit(12)
                ->get();
            } else {
                $products = Product::query()->select([
                    DB::raw('products.id as pid, products.retail_price as pprice, products.name as pname, products.image as pimage')
                ])
                ->join('shop_products','shop_products.product_id','products.id')
                ->where('products.product_category_id',$cat_id)
                ->where('shop_products.shop_id',$shop_id)
                ->where('products.status','published')
                ->get();                
            }
            return response()->json(['products'=>$products]);
        }
        if ($check == "expenses") {
            $shop = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('shop_id',$sid)->where('who','cashier')->first();
            if ($shop) {
                $data['otherroles'] = Auth::user()->roles()->where('name','!=','Cashier')->get();
                $data['shop'] = Shop::find($sid);
                $data['expenses'] = Expense::where('company_id',Auth::user()->company_id)->get();
                $data['shopExpenses'] = ShopExpense::whereDate('created_at', Carbon::today())->where('shop_id',$sid)->where('company_id',Auth::user()->company_id)->get();
                return view('cashier.expenses',compact('data'));
            } else {
                return redirect()->back()->with('error','Sorry! It seems like you dont have permission in this shop.');
            }        
        }
    }

    public function customers($sid) {
        $shop = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('shop_id',$sid)->where('who','cashier')->first();
        if ($shop) {
            $data['otherroles'] = Auth::user()->roles()->where('name','!=','Cashier')->get();
            $data['shop'] = Shop::find($sid);
            $data['customers'] = Customer::where('status','active')->where('company_id',Auth::user()->company_id)->orderBy('name')->get();
            return view('customers',compact('data'));
        } else {
            return redirect()->back()->with('error','Sorry! It seems like you dont have permission in this shop.');
        }        
    }


}
