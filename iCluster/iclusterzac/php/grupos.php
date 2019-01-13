<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <link rel="stylesheet" href="css/estilo.css">  
<script>
var xmlhttp=new XMLHttpRequest();
var datos="";
xmlhttp.onreadystatechange=function() {
	if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		var datos=xmlhttp.responseText;		
		document.getElementById('clusteres').innerHTML=datos;
		revisa_enabled(document.getElementById('grupo'));
	}				       
}
function habilita(dato){
	document.getElementById('clusteres').innerHTML="";
	document.getElementById('grafbutton').disabled=false;
	document.getElementById('econbutton').disabled=false;

	//alert(dato.value);
	xmlhttp.open("GET","consulta_cluster.php?tipo="+dato.value,true);
	xmlhttp.send();		
}
function visualizaG(){
	tema=document.getElementById('tema').value;
	//id=document.getElementById('grupo').value;
	id=document.getElementById('grupo').options[document.getElementById('grupo').selectedIndex].getAttribute('imagen');
	
	window.parent.visualizaGrafica(id,tema);
}
function visualizaE(){
	tema=document.getElementById('tema').value;	
	id=document.getElementById('grupo').options[document.getElementById('grupo').selectedIndex].getAttribute('imagen');	
	window.parent.visualizaEconomico(id,tema);
}
function revisa_enabled(dato){	
	if(dato.options[dato.selectedIndex].getAttribute('tipo')=='1'){
		document.getElementById('grafbutton').disabled=false;
		document.getElementById('econbutton').disabled=false;
	}else{
		document.getElementById('grafbutton').disabled=true;
		document.getElementById('econbutton').disabled=true;
	}
}


 
 </script>
</head>
<body onload="revisa_enabled(document.getElementById('grupo'));">
	<div style="width:auto;height:auto">    
		<b>Temática:</b>  	  
		<center>	   
			<table>    
				<tr>				
				<td align='center'>
				<select name='tema' id='tema' onchange='habilita(this)' style='width: 280px'>
					<option title='Agrupamientos' value='1'>Agrupamientos</option>                                      
					<option title='Clusters' value='2'>Clusters</option>                                      					
					<option title='Sectores estratégicos' value='3'>Sectores estratégicos</option>                                      					
				</select>
				</td>
				</tr>
			</table>
		</center>
  </div>      
  <br>  
  <div id='clusteres' style="width:auto;height:auto">    		  	  
		<b>Grupos:</b>
		<center>	   
			<table>    
				<tr>
				<?php
				$conn = pg_connect("host=10.221.67.10 dbname=agrupa user=postgres password=inegi2018 port=5432") or die('Could not connect: ' . pg_last_error());	
				$resultado=pg_query("Select nombre,tipo_ag,idx,imagen from clusters order by tipo_ag,nombre");				
				?>
				<td align='center'>
				<select name='grupo' id='grupo' onchange='revisa_enabled(this)' style='width: 280px'>
				<?php
					while ($line = pg_fetch_array($resultado)) {
						$dato=$line[1]."-".trim($line[0]);
						$nombre=trim($line[0]);
						//alert($nombre);
						echo "<option nombre='$nombre' imagen='$line[3]' tipo='$line[1]' title='$dato' value='$line[2]'>$dato</option>";                                      
					}
					$resultado = pg_query("Select grupo_desc,'3',grupo from cat_grupos group by grupo_desc,grupo order by grupo") or die('Query failed: ' . pg_last_error());
					while ($line = pg_fetch_array($resultado)) {
						$dato=$line[1]."-".trim($line[0]);
						$nombre=trim($line[0]);
						echo "<option nombre='$nombre' imagen='varios' tipo='$line[1]' title='$dato' value='$line[2]'>$dato</option>";                                      
					}					
					pg_free_result($resultado);
					pg_close($conn);					
				?>
				</select>
				</td>
				</tr>
			</table>
		</center>
  </div><br>
  <center>
  <button class='textbuttonestab' title='Consultar establecimientos en cluster/grupo' onclick='window.parent.umap.cargaGrupo()'>Ver cluster/grupo</button><button onclick='window.parent.visualizaActivos()' class='textbuttonborra' title='Clusters/grupos activos'>Clusters/grupos activos</button><br><br>
  <button id='grafbutton' class='textbuttongraf' onclick='visualizaG()' title='Consultar empleo'>Graficas de empleo</button><button id='econbutton' class='textbuttoneco'onclick='visualizaE()' title='Consultar información económica en el estado'>Inf. económica</button>
  </center>
</body>
</html>
