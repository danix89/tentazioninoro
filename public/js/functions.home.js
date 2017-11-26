jQuery(document).ready(function ($) {
    $('#riparazioneModal').modal({show: false});

    $(".logout").click(function (e) {
	e.preventDefault();
	logout();
    });

    $('#modify-riparazione').click(function () {

	$('#riparazioneModal').modal('show');
    });
});

function initialize_grid(grid_id) {
    var grid = $(grid_id).bootgrid({
	selection: true,
	multiSelect: true,
	formatters: {
	    "commands": function (column, row) {
//		console.log(row);
		return "<button id=\"modify-fixing\" type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.fixing_id + "\"><span class=\"glyphicon glyphicon-pencil\"></span></button> " +
			"<button id=\"delete-fixing\" type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.fixing_id + "\"><span class=\"glyphicon glyphicon-trash\"></span></button>";
	    }
	}
    }).on("selected.rs.jquery.bootgrid", function (e, rows) {
	var rowIds = [];
	for (var i = 0; i < rows.length; i++) {
	    rowIds.push(rows[i].fixing_id);
	}
	alert("Select: " + rowIds.join(","));
    }).on("deselected.rs.jquery.bootgrid", function (e, rows) {
	var rowIds = [];
	for (var i = 0; i < rows.length; i++) {
	    rowIds.push(rows[i].fixing_id);
	}
	alert("Deselect: " + rowIds.join(","));
    }).on("loaded.rs.jquery.bootgrid", function (e, rows) {
	console.log($("#delete-all-btn"));
	if($("#delete-all-btn").length === 0) {
	    console.log($(".actions.btn-group .dropdown.btn-group").last());
	    $(".actions.btn-group .dropdown.btn-group").last().after('<div id="delete-all-btn" class="dropdown btn-group"><button class="btn btn-default dropdown-toggle" type="button" style="width:51px; height:34px;"><span class="glyphicon glyphicon-trash"></span></div>');
	}
    });
}