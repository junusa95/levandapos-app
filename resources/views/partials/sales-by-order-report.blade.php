
<div class="card">
    <div class="header">
        <h2><?php echo $_GET['sales-by-order']; ?>:</h2>
        <ul class="header-dropdown">
            <li>
                <select class="form-control-sm change-shop2" name="shopid">
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
                    <input type="text" data-provide="datepicker" data-date-autoclose="true" class="form-control from-date2 form-control-sm" placeholder="From" value="<?php echo date('d/m/Y', mktime(0, 0, 0, date("m") , date("d") - 9, date("Y"))); ?>">
                </div>
            </div>
            <div class="col-sm-3 col-4 ml-2 b">
                <div class="form-group">
                    <label><?php echo $_GET['to']; ?></label>
                    <input type="text" data-provide="datepicker" data-date-autoclose="true" class="form-control to-date2 form-control-sm" placeholder="To" value="<?php echo date('d/m/Y'); ?>">
                </div>
            </div>
            <div class="col-3">
                <button type="button" class="btn btn-info btn-sm check-o-sales">Check</button>
            </div>
        </div>

        <style type="text/css">
            @media screen and (max-width: 680px) {
                .profile_state .col-3,.profile_state .body,.profile_state .col-9 {
                    padding: 0px;
                }
            }
        </style>
        <div class="row clearfix mt-2">
            <div class="col-lg-12 col-12">
                <div class="card top_counter mt-3">
                    <div class="body">
                        <div class="row profile_state">
                            <div class="col-lg-3 col-3">
                                <div class="body">
                                    <span>Total</span>
                                    <h5 class="m-b-0 my-1 number totalOr">0</h5>
                                    <span>Orders</span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-9">
                                <div class="body text-left">
                                    <ul class="orderers">
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>                        
                </div>
            </div>
        </div>

        <div class="row">
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th><?php echo $_GET['order']; ?> #</th>
                            <th><?php echo $_GET['quantity-full']; ?></th>
                            <th><?php echo $_GET['amount']; ?></th>
                            <th><?php echo $_GET['ordered-by']; ?></th>
                            <th><?php echo $_GET['sold-by']; ?></th>
                            <th><?php echo $_GET['shop']; ?></th>
                        </tr>
                    </thead>
                    <!-- <tfoot>
                        <tr>
                            <th>Order #</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                            <th>Ordered by</th>
                            <th>Sold by</th>
                            <th>Shop</th>
                        </tr>
                    </tfoot> -->
                    <tbody class="orders-report">
                        
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>