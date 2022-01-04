<?php
session_start();
require_once "../../classes/conexao.php";
$c = new conectar();
$conexao = $c->conexao();

//pegando dados dos campos de vendas (lado esquerdo)
$idcliente = $_POST['clienteVenda'];
$idproduto = $_POST['produtoVenda'];
$descricao = $_POST['descricaoV'];
$quantidade = $_POST['quantidadeV']; //quantidade em estoque //tabela produtos
$preco = $_POST['precoV'];
$quantV = $_POST['quantV']; //quantidade vendida

$sql = "SELECT nome,sobrenome
        FROM clientes
        WHERE id_cliente = '$idcliente'";
$result = mysqli_query($conexao,$sql);

$r = mysqli_fetch_row($result);
//armazenando o nome/sobrenome do cliente
$nomecliente = $r[0]." ".$r[1];

$sql = "SELECT nome
        FROM produtos WHERE id_produto = '$idproduto'";
$result = mysqli_query($conexao, $sql);
//armazenando nome do produto
$nomeproduto = mysqli_fetch_row($result)[0];

$produto = $idproduto."||".
            $nomeproduto."||".
            $descricao."||".$preco."||"
            .$nomecliente."||".$quantidade."||"
            .$idcliente."||".$quantV."||".$quantV * $preco;
//inserindo string em um array com separadores: $idproduto||$nomeproduto||".
$_SESSION['tabelaComprasTemp'][] = $produto;

//atualização de estoque quando clica no botão #btnAddVenda //remove a quantidade do estoque na tabela de produtos
$quantNova = $quantidade - $quantV;
$sqlU = "UPDATE produtos SET quantidade = '$quantNova' WHERE id_produto = '$idproduto'";
mysqli_query($conexao,$sqlU);


//echo print_r($produto);

?>