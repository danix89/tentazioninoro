var deleteRoute;

function setDeleteRoute(dr) {
    deleteRoute = dr;
}

function showPhotoPreview(input) {
    var len = input.files.length;
    if (input.files && input.files[0]) {
        var vocal = "";
        if(len === 1) {
            vocal = "a";
        } else {
            vocal = "e";
        }
        $("#photos-message").text(len + " foto selezionat" + vocal);
        $.each(input.files, function (index, file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('<div class="item"><img class="photo big d-block img-fluid" style="margin: 0 auto;" src="' + e.target.result + '"><div class="carousel-caption"></div></div>').appendTo('.carousel-inner');
                $('<li data-target="#myCarousel" data-slide-to="' + index + '"></li>').appendTo('.carousel-indicators');

                if(index === len - 1) {
                    $('.item').first().addClass('active');
                    $('.carousel-indicators > li').first().addClass('active');
                    $('#myCarousel').show();
                    $('#myCarousel').carousel();
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
    $('#myCarousel').hide();
    $("#deletePhotos").val(true);
    $(".carousel-indicators > li").remove();
    $(".carousel-inner > div").remove();
}

jQuery(document).ready(function ($) {
    $("#path_photo").change(function (e) {
        deletePreviewsAndPhotosOnUpdate();
        showPhotoPreview(this);
    });
    
    $("#photo-paths-btn").click(function (e) {
        if($("#path_photo").data("to-alert")) {
            showConfirmDialog(e, "Procedendo, verrano cancellate le foto caricate in precedenza. Procedere comunque?", function () {
                $("#path_photo").click();
                $("#path_photo").data("to-alert", false)
            });
        } else {
            $("#path_photo").click();
        }
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
