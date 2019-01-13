<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1" />
<title>.:Ficha:.</title>
<style type="text/css">
.style1 {
	font-size: medium;
}
.boldtable, .boldtable TD, .boldtable TH
{
font-family:sans-serif;
font-size:10pt;

}
.contenido {
    height:300px;
	
	overflow-x:auto;
    overflow-y:auto;
}
.fuente{
  font-family: Arial;
  color: #0c1ff2;
  font-size: 12px;
  text-decoration: none;
  cursor:pointer;
}


</style>
</head>
   <link rel="stylesheet" href="js/jquery-ui-1.10.32/themes/base/jquery.ui.all.css">    
    <script src="js/jquery-ui-1.10.32/jquery-1.9.1.js"></script>
    <script src="js/jquery-ui-1.10.32/ui/jquery-ui.js"></script>
<script>
function lin(){    
window.opener.limpia_marcas3();
}
function abre(dato){        
window.open("crea_ficha.php?dato="+dato,'Ficha','width=800,height=500,scrollbars=1');    
}
function getArray() {
    return array("AGS","BC","BCS","CAMP","COAH","COL","CHIS","CHIH","DF","DGO","GTO","GRO","HGO","JAL","MÉX","MICH","MOR","NAY","NL","OAX","PUE","QRO","QROO","SLP",
		"SIN","SON","TAB","TAMPS","TLAX","VER","YUC","ZAC");
}
 $(function() {
    $("#tabs" ).tabs({collapsible: true,active: false});
  });

</script>    
<body>
<?php    
error_reporting(0);
$dato=$_GET['dato'];

$dato=$_GET['id'];
$tema=$_GET['tema']; 
if ($tema=='1'){
	$conn = pg_connect("host=10.221.67.10 dbname=agrupa user=postgres password=inegi2018 port=5432") or die('Could not connect: ' . pg_last_error());	  
  }else{
	$conn = pg_connect("host=10.221.67.10 dbname=mdm6data_zac user=postgres password=inegi2018 port=5432") or die('Could not connect: ' . pg_last_error());	  
  }  
include "ficha_config.php";
$result3 = pg_query("Select nombre,clases_2014,imagen from clusters where imagen='$dato'") or die('Query failed: ' . pg_last_error());


//$resulinfo = pg_query("SELECT sum(ue), sum(p_ocupado),sum(remun), sum(t_gastos), sum(t_ingresos), sum(p_bruta), sum(consumo), sum(v_agregado), sum(inv_total) FROM public.cat_saic_2014 where ent='00' and mpio='00' group by ent") or die('Query failed: ' . pg_last_error());
$resulinfo = pg_query("SELECT ue, p_ocupado,remun, t_gastos, t_ingresos, p_bruta, consumo,v_agregado, inv_total FROM public.cat_saic_2014  where clase = '000000' and (entidad = 'Total Nacional' or entidad='Estados Unidos Mexicanos')" ) or die('Query failed: ' . pg_last_error());
$info = pg_fetch_array($resulinfo);
$ue_tot_nac=$info[0];
$p_ocup_nac=$info[1];
$inversion_nac=$info[8];
$remun_nac=$info[2];
$gastos_nac=$info[3];
$ingresos_nac=$info[4];
$produccion_nac=$info[5];
$consumo_nac=$info[6];
$valor_nac=$info[7];









