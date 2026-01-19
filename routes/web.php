<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
 
 
Auth::routes();

Route::get('/test-scanning', 'CountryController@test');
    Route::post('/submit-data2', 'CountryController@submit_data')->name('submit-data2');

// Route::get('/move-products', 'CountryController@products');
// Route::get('/move-users', 'CountryController@users');
// Route::get('/move-customers', 'CountryController@customers');
// Route::get('/move-shops', 'CountryController@shops');

Route::get('/', 'CompanyController@index');
Route::get('/agent-registration', 'CompanyController@agent_registration');
Route::get('/about-levanda-pos-agent', 'CompanyController@levanda_pos_agent');
Route::get('/switch-lang/{lang}', 'UserController@changeLanguage');
Route::get('/new-account', 'CompanyController@new_account');
Route::get('/company/{check}/{data}', 'CompanyController@check');
Route::post('/config-company', 'CompanyController@store')->name('config-company');
Route::post('/register-agent', 'CompanyController@register_agent')->name('register-agent');
Route::get('/count-installation', 'CompanyController@count_installation');
Route::get('/links', function () {
    return view('website.links');
});
Route::get('/privacy-policy', function () {
    return view('website.privacy-policy');
});
// ---registration location routes===============
Route::get('/get/region_data', 'CompanyController@getRegionData')->name('getRegionData');
Route::get('/get/district_data', 'CompanyController@getDistrictData')->name('getDistrictData');
Route::get('/get/ward_data', 'CompanyController@getWardData')->name('getWardData');

