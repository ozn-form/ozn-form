<?php namespace OznForm;

require_once dirname(__FILE__) . '/FormError.class.php';


class FormConfig
{
    private $config_raw;    // 設定値

    /**
     * FormConfig constructor.
     *
     * @param $config_path
     */
    public function __construct($config_path)
    {
        $this->config_raw = $this->parseConfigFile($config_path);
    }

    /**
     * 設定ファイルの有効性をチェックしパースする
     *
     * @param string $path <設定ファイルパス>
     *
     * @throws FormError
     *
     * @return array <設定値>
     */
    public function parseConfigFile($path) {

        if(empty($path))        { throw new FormError('設定ファイルパスが記載されていません。'); }
        if(!file_exists($path)) { throw new FormError('設定ファイルが存在していません。'); }

        $config = json_decode(file_get_contents($path),true);

        if(is_null($config)) { throw new FormError('設定ファイルを読み込めません。書式を確認してください。'); }

        return $config;
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
     * 送信実行フラグを返す（デバッグ用）
     * @return bool
     */
    public function send_flag() {
        if (isset($this->config_raw['mail']['send_flag']) && $this->config_raw['mail']['send_flag'] === false) {
            return FALSE;
        } else {
            return TRUE;
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
     * 全てのページのフォーム設定を返す
     *
     * @return array
     */
    public function allPageForms() {

        $page_forms = array();

        foreach ($this->config_raw['pages'] as $key => $page) {

            if($page['role'] == 'form') {
                $page_forms[$key] = $this->pageForms($key);
            }
        }

        return $page_forms;
    }

    /**
     * 特定ページのフォーム設定を返す
     *
     * @param $page_name
     *
     * @return mixed
     */
    public function pageForms($page_name)
    {
        if($page_name && isset($this->config_raw['pages'][$page_name]['forms']))
        {

            $forms = $this->config_raw['pages'][$page_name]['forms'];

            foreach ($forms as $name => $config) {
                if(! isset($config['error_messages'])) { $forms[$name]['error_messages'] = array(); }
                if(! isset($config['validate_condition'])) { $forms[$name]['validate_condition'] = array(); }
            }

            return $forms;
        }
        else
        {
            return array();
        }
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


    public function prevPageName($current_page_name) {

        $prev_key = false;

        foreach ($this->config_raw['pages'] as $key => $page) {
            if($current_page_name == $key) {break;}
            $prev_key = $key;
        }

        return $prev_key;
    }


    /**
     * 前のページのフォーム設定を返す
     *
     * @param $current_page_name
     *
     * @return array <フォーム設定>
     */
    public function prevPageForms($current_page_name)
    {
        $prev_page = $this->prevPageName($current_page_name);
        return $this->pageForms($prev_page);
    }

    /**
     * メール送信方法を返す
     * @return mixed
     */
    public function send_by() {
        return $this->config_raw['mail']['send_by'];
    }


    public function enabledAutoReply() {
        return $this->config_raw['mail']['auto_reply']['enabled'] === TRUE ? TRUE : FALSE;
    }


    /**
     * 管理者宛メールの設定
     * @return mixed
     */
    public function adminMail() {
        return $this->mailSetting($this->config_raw['mail']['admin']);
    }


    public function autoReplyMail() {
        return $this->mailSetting($this->config_raw['mail']['auto_reply']);
    }

    private function mailSetting($raw) {

        if(empty($raw['to'])) throw new FormError('To アドレスが設定されていません。');
        if(empty($raw['from'])) throw new FormError('From アドレスが設定されていません。');
        if(empty($raw['reply_to'])) throw new FormError('Reply To アドレスが設定されていません。');

        return $raw;
    }

    /**
     * アップロード項目のフォーム名を返す
     */
    public function uploadFileForms() {

        $file_forms = array();

        foreach ( $this->allPageForms() as $page) {

            foreach ($page as $key => $form) {
                if(isset($form['type']) && $form['type'] === 'upload_files') {
                    $file_forms[] = $key;
                }
            }
        }

        return $file_forms;

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