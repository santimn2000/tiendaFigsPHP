<?php
session_start();
include('funciones.php');


if(isset($_SESSION["user"]) && isset($_SESSION["permisos"])){

    $user = $_SESSION["user"];
    $permisos = $_SESSION["permisos"];
}else{
    //print_r($_SESSION);
    header('Location: PR1-login.php');
}

function mostrarProductos(){
    try{
        $con = new PDO('mysql:dbname=fesfiguras;host=localhost;charset=utf8','santimn','root');
        $sql = 'SELECT * FROM figuras';

        crearTablaQuery($con, "LISTA DE FIGURAS",$sql, "figuras",array(0,1,2,3,4,5,6), "blue", "red");

    }catch(PDOException $e){
        echo 'Error: '. $e->getMessage();
    }
}

?>
<html>
    <head>
        <style>
            .info{
                display: grid;
                grid-template-columns: 1fr 1fr; /* Divide el contenedor en dos columnas de igual ancho */
                grid-gap: 10px;
            }

            .foto img{
                width: 350px;
                height: 400px;
            }
            
            .enlace{
                width: 100%;
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
    
    <div class= "info">
        <div class = "tabla">
            <?php
                mostrarProductos();
            ?>
        </div>
        <div class="foto">
            <img src="" alt="Haga click en un enlace para ver la imagen">
        </div>    
    <div>
    

    <form action="PR1-agregar.php" method="POST">
        <?php 
            if($_SESSION['permisos'] == "admin"){
                echo "<input type=\"submit\" name=\"agregarProd\" value=\"Agregar\"/><br>";
            }
        ?>
    </form>

        <script>
            
            botones =document.getElementsByClassName("enlace");

            for(i=0; i<botones.length;i++){
                botones[i].addEventListener("click", mostrarImg);
            }

            function mostrarImg(e){
                console.log(e.currentTarget);

                foto =document.getElementsByClassName("foto")[0].getElementsByTagName("img")[0];
                foto.src = "img/"+e.currentTarget.textContent;
                console.log("Texto "+e.currentTarget.textContent);
            }

        </script>
    </body>
</html>
