

    @if($data['items'])
        @foreach($data['items'] as $item)
            <tr class="ptr-{{$item->id}}">
                <td>{{$item->product->name}}</td>
                <td>{{sprintf('%g',$item->quantity)}}</td>  
                <td>
                    <span class="p-1 text-danger remove-item" val="{{$item->id}}" style="cursor: pointer;"><i class="fa fa-times"></i></span>
                </td>
            </tr>
        @endforeach
    @endif