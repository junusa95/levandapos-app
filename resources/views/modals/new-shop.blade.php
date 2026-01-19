

    <div class="modal fade" id="newShop" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Create new shop</h4>
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9;">
                        <button class="btn btn-danger btn-sm">x</button>
                    </span>
                </div>
                <div class="modal-body">                     
                    <form id="basic-form" class="new-shop">
                        @csrf
                        <div class="load-areas">
                            <i class="fa fa-spinner fa-spin"></i>
                        </div>

                        <div class="check-location-level">
                            
                        </div>
                        <div class="row clearfix">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Shop Name</label>
                                    <input type="text" class="form-control" placeholder="Name" name="name" required>
                                </div>
                            </div>
                            <!-- <div class="col-6">
                                <div class="form-group">
                                    <label>Location</label>
                                    <input type="text" class="form-control" placeholder="Location" name="location" required>
                                </div>
                            </div> -->
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="mb-1"><?php echo $_GET['country_select']; ?></label>
                                    <select class="form-control select2 change-country-2" name="change_country" style="width: 100%;" required>
                                        <option value="">- <?php echo $_GET['select']; ?> -</option>
                                        @if($data['countries']->isNotEmpty())
                                        @foreach($data['countries'] as $country)
                                            <option value="{{$country->id}}">{{$country->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-6 shoplocation_view">
                                <div class="form-group">
                                    <label class="mb-1"><?php echo $_GET['shop-location']; ?></label>
                                    <input type="text" class="form-control form-control-sm" id="" name="shoplocation">
                                </div>
                            </div>
                        </div>
                        <div class="row location_view">
                            <div class="col-sm ">
                                <div class="form-group">
                                    <label class="text-capitalize mb-1"><?php echo $_GET['region_select']; ?></label>
                                    <div class="input-group mb-3">
                                        <select class="form-control select2 region_id" name="region_id" style="width: 100%" required>
                                            <option value="" disabled selected>-Select-</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm col-6">
                                <div class="form-group">
                                    <label class="text-capitalize mb-1"><?php echo $_GET['district_select']; ?></label>
                                    <div class="input-group mb-3">
                                        <select class="form-control select2 district_id" name="district_id" style="width: 100%" required>
                                            <option value="" disabled selected>-Select-</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm col-6">
                                <div class="form-group">
                                    <label class="text-capitalize mb-1"><?php echo $_GET['ward_select']; ?></label>
                                    <div class="input-group mb-3">
                                        <select class="form-control select2 ward_id" name="ward_id" style="width: 100%" required>
                                            <option value="" disabled selected>-Select-</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Cashier</label>
                                    <select class="form-control form-control-sm" name="cashier">
                                        <option value="">- none -</option>
                                        @if($data['users']->isNotEmpty())                                            
                                            @foreach($data['users'] as $user)
                                                <option value="{{$user->id}}">{{$user->username}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12" style="display:none">
                                <div class="form-group">
                                    <label>Do you keep customer records ?</label><br>
                                    <label class="fancy-radio">
                                        <input type="radio" name="crecords" value="yes" required="" data-parsley-errors-container="#error-radio" data-parsley-multiple="crecords" checked>
                                        <span><i></i>Yes</span>
                                    </label>
                                    <label class="fancy-radio">
                                        <input type="radio" name="crecords" value="no" required="" data-parsley-errors-container="#error-radio" data-parsley-multiple="crecords">
                                        <span><i></i>No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix my-2 mb-4">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary submit-new-shop" style="width: inherit;">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>