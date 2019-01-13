<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>    
<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1" />
<title>.:Area de selección:.</title>
<style type="text/css">
.style1 {
	font-size: medium;
}
.style3 {
	font-size: 1.5em;
}
.style2 {
	border-width: 1px;
	background-color: #C0C0C0;
}
.on  { background:#0094FF; }
.off { background:#C0C0C0; }

    #muestra_ima { width: 400px;
                   height: 600px; 
                   padding: 0.5em;                 
                   left: 10px;
                   top: 0px;
    }
    
    #imagen { width: 350px;
             height: 550px; 
             padding: 0.5em;               
             left:13px;
             border:2px solid #073662;
             background-color: #A0A0A0;
             
    }
    
    #popupBoxClose {
        width: 20px;
        height: 20px; 
        font-size:20px;  
        line-height:15px;  
        right:15px;  
        top:0px;      
        color:#6fa5e2;  
        font-weight:500;   
        
    }    


/* clase para ocultar el div al inicio */
.button {         
        border:2px solid #565656;
        border-radius:25px;        
        background: #dcdcdc  5px center;
        height: 30px; 
        width: 30px;
        padding:1px 1px 1px 1px; 
    }

.ocultopo,.ocultovi,.ocultoed,.ocultoec,.ocultosa,.ocultolpo,.ocultolvi,.ocultoled,.ocultolec,.ocultolsa{
    display:none;
}

.alavistapo,.alavistavi,.alavistaed,.alavistaec,.alavistasa,.alavistalpo,.alavistalvi,.alavistaled,.alavistalec,.alavistalsa{
    display:"";
}

</style>
</head>
    <link rel="stylesheet" href="js/jquery-ui-themes-1.10.3/themes/cupertino/jquery-ui.css">
    <link rel="stylesheet" href="js/jquery-ui-1.10.3/demos/demos.css">    
    <script src="js/jquery-ui-1.10.3/jquery-1.9.1.js"></script>
    <script src="js/jquery-ui-1.10.3/ui/jquery-ui.js"></script>        
    <script>
        function ver_ficha(elemento){
            document.getElementById("muestra_ima").style.height="600px";
            document.getElementById("muestra_ima").style.width="400px";
            document.getElementById("imagen").style.height="550px";
            document.getElementById("imagen").style.width="350px";
            document.getElementById("imagen").src="ficha.php?ima=" + elemento.id;
            document.getElementById("muestra_ima").style.visibility='visible';            
        }
        function oferta_esc2(elemento){          
            datos=elemento.id;    
            nombre=datos.substr(0,datos.indexOf("_"));
            datos=datos.substr(datos.indexOf("_")+1);
            cveesc=datos.substr(0,datos.indexOf("_"));
            cve_unid=datos.substr(datos.indexOf("_")+1);    
            //window.open(,"Oferta_educativa","width=800,height=400,scrollbars=1,status=1");
            document.getElementById("muestra_ima").style.height="400px";
            document.getElementById("muestra_ima").style.width="800px";
            document.getElementById("imagen").style.height="350px";
            document.getElementById("imagen").style.width="750px";
            document.getElementById("imagen").src="oferta.php?cveesc="+cveesc+"&cve_unid="+cve_unid+"&nombre="+nombre;
            document.getElementById("muestra_ima").style.visibility='visible';
        }
        function toggleState(item){            
           if(item.className == "on ui-corner-all") {
              item.className="off ui-corner-all";              
           } else {
              item.className="on ui-corner-all";              
           }
        }
        function muestra_oculta(dato){
            if (document.getElementById(dato).style.display=='none'){
              document.getElementById(dato).style.display='inline-block';  
            }else
            {
             document.getElementById(dato).style.display='none';   
            }
        }
        function vista(elemento){        
            var oculta="oculto"+elemento.id;
            var vista= "alavista"+elemento.id;                        
           if (elemento.checked==true){
                $("."+oculta).attr("class", vista);
            }
            else{                                             
                $("."+vista).attr("class", oculta);
            }            
        }
        $(function() {
                $( "#muestra_ima" ).draggable({cursor: "move", cancel: "#imagen"});
            })
    </script>    
<body>
<center>
<?php
$coords=$_POST['coords'];
$campos=$_POST['campost'];

echo "<center class='style1'><strong>Datos en el área seleccionada</strong></center>";

if ($campos==""){
 $campos="codigo_act,nombre_act$idio,id,nom_estab as Nombre";   
}else{
 $campos="codigo_act,nombre_act$idio,id,nom_estab as Nombre,".$campos;   
}
$valor=$_GET['valor'];
$cam=1;//substr($valor,0,1);
$pre=0;//substr($valor,1,1);
$datos=0;
$ccam=0;
$cpre=0;
$plocrur=0;
$anpe=0;
$anpf=0;
$ps=0;
$us=0;
$ts=0;
$tira=0;
$temp=0;
$clima=0;
$precip=0;
$esc=0;
$esc2=0;
$pre=0;
$pri=0;
$sec=0;
$med=0;
$sup=0;
$div=0;
$otr=0;
$infra[0]=0;
$ignorados=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
//echo $campos;
//echo "<a href='fd_agebmza_urbana.pdf' target='_blank'>Descriptores de campos</a><br/>";
// Connecting, selecting database
include 'conexion.php';


$query = "SELECT ST_Area(the_geog,true) FROM (SELECT geography(ST_GeomFromText('POLYGON(($coords))',4326))) As foo(the_geog)";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
// Printing results in HTML
while ($row = pg_fetch_array($result)) {
      $area=$row[0];    
}
//echo "Area de Selección: ".round($area/1000000, 2)." km2";
echo "<center class='style3'>Área: ".round($area/1000000, 2)." km2</center><br>";
// Performing SQL query
@ob_flush();
	flush();
	// Performing SQL query
$query = "SELECT $campos,st_astext(ST_Transform(the_geom,4326)) FROM c_denue_2014 where st_intersects(ST_Transform(the_geom,4326),GeomFromText('POLYGON(($coords))',4326)) order by codigo_act";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$rows = pg_num_rows($result);
if ($rows <> 0){$datos=1;
echo "<center><button class='off ui-corner-all' style='width:300px' onclick=toggleState(this);muestra_oculta('est');>Establecimientos ($rows)</button></center><div class='ui-widget-content ui-corner-all' style='display:none' id='est'>";
echo "</br>";
$i = pg_num_fields($result);
$clase="";
$clase_con=array();
$nombre_con=array();
$puntos_con=array();
$x=0;
while ($line = pg_fetch_array($result)) {
$clase_con[$x]=$line[0];
$nombre_con[$x]=$line[3];
//echo $x;
if ($line[0]!=$clase){
       if ($clase!=""){
            echo "</table></div>";
       } 
        echo "<center><button class='off ui-corner-all' style='width:500px' onclick=toggleState(this);muestra_oculta('$line[0]');>$line[0]--$line[1]</button></center><div class='ui-widget-content ui-corner-all' style='display:none' id='$line[0]'>";

// Printing results in HTML
echo "<p><table border='1'>\n";
echo "<tr class='style2'>";
for ($j = 2; $j < $i-1; $j++) {
      $fieldname = pg_field_name($result, $j);
      echo "<td>".strtoupper($fieldname)."</td>"; 
}
echo "<td>Ver en mapa</td>"; 
echo "</tr>";
echo "<tr>";}
     for ($j = 2; $j < $i-1; $j++) {
        if ($line[$j] <> ""){
        echo "<td>$line[$j]</td>";
        }else{
        echo "<td>&nbsp;</td>";    
        }
        $fieldname = pg_field_name($result, $j);       
    }
    $punto=$line[$i-1]; 
    $punto=str_replace('POINT(','',$punto);
    $punto=str_replace(')','',$punto); 
    $punto=str_replace(' ',', ',$punto);
	$puntos_con[$x]=$punto;	
    //echo "<td align='center'>";
      //  echo "<input name='Button1' type='button' value='>>' onclick='pointZoom($punto)'/>";
        echo "<td align='center'><button class='button' style='height: 30px; width: 30px;padding:1px 1px 1px 1px' type='button' onclick='window.parent.pointZoom($punto)' name='ver' title='Ver en mapa'><img id='ver' onclick='window.parent.pointZoom($punto)' alt='Ver en mapa' src='imagenes/ver_mapa.png' height='20' width='20'/></button></td>";
    //echo "</td>";
    echo "</tr>";    
    $clase=$line[0];
	$x=$x+1;
	@ob_flush();
	flush();
}
echo "</table></div>";





echo "</p></div></br>";
}

@ob_flush();
	flush();
