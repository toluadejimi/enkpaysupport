(function ($) {
    "use strict";
    function openForm() {

        if (pushActive == 1) {
            document.getElementById("myForm").style.display = "block";

        } else {
            toastr.error("Contact to admin for pusher configuration!");

        }
    }

    window.closeForm = closeForm;
    window.openForm = openForm;
    function closeForm() {
        document.getElementById("myForm").style.display = "none";
    }
    $("#announcement-seen-unseen").on('click',function () {
        commonAjax('GET', $('#announcementSeen').val(), announcementSeenRes, announcementSeenRes);
    });
    window.announcementSeenRes = announcementSeenRes;
    function announcementSeenRes(response){
        location.reload();
    }

})(jQuery)
