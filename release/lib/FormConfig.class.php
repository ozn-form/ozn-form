<?php namespace OznForm;

class FormConfig
{

    public $config_path;

    private $config_raw;

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

    }

    /**
     * 設定ファイルの検証を行う
     */
    public function verifyConfig()
    {

    }


}