(function ($) {
    "use strict";
    $(document).on('click', '#service', function () {
        var isChecked = $(this).is(':checked');
        if (isChecked) {
            $('.submit-btu').attr('type', 'submit');
            $('.submit-btu').removeAttr('disabled', 'disabled');
        } else {
            $('.submit-btu').removeAttr('type', 'submit');
            $('.submit-btu').attr('disabled', 'disabled');
        }
    });
})(jQuery)
