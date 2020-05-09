<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
	<title>Prueba de Formulario</title>
</head>
<body>
	<h2>Registro de Personas</h2>
	<hr>
	<form action="procesar.php" method="post">
		<label>Ingrese su nombre completo:</label>
		<input type="text" name="nombre" placeholder="Ingrese su nombre completo" required="required">
		<br>
		<label>Ingrese su fecha de nacimiento:</label>
		<input type="date" name="fecha_nacimiento" placeholder="Ingrese su fecha de nacimiento" required="required">
		<br>
		<label>Ingrese su email:</label>
		<input type="email" name="email" placeholder="Ingrese un correo electrónico" required="required">
		<br>
		<label>Seleccione pais:</label>
		<select name="pais">
			<option value="Chile">Chile</option>
			<option value="Argentina">Argentina</option>
			<option value="Bolivia">Bolivia</option>
		</select>
		<br>
		<input type="hidden" name="enviar" value="si">
		<input type="submit" value="Enviar">
	</form>
</body>
</html>