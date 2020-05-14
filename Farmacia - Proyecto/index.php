<?php
session_destroy();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>FarmaPlus 3000 - Index</title>

<link href="estilos.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="bg">
	<div id="main">
<!-- header -->
		<div id="header">
			
			<div id="logo">
				<a href="#">farmaplus 3000</a>

			</div>

		</div>
<!-- / header -->
<!-- content -->

		<div id="content">

		
		
		<h2>Login</h2>
			<form class='form-2' method='post' action='principal.php' name='buscar'>

				<p>
					<label for='numero'>Número de Colegiado</label>
				  <input type='text' name='numColegiado' placeholder='Número de Colegiado' >
				</p>
				<p>
					<label for='clave'>Clave</label>
					<input type='password' name='clave' placeholder='Clave'> 
				</p>

			   <p>
				<input  class='button white' name='entrar' value='Entrar' type='submit'> 

				<input  class='button white' name='limpiar' value='Limpiar' type='reset'><br>
				</p>

			</form>
		
		
		
		</div>

<!-- / content --> 
		<div style="height:15px; width: 100%"></div>
<!-- bottom --><!-- / bottom -->
	<div id="footer">
		<p>Farmaplus 3000, diseñado por David Matute</p>


	</div>
	</div>
</div>
</body>
</html>