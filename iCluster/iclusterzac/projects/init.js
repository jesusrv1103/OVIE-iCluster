var evento = function(){

};

var getContenido = function(){
  return '<div id="mdmp_georss"><div>';
};

var projectParams = {
  'panel':            {
                        'right':{
                                  width:'0px',
                                  content:getContenido(),
                                  load:function(){
                                        
                                  }
                                }
                      },
  'aditionalLayers':[
                    /*
                      {
                        type:'Wms',
                        label:'escuelas',		             
                        url:'http://10.1.30.102/fcgi-bin/mapserv.exe?map=/opt/map/mercator.map&',
                        layer:'',
                        tiled:false,
                        format:'png'
                      }*/
                    ],
  'onLoad':           evento,
  'onMoveEnd':function(){},
  'onZoomEnd':function(){},
  'onIdentify':function(){},
  'btnTogglePanels':true
};
if(typeof(projectParams) != "undefined"){
    //MDM6('init',projectParams);
}
