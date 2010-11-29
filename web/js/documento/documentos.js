/*A esto le falta lo de las historias de usuario, combo*/
 
var Documento = function () 
{
	
Ext.QuickTips.init();
			
		/*************************************************LISTAR DOCUMENTOS**************************************/
		
/*CREACION DE DATSOTORES Y COLUMNS*/
    //creamos el data estore cargando desde la base de datos
    dataStoreDocumentos = new Ext.data.GroupingStore({
	id: 'dataStoreDocumentos',
	proxy: new Ext.data.HttpProxy({
		  url: 'documentos/cargar', 
		  method: 'POST'
	      }),
	baseParams:{task: 'LISTARDOCS'}, 
	reader: new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'id'
	    },[ 
		{name: 'idDocumento'},
		{name: 'nombre'},
		{name: 'tamano'},
		{name: 'tipo'},
		{name: 'modulo'},//id mod
		{name: 'moduloNombre'},
		{name: 'historia'},//id his
		{name: 'historiaNombre'},
		{name: 'subidoPor'},
		{name: 'fechasubido'},
		{name: 'descripcion'}	
	]),
	sortInfo:{field: 'tipo', direction: "ASC"},
	groupField:'moduloNombre'
    });

    function ponerIconoDoc(val,x,store)
    {
	var i=store.data.tipo;

	if(i.indexOf('application')!==-1)	
	return '<img src="../images/iconos/doc/file_acrobat.gif">';

	if(i.indexOf('text')!==-1)		
	return '<img src="../images/iconos/doc/doc_text.png">';

	if(i.indexOf('image')!==-1)		
	return '<img src="../images/iconos/doc/image.png">';
    }
    
    var colModelDocumento;
    colModelDocumento = new Ext.grid.ColumnModel({
    defaults:{sortable: true, locked:false,resizable:true,width: 160},
    columns:[
		{id:'icon', header: "Icon", width: 30, dataIndex: 'icon',renderer:ponerIconoDoc},
		{id:'nombre', header: "Nombre",  dataIndex: 'nombre'},
		{id:'tamano', header: "Tamano", width: 60, dataIndex: 'tamano'},
		{id:'tipo', header: "Tipo", width: 70, dataIndex: 'tipo'},
		//{id:'modulo', header: "Modulo",  dataIndex: 'modulo'},
		{id:'moduloNombre', header: "Modulo",  dataIndex: 'moduloNombre'},
		//{id:'historia', header: "Historia", dataIndex: 'historia'},
		{id:'historiaNombre', header: "Historia", dataIndex: 'historiaNombre'},
		{id:'subidoPor', header: "Usuario Subio", width: 110, dataIndex: 'subidoPor'},
		{id:'fechasubido', header: "Fecha Subida", width: 110,  dataIndex: 'fechasubido'},
		{id:'descripcion', header: "Descripcion", width: 230,  dataIndex: 'descripcion'},
    	]
    });

    dataStoreDocumentos.load();
    /*los de la tool bar*/
    dataStoreDocxModuloFiltro = new Ext.data.Store({
	id: 'dataStoreDocxModuloFiltro',
	proxy: new Ext.data.HttpProxy({
		  url: 'documentos/cargar', 
		  method: 'POST'
	      }),
	baseParams:{task: 'LISTARMOD'}, // this parameter is passed for any HTTP request
	reader: new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'id'
	    },[{name: 'modId'},{name: 'modNombre'}]),
	sortInfo:{field: 'modNombre', direction: "ASC"}
    });

	comboBoxDocxModuloFiltro= new Ext.form.ComboBox({
		id:'comboBoxDocxModuloFiltro',
		name:'comboBoxDocxModuloFiltro',
		fieldLabel:'Modulo',
		store:dataStoreDocxModuloFiltro,
		mode:'local',
		emptyText:'Filtre por modulo',
		displayField:'modNombre',
		valueField:'modId',
		triggerAction:'all',
		//forceSelection:true,
		width: 220,
		disabled:false
	});
	dataStoreDocxModuloFiltro.load();

	comboBoxDocxModuloFiltro.on(
         'select', function(){	
						
			dataStoreDocumentos.removeAll();
			
			dataStoreDocumentos.baseParams = {
					task: 'LISTARDOCS',
					modId: Ext.getCmp('comboBoxDocxModuloFiltro').getValue()
					};
			
			dataStoreDocumentos.reload();
			
		},this
		);

   /*los del formulario*/
  dataStoreDocxModulo = new Ext.data.Store({
	id: 'dataStoreDocxModuloFiltro',
	proxy: new Ext.data.HttpProxy({
		  url: 'documentos/cargar', 
		  method: 'POST'
	      }),
	baseParams:{task: 'LISTARMOD'}, // this parameter is passed for any HTTP request
	reader: new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'id'
	    },[{name: 'modId'},{name: 'modNombre'}]),
	sortInfo:{field: 'modNombre', direction: "ASC"}
    });
  dataStoreDocxModulo.load();

