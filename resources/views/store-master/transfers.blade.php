@extends('layouts.app')
@section('css')
<style type="text/css">
    .large-summary {display: block;}
    .small-summary {display: none;}

    @media screen and (max-width: 767px) {
        .large-summary {display: none;}
        .small-summary {display: block;}
        .card .body .top_counter {
            padding-left: 10px;
        }
    }
    .top_counter {box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;padding-top: 8px;}
    .filter-date input {width: 90px;display: inline-block;font-size: 12px;padding-top: 2px;padding-bottom: 2px;}
</style>
@endsection
<?php  

    $sid = $data["store"]->id;

    $today = date('d/m/Y');
    $yesterday = date('d/m/Y',strtotime("-1 days"));
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
                    </div>
                </div>

                <div class="row clearfix">
                    <input type="hidden" name="fromid" value="{{$data['store']->id}}">

                    <div class="col-12 small-summary">
                        <div class="row clearfix">
                            <div class="col-12">     
                                <div class="card"> 
                                    <div class="header">
                                        <h2>Transfer summary:</h2>
                                    </div>     
                                    <div class="body pb-0 pt-0" style="">
                                        <div class="card top_counter">
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="content">
                                                        <div class="text">Today</div>
                                                        <h5 class="number total-today-transfer">0</h5>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="content">
                                                        <div class="text">Tthis week</div>
                                                        <h5 class="number total-week-transfer">0</h5>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="content">
                                                        <div class="text">This month</div>
                                                        <h5 class="number total-month-transfer">0</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 large-summary">
                        <div class="row clearfix">
                            <div class="col-md-4 col-6">     
                                <div class="card"> 
                                    <div class="header">
                                        <h2>Today Transfers:</h2>
                                    </div>     
                                    <div class="body pb-0 pt-0" style="margin-top: 20px;">
                                        <div class="card top_counter">
                                            <div class="icon"><i class="fa fa-long-arrow-down"></i><i class="fa fa-long-arrow-up"></i> </div>
                                            <div class="content">
                                                <div class="text">Total Transfers</div>
                                                <h5 class="number total-today-transfer">0</h5>
                                            </div>
                                        </div>
                                        <div class="daily-transfers">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-6">
                                <div class="card">
                                    <div class="header">
                                        <h2>This Week Transfers:</h2>
                                        <span>(Monday to Sunday)</span>
                                    </div>     
                                    <div class="body pb-0 pt-0">
                                        <div class="card top_counter">
                                            <div class="icon"><i class="fa fa-long-arrow-down"></i><i class="fa fa-long-arrow-up"></i> </div>
                                            <div class="content">
                                                <div class="text">Total Transfers</div>
                                                <h5 class="number total-week-transfer">0</h5>
                                            </div>
                                        </div>
                                        <div class="weekly-transfers">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <div class="header">
                                        <h2>This Month Transfers:</h2>
                                        <span>(<span class="start-month"></span> to <span class="end-month"></span>)</span>
                                    </div>     
                                    <div class="body pb-0 pt-0">
                                        <div class="card top_counter">
                                            <div class="icon"><i class="fa fa-long-arrow-down"></i><i class="fa fa-long-arrow-up"></i> </div>
                                            <div class="content">
                                                <div class="text">Total Transfers</div>
                                                <h5 class="number total-month-transfer">0</h5>
                                            </div>
                                        </div>
                                        <div class="monthly-transfers">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card">      
                            <div class="header">
                                <h2><b>Pending Transfers:</b></h2>
                            </div>     
                            <div class="body pt-0">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table m-b-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Transfer #</th>
                                                    <th>Qty</th>
                                                    <th>From/To</th>
                                                    <th>Shipper</th>
                                                    <th>Status</th>
                                                    <th>Sent at</th>
                                                    <th>Time</th>
                                                </tr>
                                            </thead>
                                            <tbody class="render-pitems">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>                            
                        </div>

                        <div class="card">      
                            <div class="header">
                                <h2>Received Transfers:</h2><hr>
                                <div class="form-group mt-2 mb-0">
                                    <label class="m-b-0">Received date:</label>
                                    <div class="filter-date">
                                        <input type="text" name="date_rf" data-provide="datepicker" data-date-autoclose="true" class="form-control form-control-sm" placeholder="From" value="<?php echo $yesterday; ?>">
                                        <span>to</span>
                                        <input type="text" name="date_rt" data-provide="datepicker" data-date-autoclose="true" class="form-control form-control-sm" placeholder="From" value="<?php echo $today; ?>">
                                        <input type="submit" class="btn btn-primary btn-sm received-filter" value="Filter" style="width:60px">
                                    </div>                                    
                                </div>
                            </div>     
                            <div class="body pt-0">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table m-b-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Transfer #</th>
                                                    <th>Qty</th>
                                                    <th>From</th>
                                                    <th>Shipper</th>
                                                    <th>Status</th>
                                                    <th>Sent at</th>
                                                    <th>Received at</th>
                                                    <th>Time</th>
                                                </tr>
                                            </thead>
                                            <tbody class="render-ritems">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>                            
                        </div>

                        <div class="card">      
                            <div class="header">
                                <h2>Sent Transfers:</h2><hr>
                                <div class="form-group mt-2 mb-0">
                                    <label class="m-b-0">Sent date:</label>
                                    <div class="filter-date">
                                        <input type="text" name="date_f" data-provide="datepicker" data-date-autoclose="true" class="form-control form-control-sm" placeholder="From" value="<?php echo $yesterday; ?>">
                                        <span>to</span>
                                        <input type="text" name="date_t" data-provide="datepicker" data-date-autoclose="true" class="form-control form-control-sm" placeholder="From" value="<?php echo $today; ?>">
                                        <input type="submit" class="btn btn-primary btn-sm sent-filter" value="Filter" style="width:60px">
                                    </div>                                    
                                </div>
                            </div>     
                            <div class="body pt-0">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table m-b-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Transfer #</th>
                                                    <th>Qty</th>
                                                    <th>To</th>
                                                    <th>Shipper</th>
                                                    <th>Status</th>
                                                    <th>Sent at</th>
                                                    <th>Received at</th>
                                                    <th>Time</th>
                                                </tr>
                                            </thead>
                                            <tbody class="render-sitems">

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

    <!-- larg modal -->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom:none;">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Transfer # <span class="transferno"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body render-titems">
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script type="text/javascript">
    var store_id = $('[name="fromid"]').val();

    $(function () {

        var fdate = $('input[name="date_f"]').val();
        var tdate = $('input[name="date_t"]').val();
        fdate = fdate.split('/').join('-');
        tdate = tdate.split('/').join('-');
        var date = fdate+'~'+tdate;

        Transfers('store','pending',date,store_id);
        Transfers('store','received',date,store_id);
        Transfers('store','sent',date,store_id);

        $.get('/transfer-report/today/store/'+store_id, function(data){
            var data2 = data.view;
            var data = data.data;
            if (data.error) { } else {
                $('.total-today-transfer').html(data.totalQty); 
                $('.daily-transfers').html(data2);
                $.get('/transfer-report/week/store/'+store_id, function(data3){
                    var data4 = data3.view;
                    var data3 = data3.data3;
                    if (data3.error) { } else {
                        $('.total-week-transfer').html(data3.totalQty); 
                        $('.weekly-transfers').html(data4);
                        $.get('/transfer-report/month/store/'+store_id, function(data5){
                            var data6 = data5.view;
                            var data5 = data5.data5;
                            if (data5.error) { } else {
                                $('.start-month').html(data5.startMonth);
                                $('.end-month').html(data5.endMonth);
                                $('.total-month-transfer').html(data5.totalQty); 
                                $('.monthly-transfers').html(data6);
                            }
                        });
                    }
                });
            }                 
        });
    });

    function Transfers(location,status,date,store_id) {
        if (status == "sent") { $('.render-sitems').html("<tr><td>Loading..</td></tr>"); }  
        if (status == "received") { $('.render-ritems').html("<tr><td>Loading..</td></tr>"); }  

        $.get('/get-transfers/'+location+'/'+status+'/'+date+'/'+store_id, function(data){              
            if (status == "pending") {
                $('.render-pitems').html(data.view);  
            }   
            if (status == "sent") {
                $('.render-sitems').html(data.view);  
            }                
            if (status == "received") {
                $('.render-ritems').html(data.view);  
            }                
        });
    }

    $(document).on('click', '.received-filter', function(e) {
        e.preventDefault();
        var fdate = $('input[name="date_rf"]').val();
        var tdate = $('input[name="date_rt"]').val();
        fdate = fdate.split('/').join('-');
        tdate = tdate.split('/').join('-');
        var date = fdate+'~'+tdate;

        Transfers('store','received',date,store_id);
    });
    $(document).on('click', '.sent-filter', function(e) {
        e.preventDefault();
        var fdate = $('input[name="date_f"]').val();
        var tdate = $('input[name="date_t"]').val();
        fdate = fdate.split('/').join('-');
        tdate = tdate.split('/').join('-');
        var date = fdate+'~'+tdate;

        Transfers('store','sent',date,store_id);
    });

    $(document).on('click', '.transfer-items', function(e) {
        e.preventDefault();
        var tno = $(this).attr('transfer');
        $('.transferno').html(tno);
        $.get('/transfer-items/'+tno+'/store/<?php echo $sid; ?>', function(data){
            $('.render-titems').html(data.view);
            $('.bd-example-modal-lg').modal('toggle');
        });
    });

    $(document).on('click', '.receive-stock', function(e) {
        e.preventDefault();
        var tno = $(this).attr('transfer');
        $('button').prop('disabled', true);
        $(this).html("Receiving...");
        $.get('/receive-items/'+tno, function(data){
            location.reload();
        });
    });

    $(document).on('click', '.delete-transfer', function(e) {
        e.preventDefault();
        $('button').prop('disabled', true);
        $(this).html("Deleting...");
        var tno = $(this).attr('transfer');
        $.get('/delete-transfer/'+tno, function(data){
            if (data.success) {
                location.reload();
            } else {
                alert('Sorry, the system fails to delete transfer.');
            }
        });
    });

    $(document).on('click', '.edit-transfer', function(e) {
        e.preventDefault();
        $('button').prop('disabled', true);
        $(this).html("Editing...");
        var tno = $(this).attr('transfer');
        $.get('/edit-transfer/'+tno, function(data){
            if (data.status == "success") {
                window.location = '/store-master/<?php echo $sid; ?>/transfer-form';
            } else {
                if (data.error == 'another transfer on editing') {
                    $('.edit-error').css('display','');
                } else {
                    alert(data.error);
                }
            }
        });
    });

    $( document ).ajaxComplete(function() {
        // Required for Bootstrap tooltips in DataTables
        $('[data-toggle="tooltip"]').tooltip({
            "html": true,
            "delay": {"show": 1000, "hide": 0},
        });
    });
</script>
@endsection