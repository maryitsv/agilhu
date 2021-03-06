
var agGestionUsuario = function () 
{

  Ext.QuickTips.init();

	var UsuariosDataStore;
	var UsuariosColumnModel;
	var UsuariosListingGrid;
	var UsuariosListingWindow;
      

	UsuariosDataStore = new Ext.data.JsonStore({	
		id: 'UsuariosDataStore',
		url:'gesUsuarios/cargar',
		root: 'results',
		baseParams:{task:'LISTING'},
		totalProperty: 'total',
		reader:new Ext.data.JsonReader({
			root:'results',
			totalProperty:'total',
			id:'id'}),
		fields:[
			{name: 'usuId', type: 'int'},
			{name: 'usuNombres', type: 'string'},
			{name: 'usuApellidos', type: 'string'},
			{name: 'usuUsuario', type: 'string'},
			{name: 'usuClave', type: 'string'},
			{name: 'usuCorreo', type: 'string'},
			{name: 'usuRolId', type: 'string'},
			{name: 'usuEstado', type: 'string'}
		],
		sortInfo:{field: 'usuCorreo', direction: 'ASC'}	
	});
	UsuariosDataStore.load({params: {start: 0, limit: 10}});


    function imagenEstado(val){
	if(val=='habilitado')
	{
	 return '<img src="../images/iconos/usuario/h.png" >';
	}
	else
	{ 
	 return '<img src="../images/iconos/usuario/d.png" >';
	}
    }
  
	UsuariosColumnModel = new Ext.grid.ColumnModel({
	columns:[{
		header: 'id',dataIndex: 'usuId',width: 60},{
		header: 'Nombres',dataIndex: 'usuNombres',width: 100},{
		header: 'Apellidos',dataIndex: 'usuApellidos',width: 100},{
		header: 'Correo',dataIndex: 'usuCorreo',width: 150},{
		header: 'Estado',dataIndex: 'usuEstado',width: 50,renderer:imagenEstado}
	],
	defaults:{sortable:true}});
	
	UsuariosColumnModel.defaultSortable= true;

	UsuariosListingGrid =  new Ext.grid.GridPanel({
		id: 'UsuariosListingGrid',
		store: UsuariosDataStore,
		cm: UsuariosColumnModel,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false})
	});

	UsuariosListingWindow = new Ext.Panel({
		id: 'UsuariosListingWindow',
		title: 'Informacion de Usuarios',
		closable:true,
		width:400,
		height:390,
		plain:true,
		layout:'fit',
		frame: true,
		items: UsuariosListingGrid
	});

	var RolesDataStore = new Ext.data.JsonStore({
		id: 'RolesDataStore',
		url:'gesUsuarios/cargar',
		root: 'results',
		baseParams:{task:'LISTINGROL'},
		totalProperty: 'total',
		fields:[
			{name: 'rolId', type: 'string'},
			{name: 'rolNombre', type: 'string'},
		],
		sortInfo:{field: 'rolId', direction: 'ASC'}
	});
	RolesDataStore.load();


  
	var formularioUsuario = new Ext.FormPanel({
	id: 'formUsuario',
	url: 'gesUsuarios/cargar',
	frame: true,
	labelAlign: 'left',
	title: 'Gestion De Usuarios',
        iconCls:'usuarios',
	bodyStyle:'padding:5px',
	width: 1200,
	height: 500,
	autoScroll:true,
	layout: 'column',
	items: [{
		columnWidth: 0.5,
		layout: 'fit',
		autoScroll:true,
		items: {
			xtype: 'grid',
			id:	'listaUsuarios',
			stripeRows:true,
			bbar: new Ext.PagingToolbar({
				pageSize: 10,
				store: UsuariosDataStore,
				displayInfo: true,
				displayMsg: 'Usuarios {0} - {1} de {2}',
				emptyMsg: "No hay Usuarios"
			}),
			ds: UsuariosDataStore,
			cm: UsuariosColumnModel,
			sm: new Ext.grid.RowSelectionModel({
				singleSelect: true,
				listeners: {
				rowselect: function(sm, row, rec) {
				//
				//myMask = new Ext.LoadMask(formularioUsuario.getEl(), {msg:'Cargando...',removeMask: true});
				//myMask.show();
				//setTimeout('myMask.hide()',400);

				formularioUsuario.getForm().loadRecord(rec);
				nombreU = Ext.getCmp('usuNombres').getValue();
				titulo = 'Actualizar Datos de '+nombreU;
				Ext.getCmp('btGuardar').setText('Actualizar');
				Ext.getCmp('panelDatos').setTitle(titulo);
				Ext.getCmp('usuNombres').setDisabled(false);
				Ext.getCmp('usuApellidos').setDisabled(false);
				Ext.getCmp('usuUsuario').setDisabled(true);
			        Ext.getCmp('usuCorreo').setDisabled(false);
				
				Ext.getCmp('usuClave').setDisabled(false);
				Ext.getCmp('usuReclave').setDisabled(false);
				Ext.getCmp('usuReclave').setValue(rec.get('usuClave'));
				Ext.getCmp('rolUsuario').setDisabled(false);
				Ext.getCmp('rolUsuario').setValue(rec.get('usuRolId'));

				Ext.getCmp('usu_habilitado').setDisabled(false);
				Ext.getCmp('usu_deshabilitado').setDisabled(false);

				if(rec.get('usuEstado')=='habilitado')
				{
					Ext.getCmp('usu_habilitado').setValue(true);
					Ext.getCmp('usu_deshabilitado').setValue(false);
				}
				else 
				{
					Ext.getCmp('usu_habilitado').setValue(false);
					Ext.getCmp('usu_deshabilitado').setValue(true);
				}
				
			}
			}
		}),
		height: 400,
		title:'Lista De Usuarios',
		border: true,
		        listeners: {
		        	render: function(g) {
		        		g.getSelectionModel().selectRow(0);
		        	},
		        	delay: 10
		        },
			tbar: [{
				text: 'Nuevo',scale:'large',tooltip: 'Agregar un usuario',iconCls:'add_usu',handler:agfunAgregarUsu},{
				text: 'Borrar',scale:'large',tooltip: 'Borra un usuario',iconCls:'eli_usu',handler:agfunConfirDelete}],
			plugins:[new Ext.ux.grid.Search({
				mode:          'local',
				position:      top,
				searchText:    'Filtrar',
				iconCls:  'filtrar',
				selectAllText: 'Seleccionar todos',
				searchTipText: 'Escriba el texto que desea buscar y presione la tecla enter',
				width:         100
			})
			]
		}
        },{
		columnWidth: 0.5,
		xtype:  'panel',
		id:'panelDatos',
		title:'Actualizar Datos del Usuario',
		defaultType: 'textfield',
		layout: 'column',
		bodyStyle: Ext.isIE ? 'padding:0 0 15px 15px;' : 'padding:10px 15px;',
		border: true,
		style: {
			"margin-left": "10px", 
			"margin-right": Ext.isIE6 ? (Ext.isStrict ? "-10px" : "-13px") : "0"  
		},
		items: [{
			columnWidth: 0.6,
			xtype: 'fieldset',
			labelWidth: 80,
			title:'Informacion Personal',
			defaultType: 'textfield',
			autoHeight : true,
			autoWidth : true,
			bodyStyle: Ext.isIE ? 'padding:0 0 24px 15px;' : 'padding:24px 15px;',
			border: true,
			defaults:{width: 140,disabled:true,allowBlank:false},
			items: [{
				xtype:  'panel',
				height: 30,width: 220,
				border: false,			
				disabled:false,
				items:
				[{xtype: 'label',text:'Todos los campos son obligatorios',style: 'font-size:8.5pt; color:#484848;font-weight: bold;'}]},
				{fieldLabel: 'Nombres',name: 'usuNombres',id: 'usuNombres',blankText: 'El Nombre es obligatorio'},
				{fieldLabel: 'Apellidos',name: 'usuApellidos',id: 'usuApellidos',blankText: 'El Apellido es obligatorio'},
				{fieldLabel: 'Correo',name: 'usuCorreo',id: 'usuCorreo',vtype:  'email',minLength : 5,maxLength : 30,blankText: 'El Correo es obligatorio'}
			]},{
			columnWidth: 0.4,
			xtype: 'fieldset',
			labelWidth: 90,
			title:'Detalles del Sistema',
			defaultType: 'textfield',
			autoHeight : true,
			autoWidth : true,
			bodyStyle: Ext.isIE ? 'padding:0 0 15px 15px;' : 'padding:15px 15px;',
			border: true,
			style: {
				"margin-left": "10px", 
				"margin-right": Ext.isIE6 ? (Ext.isStrict ? "-10px" : "-13px") : "0"  
			},
			defaults:{allowBlank:false,disabled:true,width: 140},
			items: [{
				xtype:  'panel',
				height: 30,
				border: false,
				disabled:false,
				hideMode :'visibility',
				width: 220,
				items:
				[{xtype: 'label',text:'Todos los campos son obligatorios',style: 'font-size:8.5pt; color:#484848;font-weight: bold;'}]
				},{
				fieldLabel: 'Id',name: 'usuId',id: 'usuId'},{
				fieldLabel: 'Usuario',name: 'usuUsuario',id: 'usuUsuario',blankText: 'El Login es obligatorio'},{
				fieldLabel: 'Clave',name: 'usuClave',id: 'usuClave',inputType:'password',blankText: 'La Clave es obligatoria y debe tener minimo 8 digitos'},{
				fieldLabel: 'ReClave',name: 'usuReclave',id: 'usuReclave',initialPassField: 'usuReclave',
				inputType:'password',blankText: 'La ReContraseña es obligatoria'},{
				xtype: 'combo',store: RolesDataStore,hiddenName :'rolUsuario',name: 'rolUsuario',id: 'rolUsuario',mode:'local', displayField: 'rolNombre',triggerAction: 'all',emptyText: 'Selecione....',selectOnFocus: true,fieldLabel: 'Rol Usuario',valueField:'rolId',hiddenName : 'rolId'
				},{
					xtype: 'panel',
					disabled:false,
					layout: 'form',
					width: 220,
					id:    'radios_estado',
					items:
					[{
						xtype:      'radiogroup',
						fieldLabel: 'Estado',
						items: 
						[{
						column: '.5',
						items:
							[{disabled:true,boxLabel:'Habilitado',name:'usuEstado',id:'usu_habilitado',inputValue: 'habilitado'},
							{disabled:true,boxLabel:'Deshabilitado',name:'usuEstado',id:'usu_deshabilitado',inputValue: 'deshabilitado'}]
						}]
					}]
				}]
		}],
                buttons:[
			{text:'Actualizar',align:'center',id: 'btGuardar',formBind: true,iconCls:'edit_usu',scale:'large',handler:agfunActualizarUsu},
			]

		}],
		//renderTo: 'formularioUsuario'
	});

