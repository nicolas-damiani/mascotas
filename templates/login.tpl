{* Smarty *}
<!DOCTYPE html>

<html>
    <head>
        <title>Login</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/estilos.css" />
        <link rel="stylesheet" type="text/css" href="css/login.css" />
        <script type="text/javascript" src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script>
            $(document).ready(function () {
                $("form").submit(function (e) {
                    var user = $("#email").val().length;
                    var pass = $("#password").val().length;

                    if (user == 0 || pass == 0) {
                        e.preventDefault();
                        // alert("debe completar todos los datos.");
                        if (user == 0) {
                            $("#email").addClass("invalido").focus();
                        } else {
                            $("#email").removeClass("invalido");
                            $("#password").addClass("invalido").focus();
                        }
                    }
                });
            });
        </script>

    </head>
    <body>
        {if !$logueado}
            <div id="tituloLogin">LOGIN</div>

            <img id="logoLogin" src='/Obligatorio/imgs/logo.png'>

            <div id="contenedorForm">
                {if $mensaje }
                    <div class="error">
                        {$mensaje}
                    </div>
                {/if}
                <form action="?" method="POST">
                    <div id="contenedorEmail">
                        <label id="labelEmail" for="email">Email</label>
                        <input id="email" name="email" />
                    </div>
                    <div id="contenedorPassword">
                        <label id="labelPassword" for="password">Contraseña</label>
                        <input id="password" type="password" name="password" />
                    </div>
                    <input type="hidden" name="accion" value="login" />
                    <button id="botonLogin" type="submit">Acceder</button>
                </form>
                <a href="registro.php">
                    <div id="registrarseLabel">
                        Si no es usuario registrado puede crear una nueva cuenta aquí
                    </div>
                </a>
            </div>


        {/if}
    </body>
</html>
