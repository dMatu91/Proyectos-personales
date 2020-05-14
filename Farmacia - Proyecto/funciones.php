<!doctype html>
<html>
<head>
<meta content="text/html; charset="UTF-8" />

<title>funciones.php</title>

<link href="estilos.css" rel="stylesheet" type="text/css">

</head>
<body>


<?php

function conecta(){
	//conexion con BD
	 // $conexion=mysql_connect('192.168.31.14','root','root'); // para clase
	  $conexion=mysql_connect('127.0.0.1','root','root'); // para casa
	mysql_select_db('farmacia',$conexion);
	return $conexion;
}



/////////////////////////////////////////////////////////////
// Funcion pagina($resultset,$inicio,$desplaza)
/////////////////////////////////////////////////////////////
// funcion para paginar los reultados de la búsqueda avanzada

function pagina($resultset,$inicio,$desplaza){
	$num_campos=mysql_num_fields($resultset);
	
	// Muevo el puntero donde yo quiero
	mysql_data_seek($resultset,$inicio-1);

	// Imprimo los registros que quiero
	echo "<table style='text-align: left; margin: 0 auto;' border='1';>";
			echo "<tr bgcolor='#85A9DA'>";
			echo "<td>Nombre</td>";
			echo "<td>Descripción</td>";
			echo "<td>Precio</td>";
			echo "<td>Laboratorio</td>";
			echo "<td>Cantidad</td>";
			echo "</tr>";
	for($i=0;$i<$desplaza;$i++){
		$reg=mysql_fetch_array($resultset);
		
		
		echo "<tr class='buscador'>";
		for($j=0;$j<$num_campos;$j++){
			echo "<td>";
			echo $reg[$j];
			echo "</td>";
		}

		echo "</tr>";
	}
	echo "</table>";
}

/////////////////////////////////////////////////////////////
// Funcion paginaAgotados($resultset,$inicio,$desplaza)
/////////////////////////////////////////////////////////////
//funcion para paginar los medicamentos agotados

function paginaAgotados($resultset,$inicio,$desplaza){
	$num_campos=mysql_num_fields($resultset);
	
	// Muevo el puntero donde yo quiero
	mysql_data_seek($resultset,$inicio-1);

	// Imprimo los registros que quiero
	echo "<table style='text-align: left; margin: 0 auto;' border='1';>";
			echo "<tr bgcolor='#85A9DA'>";
			echo "<td>Código</td>";
			echo "<td>Nombre</td>";
			echo "<td>Descripción</td>";
			echo "<td>Precio</td>";
			echo "<td>Laboratorio</td>";

			echo "</tr>";
	for($i=0;$i<$desplaza;$i++){
		$reg=mysql_fetch_array($resultset);
		
		
		echo "<tr class='buscador'>";
		for($j=0;$j<$num_campos;$j++){
			echo "<td>";
			echo $reg[$j];
			echo "</td>";
		}
		echo "</tr>";
	}
	echo "</table>";
}


/////////////////////////////////////////////////////////////
// Funcion paginaCaducados($resultset,$inicio,$desplaza)
/////////////////////////////////////////////////////////////
//funcion para paginar los medicamentos caducados

function paginaCaducados($resultset,$inicio,$desplaza){
	$num_campos=mysql_num_fields($resultset);
	
	// Muevo el puntero donde yo quiero
	mysql_data_seek($resultset,$inicio-1);

	// Imprimo los registros que quiero
	echo "<table style='text-align: left; margin: 0 auto;' border='1';>";
			echo "<tr bgcolor='#85A9DA'>";
			echo "<td>Código</td>";
			echo "<td>Nombre</td>";
			echo "<td>Descripción</td>";
			echo "<td>Precio</td>";
			echo "<td>Laboratorio</td>";
			echo "<td>Cantidad</td>";
			echo "</tr>";
	for($i=0;$i<$desplaza;$i++){
		$reg=mysql_fetch_array($resultset);
		
		
		echo "<tr class='buscador'>";
		for($j=0;$j<$num_campos;$j++){
			echo "<td>";
			echo $reg[$j];
			echo "</td>";
		}
		echo "</tr>";
	}
	echo "</table>";
}


/////////////////////////////////////////////////////////////
// Funcion paginaPedido($resultset,$inicio,$desplaza)
/////////////////////////////////////////////////////////////
//funcion para paginar los medicamentos para pedir

