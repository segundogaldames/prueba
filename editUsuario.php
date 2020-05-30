<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

//requerimos la conexion a la base de datos
require('conexion.php');

if(isset($_GET['id'])){

	$id = (int) $_GET['id'];

	$usuario = $con->prepare("SELECT u.id, u.nombre, u.email, u.rol_id, u.activo, u.created_at, u.updated_at, r.nombre as rol FROM usuarios u INNER JOIN roles r ON u.rol_id = r.id WHERE u.id = ?");
	$usuario->bindParam(1, $id); //sanitizando la variable

	//ejecutar la consulta o traemos los datos efectivamente
	$usuario->execute();

	//especificar que necesitamos todos los datos
	$res = $usuario->fetch();



	if (isset($_POST['enviar']) && $_POST['enviar'] == 'si') {
		//recuperamos los datos
		$nombre = trim(strip_tags($_POST['nombre']));
		$email = trim(strip_tags($_POST['email']));
		$rol = (int) $_POST['rol'];
		$activo = (int) $_POST['activo'];


		if (!$nombre) {
			$mensaje = 'Ingrese el nombre del usuario';
		}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$mensaje = 'El email ingresado no es válido';
		}elseif (!$rol) {
			$mensaje = 'Seleccione el rol del usuario';
		}elseif (!$activo) {
			$mensaje = 'Seleccione una opción para activo';
		}else{
			//actualizar usuario
			$sql = $con->prepare("UPDATE usuarios SET nombre = ?, email = ?, rol_id = ?, activo = ?, updated_at = now() WHERE id = ?");
			$sql->bindParam(1, $nombre);
			$sql->bindParam(2, $email);
			$sql->bindParam(3, $rol);
			$sql->bindParam(4, $activo);
			$sql->bindParam(5, $id);
			$sql->execute();

			$row = $sql->rowCount();

			if($row){
				$msg = 'ok';
				header('Location: verUsuario.php?id=' . $id . '&m=' . $msg);
			}else{
				$mensaje = 'El usuario no se ha modificado';
			}
		}
	}
}



?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Editar Usuario</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<?php include('header.php'); ?>
		<div class="col-md-6 mt-3">
			<h3>Editar Usuario</h3>

			<?php if(isset($mensaje)): ?>
				<p class="alert alert-danger"><?php echo $mensaje; ?></p>
			<?php endif; ?>

			<form action="" method="post">
				<div class="form-group">
					<label>Nombre usuario</label>
					<input type="text" name="nombre" placeholder="Nombre del usuario" class="form-control" value="<?php echo $res['nombre']; ?>">
				</div>
				<div class="form-group">
					<label>Email</label>
					<input type="email" name="email" placeholder="Email del usuario" class="form-control" value="<?php echo $res['email']; ?>">
				</div>
				<div class="form-group">
					<label>Rol</label>
					<select name="rol" class="form-control">
						<!--Listar los roles disponibles-->
						<option value="<?php echo $res['rol_id'] ?>"><?php echo $res['rol'] ?></option>
						<?php 
							$roles = $con->query("SELECT id, nombre FROM roles ORDER BY nombre");
							$consulta = $roles->fetchAll();

							foreach($consulta as $cons):
						?>
							<option value="<?php echo $cons['id']; ?>"><?php echo $cons['nombre']; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label>Activo</label>
					<select name="activo" class="form-control">
						<option value="<?php echo $res['activo'] ?>">
							<?php if($res['activo']==1): ?> Activo <?php else: ?> No activo <?php endif ?>		
						</option>
						<option value="1">Activar</option>
						<option value="2">Desactivar</option>

					</select>
				</div>
				<div class="form-group">
					<input type="hidden" name="enviar" value="si">
					<button type="submit" class="btn btn-success">Editar</button>
					<a href="usuarios.php" class="btn btn-link">Volver</a>
				</div>
			</form>
		</div>
	</div>
</body>
</html>