(function ($) {
    "use strict";

$('#instantReplySearch').on('input', function () {
    commonAjax('GET', $('#instantReplaySearchRoute').val(), instantReplaySearchRes, instantReplaySearchRes, {'content': $(this).val()});
})

    function instantReplaySearchRes(response){
        $('.all-user-search').html(response.responseText);
    }

$('.generate-ai-replay').on('click', function () {
    $(".spinner-border").removeClass('d-none');
    $(".generate-done").addClass('d-none');
    commonAjax('GET', $('#generateAiReplayRoute').val(), generateAiResponse, generateAiResponse, {'id': $(this).data('id')});
})

$('.ai_reply_delete').on('click', function () {
    commonAjax('GET', $('#aiReplayDeleteRoute').val(), commonResponse, commonResponse, {'id': $(this).data('id')});
    $(this).closest(".coustomPart-new").fadeOut(300);
})

$('.reply-result').on('click', function () {
    var result = $(this).data('result');
    $('#conversation_details').summernote('reset');
    $('#conversation_details').summernote('editor.pasteHTML', result);
})

function generateAiResponse(response) {
    $('.error-message').remove();
    $('.is-invalid').removeClass('is-invalid');
    if (response['status'] === true) {
        $(".spinner-border").addClass('d-none');
        $(".generate-done").removeClass('d-none');

        $(".reply-list").prepend(` <div class="coustomPart-new">
                    <div class="show-read-more reply-result">${response.data.replayText}</div>
                    <span class="ai_reply_delete" data-id="${response.data.generate_id}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M2 4H3.33333H14" stroke="#737C90" stroke-width="1.4" stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path
                                d="M5.33203 4.00004V2.66671C5.33203 2.31309 5.47251 1.97395 5.72256 1.7239C5.9726 1.47385 6.31174 1.33337 6.66536 1.33337H9.33203C9.68565 1.33337 10.0248 1.47385 10.2748 1.7239C10.5249 1.97395 10.6654 2.31309 10.6654 2.66671V4.00004M12.6654 4.00004V13.3334C12.6654 13.687 12.5249 14.0261 12.2748 14.2762C12.0248 14.5262 11.6857 14.6667 11.332 14.6667H4.66536C4.31174 14.6667 3.9726 14.5262 3.72256 14.2762C3.47251 14.0261 3.33203 13.687 3.33203 13.3334V4.00004H12.6654Z"
                                stroke="#737C90" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M6.66797 7.33337V11.3334" stroke="#737C90" stroke-width="1.4" stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M9.33203 7.33337V11.3334" stroke="#737C90" stroke-width="1.4" stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            </svg>
                            </span>
                </div>`);
    } else {
        commonHandler(response)
    }
}
window.generateAiResponse = generateAiResponse;

function deleteAiResponse(response){
    $('.error-message').remove();
    $('.is-invalid').removeClass('is-invalid');
    if (response['status'] === true) {
        toastr.success(response['message']);

    } else {
        commonHandler(response)
    }
}
window.deleteAiResponse = deleteAiResponse;


$(document).ready(function () {
    var maxLength = 25;
    $(".show-read-more").each(function () {
        var myStr = $(this).text();
        if ($.trim(myStr).length > maxLength) {
            var newStr = myStr.substring(0, maxLength);
            var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
            $(this).empty().html(newStr);
            $(this).append(' <a href="javascript:void(0);" class="read-more">More..</a>');
            $(this).append('<span class="more-text">' + removedStr + '</span>');
        }
    });
    $(".read-more").click(function () {
        $(this).siblings(".more-text").contents().unwrap();
        $(this).remove();
    });
});



})(jQuery)

