
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
    /* .edit-pcategory-btn {
        color: #007bff;
    }
    .delete-p-category {
        color: #dc3545;margin-left: 0.5rem !important;
    } */
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

<div class="row">
    <div class="col-12 pl-0 pr-0 reduce-padding">
        <div class="header">
            <h2><?php echo $_GET['products-categories']; ?></h2>
            @if(Auth::user()->isCEOorAdminorBusinessOwner())
            <ul class="header-dropdown">
                <li>
                    <button class="btn btn-info btn-sm new-sub-category-form" data-toggle="modal" data-target="#addSCategory">
                        <b><?php echo $_GET['add-category']; ?></b>
                    </button>
                </li>
            </ul>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th><?php echo $_GET['name']; ?></th>
                        <th><?php echo $_GET['products-menu']; ?></th>
                        @if(Auth::user()->isCEOorAdmin())
                        <th><?php echo $_GET['action']; ?></th>
                        @endif
                    </tr>
                </thead>
                <tbody class="render-pro-categories" style="background-color: #f4f7f6;">

                </tbody>
            </table>
        </div>
    </div>
</div>




<script type="text/javascript">

    $(document).ready(function(){        
        renderProductCategories();
    });

    $(document).on('click','.view-products-of-category',function(e){
        e.preventDefault();
        var cid = $(this).attr('cid');
        var cname = $(this).attr('cname');
        
        $('.notification-body').html('<div class="row mb-2" align="left"><div class="col-md-10 offset-md-1"><h6 class="mb-3"><?php echo $_GET["products-created-under"]; ?> '+cname+'</h6>'+
                    '<div class="col-12 pl-0 pr-0 mt-5">'+
                        '<div class="my-5"><ol class="render-products-of-category"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...</ol><div>'+
                    '</div></div>');
        
        $('#notificationModal').modal('toggle');
        
        $.get("/get-data/products-of-category/"+cid, function(data){
            if(data.status == "available") {
                $('.render-products-of-category').html(data.items);
            } else {
                $('.render-products-of-category').html('<div><td colspan="4" align="center"><i>-- <?php echo $_GET["no-product-created"]; ?> --</i></td></div>');
            }                
        });
    });
    
    function renderProductCategories() {
        $('.render-pro-categories').html('<tr><td align="center" colspan="2"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...</td></tr>');
        
        $.get("/get-data/product-categories/all", function(data){
            $('.render-pro-categories').html(data.pcategories);        
        });         
    }    
</script>