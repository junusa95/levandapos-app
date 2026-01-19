
    @if($data['CEOs'])
        <div class="header">
            <h2>CEO of the Company:</h2>
        </div>
        <div class="body">
            <div class="table-responsive">
                <table class="table table-hover m-b-0 c_list">
                    <thead>
                        <tr>
                            <th>Name</th>                                    
                            <th>Phone</th>                                    
                            <th>Email</th>                                   
                            <th>Gender</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                        <tbody>
                        @foreach($data['CEOs'] as $value)
                        <tr>
                            <td>
                                <img src="{{ asset('images/xs/avatar1.jpg') }}" class="rounded-circle avatar" alt="">
                                <p class="c_name">{{$value->name}}</p>
                            </td>
                            <td>
                                <span class="phone"><i class="fa fa-phone fa-lg m-r-10"></i>{{$value->phone}}</span>
                            </td>                                   
                            <td>
                                {{$value->email}}
                            </td>                                   
                            <td>
                                {{$value->gender}}
                            </td>
                            <td>                                            
                                <button type="button" class="btn btn-info btn-sm edit-user" title="Edit"><i class="fa fa-edit"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="header">
            <h2>Add Business Owner of the Company:</h2>
        </div>
        <div class="body">
            <form id="basic-form" class="new-user">
                @csrf
                <div class="row clearfix">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Full name</label>
                            <input type="text" class="form-control" placeholder="Full Name" name="name" required>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Phone number</label>
                            <input type="text" class="form-control" placeholder="Phone" name="phone" required>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Gender</label>
                            <select class="form-control show-tick" name="gender" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" placeholder="Enter Your Email" name="email" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" class="form-control" placeholder="Password" name="password" required>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Attach roles</label>
                            <br/>
                            @foreach(\App\Role::where('name','=','Business Owner')->get() as $value)
                            <label class="fancy-checkbox">
                                <input type="checkbox" name="roles[]" value="{{$value->id}}" checked required data-parsley-errors-container="#error-checkbox">
                                <span>{{$value->name}}</span>
                            </label>
                            @endforeach
                            <p id="error-checkbox"></p>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary px-5 submit-new-user">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    @endif