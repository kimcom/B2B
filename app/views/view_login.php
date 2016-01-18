<script src="/js/ajaxtcr.js" type="text/javascript"></script> 
<script src="/ulogin.ru/js/ulogin.js"></script>
<script type="text/javascript">
$(document).ready(function () {
$(document.body).css('padding-top', '0');
	
	preview = function(token){
		$.getJSON("//ulogin.ru/token.php?host=" + encodeURIComponent(location.toString()) + "&token=" + token + "&callback=?", function (data) {
			data = $.parseJSON(data.toString());
			if (!data.error) {
				$("#reg_username").val(data.nickname);
				$("#reg_email").val(data.email);
				$("#reg_fio").val(data.first_name + " " + data.last_name);
				$("#reg_phone").val(data.phone);
				$("#reg_pass").focus();
			}	
		});
	}
		
	var imgload = false;
	$("#img_main").load(function () {
	    imgload = true;
	    $(window).resize();
	});
	$(window).resize(function () {
	    if (!imgload) return;
	    dl = $("#div_logon").height();
	    scr = $(window).height();
	    imgh = $("#img_main").height();
	    if (imgh == 0)
		imgh = 999999;
	    h = Math.min(screen.height, $(window).height(), imgh);
	    //$("#log").html("|screen:"+screen.height+" |window:"+$(window).height()+" |imgh:"+imgh+" |logon:"+dl+" |h:"+h);
	    $("#div_logon").css("margin-top", (h - dl) / 2 + "px");
	    $("#div_logon").fadeIn(1000);
	});
	$("#div_main").keyup(function( event ) {
		if ( event.which == 13 || event.keyCode == 13) {
			if(event.target.id=='user') $("#pass").focus();
			if(event.target.id=='pass') $("#btn_logon").focus();
		}
		if ( event.which == 32 || event.keyCode == 32) if(event.target.id=='btn_logon') $("#btn_logon").click();
	});
	$("#div_forgot").keyup(function( event ) {
		if ( event.which == 13 || event.keyCode == 13) {
			if(event.target.id=='fgt_email') $("#btn_forgot").focus();
		}
	});
	$("#div_register").keyup(function( event ) {
		if ( event.which == 13 || event.keyCode == 13) {
			setfocus = false;
			$.each($("#div_register INPUT"),function (index, obj){
				if (event.target.id == 'reg_captcha') {$("#btn_register").focus();return false;}
				if (setfocus) {$(obj).focus();return false;}
				if (obj.id == event.target.id) setfocus = true;
			});
		}
	});
	$("#btn_logon").click(function (){
		sendRequest($("#user").val(),$("#pass").val());
	});
	$("a").click(function (){
		if(this.id=='a_register') {
			$("#div_register").dialog("open");
			$('#captcha').attr('src', '/engine/captcha?' + Math.random());
			$("#reg_username").focus();
		}
		if(this.id=='a_forgot') $("#div_forgot").dialog("open");
	});
	$("#dialog").dialog({
		autoOpen: false, modal: true, width: 400, //height: 300,
		buttons: [{text: "Закрыть", click: function () { $(this).dialog("close"); }}],
		show: {effect: "clip", duration: 500},
		hide: {effect: "clip", duration: 500}
    });
	$("#div_register").dialog({
		autoOpen: false, modal: true, width: 520, height: 'auto',
		show: {effect: "explode", duration: 1000},
		hide: {effect: "explode", duration: 1000},
		open: function( event, ui ) {$("[aria-describedby=div_register] > .ui-dialog-titlebar").remove();}
	});
	$("#div_forgot").dialog({
		autoOpen: false, modal: true, width: 410, height: 'auto',
		show: {effect: "explode", duration: 1000},
		hide: {effect: "explode", duration: 1000},
		open: function( event, ui ) {$("[aria-describedby=div_forgot] > .ui-dialog-titlebar").remove();}
	});
	$("#btn_forgot").click(function (){
		if ($("#fgt_email").val() == '') {
			$("#dialog").css('background-color','#FFE3E2');
			$("#dialog>#text").html('Укажите Ваш e-mail !');
			$("#dialog").dialog("open");
			return;
		}
		$.post("/login/forgot",{
				email: $("#fgt_email").val()
		    }, function (json) {
				//console.log(json);
				if (json.success) {
					$("#div_forgot").dialog("close");
					$("#dialog").css('background-color', '');
				} else {
					//console.log(json.sql);
					$("#dialog").css('background-color', '#FFE3E2');
				}
				$("#dialog>#text").html(json.message);
				$("#dialog").dialog("open");
	    });
    });
	
	$("#btn_register").click(function (){
		error = false; msg = "";
		$.each($("#div_register INPUT"),function (index, obj){
			if ($(obj).val()=='') {
				error = true;
				msg += 'Заполните поле: "'+$(obj).attr('placeholder')+'"<br><br>';
				$(obj).css('background-color', '#FFE3E2');
			}
		});
		if ($("#reg_pass").val()!=$("#reg_repass").val()) {
			error = true;
			msg += "Некорректный повтор пароля!";
		}
		if (error){
			$("#dialog").css('background-color','#FFE3E2');
			$("#dialog>#text").html(msg);
			$("#dialog").dialog("open");
			return;
		}
		$.post("/login/register",{
			username:	$("#reg_username").val(),
			email:		$("#reg_email").val(),
			userpass:	$("#reg_pass").val(),
			fio:		$("#reg_fio").val(),
			post:		$("#reg_post").val(),
			company:	$("#reg_company").val(),
			phone:		$("#reg_phone").val(),
			captcha:	$("#reg_captcha").val()
		}, function (json) {
			//console.log(json);
			if (json.success) {
				$('#captcha').attr('src','');
				$("#div_register").dialog("close");
				$("#dialog").css('background-color','');
				$("#user").val($("#reg_username").val());
				$("#pass").val($("#reg_pass").val());
				$.post("/login/sendmail",{
					email:		$("#reg_email").val(),
					fio:		$("#reg_fio").val(),
					captcha:	$("#reg_captcha").val()
				}, function (json) {	});
			}else{
				//console.log(json.sql);
				$("#dialog").css('background-color','#FFE3E2');
			}
			$("#dialog>#text").html(json.message);
			$("#dialog").dialog("open");
		});
	});

	setTimeout(function (){
	    imgload = true;
	    $(window).resize();
		if ($("#user").val()!='') $("#btn_logon").focus();
    }, 500);

	sendRequest = function (username, password) {
		var url = document.location.origin + "/login/logon";

		var options = {method: "GET", username: username, password: password,
			onSuccess: function (response) {
				result = response.xhr.responseText;
				if(result=='success'){
					document.location = document.location.origin + "/main/index";
				}else{
					$("#dialog").css('background-color','#FFE3E2');
					$("#dialog>#text").html(result);
					$("#dialog").dialog("open");
				}
			},
			onFail: function (response, message) {
				//console.log('fail',response,message);
			}
		};
		AjaxTCR.comm.sendRequest(url, options);
	}
});
</script>
<div id="div_main" class="container-fluid p0" style="z-index: 1000;">
	<img id="img_main" class="w100p" src="/image/gosprom_color.jpg">
	<div id="div_logon" class="carousel-caption-login maxw400 minw400" style="display: none;">
		<form>
		<h2 class="center m0 fontb">
			Добро пожаловать
		</h2>
		<h3 class="center m0 fontb">
			на сайт компании<br><?php echo $_SESSION['company']; ?>
		</h3>
		<h4 class="center fontb">
			система для оптовых покупателей
		</h4>
		<div class="form-group mb10 w200 floatL">
			<label class="sr-only" for="user">User name:</label>
			<input type="text"	   class="form-control maxw150 minw150 center-block" id="user" placeholder="Пользователь" required autofocus>
		</div>
		<div class="form-group mb10 w200 floatL">
			<label class="sr-only" for="pass">Password:</label>
			<input type="password" class="form-control maxw150 minw150 center-block" id="pass" placeholder="Пароль" required autofocus>
		</div>
		<div class="form-group mb10 w200 center-block floatL">
			<a id="a_register" class="font12 c0" href="#">Регистрация</a>
		</div>
		<div class="form-group mb10 w200 center-block floatL">
			<a id="a_forgot" class="font12 c0" href="#">Я забыл пароль</a>
		</div>
		<div class="form-group mb10 w400 center-block floatL">
			<button id="btn_logon" type="button" class="btn btn-lg btn-info w150 minw150 maxw150">Войти</button>
		</div>
		</form>
	</div>
	<div id="log"></div>
