
@include("layouts.translater")
<?php
    if(Cookie::get("language") == 'en') {
        $_GET['how-to-create-product'] = "How to create product";
        $_GET['how-to-sale-product'] = "How to sale product";
    } else {
        $_GET['how-to-create-product'] = "Jinsi ya kutengeneza bidhaa";
        $_GET['how-to-sale-product'] = "Jinsi ya kuuza bidhaa";
    }
?>

<div class="modal fade" id="howCreateProduct" tabindex="-1" role="dialog" aria-labelledby="howCreateProductModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="mt-2 mr-3">
                <!-- <h4 class="title" id="largeModalLabel">Add payment</h4> -->
                <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                    <button class="btn btn-danger btn-sm">x</button>
                </span>
            </div>
            <div class="modal-body"> 
                <div align="center">
                    <h5 class="mt-3"><b><?php echo $_GET['how-to-create-product']; ?></b></h5>
                </div>
                
                <?php if(Auth::user()->company->has_product_categories == 'no') { ?>
                <div class="col-12 mb-4 px-0 reduce-padding">
                    <div class="mt-4">
                        <h6><b>Bidhaa:</b></h6>
                        <div class="mt-2">
                            Kwenye kila bidhaa unatakiwa kujaza <br> 
                            1. Jina la bidhaa <br> 2. Bei uliyonunulia bidhaa <br> 3. Bei unayouza bidhaa <br> 4. Bandika picha ya bidhaa (sio lazima kubandika picha)
                        </div>
                        <div class="mt-3">
                            Baada ya kutengeneza bidhaa zako, hatua inayofata ni kuongeza idadi ya bidhaa ulizonazo.
                        </div>
                        <div class="mt-3">
                            Bonyeza <i class="fa fa-hand-o-right"></i> <b><a href="/shops/{{$fshop->id}}?tab=products&tab2=add-product">Tengeneza Bidhaa</a></b> <i class="fa fa-hand-o-left"></i> 
                        </div>
                    </div>
                </div>    
                <?php } else { ?>
                <div class="col-12 mb-4 px-0 reduce-padding">
                    Kabla ya kutengeneza bidhaa unatakiwa kutengeneza kategori/makundi ya bidhaa. 
                    <div class="mt-4">
                        <h6><b>Kategori/Makundi ya bidhaa:</b></h6>
                        Bidhaa zako unatakiwa kuzipanga kwenye makundi. <br>
                        Mfano wa makundi ya bidhaa <br>
                        1. Biashara ya <b>Mavazi</b> ni kama <b>Nguo, Viatu, Jezi n.k</b> <br>
                        2. Biashara ya <b>Vifaa vya Simu</b> ni kama <b>Chaja, Kava, Earphone n.k</b> 
                        <div class="mt-2">
                            Bonyeza <i class="fa fa-hand-o-right"></i> <b><a href="#" class="new-sub-category-form" data-toggle="modal" data-target="#addSCategory"><?php echo $_GET['create-category']; ?></a></b> <i class="fa fa-hand-o-left"></i> kisha andika majina ya kategori za bidhaa zako. Bonyeza alama ya jumlisha kuongeza kategori
                        </div>
                    </div>
                    <hr>
                    <div class="mt-4">
                        <h6><b>Bidhaa:</b></h6>
                        Mfano wa bidhaa <br>
                        1. Biashara ya <b>Mavazi</b> ni kama <b>Shati, Jeanz, Vest</b> zinayopatikana kwenye kundi ya <b>Nguo</b>...  <b>Raba, Moka, Travota</b> zinazopatikana kwenye kundi la <b>Viatu</b> n.k<br>
                        <div class="mt-2">
                            Kwenye kila bidhaa unatakiwa kujaza <br> 
                            1. Jina la bidhaa <br> 2. Kategori ya bidhaa (Chagua kweny list, kama haipo kwenye list bonyeza kitufe cha <b>ongeza</b> kutengeneza kategori mpya) <br> 3. Bei uliyonunulia bidhaa <br> 4. Bei unayouza bidhaa <br> 5. Bandika picha ya bidhaa (sio lazima kubandika picha)
                        </div>
                        <div class="mt-3">
                            Baada ya kutengeneza bidhaa zako, hatua inayofata ni kuongeza idadi ya bidhaa ulizonazo.
                        </div>
                        <div class="mt-3">
                            Bonyeza <i class="fa fa-hand-o-right"></i> <b><a href="/shops/{{$fshop->id}}?tab=products&tab2=add-product">Tengeneza Bidhaa</a></b> <i class="fa fa-hand-o-left"></i> 
                        </div>
                    </div>
                </div>    
                <?php } ?>
                <hr>

                <div class="col-12 mt-5 px-0 pb-5">
                    <h6><b>Unapata changamoto ?</b> </h6>
                    Wasiliana na mtoa huduma wetu muda wowote kwa namba <a href="tel:+255656040073">+255 656 040 073</a> <br>
                    Atakusaidia kwa njia ya simu. Na kama changamoto ni kubwa atafika ofisini kwako kwa msaada zaidi.
                </div>
                
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="howSaleProduct" tabindex="-1" role="dialog" aria-labelledby="howSaleProductModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="mt-2 mr-3">
                <!-- <h4 class="title" id="largeModalLabel">Add payment</h4> -->
                <span type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: .9">
                    <button class="btn btn-danger btn-sm">x</button>
                </span>
            </div>
            <div class="modal-body"> 
                <div align="center">
                    <h5 class="mt-3"><b><?php echo $_GET['how-to-sale-product']; ?></b></h5>
                </div>
                                        
                <div class="col-12 mb-4 px-0 reduce-padding">
                    Kabla ya kuuza hakikisha umetengeneza bidhaa na zipe idadi. (kila bidhaa isome idadi kadhaa kwenye duka)
                    <div class="mt-4">
                        <h6><b>Jinsi ya kuuza:</b></h6>
                        1. Nenda kwenye list ya maduka yako <i class="fa fa-hand-o-right"></i> <b><a href="/shops">Maduka</a></b> <i class="fa fa-hand-o-left"></i> <br>
                        2. Bonyeza jina la duka unalotaka kuuza bidhaa <br>
                        3. Bonyeza kitufe kilichoandikwa <b>Uza bidhaa</b> <br>
                        <div class="ml-2"><img src="/images/screenshots/uza_bidhaa_btn.png" width="300" alt=""></div> <br>
                        4. Bonyeza/tafuta bidhaa <br>
                        <div class="ml-2"><img src="/images/screenshots/search_product.png" width="300" alt=""></div> <br>
                        <i class="fa fa-hand-o-right"></i> Bonyeza jina la bidhaa. <br><br>
                        5. Ukibonyeza jina la bidhaa litajiorodhesha kwenye ubao wa mauzo <br>
                        <div class="ml-2"><img src="/images/screenshots/products_to_sale.png" width="300" alt=""></div> <br>
                        <i class="fa fa-hand-o-right"></i> Kwenye ubao wa mauzo unaweza ukabadilisha idadi ya bidhaa, ukabadilisha bei unayotaka kuuzia. <br>
                        <i class="fa fa-hand-o-right"></i> Ukishamaliza kuandaa bidhaa unazouza bonyza kitufe cha <b>Uza</b> kulichopo chini kulia. 
                        <div class="mt-3">
                            Baada ya kuuza bidhaa unaweza ukaona ripoti ya mauzo kama, idadi ya bidhaa zilizouzwa, jumla ya mauzo, faida iliyopatikana n.k
                        </div>
                    </div>
                </div>    
                <hr>

                <div class="col-12 mt-5 px-0 pb-5">
                    <h6><b>Unapata changamoto ?</b> </h6>
                    Wasiliana na mtoa huduma wetu muda wowote kwa namba <a href="tel:+255656040073">+255 656 040 073</a> <br>
                    Atakusaidia kwa njia ya simu. Na kama changamoto ni kubwa atafika ofisini kwako kwa msaada zaidi.
                </div>
                
            </div>
        </div>
    </div>
</div>

