<?php

namespace App\Exception;

class UnmatchUserException extends \Exception {
  protected $message = 'ユーザーが存在しません。';
}