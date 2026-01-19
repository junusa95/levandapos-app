

    @if($data['measurements'])
    @foreach($data['measurements'] as $value)
        <tr>
            <td class="mrname{{$value->id}}">
                {{$value->name}}
            </td>                                 
            <td class="mrsymbol{{$value->id}}">
                {{$value->symbol}}
            </td>   
            @if(Auth::user()->isCEOorAdmin())
            <td>  
                <a href="#" class="btn btn-info btn-sm edit-measurement-btn" valid="{{$value->id}}"><i class="fa fa-edit"></i></a>
            </td>
            @endif
        </tr>
    @endforeach
    @endif