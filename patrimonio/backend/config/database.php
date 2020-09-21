<?php
class DatabaseService {

	private $db_host = "localhost";
	private $db_name = "db_academia";
	private $db_user = "postgres";
	private $db_password = "1234";
	private $connection;
		
	public function getConnection(){
		//$this->$connection = null;
		
		try{
			$this->connection = new PDO("pgsql:host=" . $this->db_host . ";dbname=" . $this->db_name, $this->db_user, $this->db_password);
		}catch(PDOException $exception){
			echo "Falha na conexão: " . $exception->getMessage();
		}	
		return $this->connection;
	}

}
?>