    

@include("layouts.translater") 

    <style type="text/css"> 
    /*.date-range {float: left;}  */
        .table-details {font-size:13px}
        .previous-header .header-dropdown {right: 0px;}
        .date-range label {margin-bottom: 0px;}  
        .date-range button {margin-top: 20px;}
        .date-range .col-md-3 {padding-left: 0px;padding-right: 10px;}
        .previous-body {margin-top: 40px;}
        .displaynone {display: none;}
    @media screen and (max-width: 767px) {
        .previous-header .header-dropdown {position: relative; left: 0px;}
        .date-range {margin-top: 35px;margin-left: 0px;}
        .previous-body {margin-top: 70px;}
    }
    @media screen and (max-width: 480px) {
        .date-range button {margin-top: 18px;}
    }
    </style>

<div class="row">
    <div class="col-12 p-0">
        <div class="<?php if(Auth::user()->company->cashier_stock_approval == 'no') { echo 'displaynone'; }  ?>" style="background-color: #f9f6f2;padding-top: 10px;border-top: 1px solid #ddd;">
            <div class="header p-0 pl-1 pb-2">
                <h2><?php echo $_GET['pending-stock']; ?>:</h2>
            </div>     
            <div class="body pt-0">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table m-b-0 c_list">
                            <thead class="thead-light">
                                <tr>
                                    <th><?php echo $_GET['to-shop-store']; ?></th> 
                                    <th><?php echo $_GET['quantity']; ?></th>  
                                    <th><?php echo $_GET['date']; ?></th>   
                                    <th>Status</th>
                                    <th><?php echo $_GET['action']; ?></th>
                                </tr>
                            </thead>
                            <tbody class="pending-stock">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div style="background-color: #f0f0f0;padding-top: 20px;padding-bottom: 20px;border-top: 1px solid #ddd;margin-top: 15px;"> 
            <div class="header p-0 pl-1 previous-heade">
                <h2 class="mb-0"><?php echo $_GET['previous-stock-records']; ?>:</h2>
                <ul class="header-dropdown" style="margin-top: -20px !important;">
                    <li>                                
                        <div class="row clearfix date-range ml-1" style="">
                            <div class="col-md-9 offset-md-3" style="padding-left: 0px;">
                                <b class="bg-secondary text-light px-2"><?php echo $_GET['added-date']; ?>:</b>
                            </div>
                            <div class="col-md-3 offset-md-3 col-4 b">
                                <div class="form-group">
                                    <label><?php echo $_GET['from']; ?></label>
                                    <input type="text" data-provide="datepicker" data-date-autoclose="true" class="form-control from-date form-control-sm" placeholder="From" value="<?php echo date('d/m/Y', mktime(0, 0, 0, date("m") , date("d") - 5, date("Y"))); ?>">
                                </div>
                            </div>
                            <div class="col-md-3 col-4 b">
                                <div class="form-group">
                                    <label><?php echo $_GET['to']; ?></label>
                                    <input type="text" data-provide="datepicker" data-date-autoclose="true" class="form-control to-date form-control-sm" placeholder="To" value="<?php echo date('d/m/Y'); ?>">
                                </div>
                            </div>
                            <div class="col-md-3 col-3">
                                <button type="button" class="btn btn-info btn-sm check-pre-stock">Check</button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>     
            <div class="body previous-body">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table m-b-0 mt-3 c_list">
                            <thead class="thead-light">
                                <tr>
                                    <th><?php echo $_GET['item-name']; ?></th> 
                                    <th><?php echo $_GET['quantity']; ?></th>   
                                    <th><?php echo $_GET['shop-store']; ?></th>    
                                    <th>Status</th>  
                                    <th><?php echo $_GET['details']; ?></th>  
                                </tr>
                            </thead>
                            <tbody class="received-stock">
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div> 
        </div>
    </div>
</div>

@include('modals.new-stock-view')

<script type="text/javascript">
    $(function () {
        $('.pending-stock, .received-stock').html("<tr><td>Loading...</td></tr>");

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
</script>
