jQuery(function ($) {

    OznForm.utilities.setSessionData(OznForm.page_data);

    // エンターキー押下時の送信を無効化する
    OznForm.utilities.disableEnterKeySubmit();

    // 離脱アラートを表示（送信時は解除するため関連実装あり）
    if(OznForm.unload_message) {
        $(window).on('beforeunload', showUnloadMessage);
    }

    // ページ離脱時にアラートを表示する
    function showUnloadMessage() {
        return OznForm.unload_message;
    }



    // Datepickerを適用する
    $('[data-of_datepicker]').each(function () {
       $(this).datepicker();
    });

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
    $('form').submit(validateAllForms);

    // ToDo: 未検証フォームがなかった場合どうなるかテストする
    function validateAllForms() {

        var $this = $(this);
        var ajax_validations = [];

        $.each(Object.keys(OznForm.forms), function () {
            var form_name = this;
            var $form_el  = $('[name="'+form_name+'"]');

            if((! $form_el.hasClass('ozn-form-valid')) && OznForm.forms[form_name]['validates']) {
                ajax_validations.push(validFormValue(form_name, OznForm.forms[form_name]));
            }
        });

        // 可変数のDeferredを並列実行させる
        $.when.apply($, ajax_validations)
            .done(function() {
                $this.off('submit', validateAllForms);
                $(window).off('beforeunload', showUnloadMessage);
                $this.submit();
            });

        return false;
    }

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
            });
        }
    }());


    /**
     * autoruby.js の適用
     *
     * data-autoruby="keyword" ふりがな自動入力する元の要素指定
     * data-autoruby-hiragana="keyword" ふりがな入力する要素の指定
     * data-autoruby-katakana="keyword" フリガナ入力する要素の指定
     *
     * ※ keyword を同じにすることにより各フィールドの関連付けを行う
     */

    (function () {

        // フォームキーワードを抽出して複数フォームの住所補完に対応
        var keywords = [];

        $('input[data-autoruby]').each(function () {
            keywords.push($(this).data('autoruby'));

            $.each(keywords, function () {
               var keyword = this;

                var $hiragana_ruby = $('input[data-autoruby-hiragana="'+keyword+'"]');
                var $katakana_ruby = $('input[data-autoruby-katakana="'+keyword+'"]');

                if($hiragana_ruby.length == 1) {
                    $.fn.autoKana('input[data-autoruby="'+keyword+'"]', 'input[data-autoruby-hiragana="'+keyword+'"]');
                } else if($katakana_ruby.length = 1) {
                    $.fn.autoKana('input[data-autoruby="'+keyword+'"]', 'input[data-autoruby-katakana="'+keyword+'"]', {katakana:true});
                }
            });
        });
    }());


    /**
     * domain_suggest.js の適用
     */
    (function () {

        var $target = $('[data-domein-suggest="true"]');

        // ブラウザの autocomplete 機能をOFF
        $target.attr('autocomplete', 'off');

        // サジェストリスト用の要素を用意
        $target.after('<div id="oznform-suggest" style="display:none;"></div>');

        new Suggest.Local(
            $target.get(0),
            "oznform-suggest",
            [
                'gmail.com',
                'yahoo.co.jp',
                'hotmail.com',
                'outlook.com',
                'ezweb.ne.jp',
                'docomo.ne.jp',
                'i.softbank.jp',
                'softbank.ne.jp',
                'vodafone.ne.jp',
                'disney.ne.jp',
                'emnet.ne.jp',
                'ymobile.ne.jp',
                'ymobile1.ne.jp',
                'y-mobile.ne.jp',
                'pdx.ne.jp',
                'willcom.com'
            ],
            {dispMax: 10}); // オプション
    }());




    /**
     * フォーム入力値検証
     * @param form_name
     * @param form_config
     */
    function validFormValue(form_name, form_config) {

        var dInner = new $.Deferred;

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

        $.ajax(
            {
                type: 'post',
                url: OznForm.vurl,
                data: post_data,
                timeout: 10000
            }

        ).done(function (data) {

            var response = $.parseJSON(data);

            $('.' + form_name.replace('[]', '') + '.ozn-form-errors').remove();

            if(response.valid) {

                $form_el
                    .removeClass('ozn-form-invalid')
                    .addClass('ozn-form-valid');

                dInner.resolve();

            } else {
                $form_el
                    .removeClass('ozn-form-valid')
                    .addClass('ozn-form-invalid');

                apendErrorMessages($form_el, response.errors[form_name], form_config);

                dInner.reject();
            }
        })

        .fail(function () {
            dInner.reject();
        });

        return dInner.promise();
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

        $el.after(template.addClass(form_name.replace('[]', '') + ' ozn-form-errors'));
    }

});