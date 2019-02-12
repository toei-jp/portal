# toei-jp/portal

東映ポータルサイト

## Docker

ローカル環境としてDockerが利用できます。

※現状では開発環境としての利用のみを想定

web: http://localhost:8000/

### コマンド例

コンテナを作成し、起動する。

```sh
$ docker-compose up
```

## その他

### PHP CodeSniffer

```sh
vendor/bin/phpcs --standard=phpcs.xml
```
