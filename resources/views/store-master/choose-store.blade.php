@extends('layouts.app')

@section('content')

<?php if (Session::get('Store Master')) { ?>
    
<?php } else { ?>

    <div class="modal fade" id="chooseStore2" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Select store:</h4>
                </div>
                <div class="modal-body"> 
                	@if($data['stores']->isNotEmpty())
	                    @foreach($data['stores'] as $store)
		                    <div class="mb-2">
		                        <a href="/store-master/{{$store->store_id}}" pagename="Store Master" class="text-center">
		                            <div class="body border border-success text-dark p-2" style="background:#9A9A9A">
		                                <?php echo \App\Store::find($store->store_id)->name; ?> <i class="fa fa-arrow-right"></i>
		                            </div>
		                        </a>
		                    </div>
	                    @endforeach
	                @else
	                	<div style="text-align:center;">
	                		Sorry! it seems like you dont have permission to any store.
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
        $('#chooseStore2').modal('toggle');
    });
</script>
@endsection