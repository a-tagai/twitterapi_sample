<?php

namespace App\Controller;

class Signup extends \App\Controller{

	public function run(){
		if($this->isLoggedIn()){
			header('Location: ' . SITE_URL);
			exit;
		}

		if($_SERVER['REQUEST_METHOD'] === 'POST'){
			//トークンチェック
			if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
				echo "Invalid Token!";
				exit;
			}

			//入力値バリデート
			try{
				$this->_validate();
			}catch(\App\Exception\ValidateException $e){
				$this->setErrors('message', $e->getMessage());
			}

			$this->setValues('user_email', $_POST['user_email']);

			if($this->hasErrors()){
				return;
			}else{
				//ユーザー作成
				//リダイレクト
			}

			//リダイレクト

		}
	}

	private function _validate(){
		if(!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)){
			throw new \App\Exception\ValidateException('Invalid Email!');
		}
		if(!preg_match('/\A[a-zA-Z0-9]+\z/', $_POST['user_password'])){
			throw new \App\Exception\ValidateException('Invalid Password!');
		}

	}
}