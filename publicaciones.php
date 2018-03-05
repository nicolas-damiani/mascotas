<?php

session_start();

//INCLUYO LA CONFIGURACION DE SAMRTY
require_once("libs/funciones.php");
require_once("libs/class.Conexion.BD.php");
include_once("configuracion.php");

$conn->conectar();

$sql = "select * from publicaciones order by id desc";

$conn->consulta($sql);

$resultado = $conn->restantesRegistros();

while (list($clave, $valor) = each($resultado)) {
    if (strlen($valor["descripcion"]) > 150) {
        $resultado[$clave]["descripcion"] = substr($valor["descripcion"], 0, 50) . "...";
    }
}

reset($resultado);

/*
 * PROCESO EL CONTENIDO DEL TEMPLATE
 */
$smarty->assign("publicaciones", $resultado);

/*
 * ENVIO EL TEMPLATE AL CLIENTE
 */
$smarty->display('publicaciones.tpl.html');

