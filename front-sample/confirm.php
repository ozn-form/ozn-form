<?php
	// 設定ファイルのパスを設定
	$config_path = dirname(__FILE__) . '/' . 'ozn-config.json';
	// OznForm 実行ファイル読み込み
	require '../release/ozn-form.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>Ozn-Form - サンプルフォーム - STEP02</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width">
<?php echo $ozn_form_styles; ?>
<link rel="stylesheet" href="./css/style.min.css">
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
<?php echo $ozn_form_javascript; ?>
<!--[if lt IE 9]><script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
<body>

<?php include('./inc/header.php'); ?>

<div class="container">

	<div class="page-header">
		<h1>お問い合わせ</h1>
	</div>

	<div class="ozn-form-stepbar-wrapper">
		<ol class="ozn-form-stepbar step3 sp-hide">
			<li>1. 内容の入力</li>
			<li class="current">2. 内容確認</li>
			<li>3. 送信完了</li>
		</ol>
		<ol class="ozn-form-stepbar step3 tb-hide pc-hide">
			<li>入力</li>
			<li class="current">確認</li>
			<li>完了</li>
		</ol>
	</div>

	<div class="ozn-form-container ozn-form-confirm">

		<div class="ozn-form-lead">
			<h2>ご入力内容の確認</h2>
			<p>下記の入力内容に間違いが無ければ、一番下の「この内容で送信する」ボタンを押し、送信を完了してください。</p>
		</div>

		<div class="ozn-form-inner">
			<div class="tr" data-if="title">
				<div class="th">お問い合わせ種別 <span class="ozn-label required">必須</span></div>
				<div class="td" data-insert="title"></div>
			</div>
			<div class="tr" data-if="corporate_name">
				<div class="th">企業名・団体名 <span class="ozn-label optional">任意</span></div>
				<div class="td" data-insert="corporate_name"></div>
			</div>
			<div class="tr" data-if="corporate_kana">
				<div class="th">企業名・団体名フリガナ <span class="ozn-label optional">任意</span></div>
				<div class="td" data-insert="corporate_kana"></div>
			</div>
			<div class="tr" data-if="customer_name">
				<div class="th">ご担当者様氏名 <span class="ozn-label required">必須</span></div>
				<div class="td" data-insert="customer_name"></div>
			</div>
			<div class="tr" data-if="customer_kana">
				<div class="th">ご担当者様フリガナ <span class="ozn-label required">必須</span></div>
				<div class="td" data-insert="customer_kana"></div>
			</div>
			<div class="tr" data-if="email">
				<div class="th">メールアドレス <span class="ozn-label required">必須</span></div>
				<div class="td" data-insert="email"></div>
			</div>
			<div class="tr" data-if="tel">
				<div class="th">電話番号 <span class="ozn-label required">必須</span></div>
				<div class="td" data-insert="tel"></div>
			</div>
			<div class="tr" data-if="fax">
				<div class="th">FAX番号 <span class="ozn-label optional">任意</span></div>
				<div class="td" data-insert="fax"></div>
			</div>
			<div class="tr">
				<div class="th">ご住所 <span class="ozn-label required">必須</span></div>
				<div class="td">
					<span data-if="zip-code">〒<span data-insert="zip-code"></span><br></span>
					<span data-insert="pref"></span><span data-insert="address"></span>
					<span data-if="address-building"><br><span data-insert="address-building"></span></span>
				</div>
			</div>
			<div class="tr" data-if="shipping-date">
				<div class="th">ご希望納期 <span class="ozn-label optional">任意</span></div>
				<div class="td"><span data-insert="shipping-date"></span> <br class="pc-hide tb-hide">までに必要</div>
			</div>
			<div class="tr" data-if="survey[]">
				<div class="th">チェック項目 <span class="ozn-label optional">任意</span></div>
				<div class="td" data-insert="survey[]"></div>
			</div>
			<div class="tr" data-if="materials">
				<div class="th">選択項目 <span class="ozn-label optional">任意</span></div>
				<div class="td" data-insert="materials"></div>
			</div>
			<div class="tr" data-if="mail_body">
				<div class="th">お問い合わせ内容 <span class="ozn-label required">必須</span></div>
				<div class="td" data-insert="mail_body"></div>
			</div>
				<div class="tr" data-if="attachment1[]">
					<div class="th">デザイン案添付 <span class="ozn-label optional">任意</span></div>
					<div class="td">
						<span data-insert="attachment1[]"></span><br>
						<span data-insert="attachment2[]"></span>
					</div>
				</div>
		</div>

		<div class="ozn-form-buttons">
			<span><a href="./complete.php" class="ozn-btn ozn-form-nav submit">この内容で送信する →</a></span>
			<span><a href="./index.php" class="ozn-btn ozn-form-nav back">← 戻って書き直す</a></span>
		</div>

	</div><!-- ozn-form-inner -->

</div>

<?php include('./inc/footer.php'); ?>

</body>
</html>