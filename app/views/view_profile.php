<?php
if (isset($_SESSION['UserID'])) {
	$cnn = new Cnn();
	$row = $cnn->user_info($_SESSION['UserID']);
} else {
	return;
}
?>
<script type="text/javascript">
$(document).ready(function () {
	$("#dialog").dialog({
	    autoOpen: false, modal: true, width: 400,
	    buttons: [{text: "Закрыть", click: function () {
		$(this).dialog("close");
	    }}]
	});

	$("#button_save").click(function(){
		password = $("#userPass").html();
		
		if($("#password_new1").val().length > 0){
			if ($("#password_new1").val() == $("#password_new2").val()){
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
			companyID: $("#companyID").val(),
			company: $("#company").val(),
			phone: $("#userPhone").val(),
			userID: $("#userID").html(),
			accesslevel: $("#accessLevel").html(),
			storeID: $("#select_storeID").val(),
		}, function(){
			$("#dialog>#text").html("Данные успешно сохранены!");
			$("#dialog").dialog("open");
		});
	});
	
	var a_storeID = [{id: 17, text: 'Харьковский склад'}, {id: 23, text: 'Киевский склад'}];
		$("#select_storeID").select2({data: a_storeID, placeholder: "Выберите статус"});
	    $("#select_storeID").select2("val", <?php echo $row['StoreID']; ?>);
});
</script>

<div class="container-fluid">
<?php
if ($_SESSION['ClientID'] != 0) {
?>
	<ul id="myTab" class="nav nav-tabs floatL active hidden-print" role="tablist">
	        <li class="active">
				<a href="#tab_filter" role="tab" data-toggle="tab" style="padding-top: 5px; padding-bottom: 5px;">
				<legend style="margin-bottom: 0">Профиль</legend>
			
				</a>
			</li>
	    </ul>
	    <div class="floatL">
	        <button id="button_save" class="btn btn-sm btn-primary frameL m0 h40 hidden-print font14">
				<span class="ui-button-text" style='width:120px;height:30px;'>Сохранить данные</span>
	        </button>
	    </div>
	    <div class="tab-content">
	        <div class="active tab-pane min530 m0 w100p ui-corner-all borderTop1 borderColor frameL border1" id="tab_filter">
	            <div class='p5 ui-corner-all frameL border0 w500' style='display1:table;'>

	                <div class="input-group input-group-sm w100p">
	                    <span class="input-group-addon w25p TAL">ID пользователя:</span>
	                    <span id="userID" name="userID" type="text" class="input-group-addon form-control TAL"><?php echo $row['UserID']; ?></span>
	                    <span class="input-group-addon w20p"></span>
	                </div>
	                <div class="input-group input-group-sm w100p">
	                    <span class="input-group-addon w25p TAL">Логин:</span>
						<span id="userName" name="userName" class="input-group-addon form-control TAL"><?php echo $row['Username']; ?></span>                   
	                    <span class="input-group-addon w20p"></span>
	                </div>
					<div class="input-group input-group-sm w100p">
							<span class="input-group-addon w25p TAL">Пароль</span>
							<span id="userPass" type="userPass" class="form-control TAL" disabled><?php echo $row['Userpass']; ?></span>
							<span class="input-group-addon w20p"></span>
					</div>
					<div class="input-group input-group-sm w100p">
						<span class="input-group-addon w25p TAL">Новый пароль</span>
						<input id="password_new1" name="password_new1" type="password" class="form-control TAL" placeholder="Новый пароль" value="">
						<span class="input-group-addon w20p"></span>
					</div>
					<div class="input-group input-group-sm w100p">
						<span class="input-group-addon w25p TAL">Повтор пароля</span>
						<input id="password_new2" name="password_new2" type="password" class="form-control" placeholder="Повторите пароль" TAL value="">
						<span class="input-group-addon w20p"></span>
					</div>
	                <div class="input-group input-group-sm w100p">
	                    <span class="input-group-addon w25p TAL">ФИО</span>
	                    <input id="fio" name="fio" type="text" class="form-control TAL" value="<?php echo $row['FIO']; ?>"  >
	                    <span class="input-group-addon w20p"></span>
	                </div>            
	                
					
					<div class="input-group input-group-sm w100p">
						<span class="input-group-addon w25p TAL">Компания:</span>
						<input id="company" name="company" type="text" class="form-control TAL" value="<?php echo $row['Company']; ?>">
						<span class="input-group-addon w20p"></span>
					</div>
					<div class="input-group input-group-sm w100p">
						<span class="input-group-addon w25p TAL">ID компании:</span>
						<input id="companyID" name="companyID" type="text" class="form-control TAL" value="<?php echo $row['CompanyID']; ?>">
						<span class="input-group-addon w20p"></span>
					</div>
	                <div class="input-group input-group-sm w100p">
	                    <span class="input-group-addon w25p TAL">Должность:</span>
	                    <input id="post" name="post" type="text" class="form-control TAL" value="<?php echo $row['Post']; ?>">
	                    <span class="input-group-addon w20p"></span>
	                </div>
					<div class="input-group input-group-sm w100p">
						<span class="input-group-addon w25p TAL">E-mail:</span>
						<input id="eMail" name="eMail" type="text" class="form-control TAL" value="<?php echo $row['Email']; ?>">
						<span class="input-group-addon w20p"></span>
					</div>
	                <div class="input-group input-group-sm w100p">
	                    <span class="input-group-addon w25p TAL">Телефон:</span>
	                    <input id="userPhone" name="userPhone" type="text" class="form-control TAL" value ="<?php echo $row['Phone']; ?>">
	                    <span class="input-group-addon w20p"></span>
	                </div>
	                <div class="input-group input-group-sm w100p">
	                    <span class="input-group-addon w25p TAL">Уровень доступа:</span>
	                    <span id="accessLevel" name="accessLevel" type="text"  class="input-group-addon form-control TAL" value=""><?php echo $row['AccessLevel']; ?></span>
	                    <span class="input-group-addon w20p"></span>
	                </div>
					<div class="input-group input-group-sm w100p">
						<span class="input-group-addon w25p TAL">Склад:</span><div id="select_storeID" class="w100p"></div>
						<span class="input-group-addon w20p"></span>
					</div>
	            </div>
	        </div>
	    </div>
<?php
}
?>
</div>
<div id="dialog" title="ВНИМАНИЕ!">
    <p id='text'></p>
</div>
<style>
	/*select_storeID*/
</style>
