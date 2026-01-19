
<style type="text/css">
    .date-range {text-align: left;}
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
        .tsales-summary h5 {font-size: 1rem;font-weight: bold;}
        .tsales-summary .col-6, .tsales-summary .col-12 {padding-left: 5px;padding-right: 5px;}
        .tsales-summary .top_counter {margin-bottom: 15px;}
        .tsales-summary .col-12 .top_counter {margin-bottom: 25px;}
        .tsales-summary .top_counter .body {padding: 15px;padding-bottom: 0px;}
        .tsales-summary .top_counter .body .col {padding-left: 5px;padding-right: 5px;}
        .exp-col {padding-bottom: 10px;}
    }
    
    .view-expenses {cursor: pointer;color: #007bff;}
</style>
 
    <div class="card">
        <div class="header" style="">
            <h2><?php echo $_GET['general-sales']; ?>:</h2>
            <ul class="header-dropdown">
                <li>
                    <select class="form-control-sm change-shop" name="shopid">
                        <option value="all"><?php echo $_GET['all-shops']; ?></option>
                        @if($data['shops'])
                        @foreach($data['shops'] as $shop)
                            <option value="{{$shop->id}}">{{$shop->name}}</option>
                        @endforeach
                        @endif
                    </select>
                </li>
            </ul>
        </div>
        <div class="body pt-0">
            <div class="row clearfix date-range" style="background:#f4f7f6;margin-left: -20px;padding-left: 20px;margin-right: -20px;">
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

            <div class="row clearfix tsales-summary mt-4">
                <div class="col-lg-3 col-sm-6 col-6">
                    <div class="card top_counter">
                        <div class="body">
                            <div class="icon text-info"><i class="fa fa-building"></i> </div>
                            <div class="content">
                                <div class="text"><?php echo $_GET['total-sales']; ?></div>
                                <h5 class="number totalSP">0</h5>
                            </div>
                        </div>                        
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-6">
                    <div class="card top_counter">
                        <div class="body">
                            <div class="icon text-warning"><i class="fa fa-area-chart"></i> </div>
                            <div class="content">
                                <div class="text"><?php echo $_GET['quantity-sold']; ?></div>
                                <h5 class="number totalSQ">0</h5>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 col-12">
                    <div class="card top_counter">
                        <div class="body">
                            <div class="icon text-success profit-icon"><i class="fa fa-dollar"></i> </div>
                            <div class="row">
                                @if(Auth::user()->isBusinessOwner())
                                <div class="col">
                                    <div class="content">
                                        <div class="text"><?php echo $_GET['gross-profit']; ?></div>
                                        <h5 class="number profit">0</h5>
                                    </div>
                                </div>
                                @endif
                                <div class="col exp-col">
                                    <div class="content">
                                        <div class="text"><?php echo $_GET['expenses-menu']; ?></div>
                                        <h5 class="number totalEX">0</h5>
                                        <span class="view-expenses"><i class="fa fa-eye"></i></span>
                                    </div>
                                </div>
                                @if(Auth::user()->isBusinessOwner())
                                <div class="col">
                                    <div class="content">
                                        <div class="text"><?php echo $_GET['net-profit']; ?></div>
                                        <h5 class="number netProfit">0</h5>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
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

            <div class="row">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-light">
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
                        <tbody>
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

        <div class="col-md-12 out-chart" style="width:100%;margin: 40px auto;">
            <div class="" style="text-align:center;">
                <b><?php echo $_GET['sales-graph-report']; ?></b>
            </div>

              <div class="canvas-blk">
                <canvas id="canvas"></canvas>
              </div>
        </div>

            </div>
        </div>
    </div>

