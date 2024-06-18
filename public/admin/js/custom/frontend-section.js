(function ($) {
    "use strict";
    $('#commonDataTable').DataTable({
        lengthChange: false,
        ordering: false,
        serverSide: true,
        searching: false,
        paging: false,
        responsive:true,
        info: false,
        ajax: $('#frontend-section').val(),
        dom: '<"row"<"col-sm-6"l><"col-sm-6"f>>tr<"bottom"<"row"<"col-sm-6"i><"col-sm-6"p>>><"clear">',
        columns: [
            {"data": 'DT_RowIndex', "name": 'DT_RowIndex', orderable: false, searchable: false},
            {"data": "name", "name": "name"},
            {"data": "title", "name": "title"},
            {"data": "image", "name": "image", responsivePriority:1, "className": "text-center"},
            {"data": "status", "name": "status","className": "text-center"},
            {"data": "action", "name": "action"},
        ]
    });
})(jQuery)


