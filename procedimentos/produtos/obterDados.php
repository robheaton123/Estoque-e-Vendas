<?php
require_once "../../classes/conexao.php";
require_once "../../classes/produtos.php";

$obj = new produtos();
//$_POST recebe data: "idpro=" + idproduto
echo json_encode($obj->obterDados($_POST['idpro'])); //transforma em JSON -> texto


?>