
const fs = require('fs');
const json = JSON.parse(fs.readFileSync(__dirname + '/testUrl.json', 'utf8'));
const setTimeout = require("node:timers/promises").setTimeout;


Object.keys(json.urls).forEach((phpVersion) => {

    /**
     * php7.4 でUIテスト
     */
    describe(phpVersion + ' - UIテスト [ozn-form SampleForm - 画像添付]', () => {

        let url = json.urls[phpVersion] + '/image/'; // バックエンドは最新環境（php7.4）で検証する

        beforeAll(async () => {
            await page.goto(url, {waitUntil: 'networkidle2'});
        });
        
        it('ページ表示', async () => {
            await expect(page.title()).resolves.toMatch('ozn-form SampleForm - 画像添付');
        });

        it('アップロードファイルの削除', async () => {

            // get the ElementHandle of the selector above
            const inputUploadHandle = await page.$('input[type=file]');
            let fileToUpload = __dirname + '/data/attachment1.jpg';

            await inputUploadHandle.uploadFile(fileToUpload);

            await setTimeout(500);
            
            // アップロード後のサムネイル表示ができるか
            await expect(page.$('span.oznform-uploaded-thumbnail img')).resolves.toBeTruthy();
            await expect(page.$('span.oznform-uploaded-filename')).resolves.toBeTruthy();
            
            await page.click('button.oznform-delete-file')

            await setTimeout(500);


            // アップロード後のサムネイル表示が削除されているか
            await expect(page.$('span.oznform-uploaded-thumbnail img')).resolves.toBeFalsy();
            await expect(page.$('span.oznform-uploaded-filename')).resolves.toBeFalsy();


        }, 10000);

        it('ファイルアップロード後、確認画面が正しく表示されるか', async () => {
            await page.type('[name="customer_name"]', '名前');
            await page.type('[name="customer_kana"]', 'なまえ');
            await page.type('[name="email"]', 'greajib98je34jgjrelasjgreaier@gmail.com');
            await page.$eval('[name="email"]', e => e.blur());

            // get the ElementHandle of the selector above
            const inputUploadHandle1 = await page.$('#oznform-upform1');
            const inputUploadHandle2 = await page.$('#oznform-upform2');
            let fileToUpload = __dirname + '/data/attachment1.jpg';
            
            await inputUploadHandle1.uploadFile(fileToUpload);
            await inputUploadHandle2.uploadFile(fileToUpload);

            await setTimeout(750);
            
            // アップロード後のサムネイル表示ができるか
            await expect(page.$('span.oznform-uploaded-thumbnail img')).resolves.toBeTruthy();
            await expect(page.$('span.oznform-uploaded-filename')).resolves.toBeTruthy();
            
            await page.screenshot({ path: __dirname + '/snapshots/'+phpVersion+'_ファイルアップロード.png', fullPage: true });
            
            await page.click('button[type="submit"]');
            await setTimeout(500);

            await expect(page.$eval('[data-insert="attachment1[]"]', item => RegExp("^attachment1.*.jpg$").test(item.innerText))).resolves.toBeTruthy();
            
        }, 10000);
    });
});

