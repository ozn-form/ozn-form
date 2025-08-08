# Datepicker設定機能

jQuery UI Datepickerのオプション値をフォーム設置ページのJSONファイルから指定できる機能です。

## 使用方法

### 基本的な設定

フォーム設定のJSONファイルで、対象のフィールドに `datepicker_options` を追加します：

```json
{
    "pages": {
        "index": {
            "role": "form",
            "forms": {
                "delivery-date": {
                    "label": "お届け希望日",
                    "datepicker_options": {
                        "dateFormat": "yy年mm月dd日",
                        "minDate": 0,
                        "maxDate": "+1Y"
                    }
                }
            }
        }
    }
}
```

### HTMLでの使用

HTMLでは従来通り `data-of_datepicker` 属性を指定するだけです：

```html
<input type="text" name="delivery-date" data-of_datepicker="true" class="form-control">
```

## 設定例

### 1. 日本語フォーマット

```json
"date-field": {
    "label": "日付",
    "datepicker_options": {
        "dateFormat": "yy年mm月dd日"
    }
}
```

### 2. 日付範囲の制限

```json
"future-date": {
    "label": "未来の日付",
    "datepicker_options": {
        "dateFormat": "yy/mm/dd",
        "minDate": 0,           // 今日以降
        "maxDate": "+1Y"        // 1年後まで
    }
}
```

### 3. 月・年選択ドロップダウン

```json
"birth-date": {
    "label": "生年月日",
    "datepicker_options": {
        "dateFormat": "yy/mm/dd",
        "changeMonth": true,
        "changeYear": true,
        "yearRange": "1900:2030"
    }
}
```

### 4. 複数月表示

```json
"period-start": {
    "label": "期間開始日",
    "datepicker_options": {
        "dateFormat": "yy-mm-dd",
        "numberOfMonths": 3,
        "showButtonPanel": true
    }
}
```

### 5. 特定の曜日を無効化

```json
"weekday-only": {
    "label": "平日のみ",
    "datepicker_options": {
        "dateFormat": "yy/mm/dd",
        "beforeShowDay": "$.datepicker.noWeekends"
    }
}
```

## 利用可能なオプション

jQuery UI Datepickerの全てのオプションが使用可能です。主要なものは以下の通りです：

### 日付フォーマット
- `dateFormat`: 日付の表示形式（例：`"yy年mm月dd日"`, `"yy/mm/dd"`）

### 日付制限
- `minDate`: 選択可能な最小日付（例：`0` = 今日、`"+1w"` = 1週間後）
- `maxDate`: 選択可能な最大日付（例：`"+1Y"` = 1年後）

### 表示設定
- `changeMonth`: 月選択ドロップダウンを表示（`true`/`false`）
- `changeYear`: 年選択ドロップダウンを表示（`true`/`false`）
- `yearRange`: 年の選択範囲（例：`"1900:2030"`）
- `numberOfMonths`: 表示する月数（例：`3`）
- `showButtonPanel`: ボタンパネルを表示（`true`/`false`）

### アニメーション
- `showAnim`: 表示アニメーション（例：`"slideDown"`, `"fadeIn"`）
- `duration`: アニメーション時間（例：`"fast"`, `"slow"`, `500`）

## 後方互換性

`datepicker_options` が設定されていないフィールドは、従来通りデフォルト設定で動作します。
既存のフォームに影響を与えることなく、必要な部分のみカスタマイズ可能です。

## デモ

`/samples/datepicker_demo/` に様々な設定例があります。

## 詳細な設定オプション

jQuery UI Datepickerの公式ドキュメントを参照してください：
https://api.jqueryui.com/datepicker/