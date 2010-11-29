var HistoriaUsuario = function () 
{

      Ext.QuickTips.init();
      var id_Modulo=0;
      /*******************FORMULARIO HISTORIA USUARIO************************/
  
      
      /*
      Esta es la funcion encargada controlar la accion sobre las hu
      */
    var enviarDatos = function(btn){
		if(Ext.getCmp('btForm').getText()=='Versionar')
		{
			var temporal_his_id=Ext.getCmp('his_id').getValue();
			if(temporal_his_id!=''){
			  nuevaVersionHistoria();
			}
			else{
			  Ext.Msg.alert('Informaci&oacute;n','Selecione primero una historia de usuario a versionar');
			}
		}
		else{

			if(Ext.getCmp('btForm').getText()=='Actualizar')
			{
				var temporal_his_id=Ext.getCmp('his_id').getValue();
				if(temporal_his_id!=''){
				  enviarDatosDefinitivo(btn.getText());
				}
				else{
				  Ext.Msg.alert('Informaci&oacute;n','Selecione primero una historia de usuario a actualizar');
				}
			}
			else{
		 	 enviarDatosDefinitivo(btn.getText());
			}
		}
    }

 	/*
      Esta es la funcion encargada mandar los datos de una HU al servidor
      */
      var enviarDatosDefinitivo = function(btntext){

		if(formHU.getForm().isValid())
		{
		  formHU.getForm().submit({
		    url: 'historiasusuario/guardar',
		    method: 'POST',
		    waitTitle: 'Guardar',
		    waitMsg: 'Enviando datos...',
		    params:{
		      task: btntext,
                      mod_id:id_Modulo,
                      his_dependencias:Ext.getCmp('his_dependencias').getValue(),
                      his_responsable:Ext.getCmp('his_responsable').getValue(),
                      his_unidad_tiempo:Ext.getCmp('his_unidad_tiempo').getValue(),
                      his_tiempo_estimado:Ext.getCmp('his_tiempo_estimado').getValue(),
                      his_tiempo_real:Ext.getCmp('his_tiempo_real').getValue(),
                      his_riesgo:Ext.getCmp('his_riesgo').getValue(),
                      his_identificador_historia:Ext.getCmp('his_identificador').getValue()
                      
		    },
		    success: function(fm,at)
		    {
		        Ext.Msg.alert('inform',at.result.msg);
		        jsonhispro.reload();
			formHU.getForm().reset();
		    },
		    failure: function(fm,at)
		    {
		        Ext.Msg.alert('inform',at.result.msg);
		    }
		  });
		  
		}else{
		  Ext.Msg.alert('Informacion','Faltan campos por llenar');
		}
	
      }
	  
     //carga todas las hu teniendo encuenta su identicicadion_his
     var dependenciasDataStore=new Ext.data.JsonStore({
			url: 'historiasusuario/listar',
			baseParams:{
			  task: 'IDENTIFICADORHU'
			},
			autoLoad:true,
			root: 'results',//las HU por modulo
			idProperty: 'his_id',
			fields:['his_identificador_historia'] //los campos de la respuesta 
		      });


	//carga todos los participantes con rol programador para asignacion de trabajo
     var responsablesDataStore=new Ext.data.JsonStore({
			url: 'historiasusuario/listar',
			baseParams:{
			  task: 'RESPONSABLESPROGRAMADORES'
			},
                        autoLoad:true,
                        idProperty:'id',
			root: 'results',
			fields:['usu_usuario'] 
		      });
			  

   //modulo de una histori user
   var moduloHisDataStore = new Ext.data.Store({
	id: 'moduloHisDataStore',
	proxy: new Ext.data.HttpProxy({
		  url: 'historiasusuario/listar', //cambiar a historia de usuario
		  method: 'POST'
	      }),
        autoLoad:true,
	baseParams:{task: 'LISTARMOD'}, 
	reader: new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'id'
	    },[{name: 'modId'},{name: 'modNombre'}]),
	sortInfo:{field: 'modNombre', direction: "ASC"}
    });


	    /*tree combo*/
     var comboAlias = new Ext.form.ComboBox
      ({         name:'modmalo_id',
		//id:'h_mod_id',
		 msgTarget: 'side',
		fieldLabel:'Modulo',
		frame:true,
		store:moduloHisDataStore,
		mode:'local',
                editable:false,
		emptyText:'Modulo al cual esta asociada la historia',
		displayField:'modNombre',
		valueField:'modId',
		triggerAction:'all',
		forceSelection:true,
		hiddenName :'modmalo_id',
		allowBlank:false,
		anchor:'90%',
		/*listeners:{'focus':function(campotextfield){moduloHisDataStore.reload();},
		      },*/
                maxHeight: 200,
                tpl: '<tpl for="."><div><div id="treeAddAlias"></div></div></tpl>',
                selectedClass: '',
                onSelect: Ext.emptyFn,
                renderer:
                    function(data)
                    {
                        record = moduloHisDataStore.getById(data);
                        if(record)
                        {return record.data.modNombre;}
                        else
                        {return data;}
                    }
                
            });
        
            var treeAlias = new Ext.tree.TreePanel
            ({
                loader: new Ext.tree.TreeLoader({dataUrl: URL_AGILHU+'pusuario.php/modulo/listarmodjer'}),
                root: new Ext.tree.AsyncTreeNode(),
                rootVisible: false,
                lines: false,
                autoScroll: true,
                border: false,
                height: 200,
                enableDD: false,
                useArrows: true,
                listeners:
                {
                    click: function(node)
                    {
                       comboAlias.setValue(node.attributes.modId);
			id_Modulo=node.id;
                      // comboAlias.collapse();
                    }
                }
            });

            comboAlias.on('expand', function()
            {
                treeAlias.render('treeAddAlias');
            });
         
            moduloHisDataStore.on('load', function(n)
            {
              //comboAlias.setValue('juju'); 
              //  comboAlias.setValue(category.attributes.alias); 
            });
       
            moduloHisDataStore.load();

