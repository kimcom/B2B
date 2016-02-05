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
				cellRenderer: function (value, item) {
					return '<td><input type="number" class="w50 center" onchange="good_edit(this,' + item.GoodID + ');">\n\
										<input type="button" class="jsgrid-button jsgrid-delete-button" title="Удалить" onclick="good_delete(this,' + item.GoodID + ');">\n\
									</td>';
				},
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

});
</script>
<div id="div_desktop" class="container-fluid min500">
	<div id="tree"	 class="w250 h570 floatL 0max450 0ofy"></div>
	<div id="jsGrid" class="ml5 minw400 maxw800 floatL ui-corner-all"></div>
	<div id="order"  class="border1 floatL">Order</div>
</div>

