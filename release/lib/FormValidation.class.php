<?php namespace OznForm;

require_once dirname(__FILE__) . '/../vendor/autoload.php';
require_once dirname(__FILE__) . '/custom_validation_rules.php';

use Valitron\Validator as Valitron;


/**
 * Class FromValidation
 * @package OznForm
 *
 * @param Valitron $valitron
 * @param array    $error_messages
 */
class FromValidation
{
    /**
     * @var bool $is_valid
     * @var array
     */
    private $is_valid = TRUE;
    private $errors   = array();


    function __construct()
    {
        Valitron::langDir(__DIR__.'/../vendor/vlucas/valitron/lang'); // always set langDir before lang.
        Valitron::lang('ja');
    }

    public function errorMessages()
    {
        return $this->errors;
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
    public function validatePageForm($page_name, $post_data, $config)
    {
        foreach ($config->pageForms($page_name) as $name => $setting) {

            if(!isset($setting['validates'])) {continue;}

            $name = str_replace('[]', '', $name);

            $this->run(
                $name,
                $post_data[$name],
                $setting['validates'],
                $setting['label'],
                null,
                $setting['error_messages']
            );
        }

        return $this->is_valid;
    }


    /**
     * 検証実行
     *
     * @param string $name      <フォームのNAME属性値>
     * @param string $value     <フォームの値>
     * @param array  $validates <検証項目>
     * @param string $label     <項目の名前>
     * @param array  $condition <検証実行条件>
     * @param array  $messages  <カスタムエラーメッセージ>
     *
     * @return bool
     */
    public function run($name, $value, $validates, $label, $condition, $messages = array())
    {
        $v = new Valitron(array($name => $value));

        // メールアドレス詳細チェック処理
        if(in_array('email_detail', $validates)) {
            array_splice($validates, array_search('email_detail', $validates), 1);
            $validates = array_merge($validates, array('email_atmark', 'email_no_user', 'email_domain', 'email_comma'));
        }

        foreach ($validates as $rule) {
            $this->setValidationRule($v, $name, $label, $rule);
        }

        $is_valid = $v->validate();

        if( ! $is_valid)
        {
            $this->is_valid = FALSE;
            $this->errors = array_merge($this->errors, $v->errors());
        }

        return $is_valid;
    }


    /**
     * @param Valitron $v
     * @param $name
     * @param $label
     * @param $rule
     */
    private function setValidationRule($v, $name, $label, $rule)
    {
        if(!empty($messages) && !empty($messages[$rule]))
        {
            $v->rule($rule, array($name))->message($messages[$rule]);
        }
        else
        {
            $v->rule($rule, array($name))->label($label);
        }
    }

}