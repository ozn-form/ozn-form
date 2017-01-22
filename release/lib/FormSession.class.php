<?php namespace OznForm;

require_once dirname(__FILE__) . '/FormValidation.class.php';


class FormSession
{
    function __construct()
    {
    }

    public function start($session_name)
    {
        session_name($session_name);
        session_start();
    }

    /**
     * 送信されたフォームのデータをセッションに登録する
     *
     * @param string                $page_name
     * @param \OznForm\FormConfig   $config
     * @param bool                  $invalid
     *
     * @return bool
     */
    public function savePostData($page_name, $config, $invalid = true)
    {
        $forms = $config->prevPageForms($page_name);

        if(empty($_POST) || empty($forms)) {return false;}

        if($invalid) {

            $validator = new FromValidation();

            if($validator->validatePostData($page_name, $config) !== true) {
                var_dump($validator->error_messages);
                return false;
            }
        }

        $form_names = array_keys($forms);

        // ページセッションデータ初期化
        $_SESSION[$config->prevPageName($page_name)] = array();

        foreach ($form_names as $form_name) {

            $r_name = preg_replace('/\[\]$/', '', $form_name);

            if(isset($_POST[$r_name])) {
                $_SESSION[$config->prevPageName($page_name)][$form_name] = $_POST[$r_name];
            } else {
                $_SESSION[$config->prevPageName($page_name)][$form_name] = null;
            }
        }
    }

    /**
     * ページのリファラを保存する
     */
    public function saveReferer()
    {
        if( ! isset($_SESSION['ref'])) {
            if(isset($_SERVER['HTTP_REFERER'])) {
                $_SESSION['ref'] = $_SERVER['HTTP_REFERER'];
            } else {
                $_SESSION['ref'] = 'なし';
            }
        }
    }

    /**
     * 特定ページのセッション保存済みデータを返す
     *
     * @param $page_name
     *
     * @return array
     */
    public function getPageData($page_name)
    {
        $data = array();

        if(isset($_SESSION[$page_name])) {
            $data = $_SESSION[$page_name];
        }

        return $data;
    }

    /**
     * すべてのページのセッション保存済みデータを返す
     *
     * @param bool $sanitize
     *
     * @return array
     */
    public function getAllPageData($sanitize = true)
    {
        $all_data = array();

        foreach ($_SESSION as $page_data) {
            if(is_array($page_data)) {
                foreach ($page_data as $key => $value) {

                    if($sanitize) {
                        if(is_array($value)) {
                            $all_data[$key] = array_map(array($this, 'h'), $value);
                        } else {
                            $all_data[$key] = $this->h($value);
                        }
                    } else {
                        $all_data[$key] = $value;
                    }
                }
            }
        }

        return $all_data;
    }


    /**
     * 特定フォームの値を返す
     *
     * @param $form_name
     *
     * @return mixed
     */
    public function getFormValue($form_name)
    {
        $all_data = $this->getAllPageData(false);
        return $all_data[$form_name];
    }



    public function h($str)
    {
        return str_replace("\n", '<br>', htmlspecialchars($str, ENT_QUOTES));
    }

    /**
     * ToDo: メール送信前のセッション内容確認　を実装
     *
     * すべてのページを経て検証済みデータが存在しているか確認する
     *
     * @param array $pages <ページ設定>
     *
     * @return bool
     */
    public function verifyFormDate($pages)
    {

        $is_verified = true;

        foreach ($pages as $page => $forms) {
            if(( ! isset($_SESSION[$page])) || (count($_SESSION[$page]) !== count($forms))) {
                $is_verified = FALSE;
            }
        }

        return $is_verified;
    }


}