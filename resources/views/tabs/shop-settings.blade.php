

@include("layouts.translater")


<div class="row clearfix">
    <div class="col-lg-12 col-md-12">
        <div class="card">      
            <div class="header" style="border-bottom: 1px solid #ddd;">
                <h2 class="pl-1" style="display: inline-block;"><b>Settings:</b></h2>
                <ul class="header-dropdown">
                    <li>
                        <button class="btn btn-success btn-sm refresh-page" style="display: none;">Submit changes <i class="fa fa-check" style="color: #fff;"></i></button>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div>
                    <?php echo $_GET['sell-by-order']; ?> ? 
                    <label class="mr-2 ml-4"> <input type="radio" name="sell-order" value="yes" <?php if($data['shop']->sell_order == "yes") { echo "checked"; }  ?>> <?php echo $_GET['yes']; ?> </label>
                    <label> <input type="radio" name="sell-order" value="no" <?php if($data['shop']->sell_order != "yes") { echo "checked"; }  ?>> <?php echo $_GET['no']; ?> </label>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).on('click', 'input[type=radio][name=sell-order]', function() {
        $('.refresh-page').css('display','block');
        $.get('/get-data/change-sell-order/<?php echo $data['shop']->id; ?>/'+this.value, function(data){
            if (data.status == 'success') {
                if (data.val == 'yes') {
                    popNotification('success',"Sell by order is enabled successfully.");
                }
                else if (data.val == 'no') {
                    popNotification('success',"Sell by order is disabled successfully.");
                }
            }
        });
    });
    
    $(document).on('click', '.refresh-page', function() {
        window.location.reload();
    });
</script>