<!--<link href="/css/uploadfile.css" rel="stylesheet">-->
<script src="/js/jquery.uploadfile.js"></script>
<script type="text/javascript">
$(document).ready(function () {
	var mode_manager = <?php echo ($_SESSION['ClientID']==-1 && $_SESSION['AccessLevel']>10)?'true':'false';?>;
	var clientid;
	$("#dialog").dialog({autoOpen: false, modal: true, width: 400, //height: 300,
		buttons: [{text: "Закрыть", click: function () { $(this).dialog("close");}}],
		show: {effect: "clip", duration: 500},
		hide: {effect: "clip", duration: 500}
    });
	$("#view").dialog({autoOpen: false, modal: true, width: 'auto', height: 600,
		show: { effect: "blind", duration: 800 },
		hide: { effect: "blind", duration: 800 }
	});
	$("#question").dialog({autoOpen: false, modal: true, width: 285,
		show: { effect: "blind",   duration: 500 },
		hide: { effect: "explode", duration: 500 }
	});

	$.jgrid.styleUI.Bootstrap.base.rowTable = "table table-bordered table-striped";
	$("#grid1").jqGrid({
		caption: "Список заказов",
		mtype: "GET",
		styleUI: 'Bootstrap',
//		responsive: true,
		scroll: 1, height: 397, // если виртуальная подгрузка страниц
		//height: 'auto', //если надо управлять страницами
		//multiSort: true,
		datatype: "json",
		colModel: [
		    {label: '№ заказа',		name: 'o_OrderID', index: 'o.OrderID', width: 100, sorttype: "number", search: true, align: "center"},
		    {label: 'Партнер',		name: 'ClientName', index: 'cl.Name', width: 120, sorttype: "text", search: true, align: "left"},
		    {label: 'Состояние',	name: 'State', index: 'State', width: 120, sorttype: "text", search: false, align: "left"},
		    {label: 'Дата создания',name: 'DT_create', index: 'o.DT_create', width: 130, sorttype: "date", search: true, align: "center"},
		    {label: 'Сумма',		name: 'Sum', index: 'Sum', width: 100, sorttype: "number", search: false, align: "right"},
		    {label: 'Адрес дост.',	name: 'DeliveryAddress', index: 'DeliveryAddress', width: 200, sorttype: "text", search: true, align: "left"},
		    {label: 'Примечание',	name: 'Notes', index: 'Notes', width: 200, sorttype: "text", search: true, align: "left"},
		    {label: 'Автор',		name: 'u_FIO', index: 'u.FIO', width: 120, sorttype: "text", search: true, align: "left"},
		],
		rowNum: 20,
		rowList: [20, 30, 40, 50, 100, 200, 300],
		sortname: "o.OrderID",
		sortorder: 'desc',
		viewrecords: true,
//		autowidth:false,
		shrinkToFit: true,
//		forceFit:true,
		toppager: true,
		gridview: true,
		pager: "#pgrid1",
		pagerpos: "left",
//		altclass:"ui-priority-secondary2",
//		altRows:true,
//		onSelectRow: function (id, status, e) {
//			console.log(id, status, e);
//		}
		ondblClickRow: function(rowid) {
			$("#div_order_list #order_edit").click();
		}
    });
	$("#grid1").jqGrid('navGrid', '#pgrid1', {edit: false, add: false, del: false, search: false, refresh: false, cloneToTop: true});
	$("#grid1").jqGrid('filterToolbar', { autosearch: true, searchOnEnter: true});
	$("#pg_pgrid1").remove();
	$("#pgrid1").removeClass('ui-jqgrid-pager');
	$("#pgrid1").addClass('ui-jqgrid-pager-empty');

	$('#myTab a').click(function (e) {
		e.preventDefault();
		//console.log($(this).attr('href'),$(this).attr('state'));
		if ($(this).attr('state')) {
			$("#divGrid").appendTo( $($(this).attr('href')));
			$("#divGrid").removeClass("hide");
			$("#grid1").jqGrid('setGridParam', {datatype: "json", url: "/engine/jqgrid3?action=order_list_b2b&grouping=OrderID&o.Status="+$(this).attr('state')+"&f1=OrderID&f2=ClientName&f3=State&f4=DT_create&f5=Sum&f6=DeliveryAddress&f7=Notes&f8=Author", page: 1});
			$("#grid1").trigger('reloadGrid');
		}
		$(this).tab('show');
	});
	
	$("#div_order_list button").click(function(e){
		var id = e.target.id;
		if (id == 'order_edit') {
			var rowid = $("#grid1").jqGrid('getGridParam', 'selrow');
			rowdata = $("#grid1").getRowData(rowid);
			if (rowid == null) {
				$("#dialog").css('background-color', 'linear-gradient(to bottom, #f7dcdb 0%, #c12e2a 100%)');
				$("#dialog>#text").html('Пожалуйста, выберите заказ в списке!');
				$("#dialog").dialog("open");
				return false;
			}
			if (rowdata.State == "предварительный") {
				$.post('/engine/order_edit', {action: 'order_setcurrent',orderid:rowid}, function (json) {
					if (!json.success) {
						$("#dialog").css('background-color', 'linear-gradient(to bottom, #f7dcdb 0%, #c12e2a 100%)');
						$("#dialog>#text").html(json.message);
						$("#dialog").dialog("open");
					} else {
						window.location.href = window.location.href;
					}
				});
			} else {
				id = 'order_view';
			}
		}
		if (id == 'order_view')	{
			var rowid = $("#grid1").jqGrid('getGridParam', 'selrow');
			if (rowid == null) {
				$("#dialog").css('background-color', 'linear-gradient(to bottom, #f7dcdb 0%, #c12e2a 100%)');
				$("#dialog>#text").html('Пожалуйста, выберите заказ в списке!');
				$("#dialog").dialog("open");
				return false;
		    }
			$.post('/engine/order_info_full',{action: 'order_info', orderid: rowid, view: true}, function (json) {
				if (json.success){
					$("#view").html(json.html);
					$("#view").dialog({title:'Просмотр информации о заказе №'+rowid});
					$("#view").dialog("open");
				}else{
				    $("#dialog").css('background-color', 'linear-gradient(to bottom, #f7dcdb 0%, #c12e2a 100%)');
					$("#dialog>#text").html(json.message);
					$("#dialog").dialog("open");
				}
			});
		}
		if (id == 'order_delete') {
			var rowid = $("#grid1").jqGrid('getGridParam', 'selrow');
			if (rowid == null) {
				$("#dialog").css('background-color', 'linear-gradient(to bottom, #f7dcdb 0%, #c12e2a 100%)');
				$("#dialog>#text").html('Пожалуйста, выберите заказ в списке!');
				$("#dialog").dialog("open");
				return false;
		    }
			$("#question>#text").html("После удаления<br>заказ восстановить невозможно!<br><br>Удалить заказ № " + rowid + "?");
			$("#question").dialog('option', 'buttons', [{text: "Удалить", click: order_delete_from_list}, {text: "Отмена", click: function () { $(this).dialog("close"); }}]);
			$("#question").dialog('open');
		}
		if (id == 'order_add') {
		    $.post('/engine/order_edit', {action: 'order_new'}, function (json) {
				//console.log(json);
				if (!json.success) {
				    $("#dialog").css('background-color', 'linear-gradient(to bottom, #f7dcdb 0%, #c12e2a 100%)');
				    $("#dialog>#text").html(json.message);
				    $("#dialog").dialog("open");
				} else {
				    window.location.href = window.location.href;
				}
		    });
		}
	});
	order_info = function () {
		$.post('/engine/order_info_full',{action: 'order_info'}, function (json) {
			if (json.success){
				clientid = json.clientid;
				if(json.orderid>0) $("#a_tab_0").html('Текущий заказ № '+json.orderid);
				$("#div_order_active").html(json.html);
				$.post('/engine/select2?action=partners_b2b', function (json) {
					$("#select_companyID").select2({enable: false, multiple: false, placeholder: "Укажите фирму для пользователя", data: {results: json, text: 'text'}});
					$("#select_companyID").on("change", function (e) { 
						if (e.val.length>0)
							good_edit('order_edit_client',null,0,0,0,0,0,e.val);
					});
					$("#select_companyID").select2("val", clientid);
					$("#select_companyID").select2("enable", mode_manager);
				});
//				$('#select_companyID').attr("autocomplete","off").typeahead({ 
//					autoSelect: false, items: '20', minLength: 3, appendTo: "body",
//					source: function (query, proxy) {
//						$.ajax({url: '/engine/select_search?action=partners_b2b', dataType: "json", data: {name: query}, success: proxy});
//					}
//				});
				$("#import").uploadFile({
					url:"../engine/upload",
					fileName:"file_csv",
					allowedTypes: "csv",
					acceptFiles: ".csv",
					dragDrop: false,
					nestedForms: false,
					showQueueDiv: 'xxx',
					onSuccess:function(files,data,xhr,pd)
					{
						if (xhr.status!=200) {
							$("#dialog").css('background-color', 'linear-gradient(to bottom, #f7dcdb 0%, #c12e2a 100%)');
							$("#dialog>#text").html('При загрузке файла возникла проблема!<br><br>Сообщите разработчику!');
							$("#dialog").dialog("open");
							return;
						}
						order_id = $('#orderid').val();
						$.post('/engine/order_csv_view',{orderid: order_id, filename: files[0]}, function (json) {
							if (json.success) {
								$("#view").html(json.html);
								$("#view").dialog({title: 'Предварительный результат загрузки заказа №' + order_id});
								$("#view").dialog("open");
								$("#order_import").click(function(e){
									$.post('/engine/order_csv_import',{orderid: order_id, filename: files[0]}, function (json) {
										if (json.success) {
											$("#view").dialog("close");
											order_info();
										} else {
											$("#dialog").css('background-color', 'linear-gradient(to bottom, #f7dcdb 0%, #c12e2a 100%)');
											$("#dialog>#text").html(json.message);
											$("#dialog").dialog("open");
										}
									});
								});
							} else {
								$("#dialog").css('background-color', 'linear-gradient(to bottom, #f7dcdb 0%, #c12e2a 100%)');
								$("#dialog>#text").html(json.message);
								$("#dialog").dialog("open");
							}
						});
					}
				});
				$("#div_order_buttons button").click(function(e){
					id = e.target.id;
					//console.log(id, e);
					if (id == 'state') {
						$("#question>#text").html("После отправки в обработку<br>редактировать заказ невозможно!<br><br>Отправить в обработку заказ № " + $('#orderid').val() + "?");
						$("#question").dialog('option', 'buttons', [{text: "Отправить", click: order_send}, {text: "Отмена", click: function () {$(this).dialog("close");}}]);
						$("#question").dialog('open');
					}
					if (id == 'print') window.print();
					if (id == 'export') { $('html').append($('<iframe src="/engine/order_export_csv" style="display:none;"></iframe>')); }
					if (id == 'delete') {
						$("#question>#text").html("После удаления<br>заказ восстановить невозможно!<br><br>Удалить заказ № "+$('#orderid').val()+"?");
						$("#question").dialog('option', 'buttons', [{text: "Удалить", click: order_delete},{text: "Отмена", click: function () {$(this).dialog("close");}}]);
						$("#question").dialog('open');
					}
					if (id == 'good_add') {window.location.href='/main/catalog';}
				});
			}
		});
	}
	order_send = function (e) {
		$(this).dialog("close");
		$.post('/engine/order_edit', {action: 'order_send'}, function (json) {
			//console.log(json);
			if (!json.success) {
				$("#dialog").css('background-color', 'linear-gradient(to bottom, #f7dcdb 0%, #c12e2a 100%)');
				$("#dialog>#text").html(json.message);
				$("#dialog").dialog("open");
			} else {
				window.location.href = window.location.href;
			}
		});
	}
	order_delete = function (e) {
		$(this).dialog("close");
		$.post('/engine/order_edit', {action: 'order_delete'}, function (json) {
			//console.log(json);
			if (!json.success) {
				$("#dialog").css('background-color', 'linear-gradient(to bottom, #f7dcdb 0%, #c12e2a 100%)');
				$("#dialog>#text").html(json.message);
				$("#dialog").dialog("open");
			} else {
				window.location.href = window.location.href;
			}
		});
	}
	order_delete_from_list = function (e) {
		$(this).dialog("close");
		var id = $("#grid1").jqGrid('getGridParam', 'selrow');
		if (id == null) return false;
		$.post('/engine/order_edit', {action: 'order_delete', orderid: id}, function (json) {
			//console.log(json);
			if (!json.success) {
				$("#dialog").css('background-color', 'linear-gradient(to bottom, #f7dcdb 0%, #c12e2a 100%)');
				$("#dialog>#text").html(json.message);
				$("#dialog").dialog("open");
			} else {
				if ($('#orderid').val()==id) window.location.href = window.location.href;
				$("#grid1").trigger('reloadGrid');
			}
		});
	}
	
	good_edit = function (action, el, goodid, qty, info, delivery, notes, newclientid) {
//		console.log(action, el, goodid, qty, info);
		$.post('/engine/order_edit', {action: action, goodid: goodid, qty: qty, info: info, delivery: delivery, notes: notes, clientid: newclientid}, function (json) {
//			console.log(JSON.stringify(json));
			if (!json.success){
				$("#dialog").css('background-color', 'linear-gradient(to bottom, #f7dcdb 0%, #c12e2a 100%)');
				$("#dialog>#text").html(json.message);
				$("#dialog").dialog("open");
				return;
			}
		    if (json.success && action == 'order_edit' && qty == 0) {
				next = $(el).parent().parent().next();
				$(el).parent().parent().remove();
				$(next).focus();
		    }
		});
    }
	order_info();
	
//	setTimeout(function(){
//		$("#a_tab_1").click();
//	}, 100);
});
</script>

