<?php

session_start();

//INCLUYO LA CONFIGURACION DE SAMRTY
require_once("libs/funciones.php");
require_once("libs/class.Conexion.BD.php");
include_once("configuracion.php");


if (!(isset($_SESSION["user"]))){
    header("location: publicaciones.php");
    exit;
}

$conn->conectar();

if (isset($_POST['accion']) && $_POST['accion'] == 'cargarDatos') {
    $datos['publicacionesPorEspecie'] = cargarPublicacionesPorEspecie($conn);
    $datos['publicacionesPorAbierto'] = cargarPublicacionesPorAbierto($conn);
    $datos['publicacionesExitosas'] = cargarPublicacionesPorExitoso($conn);
    
    echo json_encode($datos);
} else {
    if (!isset($_SESSION["user"])) {
        $usuario = false;
    } else {
        $usuario = $_SESSION["user"];
    }
    $smarty->assign("publicacionesPorEspecie", $publicacionesPorEspecie);
    $smarty->assign("usuario", $usuario);
    $smarty->display("estadisticas.tpl");
}