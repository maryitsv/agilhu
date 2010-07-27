	
	
var Participante = function () 
{

  Ext.QuickTips.init();

	var ParticipanteDataStore;
	var ParticipanteColumnModel;
      

	ParticipanteDataStore = new Ext.data.JsonStore({	
		id: 'ParticipanteDataStore',
		url:'participante/cargar',
		root: 'results',
		baseParams:{task:'LISTARPARTICIPANTES'},
		totalProperty: 'total',
		reader:new Ext.data.JsonReader({
			root:'results',
			totalProperty:'total',
			id:'id'}),
		fields:[
			{name: 'parUsuId', type: 'int'},
			{name: 'parUsuario', type: 'string'},
			{name: 'parCorreo', type: 'string'},
			{name: 'parNombres', type: 'string'},
			{name: 'parApellidos', type: 'string'},
			{name: 'roles', type: 'string'},
		],
		sortInfo:{field: 'parUsuario', direction: 'ASC'}	
	});
	ParticipanteDataStore.load({params: {start: 0, limit: 12}});

    	function ponerNombre(val,x,registro){
    		return registro.data.parNombres+" "+registro.data.parApellidos;
    	}
	
	
 	var participanteSelModel = new Ext.grid.CheckboxSelectionModel({
		listeners: {
			rowselect: function(sm, row, rec) {
			
			RolParticipanteGrid.getStore().removeAll();
			ParticipanteForm.getForm().loadRecord(rec);			
			datosRol=Ext.util.JSON.decode(rec.data.roles);
			RolParticipanteGrid.getStore().loadData(datosRol);

			}
		}
	});
   
	ParticipanteColumnModel = new Ext.grid.ColumnModel({
	columns:[
	    participanteSelModel,
		{header: 'Usuario',dataIndex: 'parUsuario',width: 40},
		{header: 'Correo',dataIndex: 'parCorreo',width: 150},
		{header: 'Nombre y Apellido',width: 150,renderer:ponerNombre},
		//{header: 'Roles que desempena',dataIndex: 'roles',width: 100}
		],
	defaults:{sortable:true}});
	
	
    /*los de la tool bar*/
    	rolProyectoInvitarDataStore = new Ext.data.Store({
	id: 'rolProyectoInvitarDataStore',
	proxy: new Ext.data.HttpProxy({
		  url: 'participante/cargar', 
		  method: 'POST'
	      }),
	baseParams:{task: 'LISTARROP'}, // this parameter is passed for any HTTP request
	reader: new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'id'
	    },[{name: 'ropId'},{name: 'ropNombre'}]),
	sortInfo:{field: 'ropNombre', direction: "ASC"}
    	});
    	rolProyectoInvitarDataStore.load();
    
    
	rolProyectoInvitarComboBox= new Ext.form.ComboBox({
		id:'rolProyectoInvitarComboBox',
		name:'rolProyectoInvitarComboBox',
		fieldLabel:'rol',
		store:rolProyectoInvitarDataStore,
		mode:'local',
		emptyText:'rol',
		displayField:'ropNombre',
		valueField:'ropNombre',
		triggerAction:'all',
		forceSelection:true,
		value:'Programador',
		width: 100,
		disabled:false
	});
    
	ParticipanteGrid =  new Ext.grid.GridPanel({
		id: 'ParticipanteGrid',
		region:'center',
		autoScroll:true,
		split:true,
		stripeRows:true,
		store: ParticipanteDataStore,
		cm: ParticipanteColumnModel,
		height: heightCentro,
		title:'Lista de participantes',
                frame:true,
		bbar: new Ext.PagingToolbar({
				pageSize: 12,
				store: ParticipanteDataStore,
				displayInfo: true,
				displayMsg: 'Participantes {0} - {1} de {2}',
				emptyMsg: "No hay Participantes"
			}),
		enableColLock:false,
	    	sm: participanteSelModel,
	   	listeners: {
	        	render: function(g) {
	        		g.getSelectionModel().selectRow(0);
	        	},
	        	delay: 10
	        },
	 	tbar:[{text:'Eliminar',disabled:true,id: 'btnEliminarParticipante',iconCls:'eliminar',tooltip:'Pulse este para eliminar los participantes del proyecto',handler:eliminarParticipantes}],
		plugins:[new Ext.ux.grid.Search({
				mode:          'local',
				position:      top,
				searchText:    'Filtrar',
				iconCls:  'filtrar',
				selectAllText: 'Seleccionar todos',
				searchTipText: 'Escriba el texto que desea buscar y presione la tecla enter',
				width:         100
		})],
		viewConfig:{
			    forceFit:true,
			    enableRowBody:true,
			    showPreview:true,
			    getRowClass :  function(record, rowIndex, p, ds){
						if(this.showPreview){
						   
						    return 'x-grid3-row-expanded';
						}
						return 'x-grid3-row-collapsed';
					    	}
			}	
	});
	
  	
  
