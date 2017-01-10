jQuery(function ($) {

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