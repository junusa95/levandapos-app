
@include("layouts.translater") 

<style>
    .displaynone {
        display: none;
    }
</style>

<div class="row" style="background-color: #f9f6f2;">
    <div class="col-md-8 offset-md-2 pb-4">
        <form id="basic-form" class="new-stock">
            @csrf
            <?php $stoshop = ""; ?>
            @if(Session::get('role') == 'Store Master')
                <!-- <input type="hidden" name="from" value="store">
                <input type="hidden" name="storeid" value="{{$data['store']->id}}"> -->
                <?php //$stoshop = "store"; ?>
            @elseif(Session::get('role') == 'Cashier')
                <!-- <input type="hidden" name="from" value="shop">
                <input type="hidden" name="shopid" value="{{$data['shop']->id}}"> -->
                <?php //$stoshop = "shop"; ?>
            @endif
            @if(Auth::user()->isCEOorAdmin())
                <input type="hidden" name="from" value="ceo">
                <input type="hidden" name="shopid" value="0">
                <input type="hidden" name="storeid" value="0">
                <?php $stoshop = "ceo"; ?>
            @endif
            <div class="row clearfix" style="background-color: #f0f0f0;border-bottom: 1px solid #ddd;">
                @if(Auth::user()->isCEOorAdmin())
                <div class="col-6 offset-6 mt-1">
                    <div class="form-group">
                        <label class="mb-1"><?php echo $_GET['choose-shop-store']; ?></label>
                        <select class="form-control form-control-sm shopstore22" name="shopstore" required>
                            <!-- <option value="">- select -</option> -->
                            <option value="" class="bg-success text-light" disabled>-- <?php echo $_GET['shops']; ?></option>
                            @if($data['shops'])
                                @foreach($data['shops'] as $shop)
                                    <option value="shop-{{$shop->id}}">{{$shop->name}}</option>
                                @endforeach
                            @else
                                <option disabled><i>- null -</i></option>
                            @endif
                            <option value="" class="bg-success text-light" disabled>-- <?php echo $_GET['stores']; ?></option>
                            @if($data['stores'])
                                @foreach($data['stores'] as $store)
                                    <option value="store-{{$store->id}}">{{$store->name}}</option>
                                @endforeach
                            @else
                                <option disabled><i>- null -</i></option>
                            @endif
                        </select>
                        <input type="hidden" name="whereto" value="">
                        <input type="hidden" name="shostoval" value="">
                    </div>
                </div>
                @endif
            </div>
            <div class="row clearfix">
                <div class="col-12 col-sm-6 mt-2">
                    <div class="form-group">
                        <label class="mb-0"><?php echo $_GET['choose-product']; ?></label>
                        <input type="text" class="form-control form-control-sm search-product" placeholder="Search" check="stock" stoshop="{{$stoshop}}" name="pname" autocomplete="off">
                        <div class="search-block-outer">
                            <div class="search-block">
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(Auth::user()->isCEOorAdmin())
            <div class="row" style="display:none">
                <div class="col-12 mb-2">
                    {{$stoshop}}<?php echo $_GET['adding-stock-to']; ?> <span class="bg-secondary text-light px-2 pb-1 ml-2 destname" style="padding-top: 2px;"></span>
                </div>
            </div>
            @endif
            
            <div class="row" style="margin-top:-5px">
                <div class="col-12 mt-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th><?php echo $_GET['item-name']; ?></th>
                                    <th><?php echo $_GET['quantity-full']; ?></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="render-nst-items">

                            </tbody>
                            <tbody>
                                <tr>
                                    <td><?php echo $_GET['total']; ?></td>
                                    <td class="totalStQ">0</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        
            <div class="row <?php if(Auth::user()->company->cashier_stock_approval == 'no') { echo 'displaynone'; }  ?>" style="margin-top: -5px;">
                <div class="col-12">
                    <div class="form-group">
                        <label><?php echo $_GET['is-cashier-checkup-required']; ?> ?</label><a href="#" class="ml-2 cashier-checkup-guide"><?php echo $_GET['read']; ?></a><br>
                        <label class="fancy-radio">
                            <input type="radio" name="approvalRequired" value="yes" required="" data-parsley-errors-container="#error-radio" data-parsley-multiple="approvalRequired" <?php if(Auth::user()->company->cashier_stock_approval != "no") { echo "checked"; }  ?>>
                            <span><i></i><?php echo $_GET['yes']; ?></span>
                        </label>
                        <label class="fancy-radio">
                            <input type="radio" name="approvalRequired" value="no" required="" data-parsley-errors-container="#error-radio" data-parsley-multiple="approvalRequired" <?php if(Auth::user()->company->cashier_stock_approval == "no") { echo "checked"; }  ?>>
                            <span><i></i><?php echo $_GET['no']; ?></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary submit-new-stock" style="width: inherit;">Submit</button>
                </div>
            </div>

            <!-- <div class="row mt-4 pl-2">
                <a href="/stock?tab=previous-stock-records" style="text-decoration: underline;text-underline-offset:2px"><i class="fa fa-arrow-right mr-2"></i><?php echo $_GET['previous-stock-records']; ?></a>
            </div> -->
        </form>
    </div>
