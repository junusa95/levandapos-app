@extends('layouts.app')

<?php
    if(Cookie::get("language") == 'en') {
        $_GET['manage-user-roles-f'] = "Update ".$data['user']->username."'s roles";
    } else {
        $_GET['manage-user-roles-f'] = "Badili majukum ya ".$data['user']->username;
    }
?>
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
        .edit-user .col-6, .edit-user .col-4, .edit-user .col-8, .edit-user .col-12 {padding-left: 5px;padding-right: 5px;}
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
                        <div class="card pb-3">      
                            <div class="header" style="border-bottom:1px solid #ddd;">
                                <h2><?php echo $_GET['edit-user-details']; ?>:</h2>
                            </div>     
                            <div class="body">
    <form id="basic-form" class="edit-user">
        @csrf
        <input type="hidden" name="user" value="{{$data['user']->id}}">
        <div class="row clearfix">
            <div class="col-sm-5 col-6">
                <div class="form-group">
                    <label class="mb-0"><?php echo $_GET['full-name']; ?></label>
                    <input type="text" class="form-control" placeholder="Full Name" name="name" value="{{$data['user']->name}}" required>
                </div>
            </div>
            <div class="col-sm-4 col-6">
                <div class="form-group">
                    <label class="mb-0">Email</label> <span><i id="result"></i></span>
                    <input type="text" class="form-control" id="email" placeholder="Enter Email" name="email" value="{{$data['user']->email}}">
                </div>                  
            </div>
            <div class="col-sm-3 col-6" style="display: none;">
                <div class="form-group">
                    <label class="mb-0"><?php echo $_GET['home-address']; ?></label>
                    <input type="text" class="form-control" placeholder="Enter address" name="address" value="{{$data['user']->address}}">
                </div>
            </div>
            <div class="col-sm-3 col-4">
                <div class="form-group">
                    <label class="mb-0"><?php echo $_GET['gender']; ?></label>
                    <select class="form-control show-tick" name="gender" required>
                        <option value="Male" <?php if($data['user']->gender == "Male"){ echo "selected"; } ?>>Male</option>
                        <option value="Female" <?php if($data['user']->gender == "Female"){ echo "selected"; } ?>>Female</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-5 col-md-4 col-8">
                <div class="form-group">
                    <label class="mb-0"><?php echo $_GET['phone-number']; ?></label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <select class="form-control select2 align-center" name="phonecode">
                                @foreach($data['countries'] as $codes)
                                    <option value="{{$codes->dial_code}}" <?php if($codes->dial_code == $data['user']->phonecode) { echo "selected"; } ?>>+{{$codes->dial_code}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="000 000 000" value="{{$data['user']->phone}}" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-5 col-md-4 col-12">
                <div class="form-group">
                    <label class="mb-0">Username</label>
                    <span class="ml-2 text-info tool-tip" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $_GET['username-info']; ?>"><i class="icon-info"></i></span>
                    <input type="text" class="form-control" placeholder="Username" name="username" style="border: 1px solid #c3e6cb" value="{{$data['user']->username}}" required>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-sm-3" style="display: none;">
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control form-control-sm" name="status">
                        <option value="active" <?php if($data['user']->status == "active"){ echo "selected"; } ?>>Active</option>
                        <option value="inactive" <?php if($data['user']->status == "inactive"){ echo "selected"; } ?>>In-active</option>
                        <option value="blocked" <?php if($data['user']->status == "blocked"){ echo "selected"; } ?>>Block</option>
                    </select>
                </div>
            </div>
        </div>
            <div class="col-sm-12 mt-3">
                <div class="pb-3 align-center error-alert" style="display:none;">
                    <span class="badge badge-danger p-1" style="border:none;font-size: 90%;"></span>
                </div>
                <button type="submit" class="btn btn-primary submit-edit-user" style="width: inherit;">Submit</button>
            </div>
        </div>
    </form>
                            </div>
                        </div>
                    </div>
                </div>

    <div class="row clearfix" style="margin-left: 0px;margin-right: 0px;">
        <div class="col-lg-12 col-md-12 reduce-padding">
            <div class="card">      
                <div class="header" style="border-bottom:1px solid #ddd;">
                    <h2><?php echo $_GET['manage-user-roles-f']; ?>:</h2>
                </div>     
                <div class="body">
                    <form id="basic-form" class="update-roles">
                        @csrf
                        <input type="hidden" name="user" value="{{$data['user']->id}}">
                    <div class="row clearfix mt-1">
                        <div class="col-sm-7">
                            <div class="form-group">
                                <label><?php echo $_GET['attach-user-roles']; ?></label>
                                <br/>
                                @foreach(\App\Role::where('name','!=','Admin')->get() as $value2)
                                    @if($value2->name == "Business Owner")
                                    @if(Auth::user()->isBusinessOwner())
                                    <label class="fancy-checkbox" style="margin-right: 30px !important;">
                                        <input type="checkbox" class="checkrole roles" name="roles[]" value="{{$value2->id}}" data-parsley-errors-container="#error-checkbox" <?php if ($value2->isUserHasThisRole($data['user']->id)) { echo "checked"; } ?>>
                                        <span>{{$value2->name}}</span>
                                    </label>
                                    @else
                                    <label class="fancy-checkbox" style="margin-right: 30px !important;display:none">
                                        <input type="checkbox" class="checkrole roles" name="roles[]" value="{{$value2->id}}" data-parsley-errors-container="#error-checkbox" <?php if ($value2->isUserHasThisRole($data['user']->id)) { echo "checked"; } ?>>
                                        <span>{{$value2->name}}</span>
                                    </label>
                                    @endif
                                    @else
                                        @if($value2->name == "Store Manager" || $value2->name == "Accountant" || $value2->name == "Stock Approver" || $value2->name == "Agent" || $value2->name == "Shipper")
                                        <!-- dont display them -->
                                        @else
                                            @if($value2->id == 6 || $value2->id == 7 || $value2->id == 8)
                                            <label class="fancy-checkbox" style="margin-right: 30px !important;">
                                                <input type="checkbox" class="checkrole roles" name="roles[]" value="{{$value2->id}}" data-parsley-errors-container="#error-checkbox">
                                                <span>{{$value2->name}}</span>
                                            </label>
                                            @else
                                            <label class="fancy-checkbox" style="margin-right: 30px !important;">
                                                <input type="checkbox" class="checkrole roles" name="roles[]" value="{{$value2->id}}" data-parsley-errors-container="#error-checkbox" <?php if ($value2->isUserHasThisRole($data['user']->id)) { echo "checked"; } ?>>
                                                <span>{{$value2->name}}</span>
                                            </label>
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                                <p id="error-checkbox"></p>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="cashier my-3" style="display: none;">
                                <label class="mb-0"><?php echo $_GET['choose-shop']; ?> (cashier)</label>
                                <select class="form-control add-cashier" name="cashier" user="{{$data['user']->id}}">
                                    <option value="">- select -</option>
                                    @foreach($data['shops'] as $shop)
                                        <option value="{{$shop->id}}">{{$shop->name}}</option>
                                    @endforeach
                                </select>
                            </div>     
                            <div class="s-person my-3" style="display: none;">
                                <label class="mb-0"><?php echo $_GET['choose-shop']; ?> (sale person)</label>
                                <select class="form-control add-sperson" name="sperson" user="{{$data['user']->id}}">
                                    <option value="">- select -</option>
                                    @foreach($data['shops'] as $shop)
                                        <option value="{{$shop->id}}">{{$shop->name}}</option>
                                    @endforeach
                                </select>
                            </div>        
                            <div class="s-master my-3" style="display: none;">
                                <label class="mb-0"><?php echo $_GET['choose-store']; ?> (store master)</label>
                                <select class="form-control add-smaster" name="smaster" user="{{$data['user']->id}}">
                                    <option value="">- select -</option>
                                    @foreach($data['stores'] as $store)
                                        <option value="{{$store->id}}">{{$store->name}}</option>
                                    @endforeach
                                </select>
                            </div>  
                        </div>
                    </div>
                    
                    <div class="row" style="background:#fff;margin-left: -10px;">
                        <div class="col-sm-6 col-md-4 mt-4 render-cashier">
                            <label class="mb-0"><?php echo $_GET['attached-shops']; ?> (cashier)</label>
                            @if($data['user']->isCashier())
                                @foreach($data['user']->cashierShops() as $cshops)
                                <?php $shop = \App\Shop::where('id',$cshops->shop_id)->where('company_id',Auth::user()->company_id)->first(); ?>
                                @if($shop)
                                <div class="row mb-2" id="rcashier<?php echo $shop->id.$data['user']->id; ?>">
                                    <div class="col-sm-8 col-9">
                                        <input type="text" class="form-control form-control-sm" name="cashier" value="{{$shop->name}}" disabled>
                                    </div>
                                    <div class="col-sm-2 col-3 pl-0">
                                        <button class="btn btn-outline-danger btn-sm untouch-cashier" uid="{{$data['user']->id}}" sid="{{$shop->id}}" sname="{{$shop->name}}"><i class="fa fa-times"></i> remove </button>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            @else
                                <div class="none" style="font-style: italic;">- none -</div>
                            @endif       
                        </div>                     
                        <div class="col-sm-6 col-md-4 mt-4 render-sperson">
                            <label class="mb-0"><?php echo $_GET['attached-shops']; ?> (sale person)</label>
                            @if($data['user']->isSalePerson())
                                @foreach($data['user']->salePersonShops() as $sperson)
                                <?php $shop2 = \App\Shop::where('id',$sperson->shop_id)->where('company_id',Auth::user()->company_id)->first(); ?>
                                @if($shop2)
                                <div class="row mb-2" id="rsperson<?php echo $shop2->id.$data['user']->id; ?>">
                                    <div class="col-sm-8 col-9">
                                        <input type="text" class="form-control form-control-sm" name="sperson" value="{{$shop2->name}}" disabled>
                                    </div>
                                    <div class="col-sm-2 col-3 pl-0">
                                        <button class="btn btn-outline-danger btn-sm untouch-sale-person" uid="{{$data['user']->id}}" sid="{{$shop2->id}}" sname="{{$shop2->name}}"><i class="fa fa-times"></i> remove </button>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            @else
                                <div class="none" style="font-style: italic;">- none -</div>
                            @endif  
                        </div>                         
                        <div class="col-sm-6 col-md-4 mt-4 render-smaster">
                            <label class="mb-0"><?php echo $_GET['attached-stores']; ?> (store master)</label>
                            @if($data['user']->isStoreMaster())
                                @foreach($data['user']->storeMasterStores() as $smaster)
                                <?php $store = \App\Store::where('id',$smaster->store_id)->where('company_id',Auth::user()->company_id)->first(); ?>
                                @if($store)
                                <div class="row mb-2" id="rsmaster<?php echo $store->id.$data['user']->id; ?>">
                                    <div class="col-sm-8 col-9">
                                        <input type="text" class="form-control form-control-sm" name="smaster" value="{{$store->name}}" disabled>
                                    </div>
                                    <div class="col-sm-2 col-3 pl-0">
                                        <button class="btn btn-outline-danger btn-sm untouch-store-master" uid="{{$data['user']->id}}" sid="{{$store->id}}" sname="{{$store->name}}"><i class="fa fa-times"></i> remove </button>
                                    </div>
                                </div>
                                @endif
                                @endforeach 
                            @else
                                <div class="none" style="font-style: italic;">- none -</div>
                            @endif  
                        </div>                         
                    </div>
                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-success update-roles-btn" style="width: 150px;"><?php echo $_GET['update']; ?> <i class="fa fa-check"></i></button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

                <div class="row clearfix" style="margin-left: 0px;margin-right: 0px;">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">      
                            <div class="header" style="border-bottom:1px solid #ddd;">
                                <h2><?php echo $_GET['change-password']; ?>:</h2>
                            </div>     
                            <div class="body">
                                <div class="pb-3">
                                    <form id="basic-form" class="update-pwd" novalidate>
                                        @csrf
                                        <input type="hidden" name="user" value="{{$data['user']->id}}">
                                        
                                        <div class="row">
                                            <div class="col-sm-7 col-md-5">
                                                <div class="form-group pass_show">
                                                    <label>Password</label>
                                                    <span class="ml-2 text-info tool-tip" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $_GET['password-info']; ?>"><i class="icon-info"></i></span>
                                                    <input type="password" class="form-control" placeholder="New Password" name="password" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-7 col-md-5">
                                                <div class="pb-3 align-center error2-alert" style="display:none;">
                                                    <span class="badge badge-danger p-1" style="border:none;font-size: 90%;"></span>
                                                </div>
                                                <button type="submit" class="btn btn-primary submit-update-pwd" style="width: inherit;">Update</button>
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
    </div>
@endsection

@section('js')
<script type="text/javascript">
    $('.select2').select2();

    $(document).ready(function(){
        $('.pass_show').append('<span class="ptxt">Show</span>');  
    });

    $(".checkrole").change(function() {
        if(this.checked) {
            // number 6 is cashier
            if ($(this).val() == 6) {
                $('.cashier').css('display','');                
            }
            // number 7 is sale person
            if ($(this).val() == 7) {
                $('.s-person').css('display','');                
            }
            // number 8 is store master
            if ($(this).val() == 8) {
                $('.s-master').css('display','');
            }
        } else {
            if ($(this).val() == 6) {
                $('.cashier').css('display','none');               
            }
            if ($(this).val() == 7) {
                $('.s-person').css('display','none');                
            }
            if ($(this).val() == 8) {
                $('.s-master').css('display','none');
            }
        }
    });

    $(document).on('click','.pass_show .ptxt', function(){
        $(this).text($(this).text() == "Show" ? "Hide" : "Show"); 
        $(this).prev().attr('type', function(index, attr){return attr == 'password' ? 'text' : 'password'; }); 
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

    $(document).on('submit', '.edit-user', function(e){
        e.preventDefault();
        $('.submit-edit-user').prop('disabled', true).html('submiting..');
        $('.error-alert').css('display',"none");
        var user = $('[name="user"]').val();
        var name = $('[name="name"]').val();
        var phone = $('[name="phone"]').val();
        var email = $('[name="email"]').val();
        var username = $('[name="username"]').val();
        if (name.trim() == null || name.trim() == '' || phone.trim() == null || phone.trim() == '' || username.trim() == null || username.trim() == '') {
            $('.submit-edit-user').prop('disabled', false).html('Submit');
        }
        if (name.trim() == null || name.trim() == '') {
            $('[name="name"]').addClass('parsley-error').focus(); return;}
        // check phone number
        if (phone.trim() == null || phone.trim() == '') {
            $('[name="phone"]').addClass('parsley-error').focus(); return;
        } else {
            var phone2 = phone.replace(/\s/g, ''); // remove spaces
            if (phone2.length != 9) {
                $('.submit-edit-user').prop('disabled', false).html('Submit');
                $('.error-alert').css('display',"").children('.badge').html("-- Please fill the correct phone number. (Nine numbers required)"); $('[name="phone"]').removeClass('parsley-success').addClass('parsley-error').focus(); return;
            } else {
                var regex2 = /[^0-9]/g; // check if contains alphabets, special characters
                if (regex2.test(phone2)) {
                    $('.submit-edit-user').prop('disabled', false).html('Submit');
                    $('.error-alert').css('display',"").children('.badge').html("-- Please fill the correct phone number. (Nine numbers required)"); $('[name="phone"]').removeClass('parsley-success').addClass('parsley-error').focus(); return;
                } else {
                    $('[name="phone"]').removeClass('parsley-error');
                }
            }
        }
        if (email.trim() == null || email.trim() == '') { } else {
            if (validateEmail(email)) {
                // it is valid email
            } else {
                $('.submit-edit-user').prop('disabled', false).html('Submit');
                $('#email').addClass('parsley-error').focus(); return;
            }
        }
        // check username
        if (username.trim() == null || username.trim() == '') { 
            // stop
        } else {
            var regex = /[^a-z0-9_]/gi; //allow alphanumeric and underscore
            if (regex.test(username)) {
                $('.submit-edit-user').prop('disabled', false).html('Submit');
                $('.error-alert').css('display',"").children('.badge').html("-- Special characters are not allowed for username except underscore."); $('[name="username"]').removeClass('parsley-success').addClass('parsley-error').focus(); return;
            }
        }
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        formdata.append('check','update user details');
        formdata.append('check2','with roles');
        $.ajax({
            type: 'POST',
            url: '/edit-user',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.submit-edit-user').prop('disabled', false).html('Submit');
                    if (data.status == "username occupied") {
                        $('.error-alert').css('display',"").children('.badge').html("-- Sorry, The username is used by someone else. Please change the username."); $('[name="username"]').removeClass('parsley-success').addClass('parsley-error').focus();
                        popNotification('warning','Sorry! the username is used by someone else');
                        return;
                    }
                    if (data.status == "error") {
                        popNotification('warning','Error! Something went wrong. Please try again');
                        return;
                    } 
                    if(data.status == 'success') {
                        popNotification('success','Success! User details updated successfully');                        
                    }
                }
        });
    });

    $(document).on('submit', '.update-roles', function(e){
        e.preventDefault();
        $('.update-roles-btn').prop('disabled', true).html('submiting..');
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        formdata.append('check','update user roles');
        formdata.append('check2','with roles');
        $.ajax({
            type: 'POST',
            url: '/edit-user',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.update-roles-btn').prop('disabled', false).html("<?php echo $_GET['update']; ?> <i class='fa fa-check'></i>");
                    if (data.status == "error") {
                        popNotification('warning','Error! Something went wrong. Please try again');
                        return;
                    } 
                    if(data.status == 'success') {
                        popNotification('success','Success! User roles updated successfully');
                    }
                }
        });
    });

    $(document).on('submit', '.update-pwd', function(e){
        e.preventDefault();
        $('.submit-update-pwd').prop('disabled', true).html('updating..');
        $('.error2-alert').css('display',"none");
        var user = $('[name="user"]').val();
        var password = $('[name="password"]').val();
        if (password.trim() == null || password.trim() == '' || password.length<4) {
            $('.submit-update-pwd').prop('disabled', false).html('Update');
        }
        if (password.trim() == null || password.trim() == '' || password.length<4) {
            $('[name="password"]').addClass('parsley-error').focus(); return;
        } else {
            var pass = password.trim();
            var count = pass.length;
            const regex = /^(?=.*[0-9])(?=.*[A-Za-z])[A-Za-z0-9]+$/; //check for alphanumeric
            const regex2 = /[a-zA-Z0-9]+[(@!#\$%\^\&*\)\(+=._-]{1,}/; // check for alphanumeric + special characters
            if (count < 4) {
                $('.submit-update-pwd').prop('disabled', false).html('Update'); $('.error2-alert').css('display',"").children('.badge').html("-- Password has to start with 4 digits, Must be alphanumeric, you can use special characters.");
                $('[name="password"]').removeClass('parsley-success').addClass('parsley-error').focus(); return;
            } else {
                if( regex.test(pass) ) {
                    $('[name="password"]').removeClass('parsley-error');
                } else {
                    if( regex2.test(pass) ) {
                        $('[name="password"]').removeClass('parsley-error');
                    } else {
                        $('.submit-update-pwd').prop('disabled', false).html('Update'); $('.error2-alert').css('display',"").children('.badge').html("-- Password has to start with 4 digits, Must be alphanumeric, you can use special characters.");
                        $('[name="password"]').removeClass('parsley-success').addClass('parsley-error').focus(); return;
                    }
                }
            }
        }
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        formdata.append('password',password);
        formdata.append('user',user);
        formdata.append('check','update user password');
        $.ajax({
            type: 'POST',
            url: '/edit-user',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.submit-update-pwd').prop('disabled', false).html('Update');
                    if (data.status == 'error') {
                        popNotification('warning','Error! Something went wrong. Please try again.');
                    } 
                    if (data.status == 'success') {
                        $('[name="password"]').val("");
                        popNotification('success','Success! Password updated successfully.');
                    }
                }
        });
    });
    
    $(document).on('change', '.add-cashier', function(e){
        e.preventDefault();
        var user_id = $(this).attr('user');
        var shop_id = $(this).val();
        if (shop_id == '') {
            return;
        }
        $('.full-cover').css('display','block');

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData();
        formdata.append('user_id',user_id);
        formdata.append('shop_id',shop_id);
        $.ajax({
            type: 'POST',
            url: '/add-cashier',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.full-cover').css('display','none');
                    if (data.error) {
                        popNotification('warning',data.error);
                    } else {
                        $('.render-cashier .none').css('display','none');
                        $('.render-cashier').append('<div class="row mb-2" id="rcashier'+data.shop+data.user+'"><div class="col-sm-8">'+
                                '<input type="text" class="form-control form-control-sm" name="cashier" value="'+data.shopname+'" disabled></div>'+                            
                            '<div class="col-sm-2">'+
                                '<button class="btn btn-outline-danger btn-sm untouch-cashier" uid="'+data.user+'" sid="'+data.shop+'" sname="'+data.shopname+'"><i class="fa fa-times"></i> remove </button></div></div>');
                        popNotification('success',data.success);
                    }
                }
        });
    });

    $(document).on('change', '.add-sperson', function(e){
        e.preventDefault();
        var user_id = $(this).attr('user');
        var shop_id = $(this).val();
        if (shop_id == '') {
            return;
        }
        $('.full-cover').css('display','block');

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData();
        formdata.append('user_id',user_id);
        formdata.append('shop_id',shop_id);
        $.ajax({
            type: 'POST',
            url: '/add-sperson',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.full-cover').css('display','none');
                    if (data.error) {
                        popNotification('warning',data.error);
                    } else {
                        $('.render-sperson .none').css('display','none');
                        $('.render-sperson').append('<div class="row mb-2" id="rsperson'+data.shop+data.user+'"><div class="col-sm-8">'+
                                '<input type="text" class="form-control form-control-sm" name="sperson" value="'+data.shopname+'" disabled></div>'+                            
                            '<div class="col-sm-2">'+
                                '<button class="btn btn-outline-danger btn-sm untouch-sale-person" uid="'+data.user+'" sid="'+data.shop+'" sname="'+data.shopname+'"><i class="fa fa-times"></i> remove </button></div></div>');
                        popNotification('success',data.success);
                    }
                }
        });
    });

    $(document).on('change', '.add-smaster', function(e){
        e.preventDefault();
        var user_id = $(this).attr('user');
        var store_id = $(this).val();
        if (store_id == '') {
            return;
        }
        $('.full-cover').css('display','block');

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData();
        formdata.append('user_id',user_id);
        formdata.append('store_id',store_id);
        $.ajax({
            type: 'POST',
            url: '/add-smaster',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.full-cover').css('display','none');
                    if (data.error) {
                        popNotification('warning',data.error);
                    } else {
                        $('.render-smaster .none').css('display','none');
                        $('.render-smaster').append('<div class="row mb-2" id="rsmaster'+data.store+data.user+'"><div class="col-sm-8">'+
                                '<input type="text" class="form-control form-control-sm" name="smaster" value="'+data.storename+'" disabled></div>'+                            
                            '<div class="col-sm-2">'+
                                '<button class="btn btn-outline-danger btn-sm untouch-store-master" uid="'+data.user+'" sid="'+data.store+'" sname="'+data.storename+'"><i class="fa fa-times"></i> remove </button></div></div>');
                        popNotification('success',data.success);
                    }
                }
        });
    });

    $(document).on('click', '.untouch-cashier', function(e){
        e.preventDefault();
        var shopname = $(this).attr('sname');
        if(confirm("Click OK to confirm that this user is no longer a cashier of "+shopname+".")){
            $('.full-cover').css('display','block');
            var uid = $(this).attr('uid');
            var shop = $(this).attr('sid');

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

    $(document).on('click', '.untouch-sale-person', function(e){
        e.preventDefault();
        var shopname = $(this).attr('sname');
        if(confirm("Click OK to confirm that this user is no longer a sale person of "+shopname+".")){
            $('.full-cover').css('display','block');
            var uid = $(this).attr('uid');
            var shop = $(this).attr('sid');

            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            var formdata = new FormData();
            formdata.append('uid',uid);
            formdata.append('shop',shop);
            $.ajax({
                type: 'POST',   
                url: '/untouch-sperson',
                processData: false,
                contentType: false,
                data: formdata,
                    success: function(data) {
                        $('.full-cover').css('display','none');
                        if (data.error) {
                            popNotification('warning',data.error);
                        } else {
                            popNotification('success',data.success);
                            $('#rsperson'+data.shop+data.id).css('display','none');
                        }
                    }
            });
        }
        return;
    });

    $(document).on('click', '.untouch-store-master', function(e){
        e.preventDefault();
        var storename = $(this).attr('sname');
        if(confirm("Click OK to confirm that this user is no longer a store master of "+storename+".")){
            $('.full-cover').css('display','block');
            var uid = $(this).attr('uid');
            var store = $(this).attr('sid');

            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            var formdata = new FormData();
            formdata.append('uid',uid);
            formdata.append('store',store);
            $.ajax({
                type: 'POST',   
                url: '/untouch-smaster',
                processData: false,
                contentType: false,
                data: formdata,
                    success: function(data) {
                        $('.full-cover').css('display','none');
                        if (data.error) {
                            popNotification('warning',data.error);
                        } else {
                            popNotification('success',data.success);
                            $('#rsmaster'+data.store+data.id).css('display','none');
                        }
                    }
            });
        }
        return;
    });
</script>
@endsection