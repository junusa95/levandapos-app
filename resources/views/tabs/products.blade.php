
@include("layouts.translater") 

<?php 
if(Cookie::get("language") == 'en') {
    $_GET['products-availability-in-shop'] = "Products Availability in a Shop <br> <small>Place a tick if product is available in a Shop. Remove a tick if product is not available in a Shop";
} else {
    $_GET['products-availability-in-shop'] = "Upatikanaji wa Bidhaa kwenye Duka <br> <small>Weka tiki kama bidhaa inapatikana kwenye duka. Ondoa tiki kama bidhaa haipatikani kwenye Duka</small> ";
}


if(Auth::user()->company->has_product_categories == 'no') {
    $display_none = "display-none";
} else {
    $display_none = "";
}
?>
<style type="text/css">


/*    custom select option */


.box {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 100%;
}

 .box select {
  background-color: #fff;
  color: #17a2b8;
  padding: 9px 12px;
  width: 100% !important;
  border: none;
  font-size: 18px;
  box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
/*  -webkit-appearance: button;*/
  appearance: button;
  outline: none;
  -webkit-appearance: none; /* For Safari, Chrome, Opera */
  -moz-appearance: none;    /* For Firefox */
  appearance: none;         /* Standard property */
}

.box::before {
  content: "\f13a";
  font-family: FontAwesome;
  position: absolute;
  top: 0;
  right: 0;
  width: 20%;
  height: 100%;
  text-align: center;
  font-size: 28px;
  line-height: 45px;
  color: #17a2b8;
  background-color: #efefef;
  pointer-events: none;
}

.box:hover::before {
  color: #17a2b8;
  background-color: #ddd;
}

.box select option {
  padding: 30px 20px;border-bottom: 1px solid #ddd;
}

