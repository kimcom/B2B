<script type="text/javascript">
$(document).ready(function () {
//	$(".userdiv").resizable();
//	$(".userdiv").draggable();
	
//	$("#draggable0").resizable();
//	$("#draggable0").draggable();

//	setTimeout(function () {
//		div = $("#draggable0").clone();
//		$(div).css({position:'relative',left:0,top:$(div).css("top"),width:$(div).css("width"),height:$(div).css("height"),margin:5,float:'left',background: '#F4FAFF'});
//		$("#div_desktop").append($(div[0]));
//		$( div ).animate({
//			left: 0,
//			top:  0,
//			height: 200,
//			width:  340,
//			opacity: 1
//		}, 1000);
//	},3000);

	create_div = function (parent) {
//		$.each($("#div_desktop > #div_window"),function (){
//			console.log(this);
//		});
		div = $("#div_window").clone();
		tbl = $("#tbl").clone();
		// $(div).find("IMG").css({float: 'left'});
		// $(div).find("A H6").css({position: 'relative', left: 0, top: 0, margin: 10, color: '#1B4796'});
		// $(div).css({position: 'relative', left: 0, top: 0, margin: 10, color: '#1B4796'});
		$(div).find("#ui-id-1").html($(parent).find("A H6").html());
		$(div).attr("data_src");
		$(div).removeClass("hide");
		$(tbl).removeClass("hide");
		$(div).css({position: 'relative', left: 0, top: 0, width: 0, height: 0, margin: 5, float: 'left', color: '#1B4796', background0: '#F4FAFF', border: '2px solid #FFFFFF', 'border-radius': 4, 'z-index':110});
		$(div).append($(tbl));
		$("#div_desktop").append($(div[0]));
		$(div).animate({
			left: 0,
			top: 0,
			height: 200,
			width: 520,
			opacity: 1
		}, 500);
	}
	$(".userdiv").click(function (){
		create_div(this);
		$("#div_desktop > #div_window").resizable();
		$("#div_desktop > #div_window").draggable();
	});
	
//		$("#div_desktop .userdiv0").resizable();
//		$("#div_desktop .userdiv0").draggable();

//console.log($("#div_title").html());

//		$("#div_title").dialog({
//			autoOpen: true, modal: false, position:'relative', left:0,top:0,width:340,height:200,
//			show: {effect: "explode", duration: 1000},
//			hide: {effect: "explode", duration: 1000},
//			open: function (event, ui) {
//			//$("[aria-describedby=div_register] > .ui-dialog-titlebar").remove();
//			}
//		});


	var newtop = 158;
	$.each($(".userdiv"),function (index,div){
		$(div).css({left:0,top:newtop});
		newtop += $(div).height()+2;
	});
	var newleft = 241; newtop = 111;
	$.each($(".userdiv2"),function (index,div){
		$(div).css({left:newleft,top:newtop});
		newleft += $(div).width()+2;
	});
	
//	divs = $(".userdiv");
//	console.log(divs);
//	for (i = 0; i < divs.length; i++){
//	//for (var div in divs){
//		console.log(divs[i]);
//	}




  
	var slideCount = $('#slider ul li').length;
	var slideWidth = $('#slider ul li').width();
	var slideHeight = $('#slider ul li').height();
	var sliderUlWidth = slideCount * slideWidth;
	$('#slider').css({ width: slideWidth, height: slideHeight });
	$('#slider ul').css({ width: sliderUlWidth, marginLeft: - slideWidth });
    $('#slider ul li:last-child').prependTo('#slider ul');
    moveLeft = function () {
        $('#slider ul').animate({
            left: + slideWidth
        }, 600, function () {
            $('#slider ul li:last-child').prependTo('#slider ul');
            $('#slider ul').css('left', '');
        });
    };
    moveRight = function () {
        $('#slider ul').animate({
            left: - slideWidth
        }, 600, function () {
            $('#slider ul li:first-child').appendTo('#slider ul');
            $('#slider ul').css('left', '');
        });
    };
    $('a.control_prev').click(function () { moveLeft(); });
    $('a.control_next').click(function () { moveRight(); });
	var intervalID = setInterval(function(){
		$(".control_next").click();
   	}, 5000);
});    
</script>
<style>

body{
/*		background-color: #A7DDFF;*/
	background: url(/image/blue_sky.jpg) fixed no-repeat;
	/*background: #0F7CA5;*/
}

.navbar {
	margin-bottom: 0;
}

.button-panel {
	/*background: url(/image/small_steps.png);*/
	/*background: #FFFFFF;*/
	
	min-height: 640px;
	width: 80px;
}

.userdiv {
	/* color: #777777;*/
	/*background: #99D8A8;*/
	/*box-shadow: 1px 1px 2px 1px #FFFFFF;*/
	
	position: absolute;
	background: #81B0E7;
	border: 2px solid #FFFFFF;
	border-radius: 4px;
	opacity: 1;
	width: 80px;
	height: 80px;
	z-index: 1500;
	transition: 0.4s;
}