<div class="container center min300">
<?php
if ($_SESSION['ClientID']!=0) {
?>
	<ul id="myTab" class="nav nav-tabs floatL active hidden-print" role="tablist">
		<li class="active">	<a id="a_tab_0" href="#tab_order_action" role="tab" data-toggle="tab">Текущий заказ</a></li>
		<li>				<a id="a_tab_1" href="#tab_order_list1"	state="0" role="tab" data-toggle="tab">Предварительные</a></li>
		<li>				<a href="#tab_order_list2"	role="tab" state="10,15" data-toggle="tab">Отправленные</a></li>
		<li>				<a href="#tab_order_list3"	role="tab" state="20" data-toggle="tab">Обработанные</a></li>
		<li>				<a href="#tab_order_list4"	role="tab" state="50" data-toggle="tab">Отгруженные</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane m0 w100p min530 ui-corner-tab1 borderColor frameL border1 active" id="tab_order_action">
			<div class="ml5 mt5" id="div_order_active" accept="text/csv"></div>
		</div>
		<div class="tab-pane m0 w100p min530 ui-corner-all borderColor frameL border1" id="tab_order_list1">
			<div class="ml5 mt5" id="div_order_list" >
				<div class="row">
					<div class = "col-md-12 col-xs-12 TAL hidden-print">
						<button id="order_add"		type="button" class="btn btn-primary	btn-sm minw150 mb5"><span class="glyphicon glyphicon-plus		mr5"></span>Новый заказ</button>
						<button id="order_edit"		type="button" class="btn btn-success	btn-sm minw150 mb5"><span class="glyphicon glyphicon-edit		mr5"></span>Редактировать заказ</button>
						<button id="order_delete"	type="button" class="btn btn-danger		btn-sm minw150 mb5"><span class="glyphicon glyphicon-trash		mr5"></span>Удалить заказ</button>
						<button id="order_view"		type="button" class="btn btn-info		btn-sm minw150 mb5"><span class="glyphicon glyphicon-list-alt	mr5"></span>Просморт заказа</button>
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane m0 w100p min530 ui-corner-all borderColor frameL border1" id="tab_order_list2">
			<div class="ml5 mt5" id="div_order_list" >
				<div class="row">
					<div class = "col-md-12 col-xs-12 TAL hidden-print">
						<button id="order_view"		type="button" class="btn btn-info		btn-sm minw150 mb5"><span class="glyphicon glyphicon-list-alt mr5"></span>Просморт заказа</button>
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane m0 w100p min530 ui-corner-all borderColor frameL border1" id="tab_order_list3">
			<div class="ml5 mt5" id="div_order_list" >
				<div class="row">
					<div class = "col-md-12 col-xs-12 TAL hidden-print">
						<button id="order_view"		type="button" class="btn btn-info		btn-sm minw150 mb5"><span class="glyphicon glyphicon-list-alt mr5"></span>Просморт заказа</button>
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane m0 w100p min530 ui-corner-all borderColor frameL border1" id="tab_order_list4">
			<div class="ml5 mt5" id="div_order_list" >
				<div class="row">
					<div class = "col-md-12 col-xs-12 TAL hidden-print">
						<button id="order_view"		type="button" class="btn btn-info		btn-sm minw150 mb5"><span class="glyphicon glyphicon-list-alt mr5"></span>Просморт заказа</button>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
}
?>
</div>
<div id="divGrid" class="panel pull-left ml5 mb0 hide">
	<table id="grid1"></table>
	<div id="pgrid1"></div>
</div>
<div id="dialog" title="ВНИМАНИЕ!">
	<p id='text'></p>
</div>
<div id="view" title="ВНИМАНИЕ!">
</div>
<div id="question" title="ВНИМАНИЕ!">
	<p id='text' class="center"></p>
</div>
