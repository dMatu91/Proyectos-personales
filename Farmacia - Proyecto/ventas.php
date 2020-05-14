<?php
session_start();

//variables del login
$numColegiado=$_SESSION['numColegiado'];
$contrasena=$_SESSION['contrasena'];


//recogemos las variables
$nombre=$_POST['nombre'];
$codigo=$_POST['codigo'];


$codigoBorrar=$_POST['codigoBorrar'];
$cantidadBorrar=$_POST['cantidadBorrar'];
$medicamentoBorrar=$_POST['medicamentoBorrar'];


if($nombre==""){
	
}else{
	
$_SESSION['nom']=$nombre;
$_SESSION['cod']=$codigo;
	
}

if($codigo==""){
	
}else{
	
$_SESSION['nom']=$nombre;	
$_SESSION['cod']=$codigo;
	
}

$codigo=$_SESSION['cod'];
$nombre=$_SESSION['nom'];


$codigoVenta=$_POST['codigoVenta'];
$cantidadVenta=$_POST['cantidadVenta'];
$nombreVenta=$_POST['nombreVenta'];

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>FarmaPlus 3000 - Medicamentos Caducados</title>

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
				
			  
				if($codigoBorrar!=""){
					
					$borrar=borraVenta($codigoBorrar, $cantidadBorrar, $medicamentoBorrar);
					
				}
				
				
				
				if($codigoVenta!="" && $cantidadVenta!=""){
					
					//$pedir=pedir($codigoPedido,$cantidadPedido);
					
					$comprueba=compruebaCaducidad($codigoVenta);
					
					if($comprueba==0){
						
						echo "Ese medicamento se ecuentra caducado, no es posible venderlo.";
						
						
					}else{
						
						$venta=vender($codigoVenta, $cantidadVenta);
									
						
					}
						
		
				}



			  
			  echo "<h2>Venta de Medicamentos</h2>";
			  
					echo "<form class='form-3' method='post' action='ventas.php' name='buscar'>";

				echo "<p>
					<label for='libro'>Código del medicamento</label>";
				  echo "<input type='text' name='codigo' placeholder='Código del medicamento'>
			
					<label for='autor'>Nombre del medicamento</label>
					<input type='text' name='nombre' placeholder='Nombre del medicamento' > 
					
					
				</p>";

			   echo "<p>

				<input  class='button white' name='Buscar' value='Buscar' type='submit'> ";

				echo "<input  class='button white' name='limpiar' value='Limpiar' type='reset'><br>
				</p>";

				echo "</form>";
					
				// recojo desde donde quieres paginar
				$p=$_GET['p'];
						
				if($nombre=="" && $codigo==""){	

				}else{
					
					if($p=='') $p=1;
			
					// consulta SQL a imprimir paginada
					$r=mysql_query("SELECT medicamentosgeneral.codigo, medicamentosgeneral.nombre, medicamentosgeneral.precio, medicamentosgeneral.iva, medicamentosgeneral.laboratorio, medicamentosfarmacia.caducidad, medicamentosfarmacia.cantidad 
					FROM medicamentosgeneral, medicamentosfarmacia
					WHERE medicamentosgeneral.nombre LIKE '%".$nombre."%' 
					AND medicamentosgeneral.codigo LIKE '%".$codigo."%'
					AND medicamentosfarmacia.codigo=medicamentosgeneral.codigo");
				
					

					// Muestro los medicamentos correspondientes
					paginaVentas($r,$p,3);

					// Enlaces a los siguientes bloques
					$num_regs=mysql_num_rows($r);
					// Muestro enlaces
					for($i=1;$i<$num_regs;$i=$i+3){
						echo "<a href=ventas.php?p=",$i,">",round($i/3),"</a> ";
					}
					
					
				}		
			  
			
				
					 echo "<h2 class='title'>Medicamentos Para Vender</h2>";
				
				
					echo "<table style='text-align: center; margin: 0 auto;  border=1; width=85%;' border='1' width='85%';>
						<tbody>";
						echo "<tr bgcolor='#85A9DA'>";
						echo "<td>Código de Venta</td>";
						echo "<td>Medicamento</td>";
						echo "<td>Cantidad</td>";
						echo "<td>Precio Unidad sin IVA</td>";
						echo "<td>Precio Unidad con IVA</td>";
						echo "<td>Precio Total sin IVA</td>";
						echo "<td>Precio Total con IVA</td>";
						
						echo "<td>Eliminar de la Lista</td>";

						echo "</tr>";
				
					$historial=mysql_query("SELECT ventas.codigo, medicamentosgeneral.nombre, ventas.cantidad, medicamentosgeneral.precio, medicamentosgeneral.iva, medicamentosgeneral.codigo
					FROM ventas, medicamentosgeneral
					WHERE ventas.codigoMedicamento=medicamentosgeneral.codigo
					AND ventas.estadoVenta='1'");
				
					$sumatorioConIva=0;
					$sumatorioSinIva=0;
				
					while($elemento=mysql_fetch_array($historial)){
						echo "<tr class='buscador'>";
						echo "<td>",$elemento[0],"</td>";	
						echo "<td>",$elemento[1],"</td>";	
						echo "<td>",$elemento[2],"</td>";
						echo "<td>",$elemento[3],"€</td>";
						$precioIva=($elemento[3]*$elemento[4])+$elemento[3];
						
						echo "<td>",$precioIva,"€</td>";
						
						echo "<td>",$elemento[2]*$elemento[3],"€</td>";
						
						echo "<td>",$precioIva*$elemento[2],"€</td>";
			
						$sumatorioSinIva=$sumatorioSinIva+ $elemento[2]*$elemento[3];
						$sumatorioConIva=$sumatorioConIva+ $elemento[2]*$precioIva;
		
						echo "<td>"; 
						
						echo "<form method='post' action='ventas.php' name='buscar'>";
						
						echo "
					 
							<input type=hidden name=codigoBorrar value=",$elemento[0],">
							<input type=hidden name=cantidadBorrar value=",$elemento[2],">
							<input type=hidden name=medicamentoBorrar value=",$elemento[5],">
							
		
							<input type=image src='images/delete.png' width='25'>";
							
						echo "</form>";
					
						echo "</td>";
				
						echo "</tr>";
							
					}
					
					echo "<tr bgcolor='#85A9DA' >";
					
						echo "<td>TOTAL</td>";	
						echo "<td>----</td>";
						echo "<td>----</td>";
						echo "<td>----</td>";
						echo "<td>----</td>";
						echo "<td>",$sumatorioSinIva,"€</td>";
						echo "<td>",$sumatorioConIva,"€</td>";	
					
					echo "</tr>";
					
					echo "</tbody> </table>";
				
			  
			
					echo "<form class='form-3' method='post' action='ventaConfirmada.php' target='_blank' name='pedir'>";


					   echo "<p>

						<input class='button white' name='Vender' value='Vender' type='submit'> ";

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