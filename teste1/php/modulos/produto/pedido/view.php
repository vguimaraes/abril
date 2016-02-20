

	<style type="text/css">
	.abril-bloco{
		margin: 0.5em; 
		border-radius: 0.5em;
	}
	.abril-borda{
		border:solid 0.1em #000;
	}
	.abril-titulo{
	}
	.abril-bloco div, .abril-bloco input{
		margin-top: 0.5em;
	}
	.abril-topo, .abril-conteudo{
		margin: 0.5em;
	}
	.abril-topo{
		text-align: center;
		font-weight: bold;
	}
	</style>
	<script type="text/javascript">
	var manager = {
		'erro':false,
		'on_val':false,
		'start':function(){
			manager.selects();
			manager.enviar();

			$('.table').footable();
		},
		'enviar':function(){
			$('#formulario').submit(function(e){
				if(!manager.on_val){
					e.preventDefault();
					$('.abril-preencher').each(function(){
						if($(this).val()===null){
							manager.erro = true;
							var msg = 'Por favor, informe o '+$(this).attr('label');
							bootbox.alert(msg, function() {
				  				manager.erro = false;
							});
							return false;
						}
					});
					if(!manager.erro){
						manager.on_val = true;
						$('#formulario').submit();	
					}
				}
			});
		},
		'selects':function(){
			
			var eventCliente = $("#cliente").select2({
				 placeholder:'Informe o Cliente',
				 theme:'classic',
				 width: '100%',
  				 allowClear: true
			});
			$('#cliente').select2('val','all');

			var eventProduto = $("#produto").select2({
				 placeholder:'Informe o Produto',
				 theme:'classic',
				 width: '100%',
  				 allowClear: true
			});
			$('#produto').select2('val','all');
		}
	}
	$(document).ready(function(){
		manager.start();
	});

	</script>


   <div class="abril-bloco">
		<div class="abril-topo abril-titulo">
			PEDIDOS
		</div>
	</div>

	<div class="abril-bloco abril-borda">
		<div class="abril-topo">
			COMPRAR PRODUTO
		</div>
		<div class="abril-conteudo">
			<form id="formulario" method="post">
				<div>
					<select name="id_cliente" id="cliente" class="abril-select abril-preencher form-control" label="Cliente">
						<?php 
						if(count($clientes)>0){
							foreach ($clientes as $idx => $valor) {?>
							<option value="<?php echo $valor['id']?>"><?php echo $valor['nome']?></option>	
						<?php }
						}
						?>
					</select>
				</div>
				<div>
					<select id="produto" name="id_produto" class="abril-select abril-preencher form-control" label="Produto">
						<?php 
						if(count($produtos)>0){
							foreach ($produtos as $idx => $valor) {?>
							<option value="<?php echo $valor['id']?>"><?php echo '('.$valor['estoque'].') '.$valor['nome'];?></option>	
						<?php }
						}
						?>
					</select>
				</div>
				<div class="abril-msg"><?php echo $status;?></div>
				<input type="submit" class="form-control" value="Fazer Perdido">
			</form>
		</div>
	</div>
	<div class="abril-bloco abril-borda">
		<div class="abril-topo">
			PEDIDOS
		</div>
		<div class="abril-conteudo">
			<table class="table table-hover">
			    <thead>
			      <tr>
			        <th>Data</th>
			        <th data-hide="phone">Produto</th>
			        <th>Cliente</th>
			        <th data-hide="phone">E-mail</th>
			        <th data-hide="phone">Preço</th>
			      </tr>
			    </thead>
			    <tbody>
			    <?php 
			    if(count($pedidos)>0){
			    	foreach ($pedidos as $idx => $valor) {?>
			      <tr>
			        <td><?php echo date('d-m-Y H:i',strtotime($valor['registro']))?></td>
			        <td><?php echo $valor['produto']?></td>
			        <td><?php echo $valor['cliente']?></td>
			        <td><?php echo $valor['email']?></td>
			        <td><?php echo $valor['preco']?></td>

			      </tr>
			      <?php
			  	}
			  }else{?>
			  	<tr>
			        <td colspan="4" align="center">Ainda não existem pedidos</td>
			      </tr>
			  <?php }?>
			    </tbody>
			  </table>
		  </div>
	</div>

</body>
</html>
