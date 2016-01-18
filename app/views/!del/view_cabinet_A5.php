<!--<link type="text/css" rel="stylesheet" href="/css/jsgrid/jsgrid.min.css" />
<link type="text/css" rel="stylesheet" href="/css/jsgrid/jsgrid-theme.min.css" />-->
<link type="text/css" rel="stylesheet" href="/css/jsgrid/jsgrid.css" />
<link type="text/css" rel="stylesheet" href="/css/jsgrid/jsgrid-theme.css" />
<!--<script type="text/javascript" src="/js/jsgrid.min.js"></script>-->
<script type="text/javascript" src="/js/jsgrid.js"></script>

<link type="text/css" rel="stylesheet" href="/css/bootstrap-treeview.css" />
<script src="/js/bootstrap-treeview.js"></script>

<style>
	.button-panel {
		position: fixed;
/*		min-height: 640px;*/
		width: 80px;
	}
	.userdiv {
		position: absolute;
		background: #81B0E7;
		border: 2px solid #FFFFFF;
		border-radius: 4px;
		opacity: 1;
		width: 80px;
		height: 80px;
		z-index: 1500;
		transition: 0.4s;
	}
	.userdiv img {
		width: 40px;
		margin-left: 20px;
		margin-top: 10px;
		text-align: center;
	}
	.userdiv:hover {
		box-shadow: 0 0 20px 1px black;
		border: 2px solid #CEFCEF;
	}
	.userdiv h6 {
		color: black;
	}
