<?php

	$msg="";

	 if (isset($_POST["btnLogin"])){
        $user= $_POST["txtEmail"];
        $pass= $_POST["txtPass"];
        $admin = "admin";

        $conexion = mysqli_connect("localhost","adm_webgenerator","webgenerator2020","webgenerator");

        $queryusuario = mysqli_query($conexion,"SELECT * FROM usuarios WHERE email = '".$user."' AND password ='".$pass."';");
        $verificacion = mysqli_num_rows($queryusuario);

        if ($verificacion == 1) {
            session_start();
            $_SESSION['email']=$user;
            $_SESSION['password']=$pass;
            $_SESSION['admin']=$admin;

            header('Location:panel.php');

        }else{

            $msg="<script>alert('Contraseña o email incorrecto')</script>";

        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/user/estilo.css">
	<title>Login</title>
</head>
    <body>
    	<div id="conteiner">
            <div class="titulo"><h1>WebGenerator Van de Velde</h1></div>
    	<form action="" method="POST">
    		<div class="correo">
                <input type="email" name="txtEmail" id="txtEmail" required placeholder="Ingrese su Correo">
            </div>
            <div class="contra1">
                <input type="password" name="txtPass" id="txtPass" required placeholder="Contraseña">
            </div>
    		
    		<div class="enviar">
                <input type="submit" value="Ingresar" name="btnLogin">
    	   </div>
                <?php   echo $msg; ?>
              		<center><a href="register.php">Registrarse.</a></center>
    	</form>
    	
        </div>
    </body>
</html>
