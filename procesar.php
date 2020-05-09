<?php
//mecanismo de despliegue de errores de php
error_reporting(E_ALL);
ini_set('display_errors', '1');

//print_r($_POST);

if(isset($_POST['enviar']) && $_POST['enviar'] == "si"){
	//imprimir todas las variables post del formulario
	//print_r($_POST);
	$nombre = $_POST['nombre'];
	$fecha_nac = $_POST['fecha_nacimiento'];
	$email = $_POST['email'];
	$pais = $_POST['pais'];

	//se crea una instancia de la clase DateTime a traves del metodo date_create
	//catching => transformacion de un tipo de dato a otro
	$date = date_create($fecha_nac);

	if (!$nombre) {
		//mostrar alerta en un parrafo de color rojo
		echo "<p style='color:red'>Debe ingresar su nombre</p>";
	}elseif (!$fecha_nac) {
		echo "<p style='color:red'>Debe ingresar su fecha de nacimiento</p>";
	}elseif (!$email) {
		echo "<p style='color:red'>Debe ingresar su correo electrónico</p>";
	}

}else{
	echo "los datos no han sido enviados via post";
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Bienvenida</title>
</head>
<body>
	<h3 style="color: blue">
		Bienvenid@ <?php echo $nombre; ?>
	</h3>
	<p style="color: green">
		Usted nació el <?php echo date_format($date,'d-m-Y'); ?> y el correo electrónico ingresado es <?php echo $email; ?>
	</p>
	<p style="color: green">
		Usted es de <?php echo $pais; ?>
	</p>
</body>
</html>