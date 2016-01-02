<link type="text/css" rel="stylesheet" href="/css/jsgrid/jsgrid.css" />
<link type="text/css" rel="stylesheet" href="/css/jsgrid/jsgrid-theme.css" />
<script type="text/javascript" src="/js/jsgrid.js"></script>
<link type="text/css" rel="stylesheet" href="/css/bootstrap-treeview.css" />
<script src="/js/bootstrap-treeview.js"></script>

<script type="text/javascript">
$(document).ready(function () {
	var myfilter = new Object;
	$.post('/engine/catalog',{parentid:50}, function (json){
		$("#tree").treeview({
			levels: 2,
			nodeIcon: "glyphicon glyphicon-list-alt",
			color: "gray",
			backColor: "#FFFFFF",
			onhoverColor: "orange",
			borderColor: "gray",
			selectedColor: "blue",
			selectedBackColor: "#E7E7E7",
//			color: "white",
//			backColor: "#81B0E7",
//			onhoverColor: "orange",
//			borderColor: "blue",
//			selectedColor: "yellow",
			showBorder: true,
			showTags: false,
			highlightSelected: true,
			//selectedBackColor: "darkorange",
			data: json,
			onNodeSelected: function (event, node) {
				//console.log(event, node);
				if (node.childs != 0) {
				$('#tree').treeview('toggleNodeExpanded', [ node.nodeId, { silent: true } ]);
					$('#tree').treeview('toggleNodeSelected', [ node.nodeId, { silent: true } ]);
					return;
				}
				myfilter.catid = node.CatID;
				$("#jsGrid").jsGrid("loadData");
			},
		});
	});

	$("#jsGrid").jsGrid({
		height: "auto",
		width: "auto",
		//width: "800",
		sorting: true,
		paging: true,
		filtering: true,
		selecting: true,
		pageLoading: false,
		autoload: false,
		controller: {
			loadData: function(filter) {
				filter.action = 'goods_list';
				filter.catid = myfilter.catid;
		//console.log($.param(filter));
				var d = $.Deferred();
				$.ajax({
					url: "/engine/goods_list?" + $.param(filter),
					dataType: "json"
				}).done(function (response) {
					d.resolve(response);
				});
				return d.promise();
				}
		},
		fields: [
			{name: "Article", title: "Артикул", width: 100, type: "text"},
			{name: "Name", title: "Название", width: 250, type: "text"},
			{name: "Price", title: "Цена", width: 50, type: "number", align: "right", sorter: "number", filtering: false},
			{name: "Unit_in_pack", title: "В упак.", width: 50, type: "number", align: "right", sorter: "number", filtering: false},
			{name: "FreeBalance", title: "Наличие", width: 70, type: "text", align: "right", sorter: "number", filtering: true,},// filterType: "checkbox"},
			{name: "Qty", title: "Заказ", width: 100, type: "number", align: "center", sorter: "number", filtering: false,
//				cellRenderer: function (value, item) {
//					return '<td><input type="number" class="w50 center" onchange="good_edit(this,' + item.GoodID + ');">\n\
//										<input type="button" class="jsgrid-button jsgrid-delete-button" title="Удалить" onclick="good_delete(this,' + item.GoodID + ');">\n\
//									</td>';
//				},
			},
		]
	});
	
	good_delete = function (el,goodid){
		$(el).prev().val("");
		good_edit($(el).prev(),goodid);
	}
	good_edit = function (el,goodid){
		$.post('/engine/order_edit',{action:'good_edit', goodid:goodid, qty:$(el).val()}, function (json) {
			console.log(json);
		});
	}
//	$("#jsGrid").attr('style','');
//	$("#jsGrid").attr('style','width:700px;');
//	console.log($("#jsGrid").attr('style'));
setTimeout(function (){
//	document.getElementById("jsGrid").style['width'] = '700px';
	//console.log(document.getElementById("jsGrid").style['width']);
},200);

	$("#jqGrid").jqGrid({
		url: 'http://trirand.com/blog/phpjqgrid/examples/jsonp/getjsonp.php?callback=?&qwery=longorders',
		mtype: "GET",
		styleUI : 'Bootstrap',
		datatype: "jsonp",
		colModel: [
			{label: 'OrderID', name: 'OrderID', key: true, width: 75},
			{label: 'Customer ID', name: 'CustomerID', width: 150},
			{label: 'Order Date', name: 'OrderDate', width: 150},
			{label: 'Freight', name: 'Freight', width: 150},
			{label: 'Ship Name', name: 'ShipName', width: 150}
	    ],
	    viewrecords: true,
	    height: 250,
	    rowNum: 20,
	    pager: "#jqGridPager"
	});

	$('#tree1').jqGrid({
				"url":"/engine/tree_json",
				"colModel":[
					{
						"name":"category_id",
						"index":"accounts.account_id",
						"sorttype":"int",
						"key":true,
						"hidden":true,
						"width":50
					},{
						"name":"name",
						"index":"name",
						"sorttype": "string",
		    "label": "Name",
		    "width": 170
		}, {
		    "name": "price",
		    "index": "price",
		    "sorttype": "numeric",
		    "label": "Price",
		    "width": 90,
		    "align": "right"
		}, {
		    "name": "qty_onhand",
		    "index": "qty_onhand",
		    "sorttype": "int",
		    "label": "Qty",
		    "width": 90,
		    "align": "right"
		}, {
		    "name": "color",
		    "index": "color",
		    "sorttype": "string",
		    "label": "Color",
		    "width": 100
		}, {
		    "name": "lft",
		    "hidden": true
		}, {
		    "name": "rgt",
		    "hidden": true
		}, {
		    "name": "level",
		    "hidden": true
		}, {
		    "name": "uiicon",
		    "hidden": true
		}
	    ],
	    "beforeRequest": function () {
		if (this.p.postData.nodeid != null) {
		    var nid = parseInt(this.p.postData.nodeid, 10);
		    console.log(nid);
		    if (nid > -1) {
			switch (nid) {
			    case 1 :
				this.p.url = "data1.json";
				break;
			    case 2 :
				this.p.url = "data2.json";
				break;
			    case 3 :
				this.p.url = "data3.json";
				break;
			    case 23 :
				this.p.url = "data23.json";
				break;
			}
		    }
		}
	    },
	    "width": "780",
	    "hoverrows": false,
	    "viewrecords": false,
	    "gridview": true,
	    "height": "auto",
	    "sortname": "lft",
	    "loadonce": false,
	    "rowNum": 100,
	    "scrollrows": true,
	    // enable tree grid
	    "treeGrid": true,
	    // which column is expandable
	    "ExpandColumn": "name",
	    // datatype
	    "treedatatype": "json",
	    // the model used
	    "treeGridModel": "nested",
	    // configuration of the data comming from server
	    "treeReader": {
		"left_field": "lft",
		"right_field": "rgt",
		"level_field": "level",
		"leaf_field": "isLeaf",
		"expanded_field": "expanded",
		"loaded": "loaded",
		"icon_field": "icon"
	    },
	    "sortorder": "asc",
	    "datatype": "json",
	    "pager": "#pager1"
	});
});
</script>
<div id="div_desktop" class="container-fluid min500">
	<div id="tree"	 class="w250 h570 floatL 0max450 0ofy"></div>
	<div id="jsGrid" class="ml5 minw400 maxw800 floatL ui-corner-all"></div>
	<div id="order"  class="border1 floatL">Order</div>
	<div class="floatL">
		<table id="jqGrid"></table>
		<div id="jqGridPager"></div>
	</div>
	<div class="floatL">
		<table id="tree1"></table>
		<div id="pager1"></div>	</div>
</div>

