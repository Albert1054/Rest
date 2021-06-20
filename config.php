<?php 

session_start();

spl_autoload_register(function($className){
	try{
		$dir = 'class';
		$file = $dir.DIRECTORY_SEPARATOR.$className.'.php';
		if(file_exists($file)){
			require_once($file);
		}
	}catch(Exception $e){
		throw new Exception("Error ao tentar chamar a classe: ".$className."  ".$e->getMessage()." Linha: ".$e->getLine());
		
	}	
});

define("MYSQL", [
	'mysql:host=127.0.0.1;dbname=rest',
	'root',
	'Juliana@102040'
]);


interface usuarios{
	public function buscar($email);
	public function cadastrar();
	public function desativar($email);
	public function atualizar($nome,$telefone,$codigo,$documento);
	public function validar($senha,$email);
}

function validaCPF(&$cpf) {
 
    /*// Extrai somente os números
    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
     
    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }*/
    return true;

}

function validaCNPJ($nuemro){
	return true;
}

function soma($a, $b):int{
	return $a + $b ;
}

 ?>