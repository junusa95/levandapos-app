
@include("layouts.translater") 

<div class="modal fade" id="endFreeTrialModal" tabindex="-1" role="dialog" aria-labelledby="endFreeTrialModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="mt-2 mr-3">
                    <!-- <h4 class="title" id="largeModalLabel">Add payment</h4> -->
                    <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                        <button class="btn btn-danger btn-sm">x</button>
                    </span>
                </div>
                <div class="modal-body mt-3"> 
                    <div align="center">
                        <h3 class="mb-5"><b> @if(Auth::user()->company) {{Auth::user()->company->name}} @endif </b></h3>
                        <!-- <h4 style="color: red;"><?php echo $_GET['30-days-free-trial']; ?></h4> -->
                        <h5 class="mt-3"><?php echo $_GET['please-pay-for-this-acc']; ?></h5>
                    </div>
                    
                    <div>                            
                        <div class="col-12 mb-4 px-0 reduce-padding">
                            <div class="accordion" id="accordion" style="margin-top: 60px;">
                                <div>
                                    <div class="card-header" id="headingOne">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed show-customer" type="button" data-toggle="collapse" data-target="#paymentFees" aria-expanded="false" aria-controls="collapseOne">
                                                <i class="fa fa-info-circle fa-2x" style="float: left;"></i>
                                                <div style="float: left;font-weight: bold;padding-top: 5px;padding-left: 10px;"> <?php echo $_GET['see-subscription-fees']; ?></div> 
                                                <i class="fa fa-angle-down fa-2x" style="float: right;"></i>
                                            </button>
                                        </h5>
                                    </div>                                
                                    <div id="paymentFees" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" style="border: 2px solid #eee;">
                                        <div class="card-body" style="padding-bottom: 10px;padding-top: 10px;">                
                                            <div> <br>
                                                <b>Malipo kwa duka</b> <br>
                                                - Tsh <b>12,000</b> ukilipia mwezi mmoja.<br>
                                                - Tsh <b>33,000</b> ukilipia miezi 3.. unakua umeokoa Tsh 3,000 <br>
                                                - Tsh <b>60,000</b> ukilipia miezi 6.. unakua umeokoa Tsh 12,000 <br>
                                                <!-- - Tsh <b>108,000</b> ukilipia miezi 12.. unakua umeokoa Tsh 36,000 <br> -->
                                                 <br>
                                                 
                                                <b>Malipo kwa stoo</b> <br>
                                                - Tsh <b>6,000</b> kwa mwezi mmoja.<br><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="">
                                    <div class="card-header" id="headingOne">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed show-customer" type="button" data-toggle="collapse" data-target="#paymentProcess" aria-expanded="false" aria-controls="collapseOne">
                                                <i class="fa fa-info-circle fa-2x" style="float: left;"></i>
                                                <div style="float: left;font-weight: bold;padding-top: 5px;padding-left: 10px;"> <?php echo $_GET['see-payment-process']; ?></div> 
                                                <i class="fa fa-angle-down fa-2x" style="float: right;"></i>
                                            </button>
                                        </h5>
                                    </div>                                
                                    <div id="paymentProcess" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" style="border: 2px solid #eee;">
                                        <div class="card-body" style="padding-bottom: 10px;padding-top: 10px;">                
                                            <div> <br>
                                                <b>Jinsi ya kulipia:</b>  <br>
                                                Kwasasa mfumo bado haujaunganishwa na malipo ya online, hivyo <br><br>
                                                1. Utalipia kwa Tigo lipa namba <b>7380223</b>, jina <b>LEVANDA SHOP</b>. <br>
                                                2. Tutumie meseji ya muamala kwa WhatsApp <a href="https://wa.me/+255656040073">0656-040-073</a>, Jina la akaunti yako na jina lako unalotumia kenye mfumo wetu. <br>
                                                3. Tutakufungulia akaunti yako papo hapo.
                                                 <br><br> 
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div> 
                        </div>                 
                    </div>

                    <div class="col-12 px-0 mt-5">
                        <b>MUHIMU:</b> <br>
                        Akaunti ikikaa siku 30 bila kulipiwa itafutwa kwenye mfumo na utakua umepoteza taarifa zako zote. <br> Tafadhali lipia kwa wakati ili kuepuka usumbufu utaojitokeza. <br><br> Kwa maelezo zaidi kuhusu malipo wasiliana nasi kwa namba <a href="tel:+255656040073">0656-040-073</a>
                    </div>
                     
                </div>
            </div>
        </div>
    </div>