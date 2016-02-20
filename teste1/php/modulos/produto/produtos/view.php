

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
						if($(this).val()==''){
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
			PRODUTOS
		</div>
	</div>
	<div class="abril-bloco abril-borda">
		<div class="abril-conteudo">
		<form id="formulario" method="post">
			<input type="text"name="nome" placeholder="Nome" class="abril-preencher form-control" label="Nome do Produto">
			<input type="number"name="preco" placeholder="Valor" class="abril-preencher form-control"label="Valor">
			<input type="number"name="estoque" placeholder="Estoque" class="abril-preencher form-control"label="Estoque">
			<input type="submit" class="form-control" value="Adicionar">
			<input type="hidden" name="mod" value="produto">
			<input type="hidden" name="sub" value="produtos">
			</form>
		</div>
	</div>
	<div class="abril-bloco abril-borda">
		<div class="abril-topo">
			GERENCIAR
		</div>
		<div class="abril-conteudo">
			<table class="table table-hover">
			    <thead>
			      <tr>
			        <th>Data</th>
			        <th data-hide="phone">Nome</th>
			        <th data-hide="phone">Preço</th>
			      </tr>
			    </thead>
			    <tbody>
			    <?php 
			    if(count($produtos)>0){
			    	foreach ($produtos as $idx => $valor) {?>
			      <tr>
			        <td><?php echo date('d-m-Y H:i',strtotime($valor['registro']))?></td>
			        <td><?php echo $valor['nome']?></td>
			        <td><?php echo $valor['preco']?></td>

			      </tr>
			      <?php
			  	}
			  }else{?>
			  	<tr>
			        <td colspan="4" align="center">Ainda não existem produtos</td>
			      </tr>
			  <?php }?>
			    </tbody>
			  </table>
		  </div>
	</div>

</body>
</html>
