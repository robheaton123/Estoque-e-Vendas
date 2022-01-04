<?php 

session_start();
require_once "../../classes/conexao.php";
require_once "../../classes/fornecedores.php";




$idusuario = $_SESSION['iduser']; //pegando id do usuario que irá cadastrar o fornecedor


$obj = new fornecedores();


//array para insert
$dados=array(
	$idusuario,
	$_POST['nome'],
	$_POST['sobrenome'],
	$_POST['endereco'],
	$_POST['email'],
	$_POST['telefone'],
	$_POST['cpf']

);

echo $obj->adicionar($dados);  //passando array com dados para a funcao da classe fornecedores/retorno true or false

 ?>