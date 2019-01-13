requirejs.config({
    paths: {
        map:'core/map/map',
        mapStyles:'core/map/styles',
        mapControls:'core/map/controls',
        mapLayers:'core/map/layer',
        mapTree:'core/map/tree',
        timer:'core/map/clock',
        features:'core/map/features',
        wps:'core/map/wps',
        marker:'core/map/marker',
        popup:'core/map/popup',
        georeference:'core/map/georeference',
        events:'core/events',
        request:'core/map/request',
        linetime:'core/map/lineTime',
        modal:'core/map/modal',
        poi:'core/map/poi',
        dataSource:'../config/dataSourceConfig',
        notification:'core/map/notification',
        cluster:'core/map/cluster',
        escuelas:'core/map/escuelas',
        help:'../help/help',
        thirdService:'core/map/thirdService',
        geolocation:'core/map/geolocation',
        routing:'core/map/routing'
    },
    shim: {
        map: {
            deps:['notification','mapStyles','mapControls','mapLayers','mapTree','marker','features','wps','georeference','events','request','linetime','poi','escuelas','modal','thirdService','geolocation','cluster','restFullApi'],
        },
        routing:{
            deps:['features']
        }
    }
});
//agregado
define(["map","ui","request"], function(map,ui,request){
        amplify.subscribe( 'mapAfterLoad', function(){
            
        });
        return {
            init:function(){
                    if(map.testBrowserCompatibility()){
                    //var evento = function(){
                        map.Tree.event.addAditionals();
                        ui.init(map);
                        amplify.publish( 'mapBeforeLoad');
                        map.init();
                    //}
                    //restFullApi('init',request,map,ui);
                    }
            }
        }
});

function cargaImagen(lat,lon){
	window.open("https://www.google.com/maps/@"+lat+","+lon+",3a,75y,90t/data=!3m3!1e1!3m1!2e0","Street view" , "width=800,height=600");
}

function createGeodesicPolygon(origin, radius, sides, rotation, projection) {
                var latlon = origin;
				//alert(latlon);
                var latlon=origin.transform(new OpenLayers.Projection("EPSG:900913"),new OpenLayers.Projection("EPSG:4326"));
                var angle;
                var new_lonlat, geom_point;
                var points = [];
                document.getElementById('coords').value="";
                for (var i = 0; i < sides; i++) {
                    angle = (i * 360 / sides) + rotation;
                    new_lonlat = OpenLayers.Util.destinationVincenty(latlon, angle, radius);
                    if (i==0){
		      paso=new_lonlat.lon.toString() + " " + new_lonlat.lat.toString();
		    }
                    if (i==sides-1){
                       document.getElementById('coords').value=document.getElementById('coords').value + new_lonlat.lon.toString() + " " + new_lonlat.lat.toString()+ "," + paso; 
                    }else{
                       document.getElementById('coords').value=document.getElementById('coords').value + new_lonlat.lon.toString() + " " + new_lonlat.lat.toString()+ ",";
                    }     
                    new_lonlat.transform(new OpenLayers.Projection("EPSG:4326"), projection);
                    geom_point = new OpenLayers.Geometry.Point(new_lonlat.lon, new_lonlat.lat);
                    points.push(geom_point);
                }//for				
                var ring = new OpenLayers.Geometry.LinearRing(points);
                return new OpenLayers.Geometry.Polygon([ring]);    
            }// funcion crea poligono  

function cierra_apoyo(id,id2){
document.getElementById(id2).src='php/vacio.php';
document.getElementById(id).style.display='none';
}
function minimiza(id,id2){
document.getElementById(id).style.height='25px';
document.getElementById(id2).style.display='none';
}
function maximiza(id,id2){
document.getElementById(id).style.height='550px';
document.getElementById(id2).style.display='';
}
function pointZoom(x,y){    
  	
	smap.setCenter(new OpenLayers.LonLat(x,y).transform(new OpenLayers.Projection('EPSG:4326'),smap.getProjectionObject()), 14);
    //marca(x,y,'identify');
	umap.Mark.event({action:'delete',items:'all',type:'identify'});
	var lonlat = new OpenLayers.LonLat(x,y).transform(new OpenLayers.Projection('EPSG:4326'),smap.getProjectionObject());
	var params = {lon:lonlat.lon,lat:lonlat.lat,type:'identify',params:{nom:'Identificación',desc:'descripcion'}};
	umap.Mark.add(params);
	
}
function marca(x,y,imagen){
	var arr = smap.getLayersByName("Markers2");
	if (arr.length){
	markers=arr[0];
	markers.removeAllFeatures();
	}else{
	markers = new OpenLayers.Layer.Vector('Markers', { displayInLayerSwitcher: false });
	smap.addLayer(markers);}
    var feature = new OpenLayers.Feature.Vector(
            new OpenLayers.Geometry.Point( x, y).transform(new OpenLayers.Projection('EPSG:4326'),smap.getProjectionObject()),
            {description:'Identificación'} ,
            {externalGraphic: './img/marks/'+imagen+'.png', graphicHeight: 50, graphicWidth: 35, graphicXOffset:-25, graphicYOffset:-10  }
        );
   markers.addFeatures(feature);	
}

function visualizaActivos(){
	document.getElementById('ordenamf').src='php/ovisualiza.php';
	document.getElementById('ordenam').style.display='';
}
function visualizaGrafica(id,tema){
	document.getElementById('frame_trabajo').src='php/grafica.php?id='+id+'&tema='+tema;
	document.getElementById('reporte').style.display='';
}
function visualizaEconomico(id,tema){
	document.getElementById('frame_trabajo2').src='php/economico.php?id='+id+'&tema='+tema;
	document.getElementById('reporte2').style.display='';	
}
function zoomer(x,y){    
  	
	smap.setCenter(new OpenLayers.LonLat(x,y).transform(new OpenLayers.Projection('EPSG:4326'),smap.getProjectionObject()), 14);
    //marca(x,y,'identify');
	umap.Mark.event({action:'delete',items:'all',type:'identify'});
	var lonlat = new OpenLayers.LonLat(x,y).transform(new OpenLayers.Projection('EPSG:4326'),smap.getProjectionObject());
	var params = {lon:lonlat.lon,lat:lonlat.lat,type:'identify',params:{nom:'Identificación',desc:'descripcion'}};
	umap.Mark.add(params);
	
}