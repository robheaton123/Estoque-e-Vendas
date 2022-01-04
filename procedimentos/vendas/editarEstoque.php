<?php
require_once "../../classes/conexao.php";
$c = new conectar();
$conexao = $c->conexao();

//post da funcao editarP //valor em array ex: editarP('7, 98')
$dados = $_POST['dados'];

//extraindo dados
$idproduto = $dados[0];
//quantidade recebe até 4 digitos
$quantidade = $dados[3].$dados[4].$dados[5].$dados[6];

//update retornando a quantidade para o estoque
$sqlU = "UPDATE produtos SET quantidade = '$quantidade' WHERE id_produto = '$idproduto'";
mysqli_query($conexao,$sqlU);



?>