Route::group(['middleware' => ['authenticated', 'tenant']], function () { 
    // general
    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/submit-data', 'HomeController@submit_data')->name('submit-data');
    Route::post('/delete', 'HomeController@delete')->name('delete');
    // dynamic links
    Route::get('/update/{check}/{check2}', 'HomeController@update_data');
    Route::get('/get-data/{check}/{conditions}', 'ReportController@get_data');
    Route::get('/get-data/{check}/{condition1}/{condition2}', 'ReportController@get_data2');
    Route::get('/get-form/{check}/{conditions}', 'ReportController@get_form');
    Route::get('/user-profile', 'UserController@user_profile');
    Route::get('/company-profile', 'CompanyController@company_profile');
    Route::get('/users', 'UserController@users2');
    Route::get('/{check}/users/{user}', 'UserController@user'); // has been changed to /users/{user}, but still used for user-roles
    Route::get('/users/{user}', 'UserController@user2');
    Route::get('/notification/{check}/{conditions}', 'NotificationController@check_get_data');
    Route::get('/notifications', 'NotificationController@notifications');
    Route::get('/settings/{check}/{conditions}', 'SettingController@check_get_data');

    // shop + store
    Route::get('/shops', 'ShopController@shops');
    Route::get('/shops/{sid}', 'ShopController@shop');
    Route::get('/stores', 'StoreController@stores');
    Route::get('/stores/{sid}', 'StoreController@instore');
    
    // supplier
    Route::get('/suppliers/{check}/{conditions}', 'SupplierController@check_get_data');
    
    // pdf
    Route::get('/pdf/{check}/{conditions}', 'HomeController@pdf');

    // general urls for products, stock, transfers 
    Route::get('/stock', 'ProductController@stock');
    Route::get('/report/{check}/{check2}/{check3}', 'ReportController@reports2');
    Route::get('/{check}/report/{check2}', 'ReportController@reports3');
    Route::get('/products', 'ProductController@products');

    Route::get('/which-store', 'StoreController@get_user_store');
    Route::get('/which-shop', 'CashierController@get_user_shop');
    Route::get('/which-shop-s', 'CashierController@get_user_shop_s');
    Route::get('/shopstore/{from}/{fromid}/{dest}/{shstval}', 'TransferController@shosto_products');
    Route::get('/shopstore/{from}/{fromid}/{pid}', 'ProductController@shosto_quantity');
    Route::get('/pending-transfer/{from}/{sid}', 'TransferController@pending_transfer');
    Route::post('/submit-transfer', 'TransferController@submit_transfer')->name('submit-transfer');
    Route::get('/remove-transfer-row/{id}', 'TransferController@remove_transfer_row');
    Route::get('/clear-transfer-cart/{from}/{sid}', 'TransferController@clear_transfer_cart');
    Route::get('/submit-transfer-cart/{from}/{sid}/{tno}', 'TransferController@submit_transfer_cart');
    Route::get('/get-transfers/{from}/{status}/{date}/{sid}', 'TransferController@get_transfers');
    Route::get('/transfer-report/{time}/{from}/{sid}', 'TransferController@transfer_report');
    Route::get('/transfer-items/{tno}/{storeshop}/{sid}', 'TransferController@transfer_items');
    Route::get('/receive-items/{tno}', 'ProductController@receive_items');
    Route::get('/delete-transfer/{tno}', 'TransferController@delete_transfer');
    Route::get('/edit-transfer/{tno}', 'TransferController@edit_transfer');
    Route::get('/add-stock/{from}/{from_id}/{pid}/{supplier_id}/{whereto}', 'StoreController@add_stock');
    Route::get('/remove-row/{check}/{id}', 'StoreController@remove_row');
    Route::get('/update-quantity/{status}/{id}/{qty}', 'StoreController@update_quantity');
    Route::get('/new-stock/{check}/{from}/{sid}', 'StoreController@get_new_stock');
    Route::post('/submit-returned-items', 'ShopController@submit_returned_items')->name('submit-returned-items');

    Route::post('/add-customer', 'CustomerController@store')->name('add-customer');
    Route::post('/edit-customer', 'CustomerController@update')->name('edit-customer');
    Route::get('/{check}/customer/{id}', 'CustomerController@customer');

    // sales   
    Route::get('/search-product/{stoshop}/{check}/{shostoid}/{pname}', 'ProductController@search_product');
    Route::get('/search-product-2/{stoshop}/{shostoid}', 'ProductController@search_product_2');
    Route::get('/add-sale/{shop_id}/{pid}/{customer_id}', 'ShopController@add_sale');
    Route::get('/add-returned-item/{shop_id}/{pid}', 'ShopController@add_returned_item');
    Route::get('/return-sold-items/{status}/{shop_id}', 'ShopController@return_sold_item');
    Route::get('/pending-sale/shop/{shop_id}', 'ShopController@pending_sale');
    Route::get('/remove-sale-row/{check}/{shop_id}/{id}', 'ShopController@remove_sale_row');
    Route::get('/update-sale-quantity/{check}/{shop_id}/{id}/{qty}', 'ShopController@update_sale_quantity');
    Route::get('/update-sale-price/{check}/{shop_id}/{id}/{price}', 'ShopController@update_sale_price');
    Route::get('/clear-sale-cart/{shop_id}', 'ShopController@clear_sale_cart'); 
    Route::get('/update-customer-onsale/{shop_id}/{customer_id}', 'ShopController@update_cutomer_onsale');
    Route::get('/submit-sale-cart/{check}/{shop_id}/{amount}', 'ShopController@submit_sale_cart');
    Route::get('/submit-ava-cash/{ecash}/{acash}/{shop_id}', 'ShopController@submit_ava_cart');
    Route::get('/sales-by-date/{from}/{date}/{month}/{year}/{shop_id}', 'ShopController@sales_by_date');
    Route::get('/sales-by-date-with-customer/{from}/{date}/{month}/{year}/{shop_id}', 'ShopController@sales_by_date_with_customer');
    Route::get('/sales-by-date-with-sellers/{from}/{date}/{month}/{year}/{shop_id}', 'ShopController@sales_by_date_with_sellers');
    Route::get('/sales-by-date-with-sale-numbers/{from}/{date}/{month}/{year}/{shop_id}', 'ShopController@sales_by_date_with_sale_numbers');
    Route::get('/sales-by-date-with-payment-options/{from}/{date}/{month}/{year}/{shop_id}', 'ShopController@sales_by_date_with_payment_options');
    Route::get('/report-by-date-range/{check}/{fromdate}/{todate}/{shop_id}', 'ReportController@report_by_date_range');
    Route::get('/edit-sale-form/{id}', 'ShopController@edit_sale_form');
    Route::get('/submit-edited-sale/{id}/{qty}/{price}', 'ShopController@submit_edited_sale');
    Route::get('/sales-summary/{check}/{shop_id}', 'ShopController@sales_summary');
    Route::get('/expenses-summary/shop/{shop_id}', 'ShopController@expenses_summary');
    Route::post('/add-new-sale', 'ShopController@addNewSale');
    Route::post('/add-new-order', 'ShopController@addNewOrder');
    // Route::get('/delete-submitted-sale/{shop_id}/{id}', 'ShopController@delete_submitted_sale');

    // expenses
    Route::post('/expense-cost', 'ShopController@expense_cost')->name('expense-cost');
    Route::post('/edit-expense-cost', 'ShopController@edit_expense_cost')->name('edit-expense-cost');
    Route::get('/expenses-by-date/{from}/{date}/{month}/{year}/{shop_id}', 'ShopController@expenses_by_date');
    Route::get('/expenses-in-shop/{from}/{date}/{month}/{year}/{shop_id}', 'ShopController@expenses_in_shop');
    Route::get('/expenses-by-id/{id}', 'ShopController@expenses_by_id');
    Route::get('/delete-expense/{id}', 'ShopController@delete_expense');

    // cashier 
    Route::get('/cashier', 'CashierController@index');
    Route::get('/cashier/{sid}/{check}', 'CashierController@check');

    // sale person
    Route::get('/sales-person', 'CashierController@sales_person');
    Route::get('/sales-person/{sid}', 'RoleController@sales_person');
    Route::get('/sales-person/{sid}/sales', 'ShopController@sales');
    Route::get('/{orders}/shop/{shop_id}', 'ShopController@orders');
    Route::get('/order-items/{check}/{ono}', 'ShopController@order_items');

    // admin
    Route::get('/admin', 'RoleController@admin');
    Route::get('/admin/{check}', 'AdminController@get_data');
    
    // agent
    Route::get('/agent', 'RoleController@agent');
    Route::get('/agent/{check}', 'AgentController@get_data');
    Route::get('/agent/{check}/{check2}', 'AgentController@get_data2');

    // ceo
    Route::get('/save-as-copy/product/{id}', 'ProductController@save_as_copy');
    Route::get('/delete-product/{id}', 'ProductController@delete_product');
    Route::get('/new-stock/{check}/{id}', 'ProductController@stock_check');

    // ceo, business owner 
    Route::get('/{check}/stock/{check2}', 'StoreController@stock_links');
    Route::get('/stock/{check3}/{check}/{check2}', 'StoreController@adjust_stock');
    Route::get('/report/{check}', 'ReportController@reports1'); //Cashier is using this for closure note
    Route::get('/report/{check}/{check2}', 'ReportController@reports'); //Cashier is using this for closure note
});

