<?php

require_once(__DIR__ . '/../lib/Core/head.php');

$app = new App\Controller\AuthTwitter();
$app->run();
