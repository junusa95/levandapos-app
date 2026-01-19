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
.h-line {border-bottom: 4px solid #EFB83C;width: 30px;}
.shop-desc p {font-size: 13px;}

@media screen and (max-width: 805px) {
    label {font-weight: normal;}
}
@media screen and (max-width: 768px) {
    .mt-container {padding-left: 0px;}
    .personal-block {margin-left: 5px;margin-right: 5px;}
    .outer-body {padding-left: 10px;padding-right: 10px;}
}
@media screen and (max-width: 575px) {
    .container.mt-container {padding-left: 10px;padding-right: 20px;}
}
@media screen and (max-width: 480px) {
    .mt-container {padding-left: 5px;padding-right: 5px;}
    .mt-container .top-row .top-col {margin-top: 1.5rem;}
    .mt-container .top-row .col-6 {padding-left: 10px;padding-right: 10px;}
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
</style>
@endsection

@section('content')

<?php 
if(Cookie::get("language") == 'en') { 
    $_GET['a-work-with-us'] = "Do you want to work with us";
    $_GET['a-opportunity'] = "This is an opportunity to everyone";
    $_GET['a-fill-your-details'] = "Fill your details";
    $_GET['n-fill-your-name'] = "Please fill your name";
    $_GET['n-select-region'] = "Please select region";
    $_GET['n-phone-number'] = "Please fill phone number section";
    $_GET['n-correct-phone-number'] = "Please fill the correct phone number. (Nine numbers required)"; 
    $_GET['n-fill-password'] = "Please fill Password section";    
    $_GET['n-password-digits'] = "Password has to start with 4 digits, Must be alphanumeric, you can use special characters";
    $_GET['n-username'] = "Please fill Username section";
    $_GET['n-special-characters'] = "Special characters are not allowed for username except underscore";
    $_GET['n-username-used'] = "Sorry, The username is already used by someone else. Please change the username";
    $_GET['n-failed-to-create'] = "Error! Failed to create new Company, please try again";
} else {
    $_GET['a-work-with-us'] = "Unataka kufanya kazi na sisi";
    $_GET['a-opportunity'] = "Hii ni fursa kwa kila mtu";
    $_GET['a-fill-your-details'] = "Jaza taarifa zako";
    $_GET['n-fill-your-name'] = "Tafadhali jaza jina lako";
    $_GET['n-select-region'] = "Tafadhali jaza mkoa";
    $_GET['n-phone-number'] = "Tafadhali jaza namba yako ya simu";
    $_GET['n-correct-phone-number'] = "Tafadhali jaza namba ya simu sahihi. (Tarakimu tisa)";
    $_GET['n-fill-password'] = "Tafadhali jaza password";    
    $_GET['n-password-digits'] = "Password inatakiwa isiwe chini ya tarakimu nne, Mchanganyiko wa herufi na namba, unaweza kutumia special characters pia";
    $_GET['n-username'] = "Tafadhali jaza username";
    $_GET['n-special-characters'] = "Special characters haziruhusiwi kwenye username, kasoro underscore ndio inaruhusiwa";
    $_GET['n-username-used'] = "Samahani, username uliyojaza imeshatumiwa na mtu mwingine. Tafadhali badilisha username";
    $_GET['n-failed-to-create'] = "Error! Akaunti imeshindikana kutengenezwa, Tafadhali jaribu tena";
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
        <div class="row top-row">
            <div class="col-sm-12 mb-1">
                <h2> <?php echo $_GET['a-work-with-us']; ?>? </h2>
                <div class="h-line"></div>
                <p style="display:inline-block;"><?php echo $_GET['a-opportunity']; ?> </p>
                <!-- <span><a href="#" class="show-conf-info ml-2">Info</a></span> -->
            </div>
        </div>
        <form id="config-company" method="post" class="register-agent">
            @csrf
            <div class="body py-3 shadow">
                <div class="border outer-body mx-3">
                    <div class="row py-3 pb-5">
                        <div class="col-md-12 offset-md-1 mb-2">
                            <div class="header">
                                <h5><b><?php echo $_GET['a-fill-your-details']; ?></b></h5>
                                <div class="h-line"></div>
                            </div>
                        </div>
                        <div class="col-md-4 offset-md-1">
                            <div class="form-group">
                                <label><?php echo $_GET['full-name']; ?></label>
                                <input type="text" name="fname" class="form-control fname">
                            </div>
                            <div class="form-group">
                                <label><?php echo $_GET['region']; ?></label>
                                <select class="form-control select2" name="region">
                                    <option value="">- <?php echo $_GET['select']; ?> -</option>
                                    <option value="Arusha">Arusha</option>
                                    <option value="Dar es Salaam">Dar es Salaam</option>
                                    <option value="Dodoma">Dodoma</option>
                                    <option value="Geita">Geita</option>
                                    <option value="Iringa">Iringa</option>
                                    <option value="Kagera">Kagera</option>
                                    <option value="Katavi">Katavi</option>
                                    <option value="Kigoma">Kigoma</option>
                                    <option value="Kilimanjaro">Kilimanjaro</option>
                                    <option value="Lindi">Lindi</option>
                                    <option value="Manyara">Manyara</option>
                                    <option value="Mara">Mara</option>
                                    <option value="Mbeya">Mbeya</option>
                                    <option value="Morogoro">Morogoro</option>
                                    <option value="Mtwara">Mtwara</option>
                                    <option value="Mwanza">Mwanza</option>
                                    <option value="Njombe">Njombe</option>
                                    <option value="Pemba">Pemba</option>
                                    <option value="Pwani">Pwani</option>
                                    <option value="Rukwa">Rukwa</option>
                                    <option value="Ruvuma">Ruvuma</option>
                                    <option value="Shinyanga">Shinyanga</option>
                                    <option value="Simiyu">Simiyu</option>
                                    <option value="Singida">Singida</option>
                                    <option value="Tabora">Tabora</option>
                                    <option value="Tanga">Tanga</option>
                                    <option value="Zanzibar">Zanzibar</option>
                                </select>
                            </div>
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
                        <div class="col-md-4 offset-md-1 border-left pt-3 personal-block">
                            <div class="row top-row2 clearfix"> 
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
                        <div class="col-sm-6" style="display: none;"> <!-- dont display this to users -->
                            <div class="form-group">
                                <label>Your role</label><br>
                                <p class="border border-primary role-border" style="padding-top: 8px;padding-bottom: 5px;padding-left: 10px;width: 100%;">
                                    Agent role
                                    <label class="fancy-checkbox" style="margin-right: 30px !important;margin-bottom: 0px;display: none;">
                                        <input type="checkbox" class="checkrole" name="roles[]" value="11" data-parsley-errors-container="#error-checkbox" checked>
                                        <span>Levanda POS Agent</span>
                                    </label>
                                </p>
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
            </div>
        </form>   
        
        <div style="display: none;"> <!-- hit this login form once agent register successfully -->
            <form class="form-auth-small" method="POST" action="{{ route('login') }}">
            @csrf
                <div class="form-group">
                    <label for="signin-email" class="control-label sr-only">Username</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="signin-email" name="username" placeholder="Username">
                </div>
                <div class="form-group">
                    <label for="signin-password" class="control-label sr-only">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="signin-password" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block login-btn">LOGIN</button>
            </form>
        </div>

    </div>      
</div>

    <!-- success modal -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border:#28a745 solid 5px;">
                <div class="modal-header">
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button> -->
                </div>
                <div class="modal-body align-center" align="center">
                    Loging in..
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-success go-login ml-auto mr-auto">Click to continue</button>
                </div> -->
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
    
    $(document).on('submit', '.register-agent', function(e){
        e.preventDefault();
        $('.submit-config-company').prop('disabled', true).html('submiting..');
        $('input, textarea, select').removeClass('parsley-error');
        $('.error-alert').css('display',"none");
        var fullname = $('.register-agent [name="fname"]');
        var region = $('.register-agent [name="region"]');
        var username = $('.register-agent [name="username"]');
        var password = $('.register-agent [name="password"]');
        var phone = $('.register-agent [name="phone"]');
        if (fullname.val().trim() == null || fullname.val().trim() == '' || region.val() == "" || region.val() == "" || username.val().trim() == null || username.val().trim() == '' || password.val().trim() == null || password.val().trim() == '' || phone.val().trim() == null || phone.val().trim() == '') {
            $('.submit-config-company').prop('disabled', false).html('Submit'); }
        if (fullname.val().trim() == null || fullname.val().trim() == '') {
            $('.error-alert').css('display',"").children('.badge2').html("-- <?php echo $_GET['n-fill-your-name']; ?>."); fullname.addClass('parsley-error').focus(); return;}
        if (region.val() == "") {
            $('.error-alert').css('display',"").children('.badge2').html("-- <?php echo $_GET['n-select-region']; ?>."); region.addClass('parsley-error').focus(); return;}
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
                $('.register-agent [name="password"]').removeClass('parsley-success').addClass('parsley-error').focus(); return;
            } else {
                if( regex.test(pass) ) {
                    $('.register-agent [name="password"]').removeClass('parsley-error');
                } else {
                    if( regex2.test(pass) ) {
                        $('.register-agent [name="password"]').removeClass('parsley-error');
                    } else {
                        $('.submit-config-company').prop('disabled', false).html('Submit'); $('.error-alert').css('display',"").children('.badge2').html("-- <?php echo $_GET['n-password-digits']; ?>.");
                        $('.register-agent [name="password"]').removeClass('parsley-success').addClass('parsley-error').focus(); return;
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

                        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
                        var formdata = new FormData(document.getElementById("config-company"));
                        $.ajax({
                            type: 'POST',
                            url: '/register-agent',
                            processData: false,
                            contentType: false,
                            data: formdata,
                            success: function(data) {
                                $('.submit-config-company').prop('disabled', false).html('Submit');
                                if (data.status == "success") {
                                    popNotification('success',"Congratulation..");
                                    $('#successModal').modal('toggle');    
                                    $('.register-agent')[0].reset();
                                    $('#signin-email').val(data.username); 
                                    $('#signin-password').val(data.password); 
                                    $('.login-btn').click();
                                } else {
                                    popNotification('warning',"<?php echo $_GET['n-failed-to-create']; ?>.");
                                }
                            }
                        });
                    }
                }); 
            }
        }

    });
</script>
@endsection 