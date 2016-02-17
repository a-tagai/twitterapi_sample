<?php

require_once(__DIR__ . '/../config/config.php');

$app = new App\Controller\Index();
$app->run();
