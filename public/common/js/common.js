(function ($) {
    "use strict";

    $(document).on('submit', "form.ajax", function (event) {
        event.preventDefault();
        var enctype = $(this).prop("enctype");
        if (!enctype) {
            enctype = "application/x-www-form-urlencoded";
        }
        commonAjax($(this).prop('method'), $(this).prop('action'), window[$(this).data("handler")], window[$(this).data("handler")], new FormData($(this)[0]));
    });

    function commonAjax(type, url, successHandler, errorHandler, data, selector) {
        if (typeof url == 'undefined') {
            return false;
        }
        if (typeof selector == 'undefined') {
            var ajaxData = {
                type: type,
                url: url,
                dataType: 'json',
                success: successHandler,
                error: errorHandler
            }
        } else {
            var ajaxData = {
                type: type,
                url: url,
            }
        }
        if (typeof (data) != 'undefined') {
            ajaxData.data = data;
        }
        if (type == 'POST' || type == 'post') {
            ajaxData.encType = 'enctype';
            ajaxData.contentType = false;
            ajaxData.processData = false;
            ajaxData.data.append("ulc", localStorage.getItem("ulc"));
        }
        if (typeof selector == 'undefined') {
            $.ajax(ajaxData);
        } else {
            $.ajax(ajaxData).done(function (response) {
                successHandler(selector, response);
            })
                .fail(function (response) {
                    successHandler(selector, response);
                })
        }
    }

    window.commonAjax = commonAjax;

    function commonHandler(data) {
        var output = '';
        var type = 'error';
        $('.error-message').remove();
        $('.is-invalid').removeClass('is-invalid');
        if (data['status'] == false) {
            output = output + data['message'];
        } else if (data['status'] === 422) {
            var errors = data['responseJSON']['errors'];
            output = getValidationError(errors);
        } else if (data['status'] === 401) {
            output = data['responseText'];
        } else if (typeof data['responseJSON']['error'] !== 'undefined') {
            output = data['responseJSON']['error'];
        } else {
            output = data['responseJSON']['message'];
        }
        alertAjaxMessage(type, output);
    }

    window.commonHandler = commonHandler;

    function alertAjaxMessage(type, message) {
        if (type === 'success') {
            toastr.success(message);
        } else if (type === 'error') {
            toastr.error(message);
        } else if (type === 'warning') {
            toastr.error(message);
        } else {
            return false;
        }
    }

    window.alertAjaxMessage = alertAjaxMessage;

    function getValidationError(errors) {
        var output = 'Validation Errors';
        $.each(errors, function (index, items) {
            if (index.indexOf('.') != -1) {
                var name = index.split('.');
                var getName = name.slice(0, -1).join('-');
                var i = name.slice(-1);
                var message = items[0];
                var itemSelect = $(document).find('.' + getName + ':eq(' + i + ')')
                itemSelect.addClass('is-invalid');
                itemSelect.closest('div').append('<span class="text-danger p-2 position-relative error-message">' + message + '</span>')
            } else {
                var itemSelect = $(document).find("[name^='" + index + "']");
                itemSelect.addClass('is-invalid');
                itemSelect.closest('div').append('<span class="text-danger p-2 position-relative error-message">' + items[0] + '</span>')
            }
        });
        return output;
    }

    window.getValidationError = getValidationError;

    function settingCommonHandler(data) {
        var output = '';
        var type = 'error';
        $('.error-message').remove();
        $('.is-invalid').removeClass('is-invalid');

        if (data['status'] == true) {
            output = output + data['message'];
            type = 'success';
            if ($('.modal.show').length) {
                $('.modal.show').modal('toggle')
            }
            if ($('.dataTable ').length) {
                $('.dataTable').DataTable().ajax.reload();
            }
            alertAjaxMessage(type, output);
            if ($(document).find('form.reset').length) {
                $(document).find('form.reset').trigger('reset');
            }
        } else {
            commonHandler(data)
        }
    }

    window.settingCommonHandler = settingCommonHandler;

    function getEditModal(url, modalId) {
        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {
                $(document).find(modalId).find('.modal-content').html(data);
                $(modalId).modal('toggle');
                $(document).ready(function () {
                    $('.js-example-basic-multiple').select2();
                });
            },
            error: function (error) {
                if (error['status'] == 401) {
                    toastr.error(error.responseText)
                } else {
                    toastr.error(error.responseJSON.message)
                }
            }
        })
    }

    window.getEditModal = getEditModal;

    function commonResponseForModal(response) {
        $('.error-message').remove();
        $('.is-invalid').removeClass('is-invalid');
        if (response['status'] === true) {
            toastr.success(response['message'])

            if ($('.modal.show').length) {
                $('.modal.show').modal('toggle');
            }

            if ($('.dataTable').length) {
                $('.dataTable').DataTable().ajax.reload();
            } else {
                setTimeout(() => {
                    location.reload()
                }, 1000);
            }

            if ($(document).find('form.reset').length) {
                $(document).find('form.reset').trigger('reset');
            }

        } else {
            commonHandler(response)
        }
    }

    window.commonResponseForModal = commonResponseForModal;

    function commonResponseWithPageLoad(response) {
        $('.error-message').remove();
        $('.is-invalid').removeClass('is-invalid');
        if (response['status'] === true) {
            toastr.success(response['message'])

            setTimeout(() => {
                location.reload()
            }, 1000);


        } else {
            commonHandler(response)
        }
    }

    window.commonResponseWithPageLoad = commonResponseWithPageLoad;

    function commonResponse(response) {
        $('.error-message').remove();
        $('.is-invalid').removeClass('is-invalid');
        if (response['status'] === true) {
            toastr.success(response['message']);
            if ($('.dataTable ').length) {
                $('.dataTable').DataTable().ajax.reload();
            }
        } else {
            commonHandler(response)
        }
    }

    window.commonResponse = commonResponse;

    function dateFormat(date, format = 'MM-DD-YYYY') {
        return moment(date).format(format);
    }

    window.dateFormat = dateFormat;

    function deleteItem(url, id, reload = false) {
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
                        if (reload){
                            location.reload();
                        }
                        $('#' + id).DataTable().ajax.reload();

                    },
                    error: function (error) {
                        if (error['status'] == 401) {
                            toastr.error(error.responseText)
                        } else {
                            toastr.error(error.responseJSON.message)
                        }
                    }
                })
            }
        })
    }

    window.deleteItem = deleteItem;


    function currencyPrice($price) {
        if (currencyPlacement == 'after')
            return $price + ' ' + currencySymbol;
        else {
            return currencySymbol + $price;
        }
    }

    window.currencyPrice = currencyPrice;

    function gatewayCurrencyPrice($price, $currency = '$') {

        if (currencyPlacement == 'after')
            return $price + ' ' + $currency;
        else {
            return $currency + ' ' + $price;
        }
    }

    window.gatewayCurrencyPrice = gatewayCurrencyPrice;

    function copyToClipboard(txt) {
        navigator.clipboard.writeText(txt)
            .then(() => {
                toastr.success('Copy to clipboard');
            })
            .catch((err) => {
                toastr.error('Error copying text');
            });

    }

    window.copyToClipboard = copyToClipboard;

    function downloadImage(url) {
        fetch(url, {
            mode: 'no-cors',
        })
            .then(response => response.blob())
            .then(blob => {
                let blobUrl = window.URL.createObjectURL(blob);
                let a = document.createElement('a');
                a.download = url.replace(/^.*[\\\/]/, '');
                a.href = blobUrl;
                document.body.appendChild(a);
                a.click();
                a.remove();
            })
    }

    window.downloadImage = downloadImage;

    function downloadResponse(response) {
        var output = '';
        var type = 'error';
        $('.error-message').remove();
        $('.is-invalid').removeClass('is-invalid');
        if (response['status'] == true) {

        } else {
            commonHandler(response)
        }
    }

    window.downloadResponse = downloadResponse;

    $(document).on('keyup change paste', 'input, select, textarea', function () {
        var form = $(this).closest('form')
        form.find('button[type=submit]').attr('disabled', false);
    });

})(jQuery)
