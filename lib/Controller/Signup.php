<?php

namespace App\Controller;

class Signup extends \App\Controller{

	public function run(){
		if($this->isLoggedIn()){
			header('Location: ' . SITE_URL);
			exit;
		}

		if($_SERVER['REQUEST_METHOD'] === 'POST'){
			$this->doPost();
		}
	}
	protected function doPost(){
		//トークンチェック
		if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
			echo "Invalid Token!";
			exit;
		}

		//セッションに入力値を保存
		$this->setValues('user_email', $_POST['user_email']);

		//入力値バリデーション
		try{
			$this->_validate();
		}catch(\Exception $e){
			$this->setErrors('message', $e->getMessage());
			return;
		}

		//ユーザー作成
		$userModel = new \App\Model\User();
		try{
			$userModel->create([
				'email' => $_POST['user_email'],
				'password' => $_POST['user_password']
			]);
		}catch(\Exception $e){
			$this->setErrors('message', $e->getMessage());
			return;
		}

		header('Location: ' . SITE_URL . 'login.php');
		exit;

	}

	private function _validate(){
		if(!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)){
			throw new \Exception("Invalid Email!");
		}elseif(!preg_match('/\A[a-zA-Z0-9]+\z/', $_POST['user_password'])){
			throw new \Exception("Invalid Password!");
		}
	}

}