<?php

session_start();

//INCLUYO LA CONFIGURACION DE SAMRTY
require_once("libs/funciones.php");
require_once("libs/class.Conexion.BD.php");
include_once("configuracion.php");

$conn->conectar();



if (!isset($_SESSION["user"])) {
    $usuario = false;
} else {
    $usuario = $_SESSION["user"];
}

$param = array(
    array("id", $_GET["publicacion"], "int"),
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

$param3 = array(
    array("id", $_GET["publicacion"], "int")
);

$sql3 = "select * from preguntas where id_publicacion = :id";
$conn->consulta($sql3, $param3);


$preguntas = $conn->restantesRegistros();

while (list($clave, $valor) = each($preguntas)) {
    if ($valor['respuesta'] == null) {
        $preguntas[$clave]['respuesta'] = "No hay respuesta aun.";
    }
}

reset($preguntas);






$smarty->assign("publicacion", $publicacion);
$smarty->assign("especie", $especie);
$smarty->assign("preguntas", $preguntas);
$smarty->assign("usuario", $usuario);
/*
 * ENVIO EL TEMPLATE AL CLIENTE
 */
$smarty->display('publicacion.tpl');


