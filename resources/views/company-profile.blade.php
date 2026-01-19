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


	.profile-details .col-md-3 {padding-right: 0px;font-weight: bold;margin-bottom: 10px;}
	.profile-details .col-md-3 b {float: right;}
	.profile-details .col-md-9 {padding-right: 3px;margin-bottom: 10px;}
	@media screen and (max-width: 991px) {
	    .profile-details .col-md-3 {min-width: 35% !important;max-width: 35% !important;}
	    .profile-details .col-md-9 {min-width: 65% !important;max-width: 65% !important;}
	}
	@media screen and (max-width: 469px) {
		.profile-details .col-md-3 b {float: none;margin-left: 5px;}
	    .profile-details .col-md-3 {min-width: 100% !important;max-width: 100% !important;margin-bottom: 0px;}
	    .profile-details .col-md-9 {min-width: 100% !important;max-width: 100% !important;margin-bottom: 15px;}
		.profile-details .col-md-9:before {
		    content: " ";
		    background: rgba(0, 0, 0, .25);
		    position: absolute;
		    height: 100%;
		    top: 0;
		    left: 0;margin-left: 3px;
		    width: 5px;
		    z-index: 0;
		    -webkit-user-select: none;
		    -moz-user-select: none;
		    -ms-user-select: none;
		    user-select: none
		}
	}

	.change-img {margin-top: 10px;text-align: center;}
	.change-img span {color: #007bff;cursor: pointer;padding: 2px;}
	#image_preview {width: 100%;text-align: center;}
	#image_preview img {width: 150px;height: 150px;object-fit: cover; border-radius: 50%;}
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
					            <li class="breadcrumb-item"><a href="#" onclick="history.back();" class="homepath2"><i class="fa fa-arrow-left"></i></a></li>
					            <li class="breadcrumb-item active">Company profile</li>
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
	                                    	@if($data['company']->logo) 
	                                    		<?php $src = 'images/companies/'.$data["company"]->folder.'/company-profiles/'. $data['company']->logo; ?>
	                                    	@else
							                    <?php $src = "images/companies/default_logo.png"; ?>
							                @endif
	                                    	<img class="logoimg" src="{{ asset($src) }}" alt=""> 
		                                    <div class="change-img">
		                                    	<span id="change-img"><i class="fa fa-pencil"></i> Change logo</span> 
		                                    </div>
	                                    </div>
	                                </div>
	                                <div class="col-lg-8 col-md-8 col-12 profile-details">
	                                    <h4 class="m-t-0 m-b-0">{{$data['company']->name}}</h4>
	                                    <!-- <span class="job_post">({{Auth::user()->username}})</span> -->
	                                    <div class="row" style="margin-top: 20px;">
	                                    	<div class="col-md-3">About the company<b>:</b></div>
	                                    	<div class="col-md-9">{{$data['company']->about}}</div>

	                                    	<div class="col-md-3 col-4">Country<b>:</b></div>
	                                    	<div class="col-md-9 col-8">@if($data['company']->country) {{$data['company']->country->name}} @endif</div>
											
	                                    	<div class="col-md-3 col-4">TIN<b>:</b></div>
	                                    	<div class="col-md-9">{{$data['company']->tin}}</div>

	                                    	<div class="col-md-3 col-4">VRN<b>:</b></div>
	                                    	<div class="col-md-9">{{$data['company']->vrn}}</div>

	                                    	<div class="col-md-3 col-4">Company owner<b>:</b></div>
	                                    	<div class="col-md-9 col-8">
	                                    		@if($data['company']->companyOwners())
	                                    		@foreach($data['company']->companyOwners() as $owner) 
	                                    			{{$owner->name}}<br>
	                                    		@endforeach
	                                    		@endif
	                                    	</div>

	                                    	<div class="col-md-3 col-4">Man incharge<b>:</b>
	                                    		<span class="ml-2 text-info tool-tip" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $_GET['man-incharge-info']; ?>"><i class="icon-info"></i></span>
	                                    	</div>
	                                    	<div class="col-md-9 col-8">
	                                    		@if($data['company']->companyCEOs())
	                                    		@foreach($data['company']->companyCEOs() as $ceo) 
	                                    			{{$ceo->name}} ({{'+'.$ceo->phonecode.' '.$ceo->phone}})<br>
	                                    		@endforeach
	                                    		@endif
	                                    	</div>

	                                    	<div class="col-md-3 col-4">Currency used<b>:</b></div>
	                                    	<div class="col-md-9 col-8">{{$data['company']->currency->name.' ('.$data['company']->currency->code.')'}} </div>

	                                    	<div class="col-md-3 col-4">Status<b>:</b></div>
	                                    	<div class="col-md-9 col-8">{{ucfirst($data['company']->status)}}</div>

	                                    	<div class="col-md-3 col-4">Number of shops<b>:</b></div>
	                                    	<div class="col-md-9 col-8">
	                                    		{{ \App\Shop::where('company_id',$data['company']->id)->count() }}
	                                    	</div>

	                                    	<div class="col-md-3 col-4">No of stores<b>:</b></div>
	                                    	<div class="col-md-9 col-8">
	                                    		{{ \App\Store::where('company_id',$data['company']->id)->count() }}
	                                    	</div>

	                                    	<div class="col-md-3 col-4">No of customers<b>:</b></div>
	                                    	<div class="col-md-9 col-8">
	                                    		{{ \App\Customer::where('company_id',$data['company']->id)->count() }}
	                                    	</div>

	                                    	<div class="col-md-3 col-4">Created date<b>:</b></div>
	                                    	<div class="col-md-9 col-8">{{date('d/m/Y H:i', strtotime($data['company']->created_at))}}</div>
	                                    </div>
										@if(Auth::user()->isCEOorAdminorBusinessOwner())
	                                    <div class="mt-3">
	                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal">Edit</button>
	                                    </div>
										@endif
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
                        	<input type="file" name="image" class="form-control form-control-sm img-input">
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
                    <form class="edit-company">
                    	@csrf
                    	<div class="row">
	                        <div class="col-md-6">
	                            <div class="form-group">
	                                <label class="mb-0">Company name</label>
	                                <input type="text" class="form-control form-control-sm" placeholder="Company Name" name="name" value="{{$data['company']->name}}" required>
	                            </div>
	                        </div>
	                        <div class="col-md-6">
	                            <div class="form-group">
	                                <label class="mb-0">TIN No</label>
	                                <input type="text" class="form-control form-control-sm" placeholder="TIN No" name="tin" value="{{$data['company']->tin}}">
	                            </div>
	                        </div>
	                        <div class="col-md-6">
	                            <div class="form-group">
	                                <label class="mb-0">VRN</label>
	                                <input type="text" class="form-control form-control-sm" placeholder="VRN" name="vrn" value="{{$data['company']->vrn}}">
	                            </div>
	                        </div>
	                        <div class="col-md-6">
	                            <div class="form-group">
	                                <label class="mb-0">About company</label>
                    				<textarea rows="4" class="form-control" name="about" placeholder="About the company">{{$data['company']->about}}</textarea>
	                            </div>
	                        </div>
	                        <div class="col-md-12">
	                            <div class="form-group">
	                                <button class="btn btn-success btn-sm submit-edit-company" style="width:100%">Submit changes</button>
	                            </div>
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
        formdata.append('status','change company profile');
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
                        window.location = "/company-profile";
                    } else {
                        popNotification('warning','Error! Something went wrong. Please try again');
                        return;
                    }
                }
        });
    });  

    $(document).on('submit', '.edit-company', function(e){
        e.preventDefault();
        $('.submit-edit-company').prop('disabled', true).html('submiting..');
        var name = $('.edit-company [name="name"]').val();
        var about = $('.edit-company [name="about"]').val();
        
        if (name.trim() == null || name.trim() == '') {
            $('.submit-edit-company').prop('disabled', false).html('Submit changes');
        }
        if (name.trim() == null || name.trim() == '') {
            $('.edit-company [name="name"]').addClass('parsley-error').focus(); return;}
        
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var formdata = new FormData(this);
        formdata.append('status','update company details');
        $.ajax({
            type: 'POST',
            url: '/submit-data',
            processData: false,
            contentType: false,
            data: formdata,
                success: function(data) {
                    $('.submit-edit-company').prop('disabled', false).html('Submit changes');
                    if (data.status == "error") {
                        popNotification('warning','Error! Something went wrong. Please try again');
                        return;
                    } 
                    if(data.status == 'success') {
                        popNotification('success','Success! Company info updated successfully');
                        window.location = "/company-profile";
                    }
                }
        });
    });

</script>
@endsection