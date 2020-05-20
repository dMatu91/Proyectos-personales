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
<title>Tiempo Comarcas</title>
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
//                         //
//////////////////////////////////////////////
// Documentacion en https://code.google.com/p/php-excel-reader/wiki/Documentation

// $fichero1 es el fichero remoto, $fichero es la copia en local
$fichero1="http://opendata.euskadi.eus/contenidos/prevision_tiempo/met_forecast_zone/opendata/met_forecast_zone.xml";
$fichero="met_forecast_zone.xml";

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
$xml="met_forecast_zone.xml";

if (file_exists($xml)) {
    $leido = simplexml_load_file($xml);
	//echo $leido->weatherForecast->forecast[0]->description->es;
} else {
    exit('Error abriendo test.xml.');
}
//echo $leido->forecasts->forecast[1]->description->es;
echo "<br></br>";
//echo $leido->forecasts->forecast[1]->description->eu;



/*

$array = [
    "1" => "43.324938, -2.411601", // zona litoral
    "2" => "43.125334, -2.429512", // valles cantabricos
	"3" => "43.036001, -2.976597", // montaña cantabrica
	"4" => "42.801424, -3.049038", // cuencas interiores
	"5" => "42.705628, -2.451656", // montaña meridional
	"6" => "42.549011, -2.587955", // valle del Ebro
	"7" => "43.034413, -2.201876", // Pirineo
	"8" => "43.268621, -2.930935", // Gran Bilbao
	"9" => "43.315508, -1.990402", // Donostialdea
	"10" => "42.846551, -2.672670", // Vitoria-gasteiz
	
];

*/
$array= array (
				"43.324938, -2.411601",
				"43.125334, -2.429512",
				"43.036001, -2.976597",
				"42.801424, -3.049038",
				"42.705628, -2.451656",
				"42.549011, -2.587955",
				"43.034413, -2.201876",
				"43.268621, -2.930935",
				"43.315508, -1.990402", 
				"42.846551, -2.672670"
				);
		
		
 
 /*
 function mostrar($array, $contador){
	 
		$contadorM= 0+ $contador;
	 
		$resul=$array[$contadorM];
		echo "Contador",$contador,"--";
		echo gettype($contador);
		echo "Covertido a",$contadorM,"--";
		echo gettype($contadorM);
		
		//echo $resul;
	 return $resul;
	 
	 
 }
 */
 
