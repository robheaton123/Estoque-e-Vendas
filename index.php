<?php
	//consulta para verificar se há administrador no sistema
	require_once "classes/conexao.php";
	$obj = new conectar();
	$conexao = $obj->conexao();

	$sql = "SELECT * from usuarios where email='admin'";
	$result = mysqli_query($conexao, $sql);

	$validar = 0;
	if(mysqli_num_rows($result) > 0){
		$validar = 1; //se existir, recebe 1
	}

?>



<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">
	<script src="lib/jquery-3.2.1.min.js"></script>
	<script src="js/funcoes.js"></script>
</head>
<body style="background-color: gray">
	<br><br><br>
	<div class="container">
		<div class="row">
			<div class="col-sm-4"></div>
			<div class="col-sm-4">
				<div class="panel panel-primary">
					<div class="panel panel-heading">Sistema</div>
					<div class="panel panel-body">
						<p>
							<img src="img/phpoo.png"  width="100%">
						</p>
						<form id="frmLogin">
							<label>Email</label>
							<input type="text" class="form-control input-sm" name="email" id="email">
							<label>Senha</label>
							<input type="password" name="senha" id="senha" class="form-control input-sm">
							<p></p>
							<span class="btn btn-primary btn-sm" id="entrarSistema">Entrar</span>
							<?php if(!$validar): //if para mostrar ou não o botao de registro?> 
							<a href="registrar.php" class="btn btn-danger btn-sm">Registrar</a>

							<?php 
								endif;
							 ?>
							
						</form>
					</div>
				</div>
			</div>
			<div class="col-sm-4"></div>
		</div>
	</div>
</body>
</html>

<script type="text/javascript">
	$(document).ready(function(){ //verificar campos vazios
		$('#entrarSistema').click(function(){

		vazios=validarFormVazio('frmLogin'); //funcoes.js

			if(vazios > 0){
				alert("Preencha os campos!!");
				return false;  //cancela o restante do script (serialize e consulta)
			}

		dados=$('#frmLogin').serialize(); //serializando dados
		//ajax para verificar login // se verdadeiro faz login
		$.ajax({
			type:"POST",
			data:dados,
			url:"procedimentos/login/login.php",
			success:function(r){
				//alert(r);
				if(r==1){
					window.location="view/inicio.php";
				}else{
					alert("Acesso Negado!!");
				}
			}
		});
	});
	});
</script>