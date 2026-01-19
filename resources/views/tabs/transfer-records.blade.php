
@include("layouts.translater") 

<style type="text/css"> 
    .tr-body {margin-top: 35px;}
    .previous-heade h2 {
        margin-bottom: 20px !important;
    }
    .previous-heade .header-dropdown {
        /* background-color: gold; */
        padding-top: 100px !important;margin-bottom: 30px;
    }
        .date-range label {margin-bottom: 0px;}  
        .date-range button {margin-top: 20px;}
        .date-range .col-md-3 {padding-left: 0px;padding-right: 10px;}
    @media screen and (max-width: 767px) {
        .tr-body {margin-top: 70px;}
        .date-range {margin-top: 35px;margin-left: 0px;}
    }
    @media screen and (max-width: 480px) {
        .tr-body {margin-top: 60px;}
    }
</style>
        
        <!-- pending -->

<div class="row">
    <div class="col-12 p-0">
        <div style="background-color: #f9f6f2;padding-top: 10px;border-top: 1px solid #ddd;">
            <div class="header p-0 pl-1 pb-2 previous-header">
                <h2><?php echo $_GET['pending-transfers']; ?>:</h2>
                <ul class="header-dropdown">
                    <li>                                
                        <div class="row clearfix date-range" style="display: none;">
                            <div class="col-md-9 offset-md-3" style="padding-left: 0px;">
                                <b class="bg-secondary text-light px-2"><?php echo $_GET['added-date']; ?>:</b>
                            </div>
                            <div class="col-md-3 offset-md-3 col-4 b">
                                <div class="form-group">
                                    <label><?php echo $_GET['from']; ?></label>
                                    <input type="text" data-provide="datepicker" data-date-autoclose="true" class="form-control from-date-t form-control-sm" placeholder="From" value="<?php echo date('d/m/Y'); ?>">
                                </div>
                            </div>
                            <div class="col-md-3 col-4 b">
                                <div class="form-group">
                                    <label><?php echo $_GET['to']; ?></label>
                                    <input type="text" data-provide="datepicker" data-date-autoclose="true" class="form-control to-date-t form-control-sm" placeholder="To" value="<?php echo date('d/m/Y'); ?>">
                                </div>
                            </div>
                            <div class="col-md-3 col-3">
                                <button type="button" class="btn btn-info btn-sm check-p-trans-rec">Check</button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>     
            <div class="body pt-0">
                <div class="row">
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
                            <tbody class="render-p-transfers">

                            </tbody>
                        </table>
                    </div>       
                </div>
            </div>
        </div>


        <!-- received -->
        <div style="background-color: #f0f0f0;padding-top: 20px;padding-bottom: 20px;margin-top: 15px;border-top: 1px solid #ddd;"> 
            <div class="header p-0 pl-1 previous-heade">
                <h2 class="mb-0"><?php echo $_GET['received-transfers']; ?>:</h2>
                <ul class="header-dropdown" style="margin-top: -20px !important;">
                    <li>                                
                        <div class="row clearfix date-range ml-1" style="">
                            <div class="col-md-9 offset-md-3" style="padding-left: 0px;">
                                <b class="bg-secondary text-light px-2"><?php echo $_GET['sent-time']; ?>:</b>
                            </div>
                            <div class="col-md-3 offset-md-3 col-4 b">
                                <div class="form-group">
                                    <label><?php echo $_GET['from']; ?></label>
                                    <input type="text" data-provide="datepicker" data-date-autoclose="true" class="form-control from-date-rt form-control-sm" placeholder="From" value="<?php echo date('d/m/Y', mktime(0, 0, 0, date("m") , date("d") - 5, date("Y"))); ?>">
                                </div>
                            </div>
                            <div class="col-md-3 col-4 b">
                                <div class="form-group">
                                    <label><?php echo $_GET['to']; ?></label>
                                    <input type="text" data-provide="datepicker" data-date-autoclose="true" class="form-control to-date-rt form-control-sm" placeholder="To" value="<?php echo date('d/m/Y'); ?>">
                                </div>
                            </div>
                            <div class="col-md-3 col-3">
                                <button type="button" class="btn btn-info btn-sm check-r-trans-rec">Check</button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>     
            <div class="body tr-body">
                <div class="row">
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
                            <tbody class="render-r-transfers">

                            </tbody>
                        </table>
                    </div>       
                </div>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    $(function () {
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
</script>