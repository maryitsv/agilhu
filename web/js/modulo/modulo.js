/*LA VARIABLE ROLES PROYECTO, ES TRATADA EN LISTADO PROYECTO
lA FUNCION TIENE ROL ES UNA FUNCION AUXILIAR DE AUXILIARES/FUNCIONES.JS
*/
	var ModuloListingGrid;
	//var rolesProyecto=['admin','tester','cliente','programador'];

google.load('visualization', '1', {packages:['orgchart']});
var Modulo = function () 
{
        Ext.QuickTips.init();

	var ModuloPadreDataStore;
	var ModuloColumnModel;
	
        ModuloPadreDataStore = new Ext.data.JsonStore({	
		id: 'ModuloPadreDataStore',
		url:'modulo/cargar',
		root: 'results',
		baseParams:{task:'LISTINGMOD'},
		totalProperty: 'total',
		reader:new Ext.data.JsonReader({
			root:'results',
			totalProperty:'total',
			id:'id'}),
		fields:[
			{name: 'modId', type: 'string'},
			{name: 'modNombre', type: 'string'},
		],
		sortInfo:{field: 'modId', direction: 'ASC'}	
	});
	ModuloPadreDataStore.load();
	
	 var ModuloGrid = new Ext.ux.tree.TreeGrid({
        region:'center',
	height: heightCentro,
	title:'Lista de Modulos',
     //   autoExpandColumn:'Habilitado',
        width: 500,
        frame:true,
        enableDD: true,
        bodyStyle  :'background-color:white ;',
        columns:[
		{header: 'Nombre',dataIndex: 'modNombre',width: 150},
		{header: 'Estado',dataIndex: 'modEstado',width: 80},
		{header: 'Fecha de creacion',dataIndex: 'modFechaCreacion',width: 150},
		{header: 'Habilitado',dataIndex: 'modHabilitado',width: 150}
            //--    ,{header: 'id',dataIndex: 'modId',width: 40,hidden:true}//hidden:true
                ],
        dataUrl: URL_AGILHU+'pusuario/modulo/listarmodjer',
        tbar: [{text: 'Nuevo',id:'btNuevoMod',disabled:true,tooltip: 'Agregar un modulo',scale:'large',iconCls:'nuevo_mod',handler:agfunAgregarMod},
	       {text: 'Borrar',id:'btBorrarMod',disabled:true,tooltip: 'Borra un modulo',scale:'large',iconCls:'eliminar_mod',handler:agfunConfirDelete}
	      ],
	listeners:{
	        click: function(nodo) {
                        myMask = new Ext.LoadMask(Ext.getCmp('panelDatos').getEl(), {msg:'Cargando...',removeMask: true});
			myMask.show();
			setTimeout('myMask.hide()',200);

			//formularioModulo.getForm().loadRecord(nodo);
			// n.attributes.
			  Ext.getCmp('modNombre').setValue(nodo.attributes.modNombre);
			  Ext.getCmp('modEstado').setValue(nodo.attributes.modEstado);
			  Ext.getCmp('modDescripcion').setValue(nodo.attributes.modDescripcion);
			  Ext.getCmp('modPadreCombo').setValue(nodo.attributes.modPadre);
			  Ext.getCmp('modId').setValue(nodo.attributes.modId);
			 // Ext.getCmp('modHabilitado').setValue(nodo.attributes.modHabilitado);
			  if(nodo.attributes.modHabilitado=='habilitado')
				{
					Ext.getCmp('mod_habilitado').setValue(true);
					Ext.getCmp('mod_deshabilitado').setValue(false);
				}
				else 
				{
					Ext.getCmp('mod_habilitado').setValue(false);
					Ext.getCmp('mod_deshabilitado').setValue(true);
				}

			  Ext.getCmp('btGuardarMod').setText('Actualizar');
			}
	        	
	        }
    });

	formularioModulo = new Ext.FormPanel({
	id: 'formularioModulo',
	url: 'modulo/cargar',
        title:'Modulos',
        closable: true,
        frame:true,
        border:false,
        iconCls:'modulo',
	tabTip :'Aqui puedes ver,crear, eliminar y actualizar los modulos del proyecto',
	autoWidth:true,
	monitorResize : true,
	autoScroll:true,
	layout: 'border',
	height: heightCentro,
	items: [{
		layout: 'border',
		autoScroll:true,
		items: [ModuloGrid,
                        {frame:true, 
                         bodyStyle  :'background-color:white ;',
                         title:'Diagrama organizacional de modulos',
			autoScroll:true,height: 180,
			html: "<div id='moduloGrafico'> </div>",
			region:'south',collapsible: true,
			split: true
			}
                       ],
		region:'center',
		split: true
		},{
		collapsible: true,
		split: true,
		frame:true,
		region:'east',
                width:400,
		xtype:  'panel',
		id:'panelDatos',
		layout:'form',
		title:'Actualizar Datos del Modulo',
		defaults: {xtype:'textfield',anchor:'97%'},
		bodyStyle: Ext.isIE ? 'padding:0 0 15px 15px;' : 'padding:10px 10px;',
		items: [{
				xtype:  'panel',
				height: 30,
				border: false,
				disabled:false,
					items:
					[{xtype: 'label',text:'Los campos marcados con (*) son obligatorios',style: 'font-size:8.5pt; color:#484848;font-weight: bold;'}]
				},
				{fieldLabel: 'Nombre(*)',name: 'modNombre',id: 'modNombre',
                                 emptyText: 'Escriba el nombre del modulo aqui',allowBlank:false,maxLength: 140,msgTarget: 'side',
                                 listeners:{
                                     'render':function(){
                                              new Ext.ToolTip({
						target: (Ext.getCmp('modNombre')).getEl(),
						title: 'Ayuda rapida',
						width:200,
						html: 'Escriba el nombre del modulo que va a crear, o el nombre por el cual va a cambiar el actual',
						trackMouse:true
					    });

                                             }       
                                    }
                                },
				
				new Ext.form.ComboBox({
				        fieldLabel: 'Estado de avance',
				        name:'modEstado',
					id:'modEstado',
				        store: new Ext.data.ArrayStore({
				            fields: ['std'],
				            data : [['iniciado'],['en desarrollo'],['en mantenimiento'],['terminado']]// from states.js
				        }),
				        valueField:'std',
				        displayField:'std',
				        typeAhead: true,
				        mode: 'local',
				        triggerAction: 'all',
				        blankText: 'Aqui el avance del modulo',
				        selectOnFocus:true,
                                        maxLength: 79,
				        width:190
				    }),
                                new Ext.form.ComboBox({
                                    id:'modPadreCombo',
				    name:'modPadre',
				    fieldLabel:'Padre',
				    store:ModuloPadreDataStore,
				    mode:'local',
				    displayField:'modNombre',
				    valueField:'modId',
				    triggerAction:'all',
				    forceSelection:true,
				    hiddenName :'modPadre',
                                    typeAhead: true,
				    selectOnFocus:true,  
				    disabled:false
			        }),
				{
					xtype:      'radiogroup',
					fieldLabel: 'Estado',
					items: 
					[{
					column: '.5',
					items:
						[{boxLabel:'Habilitado',name:'modHabilitado',id:'mod_habilitado',inputValue: 'habilitado',checked:true},//,value:true
						{boxLabel:'Deshabilitado',name:'modHabilitado',id:'mod_deshabilitado',inputValue: 'deshabilitado'}]
					}]
				},
                                {fieldLabel: 'Descripcion',xtype:'label'},
				{hideLabel: true,height: 200,name: 'modDescripcion',id: 'modDescripcion',xtype:'htmleditor'},
				{name: 'modId',id: 'modId',hidden:true}],
		buttons:[
			{text:'Crear',align:'center',disabled:true,id: 'btGuardarMod',scale:'large',
				tooltip:'Pulse para actualizar el proyecto',iconCls:'actualizar_mod',handler:agfunActualizarMod},
		
			]
		}]
	});
				 

/*************************************/
/*Aqui tenemos el manejo de eventos tanto de crear , actualizar, eliminar*/
/*************************************/
	function agfunAgregarMod(formulario,accion)
	{
		  myMask = new Ext.LoadMask(Ext.getCmp('panelDatos').getEl(), {msg:'Cargando...',removeMask: true});
		  myMask.show();
		  setTimeout('myMask.hide()',500);
		  titulo = 'Nuevo modulo';
		  Ext.getCmp('panelDatos').setTitle(titulo);
		  formularioModulo.getForm().reset();
		  
		  Ext.getCmp('btGuardarMod').setText('Crear');
	}

	function agfunActualizarMod(formulario,accion)
	{
	  var verificacion =verificarCamposmodulo();
	  

	  if(verificacion)
	  {
		  
		  if (Ext.getCmp('btGuardarMod').getText() == 'Actualizar')
		  {
			  task = 'UPDATEMOD';
			  Ext.getCmp('modId').setDisabled(false);
		  }
		  else
		  {
			  task = 'CREATEMOD';
		  }
		  formularioModulo.getForm().submit({
		  method: 'POST',
		  url:'modulo/cargar',
		  params: {
		  task: task
		  },
		  waitTitle: 'Enviando',
		  waitMsg: 'Enviando datos...',
		  success: function(response, action)
		  {
			  obj = Ext.util.JSON.decode(action.response.responseText);
			  agaviso(obj.mensaje);
                          ModuloGrid.getRootNode().reload();
			  ModuloPadreDataStore.reload();
			  Ext.getCmp('modId').setDisabled(true);
			  Ext.getCmp('btGuardarMod').setText('Actualizar');
                          drawChartMod();
		  },
		  failure: function(form, action, response)
		  {
			if(action.failureType == 'server'){
				obj = Ext.util.JSON.decode(action.response.responseText); 
				agerror(obj.errors.reason);
				
			}
		  }
		  });
	  }
	}

	function agfunConfirDelete()
	{
               if(Ext.getCmp('modId').getValue()!=''  && Ext.getCmp('modNombre').getValue()!='')
               {
                    Ext.MessageBox.confirm('Confirmacion','Desea borrar este modulo?', agfunBorrarModulo);
               }else {
			Ext.MessageBox.alert('Advertencia','Seleccione un modulo a borrar');
		}
                
	}

	function agfunBorrarModulo(btn){
		if(btn=='yes'){
			identificador=Ext.getCmp('modId').getValue();

			Ext.Ajax.request({  
				waitMsg: 'Por Favor Espere...',
				url:'modulo/cargar',
   				params: { 
					task: "DELETEMOD", 
					idmodulo:  identificador
				}, 
				success: function(response){
				obj = Ext.util.JSON.decode(response.responseText);
					if (obj.success)
					{
						agalerta(obj.mensaje);
						ModuloPadreDataStore.reload();
                                                ModuloGrid.getRootNode().reload();
                                                drawChartMod();
					}
					else if (obj.success == false)
					{
						agerror(obj.errors.reason);
					}
				},
				failure: function(response){
					var result=response.responseText;
					agerror('No se pudo conectar con la base de datos');
				}
			});
		}
	}
	
	
	function verificarCamposmodulo(){
		valido=true;
	
		if(!(Ext.getCmp('modNombre').isValid())) 
	 	{
	 		agalerta('Es necesario llenar el nombre del proyecto');
	 		return false;
	 	}
		
	return valido;
	}
   

/*************************************/
/*Aqui tengo unas funciones para mostrar los mensajes de error y los avisos del sistema*/
/*************************************/
	function agregarBotones(){
		if(tieneRol("administrador") || tieneRol("programador")){
		 Ext.getCmp('btNuevoMod').setDisabled(false);
		 Ext.getCmp('btBorrarMod').setDisabled(false);
		 Ext.getCmp('btGuardarMod').setDisabled(false);
		}
		/*if(tieneRol("cliente")){
		 Ext.getCmp('btNuevoMod').setDisabled(false);
		 Ext.getCmp('btGuardarMod').setDisabled(false);
		}*/
	}
	
	agregarBotones();


//google.setOnLoadCallback(function(){
//existe el riesgo de que no haya nada cuando trate de cargar esto
function drawChartMod() {

       Ext.Ajax.request({
		      waitMsg: 'Por Favor Espere...',
		      url: 'modulo/cargar',
		      method: 'GET',
		      params: {
                       task:'LISTINGGRAFICO'
		      },
		      success: function(response)
		      {
                            var jsonDecode = Ext.util.JSON.decode(response.responseText);
		            var dataMod=jsonDecode.data;
                           
			      ///Grafico de mosulos
                                var data = new google.visualization.DataTable();
				data.addColumn('string', 'Name');
				data.addColumn('string', 'Manager');
				data.addColumn('string', 'ToolTip');
                             
                                data.addRows(dataMod);
				var chart = new google.visualization.OrgChart(document.getElementById('moduloGrafico'));
				chart.draw(data, {allowHtml:true});
		      },
		      failure: function(action, response)
		      {
			    var result=response.responseText;
			    if(action.failureType == 'server')
			    { 
			    agerror('No se pudo conectar con la base de datos');
			    }
		      }
		    });
}
drawChartMod();
// });


return formularioModulo;
	
  
}




 


