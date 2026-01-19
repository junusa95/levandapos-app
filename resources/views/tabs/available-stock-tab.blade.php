


@include("layouts.translater") 

<div class="row">
    <div class="col-md-8 offset-md-2 p-0" style="background-color: #f0f0f0;">
            <div class="header" style="background-color: #f9f6f2;height: 90px;">
                <!-- <h2>Available stock</h2> -->
                <ul class="header-dropdown">
                    <li>
                        <b><?php echo $_GET['shop-store']; ?>:</b>
                        <select class="form-control-sm change-shopstore" name="shopstore" style="">
                            <option value="all">All</option>
                            <option class="bg-success text-light" disabled>-- Shops</option>
                            @if($data['shops'])
                            @foreach($data['shops'] as $shop)
                                <option value="shop-{{$shop->id}}">{{$shop->name}}</option>
                            @endforeach
                            @endif
                            <option class="bg-success text-light" disabled>-- Stores</option>
                            @if($data['stores'])
                            @foreach($data['stores'] as $store)
                                <option value="store-{{$store->id}}">{{$store->name}}</option>
                            @endforeach
                            @endif
                        </select>
                        <p style="padding: 10px 0px;">
                            <span class="wrds">Total quantities:</span>
                            <span class="bg-dark text-light px-2 py-1 ml-2 totalQty"></span>
                        </p>
                    </li>
                </ul>
            </div>                                                      
            <div class="body pt-0">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table m-b-0 c_list">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                                <tbody class="render-quantities">

                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>
</div>



<script type="text/javascript">
    $(function () {
        $('.change-shopstore').change();
    });
    
    $(document).on('change','.change-shopstore',function(e){
        e.preventDefault();
        var shopstore = $(this).val();
        
        $('.render-quantities').html('<tr><td colspan="3">Loading...</td></tr>');
        $.get('/report/stockR/'+shopstore+'/available', function(data){ 
            $('.totalQty').html(parseFloat(data.data.totalQty));
            $('.render-quantities').html("");
            if (shopstore == "all") {
                $('.ssTitle').html("All Locations:");
            } else {
                if (data.data.shopstore == "shop") {
                    $('.ssTitle').html(data.data.shop.name+":");
                }
                if (data.data.shopstore == "store") {
                    $('.ssTitle').html(data.data.store.name+":");
                }
            }
            var num = 0;
            var temp = [];
            $.each(data.quantities, function(key, value) {
                temp.push({v:value, k: key});
            });
            temp.sort(function(a,b){
               if(a.v < b.v){ return 1}
                if(a.v > b.v){ return -1}
                  return 0;
            });
            $.each(temp, function(key, obj) {
                num = key+1;
                $('.render-quantities').append('<tr><td>'+num+'</td><td>'+obj.k+'</td><td>'+parseFloat(obj.v)+'</td></tr>');
                   
            });
        });
    });
</script>