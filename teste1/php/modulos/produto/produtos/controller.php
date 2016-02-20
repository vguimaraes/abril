<?php
include_once(PATH_CORE."/class_produto.php");
$produto = new Produto();
$status = '';

if(isset($_POST)&&!empty($_POST)){
	switch ($_POST['act']) {
		case 'salvar':echo 1;
			$status = $produto->adicionar_produto($_POST);
		break;
		case'remover':
			$status = $produto->remover_produto($_POST['id']);
		break;
		case'atualizar':
			$status = $produto->atualizar_produto($_POST);
		break;
	}
	
}


$produtos = $produto->ler_produto()['retorno'];



