<?php 
namespace OznForm;

use DateTime;
use OznForm\lib\exceptions\FormError;
use OznForm\lib\exceptions\SendMailException;
use OznForm\lib\FormConfig;
use OznForm\lib\FormSession;
use OznForm\lib\FormValidation;
use OznForm\lib\MailSender;
use OznForm\lib\MailTemplate;
use OznForm\lib\Token;
use OznForm\lib\MailHistory;


require_once __DIR__ . '/vendor/autoload.php';

/**
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 *   OznForm Core
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 *
 * @var string $config_path <設定ファイルパス>
 *
 */

/**
 * 初期処理
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */

date_default_timezone_set('Asia/Tokyo');


/**
 * バージョン
 * @note 2.6.0 PSR-4 AutoLoader 対応
 *       2.7.0 PHPMailer ver.6 アップデート 及び 依存ライブラリ最新化 (2021.7)
 *       2.8.0 PHP7.3 ~ PHP8.3まで対応・PHPMailer ver.6.9.4 アップデート 及び google OAUth ライブラリ最新化 (2024.7)　PHP7.1非対応
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */
const VERSION = '2.8.0';


/**
 * 環境情報（パスなど）を定義
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */

// 設定
$config = new FormConfig($config_path);

define('SYSTEM_ROOT'   , __DIR__); // OznFormシステムのルートパス

define('DOCUMENT_PATH' , str_replace($config->documentRoot(), '', SYSTEM_ROOT));

define('PAGE_NAME'     , preg_replace('/\..+$/', '', basename($_SERVER["SCRIPT_NAME"])));
define('PAGE_ROLE'     , $config->pageRole(PAGE_NAME));


/**
 * 例外時のエラーページ表示処理定義
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */

set_exception_handler(static function ($ex) use ($config) {

    $i = get_class($ex);
    if ($i === SendMailException::class) {
        require_once __DIR__ . '/send_mail_error.php';
    } else {
        require_once __DIR__ . '/error_page.php';
    }
});


/**
 * セッション開始
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */

$session = new FormSession(PAGE_NAME, $config);
$session->start();


/**
 * 送信値の処理
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */

if(strtolower($_SERVER['REQUEST_METHOD']) === 'post')
{
    $v = new FormValidation();

    if($v->validatePageForm($config->prevPageName(PAGE_NAME), $_POST, $config) && Token::check($_POST['_token']))
    {
        $session->savePostData();
    }
    else
    {
        throw new FormError('送信されたデータの検証に失敗しました。');
    }
}


/**
 * CSRF トークンの生成
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */

$oznFormToken = new Token();
$oznFormToken->make()->setSession();


/**
 * ページの役割による処理
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */

