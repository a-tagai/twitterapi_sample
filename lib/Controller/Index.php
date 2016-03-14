<?php

namespace App\Controller;

class Index extends \App\Controller{

	public function run(){
		if(!$this->isLoggedIn()){
			header('Location: ' . SITE_URL . 'login.php');
			exit;
		}

		$userModel = new \App\Model\User();
		$this->setValues('users', $userModel->findAll());
	}
}