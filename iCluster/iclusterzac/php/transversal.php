<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/transversal.css" type="text/css" />
<script>
function carga_coords(){
document.formrequest.coords.value=window.opener.parent.f1.coords.value;
}
function consultaind(elemento){
	document.formrequest.tipo.value=elemento.getAttribute("tipo");
	document.formrequest.tipog.value=elemento.getAttribute("tipog");
	document.formrequest.tabla.value=elemento.getAttribute("nombre");
	document.formrequest.aliastabla.value=elemento.getAttribute("aliast");
	document.formrequest.campos.value=elemento.getAttribute("campos");
	document.formrequest.aliascampos.value=elemento.getAttribute("aliasc");
	document.formrequest.orden.value=elemento.getAttribute("orden");
	document.formrequest.agrupa.value=elemento.getAttribute("agrupa");
	document.formrequest.rt.value=elemento.getAttribute("rt");
	document.formrequest.action='despliegue_tab.php'
	document.formrequest.submit();
}
function descargaind(elemento){
	document.formrequest.tipo.value=elemento.getAttribute("tipo");
	document.formrequest.tipog.value=elemento.getAttribute("tipog");
	document.formrequest.tabla.value=elemento.getAttribute("nombre");
	document.formrequest.aliastabla.value=elemento.getAttribute("aliast");
	document.formrequest.campos.value=elemento.getAttribute("campos");
	document.formrequest.aliascampos.value=elemento.getAttribute("aliasc");
	document.formrequest.orden.value=elemento.getAttribute("orden");
	document.formrequest.agrupa.value=elemento.getAttribute("agrupa");
	document.formrequest.rt.value=elemento.getAttribute("rt");
	document.formrequest.action='descarga_tab.php'
	document.formrequest.submit();
}

</script>
<style type="text/css">
 .barra{
	background-color: #f5f5f5;
	border-radius: 5px;
	height: 25px;
	width: 300px;
	border: solid 1px #ccc;
	box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1) inset;
	z-index:5000;
	position:absolute;
	top:10px;
	color: #057afb;
	font-size: 2em;    
	}
.progreso{
	border-radius: 5px;
	height: 25px;
	width: 0%;
	border-right: solid 1px #ccc;
	background-color: lightblue;
	background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
}
.porcentaje{
	padding-right: 7px;
	padding-top: 2px;
	text-align: right;
}

</style>
</head>
<body >
<header>
   <h1>Selección transversal</h1>
</header>  
<div id='sticky' class='barra' >
 <div class='progreso'><div class='porcentaje'></div></div>
