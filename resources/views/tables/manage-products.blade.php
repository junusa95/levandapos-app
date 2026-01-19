
<?php
if(Cookie::get("language") == 'en') {
    $_GET['show-more'] = "Show more";
    $_GET['no-products'] = "No products";
} else {
    $_GET['show-more'] = "Ona zaidi";
    $_GET['no-products'] = "Hakuna bidhaa";
}
?>

<?php
    $lastid = "";
?>

@if($data['from'] == "shop")
<!-- manage products in shop  -->

    @if($data['products']->isNotEmpty())
        @foreach($data['products'] as $p) 
        <?php $lastid = $p->id; ?>
            <tr>
                <td class="first-td-m">
                    <div>{{$p->name}}</div>
                </td>
                <td>
                    @foreach($data['shops'] as $s)
                    <?php 
                    $check = \DB::table('shop_products')->where('product_id',$p->id)->where('shop_id',$s->id)->where('active','yes')->first();
                    ?>
                    <label><span>{{$s->name}}</span> <input type="checkbox" name="shopp{{$p->id}}[]" value="{{$s->id}}" class="shopp{{$p->id}} ml-1" style="display:inline-block" <?php if($check) {echo 'checked';} ?>></label> <br>
                    @endforeach
                </td>
                <td>
                    <button class="btn btn-success update-m-p" pid="{{$p->id}}"><i class="fa fa-check"></i></button>
                </td>
            </tr>
        @endforeach

        @if(count($data['products']) == 15)
            <tr class="more-rows-btn">
                <td colspan="3" align="center">
                    <div class="mt-3"><button class="btn btn-outline-success px-3 more-manage-products" lastid="{{$lastid}}"><?php echo $_GET['show-more']; ?> </button></div>                                          
                </td>
            </tr>
        @endif
    @else 
        <tr>
            <td align="center" colspan="3">- <?php echo $_GET['no-products']; ?> -</td>
        </tr>
    @endif
    
@else
<!-- manage products in store  -->

    @if($data['products']->isNotEmpty())
    @foreach($data['products'] as $p) 
    <?php $lastid = $p->id; ?>
        <tr>
            <td class="first-td-m">
                <div>{{$p->name}}</div>
            </td>
            <td>
                @foreach($data['stores'] as $s)
                <?php $check = \DB::table('store_products')->where('product_id',$p->id)->where('store_id',$s->id)->where('active','yes')->first(); ?>
                <label><span>{{$s->name}}</span> <input type="checkbox" name="storee{{$p->id}}[]" value="{{$s->id}}" class="storee{{$p->id}} ml-1" style="display:inline-block" <?php if($check) {echo 'checked';} ?>></label> <br>
                @endforeach
            </td>
            <td>
                <button class="btn btn-success update-m-p" pid="{{$p->id}}"><i class="fa fa-check"></i></button>
            </td>
        </tr>
    @endforeach

    @if(count($data['products']) == 15)
        <tr class="more-rows-btn">
            <td colspan="3" align="center">
                <div class="mt-3"><button class="btn btn-outline-success px-3 more-manage-products" lastid="{{$lastid}}"><?php echo $_GET['show-more']; ?> </button></div>                                          
            </td>
        </tr>
    @endif
    @else 
    <tr>
        <td align="center" colspan="3">- <?php echo $_GET['no-products']; ?> -</td>
    </tr>
    @endif

@endif