if ($line = pg_fetch_array($result3)){    
    $clases_cons="'".$line[1]."'";
    $clases_cons=  str_replace(",", "','", $clases_cons);    
    $clases=$line[1];
   
    
?>
<center>
 <div id="tabs">
 <b><?php echo $line[0]?></b><ul>
            <li><a id="tab1" href="#tabs-1">Unidades económicas</a></li>            
            <li><a href="#tabs-2">Personal ocupado</a></li>
            <li><a href="#tabs-3">Remuneraciones</a></li>
            <li><a href="#tabs-4">Gastos consumo bienes y serv.</a></li>
            <li><a href="#tabs-5">Ing. por suministro de bienes y serv.</a></li>
            <li><a href="#tabs-6">Producción bruta</a></li>            
            <li><a href="#tabs-7">Consumo intermedio</a></li>            
            <li><a href="#tabs-8">Valor agregado censal bruto</a></li>            
            <li><a href="#tabs-9">Inversión total</a></li>            
        </ul>
  <div id="tabs-1" class='contenido'>
      <?php    
    	echo "<br>";
 	echo "<table style='width:700px' border=1 bordercolor='#1997FF' CLASS='boldtable'>";
	echo "<tr>";
        echo "<td align='center' colspan='2' width='20%'><b>VARIABLE</b></td>";
       // echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center' width='2%'><b>NACIONAL</b></td>";

		
    $fedos_array = array("01"=>"AGS","02"=>"BC","03"=>"BCS","04"=>"CAMP","05"=>"COAH","06"=>"COL","07"=>"CHIS","08"=>"CHIH","09"=>"CDMX","10"=>"DGO","11"=>"GTO","12"=>"GRO","13"=>"HGO","14"=>"JAL","15"=>"MÉX","16"=>"MICH","17"=>"MOR","18"=>"NAY","19"=>"NL","20"=>"OAX","21"=>"PUE","22"=>"QRO","23"=>"QROO","24"=>"SLP",
		"25"=>"SIN","26"=>"SON","27"=>"TAB","28"=>"TAMPS","29"=>"TLAX","30"=>"VER","31"=>"YUC","32"=>"ZAC");

$vmaxiedos=count($cve_edos_array)-1;

    foreach ($cve_edos_array as $valor_edos){
         echo "<td align='center' width='2%'><b>".$fedos_array[$valor_edos]."</b></td>";
        }
		
    echo "</tr>";    
    echo "<tr bgcolor='#59AAFF'>";
        echo "<td colspan='2' align='center'><b>Unidades económicas</b></td>";
        echo "<td align='center' title='NACIONAL / Unidades económicas'><b>".number_format($ue_tot_nac)."</b></td>";
	$i_edos=0;
    foreach ($cve_edos_array as $valor_edos){
         $resulinfo = pg_query("SELECT ue, p_ocupado,remun, t_gastos, t_ingresos, p_bruta, consumo, v_agregado, inv_total FROM public.cat_saic_2014 where ent='$cve_edos_array[$i_edos]' and mpio='$cve_edos_array[$i_edos]' and descrip='Total'") or die('Query failed: ' . pg_last_error());
			$info = pg_fetch_array($resulinfo);
			$ue_tot[$i_edos]=$info[0];
			//$ue_tot.$cve_edos_array[$i_edos]=$ue_tot;
			$p_ocup[$i_edos]=$info[1];
			$inversion[$i_edos]=$info[8];
			$remun[$i_edos]=$info[2];
			$gastos[$i_edos]=$info[3];
			$ingresos[$i_edos]=$info[4];
			$produccion[$i_edos]=$info[5];
			$consumo[$i_edos]=$info[6];
			$valor_a[$i_edos]=$info[7];
	 	 	 
	
        echo "<td align='center' title='$fedos_array[$valor_edos] / Unidades económicas'><b>".number_format($ue_tot[$i_edos])."</b></td>";
			 $i_edos=$i_edos+1;
		 	 
        }
    echo "</tr>";      
    
     echo "<tr>";
        echo "<td colspan='2' align='center'><b>Clases</b></td>";
        for ($x = 0; $x <=  $vmaxiedos+1; $x++) {
		echo "<td align='center'>&nbsp;</td>";
     } 
        
    echo "</tr>";
    
    
    //echo $clases;
    $clases_array = explode(",", $clases);       
    $paso=true;
    foreach ($clases_array as $valor){
        if ($paso==true){
            echo "<tr bgcolor='#59AAFF'>";
            $paso=false;    
        }else{
            echo "<tr>";
            $paso=true;        
        }
		///Nacional
        $resulinfo = pg_query("Select descrip from cat_saic_2014 where clase = '$valor'") or die('Query failed: ' . pg_last_error());
        //$result = pg_query("Select sum(ue),descrip from cat_saic_2014 where ent='00' and mpio='00' and clase = '$valor' and ue > 0 group by ue,descrip") or die('Query failed: ' . pg_last_error());
	$result = pg_query("Select ue,descrip from cat_saic_2014 where ent='00' and mpio='00' and clase = '$valor'") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
        $info = pg_fetch_array($resulinfo);  
        $title=$info[0];		
        echo "<td align='center'>".$info[0]."</b></td>";	
        echo "<td align='center'>$valor</td>";        
        
		
		if ($dato[0]<>'*'){
        echo "<td align='center' title='NACIONAL / $title'>".number_format($dato[0])."</b></td>";
	}else{
        echo "<td align='center' title='NACIONAL / $title'>".$dato[0]."</td>";
        }  	
        
		
		//$result = pg_query("Select sum(CAST(REGEXP_REPLACE('0' || COALESCE(ue,'0'), '[^0-9]+', '', 'g') AS float8)) from cat_saic_2014 where ent='05' and mpio='05' and clase = '$valor' and CAST(REGEXP_REPLACE('0' || COALESCE(ue,'0'), '[^0-9]+', '', 'g') AS float8) > 0 and descrip<>'Total'") or die('Query failed: ' . pg_last_error());
 
 $i_edos=0;
    foreach ($cve_edos_array as $valor_edos){
        $result = pg_query("Select ue from cat_saic_2014 where ent='$cve_edos_array[$i_edos]' and mpio='$cve_edos_array[$i_edos]' and clase = '$valor'") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
		//echo "Select ue from cat_saic_2014 where ent='$cve_edos_array[$i_edos]' and mpio='$cve_edos_array[$i_edos]' and clase = '$valor'";
        if ($dato[0]<>'*'){
        echo "<td align='center' title='$fedos_array[$valor_edos] / $title'>".number_format($dato[0])."</b></td>";
	}else{
        echo "<td align='center' title='$fedos_array[$valor_edos] / $title'>".$dato[0]."</td>";
        }
$i_edos=$i_edos+1;	
}	
    echo "</tr>";   
    }
    
    echo "<tr bgcolor='#59AAFF'>";
        echo "<td colspan='2' align='center'><b>TOTAL DE CLASES</b></td>";
        //echo "<td align='center'>$valor</td>";
		
		///Nacional
        $result = pg_query("Select sum(CAST(REGEXP_REPLACE('0' || COALESCE(ue,'0'), '[^0-9]+', '', 'g') AS float8)) from cat_saic_2014 where ent='00' and mpio='00'and clase in ($clases_cons) and CAST(REGEXP_REPLACE('0' || COALESCE(ue,'0'), '[^0-9]+', '', 'g') AS float8) >  0 and descrip<>'Total'") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
        $acum_nac=$dato[0];
        echo "<td align='center' title='NACIONAL / Total de clases'><b>".number_format($acum_nac)."</b></td>";
        
		$i_edos=0;
		foreach ($cve_edos_array as $valor_edos){
        $result = pg_query("Select sum(CAST(REGEXP_REPLACE('0' || COALESCE(ue,'0'), '[^0-9]+', '', 'g') AS float8)) from cat_saic_2014 where ent='$cve_edos_array[$i_edos]' and mpio='$cve_edos_array[$i_edos]' and clase in ($clases_cons) and CAST(REGEXP_REPLACE('0' || COALESCE(ue,'0'), '[^0-9]+', '', 'g') AS float8) >  0 and descrip<>'Total'") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
        //$acum=$dato[0];
		
		$acum[$i_edos]=$dato[0];
		  
		  echo "<td align='center' title='$fedos_array[$valor_edos] / Total de clases'><b>".number_format($dato[0])."</b></td>";
		$i_edos=$i_edos+1;
		}
		
    echo "</tr>";   
    
    echo "<tr>";
        echo "<td colspan='2' align='center'><b>%Unidades económicas respecto al Total</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
		
        echo "<td align='center' title='NACIONAL / Unidades económicas respecto al Total'>".round(($acum_nac / $ue_tot_nac)* 100,2)."</td>";
		
		$i_edos=0;
		foreach ($cve_edos_array as $valor_edos){
		echo "<td align='center' title='$fedos_array[$valor_edos] / Unidades económicas respecto al Total'>".round(($acum[$i_edos]/$ue_tot[$i_edos])* 100,2)."</td>";
		$i_edos=$i_edos+1;
		}
    echo "</tr>";
    
    echo "<tr>";
        echo "<td colspan='2' align='center'><b>%Unidades económicas en estado respecto al Nacional</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center'>-</td>";
		$i_edos=0;
		foreach ($cve_edos_array as $valor_edos){
		echo "<td align='center' title = '$fedos_array[$valor_edos] / Unidades económicas en estado respecto al Nacional' >".round(($acum[$i_edos]/$acum_nac)* 100,2)."</td>";
	$i_edos=$i_edos+1;
		}	
		
    echo "</tr>";       
  echo "</table>";
?>    
  </div>
  <div id="tabs-2" class='contenido'>
  <?php    
    echo "<br>";
    echo "<table style='width:700px' border=1 bordercolor='#1997FF' CLASS='boldtable'>";
    echo "<tr>";
        echo "<td align='center' colspan='2' width='20%'><b>VARIABLE</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center' width='2%'><b>NACIONAL</b></td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center' width='2%'><b>".$fedos_array[$cve_edos_array[$i_edos]]."</b></td>";
		}
    echo "</tr>";    
    echo "<tr bgcolor='#59AAFF'>";
        echo "<td colspan='2' align='center'><b>Empleo total</b></td>";
		echo "<td align='center' title='NACIONAL / Empleo total'><b>".number_format($p_ocup_nac)."</b></td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
         echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]."  / Empleo total'><b>".number_format($p_ocup[$i_edos])."</b></td>";
		}
    echo "</tr>";      
    
     echo "<tr>";
        echo "<td colspan='2' align='center'><b>Clases</b></td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos+1; $i_edos++) {
        echo "<td align='center'>&nbsp;</td>";
		}
    echo "</tr>";
    
    
    //echo $clases;
    $clases_array = explode(",", $clases);       
    $paso=true;
    foreach ($clases_array as $valor){
        if ($paso==true){
            echo "<tr bgcolor='#59AAFF'>";
            $paso=false;    
        }else{
            echo "<tr>";
            $paso=true;        
        }
        $resulinfo = pg_query("Select descrip from cat_saic_2014 where clase = '$valor'") or die('Query failed: ' . pg_last_error());
        $info = pg_fetch_array($resulinfo);
        $result = pg_query("Select p_ocupado,descrip from cat_saic_2014 where ent='00' and mpio='00' and clase = '$valor'") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
		$val_nac=$dato[0];
		$title=$info[0];
        echo "<td align='center'>".$info[0]."</b></td>";
        echo "<td align='center'>$valor</td>";        
        if ($dato[0]<>'*'){
        echo "<td align='center' title='NACIONAL / $title'>".number_format($dato[0])."</b></td>";
	}else{
        echo "<td align='center' titlae='NACIONAL / $title'>".$dato[0]."</td>";
        }  
		
		
		$i_edos=0;
		foreach ($cve_edos_array as $valor_edos){
        $result = pg_query("Select p_ocupado from cat_saic_2014 where ent='$cve_edos_array[$i_edos]' and mpio='$cve_edos_array[$i_edos]' and clase = '$valor'") or die('Query failed: ' . pg_last_error());
		$dato = pg_fetch_array($result);
		$p_ocup_clase[$i_edos]=$dato[0];
		//echo "Select p_ocupado from cat_saic_2014 where ent='$cve_edos_array[$i_edos]' and mpio='$cve_edos_array[$i_edos]' and clase = '$valor'";
       if ($dato[0]<>'*'){
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]."/ $title'>".number_format($dato[0])."</b></td>";
	}else{
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]."/ $title'>".$dato[0]."</td>";
        }
		$i_edos=$i_edos+1;
		}
         
    echo "</tr>";   
    }
    
    echo "<tr bgcolor='#59AAFF'>";
        echo "<td colspan='2' align='center'><b>TOTAL DE CLASES</b></td>";
        //echo "<td align='center'>$valor</td>";
        $result = pg_query("Select sum(p_ocupado) from cat_saic_2014 where ent='00' and mpio='00' and clase in ($clases_cons)") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
        $acum_nac=$dato[0];
        echo "<td align='center' title='NACIONAL / Total de clases'><b>".number_format($acum_nac)."</b></td>";
		
		
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        $result = pg_query("Select sum(p_ocupado) from cat_saic_2014 where ent='$cve_edos_array[$i_edos]' and mpio='$cve_edos_array[$i_edos]' and clase in ($clases_cons)") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
        $acum_edo[$i_edos]=$dato[0];
		echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]."  / Total de clases'><b>".number_format($dato[0])."</b></td>";
		}
        
    echo "</tr>";   
    
    echo "<tr>";
        echo "<td colspan='2' align='center'><b>%Empleo en Clases respecto al Total</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center' title='NACIONAL / Empleo en clases respecto al total'>".round(($acum_nac / $p_ocup_nac)* 100,2)."</td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / Empleo en clases respecto al total'>".round(( $acum_edo[$i_edos] / $p_ocup[$i_edos])* 100,2)."</td>";
		//echo "<td align='center'>".$acum_edo[$i_edos]."</td>";
		}
    echo "</tr>";
    
    echo "<tr>";
        echo "<td colspan='2' align='center'><b>%Empleo en estado respecto al Nacional</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center'>-</td>";
			for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {

         echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]."  / Empleo en estado respecto al nacional'>".round(($acum_edo[$i_edos] / $acum_nac)* 100,2)."</td>";
		//echo "<td align='center'>".$p_ocup_nac."</td>";
		}
    echo "</tr>";   
    
     echo "<tr>";
        echo "<td colspan='2' align='center'><b>Cociente de localización</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center'>-</td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]."  / Cociente de localización'>".round(($acum_edo[$i_edos]/$p_ocup[$i_edos])/($acum_nac/$p_ocup_nac),2)."</td>";
		}
    echo "</tr>";
    echo "</table>";
    

