 
@include("layouts.translater") 

<?php  
    $hideblock = 'hideblock';
 ?>
<style>
    .inside-s-c .col-sm-3 {padding-left: 0px;padding-right: 0px;}
    .inside-s-c .col-sm-3 div {width: inherit;}
    .inside-s-c .col-sm-3 span {display: block;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;width: 95%;}
    .orders-tab span {background-color: rgb(249, 79, 21);position: absolute; padding: 2px;width: 6px;height: 6px;border-radius: 4px;display: none;animation: blinking 1s linear infinite;}

    .sale-preview, .sale-loader, .sale-receipt {display: none;}
    .s-preview-loader {position: absolute;width: 95%;height: 100%;background-color: #000;z-index: 99;opacity: 0.5;}

    .print-sale .head {text-align: center;font-size: 1rem;font-weight: bolder;}
    .print-sale .left-d {text-align: left;margin-top: 10px;margin-bottom: 15px;}
    .print-sale .left-d .f {padding-right: 5px;}

    @media screen and (max-width: 480px) {
        .small-screen {padding-left: 5px !important;padding-right: 5px !important;}
        .tsales-summary-blc {margin-top: -30px !important;}
        .tsales-summary-blc .tsales-summary {padding-top: 40px;}
    }

    /* after clicking print bnt  */    
    body.printingContent > *{
        display: none;  /* hide everything in body when in print mode*/
    }

    body.printingContent .printContainer {
        display: block !important; /* Override the rule above to only show the printables*/
        position: fixed;
        z-index: 9999999999999;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    } 
    /* end printing css  */

    .displaynone {display: none;}
</style>

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 sales-outer-block">
            <div class="card" style="box-shadow: none;margin-bottom: 0px;">    
                <div class="body shop-body-card pb-0">
                    <!-- <form id="basic-form" class="transfer-form">
                        @csrf -->
                        <input type="hidden" name="from" value="shop">
                        <input type="hidden" name="shopid" value="{{$data['shop']->id}}">
                        <input type="hidden" name="transferno" value="null">
                        <input type="hidden" name="transferval" value="">
                        <div class="row clearfix">
                            <div class="col-md-8 col-12 sales-b-c-f">
                                <!-- <span class="btn btn-primary btn-sm" data-toggle="modal" data-target="#cats-to-sale" style="width:100%"><?php echo $_GET['sale-by-category']; ?></span> -->

                                <div class="mb-2 sale-by-cat">
                                    <!-- <div class="sale-opt-out" style="display:none">
                                        <div class="sale-opt">
                                            <span class="badge badge-info" check="category"><?php echo $_GET['sale-by-category']; ?> <i class="fa fa-angle-down"></i></span>
                                            <div class="sale-drop">   
                                                <div class="switch-sale-opt" check="search">
                                                    <?php echo $_GET['sale-by-search']; ?>
                                                </div>
                                            </div>       
                                        </div> 
                                    </div> -->

                                    <div class="mb-2 mt-0 sale-search-block" style="display:block;">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm search-product2 border-right-0" check="sales" stoshop="shop" placeholder="<?php echo $_GET['pick-products-to-sell']; ?>" name="pname" autocomplete="off"> 
                                            <span class="input-group-append bg-white border-left-0">
                                                <span class="input-group-text bg-transparent" style="border-left: none;">
                                                    <i class="fa fa-search"></i>
                                                </span>
                                            </span>

                                            <div class="search-block-outer">
                                                <div class="search-block" id="search-block">
                                                    
                                                </div>
                                            </div>                                   

                                        </div>
                                            
                                        @if($data['shop']->products->isEmpty()) 
                                            <div class="px-2">
                                                <span style="color:red">Hauwezi kuuza bidhaa kama duka halina bidhaa.. Kama umeshatengeneza bidhaa hakikisha bidhaa zako umezipa idadi.</span>
                                                <!-- <i class="fa fa-hand-o-right"></i> <a href="#" data-toggle='modal' data-target='#howCreateProduct'>Soma zaidi</a> <i class="fa fa-hand-o-left"></i> -->
                                            </div>
                                        @endif

                                    </div>

                                    <div class="cats-block">
                                        <div class="cats-hor">
                                            <div class="cats-h">
                                                <div class="cats-list pl-2">
                                                    <div class="cat-h cats recent-cat" value="0"><button class="btn btn-outline-info btn-sm">All</button></div>
                                                    <!-- render other cats  -->
                                                </div>
                                                <div class="cat-scroll">
                                                    <i class="fa fa-angle-double-right"></i>
                                                </div>
                                                <div class="other-cats">
                                                    <div class="cat-h cats" value="0"><button class="btn btn-outline-info btn-sm">All</button></div>
                                                    <!-- render other cats  -->
                                                </div>
                                            </div>
                                        </div>
                                        <span class="c-title pl-2" style="font-size:12px">All</span>
                                        <div class="row inside-s-c">
                                            <!-- render products by cat -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-12 px-0 scroll-to-c" style="padding-bottom:30px">
                                <div>
                                    <span class="btn btn-secondary btn-sm pull-right attach-customer" data-toggle="modal" data-target="#attachCustomer"><i class="fa fa-plus"></i> <?php echo $_GET['attach-customer']; ?></span>
                                    <input type='hidden' name='customer' value='null'>
                                </div>                                  
                                <div class="render-attached-customer">
                                    
                                </div>

                                <!-- <div class="form-group">
                                    <label style="margin-bottom: 1px;"><?php echo $_GET['search-product']; ?></label>
                                    <input type="text" class="form-control form-control-sm search-product2" check="sales" stoshop="shop" placeholder="Search" name="pname" autocomplete="off"> 
                                    <div class="search-block-outer">
                                        <div class="search-block" id="search-block">
                                            
                                        </div>
                                    </div>                                                
                                </div> -->

                                <div class="table-responsive">                   
                                    <table class="table table-borderless m-b-0 c_list mt-1">
                                        <thead class="thead-light">
                                            <tr>
                                                <th><?php echo $_GET['items-to-sale']; ?></th> 
                                            </tr>
                                        </thead>
                                        <tbody class="<?php if($data['shop']->checkSaleBackDate()) { echo ''; $bdays = $data['shop']->checkSaleBackDate()->sale_days_back; } else { echo 'displaynone'; $bdays = 0; } ?>">
                                            <tr>
                                                <td>
                                                    <input type="text" data-provide="datepicker" data-date-autoclose="true" class="form-control sale-date form-control-sm" value="<?php echo date('d/m/Y'); ?>">
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody class="items-in-cart sold-products2" id="cart-selected">
                                            
                                        </tbody>
                                        <tbody class="total-row">
                                            <tr>
                                                <td>
                                                    <div class="row" style="margin:0px">
                                                        <div class="col-2" style="padding-top: 10px;"><?php echo $_GET['total']; ?></div>
                                                        <div class="col-10">
                                                            <div>
                                                                <span style="padding-right: 3px;font-weight: 100;">
                                                                    <?php echo $_GET['quantity-full']; ?>
                                                                </span>:<span class="pl-1 totalQ" style="font-size: 1rem;"></span>
                                                            </div>
                                                            <div>
                                                                <span  style="padding-right: 8px;font-weight: 100;"><?php echo $_GET['amount']; ?></span>:<span class="pl-1 totalP" style="font-size: 1rem;"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="mt-2" style="border-bottom: 1px solid #ddd;"></div>
                                    <div class="mt-3 sale-btns" align="right">
                                        <i class="fa fa-spinner fa-spin" style="font-size:20px;display: none;"></i> 
                                        
                                        @if($data['shop']->is_cashier(Auth::user()->id))
                                        <button class="btn btn-success submit-sale-cart px-4"><?php echo $_GET['sell']; ?></button>
                                        <?php $order_btn = $_GET['save-order']; ?>
                                        @else 
                                        <?php $order_btn = $_GET['submit-order']; ?>
                                        @endif

                                        <?php if($data['shop']->sell_order == 'yes') { ?>
                                            <button class="btn btn-info submit-order-cart"><?php echo $order_btn; ?></button>
                                        <?php } ?>
                                        <button class="btn btn-danger clear-sale-cart"><?php echo $_GET['clear-cart']; ?></button>
                                        
                                    </div>
                                </div>
                            </div>
                    
                        </div>
                        <!-- <div class="row clearfix">
                            <div class="col-sm-6 offset-sm-6 px-0 sales-block">
                            </div>
                        </div> -->
                    <!-- </form> -->
                </div>                            
            </div>
        </div>

        @if($data['shop']->is_cashier(Auth::user()->id) || $data['shop']->is_saleperson(Auth::user()->id))
        <!-- today sales & orders  -->
        <div class="col-lg-12 col-md-12 col-12 mb-4 reduce-padding">
            <div class="card">
                <div class="accordion px-2" id="accordion" style="margin-top: 60px;padding-bottom: 50px;">
                    <div class="">
                        @if($data['shop']->is_cashier(Auth::user()->id))
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed td-sales-tab" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    <i class="fa fa-line-chart" style="float: left;margin-top: 10px;"></i>
                                    <div style="float: left;font-weight: bold;padding-top: 5px;padding-left: 10px;"> <?php echo $_GET['today-sales']; ?> - <span class="td-sales">0</span></div> 
                                    <i class="fa fa-angle-down fa-2x" style="float: right;"></i>
                                </button>
                            </h5>
                        </div>                         
                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" style="border: 2px solid #eee;">
                            <div class="card-body" style="padding-bottom: 20px;padding-top: 10px;">                                          
                                <div class="row mt-3">
                                    <div class="col-5" style="background:#cce5ff">
                                        <!-- <div class="icon text-success"><i class="fa fa-dollar"></i> </div> -->
                                        <div>
                                            <div class="text"><?php echo $_GET['total-sales']; ?></div>
                                            <h5 class="number"><b class="totalSP">--</b></h5>
                                        </div>
                                    </div>
                                    <div class="col-3 xl-parpl">
                                        <!-- <div class="icon text-success"><i class="fa fa-shopping-cart"></i> </div> -->
                                        <div>
                                            <div class="text"><?php echo $_GET['quantity']; ?></div>
                                            <h5 class="number"><b class="totalSQ">--</b></h5>
                                        </div>
                                    </div>
                                    @if(Auth::user()->isBusinessOwner())
                                    <div class="col-4 xl-khaki">
                                        <!-- <div class="icon text-info"><i class="fa fa-ellipsis-v"></i> </div> -->
                                        <div>
                                            <div class="text"><?php echo $_GET['profit']; ?></div>
                                            <h5 class="number"><b class="totalPro">--</b></h5>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="row mt-3 mb-3">
                                    <div class="col-md-8">
                                        <div class="table-responsive">
                                            <table class="table table-borderless m-b-0 c_list" style="background-color: #efebf4;">
                                                <tbody class="sales-report sold-products22">
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="mt-5 see-more-sales">
                                            <button class="btn btn-info btn-sm show-more-sales" style="width:150px"><?php echo $_GET['see-more-sales']; ?> <i class="fa fa-arrow-right pl-2"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                              
                        @endif 
                    </div>
                    <div class="">
                        <?php if($data['shop']->sell_order == 'yes') { ?>
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed orders-tab" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <i class="fa fa-shopping-cart" style="float: left;margin-top: 10px;"></i>
                                    <div style="float: left;font-weight: bold;padding-top: 5px;padding-left: 10px;"> Orders</div> 
                                    <i class="fa fa-angle-down fa-2x" style="float: right;"></i>
                                </button>
                            </h5>
                        </div>                                
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" style="border: 2px solid #eee;">
                            <div class="card-body" style="padding-bottom: 10px;padding-top: 10px;">            
                                <div class="render-orders">

                                </div>    
                                <div> 
                                    <!-- <br>
                                    <b>Duka</b> Lina kazi kubwa mbili. <br>
                                    1. Kuhifadhia bidhaa zako <br>
                                    2. Kuuza bidhaa <br><br>
                                    Mfumo wa Levanda POS utakusaidia kufanya mambo yafuatayo yatayokusaidia kuendesha biashara yako kidijitali:<br><br> 
                                    1. Unaweza kuona bidhaa zote zilizopo dukani kwako na idadi zake. <br>
                                    2. Unaweza kuongeza stock mpya na kupata taarifa za stock zote za nyuma ulizoziongeza dukani. <br>
                                    3. Unaweza kuuza bidhaa na kuona mauzo yako yote ya siku za nyuma (Ripoti za mauzo). <br>
                                    4. Unaweza kusajili wateja wako na kutunza kumnbukumbu za mambo muhim yanayowahusu wateja wako, kama: bidhaa walizowahi kununua kwako, madeni unayowadai/wanayokudai, marejesho ya pesa yaliyolipwa n.k <br>
                                    5. Kama unamiliki duka zaidi ya moja au unamiliki stoo, unaweza ukahamisha (Transer) bidhaa zako kutoka sehem moja kwenda ingine. <br>
                                    6. Unaweza kurekodi matumizi yako ya kila siku ya dukani. <br><br> -->
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div> 
            </div>
        </div>  
        @endif
    </div>


    <!-- sell products -->
    <div class="modal fade" id="saleModal" tabindex="-1" role="dialog" aria-labelledby="saleModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="col-12 mt-3">
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                        <button class="btn btn-danger btn-sm">x</button>
                    </span>
                </div>
                <div class="modal-body align-center mb-4">
                    <div class="sale-preview s">  <!-- dont remove s, helps to remove duplication on risiti -->
                        <div class="s-preview-loader"></div>
                        <p class="scustomer"><span><?php echo $_GET['customer']; ?>: </span> <b class="customername" style="font-size: 1rem;"></b></p>
                        <h6><?php echo $_GET['total-amount']; ?></h6>
                        <h4 class="amounttopay"></h4>

                        <div class="scustomer">
                            <div class="col-12 mt-5" align="center">
                                <div class="form-group" style="display: inline-block;">
                                    <small><?php echo $_GET['paid-amount']; ?></small>
                                    <input type="number" name="paidamount" class="form-control s-paidamount" value="0" style="font-size: 18px;width: 120px;text-align: center;">
                                </div>
                                <!-- <div class="spacer mx-2" style="display: inline-block;"></div> -->
                                <div class="change-blc" align="left" style="display: inline-block;display: none;">
                                    <label>Change</label>
                                    <h5 class="s-change">0</h5>
                                </div>
                            </div>
                        </div>      

                        <div class="col-12 pt-4" align="center">
                            <div class="label"><?php echo $_GET['payment-method']; ?></div>
                            <select class="form-control" name="payment-method" style="width: 130px;">
                                <option value="1">Cash</option>
                                <option value="2">Mobile Money</option>
                                <option value="3">Bank</option>
                            </select>
                        </div>

                        <div class="col-12 mt-5">
                            <button type="button" class="btn btn-success px-3 submit-sale-cart2" style="font-size:1.2rem"><b><?php echo $_GET['sell']; ?> <i class="fa fa-check pl-2"></i></b> </button>
                        </div>
                    </div>
                    <div class="sale-loader" style="display: none;">
                        <div class="my-5">
                            <i class="fa fa-spinner fa-spin fa-2x"></i> 
                        </div>
                        <div class="prepare-receipt" style="display: none;">
                            Prepare Receipt..
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
                                                    <tr class="customer-s-blk"><th class="f">CUSTOMER</th><th>:</th><th class="customer-s-name customername"></th></tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div>
                                            <!-- <div style="border-bottom: 1px solid #000;font-size: 1rem;font-weight: bolder;" align="left">
                                                ITEMS
                                            </div>                                             -->
                                            <table class="table table-borderless m-b-0 c_list" style="width: 100%;border-bottom: 1px solid #000;margin-bottom: 15px;color: #000;">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>ITEM</th><th><div  align="center">Qty</div> </th><th><div align="right">TOTAL</div></th>
                                                    </tr>
                                                </thead>
                                                <thead class="thead-light">
                                                    
                                                </thead>
                                                <tbody class="render-sales-to-print" style="font-size: 1rem;">
                                                    
                                                </tbody>
                                            </table>
                                            <div align="right">
                                                <table class="dd">
                                                    <thead>
                                                        <tr><th class="f">TOTAL AMOUNT</th><th>:</th><th><span class="total_SP"></span></th></tr>
                                                        <tr><th class="f">PAID AMOUNT</th><th>:</th><th><span class="totalSPA"></span></th></tr>
                                                        <!-- <tr><th class="f">CHANGE</th><th>:</th><th><span class="totalCH"></span></th></tr> -->
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
                                                <div class="customer-s-blk">CUSTOMER: <span class="customer-s-name customername"></span></div>
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
                                                <table style="width: 100%;border-bottom: 1px solid #000;border-top: 1px solid #000;font-size: 10px;" align="right" class="ddd">
                                                    <tbody>
                                                        <tr>
                                                            <th style="text-align: right;">TOTAL AMOUNT</th><th>:</th><th class="total_SP" align="left"></th>
                                                        </tr>
                                                        <tr class="pa-tr"><th style="text-align: right;">PAID AMOUNT</th><th>:</th><th class="totalSPA" align="left"></th></tr>
                                                        <!-- <tr class="ch-tr"><th style="text-align: right;">CHANGE</th><th>:</th><th class="totalCH" align="left"></th></tr> -->
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
                                                <tr class="customer-s-blk"><th>CUSTOMER</th><th>:</th><th class="customer-s-name customername"></th></tr>
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
                                            <table class="dddd">
                                                <thead style="color: #000;font-size: 2.6rem;">
                                                    <tr><th style="text-align: right;">TOTAL AMOUNT</th><th style="padding-left: 10px;padding-right: 10px;">:</th><th class="total_SP"></th></tr>
                                                    <tr><th style="text-align: right;">PAID AMOUNT</th><th style="padding-left: 10px;">:</th><th class="totalSPA"></th></tr>
                                                    <!-- <tr><th style="text-align: right;">CHANGE</th><th style="padding-left: 10px;">:</th><th class="totalCH"></th></tr> -->
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
                            <button class="btn btn-secondary close-modal"><i class="fa fa-arrow-left pr-2"></i> <?php echo $_GET['back-to-sell']; ?></button>  
                            <button class="btn btn-info ml-2 pr-android" onClick="printReport2();"><i class="fa fa-print pr-2"></i> Print</button>
                            <button class="btn btn-info ml-2 pr-others" onClick="printReport();"><i class="fa fa-print pr-2"></i> Print</button>
                        </div>      
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <!-- attach customer modal -->
    <div class="modal fade" id="attachCustomer" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h5" id="cust-m-title"><?php echo $_GET['attach-customer']; ?></h5>
                    
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9;">
                        <button class="btn btn-danger btn-sm">x</button>
                    </span>
                   
                </div>
                <div class="modal-body mb-4">
                    <div class="form-group sell-customer">
                        <label style="margin-bottom: 1px;"><?php echo $_GET['select-customer']; ?></label>
                        <span class="ml-2 text-info tool-tip" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $_GET['select-customer-info']; ?>"><i class="icon-info"></i></span><br>
                        <select class="form-control customer select2" name="customer" placeholder="Search" style="width: 300px;">
                            <option value="" selected>- select -</option>
                            <!-- render customers  -->
                        </select>
                    </div>
                    <div class="mt-5"><?php echo $_GET['new-customer']; ?> ? <a href="#" class="show-new-customer-blc"><?php echo $_GET['click-here']; ?></a></div>

                    <div class="mt-4 p-2 new-customer-blc" style="background: #f0f0f0;margin-left: -10px;margin-right: -10px;">          
                        <h5 style="margin-bottom: 15px;"><b style="text-decoration: underline;"><?php echo $_GET['create-new-customer']; ?>:</b></h5>           
                        <form id="basic-form" class="new-customer-form-2">
                            @csrf
                            <input type="hidden" name="shopid" value="{{$data['shop']->id}}"> 
                            <div class="row clearfix">
                                <div class="col-sm-7 col-8">
                                    <div class="form-group">
                                        <label class="mb-0"><?php echo $_GET['full-name']; ?></label>
                                        <input type="text" class="form-control" placeholder="Full Name" name="name" required>
                                    </div>
                                </div>
                                <div class="col-sm-5 col-4" style="display: none;">
                                    <div class="form-group">
                                        <label class="mb-0">Gender</label>
                                        <select class="form-control show-tick" name="gender" required>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="mb-0"><?php echo $_GET['phone-number']; ?></label>
                                        <input type="text" class="form-control" placeholder="Phone" name="phone" required>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="mb-0"><?php echo $_GET['address']; ?></label>
                                        <input type="text" class="form-control" placeholder="Anapopatikana" name="location" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <button class="btn btn-primary submit-new-customer" style="width: inherit;">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


<script type="text/javascript">
    $('.select2').select2();
    $('.sell-t').css('background','#dcf5ef');$('.order-t').css('background','');

    var shop_id = $('[name="shopid"]').val();
    var is_ceo = "<?php echo Auth::user()->isCEOorAdmin(); ?>";
    var user_id = "<?php echo Auth::user()->id; ?>";
    var change_s_price = "<?php echo $data['shop']->change_s_price; ?>";

    // function printdiv(elem) {
    //     $.when( closeModal() ).done(function() {
    //         printReport();
    //     });
    // }

    // function closeModal() {
    //     $('.modal').modal('hide');
    //     $('.modal').css('display','none');
    //     $('body').removeClass('modal-open');
    //     $('.modal-backdrop').remove();
    // }
    
    $(function () {
        
        if(getOS2() == "Android") {
            $('.pr-android').css('display','');
            $('.pr-others').css('display','none');
        } else {
            $('.pr-android').css('display','none');
            $('.pr-others').css('display','');
        }
        
        "<?php if(!$data['shop']->is_cashier(Auth::user()->id)) { ?>"
            $('.orders-tab').click();
        "<?php } ?>"
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

    function printdivB(elem) {
        var header_str = '<html><head><title>' + document.title  + '</title></head><body>';
        var footer_str = '</body></html>';
        var new_str = document.getElementById(elem).innerHTML;
        var old_str = document.body.innerHTML;
        document.body.innerHTML = header_str + new_str + footer_str;
        window.print();
        document.body.innerHTML = old_str;
        return false;
    }
    function printReport() { 
        
        $('#printable_div_id').print(); 

        // below is working in computer 
            // var $printerDiv = $('<div class="printContainer"></div>'); // create the div that will contain the stuff to be printed
            // var new_str = document.getElementById('printable_div_id').innerHTML;
            // $printerDiv.html(new_str); // add the content to be printed
            // $('body').append($printerDiv).addClass("printingContent"); // add the div to body, and make the body aware of printing (we apply a set of css styles to the body to hide its contents)

            // window.print(); // call print
            // $printerDiv.remove(); // remove the div
            // $('body').removeClass("printingContent");
    }
    
    function printReport2() {      
        
        // working for mobile android
            var divContents = document.getElementById("printed-sale").innerHTML;
            var a = window.open('', '', 'Print-Window');
            a.document.write('<html>');
            a.document.write('<body class="p-58mm">');
            a.document.write(divContents);
            a.document.write('</body></html>');
            a.document.close();
            a.print();
    }

    // limit no of days back to record sales 
    var ssdate = new Date();
    var bdays = "<?php echo $bdays; ?>";
    ssdate.setDate(ssdate.getDate()-bdays);
    $('.sale-date').datepicker({ 
        startDate: ssdate,
        endDate: '+0d'
    });

    $(document).ready(function(){
        // show hide cat menu
        $(".cats-h .cat-scroll").click(function () {
            $(".other-cats").stop(true).toggle("slow");
            $(this).html(function (i, t) {
                return t == '<i class="fa fa-angle-double-down"></i>' ? '<i class="fa fa-angle-double-right"></i>' : '<i class="fa fa-angle-double-down"></i>';
            });
        });
    });

    $(function () {
        $(".tool-tip").tooltip();
        $('.tsales, .tqty, .texp').html('--');
        $('.tameweka-b,.trefund-b,.ttumelipa-b,.tdeni-b').css('display','none');
        $('.items-in-cart').append('<tr class="asloader"><td><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i> Loading...</td></tr>');
        $('.inside-s-c').html('<div class="col-12 mt-2"><i class="fa fa-spinner fa-spin fa-2x"></i><span class="ml-1">Loading..</span></div>');

        if ($(window).width() <= 767) {
            var screen = "small";
        } else {
            var screen = "large";
            $('.cats-block').css('display','block');
        }         
        
        $.get("/get-data/sell-products-tab/"+shop_id+"~"+screen, function(data){  
            $('.sloader').css('display','none');   
            $('.asloader').hide(); 
            $('.inside-s-c, .search-block').html(""); 
            var disabled = '';
            if ($.isEmptyObject(data.pcats)) { } else {
                $.each( data.pcats, function( key, value ) {
                    $('.cats-h .cats-list, .cats-h .other-cats').append('<div class="cat-h cats mr-1" value="'+value.id+'"><button class="btn btn-outline-info btn-sm">'+value.name+'</button></div>');
                });
            }     
            if ($.isEmptyObject(data.customers)) {
                $('.select.customer').append('<option disabled><i>- no customer -</i></option>');
             } else {
                $.each( data.customers, function( key, val ) {
                    $('select.customer').append('<option value="'+val.id+'">'+val.name+'</option>');
                });
            }     
            
            if ($.isEmptyObject(data.sh_products)) {
                $('.search-block, .inside-s-c').html('<span><i>- No product -</i></span>');
            } else {            
                var cfolder = "<?php echo Auth::user()->company->folder; ?>";    
                for (let i = 0; i < data.sh_products.length; i++) {                 
                    var pimage = '/images/product-17.png';
                    if(data.sh_products[i]['pimage'] == null) { } else {
                        pimage = '/images/companies/'+cfolder+'/products/'+data.sh_products[i]['pimage'];
                    } 
                    if(data.sh_products[i]['quantity'] == null) { 
                        data.sh_products[i]['quantity'] = 0;
                    }
                    $('.search-block').append("<div class='searched-item px-2 py-2 border' check='sales'  container="+data.sh_products[i]["rprice"]+" pname='"+data.sh_products[i]['pname']+"' val='"+ data.sh_products[i]['pid'] +"' qty='"+ data.sh_products[i]['quantity'] +"' price='"+ Number(data.sh_products[i]['rprice']) +"'>"
                        +data.sh_products[i]['pname'] +"<span class='bg-info ml-1 px-1 text-white'>"+Number(data.sh_products[i]['quantity'])+"</span>" +"<span style='float:right'>"+Number(data.sh_products[i]['rprice']).toLocaleString('en')+"/=</span></div>");

                    $('.inside-s-c').append('<div class="col-sm-3 px-1">'
                        +'<div class="btn btn-primary btn-sm searched-item py-1 mb-2" val="'+ data.sh_products[i]["pid"] +'" pname="'+ data.sh_products[i]["pname"] +'" container="'+ Number(data.sh_products[i]["rprice"])+'"  check="sales" qty="'+ data.sh_products[i]["quantity"] +'" price="'+ Number(data.sh_products[i]["rprince"]) +'" style="font-size: 12px">'
                        +'<img src="'+pimage+'" class="avatar"><br> <span>'+ data.sh_products[i]["pname"] +'</span><b>'+ Number(data.sh_products[i]["rprice"]).toLocaleString("en") +'</b></div></div>');
                }
            }   
            
            if (localStorage.getItem("items-in-cart") === null) {
                $('.items-in-cart').html('<tr class="empty-row"><td><div class="py-3"><i>- Empty Cart -</i></div></td></tr>');
            } else {
                if (localStorage.getItem('shop_id') == shop_id) {
                    $('.items-in-cart').html(localStorage.getItem('items-in-cart'));
                    $('.totalQ').html(localStorage.getItem('totalQ'));
                    $('.totalP').html(localStorage.getItem('totalP'));
                } else {
                    $('.items-in-cart').html('<tr class="empty-row"><td><div class="py-3"><i>- Empty Cart -</i></div></td></tr>');
                    localStorage.removeItem('items-in-cart');
                    localStorage.removeItem('totalQ');
                    localStorage.removeItem('totalP');
                }
            } 

            todayTotalSales();
        });      
    });

    function todayTotalSales() {
        $('.td-sales').html('<i class="fa fa-spinner fa-spin"></i>');
        $.get('/get-data/today-total-sales/'+shop_id, function(data) {
            if (data.total[0]['totalS']) {
                $('.td-sales').html(Number(data.total[0]['totalS']).toLocaleString());
            } else {
                $('.td-sales').html(0);
            }            
        });      
    }

    function todaySales() {
        $('.sales-report').html("<tr class='loader p-5'><td colspan='6'><i class='fa fa-spinner fa-spin'></i> Loading...</td></tr>");
        $('.see-more-sales').css('display','none');
        var d = new Date();
        var date = d.getDate();
        var month = d.getMonth()+1; 
        var year = d.getFullYear();
        $.get('/sales-by-date/cashier-five-sold-items/'+date+'/'+month+'/'+year+'/'+shop_id, function(data) {
            $('.sales-report .loader').css('display','none');
            var profit = Number(data.total[0]['totalS']) - Number(data.total[0]['totalB']);
            $('.totalSQ').html(Number(data.total[0]['totalQ']));
            $('.totalSP').html(Number(data.total[0]['totalS']).toLocaleString("en"));
            $('.totalPro').html(Number(profit).toLocaleString("en"));
            if ($.isEmptyObject(data.items)) {
                $('.sales-report').html('<tr><td colspan="6"><i>-- No Sales --</i></td></tr>');
            } else {
                var num = 1;
                var displaynone = "displaynone";
                for (let i = 0; i < data.items.length; i++) {
                    if(is_ceo == true) {
                        displaynone = "";
                    } else {
                        if(data.data.uid == user_id) {
                            displaynone = "";
                        } else {
                            var displaynone = "displaynone";
                        }
                    }
                    $('.sales-report').append('<tr class="sr-'+data.items[i]["sid"]+'"><td><div class="row py-1">'
                        +'<div class="col-12 r-name">'+ num +'). '+data.items[i]["pname"]+''
                        +'<span class="p-1 pull-right text-danger edit-sr '+displaynone+'" val="'+data.items[i]["sid"]+'" style="cursor: pointer;"><i class="fa fa-pencil-square-o" style="font-size:1.5rem;"></i></span></div>'
                        +'<div class="col-12" style="font-size:1rem" align="right"> <span>'+Number(data.items[i]["sqty"])+'</span> <span><i class="fa fa-times"></i></span> <span>'+Number(data.items[i]["sprice"]).toLocaleString('en')+'</span> <span>=</span><span><b>'+Number(data.items[i]["tsales"]).toLocaleString('en')+'</b></span></div>'
                        +'</div></td></tr>');
                    num++;
                }

                // $('.see-more-sales').css('display','block');
            }

            // if(data.data.count > 5) {
            //     $('.see-more-sales').css('display','block');
            // }

            


            // if (data.expenses != 0) {
            //     $('.expenses').css('display','');
            //     $('.totalE').html(data.expenses);
            // }
            // if (data.deni != 0) {
            //     $('.deni').css('display','');
            //     $('.totalD').html(data.deni);
            // }
            // if (data.ameweka != 0) {
            //     $('.ameweka').css('display','');
            //     $('.totalA').html(data.ameweka);
            // }
            // if (data.tumelipa != 0) {
            //     $('.tumelipa').css('display','');
            //     $('.totalT').html(data.tumelipa);
            // }
            // returned items
            // if (!$.isEmptyObject(data.items2)) {
            //     $('.returned-block').css('display','');
            //     $('.render-returned-items').html(data.items2);
            // }
            // if (!$.isEmptyObject(data.items3)) {
            //     $('.returned-block2').css('display','');
            //     $('.render-returned-items2').html(data.items3);
            // }
            
            // if(data.data.check_order) {
            //     $('.orders-tab span').css('display','inline');
            // }
        });
    }

      $(document).on('click', '.attach-customer', function(e){ 
        e.preventDefault();
        $('.new-customer-blc').css('display','none');
        $('#cust-m-title').html("<?php echo $_GET['attach-customer']; ?>");
      });
      $(document).on('click', '.show-new-customer-blc', function(e){ 
        e.preventDefault();
        $('.new-customer-blc').css('display','block');
      });

    $(".search-product2").on("click keyup", function() {
        var name = $(this).val().trim().toLowerCase();
        $('.search-block').css('display','block');
        $("#search-block div").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(name) > -1);
        });
    });

    $(".sell-customer .customer").on('change', function(e) {
        e.preventDefault();
        $('.render-attached-customer').html("...");
        $('#attachCustomer').modal('hide');
        var customer_id = $(this).val();
        var cname = $(this).find('option:selected').text();
        if (customer_id == '' || customer_id == null) {
            customer_id = 'null';          
            $('.customername').html("");
            $('.render-attached-customer').html("");  
        } else {
            $('.customername').html(cname);
            $('.render-attached-customer').html("<?php echo $_GET['customer']; ?>: <b>"+cname+"</b><span class='change-a-customer'><i class='fa fa-pencil'></i></span><span class='remove-a-customer'><i class='fa fa-times'></i></span>");
        }
        $('[name="customer"]').val(customer_id);
        // $.get('/update-customer-onsale/'+shop_id+'/'+customer_id, function(data){
        //     // update on db
        // });
    });

    $(document).mouseup(function(e) {
        var container = $(".other-cats");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            if ($(".cats-h .cat-scroll .fa").hasClass('fa-angle-double-down')) {
                $('.cats-h .cat-scroll').click();
            } 
        }
    });

    $(document).on('click', '.inside-s-c, .searched-item', function(e) {
        e.preventDefault();
        if ($(window).width() <= 575) {
            $('html, body').animate({
                'scrollTop' : $(".scroll-to-c").position().top
            });
        }
    });

    $(document).on('click', '.remove-a-customer', function(e){
        e.preventDefault();
        $('.sell-customer .customer').val("").change();
    });
    $(document).on('click', '.change-a-customer', function(e){
        e.preventDefault();
        $('.new-customer-blc').css('display','none');
        $('#cust-m-title').html("<?php echo $_GET['change-customer']; ?>");
        $('#attachCustomer').modal('toggle');
    });


</script>