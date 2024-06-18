(function ($) {
    "use strict";

    $(".summernote").summernote({dialogsInBody: true,  height: 200,
        toolbar: [
            ['font', ['bold', 'italic', 'underline']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link']],
        ]});

})(jQuery)
