<?php

class Restaurante extends Usuario{

	private $idUsuario;
	private $CNPJ;
	private $representante;

	public function __construct($nome='', $senha='', $email='', $representante='', $CNPJ='', $logradouro='', $numero='', $bairro='', $complemento='', $uf='', $telefone='', $codigo=''){
		$this->setNome($nome);
		$this->setSenha($senha);
		$this->setEmail($email);
		$this->setTelefone($telefone);
		$this->setCodigo($codigo);
		$this->setLogradouro($logradouro);
		$this->setNumero($numero);
		$this->setBairro($bairro);
		$this->setComplemento($complemento);
		$this->setUF($uf);
		$this->setCNPJ($CNPJ);
		$this->representante = $representante;
	}

	public function setCNPJ($CNPJ){
		if(validaCNPJ($CNPJ) == true){
			$this->CNPJ = $CNPJ;
		}else{
			return false;
		}
	}
	public function getCNPJ(){
		return $this->CNPJ;
	}

	public function setIdUsuario($id){
		$this->idUsuario = $id;
	}
	public function getIdUsuario(){
		return $this->idUsuario;
	}

	public function setRepresentante($representante){
		$this->representante = $representante;
	}
	public function getRepresentate(){
		return $this->representante;
	}

	public function cadastrar(){
		try{
			$sql = new Sql(MYSQL);
			$sql->procedure("CALL sp_InsereRestaurante(:NOME, :SENHA, :EMAIL, :CODIGO, :NUMERO, :CNPJ, :REPRESENTANTE)", array(
				":NOME"=>$this->getNome(),
				":SENHA"=>$this->getSenha(),
				":EMAIL"=>$this->getEmail(),
				":CODIGO"=>$this->getCodigo(),
				":NUMERO"=>$this->getTelefone(),
				":CNPJ"=>$this->getCNPJ(),
				":REPRESENTANTE"=>$this->getRepresentate()
			));
			$this->cadastraEndereco($this->getLogradouro(),$this->getComplemento(),$this->getBairro(),$this->getNumero(), $this->getUF(), $this->getEmail());
			return "Cadastrado com suscesso";
		}catch(Exception $e){
			throw new Exception("Error ao cadastrar o cliente: ".$this->getNome()." ".$e->getMessage()." na Linha: ".$e->getLine());
		}
	}

	public function desativar($email):bool{
		try{
			$sql = new Sql(MYSQL);
			$sql->querys("UPDATE cliente SET Ativo = -1 WHERE Email = :EMAIL;", array(
				":EMAIL"=>$email
			));
			return true;
		}catch(Exception $e){
			throw new Exception("Erro ao inativar cliente com o email: $email ".$e->getMessage()." na linha: ".$e->getLine());
		}
	}

	public function buscar($email){}

	public function atualizar($nome,$telefone,$codigo,$documento){}

	public function validar($senha,$email){}

	public function cadastraEndereco($logradouro,$complemento,$bairro,$numero,$uf,$email){
		try{

			$sql = new Sql(MYSQL);
			$sql->procedure("CALL sp_cadastra_endereco(:LOGRADOURO, :COMPLEMENTO, :BAIRRO, :NUMERO, :UF, :EMAIL)", array(
				":LOGRADOURO"=>$logradouro,
				":COMPLEMENTO"=>$complemento,
				":BAIRRO"=>$bairro,
				":NUMERO"=>$numero,
				":UF"=>$uf,
				":EMAIL"=>$email
			));

		}catch(Exception $e){
			throw new Exception("Erro ao cadastrar endereco: ".$e->getMessage()." na linha: ".$e->getLine());
		}
	}


}

?>