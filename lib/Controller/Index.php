<?php

namespace App\Controller;

class Index extends \App\Controller{

	public function run(){
		if(!$this->isLoggedIn()){
			header('Location: ' . SITE_URL . 'login.php');
			exit;
		}
	}
}