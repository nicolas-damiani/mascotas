{* Smarty *}
<!DOCTYPE html>

<html>
    <head>
        <title>Registro</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/estilos.css" />
        <link rel="stylesheet" type="text/css" href="css/registro.css" />
        <script type="text/javascript" src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script>
            $(document).ready(function () {
                $("form").submit(function (e) {
                    var email = $("#email").val().length;
                    var user = $("#usuario").val().length;
                    var pass = $("#password").val();
                    var pass2 = $("#password2").val();

                    if (email == 0 || user == 0 || pass.length == 0 || pass2 != pass) {
                        e.preventDefault();
                        // alert("debe completar todos los datos.");

                        $("form input").removeClass("invalido");
                        $("form input").parent().find("span.error").html("");

                        if (user == 0) {
                            $("#usuario").addClass("invalido").focus();
                            $("#usuario").parent().find("span.error").html("debe completar este dato")
                        } else if (email == 0) {
                            $("#email").addClass("invalido").focus();
                            $("#email").parent().find("span.error").html("debe completar este dato")
                        } else if (pass.length == 0) {
                            $("#password").addClass("invalido").focus();
                            $("#password").parent().find("span.error").html("debe completar este dato")
                        } else {
                            $("#password2").addClass("invalido").focus();
                            $("#password2").parent().find("span.error").html("las contraseñas no coinciden")
                        }
                    }
                });
            });
        </script>

    </head>
    <body>
        <h1>REGISTRO DE USUARIO</h1>

        {if $mensaje }
            <div class="error">
                {$mensaje}
            </div>
        {/if}

        <div id="contenedorRegistro">
            <form id="contenedorForm" action="?" method="POST">
                <div class="filaRegistro">
                    <label class="labelRegistro" for="email">Email</label>
                    <input class="dataRegistro" id="email" name="email" />
                    <span class="error"></span>
                </div>
                <div class="filaRegistro">
                    <label class="labelRegistro" for="usuario">Nombre</label>
                    <input class="dataRegistro" id="usuario" name="usuario" />
                    <span class="error"></span>
                </div>
                <div class="filaRegistro">
                    <label class="labelRegistro" for="password">Contraseña</label>
                    <input class="dataRegistro" id="password" name="password" type="password" />
                    <span class="error"></span>
                </div>
                <div class="filaRegistro">
                    <label class="labelRegistro" for="password2">Repita contraseña</label>
                    <input class="dataRegistro" id="password2" name="password2" type="password" />
                    <span class="error"></span>
                </div>
                <input type="hidden" name="accion" value="registrar" />
                <button id="botonRegistro" type="submit">Registrar</button>
            </form>
        </div>

    </body>
</html>
