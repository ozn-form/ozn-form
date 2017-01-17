<?php
	// 設定ファイルのパスを設定
	$config_path = dirname(__FILE__) . '/' . 'ozn-config.json';
	// OznForm 実行ファイル読み込み
	require '../ozn-form/ozn-form.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>Ozn-Form - サンプルフォーム - STEP02</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width">
<?php echo $ozn_form_styles; ?>
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

	<div class="step_bar_box">
		<ol class="step_bar step3 sp-hide">
			<li>1. 内容の入力</li>
			<li class="current">2. 内容確認</li>
			<li>3. 送信完了</li>
		</ol>
		<ol class="step_bar step3 tb-hide pc-hide">
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

		<table class="ozn-form-inner">
			<tr data-if="title">
				<th>お問い合わせ種別 <span class="ozn-label required">必須</span></th>
				<td data-insert="title"></td>
			</tr>
			<tr data-if="corporate_name">
				<th>企業名・団体名 <span class="ozn-label optional">任意</span></th>
				<td data-insert="corporate_name"></td>
			</tr>
			<tr data-if="corporate_kana">
				<th>企業名・団体名フリガナ <span class="ozn-label optional">任意</span></th>
				<td data-insert="corporate_kana"></td>
			</tr>
			<tr data-if="customer_name">
				<th>ご担当者様氏名 <span class="ozn-label required">必須</span></th>
				<td data-insert="customer_name"></td>
			</tr>
			<tr data-if="customer_kana">
				<th>ご担当者様フリガナ <span class="ozn-label required">必須</span></th>
				<td data-insert="corporate_kana"></td>
			</tr>
			<tr data-if="email">
				<th>メールアドレス <span class="ozn-label required">必須</span></th>
				<td data-insert="email"></td>
			</tr>
			<tr data-if="tel">
				<th>電話番号 <span class="ozn-label required">必須</span></th>
				<td data-insert="tel"></td>
			</tr>
			<tr data-if="fax">
				<th>FAX番号 <span class="ozn-label optional">任意</span></th>
				<td data-insert="fax"></td>
			</tr>
			<tr>
				<th>ご住所 <span class="ozn-label required">必須</span></th>
				<td>
					<dl>
						<dt data-if="zip-code">郵便番号</dt>
						<dd data-if="zip-code">〒<span data-insert="zip-code"></span></dd>
						<dt data-if="prefecture">都道府県</dt>
						<dd data-if="prefecture"><span data-insert="prefecture"></span></dd>
						<dt data-if="street-address">番地まで</dt>
						<dd><span data-insert="street-address"></span></dd>
						<dt data-if="address-level4">建物名等</dt>
						<dd><span data-insert="address-level4"></span></dd>
					</dl>
				</td>
			</tr>
			<tr data-if="shipping-date">
				<th>ご希望納期 <span class="ozn-label optional">任意</span></th>
				<td><span data-insert="shipping-date"></span> <br class="pc-hide tb-hide">までに必要</td>
			</tr>
			<tr data-if="survey[]">
				<th>チェック項目 <span class="ozn-label optional">任意</span></th>
				<td data-insert="survey[]"></td>
			</tr>
			<tr data-if="materials">
				<th>選択項目 <span class="ozn-label optional">任意</span></th>
				<td data-insert="materials"></td>
			</tr>
			<tr data-if="mail_body">
				<th>お問い合わせ内容 <span class="ozn-label required">必須</span></th>
				<td data-insert="mail_body"></td>
			</tr>
		</table>

		<div class="ozn-form-buttons">
			<a href="./index.php" class="ozn-btn submit">この内容で送信する →</a>
			<a href="./complete.php" class="ozn-btn back">← 戻って書き直す</a>
		</div>

	</div><!-- ozn-form-inner -->

</div>

<?php include('./inc/footer.php'); ?>

</body>
</html>