<?php

// 設定ファイルのパスを設定
$config_path = __DIR__ . '/datepicker_demo.json';

// OznForm 実行ファイル読み込み
require __DIR__ . '/../../release/ozn-form/ozn-form.php';

?>


<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Datepicker Configuration Demo</title>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <?php echo $ozn_form_styles; ?>
    <?php echo $ozn_form_javascript; ?>

    <style>
        .demo-section {
            margin: 30px 0;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .code-example {
            background-color: #f4f4f4;
            padding: 10px;
            border-radius: 3px;
            font-family: monospace;
            font-size: 12px;
            margin-top: 10px;
        }
    </style>
</head>
<body class="">

<div class="container">

<div class="page-header">
    <h1>Datepicker設定デモ</h1>
    <p class="lead">フォーム設置ページでjQuery UI Datepickerのオプションを設定する例</p>
</div>

<form action="index.php" method="POST">

    <div class="demo-section">
        <h3>デフォルト設定</h3>
        <p>設定なし（従来通りの動作）</p>
        <div class="form-group">
            <label>デフォルトのDatepicker:</label>
            <input type="text" name="default-date" class="form-control" data-of_datepicker="true" placeholder="クリックして日付を選択">
        </div>
        <div class="code-example">
            JSON設定: 設定なし（デフォルト動作）
        </div>
    </div>

    <div class="demo-section">
        <h3>日本語フォーマット設定</h3>
        <p>日付フォーマットを日本語形式に設定</p>
        <div class="form-group">
            <label>日本語フォーマット:</label>
            <input type="text" name="japanese-date" class="form-control" data-of_datepicker="true" placeholder="例）2024年01月01日">
        </div>
        <div class="code-example">
            "datepicker_options": {<br>
            &nbsp;&nbsp;"dateFormat": "yy年mm月dd日"<br>
            }
        </div>
    </div>

    <div class="demo-section">
        <h3>期間制限設定</h3>
        <p>選択可能な日付範囲を制限</p>
        <div class="form-group">
            <label>今日から1年間のみ選択可能:</label>
            <input type="text" name="limited-date" class="form-control" data-of_datepicker="true" placeholder="今日以降1年間のみ">
        </div>
        <div class="code-example">
            "datepicker_options": {<br>
            &nbsp;&nbsp;"dateFormat": "yy年mm月dd日",<br>
            &nbsp;&nbsp;"minDate": 0,<br>
            &nbsp;&nbsp;"maxDate": "+1Y"<br>
            }
        </div>
    </div>

    <div class="demo-section">
        <h3>月・年選択設定</h3>
        <p>月と年のドロップダウンを表示</p>
        <div class="form-group">
            <label>月・年選択可能:</label>
            <input type="text" name="dropdown-date" class="form-control" data-of_datepicker="true" placeholder="ドロップダウンで選択">
        </div>
        <div class="code-example">
            "datepicker_options": {<br>
            &nbsp;&nbsp;"dateFormat": "yy/mm/dd",<br>
            &nbsp;&nbsp;"changeMonth": true,<br>
            &nbsp;&nbsp;"changeYear": true,<br>
            &nbsp;&nbsp;"yearRange": "1900:2030"<br>
            }
        </div>
    </div>

    <div class="demo-section">
        <h3>複数月表示設定</h3>
        <p>3ヶ月分のカレンダーを表示</p>
        <div class="form-group">
            <label>3ヶ月表示:</label>
            <input type="text" name="multiple-date" class="form-control" data-of_datepicker="true" placeholder="3ヶ月カレンダー">
        </div>
        <div class="code-example">
            "datepicker_options": {<br>
            &nbsp;&nbsp;"dateFormat": "yy-mm-dd",<br>
            &nbsp;&nbsp;"numberOfMonths": 3,<br>
            &nbsp;&nbsp;"showButtonPanel": true<br>
            }
        </div>
    </div>

    <?php echo $ozn_form_token_tag; ?>
    
    <div class="form-group">
        <button type="submit" class="btn btn-primary">送信</button>
    </div>

</form>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">実装について</h3>
    </div>
    <div class="panel-body">
        <p>各datepickerの設定は、対応するJSONファイルの<code>datepicker_options</code>フィールドで設定されています。</p>
        <p>フィールド名（name属性）と設定を対応付けることで、個別の設定が可能です。</p>
        <p>設定されていないフィールドは従来通りデフォルト設定で動作します。</p>
    </div>
</div>

</div>

<script>
// デバッグ用：設定値をコンソールに出力
console.log('OznForm.datepicker_options:', OznForm.datepicker_options);
</script>

</body>
</html>