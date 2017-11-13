jQuery(document).ready(function($) {
    $('#riparazioneModal').modal({ show: false});
    
    $(".logout").click(function(e) {
        e.preventDefault();
        logout();
    });
    
    $('#modify-riparazione').click(function() {
	
	$('#riparazioneModal').modal('show');
    });
});

function initialize_grid(grid_id, url) {
    var grid = $("#" + grid_id).bootgrid({
        ajax: true,
        url: url,
        selection: true,
        multiSelect: true,
        rowSelect: true,
        keepSelection: true,
        formatters: {
            "comandi": function (column, row) {
                return "<button id=\"modify-riparazione\" type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-pencil\"></span></button> " +
                        "<button id=\"delete-riparazione\" type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-trash\"></span></button>";
            }
        }
    }).on("selected.rs.jquery.bootgrid", function (e, rows) {
        var rowIds = [];
        for (var i = 0; i < rows.length; i++) {
            rowIds.push(rows[i].id);
        }
        alert("Select: " + rowIds.join(","));
    }).on("deselected.rs.jquery.bootgrid", function (e, rows) {
        var rowIds = [];
        for (var i = 0; i < rows.length; i++) {
            rowIds.push(rows[i].id);
        }
        alert("Deselect: " + rowIds.join(","));
    });
}