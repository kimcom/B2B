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
$cnn = new Cnn();
$row = $cnn->user_info($uid);
$mode_user = '';$mode_manager = 'true';
if ($uid == $_SESSION['UserID'] && $_SESSION['AccessLevel']<100) $mode_manager = 'false';
if ($uid != $_SESSION['UserID']) $mode_user = 'disabled';
?>
<script type="text/javascript">
$(document).ready(function () {
	var mode_manager = <?php echo $mode_manager;?>;
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
	
	var a_storeID = [{id: 17, text: 'Харьковский склад'}, {id: 23, text: 'Киевский склад'}];
	$("#select_storeID").select2({data: a_storeID, placeholder: "Выберите склад отгрузки"});
	$("#select_storeID").select2("val", <?php echo $row['StoreID']; ?>);
	$("#select_storeID").select2("enable", mode_manager);

	var a_ID = [{id: 0, text: 'по шкале <10 <100'}, {id: 1, text: 'показать количество'}];
	$("#select_viewRemain").select2({data: a_ID, placeholder: "Выберите вариант"});
	$("#select_viewRemain").select2("val", <?php echo $row['ViewRemain']; ?>);
	$("#select_viewRemain").select2("enable", mode_manager);

    function formatRepo (repo) {
      if (repo.loading) return repo.text;

      var markup = "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__avatar'><img src='" + repo.owner.avatar_url + "' /></div>" +
        "<div class='select2-result-repository__meta'>" +
          "<div class='select2-result-repository__title'>" + repo.full_name + "</div>";

      if (repo.description) {
        markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
      }

      markup += "<div class='select2-result-repository__statistics'>" +
			"<div class='select2-result-repository__forks'><i class='fa fa-flash'></i> " + repo.forks_count + " Forks</div>" +
			"<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> " + repo.stargazers_count + " Stars</div>" +
			"<div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> " + repo.watchers_count + " Watchers</div>" +
			"</div>" +
			"</div></div>";

		return markup;
	    }
    function formatRepoSelection(repo) {
		return repo.full_name || repo.text;
	    }
		
	$(".js-data-example-ajax").select2({
	  ajax: {
		url: "https://api.github.com/search/repositories",
		dataType: 'json',
		delay: 250,
		data: function (params) {
		  return {
			q: params.term, // search term
			page: params.page
		  };
		},
		processResults: function (data, params) {
		  // parse the results into the format expected by Select2
		  // since we are using custom formatting functions we do not need to
		  // alter the remote JSON data, except to indicate that infinite
		  // scrolling can be used
		  params.page = params.page || 1;

		  return {
			results: data.items,
				pagination: {
					more: (params.page * 30) < data.total_count
				}
			};
		},
		cache: true
	    },
	    escapeMarkup: function (markup) {
		return markup;
	    }, // let our custom formatter work
	    minimumInputLength: 1,
	    templateResult: formatRepo, // omitted for brevity, see the source of this page
	    templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
	});



	$.post('/engine/select2?action=partners_b2b', function (json) {
		$("#select_companyID").select2({enable:false, multiple: false, placeholder: "Укажите фирму для пользователя", data: {results: json, text: 'text'}});
		$("#select_companyID").select2("val", <?php echo $row['CompanyID']; ?>);
		$("#select_companyID").select2("enable", mode_manager);
    });

});
</script>