?>    
  </div>
  <div id="tabs-3" class='contenido'>  
      <?php    
    echo "<br>";
    echo "<table style='width:700px' border=1 bordercolor='#1997FF' CLASS='boldtable'>";
    echo "<tr>";
        echo "<td align='center' colspan='2' width='20%'><b>VARIABLE</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center' width='2%'><b>NACIONAL</b></td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center' width='2%'><b>".$fedos_array[$cve_edos_array[$i_edos]]."</b></td>";
		}
    echo "</tr>";    
    echo "<tr bgcolor='#59AAFF'>";
        echo "<td colspan='2' align='center'><b>Remuneraciones</b></td>";
        echo "<td align='center' title='NACIONAL / Remuneraciones'><b>".number_format($remun_nac)."</b></td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / Remuneraciones'><b>".number_format($remun[$i_edos])."</b></td>";
		}
    echo "</tr>";      
    
     echo "<tr>";
        echo "<td colspan='2' align='center'><b>Clases</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center'>&nbsp;</td>";
 		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center'>&nbsp;</td>";
		}
    echo "</tr>";
    
    
    //echo $clases;
    $clases_array = explode(",", $clases);       
    $paso=true;
    foreach ($clases_array as $valor){
        if ($paso==true){
            echo "<tr bgcolor='#59AAFF'>";
            $paso=false;    
        }else{
            echo "<tr>";
            $paso=true;        
        }
        $resulinfo = pg_query("Select descrip from cat_saic_2014 where clase = '$valor'") or die('Query failed: ' . pg_last_error());
        $info = pg_fetch_array($resulinfo);
		//echo "Select p_ocupado,descrip from cat_saic_2014 where entidad='00' and clase = '$valor' and p_ocupado > 0 and descrip<>'Total' group by p_ocupado,descrip";
		$result = pg_query("Select remun,descrip from cat_saic_2014 where ent='00' and mpio='00' and clase = '$valor'") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
		$title=$info[0];
        echo "<td align='center'>".$info[0]."</b></td>";
        echo "<td align='center'>$valor</td>";        
        if ($dato[0]<>'*'){
        echo "<td align='center' title='NACIONAL / $title'>".number_format($dato[0])."</b></td>";
	}else{
        echo "<td align='center' title='NACIONAL / $title'>".$dato[0]."</td>";
        }  
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        $result = pg_query("Select remun from cat_saic_2014 where ent='$cve_edos_array[$i_edos]' and mpio='$cve_edos_array[$i_edos]' and clase = '$valor' ") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
        if ($dato[0]<>'*'){
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / $title'>".number_format($dato[0])."</b></td>";
	}else{
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / $title'>".$dato[0]."</td>";
        }  
		}
    echo "</tr>";   
    }
    
    echo "<tr bgcolor='#59AAFF'>";
        echo "<td colspan='2' align='center'><b>TOTAL DE CLASES</b></td>";
        //echo "<td align='center'>$valor</td>";
        $result = pg_query("Select sum(remun) from cat_saic_2014 where ent='00' and mpio='00' and clase in ($clases_cons)") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
        $acum_nac=$dato[0];
        echo "<td align='center' title='NACIONAL / Total de clases'><b>".number_format($acum_nac)."</b></td>";
        
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        $result = pg_query("Select sum(remun) from cat_saic_2014 where ent='$cve_edos_array[$i_edos]' and mpio='$cve_edos_array[$i_edos]' and clase in ($clases_cons)") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
        $acum_edo[$i_edos]=$dato[0];
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / Total de clases'><b>".number_format($acum_edo[$i_edos])."</b></td>";
		}
    echo "</tr>";   
    
    echo "<tr>";
        echo "<td colspan='2' align='center'><b>%Remuneración en Clases respecto al Total</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center' title='NACIONAL / Remuneración en clases respecto al total'>".round(($acum_nac / $remun_nac)* 100,2)."</td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        //echo "<td align='center'>".round(($acum_edo[$i_edos] / $remun[$i_edos])* 100,2)."</td>";
		echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / Remuneración en clases respecto al total'>".round(($acum_edo[$i_edos] / $remun[$i_edos])* 100,2)."</td>";
		//echo "<td align='center'>".$remun[$i_edos]."</td>";
		}
    echo "</tr>";
    
    echo "<tr>";
        echo "<td colspan='2' align='center'><b>%Remuneración en estado respecto al Nacional</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center'>-</td>";
        //echo "<td align='center'>".round(($acum_coa / $acum_nac)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_nl / $acum_nac)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_tam / $acum_nac)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_slp / $acum_nac)* 100,2)."</td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
		echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / Remuneración en estado respecto al nacional'>".round(($acum_edo[$i_edos] / $acum_nac)* 100,2)."</td>";
		//echo "<td align='center'>".$remun_nac."</td>";
		}
    echo "</tr>";   
    
    
    echo "</table>";
