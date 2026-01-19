@extends('layouts.app')
@section('css')
<style type="text/css">
    .tab-pane .body {padding-left: 0px;padding-right: 0px;padding-top: 0px;}
    .tab-pane .header {padding-left: 0px;}
    .tab-pane .header h2 {font-size: 18px;}
    #AvaStock .body {margin-top:25px}
    /*.stock-card .nav-out {width: 300px;}*/
    .stock-card ul.nav {
        width: 100%;padding-right: 27px;
        flex-wrap:nowrap;
        overflow: hidden !important;
        overflow-x: auto !important;
        overflow-y: hidden !important;
        white-space: nowrap !important;
    }
    .stock-card ul.nav {padding-bottom: 10px;}
    .stock-card ul.nav .nav-item {
        /*display: inline-block;min-width: 50px;float: none;*/
    }
    .stock-card .tabs-drop {
        position: absolute;
        right: 0;
        background-color: #000;
        color: white;
        padding: 7px 5px 7px 10px;
        min-width: 30px;
        cursor: pointer;
        -moz-box-shadow: 3px 3px 5px 6px #ccc;
        -webkit-box-shadow: 3px 3px 5px 6px #ccc;
        box-shadow: -3px 0px 4px 0px #ccc;
    }
    .stock-card .tabs-drop i {font-size: 20px;}
    .stock-card .other-tabs {
        background-color: #f0f0f0;
        position: absolute;
        right: 0px;min-width: 150px;
        z-index: 9;margin-top: 36px;
        display: none;
        -moz-box-shadow: 3px 3px 5px 6px #ccc;
        -webkit-box-shadow: 3px 3px 5px 6px #ccc;
        box-shadow: -3px 3px 4px 0px #ccc;
    }
    .stock-card .other-tabs ul.nav {display: block;padding-right: 0px;}
    .stock-card .other-tabs ul.nav .nav-item {
        display: block;
    }
    .stock-card .other-tabs ul.nav .nav-item a.active {
        background: #01b2c6;color: #fff;
    }
    @media screen and (max-width: 767px) {
        .stock-card ul.nav {margin-left: -15px;padding-right: 13px;}
        .stock-card .other-tabs {margin-top: 33px;}
        .stock-card .other-tabs ul.nav {margin-left: 0px;}
        .stock-card .tabs-drop {
            padding: 3px 5px 3px 10px;font-size: 18px;
        }
        .stock-card ul.nav .nav-item a {
            padding: 5px 10px;
        }
    }
    @media screen and (max-width: 480px) {
        .stock-card {padding-left: 0px;padding-right: 0px;}
        .stock-card .tabs-drop {
            padding: 4px 5px 4px 8px;font-size: 14px;
        }
        .stock-card .other-tabs {margin-top: 30px;}
        #AvaStock .header-dropdown {position: relative;right: 0px;margin-right: 0px; left: 0px;}
        #AvaStock .header-dropdown li {margin-left: -10px;}
        #AvaStock .header-dropdown b {display: block;}
        #AvaStock .header-dropdown p {position: absolute; right: 0px;margin-right: -30px; margin-top: -20px;text-align: right;}
        #AvaStock .header-dropdown p .wrds {display: block;margin-bottom: 2px;}
        #AvaStock .body {margin-top:28px}
        .tab-pane .header h2 {font-size: 16px;}
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
                    <div class="col-lg-12 col-md-12 stock-card">
                        <div class="card">
                            <div class="body">
                                <div class="row">
                                    <div class="col-12 nav-out" style="padding-right: 0px;">
                                    <ul class="nav nav-tabs-new" id="stock-tabs">
                                        <li class="nav-item"><a class="nav-link ava-stock-tab active" data-toggle="tab" href="#AvaStock"><?php echo $_GET['available-stock']; ?></a></li>
                                        @if(Auth::user()->isCEOorAdmin())
                                        <li class="nav-item"><a class="nav-link add-stock-tab" data-toggle="tab" href="#addStock"><?php echo $_GET['add-stock']; ?></a></li>
                                        @endif
                                        <li class="nav-item"><a class="nav-link previous-stock-records-tab" data-toggle="tab" href="#StockRecords"><?php echo $_GET['previous-stock-records']; ?></a></li>
                                        <li class="nav-item"><a class="nav-link item-activities-tab" data-toggle="tab" href="#itemActivities"><?php echo $_GET['item-activities']; ?></a></li>
                                        <li class="nav-item"><a class="nav-link transfer-records-tab" data-toggle="tab" href="#transferRecords"><?php echo $_GET['transfer-records-menu']; ?></a></li>
                                        <li class="nav-item"><a class="nav-link stock-adjustment-tab" data-toggle="tab" href="#stockAdjustment"><?php echo $_GET['stock-adjustment-menu']; ?></a></li>
                                        <li class="nav-item"><a class="nav-link stock-taking-tab" data-toggle="tab" href="#stockTaking"><?php echo $_GET['stock-taking-menu']; ?></a></li>
                                    </ul>
                                    </div>
                                    <div class="tabs-drop">
                                      <i class="fa fa-angle-double-right"></i>
                                    </div>
                                    <div class="other-tabs">
                                        <ul class="nav" id="">
                                            <li class="nav-item"><a class="nav-link ava-stock-tab" data-toggle="tab" href="#AvaStock"><?php echo $_GET['available-stock']; ?></a></li>
                                            @if(Auth::user()->isCEOorAdmin())
                                            <li class="nav-item"><a class="nav-link add-stock-tab" data-toggle="tab" href="#addStock"><?php echo $_GET['add-stock']; ?></a></li>
                                            @endif
                                            <li class="nav-item"><a class="nav-link previous-stock-records-tab" data-toggle="tab" href="#StockRecords"><?php echo $_GET['previous-stock-records']; ?></a></li>
                                            <li class="nav-item"><a class="nav-link item-activities-tab" data-toggle="tab" href="#itemActivities"><?php echo $_GET['item-activities']; ?></a></li>
                                            <li class="nav-item"><a class="nav-link transfer-records-tab" data-toggle="tab" href="#transferRecords"><?php echo $_GET['transfer-records-menu']; ?></a></li>
                                            <li class="nav-item"><a class="nav-link stock-adjustment-tab" data-toggle="tab" href="#stockAdjustment"><?php echo $_GET['stock-adjustment-menu']; ?></a></li>
                                            <li class="nav-item"><a class="nav-link stock-taking-tab" data-toggle="tab" href="#stockTaking"><?php echo $_GET['stock-taking-menu']; ?></a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="row render-stockings" style="border-top:1px solid #ddd;margin-top: 10px;">
                                    <div class="col-12">
                                        <div class="tab-content padding-0">
                                            <!-- available stock -->
                                            <div class="tab-pane active" id="AvaStock">
                                                
                                                <div class="header">
                                                    <h2>Available stock</h2>
                                                    <ul class="header-dropdown">
                                                        <li>
                                                            <b>shop/store:</b>
                                                            <select class="form-control-sm change-shopstore" name="shopstore" style="">
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
                                                            <p style="padding: 10px 0px;">
                                                                <span class="wrds">Total quantities:</span>
                                                                <span class="bg-dark text-light px-2 py-1 ml-2 totalQty"></span>
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </div>                                                
                                                <div class="body">
                                                    <div class="row">
                                                        <div class="table-responsive">
                                                            <table class="table m-b-0 c_list">
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
                                            </div>
                                            <!-- stock records -->
                                            <div class="tab-pane" id="StockRecords">
                                                @include('tabs.previous-stock-records')
                                            </div>
                                            <!-- add stock -->
                                            <div class="tab-pane" id="addStock">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="">      
                                                            <div class="header">
                                                                <h2><?php echo $_GET['add-stock']; ?>:</h2>
                                                            </div>  
                                                            <div class="body pt-0 render-new-stock-form">
                                                                
                                                            </div>   
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- item activities -->
                                            <div class="tab-pane" id="itemActivities">

                                            </div>
                                            <!-- transfer records -->
                                            <div class="tab-pane" id="transferRecords">
                                                @include('tabs.transfer-records')
                                            </div>
                                            <!-- stock adjustment -->
                                            <div class="tab-pane" id="stockAdjustment">
                                                @include('tabs.stock-adjustment')
                                            </div>
                                            <!-- stock taking -->
                                            <div class="tab-pane" id="stockTaking">
                                                @include('tabs.stock-taking')
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

    @include('modals.new-stock')
    @include('modals.new-stock-view')

@endsection

@section('js')
<script type="text/javascript">
    $('.select2').select2();
    var is_ceo = "<?php echo Auth::user()->isCEOorAdminorBusinessOwner(); ?>";

    $(document).ready(function(){
        // show hide cat menu
        $(".stock-card .tabs-drop").click(function () {
            $(".other-tabs").stop(true).toggle("slow");
            $(this).html(function (i, t) {
                return t == '<i class="fa fa-angle-double-down"></i>' ? '<i class="fa fa-angle-double-right"></i>' : '<i class="fa fa-angle-double-down"></i>';
            });
        });
    });

    $(document).mouseup(function(e) {
        var container = $(".other-tabs");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
          var classes = $('.fa-angle-double-down').parent().closest('div').attr('class');
          $('.'+classes).click();
        }
    });

    $(function () {

        var stock_tab = getSearchParams("tab");
        if ($.isEmptyObject(stock_tab)) {
            
            $('.ava-stock-tab').click();
        } else {
            if (stock_tab == "available-stock") {
                $('.ava-stock-tab').click();
            } else if (stock_tab == "previous-stock-records") {
                $('.stock-card .nav-tabs-new').animate({
                  scrollLeft: "+=75px"
                }, "slow");
                $('.previous-stock-records-tab').click();
            } else if (stock_tab == "add-stock") {
                if (is_ceo == 1) {
                    $('.add-stock-tab').click();
                } else {window.location = "/stock";}                
            } else if (stock_tab == "item-activities") {
                $('.stock-card .nav-tabs-new').animate({
                  scrollLeft: "+=120px"
                }, "slow");
                $('.item-activities-tab').click();
            } else if (stock_tab == "transfer-records") {
                $('.stock-card .nav-tabs-new').animate({
                  scrollLeft: "+=300px"
                }, "slow");
                $('.transfer-records-tab').click();
            } else if (stock_tab == "stock-adjustment") {
                $('.stock-card .nav-tabs-new').animate({
                  scrollLeft: "+=400px"
                }, "slow");
                $('.stock-adjustment-tab').click();
            } else if (stock_tab == "stock-taking") {
                $('.stock-card .nav-tabs-new').animate({
                  scrollLeft: "+=500px"
                }, "slow");
                $('.stock-taking-tab').click();
            } else {
                window.location = "/stock";
            }
        }
    });

    function getSearchParams(k){
     var p={};
     location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(s,k,v){p[k]=v})
     return k?p[k]:p;
    }

    $(document).on('click', '.ava-stock-tab', function(e) {

        e.preventDefault();
        $('#stock-tabs .nav-link, .render-stockings .tab-pane, .other-tabs .nav-link').removeClass('active');
        $('#stock-tabs .ava-stock-tab, .render-stockings #AvaStock, .other-tabs .ava-stock-tab').addClass('active');
        history.replaceState({}, document.title, "?tab=available-stock");
        $('.change-shopstore').change();
    });

    $(document).on('change','.change-shopstore',function(e){
        e.preventDefault();
        var shopstore = $(this).val();
        
        $('.render-quantities').html('<tr><td colspan="3">Loading...</td></tr>');
        $.get('/report/stockR/'+shopstore+'/available', function(data){ 
            $('.totalQty').html(parseFloat(data.data.totalQty));
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
                $('.render-quantities').append('<tr><td>'+num+'</td><td>'+obj.k+'</td><td>'+parseFloat(obj.v)+'</td></tr>');
                   
            });
        });
    });

    $(document).on('click', '.previous-stock-records-tab', function(e){

        e.preventDefault();
        $('.pending-stock, .received-stock').html("<tr><td>Loading...</td></tr>");

        $('#stock-tabs .nav-link, .render-stockings .tab-pane, .other-tabs .nav-link').removeClass('active');
        $('#stock-tabs .previous-stock-records-tab, .render-stockings #StockRecords, .other-tabs .previous-stock-records-tab').addClass('active');
        history.replaceState({}, document.title, "?tab=previous-stock-records");

        $.get('/ceo/report/pending-stock-2/', function(data) { 
            $('.pending-stock').html("");
            $('.pending-stock').append(data.view);
        });   

        $('.check-pre-stock').click();
    });

    $(document).on('click', '.check-pre-stock', function(e){
        e.preventDefault();
        $('.received-stock').html("<tr><td>Loading...</td></tr>");
        var fromdate = $('.from-date').val();
        fromdate = fromdate.split('/').join('-');
        var todate = $('.to-date').val();
        todate = todate.split('/').join('-');
        $.get('/report-by-date-range/previous-stock-records/'+fromdate+'/'+todate+'/all', function(data) { 
            $('.received-stock').html("");
            $('.received-stock').append(data.items);
        });   
    });

    $(document).on('click', '.add-stock-tab', function(e) {
        e.preventDefault();
        $('.full-cover').css('display','block');
        $('.full-cover .inside').html('Loading...');
        $('#stock-tabs .nav-link, .render-stockings .tab-pane, .other-tabs .nav-link').removeClass('active');
        $('#stock-tabs .add-stock-tab, .render-stockings #addStock, .other-tabs .add-stock-tab').addClass('active');
        history.replaceState({}, document.title, "?tab=add-stock");
        $.get('/get-form/new-stock/0', function(data) {
            $('.full-cover').css('display','none');
            $('.render-new-stock-form').html(data.form);
        });           
    });

    $(document).on('click', '.item-activities-tab', function(e) {
        e.preventDefault();
        $('.full-cover').css('display','block');
        $('.full-cover .inside').html('Loading...');
        $('#stock-tabs .nav-link, .render-stockings .tab-pane, .other-tabs .nav-link').removeClass('active');
        $('#stock-tabs .item-activities-tab, .render-stockings #itemActivities, .other-tabs .item-activities-tab').addClass('active');
        history.replaceState({}, document.title, "?tab=item-activities");
        $.get('/ceo/report/item-activities/', function(data) { 
            $('.full-cover').css('display','none');
            $('#itemActivities').html(data.view);
        });   
    });

    $(document).on('click', '.transfer-records-tab', function(e) {
        e.preventDefault();
        $('#stock-tabs .nav-link, .render-stockings .tab-pane, .other-tabs .nav-link').removeClass('active');
        $('#stock-tabs .transfer-records-tab, .render-stockings #transferRecords, .other-tabs .transfer-records-tab').addClass('active');
        history.replaceState({}, document.title, "?tab=transfer-records");
        $('.check-p-trans-rec').click();
        $('.check-r-trans-rec').click();
    });

    $(document).on('click', '.check-p-trans-rec', function(e) {
        e.preventDefault();
        $('.render-p-transfers').html("<tr><td>Loading...</td></tr>");
        var fromdate = $('.from-date-t').val();
        fromdate = fromdate.split('/').join('-');
        var todate = $('.to-date-t').val();
        todate = todate.split('/').join('-');
        $.get('/report-by-date-range/pending-transfers/'+fromdate+'/'+todate+'/all', function(data) { // we are passing dates but we are not considering them.. all pending should be displayed
            $('.render-p-transfers').html("");
            $('.render-p-transfers').append(data.items);
        });   
    });

    $(document).on('click', '.check-r-trans-rec', function(e) {
        e.preventDefault();
        $('.render-r-transfers').html("<tr><td>Loading...</td></tr>");
        var fromdate = $('.from-date-rt').val();
        fromdate = fromdate.split('/').join('-');
        var todate = $('.to-date-rt').val();
        todate = todate.split('/').join('-');
        $.get('/report-by-date-range/received-transfers/'+fromdate+'/'+todate+'/all', function(data) { 
            $('.render-r-transfers').html("");
            $('.render-r-transfers').append(data.items);
        });   
    });

    $(document).on('click', '.stock-adjustment-tab', function(e) {
        e.preventDefault();
        $('#stock-tabs .nav-link, .render-stockings .tab-pane, .other-tabs .nav-link').removeClass('active');
        $('#stock-tabs .stock-adjustment-tab, .render-stockings #stockAdjustment, .other-tabs .stock-adjustment-tab').addClass('active');
        history.replaceState({}, document.title, "?tab=stock-adjustment");
        $('.adjust-in-form').click();
    });

    $(document).on('click', '.adjust-in-form', function(e) {
        e.preventDefault();
        $('#adjustInForm').addClass('active');
        $("#adjustInForm .shopstore").change();
    });

    $(document).on('click', '.adjust-in-records', function(e) {
        e.preventDefault();
        $('#adjustInRecords').addClass('active');
        $("#adjustInRecords .shopstore").change();
    });
    
    $("#adjustInForm .shopstore").on('change', function(e) {
        e.preventDefault();
        var shopstore = $(this).val();
        appendStockList(shopstore);
    });

    function appendStockList(shopstore) {
        $('.render-st-items').html('<tr class="asloader"><td><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i> Loading...</td></tr>');
        var split = shopstore.split("-");
        shopstore = split[0]; 
        shopstoreval = split[1];
        $.get('/stock/adjust/'+shopstore+'/'+shopstoreval, function(data) {  
            $('.render-st-items').html(data.items);
        });   
    }

    $(document).on("click", ".update-stc", function(e) {
        e.preventDefault();
        $(this).prop('disabled', true).html('updating..');
        var id = $(this).attr("row");
        var status = $(this).attr("status");
        var quantity = $('.q-'+id).val();
        var desc = $('.d-'+id).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formdata = new FormData();
        formdata.append('id',id);
        formdata.append('quantity',quantity);
        formdata.append('desc',desc);
        formdata.append('status',status);
        $.ajax({
            type: 'POST',
            url: '/update-adjust-stock',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.u-'+data.id).prop('disabled', false).html('Update');
                    if (data.error) {
                        popNotification('warning',data.error);
                    } else {
                        $('.q-'+data.id).val("");
                        $('.d-'+data.id).val("");
                        $('.aq-'+data.id).html(data.quantity);
                        popNotification('success','Successful updated');
                    }
                }
        });
    });

    $("#adjustInRecords .shopstore").on('change', function(e) {
        e.preventDefault();
        $('.render-us-items').html('<tr class="asloader"><td><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i> Loading...</td></tr>');
        $.get('/stock/records/all/all', function(data) { 
            $('.render-sa-summary').html(data.items);
        });   
        var shopstore = $(this).val();
        appendUpdatedStock(shopstore);
    });

    function appendUpdatedStock(shopstore) {
        var split = shopstore.split("-");
        shopstore = split[0]; 
        shopstoreval = split[1];
        $.get('/stock/records/'+shopstore+'/'+shopstoreval, function(data) {  
            if(data.items) {
                $('.render-us-items').html(data.items);
            } else {
                $('.render-us-items').html('<tr class="asloader"><td colspan="7"><i>-- No records --</i></td></tr>');
            }            
        });   
    }

    $(document).on('click', '.stock-taking-tab', function(e) {
        e.preventDefault();
        $('#stock-tabs .nav-link, .render-stockings .tab-pane, .other-tabs .nav-link').removeClass('active');
        $('#stock-tabs .stock-taking-tab, .render-stockings #stockTaking, .other-tabs .stock-taking-tab').addClass('active');
        history.replaceState({}, document.title, "?tab=stock-taking");
        $('.taking-in-form').click();
    });

    $(document).on('click', '.taking-in-form', function(e) {
        e.preventDefault();
        $('#takingInForm').addClass('active');
        $("#takingInForm .shopstore").change();
    });

    $(document).on('click', '.taking-in-records', function(e) {
        e.preventDefault();
        $('#takingInRecords').addClass('active');
        $("#takingInRecords .shopstore").change();
    });
    
    $("#takingInForm .shopstore").on('change', function(e) {
        e.preventDefault();
        var shopstore = $(this).val();
        $('.render-stf-items').html('<tr class="asloader"><td><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i> Loading...</td></tr>');
        var split = shopstore.split("-");
        shopstore = split[0]; 
        shopstoreval = split[1];
        $.get('/stock/taking/'+shopstore+'/'+shopstoreval, function(data) {  
            $('.render-stf-items').html(data.items);
        });   
    });

    $("#takingInRecords .shopstore").on('change', function(e) {
        e.preventDefault();
        $('.render-str-items').html('<tr class="asloader"><td><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i> Loading...</td></tr>');
        $('.balance').html("--"); $('.increase').html("--"); $('.decrease').html("--");          
        var shopstore = $(this).val();
        var split = shopstore.split("-");
        shopstore = split[0]; 
        shopstoreval = split[1];
        $.get('/stock/st-records/'+shopstore+'/'+shopstoreval, function(data) {  
            $('.balance').html(data.data.balance); $('.increase').html(data.data.increase); $('.decrease').html(data.data.decrease); $('.titems').html(data.data.titems);
            if(data.items) {
                $('.render-str-items').html(data.items);
            } else {
                $('.render-str-items').html('<tr class="asloader"><td colspan="7"><i>-- No records --</i></td></tr>');
            }            
        });   
    });

    $(document).on("click", ".update-stt", function(e) {
        e.preventDefault();
        $(this).prop('disabled', true).html('updating..');
        var id = $(this).attr("row");
        var status = $(this).attr("status");
        var quantity = $('.qt-'+id).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formdata = new FormData();
        formdata.append('id',id);
        formdata.append('quantity',quantity);
        formdata.append('status',status);
        $.ajax({
            type: 'POST',
            url: '/update-stock-taking',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.u-'+data.id).prop('disabled', false).html('Update');
                    if (data.error) {
                        popNotification('warning',data.error);
                    } else {
                        $('.qt-'+data.id).val("");
                        $('.d-'+data.id).val("");
                        $('.aq-'+data.id).html(data.quantity);
                        popNotification('success','Successful updated');
                    }
                }
        });
    });

</script>
@endsection