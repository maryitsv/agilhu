
var Reportes = function () 
{
	
      /*******************FORMULARIO HISTORIA USUARIO************************/
	  var escalaTiempo='Dia';
	  var eqvDia=8;//horas
	  var eqvMes=20;//en dias
	 	  
 

      var historiasReporteStore = new Ext.data.GroupingStore({
        proxy: new Ext.data.HttpProxy({
		  url: 'reportes/cargar',
		  method: 'POST'
	      }),
       // autoLoad: true,
        baseParams:{
          task: 'LISTARHISTORIAS',
          escalaTiempo:escalaTiempo,
          equivalenteDia:eqvDia,
          equivalenteMes:eqvMes
        },
        id: 'historiasReporteStore',
        reader: new Ext.data.JsonReader({
		root: 'hispro',
		totalProperty: 'total',
		id: 'his_id'
	    	},
		[
		{name:'his_id', type: 'int'},
		{name:'his_nombre', type: 'string'},
		{name:'created_at',type: 'string'},
		{name:'his_creador',type: 'string'},
		{name:'updated_at',type: 'string'},
		{name:'his_prioridad',type: 'string'},
		{name:'his_responsable',type: 'string'},
		{name:'mod_id', type: 'int'},
		{name:'mod_nombre', type: 'string'},

		{name:'pro_id', type: 'int'},
		{name:'his_dependencias'},
		{name:'his_riesgo', type: 'int'},
		{name:'his_tiempo_estimado', type: 'double'},
		{name:'his_tiempo_real', type: 'double'},
		{name:'his_actor'},
		{name:'his_iteracion', type: 'int'},

		{name:'his_descripcion'},
		{name:'his_identificador_historia'},
		{name:'his_version'},
		{name:'his_unidad_tiempo'},
		{name:'his_observaciones'}
		]),
        sortInfo:{field: 'his_nombre', direction: "ASC"},
        groupField:'mod_nombre'
      });
      
      

 var expanderHUReporte = new Ext.ux.grid.RowExpander({
        tpl : new Ext.Template(
            '<p><b>Nombre HU:</b> {his_nombre}</p><br>',
            '<p><b>Descripcion:</b> {his_descripcion}</p>',
	    '<p><b>Obs:</b> {his_observaciones}</p>'
        )
    });
      //las columnas que se muestran en el grid
      var historiasReporteColmodel = new Ext.grid.ColumnModel([
       expanderHUReporte,
      {header: "# id", width: 30, sortable: true, dataIndex: 'his_identificador_historia',
          renderer: function(value,cell){  cell.css = "coolcell";return value;}
       },
       {header: "Nombre", width: 150, sortable: true, dataIndex: 'his_nombre',
	     summaryType: 'count',
             hideable: false,
             summaryRenderer: function(v, params, data){
                return ((v === 0 || v > 1) ? '(' + v +' Historias)' : '(1 Historia)');
             }
       },
       {header: "Unidad", width: 65, sortable: true, dataIndex: 'his_unidad_tiempo'},

       {header: "Duraci&oacute;n Estimada", width: 80, sortable: true, dataIndex: 'his_tiempo_estimado',summaryType: 'sum'},//renderizar
       {header: "Duraci&oacute;n Real", width: 80, sortable: true, dataIndex: 'his_tiempo_real',summaryType: 'sum'},//renderizar
       {header: "Prioridad", width: 70, sortable: true, dataIndex: 'his_prioridad'},
       {header: "Riesgo", width: 65, sortable: true, dataIndex: 'his_riesgo',summaryType: 'max'},
       {header: "Iteraci&oacute;n", width: 65, sortable: true, dataIndex: 'his_iteracion',summaryType: 'max'},
       {header: "Dependencias", width: 150, sortable: true, dataIndex: 'his_dependencias'},
       {header: "Actores", width: 150, sortable: true, dataIndex: 'his_actor'},
       {header: "Responsable", width: 150, sortable: true, dataIndex: 'his_responsable'},
       {header: "M&oacute;dulo", width: 150, sortable: true, dataIndex: 'mod_nombre'},
       {header: "Versi&oacute;n", width: 60, sortable: true, dataIndex: 'his_version'},
       {header: "Creada", width: 120, sortable: true,  dataIndex:'created_at',hidden:true,summaryType: 'max'},
       {header: "Actualizada", width: 120, sortable: true, dataIndex:'updated_at',hidden:true,summaryType: 'max'},       
      ]);
      
	historiasReporteStore.load();

   
    var summary = new Ext.ux.grid.GroupSummary();


        var huReporteGrid = new Ext.grid.GridPanel({
        stripeRows:true,
        columnLines : true,
    	store: historiasReporteStore,
        cm: historiasReporteColmodel,
        sm: new Ext.grid.RowSelectionModel({
          singleSelect:true,
          listeners: {
            rowselect: function(s, i, r){
            }
          }
        }),
        listeners:{//este evento puede no estar definido en la version de Extjs
          viewready: function(g){
            g.getSelectionModel().selectRow(0);
          }
        },
        height: 300,
        frame: true,
        title: 'Historias del proyecto',
        iconCls: 'icon-grid',
        view: new Ext.grid.GroupingView(),	
        plugins:[summary,expanderHUReporte],
        tbar:[
            {text:'Imprimir Todas las historias',iconCls:'historias',handler:function(){imprimirDocumentacion();}},
            {text:'Imprimir Listado de historias',iconCls:'reportes',handler:function(){imprimirListadoHUFun();}}],
        fbar:[
              {text:'Escala '+escalaTiempo,tooltip:'Dada esta escala de tiempo configure su equivalente en hora, dias y meses, y pulse el boton recargar',handler:cambiarConfiguracionTiempo,id:'btnEscala'},
              {text:'Dia:'+eqvDia+' horas ',handler:cambiarConfiguracionTiempo,id:'btnDia'},
              {text:'Mes:'+eqvMes+' dias ',handler:cambiarConfiguracionTiempo,id:'btnMes'}]//,
             // {text:'Recargar'}]
      }); 


      function cambiarConfiguracionTiempo(){
	
	
	
       var configTiempoForm=new Ext.FormPanel({
       layout:'form',
       id:'configTiempoForm',
       buttonAlign:'center',
       name:'configTiempoForm',
       bodyStyle:'padding:10px',
       frame:true,	
       defaults:{xtype: 'textfield',width:50, labelStyle:'width: 140px;'},
       autoScroll:true,
       items:[     /*{
                    fieldLabel: 'Escala de tiempo',
                    name: 'configuracion_escala_tiempo',
                    value:escalaTiempo,
                    id: 'configuracion_escala_tiempo'
                    },*/
                   {
		    xtype:      'radiogroup',
		    fieldLabel: 'Escala de tiempo',
		    items: 
		    [{
		    column: '.3',
		    items:[
                            {boxLabel:'Hora',name:'conf_esc_tiempo',id:'escala_hora',inputValue: 'hora',checked:true},
			    {boxLabel:'Dia',name:'conf_esc_tiempo',id:'escala_dia',inputValue: 'dia'},
			    {boxLabel:'Mes',name:'conf_esc_tiempo',id:'escala_mes',inputValue: 'mes'}
			   ]
		    }]
		   },
                   {
                    fieldLabel: 'Cuantas horas hay en una dia de trabajo?',
                    name: 'eqv_horas_del_dia',
                    value:eqvDia,
                    id: 'eqv_horas_del_dia'
                    },
                   {
                    fieldLabel: 'cuantos dias hay en un mes de trabajo?',
                    name: 'eqv_dias_del_mes',
                    value:eqvMes,
                    id: 'eqv_dias_del_mes'
                    }
            
         ],
       buttons:[{text:'Configurar',handler:configurarReporte},
             {text:'Cancelar'}
       ]   
       });
	
	 var configTiempoWindow = new Ext.Window({
          title: 'Configuracion escala de tiempo',
          id:'configTiempoWindow',
          width:300,
          height:330,
          plain:true,
          layout: 'fit',
          modal :true,
          items: [configTiempoForm]
        });

        configTiempoWindow.show();
        
         function configurarReporte(){
           if(Ext.getCmp('escala_hora').getValue())
           {escalaTiempo='Hora'}
           if(Ext.getCmp('escala_dia').getValue())
           {escalaTiempo='Dia'}
           if(Ext.getCmp('escala_mes').getValue())
           {escalaTiempo='Mes'}


	   eqvDia=Ext.getCmp('eqv_horas_del_dia').getValue();//horas
	   eqvMes=Ext.getCmp('eqv_dias_del_mes').getValue();//en dias
          
          historiasReporteStore.baseParams={task:'LISTARHISTORIAS',
                                 escalaTiempo:escalaTiempo,
                                 equivalenteDia:eqvDia,
                                 equivalenteMes:eqvMes};
       
	  historiasReporteStore.reload();

          huReporteGrid.setTitle('Historias de usuario ultimas versiones,estimacion de tiempos en '+escalaTiempo);

          Ext.getCmp('btnEscala').setText('Escala:'+escalaTiempo);
          Ext.getCmp('btnDia').setText('Dia:'+eqvDia+' horas ');
          Ext.getCmp('btnMes').setText('Mes:'+eqvMes+' dias ');
 

          configTiempoWindow.close();
         }

      }
      
      	var panelContenedorReportes = new Ext.Panel({
            id: 'panelContenedorReportes',
            height: heightCentro,
            autoWidth:true,
            title:'Reportes',
            tapTip:'Aqui consulte toda la informacion del proyecto',
            closable: true,
            frame:true,
            iconCls:'reportes',
            monitorResize:true,
            autoScroll:true,
            layout:'border',
            items: [
                {
                layout:'fit',
                items:huReporteGrid,
                split: true,
                border:false,
                autoScroll:true,
                region:'center'
                }        
            ],
          //  renderTo:'gridhu',
	});



      
   function imprimirDocumentacion(){
	  //ventana de configuracion especial
	
		
	var moduloImprimirDataStore=new Ext.data.JsonStore({
            url: 'reportes/cargar',
            baseParams:{task: 'LISTARMOD'},
            autoLoad:true,
            idProperty:'id',
            root: 'results',
            fields:['mod_id','mod_nombre'] 
        });
        moduloImprimirDataStore.load();

	var modImpSelecionado=new Ext.grid.CheckboxSelectionModel();
	//grilla con lo modulos
	moduloImprimirGrid =  new Ext.grid.GridPanel({
		id: 'moduloImprimirGrid',
		stripeRows:true,
		store: moduloImprimirDataStore,
		cm: new Ext.grid.ColumnModel({
			columns:[
			{header: 'id',dataIndex: 'mod_id',width: 40,hidden:true},
			{header: 'Nombre',dataIndex: 'mod_nombre',width: 150},
			modImpSelecionado],
			defaults:{sortable:true}}),
		height: 150,
		width:200,
		autoScroll:true,
		border: true,
		style:{ marginBottom: '15px'},
		sm:modImpSelecionado
	});
	
       var imprimirDocForm=new Ext.FormPanel({
       layout:'column',
       id:'imprimirDocForm',
       buttonAlign:'center',
       name:'imprimirDocForm',
       frame:true,	
       autoScroll:true,
       items:[{
            xtype:'fieldset',
            columnWidth:1,
            title: 'Informaci&oacute;n general',
            bodyStyle:'padding:15px',
            defaults:{xtype: 'checkbox',hideLabel :true,anchor:'100%'},
            items:[{
                    boxLabel: 'Incluir Informacion del Proyecto',
                    name: 'info_pro',
                    checked:true,
                    id: 'info_pro'
                    },{
                    boxLabel: 'Incluir Informacion de Modulos',
                    name: 'info_mod',
                    checked:true,
                    id: 'info_mod'
                    },
                  //  moduloImprimirGrid,
                    {
                    boxLabel: 'Incluir resultados de las evaluaciones de las HU',
                    name: 'info_eval',
                    checked  :true,
                    id: 'info_eval'
                    }
                  ]
         }
         ],
       buttons:[{text:'Imprimir',handler:imprimirDocumentoFun},
             {text:'Cancelar',handler: function(){imprimirDocWindow.close();}}
       ]   
       });
	
	 var imprimirDocWindow = new Ext.Window({
          title: 'Configuracion documentos a imprimir',
          id:'imprimirDocWindow',
          width:340,
          height:200,//400,
          plain:true,
          layout: 'fit',
          modal :true,
          items: [imprimirDocForm]
        });

        imprimirDocWindow.show();

       function imprimirDocumentoFun()
      {
          var info_pro=Ext.getCmp('info_pro').getValue();
          var info_mod=Ext.getCmp('info_mod').getValue();
          var info_eval=Ext.getCmp('info_eval').getValue();
          var modulosSelecionados=moduloImprimirGrid.selModel.getSelections();
          var modulosArray = [];
        
          for(i = 0; i< moduloImprimirGrid.selModel.getCount(); i++){
               modulosArray.push(modulosSelecionados[i].json.mod_id);
          }  
          var enc_array_mod_ids = Ext.encode(modulosArray);

          var url = URL_AGILHU+'pusuario.php/reportes/documento?task=DetalleHistorias&info_pro='+info_pro+'&info_mod='+info_mod+'&info_eval='+info_eval+'&mod_ids='+enc_array_mod_ids;
          win = window.open(url,'Reporte de todo el proyecto','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
	  	
	
       }
  
   }

  function imprimirListadoHUFun()
      {
          var url = URL_AGILHU+'pusuario.php/reportes/documento?task=listadoHistorias';
          win = window.open(url,'Reporte lista de historias proyecto','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
	
       }
////////////////**Bloquear y desbloquear campos

	function desbloquearCamposHU(){
		if(tieneRol("cliente")){//nombre, identificador, prioridad, descripcion y observaciones puede modificar, el boton crear esta activo para el
		
		}
		if(tieneRol("programadror")){// modificar:estimacion de tiempo y unidad dependencia responsables, todos los botones botones 
		
		}
	}
	
	desbloquearCamposHU();
return panelContenedorReportes;

}//Fin function
//Bajo las siguientes supociciones
//toda la inforacion en horas
//un dia 8 horas
//una mes 1= 20 dias habiles




