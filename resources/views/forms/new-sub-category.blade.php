
@include("layouts.translater") 

<form id="basic-form" class="new-pcategory">
    @csrf
    <div class="row clearfix">
        <div class="col-md-6" style="display: none;">
            <div class="form-group">
                <label><?php echo $_GET['choose-main-category']; ?></label>
                <select class="form-control form-control-sm" name="group">
                    @if($data['main-cat'])
                        <option value="{{$data['main-cat']->id}}">{{$data['main-cat']->name}}</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="col-md-6 offset-md-3">
            <div class="form-group">
                <label><?php echo $_GET['category-name']; ?></label>
                <div class="row">
                    <div class="col-sm-12 each-cat">
                        <input type="hidden" name="check" value="1">
                        <input type="text" class="form-control form-control-sm" placeholder="<?php echo $_GET['name']; ?>" name="name1" required> 
                    </div>     
                </div>                              
                <div class="col-sm-1 pull-right mt-2" style="margin-right:12px">
                    <button class="btn btn-outline-info btn-sm add-category" id="1">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix mt-2">
        <div class="col-sm-12">
            <button type="submit" class="btn btn-primary btn-sm submit-new-pcategory" style="width: inherit;">Submit</button>
        </div>
    </div>
</form>

<?php if(Cookie::get("language") == 'en') { ?>
    <!-- <p class="mt-3">For Fashion shops: <br> Example of main category is: <b>Clothes</b> <br> Where the sub-categories of Clothes are <b>Shirts, Trousers, Underwaer, </b>e.t.c</p> -->
<?php } else { ?>
    <!-- <p class="mt-3">Kwa maduka ya mavazi <br> Mfano wa kategori kuu ni: <b>Nguo</b> <br> Na kategori ndogo za Nguo ni: <b>Shati, Suruali, Chupi, </b>n.k</p> -->
<?php } ?>