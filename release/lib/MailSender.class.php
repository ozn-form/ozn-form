<?php namespace OznForm;

// メール送信クラス
class MailSender {

    private $phpmailer;

    function __construct() {
        $this->phpmailer = new \PHPMailer;
    }

}