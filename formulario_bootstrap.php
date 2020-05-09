<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

// llamada a archivo que contiene los datos que necesitamos
require('datos.php');
//Esta pagina procesara la informacion en el mismo sitio

//comprobamos que el formulario ha sido enviado via post
//print_r($comunas);

//$mensaje = '';

if(isset($_POST['enviar']) && $_POST['enviar'] == "si"){

	//print_r($_POST);
	//Recuperacion de datos
	$email = $_POST['email'];
	$asunto = $_POST['asunto'];
	$comuna = $_POST['comuna'];
	$comentario = strip_tags($_POST['comentario']);

	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$mensaje = 'El email no es válido';
	}elseif(!filter_var($asunto, FILTER_VALIDATE_INT)){
		$mensaje = 'Seleccione un asunto';
	}elseif (!$comuna) {
		$mensaje = 'Seleccione una comuna';
	}elseif(!$comentario || strlen($comentario) < 5){
		$mensaje = 'Ingrese un comentario';
	}else{
		header('Location: contacto.php?email=' . $email);
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Ejemplo de Bootstrap</title>
	<!--Enlaces a bootstrap-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<div class="col-md-6 mt-3">
			<h2>Formulario de contacto</h2>
			<!--Area en donde se mostraran los errores del usuario-->
			<?php if(isset($mensaje)): ?>

				<p class="alert alert-danger"><?php echo $mensaje; ?></p>

			<?php endif; ?>

			<form action="" method="post">
				<div class="form-group">
					<label>Ingrese email:</label>
					<input type="email" name="email" placeholder="Correo electrónico" class="form-control" value="<?php if(@($_POST['email'])) echo $_POST['email']; ?>">
				</div>
				<div class="form-group">
					<label>Asunto:</label>
					<select name="asunto" class="form-control">
						<option value="">Seleccione una opción</option>
						<option value="1">Consultas Generales</option>
						<option value="2">Problemas Con Despacho</option>
						<option value="3">Otros</option>
					</select>
				</div>
				<div class="form-group">
					<label>Comunas:</label>
					<select name="comuna" class="form-control">
						<option value="">Seleccione una comuna</option>
						<?php foreach($comunas as $comuna): ?>
							<option value="<?php echo $comuna; ?>"><?php echo $comuna; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label>Comentarios:</label>
					<textarea name="comentario" class="form-control" placeholder="Ingrese su comentario" rows="6" style="resize: none"><?php if(@($_POST['comentario'])) echo $_POST['comentario']; ?></textarea>
				</div>
				<div class="form-group">
					<!--este input valida que la informacion sea enviada via post-->
					<input type="hidden" name="enviar" value="si">
					<button type="submit" class="btn btn-success">Enviar Comentario</button>
				</div>
			</form>
		</div>
	</div>
</body>
</html>







