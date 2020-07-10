<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $ex->getMessage() ?></title>
    <meta charset="utf-8">
    <meta name="robots" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        <!--
        #container {
            text-align: center;
            margin-top: 150px;
            line-height: 2em;
        }
        -->
    </style>
</head>

<body>

<div id="container">

    <?php if ($ex->isAdminMail() === TRUE): ?>

        <!-- 管理者メール送信失敗の時 -->

        <p><?= $ex->getMessage() ?></p>

        <p>メール送信エラーが発生しました。<br>
            お手数ですが、前の画面へ戻って入力のやり直しをお願いします。</p>
        <p><a href="<?= $config->formRoot() ?>">お問い合わせフォームへ戻る</a></p>

    <?php else: ?>

        <!-- お客様宛メール送信失敗の時 -->

        <p>後日、こちらからご連絡差し上げます。</p>
        <p><a href="<?= $config->formRoot() ?>">お問い合わせフォームへ戻る</a></p>
    <?php endif; ?>



</div>

</body>
</html>
