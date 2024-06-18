(function ($) {
    "use strict";
// Config
function themeConfig(data) {
    // Light & Dark
    if (localStorage.getItem('theme')) {
        if (localStorage.getItem('theme') === 'dark') {
            $("body").addClass("dark")
            $("body").removeClass("light")

            $('.zai-theme-customizer-container-body-item-svg[data-theme="light"]').removeClass("active")
            $('.zai-theme-customizer-container-body-item-svg[data-theme="dark"]').addClass("active")

            localStorage.setItem('theme', 'dark');
        } else if (localStorage.getItem('theme') === 'light') {
            $("body").addClass("light")
            $("body").removeClass("dark")

            $('.zai-theme-customizer-container-body-item-svg[data-theme="dark"]').removeClass("active")
            $('.zai-theme-customizer-container-body-item-svg[data-theme="light"]').addClass("active")

            localStorage.setItem('theme', 'light');
        }
    } else {
        if (!$("body").hasClass("dark")) {
            $("body").addClass("light")
            $("body").removeClass("dark")

            $('.zai-theme-customizer-container-body-item-svg[data-theme="dark"]').removeClass("active")
            $('.zai-theme-customizer-container-body-item-svg[data-theme="light"]').addClass("active")
        } else if ($("body").hasClass("dark")) {
            $("body").addClass("dark")
            $("body").removeClass("light")

            $('.zai-theme-customizer-container-body-item-svg[data-theme="light"]').removeClass("active")
            $('.zai-theme-customizer-container-body-item-svg[data-theme="dark"]').addClass("active")
        }
    }
}

themeConfig({
    contentWidth: 'full' // boxed - full
});

// Click Item
$(".page-header-mood").click(function () {
    $(this).addClass("active")
    $(this).parent().siblings().children(".page-header-mood").removeClass("active")

    // Light & Dark
    if ($(this).data("theme") === "light") {
        localStorage.setItem('theme', 'light');

        commonAjax('GET', 'set-session-data', sessionRes, sessionRes, { 'status': 0 });

        $("body").addClass("light")
        $("body").removeClass("dark")
    } else if ($(this).data("theme") === "dark") {
        localStorage.setItem('theme', 'dark');

        commonAjax('GET', 'set-session-data', sessionRes, sessionRes, { 'status': 1 });

        $("body").addClass("dark")
        $("body").removeClass("light")
    }
})

function sessionRes(response){
    return 0;
}


})(jQuery);


