
@include("layouts.translater")
<style>
    .sales-block, .sales-p-block, .top-s-p {display: none;}
    
    .print-sale .head {text-align: center;font-size: 1rem;font-weight: bolder;}
    .print-sale .left-d {text-align: left;margin-top: 10px;margin-bottom: 15px;}
    .print-sale .left-d .f {padding-right: 5px;}

    @media screen and (max-width: 455px) {
        .top-sr-menu li a {margin-right: 0px !important; padding: 5px 0px;padding-right: 8px; font-size: 14px;}
        .top-sr-menu li a:before{content:'\00B7';padding-right:8px;}
        .top-sr-menu li:first-child a:before { content: ''; }
    }
    @media screen and (max-width: 400px) {
        .sales-summary-h div.left {padding-left: 0px;}
    }
    @media screen and (max-width: 371px) {
        .top-sr-menu li a {font-size: 13.4px;}
    }
</style>

<?php  
    // check if is cashier or shop seller 
    $isCashier = \DB::table('user_shops')->where('user_id',Auth::user()->id)->where('shop_id',$data['shop']->id)->where('who','cashier')->first();
    $hideblock = 'hideblock';
    if ($data['shop']->has_customers == 'yes') {
        $hideblock = '';
    }
    $curr_code = "";
    if ($data['shop']->company) {
        // $curr_code = $data['shop']->company->currency->code;
    }    
    $is_BO = "no";
    if (Auth::user()->isBusinessOwner()) {
        $is_BO = "yes";
    }
 ?>

  
                <div class="row clearfix">

                    <input type="hidden" name="shopid" value="{{$data['shop']->id}}">
                    
                    <div class="col-md-8 offset-md-2 top-sr-menu mt-3 mb-3 px-0">
                        <div>
                            <ul class="nav nav-tabs-new2">
                                <li class="nav-item">
                                    <a class="nav-link sales" data-toggle="tab" href="#"><?php echo $_GET['sales']; ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link sales-p" data-toggle="tab" href="#"><?php if(Auth::user()->isBusinessOwner()) { echo $_GET['sales-and-profit']; } else { echo $_GET['sales-by-dates']; } ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link top-s-pr" data-toggle="tab" href="#">{{$_GET['top-sold-products']}}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-8 offset-md-2 col-sm-12 px-0 sales-bs sales-block">
                        <div class="card mb-0" style="box-shadow: none;">  
                            <div class="body pt-0 sales-body" style="min-height: auto !important;">
                                <!-- <div class="row" style="display: none;">
                                    <div class="col-sm-4">
                                        <div class="bg-color1 text-light px-2 pt-1">
                                            <h6 class="mb-1"><b><?php echo $_GET['today']; ?></b></h6>
                                            <div class="row today-summary">
                                                  
                                            </div>
                                        </div>
                                    </div>                
                                    <div class="col-sm-4">
                                        <div class="bg-color2 text-light px-2 pt-1">
                                            <h6 class="mb-1"><b><?php echo $_GET['this-week']; ?></b></h6>
                                            <div class="row week-summary">

                                            </div>   
                                        </div>
                                    </div>                
                                    <div class="col-sm-4">
                                        <div class="bg-color3 text-light px-2 pt-1">
                                            <h6 class="mb-1"><?php echo $_GET['this-month']; ?></h6>
                                            <div class="row month-summary">

                                            </div>   
                                        </div>
                                    </div>                                    
                                </div> -->
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <h6 class="mb-1" style="margin-left: -10px !important;"><?php echo $_GET['this-month']; ?></h6>
                                        <div class="row" style="margin-left: -20px !important;margin-right: -20px !important;">
                                            <div class="col-md-6 col-5 py-2 px-1 xl-turquoise">
                                                <div>
                                                    <h4 class="m-sales">-</h4>
                                                    <span><?php echo $_GET['sales']; ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-3 py-2 px-1 xl-slategray">
                                                <div>
                                                    <h4 class="m-quantity">-</h4>
                                                    <span><?php echo $_GET['quantity-full']; ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 py-2 col-4 px-1 xl-salmon">
                                                <div>
                                                    <h4 class="m-expenses">-</h4>
                                                    <span><?php echo $_GET['expenses-menu']; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card" style="box-shadow: none;">      
                            <!-- <div class="header" style="border-bottom:1px solid #ddd;">
                                <h2><?php echo $_GET['sales']; ?>:</h2>
                                <ul class="header-dropdown">
                                    <li>
                                        <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#returnSoldItems">
                                            <?php echo $_GET['return-sold-items']; ?>
                                        </button>
                                    </li>
                                </ul>
                            </div>      -->
                            <div class="body">
                                <div class="row">
                                    <div class="col-6 col-md-4 pl-0">
                                        <label class="mb-0"><?php echo $_GET['date']; ?></label>
                                        <input type="text" data-provide="datepicker" data-date-autoclose="true" class="form-control date-of-sale" value="{{date('d/m/Y')}}">
                                    </div>
                                    <div class="col-5 offset-1 col-md-4 offset-md-4 pr-0">
                                        <div class="view">
                                            <label class="mb-0"><?php echo $_GET['view']; ?></label>
                                            <select class="form-control form-control-sm sales-view">
                                                <option value="all-sales"><?php echo $_GET['sales']; ?></option>
                                                <option value="sales-w-customers"><?php echo $_GET['sales-with-customers']; ?></option>
                                                <option value="sales-w-sellers"><?php echo $_GET['sales-with-who-sold']; ?></option>
                                                <option value="sales-w-sale-numbers">With Sale Numbers</option>
                                                <option value="sales-w-payment-options"><?php echo $_GET['with-payment-options']; ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row pt-4 pb-1 sales-summary-h" style="background-color: #f9f6f2;margin-top: 15px;">
                                    <div class="col-12 left">
                                        <div>
                                            <strong><?php echo $_GET['total-sales']; ?>:</strong><span class="bg-dark text-light px-2 py-1 ml-1 totalSP"></span>
                                        </div>
                                        <div class="">
                                            <strong><?php echo $_GET['total-quantity']; ?>:</strong><span class="bg-dark text-light px-2 py-1 ml-1 totalSQ"></span>
                                        </div>   
                                        <div class="expenses">
                                            <strong><?php echo $_GET['expenses-menu']; ?>:</strong>
                                            <span class="bg-dark text-light px-2 py-1 ml-1">
                                                <span class="totalE"></span>
                                                <a href="#" class="view-expenses-2 ml-2"><i class="fa fa-eye"></i></a>
                                            </span>                                        
                                        </div>   
                                        <div class="deni">
                                            <strong>Deni tunadai:</strong>
                                            <span class="bg-dark text-light px-2 py-1 ml-1">
                                                <span class="totalD"></span>
                                                <a href="#" class="view-deni ml-2"><i class="fa fa-eye"></i></a>
                                            </span>                                        
                                        </div>   
                                        <div class="ameweka">
                                            <strong>Pesa imeingia:</strong>
                                            <span class="bg-dark text-light px-2 py-1 ml-1">
                                                <span class="totalA"></span>
                                                <a href="#" class="view-ameweka ml-2"><i class="fa fa-eye"></i></a>
                                            </span>                                        
                                        </div>   
                                        <div class="tumelipa">
                                            <strong>Pesa imetoka:</strong>
                                            <span class="bg-dark text-light px-2 py-1 ml-1">
                                                <span class="totalT"></span>
                                                <a href="#" class="view-tumelipa ml-2"><i class="fa fa-eye"></i></a>
                                            </span>                                        
                                        </div>   
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 px-0">
                                        <div class="table-responsive" style="background-color: #f9f6f2;">
                                            <table class="table">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th><?php echo $_GET['sold-items']; ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="sales-report sold-products2">
                                                    
                                                </tbody>
                                                <tbody class="sales-report-2 sold-products2">
                                                    
                                                </tbody>
                                                <tbody class="load-more-loader" style="display: none;">
                                                    <tr><td align="center" class="p2-4 pb-4">
                                                        <i class="fa fa-spinner fa-spin"></i>
                                                    </td></tr>
                                                </tbody>
                                                <tbody class="load-more-s-b" style="display: none;">
                                                    <tr><td align="center" class="pt-3 pb-4">
                                                        <button class="btn btn-outline-info load-more-sales"><?php echo $_GET['show-more']; ?></button>
                                                    </td></tr>
                                                </tbody>
                                                <tbody class="total-row">
                                                    <tr>
                                                        <td>
                                                            <div class="row" style="margin:0px">
                                                                <div class="col-2" style="padding-top: 10px;"><?php echo $_GET['total']; ?></div>
                                                                <div class="col-10">
                                                                    <div>
                                                                        <span style="padding-right: 3px;font-weight: 100;"><?php echo $_GET['quantity-full']; ?></span>:<span class="pl-1 totalSQ" style="font-size:1.2em;"></span>
                                                                    </div>
                                                                    <div>
                                                                        <span  style="padding-right: 8px;font-weight: 100;"><?php echo $_GET['amount']; ?></span>:<span class="pl-1 totalSP" style="font-size:1.2rem;"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <!-- <tr>
                                                        <td></td>
                                                        <th>Total</th>
                                                        <th class="totalSQ">0</th>
                                                        <td></td>
                                                        <th class="totalSP">0</th>
                                                    </tr> -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-12 px-1" style="display:none">
                                        <div class="table-responsive mb-3">
                                            <table class="table js-basic-example dataTable table-custom mt-3">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th colspan="6" class="">
                                                            Closure Note
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>Expected Amount</th>
                                                        <th>Submitted Amount</th>
                                                        <th>Status</th>
                                                        <th>Closed by</th>
                                                        <th>Time</th>
                                                        <th>Shop</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody class="closure-sale-2">
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="row mx-0">
                                <div class="col-12 mt-3" align="right">
                                    <button class="btn btn-secondary return-sold-items-btn btn-sm" data-toggle="modal" data-target="#returnSoldItems">
                                        <?php echo $_GET['return-sold-items']; ?>
                                    </button>
                                </div>
                            </div> -->

                            <div class="row mt-3 mx-0">
                                <div class="col-12 col-md-6 mb-5 px-1 returned-block" style="display:none;">
                                    <div>
                                        <h6><?php echo $_GET['items-returned-on-this-date']; ?>:</h6>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table m-b-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th><?php echo $_GET['item-name']; ?></th>
                                                    <th><?php echo $_GET['quantity']; ?></th>
                                                    <th class="align-right"><?php echo $_GET['sold-date']; ?></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody class="render-returned-items">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 mb-5 px-1 returned-block2" style="display:none;">
                                    <div>
                                        <h6><?php echo $_GET['returned-items-that-sold']; ?>:</h6>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table m-b-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th><?php echo $_GET['item-name']; ?></th>
                                                    <th><?php echo $_GET['quantity']; ?></th>
                                                    <th class="align-right"><?php echo $_GET['returned-date']; ?></th>
                                                </tr>
                                            </thead>
                                            <tbody class="render-returned-items2">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8 offset-md-2 col-sm-12 px-0 sales-bs sales-p-block">
                        @include('partials.general-sales-report-2') 
                    </div>
                    
                    <div class="col-md-8 offset-md-2 col-sm-12 px-0 sales-bs top-s-p-block">
                        @include('partials.top-sales-report-2')
                    </div>

                </div>

    <!-- modal Expenses from sales -->
    <div class="modal fade" id="expensesModal" tabindex="-1" role="dialog" aria-labelledby="expensesModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6><?php echo $_GET['expenses-menu']; ?></h6>
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                        <button class="btn btn-danger btn-sm">x</button>
                    </span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-12">
                            <div class="table-responsive">
                                <table class="table table-borderless m-b-0 c_list">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo $_GET['item']; ?></th>
                                            <th><?php echo $_GET['amount']; ?></th>
                                            <th><?php echo $_GET['description']; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody class="expenses-report">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal Tunawadai -->
    <div class="modal fade" id="madeniModal" tabindex="-1" role="dialog" aria-labelledby="madeniModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                        <button class="btn btn-danger btn-sm">x</button>
                    </span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-12">
                            <div class="table-responsive">
                                <div>Deni kutoka kwenye bidhaa walizonunua.</div>
                                <table class="table table-borderless m-b-0 c_list">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Mteja</th>
                                            <th>Thamani ya bidhaa</th>
                                            <th>Fedha aliyolipa</th>
                                            <th>Deni</th>
                                        </tr>
                                    </thead>
                                    <tbody class="madeni-list">
                                        <tr><td></td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive mt-3">
                                <div>Mteja amekopeshwa pesa taslim.</div>
                                <table class="table table-borderless m-b-0 c_list">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Mteja</th>
                                            <th>Kias alichokopa</th>
                                        </tr>
                                    </thead>
                                    <tbody class="kopesha-cash-list">
                                        <tr><td></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal Tumelipa -->
    <div class="modal fade" id="tumelipaModal" tabindex="-1" role="dialog" aria-labelledby="tumelipaModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                        <button class="btn btn-danger btn-sm">x</button>
                    </span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-12">
                            <div class="table-responsive">
                                <div>Wateja waliolipwa madeni au kurudishiwa pesa zao.</div>
                                <table class="table table-borderless m-b-0 c_list">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Mteja</th>
                                            <th>Kias</th>
                                            <th>Sababu</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tumelipa-list">
                                        <tr><td></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal Wanatudai -->
    <div class="modal fade" id="amewekaModal" tabindex="-1" role="dialog" aria-labelledby="amewekaModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6>Wateja wameweka pesa</h6>
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                        <button class="btn btn-danger btn-sm">x</button>
                    </span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-12">
                            <div class="table-responsive">
                                <div>Ongezeko la pesa kwenye bidhaa walizonunua.</div>
                                <table class="table table-borderless m-b-0 c_list">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Mteja</th>
                                            <th>Thamani ya bidhaa</th>
                                            <th>Fedha aliyolipa</th>
                                            <th>Anatudai</th>
                                        </tr>
                                    </thead>
                                    <tbody class="ameweka-list">
                                        <tr><td></td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive mt-3">
                                <div>Mteja ameweka pesa taslim.</div>
                                <table class="table table-borderless m-b-0 c_list">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Mteja</th>
                                            <th>Kias alichoweka</th>
                                        </tr>
                                    </thead>
                                    <tbody class="ameweka-cash-list">
                                        <tr><td></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- sell products -->
    <div class="modal fade" id="saleModal" tabindex="-1" role="dialog" aria-labelledby="saleModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="col-12 mt-3">
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                        <button class="btn btn-danger btn-sm">x</button>
                    </span>
                </div>
                <div class="modal-body align-center mb-4">
                    <div class="sale-preview">
                        <div class="s-preview-loader"></div>
                        <p class="scustomer"><span><?php echo $_GET['customer']; ?>: </span> <b class="customername" style="font-size: 1rem;"></b></p>
                        <h5><?php echo $_GET['amount-to-be-paid']; ?></h5>
                        <h4 class="amounttopay"></h4>

                        <?php if($data['shop']->sell_order == 'yes') { ?>
                        <div class="col-12 mt-5" align="center">
                            <div class="form-group" align="left" style="display: inline-block;">
                                <small><?php echo $_GET['paid-amount']; ?></small>
                                <input type="number" name="paidamount" class="form-control s-paidamount" value="0" style="font-size: 18px;width: 120px;">
                            </div>
                            <div class="spacer mx-2" style="display: inline-block;"></div>
                            <div class="change-blc" align="left" style="display: inline-block;">
                                <label>Change</label>
                                <h5 class="s-change">0</h5>
                            </div>
                        </div>
                        <?php } else { ?>
                            <div class="scustomer">
                                <div class="col-12 mt-5" align="center">
                                    <div class="form-group" align="left" style="display: inline-block;">
                                        <small><?php echo $_GET['paid-amount']; ?></small>
                                        <input type="number" name="paidamount" class="form-control s-paidamount" value="0" style="font-size: 18px;width: 120px;">
                                    </div>
                                    <div class="spacer mx-2" style="display: inline-block;"></div>
                                    <div class="change-blc" align="left" style="display: inline-block;">
                                        <label>Change</label>
                                        <h5 class="s-change">0</h5>
                                    </div>
                                </div>
                                <!-- <br>
                                <h5><?php echo $_GET['paid-amount-2']; ?> </h5>
                                <input type="number" name="paidamount" class="form-control paidamount px-0" style="margin-left: auto;margin-right: auto;text-align: center;font-size: 2rem;width: 50%;border: 3px solid #ddd;"> -->
                            </div>         
                        <?php } ?>
                        <div class="col-12 mt-5">
                            <button type="button" class="btn btn-success px-3 submit-sale-cart2" style="font-size:1.2rem"><b><?php echo $_GET['sell']; ?> <i class="fa fa-check pl-2"></i></b> </button>
                        </div>
                    </div>
                    <div class="sale-loader" style="display: none;">
                        <div class="my-5">
                            <i class="fa fa-spinner fa-spin fa-2x"></i> 
                        </div>
                    </div>
                    <div class="row sale-receipt">
                        <!-- receipt -->
                        <div class="col-12">
                            <h2>Print Receipt</h2>
                        </div>
                        <div class="col-12 mt-3" style="height: 65vh;overflow-y: scroll;">
                            <div class="row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="print-sale">
                                        <div class="head" align="center" style="border-top: 1px solid #000;">
                                            <div>{{$data['shop']->name}}</div>
                                            <div>{{$data['shop']->location}}</div>
                                            @if($data['shop']->company->tin)
                                            <div>TIN: {{$data['shop']->company->tin}}</div>
                                            @endif 
                                            @if($data['shop']->company->vrn)
                                            <div>VRN: {{$data['shop']->company->vrn}}</div>
                                            @endif 
                                            <div><?php echo '+'.Auth::user()->phonecode.' '.Auth::user()->phone; ?></div>
                                        </div> 
                                        <div class="left-d">
                                            <table>
                                                <thead>
                                                    <tr><th class="f">SALE #</th><th>:</th><th><span class="saleno"></span></th></tr>
                                                    <tr><th class="f">CASHIER</th><th>:</th><th>{{Auth::user()->name}}</th></tr>
                                                    <tr class="customer-s-blk"><th class="f">CUSTOMER</th><th>:</th><th class="customer-s-name"></th></tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div>                                      
                                            <table class="table table-borderless m-b-0 c_list" style="width: 100%;border-bottom: 1px solid #000;margin-bottom: 15px;color: #000;">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>ITEM</th><th><div  align="center">Qty</div> </th><th><div align="right">TOTAL</div></th>
                                                    </tr>
                                                </thead>
                                                <thead class="thead-light"> 
                                                    
                                                </thead>
                                                <tbody class="render-sales-to-print sold-products2" style="font-size: 1rem;">
                                                    
                                                </tbody>
                                            </table>
                                            <div align="right">
                                                <table>
                                                    <thead>
                                                        <tr><th class="f">TOTAL AMOUNT</th><th>:</th><th><span class="total_SP"></span></th></tr>
                                                        <tr><th class="f">PAID AMOUNT</th><th>:</th><th><span class="totalSPA"></span></th></tr>
                                                        <tr><th class="f">CHANGE</th><th>:</th><th><span class="totalCH"></span></th></tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>                                        
                                        <div style="width: 100%;font-size: 1rem;border-top: 1px solid #000;" align="center">Thanks for your purchase!</div>
                                        <div style="width: 100%;font-size: 0.8rem;" align="center"><?php echo date('d M, Y, g:i a'); ?></div>
                                    </div>
                                </div>
                                                        
                                <!-- printable block -->
                                <div class="col-12 pb-5" style="display: none;">

                                    <div id="printed-sale">
                                        <div class="printed-sale">
                                            <div class="head" style="font-size: 12px;">
                                                <p style="text-align: center;">
                                                    {{$data['shop']->name}} <br>
                                                    {{$data['shop']->location}} <br> 
                                                    @if($data['shop']->company->tin)
                                                    TIN: {{$data['shop']->company->tin}} <br>
                                                    @endif 
                                                    @if($data['shop']->company->vrn)
                                                    VRN: {{$data['shop']->company->vrn}} <br>
                                                    @endif 
                                                    <?php echo '+'.Auth::user()->phonecode.' '.Auth::user()->phone; ?>
                                                </p>
                                            </div> 
                                            <div style="text-align:left;font-size: 10px;">
                                                <div>SALE #: <span class="saleno"></span></div>
                                                <div>CASHIER: <span class="">{{Auth::user()->name}}</span></div>
                                                <div class="customer-s-blk">CUSTOMER: <span class="customer-s-name"></span></div>
                                                <!-- <div class="show-custom-no" style="margin-top: 20px;display: none;"><span style="font-size:2rem;font-weight:bolder;margin-bottom: 0px;padding-bottom: 0px;">A42</span></div> -->
                                            </div>
                                            <div style="margin-top: 10px;text-align:left;font-size: 10px;border-bottom: 1px solid #000;">
                                                ITEMS
                                            </div>
                                            <div class="">
                                                <table style="width: 100%;">
                                                    <thead class="render-sales-to-print" style="color: #000;font-size: 10px;">
                                                        
                                                    </thead>
                                                </table>
                                                <table style="width: 100%;border-bottom: 1px solid #000;border-top: 1px solid #000;font-size: 10px;" align="right">
                                                    <tbody>
                                                        <tr>
                                                            <th style="text-align: right;">TOTAL AMOUNT</th><th>:</th><th class="total_SP" align="left"></th>
                                                        </tr>
                                                        <tr class="pa-tr"><th style="text-align: right;">PAID AMOUNT</th><th>:</th><th class="totalSPA" align="left"></th></tr>
                                                        <tr class="ch-tr"><th style="text-align: right;">CHANGE</th><th>:</th><th class="totalCH" align="left"></th></tr>
                                                    </tbody>
                                                </table>
                                                <div class="p-thanks" style="margin-top: 30px;text-align: center;font-size: 10px;">
                                                    Thanks for your purchase!
                                                </div>
                                                <div style="text-align: center;font-size: 10px;"><?php echo date('d M, Y, g:i a'); ?></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="" id="printable_div_id" style="font-size: 3rem;font-weight: bolder;color: #000 !important; font-family: Arial;">
                                        
                                        <p class="centered" style="font-size: 2.6rem;color: #000;" align="center">
                                            <!-- <img src="https://pos.levanda.co.tz/images/pos_logo3.png" width="100" alt="Logo"> <br> -->
                                            <span style="font-size: 3rem;">{{$data['shop']->name}}</span>
                                            <br>{{$data['shop']->location}}
                                                @if($data['shop']->company->tin)
                                            <br>TIN: {{$data['shop']->company->tin}} 
                                                @endif 
                                                @if($data['shop']->company->vrn)
                                            <br>VRN: {{$data['shop']->company->vrn}} 
                                                @endif 
                                            <br><?php echo '+'.Auth::user()->phonecode.' '.Auth::user()->phone; ?></p>
                                        <table>
                                            <thead style="color: #000;font-size: 2.6rem;">
                                                <tr><th>SALE #</th><th>:</th><th class="saleno"></th></tr>
                                                <tr><th>CASHIER</th><th>:</th><th>{{Auth::user()->name}}</th></tr>
                                                <tr class="customer-s-blk"><th>CUSTOMER</th><th>:</th><th class="customer-s-name"></th></tr>
                                            </thead>
                                        </table>
                                        <table style="width: 100%;font-size: 2.6rem;margin-top: 30px;">
                                            <thead>
                                                <tr style="border-bottom: 1px solid #000;">
                                                    <th>ITEM</th><th><div style="text-align: center;">Qty</div></th><th><div align="right">TOTAL</div></th>
                                                </tr>
                                            </thead>
                                            <thead class="render-sales-to-print" style="color: #000;border-bottom: 1px solid #000;font-size: 2.6rem;">
                                                
                                            </thead>
                                        </table>
                                        <div style="width: 100%;margin-top: 15px;margin-bottom: 15px;" align="right">
                                            <table>
                                                <thead style="color: #000;font-size: 2.6rem;">
                                                    <tr><th style="text-align: right;">TOTAL AMOUNT</th><th style="padding-left: 10px;padding-right: 10px;">:</th><th class="total_SP"></th></tr>
                                                    <tr><th style="text-align: right;">PAID AMOUNT</th><th style="padding-left: 10px;">:</th><th class="totalSPA"></th></tr>
                                                    <tr><th style="text-align: right;">CHANGE</th><th style="padding-left: 10px;">:</th><th class="totalCH"></th></tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div style="width: 100%;font-size: 2.3rem;border-top: 1px solid #000;" align="center">Thanks for your purchase!</div>
                                        <div style="width: 100%;font-size: 2.3rem;" align="center"><?php echo date('d M, Y, g:i a'); ?></div>
                                    </div>
                                </div>
                
                            </div>                   
                        </div>   
                        <div class="col-12 pt-2">
                            <button class="btn btn-secondary close-modal"><i class="fa fa-arrow-left pr-2"></i> <?php echo $_GET['cancel']; ?></button>  
                            <button class="btn btn-info ml-2 pr-android" onClick="printReport2();"><i class="fa fa-print pr-2"></i> Print</button>
                            <button class="btn btn-info ml-2 pr-others" onClick="printReport();"><i class="fa fa-print pr-2"></i> Print</button>
                        </div>      
                    </div>
                </div>
            </div>
        </div>
    </div> 


    @include('modals.return-sold-items')    

    
    <!-- Notification Modal -->
    <div class="modal fade" id="monthYearModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:red;opacity:1">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="pb-3">
                    <div class="row">
                        <div class="col-12"> <h3>Chagua Mwezi wa kutoa Ripoti</h3> </div>
                        <div class="col-6 mt-3">
                            <label class="mb-1"><?php echo $_GET["month"]; ?></label>
                            <input name="monthyear" class="monthyear form-control" autocomplete="off" />
                            <br>
                            <button class="btn btn-primary export-sales-report">Toa Ripoti</button>
                        </div>
                    </div>
                </div>            
            </div>
            </div>
        </div>
    </div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
