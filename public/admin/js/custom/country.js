
(function ($) {
    "use strict";
    $('#commonDataTable').DataTable({
        pageLength: 25,
        ordering: false,
        serverSide: true,
        processing: true,
        searing: false,
        ajax: $('#country-route').val(),
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
            {"data": 'DT_RowIndex', "name": 'DT_RowIndex', searchable: false, responsivePriority:1},
            {"data": "country_name", "name": "country_name"},
            {"data": "action", searchable: false, responsivePriority:2},
        ]
    });
})(jQuery)



$(document).on('change', '#countryCheckbox', function (e) {
    commonAjax('GET', $('#update-country-Route').val(), commonResponse, commonResponse, { 'id': $(this).data('id') });
});