//VARIABLES CLIMATICAS
// Performing SQL query
$query = "SELECT distinct(rango) FROM t_media where st_intersects(ST_Transform(the_geom,4326), GeomFromText('POLYGON(($coords))',4326))";
//echo $query;
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$rows = pg_num_rows($result);
if ($rows <> 0){$datos=1;$temp=$rows;
echo "<br><center><button class='off ui-corner-all' style='width:300px'  onclick=toggleState(this);muestra_oculta('var_clima');>Variables climáticas</button></center><div class='ui-widget-content ui-corner-all' style='display:none' id='var_clima'>";
//echo "</br><center>RANGO DE PRECIPITACION</center>";
echo "</br>";
echo "<table border='1'>\n";

$i = pg_num_fields($result);
$line = pg_fetch_array($result);
echo "\t<tr>\n";
echo "<td class='style2'>Temperatura</td>";
if ($line[0] <> ""){
    echo "<td>$line[0]</td>";
    $temperaturas=$line[0];
}else{
    echo "<td>&nbsp;</td>";    
}
echo "\t</tr>\n";
    

// Performing SQL query
$query = "SELECT distinct(rango) FROM precipitacion where st_intersects(ST_Transform(the_geom,4326), GeomFromText('POLYGON(($coords))',4326))";
//echo $query;
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$rows = pg_num_rows($result);
$precip=$rows;
$i = pg_num_fields($result);
$line = pg_fetch_array($result);
echo "\t<tr>\n";
echo "<td class='style2'>Precipitación</td>";
if ($line[0] <> ""){
   echo "<td>$line[0]</td>";
        $precips=$line[0];
}else{
   echo "<td>&nbsp;</td>";    
}
echo "\t</tr>\n";

//clima
// Performing SQL query
$query = "SELECT distinct(grupoclima$idio) FROM climas where st_intersects(ST_Transform(the_geom,4326), GeomFromText('POLYGON(($coords))',4326))";
//echo $query;
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$rows = pg_num_rows($result);
$clima=$rows;
//echo "<br><center><button class='off ui-corner-all' style='width:300px'  onclick=toggleState(this);muestra_oculta('clima');>CLIMA</button></center><div class='ui-widget-content ui-corner-all' style='display:none' id='clima'>";
//echo "</br><center>CLIMAS</center>";
$i = pg_num_fields($result);
$line = pg_fetch_array($result);
echo "\t<tr>\n";
echo "<td class='style2'>Grupo climático</td>";
if ($line[0] <> ""){
echo "<td>$line[0]</td>";
        $climas=$line[0];
 }else{
        echo "<td>&nbsp;</td>";    
}
echo "\t</tr>\n";

echo "</table></div></br>";        
}
@ob_flush();
	flush();

// USO DE SUELO
$query = "SELECT distinct(descripcion) as Tipo FROM uso_suelo where st_intersects(ST_Transform(the_geom,4326), GeomFromText('POLYGON(($coords))',4326)) order by descripcion";
//echo $query;
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$rows = pg_num_rows($result);
if ($rows <> 0){$us=$rows;$datos=1;
echo "<br><center><button class='off ui-corner-all' style='width:300px'  onclick=toggleState(this);muestra_oculta('us');>Uso de suelo y vegetación ($rows)</button></center><div class='ui-widget-content ui-corner-all' style='display:none' id='us'>";
//echo "</br><center>DATOS SELECCIONADOS</center></br>";
echo "</br>";
$i = pg_num_fields($result);
// Printing results in HTML
echo "<table border='1'>\n";
echo "<tr class='style2'>";
for ($j = 0; $j < $i; $j++) {
      $fieldname = pg_field_name($result, $j);
     echo "<td>".strtoupper($fieldname)."</td>"; 
}
//echo "<td>FICHA</td>"; 
echo "</tr>";
while ($line = pg_fetch_array($result)) {
    echo "\t<tr>\n";
     for ($j = 0; $j < $i; $j++) {
        if ($line[$j] <> ""){
        echo "<td>$line[$j]</td>";
        }else{
        echo "<td>&nbsp;</td>";    
        }
        $fieldname = pg_field_name($result, $j);       
    }
/*    $valor=$line[$i];
    //echo $valor;
    echo "<td><button class='button' style='background:#9E9E9E;height: 30px; width: 30px;padding:1px 1px 1px 1px' type='button'  id='$valor' onclick='ver_ficha(this)' title='Ver ficha'><img onclick='ver_ficha($valor);' alt='Ver ficha' src='../imagenes/botones/ver.png' height='20' width='20'/></button></td>";
*/    echo "\t</tr>\n";
}

echo "</table></div></br>";        
}
@ob_flush();
	flush();
// TIPO DE SUELO
$query = "SELECT distinct(clave_wrb),n_g1,n_cs_g1,n_cp_g1,n_g2,n_cs_g2,n_cp_g2,n_g3,n_cs_g3,n_cp_g3,textura$idio,f_superf FROM tipo_suelo where st_intersects(ST_Transform(the_geom,4326), GeomFromText('POLYGON(($coords))',4326)) order by n_g1";
//echo $query;
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$rows = pg_num_rows($result);
if ($rows <> 0){$ts=$rows;$datos=1;
echo "<br><center><button class='off ui-corner-all' style='width:300px'  onclick=toggleState(this);muestra_oculta('ts');>Edafología ($rows)</button></center><div class='ui-widget-content ui-corner-all' style='display:none' id='ts'>";
echo "</br>";
$i = pg_num_fields($result);
// Printing results in HTML
echo "<table border='1'>\n";
echo "<tr class='style2'>";
echo "<td>WRB</td>"; 
echo "<td>Descripción</td>"; 
echo "<td>Textura</td>"; 
echo "</tr>";
while ($line = pg_fetch_array($result)) {
    echo "\t<tr>\n";
    echo "<td>$line[0]</td>";
    $desc1="";
    for ($j = 1; $j < 4; $j++) {
    if ($line[$j]<>"N"){
        $desc1=$desc1." ".$line[$j];
    }
    }
    $desc2="";
    for ($j = 4; $j < 7; $j++) {
    if ($line[$j]<>"N"){
        $desc2=$desc2." ".$line[$j];
    }
    }
    $desc3="";
    for ($j = 7; $j < 10; $j++) {
    if ($line[$j]<>"N"){
        $desc3=$desc3." ".$line[$j];
    }
    }
    $textura="";
    for ($j = 10; $j < 12; $j++) {
    if ($line[$j]<>"N"){
        $textura=$textura." ".$line[$j];
    }
    }
    if ($desc2 <> ""){
        $desc1=$desc1." + ".$desc2;
    }
    if ($desc3 <> ""){
        $desc1=$desc1." + ".$desc3;
    }
    echo "<td>$desc1</td>";
    echo "<td>$textura</td>";
    }    
    echo "\t</tr>\n";
echo "</table></div></br>";        
}

@ob_flush();
	flush();
// TIPO DE ROCA
$query = "SELECT distinct(tipo$idio) as Tipo FROM c_tipo_roca where st_intersects(ST_Transform(the_geom,4326), GeomFromText('POLYGON(($coords))',4326)) order by tipo$idio";
//echo $query;
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$rows = pg_num_rows($result);
if ($rows <> 0){$troc=$rows;
echo "<br><center><button class='off ui-corner-all' style='width:300px'  onclick=toggleState(this);muestra_oculta('troc');>Tipo de roca ($rows)</button></center><div class='ui-widget-content ui-corner-all' style='display:none' id='troc'>";
echo "</br>";
$i = pg_num_fields($result);
// Printing results in HTML
echo "<table border='1'>\n";
echo "<tr class='style2'>";
for ($j = 0; $j < $i; $j++) {
      $fieldname = pg_field_name($result, $j);
      echo "<td>".strtoupper($fieldname)."</td>"; 
}
echo "</tr>";
while ($line = pg_fetch_array($result)) {
    echo "\t<tr>\n";
     for ($j = 0; $j < $i; $j++) {
        if ($line[$j] <> ""){
        echo "<td>$line[$j]</td>";
        }else{
        echo "<td>&nbsp;</td>";    
        }
        $fieldname = pg_field_name($result, $j);       
    }    
    echo "\t</tr>\n";
}
echo "</table></div></br>";        
}



@ob_flush();
	flush();


// FALLAS
$query = "SELECT gid FROM c_falla where st_intersects(ST_Transform(the_geom,4326), GeomFromText('POLYGON(($coords))',4326)) order by gid";
//echo $query;
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$rows = pg_num_rows($result);
if ($rows <> 0){$cf=$rows;
echo "<br><center><button class='off ui-corner-all' style='width:300px'  onclick=toggleState(this);muestra_oculta('cf');>Fallas($rows)</button></center><div class='ui-widget-content ui-corner-all' style='display:none' id='cf'>";
echo "</br><center><b>$rows</b> Fallas en la selección</center></br>";
echo "</div></br>";        
}
@ob_flush();
	flush();
// FRACTURAS
$query = "SELECT gid FROM c_fractura where st_intersects(ST_Transform(the_geom,4326), GeomFromText('POLYGON(($coords))',4326)) order by gid";
//echo $query;
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$rows = pg_num_rows($result);
if ($rows <> 0){$fra=$rows;
echo "<br><center><button class='off ui-corner-all' style='width:300px'  onclick=toggleState(this);muestra_oculta('fra');>Fracturas($rows)</button></center><div class='ui-widget-content ui-corner-all' style='display:none' id='fra'>";
echo "</br><center><b>$rows</b> Fracturas en la selección</center></br>";
echo "</div></br>";        
}


@ob_flush();
	flush();

// Area Natural protegida(estatal)
$query = "SELECT estado as Estado,nombre as Nombre FROM anp_estatal where st_intersects(ST_Transform(the_geom,4326), GeomFromText('POLYGON(($coords))',4326)) order by nombre";
//echo $query;
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$rows = pg_num_rows($result);
if ($rows <> 0){$anpe=$rows;$datos=1;
echo "<br><center><button class='off ui-corner-all' style='width:300px'  onclick=toggleState(this);muestra_oculta('anpe');>Áreas Naturales Protegidas (Estatal) ($rows)</button></center><div class='ui-widget-content ui-corner-all' style='display:none' id='anpe'>";
echo "</br>";
$i = pg_num_fields($result);
// Printing results in HTML
echo "<table border='1'>\n";
echo "<tr class='style2'>";
for ($j = 0; $j < $i; $j++) {
      $fieldname = pg_field_name($result, $j);
      echo "<td>".strtoupper($fieldname)."</td>"; 
}
echo "</tr>";
while ($line = pg_fetch_array($result)) {
    echo "\t<tr>\n";
     for ($j = 0; $j < $i; $j++) {
        if ($line[$j] <> ""){
        echo "<td>$line[$j]</td>";
        }else{
        echo "<td>&nbsp;</td>";    
        }
        $fieldname = pg_field_name($result, $j);       
    }    
    echo "\t</tr>\n";
}
echo "</table></div></br>";        
}