<script type="text/javascript">
    $('.select2').select2();

    var shop_id = $('[name="shopid"]').val();
    var d = new Date();
    var date = d.getDate();
    var month = d.getMonth()+1; 
    var year = d.getFullYear();
    var today = date+"-"+month+"-"+year;

    $(function () {
        // $('.today-summary, .week-summary, .month-summary').html('<i class="fa fa-spinner fa-spin" style="font-size:15px;"></i> Loading...');
        $('.render-oitems,.render-soitems').html("<tr><td colspan='3' align='center'>Loading...</td></tr>");
        $('.returned-block,.returned-block2,.expenses,.deni,.ameweka,.tumelipa').css('display','none');
        $('.top-sr-menu li a').removeClass("active show");

        $('.monthyear').datepicker( {
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            autoclose: true,
            minViewMode: 1,
            format: 'MM - yyyy',
            onClose: function(dateText, inst) { 
                $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
            }
        });

        $('.monthyear').val('<?php echo date("F - Y"); ?>');
        
        var sales_opt = getSearchParams("opt");
        if ($.isEmptyObject(sales_opt)) {
            $('.top-sr-menu li a.sales').addClass("active show").click();
        } else {
            if (sales_opt == "sales") {
                $('.top-sr-menu li a.sales').addClass("active show").click();
            } else if (sales_opt == "sales-p") {
                $('.top-sr-menu li a.sales-p').addClass("active show").click();
            } else if (sales_opt == "top-s-p") {
                $('.top-sr-menu li a.top-s-pr').addClass("active show").click();
            } else {
                $('.top-sr-menu li a.sales').addClass("active show").click();
            }
        }       
        
        if(getOS2() == "Android") {
            $('.pr-android').css('display','');
            $('.pr-others').css('display','none');
        } else {
            $('.pr-android').css('display','none');
            $('.pr-others').css('display','');
        } 
    });

    function getOS2() {
        var uA = navigator.userAgent || navigator.vendor || window.opera;
        if (window.matchMedia("(max-width: 768px)").matches) {
            if ( /Android/i.test(navigator.userAgent) ) { 
                return 'Android'; 
            } else { 
                return 'Other OS'; 
            }
        } else {
            return 'Other OS';
        }        
    }
    
    function printReport() { 
        
        $('#printable_div_id').print(); 

    }
    function printReport2() {      
        
        // working for mobile android
            var divContents = document.getElementById("printed-sale").innerHTML;
            // var a = window.open('', '', 'height=500, width=500');
            var a = window.open('', '', 'Print-Window');
            a.document.write('<html>');
            a.document.write('<body class="p-58mm">');
            a.document.write(divContents);
            a.document.write('</body></html>');
            a.document.close();
            a.print();
    }

    function salesSummary(shop_id) {
        $('.m-sales, .m-quantity, .m-expenses').html('<i class="fa fa-spinner fa-spin" style="font-size:15px;"></i>');
        $.get('/get-data/this-month-sales/'+shop_id, function(data){ 
            $('.m-sales').html(data.data.month_price);
            $('.m-quantity').html(data.data.month_quantity);
            $('.m-expenses').html(data.data.month_expenses);
            
            changeSaleDateReport();

        });
    }
    function changeSaleDateReport() {
        var s_date = $('.date-of-sale').val();
        var opt = $('.sales-view').val();
        
        if(opt == "all-sales") {
            salesByDate(s_date,shop_id);
        } else if(opt == "sales-w-customers") {
            salesByDatewithCustomer(s_date,shop_id);
        } else if(opt == "sales-w-sellers") {
            salesByDatewithSellers(s_date,shop_id);
        } else if(opt == "sales-w-sale-numbers") {
            salesWithSaleNumbers(s_date,shop_id);
        } else if (opt == "sales-w-payment-options") {
            salesWithPaymentOption(s_date,shop_id);
        }
    }

    function expensesSummary(shop_id) {
        $.get('/expenses-summary/shop/'+shop_id, function(data){ 
            $('.todayE').html(data.data.today_expenses);
            $('.weekE').html(data.data.week_expenses);
            $('.monthE').html(data.data.month_expenses);
        });
    }

    $(".search-product22").on("click keyup", function() {
        var name = $(this).val().trim().toLowerCase();
        $('.search-block2').css('display','block');
        $("#search-block2 div").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(name) > -1);
        });
    });
    // $(document).on('click keyup','.search-product22',function(e){
    //     e.preventDefault();
    //     $('.search-block2').css('display','block').html('<div class="sloader m-2"><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i> Searching...</div>');
    //     var name = $(this).val().trim();
    //     var check = $(this).attr('check');
    //     var stoshop = $(this).attr('stoshop');
    //     var shop_id = $('[name="shopid"]').val();
    //     var store_id = $('[name="storeid"]').val();
        
    //     var stoshopid = 0;
    //     if ($.trim(shop_id).length) {
    //         stoshopid = shop_id;
    //     } 

    //     if ($.trim(store_id).length) {
    //         stoshopid = store_id;
    //     }
    //     if (!name.trim()) {
    //         name = 'sdfvaafv';
    //     }
    //     $.get('/search-product/'+stoshop+'/'+check+'/'+stoshopid+'/'+name, function(data) {    
    //         $('.sloader').css('display','none');   
    //         $('.search-block2').html(data.products);
    //     }); 
    // });
    
    // $(".check-g-sales").on('click', function(e) {
    //     e.preventDefault();
    //     $(this).prop('disabled', true).html('Checking..');
    //     // salesWithProfit(shop_id);       
    //     salesWithProfit2(shop_id);       
    // });
    
    $(".check-t-sales").on('click', function(e) {
        e.preventDefault();
        $(this).prop('disabled', true).html('Checking..');
        topSoldProducts(shop_id);      
    });
    
    $('.date-of-sale').datepicker({
        endDate: new Date(),
        autoclose: true,
    }).on('changeDate', function(ev){
        $('.sales-report, .sales-report-2').html("<tr><td colspan='6' align='center'><div class='py-2'><i class='fa fa-spinner fa-spin fa-2x'></i> Loading...</div></td></tr>");
        $('.load-more-s-b').css('display','none');

        changeSaleDateReport();
        
    });

    function salesWithProfit(shop_id) { 
        $('.totalSP,.totalSQ,.profit,.totalEX, .netProfit').html("<i class='fa fa-spinner fa-spin'></i>");
        $('.render-daily-sales').html("<tr><td colspan='6' align='center'><div class='py-2'><i class='fa fa-spinner fa-spin fa-2x'></i> Loading...</div></td></tr>");
        $('.canvas-blk').html('<canvas id="canvas"></canvas>');
        $('.check-g-sales').prop('disabled', true).html('Checking..');
        var fromdate = $('.sp-date .from-date').val();
        var todate = $('.sp-date .to-date').val(); 
        fromdate = fromdate.split('/').join('-');
        todate = todate.split('/').join('-');        

        $.get('/report-by-date-range/sales-with-profit-summary/'+fromdate+'/'+todate+'/'+shop_id, function(data) {
            $('.render-daily-sales').html("");
            $('.sm-report-tbody').css('display','none');
            var totalQ = data.sales[0]['total_qty']; var totalS = data.sales[0]['total_sales']; var totalB = data.sales[0]['total_buying_price'];
            if(totalQ == null) {totalQ = 0;} if(totalS == null) {totalS = 0;} if(totalB == null) {totalB = 0;}
            var profit_s = Number(totalS) - Number(totalB);
            var net_pro = Number(profit_s) - Number(data.totalEX);
            $('.totalSQ').html(Number(totalQ));
            $('.totalSP').html(Number(totalS).toLocaleString("en"));
            $('.profit').html(Number(profit_s).toLocaleString("en"));
            $('.totalEX').html(Number(data.totalEX).toLocaleString("en"));
            $('.netProfit').html(Number(net_pro).toLocaleString("en"));

            var fulldate = fromdate.split('-');
            var a = fulldate[0];
            var b = fulldate[1];   
            var c = fulldate[2];  
            var fulldate2 = todate.split('-');
            var a2 = fulldate2[0];
            var b2 = fulldate2[1];  
            var c2 = fulldate2[2];  
            var fdate = c+'-'+b+'-'+a;
            var tdate = c2+'-'+b2+'-'+a2;
            var original_fdate = fdate;
            
            var start = new Date(fdate);
            var end = new Date(tdate);
            var showmore = "";

            var datediff = (Date.parse(tdate) - Date.parse(fdate)) / 86400000;
            if(datediff > 10) {
                var myDate = new Date(tdate);
                myDate.setDate(myDate.getDate()-9);
                fdate = myDate.getFullYear()+'-'+("0" + (myDate.getMonth() + 1)).slice(-2)+'-'+("0" + (myDate.getDate())).slice(-2);
                var new_tdate = myDate.getFullYear()+'-'+("0" + (myDate.getMonth() + 1)).slice(-2)+'-'+("0" + (myDate.getDate() - 1)).slice(-2);
                start = new Date(fdate);
                showmore = "yes";
            }
            
            var loop = new Date(end);
            var thisdate;
            while(loop >= start){   
                thisdate = ("0" + (loop.getDate())).slice(-2)+'/'+("0" + (loop.getMonth() + 1)).slice(-2)+'/'+loop.getFullYear();
                thisdate2 = loop.getFullYear()+'-'+("0" + (loop.getMonth() + 1)).slice(-2)+'-'+("0" + (loop.getDate())).slice(-2);

                $('.render-daily-sales').append("<tr class='sp-"+thisdate2+"'><td>"+thisdate+"</td>"
                    +"<td class='q'>0</td><td class='s'>0</td>"
                    +"<?php if(Auth::user()->isBusinessOwner()){ ?><td class='p'>0</td><?php } ?>"
                    +"<td class='e'>0</td>"
                    +"<?php if(Auth::user()->isBusinessOwner()){ ?><td class='np'>0</td><?php } ?>"
                    +"<td style='width:50px;'><span class='view-sales' date='"+thisdate2+"'><i class='fa fa-eye'></i></span></td></tr>");
                var newDate = loop.setDate(loop.getDate() - 1);
            }
            
            $.get('/report-by-date-range/sales-with-profit-details/'+fdate+'/'+tdate+'/'+shop_id, function(data) {
                $(".check-g-sales").prop('disabled', false).html('Check');
                for (let i = 0; i < data.sales.length; i++) {
                    var totalQ = data.sales[i]['total_qty']; var totalS = data.sales[i]['total_sales']; var totalB = data.sales[i]['total_buying_price'];
                    if(totalQ == null) {totalQ = 0;} if(totalS == null) {totalS = 0;} if(totalB == null) {totalB = 0;}
                    var profit = Number(totalS) - Number(totalB);
                    var net_pro = profit;
                    $('.sp-'+data.sales[i]['DATE(updated_at)']+' .q').html(Number(totalQ).toLocaleString("en"));
                    $('.sp-'+data.sales[i]['DATE(updated_at)']+' .s').html(Number(totalS).toLocaleString("en"));
                    $('.sp-'+data.sales[i]['DATE(updated_at)']+' .p').html(Number(profit).toLocaleString("en"));
                    $('.sp-'+data.sales[i]['DATE(updated_at)']+' .np').html(Number(net_pro).toLocaleString("en"));
                }
                $.get('/report-by-date-range/daily-expenses/'+fdate+'/'+tdate+'/'+shop_id, function(data) {
                    for (let j = 0; j < data.expenses.length; j++) {
                        var ex = data.expenses[j]['amount'];
                        var profit2 = $('.sp-'+data.expenses[j]['DATE(created_at)']+' .p').text();
                        profit2 = profit2.split(',').join('');
                        var net_pro2 = Number(profit2) - Number(ex);
                        $('.sp-'+data.expenses[j]['DATE(created_at)']+' .e').html(Number(ex).toLocaleString("en"));
                        $('.sp-'+data.expenses[j]['DATE(created_at)']+' .np').html(Number(net_pro2).toLocaleString("en"));
                    }
                    if(showmore == "yes") {
                        $('.sm-report-tbody').css('display','table-row-group');
                        $('.sm-report-tbody button').attr({fdate:original_fdate,tdate:new_tdate});
                    }
                });
                
            //     data.d_dates.reverse();
            //     data.d_sales.reverse();
            //     var bdates = [];
            //     var adates = [];
            //     var bsales = [];
            //     var asales = [];
            //     for (var j = 9; j >= 0; j--) {
            //         bdates[j] = data.d_dates[j];
            //         bsales[j] = parseFloat(data.d_sales[j]);
            //     }
            //     for (var i = data.d_dates.length - 1; i > 9; i--) {
            //         adates[i] = data.d_dates[i];
            //         asales[i] = parseFloat(data.d_sales[i]);
            //     }

            //     var dData = function() {
            //     return Math.round(Math.random() * 90) + 10
            //     };

            //     var barChartData = {
            //     labels: bdates,
            //     datasets: [{
            //         fillColor: "#01b2c6",
            //         strokeColor: "#0066b2",
            //         data: bsales
            //     }]
            //     }

            //     var index = 10;
            //     var ctx = document.getElementById("canvas").getContext("2d");
            //     var barChartDemo = new Chart(ctx).Bar(barChartData, {
            //     responsive: true,
            //     barValueSpacing: 2
            //     });
            //     setInterval(function() {
            //     if (index < data.d_dates.length) {
            //         barChartDemo.removeData();
            //         barChartDemo.addData([asales[index]], adates[index]);
            //     }
            //     index++;
            //     }, 3000);
            });         
        });
    }

    function salesWithProfit2(shop_id) { // this is not used anymore
        $('.totalSP,.totalSQ,.profit,.totalEX, .netProfit').html("<i class='fa fa-spinner fa-spin'></i>");
        $('.canvas-blk').html('<canvas id="canvas"></canvas>'); // block for graph report
        $('.render-daily-sales').html("");
        $('.tb-loader').css("display",'table-row-group');
        $('.sm-report-tbody').css('display','none');

        const months = {
            January: '1',
            February: '2',
            March: '3',
            April: '4',
            May: '5',
            June: '6',
            July: '7',
            August: '8',
            September: '9',
            October: '10',
            November: '11',
            December: '12',
        }

        var monthyear = $('.monthyear').val().split(' ').join('');
        monthyear = monthyear.split('-');
        var month = monthyear[0];
        var year = monthyear[1];  
        month = months[month]; 

        if(month == null || month == "undefined") {
            // popNotification('warning',"Please pick the month from list of months");
        } else {
            var currDate = new Date();
            var date = new Date(year,month); // NOTE: months in JS are counted from 0 = Jan
            var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
            var lastDay = new Date(date.getFullYear(), date.getMonth(), 0);
            var firstDate = firstDay.getDate();
            if (currDate.getMonth() == month-1) { // check if report is for current month
                var lastDate = currDate.getDate();
            } else {
                var lastDate = lastDay.getDate();
            }

            var fromdate = firstDate+"-"+month+"-"+year;
            var todate = lastDate+"-"+month+"-"+year;

            $.get('/report-by-date-range/sales-with-profit-summary/'+fromdate+'/'+todate+'/'+shop_id, function(data) {
                
                var totalQ = data.sales[0]['total_qty']; var totalS = data.sales[0]['total_sales']; var totalB = data.sales[0]['total_buying_price'];
                if(totalQ == null) {totalQ = 0;} if(totalS == null) {totalS = 0;} if(totalB == null) {totalB = 0;}
                var profit_s = Number(totalS) - Number(totalB);
                var net_pro = Number(profit_s) - Number(data.totalEX);
                $('.totalSQ').html(Number(totalQ));
                $('.totalSP').html(Number(totalS).toLocaleString("en"));
                $('.profit').html(Number(profit_s).toLocaleString("en"));
                $('.totalEX').html(Number(data.totalEX).toLocaleString("en"));
                $('.netProfit').html(Number(net_pro).toLocaleString("en"));

                var start = new Date("02/05/2013");
                var end = new Date("02/10/2013");

                $datediff = (Date.parse("2013-02-10") - Date.parse("2013-02-05")) / 86400000;

                var loop = new Date(start);
                while(loop <= end){
                console.log($datediff);           

                var newDate = loop.setDate(loop.getDate() + 1);
                }

                $.get('/report-by-date-range/sales-with-profit-details/'+fromdate+'/'+todate+'/'+shop_id, function(data2) {
                    console.log(data2.sales);

                            // var total_q = data2.sales[0]['total_qty']; var total_s = data2.sales[0]['total_sales']; var total_bp = data2.sales[0]['total_buying_price'];
                            // if(total_q == null){total_q = 0;} if(total_s == null){total_s = 0;} if(total_bp == null){total_bp = 0;}
                            // var profit = Number(total_s) - Number(total_bp);
                            // var net_pro = Number(profit) - Number(data2.expenses);
                            // $('.rowdate'+data2.data.rowdate).append(
                            //     '<td>'+Number(total_q)+'</td>'+
                            //     '<td>'+Number(total_s).toLocaleString("en")+'</td>'+
                            //     '<td>'+profit.toLocaleString("en")+'</td>'+
                            //     '<td>'+Number(data2.expenses).toLocaleString("en")+'</td>'+
                            //     '<td>'+net_pro.toLocaleString("en")+'</td>'+
                            //     '<td style="width:50px;"><span class="view-sales" date="'+data2.data.this_date+'"><i class="fa fa-eye"></i></span></td>');
                            // countRows(lastRow,i,todate);
                        });

                var lastRow = lastDate - 9;
                // $('.tb-loader').css("display",'none');
                // for (let i = lastDate; i >= lastRow; i--) {
                //     if(i < 10) {
                //         i = "0"+i;
                //     }
                //     if(i > 0) {
                //         fromdate = i+"-"+month+"-"+year;
                //         todate = i+"-"+month+"-"+year;
                //         $('.render-daily-sales').append('<tr class="rowdate'+i+'"><td>'+fromdate+'</td></tr>');
                //         $.get('/report-by-date-range/sales-with-profit-details/'+fromdate+'/'+todate+'/'+shop_id, function(data2) {
                //             var total_q = data2.sales[0]['total_qty']; var total_s = data2.sales[0]['total_sales']; var total_bp = data2.sales[0]['total_buying_price'];
                //             if(total_q == null){total_q = 0;} if(total_s == null){total_s = 0;} if(total_bp == null){total_bp = 0;}
                //             var profit = Number(total_s) - Number(total_bp);
                //             var net_pro = Number(profit) - Number(data2.expenses);
                //             $('.rowdate'+data2.data.rowdate).append(
                //                 '<td>'+Number(total_q)+'</td>'+
                //                 '<td>'+Number(total_s).toLocaleString("en")+'</td>'+
                //                 '<td>'+profit.toLocaleString("en")+'</td>'+
                //                 '<td>'+Number(data2.expenses).toLocaleString("en")+'</td>'+
                //                 '<td>'+net_pro.toLocaleString("en")+'</td>'+
                //                 '<td style="width:50px;"><span class="view-sales" date="'+data2.data.this_date+'"><i class="fa fa-eye"></i></span></td>');
                //             countRows(lastRow,i,todate);
                //         });
                //     }
                // }
            });
        }
    }

    function countRows(lastRow,i,date) {
        if (lastRow == i) {
            $('.sm-report-tbody').css('display','table-row-group');
            if(i == "01") {
                $('.sm-report-tbody').css('display','none');
            }
            $('.sm-report-tbody button').attr('date',date);
            return;
        } 
    }
    
    $(document).on('click', '.show-more-report', function(e) {
        e.preventDefault();
        $('.sm-report-tbody').css('display','none');
        var fdate = $(this).attr('fdate');
        var tdate = $(this).attr('tdate');
        var original_fdate = fdate;

        var start = new Date(fdate);
        var end = new Date(tdate);
        var showmore = "";

        var datediff = (Date.parse(tdate) - Date.parse(fdate)) / 86400000;
        if(datediff > 10) {
            var myDate = new Date(tdate);
            myDate.setDate(myDate.getDate()-9);
            fdate = myDate.getFullYear()+'-'+("0" + (myDate.getMonth() + 1)).slice(-2)+'-'+("0" + (myDate.getDate())).slice(-2);
            var new_tdate = myDate.getFullYear()+'-'+("0" + (myDate.getMonth() + 1)).slice(-2)+'-'+("0" + (myDate.getDate() - 1)).slice(-2);
            start = new Date(fdate);
            showmore = "yes";
        }
        
        var loop = new Date(end);
        var thisdate;
        while(loop >= start){   
            thisdate = ("0" + (loop.getDate())).slice(-2)+'/'+("0" + (loop.getMonth() + 1)).slice(-2)+'/'+loop.getFullYear();
            thisdate2 = loop.getFullYear()+'-'+("0" + (loop.getMonth() + 1)).slice(-2)+'-'+("0" + (loop.getDate())).slice(-2);

            $('.render-daily-sales').append("<tr class='sp-"+thisdate2+"'><td>"+thisdate+"</td>"
                +"<td class='q'>0</td><td class='s'>0</td>"
                +"<?php if(Auth::user()->isBusinessOwner()){ ?><td class='p'>0</td><?php } ?>"
                +"<td class='e'>0</td>"
                +"<?php if(Auth::user()->isBusinessOwner()){ ?><td class='np'>0</td><?php } ?>"
                +"<td style='width:50px;'><span class='view-sales' date='"+thisdate2+"'><i class='fa fa-eye'></i></span></td></tr>");
            var newDate = loop.setDate(loop.getDate() - 1);
        }
        
        $.get('/report-by-date-range/sales-with-profit-details/'+fdate+'/'+tdate+'/'+shop_id, function(data) {
                $(".check-g-sales").prop('disabled', false).html('Check');
                for (let i = 0; i < data.sales.length; i++) {
                    var totalQ = data.sales[i]['total_qty']; var totalS = data.sales[i]['total_sales']; var totalB = data.sales[i]['total_buying_price'];
                    if(totalQ == null) {totalQ = 0;} if(totalS == null) {totalS = 0;} if(totalB == null) {totalB = 0;}
                    var profit = Number(totalS) - Number(totalB);
                    var net_pro = profit;
                    $('.sp-'+data.sales[i]['DATE(updated_at)']+' .q').html(Number(totalQ).toLocaleString("en"));
                    $('.sp-'+data.sales[i]['DATE(updated_at)']+' .s').html(Number(totalS).toLocaleString("en"));
                    $('.sp-'+data.sales[i]['DATE(updated_at)']+' .p').html(profit.toLocaleString("en"));
                    $('.sp-'+data.sales[i]['DATE(updated_at)']+' .np').html(net_pro.toLocaleString("en"));
                }
                $.get('/report-by-date-range/daily-expenses/'+fdate+'/'+tdate+'/'+shop_id, function(data) {
                    for (let j = 0; j < data.expenses.length; j++) {
                        var ex = data.expenses[j]['amount'];
                        var profit2 = $('.sp-'+data.expenses[j]['DATE(created_at)']+' .p').text();
                        profit2 = profit2.split(',').join('');
                        var net_pro2 = Number(profit2) - Number(ex);
                        $('.sp-'+data.expenses[j]['DATE(created_at)']+' .e').html(Number(ex).toLocaleString("en"));
                        $('.sp-'+data.expenses[j]['DATE(created_at)']+' .np').html(net_pro2.toLocaleString("en"));
                    }
                    if(showmore == "yes") {
                        $('.sm-report-tbody').css('display','table-row-group');
                        $('.sm-report-tbody button').attr({fdate:original_fdate,tdate:new_tdate});
                    }
                });               
            });         

        // var fulldate = fromdate.split('-');
        // var lastDate = fulldate[0];
        // lastDate = lastDate - 1;
        // var month = fulldate[1];
        // var year = fulldate[2];  
        // var lastRow = lastDate - 9;
        // for (let i = lastDate; i >= lastRow; i--) {
        //     if(i < 10) {
        //         i = "0"+i;
        //     }
        //     if(i > 0) {
        //         fromdate = i+"-"+month+"-"+year;
        //         todate = i+"-"+month+"-"+year;
        //         $('.render-daily-sales').append('<tr class="rowdate'+i+'"><td>'+fromdate+'</td></tr>');
        //         $.get('/report-by-date-range/sales-with-profit-details-2/'+fromdate+'/'+todate+'/'+shop_id, function(data) {
        //             var total_q = data.sales[0]['total_qty']; var total_s = data.sales[0]['total_sales']; var total_bp = data.sales[0]['total_buying_price'];
        //             if(total_q == null){total_q = 0;} if(total_s == null){total_s = 0;} if(total_bp == null){total_bp = 0;}
        //             var profit = Number(total_s) - Number(total_bp);
        //             var net_pro = Number(profit) - Number(data.expenses);
        //             $('.rowdate'+data.data.rowdate).append(
        //                 '<td>'+Number(total_q)+'</td>'+
        //                 '<td>'+Number(total_s).toLocaleString("en")+'</td>'+
        //                 '<td>'+profit.toLocaleString("en")+'</td>'+
        //                 '<td>'+Number(data.expenses).toLocaleString("en")+'</td>'+
        //                 '<td>'+net_pro.toLocaleString("en")+'</td>'+
        //                 '<td style="width:50px;"><span class="view-sales" date="'+data.data.this_date+'"><i class="fa fa-eye"></i></span></td>');
        //             countRows(lastRow,i,todate);
        //         });
        //     }
        // }
    });

    function topSoldProducts(shop_id) {
        var business_owner = "<?php echo $is_BO; ?>";
        var fromdate = $('.ts-date .from-date4').val();
        var todate = $('.ts-date .to-date4').val();
        fromdate = fromdate.split('/').join('-');
        todate = todate.split('/').join('-');
        $('.check-t-sales').prop('disabled', true).html('Checking..');
        $('.tsales-report').html("<tr><td colspan='4' align='center'><i class='fa fa-spinner fa-spin fa-2x'></i> Loading...</td></tr>");
        $.get('/report-by-date-range/top-sale/'+fromdate+'/'+todate+'/'+shop_id, function(data) {  
            $(".check-t-sales").prop('disabled', false).html('Check');
            $('.tsales-report').html("");

            var profit = 0;
            var arr = data.sales;
            arr.sort(function(a, b){
                return b['sumQ'] - a['sumQ']; // sort quatity in descending
            });

            for (let i = 0; i < arr.length; i++) {
                profit = Number(arr[i]['sumP']) - Number(arr[i]['sumB']);
                if (business_owner == "no") {
                    profit = "";
                }
                $('.tsales-report').append('<tr><td>'+arr[i]['pname']+'</td><td>'+Number(arr[i]['sumQ'])+'</td><td>'+Number(arr[i]['sumP']).toLocaleString("en")+'</td><td>'+profit.toLocaleString("en")+'</td></tr>');
            }
        });
    }

    $(document).on('click', '.view-sales', function(e) {
        e.preventDefault();
        var date = $(this).attr('date');
        var fromdate = date;
        var todate = date; 
        $('.vs_totalSQ,.vs_totalSP,.vs_totalEX,.vs_profit,.vs_netProfit').html('--');
        // format date and time
        var formattedDate = new Date(date);
        var d = formattedDate.getDate();
        var m =  formattedDate.getMonth();
        m += 1;  // JavaScript months are 0-11
        var y = formattedDate.getFullYear();
        $(".vs_date").html(d + "/" + m + "/" + y);

        $('#salesModal').modal('toggle');
        $('.render-view-sales, .closure-sale').html("<tr><td colspan='5'>Loading...</td></tr>");
        $.get('/report-by-date-range/sales/'+fromdate+'/'+todate+'/'+shop_id, function(data) {
            var net_pro = Math.floor(data.profit) - Math.floor(data.data.sum.replace(/,/g, ''));
            $('.render-view-sales').html(data.items);
            $('.vs_totalSQ').html(data.totalSQ);
            $('.vs_totalSP').html(Number(data.totalSP).toLocaleString("en"));
            $('.vs_profit').html(Number(data.profit).toLocaleString("en"));
            $('.vs_totalEX').html(data.data.sum);
            $('.vs_netProfit').html(Number(net_pro).toLocaleString("en"));

            closureNote(shop_id+"~"+fromdate+"~"+todate);
        });
    });

    $(document).on('click', '.view-deni', function(e){
        e.preventDefault();
        $('#madeniModal').modal('toggle');
        $('.madeni-list').html("<tr><td colspan='4'>Loading...</td></tr>");
        var date = $(this).attr('date');
        $.get('/report-by-date-range/debts/'+date+'/'+date+'/'+shop_id, function(data){ 
            if (data.error) {
                popNotification('warning',data.error);
                return;
            }          
            $('.madeni-list').html(data.items).promise().done(function() {
                $('.madeni-list').append("<tr><td></td><td></td><th>Total</th><th class='totaldd'>"+data.totald+"</th></tr>");
                if (date != today) {
                    $('.madeni-list tr td input').attr('disabled',true);
                    $('.madeni-list tr td button').css('display','none');
                }
            });       
        });
        $.get('/report-by-date-range/kopesha/'+date+'/'+date+'/'+shop_id, function(data){ 
            if (data.error) {
                popNotification('warning',data.error);
                return;
            }          
            $('.kopesha-cash-list').html(data.items).promise().done(function() {
                $('.kopesha-cash-list').append("<tr><th>Total</th><th class='totaldd'>"+data.totald+"</th></tr>");
                if (date != today) {
                    $('.kopesha-cash-list tr td input').attr('disabled',true);
                    $('.kopesha-cash-list tr td button').css('display','none');
                }
            });       
        });
    });

    $(".view-expenses").on('click', function(e) { // expe from sales and profits
        e.preventDefault();
        $('#expensesModal2').modal('toggle');
        $('.expenses-report2').html("<tr><td colspan='5'>Loading...</td></tr>");
        
        const months = {
            January: '1',
            February: '2',
            March: '3',
            April: '4',
            May: '5',
            June: '6',
            July: '7',
            August: '8',
            September: '9',
            October: '10',
            November: '11',
            December: '12',
        }

        var fromdate = $('.sp-date .from-date').val();
        var todate = $('.sp-date .to-date').val();
        fromdate = fromdate.split('/').join('-');
        todate = todate.split('/').join('-');        

        // var monthyear = $('.monthyear').val().split(' ').join('');
        // monthyear = monthyear.split('-');
        // var month = monthyear[0];
        // var year = monthyear[1];  
        // month = months[month]; 
        
        // var date = new Date(year,month); // NOTE: months in JS are counted from 0 = Jan
        // var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        // var lastDay = new Date(date.getFullYear(), date.getMonth(), 0);
        // var firstDate = firstDay.getDate();
        // var lastDate = lastDay.getDate();

        // var fromdate = firstDate+"-"+month+"-"+year;
        // var todate = lastDate+"-"+month+"-"+year;

          $.get('/report-by-date-range/expenses/'+fromdate+'/'+todate+'/'+shop_id, function(data) {
            $('.expenses-report2').html(data.view);            
          });
    });
    $(document).on('click', '.view-expenses-2', function(e){ //expe from sales
        e.preventDefault();
        $('#expensesModal').modal('toggle');
        $('.expenses-report').html("<tr><td colspan='5'>Loading...</td></tr>");
        var date = $(this).attr('date');
        $.get('/report-by-date-range/expenses-2/'+date+'/'+date+'/'+shop_id, function(data){ 
            $('.expenses-report').html(data.output);  
        });
    });

    $(document).on('click', '.view-tumelipa', function(e){
        e.preventDefault();
        $('#tumelipaModal').modal('toggle');
        $('.tumelipa-list').html("<tr><td colspan='3'>Loading...</td></tr>");
        var date = $(this).attr('date');
        $.get('/report-by-date-range/cash-out/'+date+'/'+date+'/'+shop_id, function(data){ 
            if (data.error) {
                popNotification('warning',data.error);
                return;
            }          
            $('.tumelipa-list').html(data.items).promise().done(function() {
                $('.tumelipa-list').append("<tr><th>Total</th><th class='totaldd'>"+data.totald+"</th></tr>");
                if (date != today) {
                    $('.tumelipa-list tr td input').attr('disabled',true);
                    $('.tumelipa-list tr td button').css('display','none');
                }
            });       
        });
    });

    $(document).on('click', '.view-ameweka', function(e){
        e.preventDefault();
        $('#amewekaModal').modal('toggle');
        $('.ameweka-list').html("<tr><td colspan='4'>Loading...</td></tr>");
        $('.ameweka-cash-list').html("<tr><td colspan='2'>Loading...</td></tr>");
        var date = $(this).attr('date');
        $.get('/report-by-date-range/ongezeko/'+date+'/'+date+'/'+shop_id, function(data){ 
            if (data.error) {
                popNotification('warning',data.error);
                return;
            }          
            $('.ameweka-list').html(data.items).promise().done(function() {
                $('.ameweka-list').append("<tr><td></td><td></td><th>Total</th><th class='totaldd'>"+data.totald+"</th></tr>");
                if (date != today) {
                    $('.ameweka-list tr td input').attr('disabled',true);
                    $('.ameweka-list tr td button').css('display','none');
                }
            });       
        });
        $.get('/report-by-date-range/ameweka/'+date+'/'+date+'/'+shop_id, function(data){ 
            if (data.error) {
                popNotification('warning',data.error);
                return;
            }          
            $('.ameweka-cash-list').html(data.items).promise().done(function() {
                $('.ameweka-cash-list').append("<tr><th>Total</th><th class='totaldd'>"+data.totald+"</th></tr>");
                if (date != today) {
                    $('.ameweka-cash-list tr td input').attr('disabled',true);
                    $('.ameweka-cash-list tr td button').css('display','none');
                }
            });       
        });
    });

    $(document).on('click', '.paida-b', function(e){
        e.preventDefault();
        var id = $(this).attr('rid');
        var amount = $('.paida-'+id).attr('amount');
        var new_amount = $(".paida-"+id).val();
        if (amount == new_amount) {
            popNotification('success',"The amount is updated successfully.");
            return;
        }
        $(this).html('Updating..');$('.paida-b').prop('disabled', true);
        $.get('/update-quantity/debt/'+id+'/'+new_amount, function(data){
            $('.paida-b').html('Update').prop('disabled', false);
            if (data.error) {
                popNotification('warning',data.error);
                return;
            }            
            var totald = $('.totaldd').text().split(",").join("");
            var newd = (parseFloat(totald) - parseFloat(data.data.old_debt) ) + parseFloat(data.data.new_debt);
            $('.debta-'+data.data.id).html(Number(data.data.new_debt).toLocaleString("en"));
            $('.totaldd').html(Number(newd).toLocaleString("en"));     
            $('.paida-'+data.data.id).attr("amount",data.data.new_paid);
            popNotification('success',"The amount is updated successfully.");
            
            salesSummary(shop_id);
        });
    });

    function closureNote(date){
        date = shop_id+"~"+date;
        // $.get('/report/closure-sale/'+date, function(data){ 
        //     $('.closure-sale-2').html(data.items);
        // });
    }

    function pendingReturnedItems(shop_id) {        
        $.get('/return-sold-items/pending/'+shop_id, function(data) {
            $('.returned-items').html("");
            $('.returned-items').html(data.items);
            $('.totalQr').html(data.totalQr);
        });
    }

    $(document).on('keyup', '.rquantity', function(e){
        e.preventDefault();
        var id = $(this).attr('rid');
        var qty = $(this).val();
        $.get('/update-quantity/returned-item/'+id+'/'+qty, function(data){
            if (data.error) {
                popNotification('warning',data.error);
                return;
            }            
            $('.totalQr').html(parseFloat(data.data.quantity));         
        });
    });

    $(document).on('click', '.remove-ri', function(e){
        e.preventDefault();
        var id = $(this).attr('val');
        $.get('/remove-row/returned-item/'+id, function(data){
            if (data.error) {
                popNotification('warning',data.error);
            }
            if (data.success) {
                $('.ri-'+data.id).closest("tr").remove();
                $('.totalQr').html(parseFloat(data.data.quantity));
            }            
        });
    });



</script>