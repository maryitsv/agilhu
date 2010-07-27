var Mensaje = function () 
{

return { 
init: function () {

  	Ext.QuickTips.init();

	var MensajeDataStore = new Ext.data.JsonStore({	
		id: 'mensajeDataStore',
		url:'mensajes/cargar',
		root: 'results',
		baseParams:{task:'LISTARMENSAJES'},
		totalProperty: 'total',
		reader:new Ext.data.JsonReader({
			root:'results',
			totalProperty:'total',
			id:'id'}),
		fields:[
			{name: 'menId', type: 'int'},
			{name: 'menDe', type: 'string'},
			{name: 'menPara', type: 'string'},
			{name: 'menFecha', type: 'string'},
			{name: 'menAsunto', type: 'string'},
			{name: 'menMensaje', type: 'string'},
			{name: 'menTipo', type: 'string'},

		],
		sortInfo:{field: 'menFecha', direction: 'ASC'}	
	});
	MensajeDataStore.load({params: {start: 0, limit: 12}});

 
	var MensajeSelModel = new Ext.grid.CheckboxSelectionModel({
				listeners: {
				rowselect:function(sm, row, rec) {
						MensajeFormulario.getForm().loadRecord(rec);
					}}
				
				});
   
	var MensajeColumnModel = new Ext.grid.ColumnModel({
	columns:[
	  	MensajeSelModel,
		{header: 'De',dataIndex: 'menDe',width: 100},
		{header: 'Para',dataIndex: 'menPara',width: 100},
		{header: 'Fecha',dataIndex: 'menFecha',width: 150},
		{header: 'Asunto',dataIndex: 'menAsunto',width: 150},
		{header: 'Tipo',dataIndex: 'menTipo',width: 30},
		{header: 'Mensaje',dataIndex: 'menMensaje',width: 100}],
	defaults:{sortable:true}});
	
	var MensajeGrid =  new Ext.grid.GridPanel({
		id: 'MensajeGrid',
		stripeRows:true,
		store: MensajeDataStore,
		cm: MensajeColumnModel,
		height: 400,
		title:'Lista de Mensajes',
		border: true,
		bbar: new Ext.PagingToolbar({
				pageSize: 12,
				store: MensajeDataStore,
				displayInfo: true,
				displayMsg: 'Mensajes {0} - {1} de {2}',
				emptyMsg: "No hay Mensajes"
			}),
	    	sm: MensajeSelModel,
	 	listeners: {
	        	render: function(g) {
	        		g.getSelectionModel().selectRow(0);
	        	},
	        	delay: 10
	        },
		tbar: [[{
		    xtype: 'buttongroup',
		    title: 'Filtros por tipo de mensaje',
		    columns: 3,
		    defaults: {scale: 'large'},
		    items: [{text: 'Recibidos',iconCls: 'mensaje_recivido',handler:filtroxMensaje},
		            {text: 'Enviados',iconCls: 'mensaje_enviado',handler:filtroxMensaje}
		           ]
		   },{
		    xtype: 'buttongroup',title: 'Mensajes',columns: 3,defaults: {scale: 'large'},
		    items: [{text: 'Enviar',iconCls: 'nuevo_mensaje'},
		    	    {text: 'Buscar',iconCls: 'buscar_mensaje',handler:buscarMensaje},
			    {text:'Eliminar',align:'center',scale:'large',id: 'btneliminarMensajes',iconCls:'eliminar_mensaje',handler:validacionEliminarMensaje},
			
			   ]
		   }] //end grupos
		],//end tbar
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

	
	/****************START CHATINO************/
	var contactosDataStore = new Ext.data.JsonStore({	
		id: 'contactosDataStore',
		url:'mensajes/cargar',
		root: 'results',
		baseParams:{task:'LISTARCONTACTOS'},
		totalProperty: 'total',
		reader:new Ext.data.JsonReader({
			root:'results',
			totalProperty:'total',
			id:'id'}),
		fields:[{name: 'usuUsuario', type: 'string'}],
		sortInfo:{field: 'usuUsuario', direction: 'ASC'}	
	});
	contactosDataStore.load();


var chatPanel=new Ext.Panel({
items:[{
	xtype:'grid',
	id: 'chatGrid',
	stripeRows:true,
	store: contactosDataStore,
	cm: new Ext.grid.ColumnModel({
		columns:[
		{header: 'Usuario',dataIndex: 'usuUsuario',width: 80},
		],
		defaults:{sortable:true}}),
	height: 300,
	title:'Lista de Usuarios',
	border: true,
    	sm: new Ext.grid.RowSelectionModel({
	                singleSelect: true, 
	        })
	}],

});

/****************END CHAT****************/
  
	var MensajeFormulario = new Ext.FormPanel({
	id: 'MensajeFormulario',
	url: 'mensaje/cargar',
	bodyStyle:'padding:5px',
    	autoWidth:true,
	autoHeight:true,
	autoScroll:true,
	monitorResize : true,
	layout: 'column',
	items: [{
	    //	region:'center',
		layout: 'fit',
		columnWidth:.6,
		autoScroll:true,
		items: MensajeGrid,
		},chatPanel
		/*++{
		columnWidth: 0.4,
		xtype:  'panel',
		id:'MensajeDatos',
		layout:'form',
		//readOnly:true,
		title:'Datos del Mensaje',
		bodyStyle: Ext.isIE ? 'padding:0 0 15px 15px;' : 'padding:10px 15px;',
		border: true,
		style: {
			"margin-left": "10px", 
			"margin-right": Ext.isIE6 ? (Ext.isStrict ? "-10px" : "-13px") : "0"  
		},
		monitorValid:true,
		defaults: {xtype:'textfield',anchor:'100%'},
		items: [{
			xtype:  'panel',
			height: 30,
			border: false,
			disabled:false,
				items:
				[{xtype: 'label',text:'Todos los campos son obligatorios',style: 'font-size:8.5pt; color:#484848;font-weight: bold;'}]
			},
			{fieldLabel: 'De',name: 'menDe',id: 'menDe',readOnly :true,allowBlank:false},
			{fieldLabel: 'Para',name: 'menPara',id: 'menPara',emptyText: 'Aqui para quien separado por coma',readOnly :true,allowBlank:false},
			{fieldLabel: 'Asunto',name: 'menAsunto',id: 'menAsunto',readOnly :true},
			{fieldLabel: 'Mensaje',height: 200,name: 'menMensaje',id: 'menMensaje',xtype:'htmleditor',disable :true,allowBlank:false},
			{name: 'menId',id: 'menId',hidden:true}],
		buttons:[
			
			{text:'Responder',align:'center',scale:'large',formBind: true,id: 'btnresponderMensaje',iconCls:'responder_mensaje',
			  handler:reponderMensaje},
			{text:'Eliminar',align:'center',scale:'large',formBind: true,id: 'btneliminarMensaje',iconCls:'eliminar_mensaje',handler:validacionEliminarMensaje}
			],
			}*/
		],
  	renderTo: 'formularioMensaje'
	});



/*************************************/
/*Aqui tenemos el manejo de eventos tanto de crear , actualizar, eliminar*/
/*************************************/

	var tipoMensaje='Recibidos';

	function filtroxMensaje(btn){
	  
		MensajeDataStore.baseParams={task:'BUSCARMENSAJE',tipoMensaje:btn.getText()};
		MensajeDataStore.reload();
		tipoMensaje=btn.getText();
		if(tipoMensaje=='Enviados')
		{
		Ext.getCmp('btnresponderMensaje').setDisabled(true);
		}
		else
		{
		Ext.getCmp('btnresponderMensaje').setDisabled(false);
		}
	}
  


	function buscarMensaje(){
	var spot = new Ext.ux.Spotlight({
        	easing: 'easeOut',
        	duration: .4
    	});
 	

	var ContactosDataStore = new Ext.data.JsonStore({	
		id: 'mensajeDataStore',
		url:'mensajes/cargar',
		root: 'results',
		baseParams:{task:'LISTARCONTACTOS'},
		totalProperty: 'total',
		reader:new Ext.data.JsonReader({
			root:'results',
			totalProperty:'total',
			id:'id'}),
		fields:[{name: 'usuUsuario', type: 'string'}],
		sortInfo:{field: 'usuUsuario', direction: 'ASC'}	
	});
	ContactosDataStore.load();

	var deFiltroComboBox= new Ext.form.ComboBox({
		id:'deFiltroComboBox',
		name:'deFiltroComboBox',
		fieldLabel:'De',
		store:ContactosDataStore,
		mode:'local',
		displayField:'usuUsuario',
		valueField:'usuUsuario',
		triggerAction:'all',
		forceSelection:true,
		});

	var paraFiltroComboBox= new Ext.form.ComboBox({
		id:'paraFiltroComboBox',
		name:'paraFiltroComboBox',
		fieldLabel:'para',
		store:ContactosDataStore,
		mode:'local',
		displayField:'usuUsuario',
		valueField:'usuUsuario',
		triggerAction:'all',
		forceSelection:true,
		});


	var BuscarMensajeFormulario = new Ext.FormPanel({
		id: 'BuscarMensajeFormulario',
		url: 'mensajes/cargar',
		bodyStyle:'padding:5px',
		//title:'Datos del Mensaje',
		width: 300,
		frame:true,
		defaults: {xtype:'textfield',anchor:'100%'},
		items: [		
			{checked: true,xtype:'radio',fieldLabel: 'Tipo msg',boxLabel: 'Recibidos',name: 'fav-tipo',inputValue: 'Recibidos'}, 
			{fieldLabel: '',xtype:'radio',labelSeparator: '',boxLabel: 'Enviados',name: 'fav-tipo',inputValue: 'Enviados'},
			deFiltroComboBox,	
			paraFiltroComboBox,		
			{fieldLabel: 'Asunto',name: 'busMenAsunto',id: 'busMenAsunto'},
			{fieldLabel: 'Mensaje',name: 'busMenMensaje',id: 'busMenMensaje'}],
		buttons:[
			{text:'Buscar',align:'center',scale:'small',iconCls:'filtrar',handler:function(){}},
			{text:'Cancelar',align:'center',scale:'small',iconCls:'eliminar',handler:function(){BuscarMensajeWindow.close();spot.hide();}}
			]
	
			
		});

      
	    var BuscarMensajeWindow = new Ext.Window({
		 title: 'Buscar mensaje',
		 id:'BuscarMensajeWindow',
		 closable:false,
		 autoWidth: true,
		 height: 280,
		 plain:true,
		 layout: 'fit',
		 items: BuscarMensajeFormulario
	     });

		BuscarMensajeWindow.show();
		spot.show('BuscarMensajeWindow');
	}

	function agregarBotones(){
		
	}
	
	function reponderMensaje(btn)
	{ 	//captura de datos que necesito
		if(btn.getText()=='Responder')
		{
		var para=Ext.getCmp('menDe').getValue();
		var de=Ext.getCmp('menPara').getValue();
		var asunto=Ext.getCmp('menAsunto').getValue();

		//limpiar form
		MensajeFormulario.getForm().reset();
		//asignacion de datos
		Ext.getCmp('menPara').setValue(para);
		Ext.getCmp('menDe').setValue(de);
		Ext.getCmp('menAsunto').setValue("Resp:"+asunto);

		Ext.getCmp('btneliminarMensaje').setText("Cancelar");
		Ext.getCmp('btnresponderMensaje').setText("Guardar");
		MensajeGrid.selModel.clearSelections();
		}
		else{
		guardarMensaje();
		}		
	}


	function guardarMensaje(){

	var ContactosDataStore = new Ext.data.JsonStore({	
		id: 'mensajeDataStore',
		url:'mensajes/cargar',
		root: 'results',
		baseParams:{task:'LISTARCONTACTOS'},
		totalProperty: 'total',
		reader:new Ext.data.JsonReader({
			root:'results',
			totalProperty:'total',
			id:'id'}),
		fields:[{name: 'usuUsuario', type: 'string'}],
		sortInfo:{field: 'usuUsuario', direction: 'ASC'}	
	});
	ContactosDataStore.load();

	}
	
	
	function validacionEliminarMensaje(btn){
		var encoded_array_men;
		var mensajesEliminar = [];
		var mensajesSelecionados;

		if(btn.getId()=='btneliminarMensajes')
		{
			mensajesSelecionados = MensajeGrid.selModel.getSelections();
		 	var cantMensajes=MensajeGrid.selModel.getCount();
			if(cantMensajes>0)
			{
			 	for(i = 0; i< cantMensajes; i++){
			  	mensajesEliminar.push(mensajesSelecionados[i].json.menId);
			 	}
			 	encoded_array_men = Ext.encode(mensajesEliminar);		
		
				eliminarMensaje(encoded_array_men);
			}
			else{
			agalerta('Debe selecionar uno o varios mensajes para eliminar');
			}
		}
		if(btn.getId()=='btneliminarMensaje')
		{

			if(btn.getText()=='Cancelar')
			{
			MensajeFormulario.getForm().reset();
			Ext.getCmp('btneliminarMensaje').setText("Eliminar");
			Ext.getCmp('btnresponderMensaje').setText("Responder");
			}
		
			else//if(btn.getText('Eliminar')) //si lo descomento de orden debo cambiar el orden
			{
				if(Ext.getCmp('menId').getValue()!=='')
				{
				mensajesEliminar.push(Ext.getCmp('menId').getValue());
			 	encoded_array_men = Ext.encode(mensajesEliminar);		
		
				eliminarMensaje(encoded_array_men);
				}
				if(Ext.getCmp('menId').getValue()==''){
				agalerta('Debe selecionar un mensaje para eliminar');
				}
			}	
		}
	}

	function eliminarMensaje()
	{
		Ext.Ajax.request({  
				waitMsg: 'Por Favor Espere...',
				url:'mensajes/cargar',
   				params: { 
					task: "ELIMINARMENSAJE", 
				    	ids_mensajes:encoded_array_men,
					tipo_mensaje:tipoMensaje
				    	
				}, 
				success: function(response){
				obj = Ext.util.JSON.decode(response.responseText);
					if (obj.success)
					{
						agaviso(obj.mensaje);
						MensajeDataStore.reload();
						MensajeDatos.getForm().reset();
					
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
  
}}}();

