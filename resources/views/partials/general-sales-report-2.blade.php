
<style type="text/css">
    .date-range {text-align: left;}
    .check-g-sales {
        margin-bottom:auto;margin-top: 33px;
    }
    .view-sales {cursor: pointer;color: #007bff;}
    .vs_summary {padding-top: 10px;padding-bottom: 10px;}
    .vs_summary .vs_out div {display: inline-block;font-weight: bold; padding: 3px 10px 0px;margin-bottom: 5px;}
    .vs_summary .vs_out {display: inline-block;}
    .monthyear {font-weight: bold;font-size: 16px;}
    .pdf-block {padding-bottom: 20px;}
    @media screen and (max-width: 1134px) and (min-width: 992px) and (max-width: 587px) {
        .profit-icon {display: none;}
    }
    @media screen and (max-width: 587px) {
        .profit-icon {display: none;}
        .out-chart {padding-left: 0px;padding-right: 0px;}
    }
    @media screen and (max-width: 575px) {
        .top_counter .body .icon {display: none;}
        .top_counter .body {padding-left: 8px;padding-right: 8px;text-align: center;}
    }
    @media screen and (max-width: 480px) {
        .tsales-summary h5 {font-size: 1.2rem;font-weight: bold;}
        .tsales-summary .col-6, .tsales-summary .col, .tsales-summary .col-12 {padding-left: 5px;padding-right: 5px;}
        .tsales-summary .col-6 {padding-top: 10px;padding-bottom: 10px;}
        .tsales-summary .top_counter {margin-bottom: 15px;}
        .tsales-summary .col-12 .top_counter {margin-bottom: 25px;}
        .tsales-summary .top_counter .body {padding: 15px;padding-bottom: 0px;}
        .tsales-summary .top_counter .body .col {padding-left: 5px;padding-right: 5px;}
        .exp-col {padding-bottom: 10px;}
        .small-d .row {margin-left: -5px !important;margin-right: -5px !important;}
    }
    
    .view-expenses {cursor: pointer;color: #007bff;}
</style>
 
    <div class="card">
        <div class="body mt-0 pt-3">
            <div class="row clearfix date-range sp-date" style="margin-left: -20px;padding-left: 20px;margin-right: -20px;background-color: #fff;">
                <div class="col-sm-3 col-4 b">
                    <div class="form-group">
                        <label><?php echo $_GET['from']; ?></label>
                        <input type="text" data-provide="datepicker" data-date-autoclose="true" class="form-control from-date form-control-sm" placeholder="From" value="<?php echo date('d/m/Y', mktime(0, 0, 0, date("m") , date("d") - 9, date("Y"))); ?>">
                    </div>
                </div>
                <div class="col-sm-3 col-4 ml-2 b">
                    <div class="form-group">
                        <label><?php echo $_GET['to']; ?></label>
                        <input type="text" data-provide="datepicker" data-date-autoclose="true" class="form-control to-date form-control-sm" placeholder="To" value="<?php echo date('d/m/Y'); ?>">
                    </div>
                </div>
                <div class="col-3">
                    <button type="button" class="btn btn-info btn-sm check-g-sales">Check</button>
                </div>
            </div>

            <div class="row">
                <div class="col-9">
                    <!-- <div class="form-group s-r-p">
                        <label class="mb-1"><?php echo $_GET['month']; ?></label>
                        <input name="monthyear" class="monthyear form-control" autocomplete="off" />
                    </div> -->
                </div>
                <div class="col-3 pdf-block" align="right">
                    <button class="btn btn-secondary export-sales-pdf">PDF <i class="fa fa-download pl-1"></i></button>
                </div>
            </div>

            <div class="row clearfix tsales-summary" style="margin-left: -20px;margin-right: -20px;">
                <div class="col-md-3 col-sm-6 col-6 xl-turquoise">
                    <div class="content">
                        <div class="text"><?php echo $_GET['total-sales']; ?></div>
                        <h5 class="number totalSP">0</h5>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6 col-6 xl-slategray">
                    <div class="content">
                        <div class="text"><?php echo $_GET['quantity-full']; ?></div>
                        <h5 class="number totalSQ">0</h5>
                    </div>
                </div>
                
                <div class="col-md-7 col-12 small-d">
                    <div class="row">
                        @if(Auth::user()->isBusinessOwner())
                        <div class="col xl-khaki">
                            <div class="content">
                                <div class="text"><?php echo $_GET['gross-profit']; ?></div>
                                <h5 class="number profit">0</h5>
                            </div>
                        </div>
                        @endif
                        <div class="col exp-col xl-salmon">
                            <div class="content">
                                <div class="text"><?php echo $_GET['expenses-menu']; ?></div>
                                <h5 class="number totalEX">0</h5>
                                <span class="view-expenses"><i class="fa fa-eye"></i></span>
                            </div>
                        </div>
                        @if(Auth::user()->isBusinessOwner())
                        <div class="col xl-blue">
                            <div class="content">
                                <div class="text"><?php echo $_GET['net-profit']; ?></div>
                                <h5 class="number netProfit">0</h5>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- <div class="col-lg-3 col-sm-6 col-6">
                    <div class="card top_counter">
                        <div class="body">
                            <div class="icon"><i class="fa fa-tag"></i> </div>
                            <div class="content">
                                <div class="text">Expenses</div>
                                <h5 class="number totalEX" style="">0</h5>
                                <span class="view-expenses"><i class="fa fa-eye"></i></span>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>

            <div class="row mt-2" style="margin-left: -20px;margin-right: -20px;">
                <div class="table-responsive" style="background-color: #f9f6f2;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><?php echo $_GET['date']; ?></th>
                                <th><?php echo $_GET['quantity-full']; ?></th>
                                <th><?php echo $_GET['total-sales']; ?></th>
                                @if(Auth::user()->isBusinessOwner())
                                <th><?php echo $_GET['profit']; ?></th>
                                @endif
                                <th><?php echo $_GET['expenses-menu']; ?></th>
                                @if(Auth::user()->isBusinessOwner())
                                <th><?php echo $_GET['net-profit']; ?></th>
                                @endif
                                <th style="width:50px"></th>
                            </tr>
                        </thead>
                        <tbody class="render-daily-sales">
                            
                        </tbody>
                        <tbody class="tb-loader" style="display: none;">
                            <tr>
                                <td colspan="7" align="center">
                                    <div class='py-2'><i class='fa fa-spinner fa-spin fa-2x'></i> Loading...</div>
                                </td>
                            </tr>
                        </tbody>
                        <tbody class="sm-report-tbody" style="display: none;">
                            <tr>
                                <td colspan="7" align="center" class="pt-4">
                                    <button class="btn btn-info show-more-report"><?php echo $_GET['show-more']; ?></button>
                                </td>
                            </tr>
                        </tbody>
                        <tbody style="display: none;">
                            <tr>
                                <th><?php echo $_GET['total']; ?></th>
                                <th class="totalSQ">0</th>
                                <th class="totalSP">0</th>
                                @if(Auth::user()->isBusinessOwner())
                                <th class="profit">0</th>
                                @endif
                                <th class="totalEX">0</th>
                                @if(Auth::user()->isBusinessOwner())
                                <th class="netProfit">0</th>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>

        <!-- <div class="col-md-12 out-chart" style="width:100%;margin: 40px auto;">
            <div class="" style="text-align:center;">
                <b><?php echo $_GET['sales-graph-report']; ?></b>
            </div>

              <div class="canvas-blk">
                <canvas id="canvas"></canvas>
              </div>
        </div> -->

            </div>
        </div>
    </div>


    <!-- expenses modal from sales and profit-->
    <div class="modal fade" id="expensesModal2" tabindex="-1" role="dialog" aria-labelledby="expensesModal2Label" data-backdrop="static" data-keyboard="false" aria-hidden="true">
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
                                        <th><?php echo $_GET['date']; ?></th>
                                    </tr>
                                </thead>
                                <tbody class="expenses-report2">
                                    
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
        <div class="modal-dialog modal-lg" role="document">
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
                                    </tr>
                                </thead>
                                <tbody class="render-view-sales">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div> 