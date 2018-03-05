<?php
session_start();

//INCLUYO LA CONFIGURACION DE SAMRTY
require_once("libs/funciones.php");
require_once("libs/class.Conexion.BD.php");
include_once("configuracion.php");

$accion = isset($_POST["accion"]) ? $_POST["accion"] : $_GET["accion"];

if ($accion == "registrar") {
    
    if(strlen($_POST["usuario"]) && strlen($_POST["password"]) && $_POST["password"] == $_POST["password2"]){

        $conn->conectar();

        $param = array(
            array("login", $_POST["usuario"], "string"),
            array("password", md5($_POST["password"]), "string")
        );

        $sql = "insert usuarios (login, password, fecha_registro) "
                . "values(:login, :password, current_timestamp)";

        $conn->consulta($sql, $param);

        if ( $conn->ultimoIdInsert() > 0) {
            $_SESSION["user"] = array(
                "nombre" => $_POST["usuario"],
                "addr" => $_SERVER["REMOTE_ADDR"],  
                "accesoLegible" => time_elapsed(time()),
                "acceso" => time(),
                "uacceso" => time(),
                "registro" => date()
            );
            
            header("location: index.php");
            die();
            
        } else {
            $mensaje = "Los datos ingresados son incorrectos";
        }

        $conn->desconectar();
    } else {
        $mensaje = "Los datos ingresados son incorrectos";       
    }
} 

/*
 * PROCESO EL CONTENIDO DEL TEMPLATE
 */
$smarty->assign("mensaje", $mensaje);

/*
 * ENVIO EL TEMPLATE AL CLIENTE
 */
$smarty->display('registro.tpl.html');

?>
