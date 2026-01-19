@extends('layouts.app')
@section('css')
<style type="text/css">
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
    .check-g-sales, .check-t-sales, .check-o-sales, .check-i-sales {
        margin-bottom:auto;margin-top: 33px;
    }
    
    .modal-xl {
        width: 90%;
        max-width:1200px;
    }
    
  .view-sales {cursor: pointer;color: #007bff;}
  .vs_summary {padding-top: 10px;padding-bottom: 10px;}
  .vs_summary .vs_out div {display: inline-block;font-weight: bold; padding: 3px 10px 0px;margin-bottom: 5px;}
  .vs_summary .vs_out {display: inline-block;}

  @media screen and (max-width: 900px) {
        .vs_summary .vs_out div {padding: 3px 10px 3px;}
    }
  @media screen and (max-width: 575px) {
        .sales-sm .bg-color2 {
            margin-top: 30px;
        }
        .sales-sm .bg-color3 {
            margin-top: 30px;
        }
        .modal-xl {
            width: 97%;
        }
        .vs_summary .vs_out div {padding-top: 1px;padding-bottom: 1px;}
    }
  @media screen and (max-width: 553px) {
        .top-tabs .nav-tabs-new li a {padding: 5px 10px;}
    }
  @media screen and (max-width: 480px) {
        .check-g-sales, .check-t-sales, .check-o-sales, .check-i-sales {
            margin-bottom:auto;margin-top: 23px;
        }
        .vs_summary {padding-left: 3px;padding-right: 3px;}
    }
  @media screen and (max-width: 448px) {
        .top-tabs .nav-tabs-new li a {padding: 5px 8px;font-size: 12px;}
    }
  @media screen and (max-width: 422px) {
        .top-tabs {padding-left: 5px;padding-right: 5px;}
    }
    #cont.nav {display: block;}
    #cont {
      min-width: 202px;
      /*border: 1px solid #0f0;*/
      overflow: hidden;
      overflow-x: auto;
      overflow-y: hidden;
      white-space: nowrap;
    }
    #cont .nav-item{
      display: inline-block;
      /*margin:20px;*/  
      min-width: 50px;
    }
  @media screen and (max-width: 402px) {
    .top-tabs .card .body {padding-bottom: 10px;}
    #cont {
      width: 402px;
      height: 40px;
      /*border: 1px solid #0f0;*/
      overflow: hidden;
      overflow-x: auto;
      overflow-y: hidden;
      white-space: nowrap;
    }
    .top-tabs .nav-tabs-new li a {padding: 4px 6px;}

    /*.top-tabs .row {max-width: 400px;}
        .top-tabs .nav-tabs-new {display: flex;width: 100%; overflow-x: scroll;-webkit-overflow-scrolling: touch}
        .top-tabs .nav-tabs-new li a {display: block;}*/
    }
  @media screen and (max-width: 386px) {
        .top-tabs .nav-tabs-new li a {padding: 4px 6px;font-size: 12px;}
    }
  @media screen and (max-width: 370px) {
        .top-tabs .nav-tabs-new li a {padding: 4px 6px;font-size: 11.5px;}
    }
  .date-range {
    margin-left: 0px;text-align: center;
  }
  .date-range .b {
    padding: 0px;
  }
  .date-range .b label {
    padding-top: 5px;
  }
  .date-range .form-group {
    padding: 0px;
  }
  .card.top_counter {
    box-shadow: 0 3px 2px 0 rgb(0 0 0 / 30%);background: #f4f7f6;
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
                    <div class="col-lg-12 col-md-12 top-tabs">
                        <div class="card">
                            <div class="body">
                                <div class="row">
                                    <ul class="nav nav-tabs-new" id="cont">
                                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Basic"><?php echo $_GET['general-sales']; ?></a></li>
                                        <li class="nav-item top-sale"><a class="nav-link" data-toggle="tab" href="#Top"><?php echo $_GET['top-sales']; ?></a></li>
                                        <li class="nav-item sale-item"><a class="nav-link" data-toggle="tab" href="#General"><?php echo $_GET['sales-by-item']; ?></a></li>
                                        <li class="nav-item sale-order"><a class="nav-link" data-toggle="tab" href="#Account"><?php echo $_GET['sales-by-order']; ?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12">
                        <div class="tab-content padding-0">
                            <div class="tab-pane active" id="Basic">
                                
                                @include('partials.general-sales-report') 

                            </div>
                            <div class="tab-pane" id="Account">
                                
                                @include('partials.sales-by-order-report')

                            </div>
                            <div class="tab-pane" id="Top">

                                @include('partials.top-sales-report')

                            </div>
                            <div class="tab-pane" id="General">

                                @include('partials.sales-by-item-report')

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- modal -->
    <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="col-12 mt-3">
                    <h5>Order #: <span class="orderno"></span></h5>
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px;">
                        <span aria-hidden="true">×</span>
                    </span>                    
                    <div>Ordered by: <b class="ordered_by"></b></div>
                </div>
                <div class="modal-body">
                    <div class="col-sm-12 col-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Sub-total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th class="totaloQ">0</th>
                                        <td></td>
                                        <th class="totaloP">0</th>
                                        <td></td>
                                    </tr>
                                </tfoot>
                                <tbody class="order-list">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div> 

    <!-- expenses modal -->
    <div class="modal fade" id="expensesModal" tabindex="-1" role="dialog" aria-labelledby="expensesModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5><?php echo $_GET['expenses-menu']; ?></h5>
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: red;">
                        <span aria-hidden="true">×</span>
                    </span>  
                </div>
                <div class="modal-body pt-0">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo $_GET['item']; ?></th>
                                        <th><?php echo $_GET['amount']; ?></th>
                                        <th><?php echo $_GET['description']; ?></th>
                                        <th><?php echo $_GET['shop']; ?></th>
                                        <th><?php echo $_GET['date']; ?></th>
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

    <!-- sales modal -->
    <div class="modal fade" id="salesModal" tabindex="-1" role="dialog" aria-labelledby="salesModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5><?php echo $_GET['sales-menu']; ?></h5>
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: red;">
                        <span aria-hidden="true">×</span>
                    </span>  
                </div>
                <div class="modal-body pt-0">
                    <div class="row">
                        <div class="col-12 vs_summary">
                            <span><?php echo $_GET['date']; ?>: </span><b class="vs_date"></b><br>
                            <div class="vs_out"><span><?php echo $_GET['total-sales']; ?>: </span><div class="vs_totalSP" style="background:#7CB9E8"></div></div>
                            <div class="vs_out"><span><?php echo $_GET['quantity-sold']; ?>: </span><div class="vs_totalSQ" style="background:#89CFF0"></div></div>
                            @if(Auth::user()->isBusinessOwner())
                                <div class="vs_out"><span><?php echo $_GET['gross-profit']; ?>: </span><div class="vs_profit" style="background:#bdf3f5"></div></div>
                            @endif                            
                            <div class="vs_out"><span><?php echo $_GET['expenses-menu']; ?>: </span><div class="vs_totalEX" style="background:#e0eff5"></div></div>
                            @if(Auth::user()->isBusinessOwner())
                                <div class="vs_out"><span><?php echo $_GET['net-profit']; ?>: </span><div class="vs_netProfit" style="background:#7FFFD4"></div></div>
                            @endif
                            
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo $_GET['item']; ?></th>
                                        <th><?php echo $_GET['quantity-full']; ?></th>
                                        <th><?php echo $_GET['price']; ?></th>
                                        <th><?php echo $_GET['sub-total']; ?></th>
                                        @if(Auth::user()->isBusinessOwner())
                                        <th><?php echo $_GET['profit']; ?></th>
                                        @endif
                                        <th><?php echo $_GET['time']; ?></th>
                                        <th><?php echo $_GET['shop']; ?></th>
                                    </tr>
                                </thead>
                                <tbody class="render-view-sales">
                                    
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive mt-4">
                            <h6><b><?php echo $_GET['closed-sales']; ?></b></h6>
                            <table class="table mt-1">
                                <thead class="thead-light">
                                    <tr>
                                        <th><?php echo $_GET['expected-amount']; ?></th>
                                        <th><?php echo $_GET['submitted-amount']; ?></th>
                                        <th>Status</th>
                                        <th><?php echo $_GET['closed-by']; ?></th>
                                        <th><?php echo $_GET['time']; ?></th>
                                        <th><?php echo $_GET['shop']; ?></th>
                                    </tr>
                                    <!-- <tr>
                                        <th colspan="6" class="pb-0">
                                            <h4>Closure Note</h4>
                                        </th>
                                    </tr> -->
                                </thead>
                                <!-- <tfoot>
                                    <tr>
                                        <th>Expected Amount</th>
                                        <th>Submitted Amount</th>
                                        <th>Status</th>
                                        <th>Shop</th>
                                        <th>Closed by</th>
                                        <th>Time</th>
                                    </tr>
                                </tfoot> -->
                                <tbody class="closure-sale">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div> 
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
<script type="text/javascript">
    $('.select2').select2();

$('#scroller').on('wheel',function(ev){
  let y = parseInt(ev.originalEvent.deltaY);
  if (y)
    this.scrollLeft += y;
  // console.log(y,this.scrollLeft);
});


$('#scroller .nav-item').each((i,x)=>{
  let c=i.toString(16);
  x.style.background='#'+c+c+c;
});

    var shop_id = $('[name="shopid"]').val();

    $(function () {
        $('.today-summary, .week-summary, .month-summary').html('<i class="fa fa-spinner fa-spin" style="font-size:15px;"></i> Loading...');

        var fromdate = $('.from-date').val();
        fromdate = fromdate.split('/').join('-');
        var todate = $('.to-date').val();
        todate = todate.split('/').join('-');
        
        salesByDateRange(fromdate,todate,shop_id);
        // $.get('/report/sales/all', function(data){ 
        //     $('.today-summary').html('<div class="col-5"><strong>Sales</strong><h5>'+data.data.today_price+'</h5></div><div class="col-3"><strong>Quant.</strong><h5>'+data.data.today_quantity+'</h5></div><div class="col-4"><strong>Expenses</strong><h5 class="todayE">0</h5></div>');
        //     $('.week-summary').html('<div class="col-5"><strong>Sales</strong><h5>'+data.data.week_price+'</h5></div><div class="col-3"><strong>Quant.</strong><h5>'+data.data.week_quantity+'</h5></div><div class="col-4"><strong>Expenses</strong><h5 class="weekE">0</h5></div>');
        //     $('.month-summary').html('<div class="col-5"><strong>Sales</strong><h5>'+data.data.month_price+'</h5></div><div class="col-3"><strong>Quant.</strong><h5>'+data.data.month_quantity+'</h5></div><div class="col-4"><strong>Expenses</strong><h5 class="monthE">0</h5></div>');
        // });
        // $.get('/report/expenses/all', function(data){ 
        //     $('.todayE').html(data.data.today_expenses);
        //     $('.weekE').html(data.data.week_expenses);
        //     $('.monthE').html(data.data.month_expenses);
        // });
    });

    $(".change-shop").on('change', function(e) {
        e.preventDefault();
        var shop_id = $(this).val();
        var fromdate = $('.from-date').val();
        fromdate = fromdate.split('/').join('-');
        var todate = $('.to-date').val();
        todate = todate.split('/').join('-');
        salesByDateRange(fromdate,todate,shop_id);
    });

    $(".from-date-deleted").on('change', function(e) { // this is not used anymore
        e.preventDefault();
        var fromdate = $(this).val();
        var shop_id = $('.change-shop').val();
        fromdate = fromdate.split('/').join('-');
        var todate = $('.to-date').val();
        todate = todate.split('/').join('-');
        salesByDateRange(fromdate,todate,shop_id);
    });
    $(".to-date-deleted").on('change', function(e) { // this is not used anymore
        e.preventDefault();
        var fromdate = $('.from-date').val();
        var shop_id = $('.change-shop').val();
        fromdate = fromdate.split('/').join('-');
        var todate = $(this).val();
        todate = todate.split('/').join('-');
        salesByDateRange(fromdate,todate,shop_id);
    });
    $(".check-g-sales").on('click', function(e) {
        e.preventDefault();
        $(this).prop('disabled', true).html('Checking..');
        var fromdate = $('.from-date').val();
        var todate = $('.to-date').val();
        var shop_id = $('.change-shop').val();
        fromdate = fromdate.split('/').join('-');
        todate = todate.split('/').join('-');
        $.when( salesByDateRange(fromdate,todate,shop_id) ).done(function() {
            $(".check-g-sales").prop('disabled', false).html('Check');
        });        
    });

    function dailySales(fromdate,todate,shop_id) {
    }

    function salesByDateRange(fromdate,todate,shop_id){
        $('.render-daily-sales').html("<tr><td colspan='6' align='center'>Loading...</td></tr>");
        // $('.sales-report').html("<tr><td colspan='8' align='center'>Loading...</td></tr>");
        $('.totalSP').html('--');
        $('.totalSQ').html('--');
        $('.profit').html('--');
        $('.totalEX, .netProfit').html('--');
        $('.canvas-blk').html('<canvas id="canvas"></canvas>');
        $.get('/report-by-date-range/daily-sales/'+fromdate+'/'+todate+'/'+shop_id, function(data) {
            var net_pro = Math.floor(data.profit) - Math.floor(data.totalEX);
            $('.render-daily-sales').html(data.dates);
            $('.totalSQ').html(data.totalSQ);
            $('.totalSP').html(Number(data.totalSP).toLocaleString("en"));
            $('.profit').html(Number(data.profit).toLocaleString("en"));
            $('.totalEX').html(data.totalEX);
            $('.netProfit').html(Number(net_pro).toLocaleString("en"));

            // update product id to sales by item section
            if (data.data.sale) {
                $('.change-item').val(data.data.sale.product_id).change();
            }
            data.d_dates.reverse();
            data.d_sales.reverse();
            var bdates = [];
            var adates = [];
            var bsales = [];
            var asales = [];
            for (var j = 9; j >= 0; j--) {
                bdates[j] = data.d_dates[j];
                bsales[j] = parseFloat(data.d_sales[j]);
            }
            for (var i = data.d_dates.length - 1; i > 9; i--) {
                adates[i] = data.d_dates[i];
                asales[i] = parseFloat(data.d_sales[i]);
            }

            var dData = function() {
              return Math.round(Math.random() * 90) + 10
            };

            var barChartData = {
              labels: bdates,
              datasets: [{
                fillColor: "#01b2c6",
                strokeColor: "#0066b2",
                data: bsales
              }]
            }

            var index = 10;
            var ctx = document.getElementById("canvas").getContext("2d");
            var barChartDemo = new Chart(ctx).Bar(barChartData, {
              responsive: true,
              barValueSpacing: 2
            });
            setInterval(function() {
              if (index < data.d_dates.length) {
                  barChartDemo.removeData();
                  barChartDemo.addData([asales[index]], adates[index]);
              }
              index++;
            }, 3000);
        });         
    }

    function closureNote(date){
        $('.closure-sale').html("<tr><td colspan='6'>Loading...</td></tr>");
        $.get('/report/closure-sale/'+date, function(data){ 
            $('.closure-sale').html(data.items);
        });
    }

    $(".view-expenses").on('click', function(e) {
        e.preventDefault();
        $('#expensesModal').modal('toggle');
        $('.expenses-report').html("<tr><td colspan='5'>Loading...</td></tr>");
        var fromdate = $('.from-date').val();
        var todate = $('.to-date').val();
        var shop_id = $('.change-shop').val();
        fromdate = fromdate.split('/').join('-');
        todate = todate.split('/').join('-');        
          $.get('/report-by-date-range/expenses/'+fromdate+'/'+todate+'/'+shop_id, function(data) {
            $('.expenses-report').html(data.view);            
          });
    });

    $(document).on('click', '.view-sales', function(e) {
        e.preventDefault();
        var date = $(this).attr('date');
        var fromdate = date;
        var todate = date;
        var shop_id = $('.change-shop').val();    
        $('.vs_totalSQ,.vs_totalSP,.vs_totalEX,.vs_profit,.vs_netProfit').html('--');
        // format date and time
        var formattedDate = new Date(date);
        var d = formattedDate.getDate();
        var m =  formattedDate.getMonth();
        m += 1;  // JavaScript months are 0-11
        var y = formattedDate.getFullYear();
        $(".vs_date").html(d + "/" + m + "/" + y);

        $('#salesModal').modal('toggle');
        $('.render-view-sales, .closure-sale').html("<tr><td colspan='5'>Loading...</td></tr>");
        $.get('/report-by-date-range/sales/'+fromdate+'/'+todate+'/'+shop_id, function(data) {
            var net_pro = Math.floor(data.profit) - Math.floor(data.data.sum.replace(/,/g, ''));
            $('.render-view-sales').html(data.items);
            $('.vs_totalSQ').html(data.totalSQ);
            $('.vs_totalSP').html(Number(data.totalSP).toLocaleString("en"));
            $('.vs_profit').html(Number(data.profit).toLocaleString("en"));
            $('.vs_totalEX').html(data.data.sum);
            $('.vs_netProfit').html(Number(net_pro).toLocaleString("en"));

            closureNote(shop_id+"~"+fromdate+"~"+todate);
        });
    });

    $(".sale-order").on('click', function(e) {
        e.preventDefault();
        var fromdate = $('.from-date2').val();
        var todate = $('.to-date2').val();
        var shop_id = $('.change-shop2').val();
        fromdate = fromdate.split('/').join('-');
        todate = todate.split('/').join('-');
        salesByOrder(fromdate,todate,shop_id);
    });
    $(".change-shop2").on('change', function(e) {
        e.preventDefault();
        var shop_id = $(this).val();
        var fromdate = $('.from-date2').val();
        var todate = $('.to-date2').val();
        fromdate = fromdate.split('/').join('-');
        todate = todate.split('/').join('-');
        salesByOrder(fromdate,todate,shop_id);
    });
    $(".from-date2-deleted").on('change', function(e) { //this is not used anymore
        e.preventDefault();
        var fromdate = $(this).val();
        var shop_id = $('.change-shop2').val();
        fromdate = fromdate.split('/').join('-');
        var todate = $('.to-date2').val();
        todate = todate.split('/').join('-');
        salesByOrder(fromdate,todate,shop_id);
    });
    $(".to-date2-deleted").on('change', function(e) { //this is not used anymore
        e.preventDefault();
        var fromdate = $('.from-date2').val();
        var shop_id = $('.change-shop2').val();
        fromdate = fromdate.split('/').join('-');
        var todate = $(this).val();
        todate = todate.split('/').join('-');
        salesByOrder(fromdate,todate,shop_id);
    });
    $(".check-o-sales").on('click', function(e) {
        e.preventDefault();
        $(this).prop('disabled', true).html('Checking..');
        var fromdate = $('.from-date2').val();
        var todate = $('.to-date2').val();
        var shop_id = $('.change-shop2').val();
        fromdate = fromdate.split('/').join('-');
        todate = todate.split('/').join('-');        
        $.when( salesByOrder(fromdate,todate,shop_id) ).done(function() {
            $(".check-o-sales").prop('disabled', false).html('Check');
        });
    });

    function salesByOrder(fromdate,todate,shop_id){
        $('.totalOr,.orderers').html("-");
        $('.orders-report').html("<tr><td colspan='6'>Loading...</td></tr>");
          $.get('/report-by-date-range/orders/'+fromdate+'/'+todate+'/'+shop_id, function(data) {
            $('.totalOr').html(data.data.totalorders);
            $('.orders-report').html(data.items);
            $('.orderers').html(data.list);
        });
    }

    $(".sale-item").on('click', function(e) {
        e.preventDefault();
        var fromdate = $('.from-date3').val();
        var todate = $('.to-date3').val();
        var shop_id = $('.change-shop3').val();
        var item_id = $('.change-item').val();
        fromdate = fromdate.split('/').join('-');
        todate = todate.split('/').join('-');
        salesByItem(fromdate,todate,shop_id,item_id);
    });
    $(".change-shop3").on('change', function(e) {
        e.preventDefault();
        var fromdate = $('.from-date3').val();
        var todate = $('.to-date3').val();
        var shop_id = $(this).val();
        var item_id = $('.change-item').val();
        fromdate = fromdate.split('/').join('-');
        todate = todate.split('/').join('-');
        salesByItem(fromdate,todate,shop_id,item_id);
    });
    $(".change-item-deleted").on('change', function(e) { //this is not used anymore
        e.preventDefault();
        var fromdate = $('.from-date3').val();
        var todate = $('.to-date3').val();
        var shop_id = $('.change-shop3').val();
        var item_id = $(this).val();
        fromdate = fromdate.split('/').join('-');
        todate = todate.split('/').join('-');
        salesByItem(fromdate,todate,shop_id,item_id);
    });
    $(".from-date3-deleted").on('change', function(e) { //this is not used anymore
        e.preventDefault();
        var fromdate = $(this).val();
        var todate = $('.to-date3').val();
        var shop_id = $('.change-shop3').val();
        var item_id = $('.change-item').val();
        fromdate = fromdate.split('/').join('-');
        todate = todate.split('/').join('-');
        salesByItem(fromdate,todate,shop_id,item_id);
    });
    $(".to-date3-deleted").on('change', function(e) { //this is not used anymore
        e.preventDefault();
        var fromdate = $('.from-date3').val();
        var todate = $(this).val();
        var shop_id = $('.change-shop3').val();
        var item_id = $('.change-item').val();
        fromdate = fromdate.split('/').join('-');
        todate = todate.split('/').join('-');
        salesByItem(fromdate,todate,shop_id,item_id);
    });
    $(".check-i-sales").on('click', function(e) {
        e.preventDefault();
        $(this).prop('disabled', true).html('Checking..');
        var fromdate = $('.from-date3').val();
        var todate = $('.to-date3').val();
        var shop_id = $('.change-shop3').val();
        var item_id = $('.change-item').val(); 
        fromdate = fromdate.split('/').join('-');
        todate = todate.split('/').join('-');
        $.when( salesByItem(fromdate,todate,shop_id,item_id) ).done(function() {
            $(".check-i-sales").prop('disabled', false).html('Check');
        });
    });

    function salesByItem(fromdate,todate,shop_id,item_id){
        var shop_item = shop_id+"-"+item_id;
        $('.totalIQ,.totalIA,.totalIP').html("-");
        $('.sitems-report').html("<tr><td colspan='5'>Loading...</td></tr>");
          $.get('/report-by-date-range/by-item/'+fromdate+'/'+todate+'/'+shop_item, function(data) {
            $('.sitems-report').html(data.items);
            $('.totalIQ').html(data.data.totalIQ);
            $('.totalIA').html(data.data.totalIA);
            $('.totalIP').html(data.data.totalIP);
        });
    }

    $(document).on('click', '.order-items', function(e) {
        e.preventDefault();
        $('.order-list').html("<tr><td colspan='5' align='center'>Loading...</td></tr>");
        $('.totaloQ').html("-");$('.totaloP').html("-");$('.ordered_by').html("-");
        $('.hidden-btn,.order-footer').css("display","none");
        $('#orderModal').modal('toggle');
        var ono = $(this).attr('order');
        $('.orderno').html(ono);
        $('.delete-sorder, .submit-saleo').attr("order",ono);
        $.get('/order-items/list/'+ono, function(data){
            if (data.error) {
                popNotification('warning',data.error);
                return;
            }
            if (data.data.status != "sold") {
                $('.order-footer').css("display","");
            }
            if (data.data.canchange == "yes") {
                $('.hidden-btn').css("display","");
            }
            $('.order-list').html(data.items);
            $('.totaloQ').html(data.data.totaloQ);
            $('.totaloP').html(data.subtotal);
            $('.ordered_by').html(data.data.creator);
        });
    });

    $(".top-sale").on('click', function(e) {
        e.preventDefault();
        var fromdate = $('.from-date4').val();
        var todate = $('.to-date4').val();
        var shop_id = $('.change-shop4').val();
        fromdate = fromdate.split('/').join('-');
        todate = todate.split('/').join('-');
        salesByTopSale(fromdate,todate,shop_id);
    });
    $(".from-date4-deleted").on('change', function(e) { //this is not used anymore
        e.preventDefault();
        var fromdate = $(this).val();
        var todate = $('.to-date4').val();
        var shop_id = $('.change-shop4').val();
        fromdate = fromdate.split('/').join('-');
        todate = todate.split('/').join('-');
        salesByTopSale(fromdate,todate,shop_id);
    });
    $(".to-date4-deleted").on('change', function(e) { //this is not used anymore
        e.preventDefault();
        var fromdate = $('.from-date4').val();
        var todate = $(this).val();
        var shop_id = $('.change-shop4').val();
        fromdate = fromdate.split('/').join('-');
        todate = todate.split('/').join('-');
        salesByTopSale(fromdate,todate,shop_id);
    });
    $(".change-shop4").on('change', function(e) {
        e.preventDefault();
        var fromdate = $('.from-date4').val();
        var todate = $('.to-date4').val();
        var shop_id = $(this).val();
        fromdate = fromdate.split('/').join('-');
        todate = todate.split('/').join('-');
        salesByTopSale(fromdate,todate,shop_id);
    });
    $(".check-t-sales").on('click', function(e) {
        e.preventDefault();
        $(this).prop('disabled', true).html('Checking..');
        var fromdate = $('.from-date4').val();
        var todate = $('.to-date4').val();
        var shop_id = $('.change-shop4').val();
        fromdate = fromdate.split('/').join('-');
        todate = todate.split('/').join('-');     
        $.when( salesByTopSale(fromdate,todate,shop_id) ).done(function() {
            $(".check-t-sales").prop('disabled', false).html('Check');
        });        
    });

    function salesByTopSale(fromdate,todate,shop_id){
        $('.tsales-report').html("<tr><td colspan='4'>Loading...</td></tr>");
          $.get('/report-by-date-range/top-sale/'+fromdate+'/'+todate+'/'+shop_id, function(data) {  
            $('.tsales-report').html("");
            var num = 0;
            var temp = []; 
            var temp2 = []; 
                
            $.each(data.list, function(key, value) {
                temp.push({v:value, k: key});
            });
                
            temp.sort(function(a,b){
               if(Math.floor(a.k) < Math.floor(b.k)){ return 1}
                if(Math.floor(a.k) > Math.floor(b.k)){ return -1}
                  return 0;
            });
            
            $.each(temp, function(key, obj) {
                num = key+1;    
                
                $.each(obj.v, function(key2, obj2) {
                    temp2.push({v2:obj2, k2:key2});                    
                });         

                temp2.sort(function(c,d){
                   if(Math.floor(c.k2) < Math.floor(d.k2)){ return 1}
                    if(Math.floor(c.k2) > Math.floor(d.k2)){ return -1}
                      return 0;
                });
            });
            $.each(temp2, function(key2, obj2) {
                $('.tsales-report').append(obj2.v2);  
            });
        });
    }
</script>
@endsection
