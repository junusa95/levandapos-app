<style>
    .product-d span {min-width: 120px;display: inline-block;}
    .img img {width: 100%;}

    .shop-q input, .store-q input {margin-left: 10px;width: 80px !important;}

    @media screen and (max-width: 767px) {
        .left-shops {margin-bottom: 30px;}
    }
</style>
@include("layouts.translater") 

<?php
    if(Cookie::get("language") == 'en') {
        $_GET['fill-quantity-info'] = 'Fill available quantity in a shop/store then click "<b>Update quantity</b>".. You will not be able to see product inside shop/store if it has zero quantity';
    } else {
        $_GET['fill-quantity-info'] = 'Jaza idadi iliyopo kwenye duka/stoo kisha bonyeza "<b>Boresha idadi</b>".. Hautaweza kuiona bidhaa kwenye duka/stoo kama haina idadi';
    }
?>

<div class="row" style="background-color: #f0f0f0;">
    @if($data['product']->image) 
        <?php $src = '/images/companies/'.Auth::user()->company->folder.'/products/'. $data['product']->image; $image = $data['product']->image; ?>
    @else
        <?php  $src = "/images/product.jpg"; $image = ""; ?>
    @endif
    <input type="hidden" name="pid" value="{{$data['product']->id}}">
    <input type="hidden" name="pname" value="{{$data['product']->name}}">
    <div class="col-md-2 col-6 mt-3">
        <div class="img mb-3">
            <img src="{{$src}}" alt="">
        </div>
    </div>
    <div class="col-md-8 col-10 my-3 product-d">
        <div><span><?php echo $_GET['product-name']; ?> </span>: <b>{{$data['product']->name}}</b></div>
        <div><span><?php echo $_GET['category']; ?> </span>: <b>{{$data['product']->productcategory->name}}</b></div> 
        <div><span><?php echo $_GET['buying-price']; ?> </span>: <b>{{str_replace(".00", "", number_format($data['product']->buying_price, 2))}}</b></div>
        <div><span><?php echo $_GET['selling-price']; ?> </span>: <b>{{str_replace(".00", "", number_format($data['product']->retail_price, 2))}}</b></div>
        <div><span><?php echo $_GET['created-at']; ?> </span>: <b>{{date('d/m/Y', strtotime($data['product']->created_at))}}</b></div>
    </div>
    <div class="col-md-2 col-1 mt-3 pl-0">
        <a href="/products?opt=edit-product&pid={{$data['product']->id}}" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> <?php echo $_GET['edit']; ?></a>
    </div>
</div>

<div class="mt-4">
    <h5><?php echo $_GET['product-quantity']; ?></h5>
