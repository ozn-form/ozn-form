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
                if(value) {
                    $.each(value, function () {
                        self.setUploadedFile(name, this);
                    });
                }
            } else {
                var $elem = $('[name="' + name + '"]');
                self.setValue($elem, value);
            }
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
     * 送信リンクの二重クリックの防止
     *
     * @param {JQuery} $el <送信用リンク要素>
     */
    setSendmailButtonEvent: function ($el) {
        $el.on('click', function () {

            var $this = $(this);

            if($this.hasClass('ozn-form-disabled')) {
                return false;
            }

            var send_message = '送信中です…お待ちください。';

            if($this.data('message')) {
                send_message = $this.data('message');
            }

            $this.text(send_message);
            $this.addClass('ozn-form-disabled disabled');
        })
    },

    /**
     * 要素からフォームのNAME値を取得する
     * @param $el
     * @returns {string}
     */
    getFormNameByElement: function($el) {

        var name = $el.attr('name');

        if(name === undefined) {
          name = $el.data('formname');
        }

        return name;
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
     * 半角カタカナを全角カタカナに変換
     *
     * @refer http://qiita.com/hrdaya/items/291276a5a20971592216
     *
     * @param {String} str 変換したい文字列
     */
    hankana2zenkana: function (str) {
        var kanaMap = {
            'ｶﾞ': 'ガ', 'ｷﾞ': 'ギ', 'ｸﾞ': 'グ', 'ｹﾞ': 'ゲ', 'ｺﾞ': 'ゴ',
            'ｻﾞ': 'ザ', 'ｼﾞ': 'ジ', 'ｽﾞ': 'ズ', 'ｾﾞ': 'ゼ', 'ｿﾞ': 'ゾ',
            'ﾀﾞ': 'ダ', 'ﾁﾞ': 'ヂ', 'ﾂﾞ': 'ヅ', 'ﾃﾞ': 'デ', 'ﾄﾞ': 'ド',
            'ﾊﾞ': 'バ', 'ﾋﾞ': 'ビ', 'ﾌﾞ': 'ブ', 'ﾍﾞ': 'ベ', 'ﾎﾞ': 'ボ',
            'ﾊﾟ': 'パ', 'ﾋﾟ': 'ピ', 'ﾌﾟ': 'プ', 'ﾍﾟ': 'ペ', 'ﾎﾟ': 'ポ',
            'ｳﾞ': 'ヴ', 'ﾜﾞ': 'ヷ', 'ｦﾞ': 'ヺ',
            'ｱ': 'ア', 'ｲ': 'イ', 'ｳ': 'ウ', 'ｴ': 'エ', 'ｵ': 'オ',
            'ｶ': 'カ', 'ｷ': 'キ', 'ｸ': 'ク', 'ｹ': 'ケ', 'ｺ': 'コ',
            'ｻ': 'サ', 'ｼ': 'シ', 'ｽ': 'ス', 'ｾ': 'セ', 'ｿ': 'ソ',
            'ﾀ': 'タ', 'ﾁ': 'チ', 'ﾂ': 'ツ', 'ﾃ': 'テ', 'ﾄ': 'ト',
            'ﾅ': 'ナ', 'ﾆ': 'ニ', 'ﾇ': 'ヌ', 'ﾈ': 'ネ', 'ﾉ': 'ノ',
            'ﾊ': 'ハ', 'ﾋ': 'ヒ', 'ﾌ': 'フ', 'ﾍ': 'ヘ', 'ﾎ': 'ホ',
            'ﾏ': 'マ', 'ﾐ': 'ミ', 'ﾑ': 'ム', 'ﾒ': 'メ', 'ﾓ': 'モ',
            'ﾔ': 'ヤ', 'ﾕ': 'ユ', 'ﾖ': 'ヨ',
            'ﾗ': 'ラ', 'ﾘ': 'リ', 'ﾙ': 'ル', 'ﾚ': 'レ', 'ﾛ': 'ロ',
            'ﾜ': 'ワ', 'ｦ': 'ヲ', 'ﾝ': 'ン',
            'ｧ': 'ァ', 'ｨ': 'ィ', 'ｩ': 'ゥ', 'ｪ': 'ェ', 'ｫ': 'ォ',
            'ｯ': 'ッ', 'ｬ': 'ャ', 'ｭ': 'ュ', 'ｮ': 'ョ',
            '｡': '。', '､': '、', 'ｰ': 'ー', '｢': '「', '｣': '」', '･': '・'
        };

        var reg = new RegExp('(' + Object.keys(kanaMap).join('|') + ')', 'g');
        return str
            .replace(reg, function (match) {
                return kanaMap[match];
            })
            .replace(/ﾞ/g, '゛')
            .replace(/ﾟ/g, '゜');
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

    // テンプレート生成
    var template = [];

    template.push('<div class="oznform-uploaded-file">');

    if(thumbnail_url) {
        template.push('<span class="oznform-uploaded-thumbnail"><img src="' + thumbnail_url + '"></span>');
    }

    template.push('<span class="oznform-uploaded-filename">'+file_name+'</span>');
    template.push('<button class="oznform-delete-file" type="button" data-delete-url="'+delete_url+'">削除</button>');
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

    /**
     * アップロードファイル情報を表示する要素名を生成する
     *
     * @param {string} form_name <対象フォームのNAME値>
     */
    updatedFileElementName: function (form_name) {
        form_name = form_name.replace('[]', '');
        return form_name + '_files';
    },

    uploadButtonElementName: function (form_name) {
        form_name = form_name.replace('[]', '');
        return 'upload-' + form_name + '-button';
    },


    /**
     * アップロードされたファイル情報を表示用要素へセットする
     *
     * @param {string} name  <対象フォームのNAME値>
     * @param {string} value <ファイル名>
     */
    setUploadedFile: function (name, value) {

        var self = this;
        var file_name = encodeURIComponent(value);
        var check_url = OznForm.furl + '?file=' + file_name;

        $.ajax({
            type: 'get',
            url: check_url
        }).done(function (res) {
            res = $.parseJSON(res);

            self.addUploadFileElement(
                $( '#' + self.updatedFileElementName(name)),
                name,
                res.file.thumbnailUrl,
                res.file.name,
                res.file.deleteUrl
            );
        });
    }

};