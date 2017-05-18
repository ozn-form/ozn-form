<?php namespace OznForm;

require_once dirname(__FILE__) . '/Database.class.php';


/**
 * Class MailHistory
 * @package OznForm
 *
 * @property Database $database
 */
class MailHistory
{

    private $database;
    const TABLE_NAME = 'histories';

    function __construct()
    {
        $this->database = new Database();
    }


    public function getCSV($form_name)
    {

        $sql = "SELECT * FROM " .self::TABLE_NAME. " WHERE form_name = :name";

        $dbh = $this->database->getDBH();

        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':name', $form_name);

        if($stmt->execute())
        {

            ob_start();

            $stdout = fopen('php://output', 'w');
            $count = 1;

            foreach ($stmt as $item)
            {
                $form_items = unserialize($item['form_items']);

                if($count === 1)
                {
                    fputcsv($stdout, array_merge(array(
                        'シリアルNo', 'フォーム名', '送信日時', 'ユーザエージェント', 'リファラ'
                    ), array_keys($form_items)));
                }

                fputcsv($stdout, array_merge(array(
                    $item['id'], $item['form_name'], $item['send_datetime'], $item['user_agent'], $item['referrer']
                ), array_values($form_items)));

                $count += 1;

            } ;

            if($count == 1) {return FALSE;}

            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename={$form_name}.csv");
            echo mb_convert_encoding(ob_get_clean(), 'SJIS-WIN', 'UTF-8');

            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }


    /**
     * フォーム履歴を記録する
     *
     * @param array       $sys_info
     * @param FormSession $session
     * @param FormConfig  $config
     *
     * @return string|bool
     */
    public function save($sys_info, $session, $config)
    {
        $params = array(
            'form_name'     => $config->formName(),
            'send_datetime' => $sys_info['send_date']->format('Y-m-d H:i:s'),
            'user_agent'    => $sys_info['user_agent'],
            'referrer'      => $sys_info['referrer'],
            'form_items'    => $this->serializedFormData($session, $config)
        );

        return $this->database->insert(self::TABLE_NAME, $params);
    }

    /**
     * フォームに入力されたデータをシリアライズして返す
     *
     * @param FormSession $session
     * @param FormConfig  $config
     *
     * @return string <シリアライズ済み入力データ>
     */
    public function serializedFormData($session, $config)
    {

        $form_datas = array();

        foreach ( $session->getAllPageData() as $key => $value) {
            $form_datas[$config->formName2Label($key)] = $value;
        }

        return serialize($form_datas);
    }

    /**
     * CSVダウンロードが許可されるか
     *
     * @param $id
     * @param $pass
     *
     * @return bool
     */
    public function allowCSVDownload($id, $pass)
    {
        $config = $this->database->getConfig();
        return (($id == $config['oznform_admin_id']) && ($pass == $config['oznform_admin_pass']));
    }
}