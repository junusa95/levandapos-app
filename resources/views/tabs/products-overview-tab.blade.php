


@include("layouts.translater") 

<div class="row">
    <div class="col-12">
        <div class="header p-0"><h2><?php echo $_GET['products-categories']; ?>:</h2></div>
        <div class="mt-2">
            - Zipange bidhaa zako kwenye kategori/makundi  <br>
            - Makundi/kategori za bidhaa kwa wafanyabiashara wa mavazi ni kama Viatu, Nguo, Kofia n.k <br><br>
            <div class="row">
                <div class="col">
                    <a href="#" class="new-sub-category-form" data-toggle="modal" data-target="#addSCategory">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" style="width:15px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                    </svg> Ongeza kategori ya bidhaa </a>
                </div>
                <div class="col">
                    <a href="/products?opt=products">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" style="width:15px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                    </svg> Ona kategori za bidhaa </a>
                </div>
            </div>
              <hr>
        </div>
    </div>
    <div class="col-12">
        <div class="header p-0"><h2><?php echo $_GET['products-menu']; ?>:</h2></div>
        <div class="mt-2">
            - Jaza bidhaa zako, bei uliyonunulia na bei unayouza ili system ikusaidie kupiga mahesabu ya faida unayoingiza kila unapouza bidhaa <br>
            - Mfano wa bidhaa kwa wafanyabiashara wa mavazi ni kama <b>Nike raba</b> kwenye kategori ya Viatu, <b>Polo shirt</b> kwenye kategori ya Nguo, <b>Cap</b> kwenye kategori ya Kofia n.k <br><br>
            <div class="row">
                <div class="col">
                    <a href="/products?opt=add-product">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" style="width:15px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                    </svg> Ongeza bidhaa </a>
                </div>
                <div class="col">
                    <a href="/products?opt=new-stock">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" style="width:15px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                    </svg> Ongeza idadi ya bidhaa </a>
                </div>
                <div class="col">
                    <a href="/products?opt=products">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" style="width:15px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                    </svg> Ona bidhaa </a>
                </div>
            </div>
              <hr>
        </div>
    </div>
    <div class="col-12">
        <div class="header p-0"><h2><?php echo $_GET['stock-reports']; ?>:</h2></div>
        <div class="mt-2">
            - Rekodi ya stock za nyuma <br>
            - Matukio ya bidhaa ya kila siku (kutrack/monitor bidhaa) <br>
            - Rekodi za transfaa <br>
            - Rekebisha idadi ya bidhaa <br>
            - Stock taking <br><br>
            <a href="/products?opt=stock">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" style="width:15px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                    </svg> <?php echo $_GET['stock-reports']; ?> </a>
              <hr>
        </div>
    </div>
</div> 