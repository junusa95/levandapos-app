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
@media screen and (max-width: 481px) {
    /*.render-new-product-form .row {margin-left: -30px;margin-right: -30px;}*/
    .nav-out {padding-left: 0px;padding-right: 0px; }
    .nav-out .nav-tabs-new li a {padding: 5px 10px;}
    .tab-out {padding-left: 0px;padding-right: 0px;}
    .render-new-product-form .col-12,.render-new-product-form .col-6,.render-new-product-form .col-4 {padding-left: 2px;padding-right: 2px;}
    .render-new-product-form .mt-3 {margin-top: 0px !important;}
    .p-img-input {height: 28px !important;}
    .edit-pcategories-form .col-6, .edit-pcategories-form .col-5, .edit-pcategories-form .col-4 {padding-left: 2px;padding-right: 2px;}
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
                            <div class="body">
                                <div class="row">
                                    <div class="col-12 nav-out">
                                    <ul class="nav nav-tabs-new">
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Measurements"><?php echo $_GET['measurements-menu']; ?></a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#PCategories"><?php echo $_GET['p-categories-menu']; ?></a></li>
                                        <li class="nav-item"><a class="nav-link new-product-form" data-toggle="tab" href="#addProduct"><?php echo $_GET['add-product-menu']; ?></a></li>
                                    </ul>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="tab-content padding-0">
                                            <!-- measurements -->
                                            <div  class="tab-pane" id="Measurements">
                                                <div class="row">
                                                    <div class="col-md-5 tab-out">
                                                        <div class="card shadow">      
                                                            <div class="header">
                                                                <h2><?php echo $_GET['measurements-menu']; ?>:</h2>
                                                                <ul class="header-dropdown">
                                                                    <li><a class="tab_btn" title="Add new" data-toggle="modal" data-target="#addMeasurement">
                                                                        <i class="fa fa-plus text-success" style="margin-top: 7px"></i>
                                                                    </a></li>
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
                                                                                    <th><?php echo $_GET['action']; ?></th>
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
                                                        <div class="card shadow">      
                                                            <div class="header">
                                                                <h2><?php echo $_GET['p-categories-menu']; ?>:</h2>
                                                                <ul class="header-dropdown">
                                                                    <li><a class="tab_btn" title="Add new" data-toggle="modal" data-target="#addMCategory" style="width: 50px;">
                                                                        <i class="fa fa-plus text-success" style="margin-top: 7px"></i> 
                                                                        <span>M</span>
                                                                    </a></li>
                                                                    <li><a class="tab_btn new-sub-category-form" title="Add new" data-toggle="modal" data-target="#addSCategory" style="width: 50px;">
                                                                        <i class="fa fa-plus text-success" style="margin-top: 7px"></i> 
                                                                        <span>S</span>
                                                                    </a></li>
                                                                </ul>
                                                            </div>  
                                                            <div class="body pt-0">
                                                                <div class="row">
                                                                    <div class="table-responsive">
                                                                        <table class="table m-b-0 c_list">
                                                                            <thead class="thead-light">
                                                                                <tr>
                                                                                    <th><?php echo $_GET['main-category']; ?></th>
                                                                                    <th><?php echo $_GET['sub-categories']; ?></th>
                                                                                    <th><?php echo $_GET['action']; ?></th>
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
                                                        <div class="card shadow">      
                                                            <div class="header">
                                                                <h2><?php echo $_GET['create-new-product']; ?>:</h2>
                                                            </div>  
                                                            <div class="body pt-0 render-new-product-form">
                                         
                                                            </div>   
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end add product -->
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- products -->
                    <div class="col-lg-12 col-md-12">
                        <div class="card">      
                            <div class="header">
                                <h2><?php echo $_GET['products-menu']; ?>:</h2>
                                <ul class="header-dropdown">
                                    <li>
                                        <a href="/ceo/new-product-form" class="btn btn-info btn-sm">
                                            <b style=""><?php echo $_GET['add-product-menu']; ?></b>
                                        </a>
                                    </li>
                                </ul>
                            </div>     
                            <div class="body pt-0">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table m-b-0 c_list">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th><?php echo $_GET['name']; ?></th>   
                                                    <th><?php echo $_GET['buying-price']; ?></th>   
                                                    <th><?php echo $_GET['wholesale-price']; ?></th>   
                                                    <th><?php echo $_GET['retail-price']; ?></th>            
                                                    <th><?php echo $_GET['quantity-full']; ?></th>      
                                                    <th><?php echo $_GET['category']; ?></th>  
                                                    <th>Status</th>
                                                    <th><?php echo $_GET['action']; ?></th>
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
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="title" id="largeModalLabel"><?php echo $_GET['create-sub-category']; ?></h5>
                </div>
                <div class="modal-body render-new-sub-category-form"> 

                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-primary">SAVE CHANGES</button> -->
                    <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- edit prod. category modal -->
    <div class="modal fade" id="editPCategory" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="title" id="largeModalLabel"><?php echo $_GET['edit-main-sub-categories']; ?></h5>
                    <ul class="header-dropdown" style="list-style: none;">
                        <li>
                            <button class="btn btn-success btn-sm done-edit"><i class="fa fa-check"></i> Done</button>
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
    var role = <?php $data['role']; ?> //check role
    $(function () {        
        renderProducts();
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
        $('.render-p-categories').html("<tr><td colspan='3' align='center'>Loading...</td></tr>");      
        $.get('/get-data/p-categories/all', function(data) {
            $('.render-p-categories').html(data.pcategories);
        });   
    }

    function renderProducts() {
        $('.render-products').html("<tr><td colspan='8' align='center'>Loading...</td></tr>");
        $.get('/get-data/products/'+role, function(data) {
            $('.render-products').html(data.products);
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

    $(document).on('submit', '.new-pcategory', function(e){
        e.preventDefault();
        $('.submit-new-pcategory').prop('disabled', true).html('submiting..');
        var cat_g = $('.new-pcategory [name="group"]').val();
        if (cat_g == null || cat_g == "") {
            $('.submit-new-pcategory').prop('disabled', false).html('Submit');
            return;
        }
        var check = parseFloat($('.new-pcategory [name="check"]').val());
        for (var i = 1; i <= check; i++) {
            var name = $('.new-pcategory [name="name'+i+'"]').val();
            if (name.trim() == null || name.trim() == '') {
                $('.submit-new-pcategory').prop('disabled', false).html('Submit');
            }
            if (name.trim() == null || name.trim() == '') {
                $('.new-pcategory [name="name'+i+'"]').addClass('parsley-error').focus(); return;}
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formdata = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '/add-p-category',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.submit-new-pcategory').prop('disabled', false).html('Submit');
                    if (data.error) {
                        popNotification('warning',data.error);
                    } else {
                        popNotification('success',data.success);
                        $('#addSCategory').modal('hide');
                        $('.new-pcategory')[0].reset();
                        renderProductCategories();
                        // window.location = "/"+urlArray[1]+"/product-categories";
                    }
                }
        });
    });

    $(document).on('click', '.add-category', function(e){
      e.preventDefault();
      var rowid = parseFloat($(this).attr('id'));
      var newid = (rowid + 1);
      $(this).attr('id',newid);
      $('.new-pcategory [name="check"]').val(newid);
      $('.each-cat').append('<input type="text" class="form-control form-control-sm mt-2" placeholder="Name" name="name'+newid+'" required>');
      // var cat_id = $('.cat0  [name="name"]')val();
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
        $('.render-new-product-form').html("<div align='center'>Loading...</div>");
        $.get('/get-form/new-product/0', function(data) {
            $('.render-new-product-form').html(data.form);
        });           
    });

    $(document).on('click', '.new-sub-category-form', function(e){
        $('.render-new-sub-category-form').html("<div align='center'>Loading...</div>");
        $.get('/get-form/new-sub-category/0', function(data) {
            $('.render-new-sub-category-form').html(data.form);
        });           
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
        if (name.trim() == null || name.trim() == '' || cgroup.trim() == null || cgroup.trim() == '' || pcategory.trim() == null || pcategory.trim() == '' || buying_price.trim() == null || buying_price.trim() == '' || retail_price.trim() == null || retail_price.trim() == '' || measurement.trim() == null || measurement.trim() == '') {
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
                        $('.new-product')[0].reset();
                        renderProducts();
                        // window.location = "/"+urlArray[1]+"/product-categories";
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
        $('.render-pcategories-form').html("<div align='center'>Loading...</div>");
        $.get('/get-data/p-categories-form/'+pid, function(data) {
            $('.render-pcategories-form').html(data.p_categories_form);
        });            
        $('#editPCategory').modal('toggle');
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
                }
        });
    });

    $(document).on('click', '.done-edit', function(e){
        e.preventDefault();
        $('#editPCategory').modal('hide');
        renderProductCategories();
    });

    $(document).on('click','.deleteProduct',function(e){
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