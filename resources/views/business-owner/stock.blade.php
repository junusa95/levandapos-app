@extends('layouts.app')
@section('css')
<style type="text/css">
    
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
<style type="text/css">
    #Home-new2 .choose-ss {padding-top: 5px;text-align: right;}
    @media screen and (max-width: 501px) {
        .nav-tabs-new2 li a {padding:5px 10px;}
    }    
    @media screen and (max-width: 441px) {
        .nav-tabs-new2 li a {font-size: 13px;}
    }    
    @media screen and (max-width: 415px) {
        #Home-new2 .ss-list ul {padding-left:0px !important}
        #Home-new2 .choose-ss {padding-left: 7px;}
    }    
    @media screen and (max-width: 401px) {
        .nav-tabs-new2 {width: 112%;margin-left: -20px;}
        .nav-tabs-new2 li a {padding:5px 8px;}
    }    
</style>
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="header">
                                <h2>Stock Report:</h2>
                            </div>
                            <div class="body pt-0">
                                <div>
                                    <ul class="nav nav-tabs-new2">
                                        <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#Home-new2">Quantity per Item</a></li>
                                        <li class="nav-item itemA"><a class="nav-link" data-toggle="tab" href="#Profile-new3">Item Activities</a></li>
                                        <li class="nav-item transfersR"><a class="nav-link" data-toggle="tab" href="#Profile-new2">Transferers</a></li>
                                    </ul>
                                    <div class="row">
                                        <div class="tab-content" style="width:100%">
                                            <div class="tab-pane show active" id="Home-new2">
                                                <div class="row">
                                                    <div class="col choose-ss"><b class="ssTitle-D">Choose shop/store:</b></div>
                                                    <div class="col ss-list" style="padding-left:0px !important">
                                                        <ul style="list-style:none;">
                                                            <li>
                                                                <select class="form-control-sm change-shopstore" name="shopstore" style="width:100%">
                                                                    <option value="all">All</option>
                                                                    <option class="bg-success text-light" disabled>-- Shops</option>
                                                                    @if($data['shops'])
                                                                    @foreach($data['shops'] as $shop)
                                                                        <option value="shop-{{$shop->id}}">{{$shop->name}}</option>
                                                                    @endforeach
                                                                    @endif
                                                                    <option class="bg-success text-light" disabled>-- Stores</option>
                                                                    @if($data['stores'])
                                                                    @foreach($data['stores'] as $store)
                                                                        <option value="store-{{$store->id}}">{{$store->name}}</option>
                                                                    @endforeach
                                                                    @endif
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-md-7 mb-3">
                                                        Total Available Stock: 
                                                        <span class="bg-dark text-light px-2 py-1 ml-2 totalQty"></span>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead class="thead-light">
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Name</th>
                                                                    <th>Quantity</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="render-quantities">

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="Profile-new3">
                                                
                                                @include("partials.item-activities")

                                            </div>
                                            <div class="tab-pane" id="Profile-new2"> 
                                                <div class="row">
                                                    <div class="col-md-4 col-sm-4 col-6">
                                                        <div class="form-group">
                                                            <label style="margin-bottom: 1px;">Date</label>
                                                            <input type="text" name="date_r" data-provide="datepicker" data-date-autoclose="true" class="form-control" placeholder="From" value="<?php echo date('d/m/Y'); ?>">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead class="thead-light">
                                                                <tr>
                                                                    <th>Transfer #</th>
                                                                    <th>Item Name</th>
                                                                    <th>Qty</th>
                                                                    <th>From</th>
                                                                    <th>To</th>
                                                                    <th>Status</th>
                                                                    <th>Time</th>
                                                                    <th>Users</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="render-titems">

                                                            </tbody>
                                                        </table>
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
        </div>
    </div>