</style>
<script type="text/javascript">
$(document).ready(function () {
	//var newtop = 141;
	var newtop = 1;
	$.each($(".userdiv"),function (index,div){
		$(div).css({left:0,top:newtop});
		newtop += $(div).height()+1;
	});
	
	var myfilter = new Object;
	create_div = function (parent) {
		divid = parent.id.replace('panel_','');
		//console.log($("#"+divid),divid);
		$("#"+divid).remove();
		div = $("#div_window").clone();
		tree = $("#tree").clone();
		grid = $("#jsGrid").clone();
		$(tree).removeClass("hide");
		$(grid).removeClass("hide");
		$(div).removeClass("hide");
		$(div).attr("id",divid);
		$(div).find("#ui-id-1").html($(parent).find("A H6").html());
		$(div).css({position: 'relative', left: 0, top: 0, width: 0, height: 0, margin: 0, float: 'left', color: '#1B4796', background0: '#F4FAFF', border: '1px solid #AAAAAA', 'border-radius': 4, 'z-index': 110});
//		$(div).resizable();
//		$(div).draggable();
		//console.log($(parent).attr('parrent-id'));
//console.log(parent.id);
		if (parent.id=='panel_order') {
			h = 539; w = 320;
			$("#div_desktop").append($(div));
			$(div).animate({
				left: 0, top: 0,
				height: h, width: w,
				opacity: 1
			}, 500);
		}else if (parent.id=='panel_catalog') {
			$.post('/engine/catalog',{parentid:$(parent).attr('parrent-id')}, function (json){
				$(tree).treeview({
					levels: 2,
					nodeIcon: "glyphicon glyphicon-list-alt",
					color: "white",
					backColor: "#81B0E7",
					onhoverColor: "orange",
					borderColor: "blue",
					showBorder: true,
					showTags: false,
					highlightSelected: true,
					selectedColor: "yellow",
					//selectedBackColor: "darkorange",
					data: json,
					onNodeSelected: function (event, node) {
						//console.log(event, node);
						if (node.childs != 0 ) {
							$('#tree').treeview('toggleNodeExpanded', [ node.nodeId, { silent: true } ]);
							$('#tree').treeview('toggleNodeSelected', [ node.nodeId, { silent: true } ]);
							return;
						}
						//filter = $("#jsGrid").jsGrid("getFilter");
						myfilter.catid = node.CatID;
//$("#jsGrid").jsGrid("search", { FreeBalance: 0 }).done(function() {
//    console.log("filtering completed");
//});
//						console.log(myfilter);
						$("#jsGrid").jsGrid("loadData");//.done(function() {
//						$("#jsGrid").jsGrid("loadData",{catid:node.CatID}).done(function() {
//							console.log("data loaded");
//						});
					},
				});
				$(div).append($(tree));
				$(div).append($(grid));
				grid = $(div).find("#jsGrid");
	//			h = $(window).height()-140;
	//			w = $(window).width()-80;
				h = 539; w = 950;//w = 1270;
				$("#div_desktop").append($(div));
				$(div).animate({
					left: 0, top: 0,
					height: h, width: w,
					opacity: 1
				}, 500);

				$(grid).jsGrid({
					height: h-33,
					width: 690,
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
								url: "/engine/goods_list?"+$.param(filter),
								dataType: "json"
							}).done(function (response) {
								d.resolve(response);
							});
							return d.promise();
						}
					},
//					onDataLoading: function(args) {
//						console.log("args:",args);
//					},
					fields: [
//						{name: "GoodID",	title: "GoodID",	width:50,	type: "text"},
						{name: "Article",	title: "Артикул",	width:50,	type: "text"},
						{name: "Name",		title: "Название",	width:150,	type: "text"},
						{name: "Price",		title: "Цена",		width:30,	type: "number", align: "right", sorter: "number", filtering:false},
						{name: "Unit_in_pack",title: "В упак.",	width:30,	type: "number", align: "right", sorter: "number", filtering:false},
						{name: "FreeBalance",title: "Наличие",	width:30,	type: "text",	align: "right", sorter: "number", filtering:true, filterType: "checkbox" },
						{name: "Qty",		title: "Заказ",		width:50,	type: "number", align: "center",sorter: "number", filtering:false,
							cellRenderer: function (value,item){
								//console.log(value,item);
								return '<td><input type="number" class="w50 center" onchange="good_edit(this,'+item.GoodID+');">\n\
											<input type="button" class="jsgrid-button jsgrid-delete-button" title="Удалить" onclick="good_delete(this,'+item.GoodID+');">\n\
										</td>';
							},
						},
						//{type:"control"}
					]
				});
			});
		}
    }
	
    $(".userdiv").click(function () {
		create_div(this);
    });	
	$("#panel_catalog").click();
	setTimeout(function (){$("#panel_order").click();},500);
	
	good_delete = function (el,goodid){
		$(el).prev().val("");
		good_edit($(el).prev(),goodid);
	}
	good_edit = function (el,goodid){
		$.post('/engine/order_edit',{action:'good_edit', goodid:goodid, qty:$(el).val()}, function (json) {
			console.log(json);
		});
	}
});
</script>
<div class="button-panel collapse navbar-collapse">
	<div id="panel_catalog" class="userdiv" parrent-id="50">
		<img src="/image/icons/catalog.png">
		<a style="text-decoration:none;"><h6 class="TAC c2 mt0">Каталог по брендам</h6></a>
	</div>
	<div id="panel_catalog" class="userdiv" parrent-id="20">
		<img src="/image/icons/catalog.png">
		<a style="text-decoration:none;"><h6 class="TAC c2 mt0">Каталог по категориям</h6></a>
	</div>
	<div id="panel_catalog" class="userdiv" parrent-id="70">
		<img src="/image/icons/catalog.png">
		<a style="text-decoration:none;"><h6 class="TAC c2 mt0">Категории по видам жив.</h6></a>
	</div>
	<div id="panel_order" class="userdiv" parrent-id="">
		<img src="/image/icons/active.png">
		<a style="text-decoration:none;"><h6 class="TAC c2 mt0">Текущий заказ</h6></a>
	</div>
	<div id="panel_order_list" class="userdiv" parrent-id="">
		<img src="/image/icons/history.png">
		<a style="text-decoration:none;"><h6 class="TAC c2 mt0">Список заказов</h6></a>
	</div>
	<div id="panel_goods_stable" class="userdiv" parrent-id="">
		<img src="/image/icons/favorites.png">
		<a style="text-decoration:none;"><h6 class="TAC c2 mt0">Постоянные товары</h6></a>
	</div>
	<div id="panel_search" class="userdiv" parrent-id="">
		<img src="/image/icons/balance.png">
		<a style="text-decoration:none;"><h6 class="TAC c2">Поиск по каталогу</h6></a>
	</div>
<!--	<div id="draggable5" class="userdiv">
		<img src="/image/icons/settings.png">
		<a style="text-decoration:none;"><h6 class="TAC c2">Настройки</h6></a>
	</div>-->
</div>
<div id="div_window" class="hide ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-draggable ui-resizable border1">
	<div class="div-win-titlebar ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix ui-draggable-handle" style="background:#5C74C2">
		<span id="ui-id-1" class="ui-dialog-title" style="color: #FFFFFF">&nbsp;</span>
		<button type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close" role="button" title="Закрыть" 
				onclick="window.scroll(600,0);$(this).parent().parent().remove();">
			<span class="ui-button-icon-primary ui-icon ui-icon-closethick"></span>
		</button>
	</div>
</div>

<div id="div_desktop" class="container-fluid pl80 pr0 min500">
</div>

<div id="tree" class="hide w250 h500 floatL 0max450 ofy"></div>
<div id="jsGrid" class="hide floatL"></div>
