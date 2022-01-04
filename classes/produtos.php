<?php 

class produtos{

	public function addImagem($dados){
		$c = new conectar();
		$conexao = $c->conexao();

		$data=date('Y-m-d');

		//inserindo as informações da imagem na tabela imagem
		$sql = "INSERT into imagens (
			id_categoria,
			nome,
			url,
			dataUpload)
			VALUES ('$dados[0]','$dados[1]','$dados[2]','$data')";

			$result = mysqli_query($conexao, $sql);

			//Retorna o id gerado automaticamente na última consulta
			return mysqli_insert_id($conexao);

	}

	public function inserirProduto($dados){
		$c = new conectar();
		$conexao = $c->conexao();

		$data=date('Y-m-d');

		$sql = "INSERT INTO produtos (
			id_categoria,
			id_imagem,
			id_usuario,
			nome,
			descricao,
			quantidade,
			preco,
			dataCaptura)
			VALUES
			(
				'$dados[0]',
				'$dados[1]',
				'$dados[2]',
				'$dados[3]',
				'$dados[4]',
				'$dados[5]',
				'$dados[6]',
				'$data'
				)";
		//retornando para callback ajax
		return mysqli_query($conexao, $sql);

	}

	public function obterDados($idProd){
		$c = new conectar();
		$conexao = $c->conexao();

		$sql = "SELECT 
			id_produto,
			id_categoria,
			nome,
			descricao,
			quantidade,
			preco
		FROM produtos WHERE id_produto = '$idProd'";

		$result = mysqli_query($conexao, $sql);
		$mostrar = mysqli_fetch_row($result);
		
		$dados = array(
			'id_produto' => $mostrar[0],
			'id_categoria' => $mostrar[1],
			'nome' => $mostrar[2],
			'descricao' => $mostrar[3],
			'quantidade' => $mostrar[4],
			'preco' => $mostrar[5]
		);

		return $dados;

	}

	public function atualizar($dados){
		$c = new conectar();
		$conexao = $c->conexao();

		$sql = "UPDATE produtos SET
			id_categoria = '$dados[1]',
			nome = '$dados[2]',
			descricao = '$dados[3]',
			quantidade = '$dados[4]',
			preco = '$dados[5]'
			WHERE id_produto = '$dados[0]'";

		//retornando para callback ajax
		echo mysqli_query($conexao, $sql);

	}

	public function excluir($idpro){ //excluir produto
		$c = new conectar();
		$conexao=$c->conexao();
		
		//chamando a funcao da mesma classe para obter o id da imagem na tabela produtos
		$idimagem = self::obterIdImg($idpro);

		$sql = "DELETE from produtos where id_produto = '$idpro' ";

		$result = mysqli_query($conexao, $sql);

		//se o produto for deletado
		if($result){
			//obtendo a url do produto que foi deletado
			$url = self::obterUrlImagem($idimagem);

			//deletando os dados da tabela imagens
			$sql = "DELETE FROM imagens WHERE id_imagem = '$idimagem'";
			$result = mysqli_query($conexao, $sql);
				
			//se for deletado com sucesso
				if($result){

					//unlink: deleta a imagem via url e retorna 1 para o callback
					if(unlink($url)){
						return 1;
					}

				}

		}

	}

	public function obterIdImg($idPro){
		$c = new conectar();
		$conexao=$c->conexao();
		
		$sql = "SELECT id_imagem FROM produtos WHERE id_produto = '$idPro'";
		$result = mysqli_query($conexao, $sql);
		//retorna o primeiro resultado
		return mysqli_fetch_row($result)[0];
	}

	public function obterUrlImagem($idimagem){
		$c = new conectar();
		$conexao=$c->conexao();

		$sql = "SELECT url FROM imagens WHERE id_imagem = '$idimagem'";
		$result = mysqli_query($conexao, $sql);
		//retorna o primeiro resultado
		return mysqli_fetch_row($result)[0];
	}


}


 ?>