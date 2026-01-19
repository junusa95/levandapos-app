
@include("layouts.translater") 

<?php 
if(Cookie::get("language") == 'en') { 
    $_GET['buying-p'] = "Buying price";
    $_GET['selling-p'] = "Selling price";
    $_GET['retail'] = "Retail";
    $_GET['wholesale'] = "Wholesale";
} else {
    $_GET['buying-p'] = "Ya kununulia";
    $_GET['selling-p'] = "Ya kuuzia";
    $_GET['retail'] = "Rejareja";
    $_GET['wholesale'] = "Jumla";
}   
?>

@if($data['ten-products']->isNotEmpty()) 
@foreach($data['ten-products'] as $value)
    <tr class="pr-{{$value->id}}">
        @if($value->image) 
            <?php $src = '/images/companies/'.Auth::user()->company->folder.'/products/'. $value->image; ?>
        @else
            <?php  $src = "/images/product.jpg"; ?>
        @endif
        <td class="first-td">
            <span class="outer-span">
                <img src="{{ $src }}" class="avatar mr-2" alt="">
                <span>
                    <a href="/products?opt=preview-product&pid={{ $value->id }}">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" style="width:15px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                        </svg> {{$value->name}}</a> <br> <small><?php if ($value->productcategory) { echo "(".$value->productcategory->name.")"; } ?></small>
                </span>
            </span>
        </td>                                 
        <td>
            <small><?php echo $_GET['buying-p']; ?>: </small>{{str_replace(".00", "", number_format($value->buying_price, 2))}} <br>
            <small><?php echo $_GET['selling-p']; ?>: </small>{{str_replace(".00", "", number_format($value->retail_price, 2))}}
        </td>    
        <!-- <td>
             {{number_format($value->retail_price)}}
        </td> -->
        <!-- <td>
            {{number_format($value->retail_price)}}
        </td> -->                                     
        <td>       
            @if($data['shopstore'] == 'all')
                {{ App\Http\Controllers\ProductController::totalQuantity($value->id) }} 
            @else 
                @if($data['shopstore'] == 'shop')
                    <?php echo sprintf('%g',$value->shopProductRelation($data['shop']->id)->quantity); ?>
                @endif
                @if($data['shopstore'] == 'store')
                    <?php echo sprintf('%g',$value->storeProductRelation($data['store']->id)->quantity); ?>
                @endif
            @endif
        </td>                                  
        <!-- <td> -->
            <?php
                // if ($value->productcategory) {
                //     echo $value->productcategory->name;
                //     if ($value->productcategory->categorygroup) {
                //         echo "<br> <small>(".$value->productcategory->categorygroup->name.")</small>";
                //     }
                // }
            ?>    
        <!-- </td>     -->
        <td style="display:none;">
            @if($value->status == 'published')
                <span class="badge badge-success">Published</span>
            @else
                <span class="badge badge-danger">Unpublished</span>
            @endif
        </td>   
        @if(Auth::user()->isCEOorAdmin())
        <td class="last-td">  
            <!-- <a href="/edit/products/{{ $value->id }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a> -->
            <a href="/products?opt=edit-product&pid={{ $value->id }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
            <a href="#" class="btn btn-danger btn-sm deleteProduct" val="{{$value->id}}" name="{{$value->name}}"><i class="fa fa-times"></i></a>
        </td>
        @endif
    </tr>
@endforeach

    <tr class="m-products <?php if($data['counts'] < 11) { echo 'displaynone'; } ?>">
        <td colspan="4">
            <button class="btn btn-sm px-4 btn-outline-info view-more-products"><?php echo $_GET['see-all']; ?> {{$data['counts']}} <i class="fa fa-angle-double-down pl-1"></i></button>
        </td>        
    </tr>

@else 
<tr>
    <td colspan="4" align="center">
        <i>-- No products --</i>
    </td>        
</tr>
@endif



<script type="text/javascript">

    $(".view-more-products").click(function(e){ 
        $('.m-products').html("<td colspan='4'>Loading...</td>");    
        e.preventDefault();
        var cats;
        $.get('/get-data/view-more-products/<?php echo $data["from"]; ?>', function(data) {
            $('.render-products').html(data.products);
        });   
    });
</script> 