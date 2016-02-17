<?php

namespace App;

class Controller{
	protected function isLoggedIn(){
		return isset($_SESSION['member']) && !empty($_SESSION['member']);
	}
}