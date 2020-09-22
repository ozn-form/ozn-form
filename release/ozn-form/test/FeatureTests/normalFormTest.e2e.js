
const fs = require('fs');
const json = JSON.parse(fs.readFileSync(__dirname + '/testUrl.json', 'utf8'));


Object.keys(json.urls).forEach((phpVersion) => {

    let url = json.urls[phpVersion] + '/normal/'; // バックエンドは最新環境（php7.4）で検証する

    /**
     * php7.4 でUIテスト
     */
    describe(phpVersion + ' - UIテスト [お問い合わせサンプル（ノーマル版）]', () => {
        
        beforeAll(async () => {
            await page.goto(url, {waitUntil: 'networkidle2'});
        });


        it('ページ表示', async () => {
            await expect(page.title()).resolves.toMatch('ozn-form Documents - ノーマル');
        });


        it('必須｜ラジオボタン（お問い合わせ種別）入力バリデーション（成功）', async () => {
            await page.click('[data-test-id="titleCheck"]');
            await page.$eval('[data-test-id="titleCheck"]', e => e.blur());
            await page.waitFor(200);
            await expect(page.$eval('[data-test-id="titleValid"]', item => item.classList.contains('ozn-form-valid'))).resolves.toBeTruthy();
        });


        it('必須｜テキストフィールド（お名前）入力バリデーション（失敗）', async () => {
            let targetElem = '[data-test-id="customerName"]';
            await page.type(targetElem, '');
            await page.$eval(targetElem, e => e.blur());
            await page.waitFor(200);
            await expect(page.$eval(targetElem, item => item.classList.contains('ozn-form-invalid'))).resolves.toBeTruthy();

        });


        it('必須｜テキストフィールド（お名前）入力バリデーション（成功）', async () => {
            let targetElem = '[data-test-id="customerName"]';
            await page.type(targetElem, '名前');
            await page.$eval(targetElem, e => e.blur());
            await page.waitFor(200);
            await expect(page.$eval(targetElem, item => item.classList.contains('ozn-form-valid'))).resolves.toBeTruthy();
        });


        it('必須｜テキストフィールド（フリガナ）入力バリデーション（失敗）', async () => {
            let targetElem = '[data-test-id="customerKana"]';
            await page.type(targetElem, '');
            await page.$eval(targetElem, e => e.blur());
            await page.waitFor(200);
            await expect(page.$eval(targetElem, item => item.classList.contains('ozn-form-invalid'))).resolves.toBeTruthy();
            await expect(page.$eval('div.customer_kana.ozn-form-errors', item => item.innerText)).resolves.toMatch('フリガナ を入力してください');
        });

        it('必須｜テキストフィールド（フリガナ）入力バリデーション（文字種/失敗）', async () => {
            let targetElem = '[data-test-id="customerKana"]';
            await page.$eval(targetElem, element => element.value = ''); // フォーム内容をクリア
            await page.type(targetElem, 'kana');
            await page.$eval(targetElem, e => e.blur());
            await page.waitFor(200);
            await expect(page.$eval(targetElem, item => item.classList.contains('ozn-form-invalid'))).resolves.toBeTruthy();
            await expect(page.$eval('div.customer_kana.ozn-form-errors', item => item.innerText)).resolves.toMatch('フリガナ は「ひらがな」か「カタカナ」で入力してください');
        });


        it('必須｜テキストフィールド（フリガナ）入力バリデーション（成功）', async () => {
            let targetElem = '[data-test-id="customerKana"]';
            await page.$eval(targetElem, element => element.value = ''); // フォーム内容をクリア
            await page.type(targetElem, 'なまえ');
            await page.$eval(targetElem, e => e.blur());
            await page.waitFor(200);
            await expect(page.$eval(targetElem, item => item.classList.contains('ozn-form-valid'))).resolves.toBeTruthy();
        });


        it('任意｜テキストフィールド（ご住所:郵便番号）入力バリデーション（未入力/成功）', async () => {
            let targetElem = '[name="zip-code"]';
            await page.$eval(targetElem, element => element.value = ''); // フォーム内容をクリア
            await page.type(targetElem, '');
            await page.$eval(targetElem, e => e.blur());
            await page.waitFor(200);
            await expect(page.$eval(targetElem, item => item.classList.contains('ozn-form-valid'))).resolves.toBeTruthy();
        });


        it('任意｜テキストフィールド（ご住所:郵便番号）入力バリデーション（入力/成功）', async () => {
            let targetElem = '[name="zip-code"]';
            await page.$eval(targetElem, element => element.value = ''); // フォーム内容をクリア
            await page.type(targetElem, '4608501');
            await page.$eval(targetElem, e => e.blur());
            await page.waitFor(500);

            // 入力フィールドが検証成功になっている
            await expect(page.$eval(targetElem, item => item.classList.contains('ozn-form-valid'))).resolves.toBeTruthy();

            // 郵便番号が入力されると「都道府県」「住所」が自動入力されている
            await expect(page.$eval('[name="pref"]', item => item.value)).resolves.toMatch('愛知');
            await expect(page.$eval('[name="address"]', item => item.value)).resolves.toMatch('名古屋市中区三の丸');
        });


        it('任意｜テキストフィールド（ご住所:郵便番号）入力バリデーション（桁数/失敗）', async () => {
            let targetElem = '[name="zip-code"]';
            await page.$eval(targetElem, element => element.value = ''); // フォーム内容をクリア
            await page.type(targetElem, '12345');
            await page.$eval(targetElem, e => e.blur());
            await page.waitFor(200);
            await expect(page.$eval(targetElem, item => item.classList.contains('ozn-form-invalid'))).resolves.toBeTruthy();
            await expect(page.$eval('div.zip-code.ozn-form-errors', item => item.innerText)).resolves.toMatch('郵便番号 の書式が違います。');
        });


        it('必須｜チェックボックス（当社を何で知りましたか）入力バリデーション（失敗）', async () => {
            let targetElem = '[data-test-id="clickSurvey"]';
            await page.click(targetElem); // 一度チェックを入れて...
            await page.click(targetElem); // チェックを外す
            await page.$eval(targetElem, e => e.blur());
            await page.waitFor(200);
            await expect(page.$eval('[data-test-id="checkSurvey"]', item => item.classList.contains('ozn-form-invalid'))).resolves.toBeTruthy();
            await expect(page.$eval('div.survey.ozn-form-errors', item => item.innerText)).resolves.toMatch('当社を何で知りましたか を入力してください');
        });


        it('必須｜チェックボックス（当社を何で知りましたか）入力バリデーション（成功）', async () => {
            let targetElem = '[data-test-id="clickSurvey"]';
            await page.click(targetElem); // 一度チェックを入れる
            await page.$eval(targetElem, e => e.blur());
            await page.waitFor(200);
            await expect(page.$eval('[data-test-id="checkSurvey"]', item => item.classList.contains('ozn-form-valid'))).resolves.toBeTruthy();

            await page.screenshot({ path: __dirname + '/snapshots/'+phpVersion+'_normalForm_入力値検証の最終結果.png', fullPage: true });
        });

        it('未入力項目が存在する場合、フォーム送信時にその項目だけが画面に残り送信エラーになる。', async () => {

            await page.reload({waitUntil: "networkidle0"}); // ページの状態を初期化するため一旦リロードする
            await page.type('[data-test-id="customerName"]', '名前');
            await page.click('button[type="submit"]');
            await page.waitFor(200);

            // 必須項目が残りエラー表示になっている
            await expect(page.$eval('[data-test-id="customerKana"]', item => item.classList.contains('ozn-form-invalid'))).resolves.toBeTruthy();

            // 検証OKの必須項目が非表示になっている
            await expect(page.$eval('[data-oznform-area="customer_name"]', item => window.getComputedStyle(item).display === 'none')).resolves.toBeTruthy();

            // 未入力の任意項目が非表示になっている
            await expect(page.$eval('[data-oznform-area="materials"]', item => window.getComputedStyle(item).display === 'none')).resolves.toBeTruthy();
            await expect(page.$eval('[data-oznform-area="shipping-date"]', item => window.getComputedStyle(item).display === 'none')).resolves.toBeTruthy();

            await page.screenshot({ path: __dirname + '/snapshots/'+phpVersion+'_normalForm_送信エラー時の状態.png', fullPage: true });
        });

        
        it('エラー項目を入力して送信。確認画面が表示される。', async () => {
            
            await page.click('[data-test-id="titleCheck"]');
            await page.type('[data-test-id="customerKana"]', 'なまえ');
            await page.type('[name="zip-code"]', '4608501');
            await page.type('[name="tel"]', '1234567890');
            await page.type('[name="email"]', 'greajib98je34jgjrelasjgreaier@gmail.com');
            await page.type('[name="mail_body"]', '問合せ内容です');
            await page.click('[data-test-id="clickSurvey"]');

            await page.waitFor(500);

            await page.click('button[type="submit"]');
            await page.waitForNavigation();
            
            await expect(page.$('div.ozn-form-container.ozn-form-confirm')).resolves.toBeTruthy();

            await page.screenshot({ path: __dirname + '/snapshots/'+phpVersion+'_normalForm_確認画面の表示.png', fullPage: true });
        });
    });


    describe(phpVersion + ' - 個別機能テスト', () => {

        it('getでパラメータを渡した時、事前に入力した値がある場合には上書きされない', async () => {
            await page.goto(url + '?customer_name=testName', {waitUntil: 'networkidle2'});
            await expect(page.$eval('input[name="customer_name"]', item => item.value)).resolves.toMatch('名前');
        });
        
        it('getでパラメータを渡した場合、特定の項目に初期値として挿入される', async () => {
            await page.deleteCookie({name: 'normal_form'});
            await page.goto(url + '?customer_name=testName', {waitUntil: 'networkidle2'});
            await expect(page.$eval('input[name="customer_name"]', item => item.value)).resolves.toMatch('testName');
        });
        
    });
    
});

