<?php
$uid = null;
if ($_SESSION['AccessLevel']<100) {
	if (isset($_SESSION['UserID'])) {
		$uid = $_SESSION['UserID'];
	}
} else {
	if (isset($_REQUEST['uid'])) {
		$uid = $_REQUEST['uid'];
	} else {
		if (isset($_SESSION['UserID'])) $uid = $_SESSION['UserID'];
	}
}
if ($uid==null) return;
$href1 = "http://".$_SERVER['HTTP_HOST']."/api/price.csv?auth=".$_SESSION['Auth'];
$href2 = "http://".$_SERVER['HTTP_HOST']."/api/price.json?auth=".$_SESSION['Auth'];

//$cnn = new Cnn();
//$row = $cnn->user_info($uid);
//$mode_user = '';$mode_manager = 'true';
//if ($uid == $_SESSION['UserID'] && $_SESSION['AccessLevel']<100) $mode_manager = 'false';
//if ($uid != $_SESSION['UserID']) $mode_user = 'disabled';
?>
<link href="/css/docs.min.css" rel="stylesheet">
<script type="text/javascript">
$(document).ready(function () {
//	var mode_manager = <?php echo $mode_manager;?>;
	$("#dialog").dialog({
	    autoOpen: false, modal: true, width: 400,
	    buttons: [{text: "Закрыть", click: function () {
		$(this).dialog("close");
	    }}]
	});

	$("#button_save").click(function(){
		password = '';
		if($("#password_new1").val().length > 0){
			if ($("#password_new1").val() === $("#password_new2").val()){
				password = $("#password_new1").val();
			}else{
				$("#dialog>#text").html("Ошибка при изменении пароля:<br> неправильный повтор пароля!");
				$("#dialog").dialog("open");
			}
		}
		
		$.post('../engine/user_info_save', {
			username: $("#userName").html(),
			userpass: password,
			email: $("#eMail").val(),
			fio: $("#fio").val(),
			post: $("#post").val(),
			companyID: $("#select_companyID").val(),
			company: $("#company").val(),
			phone: $("#userPhone").val(),
			userID: $("#userID").html(),
			accesslevel: $("#accessLevel").val(),
			viewRemain: $("#select_viewRemain").val(),
			storeID: $("#select_storeID").val(),
		}, function(json){
			if (!json.success) {
				$("#dialog").css('background-color', 'linear-gradient(to bottom, #f7dcdb 0%, #c12e2a 100%)');
				$("#dialog>#text").html(json.message);
				$("#dialog").dialog("open");
			} else {
				if (json.reload) window.location.href = window.location.href;
				$("#dialog>#text").html("Данные успешно сохранены!");
				$("#dialog").dialog("open");
				
			}
		});
	});
	
//	var a_storeID = [{id: 17, text: 'Харьковский склад'}, {id: 23, text: 'Киевский склад'}];
//	$("#select_storeID").select2({data: a_storeID, placeholder: "Выберите склад отгрузки"});
//	$("#select_storeID").select2("val", <?php echo $row['StoreID']; ?>);
//	$("#select_storeID").select2("enable", mode_manager);
//
//	var a_ID = [{id: 0, text: 'по шкале <10 <100'}, {id: 1, text: 'показать количество'}];
//	$("#select_viewRemain").select2({data: a_ID, placeholder: "Выберите вариант"});
//	$("#select_viewRemain").select2("val", <?php echo $row['ViewRemain']; ?>);
//	$("#select_viewRemain").select2("enable", mode_manager);
//
//	$.post('/engine/select2?action=partners_b2b', function (json) {
//		$("#select_companyID").select2({enable:false, multiple: false, placeholder: "Укажите фирму для пользователя", data: {results: json, text: 'text'}});
//		$("#select_companyID").select2("val", <?php echo $row['CompanyID']; ?>);
//		$("#select_companyID").select2("enable", mode_manager);
//    });
});
</script>

<div class="container center min300">
	<ul id="myTab" class="nav nav-tabs floatL active hidden-print" role="tablist">
		<li class="active">	<a id="a_tab_0" href="#tab_content" role="tab" data-toggle="tab">Прайс-лист</a></li>
	</ul>
	<div class="tab-content">
		<div class="active tab-pane min530 m0 w100p ui-corner-tab1 borderColor frameL border1" id="tab_content">
			<div class='p5 ui-corner-all frameL border0 w700'>
				<div class="hidden-print mt5">
					<a class="btn btn-success active" role="button" href="<?php echo $href1 . '&v=1'; ?>"><span class="glyphicon glyphicon-save	mr5"></span>Получить прайс CSV</a>
				</div>
				<div class="bs-callout bs-callout-info text-left ml20">
					<h4>Описание API (application programming interface)</h4>
					<ul class='list-unstyled 0font12 m0 mt5'>
						<li class='m0'>
							<ul>
								<li>Возможны варианты получения прайса в интерактивном режиме
									<ul>
										<li>Ваша ссылка на получение прайса в виде файла - формат CSV<br>
											<a id="a_price" href="<?php echo $href1.'&v=1';?>"><?php echo $href1.'&v=1'; ?></a>
										</li>
										<li>Ваша ссылка на получение прайса в виде текста - формат CSV<br>
											<a id="a_price" href="<?php echo $href1.'&v=2';?>"><?php echo $href1.'&v=2'; ?></a>
										</li>
										<li>Ваша ссылка на получение прайса в виде объекта - формат JSON<br>
											<a id="a_price" href="<?php echo $href2;?>"><?php echo $href2; ?></a>
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
	</div>
</div>
<div id="dialog" title="ВНИМАНИЕ!">
    <p id='text'></p>
</div>
