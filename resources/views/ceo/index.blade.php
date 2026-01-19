@extends('layouts.app')
@section('css')
<style type="text/css">
    .sales-sm .bg-color1 {
        background: #f9a11d;padding-bottom: 10px;margin-bottom: 20px;
        /* height: 85px; */
    }
    .sales-sm .bg-color2 {
        background: #f9a11d;height: 85px;
    }
    .sales-sm .bg-color3 {
        background: #f9a11d;height: 85px;
    }
    .sales-sm .today-summary, .sales-sm .week-summary, .sales-sm .month-summary, .sales-sm .past-n-days {
        text-align: center;background: #01b2c6;padding: 0px;
    }
    .sales-sm .row .col-5, .sales-sm .row .col-3, .sales-sm .row .col-4 {
        background: #01b2c6;padding: 0px;
    }
    .sales-sm .today-summary h5, .sales-sm .week-summary h5, .sales-sm .month-summary h5, .sales-sm .past-n-days h5 {
        margin-left: 10px;
    }
    /* .sales-body {
        min-height: 110px;
    } */

    .switch-shop2, .switch-store2 {font-size:16px !important;}
    .switch-shop2 img, .switch-store2 img {float: left;}
    .switch-shop2 .s-right, .switch-store2 .s-right {display:inline-block;margin-left: 13px;}
    .switch-shop2 .s-right .name, .switch-store2 .s-right .name {font-size:16px !important;color: #007bff;}
    .switch-shop2 .s-right .location, .switch-store2 .s-right .location {font-size:13px !important;color: #222;}
    
  /* @media screen and (max-width: 991px) {
    .sales-body {
        min-height: 180px;
    }
  } */
  @media screen and (max-width: 575px) {
    .sales-sm .bg-color2 {
        margin-top: 30px;
    }
    .sales-sm .bg-color3 {
        margin-top: 30px;
    }
  }
  @media screen and (max-width: 480px) {
    .sales-sm {
        padding-left: 5px; padding-right: 5px;
    }
    .sales-sm .today-summary h5, .sales-sm .week-summary h5, .sales-sm .month-summary h5, .sales-sm .past-n-days h5 {
        font-size: 1.3rem;font-weight: bold;margin-bottom: 5px;
    }
    .sales-sm .bg-color1 {
        margin-bottom: 15px;
    }
    .sales-body .col-6 {
        padding-left: 10px;padding-right: 10px;
    }
    /* .sales-sm .bg-color1, .sales-sm .bg-color2, .sales-sm .bg-color3 {height: 73px;} */
  }

  .stock-report .time {
    margin-top: -10px;
  }

  .other-roles .separator {
    padding-left: 5px;padding-right: 5px;
  }
</style>
@endsection
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
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12">
                        <div class="row clearfix">                           
                            @include('layouts.switch-role')
                        </div>
                    </div>                    
 
                    <div class="col-lg-12 col-md-12 sales-sm">
                        <div class="card">
                            <div class="header">
                                <h2><?php echo $_GET['sales-report-menu']; ?>:</h2>
                                <ul class="header-dropdown">
                                    <li>
                                        <!-- <a href="/business-owner/report/sales" class="more"><span style="display: inline-flex;"><?php echo $_GET['view-in-details']; ?> <span style="padding-left: 5px;padding-top: 1px;"><i class="wi wi-right"></i></span></span> </a> -->
                                        <span><?php echo $_GET['last-10-days']; ?></span>
                                    </li>
                                </ul>
                            </div>
                            <div class="body pt-0 pb-0 sales-body">
                                <div class="row">
                                    <div class="col-md-3 col-6">
                                        <div class="bg-color1 text-light px-2 pt-1">
                                            <div class="mb-1"><b><?php echo $_GET['total-sales']; ?></b></div>
                                            <div class="row past-n-days">
                                                  <div class="col-12"><h5 class="t-n-sales pt-1"></h5></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6" style="display:none">
                                        <div class="bg-color1 text-light px-2 pt-1">
                                            <div class="mb-1"><b><?php echo $_GET['profit']; ?></b></div>
                                            <div class="row past-n-days">
                                                  <div class="col-12"><h5 class="t-n-profit pt-1"></h5></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <div class="bg-color1 text-light px-2 pt-1">
                                            <div class="mb-1"><b><?php echo $_GET['expenses-menu']; ?></b></div>
                                            <div class="row past-n-days">
                                                  <div class="col-12"><h5 class="t-n-expenses pt-1"></h5></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <div class="bg-color1 text-light px-2 pt-1">
                                            <div class="mb-1"><b><?php echo $_GET['quantity-sold']; ?></b></div>
                                            <div class="row past-n-days">
                                                  <div class="col-12"><h5 class="t-n-quantities pt-1"></h5></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12"> 
                        <div class="card">
                            <div class="header" style="border-bottom:1px solid #ddd;">
                                <h2><?php echo $_GET['shops']; ?>:</h2>
                                <ul class="header-dropdown">
                                    <li>
                                        <button class="btn btn-info btn-sm add-shop"><?php echo $_GET['create-new-shop']; ?></button>
                                    </li>
                                </ul>
                            </div>
                            <div class="body pt-1 other-roles">
                                <div class="row append-new-shop">
                                    @foreach($data['shops'] as $shop)
                                    <div class="role-col col-md-6 col-sm-6 col-12">
                                        <div class="switch-shop2 pb-3 mt-2 pt-1" shop="{{$shop->id}}">
                                            <img src="/images/shop.png" width="50" alt="">
                                            <div class="s-right"> 
                                                <span class="name">{{$shop->name}} <span class="align-right pl-3"><i class="fa fa-arrow-right"></i></span></span>
                                                <br> <span class="location"><i class="fa fa-map-marker"></i> {{$shop->location}}</span>                                                
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach  
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="header" style="border-bottom:1px solid #ddd;">
                                <h2><?php echo $_GET['stores']; ?>:</h2>
                                <ul class="header-dropdown">
                                    <li>
                                        <button class="btn btn-info btn-sm add-store"><?php echo $_GET['create-new-store']; ?></button>
                                    </li>
                                </ul>
                            </div>
                            <div class="body pt-1 other-roles">
                                <div class="row append-new-store">
                                    @if($data['stores']->isNotEmpty())
                                    @foreach($data['stores'] as $store)
                                    <div class="role-col col-md-6 col-sm-6 col-12">
                                        <div class="switch-store2 pb-3 mt-2 pt-1" store="{{$store->id}}">
                                            <img src="/images/store.png" width="50" alt="">
                                            <div class="s-right">
                                                <span class="name">{{$store->name}} <span class="align-right pl-3"><i class="fa fa-arrow-right"></i></span></span>
                                                <br> <span class="location"><i class="fa fa-map-marker"></i> {{$store->location}}</span>                                                
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach  
                                    @else
                                    <div class="col-12 empty-store-desc">
                                        <div class="mt-3">
                                            Hakuna stoo/godown iliyotengenezwa. <br> Benyeza <a href="#" class="add-store">HAPA</a> kutengeza stoo kisha bonyeza jina la stoo uweze kutunza taarifa za mzigo ulionao stoo pamoja na kuweza kuhamisha mzigo kutoka stoo kwenda dukani au kutoka stoo moja kwenda stoo ingine.
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 sales-sm" style="display:none">
                        <div class="card">
                            <div class="header">
                                <h2><?php echo $_GET['sales-in-summary']; ?>:</h2>
                                <ul class="header-dropdown">
                                    <li>
                                        <a href="/ceo/report/sales" class="more"><span style="display: inline-flex;"><?php echo $_GET['view-in-details']; ?> <span style="padding-left: 5px;padding-top: 1px;"><i class="wi wi-right"></i></span></span> </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="body pt-0 sales-body">
                                <div class="row">
                                    <div class="col-md-4 col-sm-4">
                                        <div class="bg-color1 text-light px-2 pt-1">
                                            <h6 class="mb-1"><b><?php echo $_GET['today']; ?></b></h6>
                                            <div class="row today-summary">
                                                  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4">
                                        <div class="bg-color2 text-light px-2 pt-1">
                                            <h6 class="mb-1"><b><?php echo $_GET['this-week']; ?></b></h6>
                                            <div class="row week-summary">

                                            </div>   
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4">
                                        <div class="bg-color3 text-light px-2 pt-1">
                                            <h6 class="mb-1"><b><?php echo $_GET['this-month']; ?></b></h6>
                                            <div class="row month-summary">

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
    </div>

    @include('modals.new-shop')
    @include('modals.new-store')

@endsection

@section('js')
<script type="text/javascript">
    $(function () {
        var loading = '<div class="loading" style="margin:auto"><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i> Loading...</div>';
        $('.today-summar, .week-summary, .month-summary, .t-n-sales, .t-n-profit, .t-n-expenses, .t-n-quantities').html(loading);
        $('.render-users').html("<tr><td class='align-center' colspan='4'>Loading...</td></tr>");
        salesReport();
    });

    function salesReport() {
        // $.get('/report/sales/all', function(data){ 
        //     $('.today-summary').html('<div class="col-5 col-sm-12 col-lg-5"><strong>Sales</strong><h5>'+data.data.today_price+'</h5></div><div class="col-3 col-sm-6 col-lg-3"><strong>Quant.</strong><h5>'+parseFloat(data.data.today_quantity)+'</h5></div><div class="col-4 col-sm-6 col-lg-4"><strong>Expenses</strong><h5 class="todayE">0</h5></div>');
        //     $('.week-summary').html('<div class="col-5 col-sm-12 col-lg-5"><strong>Sales</strong><h5>'+data.data.week_price+'</h5></div><div class="col-3 col-sm-6 col-lg-3"><strong>Quant.</strong><h5>'+parseFloat(data.data.week_quantity)+'</h5></div><div class="col-4 col-sm-6 col-lg-4"><strong>Expenses</strong><h5 class="weekE">0</h5></div>');
        //     $('.month-summary').html('<div class="col-5 col-sm-12 col-lg-5"><strong>Sales</strong><h5>'+data.data.month_price+'</h5></div><div class="col-3 col-sm-6 col-lg-3"><strong>Quant.</strong><h5>'+parseFloat(data.data.month_quantity)+'</h5></div><div class="col-4 col-sm-6 col-lg-4"><strong>Expenses</strong><h5 class="monthE">0</h5></div>');
        //     $('.today-r').html(data.data.today_price);
        //     $('.week-r').html(data.data.week_price);
        //     $('.month-r').html(data.data.month_price);
        //     expensesReport();
        // });
        $.get('/report/sales-n-days/all', function(data){ 
            $('.t-n-sales').html(data.data.total_price);
            $('.t-n-profit').html(data.data.profit);
            $('.t-n-quantities').html(parseFloat(data.data.total_quantity));
            expensesReport();
        });
    }

    function expensesReport() {
        // $.get('/report/expenses/all', function(data){ 
        //     $('.todayE').html(data.data.today_expenses);
        //     $('.weekE').html(data.data.week_expenses);
        //     $('.monthE, .month-e').html(data.data.month_expenses);
        //     stockReport();
        // });
        $.get('/report/expenses-n-days/all', function(data){ 
            $('.t-n-expenses').html(data.data.total_expenses);
            stockReport();
        });
    }

    
    $(document).on('click', '.add-shop', function(e){
        e.preventDefault();
        $('.new-shop')[0].reset();
        $('#newShop').modal('toggle');
    });
    
    $(document).on('click', '.add-store', function(e){
        e.preventDefault();
        $('.new-store')[0].reset();
        $('#newStore').modal('toggle');
    });
    
</script>
@endsection