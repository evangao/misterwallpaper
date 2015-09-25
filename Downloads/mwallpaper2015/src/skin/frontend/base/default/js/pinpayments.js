
Object.extend(Payment.prototype, {
    save: function() {
        that = this;
        if (checkout.loadWaiting != false)
            return;
        var validator = new Validation(this.form);
        if (this.validate() && validator.validate()) {
            checkout.setLoadWaiting('payment');
            var formData = $(that.form).serialize(true);
            if (formData['payment[method]'] == 'pinpayments') {
                // collect the payment details
                if(formData['use_saved_card'] == 1) {
                  var request = new Ajax.Request(
                        '/pinpayments/card/get/',
                        {
                            method: 'post',
                            onSuccess: this.handleGetResponse,
                            parameters: Form.serialize(this.form),
                            onFailure: checkout.setLoadWaiting(false)
                        }
                );  
                } else {
                    var card = {
                        number: $('pinpayments_cc_number').value,
                        name: $('pinpayments_cc_name').value,
                        expiry_month: $('pinpayments_expiration').value,
                        expiry_year: $('pinpayments_expiration_yr').value,
                        cvc: $('pinpayments_cc_cid').value,
                        address_line1: $('billing:street1').value,
                        address_line2: $('billing:street2').value,
                        address_city: $('billing:city').value,
                        address_state: $('billing:region_id').value,
                        address_postcode: $('billing:postcode').value,
                        address_country: $('billing:country_id').value
                    };
                    Pin.createToken(card, this.handlePinResponse);
                }
            } else {
                var request = new Ajax.Request(
                        this.saveUrl,
                        {
                            method: 'post',
                            onComplete: this.onComplete,
                            onSuccess: this.onSave,
                            onFailure: checkout.ajaxFailure.bind(checkout),
                            parameters: Form.serialize(this.form)
                        }
                );
            }
        }
    },
    handlePinResponse: function(response) {
        if (response.response) {
            //replace the form cc details with the token details
            var formData = $(that.form).serialize(true);
            formData['payment[cc_number_enc]'] = response.response.token;
            formData['payment[cc_number]'] = response.response.display_number;
            formData['payment[cc_type]'] = response.response.scheme;
            // save this card?
            if($('pinpayments_cc_save').checked){
                var request = new Ajax.Request(
                    '/pinpayments/card/save',
                    {
                        method: 'post',
                        parameters: formData,
                    }
            );
            }
            var request = new Ajax.Request(
                    that.saveUrl,
                    {
                        method: 'post',
                        onComplete: that.onComplete,
                        onSuccess: that.onSave,
                        onFailure: checkout.ajaxFailure.bind(checkout),
                        parameters: formData
                    }
            );
        } else {
            message = 'Unexpected response from gateway.'
            if (response.messages) {
                message = response.error_description + '\n\n';
                response.messages.each(function(pair) {
                    message = message + '\n' + pair.message;
                });
            }
            alert(message);
            checkout.setLoadWaiting(false);
        }
    },
    handleGetResponse:  function(response){
        that.handlePinResponse(response.responseJSON);
    },
    
    
});

function setCardImage(accountNumber) {
    type = getCreditCardType(accountNumber);
    if (type != 'unknown') {
        $('pinpayments_cc_image').src = '/skin/frontend/base/default/images/pinpayments/credit_cards_50_' + type + '.png';
    } else {
        $('pinpayments_cc_image').src = '/skin/frontend/base/default/images/pinpayments/credit_cards_50.png';
    }
}

function getCreditCardType(accountNumber) {
    var result = "unknown";
    if (/^5[1-5]/.test(accountNumber)) {
        result = "master";
    } else if (/^4/.test(accountNumber)) {
        result = "visa";
    } else if (/^3[47]/.test(accountNumber)) {
        result = "amex";
    }
    return result;
}

function togglePaymentForm(){
}



