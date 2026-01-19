@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/partials/store.css') }}">
    <link rel="stylesheet" href="{{ asset('slick/slick/slick.css') }}">
    <style>
        .breadcrumb {display: none !important;}
        .fancy-radio input[type="radio"]+span i {
            padding-right: 5px !important;
        }
        .displaynone, .displaynone2, .displaynone3 {display: none !important;}
        .edit-p-margin {padding-left: 30px;padding-right: 30px;}
        .block-access{position: absolute;width: 98%;height: 90%;background-color: #f8d7da;z-index: 1;opacity: 0.5;}
        @media screen and (max-width: 900px) {
            .block-access{width: 96%;}
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
    if($data['store']) {
        $reminder2 = $data['store']->reminder;
    }
if(Cookie::get("language") == 'en') {
    $_GET['b-p'] = "BP";
    $_GET['s-p'] = "SP";
    $_GET['no-products'] = "No products";
    $_GET['change-supplier-details'] = "Change supplier details";
    $_GET['products-availability-in-store'] = "Products Availability in a Store <br> <small>Place a tick if product is available in a store. Remove a tick if product is not available in a store";
    $_GET['today-pro-in'] = "Today Products In";
    $_GET['ten-pro-in'] = "Products In, <small>10 Days</small>";
    $_GET['today-pro-out'] = "Today Products Out";
    $_GET['ten-pro-out'] = "Products Out, <small>10 Days</small>";
    $_GET['products-short'] = "Add and preview available products";
    $_GET['stock-short'] = "Add stock and see previous stock records";
    $_GET['transfer-short'] = "Transfer products from this store to other store/shop";
    $_GET['sh-reminder-desc'] = "Hello, Free trial uses for this store will expire after ".$reminder2." days.<br> Please pay for your store so that it will not be blocked. <a href='#' data-toggle='modal' data-target='#endFreeTrialModal'>Click here to see our pricing</a>";
    $_GET['sh-reminder-desc-2'] = "Hello, Payments for this store will expire after ".$reminder2." days.<br> Please pay for your store so that it will not be blocked. <a href='#' data-toggle='modal' data-target='#endFreeTrialModal'>Click here to see our pricing</a>";
    $_GET['sh-end-free-t'] = "Hello, 30 days free trial for this store is over. Please pay for it in order to proceed using it. <a href='#' data-toggle='modal' data-target='#endFreeTrialModal'>Click here to see our pricing</a>";
    $_GET['sh-expire-t'] = "Hello, Payments for this store is over. Please pay for it in order to proceed using it. <a href='#' data-toggle='modal' data-target='#endFreeTrialModal'>Click here to see our pricing</a>";
    $_GET['suppliers-short'] = "Register suppliers and manage purchases";
    $_GET['dont-have-access-in-store'] = '<div class="row clearfix"><div class="col-12"><div class="p-3"><i class="fa fa-warning text-warning" style="font-size:35px;"></i><h5>You dont have access in this store, <br> <a href="/users/'.Auth::user()->id.'" style="text-decoration:underline">click here</a> to assign yourself a store master role.</h5></div></div></div>';
} else {
    $_GET['b-p'] = "BN";
    $_GET['s-p'] = "BU";
    $_GET['no-products'] = "Hakuna bidhaa";
    $_GET['change-supplier-details'] = "Badili taarifa za msambazaji";
    $_GET['products-availability-in-store'] = "Upatikanaji wa Bidhaa kwenye Stoo <br> <small>Weka tiki kama bidhaa inapatikana kwenye stoo. Ondoa tiki kama bidhaa haipatikani kwenye stoo</small> ";
    $_GET['today-pro-in'] = "Bidhaa Zilizoingia Leo";
    $_GET['ten-pro-in'] = "Bidhaa Zilizoingia, <small>Siku 10</small>";
    $_GET['today-pro-out'] = "Bidhaa Zilizotoka Leo";
    $_GET['ten-pro-out'] = "Bidhaa Zilizotoka, <small>Siku 10</small>";
    $_GET['products-short'] = "Ongeza na tazama Bidhaa zilizopo";
    $_GET['stock-short'] = "Ongeza idadi ya bidhaa (stock) na tazama rekodi ya stock za zamani";
    $_GET['transfer-short'] = "Hamisha bidhaa kutoka stoo kwenda stoo ingine au dukani";
    $_GET['sh-reminder-desc'] = "Habari, Matumizi ya bure kwa stoo hii yataisha baada ya siku ".$reminder2.".<br> Tafadhali lipia stoo yako ili isifungiwe muda utakapoisha. <a href='#' data-toggle='modal' data-target='#endFreeTrialModal'>Bonyeza hapa kuona bei zetu</a>";
    $_GET['sh-reminder-desc-2'] = "Habari, Malipo kwa stoo hii yataisha baada ya siku ".$reminder2.".<br> Tafadhali lipia stoo yako ili isifungiwe muda utakapoisha. <a href='#' data-toggle='modal' data-target='#endFreeTrialModal'>Bonyeza hapa kuona bei zetu</a>";
    $_GET['sh-end-free-t'] = "Habari, Siku 30 za kutumia bure hii stoo zimeisha. Tafadhali lipia ili uendelee kuitumia. <a href='#' data-toggle='modal' data-target='#endFreeTrialModal'>Bonyeza hapa kuona bei zetu</a>";
    $_GET['sh-expire-t'] = "Habari, Malipo kwa stoo hii yameisha. Tafadhali lipia ili uendelee kuitumia. <a href='#' data-toggle='modal' data-target='#endFreeTrialModal'>Bonyeza hapa kuona bei zetu</a>";
    $_GET['suppliers-short'] = "Sajili wasambazaji na rekodi manunuzi ya bidhaa kutoka kwao";
    $_GET['dont-have-access-in-store'] = '<div class="row clearfix"><div class="col-12"><div class="p-3"><i class="fa fa-warning text-warning" style="font-size:35px;"></i><h5>Hauna ruhusa kwenye hii stoo, <br> <a href="/users/'.Auth::user()->id.'" style="text-decoration:underline">bonyeza hapa</a> kujipa ruhusa kwenye stoo hii kama stoo masta.</h5></div></div></div>';
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
                        <div class="store-top-corner">
                            <label class="mb-0" style="font-weight:300"><?php echo $_GET['store']; ?></label><br>
                              <select name="sources" id="sources" class="custom-select change-store sources" value="{{$data['store']->id}}" placeholder="{{$data['store']->name}}">
                                @if($data['isCEO'] == "yes") <option class="change-store2 as" value="add-store"><i class="fa fa-plus"></i>+ Add store</option> @endif
                                @if($data['stores']->isNotEmpty())
                                    @if($data['isCEO'] == "no")
                                        <option value="#"></option>
                                        @foreach($data['stores'] as $store)
                                            <option class="change-store2" value="{{$store->sid}}">{{$store->name}}</option>
                                        @endforeach
                                    @else
                                        @foreach($data['stores'] as $store)
                                            <option class="change-store2" value="{{$store->id}}">{{$store->name}}</option>
                                        @endforeach
                                    @endif
                                @endif
                              </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row clearfix">
            
            <?php if(strlen($data['store']->reminder) >= 1) { $displaynone = ""; } else { $displaynone = "displaynone"; } ?>
            <?php if($data['store']->status == 'end free trial') { $displaynone2 = ""; } else { $displaynone2 = "displaynone"; } ?>
            <?php if($data['store']->status == 'not paid') { $displaynone3 = ""; } else { $displaynone3 = "displaynone"; } ?>
            <div class="col-sm-12 <?php echo $displaynone; ?>">
                <?php if($data['store']->status == "active") { ?>
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
                            <li class="nav-item"><a class="nav-link home-tab active" data-toggle="tab" href="#Home"><i class="fa fa-home"></i></a></li>
                            <li class="nav-item"><a class="nav-link products-tab" data-toggle="tab" href="#Products"><?php echo $_GET['products-menu']; ?></a></li>
                            <!-- <li class="nav-item"><a class="nav-link stock-tab" data-toggle="tab" href="#Stock"><?php echo $_GET['stock-records']; ?></a></li> -->
                            <li class="nav-item"><a class="nav-link suppliers-tab" data-toggle="tab" href="#Suppliers"><?php echo $_GET['suppliers']; ?></a></li>
                            <!-- @if(Auth::user()->company->can_transfer_items != "no")
                            <li class="nav-item"><a class="nav-link transfer-tab" data-toggle="tab" href="#Transfer"><?php echo $_GET['transfer-item-menu']; ?></a></li>
                            @endif -->
                        </ul>
                        </div>
                        <div class="tabs-drop" style="display: none;">
                            <i class="fa fa-angle-double-right"></i>
                        </div>
                        <div class="other-tabs">
                            <ul class="nav" id="">
                                <li class="nav-item" style="display:none"><a class="nav-link home-tab active" data-toggle="tab" href="#Home">Home</a></li>
                                <li class="nav-item"><a class="nav-link products-tab" data-toggle="tab" href="#Products"><?php echo $_GET['products-menu']; ?></a></li>
                                <!-- <li class="nav-item"><a class="nav-link stock-tab" data-toggle="tab" href="#Stock"><?php echo $_GET['stock-records']; ?></a></li> -->
                                <li class="nav-item"><a class="nav-link suppliers-tab" data-toggle="tab" href="#Suppliers"><?php echo $_GET['suppliers']; ?></a></li>
                                <!-- @if(Auth::user()->company->can_transfer_items != "no")
                                <li class="nav-item"><a class="nav-link transfer-tab" data-toggle="tab" href="#Transfer"><?php echo $_GET['transfer-item-menu']; ?></a></li>
                                @endif -->
                            </ul>
                        </div>
                    </div>
                </div>
            
                <div class="tab-content padding-0">
                    @if($data['store']->status == "end free trial" || $data['store']->status == "not paid")
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
                                                    <h4><i class="fa fa-cubes"></i> <span class="total-products"><i class="fa fa-spinner fa-spin"></i></span></h4>
                                                    <span><?php echo $_GET['all-products-menu']; ?></span>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="item" style="background-color: #f9f1d8;">
                                                    <h4><i class="fa fa-arrow-down"></i> <span class="today-p-in"><i class="fa fa-spinner fa-spin"></i></span></h4>
                                                    <span><?php echo $_GET['today-pro-in']; ?></span>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="item" style="background-color: #efebf4;">
                                                    <h4><i class="fa fa-arrow-down"></i> <span class="ten-p-in"><i class="fa fa-spinner fa-spin"></i></span></h4>
                                                    <span><?php echo $_GET['ten-pro-in']; ?></span>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="item" style="background-color: #ffd4c3;">
                                                    <h4><i class="fa fa-arrow-up"></i> <span class="today-p-out"><i class="fa fa-spinner fa-spin"></i></span></h4>
                                                    <span><?php echo $_GET['today-pro-out']; ?></span>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="item" style="background-color: #e0eff5;">
                                                    <h4><i class="fa fa-arrow-up"></i> <span class="ten-p-out"><i class="fa fa-spinner fa-spin"></i></span></h4>
                                                    <span><?php echo $_GET['ten-pro-out']; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                    <div class="col-md-6" style="display:none">
                                        <ul class="list-unstyled feeds_widget stock-tab-blc">
                                            <li>
                                                <div class="feeds-left"><i class="fa fa-database" style="color:#6f42c1"></i></div>
                                                <div class="feeds-body">
                                                    <h4 class="title"><?php echo $_GET['stock-records']; ?> <span class="float-right"><i class="fa fa-angle-right"></i></span></h4>
                                                    <small><?php echo $_GET['stock-short']; ?></small>
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
                                                    <h4 class="title"><?php echo $_GET['transfer-item-menu']; ?> <span class="float-right"><i class="fa fa-angle-right"></i></span></h4>
                                                    <small><?php echo $_GET['transfer-short']; ?></small>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    @endif -->
                                    <div class="col-12 mb-4">
                                        <div class="accordion" id="accordion" style="margin-top: 80px;">
                                            <div class="">
                                                <div class="card-header" id="headingOne">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link collapsed show-customer" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                            <i class="fa fa-info-circle fa-2x" style="float: left;"></i>
                                                            <div style="float: left;font-weight: bold;padding-top: 5px;padding-left: 10px;"> Maelezo kuhusu stoo</div> 
                                                            <i class="fa fa-angle-down fa-2x" style="float: right;"></i>
                                                        </button>
                                                    </h5>
                                                </div>                                
                                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" style="border: 2px solid #eee;">
                                                    <div class="card-body" style="padding-bottom: 10px;padding-top: 10px;">                
                                                        <div> <br>
                                                            <b>Stoo/Godown</b> ni sehem ambayo unaitumia kuhifadhia bidhaa zako. <br><br>
                                                            Kama kwenye biashara yako unatumia stoo kuhifadhia bidhaa zako na kuzitoa kidogo kidogo kuzipeleka dukani zinapohitajika basi unaweza kutengeneza stoo hapa ili <br><br> 
                                                            1. Uweze kujua kwa urahisi idadi ya bidhaa zilizopo kwa stoo yako <br>
                                                            2. Uweze kutunza taarifa zote za uingizaji wa stock mpya kwenye stoo yako <br>
                                                            3. Uweze kutunza taarifa zote za uhamishaji (Transfer) wa bidhaa kutoka stoo kwenda dukani/stoo AU kutoka dukani/stoo kuja stoo <br><br>
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

                    <div class="tab-pane" id="Products">
                        <div class="row">
                            <div class="col-12 reduce-padding">
                                <div class="card">
                                    <div class="body pt-0 px-0">
                                        <div class="row">
                                        <div class="col-md-8 offset-md-2 mt-2">
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
                        </div>
                    </div>

                    <div class="tab-pane" id="Stock">
                        <div class="card">
                            <div class="body render-stock-report pt-0 px-0">
                                
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="Suppliers">
                        <div class="card">
                            <div class="body render-suppliers pt-0 px-0">
                                
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane" id="Transfer">
                        <div class="card">
                            <div class="body render-transfers pt-0 px-0">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            </div>
        </div>
    </div>
</div>

@include('modals.new-store')

@endsection

@section('js')
<script src="{{ asset('slick/slick/slick.min.js') }}"></script>
<script>

$(document).ready(function(){
    
    $('.report-carousel').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        arrows: false,
        autoplaySpeed: 2000,
        variableWidth:true,
    });
});

$(function () {
    var shop_tab = getSearchParams("tab");
    if ($.isEmptyObject(shop_tab)) {
        
        $('.shop-tabs .nav-tabs-new .home-tab').click();
    } else {
        if (shop_tab == "home") {
            $('.home-tab').click();            
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
        } else {
            window.location = "/stores/<?php echo $data['store']->id; ?>";
        }
    }
});

function getSearchParams(k){
    var p={};
    location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(s,k,v){p[k]=v})
    return k?p[k]:p;
}

    $(document).on('click', '.change-store2', function(e) {
        e.preventDefault();
        $('.change-store2.as').removeClass('selection');
        var val = $(this).attr('data-value');
        var store_tab = getSearchParams("tab");
        if (val == "add-store") {
            $('.new-store')[0].reset();
            $('.check-location-level').html('<input type="hidden" class="user-location2" value="inside-store">');
            $('#newStore').modal('toggle');
            var c_val = $('.change-store').attr('placeholder');
            $(".custom-select-trigger").text(c_val);
            // alert('ss');
        } else {
            if ($.isEmptyObject(store_tab)) {
                var url = "/stores/"+val;
            } else {
                var url = "/stores/"+val+"?tab="+store_tab;
            }
            window.location = url;
        }
    });

    $(document).on('click', '.home-tab', function(e) {
        e.preventDefault();
        $('.shop-tabs .nav-link, .other-tabs .nav-link').removeClass('active');
        $('.shop-tabs .home-tab, .other-tabs .home-tab').addClass('active');
        window.history.pushState({state:1}, "Home", "?tab=home");
        reportCarousel();
    });

    $(document).on('click', '.export-products-pdf', function(e) {
        e.preventDefault();
        window.open('/pdf/available-products-store/<?php echo $data["store"]->id; ?>', '_blank');     
    });

    $(document).on('click', '.products-tab-blc', function(e) {
        e.preventDefault();
        $('.other-tabs .products-tab').click();
    });
    $(document).on('click', '#Products .products-opt', function(e) {
        e.preventDefault();   
        $('.shop-tabs .nav-tabs-new .products-tab').click();     
    });
    $(document).on('click', '.products-tab', function(e) {
        e.preventDefault();
        $('.shop-tabs .nav-link, .other-tabs .nav-link, #Products .nav-link').removeClass('active');
        $('.shop-tabs .products-tab, .other-tabs .products-tab, #Products .products-opt').addClass('active');
        $('.products-outer-block').html('<div class="my-5" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>');
        $.get("/get-data/render-products-tab-store/<?php echo $data['store']->id; ?>", function(data){
            $('.products-outer-block').html(data.view);    
            $('.pro-block.all').css('display','block');
            var tab2 = getSearchParams("tab2");
            if($.isEmptyObject(tab2)) {
                getProducts("<?php echo $data['store']->id; ?>");
            } else {
                if(tab2 == "add-product") {
                    newProductForm();
                } else if (tab2 == "preview") {
                    var product_id = getSearchParams("pid");
                    if($.isEmptyObject(product_id)) { 
                        window.history.pushState({state:1}, "Products", "?tab=products");
                        getProducts("<?php echo $data['store']->id; ?>");
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
            getProducts("<?php echo $data['store']->id; ?>");
        }
        if(val == "products-in") {
            $('.pro-block.pin').css('display','block');
            getProductsIn("<?php echo $data['store']->id; ?>");
        }
        if(val == "product-categories") {
            $('.pro-block.cats').css('display','block');
            renderProductCategories();
        }
        if(val == "products-value") {
            $('.pro-block.value').css('display','block');
            calculateStockValue("<?php echo $data['store']->id; ?>");
        }
        if(val == "manage-products") {
            $('.pro-block.manage').css('display','block');
            manageProducts("<?php echo $data['store']->id; ?>");
        }
        if(val == "transfer-products") {
            $('.pro-block.transfer').css('display','block');
            transferProducts("<?php echo $data['store']->id; ?>");
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

        $.get("/report/products-in-store/<?php echo $data['store']->id; ?>", function(data){   
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

        // $('.search-p [name="pname"]').val("");
        // $('[name="sfrom"]').val("all-products");
        // $('.render-products').html('<tr><td colspan="2" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<td></tr>'); // get data
        // window.history.pushState({state:1}, "Products", "?tab=products");

        // $.get("/report/total-products-in-store/<?php echo $data['store']->id; ?>", function(data){
        //     $('.render-total-products').html(data.data.total_products);          
        // });
        // $.get('/get-data/products-report-store/<?php echo $data["store"]->id; ?>~0', function(data){
        //     if (data.status == 'not have access') {
        //         $('.render-products').html('<?php echo $_GET["dont-have-access-in-store"]; ?>');
        //     } else {
        //         $('.render-products').html(data.view);
        //         if(data.data.products) {
        //             $(data.data.products).each(function(index, value) {
        //                 $('.pq-select select, .pq-select-2 select').append('<option value="'+value.id+'">'+value.name+'</option>');
        //             });
        //         }
        //     }            
        // });
    }
    $(document).on('click', '.more-all-products', function(e) {
        e.preventDefault();
        $('.more-pr-t').css('display','none');
        var first = $(this).attr('lastid');
        first = Number(first) + 1;
        var last = Number(first) + 15;
        renderSProducts(allproducts,first,last);
    });
    // $(document).on('click', '.more-all-products', function(e) {
    //     e.preventDefault();
    //     var lastid = $(this).attr('lastid');
    //     $('.more-rows-btn').css('display','none');
    //     $('.render-products').append('<tr class="load-more-rows"><td colspan="3" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<td></tr>'); 
    //     $.get("/get-data/products-report/<?php echo $data['store']->id; ?>~"+lastid, function(data){
    //         $('.load-more-rows').css('display','none');
    //         $('.render-products').append(data.view);
    //     });          
    // });
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

    function manageProducts(sid) {
        $('.search-p [name="pname"]').val("");
        $('[name="sfrom"]').val("manage-products"); 
        $('.fps-title').html('<?php echo $_GET["products-availability-in-store"]; ?>');
        $('.render-products-m').html('<tr><td colspan="3" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<td></tr>'); // get data
        window.history.pushState({state:1}, "Manage Products", "?tab=products&tab2=manage-products");

        $.get("/get-data/manage-products-in-store/0", function(data){
            if (data.status == 'not have access') {
                $('.render-products-m').html('<?php echo $_GET["dont-have-access-in-store"]; ?>');
            } else {
                $('.render-products-m').html(data.products);
            }            
        });         
    }
    function transferProducts(sid) {
        window.history.pushState({state:1}, "Transfer Products", "?tab=products&tab2=transfer-products");

        $('.pro-block.transfer').html('<div class="my-5" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>'); // get data
        $.get("/get-data/store-transfers/"+sid, function(data){
            if (data.status == 'not have access') {
                $('.pro-block.transfer').html('<?php echo $_GET["dont-have-access-in-store"]; ?>');
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
        $.get("/get-data/manage-products-in-store/"+lastid, function(data){
            $('.load-more-rows').css('display','none');
            $('.render-products-m').append(data.products);
        });         
    });
    $(document).on('click', '.update-m-p', function(e) {
        e.preventDefault();
        $('.full-cover').css('display','block');
        $('.full-cover .inside').html('<i class="fa fa-spinner fa-spin fa-2x"></i>');
        var pid = $(this).attr('pid');
        var stores = [];
        $('input.storee'+pid+':checkbox:checked').each(function () {
            stores.push($(this).val());
        });
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData();
        formdata.append('pid',pid);
        formdata.append('stores',stores);
        formdata.append('status','update manage store products');
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
    
    function calculateStockValue(sid) {
        $('.r-total-cost, .r-total-price, .r-total-profit').html('<i class="fa fa-spinner fa-spin"></i>');
        window.history.pushState({state:1}, "Products Value", "?tab=products&tab2=products-value");

        $.get("/get-data/stock-value-in-store/"+sid, function(data){
            $('.r-total-price').html(data.tp);
            $('.r-total-cost').html(data.tc);            
            $('.r-total-profit').html(data.profit);
        });          
    }

    function reportCarousel() {
        $.get("/report/products-n-days-in-store/<?php echo $data['store']->id; ?>", function(data){
            $('.total-products').html(data.data.total_products);        
            $('.today-p-in').html(data.data.total_today_pin);       
            $('.ten-p-in').html(data.data.total_ten_pin);       
            $('.today-p-out').html(data.data.total_today_pout);       
            $('.ten-p-out').html(data.data.total_ten_pout); 
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
        
        $.get("/get-form/new-product/store~<?php echo $data['store']->id; ?>", function(data){
            $('.pro-block.new').html(data.form);        
        });         
    }
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
                    // window.location = '/products?opt=preview-product&pid='+data.pid;
                    // $('.new-product')[0].reset();
                    $('.create-new-product').click();
                    $('.new-product [name="pcategory"]').val("").trigger('change');
                    $('.notification-body').html('<div class="row">'+
                                '<div class="col-12 text-success"><i class="fa fa-check-circle fa-2x"></i> <br> <b>'+data.pname+'</b> is created successfully </div>'+
                                '<div class="col-12 mt-5">'+
                                    '<div class="mb-4"><button class="btn btn-info" data-dismiss="modal" aria-label="Close"><i class="fa fa-plus pr-2"></i> <?php echo $_GET["create-another-product"]; ?></button></div>'+
                                    '<div style="display:none" class="mb-2"><a href="/stores/<?php echo $data["store"]->id; ?>?tab=products&tab2=preview&pid='+data.pid+'#add-quantity" class="btn btn-secondary"><i class="fa fa-plus pr-2"></i> <?php echo $_GET["add-quantity"]; ?> (stock)</a></div>'+
                                    '<div style="display:none"><a href="/stores/<?php echo $data["store"]->id; ?>?tab=products&pid='+data.pid+'" class="btn btn-primary"><i class="fa fa-eye pr-2"></i> <?php echo $_GET["preview"]; ?> '+data.pname+'</a></div>'+
                                    '<div style="display:none" class="mb-2"><a href="/stores/<?php echo $data["store"]->id; ?>?tab=sell-products" class="btn btn-success"><i class="fa fa-dollar pr-2"></i> <?php echo $_GET["sell-products"]; ?></a></div>'+
                                    '<div><a href="#" class="btn btn-primary products-tab-opt" data-dismiss="modal" aria-label="Close"><i class="fa fa-eye pr-2"></i> <?php echo $_GET["see-all-products"]; ?></a></div>'+
                                '</div></div>');
                    $('#notificationModal').modal('toggle');
                    // renderProducts(); 
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
        var store_pro = "<?php echo $data['store']->id; ?>~"+pid;
        $.get("/get-data/product-details-tab-store/"+store_pro, function(data){
            $('.pd-loader').css('display','none');
            if (data.status == 'not have access') {
                $('.pro-block.preview').html('<?php echo $_GET["dont-have-access-in-store"]; ?>');
            } else {
                if($.isEmptyObject(data.products)) {
                    // no products in this store
                } else {           
                    $('.pro-actions [name="pid"]').val(data.product[0]['pid']);
                    $('.pro-actions [name="pname"]').val(data.product[0]['pname']);
                    $('.pro-actions [name="store_product"]').val(data.product[0]['spid']);
                    $('.pro-actions .add-quantity, .pro-actions .change-quantity').attr('qty',Number(data.product[0]['quantity']));
                    $('.pro-actions .remove-from-store, .pro-actions .delete-product').attr({'product':data.product[0]['pid'],'name':data.product[0]['pname']});
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
                    $('.year-summ .q-in').html(Number(data.quantityIn));
                    $('.year-summ .q-out').html(Number(data.trout));
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
            $('.pstore-activities .check-i-activities').click();

            // $('.pro-block.preview').html(data.view);        
        });         
    }
    $(document).on('change','.pro-review .change-product',function(e){
        e.preventDefault();
        var pid = $(this).val();
        history.replaceState({}, document.title, "?tab=products&tab2=preview&pid="+pid);
        getProductDetails(pid);
    });    
    $(document).on('click','.pstore-activities .check-i-activities',function(e){
        e.preventDefault();
        $(this).prop('disabled', true).html('Checking..');
        var pid = getSearchParams("pid");
        var fdate = $('.pstore-activities input[name="date_fa"]').val();
        var tdate = $('.pstore-activities input[name="date_ta"]').val();
        fdate = fdate.split('/').join('-');
        tdate = tdate.split('/').join('-');
        getProductActivities("<?php echo $data['store']->id; ?>",pid,fdate,tdate);
    });
    function getProductActivities(store_id,product_id,fdate,tdate) {          
        var store_pro_date = store_id+'~'+product_id+'~'+fdate+'~'+tdate;
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

        $.get("/get-data/store-product-activities/"+store_pro_date, function(data){
            $('.check-i-activities').prop('disabled', false).html('Check');

            var start = new Date(new_fdate);
            var end = new Date(new_tdate);
            var showmore = "";
            
            var loop = new Date(end);
            var thisdate;

            if ($.isEmptyObject(data.newstockQ) && $.isEmptyObject(data.trin) && $.isEmptyObject(data.adjust) && $.isEmptyObject(data.trout)) {
                $('.render-activities').html('<tr><td colspan="3"><div align="center" class="col-12 my-3">- Empty Records -<div></td></tr>');
            } else {
                $('.render-activities .loader').html("");
                var avaQ = data.availableQ;
                
                while(loop >= start){   
                    thisdate = loop.getFullYear()+'-'+("0" + (loop.getMonth() + 1)).slice(-2)+'-'+("0" + (loop.getDate())).slice(-2);
                    var sumQ = newstockQ = trin = trout = adjust = returnedQ = 0;

                    const exists = data.newstockQ.some(obj => Object.values(obj).includes(thisdate));
                    const exists3 = data.trin.some(obj => Object.values(obj).includes(thisdate));
                    const exists4 = data.adjust.some(obj => Object.values(obj).includes(thisdate));
                    const exists6 = data.trout.some(obj => Object.values(obj).includes(thisdate));

                    if (exists || exists3 || exists4 || exists6) {
                        if(exists) {
                            var i = getIndexByValue(data.newstockQ, 'date', thisdate);
                            newstockQ = Number(data.newstockQ[i].quantity);
                            $('.sp-'+thisdate).css('display','table-row');
                            $('.sp-'+thisdate+' .d').append('New stock: <b>'+Number(data.newstockQ[i].quantity)+'</b><br>');
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
                        if(exists6) {
                            var i = getIndexByValue(data.trout, 'date', thisdate);
                            trout = Number(data.trout[i].quantity);
                            $('.sp-'+thisdate).css('display','table-row');
                            $('.sp-'+thisdate+' .d').append('Transfer Out: <b>'+Number(data.trout[i].quantity)+'</b><br>');
                        }
                        
                        $('.sp-'+thisdate+' .b').html('<b>'+Number(avaQ)+'</b>');

                        avaQ = Number(avaQ) - Number(newstockQ) - Number(adjust) + Number(trout) - Number(trin);
                    } else {
                        // console.log('No activity');
                    }
                    
                    var newDate = loop.setDate(loop.getDate() - 1);
                }
            }
            // if(data.output.length > 0) {
            //     $('.render-activities').html(data.output);
            // } else {
            //     $('.render-activities').html('<tr><td colspan="3" align="center"><i>-- Empty records --</i></td></tr>');
            // }                
        });
    }
    function getIndexByValue(array, key, value) {
        return array.findIndex(obj => obj[key] === value);
    }

    function getStoreProductDetails(store_id,product_id) {
        var store_pro = store_id+'~'+product_id;
        $('.render-product-details').html('<div align="center" class="col-12 my-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>');
        $.get("/get-data/product-details-report-store/"+store_pro, function(data){
            if (data.status == 'not have access') {
                $('.render-product-details').html('<?php echo $_GET["dont-have-access-in-store"]; ?>');
            } else {
                $('.render-product-details').html(data.view);
                var hash = location.hash;
                if(hash == "#add-quantity") {
                    $('.pro-actions .add-quantity').click();
                }
            }  
            productsInOut(store_id,product_id);
        });      
    }

    function productsInOut(store_id,product_id) {          
        var store_pro = store_id+'~'+product_id;
        $('.render-product-in-out').html('<div align="center" class="col-12 my-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>');
        $.get("/get-data/product-in-out-store-tab/"+store_pro, function(data){
            $('.render-product-in-out').html(data.view);
            // productSales(shop_id,product_id);
        });
    }

    $(document).on('click','.pro-actions .edit-product', function(e){
        e.preventDefault();
        var pid = $('.pro-actions [name="pid"]').val();
        $('#editProduct').modal('show');
        $('#editProduct .modal-body').html('<div align="center" class="py-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>');
        
        $.get('/get-data/edit-product/product~'+pid, function(data) {
            // $('.render-product-name').html(data.product.product.name);
            // $('.render-product-details').html('<div class="col-12 edit-p-margin">'+data.view+'<div>');
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
        $.get("/get-data/deleted-products-store/<?php echo $data['store']->id; ?>", function(data){
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
        $.get("/get-data/restore-product-store/"+pid+"~<?php echo $data['store']->id; ?>", function(data){
            $('#deletedProducts').modal('hide'); 
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            popNotification('success','Product restored successfully');
            $('.change-products-option').change();
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
                    '<div class="col-12"> Add Quantity of <b>'+pname+'</b> in <b>'+sname+'</b> store </div>'+
                    '<div class="col-12 mt-3">'+
                        '<div><?php echo $_GET["available-quantity"]; ?> <br> <h2>'+pqty+'</h2></div>'+
                        '<div><?php echo $_GET["quantity-you-add"]; ?> <br> <input type="number" name="qty" class="form-control" placeholder="0" style="width:100px">'+
                        approval+
                        '<div class="col-12 mb-2 mt-4"><button class="btn btn-info confirm-add-quantity"><i class="fa fa-check pr-2"></i> <?php echo $_GET["add"]; ?></button><button class="btn btn-secondary ml-2" data-dismiss="modal" aria-label="Close"> <?php echo $_GET["cancel"]; ?></button></div>'+
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
        formdata.append('status','add store quantity');
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
    
    $(document).on('click','.pro-actions .change-quantity', function(e){
        e.preventDefault();
        var pname = $('.pro-actions [name="pname"]').val();
        var sname = $('.pro-actions [name="sname"]').val();
        var pid = $('.pro-actions [name="pid"]').val();
        var sid = $('.pro-actions [name="sid"]').val();
        var pqty = $(this).attr('qty');
        
        $('#notificationModal').modal('toggle');
        $('.notification-body').html('<div class="row change-q-form">'+
                    '<div class="col-12"> Change Quantity of <b>'+pname+'</b> in <b>'+sname+'</b> store </div>'+
                    '<div class="col-12 mt-3">'+
                        '<div><?php echo $_GET["available-quantity"]; ?> <br> <h2>'+pqty+'</h2></div>'+
                        '<div><?php echo $_GET["fill-new-quantity"]; ?> <br> <input type="number" name="qty" class="form-control" placeholder="0" style="width:100px">'+
                        '<div class="mt-3"><?php echo $_GET["why-you-change"]; ?> ? <br> <textarea class="form-control" name="desc" style="width:200px"></textarea></div>'+
                        '<div class="col-12 mb-2 mt-3"><button class="btn btn-info confirm-change-quantity"><i class="fa fa-check pr-2"></i> Submit</button><button class="btn btn-secondary ml-2" data-dismiss="modal" aria-label="Close"> <?php echo $_GET["cancel"]; ?></button></div>'+
                    '</div></div>');
    });    
    $(document).on("click", ".confirm-change-quantity", function(e) {
        e.preventDefault();
        var id = $('.pro-actions [name="store_product"]').val();
        var quantity = $('.change-q-form [name="qty"]').val();
        var desc = $('.change-q-form [name="desc"]').val();
        
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData();
        formdata.append('id',id);
        formdata.append('quantity',quantity);
        formdata.append('desc',desc);
        formdata.append('status','store');
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
                        // getStoreProductDetails($('.pro-actions [name="sid"]').val(),$('.pro-actions [name="pid"]').val());
                        $('.pro-review .change-product').change();
                        popNotification('success','Successful quantity updated');
                    }
                }
        });
    });
    
    $(document).on('click','.remove-from-store',function(e){
        e.preventDefault();
        var name = $(this).attr('name');
        var pid = $(this).attr('product');
        var sid = $(this).attr('store');
        $('.notification-body').html('<div class="row">'+
                    '<div class="col-12"><i class="fa fa-warning fa-2x text-warning"></i> <br> Please confirm that you are removing <b>'+name+'</b> from this store </div>'+
                    '<div class="col-12 mt-5">'+
                        '<div class="mb-2"><button class="btn btn-danger confirm-remove-from-store" store="'+sid+'" product="'+pid+'"><i class="fa fa-trash pr-2"></i> <?php echo $_GET["remove"]; ?></button><button class="btn btn-secondary ml-2" data-dismiss="modal" aria-label="Close"> <?php echo $_GET["cancel"]; ?></button></div>'+
                    '</div></div>');
        
        $('#notificationModal').modal('toggle');
    });
    $(document).on('click','.confirm-remove-from-store', function(e) {
        e.preventDefault();
        var pid = $(this).attr('product');
        var sid = $(this).attr('store');
        var shop_pro = sid+'~'+pid;
        $('.notification-body').html('<div align="center" class="my-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Removing...<div>');

        $.get('/update/remove-product-from-store/'+shop_pro, function(data) {
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
                        '<div class="mb-2"><button class="btn btn-danger confirm-delete-product" product="'+pid+'"><i class="fa fa-trash pr-2"></i> <?php echo $_GET["delete"]; ?></button><button class="btn btn-secondary ml-2" data-dismiss="modal" aria-label="Close"> <?php echo $_GET["cancel"]; ?></button></div>'+
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
                        '<div class="mb-2"><button class="btn btn-info submit-edit-pcategory" cid="'+cid+'"> <?php echo $_GET["update"]; ?></button><button class="btn btn-secondary ml-2" data-dismiss="modal" aria-label="Close"> <?php echo $_GET["cancel"]; ?></button></div>'+
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
    function renderProductCategoriesTab() {
        $('.shop-tabs .nav-link, .other-tabs .nav-link, .shop-tab-conten .tab-pane, #Products .nav-link').removeClass('active');
        $('.shop-tabs .products-tab, .other-tabs .products-tab, #Products, #Products .products-outer-block, #Products .cats-opt').addClass('active');
        $('.products-outer-block').html('<div align="center" class="my-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>');
        
        $.get("/get-data/product-categories-tab/<?php echo $data['store']->id; ?>", function(data){
            $('.products-outer-block').html(data.pcategories);        
        });         
    }    
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
                        '<div class="mb-2"><button class="btn btn-danger confirm-delete-p-category" cid="'+cid+'" cname="'+cname+'"><i class="fa fa-trash pr-2"></i> <?php echo $_GET["delete"]; ?></button><button class="btn btn-secondary ml-2" data-dismiss="modal" aria-label="Close"> <?php echo $_GET["cancel"]; ?></button></div>'+
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

    function getProductsIn(sid) {
        $('.pending-stock, .received-stock').html("<tr><td colspan='2' align='center'><i class='fa fa-spinner fa-spin'></i> Loading...</td></tr>");
        window.history.pushState({state:1}, "Products In", "?tab=products&tab2=products-in");

        var pending_stock_approval = "<?php echo Auth::user()->company->cashier_stock_approval; ?>";

        if (pending_stock_approval == "no") {
            $('.pending-stock-block').addClass('displaynone');
        } else {
            $.get("/get-data/pending-products-in-store/"+sid, function(data){
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
        $.get('/report-by-date-range/previous-stock-records-in-store/'+fromdate+'/'+todate+'/<?php echo $data["store"]->id; ?>', function(data) { 
            $('.received-stock').html("");
            if($.isEmptyObject(data.sum)) {
                $('.received-stock').html('<tr class="empty-row"><td align="center"><i>-- No new stock --</i></td></tr>');
            } else {
                for (let i = 0; i < data.sum.length; i++) {
                    $('.received-stock').append(
                        '<tr><td style="border-top:none"><div class="pb-2"><div style="margin-bottom:-5px;">'+data.sum[i]['date']+'</div> <small>Quantity Bought:</small> <b>'+Number(data.sum[i]['quantity'])+'</b> <small class="pl-2">Total Price:</small> <b>'+Number(data.sum[i]['total_price']).toLocaleString('en')+'</b></div>'
                            +'<div class="bi-'+data.sum[i]['date']+' pt-2" style="border-top:1px solid #dee2e6"></div></td>'
                    );
                }
                for (let j = 0; j < data.items.length; j++) {
                    $('.bi-'+data.items[j]['date']).append(
                        '<div class="row pb-2">'
                            +'<div class="col-9"><div style="margin-bottom:-3px;">'+data.items[j]['pname']+'</div> <b class="b_q" style="font-weight: bolder;">'+Number(data.items[j]['quantity'])+'</b><span> x </span><span>'+Number(data.items[j]['price']).toLocaleString('en')+'</span><span> = </span><span>'+Number(data.items[j]['total']).toLocaleString('en')+'</span></div>'
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

    $(document).on('click', '#Products .quantity-opt', function(e) {
        e.preventDefault();
        window.history.pushState({state:1}, "Products In", "?tab=products&opt=products-in");
        renderProductsIn();
    });
    function renderProductsIn() {
        $('.shop-tabs .nav-link, .other-tabs .nav-link, .shop-tab-conten .tab-pane, #Products .nav-link').removeClass('active');
        $('.shop-tabs .products-tab, .other-tabs .products-tab, #Products, #Products .products-outer-block, #Products .quantity-opt').addClass('active');
        $('.products-outer-block').html('<div align="center" class="my-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>');
        
        $.get("/get-data/get-products-in-store-tab/<?php echo $data['store']->id; ?>", function(data){
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
                        '<div class="col-12 mb-2 mt-3"><button class="btn btn-info confirm-change-added-quantity" sid="'+stock_id+'"><i class="fa fa-check pr-2"></i> <?php echo $_GET["change"]; ?></button><button class="btn btn-secondary ml-2" data-dismiss="modal" aria-label="Close"> <?php echo $_GET["cancel"]; ?></button></div>'+
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
                        '<div class="mb-2"><button class="btn btn-danger confirm-delete-added-quantity" sid="'+stock_id+'"><i class="fa fa-trash pr-2"></i> <?php echo $_GET["delete"]; ?></button><button class="btn btn-secondary ml-2" data-dismiss="modal" aria-label="Close"> <?php echo $_GET["cancel"]; ?></button></div>'+
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
        $.get('/get-data/stock-report-store/<?php echo $data["store"]->id; ?>', function(data){
            if (data.status == 'not have access') {
                $('.render-stock-report').html('<?php echo $_GET["dont-have-access-in-store"]; ?>');
            } else {
                $('.render-stock-report').html(data.view);
            }            
        });
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
        $.get("/suppliers/store-suppliers/<?php echo $data['store']->id; ?>", function(data){
            $('.render-suppliers').html(data.view);          
        });
    });
    $(document).on('click', '.supplier-details', function(e) {
        e.preventDefault();
        var sid = $(this).attr('sid');
        window.history.pushState({state:1}, "Preview Supplier", "?tab=suppliers&supplier_id="+sid);
        openSupplierTab(sid);
    });
    function openSupplierTab(supplier_id) {
        window.history.pushState({state:1}, "Preview Supplier", "?tab=suppliers&supplier_id="+supplier_id);
        $('.shop-tabs .nav-link, .other-tabs .nav-link, .shop-tab-conten .tab-pane, #Products .nav-link').removeClass('active');
        $('.shop-tabs .suppliers-tab, .other-tabs .suppliers-tab, #Suppliers, #Products .products-outer-block').addClass('active');
        $('.render-suppliers').html('<div class="my-5" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>');
        $.get("/suppliers/get-store-supplier/<?php echo $data['store']->id; ?>~"+supplier_id, function(data){
            $('.render-suppliers').html(data.view);         
        });
    }
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
                    '<input type="hidden" name="from" value="store">'+
                    '<input type="hidden" name="storeid" value="<?php echo $data["store"]->id; ?>">'+
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
                        supplierYearSummary("<?php echo $data['store']->id; ?>~"+data.supplier);
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
                    supplierYearSummary("<?php echo $data['store']->id; ?>~"+data.supplier);
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
                    '<input type="hidden" name="storeid" value="<?php echo $data["store"]->id; ?>">'+
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
                        supplierYearSummary("<?php echo $data['store']->id; ?>~"+data.supplier);
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
                        $('.suppliers-tab').click();
                    } else {
                        popNotification('warning',"Error! System failed to delete supplier.");
                    }
                }
        });              
    });
    $(document).on('change', '.pq-select select', function(e){
        e.preventDefault();
        var pid = $(this).val();
        var suppid = (new URL(location.href)).searchParams.get('supplier_id');
        if(pid == "-") { } else {
            $.get("/suppliers/add-purchased-item/<?php echo $data['store']->id; ?>~"+suppid+"~"+pid+"~store", function(data){
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

        $.get("/suppliers/edit-submitted-details/<?php echo $data['store']->id; ?>~"+suppid+"~"+date+"~store", function(data){
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
                        supplierYearSummary("<?php echo $data['store']->id; ?>~"+suppid);
                        $('#notificationModal').modal('hide');
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
        $('.render-transfers').html('<div class="mt-3" align="center">Loading...</div>'); // get data
        $.get('/get-data/store-transfers/<?php echo $data["store"]->id; ?>', function(data){
            if (data.status == 'not have access') {
                $('.render-transfers').html('<?php echo $_GET["dont-have-access-in-store"]; ?>');
            } else {
                $('.render-transfers').html(data.view);
            }            
        });
    });
    function transferForm() {
        $('#transferForm').modal('toggle');
        $('.render-transfer-form').html('<div class="my-5" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...<div>');
        $.get("/get-data/transfer-items-store/<?php echo $data['store']->id; ?>", function(data){
            if (data.status == 'not have access') {
                $('.render-transfer-form').html('<?php echo $_GET["dont-have-access-in-store"]; ?>');
            } else {
                $('.render-transfer-form').html(data.view);
            }      

            $(".select2").select2({
                dropdownParent: $("#transferForm")
            });      
        });
    }
    function transferItems() {
        $('.render-transfers').html('<div class="mt-3" align="center">Loading...</div>');
        window.history.pushState({state:1}, "Transfer Items", "?tab=transfer-items");
        $('.shop-tabs .nav-link, .other-tabs .nav-link, .shop-tab-conten .tab-pane').removeClass('active');
        $('.shop-tabs .transfer-tab, .other-tabs .transfer-tab, #Transfer').addClass('active');
        $.get('/get-data/transfer-items-store/<?php echo $data["store"]->id; ?>', function(data){
            if (data.status == 'not have access') {
                $('.render-transfers').html('<?php echo $_GET["dont-have-access-in-store"]; ?>');
            } else {
                $('.render-transfers').html(data.view);
            }            
        });
    };

    
// transfer records
$(document).on('click', '.edit-transfer', function(e) {
    e.preventDefault();
    $('button').prop('disabled', true);
    $(this).html("Editing...");
    var tno = $(this).attr('transfer');
    $('#viewTransferModal').modal('hide');
    $.get('/edit-transfer/'+tno, function(data){
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
    $.get('/transfer-items/'+tno+'/store/<?php echo $data["store"]->id; ?>', function(data){
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
        if (data.success) {
            popNotification('success',"Success! transfer has been deleted.");
            // $('.transfer-tab-blc').click();
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
        popNotification('success',"Success! transfer has been received.");
        // $('.transfer-tab-blc').click();
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
                    // window.location = "/"+urlArray[1]+"/users";
                }
            }
    });
});
$(document).on('click', '.clear-transfer-cart2', function(e) {
    e.preventDefault();
    var store_id = $('[name="fromid"]').val();
    $('button').prop('disabled', true);
    $('.fa-spin').css('display','');
    $.get('/clear-transfer-cart/store/'+store_id, function(data){
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
    var store_id = $('[name="fromid"]').val();
    var transferno = $('[name="transferno"]').val();
    if (transferno) {} else {
        transferno = 'null';
    }
    $('button').prop('disabled', true);
    $('.fa-spin').css('display','');

    $.get('/submit-transfer-cart/store/'+store_id+'/'+transferno, function(data){
        popNotification('success','Success! items transfered successfully.');
        // $('.transfer-tab-blc').click();
        $('#transferForm').modal('hide');
        $('.modal').remove();
        $('.modal-backdrop').remove();
        $('body').removeClass( "modal-open" );
        $(".change-products-option").val("transfer-products").change();
    });
});
// end transfer items 


// change store || custom select
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


</script>
@endsection