/*end combo tree*/

      //formulario para la creacion de una nueva historia de usuario
      var formHU = new Ext.form.FormPanel({
       title: 'Historia De Usuario',//esto debe ser dinamico tomo el nombre de la historia seleccionada
       formId: 'formHU',
       frame: true,
       deferredRender:false,
       autoScroll:true,
       bodyStyle: Ext.isIE ? 'padding:0 0 15px 15px;' : 'padding:10px 15px;',
       width: 700,
       items:[
       {//anchor layout los 3 campos Autor, modulo, proyecto deben estar y tener los valores por defecto 
         layout: 'column',labelWidth:75,
         defaults:{layout:'form'},
         items:[
           {
             xtype: 'hidden',name: 'his_id',id:'his_id'
           },
           {
             columnWidth: '0.5',
             items:[
               {
                xtype: 'textfield',
                fieldLabel: 'Autor',
                anchor: '90%',
                disabled: true,
                name: 'his_creador'
               }
             ]
           },
           {
             columnWidth: '0.5',labelWidth:77,
             items:[comboAlias
             ]
           }
         ]
       },//identificador y author 
       {//el campo nombre de HU y al frente el identificador 
         layout: 'column',labelWidth:77,
         defaults:{layout:'form'},
         items:[
           {
             columnWidth: '0.5',labelWidth:75,
             items:[
               {
                 xtype: 'textfield',
                  msgTarget: 'side',
                 fieldLabel: 'Nombre HU',
                 allowBlank: false,
                 maxLength: 100, //cambiar a futuro 
                 anchor:'90%',
                 emptyText: 'Digite el nombre de la Historia de usurio',
                 name: 'his_nombre',
                 id:'his_nombre',
               }
             ]
           },
           {
            columnWidth: '0.27',//30
            items:[
              {
                xtype: 'textfield',
                fieldLabel: 'Idenficador',
                 msgTarget: 'side',
                id: 'his_identificador',//esto es para cambiar sus propiedades
               // allowBlank: false,//cambio
                disabled:true,
                vtype: 'alphanum',
                vtypeText:'Solo numeros y letras',
                maxLength: 20,
                maxLengthText: 'No se permiten mas de 20 caracteres',
            //    emptyText: 'Digite el identificador',
                anchor: '95%',
                name: 'his_identificador_historia'
              }
            ]},

	  {
            columnWidth: '0.2',labelWidth:50,
            items:[
              {
                  xtype: 'combo',
                  fieldLabel: 'Prioridad',
                   msgTarget: 'side',
                  store: ['Alta','Media','Baja'],
                  anchor: '90%',
                  forceSelection: true,
                  triggerAction: 'all',
                  mode: 'local',
                  name: 'his_prioridad',
                  id:'his_prioridad'
                }]},
         //  }
         ]
       },
       {//column layout con 2 colum
         layout:'column',
         defaults:{
           labelWidth:75,
           layout: 'form'
         },
         items:[{columnWidth:'0.5',
             items:[new Ext.ux.form.LovCombo({
		 id:'his_dependencias',
                  msgTarget: 'side',
                // disabled:true,
                 fieldLabel:'Dependencia',//Un string con los identificadores de las historias de las cuales depende
                 name:'his_dependencias',
                      
	        store:dependenciasDataStore,
		valueField:'his_identificador_historia',
		displayField:'his_identificador_historia',
                mode:'local',
                anchor:'90%'
		})]
         	 },
		
		{columnWidth:'0.5',labelWidth:77,
             items:[new Ext.ux.form.LovCombo({
                 id:'his_responsable',
                  msgTarget: 'side',
                 disabled:true,
                 fieldLabel:'Responsables',//Un string con los usuarios responsables
                 name:'his_responsable',
	        store:responsablesDataStore,
		valueField:'usu_usuario',
		displayField:'usu_usuario',
                mode:'local',
                anchor:'90%'
		})]}
	       
	 	]
          
       },/**/
{//column layout con 2 colum
         layout:'column',
         defaults:{
           labelWidth:75,
           layout: 'form'
         },
         items:[{columnWidth:'0.5',
                 items:[{
                       xtype      : 'textfield',
                       id         : 'tfactor',
                       msgTarget: 'side',
                       anchor     : '90%',
                      // allowBlank : false,//no creo que deba ser obligatorio
                       fieldLabel : 'Actor(es)',
                       name       : 'his_actor'
                   }]//un layout column con 2 filas de 3 columnas (ver cuarderno)]
         	 },
		{columnWidth:'0.5',labelWidth:77,
                 items:[new Ext.form.NumberField({
                        fieldLabel: 'Iteracion',
                        msgTarget: 'side',
                        anchor: '90%',//para darle un tamaño pequeño
                        name: 'his_iteracion',
                        id:'his_iteracion'
                        })
                       ]
                }      
	 ]
       },
       {
         layout: 'column',
         defaults:{layout:'form'},
         items:[
           {
             columnWidth: '0.28',
             items:[
               {
                 xtype: 'combo',
                 disabled:true,
                 msgTarget: 'side',
                 id:'his_unidad_tiempo',
                 fieldLabel: 'Unidad de tiempo',
                 anchor: '90%',
                 store: ['Mes','Dia','Hora'],
                 mode: 'local',
                 forceSelection: true,
                 triggerAction: 'all',
                 name: 'his_unidad_tiempo'
               }
             ]
           },//la primera columna con los campos Riesgos y unidad de tiempo
           {
              columnWidth: '0.25',
              items:[
                new Ext.form.NumberField({
                 msgTarget: 'side',
                 id: 'his_tiempo_estimado',
                 disabled:true,
                 fieldLabel: 'Tiempo estimado',
                 nanText: 'No es un numero',
                 anchor: '90%',//para darle un tamaño pequeño
                 name: 'his_tiempo_estimado'
               })
              ]
           },// modificacion y tiempoEs
           {
             columnWidth: '0.22',labelWidth:70,
             items:[
		
                new Ext.form.NumberField({
                 id:'his_tiempo_real',
                 msgTarget: 'side',
                 disabled:true,
                 fieldLabel: 'Tiempo real',
                 nanText: 'No es un numero',
                 anchor: '90%',//para darle un tamaño pequeño
                 name: 'his_tiempo_real'
               })
             ]
           },//responsable y tiempoReal
          {labelWidth:45,columnWidth:'0.18',
             items:[new Ext.form.NumberField({ 
                 msgTarget: 'side',
                 id:'his_riesgo',
                 disabled:true,
                 fieldLabel: 'Riesgo',
                 nanText: 'No es un numero',
                 blankText: '0 sin y 9 maximo riesgo',
                 maxLength: 1,
                 maxLengthText: 'Solo se permite un digito',
                 emptyText: '0-9',
                 anchor: '90%',//para darle un tamaño pequeño
                 name: 'his_riesgo'
               })]}
         ]
       },
       {
         xtype: 'fieldset',
         title: 'Descripción',
	 labelAlign:'top',
         collapsible: true,
         collapsed: false,
	 id:'panel_descripcion',
         items: [
           {
             fieldLabel:'Descripcion',
             xtype: 'htmleditor',
             height: 300,
	     anchor:'98%',
             name: 'his_descripcion'
           },{
             fieldLabel:'Observaciones',
             xtype: 'textarea',
             height: 150,
             name: 'his_observaciones',
             anchor:'98%'
           }
	
         ]
       },//contine en htmleditor para la descripcion con label top
       {
         layout: 'column',
         defaults:{layout:'form'},
         items:[
           {
             columnWidth: '.5',
             items:[
               {
                 xtype: 'textfield',
                 fieldLabel: 'Creada',
                 disabled: true,
                 name: 'created_at'
               },
		{
		     width: '33%',
		     items:[
		       {
		         xtype: 'textfield',
		         fieldLabel: 'Proyecto',
		         anchor: '90%',
		         hidden:true,
		         name: 'pro_id'
		       }
		     ]
		}
             ]  
           },//fecha de creacion
           {
             columnWidth: '.5',
             items:[
               {
                 xtype: 'textfield',
                 fieldLabel: 'Modificada',
                 disabled: true, //ya que las fechas no son editables
                 name: 'updated_at'
               },
            {xtype: 'textfield', anchor:'100%',hidden:true,name: 'his_version'}
          
             ] 
           }//fecha actualizacion
         ]
       }// los campos con la fecha de creacion y actualizacion no editables
       ],
       buttonAlign: 'center',
       buttons: [{id:'btForm', iconCls:'guardar',text:'Crear',formBind: true, handler: enviarDatos},
				  {text: 'Estimar', iconCls:'estimacion', handler: estimarHistoria, tooltip: 'Estimar el costo de la historia selecionada'}
				  ]
      });
  

      ///grid donde estaran listadas las historias de usurio que pertenecen al pryecto actual
      var jsonhispro = new Ext.data.GroupingStore({//--JsonStore
        proxy: new Ext.data.HttpProxy({
		  url: 'historiasusuario/listar',
		  method: 'POST'
	      }),
       // autoLoad: true, //esto no es necesario
        baseParams:{
         // proyecto: 43, //cambio lo quite porq se maneja en el action
          task: 'hispro'
        },
        id: 'jsonhispro',
        reader: new Ext.data.JsonReader({
		root: 'hispro',
		totalProperty: 'total',
		id: 'his_id'
	    	},
		[
		{name:'his_id', type: 'int'},
		{name:'his_nombre', type: 'string'},
		{name:'created_at',type: 'string'},//timestamp buscar tipo conpatibel
		{name:'his_creador',type: 'string'},
		{name:'updated_at',type: 'string'},
		{name:'his_prioridad',type: 'string'},
		{name:'his_responsable',type: 'string'},
		{name:'mod_id', type: 'int'},
		{name:'mod_nombre', type: 'string'},

		{name:'pro_id', type: 'int'},
		{name:'his_dependencias'},
		{name:'his_riesgo', type: 'int'},
		{name:'his_tiempo_estimado', type: 'int'},
		{name:'his_tiempo_real', type: 'int'},
		{name:'his_descripcion'},
		{name:'his_identificador_historia'},
		{name:'his_version'},
		{name:'his_unidad_tiempo'},
		{name : 'his_actor'},//cambio v 1.1
		{name:'his_iteracion'},//cambio v 1.1

		//estos campos no estan incluidos en el formulario se usan por debajo
		{name:'his_tipo_actividad', type: 'int'},
		{name:'his_observaciones'}
		]),
        sortInfo:{field: 'his_nombre', direction: "ASC"},
        groupField:'mod_nombre'
      });
      
 var expanderHU = new Ext.ux.grid.RowExpander({
        tpl : new Ext.Template(
            '<p><b>Nombre HU:</b> {his_nombre}</p><br>',
            '<p><b>Descripción:</b> {his_descripcion}</p>'
        )
    });
      //las columnas que se muestran en el grid
      var colmodelHu = new Ext.grid.ColumnModel([
       expanderHU,
     //  new Ext.grid.RowNumberer(),
       {header: "# id", width: 30, sortable: true, dataIndex: 'his_identificador_historia',
          renderer: function(value,cell){ 
           cell.css = "coolcell";
           return value;
             }
       },
       {header: "Nombre", width: 150, sortable: true, dataIndex: 'his_nombre'},
       {header: "Duracion", width: 80, sortable: true, dataIndex: 'his_tiempo_estimado',renderer: estimacion },//renderizar
       {header: "Prioridad", width: 70, sortable: true, dataIndex: 'his_prioridad'},
       {header: "Riesgo", width: 70, sortable: true, dataIndex: 'his_riesgo'},
       {header: "Creada", width: 120, sortable: true,  dataIndex:'created_at',hidden:true},
       {header: "Actualizada", width: 120, sortable: true, dataIndex:'updated_at'},
       
       {header: "Responsable", width: 150, sortable: true, dataIndex: 'his_responsable'},
       {header: "Modulo", width: 150, sortable: true, dataIndex: 'mod_nombre'}
      ]);
      
	//nuevo
        jsonhispro.load();

      //poner la duracion a la izquierda de unidad de tiempo
      function estimacion(val,x,st)
      {
        return ' '+val+' '+st.data.his_unidad_tiempo;
      }

  /**
  * Funcion encargada de hacer el calculo de la estimacion para una historia de usuario.
  * 
  */
  function estimarHistoria()
  {
      if(gridhu.getSelectionModel().getCount() > 0 ){
	  var recordHistoria = gridhu.getSelectionModel().getSelected();
	  var winEstimacion=agilhu.wammetEstimacion(recordHistoria.get('his_id'),recordHistoria.get('his_nombre'));
	  winEstimacion.on('close',function(panel){
	    jsonhispro.reload();
	  });
	  winEstimacion.show();

      }else{
	  Ext.Msg.alert('INFORM','Seleccione una historia de usuario');
      }
  }


  //modulo de una historia user
   var filtroHisDataStore = new Ext.data.JsonStore({
	id: 'filtroHisDataStore',
	url: 'historiasusuario/listar', //cambiar a historia de usuario
        autoLoad:true,
	baseParams:{task: 'FILTROHIS',
		    tipo:'Modulo',
		    filtro:'si'
			}, 
	idProperty:'id',
	root: 'results',
	fields:['filtro_display','filtro_valor'] 
    });
    filtroHisDataStore.load();

