(function ($) {
    "use strict";
    $(".history-ticket").click(function () {
        commonAjax('GET', $('#historyChatDataRout').val(), getChatDataResponse2, getChatDataResponse2, { 'chat_session_id': $(this).data('id')});
    });

    window.getChatDataResponse2 = getChatDataResponse2;
    function getChatDataResponse2(response){

        $('.chat-history-details').html(response.responseText);
        $(".history-ticket-box").css("display", "inline-block");
    }

})(jQuery)
