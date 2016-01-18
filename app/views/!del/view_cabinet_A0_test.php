<link type="text/css" rel="stylesheet" href="/css/jsgrid/jsgrid.css" />
<link type="text/css" rel="stylesheet" href="/css/jsgrid/jsgrid-theme.css" />
<script type="text/javascript" src="/js/jsgrid.js"></script>
<link type="text/css" rel="stylesheet" href="/css/bootstrap-treeview.css" />
<script src="/js/bootstrap-treeview.js"></script>

<script type="text/javascript">
$(document).ready(function () {

	good_delete = function (el,goodid){
		$(el).prev().val("");
		good_edit($(el).prev(),goodid);
	}
	good_edit = function (el,goodid){
		$.post('/engine/order_edit',{action:'good_edit', goodid:goodid, qty:$(el).val()}, function (json) {
			console.log(json);
		});
	}

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
//		autowidth:true,
		shrinkToFit: true,
		height: 250,
	    rowNum: 20,
	    pager: "#jqGridPager"
	});

	$('#tree').jqGrid({
		"url":"/engine/tree_json",
		styleUI : 'Bootstrap',
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
//	    "width": "780",
//		autowidth:true,
		shrinkToFit: true,
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
	    "pager": "#pager"
	});
});
</script>
<div id="div_desktop" class="container-fluid min500">
	<div class="floatL">
		<table id="tree"></table>
		<div id="pager"></div>
	</div>
	<div class="floatL ml10">
		<table id="jqGrid"></table>
		<div id="jqGridPager"></div>
	</div>
	<div id="order"  class="ml10 border1 floatL">Order</div>
</div>

