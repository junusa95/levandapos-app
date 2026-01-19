@extends('layouts.app')
@section('css')
<style type="text/css">
    .tab_btn {cursor: pointer;}
    .p_image_preview {
        padding-top: 4px;display: none;
    }
    .p_image_preview img {
        width: 100px;height: 100px;object-fit: cover;
    }
    .nav-out {padding-bottom: 15px;border-bottom: 1px solid #ddd;}
    #cont.nav {display: block;}
    #cont {
      min-width: 202px;padding-right: 27px;
      /*border: 1px solid #0f0;*/
      overflow: hidden;
      overflow-x: auto !important;
      overflow-y: hidden;
      white-space: nowrap;
    }
    .products-card ul.nav {padding-bottom: 10px;}
    #cont .nav-item{
      display: inline-block;
      /*margin:20px;*/  
      min-width: 50px;
    }
    .products-card .tabs-drop {
        position: absolute;
        right: 0;
        background-color: #000;
        color: white;
        /* padding: 7px 5px 7px 10px; */
        /* min-width: 30px; */
        cursor: pointer;
        -moz-box-shadow: 3px 3px 5px 6px #ccc;
        -webkit-box-shadow: 3px 3px 5px 6px #ccc;
        box-shadow: -3px 0px 4px 0px #ccc;
    }
    .products-card .stock-h .tabs-drop {
        margin-top: -28px;
        padding: 2.5px 5px 2.5px;
    }
    .products-card .tabs-drop i {font-size: 20px;}
    .products-card .other-tabs, .products-card .other-stock-h {
        background-color: #f0f0f0;
        position: absolute;
        right: 0px;min-width: 150px;
        z-index: 9;
        /* margin-top: 36px; */
        display: none;
        margin-top: 0px;
        -moz-box-shadow: 3px 3px 5px 6px #ccc;
        -webkit-box-shadow: 3px 3px 5px 6px #ccc;
        box-shadow: -3px 3px 4px 0px #ccc;
    }
    .products-card .other-tabs ul.nav, .products-card .other-stock-h .tbs {display: block;padding-right: 0px;}
    .products-card .other-tabs ul.nav .nav-item {
        display: block;
    }
    .products-card .other-stock-h .tbs {
        padding: 1px 3px;cursor: pointer;
    }
    .products-card .other-stock-h .tbs:hover {
        background-color: #dcf5ef;
    }
    .products-card .other-tabs ul.nav .nav-item a.active, .products-card .other-stock-h .tbs.active {
        /* background: #01b2c6;color: #fff; */
        background-color: #dcf5ef;border-bottom: 1px solid #17a2b8;
    }
    .first-td {white-space: normal !important;word-wrap: break-word;width: 50% !important;padding-right: 0px;}
    .first-td .outer-span {display:inline-flex;}

    .stock-o-h {
        padding-left: 0px !important;padding-right: 0px !important;
    }
    .stock-h {
        margin-left: 0px;margin-right: 0px;
        min-width: 202px;padding-right: 27px;
        /*border: 1px solid #0f0;*/
        overflow: hidden;
        overflow-x: auto !important;
        overflow-y: hidden;
        white-space: nowrap;
    }
    .stock-h .tbs {
        padding: 3px; display: inline-block;background: #e2e2e2;cursor: pointer;color: #000;
    }
    .stock-h .tbs:hover {
        background-color: #dcf5ef;
    }
    .stock-h .tbs.active {
        background-color: #dcf5ef;border-bottom: 1px solid #17a2b8;
    }
    .add-p-block .header h2, .add-s-block .header h2 {
        display: inline-block;
    }

    @media screen and (max-width: 767px) {
        .tab-cont-out {padding-left: 0px;padding-right: 0px;}
        .products-card .other-tabs {margin-top: 33px;}
        .products-card .other-tabs ul.nav {margin-left: 0px;}
        .products-card .tabs-drop {
            padding: 3px 5px 3px 10px;font-size: 18px;
        }
        .products-card ul.nav .nav-item a {
            padding: 5px 10px;
        }
    }
  @media screen and (max-width: 600px) {
    .nav-out {padding-left: 5px;padding-right: 5px; }
    #cont.nav-tabs-new li a {padding: 5px 10px;}
    }
  @media screen and (max-width: 535px) {
    .first-td {padding-right: 3px !important;}
    .first-td .outer-span, .first-td .outer-span span {display:block;}
    }
