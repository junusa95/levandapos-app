@extends('layouts.app')
@section('css')
<style type="text/css">

    .sold-products, .sold-products2, .edit-sale {
        /*font-size: 13px;*/
    }
    .sold-products tr td, .sold-products2 tr td, .edit-sale tr td {
        padding-top: 5px;padding-bottom: 5px;
    }
    .sold-products .quantity, .sold-products2 .quantity, .edit-sale .quantity2 {
        width:60px;padding:0px;padding-left:5px;display: inline-block;
    }
    .sold-products .aqty, .sold-products2 .aqty, .edit-sale .aqty {
        margin-left: 3px;font-size: 12px;
    }
    .sold-products .sprice, .sold-products2 .sprice, .edit-sale .sprice2 {
        width:90px;padding:0px;padding-left:5px;
    }
    .sold-products2 tr {
        border-bottom: dotted 1px #ddd;
    }
    .sold-products2 .row {
        margin-left: -10px;margin-right: -10px;
    }
    .sold-products2 .r-name {
        padding-left: 5px;padding-right: 0px;
    }
    .sold-products2 .r-name span {
        color: red;padding: 0px 2px;cursor: pointer;
    }
    .total-row {
        font-weight: bold;
    }
    .total-row td {
        padding-left: 15px;
    }
    .sales-sm .bg-color1 {
        background: #f9a11d;height: 85px;
    }
    .sales-sm .bg-color2 {
        background: #f9a11d;height: 85px;
    }
    .sales-sm .bg-color3 {
        background: #f9a11d;height: 85px;
    }
    .sales-sm .today-summary, .sales-sm .week-summary, .sales-sm .month-summary {
        text-align: center;background: #01b2c6;padding: 0px;
    }
    .sales-sm .row .col-5, .sales-sm .row .col-3, .sales-sm .row .col-4 {
        background: #01b2c6;padding: 0px;
    }
    .sales-sm .today-summary h5, .sales-sm .week-summary h5, .sales-sm .month-summary h5 {
        margin-left: 10px;
    }
    .sale-details p {
        line-height: 10px;
    }
    .sale-details.show {
        display: block;
    }
    .sale-details.hide {
        display: none;
    }
    .paida {
        width: 100px;padding: 2px;
    }
    .sales-summary-h {
        margin-top: 25px;
    }
    .sales-summary-h div {
        display: inline-block;margin-right: 15px;margin-bottom: 10px;
    }
    .modal table input, .modal table button {
        display: inline-block;
    }
    .modal table button {
        padding-top: 2px !important;padding-bottom: 1px !important;
    }
    .sales-body {
        min-height: 110px;
    }
  @media screen and (max-width: 991px) {
    .sales-body {
        min-height: 180px;
    }
  }   
  @media screen and (max-width: 575px) {
    .sales-sm .bg-color2 {
        margin-top: 30px;
    }
    .sales-sm .bg-color3 {
        margin-top: 30px;
    }
  }
  @media screen and (max-width: 480px) {
    .sales-sm .today-summary h5, .sales-sm .week-summary h5, .sales-sm .month-summary h5 {
        font-size: 1rem;font-weight: bold;margin-bottom: 5px;
    }
    .sales-sm .bg-color1, .sales-sm .bg-color2, .sales-sm .bg-color3 {height: 73px;}
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

                    <input type="hidden" name="shopid" value="{{$data['shop']->id}}">
                    
                    <div class="col-lg-12 col-sm-12 sales-sm">
                        <div class="card">      
                            <div class="header">
                                <h2><?php echo $_GET['sales-in-summary']; ?>:</h2>
                            </div>     
                            <div class="body pt-0 sales-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="bg-color1 text-light px-2 pt-1">
                                            <h6 class="mb-1"><b><?php echo $_GET['today']; ?></b></h6>
                                            <div class="row today-summary">
                                                  
                                            </div>
                                        </div>
                                    </div>                
                                    <div class="col-sm-4">
                                        <div class="bg-color2 text-light px-2 pt-1">
                                            <h6 class="mb-1"><b><?php echo $_GET['this-week']; ?></b></h6>
                                            <div class="row week-summary">

                                            </div>   
                                        </div>
                                    </div>                
                                    <div class="col-sm-4">
                                        <div class="bg-color3 text-light px-2 pt-1">
                                            <h6 class="mb-1"><?php echo $_GET['this-month']; ?></h6>
                                            <div class="row month-summary">

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
                                <h2>Sales:</h2>
                                <ul class="header-dropdown">
                                    <li>
                                        <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#returnSoldItems">
                                            Return sold items
                                        </button>
                                    </li>
                                </ul>
                            </div>     
                            <div class="body">
                                <form id="basic-form" class="form">
                                  <select class="form-control-sm col-md-1 col-3 this-y-2">
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                  </select>
                                  <select class="form-control-sm col-md-2 col-5 this-m-2">
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                  </select>
                                  <select class="form-control-sm col-md-1 col-3 this-d-2">
                                    
                                  </select>
                                </form>
                                <div class="sales-summary-h" style="">
                                    <div>
                                        <strong>Total Sales:</strong><span class="bg-dark text-light px-2 py-1 ml-1 totalSP"></span>
                                    </div>
                                    <div class="">
                                        <strong>Total Quantity:</strong><span class="bg-dark text-light px-2 py-1 ml-1 totalSQ"></span>
                                    </div>   
                                    <div class="expenses">
                                        <strong><?php echo $_GET['expenses-menu']; ?>:</strong>
                                        <span class="bg-dark text-light px-2 py-1 ml-1">
                                            <span class="totalE"></span>
                                            <a href="#" class="view-expenses ml-2"><i class="fa fa-eye"></i></a>
                                        </span>                                        
                                    </div>   
                                    <div class="deni">
                                        <strong>Deni tunadai:</strong>
                                        <span class="bg-dark text-light px-2 py-1 ml-1">
                                            <span class="totalD"></span>
                                            <a href="#" class="view-deni ml-2"><i class="fa fa-eye"></i></a>
                                        </span>                                        
                                    </div>   
                                    <div class="ameweka">
                                        <strong>Pesa imeingia:</strong>
                                        <span class="bg-dark text-light px-2 py-1 ml-1">
                                            <span class="totalA"></span>
                                            <a href="#" class="view-ameweka ml-2"><i class="fa fa-eye"></i></a>
                                        </span>                                        
                                    </div>   
                                    <div class="tumelipa">
                                        <strong>Pesa imetoka:</strong>
                                        <span class="bg-dark text-light px-2 py-1 ml-1">
                                            <span class="totalT"></span>
                                            <a href="#" class="view-tumelipa ml-2"><i class="fa fa-eye"></i></a>
                                        </span>                                        
                                    </div>   
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-12 my-3 px-1">
                                        <div class="table-responsive">
                                            <table class="table table-borderless m-b-0 c_list">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Sold items</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="sales-report sold-products2">
                                                    
                                                </tbody>
                                                <tbody class="total-row">
                                                    <tr>
                                                        <td>
                                                            <div class="row" style="margin:0px">
                                                                <div class="col-2" style="padding-top: 10px;">Total</div>
                                                                <div class="col-10" style="">
                                                                    <div>
                                                                        <span style="padding-right: 3px;font-weight: 100;">Quantity</span>:<span class="pl-1 totalSQ"></span>
                                                                    </div>
                                                                    <div>
                                                                        <span  style="padding-right: 8px;font-weight: 100;">Amount</span>:<span class="pl-1 totalSP"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <!-- <tr>
                                                        <td></td>
                                                        <th>Total</th>
                                                        <th class="totalSQ">0</th>
                                                        <td></td>
                                                        <th class="totalSP">0</th>
                                                    </tr> -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-12 px-1">
                                        <div class="table-responsive">
                                            <table class="table js-basic-example dataTable table-custom mt-3">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th colspan="6" class="pb-0">
                                                            <h4>Closure Note</h4>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>Expected Amount</th>
                                                        <th>Submitted Amount</th>
                                                        <th>Status</th>
                                                        <th>Shop</th>
                                                        <th>Closed by</th>
                                                        <th>Time</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody class="closure-sale">
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mx-0">
                                <div class="col-12 col-md-5 mb-5 returned-block" style="display:none;">
                                    <div>
                                        <h5>Items Returned on this date:</h5>
                                    </div>
                                    <table class="table m-b-0">
                                        <thead>
                                            <tr>
                                                <th>Item name</th>
                                                <th>Qty</th>
                                                <th class="align-right">Date sold</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody class="render-returned-items">

                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-12 col-md-5 offset-md-1 returned-block2" style="display:none;">
                                    <div>
                                        <h5>Returned Items that sold on this date:</h5>
                                    </div>
                                    <table class="table m-b-0">
                                        <thead>
                                            <tr>
                                                <th>Item name</th>
                                                <th>Qty</th>
                                                <th class="align-right">Date Returned</th>
                                            </tr>
                                        </thead>
                                        <tbody class="render-returned-items2">

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

    <!-- modal -->
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

    <!-- modal Expenses -->
    <div class="modal fade" id="expensesModal" tabindex="-1" role="dialog" aria-labelledby="expensesModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6>Expenses</h6>
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                        <button class="btn btn-danger btn-sm">x</button>
                    </span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-12">
                            <div class="table-responsive">
                                <table class="table table-borderless m-b-0 c_list">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Item</th>
                                            <th>Amount</th>
                                            <th>Description</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="expenses-report">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal Tunawadai -->
    <div class="modal fade" id="madeniModal" tabindex="-1" role="dialog" aria-labelledby="madeniModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                        <button class="btn btn-danger btn-sm">x</button>
                    </span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-12">
                            <div class="table-responsive">
                                <div>Deni kutoka kwenye bidhaa walizonunua.</div>
                                <table class="table table-borderless m-b-0 c_list">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Mteja</th>
                                            <th>Thamani ya bidhaa</th>
                                            <th>Fedha aliyolipa</th>
                                            <th>Deni</th>
                                        </tr>
                                    </thead>
                                    <tbody class="madeni-list">
                                        <tr><td></td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive mt-3">
                                <div>Mteja amekopeshwa pesa taslim.</div>
                                <table class="table table-borderless m-b-0 c_list">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Mteja</th>
                                            <th>Kias alichokopa</th>
                                        </tr>
                                    </thead>
                                    <tbody class="kopesha-cash-list">
                                        <tr><td></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal Tumelipa -->
    <div class="modal fade" id="tumelipaModal" tabindex="-1" role="dialog" aria-labelledby="tumelipaModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                        <button class="btn btn-danger btn-sm">x</button>
                    </span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-12">
                            <div class="table-responsive">
                                <div>Wateja waliolipwa madeni au kurudishiwa pesa zao.</div>
                                <table class="table table-borderless m-b-0 c_list">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Mteja</th>
                                            <th>Kias</th>
                                            <th>Sababu</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tumelipa-list">
                                        <tr><td></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal Wanatudai -->
    <div class="modal fade" id="amewekaModal" tabindex="-1" role="dialog" aria-labelledby="amewekaModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6>Wateja wameweka pesa</h6>
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                        <button class="btn btn-danger btn-sm">x</button>
                    </span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-12">
                            <div class="table-responsive">
                                <div>Ongezeko la pesa kwenye bidhaa walizonunua.</div>
                                <table class="table table-borderless m-b-0 c_list">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Mteja</th>
                                            <th>Thamani ya bidhaa</th>
                                            <th>Fedha aliyolipa</th>
                                            <th>Anatudai</th>
                                        </tr>
                                    </thead>
                                    <tbody class="ameweka-list">
                                        <tr><td></td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive mt-3">
                                <div>Mteja ameweka pesa taslim.</div>
                                <table class="table table-borderless m-b-0 c_list">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Mteja</th>
                                            <th>Kias alichoweka</th>
                                        </tr>
                                    </thead>
                                    <tbody class="ameweka-cash-list">
                                        <tr><td></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modals.return-sold-items')    

@endsection

@section('js')
<script type="text/javascript">
    $('.select2').select2();

    var shop_id = $('[name="shopid"]').val();
    var d = new Date();
    var date = d.getDate();
    var month = d.getMonth()+1; 
    var year = d.getFullYear();
    var today = date+"-"+month+"-"+year;

    $(function () {
        $('.today-summary, .week-summary, .month-summary').html('<i class="fa fa-spinner fa-spin" style="font-size:15px;"></i> Loading...');
        $('.returned-items,.render-oitems,.render-soitems').html("<tr><td colspan='3' align='center'>Loading...</td></tr>");
        var d = new Date();
        var date = d.getDate();
        var month = d.getMonth()+1; 
        var year = d.getFullYear();
        var year22 = year;
        $('.this-d-2 option[value="'+date+'"]').prop('selected', true);
        $('.this-m-2 option[value="'+month+'"]').prop('selected', true);
        $('.this-y-2 option[value="'+year+'"]').prop('selected', true);
        getDatesRange(date,month,year);

        // $('.sold-products').append('<tr class="asloader"><td><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i> Adding...</td></tr>');
        // $.get('/pending-sale/shop/'+shop_id, function(data){  
        //     $('.asloader').hide();        
        //     if (data.item) {
        //         $('.customer').val(data.item.customer_id).change();
        //     }
            
        //     $('.sold-products').append(data.items);
        //     $('.totalQ').html(data.totalQ);
        //     $('.totalP').html(data.totalP);
        // });

        salesSummary(shop_id);
    });

    function salesSummary(shop_id) {
        $.get('/sales-summary/all/'+shop_id, function(data){ 
            $('.today-summary').html('<div class="col-5 col-sm-12 col-lg-5"><strong>Sales</strong><h5>'+data.data.today_price+'</h5></div><div class="col-3 col-sm-6 col-lg-3"><strong>Quant.</strong><h5>'+parseFloat(data.data.today_quantity)+'</h5></div><div class="col-4 col-sm-6 col-lg-4"><strong>Expenses</strong><h5 class="todayE">0</h5></div>');
            $('.week-summary').html('<div class="col-5 col-sm-12 col-lg-5"><strong>Sales</strong><h5>'+data.data.week_price+'</h5></div><div class="col-3 col-sm-6 col-lg-3"><strong>Quant.</strong><h5>'+parseFloat(data.data.week_quantity)+'</h5></div><div class="col-4 col-sm-6 col-lg-4"><strong>Expenses</strong><h5 class="weekE">0</h5></div>');
            $('.month-summary').html('<div class="col-5 col-sm-12 col-lg-5"><strong>Sales</strong><h5>'+data.data.month_price+'</h5></div><div class="col-3 col-sm-6 col-lg-3"><strong>Quant.</strong><h5>'+parseFloat(data.data.month_quantity)+'</h5></div><div class="col-4 col-sm-6 col-lg-4"><strong>Expenses</strong><h5 class="monthE">0</h5></div>');
            expensesSummary(shop_id);
        });
    }

    function expensesSummary(shop_id) {
        $.get('/expenses-summary/shop/'+shop_id, function(data){ 
            $('.todayE').html(data.data.today_expenses);
            $('.weekE').html(data.data.week_expenses);
            $('.monthE').html(data.data.month_expenses);
        });
    }

    function getDatesRange(thisdate,month,year) {
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), month, 1);
        var lastDay = new Date(date.getFullYear(), month, 0);
        var firstDate = firstDay.getDate();
        var lastDate = lastDay.getDate();
        
        $('.this-d-2').html('');
        for (var i = 1; i <= lastDate; i++) {
            $('.this-d-2').append($('<option>', {value:i, text:i}));
            $('.this-d-2 option[value="'+thisdate+'"]').prop('selected', true);
        }
        salesByDate(thisdate,month,year,shop_id);
    }

    $(document).on('change','.this-m-2',function(e){
        e.preventDefault();
        var month = $(this).val();
        var year = $(".this-y-2 option:selected").val();
        var date = $(".this-d-2 option:selected").val();
        getDatesRange(date,month,year);
    });
    $(document).on('change','.this-y-2',function(e){
        e.preventDefault();
        var year = $(this).val();
        var month = $(".this-m-2 option:selected").val();
        var date = $(".this-d-2 option:selected").val();
        getDatesRange(date,month,year);
    });
    $(document).on('change','.this-d-2',function(e){
        e.preventDefault();
        var date = $(this).val();
        var year = $(".this-y-2 option:selected").val();
        var month = $(".this-m-2 option:selected").val();
        getDatesRange(date,month,year);
    });

    function salesByDate(date,month,year,shop_id){
        $('.sales-report').html("<tr><td colspan='6' align='center'>Loading...</td></tr>");
        $('.returned-block,.returned-block2,.expenses,.deni,.ameweka,.tumelipa').css('display','none');
          $.get('/sales-by-date/cashier/'+date+'/'+month+'/'+year+'/'+shop_id, function(data) {
            $('.sales-report').html(data.items);
            $('.totalSQ').html(data.totalSQ);
            $('.totalSP').html(Number(data.totalSP).toLocaleString("en"));
            if (data.expenses != 0) {
                $('.expenses').css('display','');
                $('.totalE').html(data.expenses);
            }
            if (data.deni != 0) {
                $('.deni').css('display','');
                $('.totalD').html(data.deni);
            }
            if (data.ameweka != 0) {
                $('.ameweka').css('display','');
                $('.totalA').html(data.ameweka);
            }
            if (data.tumelipa != 0) {
                $('.tumelipa').css('display','');
                $('.totalT').html(data.tumelipa);
            }
            // returned items
            if (!$.isEmptyObject(data.items2)) {
                $('.returned-block').css('display','');
                $('.render-returned-items').html(data.items2);
            }
            if (!$.isEmptyObject(data.items3)) {
                $('.returned-block2').css('display','');
                $('.render-returned-items2').html(data.items3);
            }
          });
          pendingReturnedItems(shop_id);
          var fromdate = date+"-"+month+"-"+year;
          var todate = fromdate;
          closureNote(fromdate+"~"+todate);
          $('.view-deni,.view-ameweka,.view-tumelipa,.view-expenses').attr('date',todate);
    }

    $(document).on('click', '.view-deni', function(e){
        e.preventDefault();
        $('#madeniModal').modal('toggle');
        $('.madeni-list').html("<tr><td colspan='4'>Loading...</td></tr>");
        var date = $(this).attr('date');
        $.get('/report-by-date-range/debts/'+date+'/'+date+'/'+shop_id, function(data){ 
            if (data.error) {
                popNotification('warning',data.error);
                return;
            }          
            $('.madeni-list').html(data.items).promise().done(function() {
                $('.madeni-list').append("<tr><td></td><td></td><th>Total</th><th class='totaldd'>"+data.totald+"</th></tr>");
                if (date != today) {
                    $('.madeni-list tr td input').attr('disabled',true);
                    $('.madeni-list tr td button').css('display','none');
                }
            });       
        });
        $.get('/report-by-date-range/kopesha/'+date+'/'+date+'/'+shop_id, function(data){ 
            if (data.error) {
                popNotification('warning',data.error);
                return;
            }          
            $('.kopesha-cash-list').html(data.items).promise().done(function() {
                $('.kopesha-cash-list').append("<tr><th>Total</th><th class='totaldd'>"+data.totald+"</th></tr>");
                if (date != today) {
                    $('.kopesha-cash-list tr td input').attr('disabled',true);
                    $('.kopesha-cash-list tr td button').css('display','none');
                }
            });       
        });
    });

    $(document).on('click', '.view-expenses', function(e){
        e.preventDefault();
        $('#expensesModal').modal('toggle');
        $('.expenses-report').html("<tr><td colspan='5'>Loading...</td></tr>");
        var date = $(this).attr('date');
        $.get('/report-by-date-range/expenses/'+date+'/'+date+'/'+shop_id, function(data){ 
            if (data.error) {
                popNotification('warning',data.error);
                return;
            }          
            $('.expenses-report').html(data.view);
            $('.totalEX').html(data.data.sum);
        });
    });

    $(document).on('click', '.view-tumelipa', function(e){
        e.preventDefault();
        $('#tumelipaModal').modal('toggle');
        $('.tumelipa-list').html("<tr><td colspan='3'>Loading...</td></tr>");
        var date = $(this).attr('date');
        $.get('/report-by-date-range/cash-out/'+date+'/'+date+'/'+shop_id, function(data){ 
            if (data.error) {
                popNotification('warning',data.error);
                return;
            }          
            $('.tumelipa-list').html(data.items).promise().done(function() {
                $('.tumelipa-list').append("<tr><th>Total</th><th class='totaldd'>"+data.totald+"</th></tr>");
                if (date != today) {
                    $('.tumelipa-list tr td input').attr('disabled',true);
                    $('.tumelipa-list tr td button').css('display','none');
                }
            });       
        });
    });

    $(document).on('click', '.view-ameweka', function(e){
        e.preventDefault();
        $('#amewekaModal').modal('toggle');
        $('.ameweka-list').html("<tr><td colspan='4'>Loading...</td></tr>");
        $('.ameweka-cash-list').html("<tr><td colspan='2'>Loading...</td></tr>");
        var date = $(this).attr('date');
        $.get('/report-by-date-range/ongezeko/'+date+'/'+date+'/'+shop_id, function(data){ 
            if (data.error) {
                popNotification('warning',data.error);
                return;
            }          
            $('.ameweka-list').html(data.items).promise().done(function() {
                $('.ameweka-list').append("<tr><td></td><td></td><th>Total</th><th class='totaldd'>"+data.totald+"</th></tr>");
                if (date != today) {
                    $('.ameweka-list tr td input').attr('disabled',true);
                    $('.ameweka-list tr td button').css('display','none');
                }
            });       
        });
        $.get('/report-by-date-range/ameweka/'+date+'/'+date+'/'+shop_id, function(data){ 
            if (data.error) {
                popNotification('warning',data.error);
                return;
            }          
            $('.ameweka-cash-list').html(data.items).promise().done(function() {
                $('.ameweka-cash-list').append("<tr><th>Total</th><th class='totaldd'>"+data.totald+"</th></tr>");
                if (date != today) {
                    $('.ameweka-cash-list tr td input').attr('disabled',true);
                    $('.ameweka-cash-list tr td button').css('display','none');
                }
            });       
        });
    });

    $(document).on('click', '.paida-b', function(e){
        e.preventDefault();
        var id = $(this).attr('rid');
        var amount = $('.paida-'+id).attr('amount');
        var new_amount = $(".paida-"+id).val();
        if (amount == new_amount) {
            popNotification('success',"The amount is updated successfully.");
            return;
        }
        $(this).html('Updating..');$('.paida-b').prop('disabled', true);
        $.get('/update-quantity/debt/'+id+'/'+new_amount, function(data){
            $('.paida-b').html('Update').prop('disabled', false);
            if (data.error) {
                popNotification('warning',data.error);
                return;
            }            
            var totald = $('.totaldd').text().split(",").join("");
            var newd = (parseFloat(totald) - parseFloat(data.data.old_debt) ) + parseFloat(data.data.new_debt);
            $('.debta-'+data.data.id).html(Number(data.data.new_debt).toLocaleString("en"));
            $('.totaldd').html(Number(newd).toLocaleString("en"));     
            $('.paida-'+data.data.id).attr("amount",data.data.new_paid);
            popNotification('success',"The amount is updated successfully.");
            $('.this-d-2').change();
        });
    });

    function closureNote(date){ 
        date = shop_id+"~"+date;
        $.get('/report/closure-sale/'+date, function(data){ 
            $('.closure-sale').html(data.items);
        });
    }

    function pendingReturnedItems(shop_id) {
          $.get('/return-sold-items/pending/'+shop_id, function(data) {
            $('.returned-items').html("");
            $('.returned-items').html(data.items);
            $('.totalQr').html(data.totalQr);
          });
    }

    $(document).on('keyup', '.rquantity', function(e){
        e.preventDefault();
        var id = $(this).attr('rid');
        var qty = $(this).val();
        $.get('/update-quantity/returned-item/'+id+'/'+qty, function(data){
            if (data.error) {
                popNotification('warning',data.error);
                return;
            }            
            $('.totalQr').html(parseFloat(data.data.quantity));         
        });
    });

    $(document).on('click', '.remove-ri', function(e){
        e.preventDefault();
        var id = $(this).attr('val');
        $.get('/remove-row/returned-item/'+id, function(data){
            if (data.error) {
                popNotification('warning',data.error);
            }
            if (data.success) {
                $('.ri-'+data.id).closest("tr").remove();
                $('.totalQr').html(parseFloat(data.data.quantity));
            }            
        });
    });

    $(document).on('submit', '.returned-items-form', function(e){
        e.preventDefault();
        var date_sold = $('.date-sold').val();
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
                        location.reload(true);
                    }
                }
        });
    });

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

            $('.edit-sale').html('<tr><td><div class="row">'
                        +'<div class="col-12 r-name">'+data.pname+'</div>'
                        +'<div class="col-12" align="right"> <span><input type="number" class="form-control quantity2" name="quantity2" value="'+parseFloat(data.data.qty)+'"><input type="hidden" class="quantity3" value="'+parseFloat(data.data.qty)+'"><input type="hidden" class="quantity4" value="'+parseFloat(data.data.totalqty)+'"></span> <span><i class="fa fa-times"></i></span> <span><input type="number" class="form-control sprice2" name="sprice2" value="'+Number(data.data.selling_price)+'" style="display:inline-block"><input type="hidden" class="sprice3" value="'+Number(data.data.subtotal_b)+'"><input type="hidden" class="sprice4" value="'+Number(data.data.totalamount_b)+'"></span> <span> = </span><span><b class="esrp">'+data.data.subtotal+'</b></span></div>'
                        +'<div class="col-12 pr-0 pt-2" style="text-align:right;"><i class="fa fa-spinner fa-spin spiner2" style="font-size:20px;display: none;"></i><button class="btn btn-danger btn-sm delete-submitted-sale mr-1" val="'+data.data.id+'" pname="'+data.pname+'"><i class="fa fa-trash"></i> </button><span> </span><button class="btn btn-success btn-sm submit-edited-sale" val="'+data.data.id+'" style="margin-left:5px">Update</button></div>'
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

    $(document).on('click', '.delete-submitted-sale-delete', function(e){
        e.preventDefault();
        var pname = $(this).attr('pname');
        // $.get('/delete-submitted-sale/'+shop_id+'/'+id, function(data){
        //     if (data.error) {
        //         popNotification('warning',data.error);
        //     }
        //     if (data.success) {
        //         location.reload();
        //     }            
        // });        
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
                        $(document).ajaxSuccess(function(){
                            window.location.reload();
                        });
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
            location.reload();
        });  
    });

</script>

@endsection