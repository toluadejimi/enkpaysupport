(function ($) {
    "use strict"
    $(document).on('click', '.editLanguageBtn', function () {
        var url = $('#editLanguageRoute').data('route')
        $('.editLanguageForm').attr('action', url.replace("0", $(this).data('data')['id']));
        $('.editLanguageForm input[name=name]').val($(this).data('data')['name']);
        $('.editLanguageForm select[name=code]').val($(this).data('data')['code']);
        $('.editLanguageForm select[name=rtl]').val($(this).data('data')['rtl']);
        $('.editLanguageForm select[name=default]').val($(this).data('data')['default']);
        $('.editLanguageForm select[name=status]').val($(this).data('data')['status']);
        document.getElementById("editImageShow").src = $(this).data('data')['icon'];
    });
})(jQuery)

