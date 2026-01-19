
<style type="text/css">
/*slider*/
#slider {
    position: relative;
    width: 100%;
    overflow: hidden;
    margin-top: -40px;
}

#slider #line {
    height: 5px;
    background: rgba(0,0,0,0.5);
    z-index: 1;
    position: absolute;
    bottom: 0;
    right: 0;
}

#slider #dots {
    position: absolute;
    left: 0;
    right: 0;
    bottom: 16px;
    display: flex;
    justify-content: center;
}

#slider #dots li {
    transition: 0.3s;
    list-style-type: none;
    width: 12px;
    height: 12px;
    border-radius: 100%;
    background: rgba(0,0,0,0.5);
    margin: 0 0.25em;
    cursor: pointer;
}

#slider #dots li:hover,
#slider #dots li.active {
    background: white;
}

@keyframes line {

    0% {width: 0%;}
    100% {width: 100%;}

}

#slider #back,
#slider #forword {
    width: 6%;
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: 0.3s;
    cursor: pointer;
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    color: white;
    font-weight: 700;
    font-size: 2rem;
    background: -moz-linear-gradient(left,  rgba(255,255,255,0.75) 0%, rgba(255,255,255,0) 100%);
    background: -webkit-linear-gradient(left,  rgba(255,255,255,0.75) 0%,rgba(255,255,255,0) 100%);
    background: linear-gradient(to right,  rgba(255,255,255,0.75) 0%,rgba(255,255,255,0) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#bfffffff', endColorstr='#00ffffff',GradientType=1 );
}

#slider #forword {
    left: auto;
    right: 0;
    background: -moz-linear-gradient(left,  rgba(255,255,255,0) 0%, rgba(255,255,255,0.75) 100%);
    background: -webkit-linear-gradient(left,  rgba(255,255,255,0) 0%,rgba(255,255,255,0.75) 100%);
    background: linear-gradient(to right,  rgba(255,255,255,0) 0%,rgba(255,255,255,0.75) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00ffffff', endColorstr='#bfffffff',GradientType=1 );
}

#slider:hover #back,
#slider:hover #forword {
    opacity: 0.7;color: #000;
}

ul#move {
    margin: 0;
    padding: 0;
    display: flex;
    width: 100%;
    background: gray;
    margin-right: 100%;
}


ul#move li {
    transition: 0.6s;
    min-width: 100%;
    color: white;
    list-style-type: none;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
}

ul#move li img {
    width: 100%;
}

ul#move li:nth-child(1) {
    background: #657765;
}

ul#move li:nth-child(2) {
    background: #456174;
}

ul#move li:nth-child(3) {
    background: #984;
}

ul#move li:nth-child(4) {
    background: #445566;
}

ul#move li:nth-child(5) {
    background: #744674;
}

</style>

	<div class="row row-slider">
		<div class="container">
			<div class="row d-flex justify-content-between">	
		    <div id="slider" class="topSlider" style="padding:0px;">
		      <div id="line">

		      </div>
		      <ul id="move">
		        <li><img class="" src="web/images/slider5.png" style="width:100%"></li>    
		        <li><img class="" src="web/images/slider6.png" style="width:100%"></li>
		        <li><img class="" src="web/images/slider5.png" style="width:100%"></li>
		        <li><img class="" src="web/images/slider6.png" style="width:100%"></li>
		      </ul>
		      <div id="back">
		        <i class="fa fa-angle-left"></i>
		      </div>
		      <div id="forword">
		        <i class="fa fa-angle-right"></i>
		      </div>
		      <div id="dots" style="visibility: hidden;">
		        
		      </div>  
		    </div>
		    <!-- <div class="contact right-side hide-in-small">
		    	<div class="head">Unahitaji chochote ?</div>
		    	<div class="wasiliana">Wasiliana nasi tueleze unachotaka, tutakufikishia popote ulipo.</div>
		    	<div class="mr">Contact Mr. Levanda <span>(0656040073)</span></div>
          <div class="row">
              <div class="col-6">
                  <a href="https://wa.me/+255656040073" target="_blank" class="btn btn-block btn-sm btn-social btn-whatsapp">
                  <i class="fab fa-whatsapp"></i> Whatsapp
                  </a>
              </div>
              <div class="col-6">
                  <a href="tel:0656040073" class="btn btn-block btn-sm btn-social btn-facebook" style="background:#1AC1DD">
                  <i class="fas fa-phone-alt"></i> Call Us 
                  </a>
              </div>
          </div>
		    </div> -->
			</div>
		</div>
  </div>


    <script type="text/javascript">    	
	    // slider
	    $(window).on('load', function(){
	    	if ($(window).width() >= 482) {
	    		$(".topSlider").addClass("col-md-7");
	    	}
	      let slider = document.querySelector('#slider');
	      let move = document.querySelector('#move');
	      let moveLi = Array.from(document.querySelectorAll('#slider #move li'));
	      let forword = document.querySelector('#slider #forword');
	      let back = document.querySelector('#slider #back');
	      let counter = 1;
	      let time = 3000;
	      let line = document.querySelector('#slider #line');
	      let dots = document.querySelector('#slider #dots');
	      let dot;

	      for (i = 0; i < moveLi.length; i++) {

	          dot = document.createElement('li');
	          dots.appendChild(dot);
	          dot.value = i;
	      }

	      dot = dots.getElementsByTagName('li');

	      line.style.animation = 'line ' + (time / 1000) + 's linear infinite';
	      dot[0].classList.add('active');

	      function moveUP() {

	          if (counter == moveLi.length) {

	              moveLi[0].style.marginLeft = '0%';
	              counter = 1;

	          } else if (counter >= 1) {

	              moveLi[0].style.marginLeft = '-' + counter * 100 + '%';
	              counter++;
	          } 

	          if (counter == 1) {

	              dot[moveLi.length - 1].classList.remove('active');
	              dot[0].classList.add('active');

	          } else if (counter > 1) {

	              dot[counter - 2].classList.remove('active');
	              dot[counter - 1].classList.add('active');

	          }

	      }

	      function moveDOWN() {

	          if (counter == 1) {

	              moveLi[0].style.marginLeft = '-' + (moveLi.length - 1) * 100 + '%';
	              counter = moveLi.length;
	              dot[0].classList.remove('active');
	              dot[moveLi.length - 1].classList.add('active');

	          } else if (counter <= moveLi.length) {

	              counter = counter - 2;
	              moveLi[0].style.marginLeft = '-' + counter * 100 + '%';   
	              counter++;

	              dot[counter].classList.remove('active');
	              dot[counter - 1].classList.add('active');

	          }  

	      }

	      for (i = 0; i < dot.length; i++) {

	          dot[i].addEventListener('click', function(e) {

	              dot[counter - 1].classList.remove('active');
	              counter = e.target.value + 1;
	              dot[e.target.value].classList.add('active');
	              moveLi[0].style.marginLeft = '-' + (counter - 1) * 100 + '%';

	          });

	      }

	      forword.onclick = moveUP;
	      back.onclick = moveDOWN;

	      let autoPlay = setInterval(moveUP, time);

	      slider.onmouseover = function() {

	          autoPlay = clearInterval(autoPlay);
	          line.style.animation = '';

	      }

	      slider.onmouseout = function() {

	          autoPlay = setInterval(moveUP, time);
	          line.style.animation = 'line ' + (time / 1000) + 's linear infinite';

	      }
	    });
    </script>