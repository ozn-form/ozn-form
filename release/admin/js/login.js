jQuery(function ($) {

    $('.button.delete').on('click', function () {

        var form_name = $('input[name="form_name"]').val();
        var message = form_name ? form_name + 'の履歴を削除します。よろしいですか？' : 'すべての履歴を削除します。よろしいですか？';

        if(window.confirm(message)){

        } else {
            return false;
        }
    });
});