</div>
<div class="row pb-4" style="background-color: #f0f0f0;">
    <?php if($data['totalQty'] + $data['totalQty2'] == 0) { ?>
    <div class="p-2" style="color: red;">
        <?php echo $_GET['fill-quantity-info']; ?>
    </div>
    <?php } ?>
    <div class="col-12 py-3">
        <svg class="w-6 h-6 text-gray-800 dark:text-white" style="width:15px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
        </svg> <?php echo $_GET['total-quantity']; ?>: <b class="total-q">{{$data['totalQty'] + $data['totalQty2']}}</b>
    </div>
    <div class="col-12 col-md-6 left-shops">
        <div class="pb-2"><b style="border-bottom: 2px solid;"><?php echo $_GET['shops']; ?></b></div>
        @if($data['shops'])
        <div style="border-bottom: 1px solid #fff;display: none;">
            @foreach($data['shops'] as $shop)
                <?php $shquantity = 0; ?>
                <?php $check = $data['product']->shopProductRelation($shop->id); ?>
                @if($check)
                    <?php $shquantity = $check->quantity; ?>
                @endif
                <label class="fancy-checkbox" style="margin-right: 20px !important;">
                    <input type="checkbox" class="shqtty" name="shqtty{{$shop->id}}" value="{{$shop->id}}" qt="{{$shquantity}}" shname="{{$shop->name}}" <?php if($check){echo "checked";} ?>>
                    <span>{{$shop->name}}</span>
                </label>            
            @endforeach
        </div>
        <form id="basic-form" class="sh-q-form">
            <div class="mt-3 shop-q">
                @foreach($data['shops'] as $shop)
                    <?php $check = $data['product']->shopProductRelation($shop->id); ?>
                    @if($check)
                    <?php $shquantity = $check->quantity; ?>
                    <div class="form-inline mt-2 sh-q-{{$check->shop_id}}">
                        <label for="">{{$shop->name}}: </label>
                        <input type="hidden" name="shid[]" value="{{$shop->id}}">
                        <input type="text" name="shQF{{$shop->id}}" class="form-control form-control-sm" value="{{floatval($check->quantity)}}">
                        <span class="btn btn-danger btn-sm p-0 px-2 ml-1 del-shq" sid="{{$shop->id}}" qt="{{$shquantity}}" shname="{{$shop->name}}" db="yes"><i class="fa fa-times"></i></span>
                    </div>        
                    @endif 
                @endforeach
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-info update-sh-q"><?php echo $_GET['update-quantity']; ?></button>
            </div>
        </form>
        @else
        <div>No shop created yet. <br> Click <a href="/shops">HERE</a> to create.</div>
        @endif
    </div>
    <div class="col-12 col-md-6">
        <div class="pb-2"><b style="border-bottom: 2px solid;"><?php echo $_GET['stores']; ?></b></div>
        @if($data['stores']->isNotEmpty())
        <div style="border-bottom: 1px solid #fff;display: none;">
            @foreach($data['stores'] as $store)
                <?php $stquantity = 0; ?>
                <?php $check = $data['product']->storeProductRelation($store->id); ?>
                @if($check)
                    <?php $stquantity = $check->quantity; ?>
                @endif                
                <label class="fancy-checkbox" style="margin-right: 20px !important;">
                    <input type="checkbox" class="stqtty" name="stqtty{{$store->id}}" value="{{$store->id}}" qt="{{$stquantity}}" stname="{{$store->name}}" <?php if($check){echo "checked";} ?>>
                    <span>{{$store->name}}</span>
                </label>         
            @endforeach
        </div>
        <form id="basic-form" class="st-q-form">
            <div class="mt-3 store-q">
                @foreach($data['stores'] as $store)
                    <?php $check = $data['product']->storeProductRelation($store->id); ?>
                    @if($check)
                    <?php $stquantity = $check->quantity; ?>
                    <div class="form-inline mt-2 st-q-{{$check->store_id}}">
                        <label for="">{{$store->name}}: </label>
                        <input type="hidden" name="stid[]" value="{{$store->id}}">
                        <input type="text" name="stQF{{$store->id}}" class="form-control form-control-sm" value="{{floatval($check->quantity)}}">
                        <span class="btn btn-danger btn-sm p-0 px-2 ml-1 del-stq" sid="{{$store->id}}" qt="{{$stquantity}}" stname="{{$store->name}}" db="yes"><i class="fa fa-times"></i></span>
                    </div>        
                    @endif 
                @endforeach
            </div>            
            <div class="mt-3">
                <button type="submit" class="btn btn-info update-st-q"><?php echo $_GET['update-quantity']; ?></button>
            </div>
        </form>
        @else
        <div>No store created yet. <br> Click <a href="/stores">HERE</a> to create.</div>
        @endif
    </div>
</div>

