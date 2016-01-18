<?php
	$url = $_SERVER['REQUEST_URI'];
	if ($url=='/main/orders')	$active1 = 'active';
	if ($url=='/main/catalog')	$active2 = 'active';
	if ($url=='/main/my_goods')	$active3 = 'active';
	if ($url=='/main/news')		$active4 = 'active';
	if ($url=='/main/promo')	$active5 = 'active';
	if ($url=='/main/helper')	$active11 = 'active';
	if ($url=='/main/profile' || $url == '/main/setting') $active20 = 'active';
?>

<nav class="navbar navbar-<?php echo $_SESSION['nav_style']; ?>" role="navigation">
	<div class="container-fluid p0">
		<!-- Название компании и кнопка, которая отображается для мобильных устройств группируются для лучшего отображения при свертывание -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only"></span>
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
				<li class="minw100 <?php echo $active1; ?>"><a href="/main/orders">Заказы</a></li>
<?php
if ($_SESSION['ClientID'] != 0) {
?>
				<li class="minw100 <?php echo $active2; ?>"><a href="/main/catalog">Каталог</a></li>
				<li class="minw100 <?php echo $active3; ?>"><a href="/main/templates">Шаблоны</a></li>
<?php } ?>
				<li class="minw100 <?php echo $active4; ?>"><a href="/main/news">Новинки</a></li>
				<li class="minw100 <?php echo $active5; ?>"><a href="/main/promo">Акции</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
<?php
if (1==0 && $_SESSION['ClientID'] != 0) {
?>
				<form class="navbar-left navbar-form" role="search">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Введите артикул">
					</div>
					<button type="submit" class="btn btn-default">Поиск</button>
				</form>
<?php } ?>
<?php
if ($_SESSION['UserID'] < 10) {
?>
					<li class="minw100 <?php echo $active11; ?>"><a href="/main/helper">HELPER</a></li>
<?php } ?>
				<li class="minw100 dropdown <?php echo $active20; ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['ClientName'];?><b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="/main/profile">Профиль</a></li>
						<li><a href="/engine/banners?id=1">Баннер 1 - <?php echo ($_SESSION['banners1']) ? 'выключить' : 'включить';?></a></li>
						<li><a href="/engine/banners?id=2">Баннер 2 - <?php echo ($_SESSION['banners2']) ? 'выключить' : 'включить';?></a></li>
						<li class="divider"></li>
						<li><a href="/login/logout">Выход</a></li>
					</ul>
				</li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>
<?php
if ($_SESSION['ClientID']==0){
?>
<div class="container center">
		<div class="panel panel-warning ">
			<div class="panel-heading center">
				<h2>ВНИМАНИЕ!</h2>
				<h3><p>Доступ к системе ограничен!</p>
					<p>Вы не можете делать заказы!</p>
					<p>Сообщите своему менеджеру!</p>
				</h3>
			</div>
<!--			<div class="panel-body">
			</div>-->
		</div>
	</div>
<?php
}
?>