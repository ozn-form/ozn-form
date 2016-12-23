jQuery(function ($) {

    $.each(Object.keys(OznForm.forms), function () {

        var form_name = this;

        $('[name="'+form_name+'"]').on('blur', function () {

            var form = OznForm.forms[form_name];
            var $this = $(this);

            if(form.validates)

            var post_data = {
                name: form_name,
                value: $this.val(),
                label: form.label,
                error_messages: form.error_messages,
                validate: form.validates
            };

            $.post(OznForm.vurl, post_data, function (data) {

                var response = $.parseJSON(data);

                $('.' + form_name + '.ozn-form-errors').remove();

                if(response.valid) {
                    $this
                        .removeClass('ozn-form-invalid')
                        .addClass('ozn-form-valid');

                } else {
                    $this
                        .removeClass('ozn-form-valid')
                        .addClass('ozn-form-invalid');
                    apendErrorMessages($this, response.errors[form_name]);
                }
            });
        })
    });

    function apendErrorMessages($el, msg) {

        if(OznForm.error_fields) {

        } else {
            $el.before('<div class="' + $el.attr('name') + ' ozn-form-errors">' + msg.join('<br />') + '</div>');
        }
    }

});