<?php

namespace App\Exception;

class ValidateException extends \Exception {
  protected $message = '無効な値です。';
}