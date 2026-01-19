
<style>
    .select2-container .select2-selection--single{
        height:34px !important;
    }
    .select2-container--default .select2-selection--single{
        border: 1px solid #ccc !important; 
         border-radius: 0px !important; 
    }
    .pd-loader {
        position: absolute;background: rgb(60, 60, 60);opacity: 0.5; width: 100%;height: 100%;z-index: 91;text-align: center;padding-top: 100px;padding-bottom: 100px;display: none;
    }
    .pd-loader div {
        color: #fff;
    }
    .back-products {
        color: #007bff;padding-top: 3px;padding-bottom: 4px;
    }
    @media screen and (max-width: 595px) {
        .col-left-back {padding-left:0px !important;}
    }
</style>

<?php
if(Cookie::get("language") == 'en') {
    $_GET['cancel'] = "Cancel";
    $_GET['delete'] = "Delete";
    $_GET['remove'] = "Remove";
    $_GET['available-products'] = "Available Products";
    $_GET['dont-have-access-in-shop'] = '<div class="row clearfix"><div class="col-12"><div class="p-3"><i class="fa fa-warning text-warning" style="font-size:35px;"></i><h5>You dont have access in this shop, <br> <a href="/users/'.Auth::user()->id.'" style="text-decoration:underline">click here</a> to assign yourself a cashier or sale person role.</h5></div></div></div>';
} else {
    $_GET['available-products'] = "Bidhaa zilizopo";
    $_GET['dont-have-access-in-shop'] = '<div class="row clearfix"><div class="col-12"><div class="p-3"><i class="fa fa-warning text-warning" style="font-size:35px;"></i><h5>Hauna ruhusa kwenye hili duka, <br> <a href="/users/'.Auth::user()->id.'" style="text-decoration:underline">bonyeza hapa</a> kujipa ruhusa kwenye hili duka kama keshia au muuzaji wa kawaida.</h5></div></div></div>';
    $_GET['delete'] = "Futa";
    $_GET['cancel'] = "Sitisha";
    $_GET['remove'] = "Ondoa";
}
?>

<div class="row">
    <div class="col-md-12"> 
        <div class="card" style="box-shadow: none;">
            <div class="pd-loader">
                <div><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...</div>
            </div>
            <!-- <div class="p-2 py-3">
                <a href="#" class="products-tab"><b class="back-products"><i class="fa fa-arrow-left pr-2"></i> <?php echo $_GET["available-products"]; ?></b></a>  
            </div>  -->
            <div class="body px-1">
                <div class="form-group row ml-0 pro-review">
                    <div class="col-1 col-left-back" align="center">
                        <label class="pt-1">
                            <a href="#" class="products-tab-opt pb-2 pt-1"><b class="back-products px-3 pt-2 pb-2"><i class="fa fa-arrow-left"></i></b></a>
                        </label>
                    </div>
                    <div class="col-9">
                        <select name="pname" class="form-control select2 change-product" style="z-index: 999 !important;width:100%">
                            
                        </select>
                    </div>
                </div>
                <div class="row render-product-details">

                    @include("partials.product-details-store")

                </div>
            </div>
        </div> 
    </div>
</div>

<script>
    $('.select2').select2();

</script>