<?php
$variable=$_GET['variable'];
$grupo=$_GET['grupo'];
$tema=$_GET['tema'];
if ($tema=='1'){
	$conn = pg_connect("host=10.221.67.10 dbname=agrupa user=postgres password=inegi2018 port=5432") or die('Could not connect: ' . pg_last_error());	  
  }else{
	$conn = pg_connect("host=10.221.67.10 dbname=mdm6data_zac user=postgres password=inegi2018 port=5432") or die('Could not connect: ' . pg_last_error());	  
  }   

 //obtener estados participantes para filtros
 $resultado=pg_query("Select distinct(cve_ent) from c_mun");
 $estados="";
while($row = pg_fetch_array($resultado)){
	$estados=$estados."'".$row[0]."'";	
}
$estados=str_replace("''","','",$estados);
//echo $estados;  
 
$resultado=pg_query("Select clases_2014,sec_2014 from clusters where idx='$grupo'");
if ($line = pg_fetch_array($resultado)){
	$clases_cons="'".$line[0]."'";
	$clases_cons=str_replace(",","','",$clases_cons);
	$clases=$line[0];
	
	$sec_cons="'".$line[1]."'";
	$sec_cons=str_replace(",","','",$sec_cons);
	$sec=$line[1];	
}
//echo $clases."<br>";
//echo $sec."<br>";

$variable=trim($variable);
if ($variable == "c_loca"){
	$variable='p_ocupado';
}

if ($variable == 'ue')
{
$variable="CAST(REGEXP_REPLACE('0' || COALESCE(ue,'0'), '[^0-9]+', '','g') AS float8)";
}



//datos maximos y rango de variable seleccionada
if ($tema == '3'){
	$queryrango="select sum($variable) FROM cat_saic_2014 where clase in ($clases_cons) and ent in ($sec_cons) and ent in ($estados) group by ent order by sum($variable)";
}else{
	$queryrango="select sum($variable) FROM cat_saic_2014 where clase in ($clases_cons) and ent ent in ($estados) group by ent order by sum($variable)";
}
echo $queryrango;
/*





$resultr = pg_query($queryrango) or die('Query failed: ' . pg_last_error());
$i=0;
while($rowr = pg_fetch_array($resultr)){
	if ($i==0){
	$min=$rowr[0];
	}else{
	$max=$rowr[0]+1;
	$maxv=$rowr[0];
	}
	$i=$i+1;	    	
}
$rango=($max - $min)/10;
//echo $max;
//echo $max;


//datos estatales
$queryrango="select sum(p_ocupado),(select p_ocupado from cat_saic_$anio where clase ='000000' and ent = '00') FROM cat_saic_$anio where clase in ($clases_cons) and ent = '00'";
$resultr = pg_query($queryrango) or die('Query failed: ' . pg_last_error());
while($rowr = pg_fetch_array($resultr)){
	$t_nac_edo=$rowr[0];
	$t_nac=$rowr[1];	    	
}
$query = "SELECT row_to_json(fc)
 FROM ( SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
 FROM (SELECT 'Feature' As type
    , ST_AsGeoJSON(ST_Simplify(t2.the_geom,600))::json As geometry
    , row_to_json((SELECT l FROM (SELECT sum($variable) as dato, entidad, ent, (SELECT p_ocupado FROM public.cat_saic_$anio where ent=t2.cve_ent and clase='000000') as ptotal) As l
      )) As properties
   FROM cat_saic_$anio As lg LEFT JOIN estados_nac as t2 ON lg.ent=t2.cve_ent where lg.clase in ($clases_cons) and lg.ent <> '00' group by lg.ent,lg.entidad,t2.the_geom,t2.cve_ent) As f )  As fc;";

$result = pg_query($query) or die('Query failed: ' . pg_last_error());
if ($row = pg_fetch_array($result)){
	echo $min.','.$rango.','.$maxv.','.$t_nac_edo.','.$t_nac.$row[0];
}
*/
pg_free_result($result);
pg_close($conn);
?>