/*end custom css */


    .pro-block {display: none;}
    .table-responsive .table {
        font-size: 14px;
    }
    .product-details:hover {cursor: pointer;background:#FAF9F6}
    .first-td {white-space: normal !important;word-wrap: break-word;}
    .first-td-m {white-space: normal !important;word-wrap: break-word;border-right: 1px solid #ddd;}
    .first-td span span {
        margin-top: 0px;
    }
    .pro-menu li a {padding-left: 10px;padding-right: 10px;}
    .pro-menu li a:hover {background-color: #68a4e3 !important;}
    .pq-list .form-group {margin-bottom: 0px !important;}
    .pq-list .bb-price {margin-bottom: 10px;border-bottom: 1px solid #ddd;}
    .pq-list .bb-price div {width: 270px;text-align: right;}
    .pq-list label, .pq-list input, .pq-list span {display: inline-block;}
    .pq-list label {width: 190px;}
    .pq-list input {width: 80px;}
    .pq-list .clear-pq-row {font-size: 16px !important;cursor: pointer;color: red;}
    .pq-add-pro, .pq-footer {display: none;}
    .pq-select-2 {padding-left: 100px !important;}
    .pro-block.all .table .thead-light th, .pro-block.manage .table .thead-light th {background-color: #f9f6f2;}
    /* products in  */
    .b_q {font-size: 16px !important;background-color: aqua;padding-left: 2px;padding-right: 2px;}
    .date-range {text-align: left;padding-left: 10px;background:#f4f7f6;margin-left: -15px;margin-right: -15px;}
    .date-range .form-group {
        padding: 0px;
    }
    .date-range label {margin-bottom: 0px;padding-top: 5px;}  
    .date-range button {margin-top: 26px;}
    .date-range .b {padding-left: 0px;padding-right: 10px;}
    .display-none {display: none !important;}
    .product-details.about-finish {background: #fff3cd}
    .product-details.finished {background: #f8d7da}
    .pro-block input {
        border: 2px solid #ced4da;
    }
    .pro-block .input-group-text {        
        float: right;
        margin-top: -36px;margin-right:15px;
        height: 36px;padding: 0px;
        border-top-left-radius: 0;border: none;
    }
    #search-block {overflow-y : auto;height: 300px;}
    .sale-search-block .form-control {padding-top: 10px;padding-bottom: 10px;font-size: 1rem;color: #000;}
    @media screen and (max-width: 767px) {
        .pro-add {padding-left: 15px;}
        .left-head {margin-left: 10px;}
        /* .date-range {margin-top: 15px;margin-left: 0px;} */
    }
    @media screen and (max-width: 574px) {
        .c-op {padding-right: 25px;}
    }
@media screen and (max-width: 480px) {
    .box select option {
      font-size: 15px;
    }
    .reduce-padding {padding-left:5px;padding-right:5px;}
    .b_q {font-size: 14px !important;}
    .date-range button {margin-top: 30px;}
    .pro-add {padding-left: 5px;}
    .table-responsive .table {
        font-size: 12px;
    }        
    .pq-select-2 {padding-left: 0px !important;text-align: center !important;}
    .first-td {padding-left:3px !important;}    
    .first-td-m {padding-left:5px !important;padding-right: 5px !important;}    
    .first-td span span {margin-top: 2px;}
}
</style>

<div class="row clearfix" style="margin-top: -15px;">
    <div class="col-md-12 reduce-padding">
        <div class="card" style="border: none;box-shadow: none;">
            <div class="body">
                <div class="row py-3" style="margin-top: 15px;margin-bottom: 15px;">
                    <div class="col-8 offset-2 c-op">
                        <div class="box">
                            <select class="change-products-option">
                                <option value="all-products"><?php echo $_GET['available-products']; ?></option>
                                <option value="products-in"><?php echo $_GET['products-in']; ?></option>
                                <option value="product-categories" class="<?php echo $display_none; ?>"><?php echo $_GET['product-categories']; ?></option>
                                @if(Auth::user()->isCEOorAdminorBusinessOwner())
                                <option value="products-value"><?php echo $_GET['value-of-all-products']; ?></option>
                                @if($data['shopstore'] == "many")
                                <option value="manage-products"><?php echo $_GET['products-availability']; ?></option>
                                @endif
                                @endif
                                @if(Auth::user()->company->can_transfer_items != "no")
                                <option value="transfer-products"><?php echo $_GET['transfer-item-menu']; ?></option>
                                @endif
                            </select>
                        </div>
                    </div>                    
                </div>
            </div>
            <!-- all products  -->
            <div class="body pro-block all">
                <div class="row mt-3">
                    <div class="col-8">
                        <div class="input-group search-p">
                            @if(isset($data['shop']))
                                <?php $sid = $data['shop']->id; ?>
                                <input type="hidden" name="from" value="shop">
                                <input type="hidden" name="shopid" value="{{$data['shop']->id}}">
                            @endif
                            @if(isset($data['store']))
                                <?php $sid = $data['store']->id; ?>
                                <input type="hidden" name="from" value="store">
                                <input type="hidden" name="storeid" value="{{$data['store']->id}}">
                            @endif
                            <input type="hidden" name="sfrom">
                            <!-- <input type="text" class="form-control" name="pname" placeholder="<?php echo $_GET['search-product']; ?>" aria-describedby="basic-addon2"> -->
                            <!-- <div class="input-group-append">
                                <button class="btn btn-outline-info search-product-btn" type="button"><?php echo $_GET['search']; ?></button>
                            </div> -->
                        </div>

                        <div class="form-group mb-3">
                            <input type="text" class="form-control search-product22" check="sales" stoshop="shop" placeholder="<?php echo $_GET['search-product']; ?>" name="pname" autocomplete="off"> 
                            <span class="input-group-text bg-transparent" style="border-left: none;">
                                <i class="fa fa-search"></i>
                            </span>                            

                            <div class="search-block-outer">
                                <div class="search-block" id="search-block">
                                    
                                </div>
                            </div>  
                        </div>
                    </div>
                    @if(Auth::user()->isCEOorAdminorBusinessOwner())
                    <div class="col-2 pr-0" align="right">                    
                        <div class="navbar-nav right-navbar">
                            <div class="dropdown pro-add">
                                <a class="btn btn-info border" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-plus px-1" style="font-size: 1.5rem;"></i> 
                                </a>    
                                <ul class="dropdown-menu user-menu p-1 pt-2" aria-labelledby="dropdownMenuButton" style="border-radius:5px;margin-left:-160px !important;background-color: #fff;">
                                    <a class="dropdown-item bg-primary text-light py-2 create-new-product" style="border-radius: 5px 5px 0px 0px;" href="#"><i class="fa fa-plus pr-1"></i> <?php echo $_GET['new-product']; ?></a>
                                    <a class="dropdown-item bg-info text-light py-2 add-product-quantity" style="border-radius: 0px 0px 5px 5px;" href="#"><i class="fa fa-plus pr-1"></i> <?php echo $_GET['product-quantity']; ?> <small>(stock)</small></a>
                                </ul>
                            </div> 
                        </div>                    
                    </div>
                    <div class="col-2 pr-0" align="right">
                        <!-- <button class="btn btn-info" data-toggle="modal" data-target="#createCustomer">
                            <i class="fa fa-filter text-white px-1" style="font-size: 1.4rem;"></i>
                        </button> -->
                        <div class="dropdown">
                            <a class="btn btn-light text-info border" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-filter" style="font-size: 1.5rem;"></i> 
                            </a>    
                            <ul class="dropdown-menu user-menu p-1 pt-2" aria-labelledby="dropdownMenuButton" style="border-radius:5px;margin-left:-160px !important;background-color: #fff;">
                                <a class="dropdown-item bg-danger text-light py-2 deleted-products" style="border-radius: 5px 5px 0px 0px;" href="#"><?php echo $_GET['deleted-products']; ?><i class="fa fa-angle-right pt-1 pl-3" style="float:right;"></i></a>
                                <a class="dropdown-item bg-info text-light py-2 export-products-pdf" style="border-radius: 0px 0px 5px 5px;" href="#"> PDF <i class="fa fa-download pt-1 pl-3" style="float:right;"></i></a>
                            </ul>
                        </div> 
                    </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-12">
                    <div class="mb-2">
                        <div class="fp-title pt-2" style="display: flex;align-items: center;">
                            <div class="" style="margin-top: -10px !important;display:inline-block;"><?php echo $_GET["all-products-menu"]; ?>:</div>
                            <h2 class="px-2 ml-1 render-total-products" style="display: inline-block;">--</h2>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 px-0">
                        <div class="table-responsive">
                            <table class="table m-b-0 c_list f-products">
                                <thead class="thead-light">
                                    <tr> 
                                        <th><?php echo $_GET['item']; ?></th>    
                                        <th><?php echo $_GET['quantity-full']; ?></th>    
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="render-products">

                                </tbody>
                                <tbody class="more-pr-t">
                                    <tr>
                                        <td colspan="3" align="center">
                                            <div class="mt-3"><button class="btn btn-outline-info px-3 more-all-products" lastid=""><?php echo $_GET['show-more']; ?> </button></div>                                          
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- products in  -->
            <div class="body pro-block pin">
                <div class="row">
                    <div class="col-12">
                        <div class="pending-stock-block" style="margin-bottom: 40px;">
                            <div class="header pl-1">
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
                                <div class="col-md-12">
                                    <div class="p-3" style="background-color: #f9f6f2;">
                                        <h5 class="mb-0"><?php echo $_GET['added-stock']; ?>: <small class="bg-success text-light">(Received)</small></h5>
                                        <div>( New Stocks Records )</div>
                                    </div>
                                </div>
                                <div class="col-md-12">            
                                    <div class="px-4 pb-2" style="background-color: #f9f6f2;">  
                                        <div class="row clearfix date-range" style="background:#fff">
                                            <div class="col-md-12" style="padding-left: 0px;display: none;">
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
                            </div>
                            <div class="previous-body">
                                <div class="table-responsive" style="background-color: #f9f6f2;"> 
                                    <table class="table">
                                        <!-- <thead class="thead-light">
                                            <tr>
                                                <th><?php echo $_GET['item']; ?></th> 
                                                <th></th>  
                                            </tr>
                                        </thead> -->
                                        <tbody class="received-stock">
                                        </tbody>
                                    </table>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>                
            </div>
            <!-- product categories  -->
            <div class="body pro-block cats">
                <div class="row">
                    <div class="col-12">
                        <div class="header">
                            <h2><?php echo $_GET['products-categories']; ?></h2>
                            @if(Auth::user()->isCEOorAdminorBusinessOwner())
                            <ul class="header-dropdown">
                                <li>
                                    <button class="btn btn-info btn-sm new-sub-category-form" data-toggle="modal" data-target="#addSCategory">
                                        <b><?php echo $_GET['add-category']; ?></b>
                                    </button>
                                </li>
                            </ul>
                            @endif
                        </div>
                        <div class="table-responsive" style="background-color: #f9f6f2;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><?php echo $_GET['name']; ?></th>
                                        <th><?php echo $_GET['products-menu']; ?></th>
                                        @if(Auth::user()->isCEOorAdmin())
                                        <th><?php echo $_GET['action']; ?></th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="render-pro-categories">
                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- products value  -->
            <div class="body pro-block value">
                <div class="row mt-3" style="padding-right: 15px;">
                    <div class="col-7">
                        <div class="row">
                            <div class="col-12">
                                <div class="body" style="background-color: #eceeef;">
                                    <h5 class="r-total-cost"></h5>
                                    <div>Total Cost</div>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="body" style="background-color: #e0eff5;">
                                    <h5 class="r-total-price"></h5>
                                    <div>Total Price</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-5 px-0" style="background-color: #bdf3f5;">
                        <div class="row">
                            <div class="col-12">
                                <div class="body mr-0">
                                    <h5 class="r-total-profit"></h5>
                                    <div>Total Profit</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- manage products  -->
            <div class="body pro-block manage">
                <div class="row mt-3">
                    <div class="col-sm-10 offset-md-1">
                        <div class="input-group mt-0 mb-3 search-p">
                            @if(isset($data['shop']))
                                <?php $sid = $data['shop']->id; ?>
                                <input type="hidden" name="from" value="shop">
                                <input type="hidden" name="shopid" value="{{$data['shop']->id}}">
                            @endif
                            @if(isset($data['store']))
                                <?php $sid = $data['store']->id; ?>
                                <input type="hidden" name="from" value="store">
                                <input type="hidden" name="storeid" value="{{$data['store']->id}}">
                            @endif
                            <input type="hidden" name="sfrom">
                            <input type="text" class="form-control" name="pname" placeholder="<?php echo $_GET['search-product']; ?>" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-outline-info search-product-btn-2" type="button"><?php echo $_GET['search']; ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-2">
                    <div class="fps-title"><?php echo $_GET["products-availability-in-shop"]; ?></div>
                </div>
                <div class="table-responsive">
                    <table class="table m-b-0 c_list">
                        <thead class="thead-light">
                            <tr> 
                                <th><?php echo $_GET['item']; ?></th>    
                                <th></th>    
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="render-products-m">

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- transfer products  -->
            <div class="body pro-block transfer">
                
            </div>
            <!-- new product  -->
            <div class="body pro-block new">

            </div>
            <!-- preview product  -->
            <div class="body pro-block preview">
                @if(isset($data['shop']))
                    @include('tabs.product-details-tab')
                @endif
                @if(isset($data['store']))
                    @include('tabs.product-details-store-tab')
                @endif
                
            </div>
        </div>
    </div>
</div>


<!-- add new stock modal -->
<div class="modal fade" id="addPQuantity" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="title" id="largeModalLabel"><?php echo $_GET['add-quantity-of-product']; ?> <br> <small>(<?php echo $_GET['new-stock-menu']; ?>)</small></h5>
                <ul class="header-dropdown mb-0" style="list-style: none;">
                    <li>
                        <button class="btn btn-danger btn-sm close-modal" data-dismiss="modal"><i class="fa fa-times py-1"></i></button>
                    </li>
                </ul>
            </div>
            <div class="modal-body pq-body"> 
                <form class="add-product-quantity-form">
                    <div class="pq-list">
                        <!-- list of selected items  -->
                    </div>
                    <div class="pq-select-2">
                        <div class="loader"><i class="fa fa-spinner fa-spin fa-2x"></i></div>
                        <div class="select">
                            <select name="product" class="form-control select2" style="width: 200px;">
                                <option value="-">- <?php echo $_GET['choose-product']; ?> -</option>
                            </select>
                        </div>
                    </div>
                    <div class="pq-add-pro mt-2">
                        <button class="btn btn-sm"><i class="fa fa-plus text-info pr-1"></i><?php echo $_GET['add']; ?></button>
                    </div>
                    <div class="pq-footer mt-5">
                        @if(Auth::user()->company->cashier_stock_approval == 'no')
                            <div style="display:none"><input type="radio" name="approvalRequired" value="no" checked></div>
                        @else
                            <div class="form-group mt-3"><label><?php echo $_GET["is-cashier-checkup-required"]; ?> ?</label><br>
                                <label class="fancy-radio"><input type="radio" name="approval" value="yes" required="" data-parsley-errors-container="#error-radio" data-parsley-multiple="approvalRequired" checked><span><i></i><?php echo $_GET["yes"]; ?></span></label>
                                <label class="fancy-radio"><input type="radio" name="approval" value="no" required="" data-parsley-errors-container="#error-radio" data-parsley-multiple="approvalRequired" ><span><i></i><?php echo $_GET["no"]; ?></span></label>
                            </div>
                        @endif
                        <input type="hidden" name="check" class="check" value="0">
                        <button type="submit" class="btn btn-success"><i class="fa fa-check pr-2"></i> Done</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-primary">SAVE CHANGES</button> -->
                <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button> -->
            </div>
        </div>
    </div>
</div>

<!-- edit product  -->
<div class="modal fade" id="editProduct" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="title" id="largeModalLabel"><?php echo $_GET['change-product-details']; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:red;opacity:1">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"> 
                
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-primary">SAVE CHANGES</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
            </div> -->
        </div>
    </div>
</div>

<!-- deleted products  -->
<div class="modal fade" id="deletedProducts" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="title" id="largeModalLabel"><?php echo $_GET['deleted-products']; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:red;opacity:1">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body list-deleted-products"> 
                
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-primary">SAVE CHANGES</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
            </div> -->
        </div>
    </div>
</div>

    
<script type="text/javascript">
    $('.select2').select2();
    $(document).on('click', '.add-product-quantity', function(e){
        e.preventDefault();
        $('#addPQuantity').modal('toggle');
    });
    $(document).on('click', '.pq-add-pro button', function(e){
        e.preventDefault();
        $('.pq-select-2').css('display','block');
        $('.pq-add-pro').css('display','none');
    });
    
    $(document).on('click', '.f-all-products', function(e){
        e.preventDefault();
        getProducts("<?php echo $sid; ?>");
    });
    
    $(document).on('click', '.f-manage-products', function(e){
        e.preventDefault();
        manageProducts("<?php echo $sid; ?>");
    });
    
    $(document).on('click', '.f-stock-value', function(e){
        e.preventDefault();
        calculateStockValue("<?php echo $sid; ?>");
    });
    
    $(".search-product22").on("click keyup", function() {
        var name = $(this).val().trim().toLowerCase();
        $('.search-block').css('display','block');
        $("#search-block div").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(name) > -1);
        });
    });
</script>
