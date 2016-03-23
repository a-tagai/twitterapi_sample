<?php
namespace App;

class Model{
	protected $conn;

	public function __construct(){
		try{
			$this->conn = new \PDO(DNS, DB_USERNAME, DB_PASSWORD);
		}catch(\PDOException $e){
			echo $e->getMessage();
			exit;
		}
	}

}