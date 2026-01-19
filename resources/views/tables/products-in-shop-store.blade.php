
<?php 
if(Cookie::get("language") == 'en') {
    $_GET['b-p'] = "BP";
    $_GET['s-p'] = "SP";
    $_GET['show-more'] = "Show more";
    $_GET['no-products'] = "No products";
} else {
    $_GET['b-p'] = "BN";
    $_GET['s-p'] = "BU";
    $_GET['show-more'] = "Ona zaidi";
    $_GET['no-products'] = "Hakuna bidhaa";
}
?>

<?php
    $lastid = "";
    if(Auth::user()->company->has_product_categories == 'no') {
        $display_none = "display-none";
    } else {
        $display_none = "";
    }
    
    $msl = "";
    if(Auth::user()->company->defaultStockLevel()) {
        if(Auth::user()->company->defaultStockLevel()->status == "yes") {
            $msl = "yes";
        }
    }
?>
@if($data['products']->isNotEmpty()) 
@foreach($data['products'] as $value)    
 
    @if($data['from'] == "shop")
        <?php $av_q = sprintf('%g',$value->shopProductRelation($data['shop']->id)->quantity); ?>
    @elseif($data['from'] == "store")
        <?php $av_q = sprintf('%g',$value->storeProductRelation($data['store']->id)->quantity); ?>
    @endif
    <?php 
        $lastid = $value->id; 
        $q_s_color = "";
        if($msl == "yes") {
            if($value->min_stock_level >= $av_q) {
                $q_s_color = "about-finish";
                if($av_q <= 0) {
                    $q_s_color = "finished";
                }
            }
        }
    ?>
    <tr class="product-r product-details {{$q_s_color}}" pid="{{$value->id}}">
        @if($value->image) 
            <?php $src = '/images/companies/'.Auth::user()->company->folder.'/products/'. $value->image; ?>
        @else
            <?php  $src = "/images/product.jpg"; ?>
        @endif
        <td class="first-td">
            <span style="display:inline-flex;">
                <img src="{{ $src }}" class="avatar mr-2" alt="">
                <span style="display: inline-block;">
                    <b>{{$value->name}}</b> 
                    <small class="category <?php echo $display_none; ?>"><?php if ($value->productcategory) { echo $value->productcategory->name; } ?></small> 
                    @if(Auth::user()->isCEOorAdminorBusinessOwner())
                    <span style="display:block"><small><?php echo $_GET['b-p']; ?>/=</small> <b>{{str_replace(".00", "", number_format($value->buying_price, 2))}}</b></span> 
                    @endif
                    <span><small><?php echo $_GET['s-p']; ?>/=</small> <b>{{str_replace(".00", "", number_format($value->retail_price, 2))}}</b></span>
                </span>
            </span>
        </td>  
        <!-- <td>
            {{number_format($value->wholesale_price)}}
        </td> -->
        <!-- <td>
            {{number_format($value->retail_price)}}
        </td> -->
        <td>       
            {{$av_q}}
        </td>                                  
        <!-- <td>
            <?php
                if ($value->productcategory) {
                    echo $value->productcategory->name;
                    if ($value->productcategory->categorygroup) {
                        echo " (".$value->productcategory->categorygroup->name.")";
                    }
                }
            ?>    
        </td>  -->
        <td>
            <b><i class="fa fa-angle-right fa-2x"></i></b>
        </td>
    </tr>
@endforeach

@if(count($data['products']) == 15)
    <tr class="more-rows-btn">
        <td colspan="3" align="center">
            <div class="mt-3"><button class="btn btn-outline-info px-3 more-all-products" lastid="{{$lastid}}"><?php echo $_GET['show-more']; ?> </button></div>                                          
        </td>
    </tr>
@endif
@else 
<tr>     
    <td colspan="3" align="center">
        <b>-<?php echo $_GET['no-products']; ?>-</b>
    </td>
</tr>
@endif