function paginaPedido($resultset,$inicio,$desplaza){
	$num_campos=mysql_num_fields($resultset);
	
	// Muevo el puntero donde yo quiero
	mysql_data_seek($resultset,$inicio-1);

	echo "<form class='form-pedido' method='post' action='pedido.php' name='comprar'>";
	// Imprimo los registros que quiero
	echo "<table style='text-align: left; margin: 0 auto;' border='1'; >";
			echo "<tr bgcolor='#85A9DA'>";
			echo "<td>Codigo</td>";
			echo "<td>Nombre</td>";
			echo "<td>Precio</td>";
			echo "<td>Laboratorio</td>";
			echo "<td>Cantidad a Pedir</td>";
			echo "</tr>";
	for($i=0;$i<$desplaza;$i++){
		$reg=mysql_fetch_array($resultset);
		
		
		echo "<tr class='buscador'>";
		for($j=0;$j<$num_campos;$j++){
			echo "<td>";
			echo $reg[$j];
			echo "</td>";
		}
		
				
			echo "<td><select name='cantidadPedido'>";
			for ($i=0;$i<=10;$i++){
				echo "<option value=",$i,">",$i,"</option>";
			}
			echo "</select></td>";
		
		echo "</tr>";
	}
	echo "</table>";
	echo "<input type='hidden' name='codigoPedido' value= $reg[0]>"; 
	echo "<input type='hidden' name='nombrePedido' value= $reg[1]>"; 
	
	echo "<input class='button white' name='Adquirir' value='Adquirir' type='submit'>";
	
	echo "</form>";
}


/////////////////////////////////////////////////////////////
// Funcion recepcionar($codigo,$cantidad,$fecha)
/////////////////////////////////////////////////////////////
//funcion para recepcionar un medicamento

function recepcionar($codigo,$cantidad,$fecha){

	//tras recoger los datos se introducen is nuevos datos en la base de datos
	$orden="UPDATE medicamentosfarmacia SET cantidad=(cantidad+'".$cantidad."'),caducidad='".$fecha."'
	WHERE codigo='".$codigo."'";
		
	mysql_query($orden);


	return "Medicamento Recepcionado Correctamente";


}


/////////////////////////////////////////////////////////////
// Funcion pedir($codigo,$cantidad)
/////////////////////////////////////////////////////////////
//funcion para añadir un medicamento a la lista de pedidos

function pedir($codigo,$cantidad){


	//tras recoger los datos 
	//EL ESTADO PEDIDO EN 1 QUIERE DECIR QUE ESTÁ EN LA LISTA PERO AUN NO SE HA PEDIDO, SI ESTA EN 2 YA SE HA PEDIDO
	$orden="INSERT INTO pedidos (codigoMedicamento,cantidad,estadoPedido) 
	VALUES ('".$codigo."','".$cantidad."','1')";
		
	mysql_query($orden);


	//return "Medicamento Recepcionado Correctamente";

}

/////////////////////////////////////////////////////////////
// Funcion borraPedido($codigo)
/////////////////////////////////////////////////////////////
//funcion para borrar un pedido de la lista

function borraPedido($codigo){

	$orden="DELETE FROM pedidos WHERE codigo='".$codigo."'";
		
	mysql_query($orden);


	//return "Medicamento Recepcionado Correctamente";

}


/////////////////////////////////////////////////////////////
// Funcion enviarEmail($direccion,$asunto,$texto)
/////////////////////////////////////////////////////////////
//funcion para enviar un email 
function enviarEmail($direccion,$asunto,$texto){    
    $mail = new phpmailer();
	$mail->IsSMTP();    
	$mail->Mailer = "smtp";    
	$mail->Host = "smtp.googlemail.com";
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "ssl";
	$mail->Port = 465;
	// Hay que rellenar estos datos con una cuenta de gmail
	$mail->Username = "seniorbibliotecario@gmail.com";	// Quien envia el correo a traves de gmail
	$mail->Password = "biblioteca69"; 			// Contraseña del emisor
	$mail->From = "seniorbibliotecario@gmail.com";			// Direccion del emisor
	$mail->FromName = "Farmacia Mari Pili";	// Remitente que le aparece al receptor
	////////////////////////////////////////////////////////////////////////////////////
	$mail->Timeout=30;
	$mail->AddAddress($direccion);				// email destinatario
	$mail->Subject = $asunto;					// Asunto
	$mail->Body = $texto; 						// contenido del email
	$mail->AltBody =  $texto; 					// contenido del email alternativo
	$exito = $mail->Send();
	$intentos=1; 
	while ((!$exito) && ($intentos < 5)) {
		sleep(5);
		$exito = $mail->Send();
		$intentos++;  
	}    
	if(!$exito){
		echo "Problemas enviando el pedido ",$mail->ErrorInfo;  
	}else{
		echo "Pedido enviado correctamente";
	} 
}




/////////////////////////////////////////////////////////////
// Funcion paginaVentas($resultset,$inicio,$desplaza)
/////////////////////////////////////////////////////////////
//funcion para paginar los medicamentos para vender

