<?php
session_start();

if(isset($_POST['enviar'])){

    if(strlen($_POST['user']) <= 0){
        $_SESSION['userError'] = true;
        header("Location: PR1-login.php");
    }
    if(strlen($_POST['passwd']) <= 0){
        $_SESSION['passwdError'] = true;
        header("Location: PR1-login.php");
    }
    
    if(strlen($_POST['user']) > 0 && strlen($_POST['passwd']) > 0){
        $passwd = sha1($_POST['passwd']);

        $con = new PDO('mysql:dbname=fesfiguras;host=localhost;charset=utf8','santimn','root');
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'SELECT * FROM usuarios WHERE usuario=:user AND password=:passwd';
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':user', $_POST['user']);
        $stmt->bindValue(':passwd', $passwd);
        $stmt->execute();

        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if($res == false){
            $_SESSION['loginError'] = true;
            header("Location: PR1-login.php");
        }else{
            $_SESSION['userError'] = false;
            $_SESSION['passwdError'] = false;
            $_SESSION['loginError'] = false;
            echo "Correcto";
            $_SESSION['user'] = $_POST['user'];
            $_SESSION['permisos'] = $res['permiso'];
            header("Location: PR1-dashboard.php");
        }
    }

        
}else{

    if(isset($_SESSION['user'])){
        header("Location: PR1-dashboard.php");
    
        
    }else{
        echo "Primero debes iniciar sesion";
        echo "<br>";
        echo "<a href=\"PR1-login.php\">Iniciar sesion</a>";
    
    }



}


?>