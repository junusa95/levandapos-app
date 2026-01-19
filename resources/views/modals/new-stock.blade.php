

<div class="modal fade" id="newStock" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">New Stock</h4>
            </div>
            <div class="modal-body"> 
                <form id="basic-form" class="new-stock">
                    @csrf
                    @if(Session::get('role') == 'Store Master')
                        <input type="hidden" name="from" value="store">
                        <input type="hidden" name="storeid" value="{{$data['store']->id}}">
                        <?php $stoshop = "store"; ?>
                    @elseif(Session::get('role') == 'Cashier')
                        <input type="hidden" name="from" value="shop">
                        <input type="hidden" name="shopid" value="{{$data['shop']->id}}">
                        <?php $stoshop = "shop"; ?>
                    @elseif(Auth::user()->isCEOorAdmin())
                        <input type="hidden" name="from" value="ceo">
                        <input type="hidden" name="shopid" value="0">
                        <input type="hidden" name="storeid" value="0">
                        <?php $stoshop = "ceo"; ?>
                    @endif
                    <div class="row clearfix">
                        @if(Auth::user()->isCEOorAdmin())
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>To shop/store</label>
                                <select class="form-control shopstore" name="shopstore" required>
                                    <option value="">- select -</option>
                                    <option class="bg-success text-light" disabled>-- Shops</option>
                                    @if($data['shops'])
                                        @foreach($data['shops'] as $shop)
                                            <option value="shop-{{$shop->id}}">{{$shop->name}}</option>
                                        @endforeach
                                    @else
                                        <option disabled><i>- null -</i></option>
                                    @endif
                                    <option class="bg-success text-light" disabled>-- Stores</option>
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
                        <div class="col-sm-6">
                            @if(Auth::user()->isCEOorAdmin())
                            <div class="form-group">
                                <label>Product name</label>
                                <input type="text" class="form-control form-control-sm search-product" placeholder="Search" check="stock" stoshop="{{$stoshop}}" name="pname" autocomplete="off">
                                <div class="search-block-outer">
                                    <div class="search-block">
                                      
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    @if(Auth::user()->isCEOorAdmin())
                    <div class="row">
                        <div class="col-12 mb-2">
                            Adding stock to <span class="bg-secondary text-light px-2 pb-1 ml-2 destname" style="padding-top: 2px;"></span>
                        </div>
                    </div>
                    @endif
                    
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
                                    <tbody class="render-st-items">

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
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary submit-new-stock" style="width: inherit;">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-primary">SAVE CHANGES</button> -->
                <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>