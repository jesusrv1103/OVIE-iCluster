function abrirLeyenda() {	
	
	if (cont == '') { alert("No existen elementos consultados") } else {
		document.getElementById("leyenda").style.display="";
		document.getElementById('div_auxiliar').innerHTML =cont;	
	    //html = '<div id="legenda">' + cont + '</div>';
	    //MDM5.ui.window.New({ type: 'consult', title: 'Leyenda DENUE', width: anchov, height: alturav, center: true, resize: false, object: html });
	}
};
function abrir_sim(){
	document.getElementById("auxiliar").style.display="";
	document.getElementById("frame_auxiliar").src="vacio.php";
	document.getElementById("frame_auxiliar").src="simbologia.php";
	//window.open('simbologia.php','Simbolos','width=400,height=500,scrollbars=1')
}
function buscadenue(){
	document.getElementById("trabajo").style.display="";
	document.getElementById("frame_trabajo").src="vacio.php";
	document.getElementById("frame_trabajo").src="marcas_denue.php";	
}

function sel_camp(){
	document.getElementById("auxiliar").style.display="";
	document.getElementById("frame_auxiliar").src="vacio.php";
	document.getElementById("frame_auxiliar").src="sel_camp.php";
	document.getElementById("trabajo").style.display="none";
	document.getElementById("frame_trabajo").src="vacio.php";

	//window.open('sel_camp.php','Campos','width=300,height=500,scrollbars=0')
}
function selecciona(tool){ 
if (tool==1){
document.getElementById("noneToggle").click();
document.getElementById("op1").className="buttonactivo";
document.getElementById("op2").className="button";
document.getElementById("op3").className="button";
document.getElementById("op4").className="button";
document.getElementById("op5").className="button";
document.getElementById("rd").style.display="none";
document.getElementById("divxy").style.display="none";
document.getElementById("medir").style.display="none";
document.getElementById("op8").className="button";
}
if (tool==2){
document.getElementById("pointToggle").click();
document.getElementById("op1").className="button"
document.getElementById("op2").className="buttonactivo";
document.getElementById("op3").className="button";
document.getElementById("op4").className="button";
document.getElementById("op5").className="button";
document.getElementById("rd").style.display="";
document.getElementById("divxy").style.display="none";
document.getElementById("medir").style.display="none";
document.getElementById("op8").className="button";
}
if (tool==3){
document.getElementById("polygonToggle").click();
document.getElementById("op1").className="button";
document.getElementById("op2").className="button";
document.getElementById("op3").className="buttonactivo";
document.getElementById("op4").className="button";
document.getElementById("op5").className="button";
document.getElementById("rd").style.display="none";
document.getElementById("divxy").style.display="none";
document.getElementById("medir").style.display="none";
document.getElementById("op8").className="button";
}
if (tool==4){
document.getElementById("street").click();
document.getElementById("op1").className="button";
document.getElementById("op2").className="button";
document.getElementById("op3").className="button";
document.getElementById("op4").className="buttonactivo";
document.getElementById("op5").className="button";
document.getElementById("rd").style.display="none";
document.getElementById("divxy").style.display="none";
document.getElementById("medir").style.display="none";
document.getElementById("op8").className="button";
}
if (tool==5){   
document.getElementById("xy").click();
document.getElementById("op1").className="button";
document.getElementById("op2").className="button";
document.getElementById("op3").className="button";
document.getElementById("op4").className="button";
document.getElementById("rd").style.display="none";
document.getElementById("divxy").style.display="";
document.getElementById("medir").style.display="none";
document.getElementById("op5").className="buttonactivo";
document.getElementById("op8").className="button";
}
if (tool==6){   
document.getElementById("origen").click();
document.getElementById("op1").className="button";
document.getElementById("op2").className="button";
document.getElementById("op3").className="button";
document.getElementById("op4").className="button";
document.getElementById("rd").style.display="none";
document.getElementById("divxy").style.display="none";
document.getElementById("medir").style.display="none";
document.getElementById("op5").className="button";
document.getElementById("ori").value="";
document.getElementById('distancia').innerHTML = "<br><b>De click en ubicación de origen.</b>";
document.getElementById("op8").className="button";
}
if (tool==7){   
document.getElementById("destino").click();
document.getElementById("op1").className="button";
document.getElementById("op2").className="button";
document.getElementById("op3").className="button";
document.getElementById("op4").className="button";
document.getElementById("rd").style.display="none";
document.getElementById("divxy").style.display="none";
document.getElementById("medir").style.display="none";
document.getElementById("op5").className="button";
document.getElementById("des").value="";
document.getElementById("op8").className="button";
document.getElementById('distancia').innerHTML = "<br><b>De click en ubicación de destino.</b>";
}
if (tool==8){   
document.getElementById("lineToggle").click();
document.getElementById("op1").className="button";
document.getElementById("op2").className="button";
document.getElementById("op3").className="button";
document.getElementById("op4").className="button";
document.getElementById("rd").style.display="none";
document.getElementById("divxy").style.display="none";
document.getElementById("medir").style.display="";
document.getElementById("op5").className="button";
document.getElementById("des").value="";
document.getElementById("op8").className="buttonactivo";

}



document.getElementById('outputm').innerHTML='0000';
markers.setZIndex(750);    
}
function mdetalle(){    
    document.getElementById("con_instrucciones").style.display="";
    document.getElementById('con_instrucciones').style.visibility='visible';
    document.getElementById('con_instrucciones').style.zIndex='3000';
                }

