<?php

//INCLUYO LA CONFIGURACION DE SAMRTY
require_once("libs/funciones.php");
require_once("libs/class.Conexion.BD.php");
include_once("configuracion.php");


session_start();

$accion = isset($_POST["accion"]) ? $_POST["accion"] : $_GET["accion"];

$logins = array();

$conn->conectar();

$conn->consulta("select * from usuarios");

$resultados = $conn->restantesRegistros();

foreach($resultados as $res){
    $logins[$res["email"]] = $res["password"];
    $logins[$res["email"]."_id"] = $res["id"];
}

// print_r($logins);
// die();

$conn->desconectar();

if(isset($_SESSION["user"])){
    header("location: publicaciones.php");
    exit;
}

if ($accion == "login") {
    if (isset($logins[$_POST["email"]]) && md5($_POST["password"]) == $logins[$_POST["email"]]) {
        $_SESSION["user"] = array(
            "id_usuario" => $logins[$_POST["email"]."_id"],
            "nombre" => $_POST["email"],
            "addr" => $_SERVER["REMOTE_ADDR"],  
            "accesoLegible" => time_elapsed(time()),
            "acceso" => time(),
            "uacceso" => time()
        );
        header("location: publicaciones.php");
        exit;
    } else {
        $mensaje = "El usuario o contraseña ingresados son incorrectos";
    }
} else if ($accion == "logout") {
    unset($_SESSION["user"]);
    session_destroy();
    header("location: " . $_SERVER["PHP_SELF"]);
    die();
}

/*
 * PROCESO EL CONTENIDO DEL TEMPLATE
 */
$smarty->assign("user", $_SESSION["user"]);
$smarty->assign("mensaje", $mensaje);
$smarty->assign("logueado", isset($_SESSION["user"]));
$smarty->assign("inactividad", $inactividad);


/*
 * ENVIO EL TEMPLATE AL CLIENTE
 */
$smarty->display('login.tpl');

?>