@ob_flush();
	flush();
// Area Natural protegida(federal)
$query = "SELECT estados as Estado,nombre as Nombre FROM anp_federal where st_intersects(ST_Transform(the_geom,4326), GeomFromText('POLYGON(($coords))',4326)) order by nombre";
//echo $query;
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$rows = pg_num_rows($result);
if ($rows <> 0){$anpf=$rows;$datos=1;
echo "<br><center><button class='off ui-corner-all' style='width:300px'  onclick=toggleState(this);muestra_oculta('anpf');>Áreas Naturales Protegidas (Federales) ($rows)</button></center><div class='ui-widget-content ui-corner-all' style='display:none' id='anpf'>";
echo "</br>";
$i = pg_num_fields($result);
// Printing results in HTML
echo "<table border='1'>\n";
echo "<tr class='style2'>";
for ($j = 0; $j < $i; $j++) {
      $fieldname = pg_field_name($result, $j);
     echo "<td>".strtoupper($fieldname)."</td>";  
}
echo "</tr>";
while ($line = pg_fetch_array($result)) {
    echo "\t<tr>\n";
     for ($j = 0; $j < $i; $j++) {
        if ($line[$j] <> ""){
        echo "<td>$line[$j]</td>";
        }else{
        echo "<td>&nbsp;</td>";    
        }
        $fieldname = pg_field_name($result, $j);       
    }    
    echo "\t</tr>\n";
}
echo "</table></div></br>";        
}

@ob_flush();
	flush();
// RELLENO SANITARIO
$query = "SELECT municipio as Municipio,clasificac as Tipo,st_astext(ST_Centroid(ST_Transform(the_geom,4326))) FROM c_tiradero where st_intersects(ST_Transform(the_geom,4326), GeomFromText('POLYGON(($coords))',4326)) order by municipio";
//echo $query;
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$rows = pg_num_rows($result);
if ($rows <> 0){$tira=$rows;$datos=1;
echo "<br><center><button class='off ui-corner-all' style='width:300px'  onclick=toggleState(this);muestra_oculta('tira');>RELLENOS SANITARIOS ($rows)</button></center><div class='ui-widget-content ui-corner-all' style='display:none' id='tira'>";
echo "</br>";
$i = pg_num_fields($result);
// Printing results in HTML
echo "<table border='1'>\n";
echo "<tr class='style2'>";
for ($j = 0; $j < $i-1; $j++) {
      $fieldname = pg_field_name($result, $j);
     echo "<td>".strtoupper($fieldname)."</td>"; 
}
echo "<td>Ver en mapa</td>";
echo "</tr>";
while ($line = pg_fetch_array($result)) {
    echo "\t<tr>\n";
     for ($j = 0; $j < $i-1; $j++) {
        if ($line[$j] <> ""){
        echo "<td>$line[$j]</td>";
        }else{
        echo "<td>&nbsp;</td>";    
        }
        $fieldname = pg_field_name($result, $j);       
    }
    $punto=$line[$i-1]; 
    $punto=str_replace('POINT(','',$punto);
    $punto=str_replace(')','',$punto); 
    $punto=str_replace(' ',', ',$punto);               
   echo "<td><button class='button' style='height: 30px; width: 30px;padding:1px 1px 1px 1px' type='button' onclick='window.parent.pointZoom($punto)' name='ver' title='Ver en mapa'><img id='ver' onclick='window.parent.pointZoom($punto)' alt='Ver en mapa' src='imagenes/ver_mapa.png' height='20' width='20'/></button></td>";
    echo "\t</tr>\n";
}
echo "</table></div></br>";        
}

@ob_flush();
	flush();
// localidades rurales
$titlesrur=array("Localidad","Nombre","Población total","Población de 0 a 14 años","Población de 15 a 29 años","Población de 15 a 64 años","Población de 30 a 49 años","Población nacida en la entidad","Población con discapacidad","Población de 15 años y más sin escolaridad","Población de 15 años y más con eduación básica incompleta","Población de 15 años y más con educación básica completa","Población de 15 años y más con educación pos-básica","Población de 18 años y más con al menos un grado en educación media superior","Población de 25 años y más con al menos un grado aprobado en educación superior","Grado promedio de escolaridad","Población económicamente activa","Población Ocupada",
"Población Desocupada","Población no económicamente activa","Población derechohabiente a servicios de salud","Población derechohabiente del IMSS","Población derechohabiente del ISSSTE o ISSSTE estatal","Total de viviendas","Total de viviendas habitadas","Viviendas particulares habitadas","Ocupantes en viviendas particulares","Viviendas particulares habitadas que disponen de luz eléctrica, agua entubada en el ámbito de la vivienda y drenaje","Viviendas particulares habitadas que no disponen de refrigerador, lavadora ni automóvil o camioneta","Viviendas particulares habitadas sin tecnologías de la información y la comunicación (TIC)","Viviendas particulares habitadas sin ningún bien");

$query = "SELECT cvegeo as localidad,nom_loc,pob1, pob8,pob11, pob12, pob14, mig1, disc1, edu31, edu34, edu37, edu40,edu43, edu46, edu49_r, eco1, eco4, eco25, eco28, salud1, salud3, 
       salud4, viv0, viv1, viv2, viv3, viv24, viv30, viv40, viv41,st_astext(ST_Transform(the_geom,4326)) FROM loc_rur where st_intersects(ST_Transform(the_geom,4326), GeomFromText('POLYGON(($coords))',4326)) order by nom_loc";
//echo $query;
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$rows = pg_num_rows($result);
if ($rows <> 0){$datos=1;$infral[0]=$rows;
echo "<br><center><button class='off ui-corner-all' style='width:300px'  onclick=toggleState(this);muestra_oculta('rurales');>Localidades Rurales ($rows)</button></center><div class='ui-widget-content ui-corner-all' style='display:none' id='rurales'>";
echo "</br><center>VALORES</CENTER>";
echo "<TABLE border='1'>";
echo "<TR><TD>-6</TD><TD>CONFIDENCIALIDAD</TD></TR>";
echo "<TR><TD>-9</TD><TD>NO ESPECIFICADO</TD></TR>";
echo "<TR><TD>-8</TD><TD>NO APLICA</TD></TR>";
echo "</TABLE>";
$i = pg_num_fields($result);
echo "<br><input type='checkbox' title='Desplegar información de población' id='lpo' onclick=vista(this)> Población &nbsp;&nbsp;&nbsp;";
echo "<input type='checkbox' title='Desplegar información de educación' id='led' onclick=vista(this)> Educación &nbsp;&nbsp;&nbsp;";
echo "<input type='checkbox' title='Desplegar información de económico' id='lec' onclick=vista(this)> Económico &nbsp;&nbsp;&nbsp;";
echo "<input type='checkbox' title='Desplegar información de salud' id='lsa' onclick=vista(this)> Salud &nbsp;&nbsp;&nbsp;";
echo "<input type='checkbox' title='Desplegar información de viviendas' id='lvi' onclick=vista(this)> Vivienda &nbsp;&nbsp;&nbsp;<br>";
// Printing results in HTML
echo "<table border='1'>\n";
echo "<tr class='style2'>";
for ($j = 0; $j < $i-1; $j++) {
      $fieldname = pg_field_name($result, $j);      
      $valor=substr(pg_field_name($result, $j),0,2);
       switch ($valor){
            case "po":
                echo "<td title='$titlesrur[$j]' class='ocultolpo'>".strtoupper($fieldname)."</td>";       
                break;
            case "mi":
                echo "<td title='$titlesrur[$j]' class='ocultolpo'>".strtoupper($fieldname)."</td>";       
                break;
            case "di":
                echo "<td title='$titlesrur[$j]' class='ocultolpo'>".strtoupper($fieldname)."</td>";       
                break;
            case "ed":
                echo "<td title='$titlesrur[$j]' class='ocultoled'>".strtoupper($fieldname)."</td>"; 
                break;
            case "ec":
                echo "<td title='$titlesrur[$j]' class='ocultolec'>".strtoupper($fieldname)."</td>"; 
                break;
            case "sa":
                echo "<td title='$titlesrur[$j]' class='ocultolsa'>".strtoupper($fieldname)."</td>"; 
                break;
            case "vi":
                echo "<td title='$titlesrur[$j]' class='ocultolvi'>".strtoupper($fieldname)."</td>"; 
                break;
            default:
               echo "<td title='$titlesrur[$j]'>".strtoupper($fieldname)."</td>";
               break;
        }
}
echo "<td>Ver en mapa</td>";
echo "</tr>";
$plocrur=0;
while ($line = pg_fetch_array($result)) {
    //$plocrur=$plocrur+$line['pobtot'];
   
    echo "\t<tr>\n";
     for ($j = 0; $j < $i-1; $j++) {
        //if ($line[$j] <> ""){
        //echo "<td>$line[$j]</td>";
        //}else{
        //echo "<td>&nbsp;</td>";    
       // }
       // $fieldname = pg_field_name($result, $j);       
        $valor=substr(pg_field_name($result, $j),0,2);
        switch ($valor){
            case "po":
                echo "<td class='ocultolpo'>$line[$j]</td>"; 
                if ($line[$j]>=0){
                    $infral[$j]=$infral[$j]+$line[$j];
                }else{
                    $ignoradosl[$j]=$ignoradosl[$j]+1;
                }                
                break;
            case "mi":
                echo "<td class='ocultolpo'>$line[$j]</td>"; 
                if ($line[$j]>=0){
                    $infral[$j]=$infral[$j]+$line[$j];
                }else{
                    $ignoradosl[$j]=$ignoradosl[$j]+1;
                }                
                break;
            case "di":
                echo "<td class='ocultolpo'>$line[$j]</td>"; 
                if ($line[$j]>=0){
                    $infral[$j]=$infral[$j]+$line[$j];
                }else{
                    $ignoradosl[$j]=$ignoradosl[$j]+1;
                }                
                break;
            case "ed":
                echo "<td class='ocultoled'>$line[$j]</td>"; 
                if ($line[$j]>=0){             
                    $infral[$j]=$infral[$j]+$line[$j];
                }else{
                    $ignoradosl[$j]=$ignoradosl[$j]+1;
                }
                break;
            case "ec":
                echo "<td class='ocultolec'>$line[$j]</td>"; 
                if ($line[$j]>=0){             
                    $infral[$j]=$infral[$j]+$line[$j];
                }else{
                    $ignoradosl[$j]=$ignoradosl[$j]+1;
                }
                break;
            case "sa":
                echo "<td class='ocultolsa'>$line[$j]</td>"; 
                if ($line[$j]>=0){
                    $infral[$j]=$infral[$j]+$line[$j];
                }else{
                    $ignoradosl[$j]=$ignoradosl[$j]+1;
                }
                break;
            case "vi":
                echo "<td class='ocultolvi'>$line[$j]</td>"; 
                if ($line[$j]>=0){
                    $infral[$j]=$infral[$j]+$line[$j];
                }else{
                    $ignoradosl[$j]=$ignoradosl[$j]+1;
               }
                break;
            default:
               echo "<td>$line[$j]</td>"; 
               break;
            
                
        }  
        
        
    }
    $punto=$line[$i-1]; 
    $punto=str_replace('POINT(','',$punto);
    $punto=str_replace(')','',$punto); 
    $punto=str_replace(' ',', ',$punto);               
   echo "<td><button class='button' style='height: 30px; width: 30px;padding:1px 1px 1px 1px' type='button' onclick='window.parent.pointZoom($punto)' name='ver' title='Ver en mapa'><img id='ver' onclick='window.parent.pointZoom($punto)' alt='Ver en mapa' src='imagenes/ver_mapa.png' height='20' width='20'/></button></td>";
    echo "\t</tr>\n";
}
echo "</table></div></br>";        
}

