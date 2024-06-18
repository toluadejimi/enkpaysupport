(function ($) {
    "use strict";
    $('#commonDataTable').DataTable({
        pageLength: 25,
        ordering: false,
        serverSide: true,
        searing: false,
        ajax: $('#news-route').val(),
        language: {
            paginate: {
                previous: "<span class='iconify' data-icon='material-symbols:chevron-left-rounded'></span>",
                next: "<span class='iconify' data-icon='material-symbols:chevron-right-rounded'></span>",
            },
            searchPlaceholder: "Search",
            search: ""
        },
        dom: '<"row"<"col-sm-6"l><"col-sm-6"f>>tr<"bottom"<"row"<"col-sm-6"i><"col-sm-6"p>>><"clear">',
        "createdRow": function (row, data, dataIndex) {
            $(row).find('td:first-child').text(dataIndex + 1);
        },
        columns: [
            { "data": null, "orderable": false },
            {"data": "title", "name": "title"},
            {"data": "description", "name": "description"},
            {"data": "status", "name": "status", "className": "text-center"},
            {"data": "image", "name": "image", searchable: false, responsivePriority:1, "className": "text-center"},
            {"data": "action", searchable: false, responsivePriority:2},
        ]
    });
})(jQuery)
