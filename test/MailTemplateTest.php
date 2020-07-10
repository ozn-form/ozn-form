<?php namespace OznForm\Test;

use OznForm\MailTemplate;

require dirname(__FILE__) . "/../release/vendor/autoload.php";
require dirname(__FILE__) . "/../release/lib/MailTemplate.class.php";


/**
 * メールテンプレートテスト
 *
 * @property MailTemplate template
 */
class MailTemplateTest {


    function __construct()
    {
        $this->template = new MailTemplate([]);
    }


    function problemNumber83Test() {

        $params = [
            'corporate_kana' => 'コーポレートネーム',
            'customer_kana'  => 'カスタマーネーム'
        ];

        $template = <<<TEXT
<%% if.corporate_kana %%>【企業名・団体名フリガナ】 <%% halfsize %%><% corporate_kana %><%% endhalfsize %%>
<%% endif %%>

【ご担当者様フリガナ】<%% halfsize %%><% customer_kana %><%% endhalfsize %%>
TEXT;


        $this->template->setParams($params);

        echo $this->template->output($template);

    }



    function problemNumber84Test() {

        $params = [
            'corporate_kana' => '0',
            'customer_kana'  => 'カスタマーネーム'
        ];

        $template = <<<TEXT
<%% if.corporate_kana %%>【企業名・団体名フリガナ】 この値は出ますか？
<%% endif %%>

<%% if.undefined %%> 未定義値の場合
<%% endif %%>

【ご担当者様フリガナ】<%% halfsize %%><% customer_kana %><%% endhalfsize %%>
TEXT;


        $this->template->setParams($params);

        echo $this->template->output($template);

    }
}



$test = new MailTemplateTest();


$test->problemNumber84Test();


