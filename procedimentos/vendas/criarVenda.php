<?php
session_start();
require_once "../../classes/conexao.php";
require_once "../../classes/vendas.php";
$c = new conectar();
$obj = new vendas();

//se nao houver linha na tabela temporaria
if (count($_SESSION['tabelaComprasTemp']) == 0) {
    echo 0; //para callback
} else {
    $result = $obj->criarVenda();//cria venda
    unset($_SESSION['tabelaComprasTemp']);//apaga tabela temporaria
    echo $result;//resultado para callback
}

?>