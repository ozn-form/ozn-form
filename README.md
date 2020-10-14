# ozn-form（オゾン・フォーム）

ozn-form（オゾン・フォーム）は、いわゆる「EFO（入力フォーム最適化）」における代表的なセオリーを盛り込んだ、コーポレートサイト向けのPHP製汎用メールフォームです。
基本的なHTMLとCSSの知識があれば、高機能なメールフォームを少ない工数で設置できます。

## ライセンス・ご利用にあたって

- 本製品はシェアウェアとして開発しています。詳細は [ozn-form 製品公式サイト](https://www.ozonenotes.jp/ozn-form/) にてご確認ください。
- プログラム本体は [GPL-3.0 License](https://www.gnu.org/licenses/gpl-3.0.ja.html) に基づき、オープンソースとして公開しています。そのため、製品公式サイトにてご購入をいただかずともプログラムの入手・利用は可能です。
- しかし、フォームの設置マニュアルやサンプルデータなどは、有償にて製品をご購入の方・フォームの設置代行をご依頼の方にのみご提供しています。無償利用の方からのご質問・サポート依頼には応じることができませんのでご了承ください。
- 購入者様・代行設置ご依頼者様には、製品アップデートリリース時にメールにてご案内を差し上げます。
- プルリクエストはどなたでもお気軽にお寄せください。

## 動作要件

- PHP 5.6 以上（PHP 7.4 まで動作確認済み）
- SQLite が使用できること（問い合わせ履歴管理機能ONの場合）
- 動作には jQuery 1.8 以上の読み込みが必要です（1.8 未満は動作対象外）。既存サイトに組み込んで使用する場合は導入済みのライブラリとの競合にご注意ください。

## 変更履歴

#### [v2.6.0] - 2020-10-15

- Changed: 動作要件を PHP 5.6〜7.4.x に変更
- Changed: jQuery の動作要件に v3.x を追加
- Changed: ozn-form/css/ozn-form.min.css のフォントサイズ単位を em による相対指定に変更

#### [v2.5.0] - 2019-08-27

- Added: Google ReCAPTCHA v3 機能を追加
- Added: マニュアルに「連続クリック防止」設定例追記、「その他の活用例・トラブルシューティング等」ページ追加

#### [v2.4.0] - 2019-08-01

- Added: CSRF対策のため、トークン出力機能を追加
- Changed: 内部ライブラリ群のバージョンアップ
- Changed: 動作要件を PHP 5.6.x〜7.3.x に変更

#### [v2.3.1] - 2018-12-20

- Added: 製品マニュアル追加

#### [v2.3.0] - 2018-04-30

- Added: 任意の項目の選択肢によって、管理者宛てメールの送信先を振り分ける機能を追加
- Fixed: iOS11 で、メールアドレス入力欄で日本語キーボード使用時、メールアドレスサジェストを使うと、日本語の未確定文字が残ってしまう問題に対応

#### [v2.2.0] - 2018.01.21

- Added: 客先宛メールが送信失敗した時に表示する専用のエラー画面用ファイルを追加

#### [v2.1.4] - 2017-12-27

- Added: バリデーション条件を追加（メールアドレスで、@が複数入力された場合をエラーに）
- Added: アップロード済みファイル検証関数に日付のチェックを導入
- Fixed: バグフィックス 検証条件のある項目をリアルタイム検証するとき、一部の条件判定でエラーとなっていた部分を修正

#### [v2.1.1] - 2017-12-26

- Added: バリデーション条件を追加（チェックボックスの値に指定地を含むかどうか）
- Fixed: 軽微なバグフィックス

#### [v2.0.0] - 2017-08-07

- Added: 問い合わせ履歴のCSVダウンロード機能を追加
- Added: バーチャルホスト環境でドキュメントルートのパスを指定できるように
- Fixed: 汎用化に伴うリファクタリング、バグフィックス

#### [v1.0] - 2017.03.10

- 基本機能を実装した最初のリリース

## お問い合わせ先

本製品についてのお問い合わせは [ozone notes](https://www.ozonenotes.jp/) にて承ります。

- [特定商取引法に基づく表記](https://www.ozonenotes.jp/ozn-form/guidance.html) 
- [プライバシーポリシー](https://www.ozonenotes.jp/agreement/#privacy)