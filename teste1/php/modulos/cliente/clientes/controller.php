<?php
include_once(PATH_CORE."/class_cliente.php");
$cliente = new Cliente();
$status = '';

if(isset($_POST)&&!empty($_POST)){
	switch ($_POST['act']) {
		case 'salvar':echo 1;
			$status = $cliente->novo_cliente($_POST);
		break;
		case'remover':
			$status = $cliente->remover_cliente($_POST['id']);
		break;
		case'atualizar':
			$status = $cliente->atualizar_cliente($_POST);
		break;
	}
	
}


$clientes = $cliente->ler_cliente()['retorno'];


