jQuery(function ($) {

    var $send_button = $('.ozn-form-send');

    // 送信リンクの連続クリック防止
    OznForm.utilities.setSendmailButtonEvent($send_button);

    // ページ離脱時にアラートを表示する
    function showUnloadMessage() {
        return OznForm.unload_message;
    }

    // 離脱アラートを表示（送信時は解除するため関連実装あり）
    if(OznForm.unload_message) {
        $(window).on('beforeunload', showUnloadMessage);
    }

    $(".ozn-form-send, .ozn-form-nav").on('click', function () {
        $(window).off('beforeunload', showUnloadMessage);
    });


    // IFタグの処理
    $.each($('[data-if]'), function () {
        var target = this.getAttribute('data-if');

        if(!OznForm.page_data[target]) {
            this.parentNode.removeChild(this);
        }
    });

    // Insert タグの処理
    $.each($('[data-insert]'), function () {

        var replace_column = this.getAttribute('data-insert');
        var string = OznForm.page_data[replace_column];

        this.innerHTML = string;
    })

});