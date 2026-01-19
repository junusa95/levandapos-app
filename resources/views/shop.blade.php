@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/partials/sell-products-2.css') }}">
<link rel="stylesheet" href="{{ asset('css/partials/sales-report.css') }}">

@section('css')
    <link rel="stylesheet" href="{{ asset('css/partials/shop.css') }}">
    <link rel="stylesheet" href="{{ asset('slick/slick/slick.css') }}">
    <style>
        .breadcrumb {display: none !important;}
        .fancy-radio input[type="radio"]+span i {
            padding-right: 5px !important;
        }
        .displaynone, .displaynone2, .displaynone3 {display: none !important;}
        .edit-p-margin {padding-left: 30px;padding-right: 30px;}
        .block-access{position: absolute;width: 98%;height: 90%;background-color: #f8d7da;z-index: 1;opacity: 0.5;}

        .load-areas {
            background: #000;color: #fff;position: absolute;width: 98%;min-height: 100%;z-index: 99;opacity: 0.5;text-align: center;padding-top: 50px;font-size: 20px;display: none;
        }
        @media screen and (max-width: 900px) {
            .block-access{width: 96%;}
        }
        @media screen and (max-width: 766px) {
            #Expenses .render-expenses {height: 100px !important;}
        }
        @media screen and (max-width: 576px) {
            .block-access{width: 96%;left: 0;margin-left: 5px;}
        }
        @media screen and (max-width: 363px) {
            #Products .nav-tabs-new2>li>a {
                padding-left: 19px;padding-right: 19px;
            }
        }
    </style>
@endsection

<?php
    $reminder2 = "";
    if($data['shop']) {
        $reminder2 = $data['shop']->reminder;
    }
if(Cookie::get("language") == 'en') {
    $_GET['country_select'] = "Country";
    $_GET['region_select'] = "Region";
    $_GET['ward_select'] = "Ward";
    $_GET['district_select'] = "District";
    $_GET['b-p'] = "BP";
    $_GET['change-supplier-details'] = "Change supplier details";
    $_GET['s-p'] = "SP";
    $_GET['no-products'] = "No products";
    $_GET['no-customer-sales'] = "No Customer Sales";
    $_GET['sales-past-ten-days'] = "Sales Past 10d";
    $_GET['sales-with-no-customer'] = "Sales with No Customer";
    $_GET['profit-past-ten-days'] = "Profit Past 10d";
    $_GET['today-profit'] = "Today Profit";
    $_GET['expenses-past-ten-days'] = "Expenses Past 10d";
    $_GET['sold-products-ten-days'] = "Sold Products Past 10d";
    $_GET['sell-products-short'] = "Sell by searhing product OR by filtering the categories";
    $_GET['sales-report-short'] = "Get all your previous sales records";
    $_GET['products-bought-by'] = "Products bought by";
    $_GET['products-short'] = "Add and preview available products";
    $_GET['stock-short'] = "Add stock and see previous stock records";
    $_GET['expenses-short'] = "Record your daily expenses at shop i.e allowance, food, electricity e.t.c";
    $_GET['customers-short'] = "Register customer and monitor their purchases, loans, payments e.t.c";
    $_GET['transfer-short'] = "Transfer products from this shop to other shop/store";
    $_GET['settings-short'] = "Manage features for your shop";
    $_GET['sh-reminder-desc'] = "Hello, Free trial uses for this shop will expire after ".$reminder2." days.<br> Please pay for your shop so that it will not be blocked. <a href='#' data-toggle='modal' data-target='#endFreeTrialModal'>Click here to see our pricing</a>";
    $_GET['sh-reminder-desc-2'] = "Hello, Payments for this shop will expire after ".$reminder2." days.<br> Please pay for your shop so that it will not be blocked. <a href='#' data-toggle='modal' data-target='#endFreeTrialModal'>Click here to see our pricing</a>";
    $_GET['sh-end-free-t'] = "Hello, 30 days free trial for this shop is over. Please pay for it in order to proceed using it. <a href='#' data-toggle='modal' data-target='#endFreeTrialModal'>Click here to see our pricing</a>";
    $_GET['sh-expire-t'] = "Hello, Payments for this shop is over. Please pay for it in order to proceed using it. <a href='#' data-toggle='modal' data-target='#endFreeTrialModal'>Click here to see our pricing</a>";
    $_GET['suppliers-short'] = "Register suppliers and manage purchases";
    $_GET['dont-have-access-in-shop'] = '<div class="row clearfix"><div class="col-12"><div class="p-3"><i class="fa fa-warning text-warning" style="font-size:35px;"></i><h5>You dont have access in this shop, <br> <a href="/users/'.Auth::user()->id.'" style="text-decoration:underline">click here</a> to assign yourself a cashier or sale person role.</h5></div></div></div>';
} else {
    $_GET['country_select'] = "Nchi";
    $_GET['region_select'] = "Mkoa";
    $_GET['ward_select'] = "Kata";
    $_GET['district_select'] = "Wilaya";
    $_GET['b-p'] = "BN";
    $_GET['change-supplier-details'] = "Badili taarifa za msambazaji";
    $_GET['s-p'] = "BU";
    $_GET['no-products'] = "Hakuna bidhaa";
    $_GET['no-customer-sales'] = "Mauzo bila Mteja";
    $_GET['sales-past-ten-days'] = "Mauzo ya Siku 10";
    $_GET['sales-with-no-customer'] = "Mauzo bila Mteja";
    $_GET['profit-past-ten-days'] = "Faida ya Siku 10";
    $_GET['today-profit'] = "Faida ya Leo";
    $_GET['expenses-past-ten-days'] = "Matumizi ya siku 10";
    $_GET['sold-products-ten-days'] = "Bidhaa Zilizouzwa siku 10";
    $_GET['sell-products-short'] = "Uza kwa kutafuta bidhaa AU kwa kuchagua kategori";
    $_GET['sales-report-short'] = "Pata rekodi ya mauzo yako ya zamani";
    $_GET['products-bought-by'] = "Bidhaa zilizonunuliwa na";
    $_GET['products-short'] = "Ongeza na tazama Bidhaa zilizopo";
    $_GET['stock-short'] = "Ongeza idadi ya bidhaa (stock) na tazama rekodi ya stock za zamani";
    $_GET['expenses-short'] = "Rekodi matumizi ya kila siku kama chakula, posho, umeme n.k";
    $_GET['customers-short'] = "Sajili mteja kisha fatilia bidhaa anazonunua, madeni, malipo n.k";
    $_GET['transfer-short'] = "Hamisha bidhaa kutoka dukani kwenda duka ingine au stoo";
    $_GET['settings-short'] = "Rekebisha vipengele kwenye duka lako";
    $_GET['sh-reminder-desc'] = "Habari, Matumizi ya bure kwa duka hili yataisha baada ya siku ".$reminder2.".<br> Tafadhali lipia duka lako ili lisifungiwe muda utakapoisha. <a href='#' data-toggle='modal' data-target='#endFreeTrialModal'>Bonyeza hapa kuona bei zetu</a>";
    $_GET['sh-reminder-desc-2'] = "Habari, Malipo kwa duka hili yataisha baada ya siku ".$reminder2.".<br> Tafadhali lipia duka lako ili lisifungiwe muda utakapoisha. <a href='#' data-toggle='modal' data-target='#endFreeTrialModal'>Bonyeza hapa kuona bei zetu</a>";
    $_GET['sh-end-free-t'] = "Habari, Siku 30 za kutumia bure hili duka zimeisha. Tafadhali lipia ili uendelee kulitumia. <a href='#' data-toggle='modal' data-target='#endFreeTrialModal'>Bonyeza hapa kuona bei zetu</a>";
    $_GET['sh-expire-t'] = "Habari, Malipo kwa duka hili yameisha. Tafadhali lipia ili uendelee kulitumia. <a href='#' data-toggle='modal' data-target='#endFreeTrialModal'>Bonyeza hapa kuona bei zetu</a>";
    $_GET['suppliers-short'] = "Sajili wasambazaji na rekodi manunuzi ya bidhaa kutoka kwao";
    $_GET['dont-have-access-in-shop'] = '<div class="row clearfix"><div class="col-12"><div class="p-3"><i class="fa fa-warning text-warning" style="font-size:35px;"></i><h5>Hauna ruhusa kwenye hili duka, <br> <a href="/users/'.Auth::user()->id.'" style="text-decoration:underline">bonyeza hapa</a> kujipa ruhusa kwenye hili duka kama keshia au muuzaji wa kawaida.</h5></div></div></div>';
}
?>

@section('content')
    
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
                        <div class="col-12">
                            <div class="shop-top-corner">
                                <label class="mb-0" style="font-weight:300"><?php echo $_GET['shop']; ?></label><br>
                                  <select name="sources" id="sources" class="custom-select change-shop sources" value="{{$data['shop']->id}}" placeholder="{{$data['shop']->name}}">
                                  @if($data['isCEO'] == "yes") <option class="change-shop2 as" value="add-shop"><i class="fa fa-plus pr-1"></i> <?php echo $_GET['add-shop']; ?></option> @endif
                                    @if($data['shops']->isNotEmpty())
                                        @if($data['isCEO'] == "no") 
                                            <option value="#"></option>
                                            @foreach($data['shops'] as $shop)
                                                <option class="change-shop2" value="{{$shop->sid}}">{{$shop->name}}</option>
                                            @endforeach
                                        @else
                                            @foreach($data['shops'] as $shop)
                                                <option class="change-shop2" value="{{$shop->id}}">{{$shop->name}}</option>
                                            @endforeach
                                        @endif
                                    @endif
                                  </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">

                    <?php if(strlen($data['shop']->reminder) >= 1) { $displaynone = ""; } else { $displaynone = "displaynone"; } ?>
                    <?php if($data['shop']->status == 'end free trial') { $displaynone2 = ""; } else { $displaynone2 = "displaynone"; } ?>
                    <?php if($data['shop']->status == 'not paid') { $displaynone3 = ""; } else { $displaynone3 = "displaynone"; } ?>
                    <div class="col-sm-12 <?php echo $displaynone; ?>">
                        <?php if($data['shop']->status == "active") { ?>
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <i class="fa fa-warning fa-2x" style="float:left"></i> <div class="pl-3" style="display:inline-block;"><h5 class="mb-2"><b><?php echo $_GET['reminder']; ?>:</b></h5> <?php echo $_GET['sh-reminder-desc-2']; ?> </div>
                            </div>
                        <?php } else { ?>
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <i class="fa fa-warning fa-2x" style="float:left"></i> <div class="pl-3" style="display:inline-block;"><h5 class="mb-2"><b><?php echo $_GET['reminder']; ?>:</b></h5> <?php echo $_GET['sh-reminder-desc']; ?></div>
                            </div>
                        <?php } ?>
                    </div>
                    
                    <div class="col-sm-12 <?php echo $displaynone2; ?>">
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <i class="fa fa-warning fa-2x" style="float:left"></i> <div class="pl-3" style="display:inline-block;"><h5 class="mb-2"><b><?php echo $_GET['reminder']; ?>:</b></h5> <?php echo $_GET['sh-end-free-t']; ?></div>
                        </div>
                    </div>
                    
                    <div class="col-sm-12 <?php echo $displaynone3; ?>">
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <i class="fa fa-warning fa-2x" style="float:left"></i> <div class="pl-3" style="display:inline-block;"><h5 class="mb-2"><b><?php echo $_GET['reminder']; ?>:</b></h5> <?php echo $_GET['sh-expire-t']; ?></div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 shop-tab-conten" style="margin-top: -10px;">
                        <div class="shop-tabs">
                            <div class="row px-0 mx-0">
                                <div class="col-12 nav-out" style="padding-left:0px">
                                <ul class="nav nav-tabs-new" id="cont">
                                    @if($data['who'] == "sale person")
                                    <li class="nav-item"><a class="nav-link home-tab active" data-toggle="tab" href="#Home"><i class="fa fa-home"></i></a></li>
                                    <li class="nav-item"><a class="nav-link sell-tab" data-toggle="tab" href="#Sell"><?php echo $_GET['sell-products']; ?></a></li>
                                    @else
                                    <li class="nav-item"><a class="nav-link home-tab active" data-toggle="tab" href="#Home"><i class="fa fa-home"></i></a></li>
                                    <li class="nav-item"><a class="nav-link products-tab" data-toggle="tab" href="#Products"><?php echo $_GET['products-menu']; ?></a></li>
                                    <li class="nav-item"><a class="nav-link sell-tab" data-toggle="tab" href="#Sell"><?php echo $_GET['sell-products']; ?></a></li>
                                    <li class="nav-item"><a class="nav-link report-tab" data-toggle="tab" href="#Report"><?php echo $_GET['sales-report-menu']; ?></a></li>
                                    <!-- <li class="nav-item"><a class="nav-link stock-tab" data-toggle="tab" href="#Stock"><?php echo $_GET['stock-records']; ?></a></li> -->
                                    <li class="nav-item"><a class="nav-link expenses-tab" data-toggle="tab" href="#Expenses"><?php echo $_GET['expenses-menu']; ?></a></li>
                                    <li class="nav-item"><a class="nav-link customers-tab" data-toggle="tab" href="#Customers"><?php echo $_GET['customers']; ?></a></li>
                                    <li class="nav-item"><a class="nav-link suppliers-tab" data-toggle="tab" href="#Suppliers"><?php echo $_GET['suppliers']; ?></a></li>
                                    <!-- @if(Auth::user()->company->can_transfer_items != "no")
                                        <li class="nav-item"><a class="nav-link transfer-tab" data-toggle="tab" href="#Transfer"><?php echo $_GET['transfer-menu']; ?></a></li>
                                    @endif -->
                                    <!-- <li class="nav-item"><a class="nav-link settings-tab" data-toggle="tab" href="#Settings">Settings</a></li> -->
                                    @endif
                                </ul>
                                </div>
                                <div class="tabs-drop">
                                    <i class="fa fa-angle-double-right"></i>
                                </div>
                                <div class="other-tabs">
                                    <ul class="nav" id="">
                                        <li class="nav-item"><a class="nav-link home-tab active" data-toggle="tab" href="#Home"><i class="fa fa-home"></i> Home</a></li>
                                        @if($data['who'] == "sale person")
                                        <li class="nav-item"><a class="nav-link sell-tab" data-toggle="tab" href="#Sell"><?php echo $_GET['sell-products']; ?></a></li>
                                        @else
                                        <li class="nav-item" style="display:none"><a class="nav-link home-tab active" data-toggle="tab" href="#Home">Home</a></li>
                                        <li class="nav-item"><a class="nav-link products-tab" data-toggle="tab" href="#Products"><?php echo $_GET['products-menu']; ?></a></li>
                                        <li class="nav-item"><a class="nav-link sell-tab" data-toggle="tab" href="#Sell"><?php echo $_GET['sell-products']; ?></a></li>
                                        <li class="nav-item"><a class="nav-link report-tab" data-toggle="tab" href="#Report"><?php echo $_GET['sales-report-menu']; ?></a></li>
                                        <!-- <li class="nav-item"><a class="nav-link stock-tab" data-toggle="tab" href="#Stock"><?php echo $_GET['stock-records']; ?></a></li> -->
                                        <li class="nav-item"><a class="nav-link expenses-tab" data-toggle="tab" href="#Expenses"><?php echo $_GET['expenses-menu']; ?></a></li>
                                        <li class="nav-item"><a class="nav-link customers-tab" data-toggle="tab" href="#Customers"><?php echo $_GET['customers']; ?></a></li>
                                        <li class="nav-item"><a class="nav-link suppliers-tab" data-toggle="tab" href="#Suppliers"><?php echo $_GET['suppliers']; ?></a></li>
                                        <!-- @if(Auth::user()->company->can_transfer_items != "no")
                                            <li class="nav-item"><a class="nav-link transfer-tab" data-toggle="tab" href="#Transfer"><?php echo $_GET['transfer-menu']; ?></a></li>
                                        @endif -->
                                        <!-- <li class="nav-item"><a class="nav-link settings-tab" data-toggle="tab" href="#Settings">Settings</a></li> -->
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content padding-0">
                            @if($data['shop']->status == "end free trial" || $data['shop']->status == "not paid")
                            <div class="block-access"></div>
                            @endif 
                            <div class="tab-pane active" id="Home">
                                <div class="card">
                                    <div class="body">
                                        <div class="row">
                                            <div class="col-12 report-carousel-block px-0 mb-3">                                                
                                                <div class="report-carousel">
                                                    <div>
                                                        <div class="item" style="background-color: #bdf3f5;">
                                                            <h4><i class="icon-wallet"></i> <span class="sales-ten"><i class="fa fa-spinner fa-spin"></i></span></h4>
                                                            <span><?php echo $_GET['sales-past-ten-days']; ?></span>
                                                        </div>
                                                    </div>
                                                    <!-- <div>
                                                        <div class="item" style="background-color: #f9f1d8;">
                                                            <h4><i class="icon-wallet"></i> <span class="sales-today"><i class="fa fa-spinner fa-spin"></i></span></h4>
                                                            <span><?php echo $_GET['today-sales']; ?></span>
                                                        </div>
                                                    </div> -->
                                                    @if(Auth::user()->isBusinessOwner())
                                                    <div>
                                                        <div class="item" style="background-color: #efebf4;">
                                                            <h4><i class="icon-wallet"></i> <span class="profit-ten"><i class="fa fa-spinner fa-spin"></i></span></h4>
                                                            <span><?php echo $_GET['profit-past-ten-days']; ?></span>
                                                        </div>
                                                    </div>
                                                    <!-- <div>
                                                        <div class="item" style="background-color: #ffd4c3;">
                                                            <h4><i class="icon-wallet"></i> <span class="profit-today"><i class="fa fa-spinner fa-spin"></i></span></h4>
                                                            <span><?php echo $_GET['today-profit']; ?></span>
                                                        </div>
                                                    </div> -->
                                                    @endif
                                                    <div>
                                                        <div class="item" style="background-color: #e0eff5;">
                                                            <h4><i class="icon-wallet"></i> <span class="sold-p-ten"><i class="fa fa-spinner fa-spin"></i></span></h4>
                                                            <span><?php echo $_GET['sold-products-ten-days']; ?></span>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="item" style="background-color: #e0eff5;">
                                                            <h4><i class="icon-wallet"></i> <span class="expenses-ten"><i class="fa fa-spinner fa-spin"></i></span></h4>
                                                            <span><?php echo $_GET['expenses-past-ten-days']; ?></span>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="item" style="background-color: #FFEEAE;">
                                                            <h4><i class="icon-wallet"></i> <span class="total-products"><i class="fa fa-spinner fa-spin"></i></span></h4>
                                                            <span><?php echo $_GET['available-products']; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($data['who'] == "sale person")
                                            <div class="col-md-6">
                                                <ul class="list-unstyled feeds_widget sell-tab-blc">
                                                    <li>
                                                        <div class="feeds-left"><i class="fa fa-shopping-cart text-info"></i></div>
                                                        <div class="feeds-body">
                                                            <h4 class="title"><?php echo $_GET['sell-products']; ?> <span class="float-right"><i class="fa fa-angle-right"></i></span></h4>
                                                            <small><?php echo $_GET['sell-products-short']; ?></small>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            @else
                                            <div class="col-md-6">
                                                <ul class="list-unstyled feeds_widget products-tab-blc">
                                                    <li>
                                                        <div class="feeds-left"><i class="fa fa-cubes text-primary"></i></div>
                                                        <div class="feeds-body">
                                                            <h4 class="title"><?php echo $_GET['products-menu']; ?> <span class="float-right"><i class="fa fa-angle-right"></i></span></h4>
                                                            <small><?php echo $_GET['products-short']; ?></small>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <ul class="list-unstyled feeds_widget sell-tab-blc">
                                                    <li>
                                                        <div class="feeds-left"><i class="fa fa-shopping-cart text-info"></i></div>
                                                        <div class="feeds-body">
                                                            <h4 class="title"><?php echo $_GET['sell-products']; ?> <span class="float-right"><i class="fa fa-angle-right"></i></span></h4>
                                                            <small><?php echo $_GET['sell-products']; ?></small>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <ul class="list-unstyled feeds_widget report-tab-blc">
                                                    <li>
                                                        <div class="feeds-left"><i class="fa fa-bar-chart-o text-success"></i></div>
                                                        <div class="feeds-body">
                                                            <h4 class="title"><?php echo $_GET['sales-report-menu']; ?> <span class="float-right"><i class="fa fa-angle-right"></i></span></h4>
                                                            <small><?php echo $_GET['sales-report-short']; ?></small>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6" style="display: none;">
                                                <ul class="list-unstyled feeds_widget stock-tab-blc">
                                                    <li>
                                                        <div class="feeds-left"><i class="fa fa-database" style="color:#6f42c1"></i></div>
                                                        <div class="feeds-body">
                                                            <h4 class="title"><?php echo $_GET['stock-menu']; ?> <span class="float-right"><i class="fa fa-angle-right"></i></span></h4>
                                                            <small><?php echo $_GET['stock-short']; ?></small>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <ul class="list-unstyled feeds_widget expenses-tab-blc">
                                                    <li>
                                                        <div class="feeds-left"><i class="fa fa-dollar" style="color:#f9a11d"></i></div>
                                                        <div class="feeds-body">
                                                            <h4 class="title"><?php echo $_GET['expenses-menu']; ?> <span class="float-right"><i class="fa fa-angle-right"></i></span></h4>
                                                            <small><?php echo $_GET['expenses-short']; ?></small>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <ul class="list-unstyled feeds_widget customers-tab-blc">
                                                    <li>
                                                        <div class="feeds-left"><i class="fa fa-user text-info"></i></div>
                                                        <div class="feeds-body">
                                                            <h4 class="title"><?php echo $_GET['customers']; ?> <span class="float-right"><i class="fa fa-angle-right"></i></span></h4>
                                                            <small><?php echo $_GET['customers-short']; ?></small>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <ul class="list-unstyled feeds_widget suppliers-tab-blc">
                                                    <li>
                                                        <div class="feeds-left"><i class="fa fa-user text-info"></i></div>
                                                        <div class="feeds-body">
                                                            <h4 class="title"><?php echo $_GET['suppliers']; ?> <span class="float-right"><i class="fa fa-angle-right"></i></span></h4>
                                                            <small><?php echo $_GET['suppliers-short']; ?></small>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <!-- @if(Auth::user()->company->can_transfer_items != "no")
                                            <div class="col-md-6">
                                                <ul class="list-unstyled feeds_widget transfer-tab-blc">
                                                    <li>
                                                        <div class="feeds-left"><i class="fa fa-expand text-primary"></i></div>
                                                        <div class="feeds-body">
                                                            <h4 class="title"><?php echo $_GET['transfer-menu']; ?> <span class="float-right"><i class="fa fa-angle-right"></i></span></h4>
                                                            <small><?php echo $_GET['transfer-short']; ?></small>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            @endif -->
                                            <div class="col-md-6" style="display: none;">
                                                <ul class="list-unstyled feeds_widget settings-tab-blc">
                                                    <li>
                                                        <div class="feeds-left"><i class="icon-settings text-info"></i></div>
                                                        <div class="feeds-body">
                                                            <h4 class="title">Settings <span class="float-right"><i class="fa fa-angle-right"></i></span></h4>
                                                            <small><?php echo $_GET['settings-short']; ?></small>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                          

                                            @endif
                                            <div class="col-12 mb-4">
                                                <div align="center" style="margin-top: 60px;">
                                                  <button class="btn btn-outline-orange how-to-use"> <?php echo $_GET['how-to-use']; ?> </button>
                                                </div>


                                                <div class="accordion" id="accordion" style="margin-top: 60px;display: none;">
                                                    <div class="">
                                                        <div class="card-header" id="headingOne">
                                                            <h5 class="mb-0">
                                                                <button class="btn btn-link collapsed show-customer" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="font-size: 14px;">
                                                                    <i class="fa fa-info-circle fa-2x" style="float: left;"></i>
                                                                    <div style="float: left;font-weight: bold;padding-top: 5px;padding-left: 10px;"> Maelezo kuhusu duka</div> 
                                                                    <i class="fa fa-angle-down fa-2x" style="float: right;"></i>
                                                                </button>
                                                            </h5>
                                                        </div>                                
                                                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" style="border: 2px solid #eee;">
                                                            <div class="card-body" style="padding-bottom: 10px;padding-top: 10px;">                
                                                                <div> <br>
                                                                    Mambo muhimu unayoweza kuyafanya ndani ya <b>Duka</b> <br><br> 
                                                                    1. Kurekodi na kutunza taarifa za bidhaa. <br>
                                                                    2. Kurekodi Mauzo. <br>
                                                                    3. Kuona ripoti ya Mauzo na Faida. <br>
                                                                    4. Kurekodi na kupata taarifa za Matumizi <br>
                                                                    5. Kurekodi na kupata taarifa za Wateja na Madeni. <br>
                                                                    6. Kurekodi na kupata taarifa za Suppliers, bidhaa ulizonunua kwao na madeni wanayokudai. <br>
                                                                    7. Na mengine mengi.. <br><br>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>                 
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="Sell">
                                <div class="card">
                                    <!-- <?php if($data['shop']->sell_order == 'yes') { ?>
                                    <div class="row sell-order-tabs" align="center">
                                        <div class="col-6 col-md-3">
                                            <div class="sell-t"><?php echo $_GET['sell']; ?></div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="order-t"><?php echo $_GET['orders']; ?></div>
                                        </div>
                                    </div>
                                    <?php } ?> -->

                                    <div class="body render-sell-products pt-0 px-0">
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="Report">
                                <div class="row">
                                    <div class="col-12 reduce-padding">
                                        <div class="card">
                                            <div class="body render-sales-report pt-0 px-3">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="Products">
                                <div class="card">
                                    <div class="body pt-0 px-0">
                                       <div class="row">
                                            <div class="col-md-8 offset-md-2 px-0">
                                                <ul class="nav nav-tabs-new2" style="display: none;">
                                                    <li class="nav-item"><a class="nav-link products-opt" data-toggle="tab" href="#"><?php echo $_GET['products-menu']; ?></a></li>
                                                    <li class="nav-item"><a class="nav-link cats-opt" data-toggle="tab" href="#"><?php echo $_GET['categories']; ?></a></li>
                                                    <li class="nav-item"><a class="nav-link quantity-opt" data-toggle="tab" href="#"><?php echo $_GET['products-in']; ?></a></li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane products-outer-block show active">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                       </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="Stock">
                                <div class="card">
                                    <div class="body render-stock-report pt-0 px-0">
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="Expenses">
                                <div class="card" style="margin-top: 10px !important;">
                                    <div class="body render-expenses pt-0 px-0">
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="Customers">
                                <div class="card">
                                    <div class="body render-customers pt-0 px-0">
                                        
                                    </div>
                                </div>
                            </div>
                            
                            <div class="tab-pane" id="Suppliers">
                                <div class="card">
                                    <div class="body render-suppliers pt-0 px-0">
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="Transfer"><!--  this is not longer used -->
                                <div class="card">
                                    <div class="body render-transfers pt-0 px-0">
                                        
                                    </div>
                                </div>
                            </div>
                            
                            <div class="tab-pane" id="Settings"><!--  this is not longer used -->
                                <div class="card">
                                    <div class="body render-settings pt-0 px-0">
                                        
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- modal edit sales -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-12">
                            <div class="table-responsive">
                                <table class="table table-borderless m-b-0 c_list">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Edit sale row</th>
                                        </tr>
                                    </thead>
                                    <tbody class="edit-sale sold-products2">
                                        
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-5 ml-2 sale-details">
                                <p>Mteja: <b class="customer-name"></b></p>
                                <p>Sale No: <b class="sale-no"></b></p>
                                <p>Idadi: <b class="total-q"></b></p>
                                <p>Thamani ya bidhaa: <b class="total-a"></b></p>
                                <p>Kias kilicholipwa: <b class="amount-p"></b></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modals.new-shop')
    @include('modals.create-customer')

@endsection

