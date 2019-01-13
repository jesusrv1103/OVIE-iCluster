<?php
$tipo=$_GET['tipo'];
if ($tipo==1){
	$conn = pg_connect("host=10.221.67.10 dbname=agrupa user=postgres password=inegi2018 port=5432") or die('Could not connect: ' . pg_last_error());	
	$resultado=pg_query("Select nombre,tipo_ag,idx,imagen from clusters order by tipo_ag,nombre");				
	echo "<b>Grupos:</b><center><table><tr><td align='center'>";
		echo "<select name='grupo' id='grupo' onchange='revisa_enabled(this)'; style='width: 280px'>";
		while ($line = pg_fetch_array($resultado)) {
				$dato=$line[1]."-".trim($line[0]);
				$nombre=trim($line[0]);		
				echo "<option nombre='$nombre' imagen='$line[3]' tipo='$line[1]' title='$dato' value='$line[2]'>$dato</option>";                                      
		}
		$resultado = pg_query("Select grupo_desc,'3',grupo from cat_grupos group by grupo_desc,grupo order by grupo") or die('Query failed: ' . pg_last_error());
		while ($line = pg_fetch_array($resultado)) {
				$dato=$line[1]."-".trim($line[0]);
				$nombre=trim($line[0]);
				echo "<option nombre='$nombre' imagen='varios' tipo='$line[1]' title='$dato' value='$line[2]'>$dato</option>";                                      
		}					
		echo "</select></td></tr></table></center>";	
}else if ($tipo==2){	
	$conn = pg_connect("host=10.221.67.10 dbname=mdm6data_zac user=postgres password=inegi2018 port=5432") or die('Could not connect: ' . pg_last_error());	
	$resultado=pg_query("Select nombre,tipo_ag,idx,imagen,imagen from clusters where tipo = 1 order by tipo_ag,nombre");				
	echo "<b>Clusters:</b><center><table><tr><td align='center'>";
		echo "<select name='grupo' id='grupo' onchange='revisa_enabled(this)'; style='width: 280px'>";
		while ($line = pg_fetch_array($resultado)) {
				$dato=trim($line[0]);
				$nombre=trim($line[0]);		
				echo "<option nombre='$nombre' imagen='$line[3]' tipo='$line[1]' title='$dato' value='$line[2]'>$dato</option>";                                      
		}					
	echo "</select></td></tr></table></center>";	

}else{
	$conn = pg_connect("host=10.221.67.10 dbname=mdm6data_zac user=postgres password=inegi2018 port=5432") or die('Could not connect: ' . pg_last_error());	
	$resultado=pg_query("Select nombre,tipo_ag,idx,imagen from clusters where tipo= 2 order by tipo_ag,nombre");				
	echo "<b>Sectores estratégicos:</b><center><table><tr><td align='center'>";
		echo "<select name='grupo' id='grupo' onchange='revisa_enabled(this)'; style='width: 280px'>";
		while ($line = pg_fetch_array($resultado)) {
				$dato=trim($line[0]);
				$nombre=trim($line[0]);		
				echo "<option nombre='$nombre' imagen='$line[3]' tipo='$line[1]' title='$dato' value='$line[2]'>$dato</option>";                                      
		}					
	echo "</select></td></tr></table></center>";		
}
		pg_free_result($resultado);
		pg_close($conn);					
?>
