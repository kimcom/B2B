<script type="text/javascript">
$(document).ready(function () {
	$.jgrid.styleUI.Bootstrap.base.rowTable = "table table-bordered table-striped";
	var reportID = 5; 
	var mode_manager = <?php echo ($_SESSION['ClientID'] == -1 && $_SESSION['AccessLevel'] > 10) ? 'true' : 'false'; ?>;
//	var x="<?php $_SESSION['ClientName']; ?>"

//Object Converter
	oconv	= function (a) {var o = {};for(var i=0;i<a.length;i++) {o[a[i]] = '';} return o;}
	strJoin = function (obj){ var ar = []; for (key in obj){ar[ar.length] = obj[key];}return ar;}
	keyJoin = function (obj){ var ar = []; for (key in obj){ar[ar.length] = key;}return ar;}
	clearObj= function (obj){ for(key in obj){for(k in obj[key]){delete obj[key][k];}}return obj;}
	var settings = new Object();
	var grouping = new Object();
	var group = new Object();
	var good = new Object();
	var catType = new Object();
	var catBrand = new Object();
	var company = new Object();
	settings['grouping']=grouping;
	settings['group']=group;
	settings['good']=good;
	settings['catType']=catType;
	settings['catBrand']=catBrand;
	settings['company']=company;
	var colnames = ['Ед.','Вес','Отдел','Макс.%'];
	$("#dialog").dialog({
		autoOpen: false, modal: true, width: 400, //height: 300,
		buttons: [{text: "Закрыть", click: function () {
			    $(this).dialog("close");}}],
		show: {effect: "clip",duration: 500},
		hide: {effect: "clip",duration: 500}
    });
	$("#dialog_progress").dialog({
		autoOpen: false, modal: true, width: 400, height: 400,
		show: {effect: "explode",duration: 600},
		hide: {effect: "explode",duration: 600}
    });
	
	$.post('../Engine/setting_get?sid='+reportID, function (json) {
		$("#select_report_setting").select2({
		    createSearchChoice: function (term, data){
				if ($(data).filter(function(){return this.text.localeCompare(term) === 0;}).length === 0) {
				    return {id: term, text: term};
				}
			},
			//multiple: true,
			placeholder: "Выберите настройку отчета",
		    data: {results: json, text: 'text'}
		});
$("#select_report_setting").select2("val", "тест");
$("#select_report_setting").click();
    });

	$("#select_report_setting").click(function () { 
		var setting = $("#select_report_setting").select2("data");
		if (setting == null) return;
		clearObj(settings);
		$.post('../Engine/setting_get_byName?sid='+reportID+'&sname='+setting.text,
		function (json) {
			var set = json.Setting;
			var aset = set.split('&');
			for(key in aset){
				var k = aset[key].split('=');
				if(k[1]=='')continue;
				var l = k[1].split('|');
				var m = l[0].split(';');
				var n = l[1].split(';');
				for(i=0;i<m.length;i++){
					if(m[i]=='') continue;
					if(k[0]=='grouping'){
						settings[k[0]][i]=n[i];
					}else{
						settings[k[0]][m[i]]=n[i];
					}
				}
			}
			$("#grouping li").each(function( index ) {
				var id = this.id;
				$("#" + id).appendTo($('#grouping_add'));
				$("#" + id + ">#a1").removeClass('hide').addClass('show');
				$("#" + id + ">#a2").removeClass('show').addClass('hide');
			});
			for(id in grouping){
				$("#divGridGrouping_add #" + grouping[id]).appendTo($('#grouping'));
				$("#" + grouping[id] + ">#a2").removeClass('hide').addClass('show');
				$("#" + grouping[id] + ">#a1").removeClass('show').addClass('hide');
			}
			if(Object.keys(grouping).length==0){
				id = 'g_goodID';
				$("#"+id).appendTo($('#grouping'));
				$("#" + id + ">#a2").removeClass('hide').addClass('show');
			    $("#" + id + ">#a1").removeClass('show').addClass('hide');
			}
			$("#group").val(strJoin(group).join(';'));
			$("#group").attr("title", strJoin(group).join("\n"));
			$("#good").val(strJoin(good).join(';'));
			$("#good").attr("title", strJoin(good).join("\n"));
			$("#catType").val(strJoin(catType).join(';'));
			$("#catType").attr("title",strJoin(catType).join("\n"));
			$("#catBrand").val(strJoin(catBrand).join(';'));
			$("#catBrand").attr("title",strJoin(catBrand).join("\n"));
			$("#company").val(strJoin(company).join(';'));
			$("#company").attr("title", strJoin(company).join("\n"));
//$('#button_report_run').click();
		});
	});
		
//группы товара
	$("#treeGrid").jqGrid({
		treeGrid: true,
		treeGridModel: 'nested',
		treedatatype: 'json',
		datatype: "json",
		mtype: "POST",
		width: 400,
		height: 380,
		ExpandColumn: 'name',
		colNames: ["id", "Категории"],
		colModel: [
		    {name: 'id', index: 'id', width: 1, hidden: true, key: true},
		    {name: 'name', index: 'name', width: 190, resizable: false, editable: true, sorttype: "text", edittype: 'text', stype: "text", search: true}
		],
		sortname: "Name",
		sortorder: "asc",
		pager: "#ptreeGrid",
		toppager: true,
		onSelectRow: function (cat_id) {
		    if (cat_id == null)
			cat_id = 0;
		    $("#grid1").jqGrid('setGridParam', {datatype: "json", url: "/engine/jqgrid3?action=good_list_b2b&sid=5&group=" + cat_id + "&f1=Article&f2=Name&f3=Brand", page: 1});
		    $("#grid1").trigger('reloadGrid');
		}
    });
	$("#treeGrid").jqGrid('navGrid','#ptreeGrid', {edit:false, add:false, del:false, search: false, refresh: true, cloneToTop: true});
	$("#treeGrid").navButtonAdd('#treeGrid_toppager',{
		buttonicon: "ui-icon-plusthick", caption: 'Выбрать', position: "last",
		onClickButton: function () {
		    var id = $("#treeGrid").jqGrid('getGridParam', 'selrow');
		    var node = $("#treeGrid").jqGrid('getRowData', id);
			datastr = $("#treeGrid").getGridParam('datastr');
			if (datastr=='group'){
				group[id] = node.name;
				$("#group").val(strJoin(group).join(';'));
				$("#group").attr("title",strJoin(group).join("\n"));
			}
			if (datastr=='catType'){
				catType[id] = node.name;
				$("#catType").val(strJoin(catType).join(';'));
				$("#catType").attr("title",strJoin(catType).join("\n"));
		    }
			if (datastr=='catBrand'){
				catBrand[id] = node.name;
				$("#catBrand").val(strJoin(catBrand).join(';'));
				$("#catBrand").attr("title",strJoin(catBrand).join("\n"));
		    }
//			if (datastr=='company'){
//				company[id] = node.name;
//				$("#company").val(strJoin(company).join(';'));
//				$("#company").attr("title",strJoin(company).join("\n"));
//		    }
		}
    });
	$("#pg_ptreeGrid").remove();
	$(".ui-jqgrid-hdiv").remove();
	$("#ptreeGrid").removeClass('ui-jqgrid-pager');
    $("#ptreeGrid").addClass('ui-jqgrid-pager-empty');
	$("#treegrid_name").remove();
	$('#gbox_treeGrid .ui-jqgrid-caption').addClass('title1');

//список товаров
	$("#grid1").jqGrid({
//		styleUI : 'Bootstrap',
		mtype: "GET",
		sortable: true,
		datatype: "json",
		width: 300,
		height: 330,
		colNames: ['Артикул', 'Название','field3'],
		colModel: [
		    {name: 'field1', index: 'field1', width: 80, sorttype: "text", search: true},
		    {name: 'field2', index: 'field2', sorttype: "text", search: true},
		    {name: 'field3', index: 'field3', sorttype: "text", search: true}
		],
		rowNum: 15,
		rowList: [15, 30, 40, 50, 100, 200, 300],
		sortname: "Name",
		viewrecords: true,
		multiselect: true,
		//loadonce: true,
		gridview: true,
		toppager: true,
		caption: "Список товаров",
		pager: '#pgrid1'
	    });
	    $("#grid1").jqGrid('navGrid', '#pgrid1', {edit: false, add: false, del: false, search: false, refresh: false, cloneToTop: true});
	    $("#grid1").jqGrid('filterToolbar', {autosearch: true, searchOnEnter: true});

	    $("#grid1").navButtonAdd('#grid1_toppager', {
		buttonicon: 'ui-icon-plusthick', caption: 'Выбрать', position: "last",
		onClickButton: function () {
		    var sel;
		    sel = jQuery("#grid1").jqGrid('getGridParam', 'selarrrow');
		    if (sel == '') {
				$("#dialog").css('background-color','');
				$("#dialog>#text").html('Вы не выбрали ни одной записи!');
				$("#dialog").dialog("open");
				return;
		    }
			datastr = $("#grid1").getGridParam('datastr');
			for(key in sel){
				var node = $("#grid1").jqGrid('getRowData', sel[key]);
				if (datastr=='good') good[sel[key]] = node.field2;
				if (datastr=='client') company[sel[key]] = node.field2;
			}
			if (datastr=='good'){
				$("#good").val(strJoin(good).join(';'));
				$("#good").attr("title", strJoin(good).join("\n"));
			}
			if (datastr=='client'){
				$("#company").val(strJoin(company).join(';'));
				$("#company").attr("title", strJoin(company).join("\n"));
		    }
		}
	});

	$("#pg_pgrid1").remove();
	$("#pgrid1").removeClass('ui-jqgrid-pager');
	$("#pgrid1").addClass('ui-jqgrid-pager-empty');
	$("#grid1_name").remove();
	$('#gbox_grid1 .ui-jqgrid-caption').addClass('title1');

//список клиентов
	$("#grid2").jqGrid({
//		styleUI : 'Bootstrap',
		mtype: "GET",
		sortable: true,
		datatype: "json",
	    width: 300,
	    height: 330,
	    colNames: ['Артикул', 'Название'],
	    colModel: [
		{name: 'field1', index: 'field1', width: 80, sorttype: "text", search: true},
		{name: 'field2', index: 'field2', sorttype: "text", search: true}
	    ],
	    rowNum: 15,
	    rowList: [15, 30, 40, 50, 100, 200, 300],
	    sortname: "Name",
	    viewrecords: true,
	    gridview: true,
	    toppager: true,
	    caption: "Список клиентов",
	    pager: '#pgrid2'
	});
	$("#grid2").jqGrid('navGrid', '#pgrid2', {edit: false, add: false, del: false, search: false, refresh: false, cloneToTop: true});
	$("#grid2").jqGrid('filterToolbar', {autosearch: true, searchOnEnter: true});

	$("#grid2").navButtonAdd('#grid2_toppager', {
	    buttonicon: 'ui-icon-plusthick', caption: 'Выбрать', position: "last",
	    onClickButton: function () {
			var sel;
			sel = jQuery("#grid2").jqGrid('getGridParam', 'selrow');
			if (sel == '') {
				$("#dialog").css('background-color', '');
				$("#dialog>#text").html('Вы не выбрали ни одной записи!');
				$("#dialog").dialog("open");
				return;
			}
			datastr = $("#grid2").getGridParam('datastr');
			rowdata = $("#grid2").getRowData(sel);
			if (datastr == 'client') company[rowdata.field1] = rowdata.field2;
			if (datastr == 'client') {
				$("#company").val(strJoin(company).join(';'));
				$("#company").attr("title", strJoin(company).join("\n"));
			}
	    }
	});

	$("#pg_pgrid2").remove();
	$("#pgrid2").removeClass('ui-jqgrid-pager');
	$("#pgrid2").addClass('ui-jqgrid-pager-empty');
	$("#grid2_name").remove();
	$('#gbox_grid2 .ui-jqgrid-caption').addClass('title1');

	$("#treeGrid").gridResize();
	$("#grid1").gridResize();
	$("#grid2").gridResize();
	
	$("#divGrid").hide();

	$("#setting_filter a").click(function() {
		operid = '';
		var command = this.parentNode.previousSibling.previousSibling.previousSibling.previousSibling;
		if(command.tagName=='SPAN'){
			command = this.parentNode.previousSibling.previousSibling;
		}
//		console.log(command,$(this).html(),this.parentNode.previousSibling.previousSibling.previousSibling.previousSibling.id);
		if(command.tagName=="INPUT"){
			operid = command.id;
		}else if(command.tagName=="DIV"){
			operid = this.parentNode.previousSibling.previousSibling.previousSibling.previousSibling.id;
	    } else{
			alert('Ошибка определения действия!');
			return;
		}
		if($(this).html()=='X'){
			for(k in settings[operid]){
				delete settings[operid][k];
			}
			$("#"+operid).val(strJoin(settings[operid]).join(';'));
			$("#"+operid).attr("title", strJoin(settings[operid]).join("\n"));
			return;
		}
		if(operid=='select_report_setting'){
			setting = $("#select_report_setting").select2("data");
			if(setting==null){
				$("#dialog").css('background-color','');
				$("#dialog>#text").html('Введите название для сохранения настройки!');
				$("#dialog").dialog("open");
				return;
			}
			grouping = [];
			$("#grouping li").each(function( index ) {grouping[index] = this.id;});
			setID = setting.id;
			if(setting.id==setting.text) setID='';
			$.post("../Engine/setting_set"+
					"?grouping="+ keyJoin(grouping).join(';')+"|"+strJoin(grouping).join(';')+
					"&group="	+ keyJoin(group).join(';')	 +"|"+strJoin(group).join(';')+
					"&good="	+ keyJoin(good).join(';')	 +"|"+strJoin(good).join(';')+
					"&catType="	+ keyJoin(catType).join(';') +"|"+strJoin(catType).join(';')+
					"&catBrand="+ keyJoin(catBrand).join(';')+"|"+strJoin(catBrand).join(';')+
					"&company="	+ keyJoin(company).join(';') +"|"+strJoin(company).join(';'),
				{	sid:	reportID,
					sname:	setting.text,
				}, 
				function (data) {
					if (data == 0) {
						$("#dialog").css('background-color','linear-gradient(to bottom, #f7dcdb 0%, #c12e2a 100%)');
						$("#dialog>#text").html('Возникла ошибка.<br/>Сообщите разработчику!');
						$("#dialog").dialog("open");
					} else {
						$("#dialog").css('background-color','');
						$("#dialog>#text").html('Настройки успешно сохранены!');
						$("#dialog").dialog("open");
					}
			});
		}
		if(operid=='group'){
			$("#legendGrid").html('Выбор товара или группы:');
			$("#treeGrid").jqGrid('setGridParam',{datastr:"group"});
			$("#treeGrid").jqGrid('setCaption','Группы товаров');
		    $("#treeGrid").jqGrid('setGridParam', {url: "../engine/tree_NS?nodeid=20", page: 1}).trigger('reloadGrid');
			$('#treeGrid').jqGrid('setGridWidth', '400');
			$("#divTable").hide();
			$("#divTable2").hide();
			$("#divTree").show();
			$("#divGrid").show();
		}
		if(operid=='good'){
			$("#grid1").jqGrid('setCaption', "Список товаров");
			$("#grid1").jqGrid('setLabel', "field1","Артикул");
			$("#grid1").jqGrid('setLabel', "field2","Название");
			$("#grid1").jqGrid('setLabel', "field3","Бренд");
			$("#legendGrid").html('Выбор товара или группы:');
			$("#treeGrid").jqGrid('setGridParam',{datastr:"good"});
			$("#treeGrid").jqGrid('setCaption','Группы товаров');
		    $("#treeGrid").jqGrid('setGridParam', {url: "../engine/tree_NS?nodeid=20", page: 1}).trigger('reloadGrid');
		    $('#treeGrid').jqGrid('setGridWidth', '300');
			$("#grid1").jqGrid('setGridParam',{datastr:"good"});
			$('#grid1').jqGrid('setGridWidth', '450');
		    $(".ui-search-input>input").val("");
			$('#gview_grid1 #grid1_cb').attr('style', 'word-break: break-word;height:auto;white-space:normal;text-align:center;width: 35px;');
		    $("#grid1").jqGrid('setGridParam', {datatype: "json", url: "/engine/jqgrid3?action=good_list_b2b&sid=5&group=-1&f1=Article&f2=Name&f3=Brand", page: 1}).trigger('reloadGrid');
			$("#divTable").addClass('ml10');
			$("#divTable").show();
			$("#divTable2").hide();
			$("#divTree").show();
			$("#divGrid").show();
		}
		if(operid=='catType'){
			$("#legendGrid").html('Выбор категории по виду товара:');
			$("#treeGrid").jqGrid('setGridParam',{datastr:"catType"});
			$("#treeGrid").jqGrid('setCaption', 'Категории по видам товаров');
		    $("#treeGrid").jqGrid('setGridParam', {datatype: "json", url: "../engine/tree_NS?nodeid=10", page: 1}).trigger('reloadGrid');
			$('#treeGrid').jqGrid('setGridWidth', '400');
			$("#divTable").hide();
			$("#divTable2").hide();
			$("#divTree").show();
			$("#divGrid").show();
	    }
		if(operid=='catBrand'){
			$("#legendGrid").html('Выбор категории по брендам:');
			$("#treeGrid").jqGrid('setGridParam',{datastr:"catBrand"});
			$("#treeGrid").jqGrid('setCaption', 'Категории по брендам');
		    $("#treeGrid").jqGrid('setGridParam', {datatype: "json", url: "../engine/tree_NS?nodeid=50", page: 1}).trigger('reloadGrid');
			$('#treeGrid').jqGrid('setGridWidth', '400');
			$("#divTable").hide();
			$("#divTable2").hide();
			$("#divTree").show();
			$("#divGrid").show();
	    }
		if(operid=='company'){
			$("#grid2").jqGrid('setCaption', "Список клиентов");
			$("#grid2").jqGrid('setLabel', "field1","Код внутр.");
			$("#grid2").jqGrid('setLabel', "field2", "Наименование");
			$("#legendGrid").html('Выбор заказчика:');
			$("#grid2").jqGrid('setGridParam', {datastr: "client"});
			$('#grid2').jqGrid('setGridWidth', '500');
			$('#gview_grid2 #grid2_cb').removeAttr('style');
			$('#gview_grid2 #grid2_cb').attr('style', 'word-break: break-word;height:auto;white-space:normal;text-align:center;width: 35px;');
			$(".ui-search-input>input").val("");
			$("#grid2").jqGrid('setGridParam', {datatype: "json", url: "/engine/jqgrid3?action=client_list_b2b&sid=5&group=-1&f1=ClientID&f2=Name&f3=Name", page: 1}).trigger('reloadGrid');
			$("#divTable").hide();
			$("#divTable2").show();
			$("#divTree").hide();
			$("#divGrid").show();
	    }
	});
	$('#grouping_add').selectable({
		selected: function(event, ui){
			if(ui.selected.tagName!='LI') return;
			var count = $("#grouping").children().length;
			if (count==2) {
				$("#dialog").css('background-color','linear-gradient(to bottom, #f7dcdb 0%, #c12e2a 100%)');
				$("#dialog>#text").html('В прайсе возможен выбор<br>только 2-ух группировок!');
				$("#dialog").dialog("open");
				return;
		    };
			$(ui.selected).appendTo($('#grouping'));
			$("#"+ui.selected.id+">#a2").removeClass('hide').addClass('show');
			$("#"+ui.selected.id+">#a1").removeClass('show').addClass('hide');
		}
	});
	$('#grouping').selectable({
		selected: function(event, ui){
			if(ui.selected.tagName!='LI') return;
			$(ui.selected).appendTo($('#grouping_add'));
			$("#"+ui.selected.id+">#a1").removeClass('hide').addClass('show');
			$("#"+ui.selected.id+">#a2").removeClass('show').addClass('hide');
		}
	});

// Creating gridRep
	var gridRep = function(){
	$("#gridRep").jqGrid({
		sortable: true,
	    //datatype: "json",
		datatype: 'local',
	    height: 'auto',
	    colModel: [
			{name: 'field0' , index: 'field0' , width: 200, align: "left", sorttype: "text"},
			{name: 'field1' , index: 'field1' , width: 200, align: "left", sorttype: "text"},
			{name: 'field2' , index: 'field2' , width: 200, align: "center", sorttype: "text"},
			{name: 'field3' , index: 'field3' , width: 150, align: "center", sorttype: "text"},
			{name: 'field4' , index: 'field4' , width:  80, align: "center", sorttype: "number"},
			{name: 'field5' , index: 'field5' , width:  80, align: "center", sorttype: "number"},
			{name: 'field6' , index: 'field6' , width:  80, align: "center", sorttype: "number"},
			{name: 'field7' , index: 'field7' , width:  80, align: "center", sorttype: "number"},
			{name: 'field8' , index: 'field8' , width:  80, align: "center", sorttype: "text"},
			{name: 'field9' , index: 'field9' , width:  80, align: "center", sorttype: "text"},
			{name: 'field10', index: 'field10', width:  80, align: "center", sorttype: "text"},
			{name: 'field11', index: 'field11', width: 120, align: "center", sorttype: "text"},
			{name: 'field12', index: 'field12', width:  80, align: "center", sorttype: "text"},
	    ],
	    //width: 'auto',
	    shrinkToFit: true,
		loadonce: true,
		rowNum:10000000,
	    gridview: true,
	    toppager: true,
		loadComplete: function(data) {
			//console.log(data);
			if(data['error']){
				$("#dialog_progress").dialog("close");
				setTimeout(function () {
					$("#dialog").css('background-color', 'linear-gradient(to bottom, #f7dcdb 0%, #c12e2a 100%)');
					$("#dialog>#text").html("При выполнении запроса возникла ошибка: <br><br>"
						+ data.error[2] + "<br><br>"
						+ "Сообщите разработчику!");
					$("#dialog").dialog("open");
				}, 1200);
				return;
			}
			if (data['total'] > 0 && data['records'] == 0) {
				setTimeout(function () {
					$("#dialog").css('background-color', 'linear-gradient(to bottom, #def0de 0%, #419641 100%)');
					$("#dialog>#text").html("По Вашему запросу: <br><br>"
						+ "Не найдено ни одной записи!");
					$("#dialog").dialog("open");
				}, 1200);
				return;
			}
//			$("#grouping li").each(function( index ) {
//				var cl = this.className.substr(0,3);
//				$(".jqgroup.ui-row-ltr.gridRepghead_"+index).css("background-image","none");
//				$(".jqgroup.ui-row-ltr.gridRepghead_"+index).addClass(cl);
//			});
			$("#dialog_progress").dialog("close");
		},
	    caption: 'Прайс-лист',
	    pager: '#pgridRep',
	});
	$("#gridRep").jqGrid('navGrid', '#pgridRep', {edit: false, add: false, del: false, search: false, refresh: true, cloneToTop: true});
	$("#gridRep").navButtonAdd("#gridRep_toppager",{
		caption: 'Экспорт в Excel', 
		title: 'to Excel', 
		icon: "ui-extlink",
		onClickButton: function () {
			$("#dialog_progress").dialog( "option", "title", 'Ожидайте! Готовим данные для XLS файла');
			$("#dialog_progress").dialog("open");
			setTimeout(function(){
				var gr = $("#gview_gridRep").clone();
				$(gr).find("#pg_gridRep_toppager").remove();
				$(gr).find("#gridRep_toppager").html($("#report_param_str").html());
				$(gr).find("th").filter(function () {if ($(this).css('display') == 'none') $(this).remove();});
				$(gr).find("td").filter(function () {if ($(this).css('display') == 'none') $(this).remove();});
				$(gr).find("table").filter(function () {if ($(this).attr('border') == '0') $(this).attr('border', '1');});
				$(gr).find("td").filter(function () {if ($(this).attr('colspan') > 1) $(this).attr('colspan', '6');});
				$(gr).find("a").remove();
				$(gr).find("div").removeAttr("id");
				$(gr).find("div").removeAttr("style");
				$(gr).find("div").removeAttr("class");
				$(gr).find("div").removeAttr("role");
				$(gr).find("div").removeAttr("dir");
				$(gr).find("span").removeAttr("class");
				$(gr).find("span").removeAttr("style");
				$(gr).find("span").removeAttr("sort");
				$(gr).find("table").removeAttr("id");
				$(gr).find("table").removeAttr("class");
				$(gr).find("table").removeAttr("role");
				$(gr).find("table").removeAttr("tabindex");
				$(gr).find("table").removeAttr("aria-labelledby");
				$(gr).find("table").removeAttr("aria-multiselectable");
				$(gr).find("th").removeAttr("id");
				$(gr).find("th").removeAttr("class");
				$(gr).find("th").removeAttr("role");
				$(gr).find("tr").removeAttr("id");
				$(gr).find("tr").removeAttr("class");
				$(gr).find("tr").removeAttr("role");
				$(gr).find("tr").removeAttr("tabindex");
				$(gr).find("td").removeAttr("id");
				$(gr).find("td").removeAttr("role");
				$(gr).find("td").removeAttr("title");
				$(gr).find("td").removeAttr("aria-describedby");
				$(gr).find("table").removeAttr("style");
				$(gr).find("th").removeAttr("style");
				$(gr).find("tr").removeAttr("style");
				$(gr).find("td").removeAttr("style");

				var html = $(gr).html();
				html = html.split(" грн.").join("");
				html = html.split("<table").join("<table border='1' ");
				var file_name = 'Прайс-лист';
				var report_name = 'report'+reportID;
				$.ajax({
					type: "POST",
					data: ({report_name: report_name, file_name: file_name, html: html}),
					url: '../Engine/set_file',
					dataType: "html",
					success: function (data) {
						$("#dialog_progress").dialog("close");
						var $frame = $('<iframe src="../Engine/get_file?report_name='+report_name+'&file_name='+file_name+'" style="display:none;"></iframe>');
						$('html').append($frame);
					}
				});
			}, 1000);
		}
	});
	$("#pg_pgridRep").remove();
	$("#pgridRep").removeClass('ui-jqgrid-pager');
	$("#pgridRep").addClass('ui-jqgrid-pager-empty');
	$("#gridRep").gridResize();
		
	$('#myTab a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	});
	}

	$('#button_report_run').click(function (e) {
		var count = $("#grouping").children().length;
		    if (count == 0) {
			$("#dialog").css('background-color', 'linear-gradient(to bottom, #f7dcdb 0%, #c12e2a 100%)');
			$("#dialog>#text").html('Необходимо выбрать группировку!');
			$("#dialog").dialog("open");
			return;
	    }
		if($("#gridRep").jqGrid('getRowData').length > 0) $.jgrid.gridUnload("#gridRep");
		gridRep();
		$("#dialog_progress").dialog( "option", "title", 'Ожидайте! Выполняется формирование отчета...');
		$("#dialog_progress").dialog("open");
		$("#a_tab_report").tab('show');

		grouping = [];
		$("#grouping li").each(function( index ) {
			grouping[index] = this.id;
		});
//		for(i=0; i<11; i++){
//			$("#gridRep").jqGrid('showCol',"field"+i);
//		}
		var grlen = Object.keys(grouping).length;
		var ar = [];
		for(var id=0; id<grlen; id++){
			if (id == grlen-1) break;
			ar[id] = 'field'+id;
			$("#gridRep").jqGrid('setLabel', "field"+id, grouping[id]);
		}
		if(grouping[id]=='groupName')	$("#gridRep").jqGrid('setLabel', "field"+id, "Группа товара");
		if(grouping[id]=='catTypeName') $("#gridRep").jqGrid('setLabel', "field"+id, "Категория по виду товара");
		if(grouping[id]=='catBrandName')$("#gridRep").jqGrid('setLabel', "field"+id, "Категория по брендам");
		if(grouping[id]=='g_goodID'){
			$("#gridRep").jqGrid('setLabel', "field"+id, "Артикул");
			id++;
			$("#gridRep").jqGrid('setLabel', "field"+id, "Название");
			id++;
			$("#gridRep").jqGrid('setLabel', "field"+id, "Бренд");
			id++;
			$("#gridRep").jqGrid('setLabel', "field"+id, "Цена ОПТ");
			id++;
			$("#gridRep").jqGrid('setLabel', "field"+id, "Ваша цена");
			id++;
			$("#gridRep").jqGrid('setLabel', "field"+id, "Цена реком.");
			id++;
			$("#gridRep").jqGrid('setLabel', "field"+id, "Наценка");
			id++;
			$("#gridRep").jqGrid('setLabel', "field"+id, "Кол-во в упак.");
			id++;
			$("#gridRep").jqGrid('setLabel', "field"+id, "Ост. Харьков");
			id++;
			$("#gridRep").jqGrid('setLabel', "field"+id, "Ост. Киев");
			id++;
			$("#gridRep").jqGrid('setLabel', "field"+id, "Штрих-код");
			id++;
			$("#gridRep").jqGrid('setLabel', "field"+id, "Код 1С");
		}
//		id++;
//		for(var fi=0; fi<10; fi++){
//			$("#gridRep").jqGrid('setLabel', "field"+(fi+6), colnames[fi]);
//		}
		if(grlen<=1){
			$("#gridRep").jqGrid('setGridParam', {
				grouping: true,
				groupingView : {
					groupField: ar,
					//groupColumnShow: [false, false, false, false, false, false, false, false, false, false],
					groupColumnShow: [true, true, true, true, true, true, true, true, true, true],
					groupText: ['<b>{0}</b>'],
					//groupCollapse: false,
					groupDataSorted: true,
					//groupOrder: ['asc', 'asc'],
					groupSummary : [true, true, true, true, true, true, true, true, true, true],
					showSummaryOnHide: true,
				}
			});
		}else{
			$("#gridRep").jqGrid('setGridParam', {
				grouping: true,
				groupingView : {
					groupField: ar,
					groupColumnShow: [false, false, false, false, false, false, false, false, false, false],
					//groupColumnShow: [true, true, true, true, true, true, true, true, true, true],
					groupText: ['<b>{0}</b>'],
					//groupCollapse: false,
					groupDataSorted: true,
					//groupOrder: ['asc', 'asc'],
					groupSummary : [true,true,true,true,true,true,true,true,true,true],
					showSummaryOnHide: true,
				}
			});
		}
		var grouping_str = '';
		$("#grouping li span").each(function( index ) { grouping_str += ((grouping_str.length==0) ? '' : ', ') + $(this).html();});
		prmRep = "<b>Отбор данных выполнен по критериям:</b> ";
		prmRep += (Object.keys(group).length == 0) ? "" : "<br>" + "Группа товара: " + strJoin(group).join(', ');
		prmRep += (Object.keys(catType).length == 0) ? "" : "<br>" + "Категории по видам товаров: " + strJoin(catType).join(', ');
		prmRep += (Object.keys(catBrand).length == 0) ? "" : "<br>" + "Категории по брендам: " + strJoin(catBrand).join(', ');
		prmRep += (Object.keys(good).length == 0) ? "" : "<br>" + "Товары: " + strJoin(good).join(', ');
		prmRep += (Object.keys(company).length == 0) ? "" : "<br>" + "Клиент: " + strJoin(company).join(', ');
		prmRep += (grouping_str.length == 0) ? "" : "<br>" + "Группировки отчета: " + grouping_str;
		$("#report_param_str").html(prmRep);

		orderby = ""; len = Object.keys(grouping).length - 1;
		for (id in grouping) {
			orderby += grouping[id].replace('_', '.') + " asc";
			if (len != parseInt(id))
				orderby += ', ';
		}
		orderby = orderby.split("g.goodID").join("g.Name");

		$("#gridRep").jqGrid('setGridParam', {datatype: "json", url: "../engine/report"+reportID+"_data" +
			"?sid=" + reportID +
			"&grouping=" + strJoin(grouping).join(';') +
			"&group=" + keyJoin(group).join(';') +
			"&catType=" + keyJoin(catType).join(';') +
			"&catBrand=" + keyJoin(catBrand).join(';') +
			"&goodID=" + keyJoin(good).join(';') +
			"&b2bCompanyID=" + keyJoin(company).join(';') +
			"&orderby=" + orderby +
			"",
		}).trigger('reloadGrid');
//		for(i=2; i<5; i++){
//			$("#gridRep").jqGrid('hideCol',"field"+i);
//		}
	});
});

</script>
<style>
 #feedback { font-size: 12px; }
 .selectable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
 .selectable li { margin: 3px; padding: 7px 0 0 5px; text-align: left;font-size: 14px; height: 34px; }
</style>
<div class="container-fluid center mt40">
	<ul id="myTab" class="nav nav-tabs floatL active hidden-print" role="tablist">
		<li class="active"><a href="#tab_filter" class="h40" role="tab" data-toggle="tab">Настройки отбора</a></li>
		<li><a href="#tab_grouping"  class="h40" role="tab" data-toggle="tab">Настройки группировок</a></li>
		<li><a id="a_tab_report" href="#tab_report" class="h40" role="tab" data-toggle="tab">Прайс-лист</a></li>
	</ul>
	<div class="floatL">
		<button id="button_report_run" class="btn btn-sm btn-info frameL m0 h40 hidden-print font14">
			<span class="ui-button-text" style1='width:120px;height:22px;'>Сформировать отчет</span>
		</button>
	</div>
	<div class="tab-content">
		<div class="active tab-pane min530 m0 w100p ui-corner-tab1 borderColor frameL border1" id="tab_filter">
			<div id="setting_filter" class='p5 frameL w500 h400 ml0 border0' style='display:table;'>
				<legend class="mb10">Параметры отбора данных:</legend>
				<div class="input-group input-group-lg mt10 w100p">
					<span class="input-group-addon w170">Настройки:</span>
					<div class="w100p" id="select_report_setting" name="select_report_setting"></div>
					<span class="input-group-btn hide">
						<a class="btn btn-default w100p" type="button">X</a>
					</span>
					<span class="input-group-btn w32">
						<a class="btn btn-default w100p" type="button"><img class="img-rounded h20 m0" src="../../image/save-as.png">
						</a>
					</span>
				</div>
				<div class="input-group input-group-lg mt20 w100p">
					<span class="input-group-addon w170">Группа товара:</span>
					<input id="group" name="group" type="text" class="form-control">
					<span class="input-group-btn w32">
						<a class="btn btn-default w100p" type="button">X</a>
					</span>
					<span class="input-group-btn w32">
						<a class="btn btn-default w100p" type="button">...</a>
					</span>
				</div>
				<div class="input-group input-group-lg mt5 w100p">
					<span class="input-group-addon w170">Категория по виду:</span>
					<input id="catType" name="catType" type="text" class="form-control" >
					<span class="input-group-btn w32">
						<a class="btn btn-default w100p" type="button">X</a>
					</span>
					<span class="input-group-btn w32">
						<a class="btn btn-default w100p" type="button">...</a>
					</span>
				</div>
				<div class="input-group input-group-lg mt5 w100p">
					<span class="input-group-addon w170">Категория по брендам:</span>
					<input id="catBrand" name="catBrand" type="text" class="form-control" >
					<span class="input-group-btn w32">
						<a class="btn btn-default w100p" type="button">X</a>
					</span>
					<span class="input-group-btn w32">
						<a class="btn btn-default w100p" type="button">...</a>
					</span>
				</div>
				<div class="input-group input-group-lg mt5 w100p">
					<span class="input-group-addon w170">Товар:</span>
					<input id="good" name="good" type="text" class="form-control">
					<span class="input-group-btn w32">
						<a class="btn btn-default w100p" type="button">X</a>
					</span>
					<span class="input-group-btn w32">
						<a class="btn btn-default w100p" type="button">...</a>
					</span>
				</div>
				<div class="input-group input-group-lg mt20 w100p">
					<span class="input-group-addon w170">Заказчик:</span>
					<input id="company" name="company" type="text" class="form-control">
					<span class="input-group-btn w32">
						<a class="btn btn-default w100p" type="button">X</a>
					</span>
					<span class="input-group-btn w32">
						<a class="btn btn-default w100p" type="button">...</a>
					</span>
				</div>
			</div>
			<div id="divGrid" class='p5 ui-corner-all frameL ml5 border0'>
				<legend class="mb10" id="legendGrid"></legend>
				<div id="divTree" class='frameL'>
					<table id="treeGrid"></table>
					<div id="ptreeGrid"></div>
				</div>
				<div id="divTable" class='frameL ml10'>
					<table id="grid1"></table>
					<div id="pgrid1"></div>
				</div>
				<div id="divTable2" class='frameL ml10'>
					<table id="grid2"></table>
					<div id="pgrid2"></div>
				</div>
			</div>
		</div>
		<div class="tab-pane m0 w100p min530 ui-corner-all borderColor frameL border1" id="tab_grouping">
			<div id="divGridGrouping" class='p5 ui-corner-all frameL m10 border1'>
				<legend class="mb10">Выбранные группировки</legend>
				<ol id="grouping" class="w100p selectable">
				</ol>
			</div>
			<div id="divGridGrouping_add" class='p5 ui-corner-all frameL m10 border1'>
				<legend>Возможные группировки</legend>
				<ul id="grouping_add" class="w100p selectable">
					<li class="bc1 ui-corner-all" id="groupName">
						<a id="a1" class="floatL ui-icon ui-icon-triangle-1-w mt2 show" type="button"></a>
						<span class="pl5 floatL w80p">Группа товара</span>
						<a id="a2" class="floatL ui-icon ui-icon-triangle-1-e mt2 hide" type="button"></a>
					</li>
					<li class="bc3 ui-corner-all" id="catTypeName">
						<a id="a1" class="floatL ui-icon ui-icon-triangle-1-w mt2 show" type="button"></a>
						<span class="pl5 floatL w80p">Категория по виду товара</span>
						<a id="a2" class="floatL ui-icon ui-icon-triangle-1-e mt2 hide" type="button"></a>
					</li>
					<li class="bc7 ui-corner-all" id="catBrandName">
						<a id="a1" class="floatL ui-icon ui-icon-triangle-1-w mt2 show" type="button"></a>
						<span class="pl5 floatL w80p">Категория по брендам</span>
						<a id="a2" class="floatL ui-icon ui-icon-triangle-1-e mt2 hide" type="button"></a>
					</li>
					<li class="bc2 ui-corner-all" id="g_goodID">
						<a id="a1" class="floatL ui-icon ui-icon-triangle-1-w mt2 show" type="button"></a>
						<span class="pl5 floatL w80p">Товар</span>
						<a id="a2" class="floatL ui-icon ui-icon-triangle-1-e mt2 hide" type="button"></a>
					</li>
				</ul>
			</div>
		</div>
		<div class="tab-pane m0 w100p min530 borderColor borderTop1 frameL center border0" id="tab_report">
			<div id='report_param_str' class="mt10 TAL font14">
			</div>
			<div id='div1' class='center frameL mt10'>
				<table id="gridRep"></table>
				<div id="pgridRep"></div>
			</div>
		</div>
	</div>
</div>
<div id="dialog" title="ВНИМАНИЕ!">
	<p id='text'></p>
</div>
<div id="dialog_progress" title="Ожидайте!">
	<img class="ml30 mt20 border0 w300" src="../../image/progress_circle5.gif">
</div>