/*Los roles del usuario selecionado*/

 	var rolesSelModel = new Ext.grid.CheckboxSelectionModel();
	var datosRol=[];
	var RolParticipanteGrid =  new Ext.grid.GridPanel({
		style: {
			"margin-top": "20px", 
		},
		id: 'RolParticipanteGrid',
		stripeRows:true,
	 	store: new Ext.data.Store({
		    reader: new Ext.data.ArrayReader({}, [
		       {name: 'ropId',mapping:'ropId'},
		       {name: 'ropNombre',mapping:'ropNombre'}
		    ]),
		    data: datosRol
		}),
		cm: new Ext.grid.ColumnModel([
		    rolesSelModel,
		    {header: "ID", width: 50, sortable: true, dataIndex: 'ropId',hidden:true},
		    {header: "Rol", width: 120, sortable: true, dataIndex: 'ropNombre'},
		    
		]),
		anchor:'100%',
		height: 200,
		title:'Roles de usuario en el proyecto',
		border: true,
		autoScroll:true,
	    	sm: rolesSelModel,	
		bbar:[{text:'Quitar rol',id:'btnQuitarRol',disabled:true,iconCls:'eliminar',tooltip:'Quitar rol, o roles seleccionados a el participante',handler:quitarRolParticipante}]
	});

  
	var ParticipanteForm = new Ext.FormPanel({
	id: 'ParticipanteForm',
	url: 'participante/cargar',
    	autoWidth:true,
	height:heightCentro,

        title:'Participantes',
        closable: true,
        frame:true,
      //  border:false,
        iconCls:'participantes',
	tabTip :'Aqui puedes ver,los participantes del proyecto, invitar nuevos participantes y quitar roles',

	autoScroll:true,
	layout: 'border',
	monitorResize : true,
	items: [
		 ParticipanteGrid,
		{
	    	title:'Detalle del participnate',
		xtype:'panel',
                frame:true,
		split:true,
                width:350,
		collapsible: true,
        	region:'east',
		layout: 'form',	
		autoScroll:true,
		defaults: {xtype:'textfield',anchor:'100%',readOnly:true},
		bodyStyle: Ext.isIE ? 'padding:0 0 15px 15px;' : 'padding:10px 15px;',
		items:[
			{fieldLabel: 'IdUsu',name: 'parUsuId',id: 'parUsuId'},
			{fieldLabel: 'Usuario',name: 'parUsuario',id: 'parUsuario'},
			{fieldLabel: 'Nombres',name: 'parNombres',id: 'parNombres'},
			{fieldLabel: 'Apellidos',name: 'parApellidos',id: 'parApellidos'},
			{fieldLabel: 'Correo',name: 'parCorreo',id: 'parCorreo'},
			RolParticipanteGrid,
			],
		}
		],
	tbar: [{
	    	xtype: 'buttongroup',title: 'Filtros por rol de proyecto',columns:3,
	    	defaults: {scale: 'small'},
	    	items: [
	        	{text: 'Tester',iconCls: 'rol_tester',handler:filtroxRol},
			{text: 'Programador',iconCls: 'rol_programador',handler:filtroxRol},
	        	
	        	{text: 'Todos',iconCls: 'rol_todos',rowspan:2,scale: 'large',
	        		handler:function(){
	        				 ParticipanteDataStore.baseParams={task:'LISTARPARTICIPANTES'};
						 ParticipanteDataStore.reload();
						 ParticipanteGrid.setTitle('Lista de participantes');
							    }
				},
	        	{text: 'Cliente',iconCls: 'rol_cliente',handler:filtroxRol},
	        	{text: 'Administrador',iconCls: 'rol_jefe',handler:filtroxRol}
			]
	   	},/*{
		xtype: 'buttongroup',title: 'Mensajes',columns: 2,
		defaults: {scale: 'large'},
		items: [{text: 'Enviar',iconCls: 'enviar_mensaje'},
		    	{text: 'Buscar',iconCls: 'buscar'},
		    	]
	   	},*/
                {
	    	xtype: 'buttongroup',title: 'Nuevas Invitaciones',columns: 2,
	    	defaults: {scale: 'small'},
	    	items: [{xtype:'textfield',id:'nuevosInvitados',width:150,emptyText:'Usuarios que van a invitar',colspan:2},
	        	rolProyectoInvitarComboBox,
	        	{text: 'Invitar',id:'btnInvitarOtro',disabled:true,iconCls: 'nueva_invitacion',handler:invitarUsuarios}
	        	]
		}
	]//,		
  	//renderTo: 'formularioParticipante'
	});


