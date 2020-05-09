<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Contacto</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<style type="text/css">
		/*
		1. para crear una clase css se una un punto mas el nombre de la clase
		2. para crear un id css se una un # mas el nombre del id
		*/

		.texto{
			color:  #0723c1;
			font-size: 32px;
		}
	</style>
</head>
<body>
	<div class="container mt-5">
		<!--Para insertar colores o estilos en un elemento html, tengo 3 maneras:
			1. Que lo haga usando el atributo style
			2. Crear una clase o id dentro del mismo documento con las propiedades que deseo aplicar
			3. Crear una clase o id en un archivo externo css con las propiedades que deseo aplicar-->
		<h4 class="text-center" style="color: #fa23f7;font-size: 24px">Gracias por contactarte con nosotros, en breve nos comunicaremos contigo</h4>
		<hr>
			<p>El correo electrónico que nos has dado es <?php echo $_GET['email']; ?></p>
		<hr>
		<p class="texto text-right">
			Este mensaje es una prueba del uso de una clase
		</p>
		<p class="prueba">
			Prueba de estilos con llamada externa
		</p>
	</div>
</body>
</html>