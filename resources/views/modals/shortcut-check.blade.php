

<div class="modal fade" id="shortcutCheck" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom:1px solid #ddd;">
                <h4 class="title shortcut-tittle" id="largeModalLabel"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color:red">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <!-- user dont assigned to any shop  -->
                <div class="shortcut-body shortcut-b-sell">
                    @if(Session::get('role') == 'Business Owner')
                        <?php $url = "/business-owner/users/".Auth::user()->id; ?>
                    @else                     
                        <?php $url = "/ceo/users/".Auth::user()->id; ?>
                    @endif
                    <?php if(Cookie::get("language") == 'en') { ?>
                        Sorry, you are not a cashier to any shop. <br> Please click <a href="{{$url}}">HERE</a> to add a cashier role to yourself. <br><br> IF you dont have a shop created in this account please click <a href="/shops">HERE</a> to create shop first. 
                    <?php } else { ?>
                        Samahani, wewe sio keshia kwenye duka lolote. <br> Tafadhali bonyeza <a href="{{$url}}">HAPA</a> ujiongezee uwezo wa keshia. <br><br> KAMA haujatengeneza duka tafadhali bonyeza <a href="/shops">HAPA</a> kutengeneza duka kwanza.
                    <?php } ?>
                </div>
                <!-- user assigned to multiple shops  -->
                <div class="shortcut-body shortcut-b-sell2">
                    @if(Session::get('role') == 'Business Owner')
                        <?php $url = "/business-owner/users/".Auth::user()->id; ?>
                    @else                     
                        <?php $url = "/ceo/users/".Auth::user()->id; ?>
                    @endif
                    <p><b><?php echo $_GET['please-choose-shop']; ?></b></p>
                    <div class="render-shops"></div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button> -->
            </div>
        </div>
    </div>
</div>