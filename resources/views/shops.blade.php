@extends('layouts.app')
@section('css')
<style type="text/css">
    /*table {table-layout: fixed;}*/
table th,
table td {
 /* border: 1px solid black;
  max-width: 100px;*/

  /*overflow: hidden;*/
}
.load-deleting.padding {
    padding-top: 20px;padding-bottom: 20px;
}
.load-deleting.padding p {
    display: block;width: 100%;text-align: center;margin-bottom: 0px;
}
.cashier-row {max-width: 300px;}

.load-areas {
    background: #000;color: #fff;position: absolute;width: 98%;min-height: 100%;z-index: 99;opacity: 0.5;text-align: center;padding-top: 50px;font-size: 20px;display: none;
}
.select2-selection__rendered {
    line-height: 31px !important;
}
.select2-container .select2-selection--single {
    height: 35px !important;font-size: 1rem;
}
.select2-selection__arrow {
    height: 34px !important;
}

@media screen and (max-width: 480px) {
    .cashier-row {max-width: 200px;}
    .shops-card {padding-left: 0px;padding-right: 0px;}
    .shops-card .reduce-padding {padding-left:0px;padding-right:0px}
    .c_list tr td.action-btn .btn {display:block;width:35px;margin-bottom:8px !important}

    .select2-selection__rendered {
        line-height: 28px !important;
    }
    .select2-container .select2-selection--single {
        height: 2rem !important;font-size: 13px;
    }
    .select2-selection__arrow {
        height: 2rem !important;
    }
    .select2-results__option {font-size: 13px !important;}
}
</style>
@endsection
@section('content')

<?php
if(Cookie::get("language") == 'en') {
     $_GET['country_select'] = "Country";
    $_GET['region_select'] = "Region";
    $_GET['ward_select'] = "Ward";
    $_GET['district_select'] = "District";
} else {
     $_GET['country_select'] = "Nchi";
    $_GET['region_select'] = "Mkoa";
    $_GET['ward_select'] = "Kata";
    $_GET['district_select'] = "Wilaya";
}
?>

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
                    <div class="col-md-12 shops-card">
                        <div class="card">    
                            <div class="body pt-0">
                                <div class="row">
                                    <div class="col-md-12 reduce-padding">  
                                    <div class="header px-0">
                                        <h2><?php echo $_GET['shops']; ?>:</h2>
                                        @if(Auth::user()->isCEOorAdminorBusinessOwner())
                                        <ul class="header-dropdown">
                                            <li>
                                                <button class="btn btn-info btn-sm add-shop-2">
                                                    <b style=""><?php echo $_GET['create-new-shop']; ?></b>
                                                </button>
                                            </li>
                                        </ul>
                                        @endif
                                    </div>     
                                    <div class="table-responsive">
                                        <table class="table m-b-0 c_list">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th><?php echo $_GET['shop-name']; ?></th>              
                                                    <!-- <th>Location</th>  -->
                                                    <!-- <th><?php echo $_GET['cashier']; ?></th>                                                -->
                                                    
                                                    <th style="text-align: right;"><?php echo $_GET['action']; ?></th>
                                                    
                                                </tr>
                                            </thead>
                                                <tbody>
                                                @if($data['shops'])
                                                @foreach($data['shops'] as $value)
                                                    <tr>
                                                        @if($data['isCEO'] == "no")     
                                                        <td style="white-space: normal !important;word-wrap: break-word;">
                                                            <a href="/shops/<?php echo $value->sid; ?>">
                                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" style="width:15px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                                            </svg> {{$value->sname}} </a> <br>
                                                            <i class="fa fa-map-marker"></i> @if($value->rid) {{$value->wname}}, {{$value->dname}} @else {{$value->location}} @endif
                                                        </td>                                 
                                                        <!-- <td>
                                                            {{$value->location}}
                                                        </td> -->
                                                        <td align="right">  
                                                            <a href="#" class="btn btn-primary btn-sm view-shop" shop="{{$value->sid}}"><i class="fa fa-eye"></i></a> 
                                                        </td>
                                                        @else
                                                        <td style="white-space: normal !important;word-wrap: break-word;">
                                                            <a href="/shops/<?php echo $value->sid; ?>">
                                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" style="width:15px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                                            </svg> {{$value->sname}} </a><br>
                                                            <i class="fa fa-map-marker"></i> @if($value->rid) {{$value->wname}}, {{$value->dname}} @else {{$value->location}} @endif
                                                        </td>                                 
                                                        <!-- <td>
                                                            {{$value->location}}
                                                        </td>  -->
                                                        <!-- <td>
                                                            <div class="row">
                                                                <div class="col-md-6 cashier-row">
                                                                </div>
                                                            </div>                                                            
                                                        </td>  --> 
                                                        <td class="action-btn" align="right">  
                                                            <a href="#" class="btn btn-primary btn-sm view-shop" shop="{{$value->sid}}"><i class="fa fa-eye"></i></a>
                                                            <a href="#" class="btn btn-info btn-sm edit-shop" country="{{$value->cid}}" region="{{$value->rid}}" district="{{$value->did}}" ward="{{$value->wid}}" shop="{{$value->sid}}" sname="{{$value->sname}}" location="{{$value->location}}"><i class="fa fa-edit"></i></a>
                                                            <a href="#deleteShop{{$value->sid}}" class="btn btn-danger btn-sm delete-shop" data-toggle="modal" data-target="#deleteShop{{$value->sid}}"><i class="fa fa-trash"></i></a>
                                                        </td>
                                                        @endif  
                                                    </tr>
                                                    
