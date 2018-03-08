<?php

session_start();

//INCLUYO LA CONFIGURACION DE SAMRTY
require_once("libs/funciones.php");
require_once("libs/class.Conexion.BD.php");
include_once("configuracion.php");

$conn->conectar();

$param = array(
    array("id_publicacion", $_POST["publicacion"], "int"),
    array("texto", $_POST["texto"], "string"),
    array("usuario_id", 3, "int"),
);

$sql = "insert into preguntas(id_publicacion, texto, usuario_id) values(:id_publicacion, :texto, :usuario_id)";

$conn->consulta($sql, $param);

if ($conn->ultimoIdInsert() > 0) {
    $respuesta = "ok";
    echo $respuesta;
} else {
    $mensaje = "No se pudo guardar la pregunta";
}

$conn->desconectar();
?>