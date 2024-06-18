(function ($) {
    "use strict";
    $('#customPageDataTable').DataTable({
        pageLength: 25,
        ordering: false,
        serverSide: true,
        processing: true,
        searing: false,
        ajax: $('#pages-list-route').val(),
        language: {
            paginate: {
                previous: "<span class='iconify' data-icon='material-symbols:chevron-left-rounded'></span>",
                next: "<span class='iconify' data-icon='material-symbols:chevron-right-rounded'></span>",
            },
            searchPlaceholder: "Search",
            search: ""
        },
        dom: '<"row"<"col-sm-6"l><"col-sm-6"f>>tr<"bottom"<"row"<"col-sm-6"i><"col-sm-6"p>>><"clear">',
        columns: [
            {"data": "title", "name": "title"},
            {"data": "link", "name": "link"},
            {"data": "status", "name": "status"},
            {"data": "created_at", "name": "created_at"},
            {"data": "action", searchable: false, responsivePriority:2},
        ]
    });


    $(document).on('click', '.copy-custom-page-link', function (e) {
        var copyText = $(this).data('src');
        copyToClipboard(copyText);
    });

    window.copyToClipboard = copyToClipboard;
    function copyToClipboard(txt) {
        navigator.clipboard.writeText(txt)
            .then(() => {
                toastr.success('Copy to clipboard');
            })
            .catch((err) => {
                toastr.error('Error copying text');
            });

    }

    $('#pageDataTable').DataTable({
        pageLength: 25,
        ordering: false,
        serverSide: true,
        processing: true,
        searing: false,
        language: {
            paginate: {
                previous: "<span class='iconify' data-icon='material-symbols:chevron-left-rounded'></span>",
                next: "<span class='iconify' data-icon='material-symbols:chevron-right-rounded'></span>",
            },
            searchPlaceholder: "Search",
            search: ""
        },
        dom: '<"row"<"col-sm-6"l><"col-sm-6"f>>tr<"bottom"<"row"<"col-sm-6"i><"col-sm-6"p>>><"clear">',
        columns: [
            {"data": "type", "name": "type"},
            {"data": "title", "name": "title"},
            {"data": "action", searchable: false, responsivePriority:2},
        ]
    });

})(jQuery)
