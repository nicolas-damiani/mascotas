{* Smarty *}
<!DOCTYPE html>

<html>
    <head>
        <title>Login</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/estilos.css" />
        <script type="text/javascript" src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script>
        $(document).ready(function(){
            $("form").submit(function(e){
               var user = $("#email").val().length;
               var pass = $("#password").val().length;
               
               if(user == 0 || pass == 0){
                   e.preventDefault();
                   // alert("debe completar todos los datos.");
                   if(user == 0){
                       $("#email").addClass("invalido").focus();
                   }else{                       
                       $("#email").removeClass("invalido");
                       $("#password").addClass("invalido").focus();
                   }
               }
            });
        });
        </script>
            
    </head>
    <body>
        {include file="encabezado.tpl"}
        {if !$logueado}
        <h1>LOGIN</h1>
        
        {if $mensaje }
            <div class="error">
                {$mensaje}
            </div>
        {/if}
        
        <form action="?" method="POST">
            <div>
                <label for="email">Email</label>
                <input id="email" name="email" />
            </div>
            <div>
                <label for="password">Contraseña</label>
                <input id="password" name="password" />
            </div>
            <input type="hidden" name="accion" value="login" />
            <button type="submit">Acceder</button>
        </form>
        
        <div>
            <a href="registro.php">
            Si no es usuario registrado puede crear una nueva cuenta aquí
            </a>
        </div>
        
        {else}
        <h1>Bienvenido {$user.nombre}</h1>
        <p>Te conectaste desde el equipo <strong>{$user.addr}</strong></p>
        
        <table>
            <tr>
                <th>Clave</th>
                <th>Valor</th>
            </tr>
            {foreach from=$user item=valor key=clave}
            <tr>
                <td>{$clave}</td>
                <td>{$valor}</td>
            </tr>
            {/foreach}
        </table>
        
            <a href="?accion=logout">Salir</a>
        {/if}
        
        <div class="error">Inactividad {$inactividad} </div>
    </body>
</html>
