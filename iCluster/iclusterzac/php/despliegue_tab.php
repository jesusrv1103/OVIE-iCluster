<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="shortcut icon" href="imagenes/icono.ico" type="image/x-icon" >
	<link rel="stylesheet" href="../../agp/css/bootstrap-3.3.2.min.css" type="text/css">
 <script type="text/javascript" src="../../agp/js/jquery-2.1.3.min.js"></script>
 <script type="text/javascript" src="../../agp/js/bootstrap-3.3.2.min.js"></script> 
 <link rel="stylesheet" href="../../agp/css/bootstrap-multiselect.css" type="text/css">
 <script type="text/javascript" src="../../agp/js/bootstrap-multiselect.js"></script>
<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1" />

<style type="text/css">
 .barra{
	background-color: #f5f5f5;
	border-radius: 5px;
	height: 25px;
	width: 300px;
	border: solid 1px #ccc;
	box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1) inset;
	}
.progreso{
	border-radius: 5px;
	height: 25px;
	width: 0%;
	border-right: solid 1px #ccc;
	background-color: gray;
	background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
}
.porcentaje{
	padding-right: 7px;
	padding-top: 2px;
	text-align: right;
}
ul.multiselect-container dropdown-menu{
	width:350px !important;
}
#sticky {
    #padding: 0.5ex;
    width: 600px;
    background-color: #333;
    color: #fff;
    #font-size: 2em;
    border-radius: 0.5ex;
}

#sticky.stick {
    margin-top: 0 !important;
    position: fixed;
    top: 0;
    z-index: 10000;
    border-radius: 0 0 0.5em 0.5em;
}
.oculto{
    display:none;
}
.alavista{
    display:"";
}
</style>
</head>
    <script>
	function sticky_relocate() {
    var window_top = $(window).scrollTop();
    var div_top = $('#sticky-anchor').offset().top;
    if (window_top > div_top) {
        $('#sticky').addClass('stick');
        $('#sticky-anchor').height($('#sticky').outerHeight());
    } else {
        $('#sticky').removeClass('stick');
        $('#sticky-anchor').height(0);
    }
}

		$(document).ready(function() {
		$('#clase').multiselect({	
		nonSelectedText: 'Datos disponibles', 					
		buttonWidth: 350,
		enableCaseInsensitiveFiltering: true,
		minWidth: 350,		
		maxWidth: 350,		
		enableFiltering: true,
		includeSelectAllOption: true,
		onChange: function(option, checked,select) {
                activa($('#clase').val());
            },
            onSelectAll: function(){
                activa($('#clase').val());
            },
            onDeselectAll:function(){
                activa($('#clase').val());
            }
		});
		
		$('.dropdown-menu').width(350);
		function activa(datos){
			if (datos){	
			//alert(datos);
				var elementos = $('.oculto, .alavista');			
				$.each(elementos, function(){
					if(datos.includes($(this).attr('identi'))){						
						$(this).attr("class", 'alavista');
					}else{
						$(this).attr("class", 'oculto');
					}
				});
			}else{				
				var elementos = $('.alavista');			
				$.each(elementos, function(){					
						$(this).attr("class", 'oculto');
				}
			);
			}
		}
		});
		

    </script>    
<body>
<center>
<?php
$coords=$_POST['coords'];
//echo $coords;
$tipo=$_POST['tipo'];
$tabla=$_POST['tabla'];
$aliastabla=$_POST['aliastabla'];
$campos=$_POST['campos'];
$tipog=$_POST['tipog'];
$campos=str_replace("*","'",$campos);
$valor=strpos($campos,'distinct');
if ($valor===0){
	$campos=substr($campos,0,-1);	
	$sum_campos=1;
	$ban_ubica=false;
}else{	
	$campos=$campos."st_astext(ST_Centroid(ST_Transform(the_geom,4326)))";	
	$sum_campos=0;
	$ban_ubica=true;
}
//echo $campos;
$aliascampos=$_POST['aliascampos'];
$aliascampos=$aliascampos."Ubicación";
$aliascampos=explode("#",$aliascampos);
$orden=$_POST['orden'];
$tipo=$_POST['tipo'];
$agrupa=$_POST['agrupa'];
$rt=$_POST['rt'];
ini_set("memory_limit", "1000M"); 
if ($tipog==''){
	include 'conexion.php';
}else{
	$conn = pg_connect("host=10.221.67.10 dbname=mdm6data_zac user=postgres password=inegi2018 port=5432") or die('Could not connect: ' . pg_last_error());
}
//echo $rt;
if ($tipo == 5){
	
	if ($rt==3){
		
		$sql="SELECT $campos FROM c_denue_2014 left join elem_grupos on c_denue_2014.id=elem_grupos.d_llave where elem_grupos.id_grupo like '".$agrupa."_%' and st_intersects(ST_Transform(c_denue_2014.the_geom,4326),GeomFromText('POLYGON(($coords))',4326))";					
	}else{	
		$query = "SELECT clases_2014 from clusters where idx = '$agrupa'";	
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());		
		$row = pg_fetch_array($result);	
		$clases= $row[0];
		$clases =str_replace(",","','",$clases);
		$clases ="'".$clases."'";				
		//echo $clases;
		$sql = "SELECT $campos FROM $tabla where codigo_act in ($clases) and st_intersects(ST_Transform(the_geom,4326),GeomFromText('POLYGON(($coords))',4326))";
	}
	
	
}else{
if ($orden==""){
	if ($agrupa==""){
		$sql = "SELECT $campos FROM $tabla where st_intersects(ST_Transform(the_geom,4326),GeomFromText('POLYGON(($coords))',4326))";
	}else{
		$sql = "SELECT $campos,".$agrupa." FROM $tabla where st_intersects(ST_Transform(the_geom,4326),GeomFromText('POLYGON(($coords))',4326)) order by $agrupa";
	}
}else{
	$sql = "SELECT $campos FROM $tabla where st_intersects(ST_Transform(the_geom,4326),GeomFromText('POLYGON(($coords))',4326)) order by $orden";
}
}


