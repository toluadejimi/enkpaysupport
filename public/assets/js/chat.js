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
        if (data.chat_session_id) {
            $('#receiverid').val(data.receiver_id);
            commonAjax('GET', $('#chatDataRout').val(), getCustomerChatDataResponse, getCustomerChatDataResponse, {
                'chat_session_id': data.chat_session_id
            });
        }
    });
}

//pusher end

function getCustomerChatDataResponse(response) {
    $('.chat-customer-thread-' + $('#receiverid').val()).html(response.responseText);
}


jQuery(document).ready(function () {
    ImgUpload();
});

function ImgUpload() {
    var imgWrap = "";
    var imgArray = [];

    $('.upload__inputfile').each(function () {
        $(this).on('change', function (e) {
            imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
            var maxLength = $(this).attr('data-max_length');

            var files = e.target.files;
            var filesArr = Array.prototype.slice.call(files);
            var iterator = 0;
            filesArr.forEach(function (f, index) {

                if (!f.type.match('image.*')) {
                    return;
                }

                if (imgArray.length > maxLength) {
                    return false
                } else {
                    var len = 0;
                    for (var i = 0; i < imgArray.length; i++) {
                        if (imgArray[i] !== undefined) {
                            len++;
                        }
                    }
                    if (len > maxLength) {
                        return false;
                    } else {
                        imgArray.push(f);

                        var reader = new FileReader();
                        reader.onload = function (e) {
                            var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                            imgWrap.append(html);
                            iterator++;
                        }
                        reader.readAsDataURL(f);
                    }
                }
            });
        });
    });

    $('body').on('click', ".upload__img-close", function (e) {
        var file = $(this).parent().data("file");
        for (var i = 0; i < imgArray.length; i++) {
            if (imgArray[i].name === file) {
                imgArray.splice(i, 1);
                break;
            }
        }
        $(this).parent().parent().remove();
    });
}


/*-----------
chart tab off  ticket start
---------------*/
$(".close-tab-chart").click(function () {
    $("#myForm").css("display", "none");
    console.log("hekhd");
});
/*-----------
chart tab off  ticket end
---------------*/

/*-------------------
 chart box off  ticket start
 --------------------*/

$(".back-button-chat").click(function () {
    $(".new-ticket-box").css("display", "none");

});

$(".back-button-chat-history").click(function () {
    $(".history-ticket-box").css("display", "none");
});

/*-------------------
 chart box end  ticket start
 --------------------*/


/*-------------------
 chart box show history ticket start
 --------------------*/


/*-------------------
 chart box show history ticket end
 --------------------*/

/*-------------------
 magnificPopup chart box show history ticket start
 --------------------*/
$('.test-popup-link').magnificPopup({
    type: 'image',
});
console.log("ghrtyhvcuyre");

/*-------------------
 magnificPopup chart box show history ticket end
--------------------*/

function imagePreview(img) {
    $("#zaiDeskChatPopup").css('display', 'block');
    $(".closedImg").css('display', 'block');
    $(".model-image-preview").css('display', 'block');
    $("#imagePreviewSection").attr('src', img);
}

function closeImagePreview() {
    $("#zaiDeskChatPopup").css('display', 'none');
}


$('body').on('click', "#new-ticket", function (e) {
    commonAjax('GET', $('#chatDataRout').val(), getChatDataResponse, getChatDataResponse);
    // $(".history-ticket-box").removeAttribute("style");
});

function getChatDataResponse(response) {
    $('.msg-board').html(response.responseText);
}


$('body').on('click', ".chat-history", function (e) {
    commonAjax('GET', $('#chatHistoryRout').val(), chatHistoryResponse, chatHistoryResponse);
});


function chatHistoryResponse(response) {
    $('#chatHistoryList').html(response.responseText);
}


function sessionStatusChangeRes(response) {
    console.log('Status changed');
}

function msgSentResponse(response) {
    $('.error-message').remove();
    $('.is-invalid').removeClass('is-invalid');
    if (response['status'] === true) {
        $('.input-field-reset').val('');
        $('.upload__img-wrap').html('');
        $('.upload__inputfile').val('');
    } else {
        commonHandler(response)
    }
}

/*-------------------
 chart box show new ticket start
 --------------------*/

$(".new-ticket-create").click(function () {
    $(".new-ticket-box").css("display", "inline-block");
    // commonAjax('GET', $('#chatHistoryRout').val(), chatHistoryResponse, chatHistoryResponse);
});

/*-------------------
 chart box show new ticket end
 --------------------*/
