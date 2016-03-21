# loginApp
ソーシャルログインざっくり検証用  
## 機能：  
* 通常ログイン  
* Twitterログイン

## Installation
```
cd twitterapi_sample/
curl -sS https://getcomposer.org/installer | php
php composer.phar install

#npm install -g bower
bower install

```
/config/config.sample.phpを/config/config.phpにリネーム。
中のPDOの接続設定とか、Twitterのコンシューマーキーの設定とかを自分の環境に合わせる


.htaccess有効化しとく必要あり

