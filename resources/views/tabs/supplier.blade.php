
@include("layouts.translater")

<style>
    .supplier-row {cursor: pointer;}
    .supp-action {float: right;margin-top: -55px;}
    .supp-action button {display: block;}
    .supp-action button.btn-outline-danger {margin-top: 6px;}
    fieldset .loader {position: absolute;background: #000;color: #fff; opacity: 0.3; width: 90%;height: 70%;text-align: center;padding-top: 25px;display: none;}
    fieldset .col-8 {padding: 10px 0px 20px 30px;}
    fieldset .col-4 {margin-top: 20px;}
    fieldset h5 {font-size: 1rem !important;margin-bottom: 0px;}
    fieldset h5 small {font-size: 12px;}
    .records-blc .no-records {text-align: center;}
    .records-blc .rec-row {margin-bottom: 15px;}
    .left-names div {padding-bottom: 5px;}
    
    .pq-select {text-align: center;}
    .pq-list .form-group {margin-bottom: 0px !important;}
    .pq-list .bb-price {margin-bottom: 10px;border-bottom: 1px solid #ddd;}
    .pq-list .bb-price div {width: 270px;text-align: right;}
    .pq-list label, .pq-list input, .pq-list span {display: inline-block;}
    .pq-list label {width: 190px;}
    .pq-list input {width: 80px;}
    .pq-list .clear-pq-row2 {font-size: 16px !important;cursor: pointer;color: red;}
    .add-loader {display: none;}
    .pq-add-pro, .pq-footer {display: none;}
    .d-edit-block button {border:none;background:#fff;border-radius:15px;margin-top: 5px;}

    .item-col {width: 80%;display: inline-block;}
    .item-col input {width: 50px;display: inline-block;}
    .item-col span {padding-left: 3px;}
    .i-calcul {display: inline-block;}
    .delete-purchased-item {padding: 3px 5px;border: none;}
    #notificationModal .modal-header {border-bottom: none !important;}
    .close-modal {display: none;}
    /* @media screen and (max-width: 480px) {
        .pq-select {padding-left: 0px !important;text-align: center !important;}
    } */
    
</style>

<div class="row clearfix"> 
    <div class="col-md-8 offset-md-2 reduce-padding">
        <div class="card" style="box-shadow: none;">      
            <div class="header px-0">
                <h2>
                    <a href="#" class="suppliers-tab pr-1"><i class="fa fa-arrow-left px-1"></i> </a> | 
                    <span class="pl-1"><?php echo $_GET["suppliers"]; ?></span>
                </h2>
                @if(Auth::user()->isCEOorAdminorCashier())
                <ul class="header-dropdown">
                    <li>
                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#newSupplier">
                            <i class="fa fa-plus text-white pr-1" style="font-size: 14px;"></i> <?php echo $_GET["new-supplier"]; ?>
                        </button>
                    </li>
                </ul>
                @endif
            </div>     
            <div class="body pt-0 px-0">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <select class="form-control select2 change-supplier" name="supplier">
                            @if($data['suppliers']->isNotEmpty())
                                @foreach($data['suppliers'] as $supp)
                                <option value="{{$supp->id}}" <?php if($data['supplier']->id == $supp->id) {echo 'selected'; } ?>>{{$supp->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="render-supplier-details p-3" style="background: #f9f6f2;">
                            <h5>{{$data['supplier']->name}}</h5>
                            <div>{{$data['supplier']->phone}}</div> 
                            <div style="margin-top: -2px;"><small>{{$data['supplier']->location}}</small></div>
                            <div class="supp-action">
                                <button class="btn btn-outline-warning edit-supplier-btn" sid="{{$data['supplier']->id}}" sname="{{$data['supplier']->name}}" sphone="{{$data['supplier']->phone}}" slocation="{{$data['supplier']->location}}"><i class="fa fa-pencil"></i></button>
                                <button class="btn btn-outline-danger delete-supplier-btn" sid="{{$data['supplier']->id}}" sname="{{$data['supplier']->name}}"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <fieldset style="border: 1px #ddd solid">
                            <legend class="px-1" style="border: 1px #ddd solid;margin-left: 1em;width:70px;font-size: 12px;"><?php echo date('Y'); ?></legend>
                            <div class="loader"> <span><i class="fa fa-spinner fa-spin"></i> Loading...</span> </div>
                            <div class="row">
                                <div class="col-8">
                                    <div class="left-names" style="display: inline-block;text-align: right;">
                                        <div><small><?php echo $_GET["items-bought"]; ?>:</small></div>
                                        <div><small><?php echo $_GET["value-of-items"]; ?>:</small></div>
                                        <!-- <div><small><?php echo $_GET["amount-you-borrow"]; ?>:</small></div> -->
                                        <div><small><?php echo $_GET["amount-you-paid"]; ?>:</small></div>
                                    </div>
                                    <div style="display: inline-block;">
                                        <div><b class="y_totalq">0</b></div>
                                        <div><b class="y_totalp">0</b></div>
                                        <!-- <div><b class="y_borrow">0</b></div> -->
                                        <div><b class="deposits" style="color: #41B06E;">0</b></div>
                                    </div>
                                    <!-- <h5><span class="y_totalq">0</span> <small>Products Bought</small></h5>
                                    <h5><span class="y_totalp">0</span> <small>Value of Items</small></h5>
                                    <h5><span class="deposits">0</span> <small>Deposits</small></h5> -->
                                </div>
                                <div class="col-4 render-y-balance">
                                    <h5>0</h5>
                                    <small>Balance</small>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-md-12 records-blc" style="margin-top: 30px;">
                        <div class="">
                            <div><b>Purchases and Deposits</b></div>
                            <div style="float: right;">
                                <button class="btn btn-sm btn-outline-info supplier-purchase-btn" sid="{{$data['supplier']->id}}" data-toggle="modal" data-target="#addPQuantity"><i class="fa fa-plus"></i> <?php echo $_GET["purchase"]; ?></button>
                                <button class="btn btn-sm btn-outline-success supplier-deposit-btn" sid="{{$data['supplier']->id}}" sname="{{$data['supplier']->name}}"><i class="fa fa-dollar"></i> <?php echo $_GET["pay-debt"]; ?></button>
                                <!-- <button class="btn btn-sm btn-outline-secondary supplier-borrow-btn" sid="{{$data['supplier']->id}}" sname="{{$data['supplier']->name}}"><i class="fa fa-dollar"></i> <?php echo $_GET["borrow-money"]; ?></button> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <hr>
                        <div class="render-purchases-deposits">                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="newSupplier" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel"><?php echo $_GET["new-supplier"]; ?> <small style="font-size:12px"> - {{$data['shop']->name}}</small></h4>
            </div>
            <div class="modal-body"> 
                <form id="basic-form" class="new-supplier">
                    @csrf
                    <input type="hidden" name="shopstore" value="shop"> 
                    <input type="hidden" name="sid" value="{{$data['shop']->id}}"> 
                    <div class="row clearfix">
                        <div class="col-sm-7 col-8">
                            <div class="form-group">
                                <label><?php echo $_GET["full-name"]; ?></label>
                                <input type="text" class="form-control" placeholder="Full Name" name="name" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label><?php echo $_GET["phone-number"]; ?></label>
                                <input type="text" class="form-control" placeholder="Phone" name="phone" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label><?php echo $_GET["address"]; ?></label>
                                <input type="text" class="form-control" placeholder="Anapopatikana" name="location" required>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-3 clearfix">
                        <div class="col-9">
                            <button type="submit" class="btn btn-primary submit-new-supplier" style="width: inherit;">Submit</button>
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-primary">SAVE CHANGES</button>
            </div> -->
        </div>
    </div>
</div>

<!-- purchase stock modal -->
<div class="modal fade" id="addPQuantity" role="dialog" aria-labelledby="saleModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="title" id="largeModalLabel"><?php echo $_GET['add-products-to-purchase']; ?> </h5>
                <ul class="header-dropdown mb-0" style="list-style: none;">
                    <li>
                        <button class="btn btn-danger btn-sm close-modal" data-dismiss="modal"><i class="fa fa-times py-1"></i></button>
                    </li>
                </ul>
            </div>
            <div class="modal-body pq-body"> 
                <form class="purchase-products-form">
                    <div class="pq-list">
                        <!-- list of selected items  -->
                    </div>
                    <div class="pq-select">
                        <select name="product" class="form-control select2" style="width: 250px;">
                            <option value="-">- <?php echo $_GET['choose-product']; ?> -</option>
                        </select>
                    </div>
                    <div class="pq-add-pro mt-2">
                        <button class="btn btn-sm"><i class="fa fa-plus text-info pr-1"></i><?php echo $_GET['add']; ?></button>
                        <span class="pl-1 add-loader"><i class="fa fa-spinner fa-spin"></i></span>
                    </div>
                    <div class="pq-footer mt-5">
                        <div class="mb-2">
                            <b><small>Total:</small></b>
                            <div><b class="supp-tq">0</b> items worth <b class="supp-tp">0</b></div>
                        </div>
                        <button type="submit" class="btn btn-success submit-purchased-cart" style="width: 40%;"><i class="fa fa-check pr-2"></i> Purchase</button>
                        <button class="btn btn-outline-danger clear-purchased-cart"><i class="fa fa-times pr-2"></i> Cansel</button>
                    </div>
                </form>
            </div>
            <div class="modal-body body-loader" style="display: none;">
                <div class="p-3">
                    <i class="fa fa-spinner fa-spin fa-2x"></i> <br>
                    Submitting..
                </div>
            </div>
            <div class="modal-body after-purchase" style="display: none;">
                <div class="p-3">
                    <form id="basic-form" class="deposit-after-purchase">
                        <p class="mb-0">You have bought</p>
                        <h5><span class="supp-tq"></span> items worth <span class="supp-tp"></span></h5>
                        <p class="mb-1 mt-3"><b>How much do you pay?</b></p>
                        <input type="number" class="form-control" name="amount" value="" style="width: 150px;font-size: 16px;"> <br>
                        <input type="hidden" name="sid" value="{{$data['supplier']->id}}">
                        <input type="hidden" name="from" value="shop">
                        <input type="hidden" name="shopid" value="{{$data['shop']->id}}">
                        <button class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-primary">SAVE CHANGES</button> -->
                <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button> -->
            </div>
        </div>
    </div>
</div>

<script>
    $('.select2').select2();

    $(function () { 
        $('fieldset .loader').css('display','block');
        // checkPurchasesCart("<?php echo $data['shop']->id.'~'.$data['supplier']->id; ?>");
        supplierYearSummary("<?php echo $data['shop']->id.'~'.$data['supplier']->id; ?>");
    });

    $(document).on('change', '.change-supplier', function(e) {
        e.preventDefault();
        $('fieldset .loader').css('display','block');
        var sid = $(this).val();
        var sname = $(this).find("option:selected").text();
        $('.supplier-deposit-btn, .supplier-purchase-btn').attr('sid',sid).attr('sname',sname);
        history.replaceState({}, document.title, "?tab=suppliers&supplier_id="+sid);
        getSupplierDetails(sid);
        supplierYearSummary("<?php echo $data['shop']->id; ?>~"+sid);
    });

    function getSupplierDetails(sid) {
        $('.render-supplier-details').html('<div class="m-3"><i class="fa fa-spinner fa-spin"></i> Loading...<div>'); 
        $.get("/suppliers/get-supplier-details/"+sid, function(data){
            $('.render-supplier-details').html(data.details);     
            checkPurchasesCart("<?php echo $data['shop']->id; ?>~"+sid);     
        });
    }

    function checkPurchasesCart(ssid) {
        $.get("/suppliers/supplier-purchases-cart/"+ssid+"~shop", function(data){
            $('.pq-list').html('<div class="m-3"><i class="fa fa-spinner fa-spin"></i> Checking...<div>');
            $('.pq-select select').html('<option value="-">- <?php echo $_GET["choose-product"]; ?> -</option>');
            if(data.data.allproducts) {
                $(data.data.allproducts).each(function(index, value) {
                    $('.pq-select select').append('<option value="'+value.id+'">'+value.name+'</option>');
                });
            }
            if(data.output.length == 0) {
                // no pending cart
                $('.pq-list').html("");
                $('.pq-footer, .pq-add-pro').css('display','none');
                $('.pq-select').css('display','block');
            } else {
                $('.pq-list').html(data.output);
                $('.pq-footer, .pq-add-pro').css('display','block');
                $('.pq-select').css('display','none');
                $('.supp-tq').text(data.data.totalq);
                $('.supp-tp').text(data.data.totalp);
            }
        });
    }
    
    function supplierYearSummary(ssid) {
        $.get("/suppliers/supplier-year-summary/"+ssid+"~shop", function(data){
            $('fieldset .loader').css('display','none');   
            $('.deposits').html(data.data.deposits);
            $('.y_totalq').html(data.data.totalq);
            $('.y_totalp').html(data.data.totalp);
            $('.y_borrow').html(data.data.borrow);
            $('.render-y-balance').html(data.data.balance);

            getSupplierPurchasesDepositsDetails(ssid);
            // console.log(data.data.deposits);     
        });
    }

    function getSupplierPurchasesDepositsDetails(ssid) {
        $('.render-purchases-deposits').html('<div class="m-3"><i class="fa fa-spinner fa-spin"></i> Loading...<div>'); 
        $.get("/suppliers/get-purchases-deposits/"+ssid+"~shop", function(data){
            if(data.details.length == 0) {
                $('.render-purchases-deposits').html('<div class="no-records">- No records yet -</div>');   
            } else {
                $('.render-purchases-deposits').html(data.details);   
            }  
        });
    }
    
    $(document).on('click', '.supplier-purchase-btn', function(e){
        e.preventDefault();
        // $('#addPQuantity').modal('toggle');
        var suppid = (new URL(location.href)).searchParams.get('supplier_id');
        checkPurchasesCart("<?php echo $data['shop']->id; ?>~"+suppid);
        $('.supp-tq').text(0);
        $('.supp-tp').text(0);
        $('.body-loader, .after-purchase').css('display','none');
        $('.pq-body').css('display','block');
        $('#addPQuantity .close-modal').css('display', 'inline');
    });
    
    $(document).on('click', '.pq-add-pro button', function(e){
        e.preventDefault();
        $('.pq-select').css('display','block');
        $('.pq-add-pro').css('display','none');
    });
    
    $(document).on('keyup', '.p-quantity', function(e){
        e.preventDefault();
        $('.purchase-products-form button').prop('disabled',true);
        $('.add-loader').css('display','inline');
        var val = $(this).val();
        var rowid = $(this).attr('rowid');
        if(parseInt(val) > 0){
            $.get("/suppliers/update-purchased-quantity/"+rowid+"~"+val, function(data){
                $('.purchase-products-form button').prop('disabled',false);
                $('.add-loader').css('display','none');
                if(data.status == 'success') {
                    $('.rowq-'+data.data.rowid).text(data.data.newq);
                    $('.rowp-'+data.data.rowid).text(data.data.newp);
                    $('.supp-tq').text(data.data.totalq);
                    $('.supp-tp').text(data.data.totalp);
                }
            });
        } 
    });
    
    $(document).on('click', '.clear-pq-row2', function(e){
        e.preventDefault();
        $('.purchase-products-form button').prop('disabled',true);
        $('.add-loader').css('display','inline');
        var rowid = $(this).attr('rid');
        $.get("/suppliers/clear-purchased-row/"+rowid, function(data){
            $('.purchase-products-form button').prop('disabled',false);
            $('.add-loader').css('display','none');
            if(data.status == 'success') {
                $('.pq-row-'+data.data.rowid).fadeOut(300, function() { $(this).remove(); });
                popNotification('warning',"Row Cleared!");
                $('.supp-tq').text(data.data.totalq);
                $('.supp-tp').text(data.data.totalp);
            }
        });
    });
    
    $(document).on('click', '.clear-purchased-cart', function(e){
        e.preventDefault();
        $('.purchase-products-form button').prop('disabled',true);
        $('.add-loader').css('display','inline');
        $.get("/suppliers/clear-purchased-cart/<?php echo $data['shop']->id.'~'.$data['supplier']->id.'~shop'; ?>", function(data){
            $('.purchase-products-form button').prop('disabled',false);
            $('.add-loader').css('display','none');
            if(data.status == 'success') {
                popNotification('warning',"Purchased cart cleared successfully!");
                $('#addPQuantity').modal('hide');
                $('.pq-select').css('display','block');
                $('.pq-footer, .pq-add-pro').css('display','none');
                $('.pq-list').html("");
                $('.supp-tq, .supp-tp').text(0);
            }
        });
    });
    
    $(document).on('click', '.submit-purchased-cart', function(e){
        e.preventDefault();
        var tt = $('.pq-footer .supp-tp').text().replace(/,/g, '');
        $('.deposit-after-purchase [name="amount"]').val(tt);
        $('.body-loader').css('display','block');
        $('.pq-body').css('display','none');
        $.get("/suppliers/submit-purchased-cart/<?php echo $data['shop']->id.'~'.$data['supplier']->id.'~shop'; ?>", function(data){
            $('.purchase-products-form button').prop('disabled',false);
            $('.add-loader').css('display','none');
            if(data.status == 'success') {
                $('.body-loader').css('display','none');
                $('.after-purchase').css('display','block');
                $('#addPQuantity .close-modal').prop('disabled', true);
                popNotification('success',"Products have been purchased successfully!");
            }
        });
    });

    $(document).on('submit', '.edit-submitted-details-form', function(e){
        e.preventDefault(); 
        $('.notification-body button').prop('disabled',true);
        $('.bought-purchases').prepend('<div class="load-p bg-success text-white pl-2">Updating..</div>');
        var suppid = (new URL(location.href)).searchParams.get('supplier_id');
        var shopid = "<?php echo $data['shop']->id; ?>";
        
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        formdata.append('shopid',shopid);
        formdata.append('suppid',suppid);
        formdata.append('status','update purchased items');
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.load-p').css('display','none');
                    $('.notification-body button').prop('disabled',false);
                    supplierYearSummary("<?php echo $data['shop']->id; ?>~"+suppid);
                    $('.close-modal').css('display','inline');
                    if (data.status == "success") {
                        popNotification('success','Changes updated successful');
                    } else {
                        popNotification('warning',"Ops! System failed to update changes. Please try again");
                    }
                }
        });
    });

    $(document).on('click', '.delete-purchased-item', function(e){
        e.preventDefault();
        $('.item-row button').prop('disabled',true);
        var rowid = $(this).attr('pid');
        $('.bought-purchases').prepend('<div class="load-p bg-success text-white pl-2">Loading..</div>');
        $.get("/suppliers/clear-purchased-row-2/"+rowid+"~shop", function(data){
            if(data.status == 'success') {
                $('.item-row button').prop('disabled',false);
                $('.load-p').css('display','none');
                $('.prow-'+data.id).fadeOut(300, function() { $(this).remove(); });
            }
        });
    });
    
    $(document).on('keyup', '.updated-bq', function(e){
        e.preventDefault();
        var q = $(this).val();
        if(q == null || q == "") {
            q = 0;
        }
        var rid = $(this).attr('val');
        var bp = $('.epqq'+rid).text().replace(/,/g, '');
        bp = parseInt(bp) * parseInt(q);
        $('.epqqq'+rid).html(Number(bp).toLocaleString("en"));
    });
    

</script>