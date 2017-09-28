<?php
    // 設定ファイルのパスを設定
    $config_path = dirname(__FILE__) . '/' . 'ozn-config.json';
    // OznForm 実行ファイル読み込み
    require '../release/ozn-form.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>ozn-form 導入についてのお問い合わせ - STEP01</title>
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
        <h1>導入についてのお問い合わせ</h1>
    </div>

    <div class="ozn-form-stepbar-wrapper">
        <ol class="ozn-form-stepbar step3 sp-hide">
            <li class="current">1. 内容の入力</li>
            <li>2. 内容確認</li>
            <li>3. 送信完了</li>
        </ol>
        <ol class="ozn-form-stepbar step3 tb-hide pc-hide">
            <li class="current">入力</li>
            <li>確認</li>
            <li>完了</li>
        </ol>
        <p>本フォームから送信した段階では購入は確定いたしません。送信後、担当者からのご連絡をお待ちください。</p>
    </div>

    <div class="ozn-form-container">
        <form action="./confirm.php" method="post">

            <div class="ozn-form-inner">
                <div class="tr" data-oznform-area="title">
                    <div class="th">ご希望の導入方法 <span class="ozn-label required">必須</span></div>
                    <div class="td">
                    <div class="ozn-check vertical">
                        <label>
                            <input type="radio" name="title" value="設置代行: 標準テンプレートで設置">
                            設置代行: 標準テンプレートで設置
                        </label>
                        <label>
                            <input type="radio" name="title" value="設置代行: デザインカスタマイズあり">
                            設置代行: デザインカスタマイズあり
                        </label>
                        <label>
                            <input type="radio" name="title" value="設置代行なし: 製品マニュアルあり">
                            設置代行なし: 製品マニュアルあり
                        </label>
                    </div>
                    <div class="title-error"></div>
                    </div>
                </div>
                <div class="tr" data-oznform-area="corporate_name">
                    <div class="th">企業名・団体名 <span class="ozn-label optional">任意</span></div>
                    <div class="td">
                        <input type="text" name="corporate_name" class="ozn-input" data-autoruby="corporate_name" placeholder="例）sample株式会社" autocomplete="organization">
                        <p class="ozn-notice">個人のお客様の場合は入力不要です。</p>
                    </div>
                </div>
                <div class="tr" data-oznform-area="corporate_kana">
                    <div class="th">企業名・団体名フリガナ <span class="ozn-label optional">任意</span></div>
                    <div class="td">
                        <input type="text" name="corporate_kana" class="ozn-input" data-autoruby-katakana="corporate_name" placeholder="例）サンプルカブシキガイシャ" autocomplete="">
                    </div>
                </div>
                <div class="tr" data-oznform-area="customer_name">
                    <div class="th">ご担当者様氏名 <span class="ozn-label required">必須</span></div>
                    <div class="td">
                        <input type="text" name="customer_name" class="ozn-input" id="customer_name" data-autoruby="customer_name" placeholder="例）山田 太郎" autocomplete="name">
                    </div>
                </div>
                <div class="tr" data-oznform-area="customer_kana">
                    <div class="th">ご担当者様フリガナ <span class="ozn-label required">必須</span></div>
                    <div class="td">
                        <input type="text" name="customer_kana" class="ozn-input" id="customer_kana" data-autoruby-katakana="customer_name" placeholder="例）ヤマダ タロウ" autocomplete="">
                    </div>
                </div>
                <div class="tr" data-oznform-area="email">
                    <div class="th">メールアドレス <span class="ozn-label required">必須</span></div>
                    <div class="td">
                        <div class="ozn-form-suggest-wrapper">
                            <input data-domain-suggest="true" type="email" name="email" style="ime-mode:inactive;" class="ozn-input" placeholder="例）yamada@example.com">
                        </div>
                    </div>
                </div>

                <div class="tr"  data-oznform-area="mail_body">
                    <div class="th">お問い合わせ内容 <span class="ozn-label optional">任意</span></div>
                    <div class="td">
                        <textarea name="mail_body" rows="10" class="ozn-input" placeholder="導入予定のサイトの情報などあればご入力ください。"></textarea>
                    </div>
                </div>
            </div>

            <div class="privacy-wrapper">
                <h2>個人情報の取り扱いについて</h2>
                <div class="privacy-inner">
                    <p>ozone notes（以下、当事務所）では、個人情報の保護に関する法律を遵守し、個人情報の適切な取り扱いと保護に努めます。</p>
                    <h3>個人情報の収集および利用目的</h3>
                    <p>当事務所では、個人情報の保護に関する法律に基づき、お客様およびご依頼案件に関する個人情報を、下記利用目的の達成に必要な範囲で利用いたします。</p>
                    <ul>
                    <li>Webコンテンツ制作のため</li>
                    <li>お問い合わせ等へのご返答のため</li>
                    <li>見積書・納品書・請求書等の発送のため</li>
                    <li>その他、随時お客様への連絡のため</li>
                    </ul>
                    <h3>個人情報の第三者への提供及び二次使用について</h3>
                    <p>当方では以下の場合において、お預かりした個人情報を第三者へ提供する場合があります。</p>
                    <ul>
                    <li>情報提供者本人の同意がある場合</li>
                    <li>法令に基づき公的機関から情報開示の要請があった場合</li>
                    <li>人命または財産の保護のために必要であり、直ちに本人の同意を得る事が困難である場合</li>
                    <li>お客様の商品発送を請け負う運送業者および当事務所からの委託を受けて業務を行うパートナー会社が情報を必要とする場合</li>
                    <li>ご提供者個人を特定できない状態で開示する場合</li>
                    </ul>
                    <p>上記のいずれかに該当する場合を除き、お客様の承諾無しにお預かりした個人情報を第三者に提供・開示することはございません。</p>
                    <h3>Cookie利用について</h3>
                    <p>当サイトではファーストパーティcookieにより匿名のトラフィックデータを収集しています。<br />
                    収集したデータはマーケティングやSEO等、当事務所業務の品質向上のための分析に利用いたしますが、個人を特定・識別することはいたしません。</p>
                    <h3>個人情報の安全管理について</h3>
                    <p>お客様よりお預かりした個人情報の安全管理は、合理的、組織的、物理的、人的、技術的施策を講じるとともに、当社では関連法令に準じた適切な取扱いを行うことで個人データへの不正な侵入、個人情報の紛失、改竄、漏洩等の危険防止に努めます。</p>
                    <h3>個人情報の訂正、削除について</h3>
                    <p>お客様ご本人の要請があった場合、ご本人を確認した上で個人情報の訂正、削除を適切に行います。</p>
                    <h3>プライバシーポリシーの変更について</h3>
                    <p>プライバシーポリシーの変更を行う際は、当ページへの掲載をもって公表とさせていただきます。</p>
                    <h3>個人情報保護に関するお問い合わせ</h3>
                    <p>個人情報保護に関するお問い合わせや開示、修正、削除のご依頼がある場合は、お問い合わせフォームよりご連絡ください。</p>
                    <p style="text-align: right;">2011年4月1日制定</p>
                    <p style="text-align: right;">2013年7月1日改訂</p>
                </div>
            </div>

            <div class="ozn-form-inner">
                <div class="tr">
                    <div class="th">個人情報取り扱いへの同意 <span class="ozn-label required">必須</span></div>
                    <div class="td">
                        <div class="ozn-check vertical">
                            <label>
                                <input name="privacy" type="checkbox"> 個人情報の取り扱いに同意する
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="privacy-error"></div>

            <div class="ozn-form-buttons">
                <button type="submit" class="ozn-btn ozn-form-nav submit">入力内容の確認へ進む →</button>
            </div>

        </form>
    </div><!-- ozn-form-inner -->


</div>

<?php include('./inc/footer.php'); ?>

</body>
</html>
