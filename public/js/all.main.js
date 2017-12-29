var deleteRoute;

function setDeleteRoute(dr) {
    deleteRoute = dr;
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
});