function paginaVentas($resultset,$inicio,$desplaza){
	$num_campos=mysql_num_fields($resultset);
	
	// Muevo el puntero donde yo quiero
	mysql_data_seek($resultset,$inicio-1);

	echo "<form class='form-pedido' method='post' action='ventas.php' name='comprar'>";
	// Imprimo los registros que quiero
	echo "<table style='text-align: left; margin: 0 auto;' border='1'; >";
			echo "<tr bgcolor='#85A9DA'>";
			echo "<td>Codigo</td>";
			echo "<td>Nombre</td>";
			echo "<td>Precio</td>";
			echo "<td>IVA</td>";
			echo "<td>Laboratorio</td>";
			echo "<td>Fecha Caducidad</td>";
			echo "<td>Cantidad Disponible</td>";
			echo "<td>Cantidad a Vender</td>";
			

			echo "</tr>";
	for($i=0;$i<$desplaza;$i++){
		$reg=mysql_fetch_array($resultset);
		
		
		echo "<tr class='buscador'>";
		for($j=0;$j<$num_campos;$j++){
			echo "<td>";
			echo $reg[$j];
			echo "</td>";
		}
		
				
			
			if($reg[6]>0){
				echo "<td><select name='cantidadVenta'>";
				for ($i=0;$i<=$reg[6];$i++){
					echo "<option value=",$i,">",$i,"</option>";  //Solo se deja vender la cantidad que máxima que halla disponible
				}
				echo "</select></td>";
			}else{
				
				if(isset($reg[6])){
					
					echo "<td>";
					echo "Medicamento Agotado";
					echo "</td>";
					
				}
				
				
			}	
		echo "</tr>";
	}
	echo "</table>";
	echo "<input type='hidden' name='codigoVenta' value= $reg[0]>"; 
	echo "<input type='hidden' name='nombreVenta' value= $reg[1]>"; 
	
	echo "<input class='button white' name='Agregar' value='Agregar a la Venta' type='submit'>";
	
	echo "</form>";
}

/////////////////////////////////////////////////////////////
// Funcion compruebaCaducidad($codigo)
/////////////////////////////////////////////////////////////
//funcion para comprobar la caducidad de un medicamento al venderlo

function compruebaCaducidad($codigo){
	
		$caducidad=mysql_query("SELECT medicamentosfarmacia.caducidad
		FROM medicamentosgeneral, medicamentosfarmacia
		WHERE medicamentosgeneral.codigo LIKE '%".$codigo."%'
		AND medicamentosfarmacia.codigo=medicamentosgeneral.codigo");
		
	$caducidad=mysql_fetch_array($caducidad);
	$caducidad= $caducidad[0];
	$caducidad=strtotime($caducidad)/(3600*24);
	
	
	$dia=date("d");
	$mes=date("m");
	$anno=date("Y");
	$fechaHoy=$anno."/".$mes."/".$dia;
	$fechaHoy=strtotime($fechaHoy)/(3600*24);

	if($fechaHoy>$caducidad){
		
		$respuesta=0;
		
		
	}else{
		
		$respuesta=1;
		
	}

	return $respuesta;

	
}

function vender($codigo,$cantidad){

		$codigoGeneral=mysql_query("SELECT codigoVenta, estadoVenta
		FROM ventas
		ORDER BY codigo DESC LIMIT 1");
	
	$codigoGeneral=mysql_fetch_array($codigoGeneral);
	
	
	if($codigoGeneral[1]==1){
		
		//tras recoger los datos 
		//EL ESTADO VENTAS EN 1 QUIERE DECIR QUE ESTÁ EN LA LISTA PERO AUN NO SE HA VENDIOO, SI ESTA EN 2 YA SE HA VENDIDO
		$orden="INSERT INTO ventas (codigoMedicamento,codigoVenta ,cantidad, estadoVenta) 
		VALUES('".$codigo."','".$codigoGeneral[0]."','".$cantidad."','1')";
			
		mysql_query($orden);		
		
		//quitamos la cantidad vendida de la base de datos
		$orden="UPDATE medicamentosfarmacia SET cantidad=(cantidad-'".$cantidad."')
		WHERE codigo='".$codigo."'";
		
		mysql_query($orden);	
		
		
	}
	
	if($codigoGeneral[1]==2){
		
		$nuevaVenta=$codigoGeneral[0]+1;
		
		$orden="INSERT INTO ventas (codigoMedicamento,codigoVenta ,cantidad,estadoVenta) 
		VALUES ('".$codigo."','".$nuevaVenta."','".$cantidad."','1')";
			
		mysql_query($orden);
		
		//quitamos la cantidad vendida de la base de datos
		$orden="UPDATE medicamentosfarmacia SET cantidad=(cantidad-'".$cantidad."')
		WHERE codigo='".$codigo."'";
		
		mysql_query($orden);
		
		
	}


}


function borraVenta($codigo, $cantidad, $medicamento){

	$orden="DELETE FROM ventas WHERE codigo='".$codigo."'";
		
	mysql_query($orden);

	//añadimos la cantidad a stock
	$orden="UPDATE medicamentosfarmacia SET cantidad=(cantidad+'".$cantidad."')
		WHERE codigo='".$medicamento."'";
		
	mysql_query($orden);	

}

?>


</body>
</html>