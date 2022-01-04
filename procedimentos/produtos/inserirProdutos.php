<?php
session_start();
$iduser = $_SESSION['iduser'];
require_once "../../classes/conexao.php";
require_once "../../classes/produtos.php";

$obj = new produtos();
 
$dados = array();

//armazenando nome da imagem
//url temporaria
//url final = caminho + nome do arquivo
$nomeImg = $_FILES['imagem']['name'];
$urlArmazenamento = $_FILES['imagem']['tmp_name'];
$pasta = '../../arquivos/';
$urlFinal = $pasta.$nomeImg;

$dadosImg = array(
    $_POST['categoriaSelect'],
    $nomeImg,
    $urlFinal

);

//move = enviando arquivo para a url final
if (move_uploaded_file($urlArmazenamento,$urlFinal)) {
    $idimagem = $obj->addImagem($dadosImg);
    //$idimagem contem o id gerado automaticamente na última consulta
    //se $idimagem existir, ou seja, as informacoes da imagem estao adicionadas, o produto será inserido
    if($idimagem > 0){
        $dados[0]=$_POST['categoriaSelect'];
        $dados[1]=$idimagem;
        $dados[2]=$iduser;
        $dados[3]=$_POST['nome'];
        $dados[4]=$_POST['descricao'];
        $dados[5]=$_POST['quantidade'];
        $dados[6]=$_POST['preco'];

        echo $obj->inserirProduto($dados);
        
   }else{
    echo 0;
 }

}



?>