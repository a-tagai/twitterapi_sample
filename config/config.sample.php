<?php

ini_set('display_errors', 1);


define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/twitterapi_sample/');

//twitterAPI settings
define('TWITTER_CONSUMER_KEY','*******');
define('TWITTER_CONSUMER_SECRET','*******');
define('TWITTER_CAKKBACK_URL',SITE_URL . '/authTwitter.php');
//

//database settings
define('DNS', 'mysql:dbhost=localhost;dbname=loginApp');
define('DB_USERNAME','*******');
define('DB_PASSWORD','*******');
//




