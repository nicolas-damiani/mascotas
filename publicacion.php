<?php

session_start();

//INCLUYO LA CONFIGURACION DE SAMRTY
require_once("libs/funciones.php");
require_once("libs/class.Conexion.BD.php");
include_once("configuracion.php");

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
    } else if ($_POST['accion'] == "responderPregunta") {
        if (isset($_POST['idPregunta']) && $_POST['respuesta']) {
            responderPregunta($conn, $_POST['idPregunta'], $_POST['respuesta']);
        }
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

    $sql = "SELECT * from publicaciones where id = :id";

    $conn->consulta($sql, $param);

    $publicacion = $conn->siguienteRegistro();

    $creador = false;
    if ($publicacion['usuario_id'] == $usuario['id_usuario']) {
        $creador = true;
    }

    $cerrada = false;
 /*   if (((int) $publicacion['abierto'] == 0)) {
        $cerrada = true;
        $exitosa = false;
        if (((int) $publicacion['exitoso'] == 1)) {
            $exitosa = true;
        }
    }*/

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


    $dir = "imgs/" . $_GET["publicacion"] . "/";
    $fotos = array();


    if (is_dir($dir)) {
        $d = dir($dir);
        // echo "Handle: " . $d->handle . "\n";
        // echo "Path: " . $d->path . "\n";
        while (false !== ($entry = $d->read())) {
            // $fotos[] = $entry;
            if ($entry != "." && $entry != "..") {
                array_push($fotos, $entry);
            }
        }
        $d->close();
    }





    $smarty->assign("publicacion", $publicacion);
    $smarty->assign("fotos", $fotos);
    $smarty->assign("especie", $especie);
    $smarty->assign("preguntas", $preguntas);
    $smarty->assign("usuario", $usuario);
    $smarty->assign("creador", $creador);

    /*
     * ENVIO EL TEMPLATE AL CLIENTE
     */
    $smarty->display('publicacion.tpl');
}
