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

    // 送信時の入力値検証
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
     * ajaxzip3 の適用
     *
     * data-oznform-zip="keyword" 郵便番号フィールドの指定
     * data-oznform-pref="keyword" 都道府県入力フィールドの指定
     * data-oznform-address="keyword" 住所入力フィールドの指定
     *
     * ※ keyword を同じにすることにより各フィールドの関連付けを行う
     * ※ 都道府県入力フィールドが存在しない場合には、住所入力フィールドに全ての住所を入力する
     */
    (function () {

        // フォームキーワードを抽出して複数フォームの住所補完に対応
        var keywords = [];

        $('input[data-oznform-zip]').each(function () {
           keywords.push($(this).data('oznformZip'))
        });

        if(keywords.length > 0) {

            $.each($.unique(keywords), function () {
                var keyword = this;

                var $zip_fields = $('input[data-oznform-zip="'+keyword+'"]');
                var pref_elem_name = $('input[data-oznform-pref="'+keyword+'"]').attr('name');
                var addr_elem_name = $('input[data-oznform-address="'+keyword+'"]').attr('name');

                if(!pref_elem_name) {pref_elem_name = addr_elem_name;}

                if($zip_fields.length == 1) {
                    $zip_fields.on('keyup', function () {
                        AjaxZip3.zip2addr(this, '', pref_elem_name, addr_elem_name);
                    });
                } else {
                    $($zip_fields[1]).on('keyup', function () {
                        AjaxZip3.zip2addr($($zip_fields[0]).attr('name'), $($zip_fields[1]).attr('name'), pref_elem_name, addr_elem_name);
                    });
                }



                // console.log(keyword, $zip_fields, pref_elem_name, addr_elem_name);

            });
        }
    }());


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

                apendErrorMessages($form_el, response.errors[form_name], form_config);
            }
        });

        return is_valid;

    }

    /**
     * エラーメッセージをページに挿入
     * @param $el <フォーム要素>
     * @param msg <エラーメッセージ>
     */
    function apendErrorMessages($el, msg, form_config) {

        var form_name = $el.attr('name');
        var template  = $('<div>' + msg.join('<br />') + '</div>');

        // エラー位置の指定があれば基準要素を置換
        if(form_config.error_message_position) {
            $el = $(form_config.error_message_position);
        }

        // エラーメッセージテンプレートがあればデフォルトテンプレートを置換
        if(form_config.error_message_template) {
            template = $(form_config.error_message_template.replace('<% messages %>', msg.join('<br />')));
        }

        $el.before(template.addClass(form_name.replace('[]', '') + ' ozn-form-errors'));
    }

});