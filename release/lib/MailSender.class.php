<?php namespace OznForm;

// 依存ライブラリ読み込み
require dirname(__FILE__) . '/../vendor/autoload.php';

// メール送信クラス
class MailSender {

    private $phpmailer;

    function __construct() {
        $this->phpmailer = new \PHPMailer;
    }

}