?>    
  </div>
  <div id="tabs-4" class='contenido'>
        <?php    
    echo "<br>";
    echo "<table style='width:700px' border=1 bordercolor='#1997FF' CLASS='boldtable'>";
    echo "<tr>";
        echo "<td colspan='2' align='center' width='20%'><b>VARIABLE</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center' width='2%'><b>NACIONAL</b></td>";
        //echo "<td align='center'><b>COAH</b></td>";
       // echo "<td align='center'><b>NL</b></td>";
        //echo "<td align='center'><b>TAMP</b></td>";
        //echo "<td align='center'><b>SLP</b></td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center' width='2%'><b>".$fedos_array[$cve_edos_array[$i_edos]]."</b></td>";
		}
    echo "</tr>";    
    echo "<tr bgcolor='#59AAFF'>";
        echo "<td colspan='2' align='center'><b>Gastos por Consumo de Bienes y Servicios</b></td>";
        echo "<td align='center' title='NACIONAL / Gastos por consumo de bienes y servicios'><b>".number_format($gastos_nac)."</b></td>";
        //echo "<td align='center'><b>".number_format($gastos_coa)."</b></td>";
        //echo "<td align='center'><b>".number_format($gastos_nl)."</b></td>";
        //echo "<td align='center'><b>".number_format($gastos_tam)."</b></td>";
       // echo "<td align='center'><b>".number_format($gastos_slp)."</b></td>";
	   for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
	   echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / Gastos por consumo de bienes y servicios'><b>".number_format($gastos[$i_edos])."</b></td>";
	   }
    echo "</tr>";      
    
     echo "<tr>";
        echo "<td colspan='2' align='center'><b>Clases</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center'>&nbsp;</td>";
        //echo "<td align='center'>&nbsp;</td>";
        //echo "<td align='center'>&nbsp;</td>";
        //echo "<td align='center'>&nbsp;</td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center'>&nbsp;</td>";
		}
    echo "</tr>";
    
    
    //echo $clases;
    $clases_array = explode(",", $clases);       
    $paso=true;
    foreach ($clases_array as $valor){
        if ($paso==true){
            echo "<tr bgcolor='#59AAFF'>";
            $paso=false;    
        }else{
            echo "<tr>";
            $paso=true;        
        }
        $resulinfo = pg_query("Select descrip from cat_saic_2014 where clase = '$valor'") or die('Query failed: ' . pg_last_error());
        $info = pg_fetch_array($resulinfo);
		//echo "Select sum(p_ocupado),descrip from cat_saic_2014 where entidad='00' and clase = '$valor' and p_ocupado > 0 group by p_ocupado,descrip";
		$result = pg_query("Select t_gastos,descrip from cat_saic_2014 where ent='00' and mpio='00' and clase = '$valor'") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
		$title=$info[0];
        echo "<td align='center'>".$info[0]."</b></td>";
        echo "<td align='center'>$valor</td>";        
        if ($dato[0]<>'*'){
        echo "<td align='center' title='NACIONAL / $title'>".number_format($dato[0])."</b></td>";
	}else{
        echo "<td align='center' title='NACIONAL / $title'>".$dato[0]."</td>";
        }  
		
        for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {  
        $result = pg_query("Select t_gastos from cat_saic_2014 where ent='$cve_edos_array[$i_edos]' and mpio='$cve_edos_array[$i_edos]' and clase = '$valor'") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
        if ($dato[0]<>'*'){
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / $title'>".number_format($dato[0])."</b></td>";
	}else{
        echo "<td align='center'  title='".$fedos_array[$cve_edos_array[$i_edos]]." / $title'>".$dato[0]."</td>";
        } 
}		
    echo "</tr>";   
    }
    
    echo "<tr bgcolor='#59AAFF'>";
        echo "<td colspan='2' align='center'><b>TOTAL DE CLASES</b></td>";
        //echo "<td align='center'>$valor</td>";
        $result = pg_query("Select sum(t_gastos) from cat_saic_2014 where ent='00' and mpio='00' and clase in ($clases_cons)") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
        $acum_nac=$dato[0];
        echo "<td align='center' title='NACIONAL / Total de clases'><b>".number_format($acum_nac)."</b></td>";
		
        for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        $result = pg_query("Select sum(t_gastos) from cat_saic_2014 where ent='$cve_edos_array[$i_edos]' and mpio='$cve_edos_array[$i_edos]' and clase in ($clases_cons)") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
        $acum_edo[$i_edos]=$dato[0];
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / Total de clases'><b>".number_format($acum_edo[$i_edos])."</b></td>";
		}
    echo "</tr>";   
    
    echo "<tr>";
        echo "<td colspan='2' align='center'><b>%Gastos en Clases respecto al Total</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center' title='NACIONAL / Gastos en clases respecto al total'>".round(($acum_nac / $gastos_nac)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_coa / $gastos_coa)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_nl / $gastos_nl)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_tam / $gastos_tam)* 100,2)."</td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / Gastos en clases respecto al total'>".round(($acum_edo[$i_edos] / $gastos[$i_edos])* 100,2)."</td>";
		}
    echo "</tr>";
    
    echo "<tr>";
        echo "<td colspan='2' align='center'><b>%Gastos en estado respecto al Nacional</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center'>-</td>";
        //echo "<td align='center'>".round(($acum_coa / $acum_nac)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_nl / $acum_nac)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_tam / $acum_nac)* 100,2)."</td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / Gastos en estado respecto al nacional'>".round(($acum_edo[$i_edos] / $acum_nac)* 100,2)."</td>";
		}
    echo "</tr>";   
    
    
    echo "</table>";
