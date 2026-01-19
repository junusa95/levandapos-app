
@include("layouts.translater") 

<style type="text/css">
    .update-product-form label {
        margin-bottom: 2px;
    }
    .p_image_preview {display:block;width:100px;}
    .p_image_preview img {width:inherit}
    .ex-date-b, .min-stock-b {display: none;}
    .more-options {padding-top: 25px;text-align: right;}
    .more-options span a {padding: 3px;font-weight: 550;}
@media screen and (max-width: 768px) {
    .p-name-block {margin-right: 20px;}
}
@media screen and (max-width: 481px) {
    .update-product-form label {font-weight: normal;}
    .update-product-form label.s-l {font-size: 11px;}
}
</style>

<?php
    if(Auth::user()->company->has_product_categories == 'no') {
        $display_none = "display-none";
    } else {
        $display_none = "";
    }
?>

<div class="row" style="">
    <div class="col-md-12 mt-3 mb-3 product"> 
        <!-- <div style="border-bottom: 1px solid #fff;">
            <h5><i class="fa fa-pencil pr-2"></i> <?php echo $_GET['change-product-details']; ?></h5>
        </div> -->
        <form id="basic-form" class="update-product-form" method="post" action="{{ route('update-product') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="pid" value="{{$data['product']->id}}">
            <div class="row clearfix">
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label><?php echo $_GET['product-name']; ?></label>
                        <input type="text" class="form-control" placeholder="Product Name" name="name" value="{{$data['product']->name}}" required>
                    </div>
                </div>
                <div class="col-sm-3" style="display: none;">
                    <div class="form-group">
                        <label>Main category*</label>
                        <select class="form-control cgroup" name="cgroup">
                            <option value="">- select -</option>
                            @if($data['cgroups'])
                                @foreach($data['cgroups'] as $group)
                                    <option value="{{$group->id}}" <?php if($group->id == $data['category-group']->id) { echo 'selected'; } ?>>{{$group->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-12 <?php echo $display_none; ?>">
                    <div class="form-group">
                        <label><?php echo $_GET['category']; ?></label>
                        <div class="input-group">
                            <input type="hidden" name="pro-form" value="yes">
                            <select class="custom-select pcategory select2" name="pcategory" id="inputGroupSelect04" style="width: 50%;" required>
                                @if($data['categories'])
                                    @foreach($data['categories'] as $category)
                                        <option value="{{$category->id}}" <?php if($category->id == $data['product-category']->id) { echo 'selected'; } ?>>{{$category->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-secondary btn-sm new-sub-category-form" data-toggle="modal" data-target="#addSCategory" style="margin-left: -1px;"><i class="fa fa-plus"></i> <?php echo $_GET['add']; ?> </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-6 col-md-6">
                    <div class="form-group">
                        <label><?php echo $_GET['buying-price']; ?></label>
                        <input type="number" class="form-control" step=".01" placeholder="Buying Price" name="buying_price" value="{{$data['product']->buying_price + 0}}">
                    </div>
                </div>
                <div class="col-sm-4" style="display: none;">
                    <div class="form-group">
                        <label>Wholesale Price</label>
                        <input type="number" class="form-control" placeholder="Wholesale Price" step=".01" name="wholesale_price" value="{{$data['product']->wholesale_price}}">
                    </div>
                </div>
                <div class="col-6 col-md-6">
                    <div class="form-group">
                        <label><?php echo $_GET['selling-price']; ?></label>
                        <input type="number" class="form-control" step=".01" placeholder="Retail Price" name="retail_price" value="{{$data['product']->retail_price + 0}}">
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-6 col-md-6">
                    <div class="form-group">
                        <label><?php echo $_GET['attach-image']; ?> <small style="color: red;">(sio lazima)</small></label>
                        @if($data['product']->image) 
                            <?php $src = '/images/companies/'.Auth::user()->company->folder.'/products/'. $data['product']->image; $image = $data['product']->image; ?>
                        @else
                            <?php  $src = "/images/product.jpg"; $image = ""; ?>
                        @endif
                        <input type="file" class="form-control form-control-sm p-img-input" name="image" value="{{$image}}"  accept="image/*">
                        <div class="p_image_preview mt-2">
                            <img id="p_imgPreview" src="{{ $src }}" name="" />
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-6">
                    <div class="form-group ex-date-b">
                        <label>Expire date</label>
                        <input type="text" name="expire_date" data-provide="datepicker" data-date-autoclose="true" class="form-control" value="<?php if($data['product']->expire_date){ echo date('d/m/Y',strtotime($data['product']->expire_date)); } ?>">
                    </div>
                    <div class="form-group min-stock-b">
                        <label>Minimum stock level</label>
                        <?php
                            $min_level = $data['product']->min_stock_level + 0;
                        ?>
                        <input type="text" name="min_stock_level" class="form-control" value="{{$min_level}}">
                    </div>
                    <div class="more-options">
                        <?php 
                            if(Auth::user()->company->settings->isNotEmpty()) { 
                                foreach(Auth::user()->company->settings as $cs) { ?>

                            @if($cs->pivot->setting_id == 1) <span><a href="#" class="expire-date">+ Expire date</a></span>@endif
                            @if($cs->pivot->setting_id == 2) <div class="pt-2"></div> <span><a href="#" class="min-stock-level">+ Minimum stock level</a></span>@endif

                        <?php } } ?>
                    </div>
                </div>
                <div class="col-sm-4" style="display:none">
                    <div class="form-group">
                        <label>Status*</label>
                        <select class="form-control" name="status" required>
                            <?php for ($i=0; $i < count($data['status']); $i++) { ?>
                                    <option value="{{$data['status'][$i]}}" <?php if($data['status'][$i] == $data['product']->status) { echo 'selected'; } ?>>{{ucfirst($data['status'][$i])}}</option>
                                <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-sm-12 mt-2">
                    <div style="display: none;">
                        <input type="submit" class="btn update-product-2" value="submit">
                    </div>                      
                    @if($data['check'] == "product") <!-- this buttons are managed from shop -->
                    <button type="submit" class="btn btn-primary update-product-3" style="width: 60%;"><?php echo $_GET['update-changes']; ?></button>
                    <button class="btn btn-warning px-3" data-dismiss="modal" aria-label="Close">Cancel</button>
                    @else 
                    <button type="submit" class="btn btn-primary update-product-3" style="width: 60%;"><?php echo $_GET['update-changes']; ?></button>
                    <!-- <a href="#" class="btn btn-warning px-3 cancel-edit-pro">Cancel</a> -->
                    <a href="#" class="close btn btn-warning px-3" data-dismiss="modal" aria-label="Close">Cancel</a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $('.select2').select2();
    
    $(document).ready(function() {
        $("#inputGroupSelect04").select2({
            dropdownParent: $("#editProduct")
        });
    });

    $(".p-img-input").change(function(){
        $('.p_image_preview').css("display","block");
        const file = this.files[0];
        if (file) {
          let reader = new FileReader();
          reader.onload = function(event){
            $('#p_imgPreview').attr('src', event.target.result);
          }
          reader.readAsDataURL(file);
        }        
    });
    
    $(document).on('click', '.update-product', function(e){
        e.preventDefault();
        $(this).prop('disabled', true).html('updating..');
        var name = $('.update-product-form [name="name"]').val();
        var cgroup = $('.update-product-form [name="cgroup"]').val();
        var pcategory = $('.update-product-form [name="pcategory"]').val();
        var buying_price = $('.update-product-form [name="buying_price"]').val();
        var retail_price = $('.update-product-form [name="retail_price"]').val();
        if (name.trim() == null || name.trim() == '' || pcategory.trim() == null || pcategory.trim() == '' || buying_price.trim() == null || buying_price.trim() == '' || retail_price.trim() == null || retail_price.trim() == '') {
            popNotification('warning','Please fill all required fields');
            $('.update-product').prop('disabled', false).html("<?php echo $_GET['update-changes']; ?>");
        }
        $('.update-product-2').click();
    });
    
    $(".expire-date").click(function(e){
        e.preventDefault();
        $('.ex-date-b').css("display","block");
        $(this).css("display","none");
        $('.more-options').css({"padding-top":"0px"});
    });
    
    $(".min-stock-level").click(function(e){
        e.preventDefault();
        $('.min-stock-b').css("display","block");
        $(this).css("display","none");
        $('.more-options').css({"padding-top":"0px"});
    });
</script>