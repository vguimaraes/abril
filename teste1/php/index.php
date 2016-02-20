<?php
session_start();

error_reporting(E_ALL);
ini_set("display_errors", 1);

DEFINE('PATH_MODULO',			'modulos');
DEFINE('PATH_CORE',				'core');
DEFINE('PATH_LIB',				'lib');

DEFINE('DEFAULT_MODULO',		'produto');
DEFINE('DEFAULT_MODULO_SUB',	'pedido');
DEFINE('DEFAULT_VIEW',			'view.php');
DEFINE('DEFAULT_CONTROLLER',	'controller.php');

$_modulo 		= (isset($_REQUEST['mod']))?$_REQUEST['mod']:DEFAULT_MODULO;
$_modulo_sub 	= (isset($_REQUEST['sub']))?$_REQUEST['sub']:DEFAULT_MODULO_SUB;
$_controller 	= PATH_MODULO."/$_modulo/$_modulo_sub/".DEFAULT_CONTROLLER;
$_view 			= PATH_MODULO."/$_modulo/$_modulo_sub/".DEFAULT_VIEW;

if(isset($_REQUEST['ajax'])){
	if(file_exists($_controller) && file_exists($_controller)){
		include_once($_controller);
		include_once($_view);	
	}else{
		echo 'Modulo não encontrado';
	}
	die;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Editora Abril - Teste</title>
	<meta name="viewport" content="width=device-width, user-scalable=yes">
	<script type="text/javascript" src="lib/jquery/jquery.js"></script>
	<link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="lib/bootstrap/css/bootstrap-theme.min.css">
	<script src="lib/bootstrap/js/bootstrap.min.js"></script>
	<script src="lib/bootbox/bootbox.js"></script>
	<link href="lib/select2/css/select2.min.css" rel="stylesheet" />
	<script src="lib/select2/js/select2.min.js"></script>
	<link href="lib/footable/css/footable.core.css" rel="stylesheet" type="text/css" />
	<link href="lib/footable/css/footable.metro.css" rel="stylesheet" type="text/css" />
	<script src="lib/footable/js/footable.js" type="text/javascript"></script>
	<script type="text/javascript">
      $(document).ready(function(){

      	$('.abril-controle-menu').each(function(){
      		$('.abril-controle-menu').click(function(){
      			var modv = $(this).attr('mod');
	      		var subv = $(this).attr('sub');
				
				var param = {
					mod:modv,
					sub:subv,
					ajax:1
				};
				
				$.ajax({
				  url: "./?"+$.param(param)
				}).done(function(modulo) {
				  $('.abril-modulo').html(modulo);console.log(modulo)
				  $('title').html('Editora Abril - '+subv)
				});
      		});  		
      	});
      });
	</script>
</head>
<body>
<nav class="navbar navbar-default">
	  <div class="container-fluid">
	  	<div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#abril-menu" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="#">Editora Abril</a>
	    </div>

	    <div class="collapse navbar-collapse" id="abril-menu">
	    	<ul class="nav navbar-nav navbar-right">
		        <li><a class="abril-controle-menu" mod="produto"sub="pedido">Pedidos</a></li>
		        <li><a class="abril-controle-menu"mod="cliete"sub="clientes">Clientes</a></li>
		        <li><a class="abril-controle-menu"mod="produto"sub="produtos">Produtos</a></li>
		      </ul>
	    </div>

	  </div>
   </nav>
	<div class="abril-modulo">
<?php

include_once($_controller);
include_once($_view);


?>
</div>
</body>
