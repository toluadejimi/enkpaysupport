!(function (n) {
    "use strict";

    $(document).on('change', '#monthly-yearly-button', function () {
        planeTypeChange()
    });

    // Preloader Start
    $(window).on('load', function () {
        $('#preloaderInner').fadeOut();
        $('#preloader')
            .delay(350)
            .fadeOut('slow');
        $('body')
            .delay(350)


        $(document).on('click', '#chooseAPlan', function () {
            $("#monthly-yearly-button").prop("checked", false);
            commonAjax('GET', $('#chooseAPanRoute').val(), setPlanModalData, setPlanModalData);
        });


        $(document).on('click', '.select-payment-gateway', function () {
            $(document).find('.payment-gateway-active').removeClass('payment-gateway-active');
            $(document).find('.payment-gateway-border-active').removeClass('payment-gateway-border-active');
            $(this).addClass('payment-gateway-active');
            $(this).closest('.payment-method-item').addClass('payment-gateway-border-active')
        });

        $(document).on('change', '#bank_id', function () {
            $('#bankDetails').removeClass('d-none');
            $('#bankDetails p').html($(this).find(':selected').data('details'));
        });

        $(document).on('click', '.paymentGateway', function (e) {
            e.preventDefault();

            $(this).closest('#gatewaySection').find('button').removeClass('active')
            $(this).closest('#gatewaySection').find('.payment-method-item').removeClass('border border-primary')
            $(this).parent().addClass('border border-primary')
            $(this).addClass('active')
            var selectGateway = $(this).data('gateway').replace(/\s+/g, '');
            $('#selectGateway').val(selectGateway)
            $('#selectCurrency').val('');
            $('#plan_id').val($(this).data('plan_id'));
            // $('#duration_type').val($(this).data('duration_type'));
            $('#duration_type').val($("#durationType").val());
            commonAjax('GET', $('#getCurrencyByGatewayRoute').val(), getCurrencyRes, getCurrencyRes, { 'id': $(this).data('id') });
            if (selectGateway == 'bank') {
                $('#bankAppend').removeClass('d-none');
                $('#bank_slip').attr('required', true);
                $('#bank_id').attr('required', true);
            } else {
                $('#bank_slip').attr('required', false);
                $('#bank_id').attr('required', false);
                $('#bankAppend').addClass('d-none');
            }
        });

        $(document).on('click', '.gatewayCurrencyAmount', function () {
            var getCurrencyAmount = '(' + $(this).find('input').val() + ')';
            $('#gatewayCurrencyAmount').text(getCurrencyAmount)
            $('#selectCurrency').val($(this).text().replace(/\s+/g, ''));
        });

        $('#payBtn').on('click', function () {
            var gateway = $('#selectGateway').val()
            var currency = $('#selectCurrency').val();
            if (gateway == '') {
                toastr.error('Select Gateway');
                $('#payBtn').attr('type', 'button');
            } else {
                if (currency == '') {
                    toastr.error('Select Currency');
                    $('#payBtn').attr('type', 'button');
                } else {
                    $('#payBtn').attr('type', 'submit');
                }
            }
        });
        $(document).on('change', '#bank_id', function () {
            $('#bank_account_number').val($(this).find(':selected').data('account_number'));
        });

        var pk_id = $("#package_id_js").val();
        var type_id = $("#type_js").val();

        if(pk_id !=null && type_id !=null){
            if(type_id == 1){
                commonAjax('GET', $('#chooseAPanRoute').val(), setPlanModalData, setPlanModalData, {'package_id':pk_id,'type':type_id});
                $('#monthly-yearly-button').prop('checked', false);
                setTimeout(() => {
                    planeTypeChange();
                }, "1000");

            }
            if(type_id == 2){
                commonAjax('GET', $('#chooseAPanRoute').val(), setPlanModalData, setPlanModalData, {'package_id':pk_id,'type':type_id});
                $('#monthly-yearly-button').prop('checked', true);
                setTimeout(() => {
                    planeTypeChange();
                }, "1000");
            }
        }


    });
    // Preloader End

window.setPlanModalData = setPlanModalData;
function setPlanModalData(response) {
    var selector = $('#choosePlanModal')
    selector.modal('show');
    selector.find('#planListBlock').html(response.view);
}
window.setPaymentModal = setPaymentModal;
function setPaymentModal(response) {
    var selector = $('#paymentMethodModal')
    selector.modal('show');
    $('#choosePlanModal').modal('hide');
    selector.find('#gatewayListBlock').html(response.responseText);
}
window.getCurrencyRes = getCurrencyRes;
function getCurrencyRes(response) {
    var html = '';
    var planAmount = parseFloat($('#planAmount').val()).toFixed(2);
    Object.entries(response.data).forEach((currency) => {
        let currencyAmount = currency[1].conversion_rate * planAmount;
        html += `<tr>
                <td>
                    <div class="custom-radiobox gatewayCurrencyAmount">
                        <input type="radio" name="gateway_currency_amount" id="${currency[1].id}" class="" value="${gatewayCurrencyPrice(currencyAmount, currency[1].symbol)}">
                        <label for="${currency[1].id}">${currency[1].currency}</label>
                    </div>
                </td>
                <td><h6 class="tenant-invoice-tbl-right-text text-end">${gatewayCurrencyPrice(planAmount)} * ${currency[1].conversion_rate} = ${gatewayCurrencyPrice(currencyAmount, currency[1].symbol)}</h6></td>
            </tr>`;
    });
    $('#currencyAppend').html(html);
}
window.planeTypeChange = planeTypeChange;
function planeTypeChange(){
    if ($("#monthly-yearly-button").is(':checked') == true) {
        // $(document).find('.price-yearly').removeClass('d-none');
        // $(document).find('.price-monthly').addClass('d-none');
        // $(document).find('.plan_type').val(2);
        $(".yearly_short").removeClass('d-none');
        $(".monthly_short").addClass('d-none');
        // $("#durationType").val(2);
        $('.plan_type').val(2);
    }
    else {
        // $(document).find('.price-yearly').addClass('d-none');
        // $(document).find('.price-monthly').removeClass('d-none');
        // $(document).find('.plan_type').val(1);
        $(".yearly_short").addClass('d-none');
        $(".monthly_short").removeClass('d-none');
        $('.plan_type').val(1);
    }
}

})(jQuery);
