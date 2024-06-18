(function ($) {
    "use strict";
$(function () {
    $("#showPassword").click(function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var type = $(this).hasClass("fa-eye-slash") ? "text" : "password";
        $("#password").attr("type", type);
    });
    $("#showPassword2").click(function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var type = $(this).hasClass("fa-eye-slash") ? "text" : "password";
        $("#password").attr("type", type);
    });

    $(document).ready(function () {
        $('.alert-danger').fadeIn().delay(3000).fadeOut();
    });

    $('#adminCredentialShow').on('click', function () {
        $('.email').val('sadmin@gmail.com');
        $('.password').val('123456');
    });
    $('#userCredentialShow').on('click', function () {
        $('.email').val('admin@gmail.com');
        $('.password').val('123456');
    });
    $('#agentCredentialShow').on('click', function () {
        $('.email').val('agent@gmail.com');
        $('.password').val('123456');
    });
    $('#customerCredentialShow').on('click', function () {
        $('.email').val('customer@gmail.com');
        $('.password').val('123456');
    });
});
})(jQuery)