?>  
  </div>
  <div id="tabs-5" class='contenido'> 
  <?php    
    echo "<br>";
    echo "<table style='width:700px' border=1 bordercolor='#1997FF' CLASS='boldtable'>";
    echo "<tr>";
        echo "<td colspan='2' align='center' width='20%'><b>VARIABLE</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center' width='2%'><b>NACIONAL</b></td>";
        //echo "<td align='center'><b>COAH</b></td>";
        //echo "<td align='center'><b>NL</b></td>";
        //echo "<td align='center'><b>TAMP</b></td>";
        //echo "<td align='center'><b>SLP</b></td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center' width='2%'><b>".$fedos_array[$cve_edos_array[$i_edos]]."</b></td>";
		}
    echo "</tr>";    
    echo "<tr bgcolor='#59AAFF'>";
        echo "<td colspan='2' align='center'><b>Ingresos por suministro de bienes y servicios </b></td>";
        echo "<td align='center' title='NACIONAL / Ingresos por suministro de bienes y servicios'><b>".number_format($ingresos_nac)."</b></td>";
        //echo "<td align='center'><b>".number_format($ingresos_coa)."</b></td>";
        //echo "<td align='center'><b>".number_format($ingresos_nl)."</b></td>";
        //echo "<td align='center'><b>".number_format($ingresos_tam)."</b></td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / Ingresos por suministro de bienes y servicios'><b>".number_format($ingresos[$i_edos])."</b></td>";
		}
    echo "</tr>";      
    
     echo "<tr>";
        echo "<td colspan='2' align='center'><b>Clases</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center'>&nbsp;</td>";
        //echo "<td align='center'>&nbsp;</td>";
        //echo "<td align='center'>&nbsp;</td>";
        //echo "<td align='center'>&nbsp;</td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center'>&nbsp;</td>";
		}
    echo "</tr>";
    
    
    //echo $clases;
    $clases_array = explode(",", $clases);       
    $paso=true;
    foreach ($clases_array as $valor){
        if ($paso==true){
            echo "<tr bgcolor='#59AAFF'>";
            $paso=false;    
        }else{
            echo "<tr>";
            $paso=true;        
        }
        $resulinfo = pg_query("Select descrip from cat_saic_2014 where clase = '$valor'") or die('Query failed: ' . pg_last_error());
        $info = pg_fetch_array($resulinfo);
		//echo "Select sum(p_ocupado),descrip from cat_saic_2014 where entidad='00' and clase = '$valor' and p_ocupado > 0 and descrip<>'Total' group by p_ocupado,descrip";
		$result = pg_query("Select t_ingresos,descrip from cat_saic_2014 where ent='00' and mpio='00' and clase = '$valor' ") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
		$title=$info[0];
        echo "<td align='center' >".$info[0]."</b></td>";
        echo "<td align='center'>$valor</td>";        
        if ($dato[0]<>'*'){
        echo "<td align='center' title='NACIONAL / $title'>".number_format($dato[0])."</b></td>";
	}else{
        echo "<td align='center' title='NACIONAL / $title'>".$dato[0]."</td>";
        }  
		
		
        for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        $result = pg_query("Select t_ingresos from cat_saic_2014 where ent='$cve_edos_array[$i_edos]' and mpio='$cve_edos_array[$i_edos]' and clase = '$valor'") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
        if ($dato[0]<>'*'){
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / $title'>".number_format($dato[0])."</b></td>";
	}else{
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / $title'>".$dato[0]."</td>";
        }  
		}
    echo "</tr>";   
    }
    
    echo "<tr bgcolor='#59AAFF'>";
        echo "<td colspan='2' align='center'><b>TOTAL DE CLASES</b></td>";
        //echo "<td align='center'>$valor</td>";
        $result = pg_query("Select sum(t_ingresos) from cat_saic_2014 where ent='00' and mpio='00'  and clase in ($clases_cons)") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
        $acum_nac=$dato[0];
        echo "<td align='center' title='NACIONAL / Total de clases'><b>".number_format($acum_nac)."</b></td>";
        
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        $result = pg_query("Select sum(t_ingresos) from cat_saic_2014 where ent='$cve_edos_array[$i_edos]' and mpio='$cve_edos_array[$i_edos]'  and clase in ($clases_cons)") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
        $acum_edo[$i_edos]=$dato[0];
        echo "<td align='center' title ='".$fedos_array[$cve_edos_array[$i_edos]]." / Total de clases'><b>".number_format($acum_edo[$i_edos])."</b></td>";
		}
    echo "</tr>";   
    
    echo "<tr>";
        echo "<td colspan='2' align='center'><b>%Ingresos en Clases respecto al Total</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center' title='NACIONAL / Ingresos en clases respecto al total'>".round(($acum_nac / $ingresos_nac)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_coa / $ingresos_coa)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_nl / $ingresos_nl)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_tam / $ingresos_tam)* 100,2)."</td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / Ingresos en clases respecto al total'>".round(($acum_edo[$i_edos] / $ingresos[$i_edos])* 100,2)."</td>";
		}
    echo "</tr>";
    
    echo "<tr>";
        echo "<td colspan='2' align='center'><b>%Ingresos en estado respecto al Nacional</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center'>-</td>";
        //echo "<td align='center'>".round(($acum_coa / $acum_nac)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_nl / $acum_nac)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_tam / $acum_nac)* 100,2)."</td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / Ingresos en estado respecto al nacional'>".round(($acum_edo[$i_edos] / $acum_nac)* 100,2)."</td>";
		}
    echo "</tr>";   
    
    
    echo "</table>";
