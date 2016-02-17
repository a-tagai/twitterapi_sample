<?php

/*
App\Controller
-> lib/Controller.php

App\Controller\Index
-> lib/Controller/Index.php
*/

spl_autoload_register(function($class) {
  $prefix = 'App\\';
  if (strpos($class, $prefix) === 0) {
    $className = substr($class, strlen($prefix));
    $classFilePath = __DIR__ . '/../lib/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($classFilePath)) {
      require $classFilePath;
    }
  }
});