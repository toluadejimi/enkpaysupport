(function ($) {
    "use strict";
    $(".progress-bar").loading();
    $('input').on('click', function () {
        $(".progress-bar").loading();
    });
})(jQuery)
