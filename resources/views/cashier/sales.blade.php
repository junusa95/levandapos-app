@extends('layouts.app')
@section('css')
<style type="text/css">
    .select2-container .select2-selection--single{
        height:34px !important;
    }
    .select2-container--default .select2-selection--single{
        border: 1px solid #ccc !important; 
         border-radius: 0px !important; 
    }
    .sale-by-cat {position: relative; height: 98%;box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.06) 0px 2px 4px -1px;}
    /*.sale-by-cat .inside-s-c {margin: 0;position: absolute;top:50%; transform: translateY(-50%);width: 100%;text-align: center;}*/
    .sale-by-cat .inside-s-c {margin: 0 0 14px 5px; background:#f4f7f6;padding-top: 10px; width: 99%;height: 240px; text-align: center;overflow-y: scroll;}
    .cats-block, .sale-search-block {display: none;}
    .sale-search-block .form-group {width: 80%;margin-left: auto;margin-right: auto;}
    .sale-search-block .form-control {padding-top: 10px;padding-bottom: 10px;}
    .sold-products, .sold-products2, .edit-sale {
        font-size: 13px;
    }
    .sold-products tr td, .sold-products2 tr td, .edit-sale tr td {
        padding-top: 5px;padding-bottom: 5px;
    }
    .sold-products .quantity, .sold-products2 .quantity, .sold-products2 .soquantity, .edit-sale .quantity2 {
        width:45px;padding:0px;padding-left:5px;display: inline-block;
    }
    .sold-products .aqty, .sold-products2 .aqty, .edit-sale .aqty {
        margin-left: 3px;font-size: 12px;
    }
    .sold-products .sprice, .sold-products2 .sprice, .sold-products2 .soprice, .edit-sale .sprice2 {
        width:70px;padding:0px;padding-left:5px;
    }
    .sold-products2 tr {
        border-bottom: dotted 1px #ddd;
    }
    .sold-products2 .row {
        margin-left: -10px;margin-right: -10px;
    }
    .sold-products2 .r-name {
        padding-left: 5px;padding-right: 0px;
    }
    .sold-products2 .r-name span {
        color: red;padding: 0px 2px;cursor: pointer;
    }
    .sold-products2 .r-fill {
        /*display: inline-block;*/
    }
    .submit-sale-cart {
        margin-right: 1.5rem;
    }
    .order-footer {position: absolute;bottom:0;margin-bottom: 10px;background: #fff;}
    .order-footer .btn {margin-top: 8px;margin-right: 5px;}
    .order-footer .hidden-btn {
        margin-left: 1.5rem;
    }
    .paidamount, .paidamount2 {
        width: 200px;
    }
    .tsales-summary h6 {
        font-weight: bold;margin-top: 5px;
    }
    .tsales-summary .top-row .row .col, 
    .tsales-summary .top-row .row .col-5, 
    .tsales-summary .top-row .row .col-4, 
    .tsales-summary .top-row .row .col-3 {
        padding: 0px;padding-right: 10px;
    }   
    .total-row {
        font-weight: bold;
    }
    .total-row td {
        padding-left: 15px;
    }
    .top_counter .body {
        padding-top: 5px;
    }
    .top_counter .content {
        border-bottom: solid 1px #dee2e6;
    }
    .top_counter .icon {
        width: 25px;
    }
    .soquantity {
        width: 50px;padding: 0px 5px;
    }
    .soprice {
        width: 90px;padding: 0px 5px;
    }
    #cats-to-sale .modal-body .cats {color: #007bff;padding: 5px;margin-bottom: 5px;cursor: pointer;border-bottom: 1px solid #ddd;}
    #cats-to-sale .modal-body .cats:hover{color: #6610f2;border-bottom: 1px solid #000;}
    .hideblock {display: none;}
    .searched-item .avatar {
        width: 50px;height: 50px;object-fit: cover;
    }

    .sale-opt-out {text-align: center;width: 150px;margin-left: auto;margin-right: auto;}
    .sale-opt {margin-bottom: 15px;}
    .sale-opt .badge {padding-bottom: 5px;cursor: pointer;width: 150px;margin-left: 0px;}
    .sale-opt .badge:hover {transform: scale(1.02)}
    .sale-opt i {margin-left: 10px;font-size: 15px !important;}
    .sale-drop {position: absolute;background: #fff;width: 150px;height: 40px; margin-left: auto;margin-right: auto; margin-top: 3px; text-align: center;box-shadow: 0 1px 1px rgba(0,0,0,0.08), 0 2px 2px rgba(0,0,0,0.12), 0 4px 4px rgba(0,0,0,0.16), 0 8px 8px rgba(0,0,0,0.20);display: none;}
    .cats-hor {text-align: center;}
    .cats-hor .cat-h {display: inline-block;}
    .switch-sale-opt {padding: 5px 0px; margin-top: 3px;color: #3C89DA;}
    .switch-sale-opt:hover {background: #e9ecef;text-decoration: underline;cursor: pointer;}
    .cats-h {
      width: 100%;
      overflow: hidden;
      overflow-x: auto;
      overflow-y: hidden;
      white-space: nowrap;
    }
    .cats-h::-webkit-scrollbar {
      display: none;
    }
    .cats-h .cat-h {
      display: inline-block;
      min-width: 50px;
    }
    .cats-h .cat-scroll {
        position: absolute;
        right: 0;
        margin-top: -31px;
        background-color: #000;
        color: white;
        padding: 5px 7px;
        min-width: 30px;
        cursor: pointer;
        -moz-box-shadow: 3px 3px 5px 6px #ccc;
        -webkit-box-shadow: 3px 3px 5px 6px #ccc;
        box-shadow: -3px 0px 4px 0px #ccc;
    }
    .cats-h .other-cats {
        background-color: #f0f0f0;
        position: absolute;
        right: 0px;min-width: 150px;
        z-index: 9999;
        display: none;
        -moz-box-shadow: 3px 3px 5px 6px #ccc;
        -webkit-box-shadow: 3px 3px 5px 6px #ccc;
        box-shadow: -3px 3px 4px 0px #ccc;
    }
    .cats-h .other-cats .cat-h {display: block;}
    .cats-h .other-cats .cat-h button {width: 100%;}
    .inside-s-c .btn {background: #bdf3f5;color: #000;}
    .inside-s-c .btn:hover {
        background: #fff !important;
        color: #007bff !important;
    }
    .cats button {font-size: 13px;}
    .cats.active button {background: #17a2b8;color: #fff;}
    .customer-small {display: none;}
    .customer-large {display: block;}

    .custom-o-nu-block {text-align: center;width: 100px;margin-left: auto;margin-right: auto;text-align: center;margin-bottom: 10px;}
    .custom-o-nu-block span {font-size: 11.5px;}
    .custom-o-nu-block input {height: 30px;font-size: 1.2rem;text-align: center;}

    .order-pay-block {display: none;}
    .order-pay-block .scustomer {text-align: center;margin-left: auto;margin-right: auto;}
    .order-pay-block h5 {text-align: center;}

    .jumla-b {float: right;margin-left: 0px;margin-right: 0px;padding-right: 10px;}
    .jumla-b .jumla-o {margin-top: auto;margin-bottom: auto;margin-right: 20px;}

    /*printed css*/
    #printed-order {font-size: 12px;font-family: 'Times New Roman';font-weight: bolder;color: #000 !important;width: 80mm;display: none;}
    #printed-order .head {text-align: center;}
    #printed-order .head h5 {padding-bottom: 0px;}
    #printed-order table td {border-bottom: 1px solid #000;}
    #printed-order table .row {width: 80mm;margin-left: 10px;}
    #printed-order table .row .r-name {padding-left: 0px;margin-left: -10px;}

    .date-range {
        text-align: left;background:#f4f7f6;margin-left: -15px;padding-left: 10px;margin-right: -15px;margin-bottom: 20px;
    }
    .date-range .b {
        padding: 0px;
    }
    .date-range .b label {
        padding-top: 5px;
    }
    .date-range .form-group {
        padding: 0px;
    }
    .check-o-sales {
        margin-bottom:auto;margin-top: 33px;
    }
@media screen and (max-width: 1062px) and (min-width: 992px) {
    .tsales-summary .top-row .row .text {
        font-size: 12.5px;
    }    
}
@media screen and (max-width: 992px) {
    .submit-sale-cart {
        margin-right: 0rem;
    }
}
@media screen and (max-width: 767px) {
    .sale-by-cat .inside-s-c {height: 220px;}
    .sales-b-c-f {margin-bottom: 10px;}
    .sale-search-block .form-group {margin-bottom: 50px;width: 100%;padding-left: 20px;padding-right: 20px;}
    .customer-small {display: block;}
    .customer-small .form-group {width: 60%;margin-left: auto;margin-right: auto;}
    .customer-large {display: none;}
    .customer-small .select2 {width: 100% !important;}
}
@media screen and (max-width: 600px) and (min-width: 576px) {
    .sales-block button {
        padding-left: 5px;padding-right: 5px;display: none;
    }
    .sale-btns button {font-size: 13px;}
}
@media screen and (max-width: 575px) {
    .sales-outer-block {padding-left: 5px;padding-right: 5px;}
    .sales-b-c-f {padding-left: 0px;padding-right: 0px;}
    .customer-small .form-group {width: 100%;}
    /*.sale-by-cat .inside-s-c {position: relative;top: 45%;}*/
}
@media screen and (max-width: 480px) {
    .sale-search-block .form-group {margin-bottom: 30px;}
    .tsales-summary h5 {font-size: 1rem;font-weight: bold;margin-left: 5px;}
    .cats-h .cat-scroll {margin-top: -28px;}
    .check-o-sales {
        margin-bottom:auto;margin-top: 23px;
    }
}
@media screen and (max-width: 430px) {
    .order-footer {
        padding: 0px;
    }
    .order-footer .hidden-btn {
        margin-left: 3px;
    }
    .sales-block {
        padding: 0px;
    }
}
</style>
@endsection
@section('content')
<?php  
    // check if is cashier or shop seller 
    $isCashier = \DB::table('user_shops')->where('user_id',Auth::user()->id)->where('shop_id',$data['shop']->id)->where('who','cashier')->first();
    $hideblock = 'hideblock';
    if ($data['shop']->has_customers == 'yes') {
        $hideblock = '';
    }
    $curr_code = "";
    if ($data['shop']->company) {
        $curr_code = $data['shop']->company->currency->code;
    }    
 ?>
    <div id="wrapper">
        <nav class="navbar navbar-fixed-top">
            <div class="container-fluid">
                @include('layouts.topbar')
            </div>
        </nav>

        <div id="left-sidebar" class="sidebar">
            <div class="sidebar-scroll">
                @include('layouts.leftside')
            </div>
        </div>

        <div id="main-content">
            <div class="container-fluid">
                <div class="block-header">
                    <div class="row">
                        @include('layouts.topbottombar')
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 sales-outer-block">
                        <div class="card">      
                            <div class="header" style="border-bottom: 1px solid #ddd;">
                                <h2><?php echo $_GET['sell-products']; ?></h2>
                                <ul class="header-dropdown">
                                    <li>
                                        <a href="/cashier/{{$data['shop']->id}}/sales-report" class="more"><span style="display: inline-flex;"><?php echo $_GET['sales-report-menu']; ?> <span style="padding-left: 5px;padding-top: 1px;"><i class="wi wi-right"></i></span></span> </a>
                                    </li>
                                </ul>
                            </div>     
                            <div class="body">
                                <form id="basic-form" class="transfer-form">
                                    @csrf
                                    <input type="hidden" name="from" value="shop">
                                    <input type="hidden" name="shopid" value="{{$data['shop']->id}}">
                                    <input type="hidden" name="transferno" value="null">
                                    <input type="hidden" name="transferval" value="">
                                    <div class="row clearfix">
                                        <div class="col-md-8 col-12 sales-b-c-f">
                                            <!-- <span class="btn btn-primary btn-sm" data-toggle="modal" data-target="#cats-to-sale" style="width:100%"><?php echo $_GET['sale-by-category']; ?></span> -->

                                            <div class="mb-2 mt-0 sale-by-cat">
                                                <div class="sale-opt-out">
                                                    <div class="sale-opt">
                                                        <span class="badge badge-info" check="category"><?php echo $_GET['sale-by-category']; ?> <i class="fa fa-angle-down"></i></span>
                                                        <div class="sale-drop">   
                                                            <div class="switch-sale-opt" check="search">
                                                                <?php echo $_GET['sale-by-search']; ?>
                                                            </div>
                                                        </div>       
                                                    </div>
                                                </div>

                                                <div class="cats-block">
                                                    <div class="cats-hor">
                                                        <div class="cats-h">
                                                            <div class="cat-h cats recent-cat" value="0"><button class="btn btn-outline-info btn-sm">Recently</button></div>
                                                            @if(!$data['categories']->isEmpty())
                                                                @foreach($data['categories'] as $category)
                                                                    <div class="cat-h cats" value="{{$category->id}}"><button class="btn btn-outline-info btn-sm"><?php echo $category->name; ?></button></div>
                                                                @endforeach
                                                            @else
                                                                <!-- <p disabled><i>- no category -</i></p> -->
                                                            @endif
                                                            <div class="cat-scroll">
                                                              <i class="fa fa-angle-double-right"></i>
                                                            </div>
                                                            <div class="other-cats">
                                                                <div class="cat-h cats" value="0"><button class="btn btn-outline-info btn-sm">Recently</button></div>
                                                                @if(!$data['categories']->isEmpty())
                                                                    @foreach($data['categories'] as $category)
                                                                        <div class="cat-h cats" value="{{$category->id}}"><button class="btn btn-outline-info btn-sm"><?php echo $category->name." ( ".$category->categorygroup->name." )"; ?></button></div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <!-- <div class="cat-h"><button class="btn btn-outline-info btn-sm">Shirts</button></div>
                                                            <div class="cat-h"><button class="btn btn-outline-info btn-sm">Trousers</button></div>
                                                            <div class="cat-h"><button class="btn btn-outline-info btn-sm">Sneakers</button></div> -->
                                                        </div>
                                                    </div>
                                                    <span class="c-title" style="font-size:12px">Recently</span>
                                                    <div class="inside-s-c">
                                                        <!-- render products by cat -->
                                                    </div>
                                                </div>

                                                <div class="mb-2 mt-0 sale-search-block">
                                                    <div class="form-group">
                                                        <label style="margin-bottom: 1px;"><?php echo $_GET['search-product']; ?></label>
                                                        <input type="text" class="form-control form-control-sm search-product2" check="sales" stoshop="shop" placeholder="Search" name="pname" autocomplete="off"> 
                                                        <div class="search-block-outer">
                                                            <div class="search-block" id="search-block">
                                                              
                                                            </div>
                                                        </div>                                                
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12 px-0 scroll-to-c">
<div class="accordion customer-small" id="accordion">
    <div class="{{$hideblock}}">
        <div class="card-header" id="headingOne">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed show-customer" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                <?php echo $_GET['attach-customer']; ?>
                </button>
            </h5>
        </div>                                
        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" style="border: 2px solid #eee;">
            <div class="card-body" style="padding-bottom: 10px;padding-top: 10px;">                
                <div class="form-group">
                    <label style="margin-bottom: 1px;"><?php echo $_GET['select-customer']; ?></label>
                    <span class="ml-2 text-info tool-tip" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $_GET['select-customer-info']; ?>"><i class="icon-info"></i></span><br>
                    <select class="form-control customer select2" name="customer">
                        <option value="">- select -</option>
                        @if($data['customers'])
                            @foreach($data['customers'] as $customer)
                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                            @endforeach
                        @else
                            <option disabled><i>- no customer -</i></option>
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>                                      
                                            <div class="{{$hideblock}}">
                                                <div class="form-group customer-large">
                                                    <label style="margin-bottom: 1px;"><?php echo $_GET['select-customer']; ?></label>
                                                    <span class="ml-2 text-info tool-tip" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $_GET['select-customer-info']; ?>"><i class="icon-info"></i></span><br>
                                                    <select class="form-control customer select2" name="customer">
                                                        <option value="">- select -</option>
                                                        @if($data['customers'])
                                                            @foreach($data['customers'] as $customer)
                                                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                                                            @endforeach
                                                        @else
                                                            <option disabled><i>- no customer -</i></option>
                                                        @endif
                                                    </select>
                                                </div>
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
                                                <table class="table table-borderless m-b-0 c_list mt-3">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th><?php echo $_GET['items-to-sale']; ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="items-in-cart sold-products2">
                                                        
                                                    </tbody>
                                                    <tbody class="total-row">
                                                        <tr>
                                                            <td>
                                                                <div class="row" style="margin:0px">
                                                                    <div class="col-2" style="padding-top: 10px;"><?php echo $_GET['total']; ?></div>
                                                                    <div class="col-10" style="">
                                                                        <div>
                                                                            <span style="padding-right: 3px;font-weight: 100;">
                                                                                <?php echo $_GET['quantity-full']; ?>
                                                                            </span>:<span class="pl-1 totalQ"></span>
                                                                        </div>
                                                                        <div>
                                                                            <span  style="padding-right: 8px;font-weight: 100;"><?php echo $_GET['amount']; ?></span>:<span class="pl-1 totalP"></span>
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
                                                    @if(Session::get('role') == 'Cashier')
                                                    <button class="btn btn-success btn-sm submit-sale-cart"><?php echo $_GET['sale-by-cash']; ?></button>
                                                    @endif
                                                    <button class="btn btn-info btn-sm submit-order-cart"><?php echo $_GET['submit-order']; ?></button> 
                                                    <button class="btn btn-danger btn-sm clear-sale-cart"><?php echo $_GET['clear-cart']; ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-sm-6 offset-sm-6 px-0 sales-block">
                                        </div>
                                    </div>
                                </form>
                            </div>                            
                        </div>
                    </div>

                    @if(Session::get('role') == 'Cashier')
                    <div class="col-lg-6 col-md-12">
                        <div class="card top_counter tsales-summary">      
                            <div class="header" style="border-bottom: 1px solid #ddd;">
                                <h2><?php echo $_GET['today-summary']; ?>:</h2>
                            </div>    
                            <div class="body pt-3 pb-0 top-row">
                                <div class="row">
                                    <div class="col-5" style="background:#cce5ff">
                                        <!-- <div class="icon text-success"><i class="fa fa-dollar"></i> </div> -->
                                        <div>
                                            <div class="text"><?php echo $_GET['total-sales']; ?> <span>({{$curr_code}})</span></div>
                                            <h5 class="number tsales">0</h5>
                                        </div>
                                    </div>
                                    <div class="col-3 xl-parpl">
                                        <!-- <div class="icon text-success"><i class="fa fa-shopping-cart"></i> </div> -->
                                        <div>
                                            <div class="text"><?php echo $_GET['quantity']; ?></div>
                                            <h5 class="number tqty">0</h5>
                                        </div>
                                    </div>
                                    <div class="col-4 xl-khaki">
                                        <!-- <div class="icon text-info"><i class="fa fa-ellipsis-v"></i> </div> -->
                                        <div>
                                            <div class="text"><?php echo $_GET['expenses-menu']; ?> <span>({{$curr_code}})</span></div>
                                            <h5 class="number texp">0</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>   
                            <div class="body top-row pb-0">
                                <div class="row">
                                    <div class="col tdeni-b xl-salmon">
                                        <!-- <div class="icon text-secondary"><i class="fa fa-ellipsis-v"></i> </div> -->
                                        <div>
                                            <div class="text"><?php echo $_GET['debt-we-owe']; ?> <span>({{$curr_code}})</span></div>
                                            <h5 class="number tdeni">0</h5>
                                        </div>
                                    </div>
                                    <div class="col tameweka-b xl-blue">
                                        <!-- <div class="icon text-info"><i class="fa fa-ellipsis-v"></i> </div> -->
                                        <div>
                                            <div class="text"><?php echo $_GET['customer-deposit']; ?> <span>({{$curr_code}})</span></div>
                                            <h5 class="number tameweka">0</h5>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="body top-row pb-0">
                                <div class="row">
                                    <div class="col trefund-b xl-slategray">
                                        <!-- <div class="icon text-secondary"><i class="fa fa-ellipsis-v"></i> </div> -->
                                        <div>
                                            <div class="text">Refund <span>({{$curr_code}})</span></div>
                                            <h5 class="number trefund">0</h5>
                                        </div>
                                    </div>
                                    <div class="col ttumelipa-b xl-khaki">
                                        <!-- <div class="icon text-secondary"><i class="fa fa-ellipsis-v"></i> </div> -->
                                        <div>
                                            <div class="text"><?php echo $_GET['we-paid-debt']; ?> <span>({{$curr_code}})</span></div>
                                            <h5 class="number ttumelipa">0</h5>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            @if(Auth::user()->isCEOorAdmin())
                            <div class="body pt-3" style="border-bottom: solid 1px #dee2e6;border-top: solid 1px #dee2e6;">
                                <div class="row">
                                    <div class="col-6 align-center my-auto" style="border-right: solid 2px #28a745;">
                                        <h5><?php echo $_GET['available-money']; ?></h5>
                                    </div>
                                    <div class="col-6 align-center">
                                        <div class="form-group mb-2">
                                            <input type="hidden" name="cash" class="form-control form-control-sm exp_cash">
                                            <input type="number" name="cash" class="form-control form-control-sm ava_cash">
                                        </div>
                                        <button class="btn btn-success btn-sm closure-sale"><?php echo $_GET['close-sales']; ?></button>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="body align-center pt-3">
                                <a href="/cashier/{{$data['shop']->id}}/sales-report" class="btn btn-info btn-sm"><?php echo $_GET['sales-report-menu']; ?></a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="row clearfix">
                    <div class="col-lg-6 col-md-6">
                        <div class="card">      
                            <div class="header">
                                <h6><?php echo $_GET['pending-sales-orders']; ?>:</h6>
                            </div>     
                            <div class="body pt-0">
                                <div class="table-responsive">
                                    <table class="table table-hover m-b-0">
                                        <thead>
                                            <tr>
                                                <th><?php echo $_GET['order']; ?> #</th>
                                                <th><?php echo $_GET['quantity']; ?></th>
                                                <th><?php echo $_GET['amount']; ?></th>
                                            </tr>
                                        </thead>
                                        <tbody class="render-oitems">

                                        </tbody>
                                    </table>
                                </div>
                            </div>  
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="card">      
                            <div class="header">
                                <h6><?php echo $_GET['sold-sales-orders']; ?>:</h6>
                            </div>     
                            <div class="body pt-0">
            <div class="row clearfix date-range" style="">
                <div class="col-sm-3 col-4 b">
                    <div class="form-group">
                        <label><?php echo $_GET['from']; ?></label>
                        <input type="text" data-provide="datepicker" data-date-autoclose="true" class="form-control from-date form-control-sm" placeholder="From" value="<?php echo date('d/m/Y'); ?>">
                    </div>
                </div>
                <div class="col-sm-3 col-4 ml-2 b">
                    <div class="form-group">
                        <label><?php echo $_GET['to']; ?></label>
                        <input type="text" data-provide="datepicker" data-date-autoclose="true" class="form-control to-date form-control-sm" placeholder="To" value="<?php echo date('d/m/Y'); ?>">
                    </div>
                </div>
                <div class="col-3">
                    <button type="button" class="btn btn-info btn-sm check-o-sales">Check</button>
                </div>
            </div>
                                <div class="table-responsive">
                                    <table class="table table-hover m-b-0">
                                        <thead>
                                            <tr>
                                                <th><?php echo $_GET['order']; ?> #</th>
                                                <th><?php echo $_GET['quantity']; ?></th>
                                                <th><?php echo $_GET['amount']; ?></th>
                                            </tr>
                                        </thead>
                                        <tbody class="render-soitems">

                                        </tbody>
                                    </table>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal -->
    <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="">
            <div class="modal-content" style="min-height:90vh;">
                <div class="col-12 mt-3">
                    <h5 style="margin-bottom:0px">Order #: <span class="orderno" style="margin-left:7px"></span></h5>
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9;margin-top: -30px;">
                        <button class="btn btn-danger btn-sm">x</button>
                    </span>
                    <div>Created by: <b class="ordered_by" style="margin-left:10px"></b></div>
                    <div class="customer-order">Customer name: <b class="customer-order-name"></b></div>
                </div>
                <div class="modal-body p-0 pb-4">
                    <div class="col-sm-12 col-12" style="height: 73vh;padding-bottom: 5vh; overflow-y: scroll;">
                        <div class="custom-o-nu-block">
                            <span>Custom order #</span>
                            <input type="text" class="form-control form-control-sm set-cutom-no" name="conu" placeholder="0" value="">
                        </div>
                        <div class="table-responsive">
                            <table class="table table-borderless m-b-0 c_list">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Items list</th>
                                    </tr>
                                </thead>
                                <tbody class="order-list sold-products2">
                                    
                                </tbody>
                                <tbody class="total-row">
                                    <tr>
                                        <td>
                                            <div class="row jumla-b" style="">
                                                <div class="jumla-o" style=""><?php echo $_GET['total']; ?></div>
                                                <div class="jumla-n" style="">
                                                    <div>
                                                        <span style="padding-right: 3px;font-weight: 100;">
                                                            <?php echo $_GET['quantity-full']; ?>
                                                        </span>:<span class="pl-1 totaloQ"></span>
                                                    </div>
                                                    <div>
                                                        <span  style="padding-right: 8px;font-weight: 100;"><?php echo $_GET['amount']; ?></span>:<span class="pl-1 totaloP"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>

                <tbody class="order-pay-block">
                    <tr style="display: block;"><td style="display: block;">
                        <h5 style="display:none;"><span style="font-size:13px;padding-right:10px">Total:</span><span class="o-amounttopay"></span></h5>
                        <div class="scustomer">
                            <!-- <br> -->
                            <!-- <h5>Paid amount </h5> -->
                            <span style="font-size:13px;padding-right:10px">Paid amount</span>
                            <input type="number" name="" class="form-control o-paidamount px-0" value="0" style="margin-left: auto;margin-right: auto;text-align: center;font-size: 1.5rem;width: 180px;">
                        </div>
                        <h5 class="my-3"><span style="font-size:13px;padding-right:10px">Change:</span><span class="o-change"></span></h5>
                    </td></tr>
                </tbody>
                            </table>

                            @if($isCashier)
                            <!-- <div class="scustomer2 mb-4" align="center" style="">
                                <br>
                                <h5>Paid amount </h5>
                                <input type="number" name="paidamount2" class="form-control paidamount2 px-0" style="margin-left: auto;margin-right: auto;text-align: center;font-size: 2rem;">
                            </div> -->
                            @endif
                        </div>
                    </div>
                    <div class="col-12 align-center order-footer">
                        @if($isCashier)
                            <button class="btn btn-info btn-sm pay-order-btn ml-3">Pay <i class="fa fa-dollar"></i></button>
                            <button type="button" class="btn btn-primary btn-sm submit-saleo">Sell it <i class="fa fa-shopping-cart"></i></button>
                            <button type="button" class="btn btn-success btn-sm submit-saleo-print">Sell and print <i class="fa fa-shopping-cart"></i></button>
                        @endif
                        <span class="hidden-btn" style="display:none">
                            <!-- <a href="" class="btn btn-info btn-sm edit-sorder">Update changes <i class="fa fa-check"></i></a> -->
                            <button class="btn btn-info btn-sm print-order-btn" id="printOrder" value="click">Print order <i class="fa fa-print"></i></button>
                            <button type="button" class="btn btn-danger delete-sorder btn-sm ml-3">Cancel order <i class="fa fa-times"></i></button>
                        </span>
                    </div>
                    <!-- print btn for sold orders -->
                    <div class="col-12 align-center order-sold-footer" style="display:none">
                        <button class="btn btn-info btn-sm print-order-btn" id="printOrder" value="click">Print order <i class="fa fa-print"></i></button>
                    </div>

                    <!-- printed area -->
                    <div class="col-sm-12 col-12">
                        <div id="printed-order" style="">
                            <div class="printed-order" style="">
                                <div class="head" style="">
                                    <p style="text-align: center;">{{$data['shop']->name}}</p>
                                    <p style="text-align: center;">{{$data['shop']->location}}</p>
                                    <div style="text-align:left;">Order #: <span class="orderno"></span></div>
                                    <div style="text-align:left;">Cashier: <span class="">{{Auth::user()->name}}</span></div>
                                    <div class="show-custom-no" style="margin-top: 20px;display: none;"><span style="font-size:2rem;font-weight:bolder;margin-bottom: 0px;padding-bottom: 0px;">A42</span></div>
                                    <h5 style="margin-top: 40px;text-align:left;">Ordered Items</h5>
                                </div> 
                                <div class="" style="">
                                    <table class="">
                                        <thead class="thead-light">
                                            
                                        </thead>
                                        <tbody class="render-order-to-print sold-products2">
                                            
                                        </tbody>
                                        <tbody class="total-row"> 
                                            <tr> 
                                        <td> 
                                            <div class="row jumla-b" style="">
                                                <div class="jumla-o" style="margin-right: 20px"><?php echo $_GET['total']; ?></div>
                                                <div class="jumla-n" style="">
                                                    <div style="">
                                                        <span style="padding-right: 3px;font-weight: bolder;">
                                                            <?php echo $_GET['quantity-full']; ?>
                                                        </span>:<span class="pl-1 totaloQ"></span>
                                                    </div>
                                                    <div>
                                                        <span  style="padding-right: 8px;font-weight: bolder;"><?php echo $_GET['amount']; ?></span>:<span class="pl-1 totaloP"></span>
                                                    </div>
                                                    <div>
                                                        <span  style="padding-right: 8px;font-weight: bolder;"><?php echo $_GET['paid-amount']; ?></span>:<span class="pl-1 totaloPA"></span>
                                                    </div>
                                                    <div>
                                                        <span  style="padding-right: 8px;font-weight: bolder;"><?php echo $_GET['change']; ?></span>:<span class="pl-1 totaloCA"></span>
                                                    </div>
                                                    <div style="margin-top: 30px;margin-bottom: 30px;">
                                                        Thank you for choosing us.
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <div class="modal fade" id="saleModal" tabindex="-1" role="dialog" aria-labelledby="saleModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="col-12 mt-3">
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                        <button class="btn btn-danger btn-sm">x</button>
                    </span>
                </div>
                <div class="modal-body align-center mb-4">
                    <p class="scustomer"><span>Customer: </span> <b class="customername" style="font-size: 1rem;"></b></p>
                    <h5>Amount to be paid</h5>
                    <h4 class="amounttopay"></h4>
                    <div class="scustomer">
                        <br>
                        <h5>Paid amount </h5>
                        <input type="number" name="paidamount" class="form-control paidamount px-0" style="margin-left: auto;margin-right: auto;text-align: center;font-size: 2rem;">
                    </div>
                    <div class="col-12 mt-5">
                        <button type="button" class="btn btn-success px-3 submit-sale-cart2" style="font-size:1.2rem"><b>Sale <i class="fa fa-check"></i></b> </button>
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <!-- choose category modal -->
    <div class="modal fade" id="cats-to-sale" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h5" id="mySmallModalLabel">Choose category</h5>
                    <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body mb-4">
                    <p class="cats" value="0">Recently</p>
                    @if(!$data['categories']->isEmpty())
                        @foreach($data['categories'] as $category)
                            <p class="cats" value="{{$category->id}}"><?php echo $category->name." ( ".$category->categorygroup->name." )"; ?></p>
                        @endforeach
                    @else
                        <p disabled><i>- no category -</i></p>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

<script type="text/javascript">
    $('.select2').select2();

    var fromdate = $('.from-date').val();
    fromdate = fromdate.split('/').join('-');
    var todate = $('.to-date').val();
    todate = todate.split('/').join('-');

      // lang sale type
      $(document).on('click', '.sale-opt .badge', function(e){ 
          $('.sale-drop').css('display','block');
      });
      $(document).on('click', '.switch-sale-opt', function(e){ 
        e.preventDefault();
          var opt = $(this).attr('check');
          
          if (opt == "category") {
            $('.sale-opt .badge').html("<?php echo $_GET['sale-by-category']; ?> <i class='fa fa-angle-down'></i>");
            $(this).html("<?php echo $_GET['sale-by-search']; ?>").attr("check","search");
            $('.sale-search-block').css('display','none');
            $('.cats-block').css('display','block');
            history.replaceState({}, document.title, "?sale-type=category");
          } else {
            $('.sale-opt .badge').html("<?php echo $_GET['sale-by-search']; ?> <i class='fa fa-angle-down'></i>");
            $(this).html("<?php echo $_GET['sale-by-category']; ?>").attr("check","category");
            $('.cats-block').css('display','none');
            $('.sale-search-block').css('display','block');
            history.replaceState({}, document.title, "?sale-type=search");
          }
          // $.get('/switch-lang/'+opt, function(data){
          //     location.reload();
          // });
      });

    var shop_id = $('[name="shopid"]').val();

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
        $('.tsales, .tqty, .texp').html('--');
        $('.tameweka-b,.trefund-b,.ttumelipa-b,.tdeni-b').css('display','none');
        $('.returned-items,.render-oitems').html("<tr><td colspan='3' align='center'>Loading...</td></tr>");
        $('.items-in-cart').append('<tr class="asloader"><td><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i> Loading...</td></tr>');
        $('.recent-cat button').click();

        let searchParams = new URLSearchParams(window.location.search);
        if (searchParams.has('sale-type')) {
            if (searchParams.get('sale-type') == "search") {
                $('.switch-sale-opt').click();
                // $('.sale-search-block').css('display','block');
            } else {
                $('.cats-block').css('display','block');
            }
        } else {
            if ($(window).width() <= 767) {
                $('.switch-sale-opt').click();
            } else {
                $('.cats-block').css('display','block');
            }            
        }

        $.get('/search-product/shop/sales/'+shop_id+'/sdfvaafv', function(data) {    
            $('.sloader').css('display','none');   
            $('.search-block').html(data.products);
        }); 

        $.get('/pending-sale/shop/'+shop_id, function(data){  
            $('.asloader').hide();        
            if (data.item) {
                $('.customer').val(data.item.customer_id).change();
                $('.show-customer').click();
            }
            
            $('.items-in-cart').append(data.items);
            $('.totalQ').html(parseFloat(data.totalQ));
            $('.totalP').html(data.totalP);
        });
        $.get('/sales-summary/today/'+shop_id, function(data){ 
            $('.tsales').html(data.data.today_price);
            $('.tqty').html(parseFloat(data.data.today_quantity));
            $('.texp').html(data.data.today_expenses);
            if (data.data.today_deni != 0) {
                $('.tdeni-b').css('display','');
                $('.tdeni').html(data.data.today_deni);
            }
            if (data.data.today_ameweka != 0) {
                $('.tameweka-b').css('display','');
                $('.tameweka').html(data.data.today_ameweka);
            }
            if (data.data.today_refund != 0) {
                $('.trefund-b').css('display','');
                $('.trefund').html(data.data.today_refund);
            }
            if (data.data.today_paydebt != 0) {
                $('.ttumelipa-b').css('display','');
                $('.ttumelipa').html(data.data.today_paydebt);
            }
            var ava_cash = Math.floor(data.data.today_price.replace(/,/g, '')) - Math.floor(data.data.today_expenses.replace(/,/g, '')) - Math.floor(data.data.today_deni.replace(/,/g, '')) + Math.floor(data.data.today_ameweka.replace(/,/g, '')) - Math.floor(data.data.today_refund.replace(/,/g, '')) - Math.floor(data.data.today_paydebt.replace(/,/g, ''));
            $('.ava_cash, .exp_cash').val(ava_cash);
        });
        $.get('/pendingorders/shop/'+shop_id, function(data){ 
            $('.render-oitems').html(data.items);
            soldorders(shop_id,fromdate,todate);
        });
    });

    function soldorders(shop_id,fromdate,todate) {
        $('.render-soitems').html("<tr><td colspan='3' align='center'>Loading...</td></tr>");
        shopdate = shop_id+"~"+fromdate+"~"+todate;
        $.get('/soldorders/shop/'+shopdate, function(data){ 
            $('.render-soitems').html(data.items);
        });
    }

    $(document).on('click', '.check-o-sales', function(e) {
        e.preventDefault();
        var fromdate = $('.from-date').val();
        fromdate = fromdate.split('/').join('-');
        var todate = $('.to-date').val();
        todate = todate.split('/').join('-');
        soldorders(shop_id,fromdate,todate);
    });

    $(document).on('click', '.print-order-btn', function(e) {
        e.preventDefault();     
        var ono = $(this).attr('order');
        var custom_ono = $('.set-cutom-no').val();        
        ono = ono+"~"+custom_ono;
        $.get('/order-items/list-printable/'+ono, function(data){     
            if (custom_ono) {
                $('.show-custom-no').css('display','block'); $('.show-custom-no span').html(custom_ono);
            }         
            $('.render-order-to-print').html(data.items);
            $('.totaloQ').html(parseFloat(data.data.totaloQ));
            $('.totaloP, .o-amounttopay').html(data.subtotal);
            $('.ordered_by').html(data.data.creator);
            $('.totaloPA').html(Number($('.o-paidamount').val()).toLocaleString("en"));
            $('.totaloCA').html($('.o-change').text().toLocaleString("en"));

            var divContents = document.getElementById("printed-order").innerHTML;
            var a = window.open('', '', 'height=500, width=500');
            a.document.write('<html><head>');
            a.document.write("<link href='/css/print.css' rel='stylesheet' type='text/css' media='print'");
            a.document.write('</head><body >');
            a.document.write(divContents);
            a.document.write('</body></html>');
            a.document.close();
            a.print();
            // a.close();

            $.get('/pendingorders/shop/'+shop_id, function(data){ 
                $('.render-oitems').html(data.items);
            });
        });
    });

    $(document).on('click', '.submit-saleo-print', function(e) {
        e.preventDefault();
        $('.print-order-btn').click();
        $('.submit-saleo').click();
    });

    $(document).mouseup(function(e) {
        var container = $(".other-cats");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
          var classes = $('.fa-angle-double-down').parent().closest('div').attr('class');
          $('.'+classes).click();
        }
    });

    $(document).on('click', '.inside-s-c .searched-item', function(e) {
        e.preventDefault();
        if ($(window).width() <= 575) {
            $('html, body').animate({
                'scrollTop' : $(".scroll-to-c").position().top
            });
        }
    });

    $(document).on('click', '.pay-order-btn', function(e) {
        e.preventDefault();
        if($(this).hasClass('show')) {
            $(this).removeClass('show');
            $('.order-pay-block').css('display','none');
        } else {
            $(this).addClass('show');
            $('.order-pay-block').css('display','block');
        }        
    });

    $(document).on('click', '.cats', function(e) {
        e.preventDefault();
        $('.cats').removeClass('active'); $(this).addClass('active');
        var cat_id = $(this).attr('value');
        var shop_pcat = shop_id+'-'+cat_id;
        $('.inside-s-c').html('<i class="fa fa-spinner fa-spin" style="font-size:20px;"></i><span class="ml-1">Loading..</span>');
        // check for other cats dropdown
        var container = $(".other-cats");
        if (!container.is(e.target) && container.has(e.target).length === 0) { } else {$(".cat-scroll").click();}
        // end checking        
        let searchParams = new URLSearchParams(window.location.search); 
        $.get('/cashier/'+shop_pcat+'/products-by-cat', function(data){
            if (data.products) {
                $('.c-title').html(data.category);
                $('.inside-s-c').html(data.products);
            }
        });
    });

    $(".customer").on('change', function(e) {
        e.preventDefault();
        var customer_id = $(this).val();
        if (customer_id == '') {
            customer_id = 'null';
        }
        $('[name="customer"]').val(customer_id);
        $.get('/update-customer-onsale/'+shop_id+'/'+customer_id, function(data){
            if (data.customer) {
                $('.customername').html(data.customer.name);
            }
        });
    });

    $(document).on('click', '.remove-sr', function(e){
        e.preventDefault();
        var id = $(this).attr('val');
        $.get('/remove-sale-row/sale/'+shop_id+'/'+id, function(data){
            if (data.error) {
                popNotification('warning',data.error);
            }
            if (data.success) {
                $('.sr-'+data.id).closest("tr").remove();
                $('.totalQ').html(parseFloat(data.data.quantity));
                $('.totalP').html(Number(data.data.price).toLocaleString("en"));
            }            
        });
    });

    $(document).on('click', '.remove-sor', function(e){
        e.preventDefault();
        var id = $(this).attr('val');
        $.get('/remove-sale-row/order/'+shop_id+'/'+id, function(data){
            if (data.error) {
                popNotification('warning',data.error);
            }
            if (data.success) {
                $('.sor-'+data.id).closest("tr").remove();
                $('.totaloQ').html(parseFloat(data.data.totaloQ));
                $('.totaloP, .o-amounttopay').html(data.subtotal); $('.o-paidamount').val(data.subtotal.replace(/,/g, ''));
                $('.o-change').html(0);
                $('.paidamount2').val(data.data.totaloP);
            }            
        });
    });

    $(document).on('click', '.order-items', function(e) {
        e.preventDefault();
        $('.order-list').html("<tr><td>Loading...</td></tr>");
        $('.totaloQ').html("-");$('.totaloP, .o-amounttopay').html("-");$('.ordered_by').html("-");
        $('.hidden-btn,.order-footer,.customer-order,.scustomer2,.order-pay-block').css("display","none");
        $('.pay-order-btn').removeClass("show");
        $('.custom-o-nu-block').css('display','');
        $('.set-cutom-no').prop('disabled',false);
        $('#orderModal').modal('toggle');
        var ono = $(this).attr('order');
        $('.orderno').html(ono);
        $('.delete-sorder, .submit-saleo, .print-order-btn').attr("order",ono);
        $.get('/order-items/list/'+ono, function(data){
            if (data.error) {
                popNotification('warning',data.error);
                return;
            }
            if (data.data.status != "sold") {
                $('.order-footer').css("display","");$('.order-sold-footer').css("display","none");
            } else {
                $('.order-sold-footer').css("display","");$('.order-footer').css("display","none");
                $('.set-cutom-no').prop('disabled',true);
                if (data.data.custom_no) {} else {
                    $('.custom-o-nu-block').css('display','none');
                }
            }
            if (data.data.canchange == "yes") {
                $('.hidden-btn').css("display","");
            }
            $('.set-cutom-no').val(data.data.custom_no);
            $('.order-list').html(data.items);
            $('.totaloQ').html(parseFloat(data.data.totaloQ));
            $('.totaloP, .o-amounttopay').html(data.subtotal); $('.o-paidamount').val(data.subtotal.replace(/,/g, ''));
            $('.o-change').html(0);
            $('.ordered_by').html(data.data.creator);
            if (data.data.customer) {
                $('.customer-order,.scustomer2').css('display','');
                $('.paidamount2').val(data.data.totaloP);
                $('.customer-order-name').html(data.data.customer);
            }
        });
    });

    $(document).on('keyup', '.o-paidamount', function(e){
        e.preventDefault();
        var paid = $(this).val();
        $('.o-change').html(Number(Number(paid) - Number($('.o-amounttopay').text().replace(/,/g, ''))).toLocaleString("en"));
    });

    $(document).on('click', '.delete-sorder', function(e) {
        var ono = $(this).attr('order');
        if(confirm("Click OK to confirm that you delete order No. "+ono)){
            $('.full-cover').css('display','block');
            $('.full-cover .inside').html('Deleting...');
            $.get('/order-items/delete/'+ono, function(data){
                $('.full-cover').css('display','none');
                if (data.error) {
                    popNotification('warning',data.error);
                    return;
                }
                if (data.success) {
                    $('.or-'+data.ono).closest("tr").remove();
                    $('#orderModal').modal('hide');
                    popNotification('success',"The order is deleted successfully.");
                    return;
                }
            });
        }
        return;
    });

    $(document).on('click', '.submit-saleo', function(e) {
        var ono = $(this).attr('order');
        var custom_ono = $('.set-cutom-no').val();
        $('.full-cover').css('display','block');
        $('.full-cover .inside').html('Submitting...');
        // paidamount is attached if a certain order has customer_id
        var paidamount = $('.paidamount2').val();
        if (paidamount) {} else {
            paidamount = "-";
        }
        ono = paidamount+"~"+ono+"~"+custom_ono;
        $.get('/order-items/sold/'+ono, function(data){
            $('.full-cover').css('display','none');
            if (data.error) {
                popNotification('warning',data.error);
                return;
            }
            if (data.success) {
                var row = $('.or-'+data.ono).html();
                $('.or-'+data.ono).remove();
                $('.render-soitems').prepend('<tr>'+row+'</tr>');
                $('#orderModal').modal('hide');
                popNotification('success',"The order is sold successfully.");
                return;
            }
        });
    });

    $(document).on('keyup', '.quantity', function(e){
        e.preventDefault();console.log('ss');
        var id = $(this).attr('rid');
        var qty = $(this).val();
        $.get('/update-sale-quantity/sale/'+shop_id+'/'+id+'/'+qty, function(data){
            if (data.error) {
                popNotification('warning',data.error);
                return;
            }            
            $('.srp-'+data.id).html(data.data.subtotal);
            $('.totalQ').html(parseFloat(data.data.quantity));
            $('.totalP').html(Number(data.data.price).toLocaleString("en"));            
        });
    });

    $(document).on('keyup', '.soquantity', function(e){
        e.preventDefault();
        var id = $(this).attr('rid');
        var qty = $(this).val();
        $.get('/update-sale-quantity/order/'+shop_id+'/'+id+'/'+qty, function(data){
            if (data.error) {
                popNotification('warning',data.error);
                return;
            }            
            $('.totaloP-'+data.id).html(data.data.subsubtotal);
            $('.totaloQ').html(parseFloat(data.data.totaloQ));
            $('.totaloP, .o-amounttopay').html(data.subtotal); $('.o-paidamount').val(data.subtotal.replace(/,/g, ''));
            $('.o-change').html(0);        
            $('.paidamount2').val(data.data.totaloP);
        });
    });

    $(document).on('keyup', '.sprice', function(e){
        e.preventDefault();
        var id = $(this).attr('rid');
        var price = $(this).val();
        $.get('/update-sale-price/sale/'+shop_id+'/'+id+'/'+price, function(data){
            if (data.error) {
                popNotification('warning',data.error);
                return;
            }            
            $('.srp-'+data.id).html(data.data.subtotal);
            $('.totalP').html(Number(data.data.price).toLocaleString("en"));            
        });
    });
    $(document).on('keyup', '.soprice', function(e){
        e.preventDefault();
        var id = $(this).attr('rid');
        var price = $(this).val();
        $.get('/update-sale-price/order/'+shop_id+'/'+id+'/'+price, function(data){
            if (data.error) {
                popNotification('warning',data.error);
                return;
            }            
            $('.totaloP-'+data.id).html(data.data.subsubtotal);
            $('.totaloP, .o-amounttopay').html(data.subtotal); $('.o-paidamount').val(data.subtotal.replace(/,/g, ''));
            $('.o-change').html(0);          
            $('.paidamount2').val(data.data.totaloP);  
        });
    });

    $(document).on('click', '.clear-sale-cart', function(e) {
        e.preventDefault();
        $('button').prop('disabled', true);
        $('.fa-spin').css('display','');
        $.get('/clear-sale-cart/'+shop_id, function(data){
            location.reload();
        });
    });

    $(document).on('click', '.submit-order-cart', function(e){
        e.preventDefault();
        $('button').prop('disabled', true);
        $('.fa-spin').css('display','');
        var price = $('.totalP').text();
        $.get('/submit-sale-cart/order/'+shop_id+'/'+price, function(data){
            location.reload();
        });
    });

    $(document).on('click', '.submit-sale-cart', function(e){
        e.preventDefault();
        var customer = $('.scroll-to-c [name="customer"]').val();
        var price = $('.totalP').text();
        var price2 = price.replace(/,/g, '');
        $('[name="paidamount"]').val(price2);
        $('.amounttopay').html(price);
        if (customer) {
            $('.scustomer').css("display","block");
        } else {
            $('.scustomer').css("display","none");
        }
        $('#saleModal').modal('toggle');
        $.get('/update-customer-onsale/'+shop_id+'/'+customer, function(data){
            if (data.customer) {
                $('.customername').html(data.customer.name);
            }
        });
    });
    $(document).on('click', '.submit-sale-cart2', function(e){
        e.preventDefault();
        $('button').prop('disabled', true);
        $('.fa-spin').css('display','');
        var paidamount = $('[name="paidamount"]').val();
        if (paidamount) {} else { 
            paidamount = "-";
        }
        $.get('/submit-sale-cart/sale/'+shop_id+'/'+paidamount, function(data){
            location.reload();
        });
    });

    $(document).on('click', '.closure-sale', function(e){
        e.preventDefault();
        $(this).prop('disabled', true).html("Submitting..");
        var e_cash = $('.exp_cash').val();
        var cash = $('.ava_cash').val();
        if (cash == 0 || cash == null) {
            popNotification('warning',"Sorry! you cant submit 0 cash");
            return;
        }
        $.get('/submit-ava-cash/'+e_cash+'/'+cash+'/'+shop_id, function(data){
            $('.closure-sale').prop('disabled', false).html("Close Sales");
            popNotification('success','Available cash is submitted successfully');
            return;
        });
    });


</script>
@endsection