?>      
  </div>
  <div id="tabs-6" class='contenido'>    
    <?php    
    echo "<br>";
    echo "<table style='width:700px' border=1 bordercolor='#1997FF' CLASS='boldtable'>";
    echo "<tr>";
        echo "<td colspan='2' align='center' width='20%'><b>VARIABLE</b></td>";
       // echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center' width='2%'><b>NACIONAL</b></td>";
        //echo "<td align='center'><b>COAH</b></td>";
        //echo "<td align='center'><b>NL</b></td>";
        //echo "<td align='center'><b>TAMP</b></td>";
        //echo "<td align='center'><b>SLP</b></td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center' width='2%'><b>".$fedos_array[$cve_edos_array[$i_edos]]."</b></td>";
		}
    echo "</tr>";    
    echo "<tr bgcolor='#59AAFF'>";
        echo "<td colspan='2' align='center'><b>Producción Bruta Total </b></td>";
        echo "<td align='center' title='NACIONAL / Producción bruta total'><b>".number_format($produccion_nac)."</b></td>";
        //echo "<td align='center'><b>".number_format($produccion_coa)."</b></td>";
        //echo "<td align='center'><b>".number_format($produccion_nl)."</b></td>";
        //echo "<td align='center'><b>".number_format($produccion_tam)."</b></td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / Producción bruta total'><b>".number_format($produccion[$i_edos])."</b></td>";
		}
    echo "</tr>";      
    
     echo "<tr>";
        echo "<td colspan='2' align='center'><b>Clases</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center'>&nbsp;</td>";
        //echo "<td align='center'>&nbsp;</td>";
        //echo "<td align='center'>&nbsp;</td>";
        //echo "<td align='center'>&nbsp;</td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center'>&nbsp;</td>";
		}
    echo "</tr>";
    
    
    //echo $clases;
    $clases_array = explode(",", $clases);       
    $paso=true;
    foreach ($clases_array as $valor){
        if ($paso==true){
            echo "<tr bgcolor='#59AAFF'>";
            $paso=false;    
        }else{
            echo "<tr>";
            $paso=true;        
        }
        $resulinfo = pg_query("Select descrip from cat_saic_2014 where clase = '$valor'") or die('Query failed: ' . pg_last_error());
        $info = pg_fetch_array($resulinfo);
		//echo "Select sum(p_ocupado),descrip from cat_saic_2014 where entidad='00' and clase = '$valor' and p_ocupado > 0 group by p_ocupado,descrip";
		$result = pg_query("Select p_bruta,descrip from cat_saic_2014 where ent='00' and mpio='00' and clase = '$valor' ") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
		$title=$info[0];
        echo "<td align='center'>".$info[0]."</b></td>";
        echo "<td align='center'>$valor</td>";        
        if ($dato[0]<>'*'){
        echo "<td align='center' title='NACIONAL / $title'>".number_format($dato[0])."</b></td>";
	}else{
        echo "<td align='center' title='NACIONAL / $title'>".$dato[0]."</td>";
        }  
		
        for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        $result = pg_query("Select p_bruta from cat_saic_2014 where ent='$cve_edos_array[$i_edos]' and mpio='$cve_edos_array[$i_edos]'  and clase = '$valor'") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
        if ($dato[0]<>'*'){
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / $title'>".number_format($dato[0])."</b></td>";
	}else{
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / $title'>".$dato[0]."</td>";
        }  
		}
    echo "</tr>";   
    }
    
    echo "<tr bgcolor='#59AAFF'>";
        echo "<td colspan='2' align='center'><b>TOTAL DE CLASES</b></td>";
        //echo "<td align='center'>$valor</td>";
        $result = pg_query("Select sum(p_bruta) from cat_saic_2014 where ent='00' and mpio='00' and clase in ($clases_cons)") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
        $acum_nac=$dato[0];
        echo "<td align='center' title='NACIONAL / Total de clases'><b>".number_format($acum_nac)."</b></td>";
        $result = pg_query("Select sum(p_bruta) from cat_saic_2014 where ent='05' and mpio='05'  and clase in ($clases_cons)") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
        $acum_coa=$dato[0];
        
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        $result = pg_query("Select sum(p_bruta) from cat_saic_2014 where ent='$cve_edos_array[$i_edos]' and mpio='$cve_edos_array[$i_edos]' and clase in ($clases_cons)") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
        $acum_edo[$i_edos]=$dato[0];
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / Total de clases'><b>".number_format($acum_edo[$i_edos])."</b></td>";
		}
    echo "</tr>";   
    
    echo "<tr>";
        echo "<td colspan='2' align='center'><b>%Ingresos en Clases respecto al Total</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center' title='NACIONAL / Ingresos en clases respecto al total'>".round(($acum_nac / $produccion_nac)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_coa / $produccion_coa)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_nl / $produccion_nl)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_tam / $produccion_tam)* 100,2)."</td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / Ingresos en clases respecto al total'>".round(($acum_edo[$i_edos] / $produccion[$i_edos])* 100,2)."</td>";
		}
    echo "</tr>";
    
    echo "<tr>";
        echo "<td colspan='2' align='center'><b>%Ingresos en estado respecto al Nacional</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center'>-</td>";
        //echo "<td align='center'>".round(($acum_coa / $acum_nac)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_nl / $acum_nac)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_tam / $acum_nac)* 100,2)."</td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / Ingresos en estado respecto al nacional'>".round(($acum_edo[$i_edos] / $acum_nac)* 100,2)."</td>";
		}
    echo "</tr>";   
    
    
    echo "</table>";
?>     
  </div>
  <div id="tabs-8" class='contenido'>    
        <?php    
    echo "<br>";
    echo "<table style='width:700px' border=1 bordercolor='#1997FF' CLASS='boldtable'>";
    echo "<tr>";
        echo "<td align='center' colspan='2' width='20%'><b>VARIABLE</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center' width='2%'><b>NACIONAL</b></td>";
        //echo "<td align='center'><b>COAH</b></td>";
        //echo "<td align='center'><b>NL</b></td>";
        //echo "<td align='center'><b>TAMP</b></td>";
        //echo "<td align='center'><b>SLP</b></td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center' width='2%'><b>".$fedos_array[$cve_edos_array[$i_edos]]."</b></td>";
		}
    echo "</tr>";    
    echo "<tr bgcolor='#59AAFF'>";
        echo "<td colspan='2' align='center'><b>Valor Agregado Censal Bruto </b></td>";
        echo "<td align='center' title='NACIONAL / Valor agregado censal bruto'><b>".number_format($valor_nac)."</b></td>";
       // echo "<td align='center'><b>".number_format($valor_coa)."</b></td>";
        //echo "<td align='center'><b>".number_format($valor_nl)."</b></td>";
        //echo "<td align='center'><b>".number_format($valor_tam)."</b></td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / Valor agregado censal bruto'><b>".number_format($valor_a[$i_edos])."</b></td>";
		}
    echo "</tr>";      
    
     echo "<tr>";
        echo "<td colspan='2' align='center'><b>Clases</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center'>&nbsp;</td>";
        //echo "<td align='center'>&nbsp;</td>";
        //echo "<td align='center'>&nbsp;</td>";
        //echo "<td align='center'>&nbsp;</td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center'>&nbsp;</td>";
		}
    echo "</tr>";
    
    
    //echo $clases;
    $clases_array = explode(",", $clases);       
    $paso=true;
    foreach ($clases_array as $valor){
        if ($paso==true){
            echo "<tr bgcolor='#59AAFF'>";
            $paso=false;    
        }else{
            echo "<tr>";
            $paso=true;        
        }
        $resulinfo = pg_query("Select descrip from cat_saic_2014 where clase = '$valor'") or die('Query failed: ' . pg_last_error());
        $info = pg_fetch_array($resulinfo);
		//echo "Select sum(p_ocupado),descrip from cat_saic_2014 where entidad='00' and clase = '$valor' and p_ocupado > 0 and descrip<>'Total' group by p_ocupado,descrip";
		$result = pg_query("Select v_agregado,descrip from cat_saic_2014 where ent='00' and mpio='00' and clase = '$valor'") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
		$title=$info[0];
        echo "<td align='center' >".$info[0]."</b></td>";
        echo "<td align='center'>$valor</td>";        
       if ($dato[0]<>'*'){
        echo "<td align='center' title='NACIONAL / $title'>".number_format($dato[0])."</b></td>";
	}else{
        echo "<td align='center' title='NACIONAL / $title'>".$dato[0]."</td>";
        }  
		
        for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {  
        $result = pg_query("Select v_agregado from cat_saic_2014 where ent='$cve_edos_array[$i_edos]' and mpio='$cve_edos_array[$i_edos]' and clase = '$valor'") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
       if ($dato[0]<>'*'){
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / $title'>".number_format($dato[0])."</b></td>";
	}else{
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / $title'>".$dato[0]."</td>";
        } 
        }		
    echo "</tr>";   
    }
    
    echo "<tr bgcolor='#59AAFF'>";
        echo "<td colspan='2' align='center'><b>TOTAL DE CLASES</b></td>";
        //echo "<td align='center'>$valor</td>";
        $result = pg_query("Select sum(v_agregado) from cat_saic_2014 where ent='00' and mpio='00' and clase in ($clases_cons)") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
        $acum_nac=$dato[0];
        echo "<td align='center' title='NACIONAL / Total de clases'><b>".number_format($acum_nac)."</b></td>";
        
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        $result = pg_query("Select sum(v_agregado) from cat_saic_2014 where ent='$cve_edos_array[$i_edos]' and mpio='$cve_edos_array[$i_edos]' and clase in ($clases_cons)") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
        $acum_edo[$i_edos]=$dato[0];
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / Total de clases'><b>".number_format($acum_edo[$i_edos])."</b></td>";
		}
    echo "</tr>";   
    
    echo "<tr>";
        echo "<td colspan='2' align='center'><b>%Valor agregado censal bruto en Clases respecto al Total</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center' title='NACIONAL / Valor agregado censal bruto en clases respecto al total'>".round(($acum_nac / $valor_nac)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_coa / $valor_coa)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_nl / $valor_nl)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_tam / $valor_tam)* 100,2)."</td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / Valor agregado censal bruto en clases respecto al total'>".round(($acum_edo[$i_edos] / $valor_a[$i_edos])* 100,2)."</td>";
		}
    echo "</tr>";
    
    echo "<tr>";
        echo "<td colspan='2' align='center'><b>%Valor agregado censal bruto en estado respecto al Nacional</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center'>-</td>";
        //echo "<td align='center'>".round(($acum_coa / $acum_nac)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_nl / $acum_nac)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_tam / $acum_nac)* 100,2)."</td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / Valor agregado censal bruto en estado respecto al nacional'>".round(($acum_edo[$i_edos] / $acum_nac)* 100,2)."</td>";
		}
    echo "</tr>";   
    
    
    echo "</table>";
