<?php

session_start();
session_destroy();

?>

<html>
    <body>
        <h1>LOGIN DE USUARIOS</h1>

        <form action="PR1-validar-usuario.php" method="POST">
            Usuario: <input type="text" name="user"/>
            <?php
            if(isset($_SESSION['userError'])){
                if($_SESSION['userError'] == true){
                    echo "<span color=red>Usuario no válido</span>";
                }
            }
            ?>
            <br>
            <br>
            Contraseña: <input type="password" name="passwd"/>
            <?php
            if(isset($_SESSION['passwdError'])){
                if($_SESSION['passwdError'] == true){
                    echo "<span color=red>Contraseña no valida</span>";
                }
            }
            ?>
            <br>

            <?php
            if(isset($_SESSION['loginError'])){
                if($_SESSION['loginError'] == true){
                    echo "<p style=\"color:red\">Usuario y contraseña no coinciden</p> <br>";
                }
            }
            ?>
            <input type="submit" name="enviar" value="Enviar"/> 
        </form>
    </body>
</html>
