<?php 

class usuarios{

	public function obterDados($idusuario){ //obter dados do usuario
		$c = new conectar();
		$conexao=$c->conexao();

		$sql = "SELECT id, nome, user, email, dataCaptura from usuarios where id='$idusuario' ";

			$result = mysqli_query($conexao, $sql);
			$mostrar = mysqli_fetch_row($result);


			$dados = array(
				'id' => $mostrar[0],
				'nome' => $mostrar[1],
				'user' => $mostrar[2],
				'email' => $mostrar[3],
				'dataCaptura' => $mostrar[4],
			);

			return $dados; //retornando array com os dados key => valor

	}

	public function registroUsuario($dados){
		$c = new conectar();
		$conexao=$c->conexao();

		$data = date('Y-m-d');

		$sql = "INSERT into usuarios (nome, user, email, senha, dataCaptura) VALUES ('$dados[0]', '$dados[1]', '$dados[2]', '$dados[3]', '$data')";

		return mysqli_query($conexao, $sql);
	}



	public function login($dados){
			$c = new conectar();
		$conexao=$c->conexao();

		$senha = sha1($dados[1]); //verificando senha encriptada com sha1
		//setando valores da session
		$_SESSION['usuario'] = $dados[0];
		$_SESSION['iduser'] = self::trazerId($dados); //usando funcao da propria classe

		$sql = "SELECT * from usuarios where email = '$dados[0]' and senha = '$senha' ";

		$result = mysqli_query($conexao, $sql);

		//echo $sql;
		//se houver 1 resultado retorna verdadeiro
		if(mysqli_num_rows($result) > 0){
			return 1;
		}else{
			return 0;
		}


	}


	public function trazerId($dados){
		$c = new conectar();
		$conexao=$c->conexao();

		$senha = sha1($dados[1]);

		$sql = "SELECT id from usuarios where email='$dados[0]' and senha = '$senha' ";
		$result = mysqli_query($conexao, $sql);
		return mysqli_fetch_row($result)[0];
	}

	public function excluir($idusuario){
		$c = new conectar();
		$conexao= $c->conexao();

		$sql = "DELETE FROM usuarios WHERE id = $idusuario";


		return mysqli_query($conexao,$sql);
	}

	public function atualizar($dados){
		$c = new conectar();
		$conexao= $c->conexao();

		$sql = "UPDATE usuarios SET nome = '$dados[1]',user = '$dados[2]',email = '$dados[3]' WHERE id = '$dados[0]'";

		return mysqli_query($conexao, $sql);
	}
}

 ?>