?>




	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>


	
	<script>
	
	
	var array=  new Array(
				43.324938, -2.411601,
				43.125334, -2.429512,
				43.036001, -2.976597,
				42.801424, -3.049038,
				42.705628, -2.451656,
				42.549011, -2.587955,
				43.034413, -2.201876,
				43.268621, -2.930935,
				43.315508, -1.990402, 
				42.846551, -2.672670
				); 	
	
	var descripciones= new Array();
	var lugares= new Array();
	var simbolos= new Array();
	
	
		var mapa;
		function initialize() {
			var opciones = { 
			zoom: 8, 
			center: new google.maps.LatLng(43.038989, -2.428997) 
			};
			mapa = new google.maps.Map(document.getElementById('mapa'), opciones);
			var infowindow = new google.maps.InfoWindow({content:'hola'});
			
				
		
			
				<?php
				
				$cont=0;
					/*
					$i= "<script> document.write(i) </script>";
					echo $i;
					
					
					$desc=$leido->areaForecast[0]->periodDataList->periodData->areaForecastData->windIcon->descriptions->es;
					$desc=$desc."<br>".$leido->areaForecast[0]->periodDataList->periodData->areaForecastData->weatherIcon->descriptions->es;
					$desc=$desc."<br>".$leido->areaForecast[0]->periodDataList->periodData->areaForecastData->tempIcon->descriptions->es;
					
					
					*/	
				?>
				var punto=new Array();

		
				<?php
					
					$descripciones= array ();
					$lugares= array();
					$simbolos= array();
					
					
					for ($i = 0; $i < 10; $i++) {
  
				
						$desc=$leido->areaForecast[$cont]->periodDataList->periodData->areaForecastData->windIcon->descriptions->es;
						$desc=$desc."<br>".$leido->areaForecast[$cont]->periodDataList->periodData->areaForecastData->weatherIcon->descriptions->es;
						$desc=$desc."<br>".$leido->areaForecast[$cont]->periodDataList->periodData->areaForecastData->tempIcon->descriptions->es;
						
						$descripciones[$i]=$desc;
						
						
						$simbol=$leido->areaForecast[$cont]->periodDataList->periodData->areaForecastData->weatherIcon->symbolImage;
						$simbol= substr($simbol,-6,2);
						$simbol="simbolos/".$simbol.".png";
						
						$simbolos[$i]=$simbol;
						
						$lugar=$leido->areaForecast[$cont]->areaName->es;
					
						$lugares[$i]=$lugar;
						
						$cont++;
						
					}
				?>
						
				// PUNTOS DEL MAPA

					punto[0]= new google.maps.Marker({
						position: new google.maps.LatLng(array[0], array[1]),
						map: mapa,
						title:'<?php echo $lugares[0]; ?>',
						animation: google.maps.Animation.DROP,
						icon:'<?php echo $simbolos[0]; ?>'
					}); 
					
					google.maps.event.addListener(punto[0] ,'click', function() {
						infowindow.setContent('<?php echo $descripciones[0]; ?>');
						infowindow.open(mapa, punto[0]);
					});  
					
					punto[1]= new google.maps.Marker({
						position: new google.maps.LatLng(array[2], array[3]),
						map: mapa,
						title:'<?php echo $lugares[1]; ?>',
						animation: google.maps.Animation.DROP,
						icon:'<?php echo $simbolos[1]; ?>'
					}); 
					
					google.maps.event.addListener(punto[1] ,'click', function() {
						infowindow.setContent('<?php echo $descripciones[1]; ?>');
						infowindow.open(mapa, punto[1]);
					});  

					punto[2]= new google.maps.Marker({
						position: new google.maps.LatLng(array[4], array[5]),
						map: mapa,
						title:'<?php echo $lugares[2]; ?>',
						animation: google.maps.Animation.DROP,
						icon:'<?php echo $simbolos[2]; ?>'
					}); 
					
					google.maps.event.addListener(punto[2] ,'click', function() {
						infowindow.setContent('<?php echo $descripciones[2]; ?>');
						infowindow.open(mapa, punto[2]);
					});  
					
					punto[3]= new google.maps.Marker({
						position: new google.maps.LatLng(array[6], array[7]),
						map: mapa,
						title:'<?php echo $lugares[3]; ?>',
						animation: google.maps.Animation.DROP,
						icon:'<?php echo $simbolos[3]; ?>'
					}); 
					
					google.maps.event.addListener(punto[3] ,'click', function() {
						infowindow.setContent('<?php echo $descripciones[3]; ?>');
						infowindow.open(mapa, punto[3]);
					}); 
					
					punto[4]= new google.maps.Marker({
						position: new google.maps.LatLng(array[8], array[9]),
						map: mapa,
						title:'<?php echo $lugares[4]; ?>',
						animation: google.maps.Animation.DROP,
						icon:'<?php echo $simbolos[4]; ?>'
					}); 
					
					google.maps.event.addListener(punto[4] ,'click', function() {
						infowindow.setContent('<?php echo $descripciones[4]; ?>');
						infowindow.open(mapa, punto[4]);
					}); 
					
					punto[5]= new google.maps.Marker({
						position: new google.maps.LatLng(array[10], array[11]),
						map: mapa,
						title:'<?php echo $lugares[5]; ?>',
						animation: google.maps.Animation.DROP,
						icon:'<?php echo $simbolos[5]; ?>'
					}); 
					
					google.maps.event.addListener(punto[5] ,'click', function() {
						infowindow.setContent('<?php echo $descripciones[5]; ?>');
						infowindow.open(mapa, punto[5]);
					}); 
					
					punto[6]= new google.maps.Marker({
						position: new google.maps.LatLng(array[12], array[13]),
						map: mapa,
						title:'<?php echo $lugares[6]; ?>',
						animation: google.maps.Animation.DROP,
						icon:'<?php echo $simbolos[6]; ?>'
					}); 
					
					google.maps.event.addListener(punto[6] ,'click', function() {
						infowindow.setContent('<?php echo $descripciones[6]; ?>');
						infowindow.open(mapa, punto[6]);
					}); 
					
					punto[7]= new google.maps.Marker({
						position: new google.maps.LatLng(array[14], array[15]),
						map: mapa,
						title:'<?php echo $lugares[7]; ?>',
						animation: google.maps.Animation.DROP,
						icon:'<?php echo $simbolos[7]; ?>'
					}); 
					
					google.maps.event.addListener(punto[7] ,'click', function() {
						infowindow.setContent('<?php echo $descripciones[7]; ?>');
						infowindow.open(mapa, punto[7]);
					}); 
					
					punto[8]= new google.maps.Marker({
						position: new google.maps.LatLng(array[16], array[17]),
						map: mapa,
						title:'<?php echo $lugares[8]; ?>',
						animation: google.maps.Animation.DROP,
						icon:'<?php echo $simbolos[8]; ?>'
					}); 
					
					google.maps.event.addListener(punto[8] ,'click', function() {
						infowindow.setContent('<?php echo $descripciones[8]; ?>');
						infowindow.open(mapa, punto[8]);
					}); 
					
					punto[9]= new google.maps.Marker({
						position: new google.maps.LatLng(array[18], array[19]),
						map: mapa,
						title:'<?php echo $lugares[9]; ?>',
						animation: google.maps.Animation.DROP,
						icon:'<?php echo $simbolos[9]; ?>'
					}); 
					
					google.maps.event.addListener(punto[9] ,'click', function() {
						infowindow.setContent('<?php echo $descripciones[9]; ?>');
						infowindow.open(mapa, punto[9]);
					}); 
					
					
				
						
	
				
		}
		google.maps.event.addDomListener(window, 'load', initialize);
	</script>
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
				<li id="active"><a href="#">Tiempo por Comarcas</a></li>
				<li><a href="index.php">Tiempo por Ciudades</a></li>
			</ul>
		</div>
		<div id="logo">Tiempo Euskadi</div>
		<div id="author"><a href="tiempoComarcasEuskera.php"><img src="images/vasco.gif" alt="" width="28" height="15" /> Euskera</a></div>
	
	</div>
	
	<div class="inner_copy"></div>
<!-- / #header -->
<!-- #sidebar1 -->
	<div id="sidebar1">
		<div><img src="images/leftTop.jpg" alt="" width="215" height="21" /></div>
		<div>
			<div class="title"><img src="images/pTitle.gif" alt="" width="25" height="25" /><h2>Comarcas de Euskadi</h2></div>
			<ul>
				<li> Zona Litoral
				</li>
				<li> Valles Cantabricos
				</li>
				<li> Montaña Cantábrica
				</li>
				<li> Cuencas Interiores
				</li>
				<li> Montaña Meridional
				</li>
				<li> Valle del Ebro
				</li>
				<li> Pirineo
				</li>
				<li> Gran Bilbao
				</li>
				<li> Donostialdea
				</li>
				<li> Vitoria-gasteiz
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
			<font color="black">
				
				<div id="mapa"></div>
			</font>	
			
		</div>
		<div><img src="images/rightBottom.jpg" alt="" width="666" height="21" class="picBottom" /></div>
		
		<div><img src="images/rightTop.jpg" alt="" width="666" height="21" /></div>
		<div>
	
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