/*************************************/
/*Aqui tenemos el manejo de eventos tanto de crear , actualizar, eliminar*/
/*************************************/
	function filtroxRol(btn){
  
	ParticipanteDataStore.baseParams={task:'LISTARPARTICIPANTES',ropNombre:btn.getText()};
	ParticipanteDataStore.reload();
	ParticipanteGrid.setTitle('Lista de participantes con rol '+btn.getText());
  	}

	
	
	function invitarUsuarios(){
		Ext.Ajax.request({  
				waitMsg: 'Por Favor Espere...',
				url:'participante/cargar',
   				params: { 
					task: "INVITAR", 
				    	nuevosInvitados:Ext.getCmp('nuevosInvitados').getValue(),
				    	ropNombre:  Ext.getCmp('rolProyectoInvitarComboBox').getValue()
				}, 
				success: function(response){
				obj = Ext.util.JSON.decode(response.responseText);
					if (obj.success)
					{
						agaviso(obj.mensaje);
						ParticipanteDataStore.reload();
					
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


	function quitarRolParticipante(){

  		var rolesSelecionados = RolParticipanteGrid.selModel.getSelections();
         	var rolesEliminar = [];
         	for(i = 0; i< RolParticipanteGrid.selModel.getCount(); i++){
          	rolesEliminar.push(rolesSelecionados[i].json.ropId);
         	}
         	var encoded_array_rol = Ext.encode(rolesEliminar);

		Ext.Ajax.request({  
				waitMsg: 'Por Favor Espere...',
				url:'participante/cargar',
   				params: { 
					task: "ELIMINARINVITACIONROL", 
				    	usuID:Ext.getCmp('parUsuId').getValue(),
				    	roles: encoded_array_rol
				}, 
				success: function(response){
				obj = Ext.util.JSON.decode(response.responseText);
					if (obj.success)
					{
						agaviso(obj.mensaje);
						ParticipanteDataStore.reload();
						ParticipanteForm.getForm().reset();
						RolParticipanteGrid.getStore().removeAll();
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


	function eliminarParticipantes(){
		var participantesSelecionados = ParticipanteGrid.selModel.getSelections();
         	var participantesEliminar = [];
         	for(i = 0; i< ParticipanteGrid.selModel.getCount(); i++){
          	participantesEliminar.push(participantesSelecionados[i].json.parUsuId);
         	}
         	var encoded_array_usu = Ext.encode(participantesEliminar);

		Ext.Ajax.request({  
				waitMsg: 'Por Favor Espere...',
				url:'participante/cargar',
   				params: { 
					task: "ELIMINARPARTICPANTE", 
				    	ids_usu:encoded_array_usu
				    	
				}, 
				success: function(response){
				obj = Ext.util.JSON.decode(response.responseText);
					if (obj.success)
					{
						agaviso(obj.mensaje);
						ParticipanteDataStore.reload();
						ParticipanteForm.getForm().reset();
						RolParticipanteGrid.getStore().removeAll();
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

	function agregarBotonesParticipante(){
		if(tieneRol("administrador")){
		 Ext.getCmp('btnInvitarOtro').setDisabled(false);
		 Ext.getCmp('btnQuitarRol').setDisabled(false);
		 Ext.getCmp('btnEliminarParticipante').setDisabled(false);

		}
	}
	agregarBotonesParticipante();

return ParticipanteForm;
}

