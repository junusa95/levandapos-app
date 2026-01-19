@include("layouts.translater")

<style type="text/css">
    .editing-no-h-2 {display:none}
    .transfer-form2 .col-6 {padding-left: 5px;padding-right: 5px;}
    .select2-selection__rendered {
        line-height: 31px !important;
    }
    .select2-container .select2-selection--single {
        height: 35px !important;
    }
    .select2-selection__arrow {
        height: 34px !important;
    }
    .select2-container {
        /*text-align: center;*/
    }
@media screen and (max-width: 480px) {
        .reduce-padding {padding-left:5px;padding-right:5px;}
    }
</style>

<div class="row clearfix">

    <div class="col-12 mt-3 pl-4" style="display:none;">
        <a href="#" class="transfer-tab pr-1"><i class="fa fa-arrow-left pr-1"></i> <?php echo $_GET['transfer-records-menu']; ?></a> |
        <!-- <h2>Customer:</h2> -->
        <h6 class="pl-1" style="display: inline-block;"><b><?php echo $_GET['transfer-item-menu']; ?></b></h6>
    </div>

    <div class="col-12 px-4">
        <div class="alert alert-info alert-dismissible mt-4 editing-no-h-2" role="alert" style="font-weight: bold; text-align: center;">
            <i class="fa fa-pencil"></i> <span class="editing-no ml-3"></span>
        </div>
    </div>

    <div class="col-lg-7 col-md-12 mt-3 reduce-padding">
        <div class="card">      
            <!-- <div class="header" style="border-bottom:1px solid #ddd;">
                <h2>Transfer Item(s):</h2>
            </div>      -->
            <div class="body">
                <form id="basic-form" class="transfer-form2">
                    @csrf
                    @if($data['from'] == "shop")
                    <input type="hidden" name="from" value="shop">
                    <input type="hidden" name="fromid" value="{{$data['shop']->id}}">
                    @endif
                    @if($data['from'] == "store")
                    <input type="hidden" name="from" value="store">
                    <input type="hidden" name="fromid" value="{{$data['store']->id}}">
                    @endif
                    <input type="hidden" name="transferno" value="null">
                    <input type="hidden" name="transferval" value="">
                    <div class="row clearfix">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Select shop/store</label>
                                <select class="form-control shopstore" name="shopstore" required>
                                    <option value="">- select -</option>
                                    <option class="bg-success text-light" disabled>-- Shops</option>
                                    @if($data['shops'])
                                        @foreach($data['shops'] as $shop)
                                            <option value="shop-{{$shop->id}}">{{$shop->name}}</option>
                                        @endforeach
                                    @else
                                        <option disabled><i>- null -</i></option>
                                    @endif
                                    <option class="bg-success text-light" disabled>-- Stores</option>
                                    @if($data['stores'])
                                        @foreach($data['stores'] as $store)
                                            <option value="store-{{$store->id}}">{{$store->name}}</option>
                                        @endforeach
                                    @else
                                        <option disabled><i>- null -</i></option>
                                    @endif
                                </select>
                                <input type="hidden" name="whereto" value="">
                                <input type="hidden" name="shostoval" value="">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Select shipper</label>
                                <select class="form-control shipper" name="shipper" required>
                                    <option value="">- select -</option>
                                    @if($data['users'])
                                        @foreach($data['users'] as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    @else
                                        <option disabled><i>- no user -</i></option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Select product</label>
                                <select class="form-control select2 product" name="product" required>
                                    <option value="">- select -</option>
                                    @if($data['products'])
                                        @foreach($data['products'] as $product)
                                            <option value="{{$product->id}}">{{$product->name}}</option>
                                        @endforeach
                                    @else
                                        <option disabled><i>- no product -</i></option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number" class="form-control" placeholder="Quantity" name="quantity" step="0.01" value="1" style="width:85%" required>
                                <span class="text-success aquantity" style="float: right;margin-top: -20px;font-weight: bold;">0</span>
                            </div>
                        </div>
                        <!-- <div class="col-sm-6">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control" placeholder="Description"></textarea>
                            </div>
                        </div> -->
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-12 mt-3">
                            <button type="submit" class="btn btn-primary submit-transfer" style="width: inherit;">Add to cart</button>
                        </div>
                    </div>
                </form>
            </div>                            
        </div>
    </div>

    <div class="col-lg-5 col-md-12 reduce-padding">
        <div class="card">      
            <div class="header">
                <h2>Products cart:</h2>
            </div>     
            <div class="body">
                <div style="margin-top: -20px;margin-bottom: 20px;">
                    <div>
                        <strong>Sent to:</strong><span class="bg-dark text-light px-2 py-1 ml-2 shostoname"></span>
                    </div>
                    <div class="mt-1">
                        <strong>Shipper:</strong><span class="bg-dark text-light px-2 py-1 ml-2 shippername"></span>
                    </div>   
                </div>
                <div class="table-responsive">
                    <table class="table m-b-0 c_list" style="border-bottom: 1px solid #ddd;">
                        <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Qty</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="render-cart">

                        </tbody>
                    </table>
                    <div class="pull-right mt-2">
                        <i class="fa fa-spinner fa-spin" style="font-size:20px;display: none;"></i>
                        <button class="btn btn-danger btn-sm clear-transfer-cart2">Clear all </button>
                        <button class="btn btn-success btn-sm submit-transfer-cart2">Done <i class="fa fa-check"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- modal --> 
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body align-center text-danger">
                    <p class="error-modal"></p>
                </div>
                <div class="py-2" style="text-align:center; border-top: 1px solid #ddd;">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Decline</button>
                    <button type="button" class="btn btn-primary btn-sm clear-transfer-cart2">Accept</button>
                </div>
            </div>
        </div>
    </div>




<script type="text/javascript">

$('.select2').select2();
var from = "<?php echo $data['from']; ?>";

/////// SHOP JS //////////

if(from == "shop") {

    var shop_id = $('[name="fromid"]').val();

    $(function () {
        $.get('/pending-transfer/shop/'+shop_id, function(data){
            if (data.item.status == 'edit') {
                $('.editing-no-h-2').css('display','block');
                $('.editing-no').html('Editing Transfer #: '+data.item.transfer_no);
                $('[name="transferno"]').val(data.item.transfer_no);
                $('[name="transferval"]').val(data.item.transfer_val);
            } 
            $('.shopstore').val(data.item.destination+'-'+data.item.destination_id).change();
            $('.shipper').val(data.shipper.id).change();
            $('[name="whereto"]').val(data.item.destination);
            $('[name="shostoval"]').val(data.item.destination_id); 
            $('.render-cart').html(data.cart);
        });
    });

    $(".shopstore").on('change', function(e) {
        e.preventDefault();
        var shopstoreval = $(this).val();
        var shostoname = $(this).find('option:selected').text();
        var split = shopstoreval.split("-");
        var whereto = split[0]; 
        shopstoreval = split[1];
        $.get('/shopstore/shop/'+shop_id+'/'+whereto+'/'+shopstoreval, function(data){
            if (data.error) {
                $('.error-modal').html(data.error);
                $('#exampleModal').modal('toggle');
                // alert(data.error)
            } else {       
                $('[name="whereto"]').val(whereto);  
                $('[name="shostoval"]').val(shopstoreval);  
                $('.shostoname').html(shostoname+' ('+whereto+')');   
            }
        });
    });

    $(".shipper").on('change', function(e) {
        e.preventDefault();
        var name = $(this).find('option:selected').text();
        $('.shippername').html(name);
    });

    $(".product").on('change', function(e) {
        e.preventDefault();
        var pid = $(this).val();
        $.get('/shopstore/shop/'+shop_id+'/'+pid, function(data){
            $('.aquantity').html(parseFloat(data.quantity));
        });
    });
}


/////// STORE JS //////////

if(from == "store") {
    
    var store_id = $('[name="fromid"]').val();

    $(function () {
        $.get('/pending-transfer/store/'+store_id, function(data){
            if (data.item.status == 'edit') {
                $('.editing-no-h-2').css('display','block');
                $('.editing-no').html('Editing Transfer #: '+data.item.transfer_no);
                $('[name="transferno"]').val(data.item.transfer_no);
                $('[name="transferval"]').val(data.item.transfer_val);
            } 
            $('.shopstore').val(data.item.destination+'-'+data.item.destination_id).change();
            $('.shipper').val(data.shipper.id).change();
            $('[name="whereto"]').val(data.item.destination);
            $('[name="shostoval"]').val(data.item.destination_id); 
            $('.render-cart').html(data.cart);
        });
    });

    $(".shopstore").on('change', function(e) {
        e.preventDefault();
        var shopstoreval = $(this).val();
        var shostoname = $(this).find('option:selected').text();
        var split = shopstoreval.split("-");
        var whereto = split[0]; 
        shopstoreval = split[1];
        $.get('/shopstore/store/'+store_id+'/'+whereto+'/'+shopstoreval, function(data){
            if (data.error) {
                $('.error-modal').html(data.error);
                $('#exampleModal').modal('toggle');
                // alert(data.error)
            } else {       
                $('[name="whereto"]').val(whereto);  
                $('[name="shostoval"]').val(shopstoreval);  
                $('.shostoname').html(shostoname+' ('+whereto+')');   
            }
        });
    });

    $(".shipper").on('change', function(e) {
        e.preventDefault();
        var name = $(this).find('option:selected').text();
        $('.shippername').html(name);
    });

    $(".product").on('change', function(e) {
        e.preventDefault();
        var pid = $(this).val();
        $.get('/shopstore/store/'+store_id+'/'+pid, function(data){
            $('.aquantity').html(parseFloat(data.quantity));
        });
    });
}




</script>