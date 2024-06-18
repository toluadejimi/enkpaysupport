(function ($) {

//pusher start
    var pusherKey = $("#pusher_app_key").val();
    var pusherCluster = $("#pusher_cluster").val();
    var pusherChanel = $("#pusher_chanel").val();


    if (pusherKey) {
        Pusher.logToConsole = true;
        var pusher = new Pusher(pusherKey, {
            cluster: pusherCluster
        });

        var channel = pusher.subscribe(pusherChanel);
        channel.bind('chat-data', function (data) {
            if ($('.chat-thread-' + data.receiver_id).hasClass('active')) {
                $('.chat-thread-' + data.receiver_id).trigger('click');
            }
        });
    }

//pusher end

    $('.input-field-reset').val('');
    $('.upload__img-wrap').html('');

    $(document).on('click', '.inbox-item-action', function (e) {
        $("#receiverId").val($(this).data('sender_id'));
        $('.inbox-item-action').removeClass('active');
        $(this).addClass('active');
        commonAjax('GET', $('#chatDataRout').val(), getChatDataResponse, getChatDataResponse, {
            'sender_id': $(this).data('sender_id'),
        });
    });

    window.getChatDataResponse = getChatDataResponse;
    function getChatDataResponse(response) {
        $('.msg-board').html(response.responseText);
        $('.no-reply-secion').addClass('d-none');
        $('.reply-secion').removeClass('d-none');
    }

    $(document).ready(function(){
        commonAjax('GET', $('#chatUnseenMsgRout').val(), getChatUnseenMsgResponse, getChatUnseenMsgResponse);
    });

    window.getChatUnseenMsgResponse = getChatUnseenMsgResponse;
    function getChatUnseenMsgResponse(response){
        $('.unseen-count').text(response.unseen_count);
    }

})(jQuery)
