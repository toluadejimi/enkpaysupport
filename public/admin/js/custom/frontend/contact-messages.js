(function ($) {
    "use strict";
    $('#commonDataTable').DataTable({
        pageLength: 25,
        ordering: false,
        serverSide: true,
        searing: false,
        ajax: $('#contact-messages').val(),
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
            {"data": "name", "name": "name"},
            {"data": "email", "name": "email"},
            {"data": "subject", "name": "subject"},
            {"data": "phone", "name": "phone"},
            {"data": "message", "name": "message", "className": "text-center"},
            {"data": "action", searchable: false, responsivePriority:2}
        ]
    });
})(jQuery)


