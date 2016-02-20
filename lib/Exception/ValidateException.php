<?php

namespace App\Exception;

class ValidateException extends \Exception {

  public function __construct($msg = ''){
  	parent::__construct();
  	$this->message = $msg;
  }

}