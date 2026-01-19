

@if($data['cats']->isNotEmpty())
    @foreach($data['cats'] as $value)
    <tr>
        <td>
            {{$value->name}}
        </td> 
        <td>
            <a href="#" class="view-products-of-category" cid="{{$value->id}}" cname="{{$value->name}}" style="text-decoration: underline;">{{$value->totalProductsCreated()}}</a>
        </td>
        @if(Auth::user()->isCEOorAdmin())
        <td>  
            <a href="#" class="btn btn-info btn-sm edit-pcategory-btn" cid="{{$value->id}}" cname="{{$value->name}}"><i class="fa fa-edit"></i></a>
            <button class="btn btn-sm btn-danger delete-p-category" cid="{{$value->id}}" cname="{{$value->name}}"><i class="fa fa-times"></i></button>
        </td>
        @endif
    </tr>
    @endforeach
    @else
    <tr>
        <td colspan="3">
            <div align="center">
                <div><i>Kahuna kategori</i> </div>
                <div><button class="btn btn-secondary btn-sm new-sub-category-form mt-2" data-toggle="modal" data-target="#addSCategory">Tengeneza kategori</button></div>
            </div>
        </td>
    </tr>
    @endif                    