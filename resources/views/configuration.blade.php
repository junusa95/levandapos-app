@extends('layouts.app')
<style type="text/css">
hr.style14 { 
  border: 0; 
  height: 1px; width: 50%;text-align: center;
  background-image: -webkit-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
  background-image: -moz-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
  background-image: -ms-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
  background-image: -o-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0); 
}

/*password show hide*/
.pass_show{position: relative} 
.pass_show .ptxt { 
    position: absolute;
    top: 72%; right: 10px; z-index: 1; color: #f36c01; 
    margin-top: -10px; cursor: pointer; transition: .3s ease all;  
}
.pass_show .ptxt:hover{color: #333333;} 
.tool-tip:hover {
    cursor: pointer;
}

</style>
@section('content')
@include("layouts.translater")
<div class="container">
    <div class="row" style="background:#fff;margin-top: 2px;padding-top: 20px;"> 
        <div class="col-9">
            <h5>LevandaPOS</h5>
        </div>
        <div class="col-3">
            <div id="navbar-menu">
                <ul class="nav navbar-nav">
                    <li>                                                     
                        @if(Cookie::get("language"))              
                            @if(Cookie::get("language") == 'en')
                                <span class="switch-lang" check="sw">
                                    <img src="/images/sw.jpg"> <span>SW</span>
                                </span>
                            @else
                                <span class="switch-lang" check="en">
                                    <img src="/images/en.png"> <span>EN</span>
                                </span>
                            @endif
                        @else
                            <span class="switch-lang" check="en">
                                <img src="/images/en.png"> <span>EN</span>
                            </span>
                        @endif                                                         
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div style="display: none;"> <!-- informations to know -->
        <div class="alert alert-info alert-dismissible hidden-conf-info" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <i class="fa fa-info-circle"></i> The system is running well
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 mt-4 mb-1">
            <h2> Company Configuration: </h2>
            <h6 style="display:inline-block;">Fill the information below to start managing your business</h6><span><a href="#" class="show-conf-info ml-2">Info</a></span>
        </div>
        <div class="col-12 conf-info">
            <!-- render conf info -->
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
            <div class="card pb-5">
                <div class="header">
                    <h2 style="padding-left: 10px; border-left: 4px solid #EFB83C;">Company details</h2>
                </div>
                <form id="config-company" method="post" class="config-company">
                    @csrf
                    <input type="hidden" name="cid" value="{{$data['company']->id}}">
                    <div class="body" style="padding-top:0px">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="shadow-sm p-3 mb-4 bg-white rounded" >Company name: <h5 class="ml-2 px-2" style="display:inline-block;background: #21265F;color: #fff">{{$data['company']->name}}</h5></div>
                            </div>
                        </div>
                        <div class="row clearfix">  
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>About Company</label>
                                    <textarea rows="5" class="form-control no-resize" name="about_comp" placeholder="Explain about your company..."></textarea>
                                </div>
                            </div>                              
                            <div class="col-sm-6 pt-1">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Country (Head Quarters)</label>
                                            <select class="form-control select2 change-country" name="change_country">
                                                <option value="">- Select -</option>
                                                @if($data['countries']->isNotEmpty())
                                                @foreach($data['countries'] as $country)
                                                    <option value="{{$country->id}}-{{$country->dial_code}}">{{$country->name}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Currency</label>
                                            <select class="form-control select2 change-currency" name="change_currency">
                                                <option value="">- Select -</option>
                                                @if($data['currencies']->isNotEmpty())
                                                @foreach($data['currencies'] as $currency)
                                                    <option value="{{$currency->id}}">{{$currency->name}} - {{$currency->code}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <hr class="style14">
                    </div>                

                    <div class="header">
                        <h2 style="padding-left: 10px; border-left: 4px solid #EFB83C;">Personal details</h2>
                    </div>
                    <div class="body" style="padding-top:0px">
                        <div class="row clearfix">   
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text render-dial">---</span>
                                        </div>
                                        <input type="hidden" name="phonecode">
                                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="000 000 000">
                                    </div>
                                </div>
                            </div>                              
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Your role</label><br>
                                    <p class="border border-primary role-border" style="padding-top: 8px;padding-bottom: 5px;padding-left: 10px;width: 100%;">
                                        By default you will be a Business Owner
                                        <label class="fancy-checkbox" style="margin-right: 30px !important;margin-bottom: 0px;display: none;">
                                            <input type="checkbox" class="checkrole" name="roles[]" value="2" data-parsley-errors-container="#error-checkbox" checked>
                                            <span>Business Owner</span>
                                        </label>
                                        <!-- <label class="fancy-checkbox" style="margin-right: 30px !important;margin-bottom: 0px;">
                                            <input type="checkbox" class="checkrole" name="roles[]" value="3" data-parsley-errors-container="#error-checkbox">
                                            <span>CEO</span>
                                        </label> -->
                                    </p>
                                </div>
                            </div>                          
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Username</label>
                                    <span class="ml-2 text-info tool-tip" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $_GET['username-info']; ?>"><i class="icon-info"></i></span>
                                    <input type="text" name="username" class="form-control username" placeholder="Username">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group pass_show">
                                    <label>Password</label>
                                    <span class="ml-2 text-info tool-tip" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $_GET['password-info']; ?>"><i class="icon-info"></i></span>
                                    <input type="password" name="password" class="form-control password" placeholder="Password">
                                </div>
                            </div>
                            <div class="col-md-6 offset-md-3 mt-3">
                                <div class="pb-3 align-center error-alert" style="display:none;">
                                    <span class="badge badge-danger p-1" style="border:none;font-size: 90%;"></span>
                                </div>
                                <button type="submit" class="btn btn-primary mb-2 submit-config-company" style="width: 100%">Submit</button>
                                <span>Change ming ?</span>
                                <button type="submit" class="btn btn-outline-danger" style="width:100%">Delete Company</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- success modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border:#28a745 solid 5px;">
            <div class="modal-header">
                <h5 class="modal-title text-info mr-auto ml-auto" id="exampleModalCenterTitle">Congratulations!</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body align-center">
                <h6>Your company has been configured successfully.</h6>
                <p>Please make sure you remember the username and password for logging in next time.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success refresh-page ml-auto mr-auto">Click to continue</button>
            </div>
        </div>
    </div>
</div>

<!-- failed modal -->
<div class="modal fade" id="failedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border:#de4848 solid 5px;">
            <div class="modal-header">
                <h5 class="modal-title text-danger mr-auto ml-auto" id="exampleModalCenterTitle">Something wrong!</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body align-center">
                <h6>Our system failed to configure your company.</h6>
                <p>Please contact the admin to check whats happened.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success refresh-page ml-auto mr-auto">Click to restart</button>
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
        var about_comp = $('.config-company [name="about_comp"]');
        var country = $('.config-company [name="change_country"]');
        var currency = $('.config-company [name="change_currency"]');
        var username = $('.config-company [name="username"]');
        var password = $('.config-company [name="password"]');
        var phone = $('.config-company [name="phone"]');
        if (about_comp.val().trim() == null || about_comp.val().trim() == '' || country.val() == "" || currency.val() == "" || username.val().trim() == null || username.val().trim() == '' || password.val().trim() == null || password.val().trim() == '' || phone.val().trim() == null || phone.val().trim() == '') {
            $('.submit-config-company').prop('disabled', false).html('Submit'); }
        if (about_comp.val().trim() == null || about_comp.val().trim() == '') {
            $('.error-alert').css('display',"").children('.badge').html("-- Please fill About Company section."); about_comp.addClass('parsley-error').focus(); return;}
        if (country.val() == "") {
            $('.error-alert').css('display',"").children('.badge').html("-- Please select country."); country.addClass('parsley-error').focus(); return;}
        if (currency.val() == "") {
            $('.error-alert').css('display',"").children('.badge').html("-- Please select currency."); currency.addClass('parsley-error').focus(); return;}
        // check phone number
        if (phone.val().trim() == null || phone.val().trim() == '') {
            $('.error-alert').css('display',"").children('.badge').html("-- Please fill Phone Number section."); phone.addClass('parsley-error').focus(); return;
        } else {
            var phone2 = phone.val().replace(/\s/g, ''); // remove spaces
            if (phone2.length != 9) {
                $('.submit-config-company').prop('disabled', false).html('Submit');
                $('.error-alert').css('display',"").children('.badge').html("-- Please fill the correct phone number. (Nine numbers required)"); phone.removeClass('parsley-success').addClass('parsley-error').focus(); return;
            } else {
                var regex2 = /[^0-9]/g; // check if contains alphabets, special characters
                if (regex2.test(phone2)) {
                    $('.submit-config-company').prop('disabled', false).html('Submit');
                    $('.error-alert').css('display',"").children('.badge').html("-- Please fill the correct phone number. (Nine numbers required)"); phone.removeClass('parsley-success').addClass('parsley-error').focus(); return;
                } else {
                    phone.removeClass('parsley-error');
                }
            }
        }
        if ($('.checkrole').is(":checked")) {
            $('.role-border').removeClass('border-danger').addClass('border-primary');
        } else {
            $('.submit-config-company').prop('disabled', false).html('Submit');
            $('.error-alert').css('display',"").children('.badge').html("-- Please choose role (your position in this company)"); $('.role-border').removeClass('border-primary').addClass('border-danger'); return;
        }
        // check password
        if (password.val().trim() == null || password.val().trim() == '') {
            $('.error-alert').css('display',"").children('.badge').html("-- Please fill Password section."); password.addClass('parsley-error').focus(); return;
        } else {
            var pass = password.val().trim();
            var count = pass.length;
            const regex = /^(?=.*[0-9])(?=.*[A-Za-z])[A-Za-z0-9]+$/; //check for alphanumeric
            const regex2 = /[a-zA-Z0-9]+[(@!#\$%\^\&*\)\(+=._-]{1,}/; // check for alphanumeric + special characters
            if (count < 4) {
                $('.submit-config-company').prop('disabled', false).html('Submit'); $('.error-alert').css('display',"").children('.badge').html("-- Password has to start with 4 digits, Must be alphanumeric, you can use special characters.");
                $('.config-company [name="password"]').removeClass('parsley-success').addClass('parsley-error').focus(); return;
            } else {
                if( regex.test(pass) ) {
                    $('.config-company [name="password"]').removeClass('parsley-error');
                } else {
                    if( regex2.test(pass) ) {
                        $('.config-company [name="password"]').removeClass('parsley-error');
                    } else {
                        $('.submit-config-company').prop('disabled', false).html('Submit'); $('.error-alert').css('display',"").children('.badge').html("-- Password has to start with 4 digits, Must be alphanumeric, you can use special characters.");
                        $('.config-company [name="password"]').removeClass('parsley-success').addClass('parsley-error').focus(); return;
                    }
                }
            }
        }
        // check username
        if (username.val().trim() == null || username.val().trim() == '') {
            $('.error-alert').css('display',"").children('.badge').html("-- Please fill Username section."); username.addClass('parsley-error').focus(); return; 
        } else {
            var regex = /[^a-z0-9_]/gi; //allow alphanumeric and underscore
            if (regex.test(username.val())) {
                $('.submit-config-company').prop('disabled', false).html('Submit');
                $('.error-alert').css('display',"").children('.badge').html("-- Special characters are not allowed for username except underscore."); username.removeClass('parsley-success').addClass('parsley-error').focus(); return;
            } else {
                // check if username exist
                $.get('/company/check-user-name/'+username.val(), function(data) {    
                    if (data.status == "error") {
                        $('.submit-config-company').prop('disabled', false).html('Submit');
                        $('.error-alert').css('display',"").children('.badge').html("-- Sorry, The username is already used by someone else. Please change the username."); username.removeClass('parsley-success').addClass('parsley-error').focus(); return;
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
                                    $('#successModal').modal('toggle');    
                                } else {
                                    $('#failedModal').modal('toggle');  
                                    popNotification('warning',"Error! Failed to create new Company, please try again.");
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
                $('.error-alert').css('display',"").children('.badge').html("-- Sorry, The username is already used by someone else. Please change the username."); username.removeClass('parsley-success').addClass('parsley-error').focus(); console.log('in'); value = 'not ok';
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