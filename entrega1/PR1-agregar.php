<?php
session_start();

$list_animes=array("ONE PIECE","BLEACH","NANATSU NO TAIZAI","SWORD ART ONLINE","FATE");
$list_tamaño =array("XL","grande","mediano","pequeño");

//$_SESSION["nombreVacioError"] = false;
//$_SESSION["precioNanError"] = false;
if(isset($_SESSION["user"]) && isset($_SESSION["permisos"])){

    $user = $_SESSION["user"];
    $permisos = $_SESSION["permisos"];
}else{
    //print_r($_SESSION);
    header('Location: PR1-login.php');
}
?>

<html>
    <head>
        <script>  

            function comprobarDatos() {
                var nombre = document.forms["campos"]["nombre"].value;
                var anime = document.forms["campos"]["anime"].value;
                var tam = document.forms["campos"]["tam"].value;
                var precio = document.forms["campos"]["precio"].value;

                console.log(nombre+", "+ anime+", "+tam+", "+precio)
                $mensaje = "";

                if (isNaN(precio)) {

                    if(isNaN(precio)){
                        $mensaje+= "El precio no es numérico\n"
                    }
                    return false;

                }else if(precio <= 0){
                    $mensaje+= "El precio no puede ser negativo o 0";
                    return false;
                }else{
                    numero = precio.parseFloat();
                    numeroRedondeado = numero.toFixed(2);
                    document.forms["campos"]["precio"].value =numeroRedondeado;
                }

                alert($mensaje);
            }
        </script>
        <style>
            .cuerpo{
                display: flex;
                flex-direction: row;
            }
            .barra_info{
                display: flex;
                flex-direction: row;
                justify-content: space-between;
            }
        </style>
    </head>
    <body>

        <div class="barra_info">
            Bienvenido
            <?php 
                echo $user; 
                echo "<br>Rango: ".$permisos."<br>";
                
                
            ?> 

            <div class="cerrar_sesion"><a href="PR1-login.php">Cerrar sesion</a></div>
        </div>

        <div class="cuerpo">
            
            <form class="formulario" enctype="multipart/form-data" name="campos" onsubmit="return comprobarDatos()" action="PR1-validar-figura.php" method="POST" >
                <h1>CREAR FIGURA</h1><br><br>
                Nombre de figura:  <input type="text" name="nombre" required><br><br> 
                Anime: <select name="anime">
                    <?php
                        foreach ($list_animes as $a) {
                            echo "<option value='$a'>$a</option>"; 
                        }
                    ?>     
                </select><br><br>

                Tamaño: <select name="tam">
                    <?php
                        foreach ($list_tamaño as $t) {
                            echo "<option value='$t'>$t</option>"; 
                        }
                    ?>   
                </select><br><br>
                Precio: <input type="text" name="precio" required><br><br>
                
                <input id="imagen" type="file" name="img" accept="image/*"><br><br>

                <input type="submit" name="agregar" value="Agregar">
                <input type="submit" name="cancelar" value="Cancelar">

            </form>

            <div><img id="foto" width="300px" height="350px" /></div>
        </div>

        <script>
            document.getElementById('imagen').onchange = function() {
                var reader = new FileReader(); //instanciamos el objeto de laapiFileReader
                reader.onload = function(e) {
                    document.getElementById("foto").src = e.target.result;
                };
                // carga el contenido del fichero imagen.
                reader.readAsDataURL(this.files[0]);
            };
        </script>

    </body>
</html>