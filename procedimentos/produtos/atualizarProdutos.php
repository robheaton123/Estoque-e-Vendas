<?php 
require_once "../../classes/conexao.php";
require_once "../../classes/produtos.php";

$obj = new produtos();

//POST enviado via AJAX
//array para a funcao da classe produtos
$dados=array(
	$_POST['idProduto'],
	$_POST['categoriaSelectU'],
	$_POST['nomeU'],
	$_POST['descricaoU'],
	$_POST['quantidadeU'],
	$_POST['precoU']
);

echo $obj->atualizar($dados); //atualizar fornecedor //classe fornecedores

 ?>