<?php
if (isset($_SESSION['UserID'])) {
	$cnn = new Cnn();
	$row = $cnn->user_info($_SESSION['UserID']);
} else {
	return;
}
?>
<script type="text/javascript">
$(document).ready(function(){
	// генерация капчи
	$('#captcha').attr('src', '/engine/captcha?' + Math.random());
	
	// диалоговое окно
	$("#dialog").dialog({
		autoOpen: false, modal: true, width: 400,
		buttons: [{text: "Закрыть", click: function () {
			$(this).dialog("close");
		}}],
		show: {effect: "explode", duration: 200},
	    hide: {effect: "explode", duration: 300}
	});
	
	// выбор темы сообщения
	var a_select_topic = [{id: 1, text: 'Найдена ошибка'}, {id: 2, text: 'Предложение'}, {id: 3, text: 'Пожелания'}, {id: 4, text: 'Прочее'}];
	$("#select_topic").select2({data: a_select_topic, placeholder: "Выберите тему"});
	
	// обработка кнопки "Отправить"
	$("#send_email").click(function(){
		err_msg = "";
		
		if($("#name").val().length < 1)	   err_msg += "<h4>- не указано имя</h4>";
		if($("#email").val().length < 1)   err_msg += "<h4>- не указан e-mail</h4>";
		if($("#select_topic").val() == "") err_msg += "<h4>- не указана тема сообщения";
		if($("#message").val().length < 1) err_msg += "<h4>- не введено сообщение</h4>";
		
		if(err_msg.length == ""){
			$.post("/engine/feedback",{
				email: $("#email").val(),
				fio: $("#name").val(),
				subject: $("span.select2-chosen").html(),
				message: $("#message").val(),
				captcha: $("#reg_captcha").val()
				}, function (json) {
						if(json.success != false){	
							//$("#dialog>#text").html("<h4>Сообщение успешно отправлено!</h4>");
							$("#dialog>#text").html(json.message);
							$("#dialog").dialog("open");

							$('#captcha').attr('src', '/engine/captcha?' + Math.random());
							$("#reg_captcha").val("");
							$("#select_topic").select2("val", -1);
							$("#message").val("");
						}else{
							$("#dialog>#text").html(json.message);
							$("#dialog").dialog("open");
						}
					}
			);
		}else{
			$("#dialog>#text").html(err_msg);
			$("#dialog").dialog("open");
		}
	});
})
</script>

<link href="/css/docs.min.css" rel="stylesheet">

<div class="container-fluid min530" id="contact-main-container">
	<div class="bs-docs-section w40p ml30">
		<div class="bs-callout bs-callout-info" id="parent_s2id_select_topic">
			<h3 style="color:#3F2DB1;margin-top:0px;">Вы можете отправить нам сообщение:</h3>
			<h4>Ваше имя:</h4>
			<input id="name" type="text" class="form-control TAL w100p" value="<?php echo $row['FIO']; ?>">
			
			<h4 style="margin-top:5px">Ваше E-mail:</h4>
			<input id="email" type="email" class="form-control TAL w100p" value="<?php echo $row['Email']; ?>">
			
			<h4 style="margin-top:5px">Тема сообщения:</h4>
			<div id="select_topic" class="w100p"></div>
			
			<h4 style="margin-top:8px">Сообщение:</h4>
			<textarea id="message" class="form-control w100p" rows="4"></textarea>

		<!-- КАПЧА -->
		<div style="margin-top:10px" class="input-group w100p">
				<span class="input-group-addon w25p p5 h75">Проверочный<br>код:</span>
				<img class="form-control w50p h75" src="" id="captcha"><br>
				<span class="input-group-addon w25p">
					<span id="refresh_captcha" class="glyphicon glyphicon-refresh" type="button" onclick="$('#captcha').attr('src', $('#captcha').attr('src')+'?'+Math.random());" style="font-size:21px"></span>
				</span>
			</div>
			<div class="input-group w100p">
				<span class="input-group-addon w25p p5"></span>
				<input id="reg_captcha" type="text" class="form-control w50p TAC" placeholder="Проверочный код" required>
				<span class="input-group-addon w25p"></span>
			</div>

		<button style="margin-top:10px" id="send_email" type="button" class="btn btn-success btn-sm minw150 mb5 w100p" title="Отправить"><span class="glyphicon glyphicon-ok mr5"></span>Отправить</button>
		</div>	
	</div>
	</div>

<div id="dialog" title="Отправка сообщения:">
    <p id='text'></p>
</div>

<style>
	body {
		background: url(/image/email.jpg) no-repeat;
		background-size: 40%;
		background-position-x: 85%;
		background-position-y: 60%;
	}
	
	#parent_s2id_select_topic {
		position: absolute;
	}
	
	#refresh_captcha{
		transition: 0.4s;
	}
	
	#refresh_captcha:hover{
		color: blue;
		cursor:pointer;
		transform: rotate(180deg);
		-moz-transform: rotate(180deg);
		-ms-transform: rotate(180deg);
		-webkit-transform: rotate(180deg);
		-o-transform: rotate(180deg);
	}
</style>