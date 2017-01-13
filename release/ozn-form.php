<?php namespace OznForm;


/**
 * 関連クラス・依存ライブラリ読み込み
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */

require_once dirname(__FILE__) . '/lib/MailSender.class.php';
require_once dirname(__FILE__) . '/lib/FormConfig.class.php';
require_once dirname(__FILE__) . '/lib/FormError.class.php';
require_once dirname(__FILE__) . '/lib/FormSession.class.php';


$is_debug = FALSE;


/**
 * 初期処理
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */

// ページ設定チェック
if(!isset($config_path)) {
    throw new FormError('設定ファイルパスが記載されていません。');
}

$config = new FormConfig($config_path);


/**
 * 環境情報（パスなど）を定義
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */

$system_root = dirname(__FILE__);   // OznFormシステムのルートパス
$page_name   = preg_replace('/\..+$/', '', basename($_SERVER["SCRIPT_NAME"]));
$page_role   = $config->pageRole($page_name);
$is_form_root = ($config->formRoot() == $_SERVER["SCRIPT_NAME"]);
$forms       = array();

// ルートパスからのパス
$document_path = str_replace($_SERVER['DOCUMENT_ROOT'], '', $system_root);


/**
 * セッション開始
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */

$session = new FormSession();
$session->start($config->formName());


/**
 * フォーム設置ページでの処理
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */
if($page_role == 'form') {

    // POST送信時の送信値検証とセッション保存処理
    $session->savePostData($page_name, $config);

    // 出力JSタグの定義
    $forms_json     = json_encode($config->pageForms($page_name));
    $form_data_json = json_encode($session->getPageData($page_name));


    $ozn_form_javascript = array();

    $ozn_form_javascript[] = '<script type="application/javascript">';
    $ozn_form_javascript[] = '  OznForm = {};';
    $ozn_form_javascript[] = '  OznForm.page_role = "'.$page_role.'";';
    $ozn_form_javascript[] = '  OznForm.page_data = '.$form_data_json.';';
    $ozn_form_javascript[] = '  OznForm.vurl      = "'.$document_path.'/ozn-form-validation.php";';
    $ozn_form_javascript[] = '  OznForm.forms     = '.$forms_json.';';
    $ozn_form_javascript[] = '</script>';

    if($config->ajaxZipOption()) {
        $ozn_form_javascript[] = '<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>';
    }

    if($config->jqueryUIOption()) {
        $ozn_form_javascript[] = '<script src="'.$document_path.'/js/jquery-ui.min.js"></script>';
        $ozn_form_javascript[] = '<script src="'.$document_path.'/js/datepicker-ja.js"></script>';
    }

    $ozn_form_javascript[] = '<script src="'.$document_path.'/js/utilities.js"></script>';
    $ozn_form_javascript[] = '<script src="'.$document_path.'/js/ozn-form.js"></script>';

    $ozn_form_javascript = join("\n", $ozn_form_javascript);



    // 出力CSSタグの定義
    $ozn_form_styles = array();

    if($config->jqueryUIOption()) {
        $ozn_form_styles[] = '<link rel="stylesheet" href="'.$document_path.'/css/jquery-ui.min.css">';
    }

    $ozn_form_styles[] = '<link rel="stylesheet" href="'.$document_path.'/css/ozn-form-style.css">';

    $ozn_form_styles = join("\n", $ozn_form_styles);



/**
 * 入力内容確認ページでの処理
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */
} else if($page_role == 'confirm') {

    // POST送信時の送信値検証とセッション保存処理
    $session->savePostData($page_name, $config);

    // 出力JSタグの定義
    $form_data_json = json_encode($session->getAllPageData());

    $ozn_form_javascript = array();

    $ozn_form_javascript[] = '<script type="application/javascript">';
    $ozn_form_javascript[] = '  OznForm = {};';
    $ozn_form_javascript[] = '  OznForm.page_role = "'.$page_role.'";';
    $ozn_form_javascript[] = '  OznForm.page_data = '.$form_data_json.';';
    $ozn_form_javascript[] = '</script>';
    $ozn_form_javascript[] = '<script src="'.$document_path.'/js/utilities.js"></script>';
    $ozn_form_javascript[] = '<script src="'.$document_path.'/js/ozn-form-confirm.js"></script>';

    $ozn_form_javascript = join("\n", $ozn_form_javascript);

    // 出力CSSタグの定義
    $ozn_form_styles = '<link rel="stylesheet" href="'.$document_path.'/css/ozn-form-style.css">';

/**
 * メール送信ページでの処理
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */
} else if($page_role == 'mailsend') {

    if($session->verifyFormDate()) {

        $mail   = $config->mail();
        $mailer = new MailSender();

        // 管理者宛メール送信

        $additional = array();

        $additional[] = '';
        $additional[] = '- - - - - - - - - - - - - - - - - - - - - - - - -';
        $additional[] = '送信元エージェント：' . $_SERVER['HTTP_USER_AGENT'];
        $additional[] = '送信日時：' . date('Y年m月d日 H:i:s');

        $mailer->setEnvelope(
            $mail['send_by'],
            '', $mail['admin_mail_to'],
            $mail['from_name'], $mail['from_address'],
            $admin_mail_title, $admin_mail_body . join("\n", $additional)
        );

        switch ($mail['send_by']) {
            case 'sendmail':
                $mailer->sendmail();
                break;
            case 'Gmail SMTP':
                $mailer->sendGmailSMTP($gmail_user, $gmail_password);
                break;
            case 'Gmail SMTP With OAuth':
                $mailer->sendGmailSMTPWithOAuth($gmail_user, $oauth_id, $oauth_secret, $oauth_refresh_token);
                break;
        }


        // 自動返信メールが有効の時は送信
        if($mail['auto_reply']) {

            $mailer->setEnvelope(
                $mail['send_by'],
                '', $session->getFormValue($mail['customer_address_form_name']),
                $mail['from_name'], $mail['from_address'],
                $customer_mail_title, $customer_mail_body
            );

            switch ($mail['send_by']) {
                case 'sendmail':
                    $mailer->sendmail();
                    break;
                case 'Gmail SMTP':
                    $mailer->sendGmailSMTP($gmail_user, $gmail_password);
                    break;
                case 'Gmail SMTP With OAuth':
                    $mailer->sendGmailSMTPWithOAuth($gmail_user, $oauth_id, $oauth_secret, $oauth_refresh_token);
                    break;
            }

        }

    } else {
        header("Location: {$config->formRoot()}");
        exit();
    }

}
    if($is_debug) {
        var_dump('セッション内容', $_SESSION);
    }


function setPostData($post, $forms)
{
    global $session, $config, $page_name;

    // POSTデータがない場合は処理終了
    if(empty($_POST)) {return true;}

    // フォーム設定に送信値の検証
    $v = new \Valitron\Validator($post);

    foreach ($forms as $form_name => $form_config) {

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
        // 送信値をセッションに保存する
        $session->savePostData($config->prevPageName($page_name), $_POST, $config->prevPageForms($page_name));

        return true;
    } else {
        var_dump($v->errors());

        return false;
    }


}
