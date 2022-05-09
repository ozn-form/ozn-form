<?php 
namespace OznForm\admin;

require_once __DIR__ . '/../vendor/autoload.php';

use OznForm\lib\Database;
use OznForm\lib\exceptions\FormError;
use OznForm\lib\MailHistory;

// DBクラスを読み込み
try{
    $history = new MailHistory();
}
catch (FormError $e)
{
    showLoginMessage($e->getMessage());
    exit();
}

if(strtolower($_SERVER['REQUEST_METHOD']) === 'post')
{

    // 未入力
    if( ! ($_POST['id'] && $_POST['password']))
    {
        showLoginMessage('ログインに失敗しました。<br>ID/パスワードを確認してください。');
    }

    if( ! $history->allowCSVDownload($_POST['id'], $_POST['password']))
    {
        showLoginMessage('ログインに失敗しました。<br>ID/パスワードを確認してください。');
    }

    if($_POST['button_name'] == '削除')
    {
        $count = $history->destroyHistories($_POST['form_name']);
        showMessage("$count 件のデータを削除しました。");
    }
    else
    {
        if( ! $history->getCSV($_POST['form_name']))
        {
            showLoginMessage('出力データがありません。');
        }
    }
}
else
{
    showTemplate();
}


/**
 * ログイン画面にメッセージを表示して終了
 *
 * @param $message
 */
function showMessage($message)
{
    showTemplate($message);
    exit();
}

/**
 * ログイン画面にエラーメッセージを表示して終了
 *
 * @param $message
 */
function showLoginMessage($message)
{
    showTemplate('',$message);
    exit();
}

/**
 * ログインフォームのテンプレート
 *
 * @param string $message
 * @param string $error_message
 */
function showTemplate($message = '', $error_message = '')
{
    /**
     * 設定ファイルを取得
     */
    $config = Database::getDatabaseConfig();
    
    $title = $config['adminPageTitle'] ?? 'ozn-form - CSVダウンロード';
    $hideFormInput = $config['isMultiFormDataDownload'] ? '' : 'style="display:none;"';
    $hideDeleteBtn = $config['showDeleteBtn'] ? '' : 'style="display:none;"';
    
    
    $html = <<<HTML

    <!doctype html>

    <html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>{$title}</title>
        <meta name="robots" content="noindex, nofollow">
        <link rel="stylesheet" href="css/login.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="js/login.js"></script>
    </head>

    <body>
        <div class="form-wrapper">
            <h1>{$title}</h1>
            <form method="post">
                <div class="form-item">
                    <label for="email"></label>
                    <input type="text" name="id" required="required" placeholder="管理者ID">
                </div>
                <div class="form-item">
                    <label for="password"></ label>
                    <input type="password" name="password" required="required" placeholder="パスワード">
                </div>
                <div class="form-item" {$hideFormInput}>
                    <label for="form_name"></label>
                    <input type="text" name="form_name" placeholder="フォーム名">
                </div>
                <div class="message">{$message}</div>
                <div class="errors">{$error_message}</div>
                <div class="button-panel">
                    <input type="submit" name="button_name" class="button submit" title="download" value="CSVダウンロード">
                    <input {$hideDeleteBtn} type="submit" name="button_name" class="button delete" title="delete" value="削除">
                </div>
            </form>
            <div class="form-footer"></div>
        </div>
    </body>
    </html>

HTML;
    
    
    echo $html;

}