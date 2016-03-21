<?php

namespace App\Exception;

/**
 *PDOStatement::execute()の実行失敗時のエラーを、例外として投げたい時に使用する
 */
class StmtExecuteException extends \Exception {
  function __construct($erroInfo){
    $this->message = $erroInfo[2];//ドライバ固有のエラーメッセージ
    $this->code = $erroInfo[1];//ドライバ固有のエラーコード
  }
}