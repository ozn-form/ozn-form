jQuery(function ($) {


    // -- 設定に応じてオプション機能を追加

    /**
     * 郵便番号で住所補完機能（ajaxzip3）
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
     * ふりがな自動入力機能（autoruby.js）
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
     * メールドメイン補完機能（domain_suggest.js）
     */
    (function () {

        var $target = $('[data-domain-suggest="true"]');

        // suggest.js とのイベント競合を避けるため、リアルタイム検証処理を解除
        $target.off('blur', validateForm);

        // suggest.js の blur時のイベント処理に合わせて検証を実施
        // 選択後、文字挿入処理と同時ぐらいに検証イベントが発生するためちょっと遅らせて実行するようにした
        $(window).on('SuggestJSBlurEvent', function () {
            setTimeout(function () {
                validateForm($target.attr('name'));
            }, 200);
        });

        // ブラウザの autocomplete 機能をOFF
        $target.attr('autocomplete', 'off');

        // サジェストリスト用の要素を用意
        $target.after('<div id="oznform-suggest" style="display:none;"></div>');

        new Suggest.Local(
            $target.get(0),
            "oznform-suggest",
            [
                'yahoo.co.jp',
                'gmail.com',
                'ezweb.ne.jp',
                'docomo.ne.jp',
                'softbank.ne.jp',
                'i.softbank.jp',
                'icloud.com',
                'hotmail.com',
                'hotmail.co.jp',
                'outlook.com',
                // --ここまでTOP 10---
                'outlook.jp',
                'live.jp',
                'nifty.ne.jp',
                'ybb.ne.jp',
                // --↑あってここまで--
                //--↓まあほぼ見かけない--
                'goo.jp',
                'mail.goo.ne.jp',
                'infoseek.jp',
                'excite.co.jp',
                'auone.jp',
                'livedoor.com',
                'ymobile.ne.jp',
                'ymobile1.ne.jp',
                'y-mobile.ne.jp',
                'emnet.ne.jp',
                'wcm.ne.jp',
                'd.vodafone.ne.jp',
                'h.vodafone.ne.jp',
                't.vodafone.ne.jp',
                'c.vodafone.ne.jp',
                'k.vodafone.ne.jp',
                'r.vodafone.ne.jp',
                'n.vodafone.ne.jp',
                's.vodafone.ne.jp',
                'q.vodafone.ne.jp',
                'pdx.ne.jp',
                'willcom.com',
                'disney.ne.jp'
            ],
            {dispMax: 10}); // オプション
    }());


    /**
     * 添付ファイル処理機能（jquery.fileupload.js）
     *
     *  data-oznform-fileup="keyword" アップロードフォームを挿入したい要素
     *
     *  ※ keyword はアップロードフォームのNAME値を指定
     *
     */
    (function () {

        var index = 1;

        $('[data-oznform-fileup]').each(function () {

            var $el = $(this);
            var form_name = $el.data('oznformFileup');

            var file_form_id = 'oznform-upform' + index;
            var uploaded_files_id = OznForm.utilities.updatedFileElementName(form_name);


            // ファイルアップロードフォームのテンプレート
            var upload_form_template = "\n" +
                    '<span class="fileinput-button">' +
                    '<button type="button">添付ファイル追加</button>' +
                    '<input id="'+file_form_id+'" class="fileupload" type="file" name="files[]" multiple>' +
                    // '<input type="hidden" name="'+form_name+'" value="">' +
                    '</span>' +
                    '<div id="'+uploaded_files_id+'" class="oznform-uploaded-files"></div>'
                ;

            $el.append(upload_form_template);

            $('#' + file_form_id).fileupload({
                dropZone: $(),
                url: OznForm.furl,
                dataType: 'json',
                done: function (e, data) {
                    $.each(data.result.files, function (index, file) {
                        console.log(file);
                        var $files_el = $('#' + uploaded_files_id);
                        OznForm.utilities.addUploadFileElement($files_el, form_name, file.thumbnailUrl, file.name, file.deleteUrl);
                    });
                }
            });

            index++;
        });
    }());




    // エンターキー押下時の送信を無効化する
    OznForm.utilities.disableEnterKeySubmit();

    // セッションに入っているデータをフォームに適用する
    OznForm.utilities.setSessionData(OznForm.page_data, OznForm.forms);

    /**
     * getで渡された値をフォームに初期値として挿入
     *
     * @note
     *  フォームルートのみの適用。
     *  すでにフォームに値がある場合は値を挿入しない。
     *
     */
    OznForm.utilities.setInitMessage(OznForm.init_msg);


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

        $('[name="' + form_name + '"]').on('blur', {form_name: form_name}, validateForm);
    });


    /**
     * フォーム検証処理
     * @param {string} form_name
     */
    function validateForm(event) {

        var form_name = event;

        if(typeof event != "string") {
            form_name = event.data.form_name;
        }

        if(OznForm.forms[form_name]['validates']) {
            validFormValue(form_name, OznForm.forms[form_name]);
        } else {
            setVaildMark($(this));
        }
    }

    // 送信時の入力値検証
    $('form').submit(validateAllForms);

    /**
     * 全てのフォームを検証処理する
     *
     * @returns {boolean}
     */
    function validateAllForms() {

        var $this = $(this);
        var ajax_validations = [];

        $.each(Object.keys(OznForm.forms), function () {
            var form_name = this;
            var $form_el  = $('[name="'+form_name+'"]');

            if($form_el.size() == 0) { return true }

            if((! $form_el.hasClass('ozn-form-valid')) && OznForm.forms[form_name]['validates']) {
                ajax_validations.push(validFormValue(form_name, OznForm.forms[form_name]));
            } else if( ! OznForm.forms[form_name]['validates']) {
                setVaildMark($form_el);
            }
        });

        // 可変数のDeferredを並列実行させる
        $.when.apply($, ajax_validations)
            .done(function() {
                $this.off('submit', validateAllForms);
                $(window).off('beforeunload', showUnloadMessage);
                $this.submit();
            }).fail(function () {

                // 検証失敗したフォームまでスクロールバック
                var top_error_position = $('.ozn-form-invalid').eq(0).offset().top;

                $("html,body").animate({
                    scrollTop : top_error_position + OznForm.vsetting.shift_scroll_position
                });

            });

        return false;
    }


    /**
     * フォーム入力値検証
     * @param form_name
     * @param form_config
     */
    function validFormValue(form_name, form_config) {

        var dInner = new $.Deferred;

        var $form_el   = $('[name="'+form_name+'"]');
        var form_value = $form_el.val();

        // ラジオボタン・チェックボックスの時は、チェックされているデータを送信する
        if($.inArray($form_el.attr('type'), ['radio', 'checkbox']) >= 0 ) {
            form_value = $form_el.filter(':checked').val();

        // その他の input 要素の時は全角を半角に変換して送信する
        } else if ($form_el.prop("nodeName") == 'INPUT') {
            form_value = OznForm.utilities.toHalfWidth(form_value);

            // フォームのユーザ入力値を半角変換済みの値に修正
            // ※ 設定で明示的に false を指定した場合はスキップ
            if(form_config.to_half !== false) {
                $form_el.val(form_value);
            }
        }

        // 既存メッセージを初期化
        $('.' + form_name.replace('[]', '') + '.ozn-form-errors').remove();
        $('.' + form_name.replace('[]', '') + '.ozn-form-warning').remove();

        var post_data = {
            name: form_name,
            value: form_value,
            label: form_config.label,
            error_messages: form_config.error_messages,
            validate: form_config.validates
        };

        if(form_config.mobile_mail_warning) {
            post_data.mobile_warning = form_config.mobile_mail_warning
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

            // 検証OKのときの処理
            if(response.valid) {

                if(response.warning) {
                    setWarningMark($form_el, response.warning, form_config);
                } else {
                    setVaildMark($form_el);
                }

                dInner.resolve();

            // 検証NGのときの処理
            } else {
                setInvalidMark($form_el, response.errors[form_name], form_config);
                dInner.reject();
            }
        })

        .fail(function () {
            dInner.reject();
        });

        return dInner.promise();
    }

    /**
     * フォームを検証OKの表示にする
     * @param $form_el
     */
    function setVaildMark($form_el) {
        addResultClass($form_el, true);
        apendResultIcon($form_el, true);
    }

    /**
     * フォームを検証OKの表示にして、注意メッセージを表示する
     * @param $form_el
     */
    function setWarningMark($form_el, warning_message, form_config) {
        addResultClass($form_el, true);
        apendErrorMessages($form_el, warning_message, form_config, true);
        apendResultIcon($form_el, true);
    }

    function setInvalidMark($form_el, error_message, form_config) {
        addResultClass($form_el, false);
        apendErrorMessages($form_el, error_message, form_config, false);
        apendResultIcon($form_el, false);
    }

    /**
     * 検証結果に応じてクラスを付与する
     *
     * @param $el
     * @param is_valid
     */
    function addResultClass($el, is_valid) {

        // 対象要素がチェックボックスやラジオボタンの時は、ozn-check要素にクラスを追加する
        if($.inArray($el.attr('type'), ['checkbox', 'radio']) >= 0) {
            var $ozn_check = $el.closest('.ozn-check');
            if($ozn_check.length > 0) {$el = $ozn_check}
        }

        if(is_valid) {
            $el.removeClass('ozn-form-invalid')
               .addClass('ozn-form-valid');
        } else {
            $el.removeClass('ozn-form-valid')
               .addClass('ozn-form-invalid');
        }
    }

    /**
     * エラーメッセージをページに挿入
     *
     * @param $el <フォーム要素>
     * @param msg <エラーメッセージ>
     * @param form_config <フォーム設定>
     * @param warning <注意メッセージとして表示フラグ>
     */
    function apendErrorMessages($el, msg, form_config, warning) {

        var form_name = $el.attr('name');
        var template  = $('<div>' + msg.join('<br />') + '</div>');

        // エラー位置の指定があれば基準要素を置換
        if(form_config.error_message_position) {
            $el = $(form_config.error_message_position);

        // 対象要素がチェックボックスやラジオボタンの時は、ozn-checkをデフォルトとする
        } else if($.inArray($el.attr('type'), ['checkbox', 'radio']) >= 0) {
            var $ozn_check = $el.closest('.ozn-check');
            if($ozn_check.length > 0) {$el = $ozn_check}
        }

        // エラーメッセージテンプレートがあればデフォルトテンプレートを置換
        if(form_config.error_message_template) {
            template = $(form_config.error_message_template.replace('<% messages %>', msg.join('<br />')));
        }

        // ドメインサジェスト表示エリアを取得
        var $suggest_area = $el.siblings('#oznform-suggest');


        // 付加するクラスを指定
        var added_class = 'ozn-form-errors';
        if(warning) { added_class = 'ozn-form-warning';}

        if($suggest_area.length > 0) {
            $suggest_area.after(template.addClass(form_name.replace('[]', '') + ' ' + added_class));
        } else {
            $el.after(template.addClass(form_name.replace('[]', '') + ' ' + added_class));
        }
    }


    /**
     * 検証結果に応じたアイコン要素を挿入する
     *
     * @param {jQuery}  $el
     * @param {boolean} is_valid
     * @returns {number}
     */
    function apendResultIcon($el, is_valid) {

        var form_name = $el.attr('name');

        // 既存アイコンを初期化
        $('.' + form_name.replace('[]', '') + '.ozn-form-icon').remove();

        if( ! OznForm.vsetting.show_icon) {return 1}

        // 対象要素がチェックボックスやラジオボタンの時は、ozn-check要素の後ろにアイコン追加する
        if($.inArray($el.attr('type'), ['checkbox', 'radio']) >= 0) {
            var $ozn_check = $el.closest('.ozn-check');
            if($ozn_check.length > 0) {$el = $ozn_check}
        }

        if(is_valid) {
            $el.after('<i class="' + form_name.replace('[]', '') + ' ozn-form-icon icon-ok"></i>');
        } else {
            $el.after('<i class="' + form_name.replace('[]', '') + ' ozn-form-icon icon-caution"></i>')
        }
    }
});