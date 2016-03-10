<?php

namespace App;

class Controller{

	private $_values;
	private $_errors;

	public function __construct(){
		//簡易的CSRF対策
		if (!isset($_SESSION['token'])) {
			$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
		}
		//

		$this->_values = new \stdClass();
		$this->_errors = new \stdClass();

	}

	//Accessor for $this->_values
	protected function setValues($key, $value) {
		$this->_values->$key = $value;
	}
	public function getValues($key = '') {
		if($key === ''){
			return $this->_values;
		}else{
			return isset($this->_values->$key) ?  $this->_values->$key : '';
		}
	}
	//

	//Accessor for $this->_errors
	protected function setErrors($key, $value){
		$this->_errors->$key = $value;
	}
	public function getErrors($key){
		return isset($this->_errors->$key) ?  $this->_errors->$key : '';
	}
	//

	public function hasErrors() {
		return !empty(get_object_vars($this->_errors));
	}

	public function isLoggedIn(){
		return isset($_SESSION['user']) && !empty($_SESSION['user']);
	}
}