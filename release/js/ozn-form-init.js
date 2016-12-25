jQuery(function ($) {

    // リアルタイム入力値検証
    $.each(Object.keys(OznForm.forms), function () {

        var form_name = this;

        $('[name="'+form_name+'"]').on('blur', function () {
            if(OznForm.forms[form_name]['validates']) {
                validFormValue(form_name, OznForm.forms[form_name]);
            }
        })
    });

    $('form').submit(function () {

        var is_valid = true;

        $.each(Object.keys(OznForm.forms), function () {
            var form_name = this;
            var $form_el  = $('[name="'+form_name+'"]');

            if(! $form_el.hasClass('ozn-form-valid') && OznForm.forms[form_name]['validates']) {
                if(!validFormValue(form_name, OznForm.forms[form_name])) {
                    is_valid = false;
                }
            }
        });

        return is_valid;
    });

    /**
     * フォーム入力値検証
     * @param form_name
     * @param form_config
     */
    function validFormValue(form_name, form_config) {

        var $form_el = $('[name="'+form_name+'"]');

        var post_data = {
            name: form_name,
            value: $form_el.val(),
            label: form_config.label,
            error_messages: form_config.error_messages,
            validate: form_config.validates
        };

        if($.inArray($form_el.attr('type'), ['radio', 'checkbox']) >= 0 ) {
            post_data.value = $form_el.filter(':checked').val();
        }

        var is_valid = false;

        $.post(OznForm.vurl, post_data, function (data) {

            var response = $.parseJSON(data);

            $('.' + form_name.replace('[]', '') + '.ozn-form-errors').remove();

            if(response.valid) {

                is_valid = true;

                $form_el
                    .removeClass('ozn-form-invalid')
                    .addClass('ozn-form-valid');

            } else {
                $form_el
                    .removeClass('ozn-form-valid')
                    .addClass('ozn-form-invalid');
                apendErrorMessages($form_el, response.errors[form_name]);
            }
        });

        return is_valid;

    }

    /**
     * エラーメッセージをページに挿入
     * @param $el <フォーム要素>
     * @param msg <エラーメッセージ>
     */
    function apendErrorMessages($el, msg) {

        // ToDo: エラーメッセージ用HTMLテンプレートがある場合の実装をする
        $el.before('<div class="' + $el.attr('name').replace('[]', '') + ' ozn-form-errors">' + msg.join('<br />') + '</div>');
    }

});