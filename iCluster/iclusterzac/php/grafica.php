<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registro</title>

</head>
<link rel="stylesheet" href="../js/frameworks/jquery/css/custom-theme/jquery-ui-1.10.3.custom.css" />
<link rel="stylesheet" href="../css/main.css" />
<link rel="stylesheet" href="css/estilo.css" />
 <script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script>
graficacion_estado = [];
graficacion_clases = [];

function grafica(titulo,titulox,tituloy,id) {
	

	//document.getElementById('grafica').innerHTML="";
    //alert(graficacion);
	if (id==1){
    graficacion=graficacion_estado;
	espacio = document.getElementById('grafica_estado');}
	if(id==2){
	graficacion=graficacion_clases;
	espacio = document.getElementById('grafica_clases');
	}
	
	var data = google.visualization.arrayToDataTable(graficacion);
    var options = {
	   legend: 'none',
        chartArea: {width: '60%'},
        hAxis: {
          title: titulox,
          minValue: 0
        },
        vAxis: {width: '80%',
          title: tituloy,
		  
        }
      };
	  
	var chart = new google.visualization.BarChart(espacio);
	chart.draw(data, options);
}	
	
	
	
	
	
	
google.load('visualization', '1', {packages: ['corechart', 'bar'],language:'en'});
//google.setOnLoadCallback(drawBasic);
     
</script>
<body style="font-size: 12px;">

<?php
  include "ficha_config.php";
  $id=$_GET['id'];
  $tema=$_GET['tema']; 
  if ($tema=='1'){
	$conn = pg_connect("host=10.221.67.10 dbname=agrupa user=postgres password=inegi2018 port=5432") or die('Could not connect: ' . pg_last_error());	  
  }else{
	$conn = pg_connect("host=10.221.67.10 dbname=mdm6data_zac user=postgres password=inegi2018 port=5432") or die('Could not connect: ' . pg_last_error());	  
  }   

 $resultado=pg_query("Select clases_2014,nombre,sec_2014 from clusters where imagen='$id'");

 
  if ($line = pg_fetch_array($resultado)){
	$clases_cons="'".$line[0]."'";
	$clases_cons=str_replace(",","','",$clases_cons);
	$clases=$line[0];
	
	$edos_cons="'".$line[2]."'";
	$edos_cons=str_replace(",","','",$edos_cons);
	$edos=$line[2];
	$edos_array=explode(",",$edos);
	
		$titulo=$line[1];
		$titulo2="Empleo nacional por clases de actividad para ".$line[1];
		$titulo3="Estado";
		$titulo4="Empleo 2014";		
		$titulo5="Clases de actividad";	
		$idio="";	
}
echo "<center><h2>$titulo</h2></center>";
?>
<div id="grafica_estado"></div><br><br>
 <div id="grafica_clases"></div>
<?php
if(in_array($edo,$edos_array) || $tema!=3){
		$ban=false;
		$query="select sum(p_ocupado),entidad FROM cat_saic_2014 where clase in ($clases_cons) and (ent = '$edo' or ent='00') group by ent,entidad order by sum(p_ocupado) desc";		
		if ($clases_cons=="''"){	
				echo "<center>No se encontraron datos para la selección</center>";	
		}else{
		$resultado=pg_query($query);
		if (pg_num_rows($resultado) != 0){
		$i=0;		
		echo "<script>";
		echo "graficacion_estado=[";
		echo "['$titulo3', '$titulo4',],";
		while(($row = pg_fetch_array($resultado)) && ($i < 10)){
		echo "['".$row[1]."', ".$row[0]."],";
			$i=$i+1;	    	
		}
		echo "];";
		if ($i>0){
		echo "grafica('$titulo','$titulo4','$titulo3',1);</script>";
		}
		}else{
			echo "<center><h3>El estado no es representativo para el cluster/grupo seleccionado</h3></center>";
			$ban=true;
		}

		$query="select clase,descrip$idio,p_ocupado FROM cat_saic_2014 where clase in ($clases_cons) and ent = '$edo' order by p_ocupado desc"; 
		$resultado=pg_query($query);
		$cuantos=pg_num_rows($resultado);
		$i=0;
		
		if ($cuantos > 0){	
		echo "<script>";
		echo "graficacion_clases=[";
		echo "['$titulo5', '$titulo4',],";
		while(($row = pg_fetch_array($resultado)) && ($i < 10)){			
			echo "['".$row[0]."-".$row[1]."', ".$row[2]."],";
			$i=$i+1;	    	
		}
		echo "];";		
		
		
		
		if ($i>0){
			echo "grafica('$titulo2','$titulo4','$titulo5',2);</script>";
		}
		}else{
			if($ban==false){
				echo "<center><h3>El estado no es representativo para el cluster/grupo seleccionado</h3></center>";
			}
		}
		}		
		
		}else{
	echo "<center><h3>El estado no es representativo para el sector estratégico seleccionado</h3></center>";
}
		
pg_close($conn);
 ?>
 
 
</body>    
</html>