@section('js')
<script src="{{ asset('slick/slick/slick.min.js') }}"></script>
<script src="{{ asset('js/jquery.print.min.js') }}"></script>
<script type="text/javascript">
    // report carousel
 
    // end report carousel

    $(document).ready(function() {
      $(".select2").select2({
        dropdownParent: $("#newShop")
      });
    });

    $(document).ready(function(){

        // show hide cat menu
        $(".shop-tabs .tabs-drop").click(function () {
            $(".other-tabs").stop(true).toggle("slow");
            $(this).html(function (i, t) {
                return t == '<i class="fa fa-angle-double-down"></i>' ? '<i class="fa fa-angle-double-right"></i>' : '<i class="fa fa-angle-double-down"></i>';
            });
        });
        
        $('.report-carousel').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            arrows: false,
            autoplaySpeed: 2000,
            variableWidth:true,
        });
    });

    $(document).mouseup(function(e) {
        var container = $(".other-tabs");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            if ($(".shop-tabs .tabs-drop .fa").hasClass('fa-angle-double-down')) {
                $('.shop-tabs .tabs-drop').click();
            } 
        }
    });

    $(function () {

        var shop_tab = getSearchParams("tab");
        if ($.isEmptyObject(shop_tab)) {
            $('.shop-tabs .nav-tabs-new .home-tab').click();
        } else {
            if (shop_tab == "home") {
                $('.shop-tabs .nav-tabs-new .home-tab').click();
            } else if (shop_tab == "sell-products") {
                $('.shop-tabs .nav-tabs-new .sell-tab').click();
            } else if (shop_tab == "sales-report") {
                $('.shop-tabs .nav-tabs-new').animate({
                  scrollLeft: "+=50px"
                }, "slow");
                $('.shop-tabs .nav-tabs-new .report-tab').click();                
            } else if (shop_tab == "products") {
                $('.shop-tabs .nav-tabs-new').animate({
                  scrollLeft: "+=0px"
                }, "slow");
                
                $('.shop-tabs .nav-tabs-new .products-tab').click();

            } else if (shop_tab == "stock") {
                $('.shop-tabs .nav-tabs-new').animate({
                  scrollLeft: "+=200px"
                }, "slow");
                $('.shop-tabs .nav-tabs-new .stock-tab').click();
            } else if (shop_tab == "expenses") {
                $('.shop-tabs .nav-tabs-new').animate({
                  scrollLeft: "+=300px"
                }, "slow");
                $('.shop-tabs .nav-tabs-new .expenses-tab').click();
            } else if (shop_tab == "customers") {
                $('.shop-tabs .nav-tabs-new').animate({
                  scrollLeft: "+=400px"
                }, "slow");
                var customer_id = getSearchParams("customer_id");
                if ($.isEmptyObject(customer_id)) {
                    $('.shop-tabs .nav-tabs-new .customers-tab').click();
                } else {
                    getCustomerDetails(customer_id);
                }                
            } else if (shop_tab == "suppliers") {
                $('.shop-tabs .nav-tabs-new').animate({
                  scrollLeft: "+=400px"
                }, "slow");
                var supplier_id = getSearchParams("supplier_id");
                if ($.isEmptyObject(supplier_id)) {
                    $('.shop-tabs .nav-tabs-new .suppliers-tab').click();
                } else {
                    openSupplierTab(supplier_id);
                }                
            } else if (shop_tab == "transfer") {
                $('.shop-tabs .nav-tabs-new').animate({
                  scrollLeft: "+=500px"
                }, "slow");
                $('.shop-tabs .nav-tabs-new .transfer-tab').click();
            } else if (shop_tab == "transfer-items") {
                $('.shop-tabs .nav-tabs-new').animate({
                  scrollLeft: "+=500px"
                }, "slow");
                transferItems();
            } else if (shop_tab == "settings") {
                $('.shop-tabs .nav-tabs-new').animate({
                  scrollLeft: "+=300px"
                }, "slow");
                $('.shop-tabs .nav-tabs-new .settings-tab').click();
            } else {
                window.location = "/shops/<?php echo $data['shop']->id; ?>";
            }
        }
    });

    function getSearchParams(k){
     var p={};
     location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(s,k,v){p[k]=v})
     return k?p[k]:p;
    }

    $(document).on('click', '.how-to-use', function(e) {
        e.preventDefault();
        
        $('#notificationModal').modal('toggle');
        $('.notification-body').html('<div class="row" align="left">'+
                    '<div class="col-12"> Mambo muhimu unayoweza kuyafanya ndani ya <b>Duka</b> <br><br> 1. Kurekodi na kutunza taarifa za bidhaa. <br> 2. Kurekodi Mauzo. <br> 3. Kuona ripoti ya Mauzo na Faida. <br> 4. Kurekodi na kupata taarifa za Matumizi <br> 5. Kurekodi na kupata taarifa za Wateja na Madeni. <br> 6. Kurekodi na kupata taarifa za Suppliers, bidhaa ulizonunua kwao na madeni wanayokudai. <br> 7. Na mengine mengi.. <br><br> </div>'+
                    '<div class="col-12 mt-3">'+
                        '<div class="col-12 mb-2 mt-3"><a href="https://youtube.com/playlist?list=PLIA0DfELblTwPSLYZ4B1oNpvMIc98jj2w&si=6aicCDClWwz41RU2" target="_blank" class="btn btn-outline-orange" > <?php echo $_GET["how-to-use"]; ?> <i class="fa fa-arrow-right pl-2"></i></a></div>'+
                    '</div></div>');
    });

    $(document).on('click', '.change-shop2', function(e) {
        e.preventDefault();
        $('.change-shop2.as').removeClass('selection');
        var val = $(this).attr('data-value');
        var shop_tab = getSearchParams("tab");
        if (val == "add-shop") {
            $('.new-shop')[0].reset();
            $('.check-location-level').html('<input type="hidden" class="user-location" value="inside">');
            $('#newShop').modal('toggle');
            var c_val = $('.change-shop').attr('placeholder');
            $(".custom-select-trigger").text(c_val);
            $('.load-areas').css('display','block');
            $('.change-country-2').val(213).trigger("change");
            // alert('ss');
        } else {
            if ($.isEmptyObject(shop_tab)) {
                var url = "/shops/"+val;
            } else {
                var url = "/shops/"+val+"?tab="+shop_tab;
            }
            window.location = url;
        }
    });
    $(document).on('change', '.change-country-2', function(e){ // from add shop modal
        e.preventDefault();
        var country_id = $(this).val();

        if (country_id == 213) {

            $('.location_view').removeClass('d-none');
            $('.shoplocation_view').addClass('d-none');
            country_id_call(country_id);
        } else {
            // location_view
            $('.shoplocation_view').removeClass('d-none');
            $('.location_view').addClass('d-none');

            $('.load-areas').css('display','none');

            $('.region_id, .district_id, .ward_id').html('<option value="-" disabled selected>-Select-</option>'); // do this to avoid null selection on above
        }
    });
    function country_id_call(country_id) {

        $('.load-areas').css('display','block');

                    var $regionSelect = $('.region_id');

                    $regionSelect.empty();

                    var $districtSelect = $('.district_id');

                    $districtSelect.empty();

                    var $wardSelect = $('.ward_id');

                    $wardSelect.empty();

        $.ajax({
            type: 'GET',
            url: '/get/region_data',
            data: {
                country_id: country_id,
            },
            success: function(data) {
                // console.log(data);
                $('.load-areas').css('display','none');

                if (data.status == "success") {

                    var $regionSelect = $('.region_id');

                    $regionSelect.empty();
                    $regionSelect.append('<option value="-" disabled selected>-Select-</option>');
                    $.each(data.regions, function(index, region) {
                        $regionSelect.append('<option value="' + region.id + '">' + region.name + '</option>');
                    });

                } else {
                    popNotification('warning',"Failed to load regions");
                }
            }
        });
    };
    $(document).on('change', '.region_id', function(e){
        $('.load-areas').css('display','block');

        var region_id = $('.region_id').val();

                    var $districtSelect = $('.district_id');

                    $districtSelect.empty();

                    var $wardSelect = $('.ward_id');

                    $wardSelect.empty();

        $.ajax({
            type: 'GET',
            url: '/get/district_data',
            data: {
                region_id: region_id,
            },
            success: function(data) {
                $('.load-areas').css('display','none');

                if (data.status == "success") {

                    var $districtSelect = $('.district_id');

                    $districtSelect.empty();
                    $districtSelect.append('<option value="" disabled selected>-Select-</option>');
                    $.each(data.districts, function(index, district) {
                        $districtSelect.append('<option value="' + district.id + '">' + district.name + '</option>');
                    });

                } else {
                    popNotification('warning',"Failed to load Districts");
                }
            }
        });

    });
    $(document).on('change', '.district_id', function(e){
        $('.load-areas').css('display','block');

        var district_id = $('.district_id').val();
        // console.log(district_id);

                    var $wardSelect = $('.ward_id');

                    $wardSelect.empty();

        $.ajax({
            type: 'GET',
            url: '/get/ward_data',
            data: {
                district_id: district_id,
            },
            success: function(data) {
                $('.load-areas').css('display','none');

                if (data.status == "success") {

                    var $wardSelect = $('.ward_id');

                    $wardSelect.empty();
                    $wardSelect.append('<option value="" disabled selected>-Select-</option>');
                    $.each(data.wards, function(index, ward) {
                        $wardSelect.append('<option value="' + ward.id + '">' + ward.name + '</option>');
                    });

                } else {
                    popNotification('warning',"Failed to load Wards");
                }
            }
        });

    });

    $(document).on('click', '.home-tab', function(e) {
        e.preventDefault();
        $('.shop-tabs .nav-link, .other-tabs .nav-link').removeClass('active');
        $('.shop-tabs .home-tab, .other-tabs .home-tab').addClass('active');
        window.history.pushState({state:1}, "Home", "?tab=home");
        reportCarousel();
    });
    $(document).on('click', '.sell-tab-blc', function(e) {
        e.preventDefault();
        $('.other-tabs .sell-tab').click();
    });
    $(document).on('click', '.sell-tab', function(e) {
        e.preventDefault();
        $('.shop-tabs .nav-link, .other-tabs .nav-link').removeClass('active');
        $('.shop-tabs .sell-tab, .other-tabs .sell-tab').addClass('active');
        var sell_order = getSearchParams("sell-order");
        if ($.isEmptyObject(sell_order)) {
            window.history.pushState({state:1}, "Sell Products", "?tab=sell-products&sell-order=sell");
            sellProductsTab();
        } else {
            if(sell_order == "orders") {
                window.history.pushState({state:1}, "Sell Products", "?tab=sell-products&sell-order=orders");
                ordersInShop();
            } else {
                window.history.pushState({state:1}, "Sell Products", "?tab=sell-products&sell-order=sell");
                sellProductsTab();
            }
        }        
    });
    $(document).on('click', '.sell-t', function(e) {
        e.preventDefault();
        window.history.pushState({state:1}, "Sell Products", "?tab=sell-products&sell-order=sell");
        sellProductsTab();
    });
    $(document).on('click', '.order-t', function(e) {
        e.preventDefault();
        window.history.pushState({state:1}, "Sell Products", "?tab=sell-products&sell-order=orders");
        ordersInShop();
    });
    $(document).on('click', '.report-tab-blc', function(e) {
        e.preventDefault();
        $('.other-tabs .report-tab').click();
    });
    $(document).on('click', '.report-tab', function(e) {
        e.preventDefault();
        $('.shop-tabs .nav-link, .other-tabs .nav-link').removeClass('active');
        $('.shop-tabs .report-tab, .other-tabs .report-tab').addClass('active');
        var sales_opt = getSearchParams("opt");
        if ($.isEmptyObject(sales_opt)) {
            window.history.pushState({state:1}, "Sales Report", "?tab=sales-report");
        } else {
            window.history.pushState({state:1}, "Sales Report", "?tab=sales-report&opt="+sales_opt);
        }                
        $('.render-sales-report').html('<div class="my-5" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>'); // get data
        $.get("/get-data/sales-report/<?php echo $data['shop']->id; ?>", function(data){
            if (data.status == 'not have access') {
                // $('.render-sales-report').html('<?php echo $_GET["dont-have-access-in-shop"]; ?>');
                $('.render-sales-report').html(data.view);
            } else {
                $('.render-sales-report').html(data.view);
            }            
        });
    });
    $(document).on('click','.top-sr-menu .sales',function(e){
        e.preventDefault();
        $('.sales-bs').css('display','none');$('.sales-block').css('display','block');
        window.history.pushState({state:1}, "Sales Report", "?tab=sales-report");
        salesSummary(shop_id);
    });
    $(document).on('click','.top-sr-menu .sales-p',function(e){
        e.preventDefault();
        $('.sales-bs').css('display','none');$('.sales-p-block').css('display','block');
        window.history.pushState({state:1}, "Sales Report with Profit", "?tab=sales-report&opt=sales-p");
        salesWithProfit(shop_id);
    });
    $(document).on('click','.top-sr-menu .top-s-pr',function(e){
        e.preventDefault();
        $('.sales-bs').css('display','none');$('.top-s-p-block').css('display','block');
        window.history.pushState({state:1}, "Top Sold Items", "?tab=sales-report&opt=top-s-p");
        topSoldProducts(shop_id);
    });
    $(document).on('click', '.sp-date .check-g-sales', function(e) {
        e.preventDefault();
        salesWithProfit(shop_id);       
    });
    $(document).on('change', '.s-r-p .monthyear', function(e) { // this is not used
        e.preventDefault();
    });
    $(document).on('click', '.export-sales-pdf', function(e) {
        e.preventDefault();
        $('#monthYearModal').modal('toggle');
        $('.notification-body').html(
            '<div class="row">'+
            '<div class="col-12"> <h3>Chagua Mwezi wa kutoa Ripoti</h3> </div>'+
            '<div class="col-12 mt-3">'+
                '<label class="mb-1"><?php echo $_GET["month"]; ?></label>'+
                '<input name="monthyear" class="monthyear form-control" autocomplete="off" />'+
            '</div></div>');
    });
    $(document).on('click', '.export-sales-report', function(e) {
        e.preventDefault();
        var monthyear = $('.monthyear').val().split(' ').join('');
        var shopmonthyear = shop_id+"-"+monthyear;
        window.open('/pdf/sales-report/'+shopmonthyear, '_blank');      
    });
    $(document).on('click', '.export-products-pdf', function(e) {
        e.preventDefault();
        window.open('/pdf/available-products/'+shop_id, '_blank');     
    });

    $(document).on('click', '.products-tab-blc', function(e) {
        e.preventDefault();
        $('.other-tabs .products-tab').click();
    });
    $(document).on('click', '.products-tab', function(e) {
        e.preventDefault();
        $('.shop-tabs .nav-link, .other-tabs .nav-link, #Products .nav-link').removeClass('active');
        $('.shop-tabs .products-tab, .other-tabs .products-tab, #Products .products-opt').addClass('active');
        $('.products-outer-block').html('<div class="my-5" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>');
        $.get("/get-data/render-products-tab/<?php echo $data['shop']->id; ?>", function(data){
            $('.products-outer-block').html(data.view);    
            $('.pro-block.all').css('display','block');
            var tab2 = getSearchParams("tab2");
            if($.isEmptyObject(tab2)) {
                getProducts("<?php echo $data['shop']->id; ?>");
            } else {
                if(tab2 == "add-product") {
                    newProductForm();
                } else if (tab2 == "preview") {
                    var product_id = getSearchParams("pid");
                    if($.isEmptyObject(product_id)) { 
                        window.history.pushState({state:1}, "Products", "?tab=products");
                        getProducts("<?php echo $data['shop']->id; ?>");
                    } else {
                        getProductDetails(product_id);
                    }                       
                } else if (tab2 == "products-in") {
                    $(".change-products-option").val("products-in").change();
                } else if (tab2 == "product-categories") {
                    $(".change-products-option").val("product-categories").change();
                } else if (tab2 == "products-value") {
                    $(".change-products-option").val("products-value").change();
                } else if (tab2 == "manage-products") {
                    $(".change-products-option").val("manage-products").change();
                } else if (tab2 == "transfer-products") {
                    $(".change-products-option").val("transfer-products").change();
                }
            }                  
        });
    });
    $(document).on('click', '.products-tab-opt', function(e) {
        e.preventDefault();
        $(".change-products-option").val("all-products").change();
    });
    $(document).on('change', '.change-products-option', function(e) {
        e.preventDefault();
        var val = $(this).val();
        $('.pro-block').css('display','none');
        if(val == "all-products") {
            $('.pro-block.all').css('display','block');
            getProducts("<?php echo $data['shop']->id; ?>");
        }
        if(val == "products-in") {
            $('.pro-block.pin').css('display','block');
            getProductsIn("<?php echo $data['shop']->id; ?>");
        }
        if(val == "product-categories") {
            $('.pro-block.cats').css('display','block');
            renderProductCategories();
        }
        if(val == "products-value") {
            $('.pro-block.value').css('display','block');
            calculateStockValue("<?php echo $data['shop']->id; ?>");
        }
        if(val == "manage-products") {
            $('.pro-block.manage').css('display','block');
            manageProducts("<?php echo $data['shop']->id; ?>");
        }
        if(val == "transfer-products") {
            $('.pro-block.transfer').css('display','block');
            transferProducts("<?php echo $data['shop']->id; ?>");
        }
    });

    var allproducts = "";
    function getProducts(sid) {
        $('.search-p [name="pname"]').val("");
        $('[name="sfrom"]').val("all-products");
        $('.more-pr-t, .pq-select-2 .select').css('display','none');
        $('.render-products').html('<tr><td colspan="2" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<td></tr>'); // get data
        $('.pq-select-2 .loader').css('display','block');
        window.history.pushState({state:1}, "Products", "?tab=products");

        $.get("/report/products-in-shop/<?php echo $data['shop']->id; ?>", function(data){   
            $('.render-total-products').html(Number(data.totalproducts).toLocaleString("en"));
            $('.render-products, .search-block').html("");   
            $('.pq-select select, .pq-select-2 select').html('<option value="-">- <?php echo $_GET["choose-product"]; ?> -</option>');  
            $('.pq-select-2 .select').css('display','block');    $('.pq-select-2 .loader').css('display','none');
            if($.isEmptyObject(data.products)) {
                $('.render-products').html('<tr><td colspan="3" align="center"><b>-<?php echo $_GET["no-products"]; ?>-</b></td></tr>');
                $('.search-block').html('<span><i>- <?php echo $_GET["no-products"]; ?> -</i></span>');
            } else {
                allproducts = data.products;

                renderSProducts(allproducts,0,15);
                             
                for (let i = 0; i < data.products.length; i++) {
                    if(data.products[i]['quantity'] == null) { 
                        data.products[i]['quantity'] = 0;
                    }
                    $('.pq-select select, .pq-select-2 select').append('<option value="'+data.products[i]["pid"]+'">'+data.products[i]["pname"]+'</option>');
                    $('.search-block').append("<div class='product-details px-2 py-2 border' check='returnItem' pid='"+ data.products[i]['pid'] +"'>"
                        +data.products[i]['pname'] +"<span style='float:right'>"+Number(data.products[i]['rprice']).toLocaleString('en')+"/=</span></div>");
                }
            }        
        });
    }
    $(document).on('click', '.more-all-products', function(e) {
        e.preventDefault();
        $('.more-pr-t').css('display','none');
        var first = $(this).attr('lastid');
        first = Number(first) + 1;
        var last = Number(first) + 15;
        renderSProducts(allproducts,first,last);
    });

    function renderSProducts(products,start,end) {
        var msl = "";
        '<?php if(Auth::user()->company->defaultStockLevel()) { ?>'; //check for product stock level
            '<?php if(Auth::user()->company->defaultStockLevel()->status == "yes") { ?>';
                msl = "yes";
            '<?php } ?>';
        '<?php } ?>';
        
        '<?php if(Auth::user()->company->has_product_categories == "no") { ?>'; //check for product stock level
            var displaynone = "display-none";
        '<?php } else { ?>';
            var displaynone = "";
        '<?php } ?>';

        for (let i = start; i < end; i++) {
            var qs_color, cname, isCeoB = "";
            if (msl == "yes") {
                if(products[i]['msl'] >= products[i]['quantity']) {
                    qs_color = "about-finish";
                    if(products[i]['quantity'] <= 0) {
                        qs_color = "finished";
                    }
                }
            }
            var pimage = '/images/product.jpg';
            if(products[i]['pimage'] == null) { } else {
                pimage = '/images/companies/<?php echo Auth::user()->company->folder; ?>/products/'+products[i]['pimage'];
            } 
            if(products[i]['cname']) { 
                cname = products[i]['cname'];
            }
            '<?php if(Auth::user()->isCEOorAdminorBusinessOwner()) { ?>';
                isCeoB = '<span style="display:block"><small><?php echo $_GET["b-p"]; ?>/=</small> <b>'+Number(products[i]["bprice"]).toLocaleString("en")+'</b></span>';
            '<?php } ?>';
            $('.render-products').append(
                '<tr class="product-r product-details '+qs_color+'" pid="'+products[i]['pid']+'">'+
                    '<td class="first-td"><span style="display:inline-flex;">'+
                        '<img src="'+pimage+'" class="avatar mr-2" alt="">'+
                        '<span style="display: inline-block;">'+
                            '<b>'+products[i]["pname"]+'</b>'+
                            '<small class="category '+displaynone+'">'+cname+'</small>'+
                            isCeoB+'<span><small><?php echo $_GET["s-p"]; ?>/=</small> <b>'+Number(products[i]["rprice"]).toLocaleString("en")+'</b></span>'+
                '</span></span></td>'+
                '<td>'+Number(products[i]["quantity"])+'</td>'+
                '<td><b><i class="fa fa-angle-right fa-2x"></i></b></td>'
            );
            if((Number(products.length) - 1) <= i) { // terminate loop
                return;
            }
            if(i == (Number(end) - 1)) {
                $('.more-pr-t').css('display','table-row-group');
                $('.more-pr-t button').attr('lastid',i);
            }
        }
    }

    function getProductsIn(sid) {
        $('.pending-stock, .received-stock').html("<tr><td colspan='2' align='center'><i class='fa fa-spinner fa-spin'></i> Loading...</td></tr>");
        window.history.pushState({state:1}, "Products In", "?tab=products&tab2=products-in");

        var pending_stock_approval = "<?php echo Auth::user()->company->cashier_stock_approval; ?>";

        if (pending_stock_approval == "no") {
            $('.pending-stock-block').addClass('displaynone');
        } else {
            $.get("/get-data/pending-products-in/"+sid, function(data){
                $('.pending-stock').html(data.products);
            });
        }

        $('.check-pre-stock-2').click(); 
    }
    $(document).on('click', '.check-pre-stock-2', function(e){
        e.preventDefault();
        $('.received-stock').html("<tr><td>Loading...</td></tr>");
        var fromdate = $('.from-date').val();
        fromdate = fromdate.split('/').join('-');
        var todate = $('.to-date').val();
        todate = todate.split('/').join('-');
        $.get('/report-by-date-range/previous-stock-records-in-shop/'+fromdate+'/'+todate+'/<?php echo $data["shop"]->id; ?>', function(data) { 
            $('.received-stock').html("");
            if($.isEmptyObject(data.sum)) {
                $('.received-stock').html('<tr class="empty-row"><td align="center"><i>-- No new stock --</i></td></tr>');
            } else {
                for (let i = 0; i < data.sum.length; i++) {
                    $('.received-stock').append(
                        '<tr><td style="border-top:none"><div class="pb-2">'+data.sum[i]['date']+'<br> <small>Quantity Bought:</small> <b>'+Number(data.sum[i]['quantity'])+'</b> <small class="pl-2">Total Price:</small> <b>'+Number(data.sum[i]['total_price']).toLocaleString('en')+'</b></div>'
                            +'<div class="bi-'+data.sum[i]['date']+' pt-2" style="border-top:1px solid #dee2e6"></div></td>'
                    );
                }
                for (let j = 0; j < data.items.length; j++) {
                    $('.bi-'+data.items[j]['date']).append(
                        '<div class="row pb-2">'
                            +'<div class="col-9">'+data.items[j]['pname']+' <br> <b class="b_q" style="font-weight: bolder;">'+Number(data.items[j]['quantity'])+'</b><span> x </span><span>'+Number(data.items[j]['price']).toLocaleString('en')+'</span><span> = </span><span>'+Number(data.items[j]['total']).toLocaleString('en')+'</span></div>'
                            +'<div class="col-3" align="right">'
                                +'<div class="dropdown">'
                                +'<a class="btn btn-sm" href="#" role="button" id="dropdownMenuLink'+data.items[j]['nid']+'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">More <i class="fa fa-caret-down"></i></a>'
                                +'<div class="dropdown-menu py-0" aria-labelledby="dropdownMenuButton">'
                                +'<div class="p-2"> <small> <b>Added By: </b> '+data.items[j]['sent_by']+' ('+data.items[j]['sent_at']+')</small> <br> <small> <b>Received By: </b> '+data.items[j]['received_by']+' ('+data.items[j]['received_at']+')</small> </div>'
                                +'</div>'
                                +'</div>'
                            +'</div>'
                        +'</div>'
                    );
                }
            }
        });   
    });
    
    function manageProducts(sid) {
        $('.search-p [name="pname"]').val("");
        $('[name="sfrom"]').val("manage-products");
        $('.render-products-m').html('<tr><td colspan="3" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<td></tr>'); // get data
        window.history.pushState({state:1}, "Manage Products", "?tab=products&tab2=manage-products");

        $.get("/get-data/manage-products-in-shop/0", function(data){
            if (data.status == 'not have access') {
                $('.render-products-m').html('<?php echo $_GET["dont-have-access-in-shop"]; ?>');
            } else {
                $('.render-products-m').html(data.products);
            }            
        });         
    }
    function transferProducts(sid) {
        window.history.pushState({state:1}, "Transfer Products", "?tab=products&tab2=transfer-products");

        $('.pro-block.transfer').html('<div class="my-5" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>'); // get data
        $.get("/get-data/shop-transfers/"+sid, function(data){
            if (data.status == 'not have access') {
                $('.pro-block.transfer').html('<?php echo $_GET["dont-have-access-in-shop"]; ?>');
            } else {
                $('.pro-block.transfer').html(data.view);
            }            
        });
    }
    $(document).on('click', '.more-manage-products', function(e) {
        e.preventDefault();
        var lastid = $(this).attr('lastid');
        $('.more-rows-btn').css('display','none');
        $('.render-products-m').append('<tr class="load-more-rows"><td colspan="3" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<td></tr>'); 
        $.get("/get-data/manage-products-in-shop/"+lastid, function(data){
            $('.load-more-rows').css('display','none');
            $('.render-products-m').append(data.products);
        });         
    });
    $(document).on('click', '.update-m-p', function(e) {
        e.preventDefault();
        $('.full-cover').css('display','block');
        $('.full-cover .inside').html('<i class="fa fa-spinner fa-spin fa-2x"></i>');
        var pid = $(this).attr('pid');
        var shops = [];
        $('input.shopp'+pid+':checkbox:checked').each(function () {
            shops.push($(this).val());
        });
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData();
        formdata.append('pid',pid);
        formdata.append('shops',shops);
        formdata.append('status','update manage shop products');
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.full-cover').css('display','none');
                    if (data.status == "success") {
                        popNotification('success','Changes updated successful');
                    } else {
                        popNotification('warning',"Ops! System failed to update changes. Please try again");
                    }
                }
        });
    });
    $(document).on('change', '.pq-select-2 select', function(e){
        e.preventDefault();
        var pid = $(this).val();
        if(pid == "-") { } else {
            var rowid = parseFloat($('.pq-footer .check').val());
            var newid = (rowid + 1);
            $('.pq-footer .check').val(newid);
            var pname = $('.pq-select-2 select option:selected').text();
            $('.pq-list').append('<div class="form-group pb-2 pq-row-'+newid+'"><label>'+pname+'</label><input type="hidden" name="val-'+newid+'" value="'+pid+'"><input type="number" name="pq-'+newid+'-'+pid+'" class="form-control" placeholder="0" step=".01" required>'+
                        '<span class="pl-2"></span><span class="clear-pq-row p-2" rid="'+newid+'"><i class="fa fa-times"></i></span></div>'+
                        '<div class="bb-price" style="display:none"><div>1 x 20,000 = 20,000</div></div>');
            $('.pq-footer, .pq-add-pro').css('display','block');
            $('.pq-select-2').css('display','none');
            $(this).select2("val", "-");
        }
    });
    
    function calculateStockValue(sid) {
        $('.r-total-cost, .r-total-price, .r-total-profit').html('<i class="fa fa-spinner fa-spin"></i>');
        window.history.pushState({state:1}, "Products Value", "?tab=products&tab2=products-value");

        $.get("/get-data/stock-value/"+sid, function(data){
            $('.r-total-price').html(data.tp);
            $('.r-total-cost').html(data.tc);            
            $('.r-total-profit').html(data.profit);
        });          
    }

    $(document).on('click', '.create-new-product', function(e) {
        e.preventDefault();
        window.history.pushState({state:1}, "Add Product", "?tab=products&tab2=add-product");
        newProductForm();
    });
    function newProductForm() {
        $('.pro-block').css('display','none');
        $('.pro-block.new').css('display','block').html('<div align="center" class="my-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>');
        
        $.get("/get-form/new-product/shop~<?php echo $data['shop']->id; ?>", function(data){
            $('.pro-block.new').html(data.form);        
        });         
    }

    $(document).on('click', '.product-details', function(e) {
        e.preventDefault();
        var pid = $(this).attr('pid');
        window.history.pushState({state:1}, "Preview Product", "?tab=products&tab2=preview&pid="+pid);
        getProductDetails(pid);
    });
    function getProductDetails(pid) { 
        $('.pro-block').css('display','none');
        $('.pro-block.preview,.pd-loader').css('display','block');
        // $('.pro-block.preview').css('display','block').html('<div align="center" class="my-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>');
        var shop_pro = "<?php echo $data['shop']->id; ?>~"+pid;
        $.get("/get-data/product-details-tab/"+shop_pro, function(data){
            $('.pd-loader').css('display','none');
            if (data.status == 'not have access') {
                $('.pro-block.preview').html('<?php echo $_GET["dont-have-access-in-shop"]; ?>');
            } else {
                if($.isEmptyObject(data.products)) {
                    // no products in this shop
                } else {                 
                    $('.pro-actions [name="pid"]').val(data.product[0]['pid']);
                    $('.pro-actions [name="pname"]').val(data.product[0]['pname']);
                    $('.pro-actions [name="shop_product"]').val(data.product[0]['spid']);
                    $('.pro-actions .add-quantity, .pro-actions .change-quantity').attr('qty',Number(data.product[0]['quantity']));
                    $('.pro-actions .remove-from-shop, .pro-actions .delete-product').attr({'product':data.product[0]['pid'],'name':data.product[0]['pname']});
                    $('.s-desc .av_q').html(Number(data.product[0]['quantity']));
                    $('.s-desc .pname').html(data.product[0]['pname']);
                    $('.s-desc .pcname').html(data.product[0]['pcname']);
                    $('.s-desc .msl').html(Number(data.product[0]['msl']));
                    if(data.product[0]['exp']) {
                        date = data.product[0]['exp'].split(' ');
                        $('.s-desc .exp').html(date[0]);
                    } else {
                        $('.s-desc .exp').html("-");
                    }
                    $('.s-desc .bp').html(Number(data.product[0]['bprice']).toLocaleString("en"));
                    $('.s-desc .sp').html(Number(data.product[0]['sprice']).toLocaleString("en"));
                    if(data.product[0]['image']) {
                        $('.img img').attr('src','/images/companies/<?php echo Auth::user()->company->folder; ?>/products/'+data.product[0]['image']);
                    } else {
                        $('.img img').attr('src','/images/product.jpg');
                    }
                    var profit = Number(data.sales[0]['tsales']) - Number(data.sales[0]['tbuying']);
                    $('.year-summ .profit-s').html(profit.toLocaleString("en"));
                    $('.year-summ .q-in').html(Number(data.quantityIn));
                    $('.year-summ .q-sold').html(Number(data.sales[0]['quantity']));
                    $('.pro-review select').html("");    
                    for (let i = 0; i < data.products.length; i++) {
                        var selected = "";
                        if(pid == data.products[i]['pid']) {
                            selected = "selected";
                        }
                        $('.pro-review select').append('<option value="'+data.products[i]["pid"]+'" '+selected+'>'+data.products[i]["pname"]+'</option>');                        
                    }
                }
                // $('.pro-block.preview').html(data.view);  
            }                     
            $('.pshop-activities .check-i-activities').click();
        });         
    }
    $(document).on('change','.pro-review .change-product',function(e){
        e.preventDefault();
        var pid = $(this).val();
        history.replaceState({}, document.title, "?tab=products&tab2=preview&pid="+pid);
        getProductDetails(pid);
    });
    $(document).on('click','.pshop-activities .check-i-activities',function(e){
        e.preventDefault();
        $(this).prop('disabled', true).html('Checking..');
        var pid = getSearchParams("pid"); 
        var fdate = $('.pshop-activities input[name="date_fa"]').val();
        var tdate = $('.pshop-activities input[name="date_ta"]').val();
        fdate = fdate.split('/').join('-');
        tdate = tdate.split('/').join('-');
        getProductActivities(shop_id,pid,fdate,tdate);
    });
    function getProductActivities(shop_id,product_id,fdate,tdate) {          
        var shop_pro_date = shop_id+'~'+product_id+'~'+fdate+'~'+tdate;
        $('.render-activities').html('<tr class="loader"><td colspan="3"><div align="center" class="col-12 my-3"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div></td></tr>');
            
        var fulldate = fdate.split('-');
        var a = fulldate[0];
        var b = fulldate[1];  
        var c = fulldate[2];  
        var fulldate2 = tdate.split('-');
        var a2 = fulldate2[0];
        var b2 = fulldate2[1];  
        var c2 = fulldate2[2];  
        var fdate = c+'-'+b+'-'+a;
        var tdate = c2+'-'+b2+'-'+a2;
        var new_fdate = fdate;
        var new_tdate = tdate;
        
        var start = new Date(fdate);
        var end = new Date(tdate);
        var showmore = "";
        
        var loop = new Date(end);
        var thisdate;
        while(loop >= start){   
            thisdate = ("0" + (loop.getDate())).slice(-2)+'/'+("0" + (loop.getMonth() + 1)).slice(-2)+'/'+loop.getFullYear();
            thisdate2 = loop.getFullYear()+'-'+("0" + (loop.getMonth() + 1)).slice(-2)+'-'+("0" + (loop.getDate())).slice(-2);

            $('.render-activities').append("<tr class='sp-"+thisdate2+"' style='display:none'><td>"+thisdate+"</td>"
                +"<td class='d'></td>"
                +"<td class='b'>0</td>"
                +"</tr>");
            var newDate = loop.setDate(loop.getDate() - 1);
        }

        $.get("/get-data/shop-product-activities/"+shop_pro_date, function(data){
            $('.check-i-activities').prop('disabled', false).html('Check');

            var start = new Date(new_fdate);
            var end = new Date(new_tdate);
            var showmore = "";
            
            var loop = new Date(end);
            var thisdate;

            if ($.isEmptyObject(data.newstockQ) && $.isEmptyObject(data.sumQ) && $.isEmptyObject(data.trin) && $.isEmptyObject(data.adjust) && $.isEmptyObject(data.returnedQ) && $.isEmptyObject(data.trout)) {
                $('.render-activities').html('<tr><td colspan="3"><div align="center" class="col-12 my-3">- Empty Records -<div></td></tr>');
            } else {
                $('.render-activities .loader').html("");
                var avaQ = data.availableQ;
                
                while(loop >= start){   
                    thisdate = loop.getFullYear()+'-'+("0" + (loop.getMonth() + 1)).slice(-2)+'-'+("0" + (loop.getDate())).slice(-2);
                    var sumQ = newstockQ = trin = trout = adjust = returnedQ = 0;

                    const exists = data.newstockQ.some(obj => Object.values(obj).includes(thisdate));
                    const exists2 = data.sumQ.some(obj => Object.values(obj).includes(thisdate));
                    const exists3 = data.trin.some(obj => Object.values(obj).includes(thisdate));
                    const exists4 = data.adjust.some(obj => Object.values(obj).includes(thisdate));
                    const exists5 = data.returnedQ.some(obj => Object.values(obj).includes(thisdate));
                    const exists6 = data.trout.some(obj => Object.values(obj).includes(thisdate));

                    if (exists || exists2 || exists3 || exists4 || exists5 || exists6) {
                        if(exists) {
                            var i = getIndexByValue(data.newstockQ, 'date', thisdate);
                            newstockQ = Number(data.newstockQ[i].quantity);
                            $('.sp-'+thisdate).css('display','table-row');
                            $('.sp-'+thisdate+' .d').append('New stock: <b>'+Number(data.newstockQ[i].quantity)+'</b><br>');
                        }
                        if(exists2) {
                            var i = getIndexByValue(data.sumQ, 'date', thisdate);
                            sumQ = Number(data.sumQ[i].quantity);
                            $('.sp-'+thisdate).css('display','table-row');
                            $('.sp-'+thisdate+' .d').append('Sold Quantities: <b>'+Number(data.sumQ[i].quantity)+'</b><br>');
                        }
                        if(exists3) {
                            var i = getIndexByValue(data.trin, 'date', thisdate);
                            trin = Number(data.trin[i].quantity);
                            $('.sp-'+thisdate).css('display','table-row');
                            $('.sp-'+thisdate+' .d').append('Transfer In: <b>'+Number(data.trin[i].quantity)+'</b><br>');
                        }
                        if(exists4) {
                            var i = getIndexByValue(data.adjust, 'date', thisdate);
                            $('.sp-'+thisdate).css('display','table-row');
                            var val = Number(data.adjust[i].sumnQ) - Number(data.adjust[i].sumaQ);
                            adjust = val;
                            if(val < 0) {
                                $('.sp-'+thisdate+' .d').append('Negative Adjustment: <b>'+val+'</b><br>');
                            }
                            if(val > 0) {
                                $('.sp-'+thisdate+' .d').append('Positive Adjustment: <b>'+val+'</b><br>');
                            }                      
                        }
                        if(exists5) {
                            var i = getIndexByValue(data.returnedQ, 'date', thisdate);
                            returnedQ = Number(data.returnedQ[i].quantity);
                            $('.sp-'+thisdate).css('display','table-row');
                            $('.sp-'+thisdate+' .d').append('Returned Quantities: <b>'+Number(data.returnedQ[i].quantity)+'</b><br>');
                        }
                        if(exists6) {
                            var i = getIndexByValue(data.trout, 'date', thisdate);
                            trout = Number(data.trout[i].quantity);
                            $('.sp-'+thisdate).css('display','table-row');
                            $('.sp-'+thisdate+' .d').append('Transfer Out: <b>'+Number(data.trout[i].quantity)+'</b><br>');
                        }
                        
                        $('.sp-'+thisdate+' .b').html('<b>'+Number(avaQ)+'</b>');

                        avaQ = Number(avaQ) + Number(sumQ) - Number(returnedQ) - Number(newstockQ) - Number(adjust) + Number(trout) - Number(trin);
                    } else {
                        // console.log('No activity');
                    }
                    
                    var newDate = loop.setDate(loop.getDate() - 1);
                }
            }        
        });
    }
    function getIndexByValue(array, key, value) {
        return array.findIndex(obj => obj[key] === value);
    }
    $(document).on('click','.pro-sales-tab',function(e){
        e.preventDefault();
        var check = $('.psales-form input[name="check-pro-sales"]').val();
        if(check == 0) {
            $('.psales-form input[name="check-pro-sales"]').val(1);
            $('.psales-form .check-i-sales').click();
        } 
    });
    $(document).on('click','.psales-form .check-i-sales',function(e){
        e.preventDefault();  
        var pid = getSearchParams("pid");
        var fdate = $('.psales-form .from-date3').val();
        var tdate = $('.psales-form .to-date3').val();
        fdate = fdate.split('/').join('-');
        tdate = tdate.split('/').join('-');
        $('.totalIQ').html("--");
        $('.totalIA').html("--");
        $('.totalIP').html("--");
        getProductSales(shop_id,pid,fdate,tdate);
    });
    function getProductSales(shop_id,product_id,fdate,tdate) {          
        var shop_pro_date = shop_id+'~'+product_id+'~'+fdate+'~'+tdate;
        $('.sales-item-report').html('<tr><td colspan="4"><div align="center" class="col-12 my-3"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div></td></tr>');
        $.get("/get-data/shop-product-sales/"+shop_pro_date, function(data){
            
            $('.sales-item-report').html("");
            if($.isEmptyObject(data.sales)) {
                $('.totalIQ, .totalIA, .totalIP').html("0");
                $('.sales-item-report').html('<tr><td colspan="4" align="center"><i>-- Empty records --</i></td></tr>');
            } else {
                var display_none = "display-none";
                "<?php if(Auth::user()->isBusinessOwner()) { ?>";
                    display_none = "";
                "<?php } ?>"

                var tprofit = Number(data.total[0]['tsales']) - Number(data.total[0]['tbuying']);
                $('.totalIQ').html(Number(data.total[0]['quantity']));
                $('.totalIA').html(Number(data.total[0]['tsales']).toLocaleString("en"));
                $('.totalIP').html(tprofit.toLocaleString("en"));

                for (let i = 0; i < data.sales.length; i++) {
                    var bdate = data.sales[i]['date'].split('-');
                    var date = bdate[2]+"/"+bdate[1]+"/"+bdate[0];
                    var profit = Number(data.sales[i]['tsales']) - Number(data.sales[i]['tbuying']);
                    $('.sales-item-report').append('<tr><td>'+date+'</td><td>'+Number(data.sales[i]["quantity"])+'</td><td>'+Number(data.sales[i]["tsales"]).toLocaleString("en")+'</td><td class="'+display_none+'">'+profit.toLocaleString("en")+'</td></tr>');
                }
            }          
        });
    }

    function getShopProductDetails(shop_id,product_id) { // not in use
        var shop_pro = shop_id+'~'+product_id;
        $('.render-product-details').html('<div align="center" class="col-12 my-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>');
        $.get("/get-data/product-details-report/"+shop_pro, function(data){
            if (data.status == 'not have access') {
                $('.render-product-details').html('<?php echo $_GET["dont-have-access-in-shop"]; ?>');
            } else {
                $('.render-product-details').html(data.view);
                var hash = location.hash;
                if(hash == "#add-quantity") {
                    $('.pro-actions .add-quantity').click();
                }
            }  
            $('.pshop-activities .check-i-activities').click();
        });      
    }
    function productsInOut(shop_id,product_id) {  // not in use  
        var shop_pro = shop_id+'~'+product_id;
        $('.render-product-in-out').html('<div align="center" class="col-12 my-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>');
        $.get("/get-data/product-in-out-tab/"+shop_pro, function(data){
            $('.render-product-in-out').html(data.view);
            productSales(shop_id,product_id);
        });
    }
    function productSales(shop_id,product_id) {   // not in use       
        var shop_pro = shop_id+'~'+product_id;
        $('.render-product-sales').html('<div align="center" class="col-12 my-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>');
        $.get("/get-data/product-sales-tab/"+shop_pro, function(data){
            $('.render-product-sales').html(data.view);
        });
    }

    $(document).on('click', '#Products .products-opt', function(e) {
        e.preventDefault();   
        $('.shop-tabs .nav-tabs-new .products-tab').click();     
    });
    $(document).on('click', '#Products .cats-opt', function(e) {
        e.preventDefault();
        window.history.pushState({state:1}, "Product Categories", "?tab=products&opt=categories");
        renderProductCategoriesTab();
    });
    $(document).on('click','.view-products-of-category',function(e){
        e.preventDefault();
        var cid = $(this).attr('cid');
        var cname = $(this).attr('cname');
        
        $('.notification-body').html('<div class="row mb-2" align="left"><div class="col-md-10 offset-md-1"><h6 class="mb-3"><?php echo $_GET["products-created-under"]; ?> '+cname+'</h6>'+
                    '<div class="col-12 pl-0 pr-0 mt-5">'+
                        '<div class="my-5"><ol class="render-products-of-category"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...</ol><div>'+
                    '</div></div>');
        
        $('#notificationModal').modal('toggle');
        
        $.get("/get-data/products-of-category/"+cid, function(data){
            if(data.status == "available") {
                $('.render-products-of-category').html(data.items);
            } else {
                $('.render-products-of-category').html('<div><td colspan="4" align="center"><i>-- <?php echo $_GET["no-product-created"]; ?> --</i></td></div>');
            }                
        });
    });
    $(document).on('click','.edit-pcategory-btn',function(e){
        e.preventDefault();
        var cid = $(this).attr('cid');
        var cname = $(this).attr('cname');
        
        $('.notification-body').html('<div class="row mb-2" align="left"><div class="col-md-8 offset-md-2"><h5 class="mb-3"><?php echo $_GET["edit-category-name"]; ?></h5><label>Kategori</label>'+
                    '<input type="text" class="form-control form-control-sm" placeholder="Jina" name="cname" value="'+cname+'" required="">'+
                    '<div class="col-12 pl-0 pr-0 mt-5">'+
                        '<div class="mb-2"><button class="btn btn-outline-secondary" data-dismiss="modal" aria-label="Close"> <?php echo $_GET["cancel"]; ?></button><button class="btn btn-info ml-2 submit-edit-pcategory" cid="'+cid+'"> <?php echo $_GET["update"]; ?></button></div>'+
                    '</div></div>');
        
        $('#notificationModal').modal('toggle');
    });
    function renderProductCategories() {
        $('.render-pro-categories').html('<tr><td align="center" colspan="2"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...</td></tr>');
        window.history.pushState({state:1}, "Product Categories", "?tab=products&tab2=product-categories");

        $.get("/get-data/product-categories/all", function(data){
            $('.render-pro-categories').html(data.pcategories);        
        });         
    }    
    function renderProductCategoriesTab() { // this function is not used for now 
        $('.shop-tabs .nav-link, .other-tabs .nav-link, .shop-tab-conten .tab-pane, #Products .nav-link').removeClass('active');
        $('.shop-tabs .products-tab, .other-tabs .products-tab, #Products, #Products .products-outer-block, #Products .cats-opt').addClass('active');
        $('.products-outer-block').html('<div align="center" class="my-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>');
        
        $.get("/get-data/product-categories-tab/<?php echo $data['shop']->id; ?>", function(data){
            $('.products-outer-block').html(data.pcategories);        
        });         
    }    

    $(document).on('click', '#Products .quantity-opt', function(e) {
        e.preventDefault();
        window.history.pushState({state:1}, "Products In", "?tab=products&opt=products-in");
        renderProductsIn();
    });
    function renderProductsIn() {
        $('.shop-tabs .nav-link, .other-tabs .nav-link, .shop-tab-conten .tab-pane, #Products .nav-link').removeClass('active');
        $('.shop-tabs .products-tab, .other-tabs .products-tab, #Products, #Products .products-outer-block, #Products .quantity-opt').addClass('active');
        $('.products-outer-block').html('<div align="center" class="my-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>');
        
        $.get("/get-data/get-products-in-tab/<?php echo $data['shop']->id; ?>", function(data){
            $('.products-outer-block').html(data.view);        
        });         
    }
    $(document).on('click', '.pending-items .edit-added-quantity', function(e) {
        e.preventDefault();
        var stock_id = $(this).attr('val');
        var pname = $(this).attr('pname');
        var pqty = $(this).attr('qty');
        
        $('#notificationModal').modal('toggle');
        $('.notification-body').html('<div class="row change-a-q">'+
                    '<div class="col-12"> Change Quantity you Added of <b>'+pname+'</b> </div>'+
                    '<div class="col-12 mt-3">'+
                        '<div><?php echo $_GET["quantity-full"]; ?> <br> <input type="number" name="qty" class="form-control" placeholder="0" value="'+pqty+'" style="width:100px">'+
                        '<div class="col-12 mb-2 mt-3"><button class="btn btn-outline-secondary" data-dismiss="modal" aria-label="Close"> <?php echo $_GET["cancel"]; ?></button><button class="btn btn-info confirm-change-added-quantity ml-2" sid="'+stock_id+'"><i class="fa fa-check pr-2"></i> <?php echo $_GET["change"]; ?></button></div>'+
                    '</div></div>');
    });
    $(document).on("click", ".confirm-change-added-quantity", function(e) {
        e.preventDefault();
        var stock_id = $(this).attr('sid');
        var quantity = $('.change-a-q [name="qty"]').val();
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData();
        formdata.append('id',stock_id);
        formdata.append('quantity',quantity);
        formdata.append('status','change added stock quantity');
        $('.notification-body').html('<div align="center" class="my-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Updating...<div>');
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    if (data.status == "success") {
                        $('#notificationModal').modal('hide');
                        $('.pq-'+data.id).html(data.quantity);
                        $('.pp-'+data.id).html(data.totalp);
                        popNotification('success','Successful quantity updated');
                    } else {
                        popNotification('warning',"Ops! System failed to update quantity. Please try again");
                    }
                }
        });
    });    
    
    $(document).on('click','.pending-items .delete-added-quantity',function(e){
        e.preventDefault();
        var stock_id = $(this).attr('val');
        var pname = $(this).attr('pname');
        $('.notification-body').html('<div class="row">'+
                    '<div class="col-12"><i class="fa fa-warning fa-2x text-warning"></i> <br> Please confirm that you are removing <b>'+pname+'</b> from added products <br>'+
                    '<div class="col-12 mt-5">'+
                        '<div class="mb-2"><button class="btn btn-danger confirm-delete-added-quantity" sid="'+stock_id+'"><i class="fa fa-trash pr-2"></i> <?php echo $_GET["delete"]; ?></button><button class="btn btn-outline-secondary ml-2" data-dismiss="modal" aria-label="Close"> <?php echo $_GET["cancel"]; ?></button></div>'+
                    '</div></div>');
        
        $('#notificationModal').modal('toggle');
    });
    $(document).on('click','.confirm-delete-added-quantity',function(e){
        e.preventDefault();
        $('.notification-body').html('<div align="center" class="my-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Removing...<div>');
        
        var sid = $(this).attr('sid');

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData();
        formdata.append('id',sid);
        formdata.append('status','added stock quantity');
        $.ajax({
            type: 'POST',
            url: '/delete',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    if (data.status == "success") {
                        $('#notificationModal').modal('hide');
                        popNotification('success','Item  removed from list successfully');
                        $('.pqr-'+data.id).closest("tr").remove();
                    } else {
                        popNotification('warning',"Error! System failed to remove item from list.");
                    }
                }
        });              
    });
    $(document).on('click', '.pending-items .receive-added-quantity', function(e) {
        e.preventDefault();
        var id = $(this).attr('val');
        $('.pi-'+id).html('<i class="fa fa-spinner fa-spin"></i>');
        $.get('/new-stock/receive/'+id, function(data){
            if (data.success) { 
                popNotification('success','Products received successfully.');
                $('.pi-'+id).html("Received").css('color','green');  
            }
            if (data.error) {
                popNotification('warning',data.error);
            }
        });
    });

    $(document).on('click', '.submit-edit-pcategory', function(e) {
        e.preventDefault();
        $(this).prop('disabled', true).html('Submiting..');
        var cid = $(this).attr('cid');
        var cname = $('.notification-body [name="cname"]').val();
        
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData();
        formdata.append('id',cid);
        formdata.append('name',cname);
        formdata.append('check',"checked");
        $.ajax({
            type: 'POST',
            url: '/edit-p-category',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.submit-edit-pcategory').prop('disabled', false).html('Submit');
                    if (data.success) {
                        popNotification('success',data.success);
                        $('#notificationModal').modal('hide');
                        renderProductCategories();
                    } else {
                        popNotification('warning',"Sorry! System failed to update category. Please try again.");
                    }
                }
        });
    });
    
    $(document).on('click','.delete-p-category',function(e){
        e.preventDefault();
        var cname = $(this).attr('cname');
        var cid = $(this).attr('cid');
        $('.notification-body').html('<div class="row">'+
                    '<div class="col-12"><i class="fa fa-warning fa-2x text-warning"></i> <br> Please confirm that you are deleting <b>'+cname+'</b> <br>'+
                        'By deleting this, All the products created under this category will be deleted too. </div>'+
                    '<div class="col-12 mt-5">'+
                        '<div class="mb-2"><button class="btn btn-danger confirm-delete-p-category" cid="'+cid+'" cname="'+cname+'"><i class="fa fa-trash pr-2"></i> <?php echo $_GET["delete"]; ?></button><button class="btn btn-outline-secondary ml-2" data-dismiss="modal" aria-label="Close"> <?php echo $_GET["cancel"]; ?></button></div>'+
                    '</div></div>');
        
        $('#notificationModal').modal('toggle');
    });
    $(document).on('click','.confirm-delete-p-category',function(e){
        e.preventDefault();
        $('.notification-body').html('<div align="center" class="my-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Deleting...<div>');
        
        var id = $(this).attr('cid');
        var name = $(this).attr('cname');

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData();
        formdata.append('id',id);
        formdata.append('name',name);
        formdata.append('status','sub category');
        $.ajax({
            type: 'POST',
            url: '/delete',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    if (data.status == "success") {
                        $('#notificationModal').modal('hide');
                        popNotification('success','Category is deleted successfully');
                        renderProductCategories(); 
                    } else {
                        popNotification('warning',"Error! Something went wrong, Category failed to delete.");
                    }
                }
        });              
    });

    $(document).on('click', '.stock-tab-blc', function(e) {
        e.preventDefault();
        $('.other-tabs .stock-tab').click();
    });
    $(document).on('click', '.stock-tab', function(e) {
        e.preventDefault();
        $('.shop-tabs .nav-link, .other-tabs .nav-link').removeClass('active');
        $('.shop-tabs .stock-tab, .other-tabs .stock-tab').addClass('active');
        window.history.pushState({state:1}, "Stock", "?tab=stock");
        $('.render-stock-report').html('<div class="mt-3" align="center">Loading...</div>'); // get data
        $.get("/get-data/stock-report/<?php echo $data['shop']->id; ?>", function(data){
            if (data.status == 'not have access') {
                $('.render-stock-report').html('<?php echo $_GET["dont-have-access-in-shop"]; ?>');
            } else {
                $('.render-stock-report').html(data.view);
            }            
        });
    });
    $(document).on('click', '.expenses-tab-blc', function(e) {
        e.preventDefault();
        $('.other-tabs .expenses-tab').click();
    });
    $(document).on('click', '.expenses-tab', function(e) {
        e.preventDefault();
        $('.shop-tabs .nav-link, .other-tabs .nav-link').removeClass('active');
        $('.shop-tabs .expenses-tab, .other-tabs .expenses-tab').addClass('active');
        window.history.pushState({state:1}, "Expenses", "?tab=expenses");
        $('.render-expenses').html('<div class="my-5" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>'); // get data
        $.get("/get-data/shop-expenses/<?php echo $data['shop']->id; ?>", function(data){
            if (data.status == 'not have access') {
                $('.render-expenses').html('<?php echo $_GET["dont-have-access-in-shop"]; ?>');
            } else {
                $('.render-expenses').html(data.view);
            }            
        });
    });
    
    $(document).on('click','.edit-expense',function(e){
        e.preventDefault();
        var eid = $(this).attr('eid');
        var ename = $(this).attr('ename');
        
        $('.notification-body').html('<div class="row mb-2" align="left"><div class="col-md-8 offset-md-2"><h5 class="mb-3"><?php echo $_GET["edit-expense"]; ?></h5><label><?php echo $_GET["name"]; ?></label>'+
                    '<input type="text" class="form-control" placeholder="Jina" name="ename" value="'+ename+'" required="">'+
                    '<div class="col-12 pl-0 pr-0 mt-5">'+
                        '<div class="mb-2"><button class="btn btn-outline-secondary" data-dismiss="modal" aria-label="Close"> <?php echo $_GET["cancel"]; ?></button><button class="btn btn-info submit-edit-expense ml-2" eid="'+eid+'"> <?php echo $_GET["update"]; ?></button></div>'+
                    '</div></div>');
        
        $('#notificationModal').modal('toggle');
    });
    $(document).on('click', '.submit-edit-expense', function(e) {
        e.preventDefault();
        $(this).prop('disabled', true).html('Submiting..');
        var eid = $(this).attr('eid');
        var ename = $('.notification-body [name="ename"]').val();
        
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData();
        formdata.append('id',eid);
        formdata.append('name',ename);
        formdata.append('status',"update expense name");
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.submit-edit-expense').prop('disabled', false).html('<?php echo $_GET["update"]; ?>');
                    if (data.status == "success") {
                        popNotification('success',"Success! Expense name updated successfully.");
                        $('#notificationModal').modal('hide');
                        $('select.expense option[value="'+data.id+'"]').text(data.name);
                        getSExpenses();
                    } else {
                        popNotification('warning',"Sorry! System failed to update expense name. Please try again.");
                    }
                }
        });
    });
    $(document).on('click','.delete-expense',function(e){
        e.preventDefault();
        var ename = $(this).attr('ename');
        var eid = $(this).attr('eid');
        $('.notification-body').html('<div class="row">'+
                    '<div class="col-12"><i class="fa fa-warning fa-2x text-warning"></i> <br> Please confirm that you are deleting <b>'+ename+'</b> <br>'+
                        '</div>'+
                    '<div class="col-12 mt-5">'+
                        '<div class="mb-2"><button class="btn btn-outline-secondary" data-dismiss="modal" aria-label="Close"> <?php echo $_GET["cancel"]; ?></button><button class="btn btn-danger ml-2 confirm-delete-expense" eid="'+eid+'" ename="'+ename+'"><i class="fa fa-trash pr-2"></i> <?php echo $_GET["delete"]; ?></button></div>'+
                    '</div></div>');
        
        $('#notificationModal').modal('toggle');
    });
    $(document).on('click','.confirm-delete-expense',function(e){
        e.preventDefault();
        $('.notification-body').html('<div align="center" class="my-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Deleting...<div>');
        
        var id = $(this).attr('eid');
        var name = $(this).attr('ename');

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData();
        formdata.append('id',id);
        formdata.append('name',name);
        formdata.append('status','expense name');
        $.ajax({
            type: 'POST',
            url: '/delete',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    if (data.status == "success") {
                        $('#notificationModal').modal('hide');
                        popNotification('success','Expense name is deleted successfully');
                        $('select.expense').children('option[value="'+data.id+'"]').remove();
                        getSExpenses();
                    } else {
                        popNotification('warning',"Error! Something went wrong, Expense name failed to delete.");
                    }
                }
        });              
    });
    
    $(document).on('click','.editExpense',function(e){
        e.preventDefault();
        var id = $(this).attr('val');
        $('.eexpense').val(null).trigger('change');
        $('input[name="row_id"]').val(null);
        $('input[name="eamount"]').val(null);
        $('textarea[name="edescription"]').val(null);
        $('#editExpense').modal('toggle');
        $.get('/expenses-by-id/'+id, function(data) {
            $('input[name="row_id"]').val(data.data.id);
            $('.eexpense').val(data.data.expenseid).trigger('change');
            $('input[name="eamount"]').val(data.data.amount);
            $('textarea[name="edescription"]').val(data.data.description);
        });
    });

    $(document).on("submit", ".expense-record", function(e) {
        e.preventDefault();
        $('.expense-record-btn').prop('disabled', true).html('Submitting..');
        $('input, textarea, select').removeClass('parsley-error');
        var expense_id = $('.expense-record [name="expense_id"]');
        var amount = $('.expense-record [name="amount"]');

        if (expense_id.val() == null || expense_id.val() == '' || amount.val().trim() == null || amount.val().trim() == '') {
            $('.expense-record-btn').prop('disabled', false).html('Submit'); }
        if (expense_id.val() == null || expense_id.val() == '') {
            expense_id.addClass('parsley-error').focus(); return;}
        if (amount.val().trim() == null || amount.val().trim() == '') {
            amount.addClass('parsley-error').focus(); return;}

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        formdata.append('status','expense-record');
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.expense-record-btn').prop('disabled', false).html('Submit');
                    if (data.status == "success") {
                        popNotification('success',"Success! expense has been recorded successfully.");
                        var exp_date = $('.expense-date').val();
                        $('.expense-record')[0].reset();
                        $('.expense-date').val(exp_date);
                        $('.select2').val('').change();
                        var month = $(".this-m-2 option:selected").val();
                        var year = $(".this-y-2 option:selected").val();
                        var date = $(".this-d-2 option:selected").val();
                        $('.check-r-expenses').click();     
                        
                        if(data.data.predate == "no") { } else { // check if it is previous date, then go to update daily sales table 
                            $.get('/update/daily-sales/'+shop_id+'~'+data.data.predate, function(data){     
                                console.log('daily sales updated');
                            });
                        }                   
                    } else {
                        popNotification('warning',"Error! expense fails to submit, please try again.");
                    }
                }
        });
    });
    
    $(document).on("submit", ".edit-expense-cost", function(e) {
        e.preventDefault();
        $('.edit-expense-cost button').prop('disabled', true).html('Submitting..');

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        formdata.append('status','edit-submitted-expense');
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.edit-expense-cost button').prop('disabled', false).html('Submit');
                    if (data.status == "success") {
                        $('#editExpense').modal('hide');
                        popNotification('success',"Success! expense has been updated.");                        
                        $('.check-r-expenses').click();     
                        
                        if(data.data.predate == "no") { } else { // check if it is previous date, then go to update daily sales table 
                            $.get('/update/daily-sales/'+shop_id+'~'+data.data.predate, function(data){     
                                console.log('daily sales updated');
                            });
                        }                   
                    } else {
                        popNotification('warning',"Error! expense fails to update, please try again.");
                    }
                }
        });
    });

    $(document).on('click','.deleteExpense',function(e){
        e.preventDefault();
        if(confirm("Click OK to confirm that you remove this expense.")){
            e.preventDefault();
            var id = $(this).attr('val');

            $.get('/delete-expense/'+id, function(data) {
                popNotification('success',"Success! expense is deleted successfully.");
                var month = $(".this-m-2 option:selected").val();
                var year = $(".this-y-2 option:selected").val();
                var date = $(".this-d-2 option:selected").val();
                // getDatesRange(date,month,year); 
                $('.check-r-expenses').click(); 
                
                if(data.data.predate == "no") { } else { // check if it is previous date, then go to update daily sales table 
                    $.get('/update/daily-sales/'+shop_id+'~'+data.data.predate, function(data){     
                        console.log('daily sales updated');
                    });
                }                         
            });            
        }
        return;
    });

    $(document).on('click', '.customers-tab-blc', function(e) {
        e.preventDefault();
        $('.other-tabs .customers-tab').click();
    });
    $(document).on('click', '.customers-tab', function(e) {
        e.preventDefault();
        $('.shop-tabs .nav-link, .other-tabs .nav-link').removeClass('active');
        $('.shop-tabs .customers-tab, .other-tabs .customers-tab').addClass('active');
        window.history.pushState({state:1}, "Customers", "?tab=customers");
        $('.render-customers').html('<div class="my-5" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>'); // get data
        $.get("/get-data/shop-customers/<?php echo $data['shop']->id; ?>", function(data){
            if (data.status == 'not have access') {
                $('.render-customers').html('<?php echo $_GET["dont-have-access-in-shop"]; ?>');
            } else {
                $('.render-customers').html(data.view);
            }            
        });
    });
    $(document).on('click', '.edit-customer-btn', function(e) {
        e.preventDefault();
        var cid = $(this).attr('cid');
        var cname = $(this).attr('cname');
        var cgender = $(this).attr('cgender');
        var cphone = $(this).attr('cphone');
        var clocation = $(this).attr('clocation');
        $('#editCustomer').modal('toggle');
        $('.edit-customer-form').attr('customer',cid);
        $('#editCustomer input[name="name"]').val(cname);
        $('#editCustomer input[name="phone"]').val(cphone);
        $('#editCustomer input[name="location"]').val(clocation);
        $('#editCustomer .gender').val(cgender);
    });
    $(document).on('click', '.delete-customer', function(e){
        e.preventDefault();
        var cname = $(this).attr('cname');
        if(confirm("Click OK to confirm that you delete "+cname+" customer.")){
            $('.full-cover').css('display','block');
            $('.full-cover .inside').html('Deleting...');
            var cid = $(this).attr('cid');

            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            var formdata = new FormData();
            formdata.append('cid',cid);
            formdata.append('cname',cname);
            formdata.append('status','customer');
            $.ajax({
                type: 'POST',   
                url: '/delete',
                processData: false,
                contentType: false,
                data: formdata,
                success: function(data) {
                    $('.full-cover').css('display','none');
                    if (data.error) {
                        popNotification('warning',"Error! Something went wrong, please try again later.");
                    } else {
                        popNotification('success',"Success! "+data.cname+" is deleted successfully.");
                        // $(".c-"+data.cid).closest("tr").remove();
                        $('.shop-tabs .nav-tabs-new .customers-tab').click();
                    }
                }
            });
        }
        return;
    });
    $(document).on('click', '.deleted-customers', function(e){
        e.preventDefault();        
        $('#deletedCustomers').modal('toggle');
        $('.list-deleted-customers').html('<div align="center"><i class="fa fa-spinner fa-spin pr-2"></i> Loading..</div>');
        $.get("/get-data/deleted-customers/<?php echo $data['shop']->id; ?>", function(data){
            $('.list-deleted-customers').html("");
            if ($.isEmptyObject(data.customers)) {
                $('.list-deleted-customers').html('<div align="center">- Hakuna mteja -</div>');
            } else {              
                for (let i = 0; i < data.customers.length; i++) {
                    $('.list-deleted-customers').append('<div class="row pb-1"><div class="col-9">'
                        +'<div><b>'+data.customers[i]["name"]+'</b></div>'
                        +'<div><small>'+data.customers[i]["location"]+' ('+data.customers[i]["phone"]+')</small></div></div>'
                        +'<div class"col-3"><button class="btn btn-info btn-sm mt-2 restore-customer" cid="'+data.customers[i]["id"]+'"><?php echo $_GET["restore"]; ?> <i class="fa fa-undo pl-1"></i></button></div></div>');
                }
            }                 
        });
    });
    $(document).on('click', '.restore-customer', function(e){
        e.preventDefault();        
        var cid = $(this).attr('cid');
        $('.restore-customer').prop('disabled', true);
        $(this).html('<i class="fa fa-spinner fa-spin px-1"></i>');
        $.get("/get-data/restore-customer/"+cid, function(data){
            $('#deletedCustomers').modal('hide'); 
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            $('.shop-tabs .nav-tabs-new .customers-tab').click();
        });
    });
    $(document).on('click', '.more-customers', function(e) {
        e.preventDefault();
        var lastid = $(this).attr('lastid');
        $('.more-cust-tr').css('display','none');
        $('.customers-tbody').append('<tr class="cust-load"><td colspan="3" align="center" class="py-2"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...</td></tr>'); 
        $.get("/get-data/more-shop-customers/<?php echo $data['shop']->id; ?>~"+lastid, function(data){
            $('.cust-load').css('display','none');
            $.when( $('.customers-tbody').append(data.view) ).done(function() {
                $.each( data.data.customers, function( key, value ) {
                    console.log( key + ": " + value.id );
                    var data2 = "<?php echo $data['shop']->id; ?>~"+value.id;
                    $.get('/available-debt/customer/'+data2, function(data3) {    
                        $('.ddb-'+data3.id).html(data3.total);
                    }); 
                });
            });
                
        });
    });
    $(document).on('click', '.customer-row', function(e) {
        e.preventDefault();
        var cid = $(this).attr('cid');
        getCustomerDetails(cid);
    });
    function getCustomerDetails(customer_id) {
        window.history.pushState({state:1}, "Customer Preview", "?tab=customers&customer_id="+customer_id);
        $('.shop-tabs .nav-link, .other-tabs .nav-link, .shop-tab-conten .tab-pane, #Products .nav-link').removeClass('active');
        $('.shop-tabs .customers-tab, .other-tabs .customers-tab, #Customers, #Products .products-outer-block').addClass('active');
        $('.render-customers').html('<div class="my-5" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>');
        $.get("/get-data/get-customer/<?php echo $data['shop']->id; ?>/"+customer_id, function(data){
            if (data.status == 'not have access') {
                $('.render-customers').html('<?php echo $_GET["dont-have-access-in-shop"]; ?>');
            } else {
                $('.render-customers').html(data.view);
            }            
        });
    }
    $(document).on('click', '.debt-rec-btn', function(e){ // this is not used now
        e.preventDefault();
        $('.cname').html($(this).text());
        var customer_id = $(this).attr('cid');
        var fdate = $('input[name="date_f"]').val();
        var tdate = $('input[name="date_t"]').val();
        fdate = fdate.split('/').join('-');
        tdate = tdate.split('/').join('-');
        // var shop_id = $('.change-shop2').val();
        getDebtRecords(fdate,tdate,customer_id,shop_id);
    });
    $(document).on('click', '.view-bought-items', function(e){
        e.preventDefault();
        var sdate = $(this).attr('sdate');
        var customer_id = $(this).attr('cid');
        var cname = $(this).attr('cname');
        var s = sdate.split('-');
        $('.notification-body').html('<div class="row mb-2" align="left"><div class="col-md-10 offset-md-1"><h6 class="mb-3"><?php echo $_GET["products-bought-by"]; ?> '+cname+'<br>'+s[2]+'-'+s[1]+'-'+s[0]+'</h6>'+
                    '<div class="col-12 pl-0 pr-0 mt-5">'+
                        '<div class="my-5"><ol class="render-b-products pl-3"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...</ol><div>'+
                    '</div></div>');
        
        $('#notificationModal').modal('toggle');
        $.get('/get-data/customer-bought-items/'+shop_id+'~'+customer_id+'~'+sdate, function(data){ 
            if($.isEmptyObject(data.output)) {
                $('.render-b-products').html('<span><i>-- <?php echo $_GET["empty-records"]; ?> --</i></span>');
            } else {
                $('.render-b-products').html(data.output);
            }            
        });
    });
    $(document).on('submit', '.kopesha-form', function(e){
        e.preventDefault();
        $('.kopesha-btn').prop('disabled', true).html('submitting..');
        $('select, input').removeClass('parsley-error');
        var shop_id = $('.shop-k-h').val();
        var purpose = $('.purpose').val();
        var amount = $('input[name="kopesha_amount"]').val();
        var customer_id = $('input[name="customer_id"]').val();
        if (shop_id.trim() == null || shop_id.trim() == '' || amount.trim() == null || amount.trim() == '' || amount.trim() < 0) {
            $('.kopesha-btn').prop('disabled', false).html('Submit');
        }
        if (shop_id.trim() == null || shop_id.trim() == '') {
            $('.shop-k-h').addClass('parsley-error').focus(); return;}
        if (amount.trim() == null || amount.trim() == '' || amount.trim() < 0) {
            $('input[name="kopesha_amount"]').addClass('parsley-error').focus(); return;}

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        formdata.append('status','kopesha pesa');
        formdata.append('customer_k_h',customer_id);
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.kopesha-btn').prop('disabled', false).html('Submit');
                    if (data.error) {
                        popNotification('warning',data.error);
                    } else {
                        popNotification('success',data.success);
                        $('.kopesha-form')[0].reset();
                        $('.modal').modal('hide');      
                        getDebtRecords(customer_id,shop_id);
                    }
                }
        });
    });

    $(document).on('submit', '.lipa-hela-form', function(e){
        e.preventDefault();
        $('.lipa-hela').prop('disabled', true).html('adding..');
        $('select, input').removeClass('parsley-error');
        var shop_id = $('.shop-l-h').val();
        var amount = $('input[name="lipa-amount"]').val();
        var customer_id = $('input[name="customer_id"]').val();
        if (shop_id.trim() == null || shop_id.trim() == '' || amount.trim() == null || amount.trim() == '' || amount.trim() < 0) {
            $(this).prop('disabled', false).html('Add Payment');
        }
        if (shop_id.trim() == null || shop_id.trim() == '') {
            $('.shop-l-h').addClass('parsley-error').focus(); return;}
        if (amount.trim() == null || amount.trim() == '' || amount.trim() < 0) {
            $('input[name="lipa-amount"]').addClass('parsley-error').focus(); return;}

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        formdata.append('status','lipa hela');
        formdata.append('customer_l_h',customer_id);
        formdata.append('amount',amount);
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.lipa-hela').prop('disabled', false).html('Submit');
                    if (data.error) {
                        popNotification('warning',data.error);
                    } else {
                        popNotification('success',data.success);
                        $('.lipa-hela-form')[0].reset();
                        $('.modal').modal('hide');      
                        getDebtRecords(customer_id,shop_id);
                    }
                }
        });
    });
    $(document).on('click', '.edit-aliweka', function(e) {
        e.preventDefault();
        var amount = $(this).attr('amount');
        var sdate = $(this).attr('sdate');
        var customer = $(this).attr('customer');
        $('#notificationModal .close').css('display','none');

        $('.notification-body').html('<div class="row mb-2" align="left"><div class="col-md-9 offset-md-2"><h5 class="mb-4"><?php echo $_GET["change-deposited-amount"]; ?></h5>'+
            '<div class="render-cus-paid-amount"><div class="my-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...</div></div>'+
            '<div class="mt-5" align="right"><button type="button" class="btn btn-outline-danger close-cus-changes" data-dismiss="modal">CLOSE</button><button class="btn btn-success done-cus-changes" style="display:none"><i class="fa fa-check"></i> Done</button></div>'+
        '</div></div>');

        $('#notificationModal').modal('toggle');

        $.get("/get-data/cus-paid-amount/<?php echo $data['shop']->id; ?>~"+sdate+"~"+customer, function(data){
            $('.render-cus-paid-amount').html("");
            $.each( data.data.cus_desc, function( key, value ) {
                $('.render-cus-paid-amount').append('<div class="mb-2 cus-p-'+value.id+'">'
                    +'<input type="number" class="form-control" style="width:150px;display:inline" name="ec-amount-'+value.id+'" value="'+value.amount_paid+'" required="">'
                    +'<button class="btn btn-info ml-2 submit-cp-amount" eid="'+value.id+'"> <?php echo $_GET["update"]; ?></button>'
                    +'<button class="btn btn-danger ml-1 delete-cp-amount" eid="'+value.id+'"> <?php echo $_GET["delete"]; ?></button>'
                +'</div>');
            });
        });     
    });    
    $(document).on('click', '.submit-cp-amount', function(e) {
        e.preventDefault();
        var eid = $(this).attr('eid');
        var amount = $('[name="ec-amount-'+eid+'"]').val();
        $('button').prop('disabled', true);
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData();
        formdata.append('status','update weka pesa');
        formdata.append('eid',eid);
        formdata.append('amount',amount);
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('button').prop('disabled', false);
                    if (data.status == "success") {
                        popNotification('success',"Amount updated successfully.");
                        $('.close-cus-changes').css('display','none');$('.done-cus-changes').css('display','');
                    } else {
                        popNotification('warning',"Oops! Failed to updated mout");                        
                    }
                }
        });
    });
    $(document).on('click', '.delete-cp-amount', function(e){
        e.preventDefault();
        // $(this).prop('disabled', true);
        
        if(confirm("Click OK to confirm that you are deleting deposited amount.")){
            $('.full-cover').css('display','block');
            $('.full-cover .inside').html('Deleting...');
            var eid = $(this).attr('eid');

            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            var formdata = new FormData();
            formdata.append('eid',eid);
            formdata.append('status','customer deposited amount');
            $.ajax({
                type: 'POST',   
                url: '/delete',
                processData: false,
                contentType: false,
                data: formdata,
                success: function(data) {
                    $('.full-cover').css('display','none');
                    if (data.status == "success") {
                        popNotification('success',"Success! Amount has been deleted successfully.");
                        $('.cus-p-'+data.id).remove();
                        $('.close-cus-changes').css('display','none');$('.done-cus-changes').css('display','');
                    } else {
                        popNotification('warning',"Error! Something went wrong, please try again later.");                        
                    }
                }
            });
        }
        return;
    });
    $(document).on('click', '.edit-alilipwa', function(e) {
        e.preventDefault();
        var amount = $(this).attr('amount');
        var sdate = $(this).attr('sdate');
        var customer = $(this).attr('customer');
        $('#notificationModal .close').css('display','none');

        $('.notification-body').html('<div class="row mb-2" align="left"><div class="col-md-9 offset-md-2"><h5 class="mb-4"><?php echo $_GET["change-paid-debt"]; ?></h5>'+
            '<div class="render-cus-paid-debt"><div class="my-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...</div></div>'+
            '<div class="mt-5" align="right"><button type="button" class="btn btn-outline-danger close-cus-changes" data-dismiss="modal">CLOSE</button><button class="btn btn-success done-cus-changes" style="display:none"><i class="fa fa-check"></i> Done</button></div>'+
        '</div></div>');

        $('#notificationModal').modal('toggle');

        $.get("/get-data/cus-paid-debt/<?php echo $data['shop']->id; ?>~"+sdate+"~"+customer, function(data){
            $('.render-cus-paid-debt').html("");
            $.each( data.data.cus_desc, function( key, value ) {
                $('.render-cus-paid-debt').append('<div class="mb-2 cus-dp-'+value.id+'">'
                    +'<input type="number" class="form-control" style="width:150px;display:inline" name="dp-amount-'+value.id+'" value="'+value.debt_amount+'" required="">'
                    +'<button class="btn btn-info ml-2 submit-dp-amount" eid="'+value.id+'"> <?php echo $_GET["update"]; ?></button>'
                    +'<button class="btn btn-danger ml-1 delete-dp-amount" eid="'+value.id+'"> <?php echo $_GET["delete"]; ?></button>'
                +'</div>');
            });
        });     
    });    
    $(document).on('click', '.submit-dp-amount', function(e) {
        e.preventDefault();
        var eid = $(this).attr('eid');
        var amount = $('[name="dp-amount-'+eid+'"]').val();
        $('button').prop('disabled', true);
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData();
        formdata.append('status','update debt paid');
        formdata.append('eid',eid);
        formdata.append('amount',amount);
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('button').prop('disabled', false);
                    if (data.status == "success") {
                        popNotification('success',"Amount updated successfully.");
                        $('.close-cus-changes').css('display','none');$('.done-cus-changes').css('display','');
                    } else {
                        popNotification('warning',"Oops! Failed to updated mout");                        
                    }
                }
        });
    });
    $(document).on('click', '.delete-dp-amount', function(e){
        e.preventDefault();        
        if(confirm("Click OK to confirm that you are deleting the paid amount.")){
            $('.full-cover').css('display','block');
            $('.full-cover .inside').html('Deleting...');
            var eid = $(this).attr('eid');

            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            var formdata = new FormData();
            formdata.append('eid',eid);
            formdata.append('status','customer debt paid');
            $.ajax({
                type: 'POST',   
                url: '/delete',
                processData: false,
                contentType: false,
                data: formdata,
                success: function(data) {
                    $('.full-cover').css('display','none');
                    if (data.status == "success") {
                        popNotification('success',"Success! Amount has been deleted successfully.");
                        $('.cus-dp-'+data.id).remove();
                        $('.close-cus-changes').css('display','none');$('.done-cus-changes').css('display','');
                    } else {
                        popNotification('warning',"Error! Something went wrong, please try again later.");                        
                    }
                }
            });
        }
        return;
    });
    $(document).on('click', '.edit-alirudishiwa', function(e) {
        e.preventDefault();
        var amount = $(this).attr('amount');
        var sdate = $(this).attr('sdate');
        var customer = $(this).attr('customer');
        $('#notificationModal .close').css('display','none');

        $('.notification-body').html('<div class="row mb-2" align="left"><div class="col-md-9 offset-md-2"><h5 class="mb-4"><?php echo $_GET["change-paid-debt"]; ?></h5>'+
            '<div class="render-cus-paid-amount"><div class="my-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...</div></div>'+
            '<div class="mt-5" align="right"><button type="button" class="btn btn-outline-danger close-cus-changes" data-dismiss="modal">CLOSE</button><button class="btn btn-success done-cus-changes" style="display:none"><i class="fa fa-check"></i> Done</button></div>'+
        '</div></div>');

        $('#notificationModal').modal('toggle');

        $.get("/get-data/cus-refund/<?php echo $data['shop']->id; ?>~"+sdate+"~"+customer, function(data){
            $('.render-cus-paid-amount').html("");
            $.each( data.data.cus_desc, function( key, value ) {
                $('.render-cus-paid-amount').append('<div class="mb-2 cus-r-'+value.id+'">'
                    +'<input type="number" class="form-control" style="width:150px;display:inline" name="r-amount-'+value.id+'" value="'+value.debt_amount+'" required="">'
                    +'<button class="btn btn-info ml-2 submit-r-amount" eid="'+value.id+'"> <?php echo $_GET["update"]; ?></button>'
                    +'<button class="btn btn-danger ml-1 delete-r-amount" eid="'+value.id+'"> <?php echo $_GET["delete"]; ?></button>'
                +'</div>');
            });
        });     
    });    
    $(document).on('click', '.submit-r-amount', function(e) {
        e.preventDefault();
        var eid = $(this).attr('eid');
        var amount = $('[name="r-amount-'+eid+'"]').val();
        $('button').prop('disabled', true);
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData();
        formdata.append('status','update refund');
        formdata.append('eid',eid);
        formdata.append('amount',amount);
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('button').prop('disabled', false);
                    if (data.status == "success") {
                        popNotification('success',"Amount updated successfully.");
                        $('.close-cus-changes').css('display','none');$('.done-cus-changes').css('display','');
                    } else {
                        popNotification('warning',"Oops! Failed to updated mout");                        
                    }
                }
        });
    });
    $(document).on('click', '.delete-r-amount', function(e){
        e.preventDefault();        
        if(confirm("Click OK to confirm that you are deleting the refunded amount.")){
            $('.full-cover').css('display','block');
            $('.full-cover .inside').html('Deleting...');
            var eid = $(this).attr('eid');

            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            var formdata = new FormData();
            formdata.append('eid',eid);
            formdata.append('status','customer refund');
            $.ajax({
                type: 'POST',   
                url: '/delete',
                processData: false,
                contentType: false,
                data: formdata,
                success: function(data) {
                    $('.full-cover').css('display','none');
                    if (data.status == "success") {
                        popNotification('success',"Success! Amount has been deleted successfully.");
                        $('.cus-r-'+data.id).remove();
                        $('.close-cus-changes').css('display','none');$('.done-cus-changes').css('display','');
                    } else {
                        popNotification('warning',"Error! Something went wrong, please try again later.");                        
                    }
                }
            });
        }
        return;
    });
    
    $(document).on('click', '.done-cus-changes', function(e) {
        e.preventDefault();
        $('#notificationModal').modal('hide');   
        $('#notificationModal .close').css('display','');
        $('.debt-rec-btn').click();
    });

    $(document).on('click', '.suppliers-tab-blc', function(e) {
        e.preventDefault();
        $('.other-tabs .suppliers-tab').click();
    });
    $(document).on('click', '.suppliers-tab', function(e) {
        e.preventDefault();
        $('.shop-tabs .nav-link, .other-tabs .nav-link').removeClass('active');
        $('.shop-tabs .suppliers-tab, .other-tabs .suppliers-tab').addClass('active');
        window.history.pushState({state:1}, "Suppliers", "?tab=suppliers");
        $('.render-suppliers').html('<div class="my-5" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>'); // get data
        $.get("/suppliers/shop-suppliers/<?php echo $data['shop']->id; ?>", function(data){
            $('.render-suppliers').html(data.view);          
        });
    });
    $(document).on('click', '.supplier-details', function(e) {
        e.preventDefault();
        var sid = $(this).attr('sid');
        window.history.pushState({state:1}, "Supplier Preview", "?tab=suppliers&supplier_id="+sid);
        openSupplierTab(sid);
    });
    function openSupplierTab(supplier_id) {
        window.history.pushState({state:1}, "Supplier Preview", "?tab=suppliers&supplier_id="+supplier_id);
        $('.shop-tabs .nav-link, .other-tabs .nav-link, .shop-tab-conten .tab-pane, #Products .nav-link').removeClass('active');
        $('.shop-tabs .suppliers-tab, .other-tabs .suppliers-tab, #Suppliers, #Products .products-outer-block').addClass('active');
        $('.render-suppliers').html('<div class="my-5" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>');
        $.get("/suppliers/get-shop-supplier/<?php echo $data['shop']->id; ?>~"+supplier_id, function(data){
            $('.render-suppliers').html(data.view);         
        });
    }
    $(document).on('click','.edit-supplier-btn',function(e){
        e.preventDefault();
        var sid = $(this).attr('sid');
        var sname = $(this).attr('sname');
        var sphone = $(this).attr('sphone');
        var slocation = $(this).attr('slocation');
        
        $('.notification-body').html('<form id="basic-form" class="edit-supplier-form"><div class="row mb-2" align="left"><div class="col-md-8 offset-md-2"><h5 class="mb-3"><?php echo $_GET["change-supplier-details"]; ?></h5><label class="mb-0"><?php echo $_GET["name"]; ?></label>'+
                    '<input type="text" class="form-control form-control-sm" placeholder="Jina" name="sname" value="'+sname+'" required=""><br><label class="mb-0"><?php echo $_GET["phone-number"]; ?></label>'+
                    '<input type="text" class="form-control form-control-sm" placeholder="Jina" name="sphone" value="'+sphone+'" required=""><br><label class="mb-0"><?php echo $_GET["address"]; ?></label>'+
                    '<input type="text" class="form-control form-control-sm" placeholder="Jina" name="slocation" value="'+slocation+'" required="">'+
                    '<input type="hidden" name="id" value="'+sid+'">'+
                    '<div class="col-12 pl-0 pr-0 mt-5">'+
                        '<div class="mb-2"><button class="btn btn-info submit-edit-supplier" style="width:50%" sid="'+sid+'"> <?php echo $_GET["update"]; ?></button><button class="btn btn-outline-secondary ml-2" data-dismiss="modal" aria-label="Close"> <?php echo $_GET["cancel"]; ?></button></div>'+
                    '</div></div></form>');
        
        $('#notificationModal').modal('toggle');
    });
    $(document).on('submit', '.edit-supplier-form', function(e) {
        e.preventDefault();
        $('.submit-edit-supplier').prop('disabled', true).html('Updating..');
        
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        formdata.append('status',"update supplier details");
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.submit-edit-supplier').prop('disabled', false).html('<?php echo $_GET["update"]; ?>');
                    if (data.status == "success") {
                        popNotification('success',"Success! Supplier details updated successfully");
                        $('#notificationModal').modal('hide');
                        var select = $(".change-supplier").select2();
                        select.select2('destroy');          
                        $(".change-supplier").find("option:selected").text(data.sname);
                        select.select2();
                        getSupplierDetails(data.sid);
                    } else {
                        popNotification('warning',"Sorry! System failed to update supplier details. Please try again.");
                    }
                }
        });
    });
    $(document).on('click','.supplier-deposit-btn',function(e){
        e.preventDefault();
        var sid = $(this).attr('sid');
        var sname = $(this).attr('sname');
        
        $('.notification-body').html('<form id="basic-form" class="supplier-deposit-form"><div class="row mb-2" align="left"><div class="col-md-8 offset-md-2"><span class="mb-3"><?php echo $_GET["deposit-money-to"]; ?> <b>'+sname+'</b></span><div class="mt-3"><label><?php echo $_GET["amount"]; ?></label></div>'+
                    '<input type="number" class="form-control form-control-sm" placeholder="Amount" name="amount" required="">'+
                    '<input type="hidden" name="sid" value="'+sid+'">'+
                    '<input type="hidden" name="from" value="shop">'+
                    '<input type="hidden" name="shopid" value="<?php echo $data["shop"]->id; ?>">'+
                    '<div class="col-12 pl-0 pr-0 mt-5">'+
                        '<div class="mb-2"><button class="btn btn-info submit-supplier-deposit" style="width:50%"> Submit</button><button class="btn btn-outline-secondary ml-2" data-dismiss="modal" aria-label="Close"> <?php echo $_GET["cancel"]; ?></button></div>'+
                    '</div></div></form>');
        
        $('#notificationModal').modal('toggle');
    });
    $(document).on('submit', '.supplier-deposit-form', function(e) {
        e.preventDefault();
        $('.submit-supplier-deposit').prop('disabled', true).html('Submitting..');
        
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        formdata.append('status',"supplier deposit money");
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.submit-supplier-deposit').prop('disabled', false).html('Submit');
                    if (data.status == "success") {
                        popNotification('success',"Success! Amount deposit recorded successfully");
                        $('#notificationModal').modal('hide');
                        supplierYearSummary("<?php echo $data['shop']->id; ?>~"+data.supplier);
                    } else {
                        popNotification('warning',"Sorry! System failed to submit. Please try again.");
                    }
                }
        });
    });
    $(document).on('submit', '.deposit-after-purchase', function(e) {
        e.preventDefault();
        $('.deposit-after-purchase button').prop('disabled', true).html('Submitting..');
        
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        formdata.append('status',"supplier deposit money");
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.deposit-after-purchase button').prop('disabled', false).html('Submit');
                    popNotification('success',"Success! Amount recorded successfully");
                    $('#addPQuantity').modal('hide');
                    supplierYearSummary("<?php echo $data['shop']->id; ?>~"+data.supplier);
                }
        });
    });
    $(document).on('click','.supplier-borrow-btn',function(e){
        e.preventDefault();
        var sid = $(this).attr('sid');
        var sname = $(this).attr('sname');
        
        $('.notification-body').html('<form id="basic-form" class="supplier-borrow-form"><div class="row mb-2" align="left"><div class="col-md-8 offset-md-2"><span class="mb-3"><?php echo $_GET["borrow-money-from"]; ?> <b>'+sname+'</b></span><div class="mt-3"><label><?php echo $_GET["amount"]; ?></label></div>'+
                    '<input type="number" class="form-control form-control-sm" placeholder="Amount" name="amount" required="">'+
                    '<input type="hidden" name="sid" value="'+sid+'">'+
                    '<input type="hidden" name="shopid" value="<?php echo $data["shop"]->id; ?>">'+
                    '<div class="col-12 pl-0 pr-0 mt-5">'+
                        '<div class="mb-2"><button class="btn btn-info submit-supplier-borrow" style="width:50%"> Submit</button><button class="btn btn-outline-secondary ml-2" data-dismiss="modal" aria-label="Close"> <?php echo $_GET["cancel"]; ?></button></div>'+
                    '</div></div></form>');
        
        $('#notificationModal').modal('toggle');
    });
    $(document).on('submit', '.supplier-borrow-form', function(e) {
        e.preventDefault();
        $('.submit-supplier-borrow').prop('disabled', true).html('Submitting..');
        
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        formdata.append('status',"supplier borrow money");
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.submit-supplier-deposit').prop('disabled', false).html('Submit');
                    if (data.status == "success") {
                        popNotification('success',"Success! Amount recorded successfully");
                        $('#notificationModal').modal('hide');
                        supplierYearSummary("<?php echo $data['shop']->id; ?>~"+data.supplier);
                    } else {
                        popNotification('warning',"Sorry! System failed to submit. Please try again.");
                    }
                }
        });
    });
    $(document).on('click','.delete-supplier-btn',function(e){
        e.preventDefault();
        var sid = $(this).attr('sid');
        var sname = $(this).attr('sname');
        $('.notification-body').html('<div class="row">'+
                    '<div class="col-12"><i class="fa fa-warning fa-2x text-warning"></i> <br> Confirm that you are deleting <b>'+sname+'</b> <br>'+
                    '<div class="col-12 mt-5">'+
                        '<div class="mb-2"><button class="btn btn-danger confirm-delete-supplier" sid="'+sid+'"><i class="fa fa-trash pr-2"></i> <?php echo $_GET["delete"]; ?></button><button class="btn btn-outline-secondary ml-2" data-dismiss="modal" aria-label="Close"> <?php echo $_GET["cancel"]; ?></button></div>'+
                    '</div></div>');
        
        $('#notificationModal').modal('toggle');
    });
    $(document).on('click','.confirm-delete-supplier',function(e){
        e.preventDefault();
        $('.notification-body').html('<div align="center" class="my-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Removing...<div>');
        
        var sid = $(this).attr('sid');

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData();
        formdata.append('id',sid);
        formdata.append('status','delete supplier');
        $.ajax({
            type: 'POST',
            url: '/delete',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    if (data.status == "success") {
                        $('#notificationModal').modal('hide');
                        popNotification('success','Supplier deleted successfully');
                        $('.other-tabs .suppliers-tab').click();
                    } else {
                        popNotification('warning',"Error! System failed to delete supplier.");
                    }
                }
        });              
    });

    $(document).on('click', '.transfer-tab-blc', function(e) {
        e.preventDefault();
        $('.other-tabs .transfer-tab').click();
    });
    $(document).on('click', '.transfer-tab', function(e) {
        e.preventDefault();
        $('.shop-tabs .nav-link, .other-tabs .nav-link').removeClass('active');
        $('.shop-tabs .transfer-tab, .other-tabs .transfer-tab').addClass('active');
        window.history.pushState({state:1}, "Transfer", "?tab=transfer");
        $('.render-transfers').html('<div class="my-5" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>'); // get data
        $.get("/get-data/shop-transfers/<?php echo $data['shop']->id; ?>", function(data){
            if (data.status == 'not have access') {
                $('.render-transfers').html('<?php echo $_GET["dont-have-access-in-shop"]; ?>');
            } else {
                $('.render-transfers').html(data.view);
            }            
        });
    });
    function transferForm() {
        $('#transferForm').modal('toggle');
        $('.render-transfer-form').html('<div class="my-5" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>');
        $.get("/get-data/transfer-items/<?php echo $data['shop']->id; ?>", function(data){
            if (data.status == 'not have access') {
                $('.render-transfer-form').html('<?php echo $_GET["dont-have-access-in-shop"]; ?>');
            } else {
                $('.render-transfer-form').html(data.view);
            }      

            $(".select2").select2({
                dropdownParent: $("#transferForm")
            });      
        });
    }
    function transferItems() {
        $('.render-transfers').html('<div class="my-5" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>');
        window.history.pushState({state:1}, "Transfer Items", "?tab=transfer-items");
        $('.shop-tabs .nav-link, .other-tabs .nav-link, .shop-tab-conten .tab-pane').removeClass('active');
        $('.shop-tabs .transfer-tab, .other-tabs .transfer-tab, #Transfer').addClass('active');
        $.get("/get-data/transfer-items/<?php echo $data['shop']->id; ?>", function(data){
            if (data.status == 'not have access') {
                $('.render-transfers').html('<?php echo $_GET["dont-have-access-in-shop"]; ?>');
            } else {
                $('.render-transfers').html(data.view);
            }            
        });
    };
    
    $(document).on('click', '.settings-tab-blc', function(e) {
        e.preventDefault();
        $('.other-tabs .settings-tab').click();
    });
    $(document).on('click', '.settings-tab', function(e) {
        e.preventDefault();
        $('.shop-tabs .nav-link, .other-tabs .nav-link').removeClass('active');
        $('.shop-tabs .settings-tab, .other-tabs .settings-tab').addClass('active');
        window.history.pushState({state:1}, "Settings", "?tab=settings");
        $('.render-settings').html('<div class="my-5" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>'); // get data
        $.get("/get-data/shop-settings/<?php echo $data['shop']->id; ?>", function(data){
            if (data.status == 'not have access') {
                $('.render-settings').html('<?php echo $_GET["dont-have-access-in-shop"]; ?>');
            } else {
                $('.render-settings').html(data.view);
            }            
        });
    });
    function transferItems_bkp() {
        $('.render-transfers').html('<div class="mt-3" align="center">Loading...</div>');
        window.history.pushState({state:1}, "Transfer Items", "?tab=transfer-items");
        $('.shop-tabs .nav-link, .other-tabs .nav-link, .shop-tab-conten .tab-pane').removeClass('active');
        $('.shop-tabs .transfer-tab, .other-tabs .transfer-tab, #Transfer').addClass('active');
        $.get("/get-data/transfer-items/<?php echo $data['shop']->id; ?>", function(data){
            if (data.status == 'not have access') {
                $('.render-transfers').html('<?php echo $_GET["dont-have-access-in-shop"]; ?>');
            } else {
                $('.render-transfers').html(data.view);
            }            
        });
    };

    function reportCarousel() {
        $.get("/report/shop-home-data/<?php echo $data['shop']->id; ?>", function(data){
            $('.sales-ten, .profit-ten, .expenses-ten, .total-products, .sold-p-ten').html(0);  
            if($.isEmptyObject(data.sales)) { } else {
                var profit = Number(data.sales[0]['tsales']) - Number(data.sales[0]['tbuying']);
                $('.sales-ten').html(Number(data.sales[0]['tsales']).toLocaleString('en'));
                $('.sold-p-ten').html(Number(data.sales[0]['tquantity']).toLocaleString('en'));
                $('.profit-ten').html(profit.toLocaleString('en'));
            }    
            if(data.expenses) {
                $('.expenses-ten').html(Number(data.expenses).toLocaleString('en'));
            }
            if(data.products) {
                $('.total-products').html(Number(data.products));
            }
        });
    }

    function sellProductsTab() {
        $('.render-sell-products').html('<div class="my-5" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>');
        $.get("/get-data/sell-products/<?php echo $data['shop']->id; ?>", function(data){
            if (data.status == 'not have access') {
                $('.render-sell-products').html('<?php echo $_GET["dont-have-access-in-shop"]; ?>');
            } else {
                $('.render-sell-products').html(data.view);
            }            
        });
    }

    function ordersInShop() {
        $('.render-sell-products-bkp, .render-orders').html('<div class="my-5" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>');
        $.get("/get-data/shop-orders/<?php echo $data['shop']->id; ?>", function(data){
            if (data.status == 'not have access') {
                $('.render-sell-products-bkp, .render-orders').html('<?php echo $_GET["dont-have-access-in-shop"]; ?>');
            } else {
                $('.render-sell-products-bkp, .render-orders').html(data.view);
            }            
        });
    }
    
    $(document).on('click', '.cat-h.cats', function(e) {
        e.preventDefault();
        $('.cat-h.cats').removeClass('active'); $(this).addClass('active');
        $('.c-title').html($(this).find('button').text());
        var cat_id = $(this).attr('value');
        var shop_pcat = shop_id+'-'+cat_id;
        $('.inside-s-c').html('<div class="col-12 mt-2"><i class="fa fa-spinner fa-spin fa-2x"></i><span class="ml-1">Loading..</span></div>');
        // check for other cats dropdown
        var container = $(".other-cats");
        if (!container.is(e.target) && container.has(e.target).length === 0) { } else {$(".cat-scroll").click();}
        // end checking        
        let searchParams = new URLSearchParams(window.location.search); 
        $.get('/cashier/'+shop_pcat+'/products-by-cat', function(data){
            $('.inside-s-c').html("");
            if ($.isEmptyObject(data.products)) {
                $('.inside-s-c').html('<span><i>- no sold product yet -</i></span>');
            } else {                
                for (let i = 0; i < data.products.length; i++) {
                    var pimage = '/images/product-17.png';
                    if(data.products[i]['pimage'] == null) { } else {
                        pimage = '/images/companies/<?php echo Auth::user()->company->folder; ?>/products/'+data.products[i]['pimage'];
                    } 
                    $('.inside-s-c').append('<div class="col-sm-3 px-1">'
                        +'<div class="btn btn-primary btn-sm searched-item py-1 mb-2" val="'+ data.products[i]["pid"] +'"  check="sales" qty="0" price="'+ Number(data.products[i]["pprince"]) +'" style="font-size: 12px">'
                        +'<img src="'+pimage+'" class="avatar"><br> <span>'+ data.products[i]["pname"] +'</span><b>'+ Number(data.products[i]["pprice"]).toLocaleString("en") +'</b></div></div>');
                }
            }
        });
    });

    
    $(document).on('keyup', '.soquantity', function(e){
        e.preventDefault();
        var id = $(this).attr('rid');
        var qty = $(this).val();
        $.get('/update-sale-quantity/order/'+shop_id+'/'+id+'/'+qty, function(data){
            if (data.error) {
                popNotification('warning',data.error);
                return;
            }            
            $('.totaloP-'+data.id).html(data.data.subsubtotal);
            $('.totaloQ').html(parseFloat(data.data.totaloQ));
            $('.totaloP, .o-amounttopay').html(data.subtotal); $('.o-paidamount').val(data.subtotal.replace(/,/g, ''));
            $('.o-change').html(0);        
            $('.paidamount2').val(data.data.totaloP);
        });
    });

    $(document).on('keyup', '.soprice', function(e){
        e.preventDefault();
        var id = $(this).attr('rid');
        var price = $(this).val();
        $.get('/update-sale-price/order/'+shop_id+'/'+id+'/'+price, function(data){
            if (data.error) {
                popNotification('warning',data.error);
                return;
            }            
            $('.totaloP-'+data.id).html(data.data.subsubtotal);
            $('.totaloP, .o-amounttopay').html(data.subtotal); $('.o-paidamount').val(data.subtotal.replace(/,/g, ''));
            $('.o-change').html(0);          
            $('.paidamount2').val(data.data.totaloP);  
        });
    });
    
    $(document).on('click', '.clear-sale-cart', function(e) {
        e.preventDefault(); 
        $('.items-in-cart').html('<tr class="empty-row"><td><div class="py-3"><i>- Empty Cart -</i></div></td></tr>');
        $('.total-row .totalQ').html(0);
        $('.total-row .totalP').html(0);
        $('.remove-a-customer').click();
        popNotification('success','Success! Cart cleared successfully.'); 

        // clear localStorage session
        localStorage.removeItem('items-in-cart');
        localStorage.removeItem('totalQ');
        localStorage.removeItem('totalP');
                       
    });

    $(document).on('click', '.submit-order-cart', function(e){
        e.preventDefault();
        submitOrderToDatabase();
    });

    function submitOrderToDatabase() {
        $('button').prop('disabled', true);
        $('.fa-spin').css('display','');

        var dataQuantity = [];
        var dataAmount = [];
        var productIds = [];
        var customer = $('.scroll-to-c [name="customer"]').val();
        var saledate = $('.sale-date').val();
        saledate = saledate.split('/').join('-');

        $('#cart-selected .mo-quantity').each(function() {
            dataQuantity.push(parseFloat($(this).val()));
        });

         $('#cart-selected .product_id').each(function() {
            productIds.push(parseFloat($(this).val()));
        });

        $('#cart-selected .mo-price').each(function() {
            dataAmount.push(parseFloat($(this).val()));

        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var dataz = {
            'product_ids': productIds,
            'quantities': dataQuantity,
            'prises': dataAmount,
            'shop_id': shop_id,
            'customer_id':customer,
            'saledate':saledate
        }

        $.ajax({
        type: 'post',
        url: '/add-new-order',
        data: JSON.stringify(dataz),
        contentType: 'application/json',
            success: function(data) {
                if(data.status == "success") {    
                    $('button').prop('disabled', false);   
                    popNotification('success','Success! Order submitted successfully.');    
                    $('.items-in-cart').html('<tr class="empty-row"><td><div class="py-3"><i>- Empty Cart -</i></div></td></tr>');

                    // clear localStorage session
                    localStorage.removeItem('items-in-cart');
                    localStorage.removeItem('totalQ');
                    localStorage.removeItem('totalP');

                    $('.fa-spin').css('display','none');
                    $('.total-row .totalQ').html(0);
                    $('.total-row .totalP').html(0);
                    $('.remove-a-customer').click();
                    $('.orders-tab span').css('display','inline');
                    if ($('#OrdersT').hasClass('active')) {
                        pendingOrders("<?php echo $data['shop']->id; ?>"); // we run this bcoz sometime cashier will submit cart while order tab is active
                    }            
                } 
            },

            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }
    
    $(document).on('click', '.submit-sale-cart', function(e){
        e.preventDefault();
        var cancel = "";
        $('.sale-loader, .sale-receipt').css('display','none'); $('.sale-preview').css('display','block');
        $('.s-preview-loader').css('display','block');

        // check for enough quantity
        $('#cart-selected .mo-quantity').each(function() {
            $(this).attr('value',$(this).val());
            var val = parseFloat($(this).val());
            var qty = parseFloat($(this).attr('avaQty'));
            var pid = $(this).attr('rid');
            if (!isNaN(val)) {
                if (val > qty) {
                    cancel = "cancel";
                    $('.sr-'+pid+' .ra-name .aq').html(Number(qty)).css('background','gold');
                    $('.sr-'+pid).css('background','#FDF9DC');
                    popNotification('warning','Idadi haitoshi');
                    return false;
                }                
            }            
        });

        if (cancel == "cancel") {
                
        } else {
            $('#saleModal').modal('toggle');
        }

        var customer = $('.scroll-to-c [name="customer"]').val();
        var price = $('.totalP').text();
        var price2 = price.replace(/,/g, '');
        $('.s-preview-loader').css('display','none');
        $('.amounttopay').html(price);
        $('[name="paidamount"]').val(price2);

        if (customer == 'null') {
            $('.scustomer').css("display","none");
        } else {
            $('.scustomer').css("display","block");
        }

        setTimeout(function (){
            $('[name="paidamount"]').focus();
        }, 1000);

    });
    $(document).on('click', '.submit-sale-cart2', function(e){ 
        e.preventDefault();

        submitCartToDatabase();
    });

    function submitCartToDatabase(){

        $('.sale-preview, .sale-receipt').css('display','none'); $('.sale-loader').css('display','block');
        $('button').prop('disabled', true);
        $('.fa-spin').css('display','');

        var amounttopay = parseFloat($('.sale-preview.s .amounttopay').text().replace(/,/g, ''));
        var td_sales = parseFloat($('.td-sales').text().replace(/,/g, ''));
        var curr_total = amounttopay + td_sales;        

        var dataQuantity = [];
        var dataAmount = [];
        var productIds = [];
        var customer = $('.scroll-to-c [name="customer"]').val();
        var cname = $('.render-attached-customer b').text();
        var paymentmethod = $('[name="payment-method"]').val();
        var saledate = $('.sale-date').val();
        saledate = saledate.split('/').join('-');
        var paidamount = $('[name="paidamount"]').val();
        if (paidamount) {} else {  
            paidamount = 0;
            if (customer == 'null') {
                paidamount = '-';
            }
        }

        $('#cart-selected .mo-quantity').each(function() {
            dataQuantity.push(parseFloat($(this).val()));
        });

         $('#cart-selected .product_id').each(function() {
            productIds.push(parseFloat($(this).val()));
        });

        $('#cart-selected .mo-price').each(function() {
            dataAmount.push(parseFloat($(this).val()));

        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var dataz = {
            'product_ids': productIds,
            'quantities': dataQuantity,
            'prises': dataAmount,
            'shop_id': shop_id,
            'customer_id':customer,
            'saledate':saledate,
            'paidamount':paidamount,
            'paymentmethod':paymentmethod
        }

        $.ajax({
        type: 'post',
        url: '/add-new-sale',
        data: JSON.stringify(dataz),
        contentType: 'application/json',
            success: function(data) {
                if(data.status == "not enough") { // not enough status not applicable here
                    $('#saleModal').modal('hide');
                    $('button').prop('disabled', false);
                    $('.fa-spin').css('display','none');
                    $('.sr-'+data.pid+' .ra-name .aq').html(Number(data.aq)).css('background','gold');
                    $('.sr-'+data.pid).css('background','#FDF9DC');
                    popNotification('warning',data.pname+' <?php echo $_GET["is-not-enough"]; ?>');
                    return;
                } else {
                    $('button').prop('disabled', false);
                    popNotification('success','Sold! Product sold successfully.');
                    $('.items-in-cart').html('<tr class="empty-row"><td><div class="py-3"><i>- Empty Cart -</i></div></td></tr>');                    
                    // clear localStorage session
                    localStorage.removeItem('items-in-cart');
                    localStorage.removeItem('totalQ');
                    localStorage.removeItem('totalP');

                    $('.total-row .totalQ').html(0);
                    $('.total-row .totalP').html(0);
                    $('.remove-a-customer').click();
                    "<?php if($data['shop']->sell_order == 'yes') { ?>"; // check if need to print receipt
                        $('.prepare-receipt').css('display','');
                        $.get('/order-items/receipt-preview/'+data.data.saleno, function(data2){
                            $('.fa-spin, .prepare-receipt').css('display','none');
                            $('.sale-receipt').css('display','block'); $('.sale-loader').css('display','none');
                            $('.saleno').html(data.data.saleno);

                            $('.render-sales-to-print').html("");

                            if ($.isEmptyObject(data2.sales)) {  } else {
                                for (let i = 0; i < data2.sales.length; i++) {
                                    $('.render-sales-to-print').append('<tr><th style="width:50% !important">'
                                        +'<div class="r-name">'+data2.sales[i]['pname']+'</div></th>'
                                        +'<th style="width:15% !important"><div align="center">'+Number(data2.sales[i]['quantity'])+'</div></th>'
                                        +'<th style="width:35% !important"><div class="" align="right">  <span><b class="totaloP-">'+Number(data2.sales[i]['stotal']).toLocaleString('en')+'</b></span></div>'
                                        +'</th></tr>');
                                }
                            }
                            
                            $('.dd .total_SP, .ddd .total_SP, .dddd .total_SP').html(Number(amounttopay).toLocaleString('en')); 
                            $('.dd .totalSPA, .ddd .totalSPA, .dddd .totalSPA').html(Number(paidamount).toLocaleString('en'));
                            // $('.totalCH').html(data2.data.change);

                            if (customer == 'null') {
                                $('.customer-s-blk').css("display","none");
                            } else {
                                $('.customer-s-blk').css("display","");
                                $('.customername').html(cname);
                            }

                        });
                    "<?php } else { ?>";
                        $('.fa-spin').css('display','none');
                        $('.close').click();
                    "<?php } ?>";

                    // deduct quantity and check for customer debt 
                    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
                    var formdata = new FormData();
                    formdata.append('status','update quantity after sale');
                    formdata.append('saleno',data.data.saleno);
                    formdata.append('shop_id',shop_id);
                    $.ajax({
                        type: 'POST',
                        url: '/submit-data',
                        processData: false,
                        contentType: false,
                        data: formdata,
                            success: function(data) {
                                console.log('Quantity updated');
                            }
                    });

                    if (data.data.predate == "no") {
                        $('.td-sales').html(Number(curr_total).toLocaleString());
                        // todaySales();
                    } else {
                        $.get('/update/daily-sales/'+shop_id+'~'+data.data.predate, function(data){
                            console.log('daily sales updated');
                        });
                    }

                    if (data.ids.length == 0) { } else { // check and submit min stock level
                        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
                        var formdata = new FormData();
                        formdata.append('status','record min stock level');
                        formdata.append('ids',data.ids);
                        formdata.append('shop_id',shop_id);
                        $.ajax({
                            type: 'POST',
                            url: '/submit-data',
                            processData: false,
                            contentType: false,
                            data: formdata,
                                success: function(data) {
                                    // console.log(data.status);
                                    console.log('min stock level updated');
                                }
                        });
                    }
                }
            },

            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });

    }
    
    $(document).on('click', '.preview-receipt', function(e){
        e.preventDefault();
        var saleno = $(this).attr('saleno');
        $('.sale-preview, .sale-receipt').css('display','none'); $('.sale-loader').css('display','block');
        // $('.fa-spin').css('display','');
        $('#saleModal').modal('toggle');
        $.get('/order-items/list/'+saleno, function(data2){
            $('.sale-receipt').css('display','block'); $('.sale-loader').css('display','none');
            $('.saleno').html(saleno);
            $('.render-sales-to-print').html(data2.items);
            $('.total_SP').html(data2.subtotal); $('.totalSPA').html(data2.data.paidamount);
            $('.totalCH').html(data2.data.change);
            if (data2.data.customer) {
                $('.customer-s-blk').css('display','');
                $('.customer-s-name').html(data2.data.customer);
            } else {
                $('.customer-s-blk').css('display','none');
            }
        });
    });
    
    $(document).on('click', '.td-sales-tab', function(e) {
        e.preventDefault(); 
        if($(this).hasClass('collapsed')) {
            // close tab
        } else {
            todaySales();
        }    
    });
    $(document).on('click', '.orders-tab', function(e) {
        e.preventDefault(); 
        if($(this).hasClass('collapsed')) {
            // close tab
        } else {
            ordersInShop();
        }    
    });

    $(document).on('keyup', '.s-paidamount', function(e){
        e.preventDefault();
        var paid = $(this).val();
        if (isNaN(paid) || paid == "") {
            paid = 0;
        }
        var hasto = $('.sale-preview .amounttopay').text().replace(/,/g, '');
        var balance = Number(paid) - Number(hasto);
        $('.s-change').html(balance.toLocaleString("en"));
    });
    
    $(document).on('click', '.close-modal', function(e){
        e.preventDefault();
        $('.modal').modal('hide');
    });
    
    $(document).on('click', '.closure-sale', function(e){
        e.preventDefault();
        $(this).prop('disabled', true).html("Submitting..");
        var e_cash = $('.exp_cash').val();
        var cash = $('.ava_cash').val();
        if (cash == 0 || cash == null) {
            popNotification('warning',"Sorry! you cant submit 0 cash");
            return;
        }
        $.get('/submit-ava-cash/'+e_cash+'/'+cash+'/'+shop_id, function(data){
            $('.closure-sale').prop('disabled', false).html("Close Sales");
            popNotification('success','Available cash is submitted successfully');
            // return;
        });
    });
    
    $(document).on('click', '.render-oitems .order-items', function(e) { // pending orders
        e.preventDefault();
        $('.order-list').html("<tr><td><i class='fa fa-spinner fa-spin'></i> Loading...</td></tr>");
        $('.totaloQ').html("-");$('.totaloP, .o-amounttopay').html("-");$('.ordered_by').html("-");
        $('.hidden-btn,.order-footer,.customer-order,.scustomer2,.order-pay-block,.pa-tr, .ch-tr').css("display","none");
        $('.pay-order-btn').removeClass("show");
        $('.custom-o-nu-block').css('display','');
        $('.set-cutom-no').prop('disabled',false);
        $('#orderModal').modal('toggle');
        var ono = $(this).attr('order');
        $('.orderno').html(ono);
        $('.invoice-a').attr('href','/pdf/preview-invoice/'+ono);
        $('.delete-sorder, .submit-saleo, .print-order-btn').attr("order",ono);

        $('.order-footer, .th-n-sold').css("display","");$('.order-sold-footer, .th-sold').css("display","none");
        $.get('/order-items/list/'+ono, function(data){
            $('.order-list').html('');
            if ($.isEmptyObject(data.sales)) {
                $('.order-list').html('<tr><td>-- No items --</td></tr>');
            } else {
                var change_s_price = "<?php echo $data['shop']->change_s_price; ?>";
                var user_id = "<?php echo Auth::user()->id; ?>";
                var total = 0;
                if (change_s_price == "no") {
                    var disabled3 = "disabled";
                } else {
                    var disabled3 = "";
                }
                if (data.sales[0]['uid'] == user_id) {
                    var disabled = "";                    
                    var canchange = "yes";
                } else {
                    var disabled = "disabled";
                    var canchange = "no";
                }

                $('.ordered_by').html(data.sales[0]['uname']);
                if (data.sales[0]['cname']) {
                    $('.customer-order,.scustomer2').css('display','');
                    $('.customer-order-name').html(data.sales[0]['cname']);
                }

                for (let i = 0; i < data.sales.length; i++) {    
                    total = total + Number(data.sales[i]['stotal']);                
                    var clear = "<span class='pull-right text-danger remove-sor' val='"+data.sales[i]['sid']+"' style='cursor: pointer;font-size:1.2rem;'><i class='fa fa-times'></i></span>";

                    $('.order-list').append('<tr class="sor-'+data.sales[i]['sid']+'"><td><div class="row py-1">'
                    +'<div class="col-12 r-name">'+data.sales[i]['pname']+''+clear+'</div>'
                    +'<div class="col-12" align="right"> <span><input type="number" class="form-control soquantity" name="quantity" value="'+Number(data.sales[i]['quantity'])+'" rid="'+data.sales[i]['sid']+'" '+disabled+'></span> <span><i class="fa fa-times"></i></span> <span><input type="number" class="form-control soprice" name="price" value="'+Number(data.sales[i]['sprice'])+'" rid="'+data.sales[i]['sid']+'" '+disabled+' '+disabled3+' style="display:inline-block"></span> <span>=</span> <span><b class="totaloP-'+data.sales[i]['sid']+'">'+Number(data.sales[i]['stotal']).toLocaleString('en')+'</b></span></div>'
                    +'</div></td></tr>');
                }
                $('.totaloP').html(Number(total).toLocaleString('en')); 
                $('.o-paidamount').val(Number(total));
            }

        });
    });
    $(document).on('click', '.render-soitems .order-items', function(e) { // sold orders
        e.preventDefault();
        $('.order-list').html("<tr><td><i class='fa fa-spinner fa-spin'></i> Loading...</td></tr>");
        $('.totaloQ').html("-");$('.totaloP, .o-amounttopay').html("-");$('.ordered_by').html("-");
        $('.hidden-btn,.order-footer,.customer-order,.scustomer2,.order-pay-block,.pa-tr, .ch-tr').css("display","none");
        $('.pay-order-btn').removeClass("show");
        $('.custom-o-nu-block').css('display','');
        $('.set-cutom-no').prop('disabled',false);
        $('#orderModal').modal('toggle');
        var ono = $(this).attr('order');
        $('.orderno').html(ono);
        $('.delete-sorder, .submit-saleo, .print-order-btn').attr("order",ono);

        $('.order-footer, .th-n-sold').css("display","");$('.order-sold-footer, .th-sold').css("display","none");
        $.get('/order-items/sold-order/'+ono, function(data){
            $('.order-list').html('');
            if ($.isEmptyObject(data.sales)) {
                $('.order-list').html('<tr><td>-- No items --</td></tr>');
            } else {
                var total = 0;

                $('.ordered_by').html(data.sales[0]['uname']);
                if (data.sales[0]['cname']) {
                    $('.customer-order,.scustomer2').css('display','');
                    $('.customer-order-name').html(data.sales[0]['cname']);
                }

                for (let i = 0; i < data.sales.length; i++) {    
                    total = total + Number(data.sales[i]['stotal']);                
                    var clear = "<span class='pull-right text-danger remove-sor' val='"+data.sales[i]['sid']+"' style='cursor: pointer;font-size:1.2rem;'><i class='fa fa-times'></i></span>";

                    $('.order-list, .render-orders-to-print').append('<tr><th style="width:50% !important">'
                        +'<div class="r-name">'+data.sales[i]['pname']+'</div></th>'
                        +'<th style="width:15% !important"><div align="center">'+Number(data.sales[i]['quantity'])+'</div></th>'
                        +'<th style="width:35% !important"><div class="" align="right">  <span><b class="totaloP-">'+Number(data.sales[i]['stotal']).toLocaleString('en')+'</b></span></div>'
                        +'</th></tr>');
                }
                $('.totaloP').html(Number(total).toLocaleString('en')); 
                $('.totalSPA').html(Number(data.sales[0]['paid_amount']).toLocaleString('en'));

                $('.order-sold-footer, .th-sold').css("display","");$('.order-footer, .paid-change-blk, .th-n-sold').css("display","none");
                $('.pa-tr').css('display','');
                
            }
        });
    });

    $(document).on('click', '.submit-saleo', function(e) {
        var ono = $(this).attr('order'); 
        // var custom_ono = $('.set-cutom-no').val();
        var custom_ono = 0;
        $('.full-cover').css('display','block');
        $('.full-cover .inside').html('Submitting...');
        // paidamount is attached if a certain order has customer_id
        var paidamount = $('.o-paidamount').val();
        if (paidamount) {} else {
            paidamount = "-";
        }
        ono = paidamount+"~"+ono+"~"+custom_ono;
        // $('#orderModal').modal('hide');
        $('.full-cover').css('display','none');
        $.get('/order-items/sold/'+ono, function(data){
            
            if (data.error) {
                popNotification('warning',data.error);
                return;
            }
            if (data.success) {
                $('.order-footer, .paid-change-blk, .th-n-sold').css("display","none");$('.order-sold-footer, .th-sold').css("display","");
                $('.order-list, .render-orders-to-print').html(data.items);
                $('.pa-tr').css('display','');
                $('.totalSPA').html(data.data.paidamount);
                $('.totalCH').html(data.data.change);
                $('.p-thanks').html("Thanks for your purchase!");

                var row = $('.or-'+data.ono).html();
                $('.or-'+data.ono).remove();
                $('.render-soitems').prepend('<tr>'+row+'</tr>');                
                popNotification('success',"The order is sold successfully.");

                var td_sales = parseFloat($('.td-sales').text().replace(/,/g, ''));
                var totalsales = parseFloat(data.data.totalamount) + td_sales;     
                $('.td-sales').html(Number(totalsales).toLocaleString());

                if (data.ids.length == 0) { } else { // check and submit min stock level
                    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
                    var formdata = new FormData();
                    formdata.append('status','record min stock level');
                    formdata.append('ids',data.ids);
                    formdata.append('shop_id',shop_id);
                    $.ajax({
                        type: 'POST',
                        url: '/submit-data',
                        processData: false,
                        contentType: false,
                        data: formdata,
                            success: function(data) {
                                // console.log(data.status);
                                console.log('min stock level updated');
                            }
                    });
                }
            }
        });
    });

    $(document).on('click', '.submit-saleo-print', function(e) {
        e.preventDefault();
        $('.print-order-btn').click();
        $('.submit-saleo').click();
    });
    
    $(document).on('click', '.delete-sorder', function(e) {
        var ono = $(this).attr('order');
        if(confirm("Click OK to confirm that you delete order No. "+ono)){
            $('.full-cover').css('display','block');
            $('.full-cover .inside').html('Deleting...');
            $.get('/order-items/delete/'+ono, function(data){
                $('.full-cover').css('display','none');
                if (data.error) {
                    popNotification('warning',data.error);
                    return;
                }
                if (data.success) {
                    $('.or-'+data.ono).closest("tr").remove();
                    $('#orderModal').modal('hide');
                    popNotification('success',"The order is deleted successfully.");
                    // countOrders('<?php echo $data["shop"]->id; ?>');
                    return;
                }
            });
        }
        return;
    }); 

    function countOrders(sid) {
        $('.total-o').html('<i class="fa fa-spinner fa-spin"></i>');
        $.get('/get-data/count-orders/'+sid, function(data) {
            $('.total-o').html(data.total);
        });      
    }
    
    $(document).on('submit', '.new-customer-form-2', function(e){
        e.preventDefault();
        $('.submit-new-customer').prop('disabled', true).html('submiting..');
        $('input, textarea, select').removeClass('parsley-error');
        var name = $('.new-customer-form-2 [name="name"]');
        var phone = $('.new-customer-form-2 [name="phone"]');
        var location = $('.new-customer-form-2 [name="location"]');

        if (name.val().trim() == null || name.val().trim() == '' || phone.val().trim() == null || phone.val().trim() == '' || location.val().trim() == null || location.val().trim() == '') {
            $('.submit-new-customer').prop('disabled', false).html('Submit'); }
        if (name.val().trim() == null || name.val().trim() == '') {
            name.addClass('parsley-error').focus(); return;}
        if (phone.val().trim() == null || phone.val().trim() == '') {
            phone.addClass('parsley-error').focus(); return;}
        if (location.val().trim() == null || location.val().trim() == '') {
            location.addClass('parsley-error').focus(); return;}

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        formdata.append('status','new customer');
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.submit-new-customer').prop('disabled', false).html('Submit');
                    if (data.status == "error") {
                        popNotification('warning',"Error! new customer not created, please try again.");
                    } else {
                        popNotification('success',"Success! new customer created successfully.");
                        $('.new-customer-form-2')[0].reset();
                        $('#attachCustomer').modal('hide');      
                        $('.customer').append($('<option>', {
                            value: data.customer.id,
                            text: data.customer.name
                        })).val(data.customer.id).change();
                    }
                }
        });
    });

    $(document).on('submit', '.new-supplier', function(e){
        e.preventDefault();
        $('.submit-new-supplier').prop('disabled', true).html('submiting..');

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        formdata.append('status','new supplier');
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.submit-new-supplier').prop('disabled', false).html('Submit');
                    if (data.status == "success") {
                        popNotification('success',"Success! new supplier created successfully.");
                        $('.new-supplier')[0].reset();
                        $('#newSupplier').modal('hide');    
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        openSupplierTab(data.supplier.id); 
                    } else {
                        popNotification('warning',"Error! new supplier not created, please try again.");
                    }
                }
        });
    });
    
    $(document).on('change', '.pq-select select', function(e){
        e.preventDefault();
        var pid = $(this).val();
        var suppid = (new URL(location.href)).searchParams.get('supplier_id');
        if(pid == "-") { } else {
            $.get("/suppliers/add-purchased-item/<?php echo $data['shop']->id; ?>~"+suppid+"~"+pid+"~shop", function(data){
                if(data.status == 'success') {
                    // $('.render-purchases-deposits').html('<div class="no-records">- No records yet -</div>');   
                    $('.pq-list').append('<div class="form-group pq-row-'+data.row.id+'"><label>'+data.product.name+'</label>'+
                        '<input type="number" name="pq-'+data.row.id+'" rowid="'+data.row.id+'" class="form-control p-quantity" placeholder="0" value="1" step=".01" required>'+
                        '<span class="pl-2"></span><span class="clear-pq-row2 p-2" rid="'+data.row.id+'"><i class="fa fa-times"></i></span>'+
                        '<div class="bb-price"><div><span class="rowq-'+data.row.id+'">1</span> x '+Number(data.row.buying_price).toLocaleString("en")+' = <span class="rowp-'+data.row.id+'">'+Number(data.row.total_buying).toLocaleString("en")+'</span></div></div></div>');

                    $('.pq-footer, .pq-add-pro').css('display','block');
                    $('.pq-select').css('display','none');
                    $('.pq-select select').val("-").trigger('change');                                                                      
                    var totalq = parseInt($('.pq-footer .supp-tq').text()) + 1;                                        
                    var totalp = parseInt($('.pq-footer .supp-tp').text().replace(/,/g, '')) + parseInt(data.row.total_buying);
                    $('.supp-tq').text(totalq);
                    $('.supp-tp').text(Number(totalp).toLocaleString("en"));
                }  
            });
        }
    });
    
    $(document).on('click', '.d-edit-details', function(e){
        e.preventDefault();
        var date = $(this).attr('date');
        var suppid = (new URL(location.href)).searchParams.get('supplier_id');

        $('.notification-body').html('<div class="row mb-2" align="left"><div class="col-md-12"><h6 class="mb-3"><b><span>'+date+'</span> </b></h6>'+
                    '<div class="col-12 pl-0 pr-0 mt-3"><b><?php echo $_GET["items-bought"]; ?></b><hr class="mt-1"><form id="basic-form" class="edit-submitted-details-form">'+
                    '<input type="hidden" name="date" value="'+date+'">'+
                    '<div class="bought-purchases"><span class="hide-loader"><i class="fa fa-spinner fa-spin"></i></span></div></form></div>'+
                    '<div class="col-12 pl-0 pr-0 mt-4" style="display:none"><b><?php echo $_GET["amount-you-borrow"]; ?></b><hr class="mt-1"><div class="recorded-borrows"><i class="fa fa-spinner fa-spin"></i></div></div>'+
                    '<div class="col-12 pl-0 pr-0 mt-4"><b><?php echo $_GET["amount-you-paid"]; ?></b><hr class="mt-1"><div class="recorded-deposits"><i class="fa fa-spinner fa-spin"></i></div></div>'+
                    '<div class="col-12 pl-0 pr-0 mt-5">'+
                        '<div class="mb-2" style="display:none"><button class="btn btn-info submit-edit-supplier" style="width:50%"> <?php echo $_GET["update"]; ?></button><button class="btn btn-outline-secondary ml-2" data-dismiss="modal" aria-label="Close"> <?php echo $_GET["cancel"]; ?></button></div>'+
                    '</div></div>');
        
        $('#notificationModal').modal('toggle');

        $.get("/suppliers/edit-submitted-details/<?php echo $data['shop']->id; ?>~"+suppid+"~"+date+"~shop", function(data){
            $('.hide-loader').css('display','none');
            $('.bought-purchases').append(data.output);
            $('.recorded-deposits').html(data.output2);
            $('.recorded-borrows').html(data.output3);
        });
    });
    $(document).on('click', '.update-deposited-amount', function(e){
        e.preventDefault();
        $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
        var did = $(this).attr('val');
        var amount = $('.spa-'+did).val();
        console.log(amount);
        if (amount == null || amount == "") {
            $(this).prop('disabled', false).html('<i class="fa fa-check pl-1"></i>');
            $('.spa-'+did).addClass('parsley-error').focus(); return;
        }

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData();
        formdata.append('id',did);
        formdata.append('amount',amount);
        formdata.append('status','update deposited amount');
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.update-deposited-amount').prop('disabled', false).html('<i class="fa fa-check pl-1"></i>');
                    if (data.status == "success") {
                        var suppid = (new URL(location.href)).searchParams.get('supplier_id');
                        popNotification('success','Amount updated!');
                        supplierYearSummary("<?php echo $data['shop']->id; ?>~"+suppid);
                        $('#notificationModal').modal('hide');
                    }
                }
        });
    });

