
        <div class="modal fade" id="editExpense" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="title" id="largeModalLabel">Edit expense</h4>
                    </div>
                    <div class="modal-body"> 
                        <form id="basic-form" class="edit-expense-cost">
                            <input type="hidden" name="shop_id" value="{{$data['shop']->id}}">
                            <input type="hidden" name="row_id" value="">
                            <div class="row clearfix">
                                <div class="col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Expense</label>
                                        <select class="form-control eexpense select2" style="width:100%" name="expense_id" required>
                                            <option value="">- select -</option>
                                            @if($data['expenses'])
                                                @foreach($data['expenses'] as $expense)
                                                    <option value="{{$expense->id}}">{{$expense->name}}</option>
                                                @endforeach
                                            @else
                                                <option disabled><i>- no expense -</i></option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input type="number" class="form-control form-control-sm" name="eamount" placeholder="Amount" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="edescription" class="form-control" placeholder="Maelezo"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <button class="btn btn-primary" style="width: inherit;">Submit</button>
                                </div>
                            </div>
                        </form>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-primary">SAVE CHANGES</button> -->
                        <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>