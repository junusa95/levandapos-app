
@extends('layouts.app')
@section('css')
<style type="text/css">
    .s-loader {position: absolute;background-color: #f4f7f6;width: 90%;height: 25px;margin-top: -3px; opacity: 0.8;}
    .list-group-flush {position: relative;}
    .s-loader-2 {position: absolute;background-color: #f4f7f6;width: 100%;height: 100%;margin-top: -3px; opacity: 0.8;z-index: 9;}
    .s-loader-3 {position: absolute;background-color: #f4f7f6;width: 100%;height: 100%;margin-top: -3px; opacity: 0.8;z-index: 9;}
    @media screen and (max-width: 480px) {
        .single-s .header {padding-right: 0px;}
        .single-s .header .header-dropdown {position: relative !important;text-align: right;}
    }

    .ticket {
    font-size: 12px;
    font-family: 'Times New Roman';
}

.ticket td,
.ticket th,
.ticket tr,
.ticket table {
    border-top: 1px solid black;
    border-collapse: collapse;
}

.ticket td.description,
.ticket th.description {
    width: 75px;
    max-width: 75px;
}

.ticket td.quantity,
.ticket th.quantity {
    width: 40px;
    max-width: 40px;
    word-break: break-all;
}

.ticket td.price,
.ticket th.price {
    width: 40px;
    max-width: 40px;
    word-break: break-all;
}

.ticket .centered {
    text-align: center;
    align-content: center;
}

.ticket {
    width: 155px;
    max-width: 155px;
}

.ticket img {
    max-width: inherit;
    width: inherit;
}


.switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 26px;
}

/* Hide default HTML checkbox */
.switch input {display:none;}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;margin-right: -5px;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 20px;
  width: 22px;
  left: 4px;margin-right: 3px;
  bottom: 3px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input.primary:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

.update-msl {display: none;}


@media print {
    .ticket .hidden-print,
    .ticket .hidden-print * {
        display: none !important;
    }
}

body.printingContent > *{
    display: none;  /* hide everything in body when in print mode*/
}

body.printingContent .printContainer {
    display: block !important; /* Override the rule above to only show the printables*/
    position: fixed;
    z-index: 9999999999999;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
} 
</style>

@endsection
@section('content')

<?php
if(Cookie::get("language") == 'en') {
    $_GET['add-fields-to-product'] = "Add fields to product";
    $_GET['allow-recording-sales-for-previous-dates'] = "Allow recording sales of previous dates";
    $_GET['allow-recording-sales-for-previous-dates-desc'] = "Cashier will be able to record sales by Date, This will help you when you forgot to record sales of a certain date.";
    $_GET['allow-sales-to-empty-stock'] = "Allow sales to Empty stock";
    $_GET['allow-sales-to-empty-stock-desc'] = "You will be able to sale product event if it reaches zero quantity. I will allow negative stock";
    $_GET['can-transfer-products'] = "Can transfer products";
    $_GET['cashier-change-selling-price'] = "Cashier to change selling price";
    $_GET['cashier-change-selling-price-desc'] = "Allow cashier to change selling price of product when he/she is selling products";
    $_GET['product-categories-availability'] = "Product Categories Availability";
    $_GET['product-categories-availability-desc'] = "Check YES if your products are categorized in groups.. check NO if you just want to create all your products without groups.";
    $_GET['can-transfer-products-desc'] = "Ability to transfer products from shop to shop, store to store, store to shop and vice versa. This is applicable to accounts that register more than one shop or store";
    $_GET['cashier-store-master-approval'] = "Cashier/Store Master to approve new Stock added";
    $_GET['cashier-store-master-approval-desc'] = "When you add Quantity of products (new stock). They will require Cashier/Store Master approval in order to increase the existing quantity.";
    $_GET['receipt-and-orders'] = "Receipt and Orders";
    $_GET['receipt-and-orders-desc'] = "Allow printing receipts on sales. Allow saving orders to be sold later";
    $_GET['settings-applies-to-all'] = "Settings that applies to all shops/stores";
    $_GET['settings-applies-to-specific-shop'] = "Settings that applies to specific shop";
} else {
    $_GET['add-fields-to-product'] = "Ongeza machaguo kwenye bidhaa";
    $_GET['allow-recording-sales-for-previous-dates'] = "Ruhusu kurekodi mauzo ya tarehe za nyuma";
    $_GET['allow-recording-sales-for-previous-dates-desc'] = "Keshia atakua na uwezo wa kurekodi mauzo kwa tarehe, Hii itakusaidia pindi utakaposahau kurekodi mauzo ya tarehe fulani.";
    $_GET['allow-sales-to-empty-stock'] = "Ruhusu kuuza hata kama bidhaa imeisha";
    $_GET['allow-sales-to-empty-stock-desc'] = "Hautaziwiliwa kuuza bidhaa hata kama stock imeisha.. stock itasoma negative";
    $_GET['can-transfer-products'] = "Inaweza kuhamisha bidhaa";
    $_GET['cashier-change-selling-price'] = "Keshia kubadilisha bei ya kuuzia";
    $_GET['cashier-change-selling-price-desc'] = "Ruhusu keshia aweze kubadilisha bei ya kuuzia pindi anapouza bidhaa";
    $_GET['product-categories-availability'] = "Uwepo wa Makundi ya Bidhaa";
    $_GET['product-categories-availability-desc'] = "Weka NDIO kama bidhaa zako zina makundi.. weka HAPANA kama unataka bidhaa zako zote zionekane bila makundi.";
    $_GET['can-transfer-products-desc'] = "Uwezo wa kuhamisha bidhaa kutoka duka A kwenda duka B, stoo A kwenda stoo B, stoo kwenda dukani n.k. Hii inatumika kwa akaunti ambazo zimesajili duka zaidi ya moja au stoo";
    $_GET['cashier-store-master-approval'] = "Keshia/Stoo Masta kuidhinisha bidhaa zinazoongezwa (new stock)";
    $_GET['cashier-store-master-approval-desc'] = "Stock mpya ikiingia dukani/stoo, idadi ya bidhaa haitaongezeka paka keshia/stoo master aidhinishe.";
    $_GET['receipt-and-orders'] = "Risiti na Oda";
    $_GET['receipt-and-orders-desc'] = "Ruhusu kuprint risiti unapofanya mauzo. Ruhusu kusevu oda ambayo utaiuza baadae";
    $_GET['settings-applies-to-all'] = "Settings zinazotumika kwenye maduka/stoo zote";
    $_GET['settings-applies-to-specific-shop'] = "Settings zinazotumika kwenye duka husika";
}
?>

<div id="wrapper">
    <nav class="navbar navbar-fixed-top">
        <div class="container-fluid">
            @include('layouts.topbar')
        </div>
    </nav>

    <div id="left-sidebar" class="sidebar">
        <div class="sidebar-scroll">
            @include('layouts.leftside')
        </div>
    </div>

    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    @include('layouts.topbottombar')
                </div>
            </div>
            
            <div class="row clearfix">
                
                <div class="col-12">
                    <div class="card single-s">
                        <div class="header" style="border-bottom: 1px solid #ddd;">
                            <h2><?php echo $_GET['settings-applies-to-all']; ?></h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="border pb-2">
                                        <div class="p-2" style="background-color: #f4f7f6;">
                                            <b><?php echo $_GET['cashier-store-master-approval']; ?></b>
                                        </div>
                                        <div class="px-2 py-3">
                                            <?php echo $_GET['cashier-store-master-approval-desc']; ?> 
                                        </div>
                                        <div>
                                            <label class="mr-2 ml-4"> <input type="radio" name="cashier-approval" value="yes" <?php if(Auth::user()->company->cashier_stock_approval != "no") { echo "checked"; }  ?>> <?php echo $_GET['yes']; ?> </label>
                                            <label> <input type="radio" name="cashier-approval" value="no" <?php if(Auth::user()->company->cashier_stock_approval == "no") { echo "checked"; }  ?>> <?php echo $_GET['no']; ?> </label>
                                        </div>
                                    </div>
                                    
                                    <div class="border pb-2 mt-4">
                                        <div class="p-2" style="background-color: #f4f7f6;">
                                            <b><?php echo $_GET['can-transfer-products']; ?></b>
                                        </div>
                                        <div class="px-2 py-3">
                                            <?php echo $_GET['can-transfer-products-desc']; ?>  
                                        </div>
                                        <div>
                                            <label class="mr-2 ml-4"> <input type="radio" name="transfer-products" value="yes" <?php if(Auth::user()->company->can_transfer_items != "no") { echo "checked"; }  ?>> <?php echo $_GET['yes']; ?> </label>
                                            <label> <input type="radio" name="transfer-products" value="no" <?php if(Auth::user()->company->can_transfer_items == "no") { echo "checked"; }  ?>> <?php echo $_GET['no']; ?> </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="border pb-2">
                                        <div class="p-2" style="background-color: #f4f7f6;">
                                            <b><?php echo $_GET['product-categories-availability']; ?></b>
                                        </div>
                                        <div class="px-2 py-3">
                                            <?php echo $_GET['product-categories-availability-desc']; ?>  
                                        </div>
                                        <div>
                                            <label class="mr-2 ml-4"> <input type="radio" name="product-categories" value="yes" <?php if(Auth::user()->company->has_product_categories != "no") { echo "checked"; }  ?>> <?php echo $_GET['yes']; ?> </label>
                                            <label> <input type="radio" name="product-categories" value="no" <?php if(Auth::user()->company->has_product_categories == "no") { echo "checked"; }  ?>> <?php echo $_GET['no']; ?> </label>
                                        </div>
                                    </div>
                                    
                                    <div class="border pb-2 mt-4">
                                        <div class="p-2" style="background-color: #f4f7f6;">
                                            <b><?php echo $_GET['add-fields-to-product']; ?></b>
                                        </div>
                                        <div class="px-2 py-3">
                                            Switch ON/OFF  
                                        </div>
                                        <div>
                                            <ul class="list-group list-group-flush">
                                                <div class="s-loader-2"></div>
                                                <li class="list-group-item" style="border: none;">
                                                    Expire Date
                                                    <label class="switch " style="float: right;">
                                                        <input type="checkbox" class="primary" name="expire_date">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </li>
                                                <!-- dont add border none to next li  -->
                                                <li class="list-group-item">
                                                    Minimum stock value
                                                    <label class="switch " style="float: right;">
                                                        <input type="checkbox" class="primary" name="stock_level">
                                                        <span class="slider round"></span>
                                                    </label>
                                                    <div class="mt-3 show-stock-level" style="display: none;">
                                                        <div align="right">
                                                            <div class="pr-2"><small>Default level</small></div>
                                                            <div>
                                                                <input type="number" class="form-control form-control-sm" name="stock_value" style="width: 70px;">
                                                                <button class="btn btn-sm btn-info update-msl mt-1">Change <i class="fa fa-check"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    Import Products
                                                    <label class="switch " style="float: right;">
                                                        <input type="checkbox" class="primary" name="import_products">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="col-12">
                    <div class="card single-s">
                        <div class="header" style="border-bottom: 1px solid #ddd;">
                            <h2><?php echo $_GET['settings-applies-to-specific-shop']; ?></h2>
                            <ul class="header-dropdown">
                                <li>
                                    <select name="change-shop" class="form-control change-shop">
                                        @foreach(Auth::user()->company->shops as $s)
                                        <option value="{{$s->id}}">{{$s->name}}</option>
                                        @endforeach
                                    </select>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="border pb-2">
                                        <div class="p-2" style="background-color: #f4f7f6;">
                                            <b><?php echo $_GET['cashier-change-selling-price']; ?></b>
                                        </div>
                                        <div class="px-2 py-3">
                                            <?php echo $_GET['cashier-change-selling-price-desc']; ?>  
                                        </div>
                                        <div>
                                            <div class="s-loader"></div>
                                            <label class="mr-2 ml-4"> <input type="radio" name="change-s-price" id="yes-change-sp" value="yes"> <?php echo $_GET['okay']; ?> </label>
                                            <label> <input type="radio" name="change-s-price" id="no-change-sp" value="no"> <?php echo $_GET['no']; ?> </label>
                                        </div>
                                    </div>
                                    
                                    <div class="border pb-2 mt-4">
                                        <div class="p-2" style="background-color: #f4f7f6;">
                                            <b><?php echo $_GET['allow-recording-sales-for-previous-dates']; ?></b>
                                        </div>
                                        <div class="px-2 py-3">
                                            <?php echo $_GET['allow-recording-sales-for-previous-dates-desc']; ?>  
                                        </div>
                                        <div class="list-group-flush" style="padding-bottom: 10px;padding-right: 20px;">
                                            <div class="s-loader-3"></div>
                                            <label class="switch" style="float: right;">
                                                <input type="checkbox" class="primary" name="change-sale-pd-2">
                                                <span class="slider round"></span>
                                            </label>
                                            <br>
                                            <div class="show-days-back" style="display: none;">
                                                <div align="right" style="padding-top: 13px;">
                                                    <div><small><?php echo $_GET['days-back']; ?></small></div>
                                                    <div>
                                                        <select name="days_back" class="form-control" style="width: 70px;">
                                                            <option value="30">30</option>
                                                            <option value="7">7</option>
                                                            <option value="3">3</option>
                                                            <option value="1">1</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="border pb-2">
                                        <div class="p-2" style="background-color: #f4f7f6;">
                                            <b><?php echo $_GET['receipt-and-orders']; ?></b>
                                        </div>
                                        <div class="px-2 py-3">
                                            <?php echo $_GET['receipt-and-orders-desc']; ?>  
                                        </div>
                                        <div>
                                            <div class="s-loader"></div>
                                            <label class="mr-2 ml-4"> <input type="radio" name="receipt-orders" id="yes-receipt-orders" value="yes"> <?php echo $_GET['okay']; ?> </label>
                                            <label> <input type="radio" name="receipt-orders" id="no-receipt-orders" value="no"> <?php echo $_GET['no']; ?> </label>
                                        </div>
                                    </div>
                                    
                                    <div class="border pb-2 mt-4">
                                        <div class="p-2" style="background-color: #f4f7f6;">
                                            <b><?php echo $_GET['allow-sales-to-empty-stock']; ?></b>
                                        </div>
                                        <div class="px-2 py-3">
                                            <?php echo $_GET['allow-sales-to-empty-stock-desc']; ?>  
                                        </div>
                                        <div class="list-group-flush" style="padding-bottom: 30px;padding-right: 20px;">
                                            <div class="s-loader-3"></div>
                                            <label class="switch" style="float: right;">
                                                <input type="checkbox" class="primary" name="sale_empty_stock">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 pb-5" style="display: none;"> <!-- this is for testing  -->
                    <div class="" id="printable_div_id" style="font-size: 2rem;font-weight: bolder;color: #000 !important; font-family: 'Times New Roman';">
                        
                        <p class="centered" style="font-size: 2rem;color: #000;" align="center">
                            <!-- <img src="https://pos.levanda.co.tz/images/pos_logo3.png" width="100" alt="Logo"> <br> -->
                            <span style="font-size: 3rem;">RJ SHOP MSIMBAZI</span>
                            <br>Kariakoo Msimbazi
                            <br>+255 713 123 321</p>
                        <table>
                            <thead style="color: #000;font-size: 2rem;">
                                <tr><th>SALE #</th><th>:</th><th class="saleno"></th></tr>
                                <tr><th>CASHIER</th><th>:</th><th>{{Auth::user()->name}}</th></tr>
                                <tr><th>CUSTOMER</th><th>:</th><th>{{Auth::user()->name}}</th></tr>
                            </thead>
                        </table>
                        <table style="width: 100%;font-size: 2rem;margin-top: 30px;">
                            <thead>
                                <tr style="border-bottom: 1px solid #000;">
                                    <th>ITEMS</th>
                                </tr>
                            </thead>
                            <thead style="color: #000;border-bottom: 1px solid #000;">
                                <tr class="sor-54505"><td><div><div class="col-12 r-name">A99 BOXER</div><div class="col-12" align="right"> <span>2</span> <span>x</span> <span>8000</span> <span>=</span> <span><b class="totaloP-54505">16,000</b></span></div></div></td></tr>
                                
                                <tr class="sor-54505"><td><div><div class="col-12 r-name">A99 BOXER</div><div class="col-12" align="right"> <span>2</span> <span>x</span> <span>8000</span> <span>=</span> <span><b class="totaloP-54505">16,000</b></span></div></div></td></tr>
                                <tr class="sor-54505"><td><div><div class="col-12 r-name">A99 BOXER</div><div class="col-12" align="right"> <span>2</span> <span>x</span> <span>8000</span> <span>=</span> <span><b class="totaloP-54505">16,000</b></span></div></div></td></tr>
                                <tr class="sor-54505"><td><div><div class="col-12 r-name">A99 BOXER</div><div class="col-12" align="right"> <span>2</span> <span>x</span> <span>8000</span> <span>=</span> <span><b class="totaloP-54505">16,000</b></span></div></div></td></tr>
                            </thead>
                        </table>
                        <div style="width: 100%;margin-top: 20px;" align="right">
                            <table>
                                <thead style="color: #000;font-size: 2rem;">
                                    <tr><th style="text-align: right;">TOTAL AMOUNT</th><th style="padding-left: 10px;padding-right: 10px;">:</th><th>9,200</th></tr>
                                    <tr><th style="text-align: right;">PAID AMOUNT</th><th style="padding-left: 10px;">:</th><th>10,000</th></tr>
                                    <tr><th style="text-align: right;">CHANGE</th><th style="padding-left: 10px;">:</th><th>800</th></tr>
                                </thead>
                            </table>
                        </div>
                        <div style="width: 100%;font-size: 2rem;border-top: 1px solid #000;" align="center">Thanks for your purchase!</div>
                        <div style="width: 100%;font-size: 1.8rem;" align="center"><?php echo date('d M, Y, g:i a'); ?></div>
                    </div>
                    <!-- <button id="btnPrint" class="hidden-print">Print</button> -->
                    <button onClick="printReport();">PRINT</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 


@section('js')
<script type="text/javascript">
    
function printdiv(elem) {
  var header_str = '<html><head><title>' + document.title  + '</title></head><body>';
  var footer_str = '</body></html>';
  var new_str = document.getElementById(elem).innerHTML;
  var old_str = document.body.innerHTML;
  document.body.innerHTML = header_str + new_str + footer_str;
  window.print();
  document.body.innerHTML = old_str;
  return false;
}

function printReport() { 
    var $printerDiv = $('<div class="printContainer"></div>'); // create the div that will contain the stuff to be printed
    var new_str = document.getElementById('printable_div_id').innerHTML;
    $printerDiv.html(new_str); // add the content to be printed
    $('body').append($printerDiv).addClass("printingContent"); // add the div to body, and make the body aware of printing (we apply a set of css styles to the body to hide its contents)

    window.print(); // call print
    $printerDiv.remove(); // remove the div
    $('body').removeClass("printingContent");
}

//     const $btnPrint = document.querySelector("#btnPrint");
// $btnPrint.addEventListener("click", () => {
//     window.print();
// });
    $(function () { 
        $('.settings-tab').click();
        companySettings();
    });

    function companySettings() {
        $('[name="expire_date"], [name="import_products"]').prop('checked', false);
        $.get('/settings/company-settings/<?php echo Auth::user()->company_id; ?>', function(data) {
            $('.s-loader-2').css('display','none');
            if(data.settings.length == 0) { }  else {
                $(data.settings).each(function(index, value) {
                    if(value.setting_id == 1 && value.status == "yes") { // allow expire date
                        $('[name="expire_date"]').prop('checked', true);
                    } 
                    if(value.setting_id == 2 && value.status == "yes") { // allow minimum stock level
                        $('[name="stock_level"]').prop('checked', true);
                        $('.show-stock-level').css('display','block');
                        $('.show-stock-level input').val(Number(value.min_stock_level).toLocaleString("en"));
                    }
                    if(value.setting_id == 5 && value.status == "yes") { // allow upload products in bulk
                        $('[name="import_products"]').prop('checked', true);
                    } 
                });
            }

            $('.change-shop').change();
        });            
    }

    $(document).on('change', '[name="expire_date"]', function() {
        $('.full-cover').css('display','block');
        if(this.checked) {
            var val = "yes";
        } else {
            var val = "no";
        }
        $.get('/settings/update-expire-date/'+val, function(data){
            if (data.status == 'success') {
                $('.full-cover').css('display','none');
                if (data.val == 'yes') {
                    popNotification('success',"Expire date is enabled successfully.");
                }
                else if (data.val == 'no') {
                    popNotification('success',"Expire date is disabled successfully.");
                }
            }
        });
    });
    
    $(document).on('change', '[name="import_products"]', function() {
        $('.full-cover').css('display','block');
        if(this.checked) {
            var val = "yes";
        } else {
            var val = "no";
        }
        $.get('/settings/update-import-products/'+val, function(data){
            if (data.status == 'success') {
                $('.full-cover').css('display','none');
                if (data.val == 'yes') {
                    popNotification('success',"Import products is enabled successfully.");
                }
                else if (data.val == 'no') {
                    popNotification('success',"Import products is disabled successfully.");
                }
            }
        });
    });
    
    $(document).on('keyup', '[name="stock_value"]', function() {
        $('.update-msl').css('display','block');
    });
    $(document).on('click', '.update-msl', function() {
        $('.full-cover').css('display','block');
        var val = $('[name="stock_value"]').val();
        if(val == null || val == "") {
            popNotification('warning',"Sorry! you cant submit empty value");
            $('.full-cover').css('display','none');
            return;
        }
        $.get('/settings/change-minimum-stock-level/'+val, function(data){ 
            $('.full-cover').css('display','none');
            if (data.status == 'success') {
                $('.update-msl').css('display','none');
                popNotification('success',"Minimum stock level has been updated.");
            }
        });
    });

    $(document).on('change', '[name="stock_level"]', function() {
        $('.full-cover').css('display','block');
        if(this.checked) {
            var val = "yes";
        } else {
            var val = "no";
        }
        $.get('/settings/update-minimum-stock-level/'+val, function(data){
            if (data.status == 'success') {
                $('.full-cover').css('display','none');
                if (data.val == 'yes') {
                    $('.show-stock-level').css('display','block');
                    $('.show-stock-level input').val(Number(data.min_stock_level).toLocaleString("en"));
                    popNotification('success',"Minimum stock level is enabled successfully.");
                }
                else if (data.val == 'no') {
                    $('.show-stock-level').css('display','none');
                    popNotification('success',"Minimus stock level is disabled successfully.");
                }
            }
        });
    });
    
    $(document).on('change', '.change-shop', function() {
        var sid = $(this).val();
        $('[name="sale_empty_stock"]').prop('checked', false);
        $('[name="change-sale-pd-2"]').prop('checked', false); $('.show-days-back').css('display','none');
        $('.s-loader').css('display','block');
        $('.s-loader-3').css('display','block');
        $.get('/get-data/get-shop-settings/'+sid, function(data){
            $('.s-loader').css('display','none');
            $('.s-loader-3').css('display','none');
            if (data.shop.change_s_price == 'yes' || data.shop.change_s_price == null) {
                $('#yes-change-sp').prop('checked',true);
            } else {
                $('#no-change-sp').prop('checked',true);
            }
            if (data.shop.sell_order == 'no' || data.shop.sell_order == null) {
                $('#no-receipt-orders').prop('checked',true);
            } else {
                $('#yes-receipt-orders').prop('checked',true);
            }
            
            if(data.ssettings.length == 0) { }  else {
                $(data.ssettings).each(function(index, value) {
                    if(value.setting_id == 3 && value.status == "yes") { // allow expire date
                        $('[name="sale_empty_stock"]').prop('checked', true);
                    } 
                    if(value.setting_id == 4 && value.status == "yes") { // sale previous date
                        $('[name="change-sale-pd-2"]').prop('checked', true);
                        $('[name="days_back"]').val(value.sale_days_back);
                        $('.show-days-back').css('display','block');
                    } 
                });
            }
        });
    });
    
    $(document).on('change', '[name="sale_empty_stock"]', function() {
        $('.full-cover').css('display','block');
        if(this.checked) {
            var val = "yes";
        } else {
            var val = "no";
        }
        var sid = $(".change-shop").val();
        var sid_val = sid+"~"+val;
        $.get('/settings/update-sale-empty-stock/'+sid_val, function(data){
            if (data.status == 'success') {
                $('.full-cover').css('display','none');
                if (data.val == 'yes') {
                    popNotification('success',"You can sell empty stock products.");
                }
                else if (data.val == 'no') {
                    popNotification('success',"You can not sell empty stock products.");
                }
            }
        });
    });
    
    $(document).on('change', '[name="change-sale-pd-2"]', function() {
        $('.full-cover').css('display','block');
        if(this.checked) {
            var val = "yes";
        } else {
            var val = "no";
        }
        var sid = $(".change-shop").val();
        var sid_val = sid+"~"+val;
        $.get('/settings/change-sale-previous-date/'+sid_val, function(data){
            if (data.status == 'success') {
                $('.full-cover').css('display','none');
                if (data.val == 'yes') {
                    $('.show-days-back').css('display','block');
                    $('[name="days_back"]').val(data.days);
                    popNotification('success',"You can record sales of previous dates.");
                }
                else if (data.val == 'no') {
                    $('.show-days-back').css('display','none');
                    popNotification('success',"You can not record sales of previous dates.");
                }
            }
        });
    });
    
    $(document).on('change', '[name="days_back"]', function() {
        $('.full-cover').css('display','block');
        var val = $(this).val();
        var sid = $(".change-shop").val();
        var sid_val = sid+"~"+val;
        $.get('/settings/change-sale-back-days/'+sid_val, function(data){
            $('.full-cover').css('display','none');
            if (data.status == 'success') {
                popNotification('success',"Number of days has been updated.");
            }
        });
    });

    $(document).on('click', 'input[type=radio][name=cashier-approval]', function() {
        var val = $(this).val();
        $('.full-cover').css('display','block');
        $('.full-cover .inside').html('<i class="fa fa-spinner fa-spin fa-2x"></i>');
        $.get('/get-data/cashier-stock-approval/'+val, function(data){
            if (data.status == 'success') {
                $('.full-cover').css('display','none');
                if (data.val == 'yes') {
                    popNotification('success',"Cashier stock approval is enabled successfully.");
                }
                else if (data.val == 'no') {
                    popNotification('success',"Cashier stock approval is disabled successfully.");
                }
            }
        });
    });
    
    $(document).on('click', 'input[type=radio][name=transfer-products]', function() {
        var val = $(this).val();
        $('.full-cover').css('display','block');
        $('.full-cover .inside').html('<i class="fa fa-spinner fa-spin fa-2x"></i>');
        $.get('/get-data/change-transfer-products-status/'+val, function(data){
            if (data.status == 'success') {
                $('.full-cover').css('display','none');
                if (data.val == 'yes') {
                    popNotification('success',"Trasnfer Products is enabled successfully.");
                }
                else if (data.val == 'no') {
                    popNotification('success',"Trasnfer Products is disabled successfully.");
                }
            }
        });
    });
    
    $(document).on('click', 'input[type=radio][name=product-categories]', function() {
        var val = $(this).val();
        $('.full-cover').css('display','block');
        $('.full-cover .inside').html('<i class="fa fa-spinner fa-spin fa-2x"></i>');
        $.get('/get-data/change-product-categories-status/'+val, function(data){
            if (data.status == 'success') {
                $('.full-cover').css('display','none');
                if (data.val == 'yes') {
                    popNotification('success',"Product Categories is enabled successfully.");
                }
                else if (data.val == 'no') {
                    popNotification('success',"Product Categories is disabled successfully.");
                }
            }
        });
    });
    
    $(document).on('click', 'input[type=radio][name=customer-on-sales]', function() { // this is not used
        var val = $(this).val();
        $('.full-cover').css('display','block');
        $('.full-cover .inside').html('<i class="fa fa-spinner fa-spin fa-2x"></i>');
        $.get('/get-data/change-customer-on-sales-status/'+val, function(data){
            if (data.status == 'success') {
                $('.full-cover').css('display','none');
                if (data.val == 'yes') {
                    popNotification('success',"Customer view on sales is enabled successfully.");
                }
                else if (data.val == 'no') {
                    popNotification('success',"Customer view on sales is disabled successfully.");
                }
            }
        });
    });
    
    $(document).on('click', 'input[type=radio][name=change-s-price]', function() {
        var val = $(this).val();
        var sid = $(".change-shop").val();
        var sid_val = sid+"~"+val;
        $('.full-cover').css('display','block');
        $('.full-cover .inside').html('<i class="fa fa-spinner fa-spin fa-2x"></i>');
        $.get('/get-data/cashier-change-price/'+sid_val, function(data){
            if (data.status == 'success') {
                $('.full-cover').css('display','none');
                if (data.val == 'yes') {
                    popNotification('success',"Cashier is allowed to change selling price.");
                }
                else if (data.val == 'no') {
                    popNotification('success',"Cashier is not allowed to change selling price.");
                }
            }
        });
    });

    $(document).on('click', 'input[type=radio][name=receipt-orders]', function() {
        var val = $(this).val();
        var sid = $(".change-shop").val();
        var sid_val = sid+"~"+val;
        $('.full-cover').css('display','block');
        $('.full-cover .inside').html('<i class="fa fa-spinner fa-spin fa-2x"></i>');
        $.get('/get-data/change-receipt-orders/'+sid_val, function(data){
            if (data.status == 'success') {
                $('.full-cover').css('display','none');
                if (data.val == 'yes') {
                    popNotification('success',"Shop is allowed to print and save orders.");
                }
                else if (data.val == 'no') {
                    popNotification('success',"Shop is not allowed to print and save orders.");
                }
            }
        });
    });

</script>
@endsection