<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../../css/<?php echo $_SESSION['bs_style']; ?>/bootstrap.css">
		<title>Шрифт</title>
		<style>
/*@font-face {
	font-family: 'Glyphicons Halflings';

	src: url('../fonts/glyphicons-halflings-regular.eot');
	src: url('../fonts/glyphicons-halflings-regular.eot?#iefix') format('embedded-opentype'), url('../fonts/glyphicons-halflings-regular.woff2') format('woff2'), url('../fonts/glyphicons-halflings-regular.woff') format('woff'), url('../fonts/glyphicons-halflings-regular.ttf') format('truetype'), url('../fonts/glyphicons-halflings-regular.svg#glyphicons_halflingsregular') format('svg');
}
@font-face {
    font-family: Exo2r;  Гарнитура шрифта 
    src: url(../fonts/Exo2-RegularCondensed.otf);  Путь к файлу со шрифтом 
}
@font-face {
    font-family: Exo2t;  Гарнитура шрифта 
    src: url(../fonts/Exo2-ThinCondensed.otf);  Путь к файлу со шрифтом 
}
@font-face {
    font-family: Exo2c;  Гарнитура шрифта 
    src: url('../fonts/Exo2-RegularCondensed.otf');
}
@font-face {
    font-family: Exo2sb;  Гарнитура шрифта 
    src: url('../fonts/Exo2-SemiBoldCondensed.otf');
}*/
			.p1 {
				font-family: Exo2t;
			}
			.p2 {
				font-family: Exo2r;
			}
			.p3 {
				font-family: Exo2sb;
			}
		</style>
	</head>
	<body>
		<p class='p3'>Современный элемент политического процесса</p>
		<p class='p2'>Современный элемент политического процесса</p>
		<p class='p1'>Современный элемент политического процесса</p>
		<button id="good_add"	type="button" class="btn btn-primary	btn-sm minw150 mb5"><span class="glyphicon glyphicon-plus mr5"></span>Добавить товар</button>
		<button id="import"		type="button" class="btn btn-lilac		btn-sm minw150 mb5"><span class="glyphicon glyphicon-import mr5"></span>Импорт CSV</button>
		<button id="export"		type="button" class="btn btn-warning	btn-sm minw150 mb5"><span class="glyphicon glyphicon-export mr5"></span>Експорт в CSV</button>
		<button id="delete"		type="button" class="btn btn-danger		btn-sm minw150 mb5"><span class="glyphicon glyphicon-trash mr5"></span>Удалить заказ</button>
		<button id="print"		type="button" class="btn btn-info		btn-sm minw150 mb5"><span class="glyphicon glyphicon-print mr5"></span>Печать заказа</button>
		<button id="state"		type="button" class="btn btn-success	btn-sm minw150 mb5" title="Отправить заказ поставщику?"><span class="glyphicon glyphicon-ok mr5"></span>В обработку</button>
	</body>
</html>