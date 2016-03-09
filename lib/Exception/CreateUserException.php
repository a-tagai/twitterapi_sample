<?php

namespace App\Exception;

class CreateUserException extends \Exception {
  protected $message = '新規ユーザーの作成に失敗しました。';
}