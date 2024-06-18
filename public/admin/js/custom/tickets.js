(function ($) {
    "use strict";

    $('#ticketManagementDataTable').DataTable({
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
            {"data": "ticket_title", "name": "ticket_title",className: "min-w-300"},
            {"data": "created_by", "name": "users.name"},
            {"data": "created_by", "name": "users.email"},
            {"data": "category_id", "name": "category.name"},
            {"data": "updated", "name": "updated", className: "min-w-95",searchable: false, orderable: false},
            {"data": "assigned_to", "name": "assigned_to", searchable: false, orderable: false, className: "min-w-95"},
            {"data": "action", searchable: false, orderable: false, responsivePriority:2},
        ],
        columnDefs: [
            {
                targets: [3,4],
                visible: false,
            },
        ],
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
                       $(".sf-select").select2({
                           dropdownCssClass: "sf-select-dropdown",
                           selectionCssClass: "sf-select-section",
                       });
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

    // $('.editNoteBtn').on('click',function(){
    //     var dataId = $(this).attr("data-id");
    //     var note_body = $('#note_body_'+dataId).text();
    //     $('#note_details').text(note_body);
    //     $('#note_id').val(dataId);
    //     $('.submit-btu').text('Update Note');
    // })






})(jQuery)

