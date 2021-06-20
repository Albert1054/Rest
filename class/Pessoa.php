<?php 

class Pessoa extends Usuario{

	private $CPF;
	private $idUsuario;

	public function __construct($nome='',$telefone='',$codigo='',$email='',$senha='',$cpf=''){
		$this->setNome($nome);
		$this->setTelefone($telefone);
		$this->setEmail($email);
		$this->setSenha($senha);
		$this->setCodigo($codigo);
		$this->setCPF($cpf);
	}

	public function getIdUsuario(){
		return $this->idUsuario;
	}
	public function setIdUsuario($id){
		$this->idUsuario = $id;
	}

	public function getCPF(){
		return $this->CPF;
	}

	public function setCPF($cpf){
			if(validaCPF($cpf) === true){
				$this->CPF = $cpf;
			}else{
				echo "CPF inválido";
				exit;
			}
	}

	public function buscar($email){
		try{
			$sql = new Sql(MYSQL);
			$result = $sql->select('SELECT c.Id,c.Nome,c.Senha,c.Email,p.CPF,t.Codigo,t.Numero FROM cliente c INNER JOIN telefone t on c.id = t.clienteid INNER JOIN pessoa p on c.id = p.clienteid WHERE c.Email = :EMAIL;', array(
				":EMAIL"=>$email
			));

			if(isset($result[0])){
				$row = $result[0];

				$this->setNome($row['Nome']);
				$this->setEmail($row['Email']);
				$this->setSenha($row['Senha']);
				$this->setIdUsuario($row['Id']);
				$this->setCodigo($row['Codigo']);
				$this->setTelefone($row['Numero']);
				$this->setCPF($row['CPF']);

				return true;
			}

		}catch(Exception $e){
			throw new Exception("Error: ".$e->getMessage()." Linha: ".$e->getLine());
			
		}
	}

	public function cadastrar(){
		try{
			$sql = new Sql(MYSQL);

			$sql->procedure("CALL sp_InserePessoa(:NOME, :SENHA, :EMAIL, :CPF, :CODIGO, :TELEFONE )",array(
				":NOME"=>$this->getNome(),
				":SENHA"=>$this->getSenha(),
				":EMAIL"=>$this->getEmail(),
				":CPF"=>$this->getCPF(),
				":CODIGO"=>$this->getCodigo(),
				":TELEFONE"=>$this->getTelefone()
			));

			return "Cliente Cadastrado com Sucesso!";
		}catch(Exception $e){
			throw new Exception("Error ao cadastrar o cliente: ".$this->getNome()." ".$e->getMessage()." na Linha: ".$e->getLine());
			
		}	
	}


	public function desativar($email){
		try{
			$sql = new Sql(MYSQL);
			$sql->querys('UPDATE cliente SET Ativo = -1 WHERE Email = :EMAIL;',array(
				":EMAIL"=>$email
			));
		}catch(Exception $e){
			throw new Exception("Error ao inativar cliente. ".$e->getMessage()." Linha: ".$e->getLine());
			
		} 

	}

	public function deletar($email):bool{
		try{
			$sql= new Sql(MYSQL);
			$sql->querys("DELETE FROM cliente WHERE Email = :EMAIL;",array(
				":EMAIL"=>$email
			));
			return true;
		}catch(Exception $e){
			throw new Exception("Error ao deletar pessoa: ".$e->getMessage()." Linha: ".$e->getLine());
			
		}
	}

	public function atualizar($nome,$telefone,$codigo,$cpf):bool{
		try{
			$email = $this->getEmail();
			$this->setTelefone($telefone);
			$this->setCPF($cpf);
			$this->setNome($nome);
			$this->setCodigo($codigo);

			$sql = new Sql(MYSQL);
			$sql->procedure('CALL sp_AtualizaPessoa(:NOME, :TELEFONE, :CODIGO, :CPF, :EMAIL)', array(
				":NOME"=>$this->getNome(),
				":TELEFONE"=>$this->getTelefone(),
				":CODIGO"=>$this->getCodigo(),
				":CPF"=>$this->getCPF(),
				":EMAIL"=>$this->getEmail()
			));
			return true;

		}catch(Exception $e){
			throw new Exception("Error ao atualizar pessoa. ".$e->getMessage()." Linha: ".$e->getLine());
			
		}
		
	}

	public function validar($senha,$email):bool{
		if($this->buscar($email) === true){
			$sql = new Sql(MYSQL);
			$result = $sql->select('SELECT Senha FROM Cliente WHERE Email = :EMAIL',array(
				":EMAIL"=>$email
			));
			if(isset($result[0])){
				$row = $result[0];
				if($row['Senha'] == $senha){
					return true;
				}else{
					return false;
				}
				
			}
		}else{
			return false;
		}
	}

	public function __tostring(){
		return json_encode(array(
			"idUsuario"=>$this->getIdUsuario(),
			"Nome"=>$this->getNome(),
			"Senha"=>$this->getSenha(),
			"Email"=>$this->getEmail(),
			"CODIGO Tel"=>$this->getCodigo(),
			"TELEFONE"=>$this->getTelefone(),
			"CPF"=>$this->getCPF()
		));
	}

}

 ?>