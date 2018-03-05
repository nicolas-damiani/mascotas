<?php
session_start();

//INCLUYO LA CONFIGURACION DE SAMRTY
require_once("libs/funciones.php");
require_once("libs/class.Conexion.BD.php");
include_once("configuracion.php");

$accion = isset($_POST["accion"]) ? $_POST["accion"] : $_GET["accion"];

$logins = array();

$conn->conectar();

$conn->consulta("select * from usuarios");

$resultados = $conn->restantesRegistros();

foreach($resultados as $res){
    $logins[$res["login"]] = $res["password"];
}

// print_r($logins);
// die();

$conn->desconectar();

if(isset($_SESSION["user"])){
    
    $diferencia = $_SESSION["user"]["uacceso"] - $_SESSION["user"]["acceso"];
    
    if($diferencia > 60) {
        $accion = "logout";
    }
    
    $inactividad = time_elapsed($diferencia);
    
    $_SESSION["user"]["uacceso"] = time();
}

if ($accion == "login") {
    if (isset($logins[$_POST["usuario"]]) && md5($_POST["password"]) == $logins[$_POST["usuario"]]) {
        $_SESSION["user"] = array(
            "nombre" => $_POST["usuario"],
            "addr" => $_SERVER["REMOTE_ADDR"],  
            "accesoLegible" => time_elapsed(time()),
            "acceso" => time(),
            "uacceso" => time()
        );
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
$smarty->display('login.tpl.html');

?>
