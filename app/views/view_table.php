<link type="text/css" rel="stylesheet" href="/css/jsgrid/jsgrid.min.css" />
<link type="text/css" rel="stylesheet" href="/css/jsgrid/jsgrid-theme.min.css" />
<script type="text/javascript" src="/js/jsgrid.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    $("#jsGrid").jsGrid({
        height: "auto",
        width: "100%",
 
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
	<div id="jsGrid"></div>
</div>
