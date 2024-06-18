(function ($) {
    "use strict";
$(document).ready(function () {
    $('.alert-danger').fadeIn().delay(3000).fadeOut();
});

$('#adminCredentialShow').on('click', function () {
    $('.email').val('admin@gmail.com');
    $('.password').val('123456');
});
$('#userCredentialShow').on('click', function () {
    $('.email').val('user@gmail.com');
    $('.password').val('123456');
});

})(jQuery)
