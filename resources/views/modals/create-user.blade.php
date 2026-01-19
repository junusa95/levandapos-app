

<div class="modal fade" id="createUser" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">New user</h4>
            </div>
            <div class="modal-body"> 
	            <form id="basic-form" class="new-user">
	                @csrf
	                <div class="row clearfix">
	                    <div class="col-sm-6">
	                        <div class="form-group">
	                            <label>Full name</label>
	                            <input type="text" class="form-control" placeholder="Full Name" name="name" required>
	                        </div>
	                    </div>
	                    <div class="col-sm-3">
	                        <div class="form-group">
	                            <label>Phone number</label>
	                            <input type="text" class="form-control" placeholder="Phone" name="phone" required>
	                        </div>
	                    </div>
	                    <div class="col-sm-3">
	                        <div class="form-group">
	                            <label>Gender</label>
	                            <select class="form-control show-tick" name="gender" required>
	                                <option value="Male">Male</option>
	                                <option value="Female">Female</option>
	                            </select>
	                        </div>
	                    </div>
	                </div>
	                <div class="row clearfix">
	                    <div class="col-sm-6">
	                        <div class="form-group">
	                            <label>Email</label>
	                            <input type="text" class="form-control" placeholder="Enter Your Email" name="email" required>
	                        </div>
	                    </div>
	                    <div class="col-sm-6">
	                        <div class="form-group">
	                            <label>Password</label>
	                            <input type="text" class="form-control" placeholder="Password" name="password" required>
	                        </div>
	                    </div>
	                </div>
	                <div class="row clearfix">
	                    <div class="col-sm-12">
	                        <div class="form-group">
	                            <label>Attach roles</label>
	                            <br/>
	                            @foreach(\App\Role::where('name','!=','Admin')->get() as $value)
	                            <label class="fancy-checkbox" style="margin-right: 30px !important;">
	                                <input type="checkbox" name="roles[]" value="{{$value->id}}" data-parsley-errors-container="#error-checkbox">
	                                <span>{{$value->name}}</span>
	                            </label>
	                            @endforeach
	                            <p id="error-checkbox"></p>
	                        </div>
	                    </div>
	                    <div class="col-sm-12">
	                        <button type="submit" class="btn btn-primary submit-new-user" style="width: inherit;">Submit</button>
	                    </div>
	                </div>
	            </form>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-primary">SAVE CHANGES</button> -->
                <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>