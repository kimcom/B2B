<link href="/css/docs.min.css" rel="stylesheet">
<div class="container bs-docs-container">
	<h3 class="mt0">История изменений в системе B2B</h3>
	<ul id="myTab" class="nav nav-tabs floatL active hidden-print" role="tablist">
		<li class="active"><a href="#tab_20160609" role="tab" data-toggle="tab">2016-06-09</a></li>
		<li class="0active"><a href="#tab_20160429" role="tab" data-toggle="tab">2016-04-29</a></li>
		<li class="0active"><a href="#tab_20160220" role="tab" data-toggle="tab">2016-02-20</a></li>
		<li class="0active"><a href="#tab_20160213" role="tab" data-toggle="tab">2016-02-13</a></li>
		<li class="0active"><a href="#tab_20160212" role="tab" data-toggle="tab">2016-02-12</a></li>
		<li class="0active"><a href="#tab_20160210" role="tab" data-toggle="tab">2016-02-10</a></li>
		<li class="0active"><a href="#tab_20160201" role="tab" data-toggle="tab">2016-02-01</a></li>
		<li class="0active"><a href="#tab_20160125" role="tab" data-toggle="tab">2016-01-25</a></li>
		<li class="0active"><a href="#tab_20160119" role="tab" data-toggle="tab">2016-01-19</a></li>
	</ul>
	<div class="tab-content">
		<div id="tab_20160609" class="tab-pane w100p min500 ui-corner-all borderColor frameL border1 active">
			<div class="bs-docs-section m10">
				<h4 class="m0 mt5">Раздел: Прайс</h4>
				<div class="bs-callout bs-callout-info text-left ml20">
					<h4>Статус: Добавление</h4>
					<h4>Реализовано API (application programming interface)</h4>
					<ul class='list-unstyled 0font12 m0 mt5'>
						<li class='m0'>
							<ul>
								<li>Возможны варианты получения прайса в интерактивном режиме
									<ul>
										<li>Прайс в виде файла - формат CSV<br>
										</li>
										<li>Прайс в виде текста - формат CSV<br>
										</li>
										<li>Прайс в виде объекта - формат JSON<br>
										</li>
									</ul>
								</li><br>
								<li>ВНИМАНИЕ!<br>
									Файл генерируется от 2 до 5 секунд.<br>
									Информация об остатках товаров и ценах обновляется каждые 2 часа.<br>
									Информация о Ваших скидках обновляется только по воскресениям в 2:00.
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div id="tab_20160429" class="tab-pane w100p min500 ui-corner-all borderColor frameL border1">
			<div class="bs-docs-section m10">
				<h4 class="m0 mt5">Раздел: Накладные</h4>
				<div class="bs-callout bs-callout-info">
					<h4>Статус: Добавление</h4>
					<ul class='list-unstyled 0font12 m0 mt5'>
						<li class='m0'>
							<ul><br>
								<li>Создан раздел "Накладные"</li><br>
								<li>В данном разделе пользователи системы B2B<br>
									имеют возможность видеть свои накладные,<br>
									а также могут выгружать накладные в формате CSV
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div id="tab_20160220" class="tab-pane w100p min500 ui-corner-all borderColor frameL border1">
			<div class="bs-docs-section m10">
				<h4 class="m0 mt5">Раздел: Каталог</h4>
				<div class="bs-callout bs-callout-info">
					<h4>Статус: Добавление</h4>
					<ul class='list-unstyled 0font12 m0 mt5'>
						<li class='m0'>Таблица `Список товаров`:
							<ul>
								<li>Добавлена колонка `Бренд`</li>
								<li>Добавлена колонка `Цена ОПТ`</li>
							</ul>
						</li>
					</ul>
				</div>
				<div class="bs-callout bs-callout-info">
					<h4>Статус: Добавление</h4>
					<ul class='list-unstyled 0font12 m0 mt5'>
						<li class='m0'>Таблица `Заказ`:
							<ul>
								<li>Добавлена колонка `Цена`.</li>
								<li>Добавлена колонка `Сумма`.</li>
							</ul>
						</li>
					</ul>
				</div>
				<div class="bs-callout bs-callout-danger">
					<h4>Статус: Изменения</h4>
					<ul class='list-unstyled 0font12 m0 mt5'>
						<li class='m0'>Таблица `Список товаров`:
							<ul>
								<li>При наборе заказа менеджером, теперь показывает цену со скидкой клиента.</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div id="tab_20160213" class="tab-pane w100p min500 ui-corner-all borderColor frameL border1 0active">
			<div class="bs-docs-section m10">
				<h4 class="m0 mt5">Раздел: Заказы</h4>
				<div class="bs-callout bs-callout-info">
					<h4>Статус: Добавление</h4>
					<ul class='list-unstyled 0font12 m0 mt5'>
						<li class='m0'>Вкладка `Текущий заказ`:
							<ul>
								<li>Добавлено поле выбора заказчика.</li>
								<li>Добавлено информационное поле `Автор`.</li>
								<li>ВНИМАНИЕ!<ul>
										<li>Только сотрудники компании могут менять заказчика<br>
											для пользователей партнеров эта функция запрещена!
										</li>
									</ul>
								</li>
							</ul>
						</li>
					</ul>
				</div>
				<div class="bs-callout bs-callout-info">
					<h4>Статус: Добавление</h4>
					<ul class='list-unstyled 0font12 m0 mt5'>
						<li class='m0'>Вкладка `Предварительные заказы`:
							<ul>
								<li>В списке заказов добавлены колонки `Партнер` и `Автор`.</li>
								<li>В списке заказов для сотрудников компании отображаются заказы всех партнеров.</li>
								<li>Для сотрудников компании добавлена возможность корректировки любого заказа.</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div id="tab_20160212" class="tab-pane w100p min500 ui-corner-all borderColor frameL border1 0active">
			<div class="bs-docs-section m10">
				<h4 class="m0 mt5">Раздел: Вход в систему</h4>
				<div class="bs-callout bs-callout-danger">
					<h4>Статус: Изменение</h4>
					<ul class='list-unstyled 0font12 m0 mt5'>
						<li class='m0'>Форма идентификации пользователя:
							<ul>
								<li>Исправлена ошибка входа в систему через браузер Mozilla FireFox.
								</li>
								<li>ВНИМАНИЕ!<ul>
										<li>Ошибка проявляется только для пользователей,<br>
											у которых логин в систему содержит кириллицу (русские буквы)!
										</li>
										<li>Рекомендуется при регистрации в имени пользователя<br>
											использовать только латиницу!
										</li>
									</ul>
								</li>
							</ul>
						</li>
					</ul>
				</div>
				<h4 class="m0 mt5">Раздел: обратная связь</h4>
				<div class="bs-callout bs-callout-info">
					<h4>Статус: Добавление</h4>
					<ul class='list-unstyled 0font12 m0 mt5'>
						<li class='m0'>Форма обратной связи:
							<ul>
								<li>Реализована возможность отправки сообщения разработчику
								</li>
								<li>Форма доступна при нажатии на меню "Связаться с нами"
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div id="tab_20160210" class="tab-pane w100p min500 ui-corner-all borderColor frameL border1 0active">
			<div class="bs-docs-section m10">
				<h4 class="m0 mt5">Раздел: Управление пользователями</h4>
				<div class="bs-callout bs-callout-info">
					<h4>Статус: Добавление</h4>
					<ul class='list-unstyled 0font12 m0 mt5'>
						<li class='m0'>Форма идентификации клиента менеджером:
							<ul>
								<li>После регистрации пользователя сервер уведомляет по e-mail сотрудников компании.<br>
									В письме присутствует ссылка на форму идентификации.<br>
									Сотрудник компании должен выполнить идентификацию клиента, т.е.<br>
									перейти по ссылке и указать компанию клиента, склад отгрузки и прочую информацию.
								</li>
								<li>ВНИМАНИЕ!<ul>
										<li>После выполнения идентификации необходимо нажать кнопку "СОХРАНИТЬ ДАННЫЕ"!</li>
									</ul>
								</li>
							</ul>
						</li>
					</ul>
				</div>
				<h4 class="m0 mt5">Раздел: обмен данными</h4>
				<div class="bs-callout bs-callout-info">
					<h4>Статус: Добавление</h4>
					<ul class='list-unstyled 0font12 m0 mt5'>
						<li class='m0'>Выгрузка в 1С:
							<ul>
								<li>После формирования заказа пользователь нажимает кнопку "В обработку" -
									заказ получает статус "Отправлен".<br>
									Пользователь больше не сможет вносить изменения в этот заказ.
								</li>
								<li>В программе 1С (меню Сервис/Заказы B2B) - 
									сотрудники компании могут видеть и загружать заказы со статусом "Отправлен".<br>
									Автоматическая загрузка заказов происходит каждые 5 минут.
									Заказы получают статус "Загружен в 1С".<br>
								</li>
								<li>В 1С после проведения документа "Заказ покупателя" -
									заказ получает статус "Обработан".
								</li>
								<li>В 1С после формирования и проведения РН -
									заказ получает статус "Отгружен".
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div id="tab_20160201" class="tab-pane w100p min500 ui-corner-all borderColor frameL border1 0active">
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
	