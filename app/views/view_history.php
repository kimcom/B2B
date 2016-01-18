<link href="/css/docs.min.css" rel="stylesheet">
<div class="container bs-docs-container">
	<h3 class="mt0">История изменений в системе B2B</h3>
	<ul id="myTab" class="nav nav-tabs floatL active hidden-print" role="tablist">
		<li class="active"><a href="#tab_20160201" role="tab" data-toggle="tab">2016-02-01</a></li>
		<li class="0active"><a href="#tab_20160125" role="tab" data-toggle="tab">2016-01-25</a></li>
		<li class="0active"><a href="#tab_20160119" role="tab" data-toggle="tab">2016-01-19</a></li>
	</ul>
	<div class="tab-content">
		<div id="tab_20160201" class="tab-pane w100p min500 ui-corner-all borderColor frameL border1 active">
			<div class="bs-docs-section m10">
				<h4 class="m0 mt5">Раздел: Каталог</h4>
				<div class="bs-callout bs-callout-danger">
					<h4>Статус: Изменение</h4>
					<ul class='list-unstyled 0font12 m0 mt5'>
						<li class='m0'>Реализована возможность поиска в нескольких категориях:
							<ul>
								<li>Если установлен поиск по категории, 
									в списке категорий можно отметить галочками 
									несколько категорий.<br>
									После выбора нужных категорий поиск товаров по артикулу или наименованию<br>
									будет происходить только в указанных категориях товаров.
								</li>
							</ul>
						</li>
					</ul>
				</div>
				<div class="bs-callout bs-callout-danger">
					<h4>Статус: Изменение</h4>
					<ul class='list-unstyled 0font12 m0 mt5'>
						<li class='m0'>Список товаров:
							<ul>
								<li>Если в заказе уже есть товары, то при отображении
									этих товаров в списке<br>- выводиться количество, 
									которое уже внесено	в текущий заказ.</li>
								<li>При изменении количества товара в списке<br>- количество будет также изменено и в текущем заказе.</li>
							</ul>
						</li>
					</ul>
				</div>
				<h4 class="m0 mt5">Раздел: Заказы</h4>
				<div class="bs-callout bs-callout-info">
					<h4>Статус: Добавление</h4>
					<ul class='list-unstyled 0font12 m0 mt5'>
						<li class='m0'>Вкладка предварительные заказы:
							<ul>
								<li>В списке заказов при двойном клике на строке
									- заказ открывается для редактирования.
								</li>
								<li>ВНИМАНИЕ!<ul>
										<li>Текущим заказом назначается выбранный для редактирования заказ.</li>
									</ul>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div id="tab_20160125" class="tab-pane w100p min500 ui-corner-all borderColor frameL border1 0active">
			<div class="bs-docs-section m10">
				<h4 class="m0 mt5">Раздел: Каталог</h4>
				<div class="bs-callout bs-callout-info">
					<h4>Статус: Добавление</h4>
					<ul class='list-unstyled 0font12 m0 mt5'>
						<li class='m0'>Реализована возможность настройки пользователем, следующих параметров:
							<ul>
								<li>Высота и ширина `Категорий товаров`</li>
								<li>Высота и ширина `Списка товаров`</li>
								<li>Настройки видимости колонок в `Списке товаров`</li>
								<li>Настройки ширины колонок в `Списке товаров`</li>
								<li>Настройка поиска в `Списке товаров`</li>
								<li>ВНИМАНИЕ!<ul>
										<li>Эти настройки доступны при нажатии кнопки `Настройки`, которая находиться вверху списка товаров</li>
										<li>Настройки ширины и высоты `Категорий товаров` и `Списка товаров` выполняються мышкой</li>
									</ul>
								</li>
							</ul>
						</li>
					</ul>
				</div>
				<div class="bs-callout bs-callout-danger">
					<h4>Статус: Изменение</h4>
					<ul class='list-unstyled 0font12 m0 mt5'>
						<li class='m0'>Внесены изменения в алгоритм поиска товаров:
							<ul>
								<li>Если установлен глобальный поиск:
									при наборе артикула или наименования товара
									- поиск выполняется по всем товарам.</li>
								<li>Если установлен поиск по категории:
									при наборе артикула или наименования товара
									- поиск выполняется только по выбранной категории.</li>
							</ul>
						</li>
					</ul>
				</div>
				<div class="bs-callout bs-callout-info">
					<h4>Статус: Добавление</h4>
					<ul class='list-unstyled 0font12 m0 mt5'>
						<li class='m0'>Реализована возможность сохранения настроек пользователя:
							<ul>
								<li>ВНИМАНИЕ!<br>
									Сохранение настройки выполняется при нажатии кнопки `Сохранить`, которая находиться в `Настройках каталога`.</li>
								<li>Настройки ширины и высоты `Категорий товаров` и `Списка товаров` выполняються мышкой <br>
									и должны быть выполнены до нажатия кнопки `Сохранить`.
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div id="tab_20160119" class="tab-pane w100p min500 ui-corner-all borderColor frameL border1 0active">
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
	