<div class="container center min300">
	<ul id="myTab" class="nav nav-tabs floatL active hidden-print" role="tablist">
		<li class="active">	<a id="a_tab_0" href="#tab_content" role="tab" data-toggle="tab">Профиль пользователя</a></li>
	</ul>
	<div class="floatL hidden-print">
		<button id="button_save" type="button" class="btn btn-success minw200 h40 m0 p0"><span class="glyphicon glyphicon-save	mr5"></span>Сохранить данные</button>
	</div>
	<div class="tab-content">
		<div class="active tab-pane min530 m0 w100p ui-corner-tab1 borderColor frameL border1" id="tab_content">
			<div class='p5 ui-corner-all frameL border0 w500'>
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
<!--				<div class="input-group input-group-sm w100p">
					<span class="input-group-addon w25p TAL">Текущий пароль</span>
					<input id="userPass" name="userPass" type="password" class="form-control TAL" placeholder="Текущий пароль" value="">
					<span class="input-group-addon w20p"></span>
				</div>-->
				<div class="input-group input-group-sm w100p">
					<span class="input-group-addon w25p TAL">Новый пароль</span>
					<input id="password_new1" name="password_new1" type="password" class="form-control TAL" placeholder="Новый пароль" value="" <?php echo $mode_user;?>>
					<span class="input-group-addon w20p"></span>
				</div>
				<div class="input-group input-group-sm w100p">
					<span class="input-group-addon w25p TAL">Повтор пароля</span>
					<input id="password_new2" name="password_new2" type="password" class="form-control" placeholder="Повторите пароль" TAL value="" <?php echo $mode_user; ?>>
					<span class="input-group-addon w20p"></span>
				</div>
				<div class="input-group input-group-sm w100p">
					<span class="input-group-addon w25p TAL">ФИО</span>
					<input id="fio" name="fio" type="text" class="form-control TAL" value="<?php echo $row['FIO']; ?>" <?php echo $mode_user; ?>>
					<span class="input-group-addon w20p"></span>
				</div>            
				<div class="input-group input-group-sm w100p">
					<span class="input-group-addon w25p TAL">Компания:</span>
					<input id="company" name="company" type="text" class="form-control TAL" value="<?php echo $row['Company']; ?>" <?php echo $mode_user; ?>>
					<span class="input-group-addon w20p"></span>
				</div>
				<div class="input-group input-group-sm w100p">
					<span class="input-group-addon w25p TAL">Должность:</span>
					<input id="post" name="post" type="text" class="form-control TAL" value="<?php echo $row['Post']; ?>" <?php echo $mode_user; ?>>
					<span class="input-group-addon w20p"></span>
				</div>
				<div class="input-group input-group-sm w100p">
					<span class="input-group-addon w25p TAL">E-mail:</span>
					<input id="eMail" name="eMail" type="text" class="form-control TAL" value="<?php echo $row['Email']; ?>" disabled>
					<span class="input-group-addon w20p"></span>
				</div>
				<div class="input-group input-group-sm w100p">
					<span class="input-group-addon w25p TAL">Телефон:</span>
					<input id="userPhone" name="userPhone" type="text" class="form-control TAL" value ="<?php echo $row['Phone']; ?>" <?php echo $mode_user; ?>>
					<span class="input-group-addon w20p"></span>
				</div>
			</div>
			<div class='p5 ui-corner-all frameL border0 w500'>
				<div class="input-group input-group-sm w100p">
					<span class="input-group-addon w25p TAL">Уровень доступа:</span>
					<input id="accessLevel" name="accessLevel" type="text" class="form-control TAL" value="<?php echo $row['AccessLevel']; ?>" disabled>
					<span class="input-group-addon w20p"></span>
				</div>
				<div class="input-group input-group-sm w100p">
					<span class="input-group-addon w25p TAL">Компания:</span>
					<div id="select_companyID" class="w100p"></div>
					<span class="input-group-addon w20p"></span>
				</div>
				<div class="input-group input-group-sm w100p">
					<span class="input-group-addon w25p TAL">Склад:</span>
					<div id="select_storeID" class="w100p"></div>
					<span class="input-group-addon w20p"></span>
				</div>
				<div class="input-group input-group-sm w100p">
					<span class="input-group-addon w25p TAL">Остатки:</span>
					<div id="select_viewRemain" class="w100p"></div>
					<span class="input-group-addon w20p"></span>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="dialog" title="ВНИМАНИЕ!">
    <p id='text'></p>
</div>
<style>
	/*select_storeID*/
</style>
