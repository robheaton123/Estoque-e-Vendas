<?php
session_start();
//pega o index da lista de produtos
$index = $_POST['index'];
//apaga o indice de um array especifico (com o array junto)
unset($_SESSION['tabelaComprasTemp'][$index]);
//retorna os valores dos indices de cada array restante, ex: unset->1 - $dados recebe 0 e 2 
$dados = array_values($_SESSION['tabelaComprasTemp']);
//apagando toda lista de vendas que está na session
unset($_SESSION['tabelaComprasTemp']);
//criando uma nova session, com uma nova lista de vendas (array 0 e 1)
$_SESSION['tabelaComprasTemp'] = $dados;


?>