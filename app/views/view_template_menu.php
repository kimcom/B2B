<!--<script src="/js/jquery.bxslider.min.js"></script>
<link href="/css/jquery.bxslider.css" rel="stylesheet"/>-->
<script type="text/javascript">
$(document).ready(function () {
//	$('.bxslider').removeClass("hidden");
//	$('.bxslider').bxSlider({
//	    //mode: 'fade',
//	    pager: false,
//	    auto: true,
//	    speed: 3000,
//	    adaptiveHeight: true,
//	    responsive: true,
//	});
//	$(window).resize(function () {
//	    var slideWidth = $(window).width();
//	    $("#div_banners").width(slideWidth - 250);
//	});
//	$(window).resize();
	//$("body").attr({'style': 'background:url("/image/blue_sky.jpg") no-repeat center center fixed;'});
});
</script>

<nav class="navbar navbar-<?php echo $_SESSION['nav_style']; ?>" role="navigation">
	<div class="container-fluid p0">
		<!-- Название компании и кнопка, которая отображается для мобильных устройств группируются для лучшего отображения при свертывание -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand h50 m0 p0" href=".." style="margin-left: 0px;">
				<img id="div_brand" class="floatL h50" src="/image/logo_b2b.png">
			</a>
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
			<form class="navbar-form navbar-left" role="search">
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
