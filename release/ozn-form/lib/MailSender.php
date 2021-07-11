<?php
namespace OznForm\lib;

// メール送信クラス
use League\OAuth2\Client\Provider\Google;
use OznForm\lib\exceptions\FormError;
use PHPMailer\PHPMailer\OAuth;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class MailSender {

    public  $is_debug;
    private $phpmailer;

    function __construct() {

        // タイムゾーン設定
        date_default_timezone_set("Asia/Tokyo");

        $this->is_debug = false;
    }


    /**
     * メールを送信する
     *
     * @param string $send_by   <送信方法>
     * @param array  $options   <送信時オプション>
     * @param bool   $send_flag <送信実行の可否（デバッグ用）>
     *
     * @return bool
     * @throws \Exception
     */
    public function send($send_by, $options = array(), $send_flag = true) {

        // 送信フラグがたってない時は送信なし（デバッグ用）
        if($send_flag === FALSE) { sleep(1); return true; }

        switch ($send_by) {
            case 'sendmail':
                $this->sendmail();
                break;
            case 'SMTP':
                $this->sendSMTP($options['account'], $options['password'], $options['host'], $options['smtp_options']);
                break;
            case 'Gmail SMTP':
                $this->sendSMTP($options['account'], $options['password'], 'smtp.gmail.com');
                break;
            case 'Gmail SMTP With OAuth':
                $this->sendGmailSMTPWithOAuth($options['account'], $options['oauth_id'], $options['oauth_secret'], $options['oauth_refresh_token']);
                break;
        }

        if ($this->phpmailer->send()) {
            return true;
        }

        throw new \Exception("Mailer Error: " . $this->phpmailer->ErrorInfo);
    }

    /**
     * PHPMailer 初期化
     *
     * @param $send_method
     *
     * @throws FormError
     */
    private function init_mailer($send_method)
    {
        switch ($send_method) {

            case 'sendmail':
            case 'SMTP':
            case 'Gmail SMTP':
            case 'Gmail SMTP With OAuth':
                $this->phpmailer = new PHPMailer();
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
    public function setEnvelope($send_method, $to_name, $to, $from_name, $from, $reply_to, $subject, $body)
    {

        // 送信方法によってphpmailerを初期化する
        $this->init_mailer($send_method);


        // Set who the message is to be sent to
        $this->phpmailer->addAddress($to, $to_name);

        // Set who the message is to be sent from
        $this->phpmailer->setFrom($from, $from_name);

        // Set an alternative reply-to address
        $this->phpmailer->addReplyTo($reply_to, '');

        // Set the subject line
        $this->phpmailer->Subject = $subject;

        // Set the plain text body
        $this->phpmailer->Body = $body;
    }

    /**
     * CCアドレスを設定する
     *
     * @param array $addresses <設定したいアドレス>
     */
    public function setCC($addresses)
    {
        if(is_array($addresses) && ( ! empty($addresses))) {
            foreach ($addresses as $address) {
                $this->phpmailer->addCC($address);
            }
        }
    }

    /**
     * BCCアドレスを設定する
     *
     * @param array $addresses <設定したいアドレス>
     */
    public function setBCC($addresses)
    {
        if(is_array($addresses) && ( ! empty($addresses))) {
            foreach ($addresses as $address) {
                $this->phpmailer->addBCC($address);
            }
        }
    }

    /**
     * 添付ファイルを追加する
     *
     * @param string $base_path  <ファイルのあるディレクトリ>
     * @param array  $file_names <添付するファイル名>
     */
    public function setAttachment($base_path, $file_names) {

        if( ! preg_match('/\/$/', $base_path)) $base_path = '/' . $base_path;

        foreach ($file_names as $file_name) {
            $this->phpmailer->AddAttachment($base_path . $file_name, $file_name);
        }
    }
    
    public function setDebugFlag()
    {
        if($this->is_debug === true) {
            $this->phpmailer->SMTPDebug = SMTP::DEBUG_CONNECTION;
        } else {
            $this->phpmailer->SMTPDebug = SMTP::DEBUG_OFF;
        }
    }

    /**
     * sendmail で送信する
     */
    public function sendmail()
    {
        $this->phpmailer->isSendmail();
        $this->setDebugFlag();
    }

    /**
     * SMTP 経由でメール送信する
     *
     * @param string $account
     * @param string $password
     * @param string $host
     * @param array  $options
     *
     */
    public function sendSMTP($account, $password, $host, $options = array())
    {

        $smtp_options = array(
            'SMTPAuth'   => true,
            'Port'       => 587,
            'SMTPSecure' => 'tls',
        );

        $smtp_options = array_merge($smtp_options, $options);


        // -- デバッグ設定
        $this->setDebugFlag();

        //Tell PHPMailer to use SMTP
        $this->phpmailer->isSMTP();
        

        //Ask for HTML-friendly debug output
        $this->phpmailer->Debugoutput = 'html';


        // -- 送信設定

        //Username to use for SMTP authentication - use full email address for gmail
        $this->phpmailer->Username = $account;

        //Password to use for SMTP authentication
        $this->phpmailer->Password = $password;

        //Set the hostname of the mail server
        $this->phpmailer->Host = $host;

//        $this->phpmailer->SMTPOptions = array(
//            'ssl' => array(
//                'verify_peer' => false,
//                'verify_peer_name' => false,
//                'allow_self_signed' => true
//            )
//        );

        //Whether to use SMTP authentication
        $this->phpmailer->SMTPAuth = $smtp_options['SMTPAuth'];

        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $this->phpmailer->Port = $smtp_options['Port'];

        //Set the encryption system to use - ssl (deprecated) or tls
        $this->phpmailer->SMTPSecure = $smtp_options['SMTPSecure'];

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

        // デバッグ設定
        $this->setDebugFlag();

        // Ask for HTML-friendly debug output
        $this->phpmailer->Debugoutput = 'html';

        // Set the hostname of the mail server
        $this->phpmailer->Host = 'smtp.gmail.com';

        //Set the SMTP port number:
        // - 465 for SMTP with implicit TLS, a.k.a. RFC8314 SMTPS or
        // - 587 for SMTP+STARTTLS
        $this->phpmailer->Port = 465;
        
        //Set the encryption mechanism to use:
        // - SMTPS (implicit TLS on port 465) or
        // - STARTTLS (explicit TLS on port 587)
        $this->phpmailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

        // Whether to use SMTP authentication
        $this->phpmailer->SMTPAuth = true;

        // Set AuthType
        $this->phpmailer->AuthType = 'XOAUTH2';


        //Create a new OAuth2 provider instance
        $provider = new Google(
            [
                'clientId' => $oauth_id,
                'clientSecret' => $oauth_secret,
            ]
        );

        //Pass the OAuth provider instance to PHPMailer
        $this->phpmailer->setOAuth(
            new OAuth(
                [
                    'provider' => $provider,
                    'clientId' => $oauth_id,
                    'clientSecret' => $oauth_secret,
                    'refreshToken' => $oauth_refresh_token,
                    'userName' => $gmail_user,
                ]
            )
        );
    }
}