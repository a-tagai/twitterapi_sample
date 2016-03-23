# login_app
ソーシャルログインざっくり検証用  
## 機能：  
* 通常ログイン  
* Twitterログイン

## Installation
```
cd login_app/
curl -sS https://getcomposer.org/installer | php
php composer.phar install

#npm install -g bower
bower install

```
``/config/config.sample.php``を``/config/config.php``にリネーム。
PDOの接続設定とか、Twitterのコンシューマーキーの設定とかを自分の環境に合わせる


.htaccess有効化しとく必要あり