</div>
<div id="div_register" style="padding: 0; z-index: 2000;">
	<button type="button" onclick="$(this).parent().dialog('close');" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close" role="button" title="Закрыть" style="top:15px;z-index:1500;">
		<span class="ui-button-icon-primary ui-icon ui-icon-closethick"></span>
	</button>
	<div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons" 
		 style="position: relative; height: auto; width: 510px; left:50%; top:0%; margin-left:-255px; display: block; "
		 tabindex="-1">
		<h3 class="form-signin-heading center mt10 mb10">Регистрация нового пользователя<br><small>в системе компании <?php echo $_SESSION['company']; ?></small></h3>
		<div class="input-group w100p">
			<span class="input-group-addon w25p">Пользователь:</span>
			<input id="reg_username" type="text" class="form-control w50p" placeholder="Имя пользователя" required autofocus value="<?php echo $_REQUEST['login']; ?>">
			<span class="input-group-addon w25p"></span>
		</div>
		<div class="input-group w100p">
			<span class="input-group-addon w25p">E-mail:</span>
			<input id="reg_email" type="email" class="form-control w50p" placeholder="E-mail адрес" required value="<?php echo $_REQUEST['email']; ?>">
			<span class="input-group-addon w25p"></span>
		</div>
		<div class="input-group w100p">
			<span class="input-group-addon w25p">Пароль:</span>
			<input id="reg_pass" type="password" class="form-control w50p" placeholder="Пароль" required>
			<span class="input-group-addon w25p"></span>
		</div>
		<div class="input-group w100p">
			<span class="input-group-addon w25p p5">Снова пароль:</span>
			<input id="reg_repass" type="password" class="form-control w50p" placeholder="Повторите пароль" required>
			<span class="input-group-addon w25p"></span>
		</div>
		<div class="input-group w100p">
			<span class="input-group-addon w25p p5">Имя и фамилия:</span>
			<input id="reg_fio" type="text" class="form-control w50p" placeholder="Ваше Ф.И.О." required value="<?php echo $_REQUEST['fio']; ?>">
			<span class="input-group-addon w25p"></span>
		</div>
		<div class="input-group w100p">
			<span class="input-group-addon w25p p5">Должность:</span>
			<input id="reg_post" type="text" class="form-control w50p" placeholder="Ваша должность" required value="<?php echo $_REQUEST['post']; ?>">
			<span class="input-group-addon w25p"></span>
		</div>
		<div class="input-group w100p">
			<span class="input-group-addon w25p p5">Организация:</span>
			<input id="reg_company" type="text" class="form-control w50p" placeholder="Название Вашей фирмы" required value="<?php echo $_REQUEST['company']; ?>">
			<span class="input-group-addon w25p"></span>
		</div>
		<div class="input-group w100p">
			<span class="input-group-addon w25p p5">Ваш телефон:</span>
			<input id="reg_phone" type="text" class="form-control w50p" placeholder="Телефон" required value="<?php echo $_REQUEST['phone']; ?>">
			<span class="input-group-addon w25p"></span>
		</div>
		<div class="input-group w100p">
			<span class="input-group-addon w25p p5">Код:</span>
			<input id="reg_captcha" type="text" class="form-control w50p" placeholder="Проверочный код" required>
			<span class="input-group-addon w25p"></span>
		</div>
		<div class="input-group w100p">
			<span class="input-group-addon w25p p5 h75">Проверочный<br>код:</span>
			<img class="form-control w50p h75" src="" id="captcha"><br>
			<span class="input-group-btn w25p">
				<a class="btn btn-default w100p h75" type="button" onclick="$('#captcha').attr('src', $('#captcha').attr('src')+'?'+Math.random());"><span class="mt40">Обновить код</span></a>
			</span>
		</div>
		<div class="input-group center mt5 w100p">
			<div id="uLogin" data-ulogin="
				display=panel;
				optional=nickname,email,first_name,last_name,bdate,sex,phone,photo,city,country,manual;
				providers=vkontakte,odnoklassniki,facebook,twitter,google,mailru;
				redirect_uri=;
				callback=preview">
			</div>
		</div>
		<button id="btn_register" class="btn btn-lg btn-primary btn-block" type="button">Регистрация</button>
	</div>
