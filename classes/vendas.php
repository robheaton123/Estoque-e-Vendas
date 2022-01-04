<?php

class vendas{

    public function obterDadosProduto($idproduto)
    {
        $c = new conectar();
        $conexao = $c->conexao();

        $sql = "SELECT
            pro.nome,
            pro.descricao,
            pro.quantidade,
            img.url,
            pro.preco
            FROM produtos as pro
            INNER JOIN imagens as img
            on pro.id_imagem = img.id_imagem
            and pro.id_produto = '$idproduto'";

        $result = mysqli_query($conexao,$sql);

        $ver = mysqli_fetch_row($result);
        //explode: .. - .. - arquivos - img.jpg
        $i = explode('/',$ver[3]);
        //imgUrl: ../arquivos/img.jpg
        $imgUrl = $i[1].'/'.$i[2].'/'.$i[3];

        $dados = array(
            'nome' => $ver[0],
            'descricao' => $ver[1],
            'quantidade' => $ver[2],
            'url' => $imgUrl,
            'preco' => $ver[4]
        );

        return $dados;

    }
    

    public function criarVenda(){
        $c = new conectar();
        $conexao = $c->conexao();

        $data = date('Y-m-d');
        //chama funcao da mesma classe // id_venda sem chave primaria e auto incremento
        $idvenda = self::criaComprovante();
        //recebe a tabela de compras temporaria e o id do usuario
        $dados = $_SESSION['tabelaComprasTemp'];
        $idusuario = $_SESSION['iduser'];
        $r=0; //se resultado 0 não possui itens na lista de vendas

        for ($i=0; $i < count($dados) ; $i++) { 
            //linha do $dados:  1||bermuda tek tek||23.40
            //cria array $d[0],$d[1]
            $d = explode("||", $dados[$i]);
        
            $sql = "INSERT INTO vendas
                            (id_venda,
                            id_cliente,
                            id_produto,
                            id_usuario,
                            preco,
                            quantidade,
                            total_venda,
                            dataCompra)
                        values ('$idvenda',
                                '$d[6]',
                                '$d[0]',
                                '$idusuario',
                                '$d[3]',
                                '$d[7]',
                                '$d[8]',
                                '$data')";

            $r = $r + $result = mysqli_query($conexao, $sql);
        }
        //echo $sql;
        return $r;
    }


    public function criaComprovante(){
        $c = new conectar();
        $conexao = $c->conexao();
        //selecionando sempre o ultimo id da venda
        $sql = "SELECT id_venda FROM vendas GROUP BY id_venda DESC";

        $result = mysqli_query($conexao, $sql);
        //pegando primeiro resultado  // @ ignorando o notice que gera erro em VendasDeProdutos.php
        @$id = mysqli_fetch_row($result)[0];
        //se nao houver resultado no id
        if($id == "" || $id == null || $id == 0){
            return 1;
        }else{
            //ultimo id_venda + 1
            return $id + 1;
        }

    }

        //funcao para buscar o nome do cliente
    public function nomeCliente($idcliente){
        $c = new conectar();
        $conexao = $c->conexao();

        $sql = "SELECT sobrenome, nome FROM
                clientes WHERE id_cliente = '$idcliente'";

        $result = mysqli_query($conexao,$sql);

        $ver = mysqli_fetch_row($result);
        //retonra nome + sobrenome
        return $ver[1]." ".$ver[0];

    }

    public function obterTotal($idvenda){
        $c = new conectar();
        $conexao = $c->conexao();

        $sql = "SELECT total_venda FROM vendas WHERE id_venda = '$idvenda'";

        $result = mysqli_query($conexao,$sql);

        $total = 0;
        //obtem o valor total de varias vendas
        while ($ver = mysqli_fetch_row($result)) {
            $total = $total + $ver[0];
        }

        return $total;

    }



}


?>