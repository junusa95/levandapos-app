<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("","UserController@getName");

Route::post("login","Apps\AuthenticationController@login");
Route::get("logout","Apps\AuthenticationController@logout");



//shop route no auth
Route::get("shop/register","Apps\ShopController@shop_register");
Route::post("shop/create","Apps\ShopController@create");

// ---registration location routes===============
Route::get('/get/region_data/{country_id}', 'Apps\ShopController@getRegionData');
Route::get('/get/district_data/{region_id}', 'Apps\ShopController@getDistrictData');
Route::get('/get/ward_data/{district_id}', 'Apps\ShopController@getWardData');

Route::get('/get/getAllCountries', 'Apps\ShopController@getAllCountries');
Route::get('/get/getAllRegions', 'Apps\ShopController@getAllRegions');
Route::get('/get/getAllDistricts', 'Apps\ShopController@getAllDistricts');
Route::get('/get/getAllWards', 'Apps\ShopController@getAllWards');

Route::middleware(['auth:sanctum','ApiTenant'])->group(function () {

    Route::get("user/profile","Apps\AuthenticationController@profile");

    //for testing authentication
    Route::get("product/category/groupsTest","Apps\ProductCategoryGroupController@groupsTest");

    //product routes
    Route::get("product/category/groups","Apps\ProductCategoryGroupController@groups");
    Route::post("create/product/category/group","Apps\ProductCategoryGroupController@create");
    Route::post("update/product/category/group","Apps\ProductCategoryGroupController@update");
    Route::get("delete/product/category/group/{group_id}","Apps\ProductCategoryGroupController@delete");
    Route::get("restore/product/category/group/{group_id}","Apps\ProductCategoryGroupController@restore");

    Route::get("product/categories","Apps\ProductCategoryController@categories");
    Route::post("create/product/category","Apps\ProductCategoryController@create");
    Route::post("update/product/category","Apps\ProductCategoryController@update");
    Route::get("delete/product/category/{category_id}","Apps\ProductCategoryController@delete");
    Route::get("restore/product/category/{category_id}","Apps\ProductCategoryController@restore");

    Route::get("products/{shopId}","Apps\ProductController@products");
    Route::post("create/product","Apps\ProductController@create");
    Route::post("update/product","Apps\ProductController@update");
    Route::get("delete/product/{product_id}","Apps\ProductController@delete");
    Route::get("products/measurements","Apps\ProductController@measurements");
    Route::get("product/by/category/{categoryId}/{shopId}","Apps\ProductController@productByCategory");
    Route::post("product/add/quantity","Apps\ProductController@addQuntity");
    Route::get("product/getDeletedProducts","Apps\ProductController@getDeletedProducts");
    Route::get("product/restore/{product_id}","Apps\ProductController@restoreProduct");
    Route::get("product/availability/{shop_id}","Apps\ProductController@ProductAvailabilityt");
    Route::get("product/value/{shop_id}","Apps\ProductController@ProductValue");
    Route::post("product/change/quantity","Apps\ProductController@change_quantity");
    Route::post("product/history","Apps\ProductController@product_history");
    Route::post("product/products/in","Apps\ProductController@productInReport");
    Route::post("product/products/in/and/out/quantity","Apps\ProductController@productInout");



    //sale route
    Route::post("make/sale","Apps\SaleController@makeSale");
    Route::get("sales/{shop_id}/{startDate}/{endDate}","Apps\SaleController@sales");
    Route::get("sales/top/sold/product/{shop_id}/{startDate}/{endDate}","Apps\SaleController@sales_top_sold_product");
    Route::get("sales/and/profit/{shop_id}/{startDate}/{endDate}","Apps\SaleController@sales_and_profit");
    Route::get("sales/profit/view/{shop_id}/{date}","Apps\SaleController@sales_and_profit_view");
    Route::get("sales/stat/{shop_id}","Apps\SaleController@sales_stat");
    Route::get("sales/sold/by/{shop_id}/{date}","Apps\SaleController@sales_sold_by");
    Route::get("sales/by/customer/{shop_id}/{date}","Apps\SaleController@sales_by_customer");
    Route::get("sales/by/number/{shop_id}/{date}","Apps\SaleController@sales_by_number");
    Route::get("sales/top/item/{shop_id}/{date}","Apps\SaleController@sales_top_item");
    Route::get("sales/more/details/{shop_id}/{date}","Apps\SaleController@sales_more_details");
    Route::get("sales/monthly/{shop_id}","Apps\SaleController@monthlySales");
    Route::post("sales/update/sold/product","Apps\SaleController@sales_update");
    Route::get("sales/delete/{sale_id}","Apps\SaleController@sales_delete");
    Route::post("sales/edit","Apps\SaleController@editSale");

    // Route::get("sales/{shop_id}","Apps\SaleController@sales");

    //shop routes with auth
    Route::get("shops/{user_id}","Apps\ShopController@shops");
    Route::middleware(['API.ceo.businessowner'])->post("shop/create_new_shop","Apps\ShopController@create_new_shop");
    Route::middleware(['API.ceo.businessowner'])->post("shop/update_shop","Apps\ShopController@update_shop");
    Route::middleware(['API.ceo.businessowner'])->get("shops/delete_shop/{shop_id}","Apps\ShopController@delete_shop");
    Route::get("shops/details/{shop_id}","Apps\ShopController@shop_details");

    //expenses category routes
    Route::get("expense/all","Apps\ExpenseController@expenses");
    Route::post("expense/store","Apps\ExpenseController@store");
    Route::post("expense/update","Apps\ExpenseController@update");
    Route::post("expense/delete","Apps\ExpenseController@delete_expense");

    // expense shop routes
    Route::get("shop/expense/all/{shop_id}/{from_date}/{to_date}","Apps\ExpenseController@shop_expenses");
    Route::get("shop/expense/on/sales/{shop_id}/{from_date}/{to_date}","Apps\ExpenseController@shop_expenses_on_sales");
    Route::post("shop/expense/store","Apps\ExpenseController@shop_expense_create");
    Route::post("shop/expense/update","Apps\ExpenseController@shop_expense_update");
    Route::post("shop/expense/delete","Apps\ExpenseController@shop_expense_delete");


    //transfer routes
    Route::post("make/transfer","Apps\TransferController@makeTransfer");
    Route::get("getShippers","Apps\TransferController@getShippers");
    Route::get("transferDash/{shop_id}","Apps\TransferController@transferDash");
    Route::get("transfer/callback/{transfer_id}","Apps\TransferController@transfer_callback");

    //customer routes
    Route::get("customers/{shop_id}","Apps\CustomerController@customers");
    Route::post("customer/store","Apps\CustomerController@store");
    Route::post("customer/update","Apps\CustomerController@update");
    Route::get("customer/getDeletedCustomers","Apps\CustomerController@getDeletedCustomers");
    Route::get("customer/{cusromer_id}/{shop_id}","Apps\CustomerController@getCustomer");
    // Route::get("customer/del/{cusromer_id}","Apps\CustomerController@delete_customer");
    Route::get("delete/customer/{customer_id}","Apps\CustomerController@delete_customer");
    Route::get("customer/debt/details/{shop_id}/{date}/{customer_id}/{status}","Apps\CustomerController@getActivityDetails");


    // Route::get("customer/activities/{shopId}/{cusromer_id}","Apps\CustomerController@customerActivities");
    Route::post("customer/pay/amount","Apps\CustomerController@payAmount");
    Route::post("customer/update/pay/amount","Apps\CustomerController@updatePaymentAmount");
    Route::get("customer/delete/pay/amount/{id}","Apps\CustomerController@deletePaymentAmount");
    Route::post("customer/land/amount","Apps\CustomerController@LendMoney");
    Route::get("customer/purchases/{shop_id}/{customer_id}","Apps\CustomerController@purchases");

    //supplier routes
    Route::get("suppliers/{shop_id}/{search?}","Apps\SupplierController@suppliers");
    Route::post("supplier/store","Apps\SupplierController@store");
    Route::post("supplier/update","Apps\SupplierController@update");
    Route::post("supplier/delete","Apps\SupplierController@delete");
    Route::get("supplier/{supplier_id}/{year?}","Apps\SupplierController@supplier");
    Route::get("supplier/product/list/{shop_id}","Apps\SupplierController@products");
    Route::post("supplier/buy/product","Apps\SupplierController@buyProduct");
    Route::post("supplier/pay/debt","Apps\SupplierController@paySupplierDebt");
    Route::get("supplier/get/buying/products/{shop_id}/{supplier_id}/{date}","Apps\SupplierController@getSupplierTransaction");
    Route::post("supplier/update/transaction","Apps\SupplierController@updateTransaction");
    Route::post("supplier/delete/item","Apps\SupplierController@deleteItem");

    //users routes
    Route::get("users/{search?}","Apps\UserController@users");
    Route::post("user/store","Apps\UserController@store");
    Route::post("user/update","Apps\UserController@update");
    Route::post("user/update/status","Apps\UserController@status");
    Route::post("user/delete","Apps\UserController@delete");
    Route::get("user/{user_id}","Apps\UserController@user");
    Route::get("user/profile/get","Apps\UserController@user_profile");
    Route::get("company/profile/get","Apps\UserController@company_profile");
    Route::post("user/profile/update","Apps\UserController@update_user_profile");
    Route::post("user/assign/shop","Apps\UserController@assignToShop");
    Route::post("user/update/assign/shop","Apps\UserController@updateAssignment");

    // settings routes
    Route::prefix('settings/company')->group(function () {
        Route::prefix('{shop_id}')->group(function () {
            Route::patch("/", "Apps\SettingsController@update_shop_specific_settings");
            Route::get("/", "Apps\SettingsController@all_shop_settings");
        });
        Route::patch("/", "Apps\SettingsController@update_general_settings");
        Route::get("/", "Apps\SettingsController@all_company_settings");
    });

Route::get("dashboard_shop_details/{shop_id}","Apps\ShopController@dashboard_shop_details");

});
