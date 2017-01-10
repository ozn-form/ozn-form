<?php namespace OznForm;

require dirname(__FILE__) . "/../release/vendor/autoload.php";
require dirname(__FILE__) . "/../release/lib/MailSender.class.php";


$sender = new MailSender();

$sender->is_debug = true;


call_user_func(function(){

    global $sender;

    $sender->sendGMailSMTP(
        'テスト送信先', 'michikawa.seisys@gmail.com',
        'OznFormテスト送信者', 'oznform@gmail.com',
        'OznFormテスト送信メール',
        'これはテスト送信です。',
        'oznform@gmail.com',
        'nNeT7FYANyWtDX'
    );
});

