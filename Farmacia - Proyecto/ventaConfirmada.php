<?php

	// conexion con la BD
//conexion con BD
 // $conexion=mysql_connect('192.168.31.14','root','root'); // para clase
	$conexion=mysql_connect('127.0.0.1','root','root'); // para casa
	mysql_select_db('farmacia',$conexion);
	
	
	
		$historial=mysql_query("SELECT ventas.codigo, medicamentosgeneral.nombre, ventas.cantidad, medicamentosgeneral.precio, medicamentosgeneral.iva, medicamentosgeneral.codigo
			FROM ventas, medicamentosgeneral
			WHERE ventas.codigoMedicamento=medicamentosgeneral.codigo
			AND ventas.estadoVenta='1'");
			
	
		$factura=mysql_query("SELECT codigoVenta
		FROM ventas
		WHERE ventas.estadoVenta='1'
		ORDER BY codigo DESC LIMIT 1");
		
		$factura=mysql_fetch_array($factura);

	// cargamos la libreria del chino
	require("./fpdf/fpdf.php");
	// Creo un objeto pdf
	$pdf=new FPDF();
	// Añado una pagina		
	$pdf->AddPage();				
	// letra en la que escribo
	$pdf->SetFont('Arial','B',20);
	
		// Imprimiendo el anagrama
	$pdf->Image('./images/cruz-verde2.jpg',15,5,-800);

	// Imprimiendo la direccion del cliente
	$pdf->SetXY(16,45);
	$pdf->SetFont('Arial','',14);
	$pdf->Cell(60,8,"Farmacia MariPili",0,'C');
	
		// Imprimiendo texto
	$pdf->SetXY(20,60);
	$pdf->SetFont('Arial','',20);
	$pdf->Cell(200,10,"FACTURA NÚMERO: ".$factura[0],0,0);
	
	$pdf->SetXY(20,80);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(25,10,"Medicamento",1,0);
	
	$pdf->SetXY(45,80);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(25,10,"Cantidad",1,0);
	
	$pdf->SetXY(70,80);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(25,10,"Precio U.",1,0);
	
	$pdf->SetXY(95,80);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(30,10,"Precio U. con IVA",1,0);
	
	$pdf->SetXY(125,80);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(25,10,"Precio Total",1,0);
	
	$pdf->SetXY(150,80);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(35,10,"Precio Total con IVA",1,0);
	
	
	
	$inicial=90;
	
	$sumatorioConIva=0;
	$sumatorioSinIva=0;	

	//información
	while($elemento=mysql_fetch_array($historial)){
		

		
		$pdf->SetXY(20,$inicial);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(25,10,"".$elemento[1],1,0);
		
		$pdf->SetXY(45,$inicial);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(25,10,"".$elemento[2],1,0);
		
		$pdf->SetXY(70,$inicial);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(25,10,"".$elemento[3],1,0);
		
		$precioIva=($elemento[3]*$elemento[4])+$elemento[3];
		
		$sumatorioSinIva=$sumatorioSinIva+ $elemento[2]*$elemento[3];
		$sumatorioConIva=$sumatorioConIva+ $elemento[2]*$precioIva;
		
		$pdf->SetXY(95,$inicial);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(30,10,"".$precioIva."€",1,0);
		
		$pdf->SetXY(125,$inicial);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(25,10,"".$elemento[2]*$elemento[3]."€",1,0);
		
		$pdf->SetXY(150,$inicial);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(35,10,"".$precioIva*$elemento[2]."€",1,0);
		
		
		$inicial=$inicial+10;
		
	}
	
		$pdf->SetXY(20,$inicial);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(25,10,"TOTAL",1,0);
		
		$pdf->SetXY(45,$inicial);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(25,10,"",1,0);
		
		$pdf->SetXY(70,$inicial);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(25,10,"",1,0);
			
		$pdf->SetXY(95,$inicial);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(30,10,"",1,0);
		
		$pdf->SetXY(125,$inicial);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(25,10,"".$sumatorioSinIva."€",1,0);
		
		$pdf->SetXY(150,$inicial);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(35,10,"".$sumatorioConIva."€",1,0);
		
		
		
				
		$pdf->SetXY(85,$inicial+30);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(35,10,"Gracias por su visita.",0,0);
		

	// Salida=Impresion=Generacion
	$pdf->Output();		

		$fecha_actual=date("Y/m/d");
		
		//Se actualiza el estado de la venta a 2 y se añade la fecha actual
		$actualizar="UPDATE ventas SET estadoVenta='2',fechaVenta='".$fecha_actual."'
		WHERE estadoVenta='1'";
		
		mysql_query($actualizar);
				
		
?>
	