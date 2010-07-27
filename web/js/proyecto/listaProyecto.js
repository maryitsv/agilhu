//var dataStoreListaProyectos;
var ListaProyectos = function () 
{
	return { 
		init: function () {
		
		/**********************************************LISTAR INVITACIONES***********************************/
	
    //creamos el data estore cargando desde la base de datos
    dataStoreListaProyectos = new Ext.data.Store({
	id: 'dataStoreListaProyectos',
	proxy: new Ext.data.HttpProxy({
		  url: 'listaproyectos/cargar', 
		  method: 'POST'
	      }),
	baseParams:{task: 'LISTARPRO'}, // this parameter is passed for any HTTP request
	reader: new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'id'
	    },[ 
		{name: 'proid', type: 'int'},
		{name: 'procreador', type: 'string'},
		{name: 'prosigla', type: 'string'},
		{name: 'pronom', type: 'string'},
		{name: 'proarea', type: 'string'},
		{name: 'prodescripcion', type: 'string'},
		{name: 'profechaini', type: 'string'},
		{name: 'profechafin', type: 'string'},
		{name: 'proestado', type: 'string'},
		{name: 'prologo', type: 'string'},
		{name: 'estadoinvitacion', type: 'string'},
		{name: 'usuinvitado', type: 'string'},
		{name: 'prodescripcion', type: 'string'},

	]),
	//sortInfo:{field: 'fechaini', direction: "ASC"}
    });
    
function ponerRojo(val)
{
if(val=='por definir')
return '<span style="color:red;">' + val + '</span>';
else
return '<span style="color:blue;">' + val + '</span>';

}


function ponerimagen(val){
	if(val!='0')
	{
	 return '<img src='+URL_AGILHU+'/pusuario.php/documentos/cargar?task=DESCARGAR&Identificador='+val+' width=35 heigth=35 >';
	}
	else
	{ 
	 return '<img src="../images/projecto-logo-default.png" width=30 heigth=30 >';
	}
}

     
    var colModelListaProyectos = new Ext.grid.ColumnModel({
    defaults:{sortable: true, locked:false},
    columns:[  
		{ header: "%", width: 50, dataIndex: 'prologo',renderer:ponerimagen,resizable:false},
		{ header: "Nombre abreviado", width: 110, dataIndex: 'prosigla'},
		{ header: "Nombre", width: 210, dataIndex: 'pronom'},
		{ header: "Creador", width: 70,  dataIndex: 'procreador'},
		{ header: "Area", width: 70,  dataIndex: 'proarea'},
		{ header: "Fecha Inicio", width: 70,  dataIndex: 'profechaini'},
		{ header: "Fecha Fin ", width: 70, dataIndex: 'profechafin'},
		{id:'prodescripcion', header: "Descripcion ", width: 230, dataIndex: 'prodescripcion'},

    	]
    });

    dataStoreListaProyectos.load();
    
    var gridListaProyectos=new Ext.grid.GridPanel({
		id:'gridListaProyectos',
		region:'center',
	            ds: dataStoreListaProyectos,
	            cm: colModelListaProyectos,
	            stripeRows:true,
	            sm: new Ext.grid.RowSelectionModel({
	                singleSelect: true,
	                listeners: {
	                    rowselect: function(sm, row, rec) {
						selectionProyecto(sm, row, rec);
						}}
	            }),
		    autoWidth:true,
		    title:'Proyectos Aceptados en los que participo',
		    iconCls:'invitacion',
	            border: true,
                 frame:true,
		    listeners: {
				 render: function(g) {g.getSelectionModel().selectRow(0);},
		        	 delay: 10},
		    bbar: new Ext.PagingToolbar({
			    pageSize: 35,
			    store: dataStoreListaProyectos,
			    displayInfo: true,
			    displayMsg: 'Proyectos {0} - {1} of {2}',
			    emptyMsg: "No hay proyectos"
			    
			}),
		tbar:[{text:'',iconCls:'ajustar',tooltip:'Ajustar el panel al area de trabajo',
	              handler:function(){
		          agContenedorListaProyectos.setHeight(heightCentro);
		          gridListaProyectos.doLayout();
		          }
		}],
		plugins:[new Ext.ux.grid.Search({
			mode:          'local',
			position:      top,
			searchText:    'Filtrar',
			iconCls:  'filtrar',
			selectAllText: 'Seleccionar todos',
			searchTipText: 'Escriba el texto que desea buscar y presione la tecla enter',
			width:         100
		})],
		autoExpandColumn:'prodescripcion'
        	});




gridListaProyectos.on('rowdblclick', doble, this);

function doble()
{
//agalerta('doble click');

};
  	
  	
	 agContenedorListaProyectos = new Ext.Panel({
                id: 'agContenedorListaProyectos',
                height:heightCentro,
                autoWidth:true,
                monitorResize :true,
                layout:'border',
                
                items: [gridListaProyectos,
			],

                renderTo:'formularioListaProyectosDiv',
	});
	
   agContenedorListaProyectos.doLayout();
   
/***************funciones*************************/
	
         


	}//hata aqui las llaves obligatorias 
	}
}();


function selectionProyecto (sm, row, rec)
	{

	Ext.Ajax.request({  
		waitMsg: 'Por Favor Espere...',
		url:'listaproyectos/cargar',
		params: { 
			task: "SELECIONPRO", 
			idproyecto:  rec.data.proid
		}, 
		success: function(response){
		agaviso('Seleciono el proyecto '+rec.data.prosigla);
		var jsonDecode = Ext.util.JSON.decode(response.responseText);

		rolesProyecto=jsonDecode.data;
                Ext.getCmp('agPrinCentro').removeAll();
	        Ext.getCmp('agMenuPanel').hide();
	
                Ext.getCmp('agMenuPanelProyecto').show();
 	        Ext.getCmp('agMenuPanelProyecto').setTitle(rec.data.prosigla);
	
		},
		failure: function(response){
			var result=response.responseText;
			agerror('No se pudo conectar con la base de datos');
		}
	});
      
	}

