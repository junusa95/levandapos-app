@extends('layouts.app')
@section('css')
<style type="text/css">
    .remove-store, .remove-shop {
        cursor: pointer;color: red;
    }
    .p_image_preview {
        padding-top: 4px;display: none;
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
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">      
                            <div class="header">
                                <h2>Add new product:</h2>
                                <ul class="header-dropdown">
                                    <li>
                                        <a href="/ceo/products" class="btn btn-info btn-sm">
                                            <b style="">View products</b>
                                        </a>
                                    </li>
                                </ul>
                            </div>  
                            <div class="body">
                                <form id="basic-form" class="new-product" method="post" action="{{ route('new-product') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row clearfix">
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label>Name*</label>
                                                <input type="text" class="form-control" placeholder="Product Name" name="name" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Product Group*</label>
                                                <select class="form-control cgroup" name="cgroup" required>
                                                    <option value="">- select -</option>
                                                    @if($data['cgroups'])
                                                        @foreach($data['cgroups'] as $group)
                                                            <option value="{{$group->id}}">{{$group->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Category*</label>
                                                <select class="form-control pcategory" name="pcategory" required>
                                                    <option value="">- select -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 clearfix">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Buying Price</label>
                                                <input type="number" class="form-control" placeholder="Buying Price" name="buying_price">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Wholesale Price</label>
                                                <input type="number" class="form-control" placeholder="Wholesale Price" name="wholesale_price">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Retail Price</label>
                                                <input type="number" class="form-control" placeholder="Retail Price" name="retail_price">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 clearfix">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Unit of Measurement*</label>
                                                <select class="form-control" name="measurement" required>
                                                    <option value="">- select -</option>
                                                    @if($data['measurements'])
                                                        @foreach($data['measurements'] as $measurement)
                                                            <option value="{{$measurement->id}}">{{$measurement->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Attach Image</label>
                                                <input type="file" class="form-control form-control-sm p-img-input" name="image"  accept="image/png, image/gif, image/jpeg">
                                                <div class="p_image_preview">
                                                    <img id="p_imgPreview" src="" name="" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Status*</label>
                                                <select class="form-control" name="status" required>
                                                    <option value="published">Published</option>
                                                    <option value="unpublished">Unpublished</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="mt-2">
                                        <label>Quantity</label>
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
                                                                        <option value="{{$store->id}}">{{$store->name}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                        <div class="render-store-q">
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Shops</label>
                                                            <select class="form-control select-shop">
                                                                <option value="">- select -</option>
                                                                @if($data['shops'])
                                                                    @foreach($data['shops'] as $shop)
                                                                        <option value="{{$shop->id}}">{{$shop->name}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                        <div class="render-shop-q">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </blockquote>
                                    </div> -->
                                    <div class="row clearfix mt-1">
                                        <div class="col-sm-12 mt-3">
                                            <div style="display: none;">
                                                <input type="submit" class="btn submit-product" value="submit">
                                            </div>                                            
                                            <button type="submit" class="btn btn-primary submit-new-product" style="width: inherit;">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>                            
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('js')
<script type="text/javascript">

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

    $(document).on('click', '.submit-new-product', function(e){
        e.preventDefault();
        $(this).prop('disabled', true).html('submiting..');
        $('.submit-product').click();
    });
</script>
@endsection