@extends('layouts.app')
@section('css')
<style type="text/css">
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
        width: 80px !important;text-align: center;
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
    
    @media screen and (max-width: 575px) {
        .new-user .col-6, .new-user .col-4, .new-user .col-8 {padding-left: 5px;padding-right: 5px;}
    }
    @media screen and (max-width: 480px) {
        .reduce-padding {padding-left:5px;padding-right:5px}
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
                    <div class="col-lg-12 col-md-12 reduce-padding">
                        <div class="card">      
                            <div class="header" style="border-bottom:1px solid #ddd;">
                                <h2><?php echo $_GET['create-user']; ?>:</h2>
                            </div>     
                            <div class="body">
                                <form id="basic-form" method="post" class="new-user" id="add-user">
                                    @csrf
                                    <div class="row clearfix" style="">
                                        <div class="col-md-4 offset-md-2 col-6">
                                            <div class="form-group">
                                                <label class="mb-0"><?php echo $_GET['full-name']; ?></label>
                                                <input type="text" class="form-control" placeholder="" name="name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <div class="form-group">
                                                <label class="mb-0">Email <small>(sio lazima)</small></label> <span><i id="result"></i></span>
                                                <input type="text" class="form-control" id="email" placeholder="" name="email">
                                            </div>                                            
                                        </div>
                                    </div>
                                    <div class="row clearfix" style="">
                                        <div class="col-md-4 offset-md-2 col-4">
                                            <div class="form-group">
                                                <label class="mb-0"><?php echo $_GET['gender']; ?></label>
                                                <select class="form-control show-tick" name="gender" required>
                                                    <option value="Male"><?php echo $_GET['male']; ?></option>
                                                    <option value="Female"><?php echo $_GET['female']; ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-8">
                                            <div class="form-group">
                                                <label class="mb-0"><?php echo $_GET['phone-number']; ?></label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <select class="form-control select2 align-center" name="phonecode">
                                                            @foreach($data['countries'] as $codes)
                                                                <option value="{{$codes->dial_code}}" <?php if($codes->dial_code == Auth::user()->phonecode) { echo "selected"; } ?>>+{{$codes->dial_code}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="000 000 000" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-sm-3" style="display:none">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select class="form-control form-control-sm" name="status">
                                                    <option value="active">Active</option>
                                                    <option value="inactive">In-active</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix mt-1">
                                        <div class="col-md-8 offset-md-2 mt-4">
                                            <div class="form-group">
                                                <label><?php echo $_GET['attach-user-roles']; ?></label>
                                                <br/>
                                                @foreach($data['roles'] as $value)
                                                    @if($value->name == "Business Owner")
                                                    @if(Auth::user()->isBusinessOwner())
                                                    <label class="fancy-checkbox" style="margin-right: 30px !important;">
                                                        <input type="checkbox" class="checkrole" name="roles[]" value="{{$value->id}}" data-parsley-errors-container="#error-checkbox">
                                                        <span>{{$value->name}}</span>
                                                    </label>
                                                    @endif
                                                    @else
                                                        @if($value->name == "Store Manager" || $value->name == "Accountant" || $value->name == "Stock Approver" || $value->name == "Agent" || $value->name == "Shipper")
                                                        <!-- dont display them -->
                                                        @else
                                                        <label class="fancy-checkbox" style="margin-right: 30px !important;">
                                                            <input type="checkbox" class="checkrole" name="roles[]" value="{{$value->id}}" data-parsley-errors-container="#error-checkbox">
                                                            <span>{{$value->name}}</span>
                                                        </label>
                                                        @endif
                                                    @endif
                                                @endforeach
                                                <p id="error-checkbox"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-8 offset-md-2 mb-1">
                                            <div class="row">
                                                <div class="col-md-4 col-sm-6 mb-3 cashier" style="display: none;">
                                                    <label class="mb-0"><?php echo $_GET['choose-shop']; ?> (cashier)</label>
                                                    <input type="hidden" name="cashcheck" value="">
                                                    <select class="form-control" name="cashier">
                                                        @foreach($data['shops'] as $shop)
                                                            <option value="{{$shop->id}}">{{$shop->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>  
                                                <div class="col-md-4 col-sm-6 mb-3 s-person" style="display: none;">
                                                    <label class="mb-0"><?php echo $_GET['choose-shop']; ?> (sale person)</label>
                                                    <input type="hidden" name="spcheck" value="">
                                                    <select class="form-control" name="sperson">
                                                        @foreach($data['shops'] as $shop)
                                                            <option value="{{$shop->id}}">{{$shop->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>          
                                                <div class="col-md-4 col-sm-6 mb-3 s-master" style="display: none;">
                                                    <label class="mb-0"><?php echo $_GET['choose-store']; ?> (store master)</label>
                                                    <input type="hidden" name="smcheck" value="">
                                                    <select class="form-control" name="smaster">
                                                        @foreach($data['stores'] as $store)
                                                            <option value="{{$store->id}}">{{$store->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>    
                                            </div>   
                                        </div>
                                    </div>
                    <div class="mt-4 mb-4">
                        <hr class="style14">
                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-md-4 offset-md-2">
                                            <div class="form-group">
                                                <label>Username</label>
                                                <span class="ml-2 text-info tool-tip" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $_GET['username-info']; ?>"><i class="icon-info"></i></span>
                                                <input type="text" class="form-control" placeholder="Username" name="username" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <div class="form-group pass_show">
                                                <label>Password</label>
                                                <span class="ml-2 text-info tool-tip" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $_GET['password-info']; ?>"><i class="icon-info"></i></span>
                                                <input type="password" class="form-control" placeholder="Password" name="password" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 offset-md-2 mt-3">
                                            <div class="pb-3 align-center error-alert" style="display:none;">
                                                <span class="badge badge-danger p-1" style="border:none;font-size: 90%;"></span>
                                            </div>
                                            <button type="submit" class="btn btn-primary submit-new-user" style="width: inherit;">Submit</button>
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
    $('.select2').select2();

    $(document).ready(function(){
        $('.pass_show').append('<span class="ptxt">Show</span>');  
    });

    $(document).on('click','.pass_show .ptxt', function(){
        $(this).text($(this).text() == "Show" ? "Hide" : "Show"); 
        $(this).prev().attr('type', function(index, attr){return attr == 'password' ? 'text' : 'password'; }); 
    });  

    $(".checkrole").change(function() {
        if(this.checked) {
            // number 5 is cashier
            if ($(this).val() == 6) {
                $('.cashier').css('display','');$('[name="cashcheck"]').val("1");                
            }
            // number 6 is sale person
            if ($(this).val() == 7) {
                $('.s-person').css('display','');$('[name="spcheck"]').val("1");                
            }
            // number 7 is store master
            if ($(this).val() == 8) {
                $('.s-master').css('display','');$('[name="smcheck"]').val("1");
            }
        } else {
            if ($(this).val() == 6) {
                $('.cashier').css('display','none');$('[name="cashcheck"]').val("");                
            }
            if ($(this).val() == 7) {
                $('.s-person').css('display','none');$('[name="spcheck"]').val("");                
            }
            if ($(this).val() == 8) {
                $('.s-master').css('display','none');$('[name="smcheck"]').val("");
            }
        }
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

    // validate email 
    const validateEmail = (email) => {
      return email.match(
        /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      );
    };

    const validate = () => {
      const $result = $('#result');
      const email = $('#email').val();
      $result.text('');

      if (validateEmail(email)) {
        $result.text('"'+email + ' is valid :)"');
        $result.css('color', 'green');
      } else {
        if (email.trim() == null || email.trim() == '') {} else {
            $result.text('"'+email + ' is not valid :("');
            $result.css('color', 'red');
        }
      }
      return false;
    }
    $('#email').on('input', validate);

    $(document).on('submit', '.new-user', function(e){
        e.preventDefault();
        $('.submit-new-user').prop('disabled', true).html('submiting..');
        $('.error-alert').css('display',"none");
        var name = $('[name="name"]').val();
        var phone = $('[name="phone"]').val();
        var gender = $('[name="gender"]').val();
        var email = $('[name="email"]').val();
        var username = $('[name="username"]').val();
        var password = $('[name="password"]').val();
        if (name.trim() == null || name.trim() == '' || phone.trim() == null || phone.trim() == '' || password.trim() == null || password.trim() == '' || password.length<4 || username.trim() == null || username.trim() == '') {
            $('.submit-new-user').prop('disabled', false).html('Submit');
        }
        if (name.trim() == null || name.trim() == '') {
            $('[name="name"]').addClass('parsley-error').focus(); return;}
        if (email.trim() == null || email.trim() == '') { } else {
            if (validateEmail(email)) {
                // it is valid email
            } else {
                $('.submit-new-user').prop('disabled', false).html('Submit');
                $('#email').addClass('parsley-error').focus(); return;
            }
        }
        if (phone.trim() == null || phone.trim() == '') {
            $('[name="phone"]').addClass('parsley-error').focus(); return;
        } else {
            var phone2 = phone.replace(/\s/g, ''); // remove spaces
            if (phone2.length != 9) {
                $('.submit-new-user').prop('disabled', false).html('Submit');
                $('.error-alert').css('display',"").children('.badge').html("-- Please fill the correct phone number. (Nine numbers required)"); $('[name="phone"]').removeClass('parsley-success').addClass('parsley-error').focus(); return;
            } else {
                var regex2 = /[^0-9]/g; // check if contains alphabets, special characters
                if (regex2.test(phone2)) {
                    $('.submit-new-user').prop('disabled', false).html('Submit');
                    $('.error-alert').css('display',"").children('.badge').html("-- Please fill the correct phone number. (Nine numbers required)"); $('[name="phone"]').removeClass('parsley-success').addClass('parsley-error').focus(); return;
                } else {
                    $('[name="phone"]').removeClass('parsley-error');
                }
            }
        }
        if (password.trim() == null || password.trim() == '' || password.length<4) {
            $('[name="password"]').addClass('parsley-error').focus(); return;
        } else {
            var pass = password.trim();
            var count = pass.length;
            const regex = /^(?=.*[0-9])(?=.*[A-Za-z])[A-Za-z0-9]+$/; //check for alphanumeric
            const regex2 = /[a-zA-Z0-9]+[(@!#\$%\^\&*\)\(+=._-]{1,}/; // check for alphanumeric + special characters
            if (count < 4) {
                $('.submit-new-user').prop('disabled', false).html('Submit'); $('.error-alert').css('display',"").children('.badge').html("-- Password has to start with 4 digits, Must be alphanumeric, you can use special characters.");
                $('[name="password"]').removeClass('parsley-success').addClass('parsley-error').focus(); return;
            } else {
                if( regex.test(pass) ) {
                    $('[name="password"]').removeClass('parsley-error');
                } else {
                    if( regex2.test(pass) ) {
                        $('[name="password"]').removeClass('parsley-error');
                    } else {
                        $('.submit-new-user').prop('disabled', false).html('Submit'); $('.error-alert').css('display',"").children('.badge').html("-- Password has to start with 4 digits, Must be alphanumeric, you can use special characters.");
                        $('[name="password"]').removeClass('parsley-success').addClass('parsley-error').focus(); return;
                    }
                }
            }
        }

        // check username
        if (username.trim() == null || username.trim() == '') {
            // stop
        } else {
            var regex = /[^a-z0-9_]/gi; //allow alphanumeric and underscore
            if (regex.test(username)) {
                $('.submit-new-user').prop('disabled', false).html('Submit');
                $('.error-alert').css('display',"").children('.badge').html("-- Special characters are not allowed for username except underscore."); $('[name="username"]').removeClass('parsley-success').addClass('parsley-error').focus(); return;
            } else {
                // check if username exist
                $.get('/company/check-user-name/'+username.trim(), function(data) {    
                    if (data.status == "error") {
                        $('.submit-new-user').prop('disabled', false).html('Submit');
                        $('.error-alert').css('display',"").children('.badge').html("-- Sorry, The username is used by someone else. Please change the username."); $('[name="username"]').removeClass('parsley-success').addClass('parsley-error').focus(); return;
                    } 
                    if (data.status == 'success') {
                        // prepare form to submit

                        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
                        var form = $('form').get(0);
                        var formdata = new FormData(form);
                        $.ajax({
                            type: 'POST',
                            url: '/add-user',
                            processData: false,
                            contentType: false,
                            data: formdata,
                                success: function(data) {
                                    $('.submit-new-user').prop('disabled', false).html('Submit');
                                    if (data.error) {
                                        popNotification('warning',data.error);
                                    } else {
                                        popNotification('success',data.success);
                                        window.location = "/users";
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