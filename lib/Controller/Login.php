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
		try{
			$this->_validate();
		}catch(\App\Exception\ValidateException $e){
			$this->setErrors('message', $e->getMessage());
			return;
		}

		//ログイン処理
		try{
			$this->_login();
		}catch(\App\Exception\UnmatchUserException $e){
			$this->setErrors('message', $e->getMessage());
			return;
		}

		header('Location: ' . SITE_URL);
		exit;
	}

	private function _login(){
		$userModel = new \App\Model\User();
		try{
			$user = $userModel->findUser([
				'email' => $_POST['user_email'],
				'password' => $_POST['user_password']
			]);
		}catch(\App\Exception\UnmatchUserException $e){
			throw $e;
			return;
		}
		session_regenerate_id(true);
		$_SESSION["user"] = $user;
	}

	private function _validate(){
		if(!isset($_POST['user_email']) || $_POST['user_email'] === ''){
			throw new \App\Exception\ValidateException("無効なメールアドレスです");
		}elseif(!isset($_POST['user_password']) || $_POST['user_password'] === ''){
			throw new \App\Exception\ValidateException("無効なパスワードです");
		}
	}
}