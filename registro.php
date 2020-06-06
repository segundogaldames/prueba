<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

//requerimos la conexion a la base de datos
require('conexion.php');

if (isset($_POST['enviar']) && $_POST['enviar'] == 'si') {
	//recuperamos los datos
	$nombre = trim(strip_tags($_POST['nombre']));
	$email = trim(strip_tags($_POST['email']));
	$password = trim(strip_tags($_POST['password']));
	$repassword = trim(strip_tags($_POST['repassword']));


	if (!$nombre) {
		$mensaje = 'Ingrese el nombre del usuario';
	}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$mensaje = 'El email ingresado no es válido';
	}elseif (!$password || strlen($password) < 8) {
		$mensaje = 'El password debe tener al menos 8 carateres';
	}elseif ($password != $repassword) {
		$mensaje = 'El password ingresado no coincide';
	}else{
		//verificar que no haya otro usuario con el mismo email
		$res = $con->prepare("SELECT id FROM usuarios WHERE email = ?");
		$res->bindParam(1, $email);
		$res->execute();
		$cons = $res->fetch();

		if ($cons) {
			$mensaje = 'El usuario ingresado ya existe... intentelo nuevamente';
		}else{
			//enviar los datos a la base de datos
			// activo = 1 y no activo = 2
			//encriptar el campo password
			$password = sha1($password);

			$sql = $con->prepare("INSERT INTO usuarios VALUES(null, ?, ?, ?, 4, 1, now(),now())");
			$sql->bindParam(1, $nombre);
			$sql->bindParam(2, $email);
			$sql->bindParam(3, $password);
			$sql->execute();

			//numero de registros ingresados
			$row = $sql->rowCount();
			if ($row) {
				$_SESSION['success'] = 'Usted se ha registrado correctamente... Debe iniciar sesión para continuar';
				header('Location: galeriaProductos.php?');
			}else{
				$mensaje = 'Usted no ha podido ser registrado... intente mas tarde';
			}
		}
	}
}
if(!isset($_SESSION['autenticado'])):
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Crear Cliente</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<?php include('header.php'); ?>
		<div class="col-md-6 mt-3">
			<h3>Nuevo Cliente</h3>

			<?php if(isset($mensaje)): ?>
				<p class="alert alert-danger"><?php echo $mensaje; ?></p>
			<?php endif; ?>

			<form action="" method="post">
				<div class="form-group">
					<label>Nombre usuario</label>
					<input type="text" name="nombre" placeholder="Nombre del usuario" class="form-control" value="<?php echo @($nombre); ?>">
				</div>
				<div class="form-group">
					<label>Email</label>
					<input type="email" name="email" placeholder="Email del usuario" class="form-control" value="<?php echo @($email); ?>">
				</div>
				<div class="form-group">
					<label>Password</label>
					<input type="password" name="password" class="form-control" placeholder="Password del usuario">
				</div>
				<div class="form-group">
					<label>Confirmar Password</label>
					<input type="password" name="repassword" class="form-control" placeholder="Confirmar Password del usuario">
				</div>
				<div class="form-group">
					<input type="hidden" name="enviar" value="si">
					<button type="submit" class="btn btn-success">Registrar</button>
					<a href="usuarios.php" class="btn btn-link">Volver</a>
				</div>
			</form>
		</div>
	</div>
</body>
</html>
<?php
else:
	header('Location: galeriaProductos.php');
endif;
?>