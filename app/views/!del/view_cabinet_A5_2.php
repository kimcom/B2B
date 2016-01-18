<script type="text/javascript">
$(document).ready(function () {
	var slideCount = $('#slider ul li').length;
	var slideWidth = $('#slider ul li').width();
	var slideHeight = $('#slider ul li').height();
//	var sliderUlWidth = slideCount * slideWidth;
//	sliderUlWidth = Math.min(sliderUlWidth,$(window).width()-222);
	slideWidth = $(window).width()-222;
	sliderUlWidth = $(window).width()-222;
console.log(slideHeight,slideCount,slideWidth,sliderUlWidth);
console.log($(window).width(),$(window).width()-222);
	$('#slider').css({width: sliderUlWidth});
	$('#slider').css({width: slideWidth});
//$('#slider').css({width: slideWidth, height: slideHeight, 'margin-left':222});
//$('#slider ul').css({width: sliderUlWidth, marginLeft: -slideWidth});
//	$('#slider ul li:last-child').prependTo('#slider ul');
	moveLeft = function () {
		$('#slider ul').animate({ left: +slideWidth	}, 600, function () {
		    $('#slider ul li:last-child').prependTo('#slider ul');
		    $('#slider ul').css('left', '');
		});
    };
	moveRight = function () {
		$('#slider ul').animate({ left: -slideWidth }, 600, function () {
		    $('#slider ul li:first-child').appendTo('#slider ul');
		    $('#slider ul').css('left', '');
		});
	};
	$('a.control_prev').click(function () { moveLeft(); });
	$('a.control_next').click(function () { moveRight();});
//	var intervalID = setInterval(function () {
//		$(".control_next").click();
//	    }, 5000);
});
</script>

<nav class="navbar navbar-<?php echo $_SESSION['nav_style']; ?> navbar-fixed-top" role="navigation">
	<div class="container-fluid p0">
		<!-- Название компании и кнопка, которая отображается для мобильных устройств группируются для лучшего отображения при свертывание -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand h140 m0 p0" href=".." style="margin-left: 0px;">
				<img id="div_brand" class="floatL h140 logo-img0" src="/image/logo.png">
			</a>
		</div>
		<div class="collapse navbar-collapse banner-fixed-top">
			<div id="slider">
				<a href="#" class="control_next"></a>
				<a href="#" class="control_prev"></a>
				<ul>
					<li><!--Первый слайд с баннерами-->
						<div class="ml2">
							<a class="p0" href="..">
								<img class="img-responsive floatL h110" id="slide_1_1" src="/image/banners/banner_karlie.jpg">
							</a>
						</div>
						<div class="ml2">
							<a class="p0" href="..">
								<img class="img-responsive floatL h110" id="slide_1_2" src="/image/banners/banner-delipet12345-340x147-798x330.png">
							</a>
						</div>
						<div class="ml2">
							<a class="p0" href="..">
								<img class="floatL h110" id="slide_1_3" src="/image/banners/banner_brit.jpg">
							</a>
						</div>
						<div class="ml2">
							<a class="p0" href="..">
								<img class="floatL h110" id="slide_1_4" src="/image/banners/last1.jpg">
							</a>
						</div>
					</li>
					<li><!--Второй слайд с баннерами-->
						<div class="ml2">
							<a class="p0" href="..">
								<img class="floatL h110" id="slide_2_1" src="/image/banners/zoongle-26.jpg">
							</a>
						</div>
						<div class="ml2">
							<a class="p0" href="..">
								<img class="floatL h110" id="slide_2_2" src="/image/banners/banner_720x200_621.jpg">
							</a>
						</div>
						<div class="ml2">
							<a class="p0" href="..">
								<img class="floatL h110" id="slide_2_3" src="/image/banners/banner_1.jpg">
							</a>
						</div>

						<div class="ml2">
							<a class="p0" href="..">
								<img class="floatL h110" id="slide_2_4" src="/image/banners/last2.jpg">
							</a>
						</div>
					</li>
					<li><!--Третий слайд с баннерами-->
						<div class="ml2">
							<a class="p0" href="..">
								<img class="floatL h110" id="slide_3_1" src="/image/banners/186431719_banner_tualet_980h350.jpg">
							</a>
						</div>
						<div class="ml2">
							<a class="p0" href="..">
								<img class="floatL h110" id="slide_3_2" src="/image/banners/banner_all_750x417.jpg">
							</a>
						</div>
						<div class="ml2">
							<a class="p0" href="..">
								<img class="floatL h110" id="slide_3_3" src="/image/banners/banner_teplo.jpg">
							</a>
						</div>
						<div class="ml2">
							<a class="p0" href="..">
								<img class="floatL h110" id="slide_3_4" src="/image/banners/186431710_banner_perenoska_980h350.jpg">
							</a>
						</div>
					</li>
				</ul>  
			</div>
		</div>
		<!-- Группируем ссылки, формы, выпадающее меню и прочие элементы -->
		<div class="collapse navbar-collapse navbar-menu" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li class="minw100 active"><a href="#">Новинки</a></li>
				<li class="minw100"><a href="#">Акции</a></li>
				<li class="minw100"><a href=""></a></li>
				<li class="minw100"><a href=""></a></li>
				<li class="minw100"><a href=""></a></li>
				<li class="minw100"><a href=""></a></li>
			</ul>
			<form class="navbar-form navbar-left mt2 mb0" role="search">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Введите артикул">
				</div>
				<button type="submit" class="btn btn-default">Поиск</button>
			</form>
			<ul class="nav navbar-nav navbar-right">
				<li class="minw100 dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Малинин Олег<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="#">Профиль</a></li>
						<li><a href="#">Настройки</a></li>
						<li class="divider"></li>
						<li><a href="/login/logout">Выход</a></li>
					</ul>
				</li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>
<div class="container-fluid min570">
</div>
