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

		//Viewの入力項目値の維持用
		$this->setValues('user_email', $_POST['user_email']);

		//入力値バリデーション
		if(!$this->_isValidate()){
			$this->setErrors('message', '無効な入力値です');
			return;
		}

		//ユーザー作成
		$userModel = new \App\Model\User();
		$user = $userModel->create([
			'email' => $_POST['user_email'],
			'password' => $_POST['user_password']
		]);

		if($user){
			header('Location: ' . SITE_URL . 'login.php');
			exit;
		}else{
			$this->setErrors('message', '新規アカウントの作成に失敗しました。既に登録されている可能性があります。');
			return;
		}

	}

	private function _isValidate(){
		if(!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)){
			return false;
		}elseif(!preg_match('/\A[a-zA-Z0-9]+\z/', $_POST['user_password'])){
			return false;
		}else{
			return true;
		}
	}

}