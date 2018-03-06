<?php

session_start();

//INCLUYO LA CONFIGURACION DE SAMRTY
require_once("libs/funciones.php");
require_once("libs/class.Conexion.BD.php");
include_once("configuracion.php");


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

$conn->conectar();

$sql = "select count(*) as cantidad from publicaciones";

$conn->consulta($sql);

$res = $conn->siguienteRegistro();

$cantidadPaginas = (int) $res["cantidad"];

$cantidadPaginas = ceil($cantidadPaginas / $elementosPorPagina);

$conn->desconectar();

$anterior = $pagina - 1 < 1 ? 1 : $pagina - 1;
$siguiente = $pagina + 1 > $cantidadPaginas ? $cantidadPaginas : $pagina + 1;

$conn->conectar();

$sql = "select * from publicaciones order by id desc limit :offset, :cantidad";

$param = array(
    array("offset", ($pagina - 1) * $elementosPorPagina, "int"),
    array("cantidad", $elementosPorPagina, "int"),
);

$conn->consulta($sql, $param);

$resultado = $conn->restantesRegistros();

$conn->desconectar();

$paginacion = array();

$paginacion[] = array("p" => 1, "texto" => "&lt;&lt;");
$paginacion[] = array("p" => $anterior, "texto" => "&lt;");

for ($i = 1; $i <= $cantidadPaginas; $i++) {

    $paginacion[] = array("p" => $i, "texto" => "" . $i, "sel" => ($pagina == $i));
}

$paginacion[] = array("p" => $siguiente, "texto" => "&gt;");
$paginacion[] = array("p" => $cantidadPaginas, "texto" => "&gt;&gt;");



while (list($clave, $valor) = each($resultado)) {
    if (strlen($valor["descripcion"]) > 150) {
        $resultado[$clave]["descripcion"] = substr($valor["descripcion"], 0, 50) . "...";
    }
    if ($resultado[$clave]["tipo"] == "E")
        $resultado[$clave]["tipo"] = "Encontrado";
    else if ($resultado[$clave]["tipo"] == "P")
        $resultado[$clave]["tipo"] = "Perdido";
}

reset($resultado);

/*
 * PROCESO EL CONTENIDO DEL TEMPLATE
 */
if ($accion == "ajax") {
    // $smarty->display("tabla.tpl");

    sleep(1);
    echo json_encode($resultado);
} else {
    $smarty->assign("publicaciones", $resultado);
    $smarty->assign("paginacion", $paginacion);
    $smarty->assign("p", $pagina);

    $smarty->display("publicaciones.tpl.html");
}

