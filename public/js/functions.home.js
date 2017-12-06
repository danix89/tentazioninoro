var deleteRoute;

function setDeleteRoute(dr) {
    deleteRoute = dr;
}

jQuery(document).ready(function ($) {
    $('#riparazioneModal').modal({show: false});

    $(".logout").click(function (e) {
        e.preventDefault();
        logout();
    });

    $('#modify-fixing').click(function () {

    });

    $('#delete-all-btn').click(function () {
//        // CSRF protection
//        $.ajaxSetup({
//            headers: {
//                    'X-CSRF-Token': $('input[name="_token"]').val()
//                }
//        });
        
        $.post({
            url: deleteRoute,
            data: {
                _token: $('meta[name=csrf-token]').attr('content'),
                newLat: 1,
                prova: "bo",
            },
            success: function () {

            }
        }).fail(function () {
            console.log("Ajax call failed!");
        });
    });
});
