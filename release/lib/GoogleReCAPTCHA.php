<?php

namespace OznForm;

/**
 * Class GoogleReCAPTCHA
 * @property FormConfig config
 * @package OznForm
 */
class GoogleReCAPTCHA
{

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * reCAPTCHA設定が有効かを返す
     * @return bool
     */
    public function enabled()
    {
        return isset($this->config['reCAPTCHA']['enabled']) && $this->config['reCAPTCHA']['enabled'];
    }

    /**
     * jsスクリプトタグ
     * @return string
     */
    public function scriptTag()
    {
        return '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
    }

    /**
     * reCAPTCHAを挿入するHTMLタグを返す
     * @return string
     */
    public function htmlTag()
    {
        $errorMsg = '';

        if(isset($_SESSION['reCAPTCHAErrorMsg'])) {
            $errorMsg = '<div class="ozn-form-recaptcha-error">'.$_SESSION['reCAPTCHAErrorMsg'].'</div>';
        }

        return '<div class="ozn-form-recaptcha"><div class="g-recaptcha" data-sitekey="'.$this->config['reCAPTCHA']['site_key'].'"></div>'.$errorMsg.'</div>';
    }

    /**
     * 正当性検査を実施
     * @param string $googleReCaptchaSecret
     * @return bool
     */
    public function valid($googleReCaptchaSecret)
    {
        // チェックがなければ検証失敗
        if(empty($_POST['g-recaptcha-response'])) { return false;}

        $recaptcha = htmlspecialchars($_POST['g-recaptcha-response'],ENT_QUOTES,'UTF-8');

        $resp = @file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$googleReCaptchaSecret}&response={$recaptcha}");
        $resp_result = json_decode($resp,true);

        return $resp_result['success'];
    }

}