<script>
    $(function() {
        $('.shqtty').click();
        $('.stqtty').click();
    });

    $(".shqtty").click(function (e) {
        var sid = $(this).val();
        var sname = $(this).attr('shname');
        var sqtty = $(this).attr('qt');
        var pid = $('[name="pid"]').val();
        var pname = $('[name="pname"]').val();
        if ($( this ).prop( "checked" )) { //append shop
            $('.shop-q').append('<div class="form-inline mt-2 sh-q-'+sid+'"><label for="">'+sname+': </label><input type="hidden" name="shid[]" value="'+sid+'"><input type="text" name="shQF'+sid+'" class="form-control form-control-sm" value="0"><span class="btn btn-danger btn-sm p-0 px-2 ml-1 del-shq" sid="'+sid+'" qt="'+sqtty+'" shname="'+sname+'" db="no"><i class="fa fa-times"></i></span></div>');
        } else { // dont uncheck
            e.preventDefault(); // this will prevent checkbox to be unchecked
        }
    });
    
    $(document).on("click", ".del-shq", function(e){
        var sid = $(this).attr('sid');
        var sname = $(this).attr('shname');
        var sqtty = $(this).attr('qt');
        var db = $(this).attr('db');
        var pid = $('[name="pid"]').val();
        var pname = $('[name="pname"]').val();
        if(sqtty == 0) {             
            if (db == 'yes') { //zero is from DB
                $('.notification-body').html('<div><b>Removing..</b></div>');
                $('#notificationModal').modal();
                $.get('/get-data/update-shop-product/'+sid+'/'+pid, function(data) {
                    if(data.status == 'updated') {
                        $('#notificationModal').modal('hide');
                        popNotification('success','Product has been updated successfully.');
                        $('[name="shqtty'+data.sid+'"]').attr('qt',0).prop('checked', false);
                        $('.sh-q-'+data.sid).remove();
                    } else {
                        $('#notificationModal').modal('hide');
                        popNotification('warning','Error! Fail to update. Please try again.');
                    }
                });   
            } else {
                $('.sh-q-'+sid).remove();
                $('[name="shqtty'+sid+'"]').attr('qt',0).prop('checked', false);
            }
        } else {
            $('.notification-body').html('<div><b>Checking..</b></div>');
            $('#notificationModal').modal();
            $('.notification-body').html('<div>Unataka kuondoa <b>'+pname+':</b> Idadi: <b>'+sqtty+'</b> kwenye duka la <b>'+sname+'</b> ? <div class="mt-3"><button class="btn btn-warning btn-sm" data-dismiss="modal" aria-label="Close">Hapana</button><button class="btn btn-success btn-sm ml-2 unlink-shop-product" pid="'+pid+'" sid="'+sid+'">Ndio</button></div></div>');
        }
    });

    $(document).on("click", ".unlink-shop-product", function(event){
        // e.preventDefault();
        $('.notification-body').html('<div><b>Updating..</b></div>');
        var sid = $(this).attr('sid');
        var pid = $(this).attr('pid');
   
        $.get('/get-data/update-shop-product/'+sid+'/'+pid, function(data) {
            if(data.status == 'updated') {
                $('#notificationModal').modal('hide');
                popNotification('success','Product has been updated successfully.');
                $('.total-q').html(data.totalq);
                $('[name="shqtty'+data.sid+'"]').attr('qt',0).prop('checked', false);
                $('.sh-q-'+data.sid).remove();
            } else {
                $('#notificationModal').modal('hide');
                popNotification('warning','Error! Fail to update. Please try again.');
            }
        });   
    });
    
    $(".stqtty").click(function (e) {
        var sid = $(this).val();
        var sname = $(this).attr('stname');
        var sqtty = $(this).attr('qt');
        var pid = $('[name="pid"]').val();
        var pname = $('[name="pname"]').val();
        if ($( this ).prop( "checked" )) { //apend store
            $('.store-q').append('<div class="form-inline mt-2 st-q-'+sid+'"><label for="">'+sname+': </label><input type="hidden" name="stid[]" value="'+sid+'"><input type="text" name="stQF'+sid+'" class="form-control form-control-sm" value="0"><span class="btn btn-danger btn-sm p-0 px-2 ml-1 del-stq" sid="'+sid+'" qt="'+sqtty+'" stname="'+sname+'" db="no"><i class="fa fa-times"></i></span></div>');
        } else { // remove store
            e.preventDefault(); // this will prevent checkbox to be unchecked
        }
    });
    
    $(document).on("click", ".del-stq", function(e){
        var sid = $(this).attr('sid');
        var sname = $(this).attr('stname');
        var sqtty = $(this).attr('qt');
        var db = $(this).attr('db');
        var pid = $('[name="pid"]').val();
        var pname = $('[name="pname"]').val();
        if(sqtty == 0) {             
            if (db == 'yes') { //zero is from DB
                $('.notification-body').html('<div><b>Removing..</b></div>');
                $('#notificationModal').modal();
                $.get('/get-data/update-store-product/'+sid+'/'+pid, function(data) {
                    if(data.status == 'updated') {
                        $('#notificationModal').modal('hide');
                        popNotification('success','Product has been updated successfully.');
                        $('[name="stqtty'+data.sid+'"]').attr('qt',0).prop('checked', false);
                        $('.st-q-'+data.sid).remove();
                    } else {
                        $('#notificationModal').modal('hide');
                        popNotification('warning','Error! Fail to update. Please try again.');
                    }
                });   
            } else {
                $('.st-q-'+sid).remove();
                $('[name="stqtty'+sid+'"]').attr('qt',0).prop('checked', false);
            }
        } else {
            $('.notification-body').html('<div><b>Checking..</b></div>');
            $('#notificationModal').modal();
            $('.notification-body').html('<div>Unataka kuondoa <b>'+pname+':</b> Idadi: <b>'+sqtty+'</b> kwenye stoo ya <b>'+sname+'</b> ? <div class="mt-3"><button class="btn btn-warning btn-sm" data-dismiss="modal" aria-label="Close">Hapana</button><button class="btn btn-success btn-sm ml-2 unlink-store-product" pid="'+pid+'" sid="'+sid+'">Ndio</button></div></div>');
        }
    });

    $(document).on("click", ".unlink-store-product", function(e){
        // e.preventDefault();
        $('.notification-body').html('<div><b>Updating..</b></div>');
        var sid = $(this).attr('sid');
        var pid = $(this).attr('pid');
   
        $.get('/get-data/update-store-product/'+sid+'/'+pid, function(data) {
            if(data.status == 'updated') {
                $('#notificationModal').modal('hide');
                popNotification('success','Product has been updated successfully.');
                $('.total-q').html(data.totalq);
                $('[name="stqtty'+data.sid+'"]').attr('qt',0).prop('checked', false);
                $('.st-q-'+data.sid).remove();
            } else {
                $('#notificationModal').modal('hide');
                popNotification('warning','Error! Fail to update. Please try again.');
            }
        });   
    });

    $(document).on("submit", ".sh-q-form", function(e){ // this is no longer in use
        e.preventDefault();
        $('.update-sh-q').prop('disabled', true).html('updating..');
        var pid = $('[name="pid"]').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formdata = new FormData(this);
        formdata.append('status','update shop quantity');
        formdata.append('pid',pid);
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.update-sh-q').prop('disabled', false).html('Update quantity');
                    if (data.status = "updated") {
                        popNotification('success','Quantity updated successfully');
                        $(document).ajaxSuccess(function(){
                            window.location.reload();
                        });
                    } else {
                        popNotification('warning',data.error);
                    }
                }
        });
    });
    
    $(document).on("submit", ".st-q-form", function(e){
        e.preventDefault();
        $('.update-st-q').prop('disabled', true).html('updating..');
        var pid = $('[name="pid"]').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formdata = new FormData(this);
        formdata.append('status','update store quantity');
        formdata.append('pid',pid);
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.update-st-q').prop('disabled', false).html('Update quantity');
                    if (data.status = "updated") {
                        popNotification('success','Quantity updated successfully');
                        $(document).ajaxSuccess(function(){
                            window.location.reload();
                        });
                    } else {
                        popNotification('warning',data.error);
                    }
                }
        });
    });
    
</script>