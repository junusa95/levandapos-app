@extends('layouts.app')
@section('css')
<style type="text/css">
    .remove-store, .remove-shop {
        cursor: pointer;color: red;
    }
    .p_image_preview {
        padding-top: 4px;
    }
    .p_image_preview img {
        width: 100px;height: 100px;object-fit: cover;
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
                        <div class="col-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/products" class="">
                                    <!-- <i class="fa fa-arrow-left pr-1"></i>  -->
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10" style="width:15px">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4"/>
                                    </svg>
                                </a></li>                            
                                <li class="breadcrumb-item active"><?php echo $_GET['edit-product']; ?></li> 
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">      
                            <div class="header">
                                <h2><?php echo $_GET['edit-product']; ?>:</h2>
                                <ul class="header-dropdown">
                                    <li><button class="btn btn-success btn-sm save-as-copy" val="{{$data['product']->id}}">Save as copy</button></li>
                                </ul>
                            </div>   
                            <div class="body">
                                <form id="basic-form" class="update-product-form" method="post" action="{{ route('update-product') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="pid" value="{{$data['product']->id}}">
                                    <div class="row clearfix">
                                        <div class="col-md-4 col-6">
                                            <div class="form-group">
                                                <label><?php echo $_GET['product-name']; ?></label>
                                                <input type="text" class="form-control" placeholder="Product Name" name="name" value="{{$data['product']->name}}" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-3" style="display: none;">
                                            <div class="form-group">
                                                <label>Main category*</label>
                                                <select class="form-control cgroup" name="cgroup">
                                                    <option value="">- select -</option>
                                                    @if($data['cgroups'])
                                                        @foreach($data['cgroups'] as $group)
                                                            <option value="{{$group->id}}" <?php if($group->id == $data['category-group']->id) { echo 'selected'; } ?>>{{$group->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label><?php echo $_GET['category']; ?></label>
                                                <div class="input-group">
                                                    <select class="custom-select pcategory select2" name="pcategory" id="inputGroupSelect04" style="width: 50%;" required>
                                                        <option selected="">- <?php echo $_GET['select']; ?> -</option>
                                                        @if($data['categories'])
                                                            @foreach($data['categories'] as $category)
                                                                <option value="{{$category->id}}" <?php if($category->id == $data['product-category']->id) { echo 'selected'; } ?>>{{$category->name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-secondary btn-sm new-sub-category-form" data-toggle="modal" data-target="#addSCategory" style="margin-left: -1px;"><i class="fa fa-plus"></i> <?php echo $_GET['add']; ?> </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 clearfix">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label><?php echo $_GET['buying-price']; ?></label>
                                                <input type="number" class="form-control" placeholder="Buying Price" name="buying_price" value="{{$data['product']->buying_price}}">
                                            </div>
                                        </div>
                                        <div class="col-sm-4" style="display: none;">
                                            <div class="form-group">
                                                <label>Wholesale Price</label>
                                                <input type="number" class="form-control" placeholder="Wholesale Price" name="wholesale_price" value="{{$data['product']->wholesale_price}}">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label><?php echo $_GET['selling-price']; ?></label>
                                                <input type="number" class="form-control" placeholder="Retail Price" name="retail_price" value="{{$data['product']->retail_price}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 clearfix">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Attach Image</label>
                                                @if($data['product']->image) 
                                                    <?php $src = '/images/companies/'.Auth::user()->company->folder.'/products/'. $data['product']->image; $image = $data['product']->image; ?>
                                                @else
                                                    <?php  $src = "/images/product.jpg"; $image = ""; ?>
                                                @endif
                                                <input type="file" class="form-control form-control-sm p-img-input" name="image" value="{{$image}}"  accept="image/png, image/gif, image/jpeg">
                                                <div class="p_image_preview">
                                                    <img id="p_imgPreview" src="{{ $src }}" name="" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4" style="display:none">
                                            <div class="form-group">
                                                <label>Status*</label>
                                                <select class="form-control" name="status" required>
                                                    <?php for ($i=0; $i < count($data['status']); $i++) { ?>
                                                            <option value="{{$data['status'][$i]}}" <?php if($data['status'][$i] == $data['product']->status) { echo 'selected'; } ?>>{{ucfirst($data['status'][$i])}}</option>
                                                        <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-sm-12 mt-2">
                                            <div style="display: none;">
                                                <input type="submit" class="btn update-product-2" value="submit">
                                            </div>                      
                                            <button type="submit" class="btn btn-primary update-product" style="width: inherit;">Update changes</button>
                                        </div>
                                    </div>
                                </form>

                                <!-- update quantity -->
                                <form id="basic-form" class="update-product-quantity mt-4" method="post" action="{{ route('update-quantity') }}">
                                    @csrf
                                    <input type="hidden" name="pid" value="{{$data['product']->id}}">
                   <!--                  <div class="">
                                        <label>Quantity Management:</label>
                                        <blockquote>
                                            <div class="blockquote blockquote-primary">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Stores</label>
                                                            <select class="form-control select-store">
                                                                <option value="">- select -</option>
                                                                @if($data['stores'])
                                                                    @foreach($data['stores'] as $store)
                                                    <?php //$check = $data['product']->storeProductRelation($store->id); ?>
                                                                        <option value="{{$store->id}}" <?php //if($check){echo 'disabled';} ?>>{{$store->name}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                        <div class="render-store-q">
                                                            @if($data['stquantity'])
                                                                @foreach($data['stquantity'] as $stq)
                    <div class="row alert alert-secondary store-blck<?php //echo $stq->store_id; ?>  m-0 mb-2 p-0 py-1">
                        <div class="col-sm-6">
                            {{ App\Http\Controllers\StoreController::storeById($stq->store_id)->name }}
                        </div>
                        <div class="col-sm-6">
                            <input type="hidden" name="store[]" value="{{$stq->store_id}}">
                            <input type="number" class="form-control form-control-sm" name="stquantity<?php //echo $stq->store_id; ?>" value="{{$stq->quantity}}" required>
                        </div>
                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Shops</label>
                                                            <select class="form-control select-shop">
                                                                <option value="">- select -</option>
                                                                @if($data['shops'])
                                                                    @foreach($data['shops'] as $shop)
                                                    <?php //$check = $data['product']->shopProductRelation($shop->id); ?>
                                                                        <option value="{{$shop->id}}" <?php //if($check){echo 'disabled';} ?>>{{$shop->name}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                        <div class="render-shop-q">
                                                            @if($data['shquantity'])
                                                                @foreach($data['shquantity'] as $shq)
                    <div class="row alert alert-secondary shop-blck<?php //echo $shq->shop_id; ?>  m-0 mb-2 p-0 py-1">
                        <div class="col-sm-6">
                            display shop name here
                        </div>
                        <div class="col-sm-6">
                            <input type="hidden" name="shop[]" value="{{$shq->shop_id}}">
                            <input type="number" class="form-control form-control-sm" name="shquantity<?php //echo $shq->shop_id; ?>" value="{{$shq->quantity}}" required>
                        </div>
                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                    <div class="row clearfix">
                                        <div class="col-sm-12 mt-3" style="text-align: center;">
                                            <div style="display: none;">
                                                <input type="submit" class="btn update-quantity-2" value="submit">
                                            </div>                      
                                            <button type="submit" class="btn btn-primary update-quantity" style="width: 50%;">Update Quantity</button>
                                        </div>
                                    </div>
                                            </div>
                                        </blockquote>
                                    </div> -->
                                </form>
                            </div>                            
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- add sub category modal -->
    <div class="modal fade" id="addSCategory" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
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

@endsection

@section('js')
<script type="text/javascript">
    $('.select2').select2();

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

    $(".p-img-input").change(function(){
        $('.p_image_preview').css("display","block");
        const file = this.files[0];
        if (file) {
          let reader = new FileReader();
          reader.onload = function(event){
            $('#p_imgPreview').attr('src', event.target.result);
          }
          reader.readAsDataURL(file);
        }
        
    });

    $(document).on('change', '.select-store', function(e){
        e.preventDefault();
        var store_id = $(this).val();
        var name = $('.select-store option:selected').text();
        if (store_id == '') {
            return;
        }
        $('.select-store option:selected').attr("disabled", true);
        $('.render-store-q').append('<div class="row alert alert-secondary store-blck'+store_id+' m-0 mb-2 p-0 py-1">'+
                    '<div class="col-sm-6">'+name+'</div>'+
                    '<div class="col-sm-5">'+
                        '<input type="hidden" name="store[]" value="'+store_id+'">'+
                        '<input type="number" class="form-control form-control-sm" name="stquantity'+store_id+'" value="1" required>'+
                    '</div>'+
                    '<div class="col-sm-1 remove-store" val="'+store_id+'">'+
                        '<i class="fa fa-times"></i>'+
                    '</div></div>');
    });

    $(document).on('click', '.remove-store', function(e){
        e.preventDefault();
        var store_id = $(this).attr('val');
        $('.select-store option[value='+ store_id +']').attr("disabled", false);
        $('.store-blck'+store_id).remove();
    });

    $(document).on('change', '.select-shop', function(e){
        e.preventDefault();
        var shop_id = $(this).val();
        var name = $('.select-shop option:selected').text();
        if (shop_id == '') {
            return;
        }
        $('.select-shop option:selected').attr("disabled", true);
        $('.render-shop-q').append('<div class="row alert alert-secondary shop-blck'+shop_id+' m-0 mb-2 p-0 py-1">'+
                    '<div class="col-sm-6">'+name+'</div>'+
                    '<div class="col-sm-5">'+
                        '<input type="hidden" name="shop[]" value="'+shop_id+'">'+
                        '<input type="number" class="form-control form-control-sm" name="shquantity'+shop_id+'" value="1" required>'+
                    '</div>'+
                    '<div class="col-sm-1 remove-shop" val="'+shop_id+'">'+
                        '<i class="fa fa-times"></i>'+
                    '</div></div>');
    });

    $(document).on('click', '.remove-shop', function(e){
        e.preventDefault();
        var shop_id = $(this).attr('val');
        $('.select-shop option[value='+ shop_id +']').attr("disabled", false);
        $('.shop-blck'+shop_id).remove();
    });

    $(document).on('click', '.update-product', function(e){
        e.preventDefault();
        $(this).prop('disabled', true).html('updating..');
        $('.update-product-2').click();
    });

    $(document).on('click', '.update-quantity', function(e){
        e.preventDefault();
        $(this).prop('disabled', true).html('updating..');
        $('.update-quantity-2').click();
    });

    $(document).on('click', '.save-as-copy', function(e){
        e.preventDefault();
        $(this).prop('disabled', true).html('saving..');
        var id = $(this).attr('val');
        $.get('/save-as-copy/product/'+id, function(data){
            if (data.error) {
                popNotification('warning',data.error);
            } else {
                popNotification('success','Successful saving as copy');
                window.location = '/ceo/products/'+data.id;
            }
        });
    });
    
</script>
@endsection