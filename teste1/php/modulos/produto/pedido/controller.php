<?php
include_once(PATH_CORE."/class_produto.php");
include_once(PATH_CORE."/class_cliente.php");
$produto = new Produto();
$cliente = new Cliente();
$status = '';

if(isset($_POST)&&!empty($_POST)){
	$_POST['qtd']=1;
	$status = $produto->novo_pedido($_POST)['msg'];
}


$produtos = $produto->ler_produto()['retorno'];
$clientes = $cliente->ler_cliente()['retorno'];
$pedidos = $produto->ler_pedido()['retorno'];



