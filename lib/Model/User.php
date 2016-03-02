<?php

namespace App\Model;

/**
*
*/
class User extends \App\Model{

	public function create($values){
		try{
			$sql = "INSERT into users(email, password, created, modified) values(:email, :password, now(), now())";
			$stmt = $this->conn->prepare($sql);
			$rs = $stmt->execute([
				':email' => $values['email'],
				':password' => password_hash($values['password'], PASSWORD_DEFAULT)
			]);
			if($rs === false){
				throw new \Exception("error!!");
			}
		}catch(\Exception $e){
			throw $e;
		}

	}
}