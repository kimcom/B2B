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
		caption: "Список накладных",
		mtype: "GET",
		styleUI: 'Bootstrap',
//		responsive: true,
		scroll: 1, height: 365, // если виртуальная подгрузка страниц
		//height: 'auto', //если надо управлять страницами
		//multiSort: true,
		datatype: "json",
		colModel: [
		    {label: '№ РН',			name: '`1CID`', index: '`1CID`', width: 100, sorttype: "number", search: true, align: "center"},
		    {label: 'Партнер',		name: 'PartnerName', index: 'p.Name', width: 250, sorttype: "text", search: true, align: "left"},
		    {label: 'Состояние',	name: 'State', index: 'State', width: 120, sorttype: "text", search: false, align: "center"},
		    {label: 'Дата РН',		name: 'DT_doc', index: 'DT_doc', width: 140, sorttype: "date", search: true, align: "center"},
		    {label: 'Сумма',		name: 'Sum', index: 'Sum', width: 100, sorttype: "number", search: false, align: "right"},
		    {label: 'Примечание',	name: 'Notes', index: 'Notes', width: 215, sorttype: "text", search: true, align: "left"},
		    {label: 'Менеджер',		name: 'SellerName', index: 's.Name', width: 200, sorttype: "text", search: true, align: "left"},
		],
		rowNum: 20,
		rowList: [20, 30, 40, 50, 100, 200, 300],
		sortname: "o.DocID",
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
			$("#div_doc_list #doc_edit:first").click();
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
			$("#grid1").jqGrid('setGridParam', {datatype: "json", url: "/engine/jqgrid3?action=sale_list_b2b&grouping=DocID&o.Status="+$(this).attr('state')+"&f1=1CID&f2=PartnerName&f3=State&f4=DT_doc&f5=Sum&f6=Notes&f7=SellerName", page: 1});
			$("#grid1").trigger('reloadGrid');
		}
		$(this).tab('show');
	});
	
	$("#div_doc_list button").click(function(e){
		var id = e.target.id;
		if (id == 'doc_edit') {
			var rowid = $("#grid1").jqGrid('getGridParam', 'selrow');
			rowdata = $("#grid1").getRowData(rowid);
			if (rowid == null) {
				$("#dialog").css('background-color', 'linear-gradient(to bottom, #f7dcdb 0%, #c12e2a 100%)');
				$("#dialog>#text").html('Пожалуйста, выберите документ в списке!');
				$("#dialog").dialog("open");
				return false;
			}
//			if (rowdata.State == "предварительный") {
				$.post('/engine/doc_edit', {action: 'sale_setcurrent',docid:rowid}, function (json) {
					if (!json.success) {
						$("#dialog").css('background-color', 'linear-gradient(to bottom, #f7dcdb 0%, #c12e2a 100%)');
						$("#dialog>#text").html(json.message);
						$("#dialog").dialog("open");
					} else {
						//window.location.href = window.location.href;
						doc_info();
						$('#a_tab_0').click();
					}
				});
//			} else {
//				id = 'doc_view';
//			}
		}
		if (id == 'doc_view')	{
			var rowid = $("#grid1").jqGrid('getGridParam', 'selrow');
			if (rowid == null) {
				$("#dialog").css('background-color', 'linear-gradient(to bottom, #f7dcdb 0%, #c12e2a 100%)');
				$("#dialog>#text").html('Пожалуйста, выберите документ в списке!');
				$("#dialog").dialog("open");
				return false;
		    }
			$.post('/engine/doc_info_full',{action: 'sale_info', docid: rowid, view: true}, function (json) {
				if (json.success){
					$("#view").html(json.html);
					$("#view").dialog({title:'Просмотр информации о документе №'+rowid});
					$("#view").dialog("open");
				}else{
				    $("#dialog").css('background-color', 'linear-gradient(to bottom, #f7dcdb 0%, #c12e2a 100%)');
					$("#dialog>#text").html(json.message);
					$("#dialog").dialog("open");
				}
			});
		}
		if (id == 'doc_delete') {
			var rowid = $("#grid1").jqGrid('getGridParam', 'selrow');
			if (rowid == null) {
				$("#dialog").css('background-color', 'linear-gradient(to bottom, #f7dcdb 0%, #c12e2a 100%)');
				$("#dialog>#text").html('Пожалуйста, выберите документ в списке!');
				$("#dialog").dialog("open");
				return false;
		    }
			$("#question>#text").html("После удаления<br>документ восстановить невозможно!<br><br>Удалить документ № " + rowid + "?");
			$("#question").dialog('option', 'buttons', [{text: "Удалить", click: doc_delete_from_list}, {text: "Отмена", click: function () { $(this).dialog("close"); }}]);
			$("#question").dialog('open');
		}
		if (id == 'doc_add') {
		    $.post('/engine/doc_edit', {action: 'sale_new'}, function (json) {
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
	doc_info = function () {
		$.post('/engine/doc_info_full',{action: 'sale_info', view: true}, function (json) {
			if (json.success){
				clientid = json.clientid;
				if(json.docid>0) $("#a_tab_0").html('Накладная № '+json._1cid);
				$("#div_doc_active").html(json.html);
				$.post('/engine/select2?action=partners_b2b', function (json) {
					$("#select_companyID").select2({enable: false, multiple: false, placeholder: "Укажите фирму для пользователя", data: {results: json, text: 'text'}});
					$("#select_companyID").on("change", function (e) { 
						if (e.val.length>0)
							good_edit('sale_edit_client',null,0,0,0,0,0,e.val);
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
						doc_id = $('#docid').val();
						$.post('/engine/doc_csv_view',{docid: doc_id, filename: files[0]}, function (json) {
							if (json.success) {
								$("#view").html(json.html);
								$("#view").dialog({title: 'Предварительный результат загрузки документа №' + doc_id});
								$("#view").dialog("open");
								$("#doc_import").click(function(e){
									$.post('/engine/doc_csv_import',{docid: doc_id, filename: files[0]}, function (json) {
										if (json.success) {
											$("#view").dialog("close");
											doc_info();
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
				$("#div_doc_buttons button").click(function(e){
					id = e.target.id;
					//console.log(id, e);
					if (id == 'state') {
						$("#question>#text").html("После отправки в обработку<br>редактировать документ невозможно!<br><br>Отправить в обработку документ № " + $('#docid').val() + "?");
						$("#question").dialog('option', 'buttons', [{text: "Отправить", click: doc_send}, {text: "Отмена", click: function () {$(this).dialog("close");}}]);
						$("#question").dialog('open');
					}
					if (id == 'print') window.print();
					if (id == 'export') { $('html').append($('<iframe src="/engine/doc_export_csv?action=sale_info" style="display:none;"></iframe>')); }
					if (id == 'delete') {
						$("#question>#text").html("После удаления<br>документ восстановить невозможно!<br><br>Удалить документ № "+$('#docid').val()+"?");
						$("#question").dialog('option', 'buttons', [{text: "Удалить", click: doc_delete},{text: "Отмена", click: function () {$(this).dialog("close");}}]);
						$("#question").dialog('open');
					}
					if (id == 'good_add') {window.location.href='/main/catalog';}
				});
			}
		});
	}
	doc_send = function (e) {
		$(this).dialog("close");
		$.post('/engine/doc_edit', {action: 'sale_send'}, function (json) {
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
	doc_delete = function (e) {
		$(this).dialog("close");
		$.post('/engine/doc_edit', {action: 'sale_delete'}, function (json) {
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
	doc_delete_from_list = function (e) {
		$(this).dialog("close");
		var id = $("#grid1").jqGrid('getGridParam', 'selrow');
		if (id == null) return false;
		$.post('/engine/doc_edit', {action: 'sale_delete', docid: id}, function (json) {
			//console.log(json);
			if (!json.success) {
				$("#dialog").css('background-color', 'linear-gradient(to bottom, #f7dcdb 0%, #c12e2a 100%)');
				$("#dialog>#text").html(json.message);
				$("#dialog").dialog("open");
			} else {
				if ($('#docid').val()==id) window.location.href = window.location.href;
				$("#grid1").trigger('reloadGrid');
			}
		});
	}
	
	good_edit = function (action, el, goodid, qty, info, delivery, notes, newclientid) {
//		console.log(action, el, goodid, qty, info);
		$.post('/engine/doc_edit', {action: action, goodid: goodid, qty: qty, info: info, delivery: delivery, notes: notes, clientid: newclientid}, function (json) {
//			console.log(JSON.stringify(json));
			if (!json.success){
				$("#dialog").css('background-color', 'linear-gradient(to bottom, #f7dcdb 0%, #c12e2a 100%)');
				$("#dialog>#text").html(json.message);
				$("#dialog").dialog("open");
				return;
			}
		    if (json.success && action == 'sale_edit' && qty == 0) {
				next = $(el).parent().parent().next();
				$(el).parent().parent().remove();
				$(next).focus();
		    }
		});
    }
	doc_info();
	
	setTimeout(function(){
		$("#a_tab_3").click();
	}, 100);
});
</script>

<div class="container center min300">
<?php
if ($_SESSION['ClientID']!=0) {
?>
	<ul id="myTab" class="nav nav-tabs floatL active hidden-print" role="tablist">
		<li class="active">	<a id="a_tab_0" href="#tab_doc_action" role="tab" data-toggle="tab">Накладная</a></li>
		<li>				<a id="a_tab_1" href="#tab_doc_list1"	state="0,20" role="tab" data-toggle="tab">Предварительные</a></li>
		<li>				<a id="a_tab_2" href="#tab_doc_list2"	role="tab" state="50" data-toggle="tab">Обработанные</a></li>
		<li>				<a id="a_tab_3" href="#tab_doc_list3"	role="tab" state="0,20,50" data-toggle="tab">Все документы</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane m0 w100p min530 ui-corner-tab1 borderColor frameL border1 active" id="tab_doc_action">
			<div class="ml5 mt5" id="div_doc_active" accept="text/csv"></div>
		</div>
		<div class="tab-pane m0 w100p min530 ui-corner-all borderColor frameL border1" id="tab_doc_list1">
			<div class="ml5 mt5" id="div_doc_list" >
				<div class="row">
					<div class = "col-md-12 col-xs-12 TAL hidden-print">
<!--						<button id="doc_add"		type="button" class="btn btn-primary	btn-sm minw150 mb5"><span class="glyphicon glyphicon-plus		mr5"></span>Новый документ</button>-->
						<button id="doc_edit"		type="button" class="btn btn-b2b	btn-sm minw150 mb5"><span class="glyphicon glyphicon-edit		mr5"></span>Открыть документ</button>
<!--						<button id="doc_delete"	type="button" class="btn btn-danger		btn-sm minw150 mb5"><span class="glyphicon glyphicon-trash		mr5"></span>Удалить документ</button>-->
<!--						<button id="doc_view"		type="button" class="btn btn-info		btn-sm minw150 mb5"><span class="glyphicon glyphicon-list-alt	mr5"></span>Просморт документа</button>-->
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane m0 w100p min530 ui-corner-all borderColor frameL border1" id="tab_doc_list2">
			<div class="ml5 mt5" id="div_doc_list" >
				<div class="row">
					<div class = "col-md-12 col-xs-12 TAL hidden-print">
						<button id="doc_edit"		type="button" class="btn btn-b2b	btn-sm minw150 mb5"><span class="glyphicon glyphicon-edit		mr5"></span>Открыть документ</button>
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane m0 w100p min530 ui-corner-all borderColor frameL border1" id="tab_doc_list3">
			<div class="ml5 mt5" id="div_doc_list" >
				<div class="row">
					<div class = "col-md-12 col-xs-12 TAL hidden-print">
						<button id="doc_edit"		type="button" class="btn btn-b2b	btn-sm minw150 mb5"><span class="glyphicon glyphicon-edit		mr5"></span>Открыть документ</button>
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane m0 w100p min530 ui-corner-all borderColor frameL border1" id="tab_doc_list4">
			<div class="ml5 mt5" id="div_doc_list" >
				<div class="row">
					<div class = "col-md-12 col-xs-12 TAL hidden-print">
						<button id="doc_edit"		type="button" class="btn btn-b2b	btn-sm minw150 mb5"><span class="glyphicon glyphicon-edit		mr5"></span>Открыть документ</button>
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