function busca(){
sel=document.getElementById('capas').selectedIndex;
clave=document.forms[0].clave.value;
clave=clave.toUpperCase();
document.forms[0].clave.value=clave;


if (sel==0){
alert("Debe seleccionar la capa activa.");
}
if (sel==1){    
//window.open('busca_den.php?id_est='+clave,"Bus","width=800,height=400,scrollbars=1,status=1");
document.getElementById("frame_trabajo").src="vacio.php";
document.getElementById("frame_trabajo").src="busca_den.php?id_est="+clave;
}
if (sel!=1 && sel != 0){    
document.getElementById("frame_trabajo").src="vacio.php";
document.getElementById("frame_trabajo").src='busca.php?id_est='+clave+"&capa="+sel;
}
document.getElementById("trabajo").style.display="";
	
}

function lin(){
limpia_marcas();
limpia_marcas3();
limpia_marcasjump();
document.getElementById("lon").value="";
document.getElementById("lat").value="";
}

function zoomer(x,y){    
    map.setCenter(new OpenLayers.LonLat(x,y).transform(new OpenLayers.Projection('EPSG:4326'),map.getProjectionObject()), 18);
    jumpTo(new OpenLayers.LonLat(x, y).transform(new OpenLayers.Projection('EPSG:4326'),map.getProjectionObject()));
}
function zoomer2(x,y){    
    map.setCenter(new OpenLayers.LonLat(x,y).transform(new OpenLayers.Projection('EPSG:4326'),map.getProjectionObject()), 18);
    //jumpTo(new OpenLayers.LonLat(x, y).transform(new OpenLayers.Projection('EPSG:4326'),map.getProjectionObject()));
}
function zoomerd(x,y){    
    map.setCenter(new OpenLayers.LonLat(x,y), 18); 
}
function mempalmes(){
if (map.getZoom()>15){
    cuadro=map.getExtent();
    lempalmes();
    document.getElementById('empalmes').src="empalmes.php?left="+cuadro.left+"&right="+cuadro.right+"&top="+cuadro.top+"&bottom="+cuadro.bottom;
}else{
    alert("Se requiere más acercamiento");
}
}
function lempalmes(){
  var arr = map.getLayersByName("Empalmes");
    if (arr.length){
      vectorLayer=arr[0];   
      map.removeLayer(vectorLayer);
    }
}
function inserta_emp(x,y,texto){
    empalme(new OpenLayers.LonLat(x, y).transform(new OpenLayers.Projection('EPSG:4326'),map.getProjectionObject()),texto);
}
function busca2(){
coords=document.forms[0].coords.value;
if (coords==""){
alert("Debe generar un polígono para la selección.");
}else{
document.forms[0].action="busca2n.php";
document.forms[0].submit();
document.getElementById("trabajo").style.display=""; 
}
}

function busca2_ant(){    
coords=document.forms[0].coords.value;
campos=document.forms[0].campost.value;
if (coords==""){
alert("Debe generar un polígono para la selección.");
}else{
//window.open('busca2.php?coords='+coords,"Busca","width=1024,height=600,scrollbars=1");
document.forms[0].action="busca2.php";
document.forms[0].submit();
document.getElementById("trabajo").style.display=""; 
}
}

