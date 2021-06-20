<?php 


	require_once('config.php');

	$restaurante = new Restaurante('restauranteTeste','58741','teste@gmail.com','Sr.teste','65.765.512/0001-94','Rua teste do Campo','12456','Campos','','SP','25784691','11');
	echo $restaurante->cadastrar();


?>