//echo $sql;
$result = pg_query($sql) or die('Query failed: ' . pg_last_error());
$total=pg_num_rows($result);
$actual = 0;
$porcentaje = round(($actual / $total) * 100, 0);
if ($total<>0){	
	echo "<h2>$aliastabla ($total)</h2>";
if ($tipo==1){
	echo "<table border='1' id='records'>";
		echo "<tr>";	  
		for ($i=0;$i<pg_num_fields($result);$i++){	
			echo "<th style='font-size:small' bgcolor='#C0C0C0'>".$aliascampos[$i]."</th>";			
		}
			
		echo "</tr>";
		
		$filas=2;
		while ($row = pg_fetch_array($result)){
			echo "<tr>";
			$actual++;
			$porcentaje = round(($actual / $total) * 100, 0);
			?>
			 <script type="text/javascript">
				window.parent.document.getElementsByClassName("progreso")[0].style.width = "<?php echo $porcentaje; ?>%";
				window.parent.document.getElementsByClassName("porcentaje")[0].innerHTML = "<?php echo $porcentaje; ?>%";
			</script>
			<?php
			for ($i=0;$i<pg_num_fields($result)-1+$sum_campos;$i++){	
				echo "<td style='font-size:small'>".$row[$i]."</td>";	
			}
			if ($ban_ubica==true){
			$punto=$row[$i]; 
			//echo $punto;
			$punto=str_replace('POINT(','',$punto);			
			$punto=str_replace(')','',$punto); 
			$punto=str_replace(' ',', ',$punto);
			
			echo "<td align='center'><button class='button' style='height: 30px; width: 30px;padding:1px 1px 1px 1px' type='button' onclick='window.parent.opener.opener.zoomer($punto)' name='ver' title='Ver en Mapa'><img id='ver' onclick='window.parent.opener.zoomer($punto);' alt='Ver en Mapa' src='imagenes/ver_mapa.png' height='20' width='20'/></button></td>";
			}
			echo "</tr>";			
			$filas++;			
		}
	echo "</table></center>";
}else if ($tipo==2){		
		$filas=2;
		$agrupado="";
		$cantcampos=pg_num_fields($result);
		while ($row = pg_fetch_array($result)){
			if ($agrupado<>$row[$cantcampos-1]){
				$agrupado=$row[$cantcampos-1];
				echo "<br><table border='1' id='records'>";
				echo "<tr><td align='center' colspan='$cantcampos' bgcolor='#C0C0C0' style='font-size:small'><b>".$row[$cantcampos-1]."</b></td></tr>";
				for ($i=0;$i<$cantcampos-1;$i++){	
					echo "<td style='font-size:small' bgcolor='#C0C0C0'>".$aliascampos[$i]."</td>";			
				}
				echo "</tr>";
				echo "<tr>";
			}
			$actual++;
			$porcentaje = round(($actual / $total) * 100, 0);
			?>
			 <script type="text/javascript">
				window.parent.document.getElementsByClassName("progreso")[0].style.width = "<?php echo $porcentaje; ?>%";
				window.parent.document.getElementsByClassName("porcentaje")[0].innerHTML = "<?php echo $porcentaje; ?>%";
			</script>
			<?php
			for ($i=0;$i<pg_num_fields($result)-2;$i++){	
				echo "<td style='font-size:small'>".$row[$i]."</td>";	
			}
			if ($ban_ubica==true){
			$punto=$row[$i]; 
			//echo $punto;
			$punto=str_replace('POINT(','',$punto);			
			$punto=str_replace(')','',$punto); 
			$punto=str_replace(' ',', ',$punto);
			
			echo "<td align='center'><button class='button' style='height: 30px; width: 30px;padding:1px 1px 1px 1px' type='button' onclick='window.parent.opener.opener.zoomer($punto)' name='ver' title='Ver en Mapa'><img id='ver' onclick='window.parent.opener.zoomer($punto);' alt='Ver en Mapa' src='imagenes/ver_mapa.png' height='20' width='20'/></button></td>";
			}
			echo "</tr>";			
			$filas++;			
		}
	echo "</table></center>";	
}else if ($tipo==4){	
		echo "<select multiple='multiple' name='clase[]' id='clase'>";							
       for ($i=1;$i<pg_num_fields($result);$i++){	
            if (($i==0)||($i==pg_num_fields($result)-1)){
				
			}else{
				echo "<option value='".$aliascampos[$i]."' title='".$aliascampos[$i]."'>".$aliascampos[$i]."</option>";
			}
		}
        echo "</select><br><br>";
	
	
	
	echo "<table border='1' id='records'>";
		echo "<tr>";	  
		for ($i=0;$i<pg_num_fields($result);$i++){				
			if (($i==0)||($i==pg_num_fields($result)-1)){
				echo "<th style='font-size:small' bgcolor='#C0C0C0' identi='".$aliascampos[$i]."'>".$aliascampos[$i]."</th>";			
			}else{
				echo "<th style='font-size:small' identi='".$aliascampos[$i]."' bgcolor='#C0C0C0' class='oculto'>".$aliascampos[$i]."</th>";			
			}
			
		}
			
		echo "</tr>";
		
		$filas=2;
		while ($row = pg_fetch_array($result)){
			echo "<tr>";
			$actual++;
			$porcentaje = round(($actual / $total) * 100, 0);
			?>
			 <script type="text/javascript">
				window.parent.document.getElementsByClassName("progreso")[0].style.width = "<?php echo $porcentaje; ?>%";
				window.parent.document.getElementsByClassName("porcentaje")[0].innerHTML = "<?php echo $porcentaje; ?>%";
			</script>
			<?php
			for ($i=0;$i<pg_num_fields($result)-1+$sum_campos;$i++){
				if ($i==0){	
					echo "<td style='font-size:small' identi='".$aliascampos[$i]."'>".$row[$i]."</td>";	
				}else{
					echo "<td style='font-size:small' identi='".$aliascampos[$i]."' class='oculto'>".$row[$i]."</td>";	
				}
			}
			if ($ban_ubica==true){
			$punto=$row[$i]; 
			//echo $punto;
			$punto=str_replace('POINT(','',$punto);			
			$punto=str_replace(')','',$punto); 
			$punto=str_replace(' ',', ',$punto);
			
			echo "<td align='center'><button class='button' style='height: 30px; width: 30px;padding:1px 1px 1px 1px' type='button' onclick='window.parent.opener.opener.zoomer($punto)' name='ver' title='Ver en Mapa'><img id='ver' onclick='window.parent.opener.zoomer($punto);' alt='Ver en Mapa' src='imagenes/ver_mapa.png' height='20' width='20'/></button></td>";
			}
			echo "</tr>";			
			$filas++;			
		}
	echo "</table></center>";
}else if ($tipo==5){
	
		echo "<table border='1' id='records'>";
		echo "<tr>";	  
		for ($i=0;$i<pg_num_fields($result);$i++){	
			echo "<th style='font-size:small' bgcolor='#C0C0C0'>".$aliascampos[$i]."</th>";			
		}
			
		echo "</tr>";
		
		$filas=2;
		while ($row = pg_fetch_array($result)){
			echo "<tr>";
			$actual++;
			$porcentaje = round(($actual / $total) * 100, 0);
			?>
			 <script type="text/javascript">
				window.parent.document.getElementsByClassName("progreso")[0].style.width = "<?php echo $porcentaje; ?>%";
				window.parent.document.getElementsByClassName("porcentaje")[0].innerHTML = "<?php echo $porcentaje; ?>%";
			</script>
			<?php
			for ($i=0;$i<pg_num_fields($result)-1+$sum_campos;$i++){	
				echo "<td style='font-size:small'>".$row[$i]."</td>";	
			}
			if ($ban_ubica==true){
			$punto=$row[$i]; 
			//echo $punto;
			$punto=str_replace('POINT(','',$punto);			
			$punto=str_replace(')','',$punto); 
			$punto=str_replace(' ',', ',$punto);
			
			echo "<td align='center'><button class='button' style='height: 30px; width: 30px;padding:1px 1px 1px 1px' type='button' onclick='window.parent.opener.opener.zoomer($punto)' name='ver' title='Ver en Mapa'><img id='ver' onclick='window.parent.opener.zoomer($punto);' alt='Ver en Mapa' src='imagenes/ver_mapa.png' height='20' width='20'/></button></td>";
			}
			echo "</tr>";			
			$filas++;			
		}
	echo "</table></center>";
}






}
// Free resultset
pg_free_result($result);

// Closing connection
pg_close($conn);
?>    
</center>
</body>
</html>
