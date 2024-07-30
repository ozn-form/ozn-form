<?php
namespace OznForm\lib;


/**
 * Class GoogleReCAPTCHA
 * @property FormConfig config
 * @package OznForm
 */
class GoogleReCAPTCHA
{

    public $config;
    
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
     * サイトキーを返す
     */
    public function siteKey()
    {
        return isset($this->config['reCAPTCHA']['enabled'], $this->config['reCAPTCHA']['site_key']) && $this->config['reCAPTCHA']['enabled']
            ? $this->config['reCAPTCHA']['site_key']
            : '';
    }

    /**
     * jsスクリプトタグ
     * @return string
     */
    public function scriptTag()
    {
        $siteKey = $this->config['reCAPTCHA']['site_key'];

        $tag = "<script src=\"https://www.google.com/recaptcha/api.js?render={$siteKey}\"></script>";

        if(PAGE_ROLE === 'confirm') {
            $tag .= <<< HTML

  <script>
  jQuery(function ($) {
      $('form').one('submit', function() {
         
          var targetForm = $(this);
          
          grecaptcha.ready(function() {
              grecaptcha.execute('{$siteKey}', {action: 'oznform'}).then(function(token) {
                 targetForm.append('<input type="hidden" name="g-recaptcha-response" value="'+token+'">');
                 targetForm.submit();
              });
          });
          return false;
      });
  });
  </script>
HTML;
        }

        return $tag;

    }


    private function score()
    {
        return isset($this->config['reCAPTCHA']['score']) ? $this->config['reCAPTCHA']['score'] : 0.5;
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

        return $resp_result['success'] && $resp_result['score'] >= $this->score();
    }

}

