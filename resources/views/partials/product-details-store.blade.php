
@include("layouts.translater") 

<style>
    .r-navbar {margin-top: -70px !important;width: 50px;float: right !important;}
    .pro-actions .dropdown-menu a {padding-top:7px;padding-bottom:7px}
    .pro-actions .dropdown-menu a i {padding-right:5px}
    .pro-actions .dropdown-menu {padding-left:0px;padding-right:0px;margin-right:10px}
    /* .img {padding-top: 45px;} */
    .img img {width: 100%;max-height:250px;object-fit: cover;}
    .nav-tabs-new2>li>a {font-size: 14px !important;}
    .ts-btn {padding-top:29px;padding-left:0px;}
    .ibtn {padding-top:29px;padding-left:0px;}
    @media screen and (max-width: 553px) {
        .sitem-summary .col-4 .body {padding-left:0px;padding-right:0px;}
    }
    @media screen and (max-width: 510px) {
        .year-summ .col-6 .p-3 {padding-left:0.5rem !important;padding-right:0.5rem !important}
        /* .year-summ h4 { font-size: 1.3rem !important; } */
    }
    @media screen and (max-width: 480px) {
        .year-summ .col-6:first-child {padding-right:5px !important}
        .year-summ .col-6:last-child {padding-left:5px !important}
        .year-summ span {font-size:80% !important}
        .ts-btn {padding-top:25px}
        .ibtn {padding-top:25px}
    }
    @media screen and (max-width: 430px) {
        .s-desc .body {padding-left: 5px;}
        .year-summ .col-5 {padding-right:0px !important}
        .year-summ .col-5 .p-3 {padding-left:0.5rem !important;padding-right:0.5rem !important}
        .img div {width: 100%;}
        .img img {width: inherit;}
        /* .year-summ h4 { font-size: 1.4rem !important; } */
    }
    @media screen and (max-width: 414px) {
        .sitem-summary .col-4 {padding-left:5px;padding-right:5px}
    }
    @media screen and (max-width: 370px) {
        .year-summ .col-6 h4 { font-size: 1.4rem !important; }
    }
</style>

<?php
    if(Auth::user()->company->has_product_categories == 'no') {
        $display_none = "display-none";
    } else {
        $display_none = "";
    }
?>

