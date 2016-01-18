<link href="/css/docs.min.css" rel="stylesheet">
<div class="container bs-docs-container">
	<h3 class="mt0">Используемые элементы</h3>
	<ul id="myTab" class="nav nav-tabs floatL active hidden-print" role="tablist">
		<li class="active"><a href="#tab_1" role="tab" data-toggle="tab">Buttons</a></li>
		<li class="0active"><a href="#tab_2" role="tab" data-toggle="tab">Messages</a></li>
	</ul>
	<div class="tab-content">
		<div id="tab_1" class="tab-pane w100p min500 ui-corner-all borderColor frameL border1 active">
			<div class="bs-docs-section m10">
				<button id="state"		type="button" class="btn btn-success	btn-sm minw150 mb5" title="Отправить заказ поставщику?"><span class="glyphicon glyphicon-ok mr5"></span>В обработку</button>
				<button id="print"		type="button" class="btn btn-info		btn-sm minw150 mb5"><span class="glyphicon glyphicon-print mr5"></span>Печать заказа</button>
				<button id="export"		type="button" class="btn btn-warning	btn-sm minw150 mb5"><span class="glyphicon glyphicon-export mr5"></span>Експорт в CSV</button>
				<button id="import"		type="button" class="btn btn-lilac		btn-sm minw150 mb5"><span class="glyphicon glyphicon-import mr5"></span>Импорт CSV</button>
				<button id="delete"		type="button" class="btn btn-danger		btn-sm minw150 mb5"><span class="glyphicon glyphicon-trash mr5"></span>Удалить заказ</button>
				<button id="good_add"	type="button" class="btn btn-primary	btn-sm minw150 mb5"><span class="glyphicon glyphicon-plus mr5"></span>Добавить товар</button>
				<button id="good_add"	type="button" class="btn btn-default	btn-sm minw150 mb5"><span class="glyphicon glyphicon-plus mr5"></span>Добавить товар</button>
				<button id="good_add"	type="button" class="btn btn-blue	btn-sm minw150 mb5"><span class="glyphicon glyphicon-plus mr5"></span>...</button>
				<button id="good_add"	type="button" class="btn btn-gray	btn-sm minw150 mb5"><span class="glyphicon glyphicon-plus mr5"></span>...</button>
				<button id="good_add"	type="button" class="btn btn-orange	btn-sm minw150 mb5"><span class="glyphicon glyphicon-plus mr5"></span>...</button>
				<button id="good_add"	type="button" class="btn btn-orangel	btn-sm minw150 mb5"><span class="glyphicon glyphicon-plus mr5"></span>...</button>
				<button id="good_add"	type="button" class="btn btn-pink	btn-sm minw150 mb5"><span class="glyphicon glyphicon-plus mr5"></span>...</button>
				<button id="good_add"	type="button" class="btn btn-yellow	btn-sm minw150 mb5"><span class="glyphicon glyphicon-plus mr5"></span>...</button>
				<button id="good_add"	type="button" class="btn btn-purple	btn-sm minw150 mb5"><span class="glyphicon glyphicon-plus mr5"></span>...</button>
			</div>
		</div>
		<div id="tab_2" class="tab-pane w100p min500 ui-corner-all borderColor frameL border1 0active">
			<div class="bs-docs-section m10">
				<h4 class="m0 mt5">Раздел: Каталог</h4>
				<div class="bs-callout bs-callout-info">
					<h4>Статус: Добавление</h4>
					<p>В списке товаров после внесения кол-ва по кнопке "Enter" реализован переход на след. строку</p>
				</div>
				<div class="bs-callout bs-callout-info">
					<h4>Статус: Добавление</h4>
					<p>В список товара добавлены колонки РРЦ (рек.розн.цена), Наценка, остаток по Харькову и остаток по Киеву</p>
				</div>
				<div class="bs-callout bs-callout-danger">
					<h4>Статус: Изменение</h4>
					<p>Реализовано отражение остатков по шкале <10, <100, >100</p>
					<p>Реализовано отражение остатков в единицах, для лояльных клиентов</p>
				</div>
				<div class="bs-callout bs-callout-info">
					<h4>Статус: Добавление</h4>
					<p>Реализована возможность менять размер списка товаров и категорий/групп товаров.</p>
				</div>
			</div>
		</div>
	</div>
</div>
	