@media screen and (min-width: 482px) and (max-width: 590px) {
    .add-p-block .body {padding-left: 5px;padding-right: 0px;}
}
@media screen and (max-width: 481px) {
    .c_list tr td.last-td .btn {display: block;margin-bottom: 8px !important;width: 35px;}
    /*.render-new-product-form .row {margin-left: -30px;margin-right: -30px;}*/
    .pro-header {padding-bottom: 13px !important;}
    .first-td {padding-left:3px !important;}    
    .first-td span span {margin-top: 2px;}
    .tab-cont-out {padding-left: 10px;padding-right: 10px;}
    .products-card {padding-left: 0px;padding-right: 0px;}
    .nav-out {padding-left: 0px;padding-right: 0px; }
    .nav-out .nav-tabs-new li a {padding: 5px 10px;}
    .tab-out {padding-left: 0px;padding-right: 0px;}
    .render-new-product-form .row {padding-left: 5px;padding-right: 5px;}
    .render-new-product-form .col-12,.render-new-product-form .col-6,.render-new-product-form .col-4, .render-new-stock-form .col-6, .render-new-stock-form .col-12 {padding-left: 2px;padding-right: 2px;}
    .render-new-product-form .mt-3 {margin-top: 0px !important;}
    /* .p-img-input {height: 28px !important;} */
    .edit-pcategories-form .col-6, .edit-pcategories-form .col-5, .edit-pcategories-form .col-4 {padding-left: 2px;padding-right: 2px;}
        .products-card .tabs-drop {
            padding: 4px 5px 4px 8px;font-size: 14px;
        }
        .products-card .other-tabs {margin-top: 30px;}
}
@media screen and (max-width: 480px) {
    .stock-h .tbs {
        font-size: 13px !important;
    }
}
</style>
@endsection
@section('content')
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

                <div class="row clearfix margin-top-400px">
                    <div class="col-lg-12 col-md-12 products-card">
                        <div class="card">
                            <div class="body">
                                <div class="row">
                                    <div class="col-12 nav-out">
                                    <ul class="nav nav-tabs-new" id="cont">
                                        <li class="nav-item"><a class="nav-link active overview-tab" data-toggle="tab" href="#Overview"><?php echo $_GET['overview']; ?></a></li>
                                        <!-- <li class="nav-item"><a class="nav-link product-cat-tab" data-toggle="tab" href="#PCategories"><?php //echo $_GET['p-categories-menu']; ?></a></li> -->
                                        <li class="nav-item"><a class="nav-link products-tab" data-toggle="tab" href="#Products"><?php echo $_GET['products-menu']; ?></a></li>
                                        <!-- <li class="nav-item"><a class="nav-link measurement-tab" data-toggle="tab" href="#Measurements"><?php //echo $_GET['measurements-menu']; ?></a></li> -->
                                        @if(Auth::user()->isCEOorAdmin())
                                        
                                        @endif
                                        <!-- dont remove below buttons with display none: -->
                                        <li class="nav-item" style="display: none;"><a class="nav-link new-stock-form" data-toggle="tab" href="#addStock"><?php echo $_GET['add-stock']; ?></a></li>
                                        <li class="nav-item" style="display: none;"><a class="nav-link new-product-form" data-toggle="tab" href="#addProduct"><?php echo $_GET['add-product-menu']; ?></a></li>
                                        <li class="nav-item" style="display: none;"><a class="nav-link preview-product-btn" data-toggle="tab" href="#previewProduct"><?php echo $_GET['add-product-menu']; ?></a></li>
                                        <li class="nav-item" style="display: none;"><a class="nav-link edit-product-btn" data-toggle="tab" href="#editProduct"><?php echo $_GET['add-product-menu']; ?></a></li>
                                        <!-- end dont  -->
                                        <li class="nav-item"><a class="nav-link stock-tab" data-toggle="tab" href="#stockTab"><?php echo $_GET['stock-report-menu']; ?></a></li>
                                    </ul>
                                    </div>
                                    <div class="tabs-drop-2" style="display: none;">
                                      <i class="fa fa-angle-double-right"></i>
                                    </div>
                                    <div class="other-tabs-2" style="display: none;">
                                        <ul class="nav" id="">
                                            <li class="nav-item"><a class="nav-link active overview-tab" data-toggle="tab" href="#Overview"><?php echo $_GET['overview']; ?></a></li>
                                            <li class="nav-item"><a class="nav-link products-tab" data-toggle="tab" href="#Products"><?php echo $_GET['products-menu']; ?></a></li>
                                            <!-- <li class="nav-item"><a class="nav-link measurement-tab" data-toggle="tab" href="#Measurements"><?php //echo $_GET['measurements-menu']; ?></a></li> -->
                                            <!-- <li class="nav-item"><a class="nav-link product-cat-tab" data-toggle="tab" href="#PCategories"><?php // echo $_GET['p-categories-menu']; ?></a></li> -->
                                            @if(Auth::user()->isCEOorAdmin())
                                            <!-- <li class="nav-item"><a class="nav-link new-product-form" data-toggle="tab" href="#addProduct"><?php //echo $_GET['add-product-menu']; ?></a></li> -->
                                            <li class="nav-item"><a class="nav-link stock-tab" data-toggle="tab" href="#stockTab"><?php echo $_GET['stock-reports']; ?></a></li>
                                            @endif
                                        </ul>
                                    </div>

                                    <div class="col-md-12 tab-cont-out">
                                        <div class="tab-content padding-0">
                                            <!-- overview -->
                                            <div class="tab-pane active" id="Overview">
                                                <div class="row">
                                                    <div class="col-12 tab-out">
                                                        <div class="">   
                                                            <div class="body render-overview">
                                                                <!-- tabs/products-overview-tab  -->
                                                                
                                                            </div>                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- products -->
                                            <div class="tab-pane" id="Products">
                                                <div class="row">
                                                    <div class="col-md-12 tab-out">
                                                        <div class="">      
                                                            <div class="header pro-header">
                                                                <h2><?php echo $_GET['p-categories-menu']; ?>:</h2>
                                                                <ul class="header-dropdown">
                                                                    @if(Auth::user()->isCEOorAdmin())
                                                                    <li>
                                                                        <button class="btn btn-sm btn-info new-sub-category-form" data-toggle="modal" data-target="#addSCategory"><?php echo $_GET['add-category']; ?></button>
                                                                    </li>
                                                                    @endif
                                                                </ul>
                                                            </div>  
                                                            <div class="body pt-0 render-p-categories" style="background-color: #f0f0f0;">
                                                                <!-- partial/p-categories  -->
                                                            </div>   
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-5">
                                                    <div class="col-12 tab-out">
                                                        <div class="">      
                                                            <div class="header">
                                                                <h2><?php echo $_GET['products-menu']; ?>:</h2>
                                                                <ul class="header-dropdown">
                                                                @if(Auth::user()->isCEOorAdmin())
                                                                    <li>
                                                                        <a href="/products?opt=add-product" class="btn btn-info btn-sm">
                                                                            <b><?php echo $_GET['add-product-menu']; ?></b>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="/products?opt=new-stock" class="btn btn-primary btn-sm">
                                                                            <b><?php echo $_GET['add-stock-2']; ?></b>
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                                </ul>
                                                            </div>     
                                                            <div class="header" style="background-color: #f9f6f2;height: 90px;">
                                                                <!-- <h2>Available stock</h2> -->
                                                                <ul class="header-dropdown">
                                                                    <li>
                                                                        <b><?php echo $_GET['shop-store']; ?>:</b>
                                                                        <select class="form-control-sm change-shopstore" name="shopstore">
                                                                            <option value="all">All</option>
                                                                            <option class="bg-success text-light" disabled>-- Shops</option>
                                                                            @if($data['shops'])
                                                                            @foreach($data['shops'] as $shop)
                                                                                <option value="shop-{{$shop->id}}">{{$shop->name}}</option>
                                                                            @endforeach
                                                                            @endif
                                                                            <option class="bg-success text-light" disabled>-- Stores</option>
                                                                            @if($data['stores'])
                                                                            @foreach($data['stores'] as $store)
                                                                                <option value="store-{{$store->id}}">{{$store->name}}</option>
                                                                            @endforeach
                                                                            @endif
                                                                        </select>
                                                                        <p style="padding: 10px 0px;">
                                                                            <span class="wrds"><?php echo $_GET['total-quantities']; ?>:</span>
                                                                            <span class="bg-dark text-light px-2 py-1 ml-2 totalQty"></span>
                                                                        </p>
                                                                    </li>
                                                                </ul>
                                                            </div>                                                      
                                                            <div class="body pt-0" style="background-color: #f0f0f0;">
                                                                <div class="row">
                                                                    <div class="table-responsive">
                                                                        <table class="table m-b-0 c_list">
                                                                            <thead class="thead-light">
                                                                                <tr>
                                                                                    <th><?php echo $_GET['name']; ?></th>   
                                                                                    <th><?php echo $_GET['price']; ?></th>   
                                                                                    <!-- <th><?php echo $_GET['selling-price']; ?></th>    -->
                                                                                    <!-- <th><?php //echo $_GET['retail-price']; ?></th> -->            
                                                                                    <th><?php echo $_GET['quantity-full']; ?></th>      
                                                                                    <!-- <th><?php //echo $_GET['category']; ?></th> -->
                                                                                    <!-- <th>Status</th> -->
                                                                                    @if(Auth::user()->isCEOorAdmin())
                                                                                    <th><?php echo $_GET['action']; ?></th>
                                                                                    @endif
                                                                                </tr>
                                                                            </thead>
                                                                                <tbody class="render-products">

                                                                                </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- measurements -->
                                            <div class="tab-pane" id="Measurements">
                                                <div class="row">
                                                    <div class="col-md-5 tab-out">
                                                        <div class="">      
                                                            <div class="header">
                                                <?php if(Cookie::get("language") == 'en') { ?>
                                                    <p class="p-0">Example of measurement name is: <b>Kilogram</b> <br> Where the symbol is <b>Kg </b></p>
                                                <?php } else { ?>
                                                    <p class="p-0">Mfano wa kipimio ni: <b>Kilogram</b> <br> Halafu ishara yake ni <b>Kg </b></p>
                                                <?php } ?>
                                                                <h2><?php echo $_GET['measurements-menu']; ?>:</h2>
                                                                <ul class="header-dropdown">
                                                                    @if(Auth::user()->isCEOorAdmin())
                                                                    <li><a class="tab_btn" title="Add new" data-toggle="modal" data-target="#addMeasurement">
                                                                        <i class="fa fa-plus text-success" style="margin-top: 7px"></i>
                                                                    </a></li>
                                                                    @endif
                                                                </ul>
                                                            </div>  
                                                            <div class="body pt-0">
                                                                <div class="row">
                                                                    <div class="table-responsive">
                                                                        <table class="table m-b-0 c_list">
                                                                            <thead class="thead-light">
                                                                                <tr>
                                                                                    <th><?php echo $_GET['name']; ?></th>  
                                                                                    <th><?php echo $_GET['symbol']; ?></th> 
                                                                                    @if(Auth::user()->isCEOorAdmin())
                                                                                    <th><?php echo $_GET['action']; ?></th>
                                                                                    @endif
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="render-measurements">
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>   
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- product categories -->
                                            <div  class="tab-pane" id="PCategories">
                                                <div class="row">
                                                    <div class="col-md-9 tab-out">
                                                        <div class="">      
                                                            <div class="header">
                                                                <h2><?php echo $_GET['p-categories-menu']; ?>:</h2>
                                                                <ul class="header-dropdown">
                                                                    @if(Auth::user()->isCEOorAdmin())
                                                                    <!-- <li><a class="tab_btn" title="Add new" data-toggle="modal" data-target="#addMCategory" style="width: 50px;">
                                                                        <i class="fa fa-plus text-success" style="margin-top: 7px"></i> 
                                                                        <span>M</span>
                                                                    </a></li>
                                                                    <li><a class="tab_btn new-sub-category-form" title="Add new" data-toggle="modal" data-target="#addSCategory" style="width: 50px;">
                                                                        <i class="fa fa-plus text-success" style="margin-top: 7px"></i> 
                                                                        <span>S</span>
                                                                    </a></li> -->
                                                                    <li>
                                                                        <button class="btn btn-sm btn-info new-sub-category-form" data-toggle="modal" data-target="#addSCategory"><?php echo $_GET['add-category']; ?></button>
                                                                    </li>
                                                                    @endif
                                                                </ul>
                                                            </div>  
                                                            <div class="body pt-0">
                                                                <div class="row">
                                                                    <div class="table-responsive">
                                                                        <table class="table m-b-0 c_list">
                                                                            <thead class="thead-light">
                                                                                <tr>
                                                                                    <th><?php echo $_GET['category']; ?></th>
                                                                                    @if(Auth::user()->isCEOorAdmin())
                                                                                    <th><?php echo $_GET['action']; ?></th>
                                                                                    @endif
                                                                                </tr>
                                                                            </thead>
                                                                                <tbody class="render-p-categories">
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>   
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- add product -->
                                            <div  class="tab-pane" id="addProduct">
                                                <div class="row">
                                                    <div class="col-md-12 tab-out">
                                                        <div class="add-p-block mt-1">      
                                                            <div class="header pl-1">
                                                                <span>
                                                                    <a href="/products?opt=products">
                                                                        <span class="pl-1"><?php echo $_GET['products-menu']; ?></span>
                                                                    </a>
                                                                </span>
                                                                <span>|</span>
                                                                <h2><?php echo $_GET['create-new-product']; ?>:</h2>
                                                                <ul class="header-dropdown">
                                                                    <!-- <li>
                                                                        <b>
                                                                            <a href="/products?opt=products">
                                                                                <span class="pr-2"><?php echo $_GET['available-products']; ?></span>
                                                                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10" style="width: 15px;">
                                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                                                                </svg>
                                                                            </a>
                                                                        </b>
                                                                    </li> -->
                                                                </ul>
                                                            </div>  
                                                            <div class="body pt-0 render-new-product-form">
                                         
                                                            </div>   
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- preview product -->
                                            <div  class="tab-pane" id="previewProduct">
                                                <div class="row">
                                                    <div class="col-md-12 tab-out">
                                                        <div class="add-p-block mt-1">      
                                                            <div class="header pl-1">
                                                                <span>
                                                                    <a href="/products?opt=products">
                                                                        <span class="pl-1"><?php echo $_GET['products-menu']; ?></span>
                                                                    </a>
                                                                </span>
                                                                <span>|</span>
                                                                <h2 class="render-product-name">--</h2>
                                                                <ul class="header-dropdown">
                                                                    <li>
                                                                        <a href="/products?opt=add-product" class="btn btn-info btn-sm">
                                                                            <?php echo $_GET['add-product-menu']; ?>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>  
                                                            <div class="body pt-0 render-preview-product">
                                         
                                                            </div>   
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- edit product -->
                                            <div  class="tab-pane" id="editProduct">
                                                <div class="row">
                                                    <div class="col-md-12 tab-out">
                                                        <div class="add-p-block mt-1">      
                                                            <div class="header">
                                                                <span>
                                                                    <a href="/products?opt=products">
                                                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10" style="width: 15px;">
                                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4"/>
                                                                        </svg>
                                                                        <span class="pl-1"><?php echo $_GET['products-menu']; ?></span>
                                                                    </a>
                                                                </span>
                                                                <span>|</span>
                                                                <h2 class="render-product-name">--</h2>
                                                                <ul class="header-dropdown">
                                                                    <!-- <li>
                                                                        <b>
                                                                            <a href="/products?opt=products">
                                                                                <span class="pr-2"><?php echo $_GET['available-products']; ?></span>
                                                                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10" style="width: 15px;">
                                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                                                                </svg>
                                                                            </a>
                                                                        </b>
                                                                    </li> -->
                                                                </ul>
                                                            </div>  
                                                            <div class="body pt-0 render-edit-product">
                                         
                                                            </div>   
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- add stock -->
                                            <div  class="tab-pane" id="addStock">
                                                <div class="row">
                                                    <div class="col-md-12 tab-out">
                                                        <div class="add-s-block mt-1">      
                                                            <div class="header">
                                                                <span>
                                                                    <a href="/products?opt=products">
                                                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10" style="width: 15px;">
                                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4"/>
                                                                        </svg>
                                                                        <span class="pl-1"><?php echo $_GET['products-menu']; ?></span>
                                                                    </a>
                                                                </span>
                                                                <span>|</span>
                                                                <h2><?php echo $_GET['add-stock']; ?>:</h2>
                                                            </div>  
                                                            <div class="body pt-0 render-new-stock-form">
                                                                
                                                            </div>   
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end add stock -->

                                            <!-- add stock -->
                                            <div  class="tab-pane" id="stockTab">
                                                <div class="row">
                                                    <div class="col-md-12 tab-out">
                                                        <div class="">      
                                                            <div class="header">
                                                                <h2><?php echo $_GET['stock']; ?>:</h2>
                                                            </div>  
                                                            <div class="body pt-0 stock-o-h">
                                                                <div class="stock-h">
                                                                    <div class="tbs stock-overview-tab"><?php echo $_GET['overview']; ?></div>
                                                                    <!-- <div class="tbs ava-stock-tab"><?php echo $_GET['available-stock']; ?></div> -->
                                                                    <!-- <div class="tbs add-stock-tab active"><?php echo $_GET['add-stock']; ?></div> -->
                                                                    <div class="tbs previous-stock-records-tab"><?php echo $_GET['previous-stock-records']; ?></div>
                                                                    <div class="tbs item-activities-tab"><?php echo $_GET['item-activities']; ?></div>
                                                                    <div class="tbs transfer-records-tab"><?php echo $_GET['transfer-records-menu']; ?></div>
                                                                    <div class="tbs stock-adjustment-tab"><?php echo $_GET['stock-adjustment-menu']; ?></div>
                                                                    <div class="tbs stock-taking-tab"><?php echo $_GET['stock-taking-menu']; ?></div>
                                                                    <div class="tabs-drop">
                                                                      <i class="fa fa-angle-double-right"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="other-stock-h">
                                                                    <div class="tbs stock-overview-tab"><?php echo $_GET['overview']; ?></div>
                                                                    <!-- <div class="tbs ava-stock-tab"><?php echo $_GET['available-stock']; ?></div> -->
                                                                    <!-- <div class="tbs add-stock-tab active"><?php echo $_GET['add-stock']; ?></div> -->
                                                                    <div class="tbs previous-stock-records-tab"><?php echo $_GET['previous-stock-records']; ?></div>
                                                                    <div class="tbs item-activities-tab"><?php echo $_GET['item-activities']; ?></div>
                                                                    <div class="tbs transfer-records-tab"><?php echo $_GET['transfer-records-menu']; ?></div>
                                                                    <div class="tbs stock-adjustment-tab"><?php echo $_GET['stock-adjustment-menu']; ?></div>
                                                                    <div class="tbs stock-taking-tab"><?php echo $_GET['stock-taking-menu']; ?></div>
                                                                </div>
                                                            </div>
                                                            <div class="body pt-0 render-stock-tab">
                                                                
                                                            </div>   
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end add stock -->
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>

    <!-- add measurement modal -->
    <div class="modal fade" id="addMeasurement" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="title" id="largeModalLabel"><?php echo $_GET['create-measurement']; ?></h5>
                </div>
                <div class="modal-body"> 
                    <form id="basic-form" class="new-measurement">
                        @csrf
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $_GET['name']; ?></label>
                                    <input type="text" class="form-control form-control-sm" placeholder="<?php echo $_GET['name']; ?>" name="name" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $_GET['symbol']; ?></label>
                                    <input type="text" class="form-control form-control-sm" placeholder="<?php echo $_GET['symbol']; ?>" name="symbol" value="" required>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary btn-sm submit-new-measurement" style="width: inherit;">Submit</button>
                            </div>
                        </div>
                    </form>
                    <?php if(Cookie::get("language") == 'en') { ?>
                        <p class="mt-3">Example of measurement name is: <b>Kilogram</b> <br> Where the symbol is <b>Kg </b></p>
                    <?php } else { ?>
                        <p class="mt-3">Mfano wa kipimio ni: <b>Kilogram</b> <br> Halafu ishara yake ni <b>Kg </b></p>
                    <?php } ?>
                    <br>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-primary">SAVE CHANGES</button> -->
                    <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- edit measurement modal -->
    <div class="modal fade" id="editMeasurement" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="title" id="largeModalLabel"><?php echo $_GET['edit-measurement']; ?></h5>
                </div>
                <div class="modal-body"> 
                    <form id="basic-form" class="edit-measurement">
                        @csrf
                        <input type="hidden" name="measure_id" value="">
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $_GET['name']; ?></label>
                                    <input type="text" class="form-control form-control-sm" placeholder="<?php echo $_GET['name']; ?>" name="mname" value="" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $_GET['symbol']; ?></label>
                                    <input type="text" class="form-control form-control-sm" placeholder="<?php echo $_GET['symbol']; ?>" name="msymbol" value="" required>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary btn-sm submit-edit-measurement" style="width: inherit;">Submit</button>
                            </div>
                        </div>
                    </form>
                    <br>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-primary">SAVE CHANGES</button> -->
                    <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- add main category modal -->
    <div class="modal fade" id="addMCategory" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="title" id="largeModalLabel"><?php echo $_GET['create-main-category']; ?></h5>
                </div>
                <div class="modal-body"> 
                    <form id="basic-form" class="new-cgroup">
                        @csrf
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label><?php echo $_GET['name']; ?></label>
                                    <input type="text" class="form-control form-control-sm" placeholder="<?php echo $_GET['name']; ?>" name="name" required>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary btn-sm submit-new-cgroup" style="width: inherit;">Submit</button>
                            </div>
                        </div>
                    </form>
                    <?php if(Cookie::get("language") == 'en') { ?>
                        <p class="mt-3">For Fashion shops: <br> Example of main category is: <b>Clothes</b> <br> Where the sub-categories of Clothes are <b>Shirts, Trousers, Underwaer, </b>e.t.c</p>
                    <?php } else { ?>
                        <p class="mt-3">Kwa maduka ya mavazi <br> Mfano wa kategori kuu ni: <b>Nguo</b> <br> Na kategori ndogo za Nguo ni: <b>Shati, Suruali, Chupi, </b>n.k</p>
                    <?php } ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- add sub category modal -->
    <div class="modal fade" id="addSCategory" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="title" id="largeModalLabel"><?php echo $_GET['add-category']; ?></h5>
                    <ul class="header-dropdown mb-0" style="list-style: none;">
                        <li>
                            <button class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i></button>
                        </li>
                    </ul>
                </div>
                <div class="modal-body render-new-sub-category-form"> 

                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-primary">SAVE CHANGES</button> -->
                    <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button> -->
                </div>
            </div>
        </div>
    </div>

    <!-- edit prod. category modal -->
    <div class="modal fade" id="editPCategory" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="title" id="largeModalLabel"><?php echo $_GET['edit-category-name']; ?></h5>
                    <ul class="header-dropdown mb-0" style="list-style: none;">
                        <li>
                            <button class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i></button>
                        </li>
                    </ul>
                </div>
                <div class="modal-body render-pcategories-form"> 

                    <br>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-primary">SAVE CHANGES</button> -->
                    <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button> -->
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
<script type="text/javascript">
    var is_ceo_bo = "<?php echo Auth::user()->isCEOorAdminorBusinessOwner(); ?>";
    var is_ceo = "<?php echo Auth::user()->isCEOorAdmin(); ?>";

    if (is_ceo_bo == 1) {
        // proceed 
    } else {
        window.location = "/home";
    }

    $(document).ready(function(){
        // show hide cat menu
        $(".products-card .tabs-drop").click(function () {
            $(".other-stock-h").stop(true).toggle("slow");
            $(this).html(function (i, t) {
                return t == '<i class="fa fa-angle-double-down"></i>' ? '<i class="fa fa-angle-double-right"></i>' : '<i class="fa fa-angle-double-down"></i>';
            });
        });
    });

    $(document).mouseup(function(e) {
        var container = $(".other-tabs, .other-stock-h");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
          var classes = $('.fa-angle-double-down').parent().closest('div').attr('class');
          $('.'+classes).click();
        }
    });

    $(function () {     
        let searchParams = new URLSearchParams(window.location.search);
        if (searchParams.has('opt')) {
            if (searchParams.get('opt') == "overview") {
                $('.overview-tab').click();
            }
            if (searchParams.get('opt') == "products") {
                $('.products-tab').click();
            }
            if (searchParams.get('opt') == "measurement") {
                $('.products-tab').click();
            }
            if (searchParams.get('opt') == "product-cat") {
                $('.product-cat-tab').click();
            }
            if (searchParams.get('opt') == "add-product") {
                if (is_ceo == 1) {
                    $('.new-product-form').click();
                } else {
                    window.location = "/products";
                }     
            }
            if (searchParams.get('opt') == "preview-product") {
                if (is_ceo == 1) {
                    $('.preview-product-btn').click();
                } else {
                    window.location = "/products";
                }     
            }
            if (searchParams.get('opt') == "edit-product") {
                if (is_ceo == 1) {
                    $('.edit-product-btn').click();
                } else {
                    window.location = "/products";
                }     
            }
            if (searchParams.get('opt') == "new-stock") {
                if (is_ceo == 1) {
                    $('.new-stock-form').click();
                } else {
                    window.location = "/products";
                }                
            }
            if (searchParams.get('opt') == "stock") {
                if (is_ceo == 1) {
                    $('.stock-tab').click();
                } else {
                    $('.stock-tab').click();
                    // window.location = "/products";
                }                
            }
        } else {
            $('.overview-tab').click();
        }
        
        renderMeasurements();
        renderProductCategories();
    });

    function renderMeasurements() {
        $('.render-measurements').html("<tr><td colspan='3' align='center'>Loading...</td></tr>");
        $.get('/get-data/measurements/all', function(data) {
            $('.render-measurements').html(data.measurements);
        });           
    }

    function renderProductCategories() {    
        $('.render-p-categories').html("<div class='pt-2' align='center'>Loading...</div>");      
        $.get('/get-data/p-categories/all', function(data) {
            $('.render-p-categories').html(data.pcategories);
        });   
    }

    $(document).on('submit', '.new-cgroup', function(e){
        e.preventDefault();
        $('.submit-new-cgroup').prop('disabled', true).html('submiting..');
        var name = $('.new-cgroup [name="name"]').val();
        if (name.trim() == null || name.trim() == '') {
            $('.submit-new-cgroup').prop('disabled', false).html('Submit');
        }
        if (name.trim() == null || name.trim() == '') {
            $('.new-cgroup [name="name"]').addClass('parsley-error').focus(); return;}

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formdata = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '/add-cat-group',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.submit-new-cgroup').prop('disabled', false).html('Submit');
                    if (data.error) {
                        popNotification('warning',data.error);
                    } else {
                        popNotification('success',data.success);
                        $('#addMCategory').modal('hide');
                        $('.new-cgroup')[0].reset();
                        renderProductCategories();
                        // window.location = "/"+urlArray[1]+"/product-categories";
                    }
                }
        });
    });

    $(document).on('change', '.cgroup', function(e){
        e.preventDefault();
        var group_id = $(this).val();
        if (group_id == '') {
            $('.pcategory').html('<option value="">- select -</option>');
            return;
        }
        $.get('/categories-by-group/'+group_id, function(data){
            if (data.error) {
                popNotification('warning',data.error);
            } else {
                $('.pcategory').html('<option value="">- select -</option>');
                if (data.cats) {
                    $.each(data.cats, function (index, value) {
                        $('.pcategory').append('<option value="'+value.id+'">'+value.name+'</option>');
                    });
                }
            }
        });
    });

    $(document).on('click', '.new-product-form', function(e){
        $('#cont .nav-link, .tab-cont-out .tab-pane, .other-tabs .nav-link').removeClass('active');
        $('#cont .products-tab, .tab-cont-out #addProduct, .other-tabs .products-tab').addClass('active');
        history.replaceState({}, document.title, "?opt=add-product");
        $('.render-new-product-form').html("<div align='center'>Loading...</div>");
        $.get('/get-form/new-product/0', function(data) {
            $('.render-new-product-form').html(data.form);
        });           
    });
    
    $(document).on('click', '.preview-product-btn', function(e){
        $('#cont .nav-link, .tab-cont-out .tab-pane, .other-tabs .nav-link').removeClass('active');
        $('#cont .products-tab, .tab-cont-out #previewProduct, .other-tabs .products-tab').addClass('active');
        var pid = 0;
        if(!getUrlParameter('pid')) {
            
        } else {
            pid = $.trim(getUrlParameter('pid'));
        }
        
        history.replaceState({}, document.title, "?opt=preview-product&pid="+pid);
        $('.render-preview-product').html("<div align='center'>Loading...</div>");
        $.get('/get-data/preview-product/'+pid, function(data) {
            $('.render-product-name').html(data.product.product.name);
            $('.render-preview-product').html(data.view);
        });           
    });
    
    $(document).on('click', '.edit-product-btn', function(e){
        $('#cont .nav-link, .tab-cont-out .tab-pane, .other-tabs .nav-link').removeClass('active');
        $('#cont .products-tab, .tab-cont-out #editProduct, .other-tabs .products-tab').addClass('active');
        var pid = 0;
        if(!getUrlParameter('pid')) {
            
        } else {
            pid = $.trim(getUrlParameter('pid'));
        }
        
        history.replaceState({}, document.title, "?opt=edit-product&pid="+pid);
        $('.render-edit-product').html("<div align='center'>Loading...</div>");
        $.get('/get-data/edit-product/'+pid, function(data) {
            $('.render-product-name').html(data.product.product.name);
            $('.render-edit-product').html(data.view);
        });           
    });

    function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
        return false;
    };

    $(document).on('click', '.new-stock-form', function(e){
        // $('#cont .nav-link, .tab-cont-out .tab-pane, .other-tabs .nav-link').removeClass('active');
        // $('#cont .new-stock-form, .tab-cont-out #addStock, .other-tabs .new-stock-form').addClass('active');
        $('#cont .nav-link, .tab-cont-out .tab-pane, .other-tabs .nav-link').removeClass('active');
        $('#cont .products-tab, .tab-cont-out #addStock, .other-tabs .products-tab').addClass('active');
        history.replaceState({}, document.title, "?opt=new-stock");
        $('.render-new-stock-form').html("<div align='center'>Loading...</div>");
        $.get('/get-form/new-stock/0', function(data) {
            $('.render-new-stock-form').html(data.form);
        });           
    });
    
    $(document).on('click', '.stock-tab', function(e){
        $('#cont .nav-link, .tab-cont-out .tab-pane, .other-tabs .nav-link').removeClass('active');
        $('#cont .stock-tab, .tab-cont-out #stockTab, .other-tabs .stock-tab').addClass('active');
        // history.replaceState({}, document.title, "?opt=stock");
        let searchParams = new URLSearchParams(window.location.search);
        if (searchParams.has('sval')) {
            if (searchParams.get('sval') == "overview") {
                $('.stock-h .stock-overview-tab').click();
            }            
            if (searchParams.get('sval') == "available-stock") {
                $('.stock-h .ava-stock-tab').click();
            }              
            if (searchParams.get('sval') == "add-stock") {
                $('.stock-h .add-stock-tab').click();
            }                  
            if (searchParams.get('sval') == "previous-stock-records") {
                $('.stock-o-h .stock-h').animate({
                  scrollLeft: "+=55px"
                }, "slow");
                $('.stock-h .previous-stock-records-tab').click();
            }               
            if (searchParams.get('sval') == "item-activities") {
                $('.stock-o-h .stock-h').animate({
                  scrollLeft: "+=120px"
                }, "slow");
                $('.stock-h .item-activities-tab').click();
            }                 
            if (searchParams.get('sval') == "transfer-records") {
                $('.stock-o-h .stock-h').animate({
                  scrollLeft: "+=300px"
                }, "slow");
                $('.stock-h .transfer-records-tab').click();
            }                    
            if (searchParams.get('sval') == "stock-adjustment") {
                $('.stock-o-h .stock-h').animate({
                  scrollLeft: "+=400px"
                }, "slow");
                $('.stock-h .stock-adjustment-tab').click();
            }                      
            if (searchParams.get('sval') == "stock-taking") {
                $('.stock-o-h .stock-h').animate({
                  scrollLeft: "+=500px"
                }, "slow");
                $('.stock-h .stock-taking-tab').click();
            }             
        } else {
            $('.stock-overview-tab').click();
        }
    });
    
    $(document).on('click', '.stock-overview-tab', function(e) {
        e.preventDefault();
        $('.stock-h .tbs, .render-stockings .tab-pane, .other-stock-h .tbs').removeClass('active');
        $('.stock-h .stock-overview-tab, .render-stockings #AvaStock, .other-stock-h .stock-overview-tab').addClass('active');
        $('.render-stock-tab').html("<div><i class='fa fa-spinner fa-spin' style='font-size:15px;'></i> Loading..</div>");
        history.replaceState({}, document.title, "?opt=stock&sval=overview");
        $.get('/get-data/stock-overview-tab/<?php echo Auth::user()->company_id; ?>', function(data) {
            $('.render-stock-tab').html(data.view); 
        });           
    });

    $(document).on('click', '.ava-stock-tab', function(e) {
        e.preventDefault();
        $('.stock-h .tbs, .other-stock-h .tbs').removeClass('active');
        $('.stock-h .ava-stock-tab, .other-stock-h .ava-stock-tab').addClass('active');
        $('.render-stock-tab').html("<div><i class='fa fa-spinner fa-spin' style='font-size:15px;'></i> Loading..</div>");
        history.replaceState({}, document.title, "?opt=stock&sval=available-stock");
        $.get('/get-data/available-stock-tab/<?php echo Auth::user()->company_id; ?>', function(data) {
            $('.render-stock-tab').html(data.view); 
        });           
    });
    
    $(document).on('click', '.add-stock-tab', function(e) {
        e.preventDefault();
        $('.stock-h .tbs, .other-stock-h .tbs').removeClass('active');
        $('.stock-h .add-stock-tab, .other-stock-h .add-stock-tab').addClass('active');
        $('.render-stock-tab').html("<div><i class='fa fa-spinner fa-spin' style='font-size:15px;'></i> Loading..</div>");
        history.replaceState({}, document.title, "?opt=stock&sval=add-stock");
        $.get('/get-data/add-stock-tab/<?php echo Auth::user()->company_id; ?>', function(data) {
            $('.render-stock-tab').html(data.view); 
        });           
    });

    $(document).on('click', '.previous-stock-records-tab', function(e){
        e.preventDefault();
        $('.stock-h .tbs, .other-stock-h .tbs').removeClass('active');
        $('.stock-h .previous-stock-records-tab, .other-stock-h .previous-stock-records-tab').addClass('active');
        $('.render-stock-tab').html("<div><i class='fa fa-spinner fa-spin' style='font-size:15px;'></i> Loading..</div>");
        history.replaceState({}, document.title, "?opt=stock&sval=previous-stock-records");

        $.get('/get-data/previous-stock-records-tab/<?php echo Auth::user()->company_id; ?>', function(data) {
            $('.render-stock-tab').html(data.view); 
        });           
    });

    $(document).on('click', '.item-activities-tab', function(e){
        e.preventDefault();
        $('.stock-h .tbs, .other-stock-h .tbs').removeClass('active');
        $('.stock-h .item-activities-tab, .other-stock-h .item-activities-tab').addClass('active');
        $('.render-stock-tab').html("<div><i class='fa fa-spinner fa-spin' style='font-size:15px;'></i> Loading..</div>");
        history.replaceState({}, document.title, "?opt=stock&sval=item-activities");

        $.get('/ceo/report/item-activities/', function(data) { 
            $('.full-cover').css('display','none');
            $('.render-stock-tab').html(data.view);
        });       
    });

    $(document).on('click', '.transfer-records-tab', function(e){
        e.preventDefault();
        $('.stock-h .tbs, .other-stock-h .tbs').removeClass('active');
        $('.stock-h .transfer-records-tab, .other-stock-h .transfer-records-tab').addClass('active');
        $('.render-stock-tab').html("<div><i class='fa fa-spinner fa-spin' style='font-size:15px;'></i> Loading..</div>");
        history.replaceState({}, document.title, "?opt=stock&sval=transfer-records");

        $.get('/get-data/transfer-records-tab/<?php echo Auth::user()->company_id; ?>', function(data) {
            $('.render-stock-tab').html(data.view); 
        });           
    });
    
    $(document).on('click', '.stock-adjustment-tab', function(e){
        e.preventDefault();
        $('.stock-h .tbs, .other-stock-h .tbs').removeClass('active');
        $('.stock-h .stock-adjustment-tab, .other-stock-h .stock-adjustment-tab').addClass('active');
        $('.render-stock-tab').html("<div><i class='fa fa-spinner fa-spin' style='font-size:15px;'></i> Loading..</div>");
        history.replaceState({}, document.title, "?opt=stock&sval=stock-adjustment");

        $.get('/get-data/stock-adjustment-tab/<?php echo Auth::user()->company_id; ?>', function(data) {
            $('.render-stock-tab').html(data.view); 
        });           
    });
    
    $(document).on('click', '.stock-taking-tab', function(e){
        e.preventDefault();
        $('.stock-h .tbs, .other-stock-h .tbs').removeClass('active');
        $('.stock-h .stock-taking-tab, .other-stock-h .stock-taking-tab').addClass('active');
        $('.render-stock-tab').html("<div><i class='fa fa-spinner fa-spin' style='font-size:15px;'></i> Loading..</div>");
        history.replaceState({}, document.title, "?opt=stock&sval=stock-taking");

        $.get('/get-data/stock-taking-tab/<?php echo Auth::user()->company_id; ?>', function(data) {
            $('.render-stock-tab').html(data.view); 
        });           
    });

    $(document).on('click', '.overview-tab', function(e){
        $('#cont .nav-link, .tab-cont-out .tab-pane, .other-tabs .nav-link').removeClass('active');
        $('#cont .overview-tab, .tab-cont-out #Overview, .other-tabs .overview-tab').addClass('active');
        history.replaceState({}, document.title, "?opt=overview");
        $('.render-overview').html("<div align='center'>Loading...</div>");
        $.get('/get-data/products-overview-tab/<?php echo Auth::user()->company_id; ?>', function(data) {
            $('.render-overview').html(data.view); 
        });           
    });

    $(document).on('click', '.products-tab', function(e){
        $('#cont .nav-link, .tab-cont-out .tab-pane, .other-tabs .nav-link').removeClass('active');
        $('#cont .products-tab, .tab-cont-out #Products, .other-tabs .products-tab').addClass('active');
        history.replaceState({}, document.title, "?opt=products");
        $('.render-products').html("<tr><td colspan='4' align='center'>Loading...</td></tr>");
        $('.change-shopstore').change();
        // $.get('/get-data/products/all', function(data) {
        //     $('.render-products').html(data.products); 
        // });           
    });
    
    $(document).on('change','.change-shopstore',function(e){
        e.preventDefault();
        var shopstore = $(this).val();
        
        $('.render-products').html('<tr><td colspan="4">Loading...</td></tr>');
        $.get('/get-data/products-2/'+shopstore, function(data) {
            $('.totalQty').html(parseFloat(data.totalQty));
            $('.render-products').html(data.products); 
        });           
    });

    $(document).on('click', '.product-cat-tab', function(e){
        $('#cont .nav-link, .tab-cont-out .tab-pane, .other-tabs .nav-link').removeClass('active');
        $('#cont .product-cat-tab, .tab-cont-out #PCategories, .other-tabs .product-cat-tab').addClass('active');
        history.replaceState({}, document.title, "?opt=product-cat");
    });
    $(document).on('click', '.measurement-tab', function(e){
        $('#cont .nav-link, .tab-cont-out .tab-pane, .other-tabs .nav-link').removeClass('active');
        $('#cont .measurement-tab, .tab-cont-out #Measurements, .other-tabs .measurement-tab').addClass('active');
        history.replaceState({}, document.title, "?opt=measurement");
    });

    $(document).on('submit', '.new-product', function(e){
        e.preventDefault();
        $('.submit-new-product').prop('disabled', true).html('submiting..');
        var name = $('.new-product [name="name"]').val();
        var cgroup = $('.new-product [name="cgroup"]').val();
        var pcategory = $('.new-product [name="pcategory"]').val();
        var buying_price = $('.new-product [name="buying_price"]').val();
        var retail_price = $('.new-product [name="retail_price"]').val();
        var measurement = $('.new-product [name="measurement"]').val();
        if (name.trim() == null || name.trim() == '' || pcategory.trim() == null || pcategory.trim() == '' || buying_price.trim() == null || buying_price.trim() == '' || retail_price.trim() == null || retail_price.trim() == '' || measurement.trim() == null || measurement.trim() == '') {
            popNotification('warning','Please fill all required fields');
            $('.submit-new-product').prop('disabled', false).html('Submit');
        }
        if (name.trim() == null || name.trim() == '') {
            $('.new-product [name="name"]').addClass('parsley-error').focus(); return;}
        if (buying_price.trim() == null || buying_price.trim() == '') {
            $('.new-product [name="buying_price"]').addClass('parsley-error').focus(); return;}
        if (retail_price.trim() == null || retail_price.trim() == '') {
            $('.new-product [name="retail_price"]').addClass('parsley-error').focus(); return;}

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formdata = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '/new-product',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.submit-new-product').prop('disabled', false).html('Submit');
                    if (data.error) {
                        popNotification('warning',data.error);
                    } else {
                        popNotification('success',data.success);
                        window.location = '/products?opt=preview-product&pid='+data.pid;
                        // $('.new-product')[0].reset();
                        // renderProducts(); 
                    }
                }
        });
    });

    $(document).on('click','.edit-measurement-btn',function(e){
        e.preventDefault();
        var mid = $(this).attr('valid');
        var name = $('.mrname'+mid).text();
        var symbol = $('.mrsymbol'+mid).text();
        $('[name="measure_id"]').val(mid);
        $('[name="mname"]').val(name.trim());
        $('[name="msymbol"]').val(symbol.trim());
        $('#editMeasurement').modal('toggle');
    });

    $(document).on('click','.edit-pcategory-btn',function(e){
        e.preventDefault();
        var pid = $(this).attr('valid');
        $('#editPCategory').modal('toggle');
        $('.render-pcategories-form').html("<div align='center'>Loading...</div>");
        $.get('/get-data/p-categories-form/'+pid, function(data) {
            $('.render-pcategories-form').html(data.p_categories_form);
        });            
    });

    $(document).on('click', '.update-group', function(e){
        e.preventDefault();
        $(this).prop('disabled', true).html('submiting..');
        var id = $(this).attr('val');
        var name = $('[name="gname'+id+'"]').val();
        if (name.trim() == null || name.trim() == '') {
            $(this).prop('disabled', false).html('Submit');
        }
        if (name.trim() == null || name.trim() == '') {
            $('[name="gname'+id+'"]').addClass('parsley-error').focus(); return;}

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formdata = new FormData();
        formdata.append('id',id);
        formdata.append('name',name);
        $.ajax({
            type: 'POST',
            url: '/edit-cat-group',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.update-group').prop('disabled', false).html('Submit');
                    if (data.error) {
                        popNotification('warning',data.error);
                    } else {
                        popNotification('success',data.success);
                    }
                }
        });
    });

    $(document).on('click', '.update-p-category', function(e){
        e.preventDefault();
        $(this).prop('disabled', true).html('submiting..');
        var id = $(this).attr('val');
        var name = $('[name="cname'+id+'"]').val();
        var group = $('[name="cgroup'+id+'"]').find(":selected").val();
        if (name.trim() == null || name.trim() == '') {
            $(this).prop('disabled', false).html('Submit');
        }
        if (name.trim() == null || name.trim() == '') {
            $('[name="cname'+id+'"]').addClass('parsley-error').focus(); return;}

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formdata = new FormData();
        formdata.append('id',id);
        formdata.append('name',name);
        formdata.append('group',group);
        $.ajax({
            type: 'POST',
            url: '/edit-p-category',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.update-p-category').prop('disabled', false).html('Submit');
                    if (data.error) {
                        popNotification('warning',data.error);
                    } else {
                        popNotification('success',data.success);
                    }
                    $('#editPCategory').modal('hide');
                    renderProductCategories();
                    $('.products-tab').click();
                }
        });
    });

    $(document).on('click', '.delete-p-category', function(e){
        e.preventDefault();
        var name = $(this).attr('name');
        if(confirm("Click OK to confirm that you delete "+name+" sub category. \n By deleting this, all the products created under this category will be deleted too.")){
            e.preventDefault();
            $('.full-cover').css('display','block');
            $('.full-cover .inside').html('Deleting...');
            var id = $(this).attr('val');
            var gid = $(this).attr('gid');
            var name = $(this).attr('name');

            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            var formdata = new FormData();
            formdata.append('id',id);
            formdata.append('name',name);
            formdata.append('status','sub category');
            $.ajax({
                type: 'POST',
                url: '/delete',
                processData: false,
                contentType: false,
                data: formdata,
                    success: function(data) {
                        $('.full-cover').css('display','none');
                        if (data.error) {
                            popNotification('warning',"Error! Something went wrong, Category failed to delete.");
                        } else {
                            popNotification('success',name+' Category is deleted successfully');
                        }
                        renderProductCategories();      
                        $('.products-tab').click();
                    }
            });       
        }
        return;
    });

    $(document).on('click', '.done-edit', function(e){
        e.preventDefault();
        $('#editPCategory').modal('hide');
        renderProductCategories();
    });

    $(document).on('click','.deleteProduct',function(e){
        e.preventDefault();
        var name = $(this).attr('name');
        if(confirm("Click OK to confirm that you delete "+name+" product.")){
            e.preventDefault();
            $('.full-cover').css('display','block');
            $('.full-cover .inside').html('Deleting...');
            var id = $(this).attr('val');
            var name = $(this).attr('name');

            $.get('/delete-product/'+id, function(data) {
                $('.full-cover').css('display','none');
                popNotification('success',name+' product is deleted successfully');                
                $('.pr-'+data.id).closest("tr").remove();
            });            
        }
        return;
    });
</script>
@endsection  