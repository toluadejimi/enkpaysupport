(function ($) {
    "use strict";

    function changeEnvatoSettingStatus($selector, $key) {
        "use strict";
        let value = $($selector).is(':checked') ? 1 : 0;

        let data = new FormData();
        data.append('value', value);
        data.append('key', $key);
        data.append("_token", $('meta[name="csrf-token"]').attr('content'));
        commonAjax('POST', $('#statusChangeRoute').val(), envatoStatusChangeResponse, envatoStatusChangeResponse, data);
        if($key === 'enable_purchase_code'){
            if(value === 1){
                $('#licence-details').removeClass('d-none');
            }else{
                $('#licence-details').addClass('d-none');
            }
        }
    }
    window.changeEnvatoSettingStatus = changeEnvatoSettingStatus;

    function envatoStatusChangeResponse(response){
        "use strict";
        $('.error-message').remove();
        $('.is-invalid').removeClass('is-invalid');
        if (response['status'] === true) {
            toastr.success(response['message']);
        } else if(response['status'] === 401){
            toastr.error(response['responseText']);
            return 0;
        }else{
            toastr.error(response['message']);
        }
    }
    window.envatoStatusChangeResponse = envatoStatusChangeResponse;

    function configureModal(selector){
        $.ajax({
            type: 'GET',
            url: $('#configureUrl').val()+'?key='+selector,
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
    window.configureModal = configureModal;

    function helpModal(selector){
        $.ajax({
            type: 'GET',
            url: $('#helpUrl').val()+'?key='+selector,
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
    window.helpModal = helpModal;

    function licenseVerificationHandler(response) {

        if (response['status'] == true) {
            //
            var startDate = moment(response.data.supported_until).format('DD-MM-YYYY');
            var endDate = moment().format('DD-MM-YYYY');
            var supportCount = 0;
            if(endDate > startDate){
                supportCount = 1;
            }

            $('#envatoData').html(` <p class="text-success">${response['message']}</p> <br/> <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>Product Name: </td>
                                        <td>${response.data.item.name}</td>
                                    </tr>
                                    <tr>
                                        <td>License: </td>
                                        <td>${response.data.license}</td>
                                    </tr>
                                     <tr>
                                        <td>Sold At: </td>
                                        <td>${moment(response.data.sold_at).format('DD-MM-YYYY hh:mm:ss')}</td>
                                    </tr>
                                    <tr>
                                        <td>Support Until: </td>
                                        <td>${moment(response.data.supported_until).format('DD-MM-YYYY hh:mm:ss')}</td>
                                    </tr>
                                    <tr>
                                        <td>Support: </td>
                                        <td>${supportCount === 0?'Over':'Active'}</td>
                                    </tr>
                                     <tr>
                                        <td>Author Username: </td>
                                        <td>${response.data.item.author_username}</td>
                                    </tr>
                                    <tr>
                                        <td>Buyer: </td>
                                        <td>${response.data.buyer}</td>
                                    </tr>
                                    </tbody>
                                </table>`);
        } else {
            $('#envatoData').html(`<p class="text-danger">${response['message']}</p>`);
        }
    }
    window.licenseVerificationHandler = licenseVerificationHandler;
})(jQuery)
