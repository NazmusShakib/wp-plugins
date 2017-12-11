( function ( $ ) {
    'use strict';
    $('#customer-inquiry').on('submit', function (event) {
        event.preventDefault();
        var formData = $(this).serialize();
        handleRequest(formData);
    });

    function handleRequest(data) {
        var request = $.post({
            url: myVar.ajax_url,
            data: data
        });

        request.done(function (resp) {
            console.table(resp, 'done');
            if(resp == true) {
                jQuery('#customer-inquiry')[0].reset();
                jQuery("#feedback").html("<p class=\"alert alert-success\">Thanks for submitting your contact info.</p>");
            } else {
                jQuery("#feedback").html("<p class=\"alert alert-danger\">You need to fill out the required field!</p>");
            }
        });
        request.fail(function (resp) {
            console.log(resp, 'error');
            jQuery("#feedback").html(resp);
            jQuery("#feedback").html("<p class=\"alert alert-danger\">Opps! Something went wrong!</p>");

        });
    }

})(jQuery);