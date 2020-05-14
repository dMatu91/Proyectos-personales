<?php
session_start();

//variables del login
$numColegiado=$_SESSION['numColegiado'];
$contrasena=$_SESSION['contrasena'];


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>FarmaPlus 3000 - Recepción</title>

<link href="estilos.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="bg">
	<div id="main">
<!-- header -->
		<div id="header">
			
			<div id="logo">
				<a href="principal.php">Volver</a>
			</div>

		</div>
    
<!-- / header -->
<!-- content -->

		<div id="content">
			<h1>FARMAPLUS 3000 </h1>
	      <p>&nbsp;</p>
          
          <?php
		  
		  	// conexion con la BD
			include "funciones.php";
			$conexion=conecta();
			
				//se hace la orden
			$orden="SELECT nColegiado, contrasena 
						FROM farmaceuticos
						WHERE nColegiado='".$numColegiado."' and contrasena='".$contrasena."'";     			
										
			 
			$orden=mysql_query($orden);	
		
		
			if($recorre=mysql_fetch_array($orden)){
			
					//Recibimos las variables
					$codigo=$_POST['codigo'];
					$cantidad=$_POST['cantidad'];
					$dia=$_POST['dia'];
					$mes=$_POST['mes'];
					$anno=$_POST['anno'];
				  
				  
					if($codigo!=""){
						
						$fecha=$anno."/".$mes."/".$dia;
						
						$recepcion=recepcionar($codigo,$cantidad,$fecha);

						echo $recepcion;
						echo "<p></p>";
						
						
					}
				  
				  
				    echo "<h2>Recepción de Medicamentos</h2>";
				  
						echo "<form class='form-3' method='post' action='recepcionMedicamentos.php' name='buscar'>";

					echo "<p>
						<label for='libro'>Código del medicamento</label>";
					  echo "<input type='text' name='codigo' placeholder='Código del medicamento' required>
				
						<label for='autor'>Cantidad</label>
						<input type='text' name='cantidad' placeholder='Cantidad' required> 
						
						<label for='autor'>Día de Caducidad</label>
						<input type='number' name='dia' placeholder='Día de Caducidad' min='1' max='31' required> 
						
						<label for='autor'>Mes de Caducidad</label>
						<input type='number' name='mes' placeholder='Mes de Caducidad' min='1' max='12' required> 
						
						<label for='autor'>Año de Caducidad</label>
						<input type='number' name='anno' placeholder='Año de Caducidad' min='2016' max='2100' required> 
						
					</p>";

				   echo "<p>

					<input  class='button white' name='Recepcionar' value='Recepcionar' type='submit'> ";

					echo "<input  class='button white' name='limpiar' value='Limpiar' type='reset'><br>
					</p>";

					echo "</form>";
		  
		  	}else{
			
					echo "<div id='menu'>";
						echo "<ul>";
					
					echo "</ul>";
					echo "</div>";
					
					echo "<div align='center'>";
					echo"<br>
					Acceso no autorizado
					<br>
					Usuario o clave incorrectos
					<br>";
					echo "<form class='form-3' method='post' action='index.php' name='volver'>

					<input name='volver' value='volver' type='submit'>";
					echo "</form>";
				
					echo "</div>";
				
			}	
		  
		  
		  ?> 
          
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