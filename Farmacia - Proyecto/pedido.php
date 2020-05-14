<?php
session_start();

//variables del login
$numColegiado=$_SESSION['numColegiado'];
$contrasena=$_SESSION['contrasena'];

//recogemos las variables
$nombre=$_POST['nombre'];
$codigo=$_POST['codigo'];

$codigoPedido=$_POST['codigoPedido'];
$cantidadPedido=$_POST['cantidadPedido'];
$nombrePedido=$_POST['nombrePedido'];

$codigoBorrar=$_POST['codigoBorrar'];

$confirmaPedido=$_POST['confirmaPedido'];

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
      <div class="inner_copy"></div>
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
					
					$borrar=borraPedido($codigoBorrar);
					
					
				}
				
				if($confirmaPedido=="1"){
					
						
					$medicamentosPedido=mysql_query("SELECT  medicamentosgeneral.codigo, medicamentosgeneral.nombre, pedidos.cantidad
					FROM pedidos, medicamentosgeneral
					WHERE pedidos.codigoMedicamento=medicamentosgeneral.codigo
					AND pedidos.estadoPedido='1'");
							
					$asunto="Pedido de medicamentos";
					
					$texto="PEDIDO DE MEDICAMENTOS: ";
					$texto=$texto."<br>";

					while($elemento=mysql_fetch_array($medicamentosPedido)){
						$texto=$texto." -Código del medicamento: ".$elemento[0];
						$texto=$texto."<br>";
						$texto=$texto." -Nombre del medicamento: ".$elemento[1];
						$texto=$texto."<br>";
						$texto=$texto." -Cantidad: ".$elemento[2];
						$texto=$texto."<br>";
						$texto=$texto."----------------------------------------------";
						$texto=$texto."<br>";
					}
					//correo del almacen de madicamentos
					//contraseña: almacen28
					$direccion="almacenmedicamentos28@gmail.com";
					
					require_once('PHPMailer-master/class.phpmailer.php');	
					
					enviarEmail($direccion,$asunto,$texto);
					
					$fecha_actual=date("Y/m/d");
					
					
					//Se actualiza el estado del pedido a 2 y se añade la fecha actual
						$actualizar="UPDATE pedidos SET estadoPedido='2',fechaPedido='".$fecha_actual."'
						WHERE estadoPedido='1'";
			
						mysql_query($actualizar);
					
					
					
				}
			  
				if($codigoPedido!="" && $cantidadPedido!=""){
					
					if($cantidadPedido>0){
						
						$pedir=pedir($codigoPedido,$cantidadPedido);
									
					}
		
				}


			  
			  echo "<h2>Pedido de Medicamentos</h2>";
			  
					echo "<form class='form-3' method='post' action='pedido.php' name='buscar'>";

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
					$r=mysql_query("SELECT medicamentosgeneral.codigo, medicamentosgeneral.nombre, medicamentosgeneral.precio, medicamentosgeneral.laboratorio
					FROM medicamentosgeneral
					WHERE medicamentosgeneral.nombre LIKE '%".$nombre."%' 
					AND medicamentosgeneral.codigo LIKE '%".$codigo."%'");
				
					

					// Muestro los medicamentos correspondientes
					paginaPedido($r,$p,10);

					// Enlaces a los siguientes bloques
					$num_regs=mysql_num_rows($r);
					// Muestro enlaces
					for($i=1;$i<$num_regs;$i=$i+9){
						echo "<a href=pedido.php?p=",$i,">",round($i/10),"</a> ";
					}
					
					
				}		
			  
			

				
					 echo "<h2 class='title'>Medicamentos Para Pedir</h2>";
				
				
					echo "<table style='text-align: center; margin: 0 auto;  border=1; width=85%;' border='1' width='85%';>
						<tbody>";
						echo "<tr bgcolor='#85A9DA'>";
						echo "<td>Código de Pedido</td>";
						echo "<td>Medicamento</td>";
						echo "<td>Cantidad</td>";
						echo "<td>Eliminar de la Lista</td>";

						echo "</tr>";
				
					$historial=mysql_query("SELECT pedidos.codigo, medicamentosgeneral.nombre, pedidos.cantidad
					FROM pedidos, medicamentosgeneral
					WHERE pedidos.codigoMedicamento=medicamentosgeneral.codigo
					AND pedidos.estadoPedido='1'");
				
					while($elemento=mysql_fetch_array($historial)){
						echo "<tr class='buscador'>";
						echo "<td>",$elemento[0],"</td>";	
						echo "<td>",$elemento[1],"</td>";	
						echo "<td>",$elemento[2],"</td>";
		
						echo "<td>"; 
						
						echo "<form method='post' action='pedido.php' name='buscar'>";
						
						echo "
					 
							<input type=hidden name=codigoBorrar value=",$elemento[0],">
							
		
							<input type=image src='images/delete.png' width='25'>";
							
						echo "</form>";
					
						echo "</td>";
				
						echo "</tr>";
							
					}
					
					echo "</tbody> </table>";
				
			  
			
					echo "<form class='form-3' method='post' action='pedido.php' name='pedir'>";

							echo	"<input type=hidden name=confirmaPedido value='1'>";

					   echo "<p>

						<input class='button white' name='Pedir' value='Pedir' type='submit'> ";

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