</div>


    @include('modals.read-guide')


<script type="text/javascript">
 
    $(function () {
        $('.sold-products, .render-nst-items').prepend('<tr class="asloader"><td><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i> Rendering...</td></tr>');
        $('.received-stock').html('<tr class="asloader2"><td><i class="fa fa-spinner fa-spin" style="font-size:15px;"></i> Rendering...</td></tr>');
        
        $.get('/get-data/pending-stock/0', function(data) {  
            $('.asloader').hide(); 
            $('.render-nst-items').html("");
            $('.render-nst-items').append(data.items);
            $('.totalStQ').html(data.totalStQ);  
            if (data.destid) {
                $('.shopstore22').val(data.destid).change();
            } else {
                $(".shopstore22").change();
            }           
            $('.destname').html(data.whereto);    
        });   
    });

    $(".shopstore22").on('change', function(e) {
        e.preventDefault();
        $('.full-cover').css('display','block');
        $('.full-cover .inside').html('wait...');
        var shopstoreval = $(this).val();
        if(shopstoreval) {
            var shostoname = $(this).find('option:selected').text();
            var split = shopstoreval.split("-");
            var whereto = split[0]; 
            shopstoreval = split[1];
            $.get('/shopstore/ceo/0/'+whereto+'/'+shopstoreval, function(data){
                $('.full-cover').css('display','none');
                $('.new-stock [name="whereto"]').val(whereto);  
                $('.new-stock [name="shostoval"]').val(shopstoreval);  
                $('.destname').html(shostoname+' ('+whereto+')');  
            });
        } else {
            $('.full-cover').css('display','none');
        }
    });

    $(document).on('click','.cashier-checkup-guide', function(e) {
        e.preventDefault();
        var guide = "<?php if(Cookie::get('language') == 'en') { echo 'Select <b>YES</b> if you want this added stock to be reviewed and approved/received by cashier/store-master first before updating their existing stock <br><br> Select <b>NO</b> if you want this stock to update the existing stock direct without notifying cashier/store-master'; } else { echo 'Bonyeza <b>NDIO</b> kama unataka hii stock unayoiongeza ipitie kwa keshia kwanza, akishaipokea kwenye system ndio iende ikaongeze idadi kwenye stock yake  <br><br> Bonyeza <b>HAPANA</b> kama unataka hii stock unayoiongeza iende ikaongeze idadi moja kwa moja bila kumjulisha keshia/stoo-masta'; } ?>";
        $('.read-guide-body').html(guide);
        $('#readGuide').modal('toggle');
    });

</script>