.userdiv2 {
	/*color: #FFFFFF;*/
	/*background: #99D8A8;*/
	/*background: #ABD4A1;*/
	/*color: #082B6D;
	/*background: #A7DDFF;*/
	/*box-shadow: 1px 1px 2px 1px #AAAAAA;*/

	transition: 0.4s;
	position: absolute;
	background: #81B0E7;
	border: 2px solid #FFFFFF;
	border-radius: 4px;
	opacity: 1;
	width: 151px;
	margin-left: 11px;
	height: 42px;
	z-index: 1500;
}

.userdiv img {
	width: 40px;
	margin-left: 20px;
	margin-top: 10px;
	text-align: center;
}

.userdiv2 img {
	width: 20px;
	margin-left: 5px;
}

.userdiv:hover {
	box-shadow: 0 0 20px 1px black;
	border: 2px solid #CEFCEF;
}

.userdiv2:hover {
	box-shadow: 1px 3px 10px 1px black;
	border: 2px solid #CEFCEF;	
}

.userdiv h6 {
color: black;
}

.userdiv2 h5{
color: black;
}

.logo-img {
	box-shadow: 0 0 10px 1px black;
}

#slider {
  position: relative;
  overflow: hidden;
}

#slider ul {
  position: relative;
  margin: 0;
  padding: 0;
  height: 100px;
  list-style: none;
}

#slider ul li {
  position: relative;
  display: block;
  float: left;
  margin: 0;
  padding: 0;
  width: 1097px;
  height: 110px;
  text-align: center;
  /*line-height: 100px;*/
}

a.control_prev, a.control_next {
 position: absolute;
  z-index: 999;
  display: block;
  height: 200px;
  width: 20px;
  color: black;
  text-decoration: none;
  font-weight: 600;
  font-size: 18px;
  opacity: 0.6;
  cursor: pointer;
  background: black;
}

a.control_prev:hover, a.control_next:hover {
  opacity: 0.3;
  -webkit-transition: all 0.2s ease;
}

a.control_next {
  right: 0;
}

.slider_option {
  position: relative;
  width: 160px;
  font-size: 18px;
}

a.control_prev, a.control_next {
  position: absolute;
  z-index: 999;
  display: block;
  height: 200px;
  width: 30px;
  color: black;
  text-decoration: none;
  font-weight: 600;
  font-size: 18px;
  opacity: 0.2;
  cursor: pointer;
  background: blue;
}



/* 1й слайд с баннерами*/
#slide_1_1 {

}

#slide_1_2 {
	width: 280px;
}

#slide_1_3 {
	width: 289px;
}

#slide_1_4 {
	width: 220px;
}
/* 2й слайд с баннерами*/
#slide_2_1 {
	width: 270px;
}

#slide_2_2 {
	width: 335px;
}

#slide_2_3 {
	width: 285px;
}

#slide_2_4 {
	width: 197px;
}

/* 3й слайд с баннерами*/
#slide_3_1 {
	width: 280px;
}

#slide_3_2 {
	width: 250px;
}

#slide_3_3 {
	width: 290px;
}

#slide_3_4 {
	width: 265px;
}
</style>

<nav class="navbar navbar-<?php echo $_SESSION['nav_style']; ?>navbar-fixed-top2" role="navigation">
    <!-- <div class="container-fluid"> -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
			<a class="navbar-brand h150 p0" href="..">
				<img class="floatL h150 logo-img w250" src="/image/logo.png">
			</a>
        </div>
        <div class="navbar-collapse collapse" style="padding-right: 0;">
<div id="slider">
  <a href="#" class="control_next"></a>
  <a href="#" class="control_prev"></a>
  <ul>
	<li><!--Первый слайд с баннерами-->
		<div class="navbar-header ml2">
			<a class="navbar-header p0" href="..">
				<img class="floatL h110" id="slide_1_1" src="/image/banners/banner_karlie.jpg">
			</a>
		</div>
		<div class="navbar-header ml2">
			<a class="navbar-header p0" href="..">
				<img class="floatL h110" id="slide_1_2" src="/image/banners/banner-delipet12345-340x147-798x330.png">
			</a>
		</div>
		<div class="navbar-header ml2">
			<a class="navbar-header p0" href="..">
				<img class="floatL h110" id="slide_1_3" src="/image/banners/banner_brit.jpg">
			</a>
		</div>
		<div class="navbar-header ml2">
			<a class="navbar-header p0" href="..">
				<img class="floatL h110" id="slide_1_4" src="/image/banners/last1.jpg">
			</a>
		</div>
	</li>
	<li><!--Второй слайд с баннерами-->
		<div class="navbar-header ml2">
				<a class="navbar-header p0" href="..">
					<img class="floatL h110" id="slide_2_1" src="/image/banners/zoongle-26.jpg">
				</a>
			</div>
			<div class="navbar-header ml2">
				<a class="navbar-header p0" href="..">
					<img class="floatL h110" id="slide_2_2" src="/image/banners/banner_720x200_621.jpg">
				</a>
			</div>
			<div class="navbar-header ml2">
				<a class="navbar-header p0" href="..">
					<img class="floatL h110" id="slide_2_3" src="/image/banners/banner_1.jpg">
				</a>
			</div>

			<div class="navbar-header ml2">
				<a class="navbar-header p0" href="..">
					<img class="floatL h110" id="slide_2_4" src="/image/banners/last2.jpg">
				</a>
			</div>
	</li>
    	<li><!--Третий слайд с баннерами-->
		<div class="navbar-header ml2">
				<a class="navbar-header p0" href="..">
					<img class="floatL h110" id="slide_3_1" src="/image/banners/186431719_banner_tualet_980h350.jpg">
				</a>
			</div>
			<div class="navbar-header ml2">
				<a class="navbar-header p0" href="..">
					<img class="floatL h110" id="slide_3_2" src="/image/banners/banner_all_750x417.jpg">
				</a>
			</div>
			<div class="navbar-header ml2">
				<a class="navbar-header p0" href="..">
					<img class="floatL h110" id="slide_3_3" src="/image/banners/banner_teplo.jpg">
				</a>
			</div>
			<div class="navbar-header ml2">
				<a class="navbar-header p0" href="..">
					<img class="floatL h110" id="slide_3_4" src="/image/banners/186431710_banner_perenoska_980h350.jpg">
				</a>
			</div>
	</li>
  </ul>  
