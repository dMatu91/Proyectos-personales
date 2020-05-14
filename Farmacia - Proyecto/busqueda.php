<?php
session_start();

//variables del login
$numColegiado=$_SESSION['numColegiado'];
$contrasena=$_SESSION['contrasena'];


//recogemos las variables
$nombre=$_POST['nombre'];
$codigo=$_POST['codigo'];
$laboratorio=$_POST['laboratorio'];
$uso=$_POST['uso'];

if($nombre==""){
	
}else{
	
$_SESSION['nom']=$nombre;
$_SESSION['cod']=$codigo;
$_SESSION['lab']=$laboratorio;
$_SESSION['uso']=$uso;
	
}

if($codigo==""){
	
}else{
	
$_SESSION['nom']=$nombre;	
$_SESSION['cod']=$codigo;
$_SESSION['lab']=$laboratorio;
$_SESSION['uso']=$uso;
	
}

if($laboratorio==""){
	
}else{
	
$_SESSION['nom']=$nombre;	
$_SESSION['cod']=$codigo;
$_SESSION['lab']=$laboratorio;
$_SESSION['uso']=$uso;
	
}

if($uso==""){
	
}else{
	
$_SESSION['nom']=$nombre;	
$_SESSION['cod']=$codigo;
$_SESSION['lab']=$laboratorio;
$_SESSION['uso']=$uso;
	
}

$codigo=$_SESSION['cod'];
$nombre=$_SESSION['nom'];
$laboratorio=$_SESSION['lab'];
$uso=$_SESSION['uso'];


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>FarmaPlus 3000 - Búsqueda Avanzada</title>

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
			  
			  echo "<h2>Buscador de Medicamentos</h2>";
				echo "<form class='form-2' method='post' action='busqueda.php' name='buscar'>";

				echo "<p>
					<label for='libro'>Nombre del medicamento</label>";
				  echo "<input type='text' name='nombre' placeholder='Nombre del medicamento' >
				</p>";
				echo "<p>
					<label for='autor'>Código del medicamento</label>
					<input type='text' name='codigo' placeholder='Código del medicamento'> 
				</p>";
				echo "<p>
					<label for='autor'>Enfermedad a tratar</label>
					<input type='text' name='uso' placeholder='Enfermedad a tratar'> 
				</p>";
				
								//se hace la orden
					$lab="SELECT DISTINCT laboratorio
								FROM medicamentosgeneral";     			
												
					 
					$lab=mysql_query($lab);	
				
				
				
				echo "<p>
					<select name='laboratorio' placeholder='Laboratorio'>";
						echo "<option value=''>Elige un Laboratorio</option>";
						while($elemento=mysql_fetch_array($lab)){
							
							echo "<option value=",$elemento[0],">",$elemento[0],"</option>";
						}

					echo "</select>";
				echo"</p>";
			   echo "<p>

				<input  class='button white' name='buscar' value='Buscar' type='submit'> ";

				echo "<input  class='button white' name='limpiar' value='Limpiar' type='reset'><br>
				</p>";

				echo "</form>";
			  /*
			  echo $nombre;
			  echo $codigo;
			  echo $uso;
			  */
				// recojo desde donde quieres paginar, el autor y el nombre del libro
				$p=$_GET['p'];


				if($nombre=="" && $codigo=="" && $laboratorio=="" && $uso==""){	
				

				}else{

					
					if($p=='') $p=1;
			
		
					if($laboratorio==""){
						
						
							if($nombre==""){
								

								
								if($codigo==""){
									
									
									$r=mysql_query("SELECT medicamentosgeneral.nombre, medicamentosgeneral.descripcion, medicamentosgeneral.precio, medicamentosgeneral.laboratorio, medicamentosfarmacia.cantidad
									FROM medicamentosgeneral, medicamentosfarmacia
									WHERE medicamentosgeneral.codigo=medicamentosfarmacia.codigo
									AND medicamentosgeneral.descripcion LIKE '%".$uso."%' ");
									
									
								}else{
								
									$r=mysql_query("SELECT medicamentosgeneral.nombre, medicamentosgeneral.descripcion, medicamentosgeneral.precio, medicamentosgeneral.laboratorio, medicamentosfarmacia.cantidad
									FROM medicamentosgeneral, medicamentosfarmacia
									WHERE medicamentosgeneral.codigo=medicamentosfarmacia.codigo
									AND medicamentosgeneral.codigo='".$codigo."'");
									
								}
								
							}else{
								
														
								$r=mysql_query("SELECT medicamentosgeneral.nombre, medicamentosgeneral.descripcion, medicamentosgeneral.precio, medicamentosgeneral.laboratorio, medicamentosfarmacia.cantidad
								FROM medicamentosgeneral, medicamentosfarmacia
								WHERE medicamentosgeneral.codigo=medicamentosfarmacia.codigo
								AND medicamentosgeneral.nombre LIKE '%".$nombre."%' ");
								
							
								
								
							}
						

						
					}else{
						
							// consulta SQL a imprimir paginada
							$r=mysql_query("SELECT medicamentosgeneral.nombre, medicamentosgeneral.descripcion, medicamentosgeneral.precio, medicamentosgeneral.laboratorio, medicamentosfarmacia.cantidad
							FROM medicamentosgeneral, medicamentosfarmacia
							WHERE medicamentosgeneral.codigo=medicamentosfarmacia.codigo
							AND medicamentosgeneral.laboratorio='".$laboratorio."'");
					}

					
					 //AND medicamentosgeneral.codigo LIKE ''%".$codigo."%'' 
					//AND medicamentosgeneral.descripcion LIKE ''%".$uso."%'

					// Muestro los libros correspondientes
					pagina($r,$p,10);

					// Enlaces a los siguientes bloques
					$num_regs=mysql_num_rows($r);
					// Muestro enlaces
					for($i=1;$i<$num_regs;$i=$i+9){
						echo "<a href=busqueda.php?p=",$i,">",round($i/10),"</a> ";
					}
					
					
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