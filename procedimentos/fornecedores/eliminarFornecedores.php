<?php 


require_once "../../classes/conexao.php";
require_once "../../classes/fornecedores.php";

$id = $_POST['idfornecedor']; //recebendo idfornecedor da funcao eliminar()

$obj = new fornecedores(); //instanciando objeto
echo $obj->excluir($id); //excluir da classe fornecedores.php

?>