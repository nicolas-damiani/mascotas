<?php

session_start();

//INCLUYO LA CONFIGURACION DE SAMRTY
require_once("libs/funciones.php");
require_once("libs/class.Conexion.BD.php");
include_once("configuracion.php");

$conn->conectar();
$accion = "";

$elementosPorPagina = 2;
$pagina = 1;
if (isset($_POST["accion"]) && $_POST["p"]) {
    $accion = strlen($_POST["accion"]) ? $_POST["accion"] : $_GET["accion"];
    $pagina = strlen($_POST["p"]) ? $_POST["p"] : $_GET["p"];
    $pagina = (int) $pagina;
}
if ($pagina < 1)
    $pagina = 1;
// $pais = strlen($_POST["pais"]) ? $_POST["pais"] : $_GET["pais"];




$resultado = cargarPaginacion($conn, $pagina, $elementosPorPagina);

$publicaciones = $resultado['publicaciones'];

$paginacion = $resultado['paginacion'];

$especies = cargarEspecies($conn);

$barrios = cargarBarrios($conn);



while (list($clave, $valor) = each($publicaciones)) {
    if (strlen($valor["descripcion"]) > 150) {
        $publicaciones[$clave]["descripcion"] = substr($valor["descripcion"], 0, 50) . "...";
    }
    if ($publicaciones[$clave]["tipo"] == "E")
        $publicaciones[$clave]["tipo"] = "Encontrado";
    else if ($publicaciones[$clave]["tipo"] == "P")
        $publicaciones[$clave]["tipo"] = "Perdido";
}

reset($publicaciones);

$conn->desconectar();
/*
 * PROCESO EL CONTENIDO DEL TEMPLATE
 */


if ($accion == "ajax") {
    // $smarty->display("tabla.tpl");

    sleep(1);
    echo json_encode($publicaciones);
} else {
    $smarty->assign("publicaciones", $publicaciones);
    $smarty->assign("especies", $especies);
    $smarty->assign("barrios", $barrios);
    $smarty->assign("paginacion", $paginacion);
    $smarty->assign("p", $pagina);
    
    $smarty->display("publicaciones.tpl");
}


