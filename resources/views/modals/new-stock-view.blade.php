

<div class="modal fade" id="newStockView" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">View Stock</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
	            <form id="basic-form" class="new-stock">
	                @csrf

                    <div class="row">
                        <div class="col-12 mb-2">
                            Stock sent to <span class="bg-secondary text-light px-2 pb-1 ml-2 destname2" style="padding-top: 2px;"></span>
                        </div>
                    </div>
	                
                	<div class="row">
                		<div class="col-12">
                			<div class="table-responsive">
                				<table class="table">
                					<thead>
                						<tr>
                							<th>Product</th>
                							<th>Quantity</th>
                							<th></th>
                						</tr>
                					</thead>
                					<tbody class="render-st-items2">

                					</tbody>
                                    <tbody>
                                        <tr>
                                            <td>Total</td>
                                            <td class="totalStQ">0</td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                				</table>
                			</div>
                		</div>
                	</div>
	               
	                <div class="row clearfix">
	                    
	                </div>
	            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary edit-p-stock">Edit <i class="fa fa-edit"></i></button>
                <button type="button" class="btn btn-success submit-p-stock" style="display:none;">Done <i class="fa fa-check"></i></button>
                <button type="button" class="btn btn-danger delete-p-stock" val="delete">Detete <i class="fa fa-times"></i></button>
            </div>
        </div>
    </div>
</div>