@ob_flush();
	flush();

// centros de asistencia medica
// Performing SQL query
$query = "SELECT cvegeo,nombre as Nombre,st_astext(ST_Transform(the_geom,4326)) FROM cam where st_intersects(ST_Transform(the_geom,4326), GeomFromText('POLYGON(($coords))',4326)) order by nombre";
//echo $query;
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$rows = pg_num_rows($result);
if ($rows<>0){$datos=1;$ccam=$rows;
echo "<br><center><button class='off ui-corner-all' style='width:300px'  onclick=toggleState(this);muestra_oculta('hosp');>Centros de asistencia médica ($rows)</button></center><div class='ui-widget-content ui-corner-all' style='display:none' id='hosp'>";
//echo "</br><center>SE ENCONTARON <b>$rows</b> CENTROS DE ASISTENCIA MEDICA</center></br>";
echo "</br>";
$i = pg_num_fields($result);
// Printing results in HTML
echo "<table border='1'>\n";
echo "<tr class='style2'>";
for ($j = 0; $j < $i-1; $j++) {
      $fieldname = pg_field_name($result, $j);
      echo "<td>".strtoupper($fieldname)."</td>"; 
}
echo "<td>Ver en mapa</td>";
echo "</tr>";
while ($line = pg_fetch_array($result)) {
    echo "\t<tr>\n";
     for ($j = 0; $j < $i-1; $j++) {
        if ($line[$j] <> ""){
        echo "<td>$line[$j]</td>";
        }else{
        echo "<td>&nbsp;</td>";    
        }
        $fieldname = pg_field_name($result, $j);       
    }
    $punto=$line[$i-1]; 
    $punto=str_replace('POINT(','',$punto);
    $punto=str_replace(')','',$punto); 
    $punto=str_replace(' ',', ',$punto);               
    echo "<td><button class='button' style='height: 30px; width: 30px;padding:1px 1px 1px 1px' type='button' onclick='window.parent.pointZoom($punto)' name='ver' title='Ver en mapa'><img id='ver' onclick='window.parent.pointZoom($punto)' alt='Ver en mapa' src='imagenes/ver_mapa.png' height='20' width='20'/></button></td>";
    echo "\t</tr>\n";
}
echo "</table></div></br>";
    
}
@ob_flush();
	flush();
//aeropuertos
// Performing SQL query
$query = "SELECT nombre as Nombre,st_astext(ST_Transform(the_geom,4326)) FROM aeropuertos where st_intersects(ST_Transform(the_geom,4326), GeomFromText('POLYGON(($coords))',4326)) order by nombre";
//echo $query;
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$rows = pg_num_rows($result);
if ($rows <> 0){$datos=1;$aero=$rows;
echo "<br><center><button class='off ui-corner-all' style='width:300px'  onclick=toggleState(this);muestra_oculta('aero');>Aeropuertos ($rows)</button></center><div class='ui-widget-content ui-corner-all' style='display:none' id='aero'>";
//echo "</br><center>SE ENCONTARON <b>$rows</b> AEROPUERTOS</center>";
$i = pg_num_fields($result);
// Printing results in HTML
echo "<table border='1'>\n";
echo "<tr class='style2'>";
for ($j = 0; $j < $i-1; $j++) {
      $fieldname = pg_field_name($result, $j);
     echo "<td>".strtoupper($fieldname)."</td>"; 
}
echo "<td>Ver en mapa</td>";
echo "</tr>";
while ($line = pg_fetch_array($result)) {
    echo "\t<tr>\n";
     for ($j = 0; $j < $i-1; $j++) {
        if ($line[$j] <> ""){
        echo "<td>$line[$j]</td>";
        }else{
        echo "<td>&nbsp;</td>";    
        }
        $fieldname = pg_field_name($result, $j);       
    }
    $punto=$line[$i-1]; 
    $punto=str_replace('POINT(','',$punto);
    $punto=str_replace(')','',$punto); 
    $punto=str_replace(' ',', ',$punto);               
    echo "<td><button class='button' style='height: 30px; width: 30px;padding:1px 1px 1px 1px' type='button' onclick='window.parent.pointZoom($punto)' name='ver' title='Ver en mapa'><img id='ver' onclick='window.parent.pointZoom($punto)' alt='Ver en mapa' src='imagenes/ver_mapa.png' height='20' width='20'/></button></td>";
    echo "\t</tr>\n";
}
echo "</table></div></br>";        
}

@ob_flush();
	flush();

//aduanas
// Performing SQL query
$query = "SELECT nombre as Nombre,st_astext(ST_Transform(the_geom,4326)) FROM aduanas where st_intersects(ST_Transform(the_geom,4326), GeomFromText('POLYGON(($coords))',4326))";
//echo $query;
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$rows = pg_num_rows($result);
if ($rows <> 0){$datos=1;$adu=$rows;
echo "<br><center><button class='off ui-corner-all' style='width:300px'  onclick=toggleState(this);muestra_oculta('adu');>Agencias aduanales ($rows)</button></center><div class='ui-widget-content ui-corner-all' style='display:none' id='adu'>";
//echo "</br><center>SE ENCONTARON <b>$rows</b> ADUANAS</center>";
$i = pg_num_fields($result);
// Printing results in HTML
echo "<table border='1'>\n";
echo "<tr class='style2'>";
for ($j = 0; $j < $i-1; $j++) {
      $fieldname = pg_field_name($result, $j);
      echo "<td>".strtoupper($fieldname)."</td>"; 
}
echo "<td>Ver en mapa</td>";
echo "</tr>";
while ($line = pg_fetch_array($result)) {
    echo "\t<tr>\n";
     for ($j = 0; $j < $i-1; $j++) {
        if ($line[$j] <> ""){
        echo "<td>$line[$j]</td>";
        }else{
        echo "<td>&nbsp;</td>";    
        }
        $fieldname = pg_field_name($result, $j);       
    }
    $punto=$line[$i-1]; 
    $punto=str_replace('POINT(','',$punto);
    $punto=str_replace(')','',$punto); 
    $punto=str_replace(' ',', ',$punto);               
    echo "<td><button class='button' style='height: 30px; width: 30px;padding:1px 1px 1px 1px' type='button' onclick='window.parent.pointZoom($punto)' name='ver' title='Ver en mapa'><img id='ver' onclick='window.parent.pointZoom($punto)' alt='Ver en mapa' src='imagenes/ver_mapa.png' height='20' width='20'/></button></td>";
    echo "\t</tr>\n";
}
echo "</table></div></br>";        
}

@ob_flush();
	flush();
