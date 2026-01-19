

@include('layouts.translater')

<style>
    .ts-btn {padding-top:29px;padding-left:0px;}
    @media screen and (max-width: 480px) {
        .ts-btn {padding-top:25px}
    }
</style>

    <div class="row pt-3 pb-2 top-b pshop-activities" style="background:#f4f7f6">
        <div class="col-md-3 col-5 from">
            <div class="form-group">
                <label><?php echo $_GET['from']; ?></label>
                <input type="text" name="date_fa" data-provide="datepicker" data-date-autoclose="true" class="form-control form-control-sm" placeholder="From" value="<?php echo date('d/m/Y', mktime(0, 0, 0, date("m") , date("d") - 10, date("Y"))); ?>">
            </div>            
        </div>
        <div class="col-md-3 col-5 align-left to">
            <div class="form-group">
                <label><?php echo $_GET['to']; ?></label>
                <input type="text" name="date_ta" data-provide="datepicker" data-date-autoclose="true" class="form-control form-control-sm" placeholder="From" value="<?php echo date('d/m/Y'); ?>">
            </div>            
        </div>
        <div class="col-md-2 col-2 ts-btn">
            <button class="btn btn-info btn-sm check-i-activities">Check</button>
        </div>
    </div>

    <div class="row"> 
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th><?php echo $_GET['date']; ?></th>
                        <th><?php echo $_GET['activities']; ?></th>
                        <th><?php echo $_GET['remaining-quantity']; ?></th>
                    </tr>
                </thead>
                <tbody class="render-activities" style="background-color: #f4f7f6;">

                </tbody>
            </table>
        </div>
    </div>



    <script>

    $(document).ready(function(){        
        var pid = getSearchParams("pid");
        var fdate = $('input[name="date_fa"]').val();
        var tdate = $('input[name="date_ta"]').val();
        fdate = fdate.split('/').join('-');
        tdate = tdate.split('/').join('-');
        getProductActivities("<?php echo $data['shop']->id; ?>",pid,fdate,tdate);
    });
    
</script>