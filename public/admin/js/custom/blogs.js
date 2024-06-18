(function ($) {
    "use strict";

    $(document).ready(function() {
        $('.dropdown-toggle').dropdown();
        $('.select2').select2({
            dropdownParent: $('#add-modal')
        });
    });

    $('#blogDataTable').DataTable({
        pageLength: 25,
        ordering: false,
        serverSide: true,
        processing: true,
        searing: false,
        ajax: $('#news-list-route').val(),
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
            {"data": "thumbnail", "name": "thumbnail", searchable: false, responsivePriority:1},
            {"data": "title", "name": "title"},
            {"data": "category", "name": "categories.name"},
            {"data": "status", "name": "status"},
            {"data": "author", "name": "users.name"},
            {"data": "action", searchable: false, responsivePriority:2},
        ]
    });

})(jQuery)
