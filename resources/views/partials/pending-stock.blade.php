

        @if(!$data['pendingstock']->isEmpty())
        @foreach($data['pendingstock'] as $value)
            <tr>
                <td>
                    @if($value->shop_id)
                    {{$value->shop->name}}
                    @endif
                    @if($value->store_id)
                    {{$value->store->name}}
                    @endif
                    ( @if($value->shop_id) shop @endif
                      @if($value->store_id) store @endif )
                </td>                                     
                <td>
                    @if($value->shop_id)
                        <?php echo App\Http\Controllers\ProductController::stockQuantity('shop',$value->shop_id); ?>
                    @endif
                    @if($value->store_id)
                        <?php echo App\Http\Controllers\ProductController::stockQuantity('store',$value->store_id); ?>
                    @endif
                    
                </td>    
                <td>
                    {{$value->updated_at}}
                </td>
                <td>
                    @if($value->status == 'sent')
                        <span class="bg-warning px-1">Pending</span>
                    @endif
                </td>   
                <td>  
                    <a href="#" class="btn btn-info btn-sm viewStock" val="{{$value->id}}" edit="<?php if(Auth::user()->id == $value->user_id){echo "edit";} else {echo "cant edit";} ?>"><i class="fa fa-eye"></i></a>                        
                </td>
            </tr>
        @endforeach
        @else
        <tr class="empty-row"><td colspan="6" align="center"><i>-- No pending stock --</i></td></tr>
        @endif



        <script type="text/javascript">
        	
		    $(".viewStock").on('click', function(e) {
		        e.preventDefault();
		        $('.render-st-items2').html("");
		        $('#newStockView').modal('toggle');
		        var id = $(this).attr('val');
		        var edit = $(this).attr('edit');
		        if (edit == "edit") { 
		        	$('.edit-p-stock').css('display','');
		        	$('.submit-p-stock').css('display','none');
		        	$('.delete-p-stock').css('display','');
		        } else {
		        	$('.edit-p-stock').css('display','none');
		        	$('.delete-p-stock').css('display','none');
		        }
		        $.get('/new-stock/view/'+id, function(data){
		            $('.render-st-items2').append(data.items); 
		            $('.totalStQ').html(data.totalStQ);    
		            $('.destname2').html(data.whereto);  
		            $('.delete-p-stock').attr("delid",data.id);
		        });
		    });

		    $(".edit-p-stock").on('click', function(e) {
		        e.preventDefault();
		        $('.st-quantity').prop("disabled", false).focus();
		        $(this).css('display','none');
		        $('.submit-p-stock').css('display','');
		    });

		    $(".submit-p-stock").on('click', function(e) {
		        e.preventDefault();
		        location.reload(true);
		    });

		    $(".delete-p-stock").on('click', function(e) {
		        e.preventDefault();
		        if(confirm("Click OK to confirm that you delete this stock record")){
		            var id = $(this).attr('delid');
		            $.get('/new-stock/delete/'+id, function(data){
		                location.reload(true);  
		            });
		        }
		    });

		   
        </script>