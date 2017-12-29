var deleteRoute;

function setDeleteRoute(dr) {
    deleteRoute = dr;
}

function showPhotoPreview(input) {
    if (input.files && input.files[0]) {
	
	$.map(input.files, function(file, index) {
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

jQuery(document).ready(function ($) {
    $('#delete-all-btn').click(function () {
	$.post({
	    url: deleteRoute,
	    data: {
		_token: $('meta[name=csrf-token]').attr('content'),
		ids: mm.fetchArray("toDelete"),
	    },
	    success: function () {
		reloadPage(1000);
	    }
	}).fail(function () {
	    console.log("Ajax call failed!");
	});
    });

    $("#path_photo").change(function () {
	$(".photo").remove();
	showPhotoPreview(this);
    });

    $("#path_photo").click(function () {
	
    });
});
