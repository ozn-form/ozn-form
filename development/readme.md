# ozn-form 開発環境構築手順

開発/テスト環境構築のための手順を記載します。開発環境はMacで構築することを前提としています。

[TOC]



## 1. サーバ証明書の用意

### 1.1 サンプル証明書を使う

`development/docker-compose.d/sampleCerts/*`の crt & keyファイルを `development/docker-compose.d/certs/`へコピーする。HTTPS接続時にブラウザで証明書エラーが出るが無視してアクセスする。

### 1.2 mkcertで用意する（任意）

Homebrewでmkcertをインストールする。Homebrew環境の説明は省略。

```
$ brew install mkcert
```

認証局を作成

```
mkcert -install
```

ワイルドカードSSL証明書を発行

```
mkcert "*.ozn-form.com"
```

生成ファイルをリネーム

```
mv _wildcard.ozn-form.com-key.pem ozn-form.com.key
mv _wildcard.ozn-form.com.pem ozn-form.com.crt 
```

上記、2つのファイルを `DevServer/docker-compose.d/certs/` へ移動させて完了。



## 2. Hostsファイルへの追記

下記エントリをhostsファイルへ追記します。

```
127.0.0.1 php56.ozn-form.com, php71.ozn-form.com, php73.ozn-form.com, php74.ozn-form.com
```



## 3. Docker UP

`development` ディレクトリへ移動して下記コマンドでdocker環境を作成します。docker環境セットアップの説明は省略します。

```
docker-compose up -d
```



## 4. URL

| php5.6 環境 | https://php56.ozn-form.com/ |
| ----------- | --------------------------- |
| php7.1 環境 | https://php71.ozn-form.com/ |
| php7.3 環境 | https://php73.ozn-form.com/ |
| php7.4 環境 | https://php74.ozn-form.com/ |

