<?php
session_start();

//recogemos las variables
$numColegiado=$_POST['numColegiado'];
$contrasena=$_POST['clave'];

if($numColegiado==""){
	
	//recibo el nombre
	$numColegiado=$_SESSION['numColegiado'];
	$contrasena=$_SESSION['contrasena'];
	
}


// Lo almaceno en la sesion
$_SESSION['numColegiado']=$numColegiado;
$_SESSION['contrasena']=$contrasena;




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>FarmaPlus 3000 - Principal</title>

<link href="estilos.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="bg">
	<div id="main">
<!-- header -->
		<div id="header">
			
			<div id="logo">
				<a href="index.php">Salir</a>

			</div>

		</div>
<!-- / header -->
<!-- content -->

		<div id="content">
		
		
		
		<?php


		//conexion con la BD
		include "funciones.php";
		$conexion=conecta();
		
		
		//se hace la orden
		$orden="SELECT nColegiado, contrasena 
					FROM farmaceuticos
					WHERE nColegiado='".$numColegiado."' and contrasena='".$contrasena."'";     			
									
		 
		$orden=mysql_query($orden);	
		
		
		if($recorre=mysql_fetch_array($orden)){
		
			echo "<h1>Bienvenido a :</h1>";
			echo "<img src='images/cruz-verde2.jpg' alt='' width='154' height='151' class='img_l' />";
			
			//se hace la orden
			$individuo="SELECT nombre, apellidos
						FROM farmaceuticos
						WHERE nColegiado='".$numColegiado."' and contrasena='".$contrasena."'";     			
										
			 
			$individuo=mysql_query($individuo);	
			
			$individuo=mysql_fetch_array($individuo);
	
           
           echo "<h1>FARMAPLUS 3000</h1>";
		   echo "<br/>"; 
			echo "Farmacia MariPili<br/><br/>
			 Farmacéutico: ",$individuo[0]," ",$individuo[1];
			echo "<br/>"; 
				echo "<br/>"; 
					echo "<br/>"; 
					
			echo "<div class='razd_g'></div><br/>";
			echo "<div class='col'>";
				echo "<h1>Búsqueda Avanzada de Medicamentos</h1>";
                
				echo "<div align='center'>";                
				echo "<form method='post' action='busqueda.php' name='login'>
				  <blockquote>
					<p>
					   
					  <input  class='button white' name='busqueda' value='Búsqueda Avanzada' type='submit'> 
					  
					</p>
				  </blockquote>
				</form>
				</div>
			</div>";
			echo "<div class='col_razd'></div>
			   <div class='col'>
				<h1 class='tit'>Venta de Medicamentos</h1>
                <div align='center'> 
                <form method='post' action='ventas.php' name='login'>
				  <blockquote>
					<p>
					  <input class='button white' name='busqueda' value='Venta de medicamentos' type='submit'> 
					  
					</p>
				  </blockquote>
				</form>
				</div>
			</div>";
			echo "<div class='col_razd'></div>
			<div class='col'>
				<h1 class='tit'>Medicamentos Agotados</h1>
                <div align='center'> 
                <form method='post' action='agotados.php' name='login'>
				  <blockquote>
					<p>
					  <input class='button white' name='busqueda' value='Medicamentos Agotados' type='submit'> 
					  
					</p>
				  </blockquote>
				</form>
				</div>
			</div>";
			echo "<div style='clear: both'></div>
				<div style='height:15px; width: 100%'></div>";
				
		  echo "<div class='col'>
			<h1>Medicamentos Caducados</h1>
            
            <div align='center'> 
            <form method='post' action='caducados.php' name='login'>
			  <blockquote>
				<p>
				  <input class='button white' name='busqueda' value='Medicamentos Caducados' type='submit'> 
				  
				</p>
			  </blockquote>
			</form>
			</div>
   		  </div>";
			echo "<div class='col_razd'></div>
		  <div class='col'>
			<h1>Pedir Medicamentos</h1>
            
            <div align='center'> 
            <form method='post' action='pedido.php' name='login'>
			  <blockquote>
				<p>
			<input class='button white' name='busqueda' value='Pedir medicamentos' type='submit'> 
				  
				</p>
			  </blockquote>
			</form>
			</div>
   		 </div>";
			echo "<div class='col_razd'></div>
		  <div class='col'>
				<h1>Recepcionar Pedido</h1>
                
                <div align='center'> 
                <form method='post' action='recepcionMedicamentos.php' name='login'>
				  <blockquote>
					<p>
					  <input class='button white' name='busqueda' value='Recepcionar Pedido' type='submit'> 
					  
					</p>
				  </blockquote>
				</form>
				</div>
   			</div>";
			
                
			echo "<div class='razd_g'></div>
			<div style='clear: both'></div>";
		


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