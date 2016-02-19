<?php
include_once(PATH_CORE."/class_produto.php");
include_once(PATH_CORE."/class_cliente.php");
$produto = new Produto();
$cliente = new Cliente();

print_r($_POST);
if(isset($_POST)&&!empty($_POST)){
	echo 1;
	$produto->novo_pedido(array('id_produto'=>1,'id_cliente'=>2));
}


$produtos = $produto->ler_produto()['retorno'];
$clientes = $cliente->ler_cliente()['retorno'];
$pedidos = $produto->ler_pedido()['retorno'];