var menu=0;
var huSeleccionada;
      //proyecto 43 tiene modulo 1, 2 y 3 
      var gridhu = new Ext.grid.GridPanel({
	stripeRows:true,
        store: jsonhispro,
        cm: colmodelHu,
        sm: new Ext.grid.RowSelectionModel({
          singleSelect:true,
          listeners: {
            rowselect: function(s, i, r){
              Ext.getCmp('btForm').setText('Actualizar');
              
              formHU.getForm().loadRecord(r);
               comboAlias.setValue(r.data.mod_id);
               id_Modulo=r.data.mod_id;
            //  Ext.getCmp('his_identificador').setDisabled(false);
            }
          }
        }),
        listeners:{//este evento puede no estar definido en la version de Extjs
          viewready: function(g){
            g.getSelectionModel().selectRow(0);
          },//nuevo onContextClick
        rowcontextmenu  : function(grid, index, e){

       huSeleccionada=jsonhispro.getAt(index);//record seleccionado

           if(!menu){ // create context menu on first right click
               
               menu = new Ext.menu.Menu({
                   // id:'grid-ctx',
                    items: [{
                        text: 'Ver evaluación',
                        iconCls: 'filtrar',
                        scope:this,
                        handler: verResultadoEvaluacion
                      }/* ++ ,{
                        iconCls: 'new',
                        text: 'Imprimir esta historia',
                        scope:this,
                        handler: ImprimirHistoria
                      } ++ */
                      ]
                });

             
            }
                e.stopEvent();

            menu.showAt(e.getXY());
        }
//end nuevo
        },
        height: 300,
        frame: true,
        title: 'Historias del proyecto',
        iconCls: 'icon-grid',
        tbar:[{
               xtype: 'buttongroup',
               title: 'Opciones de Historias de usurio',
               autoWidth: true,
               columns: 5,
               defaults: {xtype: 'button',scale: 'large',width: '100%',iconAlign: 'top'},
               items:[{text:'Nuevo',iconCls:'nueva_his',tooltip:'Crear nuevas historias de usuario',handler: crearHistoria },//prepara el formulario para la creacion de una nueva hu
		      {text:'Nueva version',iconCls:'versionar_his',tooltip:'Crear una nueva version de una historia seleccionada',handler:versionarHistoria},//versionado de hu a partir de seleccionada
		      {text: 'Consultar historial',iconCls:'historial_his',tooltip:'Consultar todas las versiones de una historia de usuario',handler:mostrarHistorial},
               	      {text: 'Exportar a XMI',iconCls:'xml_his_grande', handler: exportarHistoriatoXMI ,tooltip:'Pulse aqui para exportar a xmi'},
			{text: 'Eliminar', iconCls:'eliminar', handler: eliminarHistoria, tooltip: 'Eliminar la historia selecionada'   }
               	    //  {text: 'Estimar', iconCls:'xml_his_grande', handler: estimarHistoria, tooltip: 'Estimar el costo de la historia selecionada'   } //Estimacion integracion pendiente cambio de icono
                      ]
               },
		{
               xtype: 'buttongroup',
               title: 'Busqueda',
               autoWidth: true,
               columns: 2,
               defaults: {width: '90%',iconAlign: 'left'},
               items:[{text:'Criterio',iconCls:'buscar',iconAlign: 'top',rowspan:2,scale: 'large',
                       menu:{items:[
                                    {text:'Modulo',group:'busqueda_his',checked: true,tooltip:'Buscar por modulo',handler: filtrarHistoria },
				    {text:'Participante',group:'busqueda_his',checked: false,tooltip:'Busca por participante responsable o creador',handler:filtrarHistoria},
				    {text:'Dependencia',group:'busqueda_his',checked: false,tooltip:'Buscar por dependencias',handler: filtrarHistoria },
				    {text:'Otro',group:'busqueda_his',checked: false,tooltip:'Consultar por cualquier campo',handler:filtrarHistoria},
				    ]
                                        }
		      },
		      new Ext.form.ComboBox({
				id:'filtro_his',
				name:'filtro_his',
				fieldLabel:'filtro_his',
				store:filtroHisDataStore,
				mode:'local',
                                width:20,
                                boxMaxWidth:20,
				emptyText:'Palabra clave',
				displayField:'filtro_display',
				valueField:'filtro_display',
				triggerAction:'all',
				disabled:false,
				enableKeyEvents:true,
                                listeners:{
					'blur':function(){filtroHistoriasUsuario();},
					'select':function(){filtroHistoriasUsuario();},
					'keyup':function(){filtroHistoriasUsuario();},
					'keydown':function(){filtroHistoriasUsuario();},
					'render':function(){
					//para poner  enter
					}//end render
				}
			}),
		
                      ]
               },
		{
               xtype: 'buttongroup',
               title: 'Detalle',
               autoWidth: true,
	       
               columns: 3,
               defaults: {xtype: 'button',scale: 'large',width: '100%',iconAlign: 'top'},
               items:[{text:'Ocultar',scale:'large',iconCls:'sin_panel',tooltip:'Pulse para ocultar el panel o ajustarlo al area de trabajo',
			   handler:function(btn){
					if(btn.getText()=='Ocultar'){formHU.ownerCt.hide();
					   formHU.ownerCt.ownerCt.doLayout();
					   gridhu.doLayout();
					   btn.setIconClass('con_panel');
					   btn.setText('Mostrar');
					}
					else
					{
					var lado = Ext.getCmp('este-hu');
					lado.add(formHU);
				    	lado.show();
				    	lado.ownerCt.doLayout();
					btn.setIconClass('sin_panel');
					btn.setText('Ocultar');
				      	}
					}
			}]
		}
         
        ],
        view: new Ext.grid.GroupingView(),	
	//plugins:expanderHU,
	plugins:[expanderHU],
      });
  

	var filtroHistoriasUsuario=function ()
	{
	var val = Ext.getCmp('filtro_his').getValue();
	var store = jsonhispro;
	var cm = ['his_nombre','his_tiempo_estimado','his_responsable','his_prioridad','mod_nombre','his_creador'];

	store.clearFilter();
	if(val) {
	 // agaviso(val);
	  store.filterBy(function(record) {
	     var retval = false;
	     for(var contador=0;contador<cm.length;contador++)
	     {
			if(retval) {return true;}
		  	var rv = record.get(cm[contador]);
			var re = new RegExp(val, 'gi');
			retval = re.test(rv);
	     }		  
	     return retval;
	  });//end filterby
	}//end if

	}

      //carga un combo box segun el criterio de busqueda    
      function filtrarHistoria(cmp)
      {
	Ext.getCmp('filtro_his').setValue('');	

	filtroHisDataStore.baseParams = {
					task: 'FILTROHIS',
					tipo: cmp.text,
					filtro:'si'
					};		
	filtroHisDataStore.reload();
      }


      /*
      *Este metodo se encarga de dejar listo el formulario para la creacion de una nueva historia de usuario
      **/
      function crearHistoria()
      { 
        formHU.getForm().reset();
        Ext.getCmp('btForm').setText('Crear');
       // Ext.getCmp('his_identificador').setDisabled(false);
	Ext.getCmp('panel_descripcion').expand (true);
	
      }
      
      
      	var panelContenedorHU = new Ext.Panel({
            id: 'panelContenedorHU',
            height: heightCentro,
            autoWidth:true,
            title:'Historias de Usuario',
           closable: true,
           frame:true,
           border:false,
           iconCls:'historias',
	   tabTip :'Crear, versiona y asignacion de historias de usuario',
            monitorResize:true,
            autoScroll:true,
            layout:'border',
            items: [
                {
                id:'centro-hu',
                layout:'fit',
                items:gridhu,
                split: true,
                border:false,
                autoScroll:true,
                region:'center'
                },
                {
                id:'este-hu',
		collapsible: true,
                layout:'fit',
                width: 700,
                heigth:500,
		collapseMode:'mini',
                items:formHU,
                autoScroll:true,
                split: true,
                border:true,
                header: false,
                region:'east'
                }
            ]//,
          //  renderTo:'gridhu',
	});

      
      
      /*
      *Este cambia el texto del boton para que en el servidor no se actulice la historia de usuario
      *si no que se cree una nueva version que contenga la informacion contenida en esta
      **/
      function versionarHistoria()
      {
        Ext.getCmp('btForm').setText('Versionar');
        //campos que no se podran modificar al versionar
        //Ext.getCmp('his_identificador').setDisabled(true); //Hay que activarlo en las otras funciones
        
      }
      
	function nuevaVersionHistoria()
	{
	
	/*
      Esta es la funcion encargada mandar los datos de una HU al servidor lo mismo que la de arriba pero con variables de mas
      */
      var enviarDatosVerionar = function(btntext){
	        var tipocambio='pequeno';
		
		if(Ext.getCmp('tipo_cambio_grande').getValue()==true){tipocambio='grande';}
		else{tipocambio='pequeno';}
		

		if(formHU.getForm().isValid())
		{
		  formHU.getForm().submit({
		    url: 'historiasusuario/guardar',
		    method: 'POST',
		    waitTitle: 'Guardar',
		    waitMsg: 'Enviando datos...',
		    params:{
		      task: btntext,
		      mensaje:Ext.getCmp('his_mensaje_version').getValue(),
		      tipo_cambio:tipocambio,
                      his_dependencias:Ext.getCmp('his_dependencias').getValue(),
                      his_responsable:Ext.getCmp('his_responsable').getValue(),
                      his_unidad_tiempo:Ext.getCmp('his_unidad_tiempo').getValue(),
                      his_tiempo_estimado:Ext.getCmp('his_tiempo_estimado').getValue(),
                      his_tiempo_real:Ext.getCmp('his_tiempo_real').getValue(),
                      his_riesgo:Ext.getCmp('his_riesgo').getValue(),
                      his_identificador_historia:Ext.getCmp('his_identificador').getValue(),
                      mod_id:id_Modulo
		      /*Versionar -> Crea un nueva historia con la informacion de la historia cuyo id es enviado a la peticion*/
		    },
		    success: function(fm,at)
		      {
		        Ext.Msg.alert('inform',at.result.msg);
                        Ext.getCmp('btForm').setText('Actualizar');
		        jsonhispro.reload();
                        versionarWindow.close();
			//gridhu.show(true);
		      },
		    failure: function(fm,at)
		      {
		        Ext.Msg.alert('inform',at.result.msg);
			//gridhu.show(true);
		      }
		  });
		}else{
		  Ext.Msg.alert('Informacion','Faltan campos por llenar');
		}
	
      }
 
	var versionarWindow = new Ext.Window({
		  title: 'Datos de version',
		  width:320,
		  height:220,
		  frame:true,
		  modal:true,
		  plain:true,
		  layout: 'fit',
		  items:[{
			xtype:'panel',
			layout:'form',
			frame:true,
			
			defauls:{anchor:'100%'},
			items:[
				{id:'tipo_cambio_grande',xtype:'radio',fieldLabel: 'Tamaño cambio',
					boxLabel: 'Grande',name: 'tipo_cambio',inputValue: 'Grande'
				}, 
				{checked:true,fieldLabel: '',id:'tipo_cambio_pequeno',xtype:'radio',labelSeparator: '',
					boxLabel: 'Pequeño',name: 'tipo_cambio',inputValue: 'Pequeño'
				}, 
				{fieldLabel:'Mensaje',id:'his_mensaje_version',xtype:'textarea',heigth:110,anchor:'100%'},
			      ],
			buttons:[
				{text:'Guardar',handler:function(){enviarDatosVerionar('Versionar');}},
				{text:'Cancelar',handler:function(){versionarWindow.close();} }
				]	
			}] 
			
		});
       
        versionarWindow.show();

	}



      //Por que no funciono el primer caso
      //Metodo encargado de generar el formato xmi de una historia de usuario
      function exportarHistoriatoXMI()
      {
          if(gridhu.getSelectionModel().getCount() > 0 )
          {
            var recordHistoria = gridhu.getSelectionModel().getSelected();
            Ext.Msg.show({
              title   : 'Confirmacion',
              msg     : '¿Desea exportar a xmi la historia '+recordHistoria.get('his_nombre')+'?',
              buttons : Ext.Msg.YESNO,
              fn      : function(btn)
              {
                if(btn == 'yes')
                {
                  //Cambiar de acuerdo a donde se encuentre el archivo
                  var url = URL_AGILHU+'pusuario_dev.php/historiasusuario/exportarXMI?his_id='+recordHistoria.get('his_id');
                  win = window.open(url,'Documento','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
                }
                
              }
            });
            
          }else{
            Ext.Msg.alert('INFORM','Seleccione una historia de usuario');
          }   
      }



      /*Cuando el campo descripcion no esta abierto la informacion que hay dentro de el 
       no se envia en la peticion */

	/****************Mostrar historial*************************************/
function mostrarHistorial()
{
  
    var expander = new Ext.ux.grid.RowExpander({
        tpl : new Ext.Template(
            '<p><b>Nombre HU:</b> {his_nombre}</p>',
	    '<p><b>Version:</b> {his_version}  ',
	    '<b>Prioridad:</b> {his_prioridad}</p>',
	    '<p><b>Mensaje:</b> {his_mensaje_version}</p> ',
            '<p><b>Descripción:</b> {his_descripcion}</p>'
        )
    });

var historialHUDataStore=new Ext.data.JsonStore({
        url: 'historiasusuario/listar',
        autoLoad: true, //esto no es necesario
        baseParams:{
          task:'HitorialVersiones',
	  his_identificador:Ext.getCmp('his_identificador').getValue()
        },
        storeId: 'jsonhispro',
        root: 'hispro',//las HU por proyecto
        idProperty: 'his_id',//el indice para este json
        fields:[
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
        {name:'his_unidad_tiempo'},
        {name:'his_actor'},//cambio v1.1
        //estos campos no estan incluidos en el formulario en donde van
        {name:'his_tipo_actividad', type: 'int'},//este se maneja por debajo para lo de las versiones
        {name:'his_observaciones', type: 'int'},//esta en el formulario y es para aclarar informacion
        {name:'his_mensaje_version'}
        ],
       sortInfo:{field: 'his_version', direction: "DESC"}
      });

historialHUDataStore.load();

    var historialGrid = new Ext.grid.GridPanel({
        store: historialHUDataStore,
	region:'center',
        cm: new Ext.grid.ColumnModel({
            defaults: {
                width: 20,
                sortable: true
            },
            columns: [
                expander,
	       {header: "Nombre", width: 150, sortable: true, dataIndex: 'his_nombre'},
	       {header: "Version", width: 30, sortable: true, dataIndex: 'his_version'},
	       {header: "Creada", width: 150, sortable: true, format: 'Y-m-d', dataIndex:'created_at'},
	       {header: "Actualizada", width: 150, sortable: true, format: 'Y-m-d',dataIndex:'updated_at'},
	       {header: "Prioridad", width: 150, sortable: true, dataIndex: 'his_prioridad'},
	       {header: "Responsable", width: 150, sortable: true, dataIndex: 'his_responsable'}
		]
        }),
        viewConfig: { forceFit:true},        
        width: 600,
        height: 300,
	bbar: new Ext.PagingToolbar({
			pageSize: 12,
			store: historialHUDataStore,
			displayInfo: true,
			displayMsg: 'Historias {0} - {1} de {2}',
			emptyMsg: "No hay Historial"
		}),
    	tbar:[
	    	{text:'Volver',iconCls:'regresar_version',tooltip:'volver a esta version',handler:volverAEstaVersion},
	    	{text:'Comparar',iconCls:'compare_his', tooltip:'Compara dos versiones seleccionadas',handler:comparaVersiones},// dos versiones
	    //	{text:'Descargar XML',iconCls:'xml_his',tooltip:'Descargar el historial de la versión en xml'},
	     ],
	plugins:[expander,new Ext.ux.grid.Search({
				mode:          'local',
				position:      top,
				searchText:    'Filtrar',
				iconCls:  'filtrar',
				selectAllText: 'Seleccionar todos',
				searchTipText: 'Escriba el texto que desea buscar y presione la tecla enter',
				width:         100
	     })],
	selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
        iconCls: 'icon-grid'
    });

function comparaVersiones()
{
   if(historialGrid.selModel.getCount() == 2)
   {	
	var versionesSeleccionadas= historialGrid.selModel.getSelections(); 
	version1=versionesSeleccionadas[0].json.his_descripcion;
	version2=versionesSeleccionadas[1].json.his_descripcion;
	versionNumero1=versionesSeleccionadas[0].json.his_version;
	versionNumero2=versionesSeleccionadas[1].json.his_version;

			        
	Ext.Ajax.request({  
		waitMsg: 'Por Favor Espere...',
		url:'historiasusuario/listar',
		params: { 
			task: 'COMPARARVERSIONES',
			versionNueva:version1,
			versionVieja:version2,
	                versionNumeroNueva:versionNumero1,
	                versionNumeroVieja:versionNumero2,

		}, 
		success: function(response)
		  {
		     obj = Ext.util.JSON.decode(response.responseText);
		     if(obj.success)
		     {//agaviso(obj.mensaje);
		     Ext.getCmp('comparacion-abajo').removeAll();
		     Ext.getCmp('comparacion-abajo').add({xtype:'panel',autoScroll:true,html:obj.mensaje});
		     Ext.getCmp('comparacion-abajo').show();
		     Ext.getCmp('comparacion-abajo').ownerCt.doLayout();
		     }
		     if (obj.success == false)
		     {agerror(obj.errors.reason);}
		  },
		  failure: function(form, response)
		  {agerror('servidor no encontrado');}
	});
	
   } 
   else{
	agalerta("Usted debe seleccionar exactamente dos versiones para comparar");
   }

}

function volverAEstaVersion()
{
   if(historialGrid.selModel.getCount() == 1)
   {	
	var versioneSeleccionada= historialGrid.selModel.getSelections(); 
	var his_identificador=versioneSeleccionada[0].json.his_identificador_historia;
	var his_version_regresamos=versioneSeleccionada[0].json.his_version;
	var his_id=versioneSeleccionada[0].json.his_id;

	Ext.Ajax.request({  
		waitMsg: 'Por Favor Espere...',
		url:'historiasusuario/guardar',
		params: { 
			task: 'REGRESARALAVERSION',
                        his_identificador:his_identificador,
			his_version_regresa:his_version_regresamos,
                        his_id:his_id
		}, 
		success: function(response)
		  {
                     var obj = Ext.util.JSON.decode(response.responseText);

		     if(obj.success)
		     {
                     historialHUDataStore.reload();
		     jsonhispro.reload();
                     agaviso(obj.mensaje);
		     }
		     if (obj.success == false)
		     {agerror(obj.errors.reason);}
		  },
		  failure: function(form, response)
		  {
		      agerror('servidor no encontrado');
		  }
	});
   } 

}

var historialWindow = new Ext.Window({
	  title: 'Historial de una HU',
	  closable:true,
	  width:720,
	  height:520,
	  plain:true,
          modal:true,
	  layout: 'fit',
	  items:[{xtype:'panel',
		layout:'border',
		items:[historialGrid,
		       {id:'comparacion-abajo',layout:'fit',height: 195,split: true,border:false,region:'south',hidden:true}
		      ]			
		}] 
		
	});
       
        historialWindow.show();
}
/**********end mostrar historial****////

//eventos de click derecho
function verResultadoEvaluacion(){

   var resultadoEvalStore = new Ext.data.Store({//--JsonStore
        proxy: new Ext.data.HttpProxy({
		  url: 'historiasusuario/listar',
		  method: 'POST'
	      }),
        baseParams:{
          task: 'LISTAREVAL',
          his_id: huSeleccionada.data.his_id,
          his_nombre: huSeleccionada.data.his_nombre,

        },
        id: 'resultadoEvalStore',
        reader: new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
                id:'id'
	    	},
		[
		{name:'his_evaluada', type: 'int'},
		{name:'usu_evaluador', type: 'string'},
		{name:'pru_independiente',type: 'int'},//timestamp buscar tipo conpatibel
		{name:'pru_negociable',type: 'int'},
		{name:'pru_valiosa',type: 'int'},
		{name:'pru_estimable',type: 'int'},
		{name:'pru_pequena',type: 'int'},
		{name:'pru_testeable', type: 'int'},
		{name:'pru_comentarios', type: 'string'},
		{name:'pru_fecha_evaluacion', type: 'string'}
		]),
        sortInfo:{field: 'pru_fecha_evaluacion', direction: "ASC"},
       });

      
    var resultadoEvalExpander = new Ext.ux.grid.RowExpander({
        tpl : new Ext.Template(
            '<p><b>Comentario:</b>{pru_comentarios}</p>'
        )
    });
      //las columnas que se muestran en el grid
    var resultadoEvalColmodel = new Ext.grid.ColumnModel([
       resultadoEvalExpander,
       {header: "Evaluador", width: 130, sortable: true, dataIndex: 'usu_evaluador'},
       {header: "Fecha", width: 110, sortable: true, dataIndex: 'pru_fecha_evaluacion'},
     //  {header: "Comentarios", width: 150, sortable: true, dataIndex: 'pru_comentarios'}
    ]);
      
	//nuevo
    resultadoEvalStore.load();


    var resultadoEvalForm = new Ext.FormPanel({
	id: 'resultadoEvalForm',
        title:'Resumen',
        closable: true,
        frame:true,
        border:false,
        iconCls:'modulo',
	monitorResize : true,
	autoScroll:true,
        columnWidth:0.5,
        defaults:{anchor:'100%',xtype:'textfield'},
	items: [{fieldLabel: 'Evaluador',name: 'usu_evaluador'},
                {fieldLabel: 'Independiente',name: 'pru_independiente'},
                {fieldLabel: 'Negociable',name: 'pru_negociable'},
                {fieldLabel: 'Valiosa',name: 'pru_valiosa'},
                {fieldLabel: 'Estimable',name: 'pru_estimable'},
                {fieldLabel: 'Pequena',name: 'pru_pequena'},
                {fieldLabel: 'Testeable',name: 'pru_testeable'},  
               ],
	});



    var resultadoEvalGrid =  new Ext.grid.GridPanel({
		id: 'resultadoEvalGrid',
		frame:true,
		stripeRows:true,
		store: resultadoEvalStore,
		cm: resultadoEvalColmodel,
		height: 250,
                columnWidth:0.5,
		title:'Lista de Comentarios',
		border: true,
	        enableColLock:false,
		selModel: new Ext.grid.RowSelectionModel({
				singleSelect: true,
                                listeners: {
				            rowselect: function(sm, row, rec) {
					               resultadoEvalForm.getForm().loadRecord(rec);
                                                       }
                                           }
				}),
              
	       plugins:[resultadoEvalExpander]
	});


  var resultadoPromEvalStore = new Ext.data.Store({//--JsonStore
        proxy: new Ext.data.HttpProxy({
		  url: 'historiasusuario/listar',
		  method: 'POST'
	      }),
        baseParams:{
          task: 'LISTARPROMEVAL',
          his_id: huSeleccionada.data.his_id,
          his_nombre: huSeleccionada.data.his_nombre,
        },
        reader: new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
                id:'id'
	    	},[
		{name:'his_nombre', type: 'string'},
		{name:'pru_independiente',type: 'float'},//timestamp buscar tipo conpatibel
		{name:'pru_negociable',type: 'float'},
		{name:'pru_valiosa',type: 'float'},
		{name:'pru_estimable',type: 'float'},
		{name:'pru_pequena',type: 'float'},
		{name:'pru_testeable', type: 'float'},
		])
       });
