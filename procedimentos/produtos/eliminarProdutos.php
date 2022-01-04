<?php 
require_once "../../classes/conexao.php";
require_once "../../classes/produtos.php";

$idpro = $_POST['idproduto'];

$obj = new produtos();

//excluir produto e imagem do produto // se houver duplicata tambem será deletada
echo $obj->excluir($idpro);

?>