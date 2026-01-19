
@extends('layouts.app')

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
.shop-desc p {font-size: 13px;}

@media screen and (max-width: 805px) {
    label {font-weight: normal;}
}
@media screen and (min-width: 768px) and (max-width: 991px) {
    .container.mt-container {width: 95% !important;max-width: 95% !important;padding-left: 0px;}
}
@media screen and (max-width: 768px) {
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
    .small-screen-margin {padding-left: 0px;padding-right: 0px;}
    .outer-body {margin-left: -15px;margin-right: -15px;}
    /*.shop-block {padding-left: 5px;border-left: 3px solid #EFB83C;}*/
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
@media screen and (max-width: 390px) {
    .shops-row .col-6 {padding-left: 5px;padding-right: 5px;}
}

</style>
@endsection

@section('content')

<?php 
if(Cookie::get("language") == 'en') { 
    $_GET['n-fill-account-name'] = "Please fill account name";
    $_GET['n-select-country'] = "Please select country";
    $_GET['n-shop-name'] = "Please fill shop name section";
    $_GET['n-shop-location'] = "Please fill Shop Location section";
    $_GET['n-full-name'] = "Please fill full name section";
    $_GET['n-select-currency'] = "Please select currency";
    $_GET['n-phone-number'] = "Please fill phone number section";
    $_GET['n-correct-phone-number'] = "Please fill the correct phone number. (Nine numbers required)";
    $_GET['n-choose-role'] = "Please choose role (your position in this company)";    
    $_GET['n-fill-password'] = "Please fill Password section";    
    $_GET['n-password-digits'] = "Password has to start with 4 digits, Must be alphanumeric, you can use special characters";
    $_GET['n-username'] = "Please fill Username section";
    $_GET['n-special-characters'] = "Special characters are not allowed for username except underscore";
    $_GET['n-username-used'] = "Sorry, The username is already used by someone else. Please change the username";
    $_GET['n-failed-to-create'] = "Error! Failed to create new Company, please try again";
} else {
    $_GET['n-fill-account-name'] = "Tafadhali jaza jina la akaunti";
    $_GET['n-select-country'] = "Tafadhali chagua nchi";
    $_GET['n-shop-name'] = "Tafadhali jaza jina la duka";
    $_GET['n-shop-location'] = "Tafadhali jaza mahala duka linapopatikana";
    $_GET['n-full-name'] = "Tafadhali jaza jina lako kamili";
    $_GET['n-select-currency'] = "Tafadhali chagua fedha";
    $_GET['n-phone-number'] = "Tafadhali jaza namba yako ya simu";
    $_GET['n-correct-phone-number'] = "Tafadhali jaza namba ya simu sahihi. (Tarakimu tisa)";
    $_GET['n-choose-role'] = "Tafadhali jaza jukumu lako (Kwenye hii biashara wewe ni nani)";    
    $_GET['n-fill-password'] = "Tafadhali jaza password";    
    $_GET['n-password-digits'] = "Password inatakiwa isiwe chini ya tarakimu nne, Mchanganyiko wa herufi na namba, unaweza kutumia special characters pia";
    $_GET['n-username'] = "Tafadhali jaza username";
    $_GET['n-special-characters'] = "Special characters haziruhusiwi kwenye username, kasoro underscore ndio inaruhusiwa";
    $_GET['n-username-used'] = "Samahani, username uliyojaza imeshatumiwa na mtu mwingine. Tafadhali badilisha username";
    $_GET['n-failed-to-create'] = "Error! Akaunti imeshindikana kutengenezwa, Tafadhali jaribu tena";
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
                    <div class="col-lg-12 col-md-12">
                        <div class="row">
                            <div class="col-12 small-screen-margin">
                                <div class="card">
                                    <div class="header">
                                        <h2><?php echo $_GET['register-account']; ?></h2>
                                        <ul class="header-dropdown">
                                            <!-- <li><button class="btn btn-info btn-sm" data-toggle="modal" data-target="#newCompany"><?php echo $_GET['register-account']; ?></button></li> -->
                                            <!-- <li><button class="btn btn-info btn-sm update-buying-price">update buying price</button></li> -->
                                        </ul>
                                    </div>
                                    <div class="body pt-0">
                                        <form id="config-company" method="post" class="config-company">
                                            @csrf
                                            <div style="display: none;">
                                                <textarea rows="5" class="form-control no-resize" name="about_comp" placeholder="Explain about your company..."></textarea>
                                            </div>
                                            <div class="body outer-body">
                                                <div class="row border py-3 pb-5">
                                                    <div class="col-md-6">
                                                        <div class="header">
                                                            <!-- <h5 style=""><b><?php //echo $_GET['account-details']; ?></b></h5>
                                                            <div class="h-line"></div> -->
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label><?php echo $_GET['account-name']; ?></label>
                                                                    <span class="ml-2" data-toggle="tooltip" data-placement="top" title="<?php echo $_GET['account-name-info']; ?>"><i class="fa fa-info-circle"></i></span>
                                                                    <input type="text" class="form-control form-control-sm" id="" name="name" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-6">
                                                                <div class="form-group" style="display:none">
                                                                    <label><?php echo $_GET['country-head-quarter']; ?></label>
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
                                                            <div class="col-md-4 col-6">
                                                                <div class="form-group" style="display:none">
                                                                    <label><?php echo $_GET['currency']; ?></label>
                                                                    <select class="form-control select2 change-currency" name="change_currency">
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
                                                        <div class="mt-4 shop-block">
                                                            <div class="header pl-0">
                                                                <h5><b><?php echo $_GET['shops-you-own']; ?></b></h5>
                                                                <div class="h-line"></div>
                                                            </div>
                                                            <div class="row shops-row">
                                                                <div class="col-md-6 col-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $_GET['shop-name']; ?></label>
                                                                        <input type="text" class="form-control form-control-sm" id="" name="shopname">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $_GET['shop-location']; ?></label>
                                                                        <input type="text" class="form-control form-control-sm" id="" name="shoplocation">
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
                                                        <div class="header pl-0">
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
                                                                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="000 000 000">
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
                                                                    <input type="text" name="username" class="form-control username">
                                                                </div>
                                                            </div>
                                                            <div class="col-6 col-md-12 par">
                                                                <div class="form-group pass_show">
                                                                    <label>Password</label>
                                                                    <span class="ml-2" data-toggle="tooltip" data-placement="top" title="<?php echo $_GET['password-info']; ?>"><i class="fa fa-info-circle"></i></span>
                                                                    <input type="password" name="password" class="form-control password">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="is_agent" value="yes">
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
                        </div>
                    </div>
                </div>
                
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
                <div class="modal-body align-center" align="center">
                    <?php
                        if(Cookie::get("language") == 'en') { ?>
                                    <h6>Account has been registered successfully.</h6>
                                    <p>SMS with USERNAME and PASSWORD has been sent to created user.</p>
                        <?php } else { ?>   
                                    <h6>Akaunti imetengenezwa kikamilifu.</h6>
                                    <p>SMS yenye USERNAME na PASSWORD imetumwa kwa mtumiaji uliemtengeneza.</p>
                    <?php } ?>
                </div>
                <div class="modal-footer">
                    <a href="/agent/accounts-you-registered" class="btn btn-info ml-auto mr-auto">Okay</a>
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
                    <h6>Our system failed to register new account.</h6>
                    <p>Please try again later OR contact the admin for more assistance - <a class="text-light" href="tel:+255656040073">+255-656-040-073</a></p>
        <?php } else { ?>   
                    <h6>Mfumo umeshindwa kusajili akaunti mpya.</h6>
                    <p>Tafadhali jaribu tena baadae AU wasiliana na admin kwa msaada zaidi - <a class="text-light" href="tel:+255656040073">+255-656-040-073</a></p>
    <?php } ?>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-success refresh-page ml-auto mr-auto">Click to restart</button> -->
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
        var dial_code = result[1];
        $('[name="phonecode"]').val(dial_code);
        $('.render-dial').html("+"+dial_code);
    });

    // space after three numbers... phone number
    document.getElementById('phone').addEventListener('input', function (e) {
      this.value=insertBlankAfterEveryThreeCharacters(this.value);
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
            console.log('no');
        } else {
            if( regex.test(pass) ) {
                $('.config-company [name="password"]').removeClass('parsley-error').addClass('parsley-success').focus();
                console.log('yes');
            } else {
                if( regex2.test(pass) ) {
                    $('.config-company [name="password"]').removeClass('parsley-error').addClass('parsley-success').focus();
                    console.log('yes');
                } else {
                    $('.config-company [name="password"]').removeClass('parsley-success').addClass('parsley-error').focus();
                    console.log('no');
                }
            }
        }
    });

    $(document).on('submit', '.config-company', function(e){
        e.preventDefault();
        $('.submit-config-company').prop('disabled', true).html('submiting..');
        $('input, textarea, select').removeClass('parsley-error');
        $('.error-alert').css('display',"none");
        var name = $('.config-company [name="name"]');
        var about_comp = $('.config-company [name="about_comp"]');
        var country = $('.config-company [name="change_country"]');
        var currency = $('.config-company [name="change_currency"]');
        var shopname = $('.config-company [name="shopname"]');
        var shoplocation = $('.config-company [name="shoplocation"]');
        var fullname = $('.config-company [name="fname"]');
        var username = $('.config-company [name="username"]');
        var password = $('.config-company [name="password"]');
        var phone = $('.config-company [name="phone"]');
        if (name.val().trim() == null || name.val().trim() == '' || country.val() == "" || currency.val() == "" || username.val().trim() == null || username.val().trim() == '' || password.val().trim() == null || password.val().trim() == '' || phone.val().trim() == null || phone.val().trim() == '' || shopname.val().trim() == '' || shoplocation.val().trim() == '') {
            $('.submit-config-company').prop('disabled', false).html('Submit'); }
        if (name.val().trim() == null || name.val().trim() == '') {
            $('.error-alert').css('display',"").children('.badge2').html("-- <?php echo $_GET['n-fill-account-name']; ?>."); name.addClass('parsley-error').focus(); return;}
        if (country.val() == "") {
            $('.error-alert').css('display',"").children('.badge2').html("-- <?php echo $_GET['n-select-country']; ?>."); country.addClass('parsley-error').focus(); return;}
        if (shopname.val() == "") {
            $('.error-alert').css('display',"").children('.badge2').html("-- <?php echo $_GET['n-shop-name']; ?>."); shopname.addClass('parsley-error').focus(); return;}
        if (shoplocation.val() == "") {
            $('.error-alert').css('display',"").children('.badge2').html("-- <?php echo $_GET['n-shop-location']; ?>."); shoplocation.addClass('parsley-error').focus(); return;}
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
                $('.submit-config-company').prop('disabled', false).html('Submit'); $('.error-alert').css('display',"").children('.badge2').html("-- Password has to start with 4 digits, Must be alphanumeric, you can use special characters.");
                $('.config-company [name="password"]').removeClass('parsley-success').addClass('parsley-error').focus(); return;
            } else {
                if( regex.test(pass) ) {
                    $('.config-company [name="password"]').removeClass('parsley-error');
                } else {
                    if( regex2.test(pass) ) {
                        $('.config-company [name="password"]').removeClass('parsley-error');
                    } else {
                        $('.submit-config-company').prop('disabled', false).html('Submit'); $('.error-alert').css('display',"").children('.badge2').html("-- <?php echo $_GET['n-password-digits']; ?>.");
                        $('.config-company [name="password"]').removeClass('parsley-success').addClass('parsley-error').focus(); return;
                    }
                }
            }
        }
        // check username
        if (username.val().trim() == null || username.val().trim() == '') {
            $('.error-alert').css('display',"").children('.badge2').html("-- <?php echo $_GET['n-username']; ?>."); username.addClass('parsley-error').focus(); return; 
        } else {
            var regex = /[^a-z0-9_]/gi; //allow alphanumeric and underscore
            if (regex.test(username.val())) {
                $('.submit-config-company').prop('disabled', false).html('Submit');
                $('.error-alert').css('display',"").children('.badge2').html("-- <?php echo $_GET['n-special-characters']; ?>."); username.removeClass('parsley-success').addClass('parsley-error').focus(); return;
            } else {
                // check if username exist
                $.get('/company/check-user-name/'+username.val(), function(data) {    
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
                                    $('.config-company')[0].reset();
                                    // send sms to user 
                                    $.get('/report/new-account-created/'+data.cid+'/'+data.password, function(data2) {    
                                        console.log(data2.output);
                                    });         
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

</script>
@endsection