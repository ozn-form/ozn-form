<?php namespace OznForm;

require_once dirname(__FILE__) . '/../vendor/autoload.php';
require_once dirname(__FILE__) . '/custom_validation_rules.php';

use Valitron\Validator as V;


class FromValidation
{

    function __construct()
    {

        V::langDir(__DIR__.'/../vendor/vlucas/valitron/lang'); // always set langDir before lang.
        V::lang('ja');

        $this->error_messages = false;

    }


    public function validatePostData($page_name, $config)
    {
        // フォーム設定に送信値の検証
        $v = new \Valitron\Validator($_POST);

        foreach ($config->prevPageForms($page_name) as $form_name => $form_config) {

            if(!isset($form_config['validates'])) {continue;}

            $form_name = str_replace('[]', '', $form_name);

            foreach ($form_config['validates'] as $validate) {
                if (isset($form_config['error_messages']) && isset($form_config['error_messages'][$validate])) {
                    $v->rule($validate, $form_name)->message($form_config['error_messages'][$validate]);
                } else {
                    $v->rule($validate, $form_name)->label($form_config['label']);
                }
            }
        }

        if($v->validate()) {
            return true;
        } else {
            $this->error_messages = $v->errors();
            return $v->errors();
        }

    }



}