</div>
<div class="content">
		<div style="display:none">
		<form name='formrequest' action='despliegue_tab.php' method='post' target='despliegue' >
			<?php
				$coords=$_POST['coords'];	
			echo "<textarea id='coords' name='coords' cols='20' rows='2'>$coords</textarea>";?>
			<input type='text' id='tipo' name='tipo'/>
			<input type='text' id='tipog' name='tipog'/>
			<input type='text' id='tabla' name='tabla'/>
			<input type='text' id='aliastabla' name='aliastabla'/>
			<textarea id="campos" name="campos" cols="20" rows="2"></textarea>
			<textarea id="aliascampos" name="aliascampos" cols="20" rows="2"></textarea>
			<input type='text' id='orden' name='orden'/>
			<input type='text' id='agrupa' name='agrupa'/>
			<input type='text' id='rt' name='rt'/>
		</form>
		</div>
        <div id="lateral">
		<?php
		include 'conexion.php';
		
		//echo $coords;
		$titsec = "0";
		$query = "SELECT ST_Area(the_geog,true) FROM (SELECT geography(ST_GeomFromText('POLYGON(($coords))',4326))) As foo(the_geog)";
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		while ($row = pg_fetch_array($result)) {
			$area=$row[0];    
		}		
		echo "<center><h2>Área: ".round($area/1000000, 2)." km2</h2></center>";
		if (file_exists('tablas_trans.xml')) {
			$xml = simplexml_load_file('tablas_trans.xml'); 			
			foreach($xml->children() as $child)
			{	
				if ($child->tipo == 1){
					$tipo=1;
					$nombre=$child->nombre;
					if ($nombre==""){
						echo "-- FALTA NOMBRE DE TABLA VERIFICAR --";
					}else{
						$alias=$child->alias;
						$orden=$child->orden;
						$camposcons='';
						$camposalias='';
						foreach($child->campos->children() as $campos){
							//echo $campos->getName() . ": " . $campos->nombre. "<br>";						
							$camposcon=$camposcon.$campos->nombre.",";
							$camposalias=$camposalias.$campos->alias."#";
						}	
						
						
						$valor=strpos($camposcon,'distinct');
						$camposcon2=substr($camposcon,0,strpos($camposcon,','));
						if ($valor===0){
							$query = "SELECT count($camposcon2) FROM $nombre where st_intersects(ST_Transform(the_geom,4326),GeomFromText('POLYGON(($coords))',4326))";					
						}else{
							$query = "SELECT count(*) FROM $nombre where st_intersects(ST_Transform(the_geom,4326),GeomFromText('POLYGON(($coords))',4326))";					
						}
						//echo $camposcon;
						
						$result = pg_query($query) or die('Query failed: ' . pg_last_error());
						while ($row = pg_fetch_array($result)) {
							$numero=$row[0];    
						}
						if ($numero != "0"){
							echo "<a href='#' onclick='consultaind(this)' class='btn' tipo='$tipo' nombre='$nombre' aliast='$alias' orden='$orden' campos='$camposcon' aliasc='$camposalias'>$alias ($numero)</a>";
							echo "<span id='btnDescarga' class='btnDescarga' onclick='descargaind(this)' tipo='$tipo' nombre='$nombre' aliast='$alias' orden='$orden' campos='$camposcon' aliasc='$camposalias'><img id='imgdes' src='imagenes/descarga.png' title='Descargar información'/></span><br><br>";
							$camposcon='';
							$camposalias='';
						}else{
							$camposcon='';
							$camposalias='';
						}
					}
				}				
				if (($child->tipo == 2)||($child->tipo == 3)||($child->tipo == 4)){
					$tipo=$child->tipo;
					$nombre=$child->nombre;
					$agrupa=$child->agrupa;
					if ($nombre==""){
						echo "-- FALTA NOMBRE DE TABLA VERIFICAR --";
					}else{
						$alias=$child->alias;
						$orden=$child->orden;
						$camposcons='';
						$camposalias='';
						foreach($child->campos->children() as $campos){
							//echo $campos->getName() . ": " . $campos->nombre. "<br>";						
							$camposcon=$camposcon.$campos->nombre.",";
							$camposalias=$camposalias.$campos->alias."#";
						}	
						
						
						$valor=strpos($camposcon,'distinct');
						$camposcon2=substr($camposcon,0,strpos($camposcon,','));
						if ($valor===0){
							$query = "SELECT count($camposcon2) FROM $nombre where st_intersects(ST_Transform(the_geom,4326),GeomFromText('POLYGON(($coords))',4326))";					
						}else{
							$query = "SELECT count(*) FROM $nombre where st_intersects(ST_Transform(the_geom,4326),GeomFromText('POLYGON(($coords))',4326))";					
						}
						//echo $camposcon;
						
						$result = pg_query($query) or die('Query failed: ' . pg_last_error());
						while ($row = pg_fetch_array($result)) {
							$numero=$row[0];    
						}
						if ($numero != "0"){
							echo "<a href='#' onclick='consultaind(this)' class='btn' tipo='$tipo' nombre='$nombre' aliast='$alias' orden='$orden' campos='$camposcon' agrupa='$agrupa' aliasc='$camposalias'>$alias ($numero)</a>";
							echo "<span id='btnDescarga' class='btnDescarga' onclick='descargaind(this)' tipo='$tipo' nombre='$nombre' aliast='$alias' orden='$orden' campos='$camposcon' aliasc='$camposalias'><img id='imgdes' src='imagenes/descarga.png' title='Descargar información'/></span><br><br>";
							$camposcon='';
							$camposalias='';
						}else{
							$camposcon='';
							$camposalias='';
						}
					}
					
				};
				@ob_flush();
				flush();
				}//for xml	
		echo "<hr>";
		echo "<center><h2 width='100%' style='background-color: #C9C9C9;color:#000000'>Agrupamientos</h2></center>";
		$query = "SELECT nombre,clases_2014,idx,imagen,tipo_ag from clusters where clases_2014 <> '' order by imagen";
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		$camposcon='nom_estab,nombre_act,';
		$camposalias='Nombre de establecimiento#Actividad principal#';
		while ($row = pg_fetch_array($result)){
			$nombre=$row[0];
			$clases=$row[1];
			$idx=$row[2];
			$clases =str_replace(",","','",$clases);
			$clases ="'".$clases."'";			
			$tipo=5;
			$imagen=$row[3];
			$tipog=$row[4];
			$cons="select count(*) from c_denue_2014 where codigo_act in ($clases) and st_intersects(ST_Transform(the_geom,4326),GeomFromText('POLYGON(($coords))',4326))";					
			$resultado = pg_query($cons) or die('Query failed: ' . pg_last_error());
			while ($rowc = pg_fetch_array($resultado)) {
							$numero=$rowc[0];    
						}			
			if ($numero != "0"){
				echo "<a href='#' onclick='consultaind(this)' class='btn' tipo='$tipo' nombre='c_denue_2014' rt='$tipog' aliast='$nombre' orden='nom_estab' campos='$camposcon' agrupa='$idx' aliasc='$camposalias'>$tipog - $nombre ($numero)</a>";
				echo "<span id='btnDescarga' class='btnDescarga' onclick='descargaind(this)' tipo='$tipo'  rt='$tipog' nombre='c_denue_2014' aliast='$nombre' agrupa='$idx' orden='nom_estab' campos='$camposcon' aliasc='$camposalias'><img id='imgdes' src='imagenes/descarga.png' title='Descargar información'/></span><br><br>";				
			}
			@ob_flush();
		flush();
		}
		
		$query = "SELECT distinct(grupo_desc),grupo from cat_grupos";
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		while ($row = pg_fetch_array($result)){
			$grupo=$row[1];
			$nombre=$row[0];
			$tipog=3;
			//0$cons="SELECT nom_estab,st_astext(st_centroid(ST_Transform(the_geom,4326))),id_grupo FROM c_denue_2014 left join elem_grupos on c_denue_2014.id=elem_grupos.d_llave where elem_grupos.id_grupo like '".$grupo."_%' and st_intersects(ST_Transform(c_denue_2014.the_geom,4326),GeomFromText('POLYGON(($coords))',4326))";					
			$cons="SELECT count(nom_estab) FROM c_denue_2014 left join elem_grupos on c_denue_2014.id=elem_grupos.d_llave where elem_grupos.id_grupo like '".$grupo."_%' and st_intersects(ST_Transform(c_denue_2014.the_geom,4326),GeomFromText('POLYGON(($coords))',4326))";					
			$resultado = pg_query($cons) or die('Query failed: ' . pg_last_error());
			while ($rowc = pg_fetch_array($resultado)){
				$numero=$rowc[0];    
						}
			if ($numero != "0"){
				echo "<a href='#' onclick='consultaind(this)' class='btn' tipo='$tipo' nombre='c_denue_2014' rt='$tipog' aliast='$nombre' orden='nom_estab' campos='$camposcon' agrupa='$grupo' aliasc='$camposalias'>$tipog - $nombre ($numero)</a>";
				echo "<span id='btnDescarga' class='btnDescarga' onclick='descargaind(this)'  rt='$tipog' tipo='$tipo' nombre='c_denue_2014' aliast='$nombre' agrupa='$grupo' orden='nom_estab' campos='$camposcon' aliasc='$camposalias'><img id='imgdes' src='imagenes/descarga.png' title='Descargar información'/></span><br><br>";				
			}	
			@ob_flush();
			flush();	
		}
		
		
		echo "<hr>";
		echo "<center><h2 width='100%' style='background-color: #C9C9C9;color:#000000'>Clusters</h2></center>";
		
		$conn = pg_connect("host=10.221.67.10 dbname=mdm6data_zac user=postgres password=inegi2018 port=5432") or die('Could not connect: ' . pg_last_error());
		$query = "SELECT nombre,clases_2014,idx,imagen,tipo from clusters where clases_2014 <> '' order by imagen";
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		
		while ($row = pg_fetch_array($result)){
			$nombre=$row[0];
			$clases=$row[1];
			$idx=$row[2];
			$clases =str_replace(",","','",$clases);
			$clases ="'".$clases."'";			
			$tipo=5;
			$imagen=$row[3];
			$tipog=$row[4];
			$cons="select count(*) from c_denue_2014 where codigo_act in ($clases) and st_intersects(ST_Transform(the_geom,4326),GeomFromText('POLYGON(($coords))',4326))";					
			$resultado = pg_query($cons) or die('Query failed: ' . pg_last_error());
			
			while ($rowc = pg_fetch_array($resultado)) {
							$numero=$rowc[0];    
						}			
			if ($numero != "0"){
				if ($tipog==2){
					if ($titsec == "0"){
						echo "<hr>";
						echo "<center><h2 width='100%' style='background-color: #C9C9C9;color:#000000'>Sectores Estratégicos</h2></center>";
						$titsec = "1";
					}
					echo "<a href='#' onclick='consultaind(this)' class='btn' tipo='$tipo' nombre='c_denue_2014' tipog='$tipog' aliast='$nombre' orden='nom_estab' campos='$camposcon' agrupa='$idx' aliasc='$camposalias'>$nombre ($numero)</a>";
					echo "<span id='btnDescarga' class='btnDescarga' onclick='descargaind(this)' tipo='$tipo' tipog='$tipog' nombre='c_denue_2014' aliast='$nombre' agrupa='$idx' orden='nom_estab' campos='$camposcon' aliasc='$camposalias'><img id='imgdes' src='imagenes/descarga.png' title='Descargar información'/></span><br><br>";				
				}else{
					echo "<a href='#' onclick='consultaind(this)' class='btn' tipo='$tipo' nombre='c_denue_2014' tipog='$tipog' aliast='$nombre' orden='nom_estab' campos='$camposcon' agrupa='$idx' aliasc='$camposalias'>$nombre ($numero)</a>";
					echo "<span id='btnDescarga' class='btnDescarga' onclick='descargaind(this)' tipo='$tipo' tipog='$tipog' nombre='c_denue_2014' aliast='$nombre' agrupa='$idx' orden='nom_estab' campos='$camposcon' aliasc='$camposalias'><img id='imgdes' src='imagenes/descarga.png' title='Descargar información'/></span><br><br>";				
					
				}
			}
			@ob_flush();
		flush();
		}











echo '<hr>';				
		} else {
			exit('Error abriendo tablas_trans.xml.');
		}
		pg_free_result($result);
		pg_close($conn);
		
		?>
			<br>			
			</div>  
			<div id="contenido">
				<iframe name='despliegue' id='despliegue' frameBorder="0" src='desplieguedef.html'></iframe>
			</div>
<footer>Derechos Reservados © INEGI</footer>
</div>
</body>
</html>
