limiteConsultas=20;
var Invitaciones = function () 
{
  return { 
    init: function () {
    /**********************************************LISTAR INVITACIONES***********************************/
	
    //creamos el data estore cargando desde la base de datos
    dataStoreInvitacion = new Ext.data.Store({
	id: 'dataStoreInvitaciones',
	proxy: new Ext.data.HttpProxy({
	    url: 'pinvitacion/cargar', 
            method: 'POST'
        }),
	baseParams:{task: 'LISTARINV',estado:'Nuevo',start:0,limit:limiteConsultas}, //listamos las invitaciones echas
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
	    {name: 'invcreated', type: 'string'},
	    {name: 'prodescripcion', type: 'string'},
	    {name: 'profechaini', type: 'string'},
	    {name: 'profechafin', type: 'string'},
	    {name: 'proestado', type: 'string'},
	    {name: 'prologo', type: 'string'},
	    {name: 'estadoinvitacion', type: 'string'},
	    {name: 'usuinvitado', type: 'string'},
	    {name: 'rolproyectoinvitado', type: 'string'},
	    {name: 'ropid', type: 'int'}
	]),//sortInfo:{field: 'fechaini', direction: "ASC"}
     });
    
    //Renderizado de la imagen y puesta de color
    function ponerRojo(val)
    {
      if(val=='Nuevo'){
        return '<span style="color:red;">' + val + '</span>';
      }
      if(val=='Rechazado'){
        return '<span style="color:green;">' + val + '</span>';
      }
      if(val=='Aceptado'){
        return '<span style="color:black;">' + val + '</span>';
      }

    }

    function ponerimagen(val){
	if(val!='0'){
	 return '<img src='+URL_AGILHU+'/pusuario.php/documentos/cargar?task=DESCARGAR&Identificador='+val+' width=35 heigth=35 >';
	}
	else{ 
	 return '<img src="../images/projecto-logo-default.png" width=30 heigth=30 >';
	}
    }

    var colModelInvitacion;
    colModelInvitacion = new Ext.grid.ColumnModel({
    defaults:{sortable: true, locked:false},
    columns:[
		{ header: "%", width: 50, dataIndex: 'prologo',renderer:ponerimagen,resizable:false},
		{ id:'pronom',header: "Nombre ", width: 110, dataIndex: 'pronom'},
                //datos inv
		{ header: 'Estado invitacion',dataIndex: 'estadoinvitacion',renderer:ponerRojo,
		  editor: new Ext.form.ComboBox({
			typeAhead: true,triggerAction: 'all',forceSelection :true,
			 store:new Ext.data.SimpleStore({fields:['estado'],data: [['Aceptado'],['Rechazado']]}),
			 mode: 'local',displayField: 'estado',//listClass: 'x-combo-list-small'
		})},
		{ header: "Rol a Desempe&#241;ar", width: 97, dataIndex: 'rolproyectoinvitado'},
		{ header: "Fecha Invitacion", width: 110,  dataIndex: 'invcreated'},
		//end datos inv
		{ header: "Autor", width: 90,  dataIndex: 'procreador'},
		{ header: "Area", width: 70,  dataIndex: 'proarea'}//,
		//{ header: "Fecha Inicio <br/> Proyecto", width: 70,  dataIndex: 'profechaini'},
		//{ header: "Fecha Fin <br/> Proyecto", width: 70, dataIndex: 'profechafin'}
    	]
    });
    dataStoreInvitacion.load();
    
    var gridInvitacion=new Ext.grid.EditorGridPanel({
        ds: dataStoreInvitacion,
        cm: colModelInvitacion,
        region:'center',
        frame:true,
        stripeRows:true,
        clicksToEdit: 1,
        sm: new Ext.grid.RowSelectionModel({
           singleSelect: true,
           listeners: {
               rowselect: function(sm, row, rec) {
		       agFormInvitacion.getForm().loadRecord(rec);
			}
            }
        }),//end sm
        height:heightCentro,	
        title:'Proyectos Existentes',
        iconCls:'invitacion',
        border: true,
        listeners: {
	   render: function(g) {g.getSelectionModel().selectRow(0);},
	   delay: 10},
        bbar: new Ext.PagingToolbar({
          pageSize: limiteConsultas,
          store: dataStoreInvitacion,
          displayInfo: true,
          displayMsg: 'Invitaciones {0} - {1} of {2}',
          emptyMsg: "No hay invitaciones"		    
        }),
        tbar:[{text:'Nuevo',iconCls:'nueva_inv',handler:buscarInvitacion},
              {text:'Aceptado',iconCls:'aceptada_inv',handler:buscarInvitacion},
              {text:'Rechazado',iconCls:'rechazada_inv',handler:buscarInvitacion},
              {text:'Todos',iconCls:'todo_inv',handler:buscarInvitacion},
              ],//es necesario ponerla por el plugin
        plugins:[new Ext.ux.grid.Search({
          mode:          'local',
          position:      top,
          searchText:    'Filtrar',
          iconCls:  'filtrar',
          selectAllText: 'Seleccionar todos',
          searchTipText: 'Escriba el texto que desea buscar y presione la tecla enter',
          width:         100
        })],
	autoExpandColumn :'pronom'
      });

      gridInvitacion.on('afteredit',cambiarEstadoInvitacion);

      function buscarInvitacion(btn){
	if(btn.getText()!='Todos')
	{ 
	dataStoreInvitacion.baseParams={task:'LISTARINV',estado: btn.getText(),start:0,limit:limiteConsultas};
	}
	else{
	dataStoreInvitacion.baseParams={task:'LISTARINV',start:0,limit:limiteConsultas};
	}
	dataStoreInvitacion.reload();
      }
    
      var agFormInvitacion=new Ext.FormPanel({
       //campos del layout border  
        width: 450,
        collapsible: true,
        split: true,
        region:'east',//end lb
        title:'Datos del proyecto',
        autoScroll:true,
        defaults: {anchor:'92%',xtype:'textfield'},
        frame:true,
        layout:'form',
        deferredRender:false,
        bodyStyle: Ext.isIE ? 'padding:0 0 15px 15px;' : 'padding:10px 15px;',
        items:[
             {fieldLabel: 'Autor',name: 'procreador'},
             {fieldLabel: 'Nombre corto',name: 'prosigla'},
             {fieldLabel: 'Nombre',name: 'pronom'},
             {fieldLabel: 'Area',name: 'proarea'},
             {xtype: 'datefield',fieldLabel: 'Fecha inicio',name: 'profechaini'},
             {xtype: 'datefield',fieldLabel: 'Fecha fin',name: 'profechafin'},            
             {fieldLabel: 'Estado',name: 'proestado'},
             {
              title: 'Descripcion del Proyecto',			
              xtype: 'fieldset',
              collapsible: true,
              collapsed: false,
              id:'forminviprodescripcion',
              items:[
                 {name: 'prodescripcion',xtype:'htmleditor',height :200,anchor:'100%',autoscroll:true,
                  enableColors:false,enableFont:false,enableFontSize:false,enableFormat:false,enableLinks:false,
                  enableLists:false,enableSourceEdit:false,enableAlignments :false,hideLabel : true,
                  }
              ]	
             }
       ]
       });

	var agContenedorInvitacion = new Ext.Panel({
            id: 'agContenedorInvitacion',
            renderTo:'formulario',
            height:heightCentro,
            autoWidth:true,
            layout: 'border',
            items: [gridInvitacion,
                   agFormInvitacion
                  ]
       });
   
	/***************************************************FUNCIONES******************************************/
	function cambiarEstadoInvitacion(event){
	Ext.Ajax.request({
	      waitMsg:'Espere por favor',
	      url:'pinvitacion/cargar',
	      params:{
		      task:"DEFINIRESTADOINV",
		      idProyecto:event.record.data.proid,
		      idRolProyecto:event.record.data.ropid,
		      estadoinvitacion:event.record.data.estadoinvitacion
		      },
	      success: function(response){
		      obj = Ext.util.JSON.decode(response.responseText);
				
				if (obj.success)
				{
					agalerta(obj.mensaje);
					dataStoreInvitacion.commitChanges();
			      		dataStoreInvitacion.reload();
				}
				else if (obj.success == false)
				{
					agerror(obj.errors.reason);
				}
		      },
	      failure:function(response){
		      var result=response.responseText;
		      Ext.MessageBox.alert('error','no se han guardado los cambio revise por favor');
		      }
	      });
	}
         
	//ponEstilo();
	}//hata aqui las llaves obligatorias 
	}
}();