</div>
 </div>	



</nav>
 
<!--<div class="ontop">
	<a class="p0" href="..">
		<img class="floatN w200" src="/image/banners/now_eat_160_600.jpg">
	</a>
</div> -->

<div class="container-fluid">
	<div id="draggable20" class=" userdiv2">
		<a style="text-decoration:none;"><h5 class="TAC c2">Прайс<img src="/image/icons/price_list.png"></h5></a>
	</div>
	<div id="draggable21" class=" userdiv2">
		<a style="text-decoration:none;"><h5 class="TAC c2">Акции<img src="/image/icons/stock.png"></h5></a>
	</div>
	<div id="draggable22" class=" userdiv2">
		<a style="text-decoration:none;"><h5 class="TAC c2">Новинки<img src="/image/icons/new.png"></h5></a>
	</div>
	<div id="draggable23" class=" userdiv2">
		<a style="text-decoration:none;"><h5 class="TAC c2">Баллы<img src="/image/icons/scores.png"></h5></a>
	</div>
	<div id="draggable24" class=" userdiv2">
		<a style="text-decoration:none;"><h5 class="TAC c2">Контакты<img src="/image/icons/contacts.png"></h5></a>
	</div>
	<div id="draggable25" class=" userdiv2">
		<a style="text-decoration:none;"><h5 class="TAC c2">Помощь<img src="/image/icons/help.png"></h5></a>
	</div>
</div>

<div class="button-panel floatL">
	<div id="draggable1" class="userdiv">
		<img src="/image/icons/catalog.png">
		<a style="text-decoration:none;"><h6 class="TAC c2">Каталог</h6></a>
	</div>
	<div id="draggable2" class="userdiv">
		<img src="/image/icons/active.png">
		<a style="text-decoration:none;"><h6 class="TAC c2 mt0">Текущий заказ</h6></a>
	</div>
	<div id="draggable3" class="userdiv">
		<img src="/image/icons/history.png">
		<a style="text-decoration:none;"><h6 class="TAC c2 mt0">Список заказов</h6></a>
	</div>
	<div id="draggable0" class="userdiv">
		<img src="/image/icons/favorites.png">
		<a style="text-decoration:none;"><h6 class="TAC c2 mt0">Постоянные товары</h6></a>
	</div>
	<div id="draggable4" class="userdiv">
		<img src="/image/icons/balance.png">
		<a style="text-decoration:none;"><h6 class="TAC c2">Баланс</h6></a>
	</div>
	<div id="draggable5" class="userdiv">
		<img src="/image/icons/settings.png">
		<a style="text-decoration:none;"><h6 class="TAC c2">Настройки</h6></a>
	</div>
</div>
<div id="div_window" class="hide ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-draggable ui-resizable">
	<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix ui-draggable-handle" style="background:#5C74C2">
		<span id="ui-id-1" class="ui-dialog-title" style="color: #E0E3C1">&nbsp;</span>
		<button type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close" role="button" title="Закрыть" 
				onclick="console.log($(this).parent().parent().remove());">
			<span class="ui-button-icon-primary ui-icon ui-icon-closethick"></span>
		</button>
	</div>
</div>
<table id="tbl" class="table table-striped table-hover table-bordered table-responsive w100p hide" cellspacing="0">
<!--	<thead><tr><th colspan="6"><h4 class='TAC mt5 mb5' >Результаты выполнения:</h4></th></tr>-->
<tr><th>№ п-п</th><th>GoodID</th><th>Артикул</th><th>Название</th><th>Старое знач.</th><th>Новое знач.</th></tr>
</thead>
<tbody>
	<tr class="hide0">
		<td class="TAC">1</td>
		<td class="TAC">2</td>
		<td class="TAC">3</td>
		<td class="TAC">4</td>
		<td class="TAC">5</td>
		<td class="TAC">6</td>
	</tr>
</tbody>
</table>
<div id="div_desktop"  class="container-fluid p0 bgi h600">
</div>
