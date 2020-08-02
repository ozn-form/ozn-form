<?php
namespace OznForm\lib;

/**
 * Class FormSession
 *
 * @package OznForm
 *
 * @param FormConfig $config
 * @param string     $session_name
 * @param string     $page_name
 */
class FormSession
{

    private $config;
    private $session_name;
    private $page_name;

    /**
     * FormSession constructor.
     *
     * @param string $page_name
     * @param FormConfig $config
     */
    public function __construct($page_name, $config)
    {
        $this->page_name    = $page_name;
        $this->config       = $config;
        $this->session_name = $config->formName();
    }

    public function start()
    {
        session_name($this->session_name);
        session_start();
    }

    /**
     * 送信されたフォームのデータをセッションに登録する
     *
     * @return bool
     */
    public function savePostData()
    {
        $forms = $this->config->prevPageForms($this->page_name);

        if(empty($_POST) || empty($forms)) {return false;}

        $form_names = array_keys($forms);

        // ページセッションデータ初期化
        $_SESSION[$this->config->prevPageName($this->page_name)] = array();

        foreach ($form_names as $form_name) {

            $r_name = preg_replace('/\[\]$/', '', $form_name);

            if(isset($_POST[$r_name])) {
                $_SESSION[$this->config->prevPageName($this->page_name)][$form_name] = $_POST[$r_name];
            } else {
                $_SESSION[$this->config->prevPageName($this->page_name)][$form_name] = null;
            }
        }
        
        return true;
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
     * 内部処理用（サニタイズなし）
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
                            $all_data[$key] = implode('、', array_map(array($this, 'h'), $value));
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


    /**
     * フォームのセッションを破棄する
     */
    public function destroy() {
        setcookie($this->session_name, '', time() - 1800);
        session_destroy();
    }



    public function h($str)
    {
        return str_replace("\n", '<br>', htmlspecialchars($str, ENT_QUOTES));
    }

    /**
     * すべてのページを経て検証済みデータが存在しているか確認する
     *
     * @return bool
     */
    public function verifyAllData()
    {
        foreach ($this->config->allPageForms() as $page => $forms) {
            if( ! $this->verifyFormData($page, $forms)) { return FALSE; }
        }

        return TRUE;
    }

    public function verifyPrevFormData() {
        return $this->verifyFormData($this->config->prevPageName($this->page_name), $this->config->prevPageForms($this->page_name));
    }


    /**
     * 特定ページの検証済みデータが存在するか確認する
     *
     * @param $page_name
     * @param $page_forms
     *
     * @return bool
     */
    public function verifyFormData($page_name, $page_forms)
    {
        return (isset($_SESSION[$page_name])) && (count($_SESSION[$page_name]) === count($page_forms));
    }


}