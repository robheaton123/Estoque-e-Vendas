<?php 

require_once "../../classes/conexao.php";
	$c= new conectar();
	$conexao=$c->conexao();
?>


<h4>Vender Produto</h4>
<div class="row">
	<div class="col-sm-4">
		<form id="frmVendasProdutos">
			<label>Selecionar Cliente</label>
			<select class="form-control input-sm" id="clienteVenda" name="clienteVenda">
				<option value="A">Selecionar</option>
				<option value="0">Sem Clientes</option>
				<?php
				$sql="SELECT id_cliente,nome,sobrenome 
				from clientes";
				$result=mysqli_query($conexao,$sql);
				while ($cliente=mysqli_fetch_row($result)):
					?>
					<option value="<?php echo $cliente[0] ?>"><?php echo $cliente[1]." ".$cliente[2] ?></option>
				<?php endwhile; ?>
			</select>
			<label>Produto</label>
			<select class="form-control input-sm" id="produtoVenda" name="produtoVenda">
				<option value="A">Selecionar</option>
				<?php
				$sql="SELECT id_produto,
				nome
				from produtos";
				$result=mysqli_query($conexao,$sql);

				while ($produto=mysqli_fetch_row($result)):
					?>
					<option value="<?php echo $produto[0] ?>"><?php echo $produto[1] ?></option>
				<?php endwhile; ?>
			</select>
			<label>Descrição</label>
			<textarea readonly="" id="descricaoV" name="descricaoV" class="form-control input-sm"></textarea>
			<label>Quantidade Estoque</label>
			<input readonly="" type="number" class="form-control input-sm" id="quantidadeV" name="quantidadeV">
			<label>Preço R$</label>
			<input readonly="" type="text" class="form-control input-sm" id="precoV" name="precoV">
			<label>Quantidade Vendida</label>
			<input type="number" class="form-control input-sm" id="quantV" name="quantV">
			<p></p>
			<span class="btn btn-primary" id="btnAddVenda">Adicionar</span>
			<span class="btn btn-danger" id="btnLimparVendas">Limpar Venda</span>
		</form>
	</div>
	<div class="col-sm-3">
		<div id="imgProduto"></div>
	</div>
	<div class="col-sm-4">
		<div id="tabelaVendasTempLoad"></div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		///carrega a tabela temporaria de vendas
		$('#tabelaVendasTempLoad').load("vendas/tabelaVendasTemp.php");
		//quando o select2 do #produtoVenda se altera, busca os dados do produto pela id
		$('#produtoVenda').change(function(){

			$.ajax({
				type:"POST",
				data:"idproduto=" + $('#produtoVenda').val(),
				url:"../procedimentos/vendas/obterDadosProdutos.php",
				success:function(r){
					//transforma em JSON objeto
					dado=jQuery.parseJSON(r);
					//coloca os valores nos campos
					$('#descricaoV').val(dado['descricao']);

					$('#quantidadeV').val(dado['quantidade']);
					$('#precoV').val(dado['preco']);
					//coloca a imagem do produto como primeiro item (first child) do #imgProduto
					$('#imgProduto').prepend('<img class="img-thumbnail" id="imgp" src="' + dado['url'] + '" />');
					
				}
			});
		});


		$('#btnAddVenda').click(function(){

			//funcao para validar campos vazios
			vazios=validarFormVazio('frmVendasProdutos');
			//iniciando variaveis
			var quant = 0;
			var quantidade = 0;
			//captura o valor dos campos #quantV e #quantidadeV
			quant = $('#quantV').val();//quantidade vendida
			quantidade = $('#quantidadeV').val();//quantidade em estoque

			//se Quantidade Vendida for maior que quantidade em estoque
			//parse para não dar erro de comparação entre strings do val() (javascript)
			if(parseInt(quant) > parseInt(quantidade)){
				alertify.alert("Quantidade inexistente em estoque!!");
				//apaga a quantidade vendida
				$('#quantV').val("");
				$('#quantidadeV').val(quantidade);

				return false;  //false para cancelar a ação 
			}else{
				$('#quantV').val(quant);
				$('#quantidadeV').val(quantidade);
			}

			//validar campos vazios
			if(vazios > 0){
				alertify.alert("Preencha os Campos!!");
				return false;
			}

			dados=$('#frmVendasProdutos').serialize();
			$.ajax({
				type:"POST",
				data:dados,
				url:"../procedimentos/vendas/adicionarProdutoTemp.php",
				success:function(r){
					$('#tabelaVendasTempLoad').load("vendas/tabelaVendasTemp.php");
				}
			});
		});

		//botão para limpar vendas
		$('#btnLimparVendas').click(function(){

		$.ajax({
			url:"../procedimentos/vendas/limparTemp.php",
			success:function(r){
				$('#tabelaVendasTempLoad').load("vendas/tabelaVendasTemp.php");
			}
		});
	});

	});
</script>

<script type="text/javascript">

	//editarP devolve a quantidade do produto removido para o estoque (tabela do banco)
	//dados é um array
	function editarP(dados){
		
		$.ajax({
			type:"POST",
			data:"dados=" + dados,
			url:"../procedimentos/vendas/editarEstoque.php",
			success:function(r){
				//alert(r);
				$('#tabelaVendasTempLoad').load("vendas/tabelaVendasTemp.php");
				alertify.success("Estoque Atualizado com Sucesso!!");
			}
		});
	}

	//passa o index do array (item da lista de compras) para está funcao //remove a linha da tabela temporaria de vendas
	function fecharP(index){
		$.ajax({
			type:"POST",
			data:"index=" + index,
			url:"../procedimentos/vendas/fecharProduto.php",
			success:function(r){
				$('#tabelaVendasTempLoad').load("vendas/tabelaVendasTemp.php");
				alertify.success("Produto Removido com Sucesso!!");
			}
		});
	}

	function criarVenda(){
		$.ajax({
			url:"../procedimentos/vendas/criarVenda.php",
			success:function(r){
				//alert(r);
				//se resultado de cada insert (linha da tabelaVendasTemp) for maior que zero
				if(r > 0){
					//carrega a tabela temp vazia (unset em criarVenda.php)
					$('#tabelaVendasTempLoad').load("vendas/tabelaVendasTemp.php");
					$('#frmVendasProdutos')[0].reset(); //reseta formulario via jquery
					alertify.alert("Venda Criada com Sucesso!");
				}else if(r==0){
					alertify.alert("Não possui lista de Vendas");
				}else{
					alertify.error("Venda não efetuada");
				}
			}
		});
	}
</script>

<script type="text/javascript">
	///biblioteca select2 para modificar o <select>, implementa busca
	$(document).ready(function(){
		$('#clienteVenda').select2();
		$('#produtoVenda').select2();

	});
</script>