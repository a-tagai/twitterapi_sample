<?php

namespace App\Controller;

class Login extends \App\Controller{

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

		//Viewの入力項目値の維持用
		$this->setValues('user_email', $_POST['user_email']);

		//入力値バリデーション
		if(!$this->_isValidate()){
			$this->setErrors('message', '無効な値です');
			return;
		}


		//ログイン処理
		if($this->_login()){
			header('Location: ' . SITE_URL);
			exit;
		}else{
			$this->setErrors('message', 'ログインに失敗しました');
			return;
		}

	}

	private function _login(){
		$userModel = new \App\Model\User();
		$user = $userModel->findUser([
			'email' => $_POST['user_email'],
			'password' => $_POST['user_password']
		]);
		if($user){
			session_regenerate_id(true);
			$_SESSION["user"] = $user;
			return true;
		}else{
			return false;
		}

	}

	private function _isValidate(){
		if(!isset($_POST['user_email']) || $_POST['user_email'] === ''){
			return false;
		}elseif(!isset($_POST['user_password']) || $_POST['user_password'] === ''){
			return false;
		}else{
			return true;
		}
	}
}