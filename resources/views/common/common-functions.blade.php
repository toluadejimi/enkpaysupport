<script>
    function deleteItem(url, id) {
        Swal.fire({
            title: '{{ __("Sure! You want to delete?") }}',
            text: "{{ __("You wont be able to revert this!") }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '{{ __("Yes, Delete It!") }}'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: { "_token": $('meta[name="csrf-token"]').attr('content')},
                    success: function (data) {
                        toastr.success(data.message);
                        $('#' + id).DataTable().ajax.reload();
                    },
                    error: function (error) {
                        toastr.error(error.responseJSON.message)
                    }
                })
            }
        })
    }
</script>
