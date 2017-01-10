window.OznForm.utilities = {

    /**
     * PHPセッションに保存済みのデータをフォームに適用する
     *
     * @param {object} session_data <セッションに保存済みのデータ>
     */
    setSessionData: function (session_data) {

        $.each(session_data, function (name, value) {

            // if (value instanceof Array) {
            //     name = name + '[]';
            // }

            var $elem = $('[name="' + name + '"]');

            // 入力済みの値を要素に適用
            if ($elem.attr('type') && (! (value instanceof Array))) {
                $elem.val([value]);
            } else {
                $elem.val(value);
            }

        });
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
     * 指定されている項目の全角英数を半角に変換する
     * @param step
     */
    toHalf: function (step) {

        var self = this;

        $.each(mano.items[step], function (name, item) {
            if (item.hasOwnProperty('to_half') && item.to_half) {
                var $el = $('input[name="' + name + '"]');
                var half = self.toHalfWidth($el.val());

                $el.val(half);
            }
        });
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
    }
};