dataStoreDocxHU = new Ext.data.Store({
	id: 'dataStoreDocxHU',
	proxy: new Ext.data.HttpProxy({
		  url: 'documentos/cargar', 
		  method: 'POST'
	      }),
	baseParams:{task: 'LISTARHU'}, // this parameter is passed for any HTTP request
	reader: new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'id'
	    },[{name: 'hisIdentificador'},{name: 'hisNombre'}]),
	sortInfo:{field: 'hisNombre', direction: "ASC"}
    });
  dataStoreDocxHU.load();

    /*CREACION DELA GRILLA*/
    //cargamos el modelo de la tabla 
    var gridPanelListaDocumentos = new Ext.grid.GridPanel({
        id: 'gridPanelListaDocumentos',
        title:'Documentos Existentes',
	//border: false,
	frame: true,
	autoExpandColumn:'descripcion',
	autoExpandMin :200,
	region:'center',
 	ds: dataStoreDocumentos,
	cm: colModelDocumento,
	stripeRows:true,
	sm: new Ext.grid.RowSelectionModel({
	    singleSelect: true,
		listeners: {
		    rowselect: function(sm, row, rec) {
					   Ext.getCmp('formDocumento').getForm().loadRecord(rec);
                                               
                                           if(rec.data.historia==0){
                                           Ext.getCmp('doc_historia').clearValue();
                                           }
                                             
                                           if(rec.data.modulo==0){
                                           Ext.getCmp('doc_modulo').clearValue();
                                           }


					}}
	    }),           
	listeners: {
	       	render: function(g) {
	        		g.getSelectionModel().selectRow(0);
	       	},delay: 10
        },
	tbar:[
		{text:'Nuevo',handler:crearDocumento,iconCls:'nuevo_doc',scale:'large',tooltip:'Pulse aqui para guardar nuevos documentos'},'-',
		{text:'Busqueda Especializada',iconCls:'buscar',scale:'large',tooltip:'Escoja un modulo para filtrar los documentos'},
		comboBoxDocxModuloFiltro
	],
        bbar: new Ext.PagingToolbar({
		pageSize: 20,
		store: dataStoreDocumentos,
		displayInfo: true,
		displayMsg: 'Proyectos {0} - {1} de {2}',
		emptyMsg: "No hay documentos"
         }),
	plugins:[new Ext.ux.grid.Search({
			mode:          'local',
			position:      top,
			searchText:    'Filtrar la lista',
			iconCls:  'filtrar',
			selectAllText: 'Seleccionar todos',
			searchTipText: 'Escriba el texto que desea buscar y presione la tecla enter',
			width:         100
		})],
	view: new Ext.grid.GroupingView(),
	//height: 340, 
	autoWidth:true,
    });
	



   /*CREACION DE FORMULARIO*/
