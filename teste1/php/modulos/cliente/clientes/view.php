

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
			manager.gerenciar();
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
		'gerenciar':function(){
			$('.abril-add').click(function(){
				$('.abril-replace').each(function(){
					$(this).val('');
				});
				$('#act').val('salvar');
				$('.abril-replace')[0].focus();
			});
			$('.abril-manager-btn').click(function(){
				$('#act').val($(this).attr('a'));
				var dados = JSON.parse($(this).attr('dados'));
				$('.abril-replace').each(function(){
					$(this).val(dados[$(this).attr('name')])
				});
				if($(this).attr('a')=='abrir'){
					$('#act').val('atualizar');
				}
				if($(this).attr('a')=='remover'){
					$('#formulario').submit();
				}
			});
		}
	}
	$(document).ready(function(){
		manager.start();
	});

	</script>


   <div class="abril-bloco">
		<div class="abril-topo abril-titulo">
			CLIENTES
		</div>
	</div>
	<div class="abril-bloco abril-borda">
		<div class="abril-topo" style="text-align:left!important" >
			  <button type="button" class="btn btn-default abril-add">
			  	<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
			  	Novo
			  </button>
		</div>
		<div class="abril-conteudo">
		<form id="formulario" method="post">
			<input type="text"name="nome" placeholder="Nome" class="abril-preencher abril-replace form-control" label="Nome do Cliente">
			<input type="text"name="email" placeholder="E-mail" class="abril-preencher abril-replace form-control"label="E-mail">
			<input type="number"name="telefone" placeholder="Telefone" class="abril-preencher abril-replace form-control"label="Telefone">
			<input type="submit" class="form-control" value="Salvar">
			<input type="hidden" name="mod" value="cliente">
			<input type="hidden" name="sub" value="clientes">
			<input type="hidden" id="act" name="act" value="salvar">
			<input type="hidden" class="abril-replace" name="id" value="">
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
			        <th data-hide="phone">Data</th>
			        <th>Nome</th>
			        <th data-hide="phone">E-mail</th>
			        <th data-hide="phone">Telefone</th>
			        <th data-hide="phone">Gerenciar</th>
			      </tr>
			    </thead>
			    <tbody>
			    <?php 
			    if(count($clientes)>0){
			    	foreach ($clientes as $idx => $valor) {?>
			      <tr>
			        <td><?php echo date('d-m-Y H:i',strtotime($valor['registro']))?></td>
			        <td><?php echo $valor['nome']?></td>
			        <td><?php echo $valor['email']?></td>
			        <td><?php echo $valor['telefone']?></td>
			        <td align="center">
			        <button a="abrir" dados='<?php echo json_encode($valor)?>' type="button" class="btn btn-default abril-manager-btn" aria-label="Left Align">
					  <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
					</button> 
					<button a="remover" dados='<?php echo json_encode($valor)?>'type="button" class="btn btn-default abril-manager-btn" aria-label="Left Align">
					  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
					</button>

			        </td>

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
