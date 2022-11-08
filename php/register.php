<?php  
    $msg="";
    if(isset($_POST['btnReg'])){
        $pos=strrpos($_POST['email'],'@');
        $pos2=strrpos($_POST['email'],'.com');
        if($pos === false || $pos2 === false || $pos > $pos2){
            $msg= "mail ingresado erroneamente";
        } else {
            $email = $_POST['email'];
            $c1 = $_POST['password'];
            $c2 = $_POST['repPassword'];
            //var_dump($db);
            //var_dump($result);
            if (! $result->num_rows) {
                if($c1!=$c2){
                    $msg= "Las contraseñas no coinciden";
                }else{
                    $fecha= date("Y-m-d H:i:s");
                    $con = mysqli_connect("localhost","adm_webgenerator","webgenerator2020","webgenerator");             
                    $ssql="INSERT INTO usuarios (idUsuario, email, password, fechaRegistro) VALUES (NULL, '".$email."', '".$c1."', '".$fecha."');";               
                    $res =mysqli_query($con,$ssql);
                    if($res){
                            header('location: http://mattprofe.com.ar:81/alumno/3803/ACTIVIDADES/CLASE_11/webgenerator/php/login.php');
                    }else{
                        $msg="Error.";
                    }       
                }
            }else{
                $msg= "Ya existe un user con ese email";
            }
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/user/estilo.css">
    <title>Registro</title>
</head>
<body>
    <div id="conteiner">    

        <div class="titulo"> <h1>Registrarse es simple</h1> </div> 


        <form action="" method="POST">
            
            <div class="correo">
                <input type="email" name="email" id="email" placeholder="Ingrese su correo" required>
            </div>

            <div class="contra1">
                <input type="password" name="password" id="password" placeholder="Contraseña" required>
             </div>
            <div class="contra2">
                <input type="password" name="repPassword" id="repPassword" placeholder="Repita su contraseña" required>
            </div>
           
            <div class="enviar">
                <input type="submit" value="Registrarse" name="btnReg">
            </div>
        </form>
            <center><?php echo $msg; ?></center>

            <center><a href="login.php">Ya tenes una cuenta? Inicia sesion.</a></center>
    </div>

</body>
</html>



