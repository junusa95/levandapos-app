
    
    
@include('layouts.translater')

<style>
    .ibtn {padding-top:29px;padding-left:0px;}
    @media screen and (max-width: 553px) {
        .sitem-summary .col-4 .body {padding-left:0px;padding-right:0px;}
    }
    @media screen and (max-width: 480px) {
        .ibtn {padding-top:25px}
    }
    @media screen and (max-width: 414px) {
        .sitem-summary .col-4 {padding-left:5px;padding-right:5px}
    }
</style>


    <div class="row pt-3 pb-2 psales-form" style="background:#f4f7f6">
        <div class="col-md-3 col-5 b bl">
            <div class="form-group">
                <label><?php echo $_GET['from']; ?></label>
                <input type="text" data-provide="datepicker" data-date-autoclose="true" class="form-control from-date3 form-control-sm" placeholder="From" value="<?php echo date('d/m/Y', mktime(0, 0, 0, date("m") , date("d") - 10, date("Y"))); ?>">
            </div>
        </div>
        <div class="col-md-3 col-5 b">
            <div class="form-group">
                <label><?php echo $_GET['to']; ?></label>
                <input type="text" data-provide="datepicker" data-date-autoclose="true" class="form-control to-date3 form-control-sm" placeholder="To" value="<?php echo date('d/m/Y'); ?>">
            </div>
        </div>
        <div class="col-md-2 col-2 ibtn">
            <button type="button" class="btn btn-info btn-sm check-i-sales">Check</button>
        </div>
    </div>
    
    <div class="row clearfix sitem-summary">
        <div class="col-lg-4 col-4">
            <div class="body">
                <span><?php echo $_GET['total']; ?></span>
                <h5 class="m-b-0 my-1 number totalIQ">--</h5>
                <small><?php echo $_GET['quantity-sold']; ?></small>
            </div>
        </div>
        <div class="col-lg-4 col-4">
            <div class="body">
                <span><?php echo $_GET['total']; ?></span>
                <h5 class="m-b-0 my-1 number totalIA">--</h5>
                <small><?php echo $_GET['sold-amount']; ?></small>
            </div>
        </div>
        @if(Auth::user()->isBusinessOwner())
        <div class="col-lg-4 col-4">
            <div class="body">
                <span><?php echo $_GET['total']; ?></span>
                <h5 class="m-b-0 my-1 number totalIP">--</h5> 
                <small><?php echo $_GET['profit']; ?></small>
            </div>
        </div>
        @endif
    </div>
    
    <div class="row">
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th><?php echo $_GET['date']; ?></th>
                        <th><?php echo $_GET['quantity-full']; ?></th>
                        <th><?php echo $_GET['amount']; ?></th>
                        @if(Auth::user()->isBusinessOwner())
                        <th><?php echo $_GET['profit']; ?></th>
                        @endif
                    </tr>
                </thead>
                <tbody class="sales-item-report" style="background-color: #f4f7f6;">
                    
                </tbody>
            </table>
        </div>
    </div>



    <script>

    $(document).ready(function(){        
        var fdate = $('.from-date3').val();
        var tdate = $('.to-date3').val();
        fdate = fdate.split('/').join('-');
        tdate = tdate.split('/').join('-');
        getProductSales("<?php echo $data['shop']->id; ?>","<?php echo $data['product']->id; ?>",fdate,tdate);
    });
    

</script>