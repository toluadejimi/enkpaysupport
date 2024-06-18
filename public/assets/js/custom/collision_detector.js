(function ($) {
    "use strict";
    $("#conversation_details").on("summernote.change", function (e) {
        commonAjax('GET', $('#checkCollisionDetector').val(), collisionDetectorResponse, collisionDetectorResponse, {'ticket_id': $('#ticketId').val()});
    });

    function  collisionDetectorResponse(response){
        if(response.code == 444){
            $(".collision-detector-alert").removeClass('d-none');
        }else{
            $(".collision-detector-alert").addClass('d-none');
        }
    }
})(jQuery)

