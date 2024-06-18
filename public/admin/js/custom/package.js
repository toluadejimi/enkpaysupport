var thisStateSelector;

$('#add').on('click', function () {
    var selector = $('#add-modal');
    selector.find('.is-invalid').removeClass('is-invalid');
    selector.find('.error-message').remove();
    selector.find('form').trigger('reset');
    selector.modal('show')
})

$(document).on('click', '.edit', function () {
    commonAjax('GET', $('#packageInfoRoute').val(), getDataEditRes, getDataEditRes, { 'id': $(this).data('id') });
});

function getDataEditRes(response) {
    console.log(response)
    var selector = $('#edit-modal');
    selector.find('.is-invalid').removeClass('is-invalid');
    selector.find('.error-message').remove();
    selector.find('input[name=id]').val(response.data.id)
    selector.find('input[name=name]').val(response.data.name)
    selector.find('input[name=number_of_agent]').val(response.data.number_of_agent)
    selector.find('select[name=custom_domain_setup]').val(response.data.custom_domain_setup)
    selector.find('input[name=access_community]').val(response.data.access_community)
    selector.find('input[name=support]').val(response.data.support)
    selector.find('input[name=device_limit]').val(response.data.device_limit)
    selector.find('select[name=status]').val(response.data.status)
    selector.find('select[name=is_trail]').val(response.data.is_trail)
    selector.find('input[name=monthly_price]').val(response.data.monthly_price)
    selector.find('input[name=yearly_price]').val(response.data.yearly_price)
    if(response.data.is_popular == 1){
        selector.find('input[name=is_popular]').attr('checked', true);
    }else{
        selector.find('input[name=is_popular]').attr('checked', false);
    }
    selector.modal('show')
}

    $('#packageDataTable').DataTable({
        pageLength: 25,
        ordering: false,
        serverSide: true,
        processing: true,
        searing: false,
        ajax: $('#packageIndexRoute').val(),
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
            {"data": "name", "name": "name"},
            {"data": "monthly_price", "name": "monthly_price"},
            {"data": "yearly_price", "name": "yearly_price"},
            {"data": "number_of_agent", "name": "number_of_agent"},
            {"data": "action", searchable: false, responsivePriority:2},
        ]
    });

$('#allPackagesUserTable').DataTable({
    processing: true,
    serverSide: true,
    pageLength: 25,
    responsive: true,
    ajax: $('#packagesUserRoute').val(),
    order: [1, 'desc'],
    ordering: false,
    autoWidth: false,
    drawCallback: function () {
        $(".dataTables_length select").addClass("form-select form-select-sm");
    },
    language: {
        'paginate': {
            'previous': '<span class="iconify" data-icon="icons8:angle-left"></span>',
            'next': '<span class="iconify" data-icon="icons8:angle-right"></span>'
        }
    },
    columns: [{
        "data": "user_name",
        "title": 'User Name',
        "name": "users.first_name"
    },
        {
            "data": "package_name",
            "title": "Package Name",
            "name": "packages.package_name"
        },
        {
            "data": "start_date",
            "title": "Start Date",
            "name": "user_packages.start_date"
        },
        {
            "data": "end_date",
            "title": "End Date",
            "name": "user_packages.end_date"
        },
        {
            "data": "payment_status",
            "title": "Payment Status",
            "name": "orders.payment_status"
        },
        {
            "data": "status",
            "title": "Status",
            "name": "user_packages.status"
        },

    ]
});
