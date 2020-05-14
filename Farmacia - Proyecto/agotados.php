<?php
session_start();

//variables del login
$numColegiado=$_SESSION['numColegiado'];
$contrasena=$_SESSION['contrasena'];


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>FarmaPlus 3000 - Medicamentos Agotados</title>

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
				  
				  echo "<h2>Medicamentos Agotados</h2>";
				  
							// recojo desde donde quieres paginar
					$p=$_GET['p'];			

						
						if($p=='') $p=1;
				
						// consulta SQL a imprimir paginada
						$r=mysql_query("SELECT medicamentosgeneral.codigo, medicamentosgeneral.nombre, medicamentosgeneral.descripcion, medicamentosgeneral.precio, medicamentosgeneral.laboratorio
						FROM medicamentosgeneral, medicamentosfarmacia
						WHERE medicamentosgeneral.codigo=medicamentosfarmacia.codigo
						AND medicamentosfarmacia.cantidad=0");
						

						// Muestro los medicamentos correspondientes
						paginaAgotados($r,$p,10);

						// Enlaces a los siguientes bloques
						$num_regs=mysql_num_rows($r);
						// Muestro enlaces
						for($i=1;$i<$num_regs;$i=$i+9){
							echo "<a href=agotados.php?p=",$i,">",round($i/10),"</a> ";
						}
				
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