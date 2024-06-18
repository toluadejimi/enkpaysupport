/*-------------------------------------------------------
All javascript and jquery plugins activation
-------------------------------------------------------*/
(function($){
    "use strict";

    // Preloader Start
    $(window).on('load', function () {
        $('#preloader_status').fadeOut();
        $('#preloader')
            .delay(350)
            .fadeOut('slow');
        $('body')
            .delay(350);
    });

    $('.modal').on('hide.bs.modal', function (e) {
        $('.modal').find('form').trigger('reset');
        $('.modal').find('.upload-img-box img').attr('src', $('#demo-image').val());
    });
    // Preloader End

    /*---------------------------
    sidebar toggle
    ---------------------------*/
    const sidebarToggler = $('.sidebar-toggler');
    const sidebarClose = $('.sidebar__close');
    const sidebarArea = $('.sidebar__area');
    sidebarToggler.on('click', () => {
        sidebarArea.addClass('active');
    });

    sidebarClose.on('click', ()=>{
        sidebarArea.removeClass('active');
    });

    var alterClass = function() {
        var ww = document.body.clientWidth;
        if (ww > 1199) {
            sidebarArea.removeClass('active');
        }
    };

    $(window).resize(function(){
        alterClass();
    });

    /*------------------------
Notification edit box list show  off start
--------------------------- */

    $(".iconNotifi").click(function () {
        $(this).find('.editPart').addClass('showeditPart');
        $("#notfioverlay").addClass("overlayClass");
    });

    $("#notfioverlay").click(function () {
        $('.editPart').removeClass('showeditPart');
        $("#notfioverlay").removeClass("overlayClass");
    });

    /*------------------------
 Notification edit box list show  off  end
--------------------------- */

    alterClass();

    /*---------------------------
    sidebar menu
    ---------------------------*/
    $('#sidebar-menu').metisMenu();

})(jQuery);
