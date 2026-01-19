
@if($transfers)
<?php 
	for ($i=0; $i < count($transfers); $i++) { 
		for ($j=0; $j < count($transfers[$i]); $j++) {  
			if ($transfers[$i][$j]->from == $from && $transfers[$i][$j]->from_id == $sid) { ?>
            <div class="card top_counter px-3 pb-2">
                <!-- <div class="icon"><i class="fa fa-university"></i> </div> -->
                <div class="content" style="text-align: right;">
                    <div class="text">
                    	@if($transfers[$i][$j]->destination == 'store')
                    		{{$transfers[$i][$j]->dstore->name}}
                    	@else
                    		{{$transfers[$i][$j]->dshop->name}}
                    	@endif
                    </div>
                    <h5 class="number mt-1">
                        <i class="fa fa-arrow-circle-o-up" style="font-size:1.2rem"></i>
                        <span class="ml-1 mr-3">
                        	<?php echo App\Http\Controllers\TransferController::quantity_transfered_individual($time,$from,$sid,$transfers[$i][$j]->destination,$transfers[$i][$j]->destination_id); ?>
                        </span>
                    </h5>
                </div>
            </div>
        <?php 
        	}
        	if ($transfers[$i][$j]->destination == $from && $transfers[$i][$j]->destination_id == $sid) { ?>
            <div class="card top_counter px-3 pb-2">
                <!-- <div class="icon"><i class="fa fa-university"></i> </div> -->
                <div class="content" style="text-align: left;">
                    <div class="text">
                    	@if($transfers[$i][$j]->from == 'store')
                    		{{$transfers[$i][$j]->fstore->name}}
                    	@else
                    		{{$transfers[$i][$j]->fshop->name}}
                    	@endif
                    </div>
                    <h5 class="number mt-1">
                        <i class="fa fa-arrow-circle-o-down ml-2" style="font-size:1.2rem"></i>
                        <span class="ml-1">
                        	<?php echo App\Http\Controllers\TransferController::quantity_transfered_individual($time,$transfers[$i][$j]->from,$transfers[$i][$j]->from_id,$from,$sid); ?>
                        </span>
                    </h5>
                </div>
            </div>
	<?php	
			}
		}	
	}
 	?>
	
@else
	<div></div>
@endif