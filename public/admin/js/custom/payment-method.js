(function ($) {
    "use strict";
    $('.currency').on('change', function () {
        $(this).closest('.payment-getaway').find('.append_currency').text($(this).val())
    })
    $('.currency').trigger("change");
})(jQuery)
