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

	public function login($values){
		try{
			$sql = "SELECT * FROM users WHERE email = :email";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute([
				':email' => $values['email']
			]);
			$stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
			$user = $stmt->fetch();

			if(empty($user)){
				throw new \Exception("ユーザーが存在しません。");
			}
			if(!password_verify($values['password'], $user->password)){
				throw new \Exception("パスワードが一致しません。");
			}
			return $user;
		}catch(\Exception $e){
			throw $e;
		}
	}

}