resultadoPromEvalStore.load();

 var diagramaHisxEvalPanel=new Ext.Panel({
        height: 290,
        width:450,
        border:false,
        columnWidth:1,
        title: 'Grafica de evaluacion a historia',
        items: [
                {
                 xtype:'columnchart',
                 store: resultadoPromEvalStore,
                 xField: 'his_nombre',
          	series: [{
		        yField: 'pru_independiente',
		        displayName: 'Independiente'
		    },{
		        yField: 'pru_negociable',
		        displayName: 'Negociable'
		    },{
		        yField: 'pru_valiosa',
		        displayName: 'valiosa'
		    },{
		        yField: 'pru_estimable',
		        displayName: 'Estimable'
		    },{
		        yField: 'pru_pequena',
		        displayName: 'Pequeña'
		    },{
		        yField: 'pru_testeable',
		        displayName: 'testeable'
		    }],
                extraStyle:{          
                    legend:{        
                            display: 'bottom'  
                           }  
                         } 
                }
                ]
    });

   var resultadoEvalWindow = new Ext.Window({
		  title: 'Resultados de evaluación hu: '+huSeleccionada.data.his_nombre,
		  width:460,
		  height:560,
		  frame:true,
		  modal:true,
		  plain:true,
		  layout: 'column',
		  items:[
                        {
			xtype:'panel',
                       // columnWidth:1,
			layout:'column',
			frame:true,
			items:[diagramaHisxEvalPanel,resultadoEvalGrid,resultadoEvalForm]	
			}] 
			
		});
       
   resultadoEvalWindow.show();
} 

