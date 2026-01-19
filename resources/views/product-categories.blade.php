@extends('layouts.app')
@section('css')
<style type="text/css">
    .each-cat {
        margin-left: 0px;margin-right: 0px;padding-left: 0px;padding-right: 0px;
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
                    <div class="col-lg-4 col-md-12">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-6">
                                <div class="card">
                                    <div class="header" style="border-bottom:1px solid #ddd;">
                                        <h2>Create New Category Group:</h2>
                                    </div>
                                    <div class="body">
                                        <form id="basic-form" class="new-cgroup">
                                            @csrf
                                            <div class="row clearfix">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Name</label>
                                                        <input type="text" class="form-control" placeholder="Name" name="name" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row clearfix">
                                                <div class="col-sm-12">
                                                    <button type="submit" class="btn btn-primary submit-new-cgroup" style="width: inherit;">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
        <div class="col-lg-12 col-md-6">
            <div class="card">
                <div class="header" style="border-bottom:1px solid #ddd;">
                    <h2>Create New Category:</h2>
                </div>
                <div class="body">
                    <form id="basic-form" class="new-pcategory">
                        @csrf
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Choose group</label>
                                    <select class="form-control form-control-sm" name="group">
                                        @foreach($data['groups'] as $value)
                                            <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Name(s)</label>
                                    <div class="col-sm-12 each-cat">
                                        <input type="hidden" name="check" value="1">
                                        <input type="text" class="form-control form-control-sm" placeholder="Name" name="name1" required> 
                                    </div>                                   
                                    <div class="col-sm-1 pull-right mt-2" style="margin-right:12px">
                                        <button class="btn btn-outline-info btn-sm add-category" id="1">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix mt-2">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary submit-new-pcategory" style="width: inherit;">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
                        </div>
                    </div>

                    <div class="col-lg-8 col-md-12">
                        <div class="card">      
                            <div class="header">
                                <h2>Product Categories:</h2>
                            </div>     
                            <div class="body pt-0">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table m-b-0 c_list">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Group</th>
                                                    <th>Categories</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                                <tbody>
                                                @if($data['groups'])
                                                @foreach($data['groups'] as $value)
                                                    <tr>
                                                        <td>
                                                            {{$value->name}}
                                                        </td> 
                                                        <td>
                                                            @if($value->productcategories())
                                                                @foreach($value->productcategories()->get() as $value2)
                                                                    <span class="badge badge-outline-dark">{{$value2->name}}</span>
                                                                @endforeach
                                                            @endif
                                                        </td>  
                                                        <td>  
                                                            <a href="#editPCategory{{$value->id}}" class="btn btn-info btn-sm edit-pcategory" data-toggle="modal" data-target="#editPCategory{{$value->id}}"><i class="fa fa-edit"></i></a>
                                                        </td>
                                                    </tr>
    <div class="modal fade" id="editPCategory{{$value->id}}" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Edit Group / Category</h4>
                    <ul class="header-dropdown" style="list-style: none;">
                        <li>
                            <button class="btn btn-success done-edit"><i class="fa fa-check"></i> Done</button>
                        </li>
                    </ul>
                </div>
                <div class="modal-body"> 
                    <form id="basic-form" class="edit-expense" expense="{{$value->id}}">
                        @csrf
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Group Name:</label>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-sm" placeholder="Group Name" name="gname{{$value->id}}" value="{{$value->name}}" required>
                                        </div>
                                        <div class="col-sm-2">
                                            <button class="btn btn-outline-info btn-sm update-group" val="{{$value->id}}">update</button>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="ml-3">
                                        <label>Categories:</label>
                                        @if($value->productcategories())
                                            @foreach($value->productcategories()->get() as $value2)
                                            <div class="row mb-2">
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control form-control-sm" placeholder="Category Name" name="cname{{$value2->id}}" value="{{$value2->name}}" required>
                                                </div>
                                                <div class="col-sm-4">
                                                    <select class="form-control form-control-sm" name="cgroup{{$value2->id}}">
                                                        @foreach($data['groups'] as $group)
                                                            <option value="{{$group->id}}" <?php if($group->id == $value->id) echo "selected"; ?>>{{$group->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <button class="btn btn-outline-info btn-sm update-p-category" val="{{$value2->id}}">update</button>
                                                </div>
                                            </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <!-- <button type="submit" class="btn btn-primary submit-edit-expense" style="width: inherit;">Submit</button> -->
                            </div>
                        </div>
                    </form>
                    <br>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-primary">SAVE CHANGES</button> -->
                    <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button> -->
                </div>
            </div>
        </div>
    </div>
                                                @endforeach
                                                @endif
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
@endsection

@section('js')
<script type="text/javascript">  
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
                        window.location = "/"+urlArray[1]+"/product-categories";
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
                        window.location = "/"+urlArray[1]+"/product-categories";
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
      window.location = "/"+urlArray[1]+"/product-categories";
    });
</script>
@endsection