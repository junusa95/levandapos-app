

<div class="modal fade" id="createCustomer" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel"><?php echo $_GET["new-customer"]; ?> <small style="font-size:12px"> - {{$data['shop']->name}}</small></h4>
            </div>
            <div class="modal-body"> 
	            <form id="basic-form" class="new-customer">
	                @csrf
					<input type="hidden" name="shopid" value="{{$data['shop']->id}}"> 
	                <div class="row clearfix">
	                    <div class="col-sm-7 col-8">
	                        <div class="form-group">
	                            <label><?php echo $_GET["full-name"]; ?></label>
	                            <input type="text" class="form-control" placeholder="Full Name" name="name" required>
	                        </div>
	                    </div>
	                    <div class="col-sm-5 col-4" style="display: none;">
	                        <div class="form-group">
	                            <label>Gender</label>
	                            <select class="form-control show-tick" name="gender" required>
	                                <option value="Male">Male</option>
	                                <option value="Female">Female</option>
	                            </select>
	                        </div>
	                    </div>
	                    <div class="col-6">
	                        <div class="form-group">
	                            <label><?php echo $_GET["phone-number"]; ?></label>
	                            <input type="text" class="form-control" placeholder="Phone" name="phone" required>
	                        </div>
	                    </div>
	                    <div class="col-6">
	                        <div class="form-group">
	                            <label><?php echo $_GET["address"]; ?></label>
	                            <input type="text" class="form-control" placeholder="Anapopatikana" name="location" required>
	                        </div>
	                    </div>
	                </div>
	                <div class="row clearfix">
	                    <div class="col-sm-12">
	                        <button type="submit" class="btn btn-primary submit-new-customer" style="width: inherit;">Submit</button>
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