(function ($) {
    "use strict";

    function licenseVerificationHandler(response) {


        if (response.status == true) {
            //
            var startDate = moment(response.data.supported_until).format('DD-MM-YYYY');
            var endDate = moment().format('DD-MM-YYYY');
            // var startDate = response.data.supported_until;
            // var endDate = new Date();
            var supportCount = 0;
            if(endDate > startDate){
                supportCount = 1;
            }

            $('#envatoData').html(` <p class="text-success pb-3 pt-5 px-2">${response['message']}</p> <br/> <table class="table table-light">
                                    <tbody>
                                    <tr>
                                        <td class="table-data-font-weight-500 table-data-font-size-13 p-4">Product Name: </td>
                                        <td class="table-data-font-size-13 p-4">${response.data.item.name}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-data-font-weight-500 table-data-font-size-13 p-4">License: </td>
                                        <td class="table-data-font-size-13 p-4">${response.data.license}</td>
                                    </tr>
                                     <tr>
                                        <td class="table-data-font-weight-500 table-data-font-size-13 p-4">Sold At: </td>
                                        <td class="table-data-font-size-13 p-4">${moment(response.data.sold_at).format('DD-MM-YYYY hh:mm:ss')}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-data-font-weight-500 table-data-font-size-13 p-4">Support Until: </td>
                                        <td class="table-data-font-size-13 p-4">${moment(response.data.supported_until).format('DD-MM-YYYY hh:mm:ss')}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-data-font-weight-500 table-data-font-size-13 p-4">Support: </td>
                                        <td class="table-data-font-size-13 p-4">${supportCount === 0?'Over':'Active'}</td>
                                    </tr>
                                     <tr>
                                        <td class="table-data-font-weight-500 table-data-font-size-13 p-4">Author Username: </td>
                                        <td class="table-data-font-size-13 p-4">${response.data.item.author_username}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-data-font-weight-500 table-data-font-size-13 p-4">Buyer: </td>
                                        <td class="table-data-font-size-13 p-4">${response.data.buyer}</td>
                                    </tr>
                                    </tbody>
                                </table>`);
        } else {
            var obj = jQuery.parseJSON( response.responseText);
            $('#envatoData').html(`<p class="text-danger pb-3 pt-5 px-2 ">${obj.message}</p>`);
        }
    }
    window.licenseVerificationHandler = licenseVerificationHandler;
})(jQuery)
