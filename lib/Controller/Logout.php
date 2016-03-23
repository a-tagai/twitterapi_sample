<?php

namespace App\Controller;

class Logout extends \App\Controller{

	public function run(){

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

		$this->_logout();

		header('Location: ' . SITE_URL);
		exit;
	}

	private function _logout(){
		$_SESION = [];
		if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time() - 86400, '/');
		}
		session_destroy();
	}
}