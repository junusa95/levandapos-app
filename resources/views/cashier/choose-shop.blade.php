@extends('layouts.app')
@include("layouts.translater") 
 
@section('content')

<?php if (Session::get('Cashier')) { ?>
    
<?php } else { ?>

    <div class="modal fade" id="chooseShop2" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Select shop:</h4>
                </div>
                <div class="modal-body"> 
                	@if($data['shops']->isNotEmpty())
	                    @foreach($data['shops'] as $shop)
		                    <div class="mb-2">
		                        <a href="/cashier/{{$shop->shop_id}}" pagename="Cashier" class="text-center">
		                            <div class="body border border-success text-dark p-2" style="background:#9A9A9A">
		                                <?php echo \App\Shop::find($shop->shop_id)->name; ?> <i class="fa fa-arrow-right"></i>
		                            </div>
		                        </a>
		                    </div>
	                    @endforeach
	                @else
	                	<div style="text-align:center;">
	                		Sorry! it seems like you dont have permission to any shop.
	                	</div>
                    @endif
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-primary">SAVE CHANGES</button> -->
                    <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

@endsection

@section('js')
<script type="text/javascript">
    $(function () {
        $('#chooseShop2').modal('toggle');
    });
</script>
@endsection