Route::group(['middleware' => ['admin']], function () {
    Route::get('/admin/{check}/{check2}', 'AdminController@get_data2');
});

Route::group(['middleware' => ['admin.businessowner', 'tenant']], function () {
    Route::get('/business-owner', 'RoleController@business_owner');
});

Route::group(['middleware' => ['admin.ceo.businessowner', 'tenant']], function () { 
    // only admin, ceo & B-Owner
    
    Route::get('/billing-and-payments', 'CompanyController@billing_and_payments');
    Route::get('/account-settings', 'CompanyController@settings');
    
    Route::post('/add-user', 'UserController@create')->name('add-user');
    Route::post('/edit-user', 'UserController@update')->name('edit-user');
    Route::get('/{check}/users', 'UserController@users'); // this is changed to /users

    Route::get('/{check}/customers', 'CustomerController@customers');

    Route::post('/add-new-stock', 'StoreController@add_new_stock')->name('add-new-stock');

    Route::get('/ceo', 'RoleController@ceo');
    Route::post('/add-cashier', 'UserController@add_cashier')->name('add-cashier');
    Route::post('/add-sperson', 'UserController@add_sperson')->name('add-sperson');
    Route::post('/add-smaster', 'UserController@add_smaster')->name('add-smaster');

    Route::get('/{check}/measurements', 'MeasurementController@measurements');
    Route::post('/add-measurement', 'MeasurementController@store')->name('add-measurement');
    Route::post('/edit-measurement', 'MeasurementController@update')->name('edit-measurement');

    Route::get('/{check}/product-categories', 'ProductCategoryController@categories');
    Route::post('/add-cat-group', 'ProductCategoryGroupController@store')->name('add-cat-group');
    Route::post('/edit-cat-group', 'ProductCategoryGroupController@update')->name('edit-cat-group');
    Route::post('/add-p-category', 'ProductCategoryController@store')->name('add-p-category');
    Route::post('/edit-p-category', 'ProductCategoryController@update')->name('edit-p-category');
 
    Route::post('/add-store', 'StoreController@store')->name('add-store');
    Route::post('/edit-store', 'StoreController@update')->name('edit-store');
    Route::post('/untouch-store-master', 'StoreController@untouch_store_master')->name('untouch-store-master');

    Route::post('/add-shop', 'ShopController@store')->name('add-shop');
    Route::post('/edit-shop', 'ShopController@update')->name('edit-shop');
    Route::post('/untouch-cashier', 'ShopController@untouch_cashier')->name('untouch-cashier');
    Route::post('/untouch-sperson', 'ShopController@untouch_sperson')->name('untouch-sperson');
    Route::post('/untouch-smaster', 'ShopController@untouch_smaster')->name('untouch-smaster');

    Route::get('/{check}/new-product-form', 'ProductController@new_product_form');
    // Route::get('/{check}/products', 'ProductController@products');
    Route::get('/{check}/products/{product_id}', 'ProductController@edit_product');
    Route::post('/update-adjust-stock', 'StoreController@update_a_s')->name('update-adjust-stock');
    Route::post('/update-stock-taking', 'StoreController@update_s_t')->name('update-stock-taking');
    Route::get('/categories-by-group/{group_id}', 'ProductController@categories_by_id');
    Route::post('/new-product', 'ProductController@store')->name('new-product');
    Route::post('/update-product', 'ProductController@update')->name('update-product');
    Route::post('/update-quantity', 'ProductController@update_quantity')->name('update-quantity');
});

