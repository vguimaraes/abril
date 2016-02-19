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


include_once($_controller);
include_once($_view);


?>
