<link type="text/css" rel="stylesheet" href="/css/jsgrid/jsgrid.min.css" />
<link type="text/css" rel="stylesheet" href="/css/jsgrid/jsgrid-theme.min.css" />
<script type="text/javascript" src="/js/jsgrid.min.js"></script>
<link type="text/css" rel="stylesheet" href="/css/bootstrap-treeview.css" />
<script src="/js/bootstrap-treeview.js"></script>
<style type="text/css" id="treeview8-style"> 
	.treeview .list-group-item{
		cursor:pointer
	}
	.treeview span.indent{
		margin-left:10px;
		margin-right:10px
	}
	.treeview span.icon{
		width:12px;
		margin-right:5px
	}
	.treeview .node-disabled{
		color:silver;
		cursor:not-allowed
	}
	.node-treeview8{
		color:yellow;
		background-color:purple;
		border:none;
	}
	.node-treeview8:not(.node-disabled):hover{
		background-color:orange;
	}
</style>
<style type="text/css" id="treeview9-style"> 
	.node-treeview9{
		color:yellow;
		background-color:purple;
		border:none;
	}
	.node-treeview9:not(.node-disabled):hover{
		background-color:orange;
	} 
</style>
<script type="text/javascript">
$(document).ready(function () {
	var db = [{
    text: "Parent 1",
	id: 1456,
    nodes: [{
        text: "Child 1",
        nodes: [{
            text: "Grandchild 1"
			},{
            text: "Grandchild 2"
			}]},
			{
        text: "Child 2"
		    }]
		},{
	text: "Parent 2"
		},{
	text: "Parent 3"
	    },{
	text: "Parent 4"
	    },{
	text: "Parent 5"
	    }
	];	
	
        var alternateData = [
          {
            text: 'Parent 1',
            tags: ['2'],
            nodes: [
              {
                text: 'Child 1',
                tags: ['3'],
                nodes: [
                  {
                    text: 'Grandchild 1',
                    tags: ['6']
                  },
                  {
                    text: 'Grandchild 2',
                    tags: ['3']
                  }
                ]
              },
              {
                text: 'Child 2',
                tags: ['3']
              }
            ]
          },
          {
            text: 'Parent 2',
            tags: ['7']
          },
          {
            text: 'Parent 3',
            icon: 'glyphicon glyphicon-earphone',
            href: '#demo',
            tags: ['11']
          },
          {
            text: 'Parent 4',
            icon: 'glyphicon glyphicon-cloud-download',
            href: '/demo.html',
            tags: ['19'],
			selected: true
		    },
		    {
			text: 'Parent 5',
			icon: 'glyphicon glyphicon-certificate',
			color: 'pink',
			backColor: 'red',
			href: 'http://www.tesco.com',
			tags: ['available', '0']
		    }
		];

////	$('#tree').treeview({data:db});
//	$('#tree').treeview({
//		data:db,
//		levels: 5,
//		color: 'white',
//		backColor: 'green',
//		onNodeSelected: function(event, data) {
////			console.log(data);
////			console.log(event);
////$(data).add($(data.nodes[0]));
//			//console.log(data);
//			//console.log(data.nodes[0]);
////			node = $('#tree').treeview('getParent', data);
////console.log(node);
////console.log(data.data);
////console.log($('#tree').data);
//return;
//			nodeId = null; node = null;
//			//$('#tree').treeview('getSelected', nodeId);
//			//console.log($('#tree').treeview('getSelected'));
//			//$('#tree').treeview('getSiblings', node);
////			curnode = $('#tree [data-nodeid='+data.nodeId+']');
////			console.log(curnode);
//			//console.log($('#tree [data-nodeid=6]'));
//			$.post('/engine/tree1',{id:data.id}, function (json) {
//				console.log(json);
////				console.log(JSON.stringify(json));
//				$('#tree2').treeview({data:json});
//				return;
////				console.log($('#tree2 ul').html());
//				//curnode.append($('#tree2 ul').html());
//				$('#tree2 ul li').removeClass('node-tree2');
//				$('#tree2 ul li').addClass('node-tree');
//				//$('#tree2 ul li').attr('data-nodeid',null);
//				$('#tree [data-nodeid='+data.nodeId+']').after($('#tree2 ul').html());
//				//$('#tree').treeview('checkAll',{});
//				//$('#tree ul').append($('#tree2 ul').html());
//				//$('#tree2 ul').appendTo($(data));
//				//$('#tree2 ul').appendTo(curnode);
//				
//				
//		//		$('#tree').treeview({data:db});
//				//return json;
//			});
//		}
//	});
//	$('#tree').treeview({data: function (){
//	console.log('start');
	$.post('/engine/tree2',{parentid:10}, function (json) {
//		console.log(JSON.stringify(json));
		//console.log(json);
		$('#tree2').treeview({
			levels: 2,
			expandIcon: "glyphicon glyphicon-stop",
			collapseIcon: "glyphicon glyphicon-unchecked",
			nodeIcon: "glyphicon glyphicon-user",
			color: "white",
			backColor: "#033C73",
			onhoverColor: "orange",
			borderColor: "red",
			showBorder: false,
			showTags: true,
			highlightSelected: true,
			selectedColor: "yellow",
			selectedBackColor: "darkorange",
			//data: alternateData
			data: json
		});
//		$('#tree').treeview({data:json});
//		$('#tree').treeview({data:db});
//		//return json;
});

//	$('#treeview8').treeview({
//          expandIcon: "glyphicon glyphicon-stop",
//          collapseIcon: "glyphicon glyphicon-unchecked",
//          nodeIcon: "glyphicon glyphicon-user",
//          color: "yellow",
//          backColor: "purple",
//          onhoverColor: "orange",
//          borderColor: "red",
//          showBorder: false,
//          showTags: true,
//          highlightSelected: true,
//          selectedColor: "yellow",
//          selectedBackColor: "darkorange",
//          data: db
//        });
//
//        $('#treeview9').treeview({
//          expandIcon: "glyphicon glyphicon-stop",
//          collapseIcon: "glyphicon glyphicon-unchecked",
//          nodeIcon: "glyphicon glyphicon-user",
//          color: "yellow",
//          backColor: "purple",
//          onhoverColor: "orange",
//          borderColor: "red",
//          showBorder: false,
//          showTags: true,
//          highlightSelected: true,
//          selectedColor: "yellow",
//          selectedBackColor: "darkorange",
//          data: alternateData
//        });
    $("#jsGrid").jsGrid({
        height: "auto",
        width: "auto",
 
        sorting: true,
        paging: false,
        autoload: true,
 
        controller: {
            loadData: function() {
                var d = $.Deferred();
                $.ajax({
					url: "/engine/testlistusers",
					dataType: "json"
				}).done(function (response) {
					d.resolve(response);
				});
				return d.promise();
			}
	    },
	    fields: [
		{name: "Username", type: "text"},
		{name: "FIO", type: "text"},
		{name: "Post", type: "text"},
		{name: "Phone", type: "text"},
		{name: "Email", type: "textarea", width: 150},
		{name: "Company", type: "textarea", width: 150},
		{name: "CompanyID", type: "number", width: 50, align: "center"}
//		{name: "Rating", type: "number", width: 50, align: "center",
//		    itemTemplate: function (value) {
//			return $("<div>").addClass("rating").append(Array(value + 1).join("&#9733;"));
//		    }
//		},
//		{name: "Price", type: "number", width: 50,
//		    itemTemplate: function (value) {
//			return value.toFixed(2) + "$";
//		    }
//		}
		]
	    });
});
</script>

<div class="container-fluid min500 p0">
	<div id="tree"></div>
	<div id="tree2" class="floatL maxw400"></div>
	<div id="jsGrid" class="floatL"></div>
	<!--	<div id="treeview8" class="treeview"></div>
	<div id="treeview9" class="treeview"></div>-->
</div>
