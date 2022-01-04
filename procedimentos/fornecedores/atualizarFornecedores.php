<?php 


require_once "../../classes/conexao.php";
require_once "../../classes/fornecedores.php";



$obj = new fornecedores();

//POST enviado via AJAX
//array para a funcao da classe fornecedores
$dados=array(
	$_POST['idfornecedorU'],
	$_POST['nomeU'],
	$_POST['sobrenomeU'],
	$_POST['enderecoU'],
	$_POST['emailU'],
	$_POST['telefoneU'],
	$_POST['cpfU']
	

);

echo $obj->atualizar($dados); //atualizar fornecedor //classe fornecedores

 ?>