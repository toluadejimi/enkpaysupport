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
            {"data": "created_at", "name": "created_at"},
            {"data": "updated_at", "name": "updated_at"},
            {"data": "status", "name": "status"},
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

    // commonAjax('GET', $('#get-daily-chart-data').val(), getDailyChartData, getDailyChartData);
    commonAjax('GET', $('#get-category-chart-data').val(), getCategoryChartData, getCategoryChartData);

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

    function getCategoryChartData(response){
        "use strict";
        return 0;

    }
    function getDailyChartData(response){
    return 0;
    }

    window.deleteTicketItem = deleteTicketItem;
    window.getCategoryChartData = getCategoryChartData;
    window.getDailyChartData = getDailyChartData;

})(jQuery)