?>  
  </div>
  <div id="tabs-7" class='contenido'>    
          <?php    
    echo "<br>";
    echo "<table style='width:700px' border=1 bordercolor='#1997FF' CLASS='boldtable'>";
    echo "<tr>";
        echo "<td align='center' colspan='2' width='20%'><b>VARIABLE</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center' width='2%'><b>NACIONAL</b></td>";
        //echo "<td align='center'><b>COAH</b></td>";
        //echo "<td align='center'><b>NL</b></td>";
        //echo "<td align='center'><b>TAMP</b></td>";
       // echo "<td align='center'><b>SLP</b></td>";
	   for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center' width='2%'><b>".$fedos_array[$cve_edos_array[$i_edos]]."</b></td>";
		}
    echo "</tr>";    
    echo "<tr bgcolor='#59AAFF'>";
        echo "<td colspan='2' align='center'><b>Consumo intermedio</b></td>";
        echo "<td align='center' title='NACIONAL / Consumo intermedio'><b>".number_format($consumo_nac)."</b></td>";
        //echo "<td align='center'><b>".number_format($consumo_coa)."</b></td>";
        //echo "<td align='center'><b>".number_format($consumo_nl)."</b></td>";
        //echo "<td align='center'><b>".number_format($consumo_tam)."</b></td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / Consumo intermedio'><b>".number_format($consumo[$i_edos])."</b></td>";
		}
    echo "</tr>";      
    
     echo "<tr>";
        echo "<td colspan='2' align='center'><b>Clases</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center'>&nbsp;</td>";
        //echo "<td align='center'>&nbsp;</td>";
        //echo "<td align='center'>&nbsp;</td>";
        //echo "<td align='center'>&nbsp;</td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center'>&nbsp;</td>";
		}
    echo "</tr>";
    
    
    //echo $clases;
    $clases_array = explode(",", $clases);       
    $paso=true;
    foreach ($clases_array as $valor){
        if ($paso==true){
            echo "<tr bgcolor='#59AAFF'>";
            $paso=false;    
        }else{
            echo "<tr>";
            $paso=true;        
        }
        $resulinfo = pg_query("Select descrip from cat_saic_2014 where clase = '$valor'") or die('Query failed: ' . pg_last_error());
        $info = pg_fetch_array($resulinfo);
		//echo "Select sum(p_ocupado),descrip from cat_saic_2014 where entidad='00' and descrip<>'Total' clase = '$valor' and p_ocupado > 0 group by p_ocupado,descrip";
		$result = pg_query("Select consumo,descrip from cat_saic_2014 where ent='00' and mpio='00'  and clase = '$valor'") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
		$title=$info[0];
        echo "<td align='center'>".$info[0]."</b></td>";
        echo "<td align='center'>$valor</td>";        
       if ($dato[0]<>'*'){
        echo "<td align='center' title='NACIONAL / $title'>".number_format($dato[0])."</b></td>";
	}else{
        echo "<td align='center' title='NACIONAL / $title'>".$dato[0]."</td>";
        }  
		
        for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        $result = pg_query("Select consumo from cat_saic_2014 where ent='$cve_edos_array[$i_edos]' and mpio='$cve_edos_array[$i_edos]' and clase = '$valor'") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
        if ($dato[0]<>'*'){
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / $title'>".number_format($dato[0])."</b></td>";
	}else{
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / $title'>".$dato[0]."</td>";
        }  
		}
    echo "</tr>";   
    }
    
    echo "<tr bgcolor='#59AAFF'>";
        echo "<td colspan='2' align='center'><b>TOTAL DE CLASES</b></td>";
        //echo "<td align='center'>$valor</td>";
        $result = pg_query("Select sum(consumo) from cat_saic_2014 where ent='00' and mpio='00' and clase in ($clases_cons)") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
        $acum_nac=$dato[0];
        echo "<td align='center' title='NACIONAL / Total de clases'><b>".number_format($acum_nac)."</b></td>";
        
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        $result = pg_query("Select sum(consumo) from cat_saic_2014 where ent='$cve_edos_array[$i_edos]' and mpio='$cve_edos_array[$i_edos]' and clase in ($clases_cons)") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
        $acum_edo[$i_edos]=$dato[0];
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / Total de clases'><b>".number_format($acum_edo[$i_edos])."</b></td>";
		}
    echo "</tr>";   
    
    echo "<tr>";
        echo "<td colspan='2' align='center'><b>%Consumos en Clases respecto al Total</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center' title='NACIONAL / Consumos en clases respecto al total'>".round(($acum_nac / $consumo_nac)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_coa / $consumo_coa)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_nl / $consumo_nl)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_tam / $consumo_tam)* 100,2)."</td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / Consumos en clases respecto al total'>".round(($acum_edo[$i_edos] / $consumo[$i_edos])* 100,2)."</td>";
		}
    echo "</tr>";
    
    echo "<tr>";
        echo "<td colspan='2' align='center'><b>%Consumos en estado respecto al Nacional</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center'>-</td>";
        //echo "<td align='center'>".round(($acum_coa / $acum_nac)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_nl / $acum_nac)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_tam / $acum_nac)* 100,2)."</td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / Consumos en estado respecto al nacional'>".round(($acum_edo[$i_edos] / $acum_nac)* 100,2)."</td>";
		}
    echo "</tr>";   
    
    
    echo "</table>";