//ESCUELAS
// Performing SQL query
$query = "SELECT nombre FROM escuelas where st_intersects(ST_Transform(the_geom,4326), GeomFromText('POLYGON(($coords))',4326))";
//echo $query;
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$rows = pg_num_rows($result);
if ($rows <> 0){$datos=1;$esc=$rows;
    echo "<br><center><button class='off ui-corner-all' style='width:450px'  onclick=toggleState(this);muestra_oculta('esc');>Escuelas($esc)</button></center><div class='ui-widget-content ui-corner-all' style='display:none' id='esc'>";    
    $query = "SELECT cvegeo,nombre as Nombre,st_astext(ST_Transform(the_geom,4326)) FROM preescolar where st_intersects(ST_Transform(the_geom,4326), GeomFromText('POLYGON(($coords))',4326)) order by nombre";
    echo "</br>";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
    $rows = pg_num_rows($result);
    if ($rows<>0){$datos=1;$pre=$rows;
    echo "<center><button class='off ui-corner-all' style='width:300px'  onclick=toggleState(this);muestra_oculta('pre');>Preescolar ($rows)</button></center><div class='ui-widget-content ui-corner-all' style='display:none' id='pre'>";    
    $i = pg_num_fields($result);
    echo "<table border='1'>\n";
    echo "<tr class='style2'>";
    for ($j = 0; $j < $i-1; $j++) {
        $fieldname = pg_field_name($result, $j);
        echo "<td>".strtoupper($fieldname)."</td>"; 
    }
    echo "<td>Ver en mapa</td>";
    echo "</tr>";
    while ($line = pg_fetch_array($result)) {
        echo "\t<tr>\n";
        for ($j = 0; $j < $i-1; $j++) {
            if ($line[$j] <> ""){
                echo "<td>$line[$j]</td>";
            }else{
                echo "<td>&nbsp;</td>";    
            }
            $fieldname = pg_field_name($result, $j);       
        }
        $punto=$line[$i-1]; 
        $punto=str_replace('POINT(','',$punto);
        $punto=str_replace(')','',$punto); 
        $punto=str_replace(' ',', ',$punto);               
        echo "<td><button class='button' style='height: 30px; width: 30px;padding:1px 1px 1px 1px' type='button' onclick='window.parent.pointZoom($punto)' name='ver' title='Ver en mapa'><img id='ver' onclick='window.parent.pointZoom($punto)' alt='Ver en mapa' src='imagenes/ver_mapa.png' height='20' width='20'/></button></td>";
        echo "\t</tr>";
        }
echo "</table></div>";
    }
    $query = "SELECT cvegeo,nombre as Nombre,st_astext(ST_Transform(the_geom,4326)) FROM primaria where st_intersects(ST_Transform(the_geom,4326), GeomFromText('POLYGON(($coords))',4326)) order by nombre";
    //echo $query;
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
    $rows = pg_num_rows($result);
    if ($rows<>0){$datos=1;$pri=$rows;
    echo "<center><button class='off ui-corner-all' style='width:300px'  onclick=toggleState(this);muestra_oculta('pri');>Primaria ($rows)</button></center><div class='ui-widget-content ui-corner-all' style='display:none' id='pri'>";    
    $i = pg_num_fields($result);
    echo "<table border='1'>\n";
    echo "<tr class='style2'>";
    for ($j = 0; $j < $i-1; $j++) {
        $fieldname = pg_field_name($result, $j);
        echo "<td>".strtoupper($fieldname)."</td>"; 
    }
    echo "<td>Ver en mapa</td>";
    echo "</tr>";
    while ($line = pg_fetch_array($result)) {
        echo "\t<tr>\n";
        for ($j = 0; $j < $i-1; $j++) {
            if ($line[$j] <> ""){
                echo "<td>$line[$j]</td>";
            }else{
                echo "<td>&nbsp;</td>";    
            }
            $fieldname = pg_field_name($result, $j);       
        }
        $punto=$line[$i-1]; 
        $punto=str_replace('POINT(','',$punto);
        $punto=str_replace(')','',$punto); 
        $punto=str_replace(' ',', ',$punto);               
        echo "<td><button class='button' style='height: 30px; width: 30px;padding:1px 1px 1px 1px' type='button' onclick='window.parent.pointZoom($punto)' name='ver' title='Ver en mapa'><img id='ver' onclick='window.parent.pointZoom($punto)' alt='Ver en mapa' src='imagenes/ver_mapa.png' height='20' width='20'/></button></td>";
        echo "\t</tr>";
   }
echo "</table></div>";
    }
    $query = "SELECT cvegeo,nombre as Nombre,st_astext(ST_Transform(the_geom,4326)) FROM secundaria where st_intersects(ST_Transform(the_geom,4326), GeomFromText('POLYGON(($coords))',4326)) order by nombre";
    //echo $query;
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
    $rows = pg_num_rows($result);
    if ($rows<>0){$datos=1;$sec=$rows;
    echo "<center><button class='off ui-corner-all' style='width:300px'  onclick=toggleState(this);muestra_oculta('sec');>Secundaria ($rows)</button></center><div class='ui-widget-content ui-corner-all' style='display:none' id='sec'>";
    
    $i = pg_num_fields($result);
    echo "<table border='1'>\n";
    echo "<tr class='style2'>";
    for ($j = 0; $j < $i-1; $j++) {
        $fieldname = pg_field_name($result, $j);
        echo "<td>".strtoupper($fieldname)."</td>"; 
    }
    echo "<td>Ver en mapa</td>";
    echo "</tr>";
    while ($line = pg_fetch_array($result)) {
        echo "\t<tr>\n";
        for ($j = 0; $j < $i-1; $j++) {
            if ($line[$j] <> ""){
                echo "<td>$line[$j]</td>";
            }else{
                echo "<td>&nbsp;</td>";    
            }
            $fieldname = pg_field_name($result, $j);       
        }
        $punto=$line[$i-1]; 
        $punto=str_replace('POINT(','',$punto);
        $punto=str_replace(')','',$punto); 
        $punto=str_replace(' ',', ',$punto);               
        echo "<td><button class='button' style='height: 30px; width: 30px;padding:1px 1px 1px 1px' type='button' onclick='window.parent.pointZoom($punto)' name='ver' title='Ver en mapa'><img id='ver' onclick='window.parent.pointZoom($punto)' alt='Ver en mapa' src='imagenes/ver_mapa.png' height='20' width='20'/></button></td>";
        echo "\t</tr>";
   }
echo "</table></div>";
    }
    $query = "SELECT cvegeo,nombre as Nombre,st_astext(ST_Transform(the_geom,4326)),cveesc,cve_unid FROM medio_sup where st_intersects(ST_Transform(the_geom,4326), GeomFromText('POLYGON(($coords))',4326)) order by nombre";
    //echo $query;
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
    $rows = pg_num_rows($result);
    if ($rows<>0){$datos=1;$med=$rows;
    echo "<center><button class='off ui-corner-all' style='width:300px'  onclick=toggleState(this);muestra_oculta('med');>Media superior ($rows)</button></center><div class='ui-widget-content ui-corner-all' style='display:none' id='med'>";    
    $i = pg_num_fields($result);
    echo "<table border='1'>\n";
    echo "<tr class='style2'>";
    for ($j = 0; $j < $i-3; $j++) {
        $fieldname = pg_field_name($result, $j);
        echo "<td>".strtoupper($fieldname)."</td>"; 
    }
    echo "<td>Ver en mapa</td>";
 
    echo "</tr>";
    while ($line = pg_fetch_array($result)) {
        echo "\t<tr>\n";
        for ($j = 0; $j < $i-3; $j++) {
            if ($line[$j] <> ""){
                echo "<td>$line[$j]</td>";
            }else{
                echo "<td>&nbsp;</td>";    
            }
            $fieldname = pg_field_name($result, $j);       
        }
        $punto=$line[$i-3]; 
        $cveesc=$line[$i-2];        
        $cve_unid=$line[$i-1];
        if ($cve_unid == ''){
         $cve_unid="00";           
        }        
        $nombre=$line[1];        
        $punto=str_replace('POINT(','',$punto);
        $punto=str_replace(')','',$punto); 
        $punto=str_replace(' ',', ',$punto);               
        
        echo "<td><button class='button' style='height: 30px; width: 30px;padding:1px 1px 1px 1px' type='button' onclick='window.parent.pointZoom($punto)' name='ver' title='Ver en mapa'><img id='ver' onclick='window.parent.pointZoom($punto)' alt='Ver en mapa' src='imagenes/ver_mapa.png' height='20' width='20'/></button></td>";
        echo "\t</tr>";
   }
echo "</table></div>";
    }
    $query = "SELECT cvegeo,nombre as Nombre,st_astext(ST_Transform(the_geom,4326)),cveesc,cve_unid FROM superior where st_intersects(ST_Transform(the_geom,4326), GeomFromText('POLYGON(($coords))',4326)) order by nombre";
    //echo $query;
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
    $rows = pg_num_rows($result);
    if ($rows<>0){$datos=1;$sup=$rows;
    echo "<center><button class='off ui-corner-all' style='width:300px'  onclick=toggleState(this);muestra_oculta('sup');>Superior ($rows)</button></center><div class='ui-widget-content ui-corner-all' style='display:none' id='sup'>";
    $i = pg_num_fields($result);
    echo "<table border='1'>\n";
    echo "<tr class='style2'>";
    for ($j = 0; $j < $i-3; $j++) {
        $fieldname = pg_field_name($result, $j);
        echo "<td>".strtoupper($fieldname)."</td>"; 
    }
    echo "<td>Ver en mapa</td>";
    
    echo "</tr>";
    while ($line = pg_fetch_array($result)) {
        echo "\t<tr>\n";
        for ($j = 0; $j < $i-3; $j++) {
            if ($line[$j] <> ""){
                echo "<td>$line[$j]</td>";
            }else{
                echo "<td>&nbsp;</td>";    
            }
            $fieldname = pg_field_name($result, $j);       
        }
        $punto=$line[$i-3]; 
        $cveesc=$line[$i-2];        
        $cve_unid=$line[$i-1];
        if ($cve_unid == ''){
         $cve_unid="00";           
        }        
        $nombre=$line[1];        
        $punto=str_replace('POINT(','',$punto);
        $punto=str_replace(')','',$punto); 
        $punto=str_replace(' ',', ',$punto);               
        
        echo "<td><button class='button' style='height: 30px; width: 30px;padding:1px 1px 1px 1px' type='button' onclick='window.parent.pointZoom($punto)' name='ver' title='Ver en mapa'><img id='ver' onclick='window.parent.pointZoom($punto)' alt='Ver en mapa' src='imagenes/ver_mapa.png' height='20' width='20'/></button></td>";
        echo "\t</tr>";
   }
echo "</table></div>";
    }

echo "</div></br>";        
}
@ob_flush();
	flush();

