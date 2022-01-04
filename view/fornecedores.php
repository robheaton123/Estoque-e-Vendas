<?php 
//inicia session e verifica se usuario está setado (tela de login)
session_start();
if(isset($_SESSION['usuario'])){

	?>

	
	<!DOCTYPE html>
	<html>
	<head>
		<title>Fornecedores</title>
		<?php require_once "menu.php"; ?>
	</head>
	<body>
		<div class="container">
			<!--form para cadastrar fornecedor-->
			<h1>Fornecedores</h1>
			<div class="row">
				<div class="col-sm-4">
					<form id="frmFornecedores"> <!--não é orientado a objetos/sem action // feito via ajax-->
						<label>Nome</label>
						<input type="text" class="form-control input-sm" id="nome" name="nome">
						<label>Sobrenome</label>
						<input type="text" class="form-control input-sm" id="sobrenome" name="sobrenome">
						<label>Endereço</label>
						<input type="text" class="form-control input-sm" id="endereco" name="endereco">
						<label>Email</label>
						<input type="text" class="form-control input-sm" id="email" name="email">
						<label>Telefone</label>
						<input type="text" class="form-control input-sm" id="telefone" name="telefone">
						<label>CPF</label>
						<input type="text" class="form-control input-sm" id="cpf" name="cpf">
						<p></p>
						<span class="btn btn-primary" id="btnAdicionarFornecedor">Salvar</span>
					</form>
				</div>
				<div class="col-sm-8">   <!--carrega tabela de fornecedores via jQuery-->
					<div id="tabelaFornecedoresLoad"></div>
				</div>
			</div>
		</div>

		<!-- Button trigger modal -->


		<!-- Modal para atualizar fornecedor-->
		<div class="modal fade" id="abremodalFornecedoresUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Atualizar fornecedor</h4>
					</div>
					<div class="modal-body">
						<form id="frmFornecedoresU">
							<input type="text" hidden="" id="idfornecedorU" name="idfornecedorU">
							<label>Nome</label>
							<input type="text" class="form-control input-sm" id="nomeU" name="nomeU">
							<label>Sobrenome</label>
							<input type="text" class="form-control input-sm" id="sobrenomeU" name="sobrenomeU">
							<label>Endereço</label>
							<input type="text" class="form-control input-sm" id="enderecoU" name="enderecoU">
							<label>Email</label>
							<input type="text" class="form-control input-sm" id="emailU" name="emailU">
							<label>Telefone</label>
							<input type="text" class="form-control input-sm" id="telefoneU" name="telefoneU">
							<label>CPF</label>
							<input type="text" class="form-control input-sm" id="cpfU" name="cpfU">
						</form>
					</div>
					<div class="modal-footer">
						<button id="btnAdicionarFornecedorU" type="button" class="btn btn-primary" data-dismiss="modal">Atualizar</button>

					</div>
				</div>
			</div>
		</div>

	</body>
	</html>

	<script type="text/javascript">
	//ADICIONAR DADOS NO MODAL PARA UPDATE
		function adicionarDado(idfornecedor){ //adiciona dados no modal para edicao -> abremodalFornecedoresUpdate

			$.ajax({
				type:"POST",
				data:"idfornecedor=" + idfornecedor,
				url:"../procedimentos/fornecedores/obterDadosFornecedores.php", //vai retornar JSON_ENCODE
				success:function(r){ //retorno JSON em String

					dado=jQuery.parseJSON(r); //transformando(dado) em objeto JSON

					//utilizando o index do objeto JSON(dado) para mostrar o valor
					//o valor é setado nos campos do Modal
					$('#idfornecedorU').val(dado['id_fornecedor']); 
					$('#nomeU').val(dado['nome']);
					$('#sobrenomeU').val(dado['sobrenome']);
					$('#enderecoU').val(dado['endereco']);
					$('#emailU').val(dado['email']);
					$('#telefoneU').val(dado['telefone']);
					$('#cpfU').val(dado['cpf']);



				}
			});
		}
		// ELIMINAR FORNECEDOR
		function eliminar(idfornecedor){ //funcao para eliminar fornecedor
			alertify.confirm('Deseja Excluir este fornecedor?', function(){ 
				$.ajax({
					type:"POST", //utilizando POST php
					data:"idfornecedor=" + idfornecedor, //passando idfornecedor VIA POST
					url:"../procedimentos/fornecedores/eliminarFornecedores.php",
					success:function(r){ //se verdadeiro carrega tabela fornecedores


						if(r==1){
							$('#tabelaFornecedoresLoad').load("fornecedores/tabelaFornecedores.php"); // carrega tabela fornecedores
							alertify.success("Excluido com sucesso!!");
						}else{
							alertify.error("Não foi possível excluir"); //caso houver erro no SQL (callback -> r)
						}
					}
				});
			}, function(){ 
				alertify.error('Cancelado !')
			});
		}
	</script>
	<!--Adicionar fornecedor-->
	<script type="text/javascript">
		$(document).ready(function(){ //ao ler documento //iniciado automaticamente via jQuery

			$('#tabelaFornecedoresLoad').load("fornecedores/tabelaFornecedores.php"); //carregar tabela fornecedores na div 8

			$('#btnAdicionarFornecedor').click(function(){ //verificar se existe campos fazios

				vazios=validarFormVazio('frmFornecedores'); //funcao verifica campos vazios

				if(vazios > 0){
					alertify.alert("Preencha os Campos!!");
					return false;
				}

				dados=$('#frmFornecedores').serialize(); //serializando dados do formulario: single=Single&multiple=Multiple&multiple=Multiple3&check=check2&radio=radio1

				$.ajax({ //enviando dados serializados via post para adicionarFornecedores.php
					type:"POST",
					data:dados,
					url:"../procedimentos/fornecedores/adicionarFornecedores.php",
					success:function(r){ //recebendo a resposta(callback): 1 verdadeiro ou falso para outro valor

						if(r==1){ //se callback r = 1
							$('#frmFornecedores')[0].reset(); //reset no formulario fornecedores com jquery
							$('#tabelaFornecedoresLoad').load("fornecedores/tabelaFornecedores.php"); //carrega tabela fornecedores
							alertify.success("Fornecedor adicionado !"); //biblioteca alertify
						}else{
							alertify.error("Não foi possível adicionar");
						}
					}
				});
			});
		});
	</script>
	<!--Atualizar fornecedores-->
	<script type="text/javascript">
		$(document).ready(function(){
			$('#btnAdicionarFornecedorU').click(function(){ //funcao click para atualizar fornecedor
				dados=$('#frmFornecedoresU').serialize(); //dados serializados do form que está no modal

				$.ajax({ //enviados dados serializados para atualizarFornecedores.php
					type:"POST",
					data:dados,
					url:"../procedimentos/fornecedores/atualizarFornecedores.php",
					success:function(r){ //callback atualizarFornecedores.php


						if(r==1){
							$('#frmFornecedores')[0].reset(); //reseta campos do formulario
							$('#tabelaFornecedoresLoad').load("fornecedores/tabelaFornecedores.php");// carrega tabela fornecedores
							alertify.success("Fornecedor atualizado com sucesso!");
						}else{
							alertify.error("Não foi possível atualizar o fornecedor");
						}
					}
				});
			})
		})
	</script>


	<?php 
}else{
	header("location:../index.php");
}
?>