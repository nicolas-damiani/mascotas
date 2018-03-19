<?php

session_start();

//INCLUYO LA CONFIGURACION DE SAMRTY
require_once("libs/funciones.php");
require_once("libs/class.Conexion.BD.php");
include_once("configuracion.php");
require_once('libs/fpdf.php');

$conn->conectar();

if (isset($_POST['accion'])) {
    if ($_POST['accion'] == "nuevaPregunta") {
        if (isset($_POST['idPublicacion']) && isset($_POST['texto'])) {
            nuevaPregunta($conn, $_POST['idPublicacion'], $_POST['texto']);
        }
    } else if ($_POST['accion'] == "nuevaPublicacion") {
        if (isset($_POST['tipo']) && isset($_POST['especie']) && isset($_POST['raza']) && isset($_POST['titulo']) && isset($_POST['descripcion'])) {
            nuevaPublicacion($conn, $_POST['tipo'], $_POST['especie'], $_POST['raza'], $_POST['barrio'], $_POST['titulo'], $_POST['descripcion']);
        }
    } else if ($_POST['accion'] == "cerrarPublicacion") {
        if (isset($_POST['exitosa']) && $_POST['idPublicacion']) {
            cerrarPublicacion($conn, $_POST['exitosa'], $_POST['idPublicacion']);
        }
    } else if ($_POST['accion'] == "exportarPublicacion") {

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(40, 10, utf8_decode('¡Hola, Mundo!'));
        $pdf->Output();
        $respuesta['status'] = "ok";

        echo json_encode($respuesta);
    }
} else {

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

    $creador = false;
    if ($publicacion['usuario_id'] == $usuario['id_usuario']) {
        $creador = true;
    }

    $cerrada = false;
    if (((int) $publicacion['abierto'] == 0)) {
        $cerrada = true;
        $exitosa = false;
        if (((int) $publicacion['exitoso'] == 1)) {
            $exitosa = true;
        }
    }

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
    $smarty->assign("creador", $creador);

    $smarty->assign("cerrada", bindec($publicacion['abierto']));
    $smarty->assign("exitosa", bindec($publicacion['exitoso']));
    /*
     * ENVIO EL TEMPLATE AL CLIENTE
     */
    $smarty->display('publicacion.tpl');
}
