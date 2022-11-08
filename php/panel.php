<?php
		session_start();
	$usu1 = $_SESSION['email'];
	$pass1 = $_SESSION['password'];
	$msg = "";
	$dom = "";
	$con = mysqli_connect("localhost","adm_webgenerator","webgenerator2020","webgenerator");
    $queryusuario = mysqli_query($con,"SELECT email FROM usuarios WHERE email ='$usu1' and password = '$pass1'");
    while ($row = mysqli_fetch_array($queryusuario, MYSQLI_NUM)) {
    	$a = $row[0]; 
	}
	if (isset($usu1) && !empty($usu1)) {
		$dom = getDom($con);
		if (isset($_POST['crear'])) {
			$web = $_POST['web'];
			if ($web == "") {
				$msg = "No se ha ingresado una pagina web";
			}else{
				$web = $a.$web;
				$sql = "SELECT dominio FROM webs WHERE dominio = '".$web."';";
				$response = mysqli_query($con,$sql);
				if (mysqli_num_rows($response) >= 1) {
					$msg = "Este dominio ya existe";
				}else{
					$sql = "INSERT INTO webs (idUsuario,dominio) VALUES ('".$a."','".$web."');";
					$response = mysqli_query($con,$sql);

					
					if (true) {
					$msg = "Se ha registrado correctamente";
						shell_exec("./wix.sh " .$web." ".$web);						
						$dom = getDom($con);
					}else{
						echo "Error" .mysqli_error($con);
					}
				}
			}
		}
		if (isset($_POST['download'])) {
			$carpeta = $_POST['download'];
			var_dump($carpeta);
			$zip = $carpeta.".zip";
			echo shell_exec("zip -r ".$zip." ".$carpeta);
			$location = "location: " .$zip;
			if (!header($location)) {

				$msg = "Zip no encontrado";
			}
		}
		if (isset($_POST['delete'])) {
			$carpeta = $_POST['delete'];
			echo shell_exec(" rm -r " .$carpeta);
			$sql = "DELETE FROM webs WHERE dominio = '".$carpeta."';";
			$response = mysqli_query($con,$sql);
			if ($response) {
				$msg  = "Se elimino correctamente";
				$dom = getDom($con);
			}else{
				$msg = "Error";
			}
		}
	}else{
		
		header("location: login.php");
	}
	
	function getDom($con){
		$dom = "";
		if ( $_SESSION['admin'] == "admin") {
			$sql = "SELECT dominio FROM webs";
		}else{
			$usu = $_SESSION['usuario'];
			$sql = "SELECT dominio FROM webs WHERE idUsuario = '$usu'";
		}
		$response = mysqli_query($con,$sql);
		if (mysqli_num_rows($response) >= 1) {
			$dom .= "<ol>";
			while ($row = mysqli_fetch_array($response,MYSQLI_ASSOC)) {			
				$domm = $row['dominio'];
				$dom .= 
				"<li>
					<a href = '".$domm."'>".$domm."</a> 
					<button name='download' value='".$domm."'>Descargar WEB </button>
					<button name='delete' value='".$domm."'>Eliminar </button>
				</li>";
			}
			$dom .= "</ol>";
		}
		return $dom;
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/user/estilo.css">
	<title>Panel</title>
</head>
<body>
	
	<div id="conteiner">	

		<div class="titulo"><h1>Panel</h1></div>
		<a id="logout" href="logout.php">Cerrar sesión de <?php echo ": ".$a; ?></a>
		<form method="POST">
			<div class="panel">	
				Generar Web de: <input type="text" name="web">
				<div class="enviar">
					<input type="submit" name="crear" value="Crear web">
				</div>
			</div>
			<?php echo $msg; ?>
		</form>
		<h1>Lista de paginas</h1>
		<form method="POST">
			<?php echo $dom ?>

	</div>

	

</body>
</html>