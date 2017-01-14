<?php namespace OznForm;

// メール送信クラス
class MailSender {

    public  $is_debug;
    private $phpmailer;

    function __construct() {

        // タイムゾーン設定
        date_default_timezone_set("Asia/Tokyo");

        $this->is_debug = false;

    }

    private function init_mailer($send_method)
    {
        switch ($send_method) {

            case 'sendmail':
            case 'Gmail SMTP':
                $this->phpmailer = new \PHPMailer;
                break;
            case 'Gmail SMTP With OAuth':
                $this->phpmailer = new \PHPMailerOAuth;
                break;
            default:
                throw new FormError("送信方法の指定値[$send_method]が間違っています。");
        }

        $this->phpmailer->CharSet  = 'UTF-8';
        $this->phpmailer->Encoding = "base64";
    }


    /**
     * 送信情報をセットする
     */
    public function setEnvelope($send_method, $to_name, $to, $from_name, $from, $subject, $body)
    {

        // 送信方法によってphpmailerを初期化する
        $this->init_mailer($send_method);


        // Set who the message is to be sent to
        $this->phpmailer->addAddress($to, $to_name);

        // Set who the message is to be sent from
        $this->phpmailer->setFrom($from, $from_name);

        // Set an alternative reply-to address
        // $this->phpmailer->addReplyTo('replyto@example.com', 'OznForm テスト送信者');

        //　Set the subject line
        $this->phpmailer->Subject = $subject;

        // Set the plain text body
        $this->phpmailer->Body = $body;
    }

    private function send()
    {
        if (!$this->phpmailer->send()) {
            throw new FormError("Mailer Error: " . $this->phpmailer->ErrorInfo);
        }
    }

    /**
     * sendmail で送信する
     */
    public function sendmail()
    {
        $this->phpmailer->isSendmail();
        $this->send();
    }

    /**
     * GMail SMTP 経由でメール送信する
     *
     * @param $gmail_address
     * @param $gmail_password
     */
    public function sendGmailSMTP($gmail_address, $gmail_password)
    {

        //Tell PHPMailer to use SMTP
        $this->phpmailer->isSMTP();

        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages

        if($this->is_debug === true) {
            $this->phpmailer->SMTPDebug = 2;
        } else {
            $this->phpmailer->SMTPDebug = 0;
        }


        //Ask for HTML-friendly debug output
        $this->phpmailer->Debugoutput = 'html';

        //Set the hostname of the mail server
        $this->phpmailer->Host = 'smtp.gmail.com';
        // use
        // $this->phpmailer->Host = gethostbyname('smtp.gmail.com');
        // if your network does not support SMTP over IPv6

        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $this->phpmailer->Port = 587;

        //Set the encryption system to use - ssl (deprecated) or tls
        $this->phpmailer->SMTPSecure = 'tls';

        //Whether to use SMTP authentication
        $this->phpmailer->SMTPAuth = true;

        //Username to use for SMTP authentication - use full email address for gmail
        $this->phpmailer->Username = $gmail_address;

        //Password to use for SMTP authentication
        $this->phpmailer->Password = $gmail_password;

        $this->send();
    }

    /**
     * Google XOAUTH2 を使用して送信する
     *
     * @note 送信にはPHP 5.5 以上が必要
     *
     * @param $gmail_user
     * @param $oauth_id
     * @param $oauth_secret
     * @param $oauth_refresh_token
     */
    public function sendGmailSMTPWithOAuth($gmail_user, $oauth_id, $oauth_secret, $oauth_refresh_token)
    {

        // Tell PHPMailer to use SMTP
        $this->phpmailer->isSMTP();

        // Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $this->phpmailer->SMTPDebug = 0;

        // Ask for HTML-friendly debug output
        $this->phpmailer->Debugoutput = 'html';

        // Set the hostname of the mail server
        $this->phpmailer->Host = 'smtp.gmail.com';
        // use
        // $this->phpmailer->Host = gethostbyname('smtp.gmail.com');
        // if your network does not support SMTP over IPv6

        // Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $this->phpmailer->Port = 587;

        // Set the encryption system to use - ssl (deprecated) or tls
        $this->phpmailer->SMTPSecure = 'tls';

        // Whether to use SMTP authentication
        $this->phpmailer->SMTPAuth = true;

        // Set AuthType
        $this->phpmailer->AuthType = 'XOAUTH2';

        // User Email to use for SMTP authentication - Use the same Email used in Google Developer Console
        $this->phpmailer->oauthUserEmail = $gmail_user;

        // Obtained From Google Developer Console
        $this->phpmailer->oauthClientId = $oauth_id;

        // Obtained From Google Developer Console
        $this->phpmailer->oauthClientSecret = $oauth_secret;

        // Obtained By running get_oauth_token.php after setting up APP in Google Developer Console.
        // Set Redirect URI in Developer Console as [https/http]://<yourdomain>/<folder>/get_oauth_token.php
        //  eg: http://localhost/phpmail/get_oauth_token.php
        $this->phpmailer->oauthRefreshToken = $oauth_refresh_token;

        $this->send();
    }


    /**
     * メールテンプレート中のタグを入力値で置換
     */
    public function replaceMailTemplateTags($page_data, $template)
    {

        // テンプレートタグ置換
        foreach ($page_data as $key => $v) {
            if(is_array($v)) {$v = join('、', $v);}
            $key = preg_quote($key);
            $template = preg_replace("/<%\s*$key\s*%>/", $v, $template);
        }

        // if文処理
        $template = preg_replace_callback(
            "/<%%\s*if\.(.+?)\s*%%>(.+)<%%\s*endif\s*%%>(\n{0,1})/",
            function($matches) {

                global $page_data;

                if($page_data[$matches[1]]) {
                    return $matches[2].$matches[3];
                }
            },
            $template);



        return $template;
    }

}