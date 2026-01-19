

<div class="modal fade" id="newStore" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Create new store</h4>
                <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9;">
                    <button class="btn btn-danger btn-sm">x</button>
                </span>
            </div>
            <div class="modal-body"> 
                <form id="basic-form" class="new-store">
                    @csrf 
                    <div class="check-location-level">
                        
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Store Name</label>
                                <input type="text" class="form-control" placeholder="Name" name="name" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Location</label>
                                <input type="text" class="form-control" placeholder="Location" name="location" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Store Master</label>
                                <select class="form-control form-control-sm" name="user">
                                    @if($data['users'])
                                        <option value="">- none -</option>
                                    @foreach($data['users'] as $user)
                                        <option value="{{$user->id}}">{{$user->username}}</option>
                                    @endforeach
                                    @else
                                        <option>- none -</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary submit-new-store" style="width: inherit;">Submit</button>
                        </div>
                    </div>
                </form>
            </div>            
        </div>
    </div>
</div>