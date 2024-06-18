(function ($) {
    "use strict";
    $('#ticketsDataTable').DataTable({
        pageLength: 25,
        ordering: true,
        serverSide: true,
        processing: true,
        searing: false,
        ajax: $('#ticket-url').val(),
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
            {"data": "ticket_title", "name": "ticket_title"},
            {"data": "updated", "name": "updated",searchable: false},
            {"data": "assigned_to", "name": "assigned_to"},
            {"data": "action", searchable: false, responsivePriority: 3},
        ]
    });


$(document).on('click', '#deleteData', function () {
        var count = 0;
        $("#deleteForm").serializeArray().map(function (item) {
            if (item.name == 'multicheck_ticket_id[]') {
                count = count + 1;
            }
        });
        if (count != 0) {
            deleteTicketItem();
        }else{
            toastr.error("Select at least one row");
        }
    });

    // commonAjax('GET', $('#planHistoryRoute').val(), chartDataResponse, chartDataResponse, { 'id': $(this).data('id') });



window.deleteTicketItem = deleteTicketItem;
    function deleteTicketItem(url, id) {
    "use strict";

    Swal.fire({
        title: 'Sure! You want to delete?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Delete It!'
    }).then((result) => {
        if (result.value) {
            $("#deleteForm").submit();
        }
    })
}

window.statusChangeResponse = statusChangeResponse;
function statusChangeResponse(response){
    "use strict";
    $('.error-message').remove();
    $('.is-invalid').removeClass('is-invalid');
    if (response['status'] === true) {
       var data = response['data'];
       $('.success-btn').html(data.status_after_change);
       if(data.status_after_change=='Closed')
       {
        const selector = $('#ticketReview');
        selector.modal('show');
        $('.conversation-reply').prop('disabled', true);
       }
       else
       {
        $('.conversation-reply').prop('disabled', false);
       }
        toastr.success(response['message']);
    } else if(response['status'] === 401){
        toastr.error(response['responseText']);
        return 0;
    } else {
        toastr.error(response['message']);
        // location.reload();
    }
}

$('input[type=radio][name=ticket_status]').on('change',function(){
    "use strict";
    let ticketStatusSelected = $(this).data('status');
    let ticketData = JSON.parse($('#ticketData').val());
    let ticket_id = ticketData.id;
    let id = $('#ticketDataId').val();
    Swal.fire({
        title: 'Sure! You want to change status?',
        text: "You Are Going To Change Ticket Status!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Change It!'
    }).then((result) => {
        if (result.value) {
            let data = new FormData();
            data.append('id', id);
            data.append('ticket_id', ticket_id);
            data.append('ticket_status', ticketStatusSelected);
            data.append("_token", $('meta[name="csrf-token"]').attr('content'));
            commonAjax('POST', $('#ticketStatusChangeRoute').val(), statusChangeResponse, statusChangeResponse, data);
        }
    })
})

window.view_rating_modal = view_rating_modal;
    function view_rating_modal()
{
    const selector = $('#ticketReview');
    selector.modal('show');
}

$(document).on('click','#service',function(){
    var isChecked = $(this).is(':checked');
    if(isChecked){
        $('.submit-btu').attr('type','submit');
        $('.submit-btu').removeAttr('disabled','disabled');
    }else{
        $('.submit-btu').removeAttr('type','submit');
        $('.submit-btu').attr('disabled','disabled');
    }
});

$(document).on('click','#service',function(){
    var isChecked = $(this).is(':checked');
    if(isChecked){
        $('.submit-btu').attr('type','submit');
        $('.submit-btu').removeAttr('disabled','disabled');
    }else{
        $('.submit-btu').removeAttr('type','submit');
        $('.submit-btu').attr('disabled','disabled');
    }
});

})(jQuery)
