(function ($) {
    "use strict";
    window.addTagToTicket = addTagToTicket;
    function addTagToTicket(ticketId,tagId) {
        var tagChecked = 0;
        if ($('#ticket_tag_'+tagId).is(':checked')) {
            tagChecked = 1;
        }
        var url = $('#addTagRoute').val();
        $.ajax({
            type: 'POST',
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'JSON',
            data:{'ticket_id':ticketId,'tag_id':tagId,'tagChecked':tagChecked},
            success: function (data) {
                if (data.status === true) {
                    toastr.success(data.message);
                    location.reload();
                    // var base_url = $(location).attr("origin");
                    // var imageUrl = base_url+'/agent/assets/images/radix-icons.png';
                    // console.log(base_url);
                    // if(data.data.names.length>0){
                    //     var tagList = '';
                    //     $.each(data.data.names,function(key,value){
                    //         tagList = tagList + '<span><img src="'+imageUrl+'" alt="">'+value+'</span>';
                    //     });
                    //     $("div").find('.tag-key-word').html(tagList);
                    // }
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

    window.addUserToTicket = addUserToTicket;
    function addUserToTicket(ticketId,userId) {
        var is_active = 0;
        if ($('#ticket_assignee_'+userId).is(':checked')) {
            is_active = 1;
        }
        var url = $('#ticketAssignRoute').val();
        $.ajax({
            type: 'POST',
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'JSON',
            data:{'id':ticketId,'group_user':userId,'is_active':is_active},
            success: function (data) {
                if (data.status === true) {
                    toastr.success(data.message);
                    location.reload();
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

    window.changeTicketStatus = changeTicketStatus;
    function changeTicketStatus(ticket_id,ticket_status, current_status) {
        if(current_status != ticket_status){
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
                    data.append('ticket_id', ticket_id);
                    data.append('ticket_status', ticket_status);
                    data.append("_token", $('meta[name="csrf-token"]').attr('content'));
                    commonAjax('POST', $('#ticketStatusChangeRoute').val(), statusChangeResponse, statusChangeResponse, data);
                }else{
                    $(".status"+current_status).prop("checked", true);
                }
            })
        }
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
                $('.ticket-btu-com').prop('disabled', true);
            }
            else
            {
                $('.ticket-btu-com').prop('disabled', false);
            }
            toastr.success(response['message']);
            location.reload();
        } else {
            toastr.error(response['message']);
            // location.reload();
        }
    }

    window.deleteTicket = deleteTicket;
    function deleteTicket(url, id){
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
                    url: url,
                    success: function (data) {
                        Swal.fire({
                            title: 'Deleted',
                            html: ' <span style="color:red">Item has been deleted</span> ',
                            timer: 2000,
                            icon: 'success'
                        })
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

    window.loadInstantMessage = loadInstantMessage;
    function loadInstantMessage(messageId)
    {
        var message = $('#'+messageId).val();
        $('#conversation_details').summernote('reset');
        $('#conversation_details').summernote('editor.pasteHTML', message);
    }

    window.deleteNote = deleteNote;
    function deleteNote(url, id){
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
                    url: url,
                    success: function (data) {
                        Swal.fire({
                            title: 'Deleted',
                            html: ' <span style="color:red">Note has been deleted</span> ',
                            timer: 2000,
                            icon: 'success'
                        })
                        toastr.success(data.message);
                        $('#note_'+id).remove();
                    },
                    error: function (error) {
                        toastr.error(error.responseJSON.message)
                    }
                })
            }
        })
    }

    $('#agentAssignmentSearch').on('change')
    $(document).ready(function () {
        $("#agentAssignmentSearch").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $(".view-user-list").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    $('#agentTagSearch').on('change')
    $(document).ready(function () {
        $("#agentTagSearch").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $(".view-user-list").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });


    $(document).on('click', '.edit-modal-action', function(){
        $("#conversion_id").val($(this).data('id'));
        $('#conversation_details_edit').summernote('reset');
        $('#conversation_details_edit').summernote('editor.pasteHTML', $(this).data('content'));
        $("#conversionEditmodel").modal('toggle');
    })

    $(document).on('click', '.delete-action', function(){
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
                commonAjax('GET', $('#conversation-delete-Route').val(), commonResponseWithPageLoad, commonResponseWithPageLoad, { 'id': $(this).data('id') });
            }
        })
    })

    $(document).on('click', '.ticket-details-dynamic-filed-edit-action', function(){
        var id = $(this).data('id');
        var type = $(this).data('filed_type');
        var level = $(this).data('level');
        var value = $(this).data('value');
        var required = $(this).data('required');
        var required_value = '';
        if(required == 1){
            required_value = '*'
        }

        $("#dynamic_field_data_id").val(id);
        $("#required").val(required);
        if(type == 1){
            $(".text-field").removeClass('d-none');
            $(".textarea-field").addClass('d-none');
            $(".text-field-title").text(level);
            $(".text-field-required").text(required_value);
            $("#text-field").val(value);

        }else{
            $(".text-field").addClass('d-none');
            $(".textarea-field").removeClass('d-none');
            $(".textarea-field-title").text(level);
            $(".textarea-field-required").text(required_value);
            $("#textarea-field").val(value);
        }
        $("#detailsInfoModel").modal('toggle');
    })
    $(document).on('click', '.license-edit-action', function(){
        var id = $(this).data('id');
        var value = $(this).data('value');
            $("#tickeId").val(id);
            $("#licenseField").val(value);
        $("#licenseEditModel").modal('toggle');
    })

    $(document).on('click', '.ticketNote', function(){
        var ticke_id = $(this).data('ticke_id');
        $("#noteTickeId").val(ticke_id);
        $("#note_details").text('');
        $('.submit-btu').text('Add Note');
        $('#exampleModalLabel').text('Add Ticket Note');
        $("#noteAddModal").modal('toggle');
    })

    $(document).on('click', '.editNoteBtn', function(){
        var dataId = $(this).data("id");
        var note_body = $(this).data("body");
        var ticket_id = $(this).data("ticket_id");
        $('#note_details').text(note_body);
        $('#noteId').val(dataId);
        $("#noteTickeId").val(ticket_id);
        $('.submit-btu').text('Update Note');
        $('#exampleModalLabel').text('Update Ticket Note');
        $("#noteAddModal").modal('toggle');
    })
    function editInstantMessage(messageId, messageTitle, messageDetails)
    {
        $(".ir-id").val(messageId);
        $(".ir-title").val(messageTitle);
        $(".ir-msg").text(messageDetails);
        $("#InstantModalLabel").text('Update Instant Reply');
        $("#InstantModalButton").text('Update Reply');
        $("#InstantModal").modal('show');
    }

    window.editInstantMessage = editInstantMessage;
})(jQuery)
