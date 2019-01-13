define(function() {
	var data = {
       	themes:{
			T1:{
                label:'Limite Estatal',
                layers:[
                    'c100'
                ],
                desc:'Marco Geoestadístico',
                img:'zacatecas.jpeg'
            },
            T2:{
                label:'Limite Municipal',
                layers:[
                    'c101'
                ],
                desc:'Marco Geoestadístico',
                img:'mun_zac.jpg'
            },
            T3:{
                label:'Localidades Urbanas',
                layers:[
                    'c102'
                ],
                desc:'Marco Geoestadístico',
                img:'locs_zac.png'
            },
			/*T4:{
                label:'Metadatos INEGI',
                layers:[
						'xx'
                ],
                desc:'',
                img:'INEGI.jpg'
            }*/
        },
		baseLayers:{
			B1:{
				type:'Wms',
				label:'Topogr&aacute;fico sin sombreado- INEGI',
				img:'mapa_sin_sombreado.jpg',		             
				url:['http://gaiamapas1.inegi.org.mx/mdmCache/service/wms?','http://gaiamapas3.inegi.org.mx/mdmCache/service/wms?','http://gaiamapas2.inegi.org.mx/mdmCache/service/wms?'],
				layer:'MapaBaseTopograficov61_sinsombreado',
				rights:'Derechos Reservados &copy; INEGI',
				tiled:true,
				legendlayer:['c100','c101','c102'],
				desc:'REPRESENTACION DE RECURSOS NATURALES Y CULTURALES DEL TERRITORIO NACIONAL A ESCALA 1: 250 000, BASADO EN IMAGENES DE SATELITE DEL  2002 Y TRABAJO DE CAMPO REALIZADO EN 2003',
				clasification:'VECTORIAL'
            },
			B2:{
				type:'Wms',
				label:'Topogr&aacute;fico con sombreado- INEGI',
				img:'mapa_con_sombreado.jpg',		             
				url:['http://gaiamapas1.inegi.org.mx/mdmCache/service/wms?','http://gaiamapas3.inegi.org.mx/mdmCache/service/wms?','http://gaiamapas2.inegi.org.mx/mdmCache/service/wms?'],
				layer:'MapaBaseTopograficov61_consombreado',
				rights:'Derechos Reservados &copy; INEGI',
				tiled:true,
				legendlayer:['c100','c101','c102','c102-r','c102m','c103','c109','c110','c111','c112','c200','c201','c202','c203','c206','c300','c301','c302','c310','c311','c762','c793','c795'],
				desc:'REPRESENTACION DE RECURSOS NATURALES Y CULTURALES DEL TERRITORIO NACIONAL A ESCALA 1: 250 000, BASADO EN IMAGENES DE SATELITE DEL  2002 Y TRABAJO DE CAMPO REALIZADO EN 2003',
				clasification:'VECTORIAL'
            },
            B3:{
				type:'Wms',
				label:'Hipsogr&aacute;fico - INEGI',
				img:'baseHipsografico.jpg',		             
				url:['http://gaiamapas1.inegi.org.mx/mdmCache/service/wms?','http://gaiamapas3.inegi.org.mx/mdmCache/service/wms?','http://gaiamapas2.inegi.org.mx/mdmCache/service/wms?'],
				layer:'MapaBaseHipsografico',
				rights:'&copy; INEGI 2013',
				tiled:true,
				legendlayer:['img_altimetria.png'],
				desc:'IMAGEN DE RELIEVE QUE MUESTRA UNA COMBINACION DE ELEVACION A TRAVES DE COLORES HIPSOGRAFICOS, GENERADA POR PROCESAMIENTO DEL CONTINUO DE ELEVACIONES MEXICANOS DE 3.0 DE 15 METROS.',
				clasification:'RASTER'
			},
            B4:{
				type:'Wms',
				label:'Ortofotos - INEGI',
				img:'baseOrtos.jpg',		             
				url:['http://gaiamapas1.inegi.org.mx/mdmCache/service/wms?','http://gaiamapas3.inegi.org.mx/mdmCache/service/wms?','http://gaiamapas2.inegi.org.mx/mdmCache/service/wms?'],
				layer:'MapaBaseOrtofoto',
				rights:'&copy; INEGI 2013',
				tiled:true,
				desc:'CONJUNTO DE IMAGENES AEREAS ORTORECTIFICADAS A DIVERSAS ESCALAS Y RESOLUCIONES, PROVENIENTES DEL ACERVO DE ORTOFOTOS DE INEGI Y QUE CORRESPONDEN A TOMAS REALIZADAS EN EL LAPSO 2005-2012.',
				clasification:'RASTER'
			},			
			B5:{
				type:'Osm',
				label:'Open Street Map',
				img:'Osm.jpg',
				rights:'&copy; OpenStreetMap contributors',
				clasification:'VECTORIAL'
			},
			B6:{
				type:'Esri',
				label:'Esri map',
				img:'Google.jpg',
				url:'http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/${z}/${y}/${x}',
				rights:'&copy; ESRI',
				clasification:'Raster'
			}, 
			B7:{
				type:'Esri',
				label:'Esri map',
				img:'Esri.jpg',
				url:'http://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/${z}/${y}/${x}',
				rights:'&copy; ESRI',
				clasification:'VECTORIAL'
            },
			B8:{
                type:'Bing',
                label:'Bing maps',
                img:'Bing.jpg',
                key:'At-Y-dJe-yHOoSMPmSuTJD5rRE_oltqeTmSYpMrLLYv-ni4moE-Fe1y8OWiNwZVT',
                layer:'Aerial',
                rights:'&copy; Bing Maps',
                clasification:'RASTER'
            },
        },
		layers:{
			groups:{
				G1:{
					label:'L&iacute;mites del Marco Geoestad&iacute;stico',
					layers:{
						c100:{
							label:'Estatales',
							synonymous:['estado','estatales'],
							scale:0,
							position:1,
							active:true,
							texts:{
								scale:1,
								active:false
                            }
						},
						c101:{
							label:'Municipales',
							synonymous:['municipio','municipales','municipal'],
							scale:0,
							position:2,
							active:true,
							texts:{
								scale:1,
								active:false
							}
						},
						c102:{
							label:'Localidades Urbanas',
							synonymous:['Localidades Urbanas'],
							scale:0,
							position:3,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_ageb:{
							label:'Agebs Urbanas',
							synonymous:['Ageb'],
							scale:0,
							position:4,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_mza:{
							label:'Manzanas',
							synonymous:['Manzanas'],
							scale:0,
							position:5,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_vial:{
							label:'Vialidades',
							synonymous:['calles'],
							scale:0,
							position:6,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_agebr:{
                            label:'Agebs rurales',
                            synonymous:['Agebs rurales'],
                            scale:0,
                            position:7,
                            active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_lpr:{
                            label:'Localidades rurales',
                            synonymous:['Localidades rurales'],
                            scale:0,
                            position:6,
                            active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_num_ext:{
                            label:'Números Exteriores',
                            synonymous:['números exteriores'],
                            scale:0,
                            position:40,
                            active:false,
							texts:{
								scale:1,
								active:false
							}
						}
					}
				},        
				G2:{
					label:'Directorio Nacional de Unidades Econ&oacute;micas DENUE ',
					layers:{
						c_denue_2014:{
							label:'Establecimientos econ&oacute;micos DENUE',
							synonymous:['DENUE'],
							scale:0,
							position:10,
							active:false,
							metadato:'php/metadato.php?dato=c_denue',
							texts:{
								scale:1,
								active:false
							}
						}
					}
				},
				G3:{
					label:'Red Estatal de Caminos (RNC 2017)',
					layers:{
						c_carr_est:{
							label:'Carretera Estatal',
							synonymous:['Carretera Estatal'],
							scale:0,
							position:11,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_carr_fed:{
							label:'Carretera Federal',
							synonymous:['Carretera Federal'],
							scale:0,
							position:12,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_plaza_cobro:{
							label:'Plaza de Cobro',
							synonymous:['Plaza de Cobro'],
							scale:0,
							position:13,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_puentes:{
							label:'Puentes',
							synonymous:['Puentes'],
							scale:0,
							position:14,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
					}
				},
				G4:{
					label:'Sitios de Interés (RNC 2017)',
					layers:{
						c_si_piscinas:{
							label:'Piscinas',
							synonymous:['piscinas'],
							scale:0,
							position:16,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_si_universidades:{
							label:'Universidades',
							synonymous:['universidades'],
							scale:0,
							position:17,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_si_aeropuertos:{
							label:'Aeropuertos',
							synonymous:['aeropuertos'],
							scale:0,
							position:18,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_si_teatros:{
							label:'Teatros',
							synonymous:['teatros'],
							scale:0,
							position:19,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_si_hospitales:{
							label:'Hospitales',
							synonymous:['hospitales'],
							scale:0,
							position:20,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_si_ccomerciales:{
							label:'Centros Comerciales',
							synonymous:['centros comerciales'],
							scale:0,
							position:21,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_si_cculturales:{
							label:'Centros Culturales',
							synonymous:['centros culturales'],
							scale:0,
							position:22,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_si_ccivicos:{
							label:'Centros Cívicos',
							synonymous:['centros civicos'],
							scale:0,
							position:23,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_si_cdeportivos:{
							label:'Centros Deportivos',
							synonymous:['centros deportivos'],
							scale:0,
							position:24,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_si_cgolf:{
							label:'Campos de Golf',
							synonymous:['campos de golf'],
							scale:0,
							position:25,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_si_estadios:{
							label:'Estadios',
							synonymous:['estadio'],
							scale:0,
							position:26,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_si_ogobierno:{
							label:'Oficinas de Gobierno',
							synonymous:['oficinas de gobierno'],
							scale:0,
							position:27,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_si_lculto:{
							label:'Lugares de Culto',
							synonymous:['lugares de culto'],
							scale:0,
							position:28,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_si_museos:{
							label:'Museos',
							synonymous:['museos'],
							scale:0,
							position:28,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_si_destilerias:{
							label:'Destilerías y Degustación de Vinos',
							synonymous:['destilerias'],
							scale:0,
							position:29,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_si_eacombustibles:{
							label:'Estaciones de Abastecimiento de Combustible',
							synonymous:['gasolineras'],
							scale:0,
							position:30,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_si_zindustriales:{
							label:'Zonas Industriales',
							synonymous:['zonas industriales'],
							scale:0,
							position:31,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_si_eferrocarriles:{
							label:'Estaciones de Ferrocarril',
							synonymous:['estaciones de ferrocarril'],
							scale:0,
							position:32,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_si_cinspeccion:{
							label:'Casetas de Inspección',
							synonymous:['casetas de inspeccion'],
							scale:0,
							position:33,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_si_lesparcimiento:{
							label:'Lugares de Esparcimiento',
							synonymous:['lugares de esparcimiento'],
							scale:0,
							position:34,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_si_mhistoricos:{
							label:'Monumentos Históricos',
							synonymous:['monumentos historicos'],
							scale:0,
							position:35,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_si_aturisticos:{
							label:'Atractivos Turísticos',
							synonymous:['atractivos turisticos'],
							scale:0,
							position:36,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_si_cconvenciones:{
							label:'Centros de Convenciones',
							synonymous:['centros de convenciones'],
							scale:0,
							position:37,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_si_ientretenimiento:{
							label:'Instalaciones de Entretenimiento',
							synonymous:['instalaciones de entretenimiento'],
							scale:0,
							position:38,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						},
						c_si_paereas:{
							label:'Pistas Aéreas',
							synonymous:['pistas aereas'],
							scale:0,
							position:39,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						}
					}
				},
				G5:{
					label:'Asentamientos',
					layers:{
						c_asentamientos:{
							label:'Asentamientos',
							synonymous:['asentamientos','colonias'],
							scale:0,
							position:15,
							active:false,
							texts:{
								scale:1,
								active:false
							}
						}
					}
				}
			}
		}
	};
	if(typeof(treeConfig)!='undefined'){
        	data = $.extend(data, treeConfig);
    	}
    	return data;
});
