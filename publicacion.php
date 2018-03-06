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

if ($publicacion["tipo"] == "E") {
    $publicacion["tipo"] = "Encontrado";
} else {
    $publicacion["tipo"] = "Perdido";
}

$param2 = array(
    array("id", $publicacion['especie_id'], "int")
);

$sql2 = "select * from especies where id = :id";
$conn->consulta($sql2, $param2);

$especie = $conn->siguienteRegistro();




$smarty->assign("publicacion", $publicacion);
$smarty->assign("especie", $especie);

/*
 * ENVIO EL TEMPLATE AL CLIENTE
 */
$smarty->display('publicacion.tpl.html');