<div class="col-12 px-1">
    <div class="body">
        <div class="row" style="background-color: #f9f6f2;">
            <div class="col-md-12">     
                @if(Auth::user()->isCEOorAdmin())    
                <div class="navbar-nav right-navbar r-navbar">        
                    <div class="dropdown pro-actions" style="z-index: 9 !important;">
                        <a class="btn border" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="float: right;">
                            <i class="fa fa-bars" style="font-size: 1.5em;"></i>
                        </a>    
                        <input type="hidden" name="pid" value="">
                        <input type="hidden" name="sid" value="<?php echo $data['store']->id; ?>">            
                        <input type="hidden" name="pname" value="">
                        <input type="hidden" name="sname" value="<?php echo $data['store']->name; ?>">
                        <input type="hidden" name="store_product" value="">
                        <ul class="dropdown-menu user-menu py-0" aria-labelledby="dropdownMenuButton" style="margin-top:0px;border-radius:5px">
                            <a class="dropdown-item bg-info text-light edit-product" style="border-radius: 5px 5px 0px 0px;" href="#"><i class="fa fa-pencil"></i> <?php echo $_GET['change-details']; ?></a>
                            <a class="dropdown-item bg-primary text-light add-quantity" qty="" href="#"><i class="fa fa-arrow-down"></i> <?php echo $_GET['add-quantity']; ?></a>
                            <a class="dropdown-item bg-secondary text-light change-quantity" qty="" href="#"><i class="fa fa-pencil"></i> <?php echo $_GET['change-quantity']; ?></a>
                            @if($data['shopstore'] == "many")
                            <a class="dropdown-item bg-warning text-dark remove-from-store" product="" name="" store="<?php echo $data['store']->id; ?>" href="#"><i class="fa fa-times"></i> <?php echo $_GET['remove-from-store']; ?></a>
                            @endif
                            <a class="dropdown-item bg-danger text-light delete-product" product="" name="" style="border-radius: 0px 0px 5px 5px;" href="#"><i class="fa fa-trash"></i> <?php echo $_GET['delete']; ?></a>
                        </ul>
                    </div>
                </div>       
                @endif
            </div>
            
            <div class="col-md-6 col-7 px-0 s-desc">
                <div class="body">
                    <small><?php echo $_GET['available-quantity']; ?></small>
                    <h2 class="av_q">-</h2>
                    <h6><b class="pname">-</b></h6>
                    <p class="mb-0 <?php echo $display_none; ?>"><small><?php echo $_GET['category']; ?>: <b class="pcname">-</b></small> </p>
                    <?php 
                        if(Auth::user()->company->settings->isNotEmpty()) { 
                            foreach(Auth::user()->company->settings as $cs) { ?>

                        @if($cs->pivot->setting_id == 1) <p class="my-0"><b class="text-danger">Exp:</b> <span class="exp">-</span></p> @endif
                        @if($cs->pivot->setting_id == 2) <p class="my-0"><b class="text-danger">MSL:</b> <span class="msl">-</span> @endif

                    <?php } } ?>                    
                    <div class="mt-3">
                        @if(Auth::user()->isCEOorAdminorBusinessOwner())
                            <small><?php echo $_GET['buying-price']; ?></small>
                            <h5 class="bp">-</h5>
                        @endif
                    </div>
                    <div>
                        <small><?php echo $_GET['selling-price']; ?></small>
                        <h5 class="sp">-</h5>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-5 pr-0" align="right"> 
                <div class="img" align="right">
                    <div>
                        <img src="/images/product.jpg" class="avatar">
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-3">
                <small><?php echo date('Y'); ?></small>
                <div class="row year-summ">
                    <div class="col-6 xl-turquoise">
                        <div class="p-3">                                  
                            <h4 class="q-in"></h4>
                            <span><?php echo $_GET['quantity-in']; ?></span>
                        </div>
                    </div>
                    <div class="col-6 xl-salmon">
                        <div class="p-3" style="padding-right:0px !important">                                  
                            <h4 class="q-out"></h4>
                            <span><?php echo $_GET['quantity-out']; ?></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="col-md-12 mt-3">
    <ul class="nav nav-tabs-new2">
        <li class="nav-item"><a class="nav-link show active" data-toggle="tab" href="#In-Out"><?php echo $_GET['product-in-out']; ?></a></li>
        <!-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Pro-Sale"><?php echo $_GET['product-sales']; ?></a></li> -->
    </ul>
    <div class="tab-content" style="padding-top: 0px;">
        <div class="tab-pane render-product-in-out show active" id="In-Out">            
            <div class="row pt-3 pb-2 top-b pstore-activities" style="background:#f4f7f6">
                <div class="col-md-3 col-5 from">
                    <div class="form-group">
                        <label><?php echo $_GET['from']; ?></label>
                        <input type="text" name="date_fa" data-provide="datepicker" data-date-autoclose="true" class="form-control form-control-sm" placeholder="From" value="<?php echo date('d/m/Y', mktime(0, 0, 0, date("m") , date("d") - 10, date("Y"))); ?>">
                    </div>            
                </div>
                <div class="col-md-3 col-5 align-left to">
                    <div class="form-group">
                        <label><?php echo $_GET['to']; ?></label>
                        <input type="text" name="date_ta" data-provide="datepicker" data-date-autoclose="true" class="form-control form-control-sm" placeholder="From" value="<?php echo date('d/m/Y'); ?>">
                    </div>            
                </div>
                <div class="col-md-2 col-2 ts-btn">
                    <button class="btn btn-info btn-sm check-i-activities">Check</button>
                </div>
            </div>

            <div class="row"> 
                <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th><?php echo $_GET['date']; ?></th>
                                <th><?php echo $_GET['activities']; ?></th>
                                <th><?php echo $_GET['remaining-quantity']; ?></th>
                            </tr>
                        </thead>
                        <tbody class="render-activities" style="background-color: #f4f7f6;">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane render-product-sales" id="Pro-Sale">
            
        </div>
    </div>
</div>

