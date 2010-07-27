

var Proyecto = function () 
{

/********************************CREAR PROYECTO***********************************************/	
var formatoFecha='d-m-Y';

function  VentanaCrearProyecto(){

	var proConocidosDataStore=new Ext.data.JsonStore({
			url: 'proyecto/cargar',
			baseParams:{task: 'CONTACTOS'},
            autoLoad:true,
            idProperty:'id',
			root: 'results',
			fields:['usu_usuario'] 
    });
	
	var adminConocidosDataStore=new Ext.data.JsonStore({
			url: 'proyecto/cargar',
			baseParams:{ task: 'CONTACTOS'},
            autoLoad:true,
            idProperty:'id',
			root: 'results',
			fields:['usu_usuario'] 
    });
	
	var testConocidosDataStore=new Ext.data.JsonStore({
			url: 'proyecto/cargar',
			baseParams:{task: 'CONTACTOS'},
            autoLoad:true,
            idProperty:'id',
			root: 'results',
			fields:['usu_usuario'] 
    });
	
	var cliConocidosDataStore=new Ext.data.JsonStore({
			url: 'proyecto/cargar',
			baseParams:{task: 'CONTACTOS'},
            autoLoad:true,
            idProperty:'id',
			root: 'results',
			fields:['usu_usuario'] 
    });

    var agCreaProy=new Ext.FormPanel({
    layout:'column',
    id:'agCreaProy',
    buttonAlign:'center',
    name:'agCreaProy',
    url:'proyecto/cargar',
    frame:true,	
    fileUpload: true,
    items:[
          {
            layout:'form',
            columnWidth:'50%',
            iconCls:'nuevopro',
            fileUpload: true,
            title: 'Datos del Proyecto',
            labelWidth :100,
            bodyStyle:'padding:15px',
            defaults:{xtype: 'textfield',anchor:'100%'},
            items:[{
		   xtype:  'panel',
		   height: 30,
		   border: false,
		   disabled:false,
		   items:
		   [{xtype: 'label',text:'Los campos marcados con (*) son obligatorios',style: 'font-size:8.5pt; color:#484848;font-weight: bold;'}]
                   },
                   {id:'agPro_nombre',name:'agPro_nombre',fieldLabel:'Nombre(*)',
                     blankText:'Digite el nombre del proyecto',allowBlank:false,maxLength: 300},
                   {id:'agPro_nomcorto',name:'agPro_nomcorto',fieldLabel:'Nombre corto(*)',
                     blankText:'Digite un nombre corto, o siglas del proyecto',allowBlank:false,maxLength: 80},
                   {id:'agPro_areapli',name:'agPro_areapli',fieldLabel:'Area de aplicacion',xtype:'combo',
                     blankText:'Escoja el area de aplicacion del proyecto',typeAhead: true,triggerAction: 'all', lazyRender:true,mode: 'local',
                     store: new Ext.data.ArrayStore({
                            id: 0,
                            fields: ['area'],
                            data: [['cientifico'],['informatico'],['social'],['deporte'],['educativo'],['comercial'],['otro']]}),
                     valueField: 'area',displayField: 'area'},
                   {id:'agPro_fecini',name:'agPro_fecini',fieldLabel:'Fecha inicio',xtype: 'datefield',format:formatoFecha,
                     blankText:'Escoja la fecha de inicio del proyecto'} ,
                   {id:'agPro_fecfin',name:'agPro_fecfin',fieldLabel:'Fecha fin',xtype: 'datefield',format:formatoFecha,
                     blankText: 'Escoja la fecha de fin del proyecto'},
                   {xtype: 'fileuploadfield', id: 'agPro_logo', emptyText: 'Seleccione una imagen', fieldLabel: 'Logo',
                     name: 'agPro_logo',
                     width: 100,
                     buttonText: '',
                     buttonCfg: {iconCls: 'archivo'}
                   }//cargar logo
                  ]
         },
         {
           iconCls:'participantes',
           title:'Participantes',
           layout:'form',
           labelWidth :90,
           columnWidth:'50%',
           width:330,
           bodyStyle:'padding:15px',
           defaults:{xtype: 'textfield',anchor:'100%',mode:'local'},
           items:[
                 {
                  xtype:'panel',height: 50,width: 278,border:false,
                  items:
                    [{
                     xtype: 'label', 
                     text:'Use el nombre de usuario de sus amigos para invitarlos a participar en este proyecto, separelos por (,) . Ejemplo:juanita,pedrito,andreita',
                     style: 'font-size:8.5pt; color:#484848;font-weight: bold;'
                    }]
                 },
                 /*{id:'agPro_administrador',name:'agPro_administrador',fieldLabel:'Administrador'},
                 {id:'agPro_programador',name:'agPro_programador',fieldLabel:'Programador'},
                 {id:'agPro_tester',name:'agPro_tester',fieldLabel:'Tester'},
                 {id:'agPro_cliente',name:'agPro_cliente',fieldLabel:'Cliente'}*/
				 new Ext.ux.form.LovCombo({
				        id:'agPro_administrador',
                        fieldLabel:'Administrador',//Un string con los usuarios responsables
						name:'agPro_administrador',
					    store:adminConocidosDataStore,
				        valueField:'usu_usuario',
				        displayField:'usu_usuario',
				}),
				new Ext.ux.form.LovCombo({
				        id:'agPro_programador',
                        fieldLabel:'Programador',//Un string con los usuarios responsables
						name:'agPro_programador',
					    store:proConocidosDataStore,
				        valueField:'usu_usuario',
				        displayField:'usu_usuario',
				}),
				new Ext.ux.form.LovCombo({
				        id:'agPro_tester',
                        fieldLabel:'Tester',//Un string con los usuarios responsables
						name:'agPro_tester',
					    store:testConocidosDataStore,
				        valueField:'usu_usuario',
				        displayField:'usu_usuario',
				}),
				 new Ext.ux.form.LovCombo({
				        id:'agPro_cliente',
                        fieldLabel:'Cliente',//Un string con los usuarios responsables
						name:'agPro_cliente',
					    store:cliConocidosDataStore,
				        valueField:'usu_usuario',
				        displayField:'usu_usuario',
				})
                 ]
         },
         {  
           xtype:'panel',
           layout:'form',
           activeTab: 0,
           border:true,
           deferredRender: false,
           height:160,width:640,
           bodyStyle: Ext.isIE ? 'padding:0 0 15px 15px;' : 'padding:0 0 0 15px;',
           labelAlign:'top',
           items:[
                 {id:'agPro_descripcion',fieldLabel:'Haga una breve descripci&oacute;n del proyecto (*)',name:'agPro_descripcion',xtype: 'htmleditor',
                  enableFont :false,enableSourceEdit :false,anchor:'100%',height:140,autoScroll:true
                 }
                 ]
         }
         ],
    buttons:[{text:'Crear',handler: crearProyecto},
             {text:'Cancelar',handler: function(){agCreaProyWindow.close();}}
            ]   
    });
					
					
		/***************************************************FUNCIONES******************************************/
     function verificarCamposProyectoCrear(){
	valido=true;
	if(!(Ext.getCmp('agPro_nombre').isValid())) 
         {
           agalerta('Es necesario llenar el nombre del proyecto de manera correcta');
           return false;
         }

          if(!(Ext.getCmp('agPro_nomcorto').isValid())) 
         {
           agalerta('Es necesario llenar el nombre corto del proyecto de manera correcta');
           return false;
         }	
		
	  if(Ext.getCmp('agPro_descripcion').getValue()=='') 
         {
           agalerta('Es necesario hacer una breve descripción del proyecto');
           return false;
         }	
	
	return valido;
	}
   
     function crearProyecto(){
     //validamos antes de enviar
     var verificacion=verificarCamposProyectoCrear();
     agCreaProy.getForm().isValid();

     if(verificacion){
       (agCreaProy.getForm()).submit({
                    waitTitle: 'Enviando',
                    waitMsg: 'Por Favor Espere...',
                    //scope:this,
                    url:URL_AGILHU+'pusuario.php/proyecto/cargar',
                    params: { 
                              task: 'CREATEPROY'
                    }, 
                    success: function(response, action)
                    {
				
                    //  agCreaProy.getForm().reset();
					
                      obj = Ext.util.JSON.decode(action.response.responseText);
                      if(obj.success)
                      {
                    	  agaviso(obj.mensaje); 
			  agCreaProyWindow.close();
			  dataStoreProyecto.reload();
			  //si existe la lista de proyectos recarge
                          if(Ext.getCmp('dataStoreListaProyectos')!='undefined') 
			  {dataStoreListaProyectos.reload();}
                      }
                     
                      if (obj.success == false)
                      {
                          agerror(obj.errors.reason); 
                      }
                    },
                    failure: function(form, response)
                    {
                       var result=response.responseText;
                       agerror(result);                    
                    }
          });
      }
     }
 		
     var agCreaProyWindow = new Ext.Window({
          title: 'Crear proyecto',
          id:'agCreaProyWindow',
          width:720,
          height:520,
          plain:true,
          layout: 'fit',
          modal :true,
          items: agCreaProy
        });

     agCreaProyWindow.show();
  
}//termina la funcion crear proyecto
		/*************************************************LISTAR PROYECTO**************************************/
		

    //creamos el data estore cargando desde la base de datos
    dataStoreProyecto = new Ext.data.GroupingStore({
        id: 'proyectoDataStore',
        proxy: new Ext.data.HttpProxy({
                url: 'proyecto/cargar', 
                method: 'POST'
        }),
        baseParams:{task: 'LISTARPROY'}, // this parameter is passed for any HTTP request
        reader: new Ext.data.JsonReader({
                root: 'results',
                totalProperty: 'total',
                id: 'id'
                },[ 
                  {name: 'proid', type: 'int'},	    
                  {name: 'prosigla', type: 'string'},
                  {name: 'pronom', type: 'string'},
                  {name: 'proareaaplicacion', type: 'string'},
                  {name: 'prodescripcion', type: 'string'},
                  {name: 'profechaini', type: 'string'},
                  {name: 'profechafin', type: 'string'},
                  {name: 'proestado', type: 'string'},
                  {name: 'prologo', type: 'string'}
        ]),
        sortInfo:{field: 'profechaini', direction: "ASC"}//,
     //   groupField:'proareaaplicacion'
    });
    

    function ponerimagen(val){
	if(val!='0')
	{
	 return '<img src='+URL_AGILHU+'/pusuario.php/documentos/cargar?task=DESCARGAR&Identificador='+val+' width=35 heigth=35 >';
	}
	else
	{ 
	 return '<img src="../images/projecto-logo-default.png" width=35 heigth=35 >';
	}
    }

    var colModel;
    colModel = new Ext.grid.ColumnModel({
    defaults:{sortable: true, locked:false},
    columns:[
		{ header: "Logo", width: 110, dataIndex: 'prologo',renderer:ponerimagen},
		{id:'pro_pronom', header: "Nombre", width: 140, dataIndex: 'pronom'},
		{ header: "Fecha Inicio", width: 120,  dataIndex: 'profechaini'},
		{ header: "Fecha Fin", width: 120, dataIndex: 'profechafin'},
		{ header: "Area", width: 100, dataIndex: 'proareaaplicacion'},
		{ header: "Estado", width: 100, dataIndex: 'proestado'}		
    	]
    });

    dataStoreProyecto.load();
    
    
    var listaProyectosGrid = new Ext.grid.GridPanel({
        region:'center',
        frame:true,
        id: 'listaproyectos',
        stripeRows:true,
	store: dataStoreProyecto,
        cm: colModel,
        title:'Mis Proyectos',
        height: heightCentro,
	border:true,
        selModel: new Ext.grid.RowSelectionModel({
             singleSelect: true,
             listeners: {
                rowselect: function(sm, row, rec) {
                          myMask = new Ext.LoadMask(agFormProyectoG.getEl(), {msg:'Cargando...',removeMask: true});
                          myMask.show();
                          setTimeout('myMask.hide()',200);

                           (Ext.getCmp('formularioProyecto').getForm()).loadRecord(rec);
                           }
             }
        }),    
       
     	bbar: new Ext.PagingToolbar({
     	     	pageSize: 12,
     	     	store: dataStoreProyecto,
     	     	displayInfo: true,
     	     	displayMsg: 'Proyectos {0} - {1} de {2}',
     	     	emptyMsg: "No hay Modulos"
		}),
	   
    	tbar:[
	    	{text:'Nuevo',iconCls:'nuevo_proyecto',scale:'large',tooltip:'Pulse para crear un nuevo proyecto',
			handler:function(){VentanaCrearProyecto();}
			}],
	listeners: {
		        render: function(g) {
		        	g.getSelectionModel().selectRow(0);
		        },
                       rowdblclick :function(grid, row, ev)
		        {
                          var sm=grid.getSelectionModel() ;
			  fila=sm.getSelected();
			  sigla=fila.data.prosigla;
                          selectionProyecto(sm, row,fila );
			},
		  //     delay: 10
                  },
       	plugins:[new Ext.ux.grid.Search({
				mode:          'local',
				position:      top,
				searchText:    'Filtrar',
				iconCls:  'filtrar',
				selectAllText: 'Seleccionar todos',
				searchTipText: 'Escriba el texto que desea buscar y presione la tecla enter',
				width:         100
			})],
	view: new Ext.grid.GroupingView(),
	autoExpandColumn :'pro_pronom'
    });
	


    var agFormProyectoG=new Ext.Panel({
          id:'agFormProyectoG',
          region:'east',
          frame:true,
          split:true,
          title:'Datos del proyecto',
          columnWidth:0.4,
          collapsible: true,
          layout:'form',
          width:400,
          defaults: {xtype:'textfield',anchor:'100%'},
          bodyStyle: Ext.isIE ? 'padding:0 0 15px 15px;' : 'padding:10px 15px;',
          border: true,
          items:[
                {/*fieldLabel: 'Id',*/name: 'proid',hidden:true},
                {
		   xtype:  'panel',
		   height: 30,
		   border: false,
		   disabled:false,
		   items:
		   [{xtype: 'label',text:'Los campos marcados con (*) son obligatorios',style: 'font-size:8.5pt; color:#484848;font-weight: bold;'}]
                   },
                {fieldLabel: 'Nombre corto(*)',name: 'prosigla',id:'formulario_prosigla',maxLength: 80,allowBlank: false,
                  blankText: 'Escriba un nombre corto o sigla para su proyecto'},			
                {fieldLabel: 'Nombre(*)',name: 'pronom',id:'formulario_pronombre',maxLength: 300,allowBlank: false,
                  blankText: 'Escriba el nombre de su proyecto'},
                {name:'proareaaplicacion',fieldLabel:'Area ',xtype:'combo',
                    blankText:'Escoja el area de aplicación del proyecto',
                    typeAhead: true,triggerAction: 'all', lazyRender:true,mode: 'local',
                    store: new Ext.data.ArrayStore({
                	id: 0,
                        fields: ['area'],
                        data: [['cientifico'],['informatico'],['social'],['deporte'],['educativo'],['comercial'],['otro']]}),
                    valueField: 'area',displayField: 'area'
                },
                {xtype: 'datefield',fieldLabel: 'Fecha inicio',name: 'profechaini',format:formatoFecha},
                {xtype: 'datefield',fieldLabel: 'Fecha fin',name: 'profechafin',format:formatoFecha},            
                {name:'proestado',fieldLabel:'Estado de avance',xtype:'combo',
                    blankText:'Escoja el estado del proyecto',maxLength: 50,
                    typeAhead: true,triggerAction: 'all', lazyRender:true,mode: 'local',
                    store: new Ext.data.ArrayStore({
                	id: 0,
                        fields: ['estado'],
                        data: [['creado'],['en proceso'],['terminado'],['otro']]
                    	}),
                     valueField: 'estado',displayField: 'estado'

                },
                {   
                  xtype:'panel',
                  layout:'form',
                  autoScroll:true,
                  deferredRender: false,
                  height:250,
                  anchor:'100%',
                  labelAlign:'top',
                  items:[{
                          id:'formulario_prodescripcion',anchor:'95%',fieldLabel:'Breve descripci&oacute;n del proyecto(*)',name:'prodescripcion',xtype: 'htmleditor',
		           blankText:'Digite una breve descripcion del proyecto',autoScroll:true,height:195
                         
                	 }
                        ]
                }
        ],
        buttons:[{text:'Actualizar',iconCls:'actualizar_proyecto',scale:'large',
                   tooltip:'Pulse para actualizar los datos del proyecto',handler:actualizarPro},   
                 {text:'Cancelar',iconCls:'eliminar_proyecto',scale:'large',
                   tooltip:'Pulse para cancelar el proyecto',handler:confirDeletePro}]	
     });



    var formularioProyecto = new Ext.FormPanel({
      id: 'formularioProyecto',
      url: 'proyecto/cargar',
      autoWidth:true,
      height:heightCentro,
      title:'Mis Proyectos',
        closable: true,
        frame:true,
        border:false,
        iconCls:'mis_proyecto',
	tabTip :'Aqui puedes ver,crear y actualizar proyectos que tu hays creado',
	autoWidth:true,
	monitorResize : true,
	
      autoScroll:true,
      layout: 'border',
      items: [
         listaProyectosGrid,
         agFormProyectoG
      ],
    //  renderTo: 'formularioPro'
   });

    
  
		/*****************************************FUNCIONES******************************************/

         

	function actualizarPro(formulario,accion)
	{
	  var verificacion =verificarCamposProyecto();
	  
	  if(verificacion)
	  {
		  
		  formularioProyecto.getForm().submit({
		  method: 'POST',
		  url:'proyecto/cargar',
		  params: {
		  task: 'UPDATEPROY'
		  },
		  waitTitle: 'Enviando',
		  waitMsg: 'Enviando datos...',
		  success: function(response, action)
		  {
			  obj = Ext.util.JSON.decode(action.response.responseText);
			  agalerta(obj.mensaje);
			  dataStoreProyecto.reload();
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

	function confirDeletePro()
	{
		if(listaProyectosGrid.selModel.getCount() == 1)
		{
			Ext.MessageBox.confirm('Confirmacion','Desea borrar este proyecto?', borrarProyecto);
		} else if(listaProyectosGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmacion','Borrar estos Proyectos?', borrarProyecto);
		} else {
			Ext.MessageBox.alert('Advertencia','Usted no puede borrar un elemento que no ha sido seleccionado');
		}
	}

	function borrarProyecto(btn){
		if(btn=='yes'){
			var selections = listaProyectosGrid.selModel.getSelections();
			var prez = [];
			fila=listaProyectosGrid.selModel.getSelected();
			identificador=fila.get('proid');
			prez.push(identificador);
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({  
				waitMsg: 'Por Favor Espere...',
				url:'proyecto/cargar',
   				params: { 
					task: "DELETEPROY", 
					idproyecto:  encoded_array
				}, 
				success: function(response){
				obj = Ext.util.JSON.decode(response.responseText);
					if (obj.success)
					{
						agalerta(obj.mensaje);
						dataStoreProyecto.reload();
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
	
	
	function verificarCamposProyecto(){
	valido=true;
	
		if(!(Ext.getCmp('formulario_pronombre').isValid())) 
	 	{
	 		agalerta('Es necesario llenar el nombre del proyecto');
	 		return false;
	 	}
		if(!(Ext.getCmp('formulario_prosigla').isValid())) 
	 	{
	 		agalerta('Es necesario llenar el nombre corto del proyecto');
	 		return false;
	 	}


		if(Ext.getCmp('formulario_prodescripcion').getValue()=='') 
	 	{
	 		agalerta('Es necesario hacer una breve descripcion del proyecto');
	 		return false;
	 	}
	return valido;
	}
         
         
         
		ponEstilo();
return formularioProyecto;
}//hata aqui las llaves obligatorias 
	
