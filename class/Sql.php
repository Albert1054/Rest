<?php 

class Sql extends PDO{

	private $conn;

	public function __construct($conexao = array()){
		try{
			$this->conn = new PDO($conexao[0],$conexao[1],$conexao[2]);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e){
			throw new PDOException("Error ao conectar: ", $e->getMessage(),$e->getLine());
			
		}	

	}

	private function setParams($stmt,$params = array()){
		foreach ($params as $key => $value) {
			$this->setParam($stmt,$key,$value);
		}
	}

	private function setParam($stmt,$key,$value){
		$stmt->bindParam($key,$value);
	}

	public function querys($rawQuery, $params = array()){
		try{
			$stmt = $this->conn->prepare($rawQuery);
			$this->setParams($stmt,$params);
			$stmt->execute();
			return $stmt;
		}catch(PDOException $e){
			throw new PDOException("Error : ". $e->getMessage()." Linha: ".$e->getLine());
			
		}
	}

	public function select($rawQuery, $params = array()):array{
		$stmt = $this->querys($rawQuery,$params);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function procedure($rawQuery, $params = array()){
		try{
			$stmt = $this->conn->prepare($rawQuery);
			$this->setParams($stmt,$params);
			$stmt->execute();
		}catch(PDOException $e){
			throw new PDOException("Error : ". $e->getMessage()." Linha: ".$e->getLine());
			
		}
	}

}

 ?>