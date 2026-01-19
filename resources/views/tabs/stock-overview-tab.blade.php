

@include("layouts.translater") 

<style type="text/css"> 
    @media screen and (max-width: 480px) {
        .mt-2 a {font-size:13px !important}
    }
</style>

<div class="row">
    <div class="col-12" style="display: none;">
        <div class="header p-0"><h2><?php echo $_GET['add-stock']; ?>:</h2></div>
        <div class="mt-2">
            - Ongeza idadi ya bidhaa ulizonazo dukani/stoo <br>
            - Chagua bidhaa kisha weka idadi unayotaka kuongeza <br>
            - Ukaguzi wa keshia au stoo master.. Chagua NDIO kama unataka keshia wa dukani au stoo master wa stoo aweze kuona idadi ya bidhaa ulizoongeza, Chagua HAPANA kama unataka bidhaa ziongezeke moja kwa moja dukani au stoo bila kuthibitishwa/approval <br><br>
            <a href="#" class="add-stock-tab">Bonyeza kuongeza stock <svg class="w-6 h-6 text-gray-800 dark:text-white" style="width:24px;padding-left:10px" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
            </svg></a>
              <hr>
        </div>
    </div>
    <div class="col-12" style="display: none;">
        <div class="header p-0"><h2><?php echo $_GET['available-stock']; ?>:</h2></div>
        <div class="mt-2">
            - Tazama jumla ya bidhaa zote ulizonazo kwenye maduka na stoo zako zote <br>
            - Chagua duka/stoo kuona idadi ya bidhaa zote zilizopo kwenye duka/stoo husika <br><br>
            <a href="#" class="ava-stock-tab">Bonyeza kuona idadi ya bidhaa <svg class="w-6 h-6 text-gray-800 dark:text-white" style="width:24px;padding-left:10px" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
            </svg></a>
              <hr>
        </div>
    </div>
    <div class="col-12 mt-2">
        <div class="header p-0"><h2><?php echo $_GET['previous-stock-records']; ?>:</h2></div>
        <div class="mt-2">
            - Taarifa zote za stock mpya ulizowahi kuingiza dukani/stoo unaweza kuzionea hapa. 
            <br><br>
            <a href="#" class="previous-stock-records-tab">
            <svg class="w-6 h-6 text-gray-800 dark:text-white" style="width:15px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
            </svg> Bonyeza kuona stock za nyuma </a>
              <hr>
        </div>
    </div>
    <div class="col-12">
        <div class="header p-0"><h2><?php echo $_GET['item-activities']; ?>:</h2></div>
        <div class="mt-2">
            - Fatilia matukio ya kila siku ya bidhaa fulani <br>
            - Chagua bidhaa uweze kuona uongezekaji na upunguaji wa idadi na balance (idadi iliyosalia) kwa tarehe fulani  
            <br><br>
            <a href="#" class="item-activities-tab">
            <svg class="w-6 h-6 text-gray-800 dark:text-white" style="width:15px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
            </svg> Bonyeza kuona matukio ya bidhaa </a>
              <hr>
        </div>
    </div>
    <div class="col-12">
        <div class="header p-0"><h2><?php echo $_GET['transfer-records-menu']; ?>:</h2></div>
        <div class="mt-2">
            - Kama kwenye akaunti hii kumesajiliwa duka/stoo moja tu, basi hiki kipengele hakikuhusu. <br>
            - Hapa unaweza kufatilia bidhaa zinazohamishwa kutoka sehem moja kwenda ingine. Mfano: kutoka stoo kwenda dukani, dukani - stoo, stoo A - stoo B, duka A - duka B. <br>
            - Ukitaka kuhamisha, nenda kaingie ndani ya duka/stoo husika kisha bonyeza kuhamisha.
            <br><br>
            <a href="#" class="transfer-records-tab">
            <svg class="w-6 h-6 text-gray-800 dark:text-white" style="width:15px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
            </svg> Bonyeza kuona rekodi za transfaa </a>
              <hr>
        </div>
    </div>
    <div class="col-12">
        <div class="header p-0"><h2><?php echo $_GET['stock-adjustment-menu']; ?>:</h2></div>
        <div class="mt-2">
            - Kama unahitaji kubadilisha idadi ya bidhaa inayosoma muda huu kwenye duka/stoo fulani. Hapa ndo mahala pake <br>
            - Bidhaa zote zitakazo badilishwa idadi yake zitarekodiwa. 
            <br><br>
            <a href="#" class="stock-adjustment-tab">
            <svg class="w-6 h-6 text-gray-800 dark:text-white" style="width:15px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
            </svg> Bonyeza kubadili idadi ya bidhaa </a>
              <hr>
        </div>
    </div>
    <div class="col-12">
        <div class="header p-0"><h2><?php echo $_GET['stock-taking-menu']; ?>:</h2></div>
        <div class="mt-2">
            - Wasomi waliosomea maswala ya biashara wanaelewa <b>Stock Taking</b> ni nini.. Kama haujui ngoja nikueleze kwa ufupi. <br>
            - Mfano umeanza biashara yako mwezi wa kwanza na ukarekodi idadi ya bidhaa zote ulizoanza nazo kwenye system, Ilipofika mwezi watatu ukataka kuhesabu bidhaa ulizonazo dukani ili uweze kulinganisha na bidhaa zinazosoma kwenye system kama zipo sawa au kuna utofauti. Hiki kitendo ndo kinaitwa <b>Stock Taking</b>. <br>
            - Hesabu bidhaa zako dukani/stoo kisha jaza kwenye system. System itakupa ripoti ya ongezeko/pungufu ya idadi pamoja na thamani ya fedha inayotokana na ongezeko/pungufu hilo. <br>
            - Mfano: kama kuna upungufu la bidhaa 15, system itakuonesha thamani ya izo bidhaa 15 ambazo zimepungua.
            <br><br>
            <a href="#" class="stock-taking-tab">
            <svg class="w-6 h-6 text-gray-800 dark:text-white" style="width:15px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
            </svg> Bonyeza kurekodi stock iliyopo </a>
              <hr>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        
    });
</script>