// transfer records
    $(document).on('click', '.edit-transfer', function(e) {
        e.preventDefault();
        $('button').prop('disabled', true);
        $(this).html("Editing...");
        var tno = $(this).attr('transfer');
        $('#viewTransferModal').modal('hide');
        $.get('/edit-transfer/'+tno, function(data){
            $('button').prop('disabled', false);  
            if (data.status == "success") {      
                $('.transfer-items-btn').click();
            } else {
                if (data.error == 'another transfer on editing') {
                    $('.edit-error').css('display','');
                } else {
                    alert(data.error);
                }
            }
        });
    });

    $(document).on('click', '.transfer-items', function(e) {
        e.preventDefault();
        var tno = $(this).attr('transfer');
        $('.transferno').html(tno);
            $('#viewTransferModal').modal('toggle');
            $('.render-titems').html("<p>Loading...</p>");
        $.get('/transfer-items/'+tno+'/shop/<?php echo $data["shop"]->id; ?>', function(data){
            $('.render-titems').html(data.view);
        });
    });
    $(document).on('click', '.delete-transfer', function(e) {
        e.preventDefault();
        $('button').prop('disabled', true);
        $(this).html("Deleting...");
        var tno = $(this).attr('transfer');
        $('#viewTransferModal').modal('hide');
        $.get('/delete-transfer/'+tno, function(data){
            $('button').prop('disabled', false);  
            if (data.success) {
                popNotification('success',"Success! transfer has been deleted.");
                $(".change-products-option").val("transfer-products").change();
            } else {
                popNotification('warning',"Sorry, the system fails to delete transfer.");
            }
        });
    });
    $(document).on('click', '.receive-stock', function(e) {
        e.preventDefault();
        var tno = $(this).attr('transfer');
        $('button').prop('disabled', true);
        $(this).html("Receiving...");
        $('#viewTransferModal').modal('hide');
        $.get('/receive-items/'+tno, function(data){
            $('button').prop('disabled', false);  
            popNotification('success',"Success! transfer has been received.");
            $(".change-products-option").val("transfer-products").change();
        });
    });
