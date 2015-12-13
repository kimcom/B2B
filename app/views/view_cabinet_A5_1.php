<nav class="navbar navbar-<?php echo $_SESSION['nav_style']; ?> navbar-fixed-top" role	="navigation">
	<div class="container-fluid p0">
		<div class="row m0">
			<div class="col-md-2 p0">
				<!-- Название компании и кнопка, которая отображается для мобильных устройств группируются для лучшего отображения при свертывание -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand h140 m0 p0" href=".." style="margin-left: 0px;">
						<img class="floatL h140 logo-img" src="/image/logo.png">
					</a>
				</div>
			</div>
			<div class="col-md-10 p0">
				<div class="row m0 collapse navbar-collapse ">
					<div class="col-md-12 p0">
						<div class="0collapse 0navbar-collapse 0navbar-header ml2">
							<a class="0navbar-header p0" href="..">
								<img class="floatL h110" id="slide_1_1" src="/image/banners/banner_karlie.jpg">
							</a>
						</div>
						<div class="0collapse 0navbar-collapse 0navbar-header ml2">
							<a class="0navbar-header p0" href="..">
								<img class="floatL h110" id="slide_1_2" src="/image/banners/banner-delipet12345-340x147-798x330.png">
							</a>
						</div>
					</div>
				</div>
				<div class="row m0">
					<div class="col-md-12 p0">
						<!-- Группируем ссылки, формы, выпадающее меню и прочие элементы -->
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
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
								<li class="minw100"><a href="#">Малинин Олег</a></li>
								<li class="minw100 dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">Кабинет <b class="caret"></b></a>
									<ul class="dropdown-menu">
										<li><a href="#">Профиль</a></li>
										<li><a href="#">Настройки</a></li>
										<li class="divider"></li>
										<li><a href="/login/logout">Выход</a></li>
									</ul>
								</li>
							</ul>
						</div><!-- /.navbar-collapse -->
					</div>
				</div>
			</div>
		</div>
	</div><!-- /.container-fluid -->
</nav>
<div class="container-fluid min570">
</div>
