<?php

session_start();

//INCLUYO LA CONFIGURACION DE SAMRTY
require_once("libs/funciones.php");
require_once("libs/class.Conexion.BD.php");
include_once("configuracion.php");

$conn->conectar();

if (isset($_POST['accion'])) {
    if ($_POST['accion'] == "nuevaPublicacion") {
        if (isset($_POST['tipo']) && isset($_POST['especie']) && isset($_POST['raza']) && isset($_POST['titulo']) && isset($_POST['descripcion'])) {
            nuevaPublicacion($conn, $_POST['tipo'], $_POST['especie'], $_POST['raza'], $_POST['barrio'], $_POST['titulo'], $_POST['descripcion']);
        }
    } else if ($_POST['accion'] == "cargarRazas") {
        if (isset($_POST["especie"])) {
            $especieId = $_POST["especie"];
            $razas = getRazasPorEspecie($conn, $especieId);
            echo json_encode($razas);
        }
    }
} else {


    $usuario = $_SESSION["user"];


    $conn->consulta("select * from barrios");
    $barrios = $conn->restantesRegistros();

    $conn->consulta("select * from especies");
    $especies = $conn->restantesRegistros();


    $smarty->assign("barrios", $barrios);
    $smarty->assign("especies", $especies);
    $smarty->assign("usuario", $usuario);
    /*
     * ENVIO EL TEMPLATE AL CLIENTE
     */
    $smarty->display('nuevaPublicacion.tpl');
}