</div>
<div id="div_forgot" style="padding: 0;z-index: 2000;">
	<button type="button" onclick="$(this).parent().dialog('close');" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close" role="button" title="Закрыть" style="top:15px;z-index:1500;">
		<span class="ui-button-icon-primary ui-icon ui-icon-closethick"></span>
	</button>
	<div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons" 
		 style="position: relative; height: auto; width: 400px; left:50%; top:0%; margin-left:-200px; display: block;"
		 tabindex="-1">
		<h3 class="form-signin-heading center">Восстановление пароля<br><small> для входа в систему компании <?php echo $_SESSION['company']; ?></small></h3>
		<div class="input-group w100p mt20">
			<h4 class='center list-group-item list-group-item-info m0'>
				ВНИМАНИЕ!<br><small>Для восстановления пароля
					введите Ваш e-mail<br>и нажмите <НАПОМНИТЬ>!</small></h4>
		</div>
		<div class="input-group w100p mt10">
			<span class="input-group-addon w25p">E-mail:</span>
			<input id="fgt_email" type="email" class="form-control w50p" placeholder="E-mail адрес" required autofocus value="">
			<span class="input-group-addon w25p"></span>
		</div>
		<button id="btn_forgot" class="btn btn-lg btn-primary btn-block mt10" type="button">Напомнить</button>
	</div>
</div>

<div id="dialog" title="Авторизация в системе компании <?php echo $_SESSION['company']; ?>">
	<p id='text'></p>
</div>
