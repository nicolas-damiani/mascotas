<?php

session_start();

//INCLUYO LA CONFIGURACION DE SAMRTY
require_once("libs/funciones.php");
require_once("libs/class.Conexion.BD.php");
include_once("configuracion.php");


$conn->conectar();

if (isset($_POST['accion']) && $_POST['accion'] == 'cargarDatos') {
    $datos['publicacionesPorEspecie'] = cargarPublicacionesPorEspecie($conn);
    $datos['publicacionesPorAbierto'] = cargarPublicacionesPorAbierto($conn);
    $datos['publicacionesExitosas'] = cargarPublicacionesPorExitoso($conn);
    
    echo json_encode($datos);
} else {
    $smarty->assign("publicacionesPorEspecie", $publicacionesPorEspecie);
    $smarty->display("estadisticas.tpl");
}