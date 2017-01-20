window.OznForm.utilities = {

    /**
     * PHPセッションに保存済みのデータをフォームに適用する
     *
     * @param {object} session_data <セッションに保存済みのデータ>
     */
    setSessionData: function (session_data) {

        var self = this;

        $.each(session_data, function (name, value) {

            // if (value instanceof Array) {
            //     name = name + '[]';
            // }

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
    }
};