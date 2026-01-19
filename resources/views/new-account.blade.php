@extends('layouts.appweb')
@section('css')
<style type="text/css">
hr.style14 {
  border: 0;
  height: 1px; width: 40%;text-align: center;
  background-image: -webkit-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
  background-image: -moz-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
  background-image: -ms-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
  background-image: -o-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
}
.header {margin-bottom: 20px;}
.mt-container {
    margin-top: 90px;
}
.form-group label {
    margin-bottom: 5px;font-size: 1rem;
}
.form-group .form-control {
    font-size: 1rem !important;height: 2.4rem;
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

/*password show hide*/
.pass_show{position: relative}
.pass_show .ptxt {
    position: absolute;
    top: 72%; right: 10px; z-index: 1; color: #f36c01;
    margin-top: -15px; cursor: pointer; transition: .3s ease all;
}
.pass_show .ptxt:hover{color: #333333;}
.tool-tip:hover {
    cursor: pointer;
}
.mt-container .top-row .top-col {margin-top: 2rem;}
.outer-body {padding-top:0px;padding-left: 10px; margin-bottom:10px;}
.h-line {border-bottom: 4px solid #EFB83C;width: 30px;background: lime;}
.shop-desc {margin-top: 30px;}
.shop-desc p {font-size: 13px;}
/* .shop-block {margin-top: 25px;} */

.location_view .load-areas {
    background: #000;color: #fff;position: absolute;width: 100%;min-height: 150px;z-index: 99;opacity: 0.5;text-align: center;padding-top: 50px;font-size: 20px;display: none;
}

@media screen and (max-width: 805px) {
    label {font-weight: normal;}
}
@media screen and (min-width: 768px) and (max-width: 991px) {
    .container.mt-container {width: 95% !important;max-width: 95% !important;padding-left: 0px;}
}
@media screen and (max-width: 768px) {
    .shop-block {margin-top: 0px;}
    .shop-desc {margin-top: 15px;margin-bottom: 15px;}
    .mt-container {padding-left: 0px;}
    .personal-block {margin-left: 5px;margin-right: 5px;}
}
@media screen and (max-width: 575px) {
    .container.mt-container {padding-left: 10px;padding-right: 20px;}
}
@media screen and (max-width: 480px) {
    .mt-container {padding-left: 5px;padding-right: 5px;}
    .mt-container .top-row .top-col {margin-top: 1.5rem;}
    .mt-container .top-row .col-6 {padding-left: 10px;padding-right: 10px;}
    /*.outer-body {padding-left: 5px;border-left: 3px solid #EFB83C;}
    .shop-block {padding-left: 5px;border-left: 3px solid #EFB83C;}*/
    .shop-desc p {font-size: 12px;}
    h2 {
        font-size: 1.5rem !important;font-weight: bold !important;
    }
    .mt-container p {font-size: 13px;}
    .mt-container label {font-size: 13px;}
    .mt-container .form-group .form-control {font-size: 13px !important;height: 2rem;}
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
    .input-group-text {font-size: 13px;padding-bottom: 0px;padding-top: 0px;}
    .pass_show .ptxt {font-size: 14px;margin-top: -10px;}
}
@media screen and (max-width: 400px) {
    .mt-container {margin-top: 60px;}
}
@media screen and (max-width: 371px) {

}
</style>
@endsection
@section('content')

<?php
if(Cookie::get("language") == 'en') {
    $_GET['n-click-to-continue'] = "Click to continue";
    $_GET['n-fill-account-name'] = "Please fill account name";
    $_GET['n-select-country'] = "Please select country";
    $_GET['n-shop-name'] = "Please fill shop name section";
    $_GET['n-shop-location-2'] = "Shop location";
    $_GET['n-shop-location'] = "Please fill Shop Location section";
    $_GET['n-full-name'] = "Please fill full name section";
    $_GET['n-select-currency'] = "Please select currency";
    $_GET['n-phone-number'] = "Please fill phone number section";
    $_GET['n-correct-phone-number'] = "Please fill the correct phone number. (Nine numbers required)";
    $_GET['n-choose-role'] = "Please choose role (your position in this company)";
    $_GET['n-fill-password'] = "Please fill Password section";
    $_GET['n-password-digits'] = "Password must contain at least 4 digits";
    $_GET['n-username'] = "Please fill Username section";
    $_GET['n-special-characters'] = "Special characters are not allowed for username except underscore";
    $_GET['n-username-used'] = "Sorry, The username is already used by someone else. Please change the username";
    $_GET['n-failed-to-create'] = "Error! Failed to create new Company, please try again";
     $_GET['country_select'] = "Country";
    $_GET['region_select'] = "Region";
    $_GET['ward_select'] = "Ward";
    $_GET['district_select'] = "District";
} else {
    $_GET['n-click-to-continue'] = "Bonyeza kuendelea";
    $_GET['n-fill-account-name'] = "Tafadhali jaza jina la akaunti";
    $_GET['n-select-country'] = "Tafadhali chagua nchi";
    $_GET['n-shop-name'] = "Tafadhali jaza jina la duka";
    $_GET['n-shop-location-2'] = "Linapopatikana duka";
    $_GET['n-shop-location'] = "Tafadhali jaza mahala duka linapopatikana";
    $_GET['n-full-name'] = "Tafadhali jaza jina lako kamili";
    $_GET['n-select-currency'] = "Tafadhali chagua fedha";
    $_GET['n-phone-number'] = "Tafadhali jaza namba yako ya simu";
    $_GET['n-correct-phone-number'] = "Tafadhali jaza namba ya simu sahihi. (Tarakimu tisa)";
    $_GET['n-choose-role'] = "Tafadhali jaza jukumu lako (Kwenye hii biashara wewe ni nani)";
    $_GET['n-fill-password'] = "Tafadhali jaza password";
    $_GET['n-password-digits'] = "Urefu wa password unatakiwa kuanza na tarakimu nne";
    $_GET['n-username'] = "Tafadhali jaza username";
    $_GET['n-special-characters'] = "Special characters haziruhusiwi kwenye username, kasoro underscore ndio inaruhusiwa";
    $_GET['n-username-used'] = "Samahani, username uliyojaza imeshatumiwa na mtu mwingine. Tafadhali badilisha username";
    $_GET['n-failed-to-create'] = "Error! Akaunti imeshindikana kutengenezwa, Tafadhali jaribu tena";
     $_GET['country_select'] = "Nchi";
    $_GET['region_select'] = "Mkoa";
    $_GET['ward_select'] = "Kata";
    $_GET['district_select'] = "Wilaya";
}
?>

<div id="wrapper">
    <nav class="navbar navbar-fixed-top shadow">
        <div class="container">
            @include('website.layouts.topbar')
        </div>
    </nav>

    <div id="left-sidebar" class="sidebar mt-2" style="margin-top: -43px !important;">
      <div class="sidebar-scroll">
          @include('website.layouts.leftside')
      </div>
    </div>

    <div class="container mt-container">
        <div style="display: none;"> <!-- informations to know -->
            <div class="alert alert-info alert-dismissible hidden-conf-info" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <i class="fa fa-info-circle"></i> The system is running well
            </div>
        </div>
        <div class="row top-row">
            <div class="col-sm-12 mb-1">
                <h2> <?php echo $_GET['new-account-registration']; ?>: </h2>
                <div class="h-line"></div>
                <p style="display:inline-block;"><?php echo $_GET['new-account-info']; ?> </p>
                <!-- <span><a href="#" class="show-conf-info ml-2">Info</a></span> -->
            </div>
            <div class="col-12 conf-info">
                <!-- render conf info -->
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 top-col">
                <form id="config-company" method="post" class="config-company">
                    @csrf
                    <div style="display: none;">
                        <textarea rows="5" class="form-control no-resize" name="about_comp" placeholder="Explain about your company..."></textarea>
                    </div>
                    <div class="body outer-body">
                        <div class="row shadow py-3 pb-5">
                            <div class="col-md-6">
                                <div class="header" style="display: none;">
                                    <!-- <h5 style=""><b><?php //echo $_GET['account-details']; ?></b></h5>
                                    <div class="h-line"></div> -->
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6" style="display: none;">
                                        <div class="form-group">
                                            <label><?php echo $_GET['account-name']; ?></label>
                                            <span class="ml-2" data-toggle="tooltip" data-placement="top" title="<?php echo $_GET['account-name-info']; ?>"><i class="fa fa-info-circle"></i></span>
                                            <input type="text" class="form-control form-control-sm" id="" name="name" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <div class="form-group" style="display:none">
                                            <label><?php echo $_GET['currency']; ?></label>
                                            <select class="form-control select2  change-currency" name="change_currency">
                                                <option value="">- <?php echo $_GET['select']; ?> -</option>
                                                @if($data['currencies']->isNotEmpty())
                                                    @foreach($data['currencies'] as $currency)
                                                        <option value="{{$currency->id}}" <?php if($currency->id == '1'){echo "selected";} ?>>{{$currency->name}} - {{$currency->code}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="shop-block">
                                    <div class="header mb-2">
                                        <h5><b><?php echo $_GET['shop']; ?></b></h5>
                                        <div class="h-line"></div>
                                    </div>
                                    <div class="row shops-row">
                                        <div class="col-md col">
                                            <div class="form-group">
                                                <label><?php echo $_GET['shop-name']; ?></label>
                                                <input type="text" class="form-control form-control-sm" id="" name="shopname" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="location-block">
                                    <div class="header mt-4 mb-2">
                                        <h5><b><?php echo $_GET['n-shop-location-2']; ?></b></h5>
                                        <div class="h-line"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label><?php echo $_GET['country_select']; ?></label>
                                                <select class="form-control select2 change-country" name="change_country">
                                                    <option value="">- <?php echo $_GET['select']; ?> -</option>
                                                    @if($data['countries']->isNotEmpty())
                                                    @foreach($data['countries'] as $country)
                                                        <option value="{{$country->id}}-{{$country->dial_code}}" <?php if($country->dial_code == '255'){echo "selected";} ?>>{{$country->name}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-6 shoplocation_view">
                                            <div class="form-group">
                                                <label><?php echo $_GET['shop-location']; ?></label>
                                                <input type="text" class="form-control form-control-sm" id="" name="shoplocation">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row location_view">
                                        <div class="load-areas">
                                            <i class="fa fa-spinner fa-spin"></i>
                                        </div>
                                        <div class="col-sm ">
                                            <div class="form-group">
                                                <label class="text-capitalize"><?php echo $_GET['region_select']; ?></label>
                                                <div class="input-group mb-3">
                                                    <select class="form-control select2 region_id" name="region_id">
                                                        <option value="" disabled selected>-Select-</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm col-6">
                                            <div class="form-group">
                                                <label class="text-capitalize"><?php echo $_GET['district_select']; ?></label>
                                                <div class="input-group mb-3">
                                                    <select class="form-control select2 district_id" name="district_id">
                                                        <option value="" disabled selected>-Select-</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm col-6">
                                            <div class="form-group">
                                                <label class="text-capitalize"><?php echo $_GET['ward_select']; ?></label>
                                                <div class="input-group mb-3">
                                                    <select class="form-control select2 ward_id" name="ward_id">
                                                        <option value="" disabled selected>-Select-</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 shop-desc">
                                            <?php if(Cookie::get("language") == 'en') { ?>
                                                <p>Do you own more than one shop ? <br> You will be able to create other shops and stores after registration.</p>
                                            <?php } else { ?>
                                                <p>Unamiliki duka zaidi ya moja ? <br> Utaweza kutengeneza maduka mengine baada ya kujisajili.</p>
                                            <?php } ?>
                                        </div>
                                        <!-- <div class="col-md-8" align="right">
                                            <button class="btn btn-info btn-sm add-shop"><i class="fa fa-plus"></i> Ongeza duka</button>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 offset-md-1 border pt-3 personal-block">
                                <div class="header">
                                    <h5><b><?php echo $_GET['personal-details']; ?></b></h5>
                                    <div class="h-line"></div>
                                </div>
                                <div class="row top-row2 clearfix">
                                    <div class="col-6" style="display:none;">
                                        <div class="form-group">
                                            <label>Full name</label>
                                            <input type="text" name="fname" class="form-control fname">
                                        </div>
                                    </div>
                                    <div class="col-12 par">
                                        <div class="form-group">
                                            <label><?php echo $_GET['phone-number']; ?></label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text render-dial">+255</span>
                                                </div>
                                                <input type="hidden" name="phonecode" value="255">
                                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6" style="display: none;">
                                        <div class="form-group">
                                            <label>Your role</label><br>
                                            <p class="border border-primary role-border" style="padding-top: 8px;padding-bottom: 5px;padding-left: 10px;width: 100%;">
                                                By default you will be a Business Owner
                                                <label class="fancy-checkbox" style="margin-right: 30px !important;margin-bottom: 0px;display: none;">
                                                    <input type="checkbox" class="checkrole" name="roles[]" value="2" data-parsley-errors-container="#error-checkbox" checked>
                                                    <span>Business Owner</span>
                                                </label>
                                                <label class="fancy-checkbox" style="margin-right: 30px !important;margin-bottom: 0px;">
                                                    <input type="checkbox" class="checkrole" name="roles[]" value="3" data-parsley-errors-container="#error-checkbox" checked>
                                                    <span>CEO</span>
                                                </label>
                                                <label class="fancy-checkbox" style="margin-right: 30px !important;margin-bottom: 0px;">
                                                    <input type="checkbox" class="checkrole" name="roles[]" value="6" data-parsley-errors-container="#error-checkbox" checked>
                                                    <span>Cashier</span>
                                                </label>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-12">
                                        <div class="form-group">
                                            <label>Username</label>
                                            <span class="ml-2" data-toggle="tooltip" data-placement="top" title="<?php echo $_GET['username-info']; ?>"><i class="fa fa-info-circle"></i></span>
                                            <input type="text" name="username2" class="form-control username" required>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-12 par">
                                        <div class="form-group pass_show">
                                            <label>Password</label>
                                            <span class="ml-2" data-toggle="tooltip" data-placement="top" title="<?php echo $_GET['password-info']; ?>"><i class="fa fa-info-circle"></i></span>
                                            <input type="password" name="password" class="form-control password" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 offset-md-3" style="margin-top:20px">
                                <div class="align-center error-alert" style="display:none;margin-bottom: -20px;">
                                    <p class="badge2 p-1" style="font-weight: normal;color: #de4848;"></p>
                                </div>
                                <button type="submit" class="btn btn-primary mt-2 submit-config-company" style="width: 100%">Submit</button>
                                <!-- <span>Change ming ?</span>
                                <button type="submit" class="btn btn-outline-danger" style="width:100%">Delete Company</button> -->
                            </div>
                        </div>
                    </div>

                    <!-- <div style="padding-top: 10px;padding-bottom: 20px;">
                        <hr class="style14">
                    </div>  -->

                </form>
            </div>
        </div>
    </div>

    <!-- success modal -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border:#28a745 solid 5px;">
                <div class="modal-header">
                    <h5 class="modal-title text-info mr-auto ml-auto" id="exampleModalCenterTitle"><?php echo $_GET['congratulations']; ?>!</h5>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button> -->
                </div>
                <div class="modal-body align-center">
    <?php
        if(Cookie::get("language") == 'en') { ?>
                    <h6>Your account has been registered successfully.</h6>
                    <p>Dont forget Username and Password for logging in next time.</p>
                    <p>Username: <b class="render-username"></b></p>
        <?php } else { ?>
                    <h6>Akaunti yako imesajiliwa kikamilifu.</h6>
                    <p>Usisahau Username na Password yako kwa ajili ya kulogin badae.</p>
                    <p>Username: <b class="render-username"></b></p>
    <?php } ?>
                </div>
                <div class="modal-footer" align="center" style="display: block;">
                    <!-- hidden login form  -->
                    <form class="form-auth-small" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div style="display: none;">
                            <input type="text" class="form-control render-username-2" id="signin-email" name="username" placeholder="Username">
                            <input type="password" class="form-control render-password-2" name="password" id="signin-password" placeholder="Password">
                        </div>
                        <button type="submit" class="btn btn-success go-login-delete"><b><?php echo $_GET['n-click-to-continue']; ?> <i class="fa fa-arrow-right pl-2"></i></b></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- failed modal -->
    <div class="modal fade" id="failedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border:#de4848 solid 5px;">
                <div class="modal-header">
                    <h5 class="modal-title text-danger mr-auto ml-auto" id="exampleModalCenterTitle"><?php echo $_GET['error']; ?>!</h5>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button> -->
                </div>
                <div class="modal-body align-center">
    <?php
        if(Cookie::get("language") == 'en') { ?>
                    <h6>Our system failed to register your account.</h6>
                    <p>Please try again later OR contact the admin for more assistance - <a class="text-light" href="tel:+255656040073">+255-656-040-073</a></p>
        <?php } else { ?>
                    <h6>Mfumo umeshindwa kusajili akaunti yako.</h6>
                    <p>Tafadhali jaribu tena baadae AU wasiliana na admin kwa msaada zaidi - <a class="text-light" href="tel:+255656040073">+255-656-040-073</a></p>
    <?php } ?>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-success refresh-page ml-auto mr-auto">Click to restart</button> -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    $('.select2').select2();

    $(document).ready(function(){
        $('.pass_show').append('<span class="ptxt">Show</span>');

        var val = $('.change-country').val();
        var result = val.split('-');
console.log(val);
        if (result[0] == 213) {
            var country_id = result[0];

            $('.location_view').removeClass('d-none');
            $('.shoplocation_view').addClass('d-none');
        // console.log(country_id);
        country_id_call(country_id);
        } else {
            // location_view
            $('.shoplocation_view').removeClass('d-none');
            $('.location_view').addClass('d-none');
        }



    });

    $(document).on('click','.pass_show .ptxt', function(){
        $(this).text($(this).text() == "Show" ? "Hide" : "Show");
        $(this).prev().attr('type', function(index, attr){return attr == 'password' ? 'text' : 'password'; });
    });

    $(document).on('click', '.show-conf-info', function(e){
        e.preventDefault();
        $('.conf-info').html("");
        var conf_info = $('.hidden-conf-info').clone();
        $('.conf-info').html(conf_info);
    });

    $(document).on('click', '.add-shop', function(e){
        e.preventDefault();
        $('.shops-row').append('<div class="col-md-4"></div><div class="col-md-4 col-6"> <div class="form-group">'+
                                    '<label><?php echo $_GET["shop-name"]; ?></label>'+
                                    '<input type="text" class="form-control form-control-sm" id="" name="shopname">'+
                                    '</div></div>'+
                                '<div class="col-md-4 col-6"> <div class="form-group">'+
                                    '<label><?php echo $_GET["shop-location"]; ?></label>'+
                                    '<input type="text" class="form-control form-control-sm" id="" name="shoplocation">'+
                                    '</div></div>');
    });

    $(document).on('change', '.change-country', function(e){
        e.preventDefault();
        var val = $(this).val();
        var result = val.split('-');
        // console.log(result[0]);
        var dial_code = result[1];
        $('[name="phonecode"]').val(dial_code);
        $('.render-dial').html("+"+dial_code);

        //   var country_id = result[0];
        // // console.log(country_id);
        // country_id_call(country_id);


        if (result[0] == 213) {
            var country_id = result[0];

            $('.location_view').removeClass('d-none');
            $('.shoplocation_view').addClass('d-none');
        // console.log(country_id);
        country_id_call(country_id);
        } else {
            // location_view
            $('.shoplocation_view').removeClass('d-none');
            $('.location_view').addClass('d-none');
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
                    $regionSelect.append('<option value="" disabled selected>-Select-</option>');
                    $.each(data.regions, function(index, region) {
                        $regionSelect.append('<option value="' + region.id + '">' + region.name + '</option>');
                    });

                } else {
                    popNotification('warning',"<?php echo $_GET['n-failed-to-create']; ?>.");
                }
            }
        });
    };

    $(document).on('change', '.region_id', function(e){
        $('.load-areas').css('display','block');

        var region_id = $('.region_id').val();

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
                    popNotification('warning',"<?php echo $_GET['n-failed-to-create']; ?>.");
                }
            }
        });

    });
    $(document).on('change', '.district_id', function(e){
        $('.load-areas').css('display','block');

        var district_id = $('.district_id').val();
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
                    popNotification('warning',"<?php echo $_GET['n-failed-to-create']; ?>.");
                }
            }
        });

    });

    // space after three numbers... phone number
    document.getElementById('phone').addEventListener('input', function (e) {
    //   this.value=insertBlankAfterEveryThreeCharacters(this.value);
    });

    function insertBlankAfterEveryThreeCharacters(str) {
      var str=str.split(" ").join("").split("");
      var formatted=[];
      while(str.length) {
        for(var i=0; i<3 && str.length; i++) {
          formatted.push(str.shift());
        }
        if(str.length) formatted.push(" ");
      }
      return formatted.join("");
    }

    $(document).on('keyup', '.username', function(e){
        e.preventDefault();
        // var username = $(this).val();
        // var regex = /[^a-z0-9_]/gi;
        // if (regex.test(username)) {
        //     $(this).removeClass('parsley-success').addClass('parsley-error').focus();
        // } else {
        //     $(this).removeClass('parsley-error').addClass('parsley-success').focus();
        // }
        // $(this).val($(this).val().replace(/[^a-z0-9_]/gi, ''));
    });

    $(document).on('keyup', '.password', function(e){
        e.preventDefault();
        var pass = $(this).val().trim();
        var count = pass.length;
        const regex = /^(?=.*[0-9])(?=.*[A-Za-z])[A-Za-z0-9]+$/; //check for alphanumeric
        const regex2 = /[a-zA-Z0-9]+[(@!#\$%\^\&*\)\(+=._-]{1,}/; // check for alphanumeric + special characters
        if (count < 4) {
            $('.config-company [name="password"]').removeClass('parsley-success').addClass('parsley-error').focus();
        } else {
            $('.config-company [name="password"]').removeClass('parsley-error').addClass('parsley-success').focus();
        }
    });

    $(document).on('submit', '.config-company', function(e){
        e.preventDefault();
        $('.submit-config-company').prop('disabled', true).html('submiting..');
        $('input, textarea, select').removeClass('parsley-error');
        $('.error-alert').css('display',"none");
        // var name = $('.config-company [name="name"]');
        var about_comp = $('.config-company [name="about_comp"]');
        var country = $('.config-company [name="change_country"]');
        var currency = $('.config-company [name="change_currency"]');
        var shopname = $('.config-company [name="shopname"]');
        var shoplocation = $('.config-company [name="shoplocation"]');
        var fullname = $('.config-company [name="fname"]');
        var username = $('.config-company [name="username2"]');
        var password = $('.config-company [name="password"]');
        var phone = $('.config-company [name="phone"]');
        var region = $('.config-company [name="region_id"]');
        var district = $('.config-company [name="district_id"]');
        var ward = $('.config-company [name="ward_id"]');
        var name = username.val();
        name = name[0].toUpperCase() + name.slice(1);
        var aname = name+' POS';
        if (country.val() == "" || currency.val() == "" || username.val().trim() == null || username.val().trim() == '' || password.val().trim() == null || password.val().trim() == '' || phone.val().trim() == null || phone.val().trim() == '' || shopname.val().trim() == '') {
            $('.submit-config-company').prop('disabled', false).html('Submit'); 
        }
        if (country.val() == "") {
            $('.error-alert').css('display',"").children('.badge2').html("-- <?php echo $_GET['n-select-country']; ?>."); country.addClass('parsley-error').focus(); return;
        } else {
            if (country.val() == "213-255") { // country id contains cid & phone # code
                if (region.val() == "" || region.val() == null || district.val() == "" || district.val() == null || ward.val() == "" || ward.val() == null) {
                    $('.error-alert').css('display',"").children('.badge2').html("-- Please select Region, District & ward.");
                    $('.submit-config-company').prop('disabled', false).html('Submit');
                    return;
                } 
            } else {
                if (shoplocation.val() == "" || shoplocation.val() == null) {
                    $('.error-alert').css('display',"").children('.badge2').html("-- <?php echo $_GET['n-shop-location']; ?>."); 
                    shoplocation.addClass('parsley-error').focus(); 
                    $('.submit-config-company').prop('disabled', false).html('Submit');
                    return;
                }
            }
        }
        if (shopname.val() == "") {
            $('.error-alert').css('display',"").children('.badge2').html("-- <?php echo $_GET['n-shop-name']; ?>."); shopname.addClass('parsley-error').focus(); return;}
        if (currency.val() == "") {
            $('.error-alert').css('display',"").children('.badge2').html("-- <?php echo $_GET['n-select-currency']; ?>."); currency.addClass('parsley-error').focus(); return;}
        // check phone number
        if (phone.val().trim() == null || phone.val().trim() == '') {
            $('.error-alert').css('display',"").children('.badge2').html("-- <?php echo $_GET['n-phone-number']; ?>."); phone.addClass('parsley-error').focus(); return;
        } else {
            var phone2 = phone.val().replace(/\s/g, ''); // remove spaces
            if (phone2.length != 9) {
                $('.submit-config-company').prop('disabled', false).html('Submit');
                $('.error-alert').css('display',"").children('.badge2').html("-- <?php echo $_GET['n-correct-phone-number']; ?>."); phone.removeClass('parsley-success').addClass('parsley-error').focus(); return;
            } else {
                var regex2 = /[^0-9]/g; // check if contains alphabets, special characters
                if (regex2.test(phone2)) {
                    $('.submit-config-company').prop('disabled', false).html('Submit');
                    $('.error-alert').css('display',"").children('.badge2').html("-- <?php echo $_GET['n-correct-phone-number']; ?>"); phone.removeClass('parsley-success').addClass('parsley-error').focus(); return;
                } else {
                    phone.removeClass('parsley-error');
                }
            }
        }
        if ($('.checkrole').is(":checked")) {
            $('.role-border').removeClass('border-danger').addClass('border-primary');
        } else {
            $('.submit-config-company').prop('disabled', false).html('Submit');
            $('.error-alert').css('display',"").children('.badge2').html("-- <?php echo $_GET['n-choose-role']; ?>."); $('.role-border').removeClass('border-primary').addClass('border-danger'); return;
        }
        // check password
        if (password.val().trim() == null || password.val().trim() == '') {
            $('.error-alert').css('display',"").children('.badge2').html("-- <?php echo $_GET['n-fill-password']; ?>."); password.addClass('parsley-error').focus(); return;
        } else {
            var pass = password.val().trim();
            var count = pass.length;
            const regex = /^(?=.*[0-9])(?=.*[A-Za-z])[A-Za-z0-9]+$/; //check for alphanumeric
            const regex2 = /[a-zA-Z0-9]+[(@!#\$%\^\&*\)\(+=._-]{1,}/; // check for alphanumeric + special characters
            if (count < 4) {
                $('.submit-config-company').prop('disabled', false).html('Submit'); $('.error-alert').css('display',"").children('.badge2').html("-- Password has to start with 4 digits.");
                $('.config-company [name="password"]').removeClass('parsley-success').addClass('parsley-error').focus(); return;
            } else {
                $('.config-company [name="password"]').removeClass('parsley-error');
            }
        }
        // check username
        if (username.val().trim() == null || username.val().trim() == '') {
            $('.error-alert').css('display',"").children('.badge2').html("-- <?php echo $_GET['n-username']; ?>."); username.addClass('parsley-error').focus(); return;
        } else {
            var uname = username.val().replace(/\s/g, '');
            var regex = /[^a-z0-9_]/gi; //allow alphanumeric and underscore
            if (regex.test(uname)) {
                $('.submit-config-company').prop('disabled', false).html('Submit');
                $('.error-alert').css('display',"").children('.badge2').html("-- <?php echo $_GET['n-special-characters']; ?>."); username.removeClass('parsley-success').addClass('parsley-error').focus(); return;
            } else {
                // check if username exist
                $.get('/company/check-user-name/'+uname, function(data) {
                    if (data.status == "error") {
                        $('.submit-config-company').prop('disabled', false).html('Submit');
                        $('.error-alert').css('display',"").children('.badge2').html("-- <?php echo $_GET['n-username-used']; ?>."); username.removeClass('parsley-success').addClass('parsley-error').focus(); return;
                    }
                    if (data.status == 'success') {
                        // prepare form to submit
                        var val = $('.config-company [name="change_country"]').val();
                        var result = val.split('-');
                        var country = result[0];

                        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
                        var formdata = new FormData(document.getElementById("config-company"));
                        formdata.append('status','new config company');
                        formdata.append('name',aname);
                        formdata.append('username',uname);
                        formdata.append('country_id',country);
                        $.ajax({
                            type: 'POST',
                            url: '/config-company',
                            processData: false,
                            contentType: false,
                            data: formdata,
                            success: function(data) {
                                $('.submit-config-company').prop('disabled', false).html('Submit');
                                if (data.status == "success") {
                                    $('.render-username').html(data.username);
                                    $('.render-username-2').val(data.username);
                                    $('.render-password-2').val(data.password);
                                    $('.config-company')[0].reset();
                                    $('#successModal').modal('toggle');
                                } else {
                                    $('#failedModal').modal('toggle');
                                    popNotification('warning',"<?php echo $_GET['n-failed-to-create']; ?>.");
                                }
                            }
                        });
                    }
                });
            }
        }

    });

    function checkUserName(username) {
        let value = null;
        return $.get('/company/check-user-name/'+username.val(), function(data) {
            if (data.status == "error") {
                $('.submit-config-company').prop('disabled', false).html('Submit');
                $('.error-alert').css('display',"").children('.badge2').html("-- <?php echo $_GET['n-username-used']; ?>."); username.removeClass('parsley-success').addClass('parsley-error').focus(); console.log('in'); value = 'not ok';
            }
            if (data.status == 'success') {
                console.log('success');
                value = "ok";
            }
        });
    }

    $(document).on('click', '.refresh-page', function(e){
        e.preventDefault();
        location.reload();
    });

    $(document).on('click', '.go-login', function(e){
        e.preventDefault();
        window.location = "/login"
    });

</script>
@endsection
