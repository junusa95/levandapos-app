
@include("layouts.translater") 

    <style type="text/css"> 
    /*.date-range {float: left;}  */
        .table-details {font-size:13px}
        .previous-header .header-dropdown {right: 0px;}
        .date-range label {margin-bottom: 0px;}  
        .date-range button {margin-top: 26px;}
        .date-range .b {padding-left: 0px;padding-right: 10px;}
        .previous-body {margin-top: -20px;}
        .received-stock-blc {margin-top: 25px;}
        .left-head {padding-top: 20px;}
        h5 small, h2 small {font-size: 12px;}
        .displaynone {display: none;}
    @media screen and (max-width: 767px) {
        .previous-header {margin-top:50px}
        .left-head {padding-top: 0px;margin-left: 10px;}
        .date-range {margin-top: 15px;margin-left: 0px;}
        /* .previous-body {margin-top: 70px;} */
    }
    @media screen and (max-width: 480px) {
        .date-range button {margin-top: 30px;}
    }
    </style>

<div class="row">
    <div class="col-12 px-0 reduce-padding">
        <div class="<?php if(Auth::user()->company->cashier_stock_approval == 'no') { echo 'displaynone'; }  ?>" style="margin-bottom: 40px;">
            <div class="header">
                <h2><?php echo $_GET['not-yet-received']; ?>: <small class="bg-warning text-dark" style="display:inline">(Pending)</small></h2>
            </div>     
            <div class="table-responsive" style="background-color: #f9f6f2;">
                <table class="table m-b-0 c_list">
                    <thead class="thead-light">
                        <tr>
                            <th><?php echo $_GET['item']; ?></th> 
                            <th><?php echo $_GET['added-by']; ?></th>  
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="pending-stock">
                        
                    </tbody>
                </table>
            </div>
        </div>

        <div class="received-stock-blc"> 
            <div class="row">
                <div class="col-md-6 pb-0 left-head">
                    <h5 class="mb-0"><?php echo $_GET['added-stock']; ?>: <small class="bg-success text-light">(Received)</small></h5>
                </div>
                <div class="col-md-6 pb-0">                    
                    <div class="row clearfix date-range" style="background:transparent">
                        <div class="col-md-12" style="padding-left: 0px;">
                            <b class="bg-secondary text-light px-2"><?php echo $_GET['added-date']; ?>:</b>
                        </div>
                        <div class="col-md-4 col-4 b">
                            <div class="form-group">
                                <label><?php echo $_GET['from']; ?></label>
                                <input type="text" data-provide="datepicker" data-date-autoclose="true" class="form-control from-date form-control-sm" placeholder="From" value="<?php echo date('d/m/Y', mktime(0, 0, 0, date("m") , date("d") - 10, date("Y"))); ?>">
                            </div>
                        </div>
                        <div class="col-md-4 col-4 b">
                            <div class="form-group">
                                <label><?php echo $_GET['to']; ?></label>
                                <input type="text" data-provide="datepicker" data-date-autoclose="true" class="form-control to-date form-control-sm" placeholder="To" value="<?php echo date('d/m/Y'); ?>">
                            </div>
                        </div>
                        <div class="col-md-3 col-3">
                            <button type="button" class="btn btn-info btn-sm check-pre-stock-2">Check</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="previous-body">
                <div class="table-responsive" style="background-color: #f0f0f0;">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th><?php echo $_GET['item-name']; ?></th> 
                                <th><?php echo $_GET['quantity']; ?></th>    
                                <th></th>  
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



<script type="text/javascript">
    $(function () {
        $('.pending-stock, .received-stock').html("<tr><td colspan='2' align='center'><i class='fa fa-spinner fa-spin'></i> Loading...</td></tr>");

        $.get("/get-data/pending-products-in/<?php echo $data['shop']->id; ?>", function(data){
            $('.pending-stock').html(data.products);        
        });         
        // $.get('/ceo/report/pending-stock-2/', function(data) { 
        //     $('.pending-stock').html("");
        //     $('.pending-stock').append(data.view);
        // });   

        $('.check-pre-stock-2').click();
    });

    $(document).on('click', '.check-pre-stock-2', function(e){
        e.preventDefault();
        $('.received-stock').html("<tr><td>Loading...</td></tr>");
        var fromdate = $('.from-date').val();
        fromdate = fromdate.split('/').join('-');
        var todate = $('.to-date').val();
        todate = todate.split('/').join('-');
        $.get('/report-by-date-range/previous-stock-records-in-shop/'+fromdate+'/'+todate+'/<?php echo $data["shop"]->id; ?>', function(data) { 
            $('.received-stock').html("");
            $('.received-stock').append(data.items);
        });   
    });
</script>