Route::group(['middleware' => ['admin.ceo.smaster', 'tenant']], function () {
    // admin, ceo, store master
    Route::get('/store-master', 'StoreController@index');
    Route::get('/store-master/{sid}', 'RoleController@store_master');
    Route::get('/store-master/{sid}/{check}', 'StoreController@check');
    Route::get('/{who}/{sid}/transfer-form', 'TransferController@transfer_form');
    Route::get('/{who}/{sid}/transfers', 'TransferController@transfers');
});

Route::group(['middleware' => ['admin.ceo.cashier', 'tenant']], function () {
    // admin, ceo, store master
    Route::get('/cashier/{sid}', 'RoleController@cashier');
    Route::get('/{who}/{sid}/transfer-form', 'TransferController@transfer_form');
    Route::get('/{who}/{sid}/transfers', 'TransferController@transfers');
    Route::get('/cashier/{sid}/sales', 'ShopController@sales');
    Route::get('/cashier/{sid}/sales-report', 'ShopController@sales_report');
    Route::get('/cashier/customers/{sid}', 'CashierController@customers');

    Route::get('/{check}/expenses', 'ExpenseController@expenses');
    Route::post('/add-expense', 'ExpenseController@store')->name('add-expense');
    Route::post('/edit-expense', 'ExpenseController@update')->name('edit-expense');
});

