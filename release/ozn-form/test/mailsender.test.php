<?php namespace OznForm;

require dirname(__FILE__) . "/../release/vendor/autoload.php";
require dirname(__FILE__) . "/../release/lib/MailSender.class.php";


class MailSenderTest {


    function __construct()
    {
        $this->sender = new MailSender();
        $this->sender->is_debug = true;
    }


    function replaceTemplateTest() {

        return $this->sender->replaceMailTemplateTags(

            array('mail_body' => 'これは改行を含む'),

            '<%% if.mail_body %%>お問い合わせ内容：<% mail_body %> <%% endif %%>'
        );


    }

}



$test = new MailSenderTest();


echo $test->replaceTemplateTest();





