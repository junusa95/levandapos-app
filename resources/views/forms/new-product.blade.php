
@include("layouts.translater") 

<link rel="stylesheet" href="{{ asset('vendor/dropify/css/dropify.min.css') }}">
<style type="text/css">
    .new-product label {
        margin-bottom: 2px;
    }
    .new-sub-category-form.btn {font-size: 0.75rem;}
    .ex-date-b, .min-stock-b {display: none;}
    .more-options {padding-top: 25px;text-align: right;}
    .more-options span a {padding: 3px;font-weight: 550;}

    .body.or h5 {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .body.or h5 span {
        margin: 0 15px;
    }
    .body.or h5:before, .body.or h5:after {
        background: black;
        height: 2px;
        flex: 1;
        content: '';
    }
@media screen and (max-width: 768px) {
    .p-name-block {margin-right: 20px;}
}
@media screen and (max-width: 481px) {
    .small-screen .col-sm-12 {padding-left:0px;padding-right:0px}
    /* .new-product label {font-weight: normal;}
    .new-product label.s-l {font-size: 11px;} */
}
</style>

<?php
    if(Auth::user()->company->has_product_categories == 'no') {
        $display_none = "display-none";
    } else {
        $display_none = "";
    }
?>

<div class="row">
    <div class="col-md-12">
        <div class="card" style="box-shadow: none;">
            @if($data['from'] == "shop" || $data['from'] == "store")
            <div class="p-2 py-3">
                <a href="#" class="products-tab-opt py-1 pl-2"><b class="back-products"><i class="fa fa-arrow-left pr-2"></i> </b></a>  
                <span class="pr-2">|</span> <b><?php echo $_GET['new-product']; ?></b> 
            </div>
            @endif
            <div class="body px-3 pt-0 pb-1">

                <div class="row" style="background-color: #f9f6f2;"> 
                    @if($data['cats']->isEmpty())
                    <!-- <div class="col-12" style="margin-top: 15px;">
                        <span style="color: red;">Kabla ya kutengeneza bidhaa anza kutengeneza kategori/makundi ya bidhaa</span> <i class="fa fa-hand-o-right"></i> <b><a href="#" class="new-sub-category-form" data-toggle="modal" data-target="#addSCategory"><?php echo $_GET['create-category']; ?></a></b> <i class="fa fa-hand-o-left"></i> .. <i class="fa fa-hand-o-right"></i> <b><a href="#" data-toggle="modal" data-target="#howCreateProduct">Soma kuhusu kategori za bidhaa</a></b> <i class="fa fa-hand-o-left"></i>
                    </div> -->
                    @endif
                    <div class="col-md-12 my-4">
                        <form id="basic-form" class="new-product" enctype="multipart/form-data">
                            @csrf

                            @if($data['from'] == "shop")
                            <input type="hidden" name="from_shop" value="yes">
                            <input type="hidden" name="shop_id" value="{{$data['shop_id']}}">
                            @elseif($data['from'] == "store")
                            <input type="hidden" name="from_store" value="yes">
                            <input type="hidden" name="store_id" value="{{$data['store_id']}}">
                            @else
                            <input type="hidden" name="from_shop" value="no">
                            @endif 

                            <div class="row clearfix">
                                <div class="col-md-6 col-12 p-name-block">
                                    <div class="form-group">
                                        <label><?php echo $_GET['product-name']; ?>*</label>
                                        <input type="text" class="form-control" placeholder="" name="name" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-6" style="display:none">
                                    <div class="form-group">
                                        <label><?php echo $_GET['measurement']; ?>*</label>
                                        <select class="form-control form-control-sm" name="measurement" required>
                                            <!-- <option value="">- select -</option> -->
                                            @if($data['measurements'])
                                                @foreach($data['measurements'] as $measurement)
                                                    <option value="{{$measurement->id}}">{{$measurement->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-6" style="display: none;">
                                    <div class="form-group"> 
                                        <label><?php echo $_GET['main-category']; ?>*</label>
                                        <select class="form-control form-control-sm cgroup" name="cgroup">
                                            <option value="">- <?php echo $_GET['select']; ?> -</option>
                                            @if($data['groups'])
                                                @foreach($data['groups'] as $group)
                                                    <option value="{{$group->id}}">{{$group->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 <?php echo $display_none; ?>">
                                    <div class="form-group">
                                        <label><?php echo $_GET['product-category']; ?>*</label>
                                        <div class="input-group">
                                            <input type="hidden" name="pro-form" value="yes">
                                            <select class="custom-select pcategory select2" name="pcategory" id="inputGroupSelect04" style="width: 50%;" required>
                                            <?php if(Auth::user()->company->has_product_categories == 'no') { } else { ?>
                                                    <option value="" selected="">- <?php echo $_GET['select']; ?> -</option>
                                            <?php } ?>                                                
                                                @if($data['cats']->isNotEmpty())
                                                    @foreach($data['cats'] as $cat)
                                                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="px-2 pt-1"><?php echo $_GET['or']; ?></span>
                                            <div class="input-group-append">
                                                <span class="btn btn-secondary new-sub-category-form" data-toggle="modal" data-target="#addSCategory" style="margin-left: -1px;border-radius: .2rem !important;"><i class="fa fa-plus"></i> <?php echo $_GET['add']; ?> </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-6 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $_GET['buying-price']; ?></label>
                                        <input type="number" class="form-control" placeholder="0" step=".01" name="buying_price" required>
                                    </div>
                                </div>
                                <div class="col-4" style="display:none">
                                    <div class="form-group">
                                        <label class="s-l"><?php echo $_GET['wholesale-price']; ?></label>
                                        <input type="number" class="form-control" placeholder="0" step=".01" value="0" name="wholesale_price">
                                    </div>
                                </div>
                                <div class="col-6 col-md-6">
                                    <div class="form-group">
                                        <label class="s-l"><?php echo $_GET['selling-price']; ?></label>
                                        <input type="number" class="form-control" placeholder="0" step=".01" name="retail_price" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-6 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $_GET['available-quantity']; ?></label>
                                        <input type="number" class="form-control" placeholder="0" name="quantity" step=".01" required>
                                    </div>
                                </div>
                                <div class="col-6 col-md-6">
                                    <div class="form-group ex-date-b">
                                        <label>Expire date</label>
                                        <input type="text" name="expire_date" data-provide="datepicker" data-date-autoclose="true" class="form-control">
                                    </div>
                                    <div class="form-group min-stock-b">
                                        <label>Minimum stock level</label>
                                        <?php
                                        $min_level = "";
                                        if(Auth::user()->company->defaultStockLevel()) {
                                            $min_level = Auth::user()->company->defaultStockLevel()->min_stock_level + 0;
                                        } ?>
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
                            </div>
                            <div class="row clearfix">
                                <div class="col-12 col-md-6">
                                    <div class="form-group attach">
                                        <label><?php echo $_GET['attach-image']; ?> <small style="color: red;">(sio lazima)</small> </label>
                                        <input type="file" class="form-control p-img-input" name="image"  accept="image/*">
                                        <div class="p_image_preview">
                                            <img id="p_imgPreview" src="" name="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-4" style="display:none;">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control form-control-sm" name="status" required>
                                            <option value="published">Published</option>
                                            <option value="unpublished">Unpublished</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <?php $data['stores'] = $data['shops'] = ""; ?> <!-- aim of this is to hide the stores and shops error -->
                            <!-- <div class="mt-2">
                                <label>Quantity</label>
                                <blockquote>
                                    <div class="blockquote blockquote-primary">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Stores</label>
                                                    <select class="form-control form-control-sm select-store">
                                                        <option value="">- select -</option>
                                                        @if($data['stores'])
                                                            @foreach($data['stores'] as $store)
                                                                <option value="{{$store->id}}">{{$store->name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="render-store-q">
                                                    
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Shops</label>
                                                    <select class="form-control form-control-sm select-shop">
                                                        <option value="">- select -</option>
                                                        @if($data['shops'])
                                                            @foreach($data['shops'] as $shop)
                                                                <option value="{{$shop->id}}">{{$shop->name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="render-shop-q">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </blockquote>
                            </div> -->
                            <div class="row clearfix mt-1">
                                <div class="col-sm-12 mt-2">                       
                                    <button type="submit" class="btn btn-primary submit-new-product" style="width: inherit;">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-12">
                        
                        @if(Auth::user()->company->isImportingProducts())
                        <div class="body or">
                            <h5><span>OR</span></h5>
                        </div>
                        <div class="body">
                            <form id="basic-form" class="upload-products">
                                @csrf

                                @if($data['from'] == "shop")
                                <input type="hidden" name="shopstore" value="shop">
                                <input type="hidden" name="sid" value="{{$data['shop_id']}}">
                                @elseif($data['from'] == "store")
                                <input type="hidden" name="shopstore" value="store">
                                <input type="hidden" name="sid" value="{{$data['store_id']}}">
                                @endif
                                <div>
                                    <label>Import products in Excel format</label>
                                </div>
                                <div align="right" style="margin-top: -30px;">
                                    <a href="#" class="image-modal" url="/images/sample-excel.jpg"><span>Sample</span> <i class="fa fa-eye pl-1"></i></a>
                                    
                                </div>
                                <div class="mt-2">
                                    <input type="file" name="products_file" class="dropify" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>
                                </div>
                                <div>
                                    <button class="btn btn-info upload-products-btn mt-3 px-4">Upload <i class="fa fa-upload pl-1"></i></button>
                                </div>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<script src="{{ asset('vendor/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('js/pages/forms/dropify.js') }}"></script>
<script type="text/javascript">
    $('.select2').select2();

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