/*************************************/
/*Aqui tenemos el manejo de eventos tanto de crear , actualizar, eliminar*/
/*************************************/
	function agfunAgregarUsu(formulario,accion)
	{
		  myMask = new Ext.LoadMask(formularioUsuario.getEl(), {msg:'Cargando...',removeMask: true});
		  myMask.show();
		  setTimeout('myMask.hide()',500);
		  titulo = 'Nuevo Usuario';
		  Ext.getCmp('panelDatos').setTitle(titulo);
		  formularioUsuario.getForm().reset();
		  Ext.getCmp('usuNombres').setDisabled(false);
		  Ext.getCmp('usuApellidos').setDisabled(false);
		  Ext.getCmp('usuCorreo').setDisabled(false);
		  Ext.getCmp('usuUsuario').setDisabled(false);
		  Ext.getCmp('usuClave').setDisabled(false);
		  Ext.getCmp('usuReclave').setDisabled(false);
		  Ext.getCmp('rolUsuario').setDisabled(false);
		  
		//manejo de estado por defecto
		  Ext.getCmp('usu_habilitado').setDisabled(false);
	  	  Ext.getCmp('usu_deshabilitado').setDisabled(false);
		  Ext.getCmp('usu_habilitado').setValue(true);
		  Ext.getCmp('usu_deshabilitado').setValue(false);
		  Ext.getCmp('btGuardar').setText('Crear');
	}

	function agfunActualizarUsu(formulario,accion)
	{
	  var verificacion =verificarCamposUsuario();
	  
	  /*var estado=false;
	  if(Ext.getCmp('usu_habilitado'))
	  {estado=true;}*/

	  if(verificacion)
	  {
		  var contrasenaEncrypt = '';
		  if(Ext.getCmp('usuClave').getValue() != ''){
		  contrasenaEncrypt =Ext.getCmp('usuClave').getValue();
		   //hex_md5(Ext.getCmp('usuClave').getValue());
		  }
		  
		  if (Ext.getCmp('btGuardar').getText() == 'Actualizar')
		  {
			  task = 'UPDATEUSU';
			  Ext.getCmp('usuId').setDisabled(false);
			  Ext.getCmp('usuUsuario').setDisabled(false);

		  }
		  else
		  {
			  task = 'CREATEUSU';
		  }
		  formularioUsuario.getForm().submit({
		  method: 'POST',
		  url:'gesUsuarios/cargar',
		  params: {
		  task: task,
		  claveEncritada:contrasenaEncrypt
		  },
		  waitTitle: 'Enviando',
		  waitMsg: 'Enviando datos...',
		  success: function(response, action)
		  {
			  obj = Ext.util.JSON.decode(action.response.responseText);
			  agMensajeAviso(obj.mensaje);
			  UsuariosDataStore.reload();
			  Ext.getCmp('usuId').setDisabled(true);
			  Ext.getCmp('usuUsuario').setDisabled(true);
		  },
		  failure: function(form, action, response)
		  {
			if(action.failureType == 'server'){
				obj = Ext.util.JSON.decode(action.response.responseText); 
				agMensajeError(obj.errors.reason);
				
			}
			else if (Ext.getCmp('usuCorreo').getRawValue()) {
			agMensajeError('No se pudo conectar con la base de datos');
			}
			Ext.getCmp('usuClave').setDisabled(false);
			Ext.getCmp('usuReclave').setDisabled(false);
		  }
		  });
	  }
	}

	function agfunConfirDelete()
	{
		if(UsuariosListingGrid.selModel.getCount() != 1)
		{
			Ext.MessageBox.confirm('Confirmacion','Desea borrar este Usuario?', agfunBorrarUsuario);
		} else if(UsuariosListingGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmacion','Borrar estos Usuarios?', agfunBorrarUsuario);
		} else {
			Ext.MessageBox.alert('Advertencia','Usted no puede borrar un elemento que no ha sido seleccionado');
		}
	}

	function agfunBorrarUsuario(btn){
		if(btn=='yes'){
			var selections = UsuariosListingGrid.selModel.getSelections();
			var prez = [];
			fila=Ext.getCmp('listaUsuarios').selModel.getSelected();
			identificador=fila.get('usuId');
			prez.push(identificador);
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({  
				waitMsg: 'Por Favor Espere...',
				url:'gesUsuarios/cargar',
   				params: { 
					task: "DELETEUSU", 
					idusuario:  encoded_array
				}, 
				success: function(response){
				obj = Ext.util.JSON.decode(response.responseText);
					if (obj.success)
					{
						agMensajeAviso(obj.mensaje);
						UsuariosDataStore.reload();
					}
					else if (obj.success == false)
					{
						agMensajeAviso(obj.errors.reason);
					}
				},
				failure: function(response){
					var result=response.responseText;
					agMensajeError('No se pudo conectar con la base de datos');
				}
			});
		}
	}
	
	
	
	
	function verificarCamposUsuario(){
		valido=true;
	
	
		if(!(Ext.getCmp('usuNombres').isValid() &&
		     Ext.getCmp('usuApellidos').isValid() &&
		     Ext.getCmp('usuCorreo').isValid() &&
		     Ext.getCmp('usuUsuario').isValid()  && 
		     Ext.getCmp('usuClave').isValid() )) 
	 	{
	 		agMensajeAviso('faltan campos por llenar');
	 		return false;
	 	}
		
		if(!(Ext.getCmp('usuClave').getValue() == Ext.getCmp('usuReclave').getValue())) 
	 	{agMensajeError('la clave y la reclave deben ser iguales');
	 	return false;}
		
		
		if((Ext.getCmp('usuClave').getValue()).length < 8) 
	 	{
	 	agMensajeError('la clave debe tener minimo 8 digitos');
	 	return false;
	 	}
	 	
	return valido;
	}
   

/*************************************/
/*Aqui tengo unas funciones para mostrar los mensajes de error y los avisos del sistema*/
/*************************************/

	function agMensajeError(mensaje)
	{
	  Ext.Msg.show({title:'Error',msg: mensaje,buttons: Ext.Msg.OK,animEl: 'elId',icon: Ext.MessageBox.ERROR});
	}

	function agMensajeAviso(mensaje)
	{
	  Ext.Msg.show({title:'Alerta!',msg: mensaje,buttons: Ext.Msg.OK,animEl: 'elId',icon: Ext.MessageBox.INFO});
	}

return formularioUsuario; 
}
//}}();

