<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="shortcut icon" href="imagenes/icono.ico" type="image/x-icon" >
<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1" />
<style type="text/css">
</style>
</head>
    <script>
	function exportToCsv(destino) { 		
	//alert(destino);
	var encodedUri = encodeURI(destino);
	//var encodedUri = "javascript:ExportToExcel('estabnew')";
	var link = document.createElement("a");
	link.setAttribute("href", encodedUri);
	//link.setAttribute("onclick", encodedUri);
	//link.setAttribute("download", "Datos.csv");
	link.innerHTML = "<img id='imgdes' src='imagenes/descarga.png' width='25px' heigth='25px' title='Descargar información'/>";
	document.getElementById('btnDescarga').innerHTML="";
	document.getElementById('btnDescarga').appendChild(link);
}
    </script>    
<body>
<center>
<?php
$coords=$_POST['coords'];
$tipo=$_POST['tipo'];
$tabla=$_POST['tabla'];
$aliastabla=$_POST['aliastabla'];
$campos=$_POST['campos'];
$tipog=$_POST['tipog'];
$rt=$_POST['rt'];
$agrupa=$_POST['agrupa'];
$campos=str_replace("*","'",$campos);
$campos=$campos."st_astext(ST_Centroid(ST_Transform(the_geom,4326)))";
//$campos=substr($campos,0,strlen($campos)-1);
$aliascampos=$_POST['aliascampos'];
$aliascampos=$aliascampos."Longitud#Latitud";
//echo $aliascampos;
$aliascampos=explode("#",$aliascampos);
$orden=$_POST['orden'];
require_once("../Classes/PHPExcel.php");
require_once("../Classes/PHPExcel/Reader/Excel2007.php");
require_once("../Classes/PHPExcel/IOFactory.php");
ini_set("memory_limit", "1000M"); 
include 'conexion.php';
$columnas=array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ","BA","BB","BC","BD","BE","BF","BG","BH","BI","BJ","BK","BL","BM","BN","BO","BP","BQ","BR","BS","BT","BU","BV","BW","BX","BY","BZ");
if ($tipog==''){
	include 'conexion.php';
}else{
	$conn = pg_connect("host=10.221.67.10 dbname=mdm6data_zac user=postgres password=inegi2018 port=5432") or die('Could not connect: ' . pg_last_error());
}

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











date_default_timezone_set('America/Mexico_City');
$name='S_Trans_'.date('Ymdhis');
$destino="files/".$name.".xlsx";
$result = pg_query($sql) or die('Query failed: ' . pg_last_error());

if (pg_num_rows($result)<>0){
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("S.Transversal")
							 ->setLastModifiedBy("S.transversal")
							 ->setTitle($aliastabla)
							 ->setSubject("")
							 ->setDescription("")
							 ->setKeywords("")
							 ->setCategory("");
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle('Datos');	
	echo 'hola';
		for ($i=0;$i<=pg_num_fields($result);$i++){	
			$letra = $columnas[$i]; 				
			$objPHPExcel->getActiveSheet()->setCellValue($letra."1", $aliascampos[$i]);
		}
		
		$filas=2;
		while ($row = pg_fetch_array($result)){
			$actual++;
			$total=500;
			$porcentaje = round(($actual / $total) * 100, 0);
						
			for ($i=0;$i<pg_num_fields($result)-1;$i++){	
				$letra = $columnas[$i]; 					
				$objPHPExcel->getActiveSheet()->getCell($letra.$filas)->setValueExplicit($row[$i], PHPExcel_Cell_DataType::TYPE_STRING);
			}
			$punto=$row[$i]; 
			//echo $punto;
			$punto=str_replace('POINT(','',$punto);			
			$punto=str_replace(')','',$punto); 
			$punto=str_replace(' ',',',$punto);
			$punto=explode(",",$punto);
			$letra = $columnas[$i];			
			$objPHPExcel->getActiveSheet()->getCell($letra.$filas)->setValueExplicit($punto[0], PHPExcel_Cell_DataType::TYPE_STRING);
			$i++;
			$letra = $columnas[$i]; ;
			$objPHPExcel->getActiveSheet()->getCell($letra.$filas)->setValueExplicit($punto[1], PHPExcel_Cell_DataType::TYPE_STRING);
			$filas++;			
			
		}	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save($destino);	
}
echo $destino;
//header('Content-type: application/xlsx');
//header('Content-Disposition: inline; filename="'.$destino.'"');
//header('Content-Transfer-Encoding: binary');
//header('Accept-Ranges: bytes');
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//header('Content-Disposition: attachment;filename="'.$destino.'"');
//header('Cache-Control: max-age=0');


header('Content-disposition: attachment; filename='.$destino);
header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Length: ' . filesize($destino));
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');




ob_clean();
flush();
if (readfile($destino))
{
  unlink($destino);
}




pg_free_result($result);
pg_close($conn);

?>    
</center>
</body>
</html>
