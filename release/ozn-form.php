<?php namespace OznForm;


/**
 * 関連クラス・依存ライブラリ読み込み
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */

require_once dirname(__FILE__) . '/lib/MailSender.class.php';
require_once dirname(__FILE__) . '/lib/FormConfig.class.php';
require_once dirname(__FILE__) . '/lib/FormError.class.php';
require_once dirname(__FILE__) . '/lib/FormSession.class.php';
require_once dirname(__FILE__) . '/lib/MailTemplate.class.php';


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

$session = new FormSession($config->formName());
$session->start();


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


    // ページごとに生成するjs
    $ozn_form_javascript[] = '<script type="application/javascript">';
    $ozn_form_javascript[] = '  OznForm = {};';
    $ozn_form_javascript[] = '  OznForm.page_role = "'.$page_role.'";';
    $ozn_form_javascript[] = '  OznForm.page_data = '.$form_data_json.';';
    $ozn_form_javascript[] = '  OznForm.vurl      = "'.$document_path.'/ozn-form-validation.php";';
    $ozn_form_javascript[] = '  OznForm.furl      = "'.$document_path.'/upload/index.php";';
    $ozn_form_javascript[] = '  OznForm.vsetting  = ' . json_encode($config->validationSetting());
    $ozn_form_javascript[] = '  OznForm.forms     = '.$forms_json.';';

    // 初期化メッセージ設定（GETで初期ページに渡された値）
    if(isset($get_values)) {
        $ozn_form_javascript[] = '  OznForm.init_msg     = '.$get_values.';';
    }

    // ページ離脱時のメッセージ
    if($config->unload_message() && $is_debug === FALSE) {
        $ozn_form_javascript[] = '  OznForm.unload_message = '.$config->unload_message().';';
    }

    $ozn_form_javascript[] = '</script>';


    // 関連ライブラリの読み込み
    if($config->ajaxZipOption()) {
        $ozn_form_javascript[] = '<script src="'.$document_path.'/js/ajaxzip3.js"></script>';
    }

    if($config->jqueryUIOption()) {
        $ozn_form_javascript[] = '<script src="'.$document_path.'/js/jquery-ui.min.js"></script>';
        $ozn_form_javascript[] = '<script src="'.$document_path.'/js/datepicker-ja.js"></script>';
    }


    // ToDo: jQueryFileUpload のパスを考える
    // ToDo: 設定ファイルで読み込み制限できるようにする
    $ozn_form_javascript[] = '<script src="'.$document_path.'/js/jQuery-File-Upload-9.14.2/js/vendor/jquery.ui.widget.js"></script>';
    $ozn_form_javascript[] = '<script src="'.$document_path.'/js/jQuery-File-Upload-9.14.2/js/jquery.iframe-transport.js"></script>';
    $ozn_form_javascript[] = '<script src="'.$document_path.'/js/jQuery-File-Upload-9.14.2/js/jquery.fileupload.js"></script>';

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

    $ozn_form_styles[] = '<link rel="stylesheet" href="'.$document_path.'/js/jQuery-File-Upload-9.14.2/css/jquery.fileupload.css">';
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

    // メール送信共通処理
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    $mailer = new MailSender();
    $page_data = $session->getAllPageData(FALSE);

    $template = new MailTemplate();
    $template->setParams($page_data);


    // 管理者宛メール送信処理
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    // 付加情報を設定
    $additional = array();

    $additional[] = '';
    $additional[] = '- - - - - - - - - - - - - - - - - - - - - - - - -';
    $additional[] = '送信元エージェント：' . $_SERVER['HTTP_USER_AGENT'];
    $additional[] = '参照元：' . $_SESSION['ref'];
    $additional[] = '送信日時：' . date('Y年m月d日 H:i:s');

    // 管理者メール設定を取得
    $mail = $config->adminMail($page_data);

    $mailer->setEnvelope(
        $config->send_by(),
        $template->output($mail['to_name']), $mail['to'],
        $template->output($mail['from_name']), $mail['from'], $template->output($mail['reply_to']),
        $template->output($admin_mail_title), $template->output($admin_mail_body) . join("\n", $additional)
    );

    // CC.BCC設定
    $mailer->setCC($mail['cc']);
    $mailer->setBCC($mail['bcc']);

    // 送信処理

    switch ($config->send_by()) {
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
    if($config->enabledAutoReply()) {

        $mail = $config->autoReplyMail();

        $mailer->setEnvelope(
            $config->send_by(),
            $template->output($mail['to_name']), $template->output($mail['to']),
            $mail['from_name'], $mail['from'], $mail['reply_to'],
            $template->output($customer_mail_title), $template->output($customer_mail_body)
        );

        // CC,BCC設定
        $mailer->setCC($mail['cc']);
        $mailer->setBCC($mail['bcc']);

        switch ($config->send_by()) {
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

    // デバッグ設定以外の時はセッションをクリアする
    if( ! $is_debug) {
        $session->destroy();
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