// end transfer records

// transfer items 
$(document).on('submit', '.transfer-form2', function(e){
    e.preventDefault();
    $('.submit-transfer').prop('disabled', true).html('Adding..');
    var quantity = $('[name="quantity"]').val();
    var aquantity = $('.aquantity').text();
    if (parseInt(quantity) <= 0) {
        $('.submit-transfer').prop('disabled', false).html('Add to cart');
        popNotification('warning','Sorry! Quantity must be greater than 0.');
        $('[name="quantity"]').addClass('parsley-error').focus(); return;
    }
    if (parseInt(quantity) > parseInt(aquantity)) {
        $('.submit-transfer').prop('disabled', false).html('Add to cart');
        popNotification('warning','Sorry! The quantity cant exceed what we have in stock.');
        $('[name="quantity"]').addClass('parsley-error').focus(); return;
    }

    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    var formdata = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '/submit-transfer',
        processData: false,
        contentType: false,
        data: formdata,
            success: function(data) {
                $('.submit-transfer').prop('disabled', false).html('Add to cart');
                if (data.error) {
                    if (data.error == 'This item is already in cart') {
                        $('.ptr-'+data.id).addClass('l-parpl');
                        setTimeout(function(){
                            $('.ptr-'+data.id).removeClass('l-parpl');
                        },5000);
                    }
                    popNotification('warning',data.error);
                } else {
                    $('.render-cart').append('<tr class="ptr-'+data.row.id+'"><td>'+data.pname+'</td>'+
                        '<td>'+data.row.quantity+'</td>'+
                        '<td><span class="p-1 text-danger remove-item" val="'+data.row.id+'" style="cursor: pointer;"><i class="fa fa-times"></i></span>'+
                        '</td></tr>');
                    popNotification('success','Added.');
                }
            }
    });
});
$(document).on('click', '.clear-transfer-cart2', function(e) {
    e.preventDefault();
    var shop_id = $('[name="fromid"]').val();
    $('button').prop('disabled', true);
    $('.fa-spin').css('display','');
    $.get('/clear-transfer-cart/shop/'+shop_id, function(data){
        $('button').prop('disabled', false);  
        popNotification('success',"Success! cart is cleared.");
        transferItems();
    });
});

