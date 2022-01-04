<?php 

class fornecedores{ 

	public function adicionar($dados){//funcao para insert no banco //$dados = array
		$c = new conectar();
		$conexao=$c->conexao();

		
		//id_usuario que está realizando o cadastro
		$sql = "INSERT INTO fornecedores (id_usuario, nome, sobrenome, endereco, email, telefone, cpf) VALUES ('$dados[0]', '$dados[1]', 
		   '$dados[2]',
		   '$dados[3]',
			'$dados[4]',
			'$dados[5]',
			'$dados[6]')";



		return mysqli_query($conexao, $sql); //por padrao gera o valor de 1, se for sucesso
	}




	public function obterDados($id){ //obter dados do fornecedor
		$c = new conectar();
		$conexao=$c->conexao();

		$sql = "SELECT id_fornecedor, nome, sobrenome, endereco, email, telefone, cpf from fornecedores where id_fornecedor='$id' ";

			$result = mysqli_query($conexao, $sql);
			$mostrar = mysqli_fetch_row($result);


			$dados = array(
				'id_fornecedor' => $mostrar[0],
				'nome' => $mostrar[1],
				'sobrenome' => $mostrar[2],
				'endereco' => $mostrar[3],
				'email' => $mostrar[4],
				'telefone' => $mostrar[5],
				'cpf' => $mostrar[6],
			);

			return $dados; //retornando array com os dados key => valor

	}


	public function atualizar($dados){ //array do atualizarFornecedores.php
		$c = new conectar();
		$conexao=$c->conexao();

		

		$sql = "UPDATE fornecedores SET nome = '$dados[1]', sobrenome = '$dados[2]',endereco = '$dados[3]',email = '$dados[4]',telefone = '$dados[5]',cpf = '$dados[6]' where id_fornecedor = '$dados[0]'";


		echo mysqli_query($conexao, $sql); //retorno para callback
	}


	public function excluir($id){ //excluir fornecedor
		$c = new conectar();
		$conexao=$c->conexao();
		

		$sql = "DELETE from fornecedores where id_fornecedor = '$id' ";

		return mysqli_query($conexao, $sql); //retorno r (callback para AJAX)
	}

}

?>