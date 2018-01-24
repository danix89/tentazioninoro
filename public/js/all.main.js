var deleteRoute;

var fileinputOptions = {
    fileActionSettings: {
        'showZoom': false,
        'indicatorNew': '&nbsp;'
    },
    'showUpload': false,
    autoOrientImage: true,
    allowedFileExtensions: ["jpeg", "jpg", "png", "gif"]
};

function setDeleteRoute(dr) {
    deleteRoute = dr;
}

function showPhotoPreview(input, uploadedPhotoCnt) {
    var len = input.files.length;
    if (input.files && input.files[0]) {
        var vocal = "";
        if (uploadedPhotoCnt === 1) {
            vocal = "a";
        } else {
            vocal = "e";
        }
        $("#photos-message").text(uploadedPhotoCnt + " foto selezionat" + vocal);
        $.each(input.files, function (index, file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('<div class="item"><img class="photo big d-block img-fluid" style="margin: 0 auto;" src="' + e.target.result + '"><div class="carousel-caption"></div></div>').appendTo('.carousel-inner');
                $('<li data-target="#myCarousel" data-slide-to="' + index + '"></li>').appendTo('.carousel-indicators');

                if (index === uploadedPhotoCnt - 1) {
                    $('.item').first().addClass('active');
                    $('.carousel-indicators > li').first().addClass('active');
                    $('#myCarousel').show();
//                    $('#myCarousel').carousel();
                }
            };

            reader.readAsDataURL(file);
        });
    } else {
        $("#photos-message").text("Nessuna foto selezionata");
    }
}

function showConfirmDialog(elem, message, action = function () {}) {
    var r = confirm(message);
    if (r == true) {
        action();
    } else {
        if (elem !== null) {
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

function appendIdToFormAction(elem, formObj) {
    var id = formObj.parents("tr").data("row-id");
    if (id <= 0) {
        elem.preventDefault();
    } else {
        var action = formObj.attr("action");
        formObj.attr("action", action + "/" + id);
    }
}

function deletePreviewsAndPhotosOnUpdate() {
    $('#myCarousel').carousel({
        interval: false,
    });
    $('#myCarousel').hide();
    $("#deletePhotos").val(true);
    $(".carousel-indicators > li").remove();
    $(".carousel-inner > div").remove();
}

function addFileInput() {
    var fileinputObj = $('<input />').attr({
        id: "input-id",
        type: "file",
        name: "path_photo[]",
        'accept': 'image/x-png,image/jpeg',
        "data-preview-file-type": "text"
    }).addClass("file").appendTo("#fileContainer");
    fileinputObj.fileinput(fileinputOptions);
}

function removeFileInput() {
    if ($(".file-input").length > 1) {
        $(".file-input").last().remove();
    }
}

function doFileInputClick(e, fileInputId) {
    if ($("#fileContainer").data("to-alert")) {
        showConfirmDialog(e, "Procedendo, verrano cancellate le foto caricate in precedenza. Procedere comunque?", function () {
            $("#" + fileInputId).click();
            $("#" + fileInputId).data("to-alert", false);
            $("#path_photo").click();
        });
    } else {
        $("#path_photo").click();
    }
}

jQuery(document).ready(function ($) {
    addFileInput();
    
    $(":required").each(function () {
	var label = $(this).parents(".form-group").find("label");
	if(label.length <= 0) {
	    label = $(this).parent("").find("label");
	}
	var text = label.text();
	var indexOfSemicolon = text.indexOf(":");
	var end = indexOfSemicolon > -1 ? indexOfSemicolon : text.length;
	text = text.substring(0, end);
	label.text(text + "*:");
    });
    
    $(".select2").select2();
    
    $('#myCarousel').carousel();
    
    if($(".carousel-inner > .item").length > 0) {
        $("#fileContainer").data("to-alert", true);
    }
//
//    $('.carousel-control.left').click(function () {
//        $('#myCarousel').carousel('prev');
//    });
//
//    $('.carousel-control.right').click(function () {
//        $('#myCarousel').carousel('next');
//    });

    $(".file, #add-photo-paths-btn").click(function (e) {
        var obj = $(this);
        if ($("#fileContainer").data("to-alert")) {
            showConfirmDialog(e, "Procedendo, verrano cancellate le foto caricate in precedenza. Procedere comunque?", function () {
                $("#fileContainer").data("to-alert", false);
                deletePreviewsAndPhotosOnUpdate();
                if (obj.attr("id") === "add-photo-paths-btn") {
                    addFileInput();
                }
            });
        } else {
            if (obj.attr("id") === "add-photo-paths-btn") {
                addFileInput();
            }
        }
    });

    $("#path_photo").change(function (e) {
//        showPhotoPreview(this, ++uploadedPhotoCnt);
//        addFileInput("path_photo");
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
