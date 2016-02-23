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

			if($this->_validate()){
				//ユーザー作成
				//リダイレクト
			}else{
				$this->setValues('user_email', $_POST['user_email']);
				return;
			}

		}
	}

	private function _validate(){
		if(!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)){
			$this->setErrors('message', 'Invalid Email!');
		}elseif(!preg_match('/\A[a-zA-Z0-9]+\z/', $_POST['user_password'])){
			$this->setErrors('message', 'Invalid Password!');
		}

		return $this->hasErrors() ? false : true;
	}
}