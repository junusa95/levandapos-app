
<div class="card">
    <div class="header">
        <h2><?php echo $_GET['sales-by-item']; ?>:</h2>
        <ul class="header-dropdown">
            <li>
                <select class="form-control-sm change-shop3" name="shopid">
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
        <style type="text/css">
            .id-range {background:#f4f7f6;margin-left: -15px;padding-left: 20px;margin-right: -15px;}
            @media screen and (max-width: 524px) {
                .id-range {margin-left: -20px;padding-left: 5px;margin-right: -20px;padding-right: -5px;}
            }
            @media screen and (max-width: 500px) {
                .id-range .col-3 { max-width: 20%; }
                .id-range .id-range { min-width: 30% !important;max-width: 30% !important;float: right; }
                .id-range .form-control {font-size: 12px;}
                /*.id-range input {width: 97px;}*/
            }
            @media screen and (max-width: 440px) {
                .id-range .form-control {padding-left: 2px;padding-right: 2px;}
            }
            @media screen and (max-width: 380px) {
                .id-range .col-3 { max-width: 23%; }
                .id-range .ibtn, .id-range .col-2 { min-width: 20% !important;max-width: 20% !important; }
            }
        </style>
        <div class="row clearfix date-range id-range">
            <style type="text/css">
                .b2 .form-group {text-align: center;}
                select.select2 {
                    width: 200px !important;height: 100px !important;
                }
                @media screen and (max-width: 900px) {
                    select.select2 { width: 150px !important; }
                }
                @media screen and (max-width: 767px) {
                    .b2 .form-group {text-align: left;margin-bottom: 5px;margin-left: -8px;}
                    .id-range .form-group label {margin-bottom: 0px;}
                    .b2 .form-group label {display: block;margin-bottom: 3px;}
                    select.select2 { width: 250px !important; }
                    .ibtn button {margin-top: 25px;}
                }
                @media screen and (max-width: 680px) and (min-width:  576px) {
                    select.select2 {
                        /*width: 150px !important;*/
                    }
                }
                @media screen and (max-width: 576px) {
                    /*select.select2 { width: 150px !important; }*/
                }
                @media screen and (max-width: 875px) {
                    .ibtn { text-align: right; }
                }
                @media screen and (max-width: 742px) {
                    .ibtn { margin-left: 25px; }
                }
                @media screen and (max-width: 524px) {
                    .ibtn { padding-right: 0px; }
                }
                @media screen and (max-width: 480px) {
                    .ibtn button {margin-top: 23px;}
                }
                @media screen and (max-width: 380px) {
                    /*select.select2 { width: 100px !important;padding-left: 0px !important;font-size: 12px !important; }*/
                    .select2-container .select2-selection--single .select2-selection__rendered {font-size: 12px !important;padding-left: 5px !important;margin-left: 0px !important;}
                }
            </style>
            <div class="col-md-3 col-sm-12 b b2">
                <div class="form-group px-2" style="padding-top: 2px;">
                    <label><?php echo $_GET['choose-product']; ?></label>
                    <select class="form-control-sm select2 change-item" name="itemid">
                        <option value="null"> <?php echo $_GET['select-item']; ?> </option>
                        @if($data['items'])
                        @foreach($data['items'] as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-sm-3 col-4 b bl">
                <div class="form-group">
                    <label><?php echo $_GET['from']; ?></label>
                    <input type="text" data-provide="datepicker" data-date-autoclose="true" class="form-control from-date3 form-control-sm" placeholder="From" value="<?php echo date('d/m/Y', mktime(0, 0, 0, date("m") , date("d") - 9, date("Y"))); ?>">
                </div>
            </div>
            <div class="col-sm-3 col-4 ml-2 b">
                <div class="form-group">
                    <label><?php echo $_GET['to']; ?></label>
                    <input type="text" data-provide="datepicker" data-date-autoclose="true" class="form-control to-date3 form-control-sm" placeholder="To" value="<?php echo date('d/m/Y'); ?>">
                </div>
            </div>
            <div class="col-sm-2 col-2 ibtn">
                <button type="button" class="btn btn-info btn-sm check-i-sales">Check</button>
            </div>
        </div>

        <style type="text/css">            
            @media screen and (max-width: 480px) {
                .sitem-summary h5 {font-size: 1rem;font-weight: bold;}
                .sitem-summary .col-12 {padding-left: 5px;padding-right: 5px;}
            }
        </style>
        <div class="row clearfix sitem-summary mt-2">
            <div class="col-lg-12 col-12">
                <div class="card top_counter mt-2">
                    <div class="body">
                        <div class="row profile_state">
                            <div class="col-lg-4 col-4">
                                <div class="body">
                                    <span><?php echo $_GET['total']; ?></span>
                                    <h5 class="m-b-0 my-1 number totalIQ">0</h5>
                                    <span><?php echo $_GET['quantity-sold']; ?></span>
                                </div>
                            </div>
                            <div class="col-lg-4 col-4">
                                <div class="body">
                                    <span><?php echo $_GET['total']; ?></span>
                                    <h5 class="m-b-0 my-1 number totalIA">0</h5>
                                    <span><?php echo $_GET['sold-amount']; ?></span>
                                </div>
                            </div>
                            <div class="col-lg-4 col-4">
                                <div class="body">
                                    <span><?php echo $_GET['total']; ?></span>
                                    <h5 class="m-b-0 my-1 number totalIP">0</h5>
                                    <span><?php echo $_GET['profit']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>                        
                </div>
            </div>
        </div>

        <div class="row">
            <div class="table-responsive">
                <table class="table table-hover js-basic-example dataTable table-custom">
                    <thead class="thead-light">
                        <tr>
                            <th><?php echo $_GET['date']; ?></th>
                            <th><?php echo $_GET['item-name']; ?></th>
                            <th><?php echo $_GET['quantity-full']; ?></th>
                            <th><?php echo $_GET['amount']; ?></th>
                            <th><?php echo $_GET['profit']; ?></th>
                        </tr>
                    </thead>
                    <!-- <tfoot>
                        <tr>
                            <th>Date</th>
                            <th>Item name</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                            <th>Profit</th>
                        </tr>
                    </tfoot> -->
                    <tbody class="sitems-report">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>