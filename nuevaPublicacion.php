<?php

session_start();

//INCLUYO LA CONFIGURACION DE SAMRTY
require_once("libs/funciones.php");
require_once("libs/class.Conexion.BD.php");
include_once("configuracion.php");

$conn->conectar();

if (isset($_POST['accion'])) {
    if ($_POST['accion'] == "nuevaPublicacion") {
        if (isset($_POST['tipo']) && isset($_POST['especie']) && isset($_POST['raza']) && isset($_POST['titulo']) && isset($_POST['descripcion']) && isset($_POST['latitud']) && isset($_POST['longitud'])) {
            $id = nuevaPublicacion($conn, $_POST['tipo'], $_POST['especie'], $_POST['raza'], $_POST['barrio'], $_POST['titulo'], $_POST['descripcion'],$_POST['latitud'],  $_POST['longitud']);
            if ($id != false) {
                $dir = "imgs/" . $id . "/";

                if (!is_dir($dir)) {
                    mkdir($dir, 0777);
                }



                $error = array();
                $extension = array("jpeg", "jpg", "png", "gif");
                foreach ($_FILES["archivos"]["tmp_name"] as $key => $tmp_name) {
                    $file_name = $_FILES["archivos"]["name"][$key];
                    $file_tmp = $_FILES["archivos"]["tmp_name"][$key];
                    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                    if (in_array($ext, $extension)) {
                        if (move_uploaded_file($file_tmp, $dir . $file_name)) {
                            
                        } else {
                            array_push($error, "$file_name, ");
                        }
                    } else {
                        array_push($error, "$file_name, ");
                    }
                }


                $respuesta['status'] = "ok";
                echo json_encode($respuesta);
            } else {
                $respuesta['status'] = "error";
                echo json_encode($respuesta);
            }
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
