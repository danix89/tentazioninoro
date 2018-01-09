var deleteRoute;

function setDeleteRoute(dr) {
    deleteRoute = dr;
}

function showPhotoPreview(input) {
    if (input.files && input.files[0]) {

	$.map(input.files, function (file, index) {
	    var reader = new FileReader();
	    reader.onload = function (e) {
		var img = $("<img />").attr({
		    'id': 'photo' + index,
		    'class': 'photo',
		    'src': e.target.result,
		});

		$('#preview').append(img);
//		$('#photo' + index).attr();
//		$('#photo').show();
	    };

	    reader.readAsDataURL(file);
	});
    }
}

function showConfirmDialog(elem, message, action = function () {}) {
    var r = confirm(message);
    if (r == true) {
	action();
    } else {
	if(elem !== null) {
	    elem.preventDefault();
	}
    }
}

function deleteAll() {
    $.post({
        url: deleteRoute,
        data: {
            _token: $('meta[name=csrf-token]').attr('content'),
            ids: mm.fetchArray("toDelete"),
        },
        success: function () {
            reloadPage();
        }
    }).fail(function () {
        console.log("Ajax call failed!");
    });
}

function appendIdToFormAction(elem, formObj){
    var id = formObj.parents("tr").data("row-id");
    if (id <= 0) {
	elem.preventDefault();
    } else {
	var action = formObj.attr("action");
	formObj.attr("action", action + "/" + id);
    }
}
jQuery(document).ready(function ($) {   
    $("#path_photo").change(function () {
	$(".photo").remove();
	showPhotoPreview(this);
    });

    $("#path_photo").click(function () {

    });

    $(".btn-danger").click(function (e) {
	showConfirmDialog(e, "L'operazione e' irreversibile. Procedere comunque?");
    });

    $(".delete-all-file").click(function (e) {
	var obj = $(this);
	showConfirmDialog(e, "Procedere con l'eliminazione di tutte le foto?", function () {
	    var href = obj.data("href");
	    obj.attr("href", href);
	});
    });

});