function busca2_nollave(){
coords=document.forms[0].coords.value;
if (coords==""){
alert("Debe generar un polígono para la selección.");
}else{
    document.forms[0].action="buscankey.php";
    document.forms[0].submit();
}
}
function consultar(){
estab=document.forms[2].nomestab.value;
nomprop=document.forms[2].nomprop.value;
muni=document.forms[2].muni.value;
col=document.forms[2].col.value;
calle=document.forms[2].calle.value;
numext=document.forms[2].numext.value;
telefono=document.forms[2].telefono.value;
estab=estab.toUpperCase();
nomprop=nomprop.toUpperCase();
muni=muni.toUpperCase();
col=col.toUpperCase();
calle=calle.toUpperCase();
numext=numext.toUpperCase();
if (muni != '' || estab != '' || col != '' || calle != '' || numext != '' || nomprop != '' || telefono != ''){
    window.open('consultacampos.php?estab='+estab+"&nomprop="+nomprop+"&muni="+muni+"&col="+col+"&calle="+calle+"&numext="+numext+"&telefono="+telefono,"Bus","width=680,height=400,scrollbars=1,status=1");
}
else{
    alert ("Debe capturar minimo un campo...");
}
//alert(venta);
}

function limpiar(){
document.forms[2].nomestab.value='';
document.forms[2].nomprop.value='';
document.forms[2].muni.value='';
document.forms[2].col.value='';
document.forms[2].calle.value='';
document.forms[2].numext.value='';
document.forms[2].telefono.value='';
//alert(venta);
}

function extension(obj){
    var ext = forma.archivo.value.substr(forma.archivo.value.length-3,3);
    ext = ext.toUpperCase();
    if(ext != 'dbf' && ext != 'DBF'){        
        //document.getElementById('btnProcesar').style.visibility="hidden";
        alert('No es un archivo DBF!');
    }else
    {
    document.getElementById('btnProcesar').style.visibility="visible";
    }
}

function reacomoda(){    
    document.getElementById('toggler').style.top="0px";    
    document.getElementById('toggler').style.left="0px";    
}

function cambiaBase(dato){    
for (var i = 0, len = map.layers.length; i < len; i++) {
        var layer = map.layers[i];
        if (layer.name == dato.value) {	
            map.setBaseLayer(layer);			
            break;
        }
        }
}
function enciende(dato){    
 var arr = map.getLayersByName(dato);  
 if (arr.length) {  
     vectorLayer=arr[0];   
     vectorLayer.setVisibility(document.getElementsByName(dato).checked);       
 } 
}
function crea_clusters(){  
  
  document.getElementById("trabajo").style.display=""; 
  document.getElementById("frame_trabajo").src="vacio.php";
  document.getElementById("frame_trabajo").src="cgrupos.php";
  //window.open('cgrupos.php',"Crea_clusters","width=950,height=700,scrollbars=1");  
}

function busca_clases(){
coords=document.forms[0].coords.value;
document.forms[0].action="busca2_clases.php";
document.forms[0].submit();
document.getElementById("trabajo").style.display=""; 
//}
}

function limpia_combo(){
       document.forms[1].campos.options.length=0;
    }
function llena_combo(dato){    
    var option = document.createElement("option");
    option.text = dato;
    option.value = "";
    var select = document.getElementById("campos");
    select.appendChild(option);    
    }

function inserta(x,y,dato){        
    inserta_marca(new OpenLayers.LonLat(x, y).transform(new OpenLayers.Projection('EPSG:4326'),map.getProjectionObject()),dato);
}
function insertad(x,y,dato){        
    inserta_marca(new OpenLayers.LonLat(x, y),dato);
}
function inserta2(x,y){   
inserta_marca2(new OpenLayers.LonLat(x, y).transform(new OpenLayers.Projection('EPSG:4326'),map.getProjectionObject()));
}


function act(){
    var capa=document.getElementById('cap_opa').value;
    var arr = map.getLayersByName(capa); 
    des=arr[0]; 
    valor=des.opacity;
    
   $( "#slider" ).slider("value",valor);
}
function oferta_esc(nombre,cveesc,cve_unid){
    if (cve_unid==''){
        cve_unid="00";
    }
    window.open("oferta.php?cveesc="+cveesc+"&cve_unid="+cve_unid+"&nombre="+nombre,"Oferta_educativa","width=800,height=400,scrollbars=1,status=1");
}
function numerocomas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
