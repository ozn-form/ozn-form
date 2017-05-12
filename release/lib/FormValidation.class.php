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
     * @var array $errors
     * @var array $last_errors
     */
    private $is_valid = TRUE;
    private $errors   = array();
    private $last_errors = array();


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
                $post_data,
                $setting['validates'],
                $setting['label'],
                $setting['validate_condition'],
                $setting['error_messages']
            );
        }

        return $this->is_valid;
    }


    /**
     * 検証実行
     *
     * @param string $name      <フォームのNAME属性値>
     * @param array  $values    <フォームの値>
     * @param array  $validates <検証項目>
     * @param string $label     <項目の名前>
     * @param array  $condition <検証実行条件>
     * @param array  $messages  <カスタムエラーメッセージ>
     *
     * @return bool
     */
    public function run($name, $values, $validates, $label, $condition, $messages = array())
    {

        $is_valid       = true;
        $run_validation = true;

        // 検証実行条件があれば先に条件を検証
        if($condition) {
            foreach ($condition as $target_name => $target_validates) {
                if( ! $this->isValid($target_name, $values, $target_validates, null, null)) {
                    $run_validation = FALSE;
                }
            }
        }

        // 検証実行条件に合わなければ TRUE を返す
        if( ! $run_validation) { return $is_valid; }


        $is_valid = $this->isValid($name, $values, $validates, $label, $messages);


        if( ! $is_valid)
        {
            $this->is_valid = FALSE;
            $this->errors = array_merge($this->errors, $this->last_errors);
        }

        return $is_valid;
    }

    /**
     * 検証を実行する
     *
     * @param $name
     * @param $values
     * @param $validates
     * @param $label
     * @param $messages
     *
     * @return bool
     */
    private function isValid($name, $values, $validates, $label, $messages)
    {
        $v = new Valitron(array($name => $values[$name]));

        // メールアドレス詳細チェック処理
        if(in_array('email_detail', $validates)) {
            array_splice($validates, array_search('email_detail', $validates), 1);
            $validates = array_merge($validates, array('email_atmark', 'email_no_user', 'email_domain', 'email_comma'));
        }

        foreach ($validates as $rule) {

            $option = preg_match("/^.+:(.+)$/", $rule, $m) ? $m[1] : null;
            $rule   = preg_replace("/:.*$/", '', $rule);

            if(!empty($messages) && !empty($messages[$rule]))
            {
                $v->rule($rule, $name, $option)->message($messages[$rule]);
            }
            else
            {
                $v->rule($rule, $name, $option)->label($label);
            }
        }

        $result = $v->validate();

        $this->last_errors = $result ? array() : $v->errors();

        return $result;
    }
}