// manzanas con poblacion
$titles=array("Clave de manzana","Población total","Población de 0 a 14 años","Población de 15 a 29 años","Población de 15 a 64 años","Población de 30 a 49 años","Población nacida en la entidad","Población con discapacidad","Población de 15 años y más sin escolaridad","Población de 15 años y más con eduación básica incompleta","Población de 15 años y más con educación básica completa","Población de 15 años y más con educación pos-básica","Población de 18 años y más con al menos un grado en educación media superior","Población de 25 años y más con al menos un grado aprobado en educación superior","Grado promedio de escolaridad","Población económicamente activa","Población Ocupada",
"Población Desocupada","Población no económicamente activa","Población derechohabiente a servicios de salud","Población derechohabiente del IMSS","Población derechohabiente del ISSSTE o ISSSTE estatal","Total de viviendas","Total de viviendas habitadas","Viviendas particulares habitadas","Ocupantes en viviendas particulares","Viviendas particulares habitadas que disponen de luz eléctrica, agua entubada en el ámbito de la vivienda y drenaje","Viviendas particulares habitadas que no disponen de refrigerador, lavadora ni automóvil o camioneta","Viviendas particulares habitadas sin tecnologías de la información y la comunicación (TIC)","Viviendas particulares habitadas sin ningún bien");

$query = "SELECT cvegeo,pob1, pob8, 
       pob11, pob12, pob14, mig1, disc1, edu31, edu34, edu37, edu40, 
       edu43, edu46, edu49_r, eco1, eco4, eco25, eco28, salud1, salud3, 
       salud4, viv0, viv1, viv2, viv3, viv24, viv30, viv40, viv41,st_astext(st_centroid(ST_Transform(the_geom,4326))) FROM mza_pob where st_intersects(ST_Transform(the_geom,4326), GeomFromText('POLYGON(($coords))',4326)) order by cvegeo";
//echo $query;
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$rows = pg_num_rows($result);
if ($rows <> 0){$infra[0]=$rows;
echo "<br><center><button class='off ui-corner-all' style='width:450px' onclick=toggleState(this);muestra_oculta('infrahum');>Infraestructura humana ($rows)</button></center><div class='ui-widget-content ui-corner-all' style='display:none' id='infrahum'>";
echo "</br><center>SE ENCONTARON <b>$rows</b> MANZANAS CON INFORMACION</center>";
echo "</br><center>VALORES</CENTER>";
echo "<TABLE border='1'>";
echo "<TR><TD>-6</TD><TD>CONFIDENCIALIDAD</TD></TR>";
echo "<TR><TD>-9</TD><TD>NO ESPECIFICADO</TD></TR>";
echo "<TR><TD>-8</TD><TD>NO APLICA</TD></TR>";
echo "</TABLE>";
$i = pg_num_fields($result);
echo "<br><input type='checkbox' title='Desplegar información de población' id='po' onclick=vista(this)> Población &nbsp;&nbsp;&nbsp;";
echo "<input type='checkbox' title='Desplegar información de educación' id='ed' onclick=vista(this)> Educación &nbsp;&nbsp;&nbsp;";
echo "<input type='checkbox' title='Desplegar información de económico' id='ec' onclick=vista(this)> Económico &nbsp;&nbsp;&nbsp;";
echo "<input type='checkbox' title='Desplegar información de salud' id='sa' onclick=vista(this)> Salud &nbsp;&nbsp;&nbsp;";
echo "<input type='checkbox' title='Desplegar información de viviendas' id='vi' onclick=vista(this)> Vivienda &nbsp;&nbsp;&nbsp;<br>";

// Printing results in HTML
echo "<table border='1'>\n";
echo "<tr class='style2'>";
for ($j = 0; $j < $i-1; $j++) {
    $fieldname = pg_field_name($result, $j); 
    $valor=substr(pg_field_name($result, $j),0,2);
    
       switch ($valor){
            case "po":
                echo "<td title='$titles[$j]' class='ocultopo'>".strtoupper($fieldname)."</td>";       
                break;
            case "mi":
                echo "<td title='$titles[$j]' class='ocultopo'>".strtoupper($fieldname)."</td>";       
                break;
            case "di":
                echo "<td title='$titles[$j]' class='ocultopo'>".strtoupper($fieldname)."</td>";       
                break;
            case "ed":
                echo "<td title='$titles[$j]' class='ocultoed'>".strtoupper($fieldname)."</td>"; 
                break;
            case "ec":
                echo "<td title='$titles[$j]' class='ocultoec'>".strtoupper($fieldname)."</td>"; 
                break;
            case "sa":
                echo "<td title='$titles[$j]' class='ocultosa'>".strtoupper($fieldname)."</td>"; 
                break;
            case "vi":
                echo "<td title='$titles[$j]' class='ocultovi'>".strtoupper($fieldname)."</td>"; 
                break;
            default:
               echo "<td title='$titles[$j]'>".strtoupper($fieldname)."</td>";
               break;
            
                
        }
}
echo "<td>Ver en mapa</td>";
echo "</tr>";
while ($line = pg_fetch_array($result)) {
    echo "\t<tr>\n";
    for ($j = 0; $j < $i-1; $j++) {        
        $valor=substr(pg_field_name($result, $j),0,2);        
        switch ($valor){
            case "po":
                echo "<td class='ocultopo'>$line[$j]</td>"; 
                if ($line[$j]>=0){
                    $infra[$j]=$infra[$j]+$line[$j];
                }else{
                    $ignorados[$j]=$ignorados[$j]+1;
                }                
                break;
            case "mi":
                echo "<td class='ocultopo'>$line[$j]</td>"; 
                if ($line[$j]>=0){
                    $infra[$j]=$infra[$j]+$line[$j];
                }else{
                    $ignorados[$j]=$ignorados[$j]+1;
                }                
                break;
            case "di":
                echo "<td class='ocultopo'>$line[$j]</td>"; 
                if ($line[$j]>=0){
                    $infra[$j]=$infra[$j]+$line[$j];
                }else{
                    $ignorados[$j]=$ignorados[$j]+1;
                }                
                break;
            case "ed":
                echo "<td class='ocultoed'>$line[$j]</td>"; 
                if ($line[$j]>=0){             
                    $infra[$j]=$infra[$j]+$line[$j];
                }else{
                    $ignorados[$j]=$ignorados[$j]+1;
                }                
                break;
            case "ec":
                echo "<td class='ocultoec'>$line[$j]</td>"; 
                if ($line[$j]>=0){             
                    $infra[$j]=$infra[$j]+$line[$j];
                }else{
                    $ignorados[$j]=$ignorados[$j]+1;
                }
                break;
            case "sa":
                echo "<td class='ocultosa'>$line[$j]</td>"; 
                if ($line[$j]>=0){
                    $infra[$j]=$infra[$j]+$line[$j];
                }else{
                    $ignorados[$j]=$ignorados[$j]+1;
                }
                break;
            case "vi":
                echo "<td class='ocultovi'>$line[$j]</td>"; 
                if ($line[$j]>=0){
                    $infra[$j]=$infra[$j]+$line[$j];
                }else{
                    $ignorados[$j]=$ignorados[$j]+1;
               }
                break;
            default:
               echo "<td>$line[$j]</td>"; 
               break;
            
                
        }     
           
     }
    $punto=$line[$i-1]; 
    $punto=str_replace('POINT(','',$punto);
    $punto=str_replace(')','',$punto); 
    $punto=str_replace(' ',', ',$punto);               
    echo "<td><button class='button' style='height: 30px; width: 30px;padding:1px 1px 1px 1px' type='button' onclick='window.parent.pointZoom($punto)' name='ver' title='Ver en mapa'><img id='ver' onclick='window.parent.pointZoom($punto)' alt='Ver en mapa' src='imagenes/ver_mapa.png' height='20' width='20'/></button></td>";
    echo "\t</tr>\n";
}

echo "</table></div></br>";        
}
@ob_flush();
	flush();

