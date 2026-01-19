<style>
    
    .search-block-outer {
            position: relative;
        }
        .search-block2 {
            position: absolute;width: 100%;z-index: 999;background: white;padding: 0px;display: none;
            border: 1px solid #ced4da;box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        }
        .search-block2 .searched-item {
            float: left; width: 100%;
        }
        .search-block2 .searched-item:hover {
            background: #efefef;cursor: pointer;text-decoration: underline;
        }
</style>

<div class="modal fade" id="returnSoldItems" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title titless" id="largeModalLabel">Return Sold Item(s)</h4>
            </div>
            <div class="modal-body"> 
                <p class="text-warning bg-secondary p-1" align="center"><b>Zingatia:</b> Tumia hapa ikiwa bidhaa iliyorudishwa haijauzwa leo. Iwe iliuzwa siku zilizopita. Kama ni bidhaa iliyouzwa leo unaweza kufuta mauzo yake kupitia ukurasa unaoonesha vitu vilivyouzwa siku ya leo.</p>
                <form id="basic-form" class="returned-items-form">
                    @csrf
                    <input type="hidden" name="shopid" value="{{$data['shop']->id}}">
                    <input type="hidden" name="today" class="today" value="<?php echo date('d/m/Y'); ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label style="margin-bottom: 1px;">Item name</label>
                                <input type="text" class="form-control form-control-sm search-product22" placeholder="Search" name="pname" autocomplete="off">
                                <div class="search-block-outer">
                                    <div class="search-block2" id="search-block2">
                                      
                                    </div>
                                </div>                       
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label style="margin-bottom: 1px;">Date sold</label>
                                <input type="text" name="date_sold" data-provide="datepicker" data-date-autoclose="true" class="form-control date-sold" placeholder="From" value="<?php echo date('d/m/Y'); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-12 col-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-borderless m-b-0 c_list">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Name</th>
                                            <th style="width: 120px;">Quantity</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="returned-items">
                                        <tr><td></td></tr>
                                    </tbody>
                                    <tbody class="total-row">
                                        <tr>
                                            <td>Total</td>
                                            <td class="totalQr">0</td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="mt-2" style="border-bottom: 1px solid #ddd;"></div>
                                <div class="mt-3" align="center">
                                    <i class="fa fa-spinner fa-spin" style="font-size:20px;display: none;"></i>
                                    <button class="btn btn-success btn-sm submit-ri-cart" style="width: 50%;">Submit <i class="fa fa-check"></i></button>
                                </div>
                            </div>
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