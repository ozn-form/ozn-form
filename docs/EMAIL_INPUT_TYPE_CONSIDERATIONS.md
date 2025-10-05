# メールアドレス入力フィールドのtype属性とドメインサジェスト機能の両立について

## 問題の概要

メールアドレス入力フィールドに対して、以下の2つの要件があります：

1. **アクセシビリティ向上**: `type="email"` を使用することで、セマンティックHTMLとしての意味が明確になり、スクリーンリーダーの対応が向上する（WCAG 2.1 Level A 準拠）
2. **ドメインサジェスト機能**: 本プロダクトが提供するカスタムドメイン補完機能の提供

しかし、`type="email"` を使用すると、ブラウザ標準のオートコンプリート機能とカスタムドメインサジェスト機能の表示UIが競合する可能性があります。

## 競合の詳細

### ブラウザのオートコンプリート動作

- Chrome、Firefox、Safariなどの主要ブラウザは、`type="email"` の入力欄に対して、過去に入力されたメールアドレスを自動補完候補として表示します
- この候補リストは、ブラウザネイティブのUIとして、入力フィールドの下部に表示されます
- z-indexが非常に高い値（通常10000以上）で表示されるため、通常のWebページのコンテンツより前面に表示されます

### カスタムドメインサジェスト機能

- 本プロダクトの `domain_suggest.js` は、`@` 記号の後に入力されたテキストに基づいて、一般的なメールドメイン（gmail.com、yahoo.co.jpなど）を候補として表示します
- `.ozn-form-suggest` クラスの要素として、`position: absolute` と `z-index: 1000` で表示されます
- ユーザー体験として、ドメイン部分の入力を簡素化することを目的としています

### 競合の発生

両方のサジェスト機能が同時に表示されると：

1. **視覚的な重なり**: ブラウザのオートコンプリートが上に表示され、カスタムサジェストが隠れる、または両方が重なって表示される
2. **操作性の問題**: ユーザーがどちらのサジェストを選択すべきか混乱する
3. **キーボード操作の競合**: 矢印キーでの選択が期待通りに動作しない可能性

## 解決方法

### Option 1: autocomplete="off" の使用（現在の実装）

**実装内容:**
```html
<input type="text" name="email" data-domain-suggest="true" ... >
```

JavaScriptで動的に `autocomplete="off"` を設定：
```javascript
$target.attr('autocomplete', 'off');
```

**メリット:**
- ブラウザのオートコンプリートを無効化し、カスタムサジェストのみを表示
- シンプルで確実な動作

**デメリット:**
- `type="text"` のため、アクセシビリティの観点では `type="email"` より劣る
- モバイルデバイスでメール用キーボード（@キー付き）が自動表示されない場合がある
- 一部のブラウザ（特に新しいバージョンのChrome）では、`autocomplete="off"` が完全に無視される場合がある

### Option 2: type="email" + autocomplete="off" の併用

**実装内容:**
```html
<input type="email" name="email" autocomplete="off" data-domain-suggest="true" ... >
```

**メリット:**
- アクセシビリティが向上（セマンティックHTML）
- モバイルでメール用キーボードが表示される
- スクリーンリーダーでの識別が改善

**デメリット:**
- ブラウザによっては `autocomplete="off"` が無視され、オートコンプリートが表示される場合がある
- z-indexの調整が必要になる可能性

### Option 3: type="text" + inputmode="email" の使用

**実装内容:**
```html
<input type="text" inputmode="email" name="email" autocomplete="off" data-domain-suggest="true" ... >
```

**メリット:**
- ブラウザのオートコンプリートを回避しながら、モバイルでメール用キーボードを表示
- カスタムサジェストが確実に動作
- `autocomplete="off"` が無視されるリスクが低い

**デメリット:**
- `type="email"` ほどセマンティックではない
- スクリーンリーダーでの識別が `type="email"` より劣る場合がある

### Option 4: z-indexの大幅な増加

**実装内容:**
```css
.ozn-form-suggest {
  z-index: 99999; /* ブラウザのオートコンプリートより高い値 */
}
```

**メリット:**
- `type="email"` を使用しながら、カスタムサジェストを前面に表示

**デメリット:**
- ブラウザによってオートコンプリートのz-indexが異なるため、確実な動作が保証されない
- 両方のサジェストが表示され、ユーザーが混乱する可能性が残る

## 推奨アプローチ

### プロジェクトの現状と推奨

本プロジェクトでは、以下の理由から **Option 1（現在の実装を維持）** または **Option 3（type="text" + inputmode="email"）** を推奨します：

1. **カスタムサジェスト機能の優先**: 本プロダクトの主要機能であるドメインサジェストを確実に動作させることが重要
2. **ブラウザ互換性**: `autocomplete="off"` の無視問題を回避
3. **ユーザー体験**: 複数のサジェストUIが表示されることによる混乱を回避

### Option 3 の実装を追加提案

現在の実装（`type="text"`）に加えて、`inputmode="email"` を追加することで、アクセシビリティとユーザビリティの両立を図ることができます：

```html
<input type="text" inputmode="email" name="email" data-domain-suggest="true" 
       style="ime-mode:inactive;" class="ozn-input" 
       placeholder="例）yamada@example.com">
```

この変更により：
- モバイルデバイスでメール用キーボードが表示される
- ブラウザのオートコンプリートを回避
- カスタムサジェストが確実に動作
- アクセシビリティが向上（inputmode属性によるヒント）

## ブラウザ互換性の確認

### autocomplete="off" の動作

| ブラウザ | バージョン | autocomplete="off"の動作 | 備考 |
|---------|-----------|------------------------|------|
| Chrome | 88+ | 一部無視される場合がある | パスワード入力以外では無視されることが多い |
| Firefox | 85+ | ほぼ尊重される | 設定による |
| Safari | 14+ | ほぼ尊重される | |
| Edge | 88+ | Chromiumベースのため、Chromeと同様 | |

### inputmode="email" のサポート

| ブラウザ | バージョン | サポート状況 |
|---------|-----------|------------|
| Chrome | 66+ | サポート |
| Firefox | 95+ | サポート |
| Safari | 12.2+ | サポート |
| Edge | 79+ | サポート |

## まとめ

type="email" とドメインサジェスト機能の両立は、ブラウザのオートコンプリート動作の制御が難しいため、完全な解決は困難です。

**現実的な対応:**

1. **現在の実装を維持** (`type="text"` + `autocomplete="off"`)
2. **推奨改善**: `inputmode="email"` 属性を追加してモバイルUXを向上
3. **z-indexの調整**: 万が一ブラウザのオートコンプリートが表示された場合でも、カスタムサジェストが見えるように z-index を高めに設定（9999など）
4. **ドキュメント化**: 本ドキュメントをプロジェクトに追加し、将来のメンテナンス時の参考とする

この問題は、WebフォームのアクセシビリティとカスタムUI機能のトレードオフという、より広範な課題の一例です。プロジェクトの目的（EFO機能の提供）を優先しつつ、可能な範囲でアクセシビリティを向上させるアプローチが現実的です。

## 参考資料

- [WCAG 2.1 - 4.1.2 Name, Role, Value](https://www.w3.org/WAI/WCAG21/Understanding/name-role-value.html)
- [MDN - input type="email"](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/email)
- [MDN - inputmode attribute](https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/inputmode)
- [HTML Standard - autocomplete attribute](https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#autofilling-form-controls:-the-autocomplete-attribute)