// ********************************************************************************************************************************* Inicia: Entorno Urbano ************************************************************************************************
// manzanas con entorno urbano
$titles=array("Clave de manzana", "Total de viviendas", "Total de viviendas habitadas", "% Total de viviendas habitadas", "Total de viviendas particulares", "% Total de viviendas particulares", "Viviendas particulares habitadas", "% Viviendas particulares habitadas",
              "Viviendas particulares deshabitadas", "% Viviendas particulares deshabitadas", "Viviendas particulares de uso temporal", "% Viviendas particulares de uso temporal", "Viviendas particulares no habitadas", "% Viviendas particulares de uso temporal",
			  "Con recubrimiento en piso", "% Con recubrimiento en piso", "Con energía eléctrica", "% Con energía eléctrica", "Con agua entubada", "% Con agua entubada", "Con drenaje", "% Con drenaje", "Con servicio sanitario", "% Con servicio sanitario",
			  "Viviendas con 3 o más ocupantes por cuarto", "% Viviendas con 3 o más ocupantes por cuarto", "Promedio de ocupantes por vivienda", "Población total", "Población de 0 a 14 años", "% Población de 0 a 14 años", "Población de 15 a 29 años",
			  "% Población de 15 a 29 años", "Población de 30 a 59 años", "% Población de 30 a 59 años", "Población de 60 y más años", "% Población de 60 y más años", "Población con discapacidad", "% Población con discapacidad", "Promedio de escolaridad",
			  "Acceso de personas", "Acceso de automóviles", "Pavimento de calles", "Letrero con nombre de la vialidad", "Alumbrado público", "Teléfono público", "Banqueta", "Guarnición", "Plantas de ornato", "Rampa para silla de ruedas", "Presencia de comercio semifijo",
			  "Presencia de comercio ambulante", "Acceso de personas", "Acceso de automóviles", "Pavimento de calles", "Letrero con nombre de la vialidad", "Alumbrado público", "Teléfono público", "Banqueta", "Guarnición", "Plantas de ornato", "Rampa para silla de ruedas",
			  "Presencia de comercio semifijo", "Presencia de comercio ambulante", "Fecha de la última actualización del polígono", "Fecha de la información", "Fecha del Cuestionario de Entorno Urbano");

$query = "SELECT cvegeo, vivtot, tvivhab, p_tvivhab, tvivpar, p_tvivpar, tvivparhab, pvivparhab, vivpar_des, p_vivpar_d, vivpar_ut, p_vivpar_u, vivnohab, p_vivnohab, vph_pisodt, p_v_pisodt, vph_c_elec, p_v_c_elec, vph_aguadv, p_v_aguadv, vph_drenaj, p_v_drenaj,
          vph_excusa, p_v_excusa, v_3masocup, p_3masocup, proocup_c, pobtot, p0a14a, pp0a14a, p15a29a, pp15a29a, p30a59a, pp30a59a, p_60ymas, pp_60ymas, pcon_lim, ppcon_lim, graproes, acesoper_, acesoaut_, recucall_, senaliza_, alumpub_, telpub_, banqueta_,
		  guarnici_, arboles_, rampas_, puessemi_, puesambu_, acesoper_c, acesoaut_c, recucall_c, senaliza_c, alumpub_c, telpub_c, banqueta_c, guarnici_c, arboles_c, rampas_c, puessemi_c, puesambu_c, fecha_poli, fecha_inf, fecha_ceu,
          st_astext(st_centroid(ST_Transform(the_geom,4326))) FROM entorno_urbano where st_intersects(ST_Transform(the_geom,4326), GeomFromText('POLYGON(($coords))',4326)) order by cvegeo";
//echo $query;
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$rows = pg_num_rows($result);
if ($rows <> 0){$infra[0]=$rows;
echo "<br><center><button class='off ui-corner-all' style='width:450px' onclick=toggleState(this);muestra_oculta('entorurb');>Entorno urbano ($rows)</button></center><div class='ui-widget-content ui-corner-all' style='display:none' id='entorurb'>";
echo "</br><center>SE ENCONTARON <b>$rows</b> MANZANAS CON INFORMACION</center>";
echo "</br><center>VALORES</CENTER>";
echo "<TABLE border='1'>";
echo "<TR><TD>*</TD><TD>CONFIDENCIALIDAD</TD></TR>";
echo "</TABLE>";
$i = pg_num_fields($result);
echo "<br><input type='checkbox' title='Desplegar información de viviendas' id='vi' onclick=vista(this)> Viviendas &nbsp;&nbsp;&nbsp;";

// Printing results in HTML
echo "<table border='1'>\n";
echo "<tr class='style2'>";
for ($j = 0; $j < $i-1; $j++) {
    $fieldname = pg_field_name($result, $j); 
    $valor=substr(pg_field_name($result, $j),0,2);
    
       switch ($valor){
            case "vi":
                echo "<td title='$titles[$j]' class='ocultovi'>".strtoupper($fieldname)."</td>";       
                break;
            default:
               echo "<td title='$titles[$j]'>".strtoupper($fieldname)."</td>";
               break;
            
                
        }
}
echo "<td>Ver en mapa</td>";
echo "</tr>";
while ($line = pg_fetch_array($result)) {
    echo "\t<tr>\n";
    for ($j = 0; $j < $i-1; $j++) {        
        $valor=substr(pg_field_name($result, $j),0,2);        
        switch ($valor){
            case "vi":
                echo "<td class='ocultovi'>$line[$j]</td>"; 
                if ($line[$j]>=0){
                    $infra[$j]=$infra[$j]+$line[$j];
                }else{
                    $ignorados[$j]=$ignorados[$j]+1;
                }                
				break;
            default:
               echo "<td>$line[$j]</td>"; 
               break;  
        }     
    }
    $punto=$line[$i-1]; 
    $punto=str_replace('POINT(','',$punto);
    $punto=str_replace(')','',$punto); 
    $punto=str_replace(' ',', ',$punto);               
    echo "<td><button class='button' style='height: 30px; width: 30px;padding:1px 1px 1px 1px' type='button' onclick='window.parent.pointZoom($punto)' name='ver' title='Ver en mapa'><img id='ver' onclick='window.parent.pointZoom($punto)' alt='Ver en mapa' src='imagenes/ver_mapa.png' height='20' width='20'/></button></td>";
    echo "\t</tr>\n";
}

echo "</table></div></br>";        
}
@ob_flush();
	flush();
// ********************************************************************************************************************************* Finaliza: Entorno Urbano ************************************************************************************************
	
echo "<div id='bgrupos'>";
echo "<br><center><button class='off ui-corner-all' style='width:450px'  onclick=toggleState(this);muestra_oculta('grupos');>Grupos</button></center><div class='ui-widget-content ui-corner-all' style='display:none' id='grupos'><br>";
$query = "SELECT nombre$idio,clases_2014,tipo,imagen from clusters where clases_2014 <> '' order by imagen";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$indio=0;
$grupasa=0;
//echo $query;
while ($row = pg_fetch_array($result)){
    $tipo=$row[2];
    //$clases="'".str_replace(",", "','", $row[1])."'";
    $clases=$row[1];
    $nombre=$row[0];
    $grupos[$indio]=$row[0];
    $imagen=$row[3];
	$class_array = explode(',', $clases);
	//echo "<br><br>";
	//print_r($class_array);
	//print_r($clase_con);
	$resulta = array_intersect($class_array, $clase_con);
	//echo $resulta;
	if ($resulta){
	//$resulta2 = array_keys($clase_con,$class_array);
	//print_r($resulta);
	//print_r($resulta2);
	$keys = array();
	foreach ($class_array as $valor) {
		$keys=array_merge($keys,array_keys($clase_con,$valor));
	}
	//print_r($keys);
	
   
	//$consulta1="select nom_estab,st_astext(ST_Transform(the_geom,4326)) from c_denue_2014 where ";
    //$consulta1=$consulta1."codigo_act in (";   
    //$consulta1=$consulta1.$clases.") and st_intersects(ST_Transform(the_geom,4326),GeomFromText('POLYGON(($coords))',4326))";
    //echo $nombre."<br>".$clases;
    //$result2 = pg_query($consulta1) or die('Query failed: ' . pg_last_error());
    $rows = count($keys);
    if ($rows <> 0){$datos=1;
    echo "<center><button class='off ui-corner-all' style='width:300px'  onclick=toggleState(this);muestra_oculta('$imagen');>$grupos[$indio] ($rows)</button></center><div class='ui-widget-content ui-corner-all' style='display:none' id='$imagen'>";
    //echo "</br><center>SE ENCONTARON <b>$rows</b> elementos del grupo $grupos[$indio]</center></br>";
    $grupasa=1;
    $cuantos[$indio]=$rows;
	echo "<table border='1'>\n";
    echo "<tr class='style2'>";
	echo "<td>Nombre</td><td>Ver en mapa</td></tr>";
    foreach ($keys as $key) {
		echo "<tr><td>".$nombre_con[$key]."</td>";
		$punto=$puntos_con[$key];
		echo "<td align='center'><button class='button' style='height: 30px; width: 30px;padding:1px 1px 1px 1px' onclick='window.parent.zoomer2($punto)' type='button' name='ver' title='Ver en mapa'><img id='ver' onclick='window.parent.pointZoom($punto)' alt='Ver en mapa' src='imagenes/ver_mapa.png' height='20' width='20'/></button></td>";
	}
	
	
	
	
	
	
    //echo "<td><button class='button' style='height: 30px; width: 30px;padding:1px 1px 1px 1px' onclick='window.parent.pointZoom($punto)' type='button' name='ver' title='Ver en mapa'><img id='ver' onclick='window.parent.pointZoom($punto)' alt='Ver en mapa' src='imagenes/ver_mapa.png' height='20' width='20'/></button></td>";
    

echo "</table></div>";        
}
$indio=$indio+1;
}
}
echo "</div></div><br>";

@ob_flush();
	flush();

@ob_flush();
	flush();






