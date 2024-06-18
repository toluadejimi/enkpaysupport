(function ($) {
    "use strict";
    $('#customDomainDataTable').DataTable({
        pageLength: 25,
        ordering: false,
        serverSide: true,
        processing: true,
        searing: false,
        ajax: $('#request-list-route').val(),
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
            {"data": "user", "name": "user"},
            {"data": "current_domain", "name": "current_domain"},
            {"data": "custom_domain", "name": "custom_domain"},
            {"data": "status", "name": "status"},
            {"data": "action", searchable: false, responsivePriority: 2},
        ]
    });


    $(document).on('click', '.customDomainStatus', function () {
        commonAjax('GET', $('#customDomainStatusChangeRoute').val(), getInfoRes, getInfoRes, { 'id': $(this).data('id') });
    });

    function getInfoRes(response) {
        const selector = $('#payStatusChangeModal');
        selector.find('input[name=id]').val(response.data.id)
        selector.find('select[name=status]').val(response.data.custom_domain_status)
        selector.modal('show')
    }

})(jQuery)