@if($data['isCEO'] == "no")

@else

    <!-- delete modal -->
    <div class="modal fade" id="deleteShop{{$value->sid}}" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h4 class="title" id="largeModalLabel">Edit shop</h4> -->
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9;padding: 0px;margin-top: 1px;margin-right: 1px;margin-bottom: 1px;">
                        <button class="btn btn-danger btn-sm">x</button>
                    </span>
                </div>
                <div class="modal-body"> 
                    <!-- <form id="basic-form" class="edit-shop" shop="{{$value->id}}">
                        @csrf -->
                        <div class="row clearfix load-deleting">
                            <div class="col-12">
                                <p class="text-danger">Do you want to delete <b class="text-info">{{$value->sname}}</b> shop ?</p> 
                                By deleting this: <br>
                                All the information connected to this shop will be deleted too permanently <br>
                                1. Sales records <br>
                                2. Stock records <br>
                                3. Item(s) transfer records <br>
                                3. Customers records <br>
                                4. Expenses records
                            </div>                            
                        </div>
                    <!-- </form> -->
                </div>
                <div class="modal-footer d-flex justify-content-center align-content-center">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Dont delete</button>
                    <button type="button" class="btn btn-danger btn-sm delete-shop2" shop="{{$value->sid}}">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endif
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    </div>

                                    <!-- <div class="col-md-3 text-light">
                                        <div class="py-4 mt-4" align="center" style="background:linear-gradient(0deg, rgba(34,193,195,1) 0%, rgba(0,90,169,1) 100%)">
                                            <h4> Tengeneza duka.. Bonyeza jina la duka kuingia ndani ya duka uweze kuuza bidhaa, kurekodi matumizi ya dukani, kuona stock iliyopo dukani n.k</h4>
                                        </div>
                                    </div> -->
                                    
                                    <div class="col-12 mb-4 reduce-padding">
                                        <div class="accordion" id="accordion" style="margin-top: 60px;">
                                            <div class="">
                                                <div class="card-header" id="headingOne">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link collapsed show-customer" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                            <i class="fa fa-info-circle fa-2x" style="float: left;"></i>
                                                            <div style="float: left;font-weight: bold;padding-top: 5px;padding-left: 10px;"> Maelezo kuhusu duka</div> 
                                                            <i class="fa fa-angle-down fa-2x" style="float: right;"></i>
                                                        </button>
                                                    </h5>
                                                </div>                                
                                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" style="border: 2px solid #eee;">
                                                    <div class="card-body" style="padding-bottom: 10px;padding-top: 10px;">                
                                                        <div> <br>
                                                            <b>Duka</b> Lina kazi kubwa mbili. <br>
                                                            1. Kuhifadhia bidhaa zako <br>
                                                            2. Kuuza bidhaa <br><br>
                                                            Mfumo wa Levanda POS utakusaidia kufanya mambo yafuatayo yatayokusaidia kuendesha biashara yako kidijitali:<br><br> 
                                                            1. Unaweza kuona bidhaa zote zilizopo dukani kwako na idadi zake. <br>
                                                            2. Unaweza kuongeza stock mpya na kupata taarifa za stock zote za nyuma ulizoziongeza dukani. <br>
                                                            3. Unaweza kuuza bidhaa na kuona mauzo yako yote ya siku za nyuma (Ripoti za mauzo). <br>
                                                            4. Unaweza kusajili wateja wako na kutunza kumnbukumbu za mambo muhim yanayowahusu wateja wako, kama: bidhaa walizowahi kununua kwako, madeni unayowadai/wanayokudai, marejesho ya pesa yaliyolipwa n.k <br>
                                                            5. Kama unamiliki duka zaidi ya moja au unamiliki stoo, unaweza ukahamisha (Transer) bidhaa zako kutoka sehem moja kwenda ingine. <br>
                                                            6. Unaweza kurekodi matumizi yako ya kila siku ya dukani. <br><br>
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
                </div>

            </div>
        </div>
    </div>
    
    @include('modals.new-shop')
    
    <!-- view shop modal -->
    <div class="modal fade" id="viewShop" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h4 class="title" id="largeModalLabel">Edit shop</h4> -->
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9;padding: 0px;margin-top: 1px;margin-right: 1px;margin-bottom: 1px;">
                        <button class="btn btn-danger btn-sm">x</button>
                    </span>
                </div>
                <div class="modal-body"> 
                    <h5>Shop Details</h5>
                    <div class="row">
                        <div class="col-12 view-sname"></div>
                        <div class="col-12"><i class="fa fa-map-marker pr-2 text-info"></i> <span class="view-slocation"></span></div>
                    </div>
                    <div class="row">
                        <div class="col-6">                            
                            <h5 class="mt-4">Cashiers</h5>
                            <div class="view-scashiers"><i class="fa fa-spinner fa-spin"></i></div>
                        </div>
                        <div class="col-6">                            
                            <h5 class="mt-4">Sales Person</h5>
                            <div class="view-sperson"><i class="fa fa-spinner fa-spin"></i></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-primary">SAVE CHANGES</button> -->
                    <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button> -->
                </div>
            </div>
        </div>
    </div>

    <!-- edit modal -->
    <div class="modal fade" id="editShop" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Edit shop</h4>
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9;padding: 0px;margin-top: 1px;margin-right: 1px;margin-bottom: 1px;">
                        <button class="btn btn-danger btn-sm">x</button>
                </div>
                <div class="modal-body"> 
                    <form id="basic-form" class="edit-shop-form">
                        @csrf
                        <div class="load-areas">
                            <i class="fa fa-spinner fa-spin"></i>
                        </div>
                        <input type="hidden" name="shopid">
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="mb-1">Shop Name</label>
                                    <input type="text" class="form-control" placeholder="Name" name="name" value="" required>
                                </div>
                            </div>
                            <!-- <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Location</label>
                                    <input type="text" class="form-control" placeholder="Location" name="location" value="" required>
                                </div>
                            </div> -->
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="mb-1"><?php echo $_GET['country_select']; ?></label>
                                    <select class="form-control select2 change-country" name="change_country" style="width: 100%;" required>
                                        <option value="">- <?php echo $_GET['select']; ?> -</option>
                                        @if($data['countries']->isNotEmpty())
                                        @foreach($data['countries'] as $country)
                                            <option value="{{$country->id}}">{{$country->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-6 shoplocation_view">
                                <div class="form-group">
                                    <label class="mb-1"><?php echo $_GET['shop-location']; ?></label>
                                    <input type="text" class="form-control form-control-sm" id="" name="shoplocation">
                                </div>
                            </div>
                        </div>
                        <div class="row location_view">
                            <div class="col-sm ">
                                <div class="form-group">
                                    <label class="text-capitalize mb-1"><?php echo $_GET['region_select']; ?></label>
                                    <div class="input-group mb-3">
                                        <select class="form-control select2 region_id" name="region_id" style="width: 100%" required>
                                            <option value="" disabled selected>-Select-</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm col-6">
                                <div class="form-group">
                                    <label class="text-capitalize mb-1"><?php echo $_GET['district_select']; ?></label>
                                    <div class="input-group mb-3">
                                        <select class="form-control select2 district_id" name="district_id" style="width: 100%" required>
                                            <option value="" disabled selected>-Select-</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm col-6">
                                <div class="form-group">
                                    <label class="text-capitalize mb-1"><?php echo $_GET['ward_select']; ?></label>
                                    <div class="input-group mb-3">
                                        <select class="form-control select2 ward_id" name="ward_id" style="width: 100%" required>
                                            <option value="" disabled selected>-Select-</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2 clearfix">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary submit-edit-shop" shop="" style="width: inherit;">Submit</button>
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

@endsection

@section('js')
<script type="text/javascript">
    $('.select2').select2();
    
    $(document).ready(function() {
      $(".select2").select2({
        dropdownParent: $("#editShop")
      });
      $(".select2").select2({
        dropdownParent: $("#newShop")
      });
    });

    $(document).on('click', '.add-shop-2', function(e){
        e.preventDefault();
        $('.load-areas').css('display','block');
        // $('.new-shop')[0].reset();
        $('.check-location-level').html('<input type="hidden" class="user-location" value="shops-page">');
        $('#newShop').modal('toggle');
        $('.change-country-2').val(213).trigger("change");
    });

    $(document).on('click', '.edit-shop', function(e){
        e.preventDefault(); 
        // $('.new-shop')[0].reset();
        var country_id = $(this).attr('country');
        var region_id = $(this).attr('region');
        var district_id = $(this).attr('district');
        var ward_id = $(this).attr('ward');
        var shop = $(this).attr('shop');
        $('.edit-shop-form [name="shopid"]').val(shop);
        $('.edit-shop-form [name="name"]').val($(this).attr('sname'));
        $('[name="shoplocation"]').val($(this).attr('location'));
        $('.load-areas').css('display','block');
        $('#editShop').modal('toggle');
        
        if (country_id) {
            if (country_id == 213) {   // tanzania
                $('.location_view').removeClass('d-none');
                $('.shoplocation_view').addClass('d-none');

                $('.change-country').select2('destroy');
                $('.change-country').val(213).select2();

                $(".select2").select2({
                    dropdownParent: $("#editShop")
                });

                $.get("/get-data/regions-by-cid/"+country_id, function(data){
                    $('.load-areas').css('display','none');

                    var $regionSelect = $('.edit-shop-form .region_id');

                    $regionSelect.empty();
                    $regionSelect.append('<option value="-" disabled selected>-Select-</option>');
                    $.each(data.data.regions, function(index, region) {
                        var selectedR = "";
                        if (region.id == region_id) {
                            selectedR = "selected";
                        }
                        $regionSelect.append('<option value="' + region.id + '" '+selectedR+'>' + region.name + '</option>');
                    });

                    $.get("/get-data/districts-by-rid/"+region_id, function(data2){ 
                        var $districtSelect = $('.district_id');

                        $districtSelect.empty();
                        $districtSelect.append('<option value="" disabled selected>-Select-</option>');
                        $.each(data2.data.districts, function(index, district) {
                            var selectedD = "";
                            if (district.id == district_id) {
                                selectedD = "selected";
                            }
                            $districtSelect.append('<option value="' + district.id + '" '+selectedD+'>' + district.name + '</option>');
                        });
                    });

                    $.get("/get-data/wards-by-did/"+district_id, function(data3){ 
                        var $wardSelect = $('.ward_id');

                        $wardSelect.empty();
                        $wardSelect.append('<option value="" disabled selected>-Select-</option>');
                        $.each(data3.wards, function(index, ward) {
                            var selectedW = "";
                            if (ward.id == ward_id) {
                                selectedW = "selected";
                            }
                            $wardSelect.append('<option value="' + ward.id + '" '+selectedW+'>' + ward.name + '</option>');
                        });
                    });

                });
            } else {
                $('.region_id, .district_id, .ward_id').html('<option value="-" disabled selected>-Select-</option>'); // do this to avoid null selection on above.

                $(".select2").select2({
                    dropdownParent: $("#editShop")
                });
                $('.change-country').select2('destroy');
                $('.change-country').val(country_id).select2();
                $('.change-country').val(country_id).trigger("change");
            }
        } else {
            $(".select2").select2({
                dropdownParent: $("#editShop")
            });
            $('.change-country').val(213).trigger("change"); // get tanzania regions
        }
        
    });

    function country_id_call(country_id) {

        $('.load-areas').css('display','block');

                    var $regionSelect = $('.region_id');

                    $regionSelect.empty();

                    var $districtSelect = $('.district_id');

                    $districtSelect.empty();

                    var $wardSelect = $('.ward_id');

                    $wardSelect.empty();

        $.ajax({
            type: 'GET',
            url: '/get/region_data',
            data: {
                country_id: country_id,
            },
            success: function(data) {
                // console.log(data);
                $('.load-areas').css('display','none');

                if (data.status == "success") {

                    var $regionSelect = $('.region_id');

                    $regionSelect.empty();
                    $regionSelect.append('<option value="-" disabled selected>-Select-</option>');
                    $.each(data.regions, function(index, region) {
                        $regionSelect.append('<option value="' + region.id + '">' + region.name + '</option>');
                    });

                } else {
                    popNotification('warning',"Failed to load regions");
                }
            }
        });
    };

    $(document).on('change', '.change-country', function(e){ // from edit shop modal
        e.preventDefault();
        var country_id = $(this).val();

        if (country_id == 213) {

            $('.location_view').removeClass('d-none');
            $('.shoplocation_view').addClass('d-none');
            country_id_call(country_id);
        } else {
            // location_view
            $('.shoplocation_view').removeClass('d-none');
            $('.location_view').addClass('d-none');

            $('.load-areas').css('display','none');

            // $('[name="shoplocation"]').val($('.edit-shop').attr('location'));
            $('.region_id, .district_id, .ward_id').html('<option value="-" disabled selected>-Select-</option>'); // do this to avoid null selection on above
        }
    });
    $(document).on('change', '.change-country-2', function(e){ // from add shop modal
        e.preventDefault();
        var country_id = $(this).val();

        if (country_id == 213) {

            $('.location_view').removeClass('d-none');
            $('.shoplocation_view').addClass('d-none');
            country_id_call(country_id);
        } else {
            // location_view
            $('.shoplocation_view').removeClass('d-none');
            $('.location_view').addClass('d-none');

            $('.load-areas').css('display','none');

            $('.region_id, .district_id, .ward_id').html('<option value="-" disabled selected>-Select-</option>'); // do this to avoid null selection on above
        }
    });

    $(document).on('change', '.region_id', function(e){
        $('.load-areas').css('display','block');

        var region_id = $(this).val();

                    var $districtSelect = $('.district_id');

                    $districtSelect.empty();

                    var $wardSelect = $('.ward_id');

                    $wardSelect.empty();

        $.ajax({
            type: 'GET',
            url: '/get/district_data',
            data: {
                region_id: region_id,
            },
            success: function(data) {
                $('.load-areas').css('display','none');

                if (data.status == "success") {

                    var $districtSelect = $('.district_id');

                    $districtSelect.empty();
                    $districtSelect.append('<option value="" disabled selected>-Select-</option>');
                    $.each(data.districts, function(index, district) {
                        $districtSelect.append('<option value="' + district.id + '">' + district.name + '</option>');
                    });

                } else {
                    popNotification('warning',"Failed to load Districts");
                }
            }
        });

    });

    $(document).on('change', '.district_id', function(e){
        $('.load-areas').css('display','block');

        var district_id = $(this).val();
        // console.log(district_id);

                    var $wardSelect = $('.ward_id');

                    $wardSelect.empty();

        $.ajax({
            type: 'GET',
            url: '/get/ward_data',
            data: {
                district_id: district_id,
            },
            success: function(data) {
                $('.load-areas').css('display','none');

                if (data.status == "success") {

                    var $wardSelect = $('.ward_id');

                    $wardSelect.empty();
                    $wardSelect.append('<option value="" disabled selected>-Select-</option>');
                    $.each(data.wards, function(index, ward) {
                        $wardSelect.append('<option value="' + ward.id + '">' + ward.name + '</option>');
                    });

                } else {
                    popNotification('warning',"Failed to load Wards");
                }
            }
        });

    });

    $(document).on('submit', '.edit-shop-form', function(e){
        e.preventDefault();
        $('.submit-edit-shop').prop('disabled', true).html('submiting..');

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        formdata.append('country_id',$('.change-country').val());
        $.ajax({
            type: 'POST',
            url: '/edit-shop',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.submit-edit-shop').prop('disabled', false).html('Submit');
                    if (data.status == "success") {
                        popNotification('success',"Success! Shop updated successfully.");
                        window.location = "/shops";
                    } else {
                        popNotification('warning',"Sorry! Something went wrong. Please try again.");
                    }
                }
        });
    });

    $(document).on('click', '.view-shop', function(e){ 
        e.preventDefault();
        var shop_id = $(this).attr('shop');
        $('#viewShop').modal('toggle');
        $.get("/get-data/shop-details/"+shop_id, function(data){
            if ($.isEmptyObject(data.shop)) { } else {
                $('.view-sname').html(data.shop[0]['sname']);
                if (data.shop[0]['rname']) {
                    $('.view-slocation').html(data.shop[0]['wname']+', '+data.shop[0]['dname']+', '+data.shop[0]['rname']);
                } else {
                    $('.view-slocation').html(data.shop[0]['location']);
                }
            }

            if ($.isEmptyObject(data.cashiers)) {
                $('.view-scashiers').html("--");
            } else {
                $('.view-scashiers').html("");
                for (var i = 0; i < data.cashiers.length; i++) {
                    $('.view-scashiers').append('<li>'+data.cashiers[i]['uname']+'</li>');
                }
            }

            if ($.isEmptyObject(data.sperson)) {
                $('.view-sperson').html("--");
            } else {
                $('.view-sperson').html("");
                for (var i = 0; i < data.sperson.length; i++) {
                    $('.view-sperson').append('<li>'+data.sperson[i]['uname']+'</li>');
                }
            }
        });
    });

    $(document).on('click', '.untouch-cashier', function(e){
        var cashier = $(this).attr('cashier');
        if(confirm("Click OK to confirm that "+cashier+" is no longer cashier in this shop.")){
            e.preventDefault();
            $('.full-cover').css('display','block');
            var uid = $(this).attr('val');
            var shop = $(this).attr('shop');

            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            var formdata = new FormData();
            formdata.append('uid',uid);
            formdata.append('shop',shop);
            $.ajax({
                type: 'POST',   
                url: '/untouch-cashier',
                processData: false,
                contentType: false,
                data: formdata,
                    success: function(data) {
                        $('.full-cover').css('display','none');
                        if (data.error) {
                            popNotification('warning',data.error);
                        } else {
                            popNotification('success',data.success);
                            $('#rcashier'+data.shop+data.id).css('display','none');
                        }
                    }
            });
        }
        return;
    });

    $(document).on('click', '.delete-shop2', function(e){
        e.preventDefault();
        $('button').prop('disabled',true);
        $('.load-deleting').html('<p><i class="fa fa-spinner fa-spin" style="font-size:20px;"></i> <span style="padding-left:10px">Deleting...</span></p><p style="font-size:16px;color:red">It will take sometime</p>').addClass('padding');
        var shop_id = $(this).attr('shop');

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData();
        formdata.append('status','delete shop');
        formdata.append('shop_id',shop_id);
        $.ajax({
            type: 'POST',   
            url: '/delete',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    if (data.status == "success") {
                        popNotification('success',"Shop deleted successfully.");
                        $(document).ajaxSuccess(function(){
                            window.location.reload();
                        });
                    } else {
                        popNotification('warning','Error.. Something went wrong, please try again.');
                        $(document).ajaxSuccess(function(){
                            window.location.reload();
                        });
                    }
                }
        });
    });
</script>
@endsection