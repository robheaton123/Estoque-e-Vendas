<?php 

require_once "../../classes/conexao.php";
require_once "../../classes/fornecedores.php";


$obj = new fornecedores();
//$_POST recebe data:"idfornecedor=" + idfornecedor
echo json_encode($obj->obterDados($_POST['idfornecedor'])); //transforma em JSON -> texto


 ?>

