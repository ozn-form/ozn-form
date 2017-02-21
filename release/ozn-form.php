<?php namespace OznForm;


/**
 * 関連クラス・依存ライブラリ読み込み
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */

require_once dirname(__FILE__) . '/lib/MailSender.class.php';
require_once dirname(__FILE__) . '/lib/FormConfig.class.php';
require_once dirname(__FILE__) . '/lib/FormError.class.php';
require_once dirname(__FILE__) . '/lib/FormSession.class.php';


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
 * デバッグフラグ
 * ・セッション内容の画面表示
 * ・ページ離脱時のアラート抑止
 */
$is_debug = $config->is_debug();


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

    // フォームルートの場合の処理
    if($is_form_root) {

        // リファラを保存
        $session->saveReferer();

        // getでの送信値を取得
        $get_values = json_encode($_GET);

    // step2以降のフォームの場合の処理
    } else {

        // 前ページのフォームデータがセッションに登録されていない場合はフォームトップページへリダイレクト
        if( ! $session->verifyFormDate(array($config->prevPageName($page_name) => $config->prevPageForms($page_name)))) {
            header("Location: {$config->formRoot()}");
            exit();
        }
    }

    // 出力JSタグの定義
    $forms_json     = json_encode($config->pageForms($page_name));
    $form_data_json = json_encode($session->getPageData($page_name));


    $ozn_form_javascript = array();

    $ozn_form_javascript[] = '<script type="application/javascript">';
    $ozn_form_javascript[] = '  OznForm = {};';
    $ozn_form_javascript[] = '  OznForm.page_role = "'.$page_role.'";';
    $ozn_form_javascript[] = '  OznForm.page_data = '.$form_data_json.';';
    $ozn_form_javascript[] = '  OznForm.vurl      = "'.$document_path.'/ozn-form-validation.php";';
    $ozn_form_javascript[] = '  OznForm.vsetting  = ' . json_encode($config->validationSetting());
    $ozn_form_javascript[] = '  OznForm.forms     = '.$forms_json.';';

    if(isset($get_values)) {
        $ozn_form_javascript[] = '  OznForm.init_msg     = '.$get_values.';';
    }

    if($config->unload_message() && $is_debug === FALSE) {
        $ozn_form_javascript[] = '  OznForm.unload_message = '.$config->unload_message().';';
    }

    $ozn_form_javascript[] = '</script>';

    if($config->ajaxZipOption()) {
        $ozn_form_javascript[] = '<script src="'.$document_path.'/js/ajaxzip3.js"></script>';
    }

    if($config->jqueryUIOption()) {
        $ozn_form_javascript[] = '<script src="'.$document_path.'/js/jquery-ui.min.js"></script>';
        $ozn_form_javascript[] = '<script src="'.$document_path.'/js/datepicker-ja.js"></script>';
    }

    $ozn_form_javascript[] = '<script src="'.$document_path.'/js/jquery.autoKana.js"></script>';
    $ozn_form_javascript[] = '<script src="'.$document_path.'/js/domain_suggest.js"></script>';

    $ozn_form_javascript[] = '<script src="'.$document_path.'/js/utilities.js"></script>';
    $ozn_form_javascript[] = '<script src="'.$document_path.'/js/ozn-form.js"></script>';

    $ozn_form_javascript = join("\n", $ozn_form_javascript);



    // 出力CSSタグの定義
    $ozn_form_styles = array();

    if($config->jqueryUIOption()) {
        $ozn_form_styles[] = '<link rel="stylesheet" href="'.$document_path.'/css/jquery-ui.min.css">';
    }

    $ozn_form_styles[] = '<link rel="stylesheet" href="'.$document_path.'/css/ozn-form.min.css">';

    $ozn_form_styles = join("\n", $ozn_form_styles);



/**
 * 入力内容確認ページでの処理
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */
} else if($page_role == 'confirm') {

    // POST送信時の送信値検証とセッション保存処理
    $session->savePostData($page_name, $config);

    // 全てのフォームデータがセッションに登録されていない場合はフォームトップページへリダイレクト
    if( ! $session->verifyFormDate($config->allPageForms())) {
        header("Location: {$config->formRoot()}");
        exit();
    }

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
    $ozn_form_styles = '<link rel="stylesheet" href="'.$document_path.'/css/ozn-form.min.css">';

/**
 * メール送信ページでの処理
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */
} else if($page_role == 'mailsend') {

    // 出力CSSタグの定義
    $ozn_form_styles = '<link rel="stylesheet" href="'.$document_path.'/css/ozn-form.min.css">';

    // 全てのフォームデータがセッションに登録されていない場合はフォームトップページへリダイレクト
    if( ! $session->verifyFormDate($config->allPageForms())) {
        header("Location: {$config->formRoot()}");
        exit();
    }

    $mail   = $config->mail();
    $mailer = new MailSender();
    $page_data = $session->getAllPageData(FALSE);

    // 管理者宛メール送信
    $additional = array();

    $additional[] = '';
    $additional[] = '- - - - - - - - - - - - - - - - - - - - - - - - -';
    $additional[] = '送信元エージェント：' . $_SERVER['HTTP_USER_AGENT'];
    $additional[] = '参照元：' . $_SESSION['ref'];
    $additional[] = '送信日時：' . date('Y年m月d日 H:i:s');

    // テンプレートタグ置換
    $admin_mail_title = $mailer->replaceMailTemplateTags($page_data, $admin_mail_title);
    $admin_mail_body  = $mailer->replaceMailTemplateTags($page_data, $admin_mail_body . join("\n", $additional));


    // 管理者宛メールのFROMを設定する
    if($mail['from']['to_admin']) {
        $admin_mail_from_name = $mail['from']['name'];
        $admin_mail_from      = $mail['from']['address'];

    } else {

        $admin_mail_from_name = array();
        foreach ( $mail['customer_name_form_name'] as $item) {
            $admin_mail_from_name[] = $session->getFormValue($item);
        }

        $admin_mail_from_name = join(' ', $admin_mail_from_name);
        $admin_mail_from      = $session->getFormValue($mail['customer_address_form_name']);
    }

    $mailer->setEnvelope(
        $mail['send_by'],
        '', $mail['admin_mail_to'],
        $admin_mail_from_name, $admin_mail_from,
        $admin_mail_title, $admin_mail_body
    );

    // CC.BCC設定
    $mailer->setCC($mail['admin_mail_cc']);
    $mailer->setBCC($mail['admin_mail_bcc']);

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

        $customer_mail_title = $mailer->replaceMailTemplateTags($page_data, $customer_mail_title);
        $customer_mail_body  = $mailer->replaceMailTemplateTags($page_data, $customer_mail_body);

        $mailer->setEnvelope(
            $mail['send_by'],
            '', $session->getFormValue($mail['customer_address_form_name']),
            $mail['from']['name'], $mail['from']['address'],
            $customer_mail_title, $customer_mail_body
        );

        // CC,BCC設定
        $mailer->setCC($mail['customer_mail_cc']);
        $mailer->setBCC($mail['customer_mail_bcc']);

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


    // リダイレクト先が設定されている場合はリダイレクトして終了
    if(isset($mail['redirect_to']) && $mail['redirect_to'] != '') {
        header("Location: {$mail['redirect_to']}");
        exit();
    }
}
    if($is_debug) {
        var_dump('セッション内容', $_SESSION);
    }