$(document).on('click', '.remove-item', function(e){
    e.preventDefault();
    var id = $(this).attr('val');
    $.get('/remove-transfer-row/'+id, function(data){
        if (data.error) {
            popNotification('warning',data.error);
        }
        if (data.success) {
            $('.ptr-'+data.id).closest("tr").remove();
        }            
    });
});
$(document).on('click', '.submit-transfer-cart2', function(e){
    e.preventDefault();
    var shop_id = $('[name="fromid"]').val();
    var transferno = $('[name="transferno"]').val();
    if (transferno) {} else {
        transferno = 'null';
    }
    $('button').prop('disabled', true);
    $('.fa-spin').css('display','');

    $.get('/submit-transfer-cart/shop/'+shop_id+'/'+transferno, function(data){
        $('button').prop('disabled', false);  
        popNotification('success','Success! items transfered successfully.');
        $('#transferForm').modal('hide');
        $('.modal').remove();
        $('.modal-backdrop').remove();
        $('body').removeClass( "modal-open" );
        $(".change-products-option").val("transfer-products").change();
    });
});
// end transfer items 

    // change shop || custom select
    $(".custom-select").each(function() {
      var classes = $(this).attr("class"),
          id      = $(this).attr("id"),
          name    = $(this).attr("name");
      var template =  '<div class="' + classes + '">';
          template += '<span class="custom-select-trigger">' + $(this).attr("placeholder") + '</span>';
          template += '<div class="custom-options" style="z-index:91">';
          $(this).find("option").each(function() {
            template += '<span class="custom-option ' + $(this).attr("class") + '" data-value="' + $(this).attr("value") + '">' + $(this).html() + '</span>';
          });
      template += '</div></div>';
      
      $(this).wrap('<div class="custom-select-wrapper"></div>');
      $(this).hide();
      $(this).after(template);
    });
    $(".custom-option:first-of-type").hover(function() {
      $(this).parents(".custom-options").addClass("option-hover");
    }, function() {
      $(this).parents(".custom-options").removeClass("option-hover");
    });
    $(".custom-select-trigger").on("click", function() {
      $('html').one('click',function() {
        $(".custom-select").removeClass("opened");
      });
      $(this).parents(".custom-select").toggleClass("opened");
      event.stopPropagation();
    });
    $(".custom-option").on("click", function() {
      $(this).parents(".custom-select-wrapper").find("select").val($(this).data("value"));
      $(this).parents(".custom-options").find(".custom-option").removeClass("selection");
      $(this).addClass("selection");
      $(this).parents(".custom-select").removeClass("opened");
      $(this).parents(".custom-select").find(".custom-select-trigger").text($(this).text());
    });
    // end custom select

    // js for managing edit sales     
    $(document).on('keyup', '.quantity2', function(e){
        e.preventDefault();
        var quantity2 = $(this).val();
        if (quantity2 != '') {
            var sprice2 = $('.sprice2').val();
            var total = parseFloat(quantity2)*parseFloat(sprice2);
            $('.esrp').html(Number(total).toLocaleString("en"));
            updateCustomerDetails(quantity2,sprice2,total);
        }        
    });
    $(document).on('keyup', '.sprice2', function(e){
        e.preventDefault();
        var sprice2 = $(this).val();
        if (sprice2 != '') {
            var quantity2 = $('.quantity2').val();
            var total = parseFloat(quantity2)*parseFloat(sprice2);
            $('.esrp').html(Number(total).toLocaleString("en"));
            updateCustomerDetails(quantity2,sprice2,total)
        }
    });
    function updateCustomerDetails(quantity2,sprice2,total) {
        if ($(".sale-details").hasClass("show")) {
            var totalq = $('.quantity4').val();
            var thisq = $('.quantity3').val();
            var newq = (parseFloat(totalq) - parseFloat(thisq) ) + parseFloat(quantity2);
            $('.total-q').html(parseFloat(newq));
            var totalp = $('.sprice4').val();
            var thisp = $('.sprice3').val();
            var newp = (parseFloat(totalp) - parseFloat(thisp) ) + parseFloat(total);
            $('.total-a').html(Number(newp).toLocaleString("en"));
        }
    }

    $(document).on('click','.edit-sr',function(e){
        e.preventDefault();
        $('#exampleModal').modal('toggle');
        var id = $(this).attr('val');    
        $('.edit-sale').html('Loading...');  
        $('.sale-details').addClass("hide").removeClass("show");
        $.get('/edit-sale-form/'+id, function(data) {

            $('.edit-sale').html('<tr><td><div class="row py-1">'
                        +'<div class="col-12 r-name">'+data.pname+'</div>'
                        +'<div class="col-12" align="right"> <span><input type="number" class="form-control quantity2" name="quantity2" value="'+parseFloat(data.data.qty)+'"><input type="hidden" class="quantity3" value="'+parseFloat(data.data.qty)+'"><input type="hidden" class="quantity4" value="'+parseFloat(data.data.totalqty)+'"></span> <span><i class="fa fa-times"></i></span> <span><input type="number" class="form-control sprice2" name="sprice2" value="'+Number(data.data.selling_price)+'" style="display:inline-block"><input type="hidden" class="sprice3" value="'+Number(data.data.subtotal_b)+'"><input type="hidden" class="sprice4" value="'+Number(data.data.totalamount_b)+'"></span> <span> = </span><span><b class="esrp">'+data.data.subtotal+'</b></span></div>'
                        +'<div class="col-12 pr-0 pt-2" style="text-align:right;"><i class="fa fa-spinner fa-spin spiner2" style="font-size:20px;display: none;"></i><button class="btn btn-danger delete-submitted-sale px-3" style="font-size:1.2rem;" val="'+data.data.id+'" pname="'+data.pname+'"> <i class="fa fa-trash"></i> </button><span> </span><button class="btn btn-success submit-edited-sale" val="'+data.data.id+'" style="margin-left:5px">Update</button></div>'
                        +'</div></td></tr>');

            if (data.data.customer) {
                $('.sale-details').addClass("show").removeClass("hide");
                $('.customer-name').html(data.data.customer);
                $('.sale-no').html(data.data.sale_no);
                $('.total-q').html(parseFloat(data.data.totalqty));
                $('.total-a').html(data.data.totalamount);
                $('.amount-p').html(data.data.paidamount);
                $('.edit-sale').append(data.rows);
            }
        });  
    });

    $(document).on('click', '.delete-submitted-sale', function(e){
        e.preventDefault();
        $(this).prop('disabled', true);
        var pname = $(this).attr('pname');
        
        if(confirm("Click OK to confirm that you delete "+pname+" item from sale.")){
            $('.full-cover').css('display','block');
            $('.full-cover .inside').html('Deleting...');
            var id = $(this).attr('val');

            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            var formdata = new FormData();
            formdata.append('id',id);
            formdata.append('pname',pname);
            formdata.append('status','sale row');
            $.ajax({
                type: 'POST',   
                url: '/delete',
                processData: false,
                contentType: false,
                data: formdata,
                success: function(data) {
                    $('.full-cover').css('display','none');
                    if (data.error) {
                        popNotification('warning',"Error! Something went wrong, please try again later.");
                    } else {
                        popNotification('success',"Success! item is deleted successfully.");
                        
                        $('#exampleModal').modal('hide');
                        let searchParams = new URLSearchParams(window.location.search);
                        if(searchParams.has('tab')) {
                            if(searchParams.get('tab') == "sell-products") {
                                todaySales();
                            } else {
                                $('.nav-tabs-new .report-tab').click();
                            }
                        }
                        
                        if(data.data.predate == "no") { } else { // check if it is previous date, then go to update daily sales table 
                            $.get('/update/daily-sales/'+shop_id+'~'+data.data.predate, function(data){     
                                console.log('daily sales updated');
                            });
                        }
                    }
                }
            });
        }
        return;
    });

    $(document).on('click','.submit-edited-sale',function(e){
        e.preventDefault();
        $('button').prop('disabled', true);
        var id = $(this).attr('val');    
        var quantity2 = $('input[name="quantity2"]').val();
        var sprice2 = $('input[name="sprice2"]').val();
        $('.spiner2').css('display','');  
        if (quantity2.trim() == null || quantity2.trim() == '' || parseFloat(quantity2.trim()) == 0) {            
            popNotification('warning','Please check your numbers correctly.');
            return;         
        }
        if (sprice2.trim() == null || sprice2.trim() == '' || parseFloat(sprice2.trim()) == 0) {            
            popNotification('warning','Please check your numbers correctly.');
            return;         
        }
        $.get('/submit-edited-sale/'+id+'/'+quantity2+'/'+sprice2, function(data) {
            
            $('#exampleModal').modal('hide');
            let searchParams = new URLSearchParams(window.location.search);
            if(searchParams.has('tab')) {
                if(searchParams.get('tab') == "sell-products") {
                    todaySales();
                } else {
                   
                    changeSaleDateReport();

                }
            }

            if(data.data.predate == "no") { } else { // check if it is previous date, then go to update daily sales table 
                $.get('/update/daily-sales/'+shop_id+'~'+data.data.predate, function(data){     
                    console.log('daily sales updated');
                });
            }
        });  
    });
    // end managin edit sales 
    
    $(document).on('submit', '.returned-items-form', function(e){
        e.preventDefault();
        var date_sold = $('.returned-items-form .date-sold').val();
        var today = $('.today').val();
        if (new Date(today) <= new Date(date_sold)) {
            popNotification('warning',"Date should be past. Please confirm.");
            return;
        } 
        
        $('.submit-ri-cart').prop('disabled', true).html('submiting..');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formdata = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '/submit-returned-items',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.submit-ri-cart').prop('disabled', false).html('Submit');
                    if (data.error) {
                        popNotification('warning',data.error);
                    } else {
                        popNotification('success',data.success);
                        $('.totalQr').html("0");
                        $('#returnSoldItems').modal('hide');

                        changeSaleDateReport();

                    }
                }
        });
    });

    $(document).on('submit', '.new-product', function(e){ 
        e.preventDefault();
        $('.submit-new-product').prop('disabled', true).html('submiting..');
        $('.notification-body').html('<div align="center" class="my-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>');
        var name = $('.new-product [name="name"]').val();
        var cgroup = $('.new-product [name="cgroup"]').val();
        var pcategory = $('.new-product [name="pcategory"]').val();
        var buying_price = $('.new-product [name="buying_price"]').val();
        var retail_price = $('.new-product [name="retail_price"]').val();
        var quantity = $('.new-product [name="quantity"]').val();
        var measurement = $('.new-product [name="measurement"]').val();
        if (name.trim() == null || name.trim() == '' || pcategory.trim() == null || pcategory.trim() == '' || buying_price.trim() == null || buying_price.trim() == '' || retail_price.trim() == null || retail_price.trim() == '' || measurement.trim() == null || measurement.trim() == '' || quantity.trim() == null || quantity.trim() == '') {
            popNotification('warning','Please fill all required fields');
            $('.submit-new-product').prop('disabled', false).html('Submit');
        }
        if (name.trim() == null || name.trim() == '') {
            $('.new-product [name="name"]').addClass('parsley-error').focus(); return;}
        if (buying_price.trim() == null || buying_price.trim() == '') {
            $('.new-product [name="buying_price"]').addClass('parsley-error').focus(); return;}
        if (retail_price.trim() == null || retail_price.trim() == '') {
            $('.new-product [name="retail_price"]').addClass('parsley-error').focus(); return;}
        if (quantity.trim() == null || quantity.trim() == '') {
            $('.new-product [name="quantity"]').addClass('parsley-error').focus(); return;}

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '/new-product',
            processData: false,
            contentType: false,
            data: formdata,
            success: function(data) {
                $('.submit-new-product').prop('disabled', false).html('Submit');
                if (data.error) {
                    popNotification('warning',data.error);
                } else {
                    popNotification('success',data.success);
                    $('.create-new-product').click();
                    $('.new-product [name="pcategory"]').val("").trigger('change');
                    $('.notification-body').html('<div class="row">'+
                                '<div class="col-12 text-success"><i class="fa fa-check-circle fa-2x"></i> <br> <b>'+data.pname+'</b> is created successfully </div>'+
                                '<div class="col-12 mt-5">'+
                                    '<div class="mb-4"><button class="btn btn-info" data-dismiss="modal" aria-label="Close"><i class="fa fa-plus pr-2"></i> <?php echo $_GET["create-another-product"]; ?></button></div>'+
                                    '<div style="display:none" class="mb-2"><a href="/shops/<?php echo $data["shop"]->id; ?>?tab=products&tab2=preview&pid='+data.pid+'#add-quantity" class="btn btn-secondary"><i class="fa fa-plus pr-2"></i> <?php echo $_GET["add-quantity"]; ?> (stock)</a></div>'+
                                    '<div style="display:none"><a href="/shops/<?php echo $data["shop"]->id; ?>?tab=products&pid='+data.pid+'" class="btn btn-primary"><i class="fa fa-eye pr-2"></i> <?php echo $_GET["preview"]; ?> '+data.pname+'</a></div>'+
                                    '<div style="display:none" class="mb-2"><a href="/shops/<?php echo $data["shop"]->id; ?>?tab=sell-products" class="btn btn-success"><i class="fa fa-dollar pr-2"></i> <?php echo $_GET["sell-products"]; ?></a></div>'+
                                    '<div><a href="#" class="btn btn-primary products-tab-opt" data-dismiss="modal" aria-label="Close"><i class="fa fa-eye pr-2"></i> <?php echo $_GET["see-all-products"]; ?></a></div>'+
                                '</div></div>');
                    $('#notificationModal').modal('toggle');
                }
            }
        });
    });
    
    $(document).on('submit', '.upload-products', function(e){ 
        e.preventDefault();
        $('.upload-products-btn').prop('disabled', true);
        $('#notificationModal').modal('toggle');
        $('.notification-body').html('<div align="center" class="my-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Uploading...<div>');

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        formdata.append('status','upload products');
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
            success: function(data) {
                $('.upload-products-btn').prop('disabled', false);
                $('.upload-products')[0].reset();
                if (data.status == "success") {
                    popNotification('success',"Products uploaded successfully");
                    $('.notification-body').html('<div class="row">'+
                                '<div class="col-12 text-success"><i class="fa fa-check-circle fa-2x"></i> <br> <b>Products uploaded successfully</b> </div>'+
                                '<div class="col-12 mt-5">'+
                                    '<div class="mb-4"><button class="btn btn-info" data-dismiss="modal" aria-label="Close"><i class="fa fa-plus pr-2"></i> <?php echo $_GET["create-another-product"]; ?></button></div>'+
                                    '<div><a href="#" class="btn btn-primary products-tab-opt" data-dismiss="modal" aria-label="Close"><i class="fa fa-eye pr-2"></i> <?php echo $_GET["see-all-products"]; ?></a></div>'+
                                '</div></div>');
                } else {
                    popNotification('warning',"Something wrong on submitted excel");
                    $('.notification-body').html('<div class="row">'+
                        '<div class="col-12"><h4>Please Crosscheck below fields in your Excel and upload again:</h4></div>'+
                        '<div class="col-12 mt-2" align="left" style="min-height:200px;max-height:60vh;overflow-y: scroll;overflow-x: hidden;">'+
                        data.errors
                        +'</div></div>');
                }
            }
        });
    });
    
    $(document).on('click','.remove-from-shop',function(e){
        e.preventDefault();
        var name = $(this).attr('name');
        var pid = $(this).attr('product');
        var sid = $(this).attr('shop');
        $('.notification-body').html('<div class="row">'+
                    '<div class="col-12"><i class="fa fa-warning fa-2x text-warning"></i> <br> Please confirm that you are removing <b>'+name+'</b> from this shop </div>'+
                    '<div class="col-12 mt-5">'+
                        '<div class="mb-2"><button class="btn btn-danger confirm-remove-from-shop" shop="'+sid+'" product="'+pid+'"><i class="fa fa-trash pr-2"></i> <?php echo $_GET["remove"]; ?></button><button class="btn btn-outline-secondary ml-2" data-dismiss="modal" aria-label="Close"> <?php echo $_GET["cancel"]; ?></button></div>'+
                    '</div></div>');
        
        $('#notificationModal').modal('toggle');
    });
    $(document).on('click','.confirm-remove-from-shop', function(e) {
        e.preventDefault();
        var pid = $(this).attr('product');
        var sid = $(this).attr('shop');
        var shop_pro = sid+'~'+pid;
        $('.notification-body').html('<div align="center" class="my-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Removing...<div>');

        $.get('/update/remove-product-from-shop/'+shop_pro, function(data) {
            if(data.status == "success") {
                $('#notificationModal').modal('hide');
                popNotification('success',name+' is removed successfully');      
                $('.products-tab-opt').click();     
            }  else {
                popNotification('warning',name+' failed to remove, Please try again.');
            }
        });            
    });

    $(document).on('click','.delete-product',function(e){
        e.preventDefault();
        var name = $(this).attr('name');
        var pid = $(this).attr('product');
        $('.notification-body').html('<div class="row">'+
                    '<div class="col-12"><i class="fa fa-warning fa-2x text-warning"></i> <br> Please confirm that you are deleting <b>'+name+'</b> </div>'+
                    '<div class="col-12 mt-5">'+
                        '<div class="mb-2"><button class="btn btn-danger confirm-delete-product" product="'+pid+'"><i class="fa fa-trash pr-2"></i> <?php echo $_GET["delete"]; ?></button><button class="btn btn-outline-secondary ml-2" data-dismiss="modal" aria-label="Close"> <?php echo $_GET["cancel"]; ?></button></div>'+
                    '</div></div>');
        
        $('#notificationModal').modal('toggle');
    });
    $(document).on('click','.confirm-delete-product',function(e){
        e.preventDefault();
        var id = $(this).attr('product');
        $('.notification-body').html('<div align="center" class="my-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Deleting...<div>');

        $.get('/delete-product/'+id, function(data) {
            if(data.success == "success") {
                $('#notificationModal').modal('hide');
                popNotification('success',data.name+' is deleted successfully');      
                $('.products-tab-opt').click();          
            } else {
                popNotification('warning','failed to delete product, Please try again.');
            }
        });            
    });
    
    $(document).on('click','.pro-actions .change-quantity', function(e){
        e.preventDefault();
        var pname = $('.pro-actions [name="pname"]').val();
        var sname = $('.pro-actions [name="sname"]').val();
        var pid = $('.pro-actions [name="pid"]').val();
        var sid = $('.pro-actions [name="sid"]').val();
        var pqty = $(this).attr('qty');
        
        $('#notificationModal').modal('toggle');
        $('.notification-body').html('<div class="row change-q-form">'+
                    '<div class="col-12"> Change Quantity of <b>'+pname+'</b> in <b>'+sname+'</b> shop </div>'+
                    '<div class="col-12 mt-3">'+
                        '<div><?php echo $_GET["available-quantity"]; ?> <br> <h2>'+pqty+'</h2></div>'+
                        '<div><?php echo $_GET["fill-new-quantity"]; ?> <br> <input type="number" name="qty" class="form-control" placeholder="0" style="width:100px">'+
                        '<div class="mt-3"><?php echo $_GET["why-you-change"]; ?> ? <br> <textarea class="form-control" name="desc" style="width:200px"></textarea></div>'+
                        '<div class="col-12 mb-2 mt-3"><button class="btn btn-info confirm-change-quantity"><i class="fa fa-check pr-2"></i> Submit</button><button class="btn btn-outline-secondary ml-2" data-dismiss="modal" aria-label="Close"> <?php echo $_GET["cancel"]; ?></button></div>'+
                    '</div></div>');
    });    
    $(document).on("click", ".confirm-change-quantity", function(e) {
        e.preventDefault();
        var id = $('.pro-actions [name="shop_product"]').val();
        var quantity = $('.change-q-form [name="qty"]').val();
        var desc = $('.change-q-form [name="desc"]').val();
        
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData();
        formdata.append('id',id);
        formdata.append('quantity',quantity);
        formdata.append('desc',desc);
        formdata.append('status','shop');
        $('.notification-body').html('<div align="center" class="my-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Updating...<div>');
        $.ajax({
            type: 'POST',
            url: '/update-adjust-stock',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    if (data.error) {
                        popNotification('warning',data.error);
                    } else {
                        $('#notificationModal').modal('hide');
                        $('.pro-review .change-product').change();
                        popNotification('success','Successful quantity updated');
                    }
                }
        });
    });
    
    $(document).on('click','.pro-actions .add-quantity', function(e){
        e.preventDefault();
        var pname = $('.pro-actions [name="pname"]').val();
        var sname = $('.pro-actions [name="sname"]').val();
        var pqty = $(this).attr('qty');

        "<?php if(Auth::user()->company->cashier_stock_approval == 'no') {  ?>";
        var approval = '<div style="display:none"><input type="radio" name="approvalRequired" value="no" checked></div>';
        "<?php } else { ?>";
        var approval = '<div class="form-group mt-3"><label><?php echo $_GET["is-cashier-checkup-required"]; ?> ?</label><br>'+
                        '<label class="fancy-radio"><input type="radio" name="approvalRequired" value="yes" required="" data-parsley-errors-container="#error-radio" data-parsley-multiple="approvalRequired" checked><span><i></i><?php echo $_GET["yes"]; ?></span></label>'+
                        '<label class="fancy-radio"><input type="radio" name="approvalRequired" value="no" required="" data-parsley-errors-container="#error-radio" data-parsley-multiple="approvalRequired" ><span><i></i><?php echo $_GET["no"]; ?></span></label>';
        "<?php } ?>";
        
        $('#notificationModal').modal('toggle');
        $('.notification-body').html('<div class="row add-q-form">'+
                    '<div class="col-12"> Add Quantity of <b>'+pname+'</b> in <b>'+sname+'</b> shop </div>'+
                    '<div class="col-12 mt-3">'+
                        '<div><?php echo $_GET["available-quantity"]; ?> <br> <h2>'+pqty+'</h2></div>'+
                        '<div><?php echo $_GET["quantity-you-add"]; ?> <br> <input type="number" name="qty" class="form-control" placeholder="0" style="width:100px">'+
                        approval+
                        '<div class="col-12 mb-2 mt-4"><button class="btn btn-info confirm-add-quantity"><i class="fa fa-check pr-2"></i> <?php echo $_GET["add"]; ?></button><button class="btn btn-outline-secondary ml-2" data-dismiss="modal" aria-label="Close"> <?php echo $_GET["cancel"]; ?></button></div>'+
                    '</div></div>');
    });     
    $(document).on("click", ".confirm-add-quantity", function(e) {
        e.preventDefault();
        var pid = $('.pro-actions [name="pid"]').val();
        var sid = $('.pro-actions [name="sid"]').val();
        var quantity = $('.add-q-form [name="qty"]').val();
        var approval = $('.add-q-form [name="approvalRequired"]:checked').val();

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData();
        formdata.append('pid',pid);
        formdata.append('sid',sid);
        formdata.append('quantity',quantity);
        formdata.append('approval',approval);
        formdata.append('status','add shop quantity');
        $('.notification-body').html('<div align="center" class="my-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Updating...<div>');
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    if (data.status == "success") {
                        $('#notificationModal').modal('hide');
                        $(".change-products-option").val("products-in").change();
                        popNotification('success','Successful quantity (stock) added');
                    } else {
                        popNotification('warning',"System Failed to add quantity. please try again later.");
                    }
                }
        });
    });
    
    $(document).on('click','.pro-actions .edit-product', function(e){
        e.preventDefault();
        var pid = $('.pro-actions [name="pid"]').val();
        $('#editProduct').modal('show');
        $('#editProduct .modal-body').html('<div align="center" class="py-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>');
        
        $.get('/get-data/edit-product/product~'+pid, function(data) {
            $('#editProduct .modal-body').html(data.view);
        });           
    });    
    $(document).on('click','.cancel-edit-pro', function(e){
        e.preventDefault();
        $('.change-product').change();
    });    
    $(document).on('click', '.update-product-3', function(e){
        e.preventDefault();
        $(this).prop('disabled', true).html('updating..');
        var name = $('.update-product-form [name="name"]').val();
        var cgroup = $('.update-product-form [name="cgroup"]').val();
        var pcategory = $('.update-product-form [name="pcategory"]').val();
        var buying_price = $('.update-product-form [name="buying_price"]').val();
        var retail_price = $('.update-product-form [name="retail_price"]').val();
        if (name.trim() == null || name.trim() == '' || pcategory.trim() == null || pcategory.trim() == '' || buying_price.trim() == null || buying_price.trim() == '' || retail_price.trim() == null || retail_price.trim() == '') {
            popNotification('warning','Please fill all required fields');
            $('.update-product').prop('disabled', false).html("<?php echo $_GET['update-changes']; ?>");
        }
        
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData($('form.update-product-form')[0]);
        formdata.append('s_status','from shop');
        $.ajax({
            type: 'POST',
            url: '/update-product',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {                     
                    if (data.status == "success") {
                        $('#editProduct').modal('hide');
                        $('.pro-review .change-product').change();
                        popNotification('success','Success! product '+data.pname+' is updated');
                    } else {
                        $('update-product-3').prop('disabled', false).html('<?php echo $_GET["update-changes"]; ?>');
                        popNotification('warning',"System Failed to update product. please try again.");
                    }
                }
        });
    });
    $(document).on('click', '.deleted-products', function(e){
        e.preventDefault();        
        $('#deletedProducts').modal('toggle');
        $('.list-deleted-products').html('<div align="center"><i class="fa fa-spinner fa-spin pr-2"></i> Loading..</div>');
        $.get("/get-data/deleted-products/<?php echo $data['shop']->id; ?>", function(data){
            $('.list-deleted-products').html("");
            if ($.isEmptyObject(data.products)) {
                $('.list-deleted-products').html('<div align="center">- Hakuna mteja -</div>');
            } else {              
                for (let i = 0; i < data.products.length; i++) {
                    $('.list-deleted-products').append('<div class="row pb-1"><div class="col-9">'
                        +'<div><b>'+data.products[i]["name"]+'</b></div>'
                        +'<div><small>BP: <b>'+Number(data.products[i]["buying_price"]).toLocaleString('en')+'</b> .. SP: <b>'+Number(data.products[i]["retail_price"]).toLocaleString('en')+'</b></small></div></div>'
                        +'<div class"col-3"><button class="btn btn-info btn-sm mt-2 restore-product" pid="'+data.products[i]["pid"]+'"><?php echo $_GET["restore"]; ?> <i class="fa fa-undo pl-1"></i></button></div></div>');
                }
            }                 
        });
    });
    $(document).on('click', '.restore-product', function(e){
        e.preventDefault();        
        var pid = $(this).attr('pid');
        $('.restore-product').prop('disabled', true);
        $(this).html('<i class="fa fa-spinner fa-spin px-1"></i>');
        $.get("/get-data/restore-product/"+pid+"~<?php echo $data['shop']->id; ?>", function(data){
            $('#deletedProducts').modal('hide'); 
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            popNotification('success','Product restored successfully');
            $('.change-products-option').change();
        });
    });
    
    $(document).on('submit','.add-product-quantity-form',function(e){
        e.preventDefault();
        var from = $('.search-p [name="from"]').val();
        if(from == "shop") {
            var shopid = $('.search-p [name="shopid"]').val();
            var storeid = null;
        }
        if(from == "store") {
            var storeid = $('.search-p [name="storeid"]').val();
            var shopid = null;
        }
        $('.pq-body').html('<div align="center" class="my-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Updating...<div>');

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        formdata.append('status','add product quantity');
        formdata.append('from',from);
        formdata.append('shopid',shopid);
        formdata.append('storeid',storeid);
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    if (data.status == "success") {
                        $(".change-products-option").val("products-in").change();
                        $('#addPQuantity').modal('hide'); $(document.body).removeClass("modal-open"); $(".modal-backdrop").remove();
                        popNotification('success','Quantity has been added successfully');
                    } else {
                        popNotification('warning',"Error! System failed to add Quantity. Please try again.");
                    }
                }
        });              
    });
    
    $(document).on('click', '.clear-pq-row', function(e){
        e.preventDefault();
        var rowid = $(this).attr('rid');
        $('.pq-row-'+rowid).fadeOut(300, function() { $(this).remove(); });
    });
    
    $(document).on('submit','.search-customer-form',function(e){ // this is not used
        e.preventDefault();
        $('.customers-tbody').html('<tr class="cust-load"><td colspan="3" align="center" class="py-2"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...</td></tr>'); 
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formdata = new FormData(this);
        formdata.append('status','search customer');
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.cust-load').css('display','none');
                    $.when( $('.customers-tbody').append(data.view) ).done(function() {
                        $.each( data.data.customers, function( key, value ) {
                            var data2 = "<?php echo $data['shop']->id; ?>~"+value.id;
                            $.get('/available-debt/customer/'+data2, function(data3) {    
                                $('.ddb-'+data3.id).html(data3.total);
                            }); 
                        });
                    });
                }
        });
    });

    $(document).on('click','.search-customer-btn',function(e){     
        $('.customers-tbody').html('<tr><td colspan="2" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading..</td></tr>');
        var cname = $('.search-p input[name="cname"]').val();
        $.get('/searched-customers/customer/'+shop_id+'~'+cname, function(data) {    
            if ($.isEmptyObject(data.customers)) {
                $('.customers-tbody').html('<td colspan="3" align="center"><i>-- <?php echo $_GET["empty-records"]; ?> --</i></td>');
            } else {
                $('.customers-tbody').html("");
                for (let i = 0; i < data.customers.length; i++) {
                    var profile = "";
                    var gender = data.customers[i]["cgender"];
                    if (gender == "Female") {
                        profile = "/images/xs/woman2.png";
                    } else {
                        profile = "/images/xs/man.png";
                    }
                    var totald = Number(data.customers[i]["a_interest"]) + Number(data.customers[i]["d_amount"]);
                    if (Number(totald) < 0) { // customer anadai duka
                        totald = '<b class="text-success">'+Number(Math.abs(totald)).toLocaleString('en')+'</b>';
                    } else if (Number(totald) > 0) { // customer anadaiwa
                        totald = '<b class="text-danger">'+Number(totald).toLocaleString('en')+'</b>';
                    } else {
                        totald = 0;
                    }
                    $('.customers-tbody').append(
                        '<tr class="customer-row c-'+data.customers[i]["cid"]+'" cid="'+data.customers[i]["cid"]+'">'
                        +'<td class="first-td" style="white-space: normal !important;word-wrap: break-word;">'
                        +'<span style="display:inline-flex;">'
                            +'<img src="'+profile+'" class="rounded-circle avatar mr-2" alt="">'
                            +'<span style="display: inline-block;"><h6 class="margin-0 pb-1"><a href="#">'+data.customers[i]["cname"]+'</a></h6>'
                            +'<small><i class="fa fa-map-marker"></i> '+data.customers[i]["clocation"]+'</small></span>'
                        +'</span></td>'
                        +'<td>'+totald+'</td>'
                        +'<td align="right"><b><i class="fa fa-angle-right fa-2x"></i></b></td>'
                        +'</tr>'
                    );                
                }
            }
        }); 
    });

    $(document).on('click', '.show-more-sales', function(e){ 
        e.preventDefault();
        $('.sales-report').append("<tr class='loader p-5'><td colspan='6'><i class='fa fa-spinner fa-spin'></i> Loading...</td></tr>");
        $('.see-more-sales').css('display','none');
        var d = new Date();
        var date = d.getDate();
        var month = d.getMonth()+1; 
        var year = d.getFullYear();
        $.get('/sales-by-date/today-sales/'+date+'/'+month+'/'+year+'/'+shop_id, function(data) {
            $('.sales-report .loader').css('display','none');
            if ($.isEmptyObject(data.items)) {
                
            } else {
                var num = 6;
                var displaynone = "displaynone";
                for (let i = 5; i < data.items.length; i++) {
                    if(data.data.is_ceo === true) {
                        displaynone = "";
                    } else {
                        if(data.data.uid == data.items[i]['uid']) {
                            displaynone = "";
                        } else {
                            var displaynone = "displaynone";
                        }
                    }
                    $('.sales-report').append('<tr class="sr-'+data.items[i]["sid"]+'"><td><div class="row py-1">'
                        +'<div class="col-12 r-name">'+ num +'). '+data.items[i]["pname"]+''
                        +'<span class="p-1 pull-right text-danger edit-sr '+displaynone+'" val="'+data.items[i]["sid"]+'" style="cursor: pointer;"><i class="fa fa-pencil-square-o" style="font-size:1.5rem;"></i></span></div>'
                        +'<div class="col-12" style="font-size:1rem" align="right"> <span>'+Number(data.items[i]["sqty"])+'</span> <span><i class="fa fa-times"></i></span> <span>'+Number(data.items[i]["sprice"]).toLocaleString('en')+'</span> <span>=</span><span><b>'+Number(data.items[i]["tsales"]).toLocaleString('en')+'</b></span></div>'
                        +'</div></td></tr>');
                    num++;
                }
            }
        });
    });

    function salesByDate(s_date,shop_id){ // this is called from sales-report page
        $('.sales-report, .closure-sale-2').html("<tr class='loader'><td colspan='6' align='center'><div class='py-2'><i class='fa fa-spinner fa-spin fa-2x'></i> Loading...</div></td></tr>");
        $('.returned-block,.returned-block2,.expenses,.deni,.ameweka,.tumelipa,.load-more-s-b,.sales-report-2').css('display','none');
        $('.totalSQ,.totalSP').html(0);
        $.get('/sales-by-date/cashier-15-sales/'+s_date+'/'+shop_id, function(data) {
            $('.sales-report .loader').css('display','none');
            if ($.isEmptyObject(data.items)) {
                $('.sales-report').html('<tr><td class="py-3" align="center"><i>-- No Sales --</i></td></tr>');
            } else {
                var num = 1;
                var displaynone = "displaynone";
                var s_date2 = s_date.split('/');
                var s_date3 = s_date2[2]+"-"+s_date2[1]+"-"+s_date2[0];
                var today = new Date(s_date3); 
                var today2 = new Date();
                $('.totalSQ').html(Number(data.total[0]['totalQ']));
                $('.totalSP').html(Number(data.total[0]['totalS']).toLocaleString("en"));
                for (let i = 0; i < data.items.length; i++) {
                    if(data.data.is_ceo === true) {
                        displaynone = "";
                    } else {
                        if(data.data.uid == data.items[i]['uid'] && today.toDateString() === today2.toDateString()) {
                            displaynone = "";
                        } else {
                            var displaynone = "displaynone";
                        }
                    }
                    $('.sales-report').append('<tr class="sr-'+data.items[i]["sid"]+'"><td><div class="row py-1">'
                        +'<div class="col-12 r-name">'+ num +'). '+data.items[i]["pname"]+''
                        +'<span class="p-1 pull-right text-danger edit-sr '+displaynone+'" val="'+data.items[i]["sid"]+'" style="cursor: pointer;"><i class="fa fa-pencil-square-o" style="font-size:1.5rem;"></i></span></div>'
                        +'<div class="col-12" style="font-size:1rem" align="right"> <span>'+Number(data.items[i]["sqty"])+'</span> <span><i class="fa fa-times"></i></span> <span>'+Number(data.items[i]["sprice"]).toLocaleString('en')+'</span> <span>=</span><span><b>'+Number(data.items[i]["tsales"]).toLocaleString('en')+'</b></span></div>'
                        +'</div></td></tr>');
                    num++;
                }
                if (data.data.count > 15) {
                    $('.load-more-s-b').css('display','table-row-group');
                }
            }
            
            if (data.data.expenses != 0) {
                $('.expenses').css('display','');
                $('.totalE').html(Number(data.data.expenses).toLocaleString('en'));
            }
            if (data.data.deni != 0) {
                $('.deni').css('display','');
                $('.totalD').html(Number(data.data.deni).toLocaleString('en'));
            }
            if (data.data.ameweka != 0) {
                $('.ameweka').css('display','');
                $('.totalA').html(Number(Math.abs(data.data.ameweka)).toLocaleString('en'));
            }
            if (data.data.tumelipa != 0) {
                $('.tumelipa').css('display','');
                $('.totalT').html(Number(data.data.tumelipa).toLocaleString('en'));
            }
            // returned items
            if (data.data.returned != 0) {
                $('.returned-block').css('display','');     
                $('.render-returned-items').html("");
                var today = "<?php echo date('Y-m-d'); ?>";           
                if ($.isEmptyObject(data.data.returned)) { } else {
                    for (let j = 0; j < data.data.returned.length; j++) {
                        var lrow = "";
                        if(data.data.returned[j]['updated'] == today) {
                            var lrow = '<td><span class="p-1 text-danger remove-ri" val="'+data.data.returned[j]['rid']+'" style="cursor: pointer;"><i class="fa fa-times"></i></span></td>';
                        }
                        $('.render-returned-items').append('<tr class="ri-'+data.data.returned[j]['rid']+'"><td>'+data.data.returned[j]['pname']+'</td>'
                            +'<td>'+Number(data.data.returned[j]['rquantity'])+'</td>'
                            +'<td class="align-right">'+data.data.returned[j]['solddate']+'</td>'
                            +lrow+'</tr>');
                    }
                }
            }
            if (data.data.returned2 != 0) {
                $('.returned-block2').css('display','');    
                $('.render-returned-items2').html("");      
                if ($.isEmptyObject(data.data.returned2)) { } else {
                    for (let j = 0; j < data.data.returned2.length; j++) {
                        $('.render-returned-items2').append('<tr class="ri-'+data.data.returned2[j]['rid']+'"><td>'+data.data.returned2[j]['pname']+'</td>'
                            +'<td>'+Number(data.data.returned2[j]['rquantity'])+'</td>'
                            +'<td class="align-right">'+data.data.returned2[j]['updated']+'</td>'
                            +'</tr>');
                    }
                }
            }
            
        });
          //   below section is not used for now 
          var fromdate = s_date.replace(/\//g, "-");
          var todate = fromdate;
          $('.view-deni,.view-ameweka,.view-tumelipa,.view-expenses-2').attr('date',todate);
    }      
    function salesByDate2(s_date,shop_id){ // this is executed when user change views
        $('.sales-report').html("<tr class='loader'><td colspan='6' align='center'><div class='py-2'><i class='fa fa-spinner fa-spin fa-2x'></i> Loading...</div></td></tr>");
        $.get('/sales-by-date/cashier-view-changed/'+s_date+'/'+shop_id, function(data) { //s_date has three partitions. date,m & y
            $('.sales-report .loader').css('display','none');
            if ($.isEmptyObject(data.items)) {
                
            } else {
                var num = 1;
                var displaynone = "displaynone";
                var s_date2 = s_date.split('/');
                var s_date3 = s_date2[2]+"-"+s_date2[1]+"-"+s_date2[0];
                var today = new Date(s_date3); 
                var today2 = new Date();
                for (let i = 0; i < data.items.length; i++) {
                    if(data.data.is_ceo === true) {
                        displaynone = "";
                    } else {
                        if(data.data.uid == data.items[i]['uid'] && today.toDateString() === today2.toDateString()) {
                            displaynone = "";
                        } else {
                            var displaynone = "displaynone";
                        }
                    }
                    $('.sales-report').append('<tr class="sr-'+data.items[i]["sid"]+'"><td><div class="row py-1">'
                        +'<div class="col-12 r-name">'+ num +'). '+data.items[i]["pname"]+''
                        +'<span class="p-1 pull-right text-danger edit-sr '+displaynone+'" val="'+data.items[i]["sid"]+'" style="cursor: pointer;"><i class="fa fa-pencil-square-o" style="font-size:1.5rem;"></i></span></div>'
                        +'<div class="col-12" style="font-size:1rem" align="right"> <span>'+Number(data.items[i]["sqty"])+'</span> <span><i class="fa fa-times"></i></span> <span>'+Number(data.items[i]["sprice"]).toLocaleString('en')+'</span> <span>=</span><span><b>'+Number(data.items[i]["tsales"]).toLocaleString('en')+'</b></span></div>'
                        +'</div></td></tr>');
                    num++;
                }
            }
        });
    }

    $(document).on('change','.sales-view',function(e){
        e.preventDefault();
        var opt = $(this).val();
        var s_date = $('.date-of-sale').val();
        $('.sales-report-2').css('display','none');
        if(opt == "all-sales") {
            salesByDate2(s_date,shop_id);
        } else if (opt == "sales-w-customers") {
            // $('.sales-report-2').css('display','table-row-group');
            salesByDatewithCustomer2(s_date,shop_id);
        } else if (opt == "sales-w-sellers") {
            salesByDatewithSellers2(s_date,shop_id);
        } else if (opt == "sales-w-sale-numbers") {
            salesWithSaleNumbers2(s_date,shop_id);
        } else if (opt == "sales-w-payment-options") {
            salesWithPaymentOption2(s_date,shop_id);
        }
    });

    function salesByDatewithCustomer(s_date,shop_id){ // this is called from sales-report page
        $('.sales-report, .closure-sale-2').html("<tr><td align='center'><div class='py-2'><i class='fa fa-spinner fa-spin fa-2x'></i> Loading...</div></td></tr>");
        $('.returned-block,.returned-block2,.expenses,.deni,.ameweka,.tumelipa,.load-more-s-b').css('display','none');
        $('.totalSQ,.totalSP').html(0);
        $.get('/sales-by-date-with-customer/cashier-date-changed/'+s_date+'/'+shop_id, function(data) {       
            if ($.isEmptyObject(data.total)) { } else {
                $('.totalSQ').html(Number(data.total[0]['totalQ']));
                $('.totalSP').html(Number(data.total[0]['totalS']).toLocaleString("en"));
            }
            if ($.isEmptyObject(data.customers)) {
                $('.sales-report').html("<tr><td class='py-3' align='center'>- No sales assigned with Customer -</td></tr>");
            } else {
                $('.sales-report').html("");
                for (let j = 0; j < data.customers.length; j++) {
                    $('.sales-report').append(
                        '<tr><td><tbody style="display:block">'
                        +'<tr style="border-bottom:none"><td class="pt-3"><div class="p-2" style="background:#fff;">'+data.customers[j]['cname']+'</div></td></tr>'
                        +'<tr><td style="border-top:none" class="cs-'+data.customers[j]['cid']+' py-2"><i class="fa fa-spinner fa-spin"></i></td></tr>'
                        +'</tbody></td></tr>'
                    );
                }
                var today = "<?php echo date('Y-m-d'); ?>";   
                var user = "<?php echo Auth::user()->id; ?>";
                for (let k = 0; k < data.sales.length; k++) {
                    $('.cs-'+data.sales[k]['cid']+' .fa-spin').css('display','none');
                    var tr = "";
                    if (data.sales[k]['updated'] == today && user == data.sales[k]['soldby']) {
                        tr = '<span class="p-1 pull-right text-danger edit-sr" val="'+data.sales[k]['rid']+'" style="cursor: pointer;"><i class="fa fa-pencil-square-o" style="font-size:1.5rem;"></i></span>';
                    } 
                    $('.cs-'+data.sales[k]['cid']).append(
                        '<tr style="display:block;border-bottom:none" class="sr-'+data.sales[k]['rid']+'"><td style="display:block"><div class="row">'
                        +'<div class="col-12 r-name">'+data.sales[k]['pname']+''+tr+'</div>'
                        +'<div class="col-12" style="font-size:1rem" align="right"> <span>'+Number(data.sales[k]['squantity'])+'</span> <span><i class="fa fa-times"></i></span> <span>'+Number(data.sales[k]['sprice']).toLocaleString('en')+'</span> <span>=</span><span><b>'+Number(data.sales[k]['tsales']).toLocaleString('en')+'</b></span></div>'
                        +'</div></td></tr>'
                    )
                }
            }
            
            $('.sales-report').append(
                '<tr><td><tbody style="display:block">'
                +'<tr style="border-bottom:none"><td class="pt-3"><div class="p-2" style="background:#fff;"><?php echo $_GET["no-customer-sales"]; ?></div></td></tr>'
                +'<tr><td style="border-top:none" class="no-customer-sales py-2" align="center"><button class="btn btn-primary no-customer-sales-btn my-2"><?php echo $_GET["sales-with-no-customer"]; ?> <i class="fa fa-arrow-right pl-2"></i></button></td></tr>'
                +'</tbody></td></tr>'
            );

            if (data.data.expenses != 0) {
                $('.expenses').css('display','');
                $('.totalE').html(Number(data.data.expenses).toLocaleString('en'));
            }
            if (data.data.deni != 0) {
                $('.deni').css('display','');
                $('.totalD').html(Number(data.data.deni).toLocaleString('en'));
            }
            if (data.data.ameweka != 0) {
                $('.ameweka').css('display','');
                $('.totalA').html(Number(Math.abs(data.data.ameweka)).toLocaleString('en'));
            }
            if (data.data.tumelipa != 0) {
                $('.tumelipa').css('display','');
                $('.totalT').html(Number(data.data.tumelipa).toLocaleString('en'));
            }
            // returned items
            if (data.data.returned != 0) {
                $('.returned-block').css('display','');     
                $('.render-returned-items').html("");
                var today = "<?php echo date('Y-m-d'); ?>";           
                if ($.isEmptyObject(data.data.returned)) { } else {
                    for (let j = 0; j < data.data.returned.length; j++) {
                        var lrow = "";
                        if(data.data.returned[j]['updated'] == today) {
                            var lrow = '<td><span class="p-1 text-danger remove-ri" val="'+data.data.returned[j]['rid']+'" style="cursor: pointer;"><i class="fa fa-times"></i></span></td>';
                        }
                        $('.render-returned-items').append('<tr class="ri-'+data.data.returned[j]['rid']+'"><td>'+data.data.returned[j]['pname']+'</td>'
                            +'<td>'+Number(data.data.returned[j]['rquantity'])+'</td>'
                            +'<td class="align-right">'+data.data.returned[j]['solddate']+'</td>'
                            +lrow+'</tr>');
                    }
                }
            }
            if (data.data.returned2 != 0) {
                $('.returned-block2').css('display','');    
                $('.render-returned-items2').html("");      
                if ($.isEmptyObject(data.data.returned2)) { } else {
                    for (let j = 0; j < data.data.returned2.length; j++) {
                        $('.render-returned-items2').append('<tr class="ri-'+data.data.returned2[j]['rid']+'"><td>'+data.data.returned2[j]['pname']+'</td>'
                            +'<td>'+Number(data.data.returned2[j]['rquantity'])+'</td>'
                            +'<td class="align-right">'+data.data.returned2[j]['updated']+'</td>'
                            +'</tr>');
                    }
                }
            }
        });
        //   below section is not used for now 
          var fromdate = s_date.replace(/\//g, "-");
          var todate = fromdate;
          $('.view-deni,.view-ameweka,.view-tumelipa,.view-expenses-2').attr('date',todate);
    }
    function salesByDatewithCustomer2(s_date,shop_id){ 
        $('.sales-report').html("<tr><td align='center'><div class='py-2'><i class='fa fa-spinner fa-spin fa-2x'></i> Loading...</div></td></tr>");
        $('.load-more-s-b').css('display','none');
        $.get('/sales-by-date-with-customer/cashier-view-changed/'+s_date+'/'+shop_id, function(data) { //s_date has three partitions. date,m & y            
            if ($.isEmptyObject(data.customers)) {
                $('.sales-report').html("<tr><td class='py-3' align='center'>- No sales assigned with Customer -</td></tr>");
            } else {
                $('.sales-report').html("");
                for (let j = 0; j < data.customers.length; j++) {
                    $('.sales-report').append(
                        '<tr><td><tbody style="display:block">'
                        +'<tr style="border-bottom:none"><td class="pt-3"><div class="p-2" style="background:#fff;">'+data.customers[j]['cname']+'</div></td></tr>'
                        +'<tr><td style="border-top:none" class="cs-'+data.customers[j]['cid']+' py-2"><i class="fa fa-spinner fa-spin"></i></td></tr>'
                        +'</tbody></td></tr>'
                    );
                }
                var today = "<?php echo date('Y-m-d'); ?>";   
                var user = "<?php echo Auth::user()->id; ?>";
                for (let k = 0; k < data.sales.length; k++) {
                    $('.cs-'+data.sales[k]['cid']+' .fa-spin').css('display','none');
                    var tr = "";
                    if (data.sales[k]['updated'] == today && user == data.sales[k]['soldby']) {
                        tr = '<span class="p-1 pull-right text-danger edit-sr" val="'+data.sales[k]['rid']+'" style="cursor: pointer;"><i class="fa fa-pencil-square-o" style="font-size:1.5rem;"></i></span>';
                    } 
                    $('.cs-'+data.sales[k]['cid']).append(
                        '<tr style="display:block;border-bottom:none" class="sr-'+data.sales[k]['rid']+'"><td style="display:block"><div class="row">'
                        +'<div class="col-12 r-name">'+data.sales[k]['pname']+''+tr+'</div>'
                        +'<div class="col-12" style="font-size:1rem" align="right"> <span>'+Number(data.sales[k]['squantity'])+'</span> <span><i class="fa fa-times"></i></span> <span>'+Number(data.sales[k]['sprice']).toLocaleString('en')+'</span> <span>=</span><span><b>'+Number(data.sales[k]['tsales']).toLocaleString('en')+'</b></span></div>'
                        +'</div></td></tr>'
                    )
                }
            }
            
            $('.sales-report').append(
                '<tr><td><tbody style="display:block">'
                +'<tr style="border-bottom:none"><td class="pt-3"><div class="p-2" style="background:#fff;"><?php echo $_GET["no-customer-sales"]; ?></div></td></tr>'
                +'<tr><td style="border-top:none" class="no-customer-sales py-2" align="center"><button class="btn btn-primary no-customer-sales-btn my-2"><?php echo $_GET["sales-with-no-customer"]; ?> <i class="fa fa-arrow-right pl-2"></i></button></td></tr>'
                +'</tbody></td></tr>'
            );

        });
    }
    
    function salesByDatewithSellers(s_date,shop_id){ // this is called from sales-report page
        $('.sales-report, .closure-sale-2').html("<tr><td colspan='6' align='center'><div class='py-2'><i class='fa fa-spinner fa-spin fa-2x'></i> Loading...</div></td></tr>");
        $('.returned-block,.returned-block2,.expenses,.deni,.ameweka,.tumelipa,.load-more-s-b').css('display','none');
        $('.totalSQ,.totalSP').html(0);
        $.get('/sales-by-date-with-sellers/cashier-date-changed/'+s_date+'/'+shop_id, function(data) {        
            if ($.isEmptyObject(data.total)) { } else {
                $('.totalSQ').html(Number(data.total[0]['totalQ']));
                $('.totalSP').html(Number(data.total[0]['totalS']).toLocaleString("en"));
            }  
            if ($.isEmptyObject(data.sellers)) {
                $('.sales-report').html("<tr><td class='py-3' align='center'>- No sales Recorded -</td></tr>");
            } else {
                $('.sales-report').html("");
                for (let j = 0; j < data.sellers.length; j++) {
                    $('.sales-report').append(
                        '<tr><td><tbody style="display:block">'
                        +'<tr style="border-bottom:none"><td class="pt-3"><div class="p-2" style="background:#fff;">'+data.sellers[j]['uname']+'<div align="right" style="display:inline-block;float:right;font-size:1rem"><b>'+Number(data.sellers[j]['tsales']).toLocaleString('en')+'</b></div></div></td></tr>'
                        +'<tr><td style="border-top:none" class="cs-'+data.sellers[j]['uid']+' py-2"><i class="fa fa-spinner fa-spin"></i></td></tr>'
                        +'</tbody></td></tr>'
                    );
                }
                var today = "<?php echo date('Y-m-d'); ?>";   
                var user = "<?php echo Auth::user()->id; ?>";
                for (let k = 0; k < data.sales.length; k++) {
                    $('.cs-'+data.sales[k]['uid']+' .fa-spin').css('display','none');
                    var tr = "";
                    if (data.sales[k]['updated'] == today && user == data.sales[k]['uid']) {
                        tr = '<span class="p-1 pull-right text-danger edit-sr" val="'+data.sales[k]['rid']+'" style="cursor: pointer;"><i class="fa fa-pencil-square-o" style="font-size:1.5rem;"></i></span>';
                    } 
                    $('.cs-'+data.sales[k]['uid']).append(
                        '<tr style="display:block;border-bottom:none" class="sr-'+data.sales[k]['rid']+'"><td style="display:block"><div class="row">'
                        +'<div class="col-12 r-name">'+data.sales[k]['pname']+''+tr+'</div>'
                        +'<div class="col-12" style="font-size:1rem" align="right"> <span>'+Number(data.sales[k]['squantity'])+'</span> <span><i class="fa fa-times"></i></span> <span>'+Number(data.sales[k]['sprice']).toLocaleString('en')+'</span> <span>=</span><span><b>'+Number(data.sales[k]['tsales']).toLocaleString('en')+'</b></span></div>'
                        +'</div></td></tr>'
                    )
                }
            }
            
            if (data.data.expenses != 0) {
                $('.expenses').css('display','');
                $('.totalE').html(Number(data.data.expenses).toLocaleString('en'));
            }
            if (data.data.deni != 0) {
                $('.deni').css('display','');
                $('.totalD').html(Number(data.data.deni).toLocaleString('en'));
            }
            if (data.data.ameweka != 0) {
                $('.ameweka').css('display','');
                $('.totalA').html(Number(Math.abs(data.data.ameweka)).toLocaleString('en'));
            }
            if (data.data.tumelipa != 0) {
                $('.tumelipa').css('display','');
                $('.totalT').html(Number(data.data.tumelipa).toLocaleString('en'));
            }
            // returned items
            if (data.data.returned != 0) {
                $('.returned-block').css('display','');     
                $('.render-returned-items').html("");
                var today = "<?php echo date('Y-m-d'); ?>";           
                if ($.isEmptyObject(data.data.returned)) { } else {
                    for (let j = 0; j < data.data.returned.length; j++) {
                        var lrow = "";
                        if(data.data.returned[j]['updated'] == today) {
                            var lrow = '<td><span class="p-1 text-danger remove-ri" val="'+data.data.returned[j]['rid']+'" style="cursor: pointer;"><i class="fa fa-times"></i></span></td>';
                        }
                        $('.render-returned-items').append('<tr class="ri-'+data.data.returned[j]['rid']+'"><td>'+data.data.returned[j]['pname']+'</td>'
                            +'<td>'+Number(data.data.returned[j]['rquantity'])+'</td>'
                            +'<td class="align-right">'+data.data.returned[j]['solddate']+'</td>'
                            +lrow+'</tr>');
                    }
                }
            }
            if (data.data.returned2 != 0) {
                $('.returned-block2').css('display','');    
                $('.render-returned-items2').html("");      
                if ($.isEmptyObject(data.data.returned2)) { } else {
                    for (let j = 0; j < data.data.returned2.length; j++) {
                        $('.render-returned-items2').append('<tr class="ri-'+data.data.returned2[j]['rid']+'"><td>'+data.data.returned2[j]['pname']+'</td>'
                            +'<td>'+Number(data.data.returned2[j]['rquantity'])+'</td>'
                            +'<td class="align-right">'+data.data.returned2[j]['updated']+'</td>'
                            +'</tr>');
                    }
                }
            }

        });
        //   below section is not used for now 
          var fromdate = s_date.replace(/\//g, "-");
          var todate = fromdate;
          $('.view-deni,.view-ameweka,.view-tumelipa,.view-expenses-2').attr('date',todate);
    }
    function salesByDatewithSellers2(s_date,shop_id){
        $('.sales-report').html("<tr><td colspan='6' align='center'><div class='py-2'><i class='fa fa-spinner fa-spin fa-2x'></i> Loading...</div></td></tr>");        
        $.get('/sales-by-date-with-sellers/cashier-view-changed/'+s_date+'/'+shop_id, function(data) { //s_date has three partitions. date,m & y         
            if ($.isEmptyObject(data.sellers)) {
                $('.sales-report').html("<tr><td class='py-3' align='center'>- No sales Recorded -</td></tr>");
            } else {
                $('.sales-report').html("");
                for (let j = 0; j < data.sellers.length; j++) {
                    $('.sales-report').append(
                        '<tr><td><tbody style="display:block">'
                        +'<tr style="border-bottom:none"><td class="pt-3"><div class="p-2" style="background:#fff;">'+data.sellers[j]['uname']+'<div align="right" style="display:inline-block;float:right;font-size:1rem"><b>'+Number(data.sellers[j]['tsales']).toLocaleString('en')+'</b></div></div></td></tr>'
                        +'<tr><td style="border-top:none" class="cs-'+data.sellers[j]['uid']+' py-2"><i class="fa fa-spinner fa-spin"></i></td></tr>'
                        +'</tbody></td></tr>'
                    );
                }
                var today = "<?php echo date('Y-m-d'); ?>";   
                var user = "<?php echo Auth::user()->id; ?>";
                for (let k = 0; k < data.sales.length; k++) {
                    $('.cs-'+data.sales[k]['uid']+' .fa-spin').css('display','none');
                    var tr = "";
                    if (data.sales[k]['updated'] == today && user == data.sales[k]['uid']) {
                        tr = '<span class="p-1 pull-right text-danger edit-sr" val="'+data.sales[k]['rid']+'" style="cursor: pointer;"><i class="fa fa-pencil-square-o" style="font-size:1.5rem;"></i></span>';
                    } 
                    $('.cs-'+data.sales[k]['uid']).append(
                        '<tr style="display:block;border-bottom:none" class="sr-'+data.sales[k]['rid']+'"><td style="display:block"><div class="row">'
                        +'<div class="col-12 r-name">'+data.sales[k]['pname']+''+tr+'</div>'
                        +'<div class="col-12" style="font-size:1rem" align="right"> <span>'+Number(data.sales[k]['squantity'])+'</span> <span><i class="fa fa-times"></i></span> <span>'+Number(data.sales[k]['sprice']).toLocaleString('en')+'</span> <span>=</span><span><b>'+Number(data.sales[k]['tsales']).toLocaleString('en')+'</b></span></div>'
                        +'</div></td></tr>'
                    )
                }
            }
        });
    }

    function salesWithPaymentOption(s_date,shop_id){ // this is called from sales-report page
        $('.sales-report, .closure-sale-2').html("<tr><td colspan='6' align='center'><div class='py-2'><i class='fa fa-spinner fa-spin fa-2x'></i> Loading...</div></td></tr>");
        $('.returned-block,.returned-block2,.expenses,.deni,.ameweka,.tumelipa,.load-more-s-b').css('display','none');
        $('.totalSQ,.totalSP').html(0);
        $.get('/sales-by-date-with-payment-options/cashier-date-changed/'+s_date+'/'+shop_id, function(data) {        
            if ($.isEmptyObject(data.total)) { } else {
                $('.totalSQ').html(Number(data.total[0]['totalQ']));
                $('.totalSP').html(Number(data.total[0]['totalS']).toLocaleString("en"));
            }  
            if ($.isEmptyObject(data.options)) {
                $('.sales-report').html("<tr><td class='py-3' align='center'>- No sales Recorded -</td></tr>");
            } else {
                $('.sales-report').html("");
                for (let j = 0; j < data.options.length; j++) {
                    $('.sales-report').append(
                        '<tr><td><tbody style="display:block">'
                        +'<tr style="border-bottom:none"><td class="pt-3"><div class="p-2" style="background:#fff;">'+data.options[j]['uname']+'<div align="right" style="display:inline-block;float:right;font-size:1rem"><b>'+Number(data.options[j]['tsales']).toLocaleString('en')+'</b></div></div></td></tr>'
                        +'<tr><td style="border-top:none" class="cs-'+data.options[j]['pid']+' py-2"><i class="fa fa-spinner fa-spin"></i></td></tr>'
                        +'</tbody></td></tr>'
                    );
                }
                var today = "<?php echo date('Y-m-d'); ?>";   
                var user = "<?php echo Auth::user()->id; ?>";
                for (let k = 0; k < data.sales.length; k++) {
                    $('.cs-'+data.sales[k]['pid']+' .fa-spin').css('display','none');
                    var tr = "";
                    if (data.sales[k]['updated'] == today && user == data.sales[k]['pid']) {
                        tr = '<span class="p-1 pull-right text-danger edit-sr" val="'+data.sales[k]['rid']+'" style="cursor: pointer;"><i class="fa fa-pencil-square-o" style="font-size:1.5rem;"></i></span>';
                    } 
                    $('.cs-'+data.sales[k]['pid']).append(
                        '<tr style="display:block;border-bottom:none" class="sr-'+data.sales[k]['rid']+'"><td style="display:block"><div class="row">'
                        +'<div class="col-12 r-name">'+data.sales[k]['pname']+''+tr+'</div>'
                        +'<div class="col-12" style="font-size:1rem" align="right"> <span>'+Number(data.sales[k]['squantity'])+'</span> <span><i class="fa fa-times"></i></span> <span>'+Number(data.sales[k]['sprice']).toLocaleString('en')+'</span> <span>=</span><span><b>'+Number(data.sales[k]['tsales']).toLocaleString('en')+'</b></span></div>'
                        +'</div></td></tr>'
                    )
                }
            }
            
            if (data.data.expenses != 0) {
                $('.expenses').css('display','');
                $('.totalE').html(Number(data.data.expenses).toLocaleString('en'));
            }
            if (data.data.deni != 0) {
                $('.deni').css('display','');
                $('.totalD').html(Number(data.data.deni).toLocaleString('en'));
            }
            if (data.data.ameweka != 0) {
                $('.ameweka').css('display','');
                $('.totalA').html(Number(Math.abs(data.data.ameweka)).toLocaleString('en'));
            }
            if (data.data.tumelipa != 0) {
                $('.tumelipa').css('display','');
                $('.totalT').html(Number(data.data.tumelipa).toLocaleString('en'));
            }
            // returned items
            if (data.data.returned != 0) {
                $('.returned-block').css('display','');     
                $('.render-returned-items').html("");
                var today = "<?php echo date('Y-m-d'); ?>";           
                if ($.isEmptyObject(data.data.returned)) { } else {
                    for (let j = 0; j < data.data.returned.length; j++) {
                        var lrow = "";
                        if(data.data.returned[j]['updated'] == today) {
                            var lrow = '<td><span class="p-1 text-danger remove-ri" val="'+data.data.returned[j]['rid']+'" style="cursor: pointer;"><i class="fa fa-times"></i></span></td>';
                        }
                        $('.render-returned-items').append('<tr class="ri-'+data.data.returned[j]['rid']+'"><td>'+data.data.returned[j]['pname']+'</td>'
                            +'<td>'+Number(data.data.returned[j]['rquantity'])+'</td>'
                            +'<td class="align-right">'+data.data.returned[j]['solddate']+'</td>'
                            +lrow+'</tr>');
                    }
                }
            }
            if (data.data.returned2 != 0) {
                $('.returned-block2').css('display','');    
                $('.render-returned-items2').html("");      
                if ($.isEmptyObject(data.data.returned2)) { } else {
                    for (let j = 0; j < data.data.returned2.length; j++) {
                        $('.render-returned-items2').append('<tr class="ri-'+data.data.returned2[j]['rid']+'"><td>'+data.data.returned2[j]['pname']+'</td>'
                            +'<td>'+Number(data.data.returned2[j]['rquantity'])+'</td>'
                            +'<td class="align-right">'+data.data.returned2[j]['updated']+'</td>'
                            +'</tr>');
                    }
                }
            }

        });
        //   below section is not used for now 
          var fromdate = s_date.replace(/\//g, "-");
          var todate = fromdate;
          $('.view-deni,.view-ameweka,.view-tumelipa,.view-expenses-2').attr('date',todate);
    }
    function salesWithPaymentOption2(s_date,shop_id){
        $('.sales-report').html("<tr><td colspan='6' align='center'><div class='py-2'><i class='fa fa-spinner fa-spin fa-2x'></i> Loading...</div></td></tr>");        
        $.get('/sales-by-date-with-payment-options/cashier-view-changed/'+s_date+'/'+shop_id, function(data) { //s_date has three partitions. date,m & y         
            if ($.isEmptyObject(data.options)) {
                $('.sales-report').html("<tr><td class='py-3' align='center'>- No sales Recorded -</td></tr>");
            } else {
                $('.sales-report').html("");
                for (let j = 0; j < data.options.length; j++) {
                    $('.sales-report').append(
                        '<tr><td><tbody style="display:block">'
                        +'<tr style="border-bottom:none"><td class="pt-3"><div class="p-2" style="background:#fff;">'+data.options[j]['uname']+'<div align="right" style="display:inline-block;float:right;font-size:1rem"><b>'+Number(data.options[j]['tsales']).toLocaleString('en')+'</b></div></div></td></tr>'
                        +'<tr><td style="border-top:none" class="cs-'+data.options[j]['pid']+' py-2"><i class="fa fa-spinner fa-spin"></i></td></tr>'
                        +'</tbody></td></tr>'
                    );
                }
                var today = "<?php echo date('Y-m-d'); ?>";   
                var user = "<?php echo Auth::user()->id; ?>";
                for (let k = 0; k < data.sales.length; k++) {
                    $('.cs-'+data.sales[k]['pid']+' .fa-spin').css('display','none');
                    var tr = "";
                    if (data.sales[k]['updated'] == today && user == data.sales[k]['pid']) {
                        tr = '<span class="p-1 pull-right text-danger edit-sr" val="'+data.sales[k]['rid']+'" style="cursor: pointer;"><i class="fa fa-pencil-square-o" style="font-size:1.5rem;"></i></span>';
                    } 
                    $('.cs-'+data.sales[k]['pid']).append(
                        '<tr style="display:block;border-bottom:none" class="sr-'+data.sales[k]['rid']+'"><td style="display:block"><div class="row">'
                        +'<div class="col-12 r-name">'+data.sales[k]['pname']+''+tr+'</div>'
                        +'<div class="col-12" style="font-size:1rem" align="right"> <span>'+Number(data.sales[k]['squantity'])+'</span> <span><i class="fa fa-times"></i></span> <span>'+Number(data.sales[k]['sprice']).toLocaleString('en')+'</span> <span>=</span><span><b>'+Number(data.sales[k]['tsales']).toLocaleString('en')+'</b></span></div>'
                        +'</div></td></tr>'
                    )
                }
            }
        });
    }

    function salesWithSaleNumbers(s_date,shop_id) { // this is called from sales-report page
        $('.sales-report, .closure-sale-2').html("<tr><td colspan='6' align='center'><div class='py-2'><i class='fa fa-spinner fa-spin fa-2x'></i> Loading...</div></td></tr>");
        $('.returned-block,.returned-block2,.expenses,.deni,.ameweka,.tumelipa,.load-more-s-b').css('display','none');
        $('.totalSQ,.totalSP').html(0);
        $.get('/sales-by-date-with-sale-numbers/cashier-date-changed/'+s_date+'/'+shop_id, function(data) {            
            if ($.isEmptyObject(data.total)) { } else {
                $('.totalSQ').html(Number(data.total[0]['totalQ']));
                $('.totalSP').html(Number(data.total[0]['totalS']).toLocaleString("en"));
            }  
            if ($.isEmptyObject(data.snumbers)) {
                $('.sales-report').html("<tr><td class='py-3' align='center'>- No sales Recorded -</td></tr>");
            } else {
                $('.sales-report').html("");
                for (let j = 0; j < data.snumbers.length; j++) {
                    $('.sales-report').append(
                        '<tr><td><tbody style="display:block">'
                        +'<tr style="border-bottom:none"><td class="pt-3"><div class="p-2" style="background:#fff;"><a href="#" class="preview-receipt" saleno="'+data.snumbers[j]['sale_no']+'"><b>'+data.snumbers[j]['sale_no']+'</b></a></div></td></tr>'
                        +'<tr><td style="border-top:none" class="cs-'+data.snumbers[j]['sale_no']+' py-2"><i class="fa fa-spinner fa-spin"></i></td></tr>'
                        +'</tbody></td></tr>'
                    );
                }
                var today = "<?php echo date('Y-m-d'); ?>";   
                var user = "<?php echo Auth::user()->id; ?>";
                for (let k = 0; k < data.sales.length; k++) {
                    $('.cs-'+data.sales[k]['sale_no']+' .fa-spin').css('display','none');
                    var tr = "";
                    if (data.sales[k]['updated'] == today && user == data.sales[k]['uid']) {
                        tr = '<span class="p-1 pull-right text-danger edit-sr" val="'+data.sales[k]['rid']+'" style="cursor: pointer;"><i class="fa fa-pencil-square-o" style="font-size:1.5rem;"></i></span>';
                    } 
                    $('.cs-'+data.sales[k]['sale_no']).append(
                        '<tr style="display:block;border-bottom:none" class="sr-'+data.sales[k]['rid']+'"><td style="display:block"><div class="row">'
                        +'<div class="col-12 r-name">'+data.sales[k]['pname']+''+tr+'</div>'
                        +'<div class="col-12" style="font-size:1rem" align="right"> <span>'+Number(data.sales[k]['squantity'])+'</span> <span><i class="fa fa-times"></i></span> <span>'+Number(data.sales[k]['sprice']).toLocaleString('en')+'</span> <span>=</span><span><b>'+Number(data.sales[k]['tsales']).toLocaleString('en')+'</b></span></div>'
                        +'</div></td></tr>'
                    )
                }
            }

            if (data.data.expenses != 0) {
                $('.expenses').css('display','');
                $('.totalE').html(Number(data.data.expenses).toLocaleString('en'));
            }
            if (data.data.deni != 0) {
                $('.deni').css('display','');
                $('.totalD').html(Number(data.data.deni).toLocaleString('en'));
            }
            if (data.data.ameweka != 0) {
                $('.ameweka').css('display','');
                $('.totalA').html(Number(Math.abs(data.data.ameweka)).toLocaleString('en'));
            }
            if (data.data.tumelipa != 0) {
                $('.tumelipa').css('display','');
                $('.totalT').html(Number(data.data.tumelipa).toLocaleString('en'));
            }
            // returned items
            if (data.data.returned != 0) {
                $('.returned-block').css('display','');     
                $('.render-returned-items').html("");
                var today = "<?php echo date('Y-m-d'); ?>";           
                if ($.isEmptyObject(data.data.returned)) { } else {
                    for (let j = 0; j < data.data.returned.length; j++) {
                        var lrow = "";
                        if(data.data.returned[j]['updated'] == today) {
                            var lrow = '<td><span class="p-1 text-danger remove-ri" val="'+data.data.returned[j]['rid']+'" style="cursor: pointer;"><i class="fa fa-times"></i></span></td>';
                        }
                        $('.render-returned-items').append('<tr class="ri-'+data.data.returned[j]['rid']+'"><td>'+data.data.returned[j]['pname']+'</td>'
                            +'<td>'+Number(data.data.returned[j]['rquantity'])+'</td>'
                            +'<td class="align-right">'+data.data.returned[j]['solddate']+'</td>'
                            +lrow+'</tr>');
                    }
                }
            }
            if (data.data.returned2 != 0) {
                $('.returned-block2').css('display','');    
                $('.render-returned-items2').html("");      
                if ($.isEmptyObject(data.data.returned2)) { } else {
                    for (let j = 0; j < data.data.returned2.length; j++) {
                        $('.render-returned-items2').append('<tr class="ri-'+data.data.returned2[j]['rid']+'"><td>'+data.data.returned2[j]['pname']+'</td>'
                            +'<td>'+Number(data.data.returned2[j]['rquantity'])+'</td>'
                            +'<td class="align-right">'+data.data.returned2[j]['updated']+'</td>'
                            +'</tr>');
                    }
                }
            }            
        });
        //   below section is not used for now 
          var fromdate = s_date.replace(/\//g, "-");
          var todate = fromdate;
          $('.view-deni,.view-ameweka,.view-tumelipa,.view-expenses-2').attr('date',todate);                                                                                                                                                                                
    }
    function salesWithSaleNumbers2(s_date,shop_id){
        $('.sales-report, .closure-sale-2').html("<tr><td colspan='6' align='center'><div class='py-2'><i class='fa fa-spinner fa-spin fa-2x'></i> Loading...</div></td></tr>");
        $('.returned-block,.returned-block2,.load-more-s-b').css('display','none');
        $.get('/sales-by-date-with-sale-numbers/cashier-view-changed/'+s_date+'/'+shop_id, function(data) { //s_date has three partitions. date,m & y      
            if ($.isEmptyObject(data.snumbers)) {
                $('.sales-report').html("<tr><td class='py-3' align='center'>- No sales Recorded -</td></tr>");
            } else {
                $('.sales-report').html("");
                for (let j = 0; j < data.snumbers.length; j++) {
                    $('.sales-report').append(
                        '<tr><td><tbody style="display:block">'
                        +'<tr style="border-bottom:none"><td class="pt-3"><div class="p-2" style="background:#fff;"><a href="#" class="preview-receipt" saleno="'+data.snumbers[j]['sale_no']+'"><b>'+data.snumbers[j]['sale_no']+'</b></a></div></td></tr>'
                        +'<tr><td style="border-top:none" class="cs-'+data.snumbers[j]['sale_no']+' py-2"><i class="fa fa-spinner fa-spin"></i></td></tr>'
                        +'</tbody></td></tr>'
                    );
                }
                var today = "<?php echo date('Y-m-d'); ?>";   
                var user = "<?php echo Auth::user()->id; ?>";
                for (let k = 0; k < data.sales.length; k++) {
                    $('.cs-'+data.sales[k]['sale_no']+' .fa-spin').css('display','none');
                    var tr = "";
                    if (data.sales[k]['updated'] == today && user == data.sales[k]['uid']) {
                        tr = '<span class="p-1 pull-right text-danger edit-sr" val="'+data.sales[k]['rid']+'" style="cursor: pointer;"><i class="fa fa-pencil-square-o" style="font-size:1.5rem;"></i></span>';
                    } 
                    $('.cs-'+data.sales[k]['sale_no']).append(
                        '<tr style="display:block;border-bottom:none" class="sr-'+data.sales[k]['rid']+'"><td style="display:block"><div class="row">'
                        +'<div class="col-12 r-name">'+data.sales[k]['pname']+''+tr+'</div>'
                        +'<div class="col-12" style="font-size:1rem" align="right"> <span>'+Number(data.sales[k]['squantity'])+'</span> <span><i class="fa fa-times"></i></span> <span>'+Number(data.sales[k]['sprice']).toLocaleString('en')+'</span> <span>=</span><span><b>'+Number(data.sales[k]['tsales']).toLocaleString('en')+'</b></span></div>'
                        +'</div></td></tr>'
                    )
                }
            }
        });
    }
    
    $(document).on('click', '.no-customer-sales-btn', function(e){
        e.preventDefault();
        $('.no-customer-sales').html("<div><i class='fa fa-spinner fa-spin fa-2x'></i> Loading...</div>");
        var s_date = $('.date-of-sale').val();
        $.get('/sales-by-date-with-customer/cashier-no-customer/'+s_date+'/'+shop_id, function(data) {  
            if ($.isEmptyObject(data.sales)) {
                $('.no-customer-sales').html("<tr style='display:block;border-bottom:none'><td class='py-3' style='border-top:none' align='center'>- No sales -</td></tr>");
            } else {
                $('.no-customer-sales').html("").removeAttr("align");
                var today = "<?php echo date('Y-m-d'); ?>";   
                var user = "<?php echo Auth::user()->id; ?>";
                for (let k = 0; k < data.sales.length; k++) {                    
                    var tr = "";
                    if (data.sales[k]['updated'] == today && user == data.sales[k]['soldby']) {
                        tr = '<span class="p-1 pull-right text-danger edit-sr" val="'+data.sales[k]['rid']+'" style="cursor: pointer;"><i class="fa fa-pencil-square-o" style="font-size:1.5rem;"></i></span>';
                    } 
                    $('.no-customer-sales').append(
                        '<tr style="display:block;border-bottom:none" class="sr-'+data.sales[k]['rid']+'"><td style="display:block"><div class="row">'
                        +'<div class="col-12 r-name">'+data.sales[k]['pname']+''+tr+'</div>'
                        +'<div class="col-12" style="font-size:1rem" align="right"> <span>'+Number(data.sales[k]['squantity'])+'</span> <span><i class="fa fa-times"></i></span> <span>'+Number(data.sales[k]['sprice']).toLocaleString('en')+'</span> <span>=</span><span><b>'+Number(data.sales[k]['tsales']).toLocaleString('en')+'</b></span></div>'
                        +'</div></td></tr>'
                    )
                }
            }
        });
    });

    $(document).on('click', '.remove-sr', function(e){
        var pid = $(this).attr('val');
        $('.sr-'+pid).remove();
        calculateTotalCatsValue();
    });
    
    $(document).on('click', '.return-sold-items-btn', function(e) { 
        e.preventDefault();
        $('.returned-items').html("<tr><td colspan='3' class='p-3' align='center'><i class='fa fa-spinner fa-spin fa-2x'></i> Loading...</td></tr>");
        $.get('/get-data/return-sold-items/'+shop_id, function(data) {    
            $('.sloader').css('display','none');   
            $('.search-block2').html("");
            if ($.isEmptyObject(data.products)) {
                $('.search-block2').html('<span><i>- No product -</i></span>');
            } else {                
                for (let i = 0; i < data.products.length; i++) {
                    if(data.products[i]['quantity'] == null) { 
                        data.products[i]['quantity'] = 0;
                    }
                    $('.search-block2').append("<div class='searched-item px-2 py-2 border' check='returnItem' val='"+ data.products[i]['pid'] +"' qty='"+ data.products[i]['quantity'] +"' price='"+ Number(data.products[i]['rprice']) +"'>"
                        +data.products[i]['pname'] +"<span style='float:right'>"+Number(data.products[i]['rprice']).toLocaleString('en')+"/=</span></div>");
                }
            }
            
            pendingReturnedItems(shop_id);
        }); 
    });

    $(document).on('click', '.load-more-sales', function(e) { // button from sales-report page
        e.preventDefault();
        $('.sales-report').append("<tr class='loader'><td colspan='6' align='center'><div class='py-2'><i class='fa fa-spinner fa-spin fa-2x'></i> Loading...</div></td></tr>");
        $('.load-more-s-b').css('display','none');
        var s_date = $('.date-of-sale').val();
        $.get('/sales-by-date/cashier-all-sales/'+s_date+'/'+shop_id, function(data) {
            $('.sales-report .loader').css('display','none');
            if ($.isEmptyObject(data.items)) {
                
            } else {
                var num = 16;
                var displaynone = "displaynone";
                var s_date2 = s_date.split('/');
                var s_date3 = s_date2[2]+"-"+s_date2[1]+"-"+s_date2[0];
                var today = new Date(s_date3); 
                var today2 = new Date();
                for (let i = 15; i < data.items.length; i++) {
                    if(data.data.is_ceo === true) {
                        displaynone = "";
                    } else {
                        if(data.data.uid == data.items[i]['uid'] && today.toDateString() === today2.toDateString()) {
                            displaynone = "";
                        } else {
                            var displaynone = "displaynone";
                        }
                    }
                    $('.sales-report').append('<tr class="sr-'+data.items[i]["sid"]+'"><td><div class="row py-1">'
                        +'<div class="col-12 r-name">'+ num +'). '+data.items[i]["pname"]+''
                        +'<span class="p-1 pull-right text-danger edit-sr '+displaynone+'" val="'+data.items[i]["sid"]+'" style="cursor: pointer;"><i class="fa fa-pencil-square-o" style="font-size:1.5rem;"></i></span></div>'
                        +'<div class="col-12" style="font-size:1rem" align="right"> <span>'+Number(data.items[i]["sqty"])+'</span> <span><i class="fa fa-times"></i></span> <span>'+Number(data.items[i]["sprice"]).toLocaleString('en')+'</span> <span>=</span><span><b>'+Number(data.items[i]["tsales"]).toLocaleString('en')+'</b></span></div>'
                        +'</div></td></tr>');
                    num++;
                }
            }
        });            
    });

    $(document).on('click', '.load-more-lb', function(e) { // load more for sales with cashier (mauzo na alieuza)
        e.preventDefault();
        var uid = $(this).attr('uid');
        var last = $(this).attr('last'); 
        var s_date = $('.date-of-sale').val().split('/').join('-');
        var s_type = $('.sales-view').val();
        var shop_u = shop_id+"~"+uid;

        $('.show-lb-'+uid).html('<td style="display:block" align="center" class="pt-3 pb-4"><i class="fa fa-spinner fa-spin"></i></td>');
        $.get('/get-data/load-more-lb/'+last+'~'+s_date+'~'+s_type+'~'+shop_u, function(data) {
            $('.show-lb-'+uid).css('display','none');
            $('.cs-'+uid).append(data.items);
        });        
    });
</script>
@endsection