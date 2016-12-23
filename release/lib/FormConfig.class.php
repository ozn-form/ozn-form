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
     * 設定ファイルの検証を行う
     */
    public function verifyConfig()
    {

    }



    public function formName()
    {
        return $this->config_raw['form_name'];
    }

    public function pageRole($page_name)
    {
        return $this->config_raw['pages'][$page_name]['role'];
    }

    public function pageForms($page_name)
    {
        return $this->config_raw['pages'][$page_name]['forms'];
    }


}