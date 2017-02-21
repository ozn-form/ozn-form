window.OznForm.utilities = {

    /**
     * PHPセッションに保存済みのデータをフォームに適用する
     *
     * @param {object} session_data <セッションに保存済みのデータ>
     * @param {object} forms        <フォーム設定>
     */
    setSessionData: function (session_data, forms) {

        var self = this;

        $.each(session_data, function (name, value) {

            // アップロードフォームの場合はファイルの情報を取得する
            if(forms[name]['type'] === 'upload_files' ) {

                var file_name = encodeURIComponent(value);

                $.ajax({
                    type: 'get',
                    url: 'http://localhost:8080/release/upload/index.php?file=' + file_name
                }).done(function (res) {
                    res = $.parseJSON(res);
                    console.log(res);
                    self.addUploadFileElement(
                        $( '#' + self.updatedFileElementName(name)),
                        name,
                        res.file.thumbnailUrl,
                        res.file.name,
                        res.file.deleteUrl
                    );
                });
            }

            var $elem = $('[name="' + name + '"]');

            self.setValue($elem, value);

        });
    },

    setInitMessage: function (messages) {

        var self = this;

        $.each(messages, function (name, value) {

            var $elem = $('[name="' + name + '"]');

            if($elem.size !== 0 && $elem.val() == '') {
                self.setValue($elem, value);
            }
        })

    },

    setValue: function ($elem, value) {
        // 入力済みの値を要素に適用
        if ($elem.attr('type') && (! (value instanceof Array))) {
            $elem.val([value]);
        } else {
            $elem.val(value);
        }
    },

    /**
     * NAME値からフォーム要素を取得する
     *
     * @param {String} name <NAME値>
     * @returns {*|jQuery|HTMLElement} <取得したフォーム要素の jQuery Object>
     */
    getFormElementByName: function (name) {
        return $('[name="' + name + '"]');
    },

    /**
     * 入力されたフォーム要素の値を返す
     *
     * @param {String|jQuery} $elem
     * @returns {String|null} <選択/入力されたフォームのVALUE値>
     */
    getEnteredValue: function ($elem) {

        if (typeof $elem == 'string') {
            $elem = this.getFormElementByName($elem);
        }

        switch ($elem.attr('type')) {
            case 'radio':
            case 'checkbox':
                return $elem.filter(':visible:checked').val();
                break;
            default:
                return $elem.val();
        }
    },




    /**
     * 全角から半角への変換
     * 入力値の英数記号を半角変換して返却
     * [引数]   strVal: 入力値
     * [返却値] String(): 半角変換された文字列
     */
    toHalfWidth: function (strVal) {

        // 半角変換
        var halfVal = strVal.replace(/[！-～]/g,
            function (tmpStr) {
                // 文字コードをシフト
                return String.fromCharCode(tmpStr.charCodeAt(0) - 0xFEE0);
            }
        );

        return halfVal;
    },

    /**
     * input 要素でエンター押下時に送信を無効にする
     */

    disableEnterKeySubmit: function () {
        $("input").on("keydown", function(e) {
            if ((e.which && e.which === 13) || (e.keyCode && e.keyCode === 13)) {
                return false;
            } else {
                return true;
            }
        });
    },

    /**
     * ファイルアップロード後の表示エレメントを追加する
     *
     * @param {jQuery} $target <挿入する要素>
     * @param {string} form_name <フォームの名前>
     * @param {string} thumbnail_url <ThumbnailのURL>
     * @param {string} file_name <アップロードファイル名>
     * @param {string} delete_url <削除用URL>
     */
    addUploadFileElement: function ($target, form_name, thumbnail_url, file_name, delete_url) {
console.log($target);
    // テンプレート生成
    var template = [];

    template.push('<div class="oznform-uploaded-file">');

    if(thumbnail_url) {
        template.push('<span class="oznform-uploaded-thumbnail"><img src="' + thumbnail_url + '"></span>');
    }

    template.push('<span class="oznform-uploaded-filename">'+file_name+'</span>');
    template.push('<button type="button" data-delete-url="'+delete_url+'">削除</button>');
    template.push('<input type="hidden" name="'+form_name+'" value="'+file_name+'">');
    template.push('</div>');

    var $file_el = $(template.join('\n'));

    // 削除処理をバインド
    $file_el.find('[data-delete-url]').on('click', function () {

        var $el = $(this);

        $.ajax({
            type: 'post',
            url: delete_url
        }).always(function () { $el.parent().remove(); });
    });

    // 対象要素に追加
    $target.append($file_el);
},

    updatedFileElementName: function (form_name) {

        form_name = form_name.replace('[]', '');
        return form_name + '_files';

    }

};