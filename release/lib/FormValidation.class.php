<?php namespace OznForm;

require_once dirname(__FILE__) . '/../vendor/autoload.php';
require_once dirname(__FILE__) . '/custom_validation_rules.php';

use Valitron\Validator as V;


/**
 * Class FromValidation
 * @package OznForm
 *
 * @param V $valitron
 * @param array $error_messages
 */
class FromValidation
{

    private $valitron;


    function __construct()
    {
        V::langDir(__DIR__.'/../vendor/vlucas/valitron/lang'); // always set langDir before lang.
        V::lang('ja');
    }

    public function errorMessages()
    {
        return $this->valitron->errors();
    }


    /**
     * FormからPOSTされたデータを検証する
     *
     * @param string     $page_name
     * @param array      $post_data
     * @param FormConfig $config
     *
     * @return array|bool
     */
    public function validateFromData($page_name, $post_data, $config)
    {

        $this->valitron = new V($post_data);

        foreach ($config->prevPageForms($page_name) as $form_name => $form_config) {

            if(!isset($form_config['validates'])) {continue;}

            $form_name = str_replace('[]', '', $form_name);

            foreach ($form_config['validates'] as $validate) {

                $this->valid($validate, $form_name, $form_config['label'], $form_config['error_messages']);
            }
        }

        return $this->valitron->validate();
    }


    /**
     * 検証設定
     *
     * @param string $rule
     * @param string $form_name
     * @param string $label
     * @param array  $custom_messages
     */

    private function valid($rule, $form_name, $label, $custom_messages = array())
    {

        if(!empty($custom_messages) && !empty($custom_messages[$rule]))
        {
            $this->valitron->rule($rule, $form_name)->message($custom_messages[$rule]);
        }
        else
        {
            $this->valitron->rule($rule, $form_name)->label($label);
        }
    }

}