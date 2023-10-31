<?php
session_start();

if(isset($_POST["agregar"]) || isset($_POST["cancelar"])){

    if(isset($_POST["agregar"])){
        $nombre = $_POST["nombre"];
        $anime = $_POST["anime"];
        $tamaño = $_POST["tam"];
        $precio = $_POST["precio"];

        print_r($_POST);
        print_r($_FILES);
        $directorio = "img";

        $fp=false;
        if($_FILES['img']['size'] > 0){
            
            if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                $nombreArchivo = $_FILES['img']['name'];
                $tipoArchivo = $_FILES['img']['type'];
                $tamañoArchivo = $_FILES['img']['size'];
                $archivoTemporal = $_FILES['img']['tmp_name'];
            
                // Verificar que el archivo es una imagen (opcional)
                $permitidos = array('image/jpeg', 'image/png', 'image/gif');
                if (!in_array($tipoArchivo, $permitidos)) {
                    echo "Error: Solo se permiten archivos de imagen JPEG, PNG o GIF.";
                } else {
                    // Mover el archivo cargado al directorio de destino
                    $directorioDestino = $directorio;
                    $rutaDestino = $directorioDestino ."/". $nombreArchivo;
            
                    if (move_uploaded_file($archivoTemporal, $rutaDestino)) {
                        echo "La imagen se ha subido correctamente.";
                        $fp = fopen($rutaDestino, 'rb');
                    } else {
                        echo "Error al subir la imagen.";
                    }
                }
            } else {
                echo "Error al procesar el archivo.";
            }
        } else {
            echo "No hay imagen";
        }
/*
        if (is_uploaded_file($_FILES["imagen"]["tmp_name"])){ // Se subió el archivo{
            //$producto = insertar_producto($_POST, $_FILES["imagen"]["tmp_name"]);
            $mensajeOK = 'Producto dado de alta.';
            echo $mensajeOK;
        }
*/

        $con2 = new PDO('mysql:dbname=fesfiguras;host=localhost;charset=utf8','santimn','root');
        $con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        

        if($fp !== false){
            
            //$sql2 = 'INSERT INTO figuras (nombre,tamaño,serie,precio,url_img,img_blob) VALUES (:nombre, :tamaño, :serie, :precio, :url_imagen, :imagenblob)';
            $sql3 = "INSERT INTO `figuras` (`id`, `nombre`, `tamano`, `serie`, `precio`, `url_img`, `img_blob`) VALUES (NULL, :nombre, :tamano, :serie, :precio, :url_imagen, :imagenblob);";

            $stmt2 = $con2->prepare($sql3);

            echo $nombreArchivo;

            $stmt2->bindParam(':nombre', $nombre);
            $stmt2->bindParam(':tamano', $tamaño);
            $stmt2->bindParam(':serie', $anime);
            $stmt2->bindParam(':precio', $precio);
            $stmt2->bindParam(':url_imagen', $nombreArchivo);
            $stmt2->bindParam(':imagenblob', $fp, PDO::PARAM_LOB);

            if($stmt3->execute()){
                fclose($fp);
                header("Location: PR1-dashboard.php");
            }else{
                fclose($fp);
                header("PR1-agregar.php");
            }
                
            //echo "Resultado".$resul;

            
        }else{
            $id = null;
            //$sql = 'INSERT INTO figuras(id,nombre,tamaño,serie,precio) VALUES (:id, :nombre, :tamaño, :serie, :precio)';
            $sql3 = "INSERT INTO `figuras` (`id`, `nombre`, `tamano`, `serie`, `precio`, `url_img`, `img_blob`) VALUES (NULL, :nombre, :tamano, :serie, :precio, NULL, NULL);";

            $stmt3 = $con2->prepare($sql3);

            echo "<br>Nombre: ".$nombre;
            echo "<br>Tamaño: ".$tamaño;
            echo "<br>ANime: ".$anime;
            echo "<br>Precio: ".$precio;

            if ($stmt3->bindParam(':nombre', $nombre)) {
                echo "1";
            }
            if ($stmt3->bindParam(':tamano', $tamaño)) {
                echo '2';
            }
            if ($stmt3->bindParam(':serie', $anime)) {
                echo '3';
            }
            if ($stmt3->bindParam(':precio', $precio)) {
                echo '4';
            }
            
            if($stmt3->execute()){
                header("Location: PR1-dashboard.php");
            }else{
                header("PR1-agregar.php");
            }
                
            //echo "Resultado".$resul;
        }
        


    }else{
        header("Location: PR1-dashboard.php");
    }

}else{
    if(isset($_SESSION["user"])){
        header("Location: PR1-dashboard.php");
    }else{
        header("Location: PR1-login.php");
    }
}

?>