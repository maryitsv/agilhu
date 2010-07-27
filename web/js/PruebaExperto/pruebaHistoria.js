//clase para con el formulario para la creacion de una historia de usuario
var PruebaHistoria = function () 
{

			Ext.QuickTips.init();
      /*******************FORMULARIO HISTORIA USUARIO************************/

      ///grid donde estaran listadas las historias de usurio que pertenecen al proyecto actual
      var jsonhispro = new Ext.data.GroupingStore({
        autoLoad: true,
        baseParams:{
          filtro: 'todas',//indica si trae las hu probadas, no probadas, o todas
          tipo_version:'todas',//indica si trae todas las versiones o solo las ultimas
          task: 'hispro'
        },
	proxy: new Ext.data.HttpProxy({
                url: 'pruebaexperto/listar', 
                method: 'POST'
        }),
        storeId: 'jsonhisproprueba',
	reader: new Ext.data.JsonReader({
                root: 'hispro',//las HU por proyect
                totalProperty: 'total',
                id: 'his_id'//el indice para este json
                },
		[
		{name:'his_id', type: 'int'},
		{name:'his_nombre'},
		{name:'created_at'},//timestamp buscar tipo conpatibel
		{name:'his_creador'},
		{name:'updated_at'},
		{name:'his_prioridad'},
		{name:'his_responsable'},
		{name:'mod_id', type: 'int'},
		{name:'pro_id', type: 'int'},
		{name:'his_dependencias'},
		{name:'his_riesgo', type: 'int'},
		{name:'his_tiempo_estimado', type: 'int'},
		{name:'his_tiempo_real', type: 'int'},
		{name:'his_descripcion'},
		{name:'his_identificador_historia'},
		{name:'his_version'},
		{name:'his_actor'},//cambio v1.1
		{name:'his_unidad_tiempo'},
		//estos campos no estan incluidos en el formulario en donde van
		{name:'his_tipo_actividad', type: 'int'},
		{name:'his_observaciones', type: 'int'},
		{name:'his_probada'}
		]),
      //  sortInfo:{field: 'profechaini', direction: "ASC"},
      //  groupField:'mod_nombre'
      });


      
     //con el RowExpander puedo mostrar mas informacion de la historia de usuario
      var expanderHUPrueba = new Ext.ux.grid.RowExpander({
        tpl : new Ext.Template(
            '<p><b>Identificador :</b> {his_identificador_historia}</p>',
            '<p><b>Version :</b> {his_version}</p>',
            '<p><b>Riesgo :</b> {his_riesgo}</p><br/>',
            '<p><b>Descripción:</b> <h1>{his_descripcion}</h1></p>'
        )
      });
      
      //las columnas que se muestran en el grid
      var colmodel = new Ext.grid.ColumnModel([expanderHUPrueba,
       {header: "Nombre", width: 150, sortable: true, dataIndex: 'his_nombre'},
       {header: "Actualizada", width: 150, sortable: true, format: 'Y-m-d',dataIndex:'updated_at'},
       {header: "Duracion", width: 150, sortable: true, dataIndex: 'his_tiempo_estimado', renderer: estimacion },
       {header: "Prioridad", width: 150, sortable: true, dataIndex: 'his_prioridad'},
       {header: "Probada", width: 150, sortable: true, dataIndex: 'his_probada'},
       {header: "Autor", width: 150, sortable: true, dataIndex: 'his_creador'},
       {header: "Version", width: 150, sortable: true, dataIndex: 'his_version'},
       {header: "Responsable", width: 150, sortable: true, dataIndex: 'his_responsable'}
      ]);
      
      //poner la duracion a la izquierda de unidad de tiempo
      function estimacion(val,x,st)
      {
        return ' '+val+' '+st.data.his_unidad_tiempo;
      }
      
      //proyecto 43 tiene modulo 1, 2 y 3 
      var gridhu = new Ext.grid.GridPanel({
        region:'center',
        store: jsonhispro,
        cm: colmodel,
        sm: new Ext.grid.RowSelectionModel({
          singleSelect:true,
          listeners: {
            rowselect: function(s, i, r){
              formPrueba.getForm().loadRecord(r); //para establecer el id de la historia a evaluar
            }
          }
        }),
        listeners:{
          viewready: function(g){
            g.getSelectionModel().selectRow(0);
          }
        },
	stripeRows:true,
	autoWidth:true,
        height: 300,
        frame: true,
        title: 'Historias del proyecto',
        plugins: expanderHUPrueba,
        iconCls: 'icon-grid',
        tbar:[{
	    	xtype: 'buttongroup',title: 'Todas las versiones',columns:3,tooltip:'Muestra todas las versiones de las hu',
	    	defaults: {scale: 'small'},
	    	items: [
	        	
	        	{text: 'Probadas',iconCls: 'aceptada_inv',scale: 'small',
                         handler:function(){
                                   jsonhispro.removeAll();
                                   jsonhispro.baseParams={filtro: 'probadas',tipo_version:'todas',task:'hispro'};
                                   jsonhispro.reload();	 
                                  }
                        },{text: 'Sin Probar',iconCls: 'rechazada_inv',scale: 'small',
                         handler:function(){
                                   jsonhispro.removeAll();
                                   jsonhispro.baseParams={filtro: 'sinprobar',tipo_version:'todas',task:'hispro'};
                                   jsonhispro.reload();	 
                                  }
                        },{text: 'Todos',iconCls: 'todo_inv',scale: 'small',
                         handler:function(){
                                   jsonhispro.removeAll();
                                   jsonhispro.baseParams={filtro: 'todas',tipo_version:'todas',task:'hispro'};
                                   jsonhispro.reload();	 
                                  }
                        }
			]
	   	},{
	    	xtype: 'buttongroup',title: 'Ultimas las versiones',columns:3,tooltip:'Solo muestra las ultimas versiones de las hu',
	    	defaults: {scale: 'small'},
	    	items: [
	        	
	        	{text: 'Probadas',iconCls: 'aceptada_inv',scale: 'small',
                         handler:function(){ 
                                   jsonhispro.removeAll();
                                   jsonhispro.baseParams={filtro: 'probadas',tipo_version:'ultimas',task:'hispro'};
                                   jsonhispro.reload();	 
                                  }
                        },{text: 'Sin Probar',iconCls: 'rechazada_inv',scale: 'small',
                         handler:function(){
                                  jsonhispro.removeAll();
                                   jsonhispro.baseParams={filtro: 'sinprobar',tipo_version:'ultimas',task:'hispro'};
                                   jsonhispro.reload();	 
                                  }
                        },{text: 'Todos',iconCls: 'todo_inv',scale: 'small',
                         handler:function(){
                                   jsonhispro.removeAll();
                                   jsonhispro.baseParams={filtro: 'todas',tipo_version:'ultimas',task:'hispro'};
                                   jsonhispro.reload();	 
                                  }
                        }
			]
	   	}],

	/*plugins:[new Ext.ux.grid.Search({
				mode:          'local',
				position:      top,
				searchText:    'Filtrar',
				iconCls:  'filtrar',
				selectAllText: 'Seleccionar todos',
				searchTipText: 'Escriba el texto que desea buscar y presione la tecla enter'
		})],*/
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
     
      

      
      /*Con este formulario se envia los resultados de la evaluacion de una nueva historia de usuario*/
      var formPrueba = new Ext.form.FormPanel({
     //   renderTo: 'pruebaForm',
        split: true,
        region:'south',
	collapsible: true,    
        height: 260,
        title: 'Evaluar Historia',
        formId: 'formPrueba',
        autoScroll:true,
        layout:'column',
        monitorResize : true,
	bodyStyle: Ext.isIE ? 'padding:0 0 15px 15px;' : 'padding:10px 15px;',
//	autoWidth:true,
	deferredRender:false,
        frame: true,
        items:[{
            layout:'form',
           // width:'45%',
             width: 210,

            defaults:{minValue: 0,width:20,anchor:'95%',maxValue: 100,alternateIncrementValue: 1,incrementValue: 10,allowDecimals: false,allowNegative: false,accelerate: true},
	    items:[
	        {
	          xtype:'spinnerfield',//sp
		  name: 'negociable',
		  fieldLabel: 'Negociable',
		  allowBlank: false
	        },{
		  xtype:'spinnerfield',
		  name: 'valiosa',
		  fieldLabel: 'Valiosa',
		  allowBlank: false
		},{
		  xtype:'spinnerfield',
		  name: 'pequena',
		  fieldLabel: 'Pequeña',
		  allowBlank: false
		},{
		  xtype:'spinnerfield',
		  name: 'independiente',
		  fieldLabel: 'Independiente',
		  allowBlank: false
	    	},{
		  xtype:'spinnerfield',
		  name: 'estimable',
		  fieldLabel: 'Estimable',
		  allowBlank: false
	   	},{
		  xtype:'spinnerfield',
		  name: 'testeable',
		  fieldLabel: 'Testeable',
		  allowBlank: false
	      	},{
		  xtype: 'hidden', //para saber que HU se esta evaluando
		  name: 'his_id',
		  id: 'his_id',
		  allowBlank: false
		}
	        ],
	  buttonAlign: 'center',
          buttons: [ { id:'btnEvaluarHistoria',disable:true,text: 'Evaluar', handler: evaluarHistoria, formBind: true }]
	 },//end form 2
	{
            layout:'form',
	   // collapsible : true,
	    //split:true,
            width:'55%',	
	    labelAlign: 'top',
	    items:[
		{ 
		  xtype:'htmleditor',anchor:'100%',height:160,autoScroll:true,
		  name: 'comentarios',
		  fieldLabel: 'Comentarios'
		}]
        }]//end form 3
       // buttonAlign: 'center',
      //  buttons: [ { text: 'Probar', handler: evaluarHistoria, formBind: true }]
      });

    /*INTEGRACION AL CONTENEDOR*/
	var panelContenedorPruebaExperto = new Ext.Panel({
            id: 'panelContenedorPruebaExperto',
            height: heightCentro,
            autoWidth:true,
            title:'Validación de expertos',
            closable: true,
            frame:true,
            border:false,
            iconCls:'prueba',
	    tabTip :'Aqui puedes probar historias de usuario',

            monitorResize:true,
            layout:'border',
            items: [gridhu,formPrueba]
	});
   

///////****************FUNCIONES************************      

      //Esta funcion es la encargada de enviar la peticion de evaluacion de una historia de usuario
      //al servidor
      function evaluarHistoria()
      {
        if(Ext.getCmp('his_id').getValue() == '')
        {
          Ext.Msg.alert('Inform','Debe seleccionar la historia a probar');
        }else if(formPrueba.getForm().isValid())
        {
          formPrueba.getForm().submit({
            url: 'pruebaexperto/probar',
            method: 'POST',
            waitTitle: 'Guardar',
            waitMsg: 'Enviando datos...',
            success: function(fm,at){
              Ext.Msg.alert('inform',at.result.msg);
              jsonhispro.reload();
              formPrueba.getForm().reset();
            },
            failure: function(fm,at){Ext.Msg.alert('inform',at.result.msg);}
          });
        }else{
          Ext.Msg.alert('Inform','Faltan campos por llenar');
        }
        
      }
/*************************************/
/*Aqui tengo unas funciones para mostrar los mensajes de error y los avisos del sistema*/
/*************************************/



	function agregarBotonesPruebaExperto(){
		if(tieneRol("administrador") || tieneRol("tester")){
		 Ext.getCmp('btnEvaluarHistoria').setDisabled(false);
		}
	}
	
	agregarBotonesPruebaExperto();

//Notas: 
/*
Las historias de usuario que no han sido probadas en el campo de grid Probada tiene un NO y las que ya han sido probadas
un SI
*/
return panelContenedorPruebaExperto;
    }//Fin init

