<?php
include_once(PATH_CORE."/class_produto.php");
$produto = new Produto();
$status = '';

if(isset($_POST)&&!empty($_POST)){
	$status = $produto->adicionar_produto($_POST);
}


$produtos = $produto->ler_produto()['retorno'];



