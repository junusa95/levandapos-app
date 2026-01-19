
<style type="text/css">
 .check-t-sales {
    margin-top: 25px;
 }
    @media screen and (max-width: 480px) {
        .check-t-sales {
            margin-top: 30px;
        }
    }
</style>

<div class="card">
    <div class="header">
        <h2>
            <!-- <?php echo $_GET['top-sold-products']; ?>:  -->
            <small>
                <?php if(Cookie::get("language") == 'en') { echo "Items as per higher quantities sold."; } else { echo "Bidhaa zilizouzika kwa wingi zaidi."; } ?>
            </small>
        </h2>
    </div>
    <div class="body pt-0">
        <div class="row clearfix date-range ts-date" style="background:#f9f6f2;margin-left: -20px;padding-left: 20px;margin-right: -20px;">
            <div class="col-sm-3 col-4 b">
                <div class="form-group">
                    <label class="mb-0"><?php echo $_GET['from']; ?></label>
                    <input type="text" data-provide="datepicker" data-date-autoclose="true" class="form-control from-date4 form-control-sm" placeholder="From" value="<?php echo date('d/m/Y', mktime(0, 0, 0, date("m") , date("d") - 9, date("Y"))); ?>">
                </div>
            </div>
            <div class="col-sm-3 col-4 ml-2 b">
                <div class="form-group">
                    <label class="mb-0"><?php echo $_GET['to']; ?></label>
                    <input type="text" data-provide="datepicker" data-date-autoclose="true" class="form-control to-date4 form-control-sm" placeholder="To" value="<?php echo date('d/m/Y'); ?>">
                </div>
            </div>
            <div class="col-3">
                <button type="button" class="btn btn-info btn-sm check-t-sales">Check</button>
            </div>
        </div>

        <div class="row" style="margin-left: -20px;margin-right: -20px;">
            <div class="table-responsive" style="background-color: #f9f6f2;">
                <table class="table table-hover js-basic-example dataTable table-custom">
                    <thead class="thead-light">
                        <tr>
                            <th><?php echo $_GET['item-name']; ?></th>
                            <th><?php echo $_GET['quantity-full']; ?></th>
                            <th><?php echo $_GET['sold-amount']; ?></th>
                            @if(Auth::user()->isBusinessOwner())
                            <th><?php echo $_GET['profit']; ?></th>
                            @endif
                        </tr>
                    </thead>
                    <!-- <tfoot>
                        <tr>
                            <th>Item name</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                            <th>Profit</th>
                        </tr>
                    </tfoot> --> 
                    <tbody class="tsales-report">
                        
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>