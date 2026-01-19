<?php

namespace App\Http\Controllers;

use App\Country; 
use Illuminate\Http\Request;
use App\Services\TenantService;
use App\Services\TenantDatabaseCreator;

class CountryController extends Controller
{

    protected $username;
    protected $password;

    public function __construct()
    {
        $this->username = env('DB_USERNAME');
        $this->password = env('DB_PASSWORD');
    }

// closure_sales
// currencies
// customers
// customer_debts
// daily_sales
// deletes
// expenses
// measurements
// monthly_sales
// new_stocks
// notifications
// payments
// payments_descs
// payment_options
// products
// product_categories
// product_category_groups
// return_sold_items
// sales 
// shops 
// shop_expenses
// shop_products
// shop_store_suppliers
// stock_adjustments
// stores 
// store_products
// suppliers 
// supplier_deposits
// supplier_histories
// track_products
// transfers 
// user_notifications

    public function tenants_creation($status) {        
        // active , free trial, not paid, end free trial
        $accounts = \App\Company::where('status',$status)->get(); 
        foreach($accounts as $account) {

            $dbName = "lpos_".$company_id;
            $username = env('DB_USERNAME');
            $password = env('DB_PASSWORD');

            $company->update(['dbname'=>$dbName]);

            // create tenant and migrate 
            TenantDatabaseCreator::createTenantDatabase($dbName, $this->username, $this->password);
        }
    }

    public function closure_sales($status) {
        $accounts = \App\Company::where('status',$status)->get(); 
        foreach($accounts as $account) {

            $ses = \DB::connection('mysql')->select('select * from closure_sales where company_id = '.$account->id);

            TenantService::connect($account->dbname);

            foreach($ses as $se) {
                \App\ClosureSale::create(get_object_vars($se));
            }
        }
    }

    public function currencies($status) {
        $accounts = \App\Company::where('status',$status)->get(); 
        foreach($accounts as $account) {

            $ses = \DB::connection('mysql')->select('select * from currencies where company_id = '.$account->id);

            TenantService::connect($account->dbname);

            foreach($ses as $se) {
                \App\Currency::create(get_object_vars($se));
            }
        }
    }

    public function customers() { //first
        $ses = \DB::connection('mysql_2')->select('select * from shop_expenses');
        foreach($ses as $se) {
            $se->company_id = 2;
            $se->user_id = 18;
            \App\ShopExpense::create(get_object_vars($se));
        }
        $ns = \DB::connection('mysql_2')->select('select * from new_stocks');
        foreach($ns as $n) {
            $n->company_id = 2;
            $n->user_id = 18;
            \App\NewStock::create(get_object_vars($n));
        }
        $sales = \DB::connection('mysql_2')->select('select * from sales');
        foreach($sales as $s) {
            $s->company_id = 2;
            $s->user_id = 18;
            if ($s->edited_by) { $s->edited_by = 18; }
            if ($s->ordered_by) { $s->ordered_by = 18; }
            $val = $s->sale_val;
            $val = "0".$val;
            $s->sale_no = "SLN".$s->user_id.$val;
            \App\Sale::create(get_object_vars($s));
        }
        return response()->json(['status'=>'shop expenses, new stock & sales migrated']);
    }

    public function shops() { // sec 
        $shops = \DB::connection('mysql_2')->select('select * from shops');
        foreach($shops as $s) {
            $s->company_id = 2;
            $s->user_id = 18;
            $ns = \App\Shop::create(get_object_vars($s));
            // new stock
            \DB::table('new_stocks')->where('company_id',$s->company_id)->where('shop_id',$s->id)->update(['shop_id'=>$ns->id]);
            // sales
            \DB::table('sales')->where('company_id',$s->company_id)->where('shop_id',$s->id)->update(['shop_id'=>$ns->id]);
            // shop expenses
            \DB::table('shop_expenses')->where('company_id',$s->company_id)->where('shop_id',$s->id)->update(['shop_id'=>$ns->id]);
            // shop products
            $sps = \DB::connection('mysql_2')->select('select * from shop_products');
            $lastRow = \DB::table('shop_products')->orderBy('id','desc')->first();
            $newRow = $lastRow->id+1;
            foreach($sps as $sp) {
                $sp->id = $newRow;
                $sp->shop_id = $ns->id;
                \DB::table('shop_products')->insert(get_object_vars($sp));
                $newRow++;
            }
        }
        return response()->json(['status'=>'shops migrated']);
    }

    public function products() { //third
        $ms = \DB::connection('mysql_2')->select('select * from measurements');
        foreach($ms as $m) {
            $m->company_id = 2;
            $m->user_id = 18;
            \App\Measurement::create(get_object_vars($m));
        }
        $expenses = \DB::connection('mysql_2')->select('select * from expenses');
        foreach($expenses as $e) {
            $e->company_id = 2;
            $e->user_id = 18;
            $ne = \App\Expense::create(get_object_vars($e));
            // shop expenses
            \DB::table('shop_expenses')->where('company_id',$e->company_id)->where('expense_id',$e->id)->update(['expense_id'=>$ne->id]);
        }
        $pcgs = \DB::connection('mysql_2')->select('select * from product_category_groups');
        foreach($pcgs as $pcg) {
            $pcg->company_id = 2;
            $pcg->user_id = 18;
            $group = \App\ProductCategoryGroup::create(get_object_vars($pcg));
            $pcs = \DB::connection('mysql_2')->select('select * from product_categories where product_category_group_id = '.$pcg->id);
            if ($pcs) {
                foreach($pcs as $pc) {
                    $pc->company_id = 2;
                    $pc->user_id = 18;
                    $pc->product_category_group_id = $group->id;
                    $cat = \App\ProductCategory::create(get_object_vars($pc));
                    $ps = \DB::connection('mysql_2')->select('select * from products where product_category_id = '.$pc->id);
                    foreach($ps as $p) {
                        $p->company_id = 2;
                        $p->user_id = 18;
                        $p->product_category_id = $cat->id;
                        $p->measurement_id = 4;
                        $np = \App\Product::create(get_object_vars($p));
                        // new stock..
                        \DB::table('new_stocks')->where('company_id',$p->company_id)->where('product_id',$p->id)->update(['product_id'=>$np->id]);
                        // sales
                        \DB::table('sales')->where('company_id',$p->company_id)->where('product_id',$p->id)->update(['product_id'=>$np->id]);
                        // shop products
                        $shop = \App\Shop::where('company_id',$p->company_id)->first();
                        if ($shop) {
                            // \DB::table('shop_products')->where('shop_id',$shop->id)->where('product_id',$p->id)->update(['product_id'=>$np->id]);
                        }
                    }
                }
            }
        }
        return response()->json(['status'=>'groups, categories, products & measurements migrated']);
    }
























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
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        //
    }
}
