<?php

	$zoom=10;
	$ciudad=$_POST['ciudad'];
	$fecha=$_POST['fecha'];
	if($ciudad=="Donostia-San"){
		$ciudad="Donostia-San Sebastián";
		
	} 	
		//$ciudad="Bilbao";
		//$zoom=5;
		
	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tiempo Ciudades</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<!--[if IE 5]>
	<style type="text/css"> 
		#sidebar1 {width:215px}
	</style>
<![endif]-->
<!--[if IE]>
	<style type="text/css"> 
		#sidebar1 { padding-top: 30px}
		#mainContent {zoom:1}
	</style>
<![endif]-->


</head>
<body>


<?php



//////////////////////////////////////////////
//  ACCESO A FICHERO REMOTO EN FORMATO xml  //
//                       //
//////////////////////////////////////////////
// Documentacion en https://code.google.com/p/php-excel-reader/wiki/Documentation

// $fichero1 es el fichero remoto, $fichero es la copia en local
$fichero1="http://opendata.euskadi.eus/contenidos/prevision_tiempo/met_forecast/opendata/met_forecast.xml";
$fichero="met_forecast.xml";

// Esta funcion permite obtener el tamaño de un fichero remoto -> no vale filesize()
function getRemoteFileSize($url) {
	$info = get_headers($url,1);
	if (is_array($info['Content-Length'])) {
		$info = end($info['Content-Length']);
	}else {
		$info = $info['Content-Length'];
	}
 	return $info;
}

// Si los tamaños son distintos, se copia el fichero remoto al local. OJO A LOS PERMISOS DE ESCRITURA
if (filesize($fichero)<>getRemoteFileSize($fichero1)){
	$resp= "Los datos del fichero remoto han variado...";
	if (!copy($fichero1, $fichero)) echo " -> Error al copiar $fichero <-";
	else $resp=$resp." ACTUALIZADOS<br>";
} else {
	 $resp=$resp." Los datos del fichero local estan actualizados";
}



$xml="http://opendata.euskadi.eus/contenidos/prevision_tiempo/met_forecast/opendata/met_forecast.xml";
$xml="met_forecast.xml";

if (file_exists($xml)) {
    $leido = simplexml_load_file($xml);
	//echo $leido->weatherForecast->forecast[0]->description->es;
} else {
    exit('Error abriendo test.xml.');
}
//echo $leido->forecasts->forecast[1]->description->es;
echo "<br></br>";
//echo $leido->forecasts->forecast[1]->description->eu;



foreach ( $leido->forecasts->forecast as $primero){
	
	 $dia= $primero->attributes()->forecastDate;
	if($dia==$fecha){
		
		foreach ( $primero->cityForecastDataList->cityForecastData as $segundo){
			
			$lugar= $segundo->attributes()->cityName;	
			
			if($ciudad==$lugar){
			
				$simbolo= $segundo->symbol->symbolImage;
				$descripcion= $segundo->symbol->descriptions->es;	
				$maxima=  $segundo->tempMax;	
				$minima=  $segundo->tempMin;

				$simbol= substr($simbolo,-6,2);
				$simbol="simbolos/".$simbol.".png";
				
								
			}
			
		}
	
	
	}
	
}


foreach ( $leido->forecasts->forecast as $primero){
	
	 $dia= $primero->attributes()->forecastDate;
	if($dia==$fecha){
	
		foreach ( $primero->description as $segundo){
			
			$descripcionG=$segundo->es;
		}
	
	}
}
 
 
?>


<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false">
	</script>

	<script type="text/javascript">
		function muestra_mapa(ciudad, simbolo) {
			
			if(ciudad==""){
				

				ciudad="Bilbao";
				
				
				var ubicacion = new google.maps.Geocoder(ciudad)
				var pedido = {address:ciudad};
				ubicacion.geocode(pedido, function(result, status){
				var coordenadas = new google.maps.LatLng(
					result[0].geometry.location.lat(), 
					result[0].geometry.location.lng());
					var opciones = { 
						zoom: 7, center: coordenadas, mapTypeId: google.maps.MapTypeId.ROADMAP	};
						var mapita = new google.maps.Map(document.getElementById("mapa"),opciones);
						//var marker = new google.maps.Marker({position:coordenadas,map:mapita,title:'Aqui',animation: google.maps.Animation.DROP,
						//icon:simbolo});
						
						
				})
				
				
				
			}else{
			
				var ubicacion = new google.maps.Geocoder(ciudad)
				var pedido = {address:ciudad};
				ubicacion.geocode(pedido, function(result, status){
				var coordenadas = new google.maps.LatLng(
					result[0].geometry.location.lat(), 
					result[0].geometry.location.lng());
					var opciones = { 
						zoom: 10, center: coordenadas, mapTypeId: google.maps.MapTypeId.ROADMAP	};
						var mapita = new google.maps.Map(document.getElementById("mapa"),opciones);
						var marker = new google.maps.Marker({position:coordenadas,map:mapita,title:'Aqui',animation: google.maps.Animation.DROP,
						icon:simbolo});
						
					google.maps.event.addListener(marker,'click', function() {
					infowindow.setContent('Es mi pueblo');
					infowindow.open(mapa, marker);
					});      	
						
						
				})
			
			}
		}
		muestra_mapa('<?php echo $ciudad; ?>','<?php echo $simbol; ?>');
	</script>
	<style type="text/css">
		#mapa {
		width:600px; 
		height:420px;
		margin:0 auto;
		}
	</style>



