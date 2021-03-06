<?php

session_start();

//INCLUYO LA CONFIGURACION DE SAMRTY
require_once("libs/funciones.php");
require_once("libs/class.Conexion.BD.php");
include_once("configuracion.php");

$conn->conectar();
$accion = "";

if (isset($_POST["accion"]) && $_POST["accion"] == "razas") {
    if (isset($_POST["especie"])) {
        $especieId = $_POST["especie"];
        $razas = getRazasPorEspecie($conn, $especieId);
        echo json_encode($razas);
    }
} else {

    $elementosPorPagina = 10;
    $pagina = 1;
    if (isset($_POST["accion"]) && $_POST["p"]) {
        $accion = strlen($_POST["accion"]) ? $_POST["accion"] : $_GET["accion"];
        $pagina = strlen($_POST["p"]) ? $_POST["p"] : $_GET["p"];
        $pagina = (int) $pagina;
    } else if (isset($_GET["p"])) {
        $pagina = $_GET["p"];
        $pagina = (int) $pagina;
        die($_GET["p"]);
    }
    if ($pagina < 1)
        $pagina = 1;
// $pais = strlen($_POST["pais"]) ? $_POST["pais"] : $_GET["pais"];


    $resultado = array();
    if (isset($_POST["accion"]) && $_POST["accion"] == "filtro") {
        $accion = "filtro";
        $filtros = $_POST;
        $resultado = cargarPaginacionConFiltro($conn, $pagina, $elementosPorPagina, $filtros);
    } else {
        $resultado = cargarPaginacionSinFiltro($conn, $pagina, $elementosPorPagina);
    }

    $publicaciones = $resultado['publicaciones'];

    $paginacion = $resultado['paginacion'];



    $especies = cargarEspecies($conn);

    $barrios = cargarBarrios($conn);



    while (list($clave, $valor) = each($publicaciones)) {
        if (strlen($valor["descripcion"]) > 150) {
            $publicaciones[$clave]["descripcion"] = substr($valor["descripcion"], 0, 150) . "...";
        }
        if ($publicaciones[$clave]["tipo"] == "E")
            $publicaciones[$clave]["tipo"] = "Encontrado";
        else if ($publicaciones[$clave]["tipo"] == "P")
            $publicaciones[$clave]["tipo"] = "Perdido";

        $dir = "imgs/" . $publicaciones[$clave]["id"] . "/";

        if (is_dir($dir)) {
            $d = dir($dir);
            // echo "Handle: " . $d->handle . "\n";
            // echo "Path: " . $d->path . "\n";
            while (false !== ($entry = $d->read())) {
                // $fotos[] = $entry;
                if ($entry != "." && $entry != "..") {
                    $publicaciones[$clave]["foto"] = $entry;
                }
            }
            $d->close();
        } else {
            $publicaciones[$clave]["foto"] = "";
        }
    }

    reset($publicaciones);

    $conn->desconectar();
    /*
     * PROCESO EL CONTENIDO DEL TEMPLATE
     */


    if ($accion == "filtro") {

        echo json_encode($resultado);
    } else if ($accion == "ajax") {
        // $smarty->display("tabla.tpl");

        sleep(1);
        echo json_encode($publicaciones);
    } else {

        if (!isset($_SESSION["user"])) {
            $usuario = false;
        } else {
            $usuario = $_SESSION["user"];
        }
        $smarty->assign("publicaciones", $publicaciones);
        $smarty->assign("especies", $especies);
        $smarty->assign("barrios", $barrios);
        $smarty->assign("paginacion", $paginacion);

        $smarty->assign("usuario", $usuario);
        $smarty->assign("p", $pagina);

        $smarty->display("publicaciones.tpl");
    }
}


