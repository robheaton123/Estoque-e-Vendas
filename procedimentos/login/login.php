<?php 

session_start();

require_once "../../classes/conexao.php";
require_once "../../classes/usuarios.php";

//instanciando classe usuarios
$obj = new usuarios();


//$_POST com dados serializados
$dados=array(
	
	$_POST['email'],
	$_POST['senha']
	
);

echo $obj->login($dados); //funcao para callback // valor 1 se for verdadeiro //seta $_SESSION['usuario'] e $_SESSION['iduser']

 ?>