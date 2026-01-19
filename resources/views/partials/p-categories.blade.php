
@include("layouts.translater") 

<style>
    .p-cats .cats-ss .c-outer {
        border-bottom: 1px solid #fff;padding: 0px;margin: 0px;padding-bottom: 2px;
    }
    .c-name-outer .c-name {line-height: 1.2;}
    .p-cats .cats-ss span:hover {
        cursor: pointer;
    }
    .p-cats .cats-ss span:hover i {
        transform: scale(1.5);
    }
    .p-cats .cats-ss .fa-times {
        font-size: 17px;
    }
    .edit-pcategory-btn {
        color: #007bff;
    }
    .delete-p-category {
        color: #dc3545;margin-left: 0.5rem !important;
    }
    .displaynone {display: none;}

    @media screen and (max-width: 550px) {
        .cats-ss span {
            padding: 3px;
        }
        .cats-ss {padding-left: 0px;padding-right: 5px;}
        .c-name-outer {padding-left: 3px;padding-right: 0px;}
        .c-name-outer .c-name b {display: none;}
        .p-cats .cats-ss .c-action {padding-left: 0px;padding-right: 0px;text-align: center;}
        .delete-p-category {
            margin-left: 0.2rem !important;
        }
    }

    @media screen and (max-width: 480px) {
        .cats-ss span i {font-size: 15px !important;}
        .cats-ss span .fa {font-size: 20px !important;}
    }

    @media screen and (max-width: 405px) {
        .cats-ss span i {font-size: 14px !important;}
        .cats-ss span .fa {font-size: 19px !important;}
        .cats-ss span {padding: 2px;}
        .delete-p-category {margin-left: 0.1rem !important;}
    }


</style>

<div class="row p-cats pt-2">
    @if($data['ten-cats'])
    <?php $num = 1; ?>
    @foreach($data['ten-cats'] as $value)
    <div class="col-6 mb-1 cats-ss">
        <div class="row c-outer">
            <div class="col-9 c-name-outer">
                <div class="c-name"><b>{{$num}}.</b> {{$value->name}} </div>
            </div>             
            <div class="col-3 c-action">
                <span class="edit-pcategory-btn" valid="{{$value->id}}"><i class="icon-pencil"></i></span>
                <span class="delete-p-category" val="{{$value->id}}" name="{{$value->name}}" gid="{{$value->product_category_group_id}}"><i class="fa fa-times"></i></span>
            </div>
        </div>
    </div>
        <!-- <tr>
            <td>
                {{$value->name}}
            </td> 
            @if(Auth::user()->isCEOorAdmin())
            <td>  
                <a href="#" class="btn btn-info btn-sm edit-pcategory-btn" valid="{{$value->id}}"><i class="fa fa-edit"></i></a>
                <button class="btn btn-sm btn-danger delete-p-category" val="{{$value->id}}" name="{{$value->name}}" gid="{{$value->product_category_group_id}}"><i class="fa fa-times"></i></button>
            </td>
            @endif
        </tr> -->
    <?php $num++; ?>
    @endforeach
    @else
        <div class="col-12" align="center">
            <div><i>Kahuna kategori</i> </div>
            <div><button class="btn btn-secondary btn-sm new-sub-category-form mt-2" data-toggle="modal" data-target="#addSCategory">Tengeneza kategori</button></div>
        </div>
    @endif

    <div class="col-12 mt-2 m-cats <?php if($data['counts'] < 11) { echo 'displaynone'; } ?>">
        <button class="btn btn-sm px-4 btn-outline-info view-more-cats"><?php echo $_GET['see-all']; ?> {{$data['counts']}} <i class="fa fa-angle-double-down pl-1"></i></button>
    </div>
</div>




<script type="text/javascript">

    $(".view-more-cats").click(function(e){ 
        $('.m-cats').html("<div class='pt-2'>Loading...</div>");    
        e.preventDefault();
        var cats;
        $.get('/get-data/view-more-cats/all', function(data) {
            $('.p-cats').html(data.cats);
        });   
    });
</script>