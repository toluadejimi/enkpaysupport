(function ($) {
    "use strict";

    $('#ticketRatingDataTable').DataTable({
        pageLength: 25,
        ordering: false,
        serverSide: true,
        processing: true,
        searing: false,
        ajax: $('#ticket-list-route').val(),
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
            {"data": 'ticket_id', "name": 'tracking_no'},
            {"data": "ticket_id", "name": "ticket_id"},
            {"data": "customer_id", "name": "customer_id"},
            {"data": "status", "name": "status"},
            {"data": "rating", "name": "rating"},
            {"data": "comment", "name": "comment"},
            {"data": "action", searchable: false, responsivePriority:2},
        ]
    });


    $(document).on('change', '#assign_to', function(){

        let val = $(this).val();
        var ticketId = $(this).attr("data-id");
        var targetUrl = $('#ticketAssignToUrl').val()+'?ticketId='+ticketId;
        var modalId = '#ticketAssignModal';
        var modalUrl = $(this).attr("modal-url");
        if(val=='others')
        {
            $.ajax({
                type: 'GET',
                url: modalUrl,
                success: function (data) {
                   $(document).find(modalId).find('.modal-content').html(data);
                   $(modalId).modal('toggle');
                   $(document).ready(function() {
                    $('.js-example-basic-multiple').select2();
                });
                },
                error: function (error) {
                    toastr.error(error.responseJSON.message)
                }
            })
        }
        else if(val=='self')
        {
            $.ajax({
                type: 'GET',
                url: targetUrl,
                dataType: 'JSON',
                success: function (data) {
                    if (data.status === true) {
                        toastr.success(data.message);
                    }
                    else{
                        toastr.error("Something Went Wrong!");
                    }
                },
                error: function (error) {
                    toastr.error(error.responseJSON.message)
                }
            });
        }
    });
})(jQuery)

