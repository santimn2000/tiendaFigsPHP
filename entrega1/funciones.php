<?php

function crearTablaQuery($conexion, $titulo, $query, $tabla, $campos_a_mostrar, $colorHeads, $colorCeldas){
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $listaCampos = array();
    $desc = "DESCRIBE $tabla";
    $result = $conexion->prepare($desc);
    $result->execute();
    //$fields = $result->setFetchMode(PDO::FETCH_ASSOC);
    
    if ($result) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            array_push($listaCampos, $row['Field']);
        }
    } else {
        echo "Error en la consulta: " . $conexion->errorInfo()[2];
    }

    //echo "Lista total campos: ";
    //print_r($listaCampos);

    $stmt = $conexion->prepare($query);
    $stmt->execute();
    //$fila = $stmt->fetch(PDO::FETCH_ASSOC);

    //print_r($fila["nom_prod"]);

    $nomClavesAMostrar = array();

    
    echo "<table border=1>";
    echo "<caption>".$titulo."</caption>";

    echo "<thead bgcolor=".$colorHeads.">";


    if(count($campos_a_mostrar) == 0){
        foreach(array_values($listaCampos) as $campo){
            echo "<th>".$campo."</th>";
        }
    }else{
        for($i=0; $i<count($campos_a_mostrar); $i++){
            array_push($nomClavesAMostrar, $listaCampos[$campos_a_mostrar[$i]]);
            echo "<th>".$listaCampos[$campos_a_mostrar[$i]]."</th>";
        }
    }
    
    echo "</thead>";

    //echo "Lista total campos: ";
    //print_r($nomClavesAMostrar);
   
    //echo "<thead><th>DNI</th><th>Nombre</th><th>Apellidos</th> <th>Poblacion</th></thead>";
    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
        
        echo "<tr>";

        if(count($campos_a_mostrar) == 0){
            foreach(array_values($fila) as $campo){
                echo "<td bgcolor=".$colorCeldas.">".$campo."</td>";
            }
            echo "<td bgcolor=".$colorCeldas."><button>".$campo."</button></td>";

        }else{
            
            for($i=0; $i<count($nomClavesAMostrar); $i++){
                /*if($i<count($nomClavesAMostrar)-1){
                    echo "<td bgcolor=".$colorCeldas.">".$fila[$nomClavesAMostrar[$i]]."</td>";
                }else{
                    if($fila[$nomClavesAMostrar[$i]] == "" || $fila[$nomClavesAMostrar[$i]] === null){
                        echo "<td bgcolor=".$colorCeldas.">NULL</td>";

                    }else{
                        echo "<td bgcolor=".$colorCeldas."><button class=\"enlace\">".$fila[$nomClavesAMostrar[$i]]."</button></td>";
                    }
                }*/
                if($nomClavesAMostrar[$i] == "url_img"){
                    if($fila[$nomClavesAMostrar[$i]] == "" || $fila[$nomClavesAMostrar[$i]] === null){
                        echo "<td bgcolor=".$colorCeldas.">NULL</td>";

                    }else{
                        echo "<td bgcolor=".$colorCeldas."><button class=\"enlace\">".$fila[$nomClavesAMostrar[$i]]."</button></td>";
                    }
                }else if($nomClavesAMostrar[$i] == "img_blob"){
                    if($fila[$nomClavesAMostrar[$i]] == "" || $fila[$nomClavesAMostrar[$i]] === null){
                        echo "<td bgcolor=".$colorCeldas.">NULL</td>";

                    }else{
                        echo'<td><img src="data:image/jpeg;base64,'.base64_encode($fila[$nomClavesAMostrar[$i]]).'" height=50px ></td>';
                    }
                }else{
                    echo "<td bgcolor=".$colorCeldas.">".$fila[$nomClavesAMostrar[$i]]."</td>";
                }
                
            }

        }

        echo "</tr>";
    }

    echo "</table>";
    echo "Numero de filas: ".$stmt->rowCount();
}

?>