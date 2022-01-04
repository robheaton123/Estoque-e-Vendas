<?php 

	session_start();
	
 ?>

 <h4>Criar Venda</h4>
 <h4><strong><div id="nomeclienteVenda"></div></strong></h4>
 <table class="table table-bordered table-hover table-condensed" style="text-align: center;">
 	<caption>
 		<span class="btn btn-success" onclick="criarVenda()"> Criar Venda
 			<span class="glyphicon glyphicon-usd"></span>
 		</span>
 	</caption>
 	<tr>
 		<td>Nome</td>
 		<td>Descrição</td>
 		<td>Preço</td>
 		<td>Quantidade</td>
 		<td>Remover</td>
 	</tr>
 	<?php 
 	$total=0;//total da venda em dinheiro
 	$cliente=""; //nome cliente
 		if(isset($_SESSION['tabelaComprasTemp'])):
 			$i=0;//numero de itens adicionados
 			foreach (@$_SESSION['tabelaComprasTemp'] as $key) {
				//retira o || da string que veio do adicionarProdutoTemp.php
				//transforma $d em array
 				$d=explode("||", @$key);

				 //cada array tem um indice(numeracao) exemplo:
				 //echo print_r($_SESSION['tabelaComprasTemp'][0]);
				 //echo print_r($_SESSION['tabelaComprasTemp'][1]);
 	 ?>

 	<tr>
 		<td><?php echo $d[1] ?></td>
 		<td><?php echo $d[2] ?></td>
 		<td><?php echo "R$ ".$d[3]?></td>
 		<td><?php echo $d[7]; ?></td>
 		<td>

 			
				<!--fecharP remove a linha da tabela temporaria via index do array-->
				<!--editarP $d[5]= quant do produto quando foi efetuado o click no botão | a função devolve a quantidade do produto removido para o estoque -->
 			<span class="btn btn-danger btn-xs" onclick="fecharP('<?php echo $i; ?>'), editarP('<?php echo $d[0]; ?>, <?php echo $d[5]; ?>')">
 				<span class="glyphicon glyphicon-remove"></span>
 			</span>
 		</td>
 	</tr>

 <?php 
		//calculo Total da venda
 		$calc = $d[3] * $d[7];
 		$total=$total + $calc;
 		$i++;
 		$cliente=$d[4];
 	}
 	endif; 
 ?>

 	<tr>
 		<td>Total da venda: <?php echo "R$ ".$total; ?></td>
 	</tr>

 </table>


 <script type="text/javascript">
 	$(document).ready(function(){
		 //variavel javascript recebendo variavel em php
 		nome="<?php echo @$cliente ?>";
 		$('#nomeclienteVenda').text("Nome de cliente: " + nome);
 	});
 </script>