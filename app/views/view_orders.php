<script type="text/javascript">
$(document).ready(function () {
	$.jgrid.styleUI.Bootstrap.base.rowTable = "table table-bordered table-striped";
	$("#grid1").jqGrid({
		caption: "Список заказов",
		mtype: "GET",
//		url: "/engine/jqgrid3?action=order_list_b2b&grouping=OrderID&o.Status=0&f1=OrderID&f2=State&f3=DT_create&f4=Sum&f5=DeliveryAddress&f6=Notes",
		styleUI: 'Bootstrap',
		responsive: true,
		scroll: 1, height: 397, // если виртуальная подгрузка страниц
		//height: 'auto', //если надо управлять страницами
		//multiSort: true,
		datatype: "json",
		colModel: [
		    {label: '№ заказа', name: 'o_OrderID', index: 'o.OrderID', width: 100, sorttype: "number", search: false, align: "center"},
		    {label: 'Состояние', name: 'State', index: 'State', width: 120, sorttype: "text", search: false, align: "left"},
		    {label: 'Дата создания', name: 'DT_create', index: 'DT_create', width: 130, sorttype: "date", search: false, align: "center"},
		    {label: 'Сумма', name: 'Sum', index: 'Sum', width: 100, sorttype: "number", search: false, align: "right"},
		    {label: 'Адрес дост.', name: 'DeliveryAddress', index: 'DeliveryAddress', width: 200, sorttype: "text", search: false, align: "left"},
		    {label: 'Примечание', name: 'Notes', index: 'Notes', width: 200, sorttype: "text", search: false, align: "left"},
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
    });
	$("#grid1").jqGrid('navGrid', '#pgrid1', {edit: false, add: false, del: false, search: false, refresh: false, cloneToTop: true});
	$("#pg_pgrid1").remove();
	$("#pgrid1").removeClass('ui-jqgrid-pager');
	$("#pgrid1").addClass('ui-jqgrid-pager-empty');

	$('#myTab a').click(function (e) {
		e.preventDefault();
		//console.log($(this).attr('href'),$(this).attr('state'));
		if ($(this).attr('state')) {
			$("#divGrid").appendTo( $($(this).attr('href')));
			$("#divGrid").removeClass("hide");
			$("#grid1").jqGrid('setGridParam', {datatype: "json", url: "/engine/jqgrid3?action=order_list_b2b&grouping=OrderID&o.Status="+$(this).attr('state')+"&f1=OrderID&f2=State&f3=DT_create&f4=Sum&f5=DeliveryAddress&f6=Notes", page: 1});
			$("#grid1").trigger('reloadGrid');
		}
		$(this).tab('show');
	});
	
	$.post('/engine/order_info_full',{action: 'order_info'}, function (json) {
		if (json.success)
		    $("#div_order_active").html(json.html);
    });
	//$("#a_tab_1").tab('show');
	//$("#a_tab_1").click();
	setTimeout(function(){
//		$("#divGrid").appendTo( $("#tab_order_list1"));
//		$("#divGrid").removeClass("hide");
//
//		$("#a_tab_1").tab('show');
	}, 100);
});
</script>

<div class="container center">
	<ul id="myTab" class="nav nav-tabs floatL active hidden-print" role="tablist">
		<li class="active">	<a id="a_tab_0" href="#tab_order_action" role="tab" data-toggle="tab">Текущий заказ</a></li>
		<li>				<a id="a_tab_1" href="#tab_order_list1"	state="0" role="tab" data-toggle="tab">Предварительные</a></li>
		<li>				<a href="#tab_order_list2"	role="tab" state="10" data-toggle="tab">Отправленные</a></li>
		<li>				<a href="#tab_order_list3"	role="tab" state="20" data-toggle="tab">Обработанные</a></li>
		<li>				<a href="#tab_order_list4"	role="tab" state="50" data-toggle="tab">Отгруженные</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane m0 w100p min530 ui-corner-tab1 borderColor frameL border1 active" id="tab_order_action">
			<div class="pull-left ml5 mt5" id="div_order_active" ></div>
		</div>
		<div class="tab-pane m0 w100p min530 ui-corner-all borderColor frameL border1" id="tab_order_list1">
		</div>
		<div class="tab-pane m0 w100p min530 ui-corner-all borderColor frameL border1" id="tab_order_list2">
		</div>
		<div class="tab-pane m0 w100p min530 ui-corner-all borderColor frameL border1" id="tab_order_list3">
		</div>
		<div class="tab-pane m0 w100p min530 ui-corner-all borderColor frameL border1" id="tab_order_list4">
		</div>
	</div>
</div>
<div id="divGrid" class="panel pull-left ml5 mt5 mb0 hide">
	<table id="grid1"></table>
	<div id="pgrid1"></div>
</div>