if(PAGE_ROLE === 'form') {

    /**
     * フォーム設置ページでの処理
     * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     */

    // フォームルートの場合の処理
    if($config->formRoot() === $_SERVER["SCRIPT_NAME"]) {

        // リファラを保存
        $session->saveReferer();

        // getでの送信値を取得
        $get_values = json_encode($_GET);

    // step2以降のフォームの場合の処理
    } else {

        // 前ページのフォームデータがセッションに登録されていない場合はフォームトップページへリダイレクト
        if( ! $session->verifyPrevFormData()) {
            header("Location: {$config->formRoot()}");
            exit();
        }
    }

    // 出力JSタグの定義
    $forms_json     = json_encode($config->pageForms(PAGE_NAME));
    $form_data_json = json_encode($session->getPageData(PAGE_NAME));


    $ozn_form_javascript = array();


    // ページごとに生成するjs
    $ozn_form_javascript[] = '<script type="application/javascript">';
    $ozn_form_javascript[] = '  OznForm = {};';
    $ozn_form_javascript[] = '  OznForm.page_role = "'.PAGE_ROLE.'";';
    $ozn_form_javascript[] = '  OznForm.page_data = '.$form_data_json.';';
    $ozn_form_javascript[] = '  OznForm.vurl      = "'.DOCUMENT_PATH.'/ozn-form-validation.php";';
    $ozn_form_javascript[] = '  OznForm.furl      = "'.DOCUMENT_PATH.'/upload/index.php";';
    $ozn_form_javascript[] = '  OznForm.vsetting  = ' . json_encode($config->validationSetting());
    $ozn_form_javascript[] = '  OznForm.forms     = '.$forms_json.';';
    $ozn_form_javascript[] = '  OznForm.reCAPTCHA = '. ($config->reCAPTCHA()->enabled() ? 'true':'false') .';';
    $ozn_form_javascript[] = '  OznForm.reCAPTCHA_sitekey = "'.$config->reCAPTCHA()->siteKey().'";';

    // 初期化メッセージ設定（GETで初期ページに渡された値）
    if(isset($get_values)) {
        $ozn_form_javascript[] = '  OznForm.init_msg     = '.$get_values.';';
    }

    // ページ離脱時のメッセージ
    if($config->unload_message() && $config->is_debug() === FALSE) {
        $ozn_form_javascript[] = '  OznForm.unload_message = '.$config->unload_message().';';
    }

    $ozn_form_javascript[] = '</script>';


    /**
     * 関連ライブラリjsの読み込み
     */

    if($config->ajaxZipOption()) {
        $ozn_form_javascript[] = '<script src="'.DOCUMENT_PATH.'/js/ajaxzip3.js?v='.VERSION.'"></script>';
    }

    if($config->jqueryUIOption()) {
        $ozn_form_javascript[] = '<script src="'.DOCUMENT_PATH.'/js/jquery-ui.min.js?v='.VERSION.'"></script>';
        $ozn_form_javascript[] = '<script src="'.DOCUMENT_PATH.'/js/datepicker-ja.js?v='.VERSION.'"></script>';
    }

    // google reCAPTCHA
    if($config->reCAPTCHA()->enabled()) {
        $ozn_form_javascript[] = $config->reCAPTCHA()->scriptTag();
    }

    // ファイルアップロード関連
    if($config->isUploadFileForm()) {
        $ozn_form_javascript[] = '<script src="'.DOCUMENT_PATH.'/js/jQuery-File-Upload-9.14.2/js/load-image.all.min.js?v='.VERSION.'"></script>';
        $ozn_form_javascript[] = '<script src="'.DOCUMENT_PATH.'/js/jQuery-File-Upload-9.14.2/js/vendor/jquery.ui.widget.js?v='.VERSION.'"></script>';
        $ozn_form_javascript[] = '<script src="'.DOCUMENT_PATH.'/js/jQuery-File-Upload-9.14.2/js/jquery.iframe-transport.js?v='.VERSION.'"></script>';
        $ozn_form_javascript[] = '<script src="'.DOCUMENT_PATH.'/js/jQuery-File-Upload-9.14.2/js/jquery.fileupload.js?v='.VERSION.'"></script>';
        $ozn_form_javascript[] = '<script src="'.DOCUMENT_PATH.'/js/jQuery-File-Upload-9.14.2/js/canvas-to-blob.min.js?v='.VERSION.'"></script>';

        $ozn_form_javascript[] = '<script src="'.DOCUMENT_PATH.'/js/jQuery-File-Upload-9.14.2/js/jquery.fileupload-process.js?v='.VERSION.'"></script>';
        $ozn_form_javascript[] = '<script src="'.DOCUMENT_PATH.'/js/jQuery-File-Upload-9.14.2/js/jquery.fileupload-image.js?v='.VERSION.'"></script>';
    }

    $ozn_form_javascript[] = '<script src="'.DOCUMENT_PATH.'/js/jquery.autoKana.js?v='.VERSION.'"></script>';
    $ozn_form_javascript[] = '<script src="'.DOCUMENT_PATH.'/js/domain_suggest.js?v='.VERSION.'"></script>';

    $ozn_form_javascript[] = '<script src="'.DOCUMENT_PATH.'/js/utilities.js?v='.VERSION.'"></script>';
    $ozn_form_javascript[] = '<script src="'.DOCUMENT_PATH.'/config/oznform_config.js?v='.VERSION.'"></script>';
    $ozn_form_javascript[] = '<script src="'.DOCUMENT_PATH.'/js/ozn-form.js?v='.VERSION.'"></script>';

    $ozn_form_javascript = implode("\n", $ozn_form_javascript);



    // 出力CSSタグの定義
    $ozn_form_styles = array();

    if($config->jqueryUIOption()) {
        $ozn_form_styles[] = '<link rel="stylesheet" href="'.DOCUMENT_PATH.'/css/jquery-ui.min.css">';
    }

    $ozn_form_styles[] = '<link rel="stylesheet" href="'.DOCUMENT_PATH.'/js/jQuery-File-Upload-9.14.2/css/jquery.fileupload.css">';
    $ozn_form_styles[] = '<link rel="stylesheet" href="'.DOCUMENT_PATH.'/css/ozn-form.min.css">';

    $ozn_form_styles = implode("\n", $ozn_form_styles);



/**
 * 入力内容確認ページでの処理
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */
} else if(PAGE_ROLE == 'confirm') {


    // 全てのフォームデータがセッションに登録されていない場合はフォームトップページへリダイレクト
    if( ! $session->verifyAllData()) {
        header("Location: {$config->formRoot()}");
        exit();
    }

    // 出力JSタグの定義
    $form_data_json = json_encode($session->getAllPageData());

    $ozn_form_javascript = array();

    $ozn_form_javascript[] = '<script type="application/javascript">';
    $ozn_form_javascript[] = '  OznForm = {};';
    $ozn_form_javascript[] = '  OznForm.page_role = "'.PAGE_ROLE.'";';
    $ozn_form_javascript[] = '  OznForm.page_data = '.$form_data_json.';';

    // ページ離脱時のメッセージ
    if($config->unload_message() && $config->is_debug() === FALSE) {
        $ozn_form_javascript[] = '  OznForm.unload_message = '.$config->unload_message().';';
    }

    $ozn_form_javascript[] = '</script>';

    // google reCAPTCHA
    if($config->reCAPTCHA()->enabled()) {
        $ozn_form_javascript[] = $config->reCAPTCHA()->scriptTag();
    }

    $ozn_form_javascript[] = '<script src="'.DOCUMENT_PATH.'/js/utilities.js?v='.VERSION.'"></script>';
    $ozn_form_javascript[] = '<script src="'.DOCUMENT_PATH.'/js/ozn-form-confirm.js?v='.VERSION.'"></script>';

    $ozn_form_javascript = implode("\n", $ozn_form_javascript);

    // 出力CSSタグの定義
    $ozn_form_styles = '<link rel="stylesheet" href="'.DOCUMENT_PATH.'/css/ozn-form.min.css">';


} else if(PAGE_ROLE == 'mailsend') {

    /**
     * メール送信ページでの処理
     *
     * @var string $admin_mail_title    <管理者向け：メールタイトル>
     * @var string $admin_mail_body     <管理者向け：メール本文>
     * @var string $customer_mail_title <返信メール：タイトル>
     * @var string $customer_mail_body  <返信メール：本文>
     * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     */

    // 全てのフォームデータがセッションに登録されていない場合はフォームトップページへリダイレクト
    if( ! $session->verifyAllData()) {
        header("Location: {$config->formRoot()}");
        exit();
    }


    // googleReCAPTCHAが有効の場合は、正当性チェックを実施

    if($config->reCAPTCHA()->enabled()) {

        if(empty($googleReCaptchaSecret)) { throw new \LogicException('[設定エラー] 送信ページに google ReCAPTCHA シークレットが設定されていません。');}
        if(isset($_SESSION['reCAPTCHAErrorMsg'])) { unset($_SESSION['reCAPTCHAErrorMsg']); }

        if(! $config->reCAPTCHA()->valid($googleReCaptchaSecret)) {

            throw new FormError('送信されたデータの検証に失敗しました。');
        }
    }


    // 出力CSSタグの定義
    $ozn_form_styles = '<link rel="stylesheet" href="'.DOCUMENT_PATH.'/css/ozn-form.min.css">';

    // 出力jsタグ
    $ozn_form_javascript = array();

    $ozn_form_javascript[] = '<script type="application/javascript">';
    $ozn_form_javascript[] = '  OznForm = {};';
    $ozn_form_javascript[] = '</script>';
    $ozn_form_javascript[] = '<script src="'.DOCUMENT_PATH.'/js/utilities.js?v='.VERSION.'"></script>';

    $ozn_form_javascript = implode("\n", $ozn_form_javascript);



    // システム情報取得/設定
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    $sys_info = array(
        'send_date'  => new DateTime(),
        'user_agent' => $_SERVER['HTTP_USER_AGENT'],
        'referrer'   => $_SESSION['ref']
    );


    // 問い合わせ履歴を保存
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    $isMailHistory = TRUE;

    try
    {
        $history = new MailHistory();
    }
    catch (FormError $e)
    {
        $isMailHistory = FALSE;
    }


    $sys_info['serial'] = $isMailHistory
        ? $history->save($sys_info, $session, $config)
        : str_replace('.','',microtime(true));


    // メール送信共通処理
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    $mailer = new MailSender();
    $page_data = $session->getAllPageData(FALSE);

    $template = new MailTemplate($sys_info);
    $template->setParams($page_data);



    // 管理者宛メール送信処理
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    // 管理者メール設定を取得
    $mail = $config->adminMail($page_data);

    $mailer->setEnvelope(
        $config->send_by(),
        $template->output($mail['to_name']), $mail['to'],
        $template->output($mail['from_name']), $mail['from'], $template->output($mail['reply_to']),
        $template->output($admin_mail_title), $template->output($admin_mail_body)
    );

    // CC.BCC設定
    $mailer->setCC($mail['cc']);
    $mailer->setBCC($mail['bcc']);

    // 添付ファイルをセット
    $upload_form_names = $config->uploadFileForms();
    if( ! empty($upload_form_names)) {
        foreach ($upload_form_names as $upload_form_name) {
            if( ! empty($page_data[$upload_form_name])) {
                $mailer->setAttachment(__DIR__ . '/upload/files/', $page_data[$upload_form_name]);
            }
        }
    }


    /**
     * 送信オプションの設定
     *
     * @var string $account      <アカウント>
     * @var string $password     <パスワード>
     * @var string $host         <ホスト>
     * @var array  $smtp_options <送信オプション>
     *
     * @var string $gmail_user     <GMailアカウント>
     * @var string $gmail_password <GMailパスワード>
     *
     * @var string $oauth_id     <OAuth ID>
     * @var string $oauth_secret <OAuth Secret>
     * @var string $oauth_refresh_token <OAuth Refresh Token>
     */

    $send_option = array();

    switch ($config->send_by()) {

        case 'SMTP':
            $send_option['account']      = $account;
            $send_option['password']     = $password;
            $send_option['host']         = $host;
            $send_option['smtp_options'] = $smtp_options;
            break;

        case 'Gmail SMTP':
            $send_option['account']  = $gmail_user;
            $send_option['password'] = $gmail_password;
            break;

        case 'Gmail SMTP With OAuth':
            $send_option['account']             = $gmail_user;
            $send_option['oauth_id']            = $oauth_id;
            $send_option['oauth_secret']        = $oauth_secret;
            $send_option['oauth_refresh_token'] = $oauth_refresh_token;

            break;
    }

    // 管理者メール送信処理
    try {
        $mailer->send($config->send_by(), $send_option, $config->send_flag());
    } catch (\Exception $e) {

        throw new SendMailException(TRUE, $e->getMessage());

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

        // 送信処理
        try {
            $mailer->send($config->send_by(), $send_option, $config->send_flag());
        } catch (\Exception $e) {
            $failCustomerMailSend = TRUE;
            $customerMailErrorMessage = $e->getMessage();
        }
    }

    // 送信後処理（デバッグ設定以外の時）
    if( ! $config->is_debug()) {

        // セッション情報をクリア
        $session->destroy();

        // 添付ファイルを削除
        $upload_form_names = $config->uploadFileForms();
        if( ! empty($upload_form_names)) {
            foreach ($upload_form_names as $upload_form_name) {
                if( ! empty($page_data[$upload_form_name])) {
                    foreach ($page_data[$upload_form_name] as $file) {

                        $file_path = __DIR__ . '/upload/files/' . $file;
                        if(file_exists($file_path)) unlink($file_path);

                        $thumbnail_path = __DIR__ . '/upload/files/thumbnail/' . $file;
                        if(file_exists($thumbnail_path)) unlink($thumbnail_path);
                    }
                }
            }
        }
    }

    /**
     * 顧客宛メールが失敗しているときは送信エラー画面を表示
     */
    if(isset($failCustomerMailSend) && $failCustomerMailSend === TRUE) {
        throw new SendMailException(FALSE, $customerMailErrorMessage);
    }

    // リダイレクト先が設定されている場合はリダイレクトして終了
    if(isset($mail['redirect_to']) && $mail['redirect_to'] != '') {
        header("Location: {$mail['redirect_to']}");
        exit();
    }
}
    if($config->is_debug()) {
        var_dump('セッション内容', $_SESSION);
    }