?>  
  </div>
  <div id="tabs-9" class='contenido'>   
       <?php    
    echo "<br>";
    echo "<table style='width:700px' border=1 bordercolor='#1997FF' CLASS='boldtable'>";
    echo "<tr>";
        echo "<td align='center' colspan='2' width='20%'><b>VARIABLE</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center' width='2%'><b>NACIONAL</b></td>";
        //echo "<td align='center'><b>COAH</b></td>";
        //echo "<td align='center'><b>NL</b></td>";
        //echo "<td align='center'><b>TAMP</b></td>";
        //echo "<td align='center'><b>SLP</b></td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center' width='2%'><b>".$fedos_array[$cve_edos_array[$i_edos]]."</b></td>";
		}
    echo "</tr>";    
    echo "<tr bgcolor='#59AAFF'>";
        echo "<td colspan='2' align='center'><b>Inversión Total </b></td>";
        echo "<td align='center' title='NACIONAL / Inversión total'><b>".number_format($inversion_nac)."</b></td>";
        //echo "<td align='center'><b>".number_format($inversion_coa)."</b></td>";
        //echo "<td align='center'><b>".number_format($inversion_nl)."</b></td>";
        //echo "<td align='center'><b>".number_format($inversion_tam)."</b></td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / Inversión total'><b>".number_format($inversion[$i_edos])."</b></td>";
		}
    echo "</tr>";      
    
     echo "<tr>";
        echo "<td colspan='2' align='center'><b>Clases</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center'>&nbsp;</td>";
        //echo "<td align='center'>&nbsp;</td>";
        //echo "<td align='center'>&nbsp;</td>";
        //echo "<td align='center'>&nbsp;</td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center'>&nbsp;</td>";
		}
    echo "</tr>";
    
    
    //echo $clases;
    $clases_array = explode(",", $clases);       
    $paso=true;
    foreach ($clases_array as $valor){
        if ($paso==true){
            echo "<tr bgcolor='#59AAFF'>";
            $paso=false;    
        }else{
            echo "<tr>";
            $paso=true;        
        }
        $resulinfo = pg_query("Select descrip from cat_saic_2014 where clase = '$valor'") or die('Query failed: ' . pg_last_error());
        $info = pg_fetch_array($resulinfo);
		//echo "Select sum(p_ocupado),descrip from cat_saic_2014 where entidad='00' and clase = '$valor' and p_ocupado > 0 and descrip<>'Total' group by p_ocupado,descrip";
		$result = pg_query("Select inv_total,descrip from cat_saic_2014 where ent='00' and mpio='00' and clase = '$valor'") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
		$title=$info[0];
        echo "<td align='center'>".$info[0]."</b></td>";
        echo "<td align='center'>$valor</td>";        
       if ($dato[0]<>'*'){
        echo "<td align='center' title='NACIONAL / $title'>".number_format($dato[0])."</b></td>";
	}else{
        echo "<td align='center' title='NACIONAL / $title'>".$dato[0]."</td>";
        }  
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
          
        $result = pg_query("Select inv_total from cat_saic_2014 where ent='$cve_edos_array[$i_edos]' and mpio='$cve_edos_array[$i_edos]' and clase = '$valor'") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
     if ($dato[0]<>'*'){
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / $title'>".number_format($dato[0])."</b></td>";
	}else{
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / $title'>".$dato[0]."</td>";
        }  
		}
    echo "</tr>";   
    }
    
    echo "<tr bgcolor='#59AAFF'>";
        echo "<td colspan='2' align='center'><b>TOTAL DE CLASES</b></td>";
        //echo "<td align='center'>$valor</td>";
        $result = pg_query("Select sum(inv_total) from cat_saic_2014 where ent='00' and mpio='00'  and clase in ($clases_cons)") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
        $acum_nac=$dato[0];
        echo "<td align='center' title='NACIONAL / Total de clases'><b>".number_format($acum_nac)."</b></td>";
        for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        $result = pg_query("Select sum(inv_total) from cat_saic_2014 where ent='$cve_edos_array[$i_edos]' and mpio='$cve_edos_array[$i_edos]' and clase in ($clases_cons)") or die('Query failed: ' . pg_last_error());
        $dato = pg_fetch_array($result);
        $acum_edo[$i_edos]=$dato[0];
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / Total de clases'><b>".number_format($acum_edo[$i_edos])."</b></td>";
		}
    echo "</tr>";   
    
    echo "<tr>";
        echo "<td colspan='2' align='center'><b>%Inversión total en Clases respecto al Total</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center' title='NACIONAL / Inversión total en clases respecto al total'>".round(($acum_nac / $inversion_nac)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_coa / $inversion_coa)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_nl / $inversion_nl)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_tam / $inversion_tam)* 100,2)."</td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center'  title='".$fedos_array[$cve_edos_array[$i_edos]]." / Inversión total en clases respecto al total'>".round(($acum_edo[$i_edos] / $inversion[$i_edos])* 100,2)."</td>";
		}
    echo "</tr>";
    
    echo "<tr>";
        echo "<td colspan='2' align='center'><b>%Inversión total en estado respecto al Nacional</b></td>";
        //echo "<td align='center'>&nbsp;</td>";
        echo "<td align='center'>-</td>";
        //echo "<td align='center'>".round(($acum_coa / $acum_nac)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_nl / $acum_nac)* 100,2)."</td>";
        //echo "<td align='center'>".round(($acum_tam / $acum_nac)* 100,2)."</td>";
		for ($i_edos = 0; $i_edos <= $vmaxiedos; $i_edos++) {
        echo "<td align='center' title='".$fedos_array[$cve_edos_array[$i_edos]]." / Inversión total en estado respecto al nacional'>".round(($acum_edo[$i_edos] / $acum_nac)* 100,2)."</td>";
		}
    echo "</tr>";   
    
    
    echo "</table>";
?>        
  </div>
</div>  

</center><br>
    <span class='fuente' title='Censos Económicos 2014. Resultados definitivos (Cifras monetarias expresadas en miles de pesos)Confidencialidad de los datos proporcionados con fines Estadísticos  La columna unidades económicas se encuentra inhibida en algunos renglones. Esto se debe a que la ley del sistema nacional de información estadística y geográfica, en vigor, en sus artículos 37, 38, 42 y 47 establece la confidencialidad de la información. El artículo 37 señala que: “los datos que proporcionen para fines estadísticos los informantes del sistema a las unidades en términos de la presente ley, serán estrictamente confidenciales y bajo ninguna circunstancia podrán utilizarse para otro fin que no sea el estadístico…”; mientras que el artículo 38 cita textualmente: "los datos e informes que los informantes del sistema proporcionen para fines estadísticos y que provengan de registros administrativos, serán manejados observando los principios de confidencialidad y reserva, por lo que no podrán divulgarse en ningún caso en forma nominativa o individualizada, ni harán prueba ante autoridad judicial o administrativa, incluyendo la fiscal, en juicio o fuera de él…”. El artículo 42 hace referencia a la posibilidad de denunciar la violación a los ya mencionados principios de confidencialidad y reserva; mientras que el artículo 47 dicta que: “la información no queda sujeta a la ley federal de transparencia y acceso a la información pública gubernamental…”.'>Fuente: INEGI.</span> 
    
    
<?php
}
 pg_free_result($resulinfo);
 pg_close($conn);
?>
</body>

</html>
