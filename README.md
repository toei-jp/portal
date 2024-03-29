# toei-jp/portal

![Test](https://github.com/toei-jp/portal/workflows/Test/badge.svg)

東映ポータルサイト

## システム要件

- PHP: 7.4
- MySQL: 5.7
- Google App Engine
- Azure Blob Storage

## EditorConfig

[EditorConfig](https://editorconfig.org/) でコーディングスタイルを定義しています。

利用しているエディタやIDEにプラグインをインストールしてください。

[Download a Plugin](https://editorconfig.org/#download)

## Docker

ローカル環境としてDockerが利用できます。

※ [Docker](https://www.docker.com/)をインストールしてください。

※ 現状では開発環境としての利用のみを想定してます。

※ データベース、ストレージについてはCMSアプリケーションのドキュメントを参照してください。

web: https://localhost:8010/

### docker-compose コマンド例

コンテナを作成し、起動する。

```sh
$ docker-compose up
```

## アプリケーション コマンド

```sh
$ php bin/console help
```

### viewキャッシュ削除

```sh
$ php bin/console cache:clear:view
```

## その他 コマンド

### PHP Lint

```sh
$ composer phplint
```

### PHP CodeSniffer

```sh
$ composer phpcs
```

### PHPStan

```sh
$ composer phpstan
```

### PHPUnit

```sh
$ composer phpunit
```
