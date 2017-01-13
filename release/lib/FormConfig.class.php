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
        return $this->config_raw['mail'];
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