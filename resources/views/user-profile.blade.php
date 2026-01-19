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

	/**
	 * ==============================================
	 * Dot Flashing
	 * ==============================================
	 */
	.dot-flashing {
	  position: relative;
	  margin-top: 5px;margin-left: 15px;
	  width: 10px;
	  height: 10px;
	  border-radius: 5px;
	  background-color: #9880ff;
	  color: #9880ff;
	  animation: dotFlashing 1s infinite linear alternate;
	  animation-delay: .5s;
	}

	.dot-flashing::before, .dot-flashing::after {
	  content: '';
	  display: inline-block;
	  position: absolute;
	  top: 0;
	}

	.dot-flashing::before {
	  left: -15px;
	  width: 10px;
	  height: 10px;
	  border-radius: 5px;
	  background-color: #9880ff;
	  color: #9880ff;
	  animation: dotFlashing 1s infinite alternate;
	  animation-delay: 0s;
	}

	.dot-flashing::after {
	  left: 15px;
	  width: 10px;
	  height: 10px;
	  border-radius: 5px;
	  background-color: #9880ff;
	  color: #9880ff;
	  animation: dotFlashing 1s infinite alternate;
	  animation-delay: 1s;
	}

	@keyframes dotFlashing {
	  0% {
	    background-color: #9880ff;
	  }
	  50%,
	  100% {
	    background-color: #ebe6ff;
	  }
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

	.profile-details .col-md-2 {padding-right: 0px;font-weight: bold;}
	.profile-details .col-md-2 b {float: right;}
	.profile-details .col-md-10 {padding-right: 3px;}
	@media screen and (max-width: 1199px) {
	    .profile-details .col-md-2 {min-width: 20% !important;max-width: 20% !important;}
	    .profile-details .col-md-10 {min-width: 80% !important;max-width: 80% !important;}
	}
	@media screen and (max-width: 991px) {
	    .profile-details .col-md-2 {min-width: 27% !important;max-width: 27% !important;}
	    .profile-details .col-md-10 {min-width: 73% !important;max-width: 73% !important;}
	}
	@media screen and (max-width: 472px) {
	    .profile-details .col-md-2 {min-width: 31% !important;max-width: 31% !important;padding-left: 2px;}
	    .profile-details .col-md-10 {min-width: 69% !important;max-width: 69% !important;}
	}
	@media screen and (max-width: 375px) {
	    .profile-details .col-md-2 {min-width: 32% !important;max-width: 32% !important;}
	    .profile-details .col-md-10 {min-width: 68% !important;max-width: 68% !important;}
	}

	.change-img {margin-top: 10px;text-align: center;}
	.change-img span {color: #007bff;cursor: pointer;padding: 2px;}
	#image_preview {width: 100%;text-align: center;}
	#image_preview img {width: 150px;height: 150px;border-radius: 50%;object-fit: cover;}
	@media screen and (max-width: 767px) {
		.change-img {text-align: left;padding-left: 30px;}
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
        
        	<div class="container" style="margin-top:90px">
        		<div class="block-header">
        			<div class="row">
        				<div class="col-lg-6 col-md-8 col-sm-12 top-btm">
					        <ul class="breadcrumb">
					            <li class="breadcrumb-item"><a href="#" onclick="window.location.replace(document.referrer);" class="homepath2"><i class="fa fa-arrow-left"></i></a></li>
					            <li class="breadcrumb-item active">User profile</li>
					        </ul>
					    </div>
        			</div>
        		</div>
        		<div class="row">
        			<div class="col-md-12">
	                    <div class="card w_profile">
	                        <div class="body">
	                            <div class="row" style="text-align:left">
	                                <div class="col-lg-4 col-md-4 col-12">
	                                    <div class="profile-image float-md-right"> 
	                                    	@if(Auth::user()->profile) 
	                                    		<?php $src = 'images/companies/'.Auth::user()->company->folder.'/profiles/'. Auth::user()->profile; ?>
	                                    	@else
							                    @if(Auth::user()->gender == 'Male')
							                    	<?php  $src = "images/companies/man.png"; ?>
							                    @else
							                    	<?php $src = "images/companies/woman2.png"; ?>
							                    @endif 
							                @endif
	                                    	<img class="logoimg" src="{{ asset($src) }}" alt=""> 
		                                    <div class="change-img">
		                                    	<span id="change-img"><i class="fa fa-pencil"></i> Change photo</span> 
		                                    </div>
	                                    </div>
	                                </div>
	                                <div class="col-lg-8 col-md-8 col-12 profile-details">
	                                    <h4 class="m-t-0 m-b-0">{{Auth::user()->name}}</h4>
	                                    <span class="job_post">({{Auth::user()->username}})</span>
	                                    <div class="row" style="margin-top: 20px;">
	                                    	<div class="col-md-2 col-4">Email<b>:</b></div>
	                                    	<div class="col-md-10 col-8">{{Auth::user()->email}}</div>

	                                    	<div class="col-md-2 col-4">Phone number<b>:</b></div>
	                                    	<div class="col-md-10 col-8">{{'+'.Auth::user()->phonecode.' '.Auth::user()->phone}}</div>

	                                    	<div class="col-md-2 col-4">Gender<b>:</b></div>
	                                    	<div class="col-md-10 col-8">{{Auth::user()->gender}}</div>

	                                    	<div class="col-md-2 col-4">Address<b>:</b></div>
	                                    	<div class="col-md-10 col-8">{{Auth::user()->address}}</div>

	                                    	<div class="col-md-2 col-4">Company<b>:</b></div>
	                                    	<div class="col-md-10 col-8">@if(Auth::user()->company) {{Auth::user()->company->name}} @endif</div>

	                                    	<div class="col-md-2 col-4">Created date<b>:</b></div>
	                                    	<div class="col-md-10 col-8">{{date('d/m/Y H:i', strtotime(Auth::user()->created_at))}}</div>
	                                    </div>
	                                    <div class="row mt-3">
	                                    	<div class="col-md-2 col-4">Roles<b>:</b></div>
	                                    	@if(Auth::user()->isAdmin())
	                                    	<div class="col-md-10 col-8" style="font-weight: bold;">
	                                    		System Admin
	                                    	</div>
	                                    	@else
	                                    	<div class="col-md-10 col-8 user-roles">
	                                    		<div class="dot-flashing"></div>
	                                    	</div>
	                                    	@endif
	                                    </div>
	                                    <div class="mt-5">
	                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal">Edit</button>
	                                        <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#passwordModal">Change password</button>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
        		</div>
        	</div>
        
    </div>

    <!-- change profile picture -->
    <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h4>Change password</h4> -->
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                        <button class="btn btn-danger btn-sm">x</button>
                    </span>
                </div>
                <div class="modal-body">
                	<div class="row">
                		<div id="image_preview">
                			<img id="imgPreview" src="#" alt="pic" name="" />
                		</div>
                	</div>
                	<br>
                    <form id="basic-form" class="upload-profile" novalidate>
                        @csrf
                        <div class="form-file mb-3">
                        	<input type="file" name="image" class="form-control form-control-sm img-input" accept="image/x-png,image/gif,image/jpeg,image/jfif" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary upload-profile-btn" style="width: inherit;">Submit new photo</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- edit profile modal -->
    <div class="modal fade" id="editModal" role="dialog" aria-labelledby="editModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Edit info</h4>
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                        <button class="btn btn-danger btn-sm">x</button>
                    </span>
                </div>
                <div class="modal-body">
                    <form class="edit-user">
                    	@csrf

        				<input type="hidden" name="user" value="{{Auth::user()->id}}">
        				<input type="hidden" name="status" value="{{Auth::user()->status}}">
                    	<div class="row">
	                        <div class="col-md-6">
	                            <div class="form-group">
	                                <label class="mb-0">Full name</label>
	                                <input type="text" class="form-control form-control-sm" placeholder="Full Name" name="name" value="{{Auth::user()->name}}" required>
	                            </div>
	                        </div>
	                        <div class="col-md-6">
	                            <div class="form-group">
	                                <label class="mb-0">Username</label>
                    				<span class="ml-2 text-info tool-tip" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $_GET['username-info']; ?>"><i class="icon-info"></i></span>
	                                <input type="text" class="form-control form-control-sm" placeholder="Username" name="username" value="{{Auth::user()->username}}" required>
	                            </div>
	                        </div>
	                        <div class="col-md-6">
	                            <div class="form-group">
	                                <label class="mb-0">Email</label>
	                                <input type="email" class="form-control form-control-sm" placeholder="Email" name="email" value="{{Auth::user()->email}}" required>
	                            </div>
	                        </div>
	                        <div class="col-md-6">
	                            <div class="form-group">
	                                <label class="mb-0">Address</label>
	                                <input type="text" class="form-control form-control-sm" placeholder="Enter address" name="address" value="{{Auth::user()->address}}">
	                            </div>
	                        </div>
				            <div class="col-md-6">
				                <div class="form-group">
				                    <label class="mb-0">Phone number</label>
				                    <div class="input-group mb-3">
				                        <div class="input-group-prepend" style="margin-right:-3px">
				                            <select class="form-control select2 align-center" name="phonecode">
				                                @foreach($data['countries'] as $codes)
				                                    <option value="{{$codes->dial_code}}" <?php if($codes->dial_code == Auth::user()->phonecode) { echo "selected"; } ?>>+{{$codes->dial_code}}</option>
				                                @endforeach
				                            </select>
				                        </div>
				                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="000 000 000" value="{{Auth::user()->phone}}" required>
				                    </div>
				                </div>
				            </div>
	                        <div class="col-md-6">
	                            <div class="form-group">
	                                <label class="mb-0">Gender</label>
	                                <select class="form-control form-control-sm" name="gender">
				                        <option value="Male" <?php if(Auth::user()->gender == "Male"){ echo "selected"; } ?>>Male</option>
				                        <option value="Female" <?php if(Auth::user()->gender == "Female"){ echo "selected"; } ?>>Female</option>
	                                </select>
	                            </div>
	                        </div>
	                        <div class="col-md-12">
				                <div class="pb-3 align-center error-alert" style="display:none;">
				                    <span class="badge badge-danger p-1" style="border:none;font-size: 90%;"></span>
				                </div>
	                            <div class="form-group">
	                                <button class="btn btn-success btn-sm submit-edit-user" style="width:100%">Submit changes</button>
	                            </div>
	                        </div>
                    	</div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- change self password -->
    <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Change password</h4>
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                        <button class="btn btn-danger btn-sm">x</button>
                    </span>
                </div>
                <div class="modal-body">
                    <form id="basic-form2" class="update-pwd" novalidate>
                        @csrf
                        <input type="hidden" name="user" value="{{Auth::user()->id}}">
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group pass_show">
                                    <label>Password</label>
                                    <span class="ml-2 text-info tool-tip" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $_GET['password-info']; ?>"><i class="icon-info"></i></span>
                                    <input type="password" class="form-control" placeholder="New Password" name="password" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="pb-1 align-center error2-alert" style="display:none;">
                                    <p class="badge2 badge-danger p-1" style="border:none;font-size: 90%;"></p>
                                </div>
                                <button type="submit" class="btn btn-primary submit-update-pwd" style="width: inherit;">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
<script type="text/javascript">
	$('.select2').select2();
	var user_id = "<?php echo Auth::user()->id; ?>";
	$(function () {
		$.get('/user-roles/users/'+user_id, function(data){ 
			$('.user-roles').html(data.view);
		});
	});

    $(document).ready(function(){
        $('.pass_show').append('<span class="ptxt">Show</span>');  
    });

    $(document).on('click','.pass_show .ptxt', function(){
        $(this).text($(this).text() == "Show" ? "Hide" : "Show"); 
        $(this).prev().attr('type', function(index, attr){return attr == 'password' ? 'text' : 'password'; }); 
    });  

    $(document).on('click','#change-img', function(e){
    	var logoimg = $('.logoimg').attr('src');
        $('#imgPreview').attr('src', logoimg);
        
        $('#profileModal').modal('toggle');
        $('.img-input').click();        
    });  

    $(".img-input").change(function(){
    	// $('#image_preview').html("");
    	const file = this.files[0];
    	if (file) {
          let reader = new FileReader();
          reader.onload = function(event){
            $('#imgPreview').attr('src', event.target.result);
          }
          reader.readAsDataURL(file);
    	}
		
    });

    $(document).on('submit','.upload-profile', function(e){
        e.preventDefault();
        $('.upload-profile-btn').prop('disabled', true).html('updating..');
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        formdata.append('status','change profile');
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.upload-profile-btn').prop('disabled', false).html('Submit new photo');
                    if(data.status == 'success') {
                        popNotification('success','Success! Profile changed successfully');
                        window.location = "/user-profile";
                    } else {
                        popNotification('warning','Error! Something went wrong. Please try again');
                        return;
                    }
                }
        });
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
            $('.submit-edit-user').prop('disabled', false).html('Submit changes');
        }
        if (name.trim() == null || name.trim() == '') {
            $('[name="name"]').addClass('parsley-error').focus(); return;}
        // check phone number
        if (phone.trim() == null || phone.trim() == '') {
            $('[name="phone"]').addClass('parsley-error').focus(); return;
        } else {
            var phone2 = phone.replace(/\s/g, ''); // remove spaces
            if (phone2.length != 9) {
                $('.submit-edit-user').prop('disabled', false).html('Submit changes');
                $('.error-alert').css('display',"").children('.badge').html("-- Please fill the correct phone number. (Nine numbers required)"); $('[name="phone"]').removeClass('parsley-success').addClass('parsley-error').focus(); return;
            } else {
                var regex2 = /[^0-9]/g; // check if contains alphabets, special characters
                if (regex2.test(phone2)) {
                    $('.submit-edit-user').prop('disabled', false).html('Submit changes');
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
                $('.submit-edit-user').prop('disabled', false).html('Submit changes');
                $('#email').addClass('parsley-error').focus(); return;
            }
        }
        // check username
        if (username.trim() == null || username.trim() == '') { 
            // stop
        } else {
            var regex = /[^a-z0-9_]/gi; //allow alphanumeric and underscore
            if (regex.test(username)) {
                $('.submit-edit-user').prop('disabled', false).html('Submit changes');
                $('.error-alert').css('display',"").children('.badge').html("-- Special characters are not allowed for username except underscore."); $('[name="username"]').removeClass('parsley-success').addClass('parsley-error').focus(); return;
            }
        }
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        formdata.append('check','update user details');
        formdata.append('check2','without roles');
        $.ajax({
            type: 'POST',
            url: '/edit-user',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.submit-edit-user').prop('disabled', false).html('Submit changes');
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
                        popNotification('success','Success! User updated successfully');
                        window.location = "/user-profile";
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
                $('.submit-update-pwd').prop('disabled', false).html('Update'); $('.error2-alert').css('display',"block").children('.badge2').html("-- Password has to start with 4 digits, Must be alphanumeric, you can use special characters.");
                $('[name="password"]').removeClass('parsley-success').addClass('parsley-error').focus(); return;
            } else {
                if( regex.test(pass) ) {
                    $('[name="password"]').removeClass('parsley-error');
                } else {
                    if( regex2.test(pass) ) {
                        $('[name="password"]').removeClass('parsley-error');
                    } else {
                        $('.submit-update-pwd').prop('disabled', false).html('Update'); $('.error2-alert').css('display',"").children('.badge2').html("-- Password has to start with 4 digits, Must be alphanumeric, you can use special characters.");
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
                        popNotification('success','Success! Password updated successfully.');
                        window.location = "/user-profile";
                    }
                }
        });
    });
</script>
@endsection