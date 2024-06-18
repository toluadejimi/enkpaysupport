(function ($) {
    "use strict";
$(document).on("click", ".deleteItem", function () {
    let form_id = this.dataset.formid;
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
            $("#" + form_id).submit();
        } else if (result.dismiss === "cancel") {
            Swal.fire(
                "Cancelled",
                "Your imaginary file is safe :)",
                "error"
            )
        }
    })
});

$(document).on("click", "a.delete", function () {
    const selector = $(this);
    const isReload = $(this).data("reload");
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
            $.ajax({
                type: 'GET',
                url: $(this).data("url"),
                success: function (data) {
                    selector.closest('.removable-item').fadeOut('fast');
                    Swal.fire({
                        title: 'Deleted',
                        html: ' <span style="color:red">Deleted Successfully</span> ',
                        timer: 2000,
                        icon: 'success'
                    })

                    if (typeof isReload != 'undefined') {
                        location.reload();
                    }
                }
            })
        }
    })
});

$(document).on("click", ".subscriptionCancel", function (event) {
    let stateSelect = $(this);
    Swal.fire({
        title: 'Sure! You want to cancel?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Cancel It!'
    }).then((result) => {
        if (result.value) {
            $(this).closest('form').submit();
        } else if (result.dismiss === "cancel") {
            Swal.fire(
                "Cancelled",
                "Your imaginary file is safe :)",
                "error"
            )
        }
    })
});

$(document).on("click", ".statusChange", function () {
    let url = this.dataset.url;
    let id = this.dataset.id;
    let status = this.dataset.status;
    Swal.fire({
        title: 'Sure! You want to change status?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Change It!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: 'GET',
                url: url,
                data: {'id': id, 'status': status},
                success: function (data) {
                    Swal.fire({
                        title: 'Changed',
                        html: ' <span style="color:red">Status has been Changed</span> ',
                        timer: 2000,
                        icon: 'success'
                    })
                    toastr.success(data.message);
                    location.reload()
                },
                error: function (error) {
                    toastr.error(error.responseJSON.message)
                }
            })
        } else if (result.dismiss === "cancel") {
            Swal.fire(
                "Cancelled",
                "Your imaginary file is safe :)",
                "error"
            )
        }
    })
});


})(jQuery)
