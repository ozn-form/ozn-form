<?php namespace OznForm;


/**
 * 関連クラス・依存ライブラリ読み込み
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */

require_once dirname(__FILE__) . '/lib/MailSender.class.php';
require_once dirname(__FILE__) . '/lib/FormConfig.class.php';
require_once dirname(__FILE__) . '/lib/FormError.class.php';
require_once dirname(__FILE__) . '/lib/FormSession.class.php';


$is_debug = true;


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
    $forms_json = json_encode($config->pageForms($page_name));
    $form_data_json = json_encode($session->getPageData($page_name));

    $ozn_form_scripts = <<<HTML

        <script type="application/javascript">
            OznForm = {};
            OznForm.page_role = "$page_role";
            OznForm.page_data = $form_data_json;
            OznForm.vurl      = "$document_path/ozn-form-validation.php";
            OznForm.forms     = $forms_json;
        </script>
        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
        <script src="$document_path/js/utilities.js"></script>
        <script src="$document_path/js/ozn-form.js"></script>
HTML;

    // 出力CSSタグの定義
    $ozn_form_styles = <<<HTML
        <link rel="stylesheet" href="$document_path/css/ozn-form-style.css">
HTML;


/**
 * 入力内容確認ページでの処理
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */
} else if($page_role == 'confirm') {

    // POST送信時の送信値検証とセッション保存処理
    $session->savePostData($page_name, $config);

    // 出力JSタグの定義
    $form_data_json = json_encode($session->getAllPageData());

    $ozn_form_scripts = <<<HTML

        <script type="application/javascript">
            OznForm = {};
            OznForm.page_role = "$page_role";
            OznForm.page_data = $form_data_json;
        </script>
        <script src="$document_path/js/utilities.js"></script>
        <script src="$document_path/js/ozn-form-confirm.js"></script>
HTML;

    // 出力CSSタグの定義
    $ozn_form_styles = <<<HTML
        <link rel="stylesheet" href="$document_path/css/ozn-form-style.css">
HTML;



/**
 * メール送信ページでの処理
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */
} else if($page_role == 'mailsend') {

    if($session->verifyFormDate()) {

        $mail   = $config->mail();
        $mailer = new MailSender();

        // 管理者宛メール送信

        $mailer->setEnvelope(
            $mail['send_by'],
            '', $mail['admin_mail_to'],
            $mail['from_name'], $mail['from_address'],
            $admin_mail_title, $admin_mail_body
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
