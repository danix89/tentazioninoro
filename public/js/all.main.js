var deleteRoute;

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

function addFileInput(fileInputId) {
    $("#" + fileInputId).clone().appendTo("#fileContainer");
}

function resetFileInputs(fileInputId) {
    showConfirmDialog(null, "Procedendo, verrano cancellate le foto appena caricate. Procedere comunque?", function () {
        var fileInput = $("#path_photo").clone();
        $("input[name='path_photo[]'").remove();
        fileInput.val();
        fileInput.appendTo("#fileContainer");
    });
}

function doFileInputClick(e, fileInputId) {
    if ($(fileInputId).data("to-alert")) {
        showConfirmDialog(e, "Procedendo, verrano cancellate le foto caricate in precedenza. Procedere comunque?", function () {
            $("#" + fileInputId).click();
            $("#" + fileInputId).data("to-alert", false);
            addFileInput(fileInputId);
            $("#path_photo").click();
        });
    } else {
        $("#" + fileInputId).click();
        addFileInput(fileInputId);
    }
}
;

jQuery(document).ready(function ($) {
    $("#deletePhotos").val(false);
    
    var uploadedPhotoCnt = 0;
    $(".path_photo").change(function (e) {
        $("#path_photo").attr("data-add-or-remove", true);
        showPhotoPreview(this, ++uploadedPhotoCnt);
    });

    $("#remove-photo-paths-btn").click(function (e) {
        uploadedPhotoCnt = 0;
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
