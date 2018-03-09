<?php

/*
 * CONFIGURACION DE SMARTY  
 */
require_once('libs/Smarty.class.php');

define('TEMPLATE_DIR', 'templates/');
define('COMPILER_DIR', 'tmp/templates_c/');
define('CONFIG_DIR', 'tmp/configs/');
define('CACHE_DIR', 'tmp/cache/');

//DECLARO SAMRTY
$smarty = new Smarty;

//COLOCO LA DESIGNACION DE DIRECTORIOS
$smarty->template_dir = TEMPLATE_DIR;
$smarty->compile_dir = COMPILER_DIR;
$smarty->config_dir = CONFIG_DIR;
$smarty->cache_dir = CACHE_DIR;

//Configuración de base de datos
define('HOST', 'localhost');
define('USUARIO', 'root');
define('CLAVE', 'root');
define('BASE', 'mascotas');

$conn = new ConexionBD("mysql", HOST, BASE, USUARIO, CLAVE);




?>