$query = "SELECT codigo_act,count(codigo_act) as Cantidad,nombre_act$idio as Clase_actividad FROM c_denue_2014 where st_intersects(ST_Transform(the_geom,4326),GeomFromText('POLYGON(($coords))',4326)) group by codigo_act,nombre_act$idio order by count(codigo_act) desc";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$i = pg_num_fields($result);
$rows = pg_num_rows($result);
if ($rows <> 0 || $datos <> 0){
$datos=1;
echo "<br><center><button class='off ui-corner-all' style='width:450px'  onclick=toggleState(this);muestra_oculta('res');>Resumen del área seleccionada</button></center><div class='ui-widget-content ui-corner-all' style='display:none' id='res'>";
if ($rows<>0){
echo "<center><button class='off ui-corner-all' style='width:300px'  onclick=toggleState(this);muestra_oculta('resest');>Resumen de establecimientos</button></center><div class='ui-widget-content ui-corner-all' style='display:none' id='resest'>";
// Printing results in HTML
echo "<table border='1'>\n";
echo "<tr class='style2'>";
for ($j = 0; $j < $i; $j++) {
      $fieldname = pg_field_name($result, $j);
      echo "<td>$fieldname</td>"; 
}
echo "</tr>";
while ($line = pg_fetch_array($result)) {
    echo "\t<tr>\n";
     for ($j = 0; $j < $i; $j++) {
        echo "<td>$line[$j]</td>";
        $fieldname = pg_field_name($result, $j);       
		}
    echo "\t</tr>\n";
}
echo "</table></div><br>";
}




if ($temp <> 0){
//echo "<br><center><button class='off ui-corner-all' style='width:300px'  onclick=toggleState(this);muestra_oculta('var_clima2');>VARIABLES CLIMATICAS</button></center><div class='ui-widget-content ui-corner-all' style='display:none' id='var_clima2'>";
echo "</br><center>Variables climáticas</center>";
echo "<table border='1'>\n";

// Printing results in HTML
echo "\t<tr>\n";
echo "<td class='style2'>Temperatura</td>";
if ($temperaturas <> ""){
   echo "<td>$temperaturas</td>";
}else{
   echo "<td>&nbsp;</td>";    
}        
echo "\t</tr>\n";
echo "\t<tr>\n";
echo "<td class='style2'>Precipitación</td>";
if ($precips <> ""){
   echo "<td>$precips</td>";
}else{
   echo "<td>&nbsp;</td>";    
}
echo "\t</tr>\n";
echo "\t<tr>\n";
echo "<td class='style2'>Grupo climático</td>";
if ($climas <> ""){
   echo "<td>$climas</td>";
}else{
   echo "<td>&nbsp;</td>";    
}    
echo "\t</tr>\n";    
echo "</table></br>";        
}

if ($ccam <> 0 || $esc<>0 || $plocrur<>0 || $anpe<>0 || $anpf<>0 || $ps<>0 || $us<>0 || $ts<>0 || $aero<>0 || $adu<>0){
echo "<br><center>Datos en el área seleccionada</center>";  
// Printing results in HTML
echo "<table border='1'>\n";
echo "<tr class='style2'>";
      echo "<td>Nombre</td>"; 
      echo "<td>Cantidad</td>"; 
echo "</tr>";
if ($us<>0){
    echo "\t<tr>\n";
        echo "<td>Uso de suelo y vegetación</td>";
        echo "<td>$us</td>";
    echo "\t</tr>\n";
}
if ($ts<>0){
    echo "\t<tr>\n";
        echo "<td>Edafología</td>";
        echo "<td>$ts</td>";
    echo "\t</tr>\n";
}
if ($troc<>0){
    echo "\t<tr>\n";
        echo "<td>Tipo de roca</td>";
        echo "<td>$troc</td>";
    echo "\t</tr>\n";
}

if ($cf<>0){
    echo "\t<tr>\n";
        echo "<td>Fallas</td>";
        echo "<td>$cf</td>";
    echo "\t</tr>\n";
}
if ($fra<>0){
    echo "\t<tr>\n";
        echo "<td>Fracturas</td>";
        echo "<td>$fra</td>";
    echo "\t</tr>\n";
}
if ($anpe<>0){
    echo "\t<tr>\n";
        echo "<td>Áreas Naturales Protegidas (Estatal)</td>";
        echo "<td>$anpe</td>";
    echo "\t</tr>\n";
}
if ($anpf<>0){
    echo "\t<tr>\n";
        echo "<td>Áreas Naturales Protegidas (Federales)</td>";
        echo "<td>$anpf</td>";
    echo "\t</tr>\n";
}
if ($tira<>0){
    echo "\t<tr>\n";
        echo "<td>Relleno sanitario</td>";
        echo "<td>$tira</td>";
    echo "\t</tr>\n";
}
if ($plocrur<>0){
    echo "\t<tr>\n";
        echo "<td>HABITANTES LOC. RURALES($locrur)</td>";
        echo "<td>$plocrur</td>";
    echo "\t</tr>\n";
}
if ($ccam<>0){
    echo "\t<tr>\n";
        echo "<td>Centros de asistencia médica</td>";
        echo "<td>$ccam</td>";
    echo "\t</tr>\n";
}
if ($aero<>0){
    echo "\t<tr>\n";
        echo "<td>Aeropuertos</td>";
        echo "<td>$aero</td>";
    echo "\t</tr>\n";
}
if ($adu<>0){
    echo "\t<tr>\n";
        echo "<td>Agencias aduanales</td>";
        echo "<td>$adu</td>";
    echo "\t</tr>\n";
}
echo "</table>";
}


if ($esc<>0){
echo "<br><center>Escuelas</center>";  
// Printing results in HTML
echo "<table border='1'>\n";
echo "<tr class='style2'>";
      echo "<td>Nivel</td>"; 
      echo "<td>Cantidad</td>"; 
echo "</tr>";
if ($pre<>0){
    echo "\t<tr>\n";
        echo "<td>Preescolar</td>";
        echo "<td>$pre</td>";
    echo "\t</tr>\n";
}
if ($pri<>0){
    echo "\t<tr>\n";
        echo "<td>Primaria</td>";
        echo "<td>$pri</td>";
    echo "\t</tr>\n";
}
if ($sec<>0){
    echo "\t<tr>\n";
        echo "<td>Secundaria</td>";
        echo "<td>$sec</td>";
    echo "\t</tr>\n";
}
if ($med<>0){
    echo "\t<tr>\n";
        echo "<td>Media superior</td>";
        echo "<td>$med</td>";
    echo "\t</tr>\n";
}
if ($sup<>0){
    echo "\t<tr>\n";
        echo "<td>Superior</td>";
        echo "<td>$sup</td>";
    echo "\t</tr>\n";
}
if ($otr<>0){
    echo "\t<tr>\n";
        echo "<td>Otros</td>";
        echo "<td>$otr</td>";
    echo "\t</tr>\n";
}
if ($div<>0){
    echo "\t<tr>\n";
        echo "<td>Diversos</td>";
        echo "<td>$div</td>";
    echo "\t</tr>\n";
}
echo "</table>";
}



if ($esc2<>0){
echo "<br><center>Escuelas</center>";  
// Printing results in HTML
echo "<table border='1'>\n";
echo "<tr class='style2'>";
      echo "<td>Nivel</td>"; 
      echo "<td>Cantidad</td>"; 
echo "</tr>";
    echo "\t<tr>\n";
        echo "<td>TODOS</td>";
        echo "<td>$esc2</td>";
    echo "\t</tr>\n";
echo "</table>";
}


if ($infral[0]<>0){   
	echo "<br><center>Localidades Rurales</center>";  
	echo "<table border='1'>\n";
	
	
	for ($j = 0; $j < count($titlesrur); $j++) {
		if ($j<>15 && $j<>1){
		echo "<tr>";
			if ($j==0){
				echo "<td class='style2' title='Localidades'> LOCALIDADES </td>";
			}else{
				echo "<td class='style2' title='$titlesrur[$j]'>$titlesrur[$j](".($infral[0]-$ignoradosl[$j]).")</td>";
			}
		
			if ($j==500){				
				$valor=round(($infral[35]/$infral[20])*100,2);
			}else{
				$valor=$infral[$j];  
			}
		
			if (($infral[0]-$ignoradosl[$j])==0){
					echo "<td>-</td>";        
			}else{
					echo "<td>$valor</td>";        
			}
		echo "</tr>";
		}
	}
	echo "</table>";
}


if ($infra[0]<>0){   
	echo "<br><center>Infraestructura humana</center>";  
	echo "<table border='1'>\n";
	
	//echo "<td>MANZANAS</td>"; 
	for ($j = 0; $j < 30; $j++) {
		if ($j<>14){
		echo "<tr>";
			if ($j==0){
				echo "<td class='style2' title='Cantidad de manzanas'> MANZANAS </td>";
			}else{
				echo "<td class='style2' title='$titles[$j]'>$titles[$j](".($infra[0]-$ignorados[$j]).")</td>";
			}
		
			if ($j==500){
				$valor=round(($infra[2]/$infra[3])*100,2);  
			}else{
				$valor=$infra[$j];  
			}
		
			if (($infra[0]-$ignorados[$j-1])==0){
					echo "<td>-</td>";        
			}else{
					echo "<td>$valor</td>";        
			}
		echo "</tr>";
		}
	}
	echo "</table>";
}

}//$rows <> 0

if ($grupasa<>0){
echo "<br><center>Grupos</center>";  
// Printing results in HTML
echo "<table border='1'>\n";
$indio=0;
echo "<tr class='style2'>";
      echo "<td>Nombre</td>"; 
      echo "<td>Cantidad</td>"; 
echo "</tr>";
foreach ($grupos as $valor) {
    if ($cuantos[$indio]<>0){
    echo "\t<tr>\n";
        echo "<td>$valor</td>";
        echo "<td>$cuantos[$indio]</td>";
    echo "\t</tr>\n";
}
 $indio=$indio+1;   
}
echo "</table></div>";
}else{
    echo "<script>document.getElementById('bgrupos').style.display='none';</script>";
}

//$rows <> 0

if ($datos==0){
  echo "<br><br><center>NO EXISTE INFORMACION EN EL AREA SELECCIONADA</center>";    
}
// Free resultset
pg_free_result($result);

// Closing connection
pg_close($conn);
?>    
</center>

</body>

</html>