var formDocumento=new Ext.FormPanel({
	title:'Datos detallados del documento',
	layout:'column',
        height: 220,
        split: true,
        region:'south',
	collapsible: true,    
        frame:true,
	id:'formDocumento',
	fileUpload: true,
        deferredRender: false,
	defaults:{bodyStyle:'padding:15px',layout:'form',border:false,},
	items:[{
	    width:'40%',	 
	    fileUpload: true,    
            deferredRender: false,
		defaults:{xtype:'textfield',anchor:'100%'},
		items:[
			{fieldLabel: 'Nombre(*)',id:'nombre',name: 'nombre',emptyText: 'Nombre del documento',allowBlank:false},
			new Ext.form.ComboBox({
                                id:'doc_modulo',
				name:'modulo',
				fieldLabel:'Modulo',
				store:dataStoreDocxModulo,
				mode:'local',
				emptyText:'Escoja un modulo si el doc esta asociado a este',
				displayField:'modNombre',
				valueField:'modId',
				triggerAction:'all',
				forceSelection:true,
				hiddenName :'modulo',
				disabled:false
			}),
			new Ext.form.ComboBox({
                                id:'doc_historia',
				name:'historia',
				fieldLabel:'Historia',
				store:dataStoreDocxHU,
				mode:'local',
				emptyText:'Escoja una historia si el doc esta asociado a esta',
				displayField:'hisNombre',
				valueField:'hisIdentificador',
				triggerAction:'all',
				forceSelection:true,
				hiddenName :'historia',
				disabled:false
			}),		
			{xtype: 'fileuploadfield', id: 'archivo', emptyText: 'Seleccione un documento', fieldLabel: 'Escojer(*)',
	               name: 'archivo',buttonText: '',allowBlank:false,
	               buttonCfg: {iconCls: 'archivo'}
		  	},
			{id:'idDocumento',name: 'idDocumento',xtype:'hidden'},
			]
		},
		{xtype:'panel',
	    deferredRender: false,
		width:'60%',
		labelAlign: 'top',
		items:[
		    	   {fieldLabel: 'Descripcion',id:'descripcion',name:'descripcion',xtype: 'textarea',
							  emptyText:'Digite una breve descripcion del proyecto',
							  enableFont :false,enableSourceEdit :false,height:80,anchor:'100%'
					    }
		    	   
            ]}],
	buttons:[{text:'Descargar',id:'btnDescargarDoc',handler:descargarDocumento,iconCls:'descargar_doc',scale:'large',tooltip:'Seleccione un documento y pulse aqui para descargarlo'},{text:'Eliminar',id:'btnEliminarDoc',handler:eliminarDocumento,iconCls:'eliminar_doc',scale:'large',tooltip:'Seleccione un documento y pulse aqui para eliminarlo'}]	
});

    
/*INTEGRACION AL CONTENEDOR*/
	var panelContenedorDocumentos = new Ext.Panel({
            id: 'agContenedorDocumentos',
            height: heightCentro,
            autoWidth:true,
            title:'Documentos',
            closable: true,
            frame:true,
            border:false,
            iconCls:'docs',
	    tabTip :'Aqui puedes ver,agregar , eliminar y descargar doucmentos del proyecto',

            monitorResize:true,
            layout:'border',
            items: [gridPanelListaDocumentos,formDocumento]//,
          //  renderTo:'formularioDocumentos',
	});
   
   

		/***************************************************FUNCIONES******************************************/
         function crearDocumento(){
		
		gridPanelListaDocumentos.disable(); 
		
		Ext.getCmp('formDocumento').getForm().reset();

		Ext.getCmp('btnDescargarDoc').setText('Guardar');
		Ext.getCmp('btnEliminarDoc').setText('Cancelar');

         }


        
         function descargarDocumento()
         {
		if(Ext.getCmp('btnDescargarDoc').getText()=='Guardar')
		{//falta verificar campos, el nombre , el archivo: la descripcion, modulo y historia es opcional
			 var verificacion =verificarCamposDocumento();
	  
	 		 if(verificacion)
	  		{
				(formDocumento.getForm()).submit({
				  waitTitle: 'Enviando',
				  waitMsg: 'Por Favor Espere...',
				  scope:this,
				  url:'documentos/cargar',
				  params: { 
					  task: 'CREATEDOC'
				  }, 
				  success: function(response, action)
				  {
				  obj = Ext.util.JSON.decode(action.response.responseText);
				    if(obj.success)
				    {
				             agaviso(obj.mensaje); 
				    }

				    if (obj.success == false)
				    {
			   	           agerror(obj.errors.reason); 
				    }

					gridPanelListaDocumentos.enable(); 
					dataStoreDocumentos.reload();
					Ext.getCmp('btnDescargarDoc').setText('Descargar');
					Ext.getCmp('btnEliminarDoc').setText('Eliminar');
				  },
				  failure: function(form, response)
				  {
				           var result=response.responseText;
				           agerror(result);

				  }
				  });
			
			}
		}
		
		if(Ext.getCmp('btnDescargarDoc').getText()=='Descargar')
		{
                 var url = URL_AGILHU+'pusuario.php/documentos/cargar?task=DESCARGAR&Identificador='+Ext.getCmp('idDocumento').getValue();
                  win = window.open(url,'Documento','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
		}
         }
         
         function eliminarDocumento()
         {
		if(Ext.getCmp('btnEliminarDoc').getText()=='Eliminar')
		{
			Ext.Ajax.request({  
				waitMsg: 'Por Favor Espere...',
				url:'documentos/cargar',
   				params: { 
					task: 'ELIMINARDOC',
				  	Identificador:Ext.getCmp('idDocumento').getValue(),
					nombre:Ext.getCmp('nombre').getValue()
				}, 
				success: function(response)
				  {
				     obj = Ext.util.JSON.decode(response.responseText);
				     if(obj.success)
				     {agaviso(obj.mensaje);}

				     if (obj.success == false)
				     {agerror(obj.errors.reason);}

				     dataStoreDocumentos.reload(); 
				  },
				  failure: function(form, response)
				  {
				     
				      agerror('servidor no encontrado');
				  }
			});
		}
		
        if(Ext.getCmp('btnEliminarDoc').getText()=='Cancelar')
        {
            gridPanelListaDocumentos.enable(); 
            Ext.getCmp('btnDescargarDoc').setText('Descargar');
            Ext.getCmp('btnEliminarDoc').setText('Eliminar');
		}
        }


	function verificarCamposDocumento(){
	valido=true;
		if(!(Ext.getCmp('nombre').isValid() &&
		     Ext.getCmp('archivo').isValid() )) 
	 	{
	 		agalerta('El nombre del documento y el archivo son obligatorios');
	 		return false;
	 	}
	return valido;
	}
	
return panelContenedorDocumentos;	
}//hata aqui las llaves obligatorias 

