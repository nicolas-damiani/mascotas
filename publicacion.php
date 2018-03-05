<?php
session_start();

//INCLUYO LA CONFIGURACION DE SAMRTY
require_once("libs/funciones.php");
require_once("libs/class.Conexion.BD.php");
include_once("configuracion.php");

$conn->conectar();
    
$param = array(
    array("id", $_GET["publicacion"], "int")
);

$sql = "select * from publicaciones where id = :id";

$conn->consulta($sql, $param);

$publicacion = $conn->siguienteRegistro();

/*
 * PROCESO EL CONTENIDO DEL TEMPLATE
 */
$smarty->assign("publicacion", $publicacion);

/*
 * ENVIO EL TEMPLATE AL CLIENTE
 */
$smarty->display('publicacion.tpl.html');
        
        