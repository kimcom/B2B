<script type="text/javascript">
$(document).ready(function () {
	$.jgrid.styleUI.Bootstrap.base.rowTable = "table table-bordered table-striped";
	$("#treegrid").jqGrid({
		styleUI : 'Bootstrap',
		treeGrid: true,
		treeGridModel: 'nested',
		treedatatype: 'json',
		datatype: "json",
		mtype: "POST",
		height: 530,
		ExpandColumn : 'name',
		ExpandColClick: true,
		url: '/engine/tree_NS?nodeid=0',
		colNames:["id","Каталог"],
		colModel:[
			{name:'id',index: 'id', width: 1, hidden: true, key: true},
		    {name: 'name', index: 'name', width: 240, resizable: false, editable: true, sorttype: "text", edittype: 'text', stype: "text", search: true}
		],
		sortname: "Name",
		sortorder: "asc",
		caption: "Категории товаров",
		toppager: false,
		onSelectRow: function (cat_id, status, e) {
			if (cat_id == null) cat_id = 0;
			row = $("#treegrid").jqGrid('getRowData',cat_id);
			//console.log(row,row.lft,row.rgt,row.lft-row.rgt);
			if (row.rgt - row.lft!=1) {$('#grid1').jqGrid('clearGridData');return;}
			var newurl = "/engine/jqgrid3?action=good_list_b2b&sid=5&group=" + cat_id + "&f1=Article&f2=Name&f3=Price&f4=Unit_in_pack&f5=FreeBalance&f6=Order";
			$("#grid1").jqGrid('setGridParam', {url: newurl, page: 1});
			$("#grid1").jqGrid('setCaption', 'Список товаров из категории: '+row.name);
			$("#grid1").trigger('reloadGrid');
		}
    });
	$("#treegrid_name").remove();

	good_edit = function (el,goodid,val){
		$.post('/engine/order_edit',{action:'order_edit', goodid:goodid, qty:val}, function (json) {
//			console.log(JSON.stringify(json.row));
			if (json.success) {
				$(el).val(val==0?'':val);
				$.post('/engine/order_info',{action: 'order_info', orderid: 5}, function (json) {
					if (json.success) $("#div_order").html(json.html);
				});
			}
		});
	}
	formatQty = function (cellValue, options, rowObject) {
		var html = '<input type="number" class="TAC editable inline-edit-cell" style="line-height:17px;width:60%;" onchange="good_edit(this,'+options.rowId+',$(this).val());">' + 
				   '<span class="ml10 mr10 glyphicon glyphicon-remove" onclick="good_edit($(this).prev(),'+options.rowId+',0);"></span>';
		return html;
    }

	$("#grid1").jqGrid({
		caption: "Список товаров",
		mtype: "GET",
		url: "/engine/jqgrid3?action=good_list_b2b&sid=5&group=-1&f1=Article&f2=Name&f3=Price&f4=Unit_in_pack&f5=FreeBalance&f6=Order",
		styleUI : 'Bootstrap',
		responsive: true,
		scroll: 1, height: 452, // если виртуальная подгрузка страниц
		//height: 'auto', //если надо управлять страницами
		//multiSort: true,
		datatype: "json",
	    colModel: [
			{label:'Артикул',		name:'Article',		index:'Article',	width: 100, sorttype: "text",	search: true,
				searchoptions: { 
					dataInit: function (element) {
					    $(element).attr("autocomplete", "off").typeahead({
						autoSelect: false, items: '20', minLength: 3, appendTo: "body",
						source: function (query, proxy) {
						    $.ajax({url: '/engine/select_search?action=good_article', dataType: "json", data: {name: query}, success: proxy});
						}
					    });
					}
			    }
			},
			{label:'Название',		name:'Name',		index:'Name',		width: 220, sorttype: "text",	search: true,
				searchoptions: { 
					dataInit: function (element) {
						$(element).attr("autocomplete","off").typeahead({ 
							autoSelect: false, items:'20', minLength:3,	appendTo : "body",
							source: function(query, proxy) {
									$.ajax({ url: '/engine/select_search?action=good_name', dataType: "json", data: {name: query}, success : proxy });
								}
							});
					}
				}
			},
			{label:'Цена',			name:'Price',		index:'Price',		width: 60, sorttype: "number", search: false, align: "right"},
			{label:'В уп.',			name:'Unit_in_pack',index:'Unit_in_pack',width:60, sorttype: "number", search: false, align: "center"},
			{label:'Налич.',		name:'FreeBalance', index:'FreeBalance',width: 60, sorttype: "number", search: false, align: "center"},
			{label:'Заказ',			name:'Qty',			index:'Qty',		width: 90, sorttype: "number", search: false, align: "center", 
				editable: true,
				formatter: formatQty,
			},
		],
		rowNum: 20,
		rowList: [20, 30, 40, 50, 100, 200, 300],
	    sortname: "Name",
	    viewrecords: true,
//		autowidth:false,
		shrinkToFit: true,
//		forceFit:true,
		toppager: true,
		gridview : true,
	    pager: "#pgrid1", 
		pagerpos: "left",
		//altclass:"ui-priority-secondary2",
		//altRows:true,
	});
	$("#grid1").jqGrid('navGrid','#pgrid1', {edit:false, add:false, del:false, search:false, refresh: false, cloneToTop: true});
	$("#grid1").jqGrid('filterToolbar', { autosearch: true, searchOnEnter: true,
		afterSearch: function () {
			p = $(this).jqGrid('getGridParam', 'postData');
			flt = '';
			if (p.Article) flt += ' Артикул: '+p.Article;
			if (p.Name) flt += ' Название: '+p.Name;
			$("#grid1").jqGrid('setCaption', 'Список найденных товаров.'+flt);
		}
	});
	$("#pg_pgrid1").remove();
	$("#pgrid1").removeClass('ui-jqgrid-pager');
	$("#pgrid1").addClass('ui-jqgrid-pager-empty');

	$.post('/engine/order_info',{action: 'order_info', orderid: 5}, function (json) {
		if (json.success) $("#div_order").html(json.html);
	});
});
</script>
<div class="container-fluid min500">
	<div class="container p0">
	<div class="panel pull-left m0 ml5">
		<table id="treegrid"></table>
		<div id="ptreegrid"></div>
	</div>
	<div class="panel pull-left m0 ml5">
		<table id="grid1"></table>
		<div id="pgrid1"></div>
	</div>
	<div class="panel panel-default pull-left m0 ml5" id="div_order" ></div>
</div>
</div>
