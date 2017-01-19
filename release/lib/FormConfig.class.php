<?php namespace OznForm;

require_once dirname(__FILE__) . '/FormError.class.php';


class FormConfig
{

    public $config_path;
    private $config_raw;

    /**
     * FormConfig constructor.
     *
     * @param $config_path
     */
    public function __construct($config_path)
    {
        $this->config_path = $config_path;

        $this->parseConfigFile();

    }

    /**
     * 設定ファイルの読み込み/パースを行う
     */
    public function parseConfigFile()
    {
        $json = file_get_contents($this->config_path);
        $this->config_raw = json_decode($json,true);

    }

    /**
     * ToDo: 設定ファイルの検証を行う メソッド実装
     */
    public function verifyConfig()
    {

    }

    /**
     * デバッグフラグを返す
     *
     * @return bool
     */
    public function is_debug() {
        if(isset($this->config_raw['is_debug']) && $this->config_raw['is_debug'] === true) {
            return TRUE;
        } else {
            return FALSE;
        }
    }


    /**
     * フォーム名を返す
     *
     * @return string <フォーム名>
     */
    public function formName()
    {
        return $this->config_raw['form_name'];
    }

    /**
     * フォーム初期ページのパスを返す
     * @return mixed
     */
    public function formRoot()
    {
        return $this->config_raw['form_root'];
    }

    /**
     * ページの役割を返す
     * @note
     *  form    : フォーム入力ページ
     *  confirm : 入力内容確認ページ
     *  mailsend : メール送信処理（＆完了画面）
     *
     * @param $page_name
     *
     * @return string <ページの役割名>
     */
    public function pageRole($page_name)
    {
        return $this->config_raw['pages'][$page_name]['role'];
    }

    /**
     * ページ離脱時のアラートメッセージ
     *
     * @note IE/Edge以外はブラウザデフォルトメッセージ（仕様）となる模様
     *
     * @return string|bool <設定時JSON(unicodeエンコード済み値)として、未設定の時はFalseを返す>
     */
    public function unload_message() {

        if(isset($this->config_raw['unload_message']) && $this->config_raw['unload_message'] != '') {
            return json_encode($this->config_raw['unload_message']);
        } else {
            return false;
        }
    }

    /**
     * ページのフォーム情報を返す
     *
     * @param $page_name
     *
     * @return mixed
     */
    public function pageForms($page_name)
    {
        return $this->config_raw['pages'][$page_name]['forms'];
    }

    /**
     * 検証の動作に関する設定
     *
     * @return array <>
     */
    public function validationSetting() {

        $v_setting = $this->config_raw['validation'];

        if( ! isset($v_setting['show_icon'])) {$v_setting['show_icon'] = FALSE;}
        if( ! isset($v_setting['shift_scroll_position'])) {$v_setting['shift_scroll_position'] = 0;}

        return $v_setting;
    }


    public function prevPageName($page_name) {

        $prev_key = false;

        foreach ($this->config_raw['pages'] as $key => $page) {
            if($page_name == $key) {break;}
            $prev_key = $key;
        }

        return $prev_key;
    }


    public function prevPageForms($page_name)
    {

        $prev_page = $this->prevPageName($page_name);

        if($prev_page && isset($this->config_raw['pages'][$prev_page]['forms'])) {
            return $this->config_raw['pages'][$prev_page]['forms'];
        } else {
            return array();
        }
    }


    public function mail()
    {
        $mail_setting = $this->config_raw['mail'];

        if( ! isset($mail_setting['admin_mail_cc'])) {$mail_setting['admin_mail_cc'] = FALSE;}
        if( ! isset($mail_setting['admin_mail_bcc'])) {$mail_setting['admin_mail_bcc'] = FALSE;}
        if( ! isset($mail_setting['customer_mail_cc'])) {$mail_setting['customer_mail_cc'] = FALSE;}
        if( ! isset($mail_setting['customer_mail_bcc'])) {$mail_setting['customer_mail_bcc'] = FALSE;}

        return $mail_setting;
    }

    /**
     * jQueryUIが有効か確認
     * @return bool
     */
    public function jqueryUIOption() {
        if(isset($this->config_raw['jquery-ui']) && $this->config_raw['jquery-ui'] === false) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * AjaxZip が有効か確認
     * @return bool
     */
    public function ajaxZipOption() {
        if(isset($this->config_raw['ajaxzip']) && $this->config_raw['ajaxzip'] === false) {
            return false;
        } else {
            return true;
        }
    }

}