function ImprimirHistoria(){

}

function eliminarHistoria(){

	if(Ext.getCmp('his_identificador').getValue()!='')
	{
		Ext.MessageBox.confirm('Confirmacion','Desea borrar esta historia?', funcionEliminarHistoria);
	}else {
		Ext.MessageBox.alert('Advertencia','Seleccione una historia a borrar');
	}
}


function funcionEliminarHistoria(btn){
	if(btn=='yes'){
	
	if(gridhu.getSelectionModel().getCount() > 0 ){
	var historiaSeleccionada = gridhu.selModel.getSelections(); 
	var his_identificador=historiaSeleccionada[0].json.his_identificador_historia;
	var his_id=historiaSeleccionada[0].json.his_id;

		Ext.Ajax.request({  
			waitMsg: 'Por Favor Espere...',
			url:'historiasusuario/eliminar',
			params: { 
				his_identificador_historia:  his_identificador
			}, 
			success: function(response){
			obj = Ext.util.JSON.decode(response.responseText);
				if (obj.success)
				{
					agalerta(obj.mensaje);
					jsonhispro.reload();
				}
				else 
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
	else{
	Ext.MessageBox.alert('Advertencia','Seleccione una historia a borrar');
	}
	}
}

////////////////**Bloquear y desbloquear campos

	function desbloquearCamposHU(){
		if(tieneRol("cliente")){//nombre, identificador, prioridad, descripcion y observaciones puede modificar, el boton crear esta activo para el
		//se deja como esta
		}
		if(tieneRol("programador")  || tieneRol("administrador") || tieneRol("tester")){// modificar:estimacion de tiempo y unidad dependencia responsables, todos los botones botones 
		      Ext.getCmp('his_dependencias').setDisabled(false);
                      Ext.getCmp('his_responsable').setDisabled(false);
                      Ext.getCmp('his_unidad_tiempo').setDisabled(false);
                      Ext.getCmp('his_tiempo_estimado').setDisabled(false);
                      Ext.getCmp('his_tiempo_real').setDisabled(false);
                      Ext.getCmp('his_riesgo').setDisabled(false);
		}
	}
	
	desbloquearCamposHU();

    function agregarTooltipAuxiliar(componente, nombreComponente, mensaje)
   {
   (Ext.getCmp(componente)).addListener('render',
                                         function(){
                                              new Ext.ToolTip({
						target: (Ext.getCmp(componente)).getEl(),//porbar con this
						title: 'Ayuda rapida '+nombreComponente,
						width:200,
						html: mensaje,
						trackMouse:true
					        });
                                         });
    }

    function agregarTooltipsHU()
    {
    agregarTooltipAuxiliar('his_riesgo','riesgo','Escriba un numero entre 0-9 que represente el riesgo de que esta historia no se haga');
    agregarTooltipAuxiliar('his_unidad_tiempo','unidad de tiempo','Seleccione la unidad de tiempo en la cual realizará la estimación de tiempos');
    agregarTooltipAuxiliar('his_tiempo_estimado','tiempo estimado','Cuanto tiempo usted estima que llevara desarrollar esta historia?');
    agregarTooltipAuxiliar('his_tiempo_real','tiempo real','cuanto tiempo se gasto realmente en la implementación de esta historia');

    agregarTooltipAuxiliar('his_nombre','nombre historia','Escriba un nombre corto pero descrptivo para esta historia');
    agregarTooltipAuxiliar('his_identificador','identificador','Este campo es asignado por AGILHU es un numero que identifica a esta historia en este proyecto');
    agregarTooltipAuxiliar('his_prioridad','prioridad','Seleccione que tan prioritaria es está historia para su negocio, Alta es muy importante, Baja es poco urgente');
    agregarTooltipAuxiliar('his_dependencias','dependencias','utilize el identificador de las historias de usuario para indicar dependencias entre ellas');
    agregarTooltipAuxiliar('his_responsable','responsables','Escoja el programador o programadores que implementaran esta historia');
    agregarTooltipAuxiliar('tfactor','actores','Escriba el nombre del actor o actores que ejecutan esta historia');
    agregarTooltipAuxiliar('his_iteracion','iteracion','Escriba en que iteración se incluye esta historia');
    
    }

    agregarTooltipsHU();

return panelContenedorHU;
}//Fin funtion




