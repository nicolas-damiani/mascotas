<?php/*
session_start();

//INCLUYO LA CONFIGURACION DE SAMRTY
require_once("libs/funciones.php");
require_once("libs/class.Conexion.BD.php");
include_once("configuracion.php");

$accion = isset($_POST["accion"]) ? $_POST["accion"] : $_GET["accion"];

if(isset($_SESSION["user"])){
    
    $diferencia = $_SESSION["user"]["uacceso"] - $_SESSION["user"]["acceso"];
    
    if($diferencia > 60) {
        $accion = "logout";
    }
    
    $inactividad = time_elapsed($diferencia);
    
    $_SESSION["user"]["uacceso"] = time();
}

if ($accion == "login") {

    $conn->conectar();
    
    $param = array(
        array("email", $_POST["email"], "string"),
        array("password", md5($_POST["password"]), "string")
    );
    
    $sql = "select * from usuarios where email = :email and password = :password";

    $conn->consulta($sql, $param);

    if ( $resultado = $conn->siguienteRegistro()) {
        $_SESSION["user"] = array(
            "id_usuario" => $resultado["id"],
            "nombre" => $resultado["login"],
            "addr" => $_SERVER["REMOTE_ADDR"],  
            "accesoLegible" => time_elapsed(time()),
            "acceso" => time(),
            "uacceso" => time(),
            "registro" => $resultado["fecha_registro"]
        );
    } else {
        $mensaje = "El usuario o contraseña ingresados son incorrectos";
    }

    
    $conn->desconectar();

} else if ($accion == "logout") {
    unset($_SESSION["user"]);
    session_destroy();
    header("location: " . $_SERVER["PHP_SELF"]);
    die();
}

/*
 * PROCESO EL CONTENIDO DEL TEMPLATE
 
$smarty->assign("user", $_SESSION["user"]);
$smarty->assign("mensaje", $mensaje);
$smarty->assign("logueado", isset($_SESSION["user"]));
$smarty->assign("inactividad", $inactividad);


/*
 * ENVIO EL TEMPLATE AL CLIENTE
 
$smarty->display('login.tpl.html');
*/
?>