@endsection
@section('js')
<script type="text/javascript">
    $('.select2').select2();

    $(function () {
        function getSearchParams(k){
         var p={};
         location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(s,k,v){p[k]=v})
         return k?p[k]:p;
        }
        var shopstore = getSearchParams("shopstore");
        if ($.isEmptyObject(shopstore)) {
            shopstore = "all";
        } 
        $('.change-shopstore').val(shopstore).change();
        // var shopstore = $('.change-shopstore').val();

        getStockReport(shopstore);
    });


    $(document).on('change','.change-shopstore',function(e){
        e.preventDefault();
        $('.render-quantities').html('<tr><td colspan="3">Loading...</td></tr>');
        var shopstore = $(this).val();
        var refresh = window.location.protocol + "//" + window.location.host + window.location.pathname + '?shopstore='+shopstore;    
        window.history.pushState({ path: refresh }, '', refresh);
        getStockReport(shopstore);
    });

    $(document).on('click','.transfersR',function(e){
        e.preventDefault();
        var date = $('input[name="date_r"]').val();
        date = date.split('/').join('-');
        if ($(this).hasClass('clicked')) {

        } else {
            $('.render-titems').html('<tr><td colspan="8">Loading...</td></tr>');
            var shopstore = $('.change-shopstore').val();
            $.get('/report/transferR/'+shopstore+'/'+date, function(data){ 
                $('.transfersR').addClass('clicked');
                $('.render-titems').html("");
                $('.render-titems').append(data.items);
            });
        }
    });

    $(document).on('change','input[name="date_r"]',function(e){
        e.preventDefault();
        var date = $(this).val();
        date = date.split('/').join('-');
        $('.render-titems').html('<tr><td colspan="8">Loading...</td></tr>');
        var shopstore = $('.change-shopstore').val();
        $.get('/report/transferR/'+shopstore+'/'+date, function(data){ 
            $('.render-titems').html("");
            $('.render-titems').append(data.items);
        });
    });

    function getStockReport(shopstore) {
        $.get('/report/stockR/'+shopstore+'/available', function(data){ 
            $('.totalQty').html(data.data.totalQty);
            $('.render-quantities').html("");
            if (shopstore == "all") {
                $('.ssTitle').html("All Locations:");
            } else {
                if (data.data.shopstore == "shop") {
                    $('.ssTitle').html(data.data.shop.name+":");
                }
                if (data.data.shopstore == "store") {
                    $('.ssTitle').html(data.data.store.name+":");
                }
            }
            var num = 0;
            var temp = [];
            $.each(data.quantities, function(key, value) {
                temp.push({v:value, k: key});
            });
            temp.sort(function(a,b){
               if(a.v < b.v){ return 1}
                if(a.v > b.v){ return -1}
                  return 0;
            });
            $.each(temp, function(key, obj) {
                num = key+1;
                $('.render-quantities').append('<tr><td>'+num+'</td><td>'+obj.k+'</td><td>'+obj.v+'</td></tr>');
                   
            });
        });
    }

    $(document).on('click','.itemA',function(e){
        e.preventDefault();
        if ($(this).hasClass('clicked')) {

        } else {
            $(this).addClass('clicked');
            $('.check-i-activities').click();
        }
    });
    $(document).on('click','.check-i-activities',function(e){
        e.preventDefault();
        var fdate = $('input[name="date_fa"]').val();
        var tdate = $('input[name="date_ta"]').val();
        var shopstore = $('.change-shopstore2').val();
        var product = $('.change-product').val();
        fdate = fdate.split('/').join('-');
        tdate = tdate.split('/').join('-');
        productActivities(shopstore,product,fdate,tdate);
    });

    function productActivities(shopstore,item,from,to) {
        var shopstoreitem = shopstore+"~"+item;
        $('.render-activities').html('<tr><td colspan="3">Loading... <br> Itachukua muda kidogo..</td></tr>');
        $.get('/report-by-date-range/product-activities/'+from+'/'+to+'/'+shopstoreitem, function(data){ 
            console.log(data.data.sales);
            $('.render-activities').html(data.output);
        });
    }

</script>
@endsection