<!-- #container -->
<div id="container">
<!-- #header -->
	<div id="header">
		<div id="mainMenu">
			<ul id="navlist">
				<li id="active"><a href="#">Tiempo por Ciudades</a></li>
				<li><a href="tiempoComarcas.php">Tiempo por Comarcas</a></li>
			</ul>
		</div>
		<div id="logo">Tiempo Euskadi</div>
		<div id="author"><a href="tiempoCiudadesEuskera.php"><img src="images/vasco.gif" alt="" width="28" height="15" /> Euskera</a></div>
	</div><div class="inner_copy"></div>
<!-- / #header -->
<!-- #sidebar1 -->
	<div id="sidebar1">
		<div><img src="images/leftTop.jpg" alt="" width="215" height="21" /></div>
		<div>
			<div class="title"><img src="images/pTitle.gif" alt="" width="25" height="25" /><h2>Elija la ciudad</h2></div>
			<ul>
				<li>
                <?php echo "<form class='bottom' method='post' action='index.php' name='buscar'>";
		 echo "<p>
		 <select class='bottom' name='ciudad'  placeholder='Ciudades' required>";
			echo "<option disabled value=0>Ciudades</option>";
			foreach ( $leido->forecasts->forecast->cityForecastDataList->cityForecastData as $ciudades){
			
				$sitio= $ciudades->attributes()->cityName;	
				echo "<option value=",$sitio,">",$sitio,"</option>";
			}
			echo "</select>";
			 "</p>";
		
			echo "</li>";

			echo "</ul>";
			echo "<div class='title'><img src='images/pTitle.gif' alt='' width='25' height='25' /><h2>Elija el día</h2></div>";
			echo "<ul>";
			echo	"<li>";
			
				
				 echo "<p>
		 <select class='bottom' name='fecha'  placeholder='Fecha' required>";
			echo "<option disabled value=0>Fechas</option>";
			foreach ( $leido->forecasts->forecast as $fechas){
				
				$dias= $fechas->attributes()->forecastDate;	
				echo "<option value=",$dias,">",$dias,"</option>";
			}

			 "</p>";
			echo "<br></br>";
		echo "<p><input name='bottom' value='buscar' type='submit'> "; 
				
				?>
				</li>

			</ul>
		</div>
		<div><img src="images/leftBottom.jpg" alt="" width="215" height="21" class="picBottom" /></div>
	</div>
<!-- / #sidebar1 -->
<!-- #mainContent -->
	<div id="mainContent">
		<div><img src="images/rightTop.jpg" alt="" width="666" height="21" /></div>
		<div>
			<div class="title"><img src="images/pTitle.gif" alt="" width="25" height="25" /><h2>Tiempo en Euskadi</h2></div>
			<p>
				
				<div id=mapa></div>
			</p>
		</div>
		<div><img src="images/rightBottom.jpg" alt="" width="666" height="21" class="picBottom" /></div>
		
		<div><img src="images/rightTop.jpg" alt="" width="666" height="21" /></div>
		<div>
			<div class="title"><img src="images/pTitle.gif" alt="" width="25" height="25" /><h2>Previsión</h2></div>
			
			<?php
			if($ciudad==""){
				
				
				
				
				
				
				
			}else{
			
			
			
				echo "<p>";
				
					
					echo "<h3>Previsión en Euskadi para el ".$fecha."</h3>";
					echo "<br></br>";
					echo "-".$descripcionG;
					echo "<br></br>";
				
				
			echo "</p>";
			
			
			echo "<p>";
				
					echo "<h3>Previsión en ".$ciudad." para el ".$fecha."</h3>";
					echo "<br></br>";
					echo "-".$descripcion;
					echo "<br></br>";
					echo "-Temperatura máxima prevista: ".$maxima." grados";	
					echo "<br></br>";
					echo "-Temperatura mínima prevista: ".$minima." grados";
			echo "</p>";		
			}	
			

			?>
	
			
		</div>
		<div><img src="images/rightBottom.jpg" alt="" width="666" height="21" class="picBottom" /></div>
		
	</div>
	
	
	
<!-- / #mainContent -->
	<br class="clearfloat" />
<!-- #footer -->
<div id="footer">
	<div class="fcenter">
		<div class="fleft"><p>Copyright Statement</p></div><div class="fright"><p><?php echo $resp; ?></p></div><div class="fclear"></div>
		<div class="fleft"><p>Design by David Matute </a></p></div><div class="fright"><p></p></div><div class="fclear"></div>
	</div>
</div>

<!-- / #footer -->
</div>
<!-- / #container -->
</body>
</html>