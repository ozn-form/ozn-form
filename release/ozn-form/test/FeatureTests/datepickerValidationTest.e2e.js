const fs = require('fs');
const json = JSON.parse(fs.readFileSync(__dirname + '/testUrl.json', 'utf8'));
const setTimeout = require("node:timers/promises").setTimeout;

Object.keys(json.urls).forEach((phpVersion) => {
    describe(phpVersion + ' - Datepicker入力時の検証テスト', () => {
        let url = json.urls[phpVersion] + '/normal/';
        let targetElem = '[name="shipping-date"]';

        beforeAll(async () => {
            await page.goto(url, {waitUntil: 'networkidle2'});
        });

        it('Datepicker選択後に未入力エラーが残らない', async () => {
            await page.$eval(targetElem, (element) => {
                // 既存サンプルに必須検証を一時的に付与して再現条件を作る
                window.OznForm.forms['shipping-date'].validates = ['required'];

                const $element = $(element);
                $element.val('');

                // 先に blur で未入力エラーを発生させる
                $element.trigger('blur');

                // Datepicker選択を模擬して値を設定し、closeイベントを実行
                $element.datepicker('setDate', new Date(2026, 4, 26));
                const inst = $element.data('datepicker');
                if (inst && inst.settings && typeof inst.settings.onClose === 'function') {
                    inst.settings.onClose.call(element, $element.val(), inst);
                }
            });

            await setTimeout(400);
            await expect(page.$eval(targetElem, item => item.classList.contains('ozn-form-valid'))).resolves.toBeTruthy();
            await expect(page.$eval(targetElem, item => item.classList.contains('ozn-form-invalid'))).resolves.toBeFalsy();
        });
    });
});
