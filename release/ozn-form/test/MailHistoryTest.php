<?php namespace OznForm;

require_once dirname(__FILE__) . '/lib/MinimaTest.class.php';
require_once dirname(__FILE__) . '/../lib/FormConfig.class.php';
require_once dirname(__FILE__) . '/../lib/FormSession.class.php';
require_once dirname(__FILE__) . '/../lib/MailHistory.class.php';

/**
 * Class MailHistoryTest
 * @package OznForm
 *
 * @property FormConfig  $config
 * @property FormSession $session
 * @property MailHistory $mh
 */
class MailHistoryTest extends \MinimaTest
{

    public $config;
    public $session;
    public $mh;

    public function setUp()
    {

        $this->mh = new MailHistory();

        $this->config = new FormConfig('./data/sample.json');
        $this->session = new FormSession('index', $this->config);

        $_SESSION = array(
            'ref' => 'http://localhost:8080/document/samples/step/complete.php',
            'index' =>
                array(
                    'title' => '業務内容について',
                    'mail_body' => 'greaea'
                ),

            'step2' =>
                array(
                    'customer_name' => '田中一郎',
                    'customer_kana' => 'タナイロ',
                    'zip-code' => '4440001',
                    'address1' => '愛知県岡崎市箱柳町',
                    'address2' => '第一ビル',
                    'email' => 'michikawa.seisys@yahoo.co.jp'
                )
        );
    }

    public function testSerializedFormData()
    {

//        $this->mh->serializedFormData($this->session, $this->config);
        $this->mh->getCSV('step_form');

    }
}



$test = new MailHistoryTest();
$test->run();