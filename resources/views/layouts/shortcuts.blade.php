
<style type="text/css">
    .card.shortcut {margin-left: 15px;margin-right: 15px;}
    .card.shortcut .body {color: #444 !important;}
    .card.shortcut .body h2 {
        font-size: 18px;
        font-weight: bold;
        color: #444;
        position: relative;
    }
    .card.shortcut .body a {display: block;margin-bottom: 2px;}
    .card.shortcut .body a:hover {text-decoration: underline;}
    .card.shortcut .body a .fa {font-size: 12px;}
    .ul-center {font-size: 18px;}
    /* .ul-summary-b a {font-size: 1rem;} */
    .ul-summary.mb-3 {margin-bottom: 0.7rem !important;}
    @media screen and (max-width: 767px) {
        .card.shortcut .col-4 {padding-left: 0px;padding-right: 0px;}
        .card.shortcut .col-4 .body {padding-top: 10px;padding-bottom: 10px;}
    }
    @media screen and (max-width: 565px) {
        .ul-summary {
            padding-left: 20px;
        }
    }
    @media screen and (max-width: 520px) {
        .card.shortcut {margin-left: 5px;margin-right: 5px;}
        .card.shortcut .col-4 .body {padding-left: 10px;padding-right: 10px;}
        .card.shortcut .body h2 {font-size: 16px;}
        .card.shortcut .col-4 .body a {font-size: 12px;}
    }
    @media screen and (max-width: 480px) {
        .card.shortcut .body h2 {margin-bottom: 10px;}
        /*.card.shortcut .col-4 .body a {display: block;margin-bottom: -12px; padding: 0px;}*/
        .card.shortcut .body {padding-bottom: 20px !important;}
        .ul-col-t-l { padding-right: 0px; }
        .ul-col-t-l .header { padding-left: 10px;padding-right: 10px; }
        .ul-col-t-r { padding-left: 0px; }
        .ul-summary {
            padding-left: 20px;
        }
        .ul-summary-b {
            padding-left: 5px !important;padding-right: 5px !important;
        }
        .ul-center {font-size: 15px;}
    }
    @media screen and (max-width: 450px) {
        .card.shortcut .col-4 .body {padding-left: 5px;padding-right: 5px;}
    }
    @media screen and (max-width: 391px) {
        .card.shortcut .col-4 .body a {margin-right: -5px;}
        .ul-center {padding-left: 10px;}
    }
    @media screen and (max-width: 391px) {
        .card.shortcut .col-4 .body a span {margin-left: -5px;}
    }
</style>

<?php 
$productsLink = "#";
$shopsLink = "#";
$salesReportLink = "#";
if(Auth::user()->isCEOorAdminorBusinessOwner()) {
    $productsLink = "/products";
    $salesReportLink = "/report/sales";
}
if(Auth::user()->isCEOorAdminorBusinessOwner() || Auth::user()->isCashier()) {
    $shopsLink = "/shops";
}
?>

<div class="col-12">
    <div class="row">
        <div class="col-5 ul-col-t-l">
            <div class="card">
                <div class="header py-2" style="background-color: #01b2c6;">
                    <a href="{{$productsLink}}"><h2 style="color: #fff;"><i class="icon-layers mr-2"></i> <?php echo $_GET['products-menu']; ?> <i class="fa fa-arrow-right float-right"></i></h2></a>
                </div>
                <div class="body ul-summary-b pt-2">
                    <span>Jaza</span>
                    <ul class="ul-summary mb-0">
                        <li>Kategori za bidhaa</li>
                        <li>Bidhaa</li>
                        <li>Idadi za bidhaa</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-2 pt-4 ul-center" align="center">
            <div><b><?php echo $_GET['then']; ?></b></div>
        </div>
        <div class="col-5 ul-col-t-r">
            <div class="card pb-2">
                <div class="header py-2" style="background-color: #01b2c6;">
                    <a href="{{$shopsLink}}"><h2 style="color: #fff;"><i class="fa fa-dollar mr-2"></i> <?php echo $_GET['sales-menu']; ?> <i class="fa fa-arrow-right float-right"></i></h2></a>
                </div>
                <div class="body ul-summary-b pt-2">
                    <ul class="ul-summary mb-3">
                        <li>Bonyeza jina la duka </li>
                        <li>Uza bidhaa</li>
                        <li>Ona ripoti ya mauzo</li>
                    </ul>
                    <span class="float-right"><a href="{{$salesReportLink}}">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" style="width:15px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                        </svg> <span style="font-size: 0.9rem;"><?php echo $_GET['sales-report-menu']; ?></span></a></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shortcut" style="display: none;"> 
    <div class="header">
        <h2><?php echo $_GET['shortcuts']; ?></h2>
    </div>
    <div class="body pt-0">
        <div class="row clearfix">
            <div class="col-md-4 col-4">  
                <div class="body xl-salmon text-light pb-2">
                    <h2><i class="icon-layers mr-2"></i> <?php echo $_GET['products-menu']; ?></h2>
                    <!-- check to add product -->
                    @if(Auth::user()->isCEOorAdminorBusinessOwner())
                        <b>Jaza na tazama bidhaa na kategori zake</b>
                        <a class="mt-2" href="/products"><i class="fa fa-arrow-right mr-1"></i> <?php echo $_GET['click-here']; ?></a>
                        <!-- <a href="/products?opt=product-cat"><i class="fa fa-arrow-right mr-1"></i> <?php //echo $_GET['p-categories-menu']; ?></a> -->
                    @endif
                    @if(Auth::user()->isCEOorAdmin())                       
                        <!-- <a href="/products?opt=add-product"><i class="fa fa-arrow-right mr-1"></i> <?php //echo $_GET['add-product-menu']; ?></a> -->
                    @endif
                    <!-- check for stock reports -->
                    @if(Auth::user()->isCEOorAdminorBusinessOwner())
                        <!-- <a href="/products?opt=products"><i class="fa fa-arrow-right mr-1"></i> <span><?php //echo $_GET['available-products']; ?></span></a> -->
                    @elseif(Session::get('role') == 'Cashier')
                        <a href="/cashier/{{$data['shop']->id}}/products"><i class="fa fa-arrow-right mr-1"></i> <?php echo $_GET['available-products']; ?></a>
                    @elseif(Session::get('role') == 'Store Master')
                        <a href="/store-master/{{$data['store']->id}}/products"><i class="fa fa-arrow-right mr-1"></i> <?php echo $_GET['available-products']; ?></a>
                    @endif
                    
                </div>
            </div>
            <div class="col-md-4 col-4">
                <div class="body xl-blue text-light pb-2">
                    <h2><i class="icon-basket-loaded mr-2"></i> <?php echo $_GET['stock-menu']; ?></h2>
                    <!-- check to add stock -->
                    @if(Auth::user()->isCEOorAdmin()) 
                        <!-- <a href="/stock?tab=add-stock"><i class="fa fa-arrow-right mr-1"></i> <?php //echo $_GET['add-stock']; ?></a> -->
                    @endif
                    <!-- check for stock reports -->
                    @if(Auth::user()->isCEOorAdminorBusinessOwner())
                        <b>Jaza na tazama idadi za bidhaa (stock)</b>
                        <a class="mt-2" href="/products?opt=stock&sval=overview"><i class="fa fa-arrow-right mr-1"></i> <?php echo $_GET['click-here']; ?></a>
                        <!-- <a href="/stock?tab=available-stock"><i class="fa fa-arrow-right mr-1"></i> <?php //echo $_GET['stock-report-menu']; ?></a> -->
                    @elseif(Session::get('role') == 'Cashier')
                        <a href="/cashier/{{$data['shop']->id}}/stock"><i class="fa fa-arrow-right mr-1"></i> <?php echo $_GET['stock-report-menu']; ?></a>
                    @elseif(Session::get('role') == 'Store Master')
                        <a href="/store-master/{{$data['store']->id}}/stock"><i class="fa fa-arrow-right mr-1"></i> <?php echo $_GET['stock-report-menu']; ?></a>
                    @endif
                </div>
            </div>
            @if(Auth::user()->isCEOorAdminorBusinessOwner() || Auth::user()->isCashier())
            <div class="col-md-4 col-4">
                <div class="body xl-turquoise text-light pb-3">
                    <h2><i class="fa fa-dollar mr-2"></i> <?php echo $_GET['sales-menu']; ?></h2>
                    <!-- check to sell products -->
                    @if(Auth::user()->isCEOorAdminorCashier())
                    <a class="click-shortcut" check="sell" href="#"><i class="fa fa-arrow-right mr-1"></i> <?php echo $_GET['sell-products']; ?></a>
                    @endif  
                    <!-- check for sales reports -->
                    @if(Auth::user()->isCEOorAdminorBusinessOwner())
                        <a href="/report/sales"><i class="fa fa-arrow-right mr-1"></i> <?php echo $_GET['sales-report-menu']; ?></a>
                    @elseif(Session::get('role') == 'Cashier')
                        <a href="/cashier/{{$data['shop']->id}}/sales-report"><i class="fa fa-arrow-right mr-1"></i> <?php echo $_GET['sales-report-menu']; ?></a>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>