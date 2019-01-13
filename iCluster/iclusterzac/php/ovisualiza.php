<!doctype html>
<html lang="en">
<head>
  <style>
 
.lista {
    list-style: none;
    text-align: center;
    width: 300px;
    line-height: 23px;
	border: 1px solid black;
	border-radius: 5px; 
}
a.boxclose{
    float:right;
    margin-top:-10px;
    margin-right:-10px;
    cursor:pointer;
    color: #fff;
    border: 1px solid #AEAEAE;
    border-radius: 4px;
    background: #ea5050;
    font-size: 15px;
    font-weight: bold;
    display: inline-block;
    line-height: 0px;
    padding: 8px 3px;       
}
 
.boxclose:before {
    content: "×";
} 

  </style>
  <script>
 function eliminac(cluster){
 
	nombre="Puntos"+cluster;
		var arr = window.parent.smap.getLayersByName(nombre);
		if (arr.length){
			markers=arr[0];
			markers.destroyFeatures();
			window.parent.smap.removeLayer(markers);		
			
		}
	document.location='ovisualiza.php';	
 }
 function eliminacc(cluster){
 
	nombre="PuntosC"+cluster;

		var arr = window.parent.smap.getLayersByName(nombre);
		if (arr.length){
			markers=arr[0];
			markers.destroyFeatures();
			window.parent.smap.removeLayer(markers);
		}
	document.location='ovisualiza.php';	
 }
  </script>
</head>
<body>
<script>
var arr = window.parent.smap.getLayersByClass("OpenLayers.Layer.Vector");
	for (i = 0; i < arr.length; i++) { 
		var capa=arr[i];
		zeta=capa.getZIndex();
		//alert(capa.id);		
		nombre=capa.name;
		if (nombre.indexOf("Puntos")!=-1){
			document.write("<div class='overlay' id='overlay' style='display:none;'></div>");
			nomb=nombre;
			nombre=nombre.replace("PuntosC", "");
			nombre=nombre.replace("Puntos", "");
			//alert(nombre);
			//t.options[t.selectedIndex].text;
			rnombre=capa.id;//window.parent.document.getElementById('datos').contentWindow.document.getElementById('grupose').options[nombre-1].text;
			//alert(capa.id);
			if (nomb.indexOf("PuntosC")!=-1){
			document.write("<div id='box' class='lista' style='background:#C0C0C0 url(../img/clusters/"+nombre+".png) 1% 50% no-repeat;background-size: 25px 25px;' nombre='"+nombre+"' indice='"+zeta+"'><a class='boxclose' id='boxclose' onclick=eliminacc('"+nombre+"')></a>"+rnombre+"</div><br>");			
			}else{
			document.write("<div id='box' class='lista' style='background:#C0C0C0 url(../img/grupos/"+nombre+".png) 1% 50% no-repeat;background-size: 20px 25px;' nombre='"+nombre+"' indice='"+zeta+"'><a class='boxclose' id='boxclose' onclick=eliminac('"+nombre+"')></a>"+rnombre+"</div><br>");			
			}
		}	
	}
 
    
    
</script>
</body>
</html>
