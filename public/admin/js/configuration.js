(function ($) {
    "use strict";

    $(document).on('click', '#sendTestMailBtn', function () {
        $('.main-modal').modal('hide');
        $(document).find('#sendTestMail').modal('show');
    });
    $(document).on('click', '#sendTestSMSBtn', function () {
        $('.main-modal').modal('hide');
        $(document).find('#sendTestSMS').modal('show');
    });

    function changeSettingStatus($selector, $key) {
        "use strict";
        let value = $($selector).is(':checked') ? 1 : 0;
        let data = new FormData();
        data.append('value', value);
        data.append('key', $key);
        data.append("_token", $('meta[name="csrf-token"]').attr('content'));

        commonAjax('POST', $('#statusChangeRoute').val(), statusChangeResponse, statusChangeResponse, data);
    }

    function statusChangeResponse(response) {
        "use strict";
        $('.error-message').remove();
        $('.is-invalid').removeClass('is-invalid');
        if (response['status'] === true) {
            toastr.success(response['message']);
        } else if(response['status'] === 401){
            toastr.error(response['responseText']);
            return 0;
        } else {
            toastr.error(response['message']);
            // location.reload();
        }
    }

    function configureModal(selector) {
        $.ajax({
            type: 'GET',
            url: $('#configureUrl').val() + '?key=' + selector,
            success: function (data) {
                $(document).find('#configureModal').find('.modal-content').html(data);
                $('#configureModal').modal('toggle');
            },
            error: function (error) {
                if(error['status'] == 401){
                    toastr.error(error.responseText)
                }else{
                    toastr.error(error.responseJSON.message)
                }
            }
        });
    }

    function helpModal(selector) {
        $.ajax({
            type: 'GET',
            url: $('#helpUrl').val() + '?key=' + selector,
            success: function (data) {
                $(document).find('#helpModal').find('.modal-content').html(data);
                $('#helpModal').modal('toggle');
            },
            error: function (error) {
                if(error['status'] == 401){
                    toastr.error(error.responseText)
                }else{
                    toastr.error(error.responseJSON.message)
                }
            }
        });
    }

    window.changeSettingStatus = changeSettingStatus;
    window.helpModal = helpModal;
    window.configureModal = configureModal;
})(jQuery)
