define(function(){
	var sources = {
		proyAlias:'Mapa Digital de México',
    		proyName:'mdm6',
		servicesVersion:'iClusterNL',
		mainPath:'http://189.254.255.113',
		//Ejemplo de configuracion a busqueda solar Externa
		search:{
		url:'http://189.254.255.113:8080/mdmSearchEngine-iCluster/busq-entidades/shard',
			type: 'POST',
			contentType : "application/json; charset=utf-8",
			dataType: "jsonp",
			jsonp:'json.wrf',
			params:{
				wt:'json',
				indent:'true',
				facet:'true',
				'facet.field':'tipo',
				'defType':'edismax',
				qf:'busqueda',
				rows:50
			}
       		}, 
        	layersSeaIde:{
			url:'http://189.254.255.113/mdmservices/fieldtypes',
			contentType : "application/json; charset=utf-8",
                	type: 'POST',
                	dataType: "json"
        	},
		exportList:{
			url:'http://189.254.255.113/mdmservices/export',
			type:   'POST',
			contentType : "application/json; charset=utf-8",
			dataType: "json",
		},
		saveStats:{
			url:'http://189.254.255.113/mdmservices/stats/layers',
			type: 'POST',
			contentType : "application/json; charset=utf-8",
			dataType: "json",
		},
		share:{
			contentType : "application/json; charset=utf-8",
			url:'http://189.254.255.113/mdmservices/share',
			type: 'POST',
			dataType: "json"
        	},
		shareEmail:{
			contentType : "application/json; charset=utf-8",
			url:'http://189.254.255.113/mdmservices/share/email',
			type: 'POST',
			dataType: "json"
        	},
        	identify:{
			url:'http://189.254.255.113/mdmservices/identify',
			type: 'POST',
			contentType : "application/json; charset=utf-8",
			dataType: "json",
        	},
        	bufferLayer:{
                	url:'http://189.254.255.113/mdmservices/totals',
                	contentType : "application/json; charset=utf-8",
                	type: 'POST',
                	dataType: "json"
        	},
        	identifyDetail:{
			url:'http://189.254.255.113/mdmservices/query',
                	type:'POST',
                	contentType : "application/json; charset=utf-8",
                	dataType: "json"
        	},
        	crossSearch:{
                	url:'http://189.254.255.113:8080/mdmSearchEngine/busqueda',
                	contentType : "application/json; charset=utf-8",
                	type: 'POST',
                	dataType: "json"
        	},
		deepSearchTranslate:{
                	url:'http://189.254.255.113:8080/mdmSearchEngine/busqueda',
                	type: 'POST',
                	dataType: "json",
			contentType : "application/json; charset=utf-8",
			stringify:true,
			params:{
				tabla: 'geolocator',
				pagina: 1,
				searchCriteria: '',
				proyName: 'mdm6',
				whereTipo: ''
			}
        	},
        
       denue:{
		    url:'http://189.254.255.113:8080/mdmSearchEngine/busq-denue/select',
	     	field:'busqueda',
			type: 'POST',
			dataType: "jsonp",
			jsonp:'json.wrf'
        	},
        	
        	kml:{
			save:'http://189.254.255.113/mdmexport/kml/download',
			read:'http://189.254.255.113/mdmexport/kml/upload'
		},
		gpx:{
			save:'http://189.254.255.113/mdmexport/gpx/download',
			read:'http://189.254.255.113/mdmexport/gpx/upload'
		},
		geometry:{
			store:{
				url:'http://189.254.255.113/mdmservices/geometry',
				type: 'POST',
				dataType: "json",
				contentType : "application/json; charset=utf-8"
			},
			addBuffer:{
				url:'http://189.254.255.113/mdmservices/buffer',
				type:'POST',
				dataType:'json',
				contentType:'application/json; charset=utf-8'
			},
			restore:{
				url:'http://189.254.255.113/mdmservices/wkt/geometries',
				type: 'GET',
				dataType: "json",
				contentType : "application/json; charset=utf-8"
			},
		},
		timeLine:'json/linetime.do',
       		school:'',
       		//Otras Url de informacion---------------------------------------------
       		leyendUrl:'http://189.254.255.113/cgi-bin/mapserv?map=/opt/map/mdm60/iclusterzac_leyenda.map&Request=GetLegendGraphic&format=image/png&Version=1.1.1&Service=WMS&LAYER=',
       		synonyms:{
       			list:{
        			/*farmacia:['botica','drogeria'],
        			banco:['cajero'],
        			restaurant:['bar','merendero'],
        			hospital:['clinica'],
        			hotel:['motel','posada']*/
       			}
       		},
		routing:{
    			movePoint:'http://189.254.255.113/routing/point/move'
		},
		cluster:{
    			moreLevels:[2.388657133483887,1.1943285667419434,0.5971642833709717,0.29858214168548586],
    			enableOn:{
				layer:'denue'
    			},
    			recordCard:{
				url:'http://mdm5beta.inegi.org.mx:8181/mdmservices/denue/label',
				type:'POST',
				dataType:'json'
    			},
    			nodes:{
				url:'http://mdm5beta.inegi.org.mx:8181/mdmservices/denue/scian',
				type:'POST',
				dataType:'json'
    			},
    			geometry:{
				url:'http://mdm5beta.inegi.org.mx:8181/mdmservices/wkt/feature',
				type:'POST',
				dataType:'json'
    			}
		},
        	logging:'http://10.1.32.5/SISEC2013/jerseyservices/ServicioSesionJson',
		georeferenceAddress:{
			url:'http://mdm5beta.inegi.org.mx:8181/mdmservices/reversegeocoding',
			type: 'POST',
			dataType: "json",
			contentType : "application/json; charset=utf-8"
		},
		mousePosition:{
		elevation:{
		//url:'http://189.254.255.113/mdmservices/raster/elevation',
			type:'POST',
		 	dataType:'json'
	    	}
	},
		files:{
				download:'http://189.254.255.113/mdmdownloadfile/download'
	    		
		}
	};
	return sources;
});
