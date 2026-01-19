
@include("layouts.translater") 

<form id="basic-form" class="edit-pcategories-form">
    @csrf
    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="form-group">
                <div>
                        <div class="row mb-2">
                            <div class="col-md-6 offset-md-3">
                                <label><?php echo $_GET['category']; ?></label>
                                <input type="text" class="form-control form-control-sm" placeholder="<?php echo $_GET['name']; ?>" name="cname{{$data['category']->id}}" value="{{$data['category']->name}}" required>
                            </div>
                            <div class="col-4" style="display: none;">
                                <select class="form-control form-control-sm" name="cgroup{{$data['category']->id}}">
                                    
                                        <option value="{{$data['category']->categoryGroup->id}}">{{$data['category']->categoryGroup->name}}</option>
                                    
                                </select>
                            </div>
                            <div class="col-md-6 offset-md-3 mt-3">
                                <button class="btn btn-info btn-sm update-p-category" style="width: 100%;" val="{{$data['category']->id}}"><?php echo $_GET['update']; ?></button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-sm-12">
            <!-- <button type="submit" class="btn btn-primary submit-edit-expense" style="width: inherit;">Submit</button> -->
        </div>
    </div>
</form>