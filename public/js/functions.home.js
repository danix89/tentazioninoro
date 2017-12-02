jQuery(document).ready(function ($) {
    $('#riparazioneModal').modal({show: false});

    $(".logout").click(function (e) {
	e.preventDefault();
	logout();
    });

    $('#modify-fixing').click(function () {
	
    });
});

function initializeGrid(gridId, routeBaseUrl) {
    var grid = $(gridId).bootgrid({
	selection: true,
	multiSelect: true,
	formatters: {
	    "commands": function (column, row) {
//		console.log(row);
		return "<a href=\"" + routeBaseUrl + "/" + row.fixing_id + "\"]) }}\"><span class=\"glyphicon glyphicon-pencil\"></span></a> " +
			"<button id=\"delete-fixing\" type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.fixingId + "\"><span class=\"glyphicon glyphicon-trash\"></span></button>";
	    }
	}
    }).on("selected.rs.jquery.bootgrid", function (e, rows) {
	var rowIds = [];
	for (var i = 0; i < rows.length; i++) {
	    rowIds.push(rows[i].fixingId);
	}
	console.log("Select: " + rowIds.join(","));
    }).on("deselected.rs.jquery.bootgrid", function (e, rows) {
	var rowIds = [];
	for (var i = 0; i < rows.length; i++) {
	    rowIds.push(rows[i].fixingId);
	}
	console.log("Deselect: " + rowIds.join(","));
    }).on("loaded.rs.jquery.bootgrid", function (e, rows) {
	if($("#delete-all-btn").length === 0) {
	    $(".actions.btn-group .dropdown.btn-group").last().after('<div id="delete-all-btn" class="dropdown btn-group"><button class="btn btn-default dropdown-toggle" type="button" style="width:51px; height:34px;"><span class="glyphicon glyphicon-trash"></span></div>');
	}
    });
}