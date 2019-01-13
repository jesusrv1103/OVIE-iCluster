<?php
error_reporting(0);
$id=$_GET['id'];
$tipo=$_GET['tipo'];
$tema=$_GET['tema'];
$clases="";
$primero=true;
if ($tema==3){
    $conn = pg_connect("host=10.221.67.10 dbname=mdm6data_zac user=postgres password=inegi2018 port=5432") or die('Could not connect: ' . pg_last_error());	
	$query = "SELECT clases_2014,sec_2014 FROM clusters where idx = '$id'";
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		$row=  pg_fetch_array($result);
		$clases= $row[0];
		$edos= $row[1];
		$clases=str_replace(",","','",$clases);
		$edos=str_replace(",","','",$edos);
		$clases= "'".$clases."'";	
		$edos= "'".$edos."'";	
		$query = "SELECT row_to_json(fc)
		FROM ( SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
		FROM (SELECT 'Feature' As type
			, ST_AsGeoJSON(the_geom)::json As geometry
			, row_to_json((SELECT l FROM (SELECT nom_estab) As l
			)) As properties FROM c_denue_2014 where codigo_act in ($clases) and cve_ent in ($edos)) As f )  As fc;";		
	
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());
	if ($row = pg_fetch_array($result)){
		echo $row[0];
	}	
}else if ($tema==2){
    $conn = pg_connect("host=10.221.67.10 dbname=mdm6data_zac user=postgres password=inegi2018 port=5432") or die('Could not connect: ' . pg_last_error());	
	$query = "SELECT clases_2014 FROM clusters where idx = '$id'";
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		$row=  pg_fetch_array($result);
		$clases= $row[0];
		$clases=str_replace(",","','",$clases);
		$clases= "'".$clases."'";	
		$query = "SELECT row_to_json(fc)
		FROM ( SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
		FROM (SELECT 'Feature' As type
			, ST_AsGeoJSON(the_geom)::json As geometry
			, row_to_json((SELECT l FROM (SELECT nom_estab) As l
			)) As properties FROM c_denue_2014 where codigo_act in ($clases)) As f )  As fc;";		
	
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());
	if ($row = pg_fetch_array($result)){
		echo $row[0];
	}	
}else{
	$conn = pg_connect("host=10.221.67.10 dbname=agrupa user=postgres password=inegi2018 port=5432") or die('Could not connect: ' . pg_last_error());	
	if ($tipo=='3'){
		$query = "SELECT d_llave FROM elem_grupos where id_grupo like '".$id."_%'";
		$resultado = pg_query($query) or die('Query failed: ' . pg_last_error());
		while($row= pg_fetch_array($resultado)){
			if ($primero){
				$clases=$row[0];        
				$primero=false;
			}else{
				$clases=$clases.",".$row[0];        
			}
		}
		if (substr($clases,-1)==","){
		$clases=substr($clases, 0, -1);
		}
		$clases=str_replace(",","','",$clases);
		$clases= "'".$clases."'";    	
		$query = "SELECT row_to_json(fc)
		FROM ( SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
		FROM (SELECT 'Feature' As type
			, ST_AsGeoJSON(the_geom)::json As geometry
			, row_to_json((SELECT l FROM (SELECT nom_estab) As l
			)) As properties FROM c_denue_2014 where id in ($clases)) As f )  As fc;";				
	}else if($tipo=='2'){	
		$query = "SELECT clases_2014 FROM clusters where idx = '$id'";
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		$row=  pg_fetch_array($result);
		$clases= $row[0];
		$clases=str_replace(",","','",$clases);
		$clases= "'".$clases."'";
		$query = "SELECT row_to_json(fc)
		FROM ( SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
		FROM (SELECT 'Feature' As type
			, ST_AsGeoJSON(the_geom)::json As geometry
			, row_to_json((SELECT l FROM (SELECT nom_estab) As l
			)) As properties FROM c_denue_2014 where id in ($clases)) As f )  As fc;";	
	}else{
		$query = "SELECT clases_2014 FROM clusters where idx = '$id'";
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		$row=  pg_fetch_array($result);
		$clases= $row[0];
		$clases=str_replace(",","','",$clases);
		$clases= "'".$clases."'";	
		$query = "SELECT row_to_json(fc)
		FROM ( SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
		FROM (SELECT 'Feature' As type
			, ST_AsGeoJSON(the_geom)::json As geometry
			, row_to_json((SELECT l FROM (SELECT nom_estab) As l
			)) As properties FROM c_denue_2014 where codigo_act in ($clases)) As f )  As fc;";		
	}
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());
	if ($row = pg_fetch_array($result)){
		echo $row[0];
	}
}	
pg_free_result($resultado);
pg_close($conn);
?>
