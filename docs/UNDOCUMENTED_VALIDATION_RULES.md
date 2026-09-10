# マニュアルに記載していない検証ルールについて

## 背景

フォーム設定ファイルの `"validates"` 配列に指定できる検証ルールは、`release/ozn-form/lib/FormValidation.php` の `isValid()` が文字列を解析して `Valitron\Validator::rule()` に渡すことで実現している。

```php
$option = preg_match("/^.+:(.+)$/", $rule, $m) ? $m[1] : null;
$rule   = preg_replace("/:.*$/", '', $rule);
...
$v->rule($rule, $name, $option)->label($label);
```

この実装は、ルール文字列の**最後の `:` より後ろをまるごと1個のスカラー文字列**として扱う。つまり `"lengthMax:300"` のようにパラメータが1つだけのルールは問題なく動作するが、パラメータを複数（配列）要求するルールは、この仕組み経由では正しく機能しない。

一般ユーザー向けマニュアル（ozn-form-docs リポジトリ）には、上記の制約下で問題なく動作し、かつ一般的なフォーム設定で使う可能性が高いルール（`lengthMax` / `lengthMin` / `numeric` / `alpha` / `url` / `date` 系など）のみを掲載している。本ドキュメントは、それ以外の「動くが載せていないルール」「載せても動かないルール」を開発者向けに記録するものである。

## マニュアルに非公開の動作するルール

以下は `"validates"` に指定すれば正しく動作するが、汎用性が低い・使い方に注意が必要（他フィールド名を指定する必要がある、正規表現の知識が必要、など）という理由で、一般ユーザー向けマニュアルには意図的に掲載していない。

実装: `release/ozn-form/vendor/vlucas/valitron/src/Valitron/Validator.php`

| ルール | 設定値例 | 実装メソッド | 挙動 |
|---|---|---|---|
| `regex` | `"regex:/^[0-9]+$/"` | `validateRegex()` | 指定した正規表現(PCRE)に一致する場合のみ許可 |
| `contains` | `"contains:foo"` | `validateContains()` | 指定した文字列を含む場合のみ許可（大文字小文字を区別） |
| `equals` | `"equals:field_name"` | `validateEquals()` | 同じ設定ファイル内の別フィールドと値が一致する場合のみ許可（確認用入力欄などに利用可能） |
| `different` | `"different:field_name"` | `validateDifferent()` | 同じ設定ファイル内の別フィールドと値が異なる場合のみ許可 |
| `accepted` | `"accepted"` | `validateAccepted()` | 値が `yes`/`on`/`1`/`true` のいずれかの場合のみ許可（同意チェックボックス等）。`required` を内包する |
| `creditCard` | `"creditCard"` または `"creditCard:visa"` | `validateCreditCard()` | Luhnアルゴリズムによるクレジットカード番号形式チェック。カードブランド（`visa`/`mastercard`/`amex`/`dinersclub`/`discover`）を1種類だけ指定して絞り込むことも可能 |

## 設定はできても実質的に機能しないルール

以下は `"validates"` に文字列としては書けてしまうが、`FormValidation::isValid()` のパース仕様（パラメータはスカラー1個のみ）では、ライブラリ側が本来要求する複数値・配列パラメータを渡せないため、意図通りに動作しない。ユーザーからの問い合わせやコードレビュー時に「なぜ効かないのか」を都度調査しなくて済むよう、既知の制約として記録する。

実装: `release/ozn-form/vendor/vlucas/valitron/src/Valitron/Validator.php`

| ルール | 実装メソッド | 機能しない理由 |
|---|---|---|
| `lengthBetween` | `validateLengthBetween()` | `$params[0]`（下限）と `$params[1]`（上限）の2つを要求するが、`isValid()` からは `$params[0]` しか渡らないため `$params[1]` が常に未定義になる |
| `in` | `validateIn()` | `$params[0]` に許可値の配列を要求するが、渡されるのは単一の文字列であるため `in_array()` が常に単一要素との比較になる |
| `notIn` | `validateNotIn()`（内部で `validateIn()` を利用） | `in` と同様の理由 |
| `boolean` | `validateBoolean()` | `is_bool($value)` を見ているが、フォームの送信値（`$_POST`）は常に文字列型のため、この形では原理的に真になり得ない |
| `instanceOf` | `validateInstanceOf()` | PHPオブジェクトとの比較を前提としており、フォームの送信値（文字列）を検証する用途には利用できない |

これらのルールを設定ファイル向けに使えるようにする場合は、`FormValidation::isValid()` のパース処理を拡張し、`"ルール名:値1,値2"` のような複数値をパースして配列として渡すよう改修する必要がある。
