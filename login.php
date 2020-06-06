<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

//requerimos la conexion a la base de datos
require('conexion.php');

if(isset($_POST['enviar']) && $_POST['enviar'] == 'si'){
	//print_r($_POST);

	$email = trim(strip_tags($_POST['email']));
	$password = trim(strip_tags($_POST['password']));

	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$mensaje = 'El email no es válido';
	}elseif (!$password) {
		$mensaje = 'Ingrese el password';	
	}else{
		//preguntamos si el email y clave ingresados existen en la tabla usuarios
		$password = sha1($password);

		$sql = $con->prepare("SELECT id, nombre, email, rol_id FROM usuarios WHERE email = ? AND password = ? AND activo = 1");
		$sql->bindParam(1, $email);
		$sql->bindParam(2, $password);
		$sql->execute();

		$res = $sql->fetch();

		if($res){
			//Crear las variables de ingreso (session) para que el usuario pueda al sistema
			$_SESSION['autenticado'] = 'si';
			$_SESSION['id'] = $res['id'];
			$_SESSION['nombre'] = $res['nombre'];
			$_SESSION['email'] = $res['email'];
			$_SESSION['rol'] = $res['rol_id'];

			header('Location: usuarios.php');
		}else{
			$mensaje = 'El usuario o password no están registrados';	
		}
	}


}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Ingreso Usuario</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<?php include('header.php'); ?>
		<div class="col-md-6 mt-3">
			<h3>Ingreso Usuario</h3>

			<?php if(isset($mensaje)): ?>
				<p class="alert alert-danger"><?php echo $mensaje; ?></p>
			<?php endif; ?>

			<form action="" method="post">
				<div class="form-group">
					<label>Email</label>
					<input type="email" name="email" placeholder="Email del usuario" class="form-control">
				</div>
				<div class="form-group">
					<label>Password</label>
					<input type="password" name="password" class="form-control" placeholder="Password del usuario">
				</div>
				<div class="form-group">
					<input type="hidden" name="enviar" value="si">
					<button type="submit" class="btn btn-success">Ingresar</button>
				</div>
			</form>
		</div>
	</div>
</body>
</html>