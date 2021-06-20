<?php 

abstract class Usuario implements usuarios{

	private $nome;
	private $telefone;
	private $email;
	private $senha;
	private $codigo;
	private $logradouro;
	private $numero;
	private $bairro;
	private $complemento;
	private $uf;

	public function setNome($nome){
		$this->nome = $nome;
	}
	public function getNome(){
		return $this->nome;
	}

	public function setTelefone($numero){
		$this->telefone = $numero;
	}
	public function getTelefone(){
		return $this->telefone;
	}

	public function setEmail($email){
		$this->email = $email;
	}
	public function getEmail(){
		return $this->email;
	}

	public function setSenha($password){
		$this->senha = $password;
	}
	public function getSenha(){
		return $this->senha;
	}

	public function setCodigo($codigo){
		$this->codigo = $codigo;
	}
	public function getCodigo(){
		return $this->codigo;
	}

	public function setLogradouro($logradouro){
		$this->logradouro = $logradouro;
	}
	public function getLogradouro(){
		return $this->logradouro;
	}

	public function setNumero($numero){
		$this->numero = $numero;
	}
	public function getNumero(){
		return $this->numero;
	}

	public function setBairro($bairro){
		$this->bairro = $bairro;
	}
	public function getBairro(){
		return $this->bairro;
	}

	public function setComplemento($complemento){
		$this->complemento = $complemento;
	}
	public function getComplemento(){
		return $this->complemento;
	} 

	public function setUF($uf){
		$this->uf = $uf;
	}
	public function getUF(){
		return $this->uf;
	}

	public abstract function buscar($email);

	public abstract function cadastrar();

	public abstract function desativar($email);

	public abstract function atualizar($nome,$telefone,$codigo,$documento);

	public abstract function validar($senha,$email);

	public abstract function cadastraEndereco($logradouro,$complemento,$bairro,$numero,$uf,$email);
}

 ?>