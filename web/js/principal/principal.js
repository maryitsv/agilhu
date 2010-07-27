
var menuPanel;
var agMenuPanel;
var agMenuPanelProyecto;
var Principal = function () 
{
//return { 
//	init: function () {

	Ext.QuickTips.init();
	
 	
	
	//area de trabajo
	 agPrinCentro=new Ext.TabPanel({
		id:'agPrinCentro',
		region:'center',
		deferredRender: false,
		enableTabScroll: true,
		autoScroll: true,
		resizeEvent:'bodyresize',                
		activeTab: 0,
		tabWidth: 145,
		resizeTabs: true,
		minTabWidth: 145,
		listeners :{
				bodyresize:function(){
				heightCentro=(agPrinCentro.getSize().height)-68;
				} 
			}
	});

       //arreglo de temas
	var agStoreTema= new Ext.data.ArrayStore({
	        fields: ['tema', 'color'],
	        data : [
        		['xtheme-access.css','access'],
        		['xtheme-blue.css','blue'],
			['xtheme-silverCherry.css','cherry'],
        		['xtheme-chocolate.css','chocolate'],
        		['xtheme-darkgray.css','drak'],
        		['xtheme-gray.css','gray'],
        		['xtheme-green.css','green'],
			['xtheme-indigo.css','indigo'],
			['xtheme-black.css','black'],
        		['xtheme-midnight.css','night'],
        		['xtheme-olive.css','olive'],
        		['xtheme-peppermint.css','pepermint'],
        		['xtheme-purple.css','purple'],
			['xtheme-red.css','red'],
        		['xtheme-slate.css','slate'],
        		['xtheme-slickness.css','slickness']
        		]
	    	});
	    
	//combo de temas
	 var agCombTema = new Ext.form.ComboBox({
	        store:agStoreTema,
	        displayField: 'color',
	        typeAhead: true,
	        mode: 'local',
	         valueField:'tema',
	        triggerAction: 'all',
	        emptyText: 'Seleccione un tema.',
	        selectOnFocus: true,
	        width: 135,
	        id:'agPrinTema',
	        listeners:{
	         	scope: this,
	         	'select': function(){ 
                            cambiaEstilo(Ext.getCmp('agPrinTema').getValue()); 
                                     }
	    		}
	    });
	    
	    //barra superior 
	    var agBarraPrin = new Ext.Toolbar({
	    renderTo:'agbarrader',
	    height: 40,
	    items:[
	    		{text:'Datos de Usuario',
			iconCls:'usuario-info',				
			menu:{
			         items:[
						{text:'Actualizar Datos',handler:ventActualiDatosUsuario},
						{text:'Cambiar Contraseña',handler:ventActualiClaveUsuario}

					]
				}				
			},
	    		'-', 
	    		{text:'Tema',iconCls:'tema'},
	    		agCombTema,
	    		'-',
	    		{text:'Salir',iconCls:'salir',handler:function(){
			//init salir
			Ext.MessageBox.confirm('Confirmar', 'Esta seguro de cerrar la cuenta?', function(btn, text){
	                      if(btn == 'yes'){
	                        var redirect = URL_AGILHU+"pusuario.php/principal/salir?urlApp='"+URL_AGILHU+"'";
	                        window.location = redirect;
	                      } 
			});//end salir
			}}
	    		]
	    });
	   
	   var jsonMenuProy = [{
	      	text: 'Inicio',
	        id: 'jsonMenuPrin',
	        draggable: false,
	        expanded: true,
	        iconCls: 'menu',
	        name: 'main',
		defaults:{disabled: false,draggable: false,tabType: 'load'},
	        children:[
        	  {leaf: true,id : 'pusuario.php/listaproyectos',text: 'Proyectos',iconCls: 'proyecto'},
		  {leaf: true,id : 'pusuario.php/proyecto',text: 'Mis Proyectos',iconCls: 'mis_proyecto'},
		  {leaf: true,id : 'pusuario.php/pinvitacion',text: 'Invitaciones',iconCls: 'historias'},
		  ]
	      }];
		
		
	   var jsonMenuOpciProy = [{
	      	text: 'Proyecto ...',
	        id: 'jsonMenuOpciProy',
	        draggable: false,
	        expanded: true,
	        iconCls: 'menu',
	        name: 'main',
	        defaults:{draggable: false,tabType: 'load',disabled: false},
	        children:[
	            {leaf: true,id : 'pusuario.php/datosproyecto',text: 'Datos Proyecto',iconCls: 'proyecto'},
	            {leaf: true,id : 'pusuario.php/modulo',text: 'Modulos',iconCls: 'modulo'},
	            {leaf: true,id : 'pusuario.php/historiasusuario',text: 'Historias de usuario',iconCls: 'historias'},
	            {leaf: true,id : 'pusuario.php/pruebaexperto',text: 'Validación de expertos',iconCls: 'prueba'},
	            {leaf: true,id : 'pusuario.php/documentos',text: 'Documentos',iconCls: 'docs'},
	            {leaf: true,id : 'pusuario.php/participante',text: 'Participantes',iconCls: 'participantes'},
	            {leaf: true,id : 'pusuario.php/reportes',text: 'Reportes',iconCls: 'reportes'}

	            ]
	      }];
	      

		function addTab(tabTitle, targetUrl,imagen){
			var tab = agPrinCentro.getItem(tabTitle);
			
			if(tab)	{
				agPrinCentro.setActiveTab(tab);
			} else {
			      switch (tabTitle){
                              case 'Datos Proyecto': agPrinCentro.add(DatosProyecto()).show(); break;
                              case 'Modulos': agPrinCentro.add(Modulo()).show(); break;
                              case 'Participantes': agPrinCentro.add(Participante()).show(); break;
                              case 'Documentos': agPrinCentro.add(Documento()).show(); break;
                              case 'Historias de usuario': agPrinCentro.add(HistoriaUsuario()).show(); break;
                              case 'Validación de expertos': agPrinCentro.add(PruebaHistoria()).show(); break;
                              case 'Mis Proyectos': agPrinCentro.add(Proyecto()).show(); break;
  
                              case 'Reportes': agPrinCentro.add(Reportes()).show(); break;

                              default:
				agPrinCentro.add
				(
					{
					id: tabTitle,
					title: tabTitle,
					frame: true,
				        margins :'5 5 5 5',
					autoLoad: {url: targetUrl,scripts: true, scope: this},
					closable: true,
					autoScroll: true,
					iconCls: imagen,
					}
				).show();
                              } 
                        }
				

		}
		
		 var agTreeProy = new Ext.tree.TreePanel({
	        iconCls: 'carpeta',
	        rootVisible: false,
	        lines: true,
		border: false,

	        draggable: false,
	        containerScroll: true,
	        singleExpand: false,
	        useArrows: true,
	        enableDD: true,    
	        listeners:{
	          click:function(n){
			 if (n.leaf) {
      			 addTab(n.text,URL_AGILHU+n.id,n.attributes.iconCls);                   
    			 }
	           	},
		afterrender: function(g) {
			var n=agTreeProy.getNodeById('pusuario.php/listaproyectos');
		
			  addTab(n.text,URL_AGILHU+n.id,n.attributes.iconCls);   		        
			},
	        },
	        selectable: true,
	        singleSelect: true,
	        root: new Ext.tree.AsyncTreeNode({
	          expanded: true,
	          text: 'Procesos',
	          draggable: false,
	          children: jsonMenuProy,
	        }),
	        layoutConfig:{
	          animate: true
	        }
		}); 			
		

		 var agTreeOpciProy = new Ext.tree.TreePanel({
	        iconCls: 'carpeta',
	        rootVisible: false,
		border: false,

	        lines: true,
	        draggable: false,
                id:'agTreeOpciProy',
	        containerScroll: true,
	        singleExpand: false,
	        useArrows: true,
	        enableDD: true,    
	        listeners:{
	          click:function(n){
			  if (n.leaf) {
      			  addTab(n.text,URL_AGILHU+n.id,n.attributes.iconCls);                   
    			  }
			},

        	 render: function(g) {
//			var n=g.getNodeById('pusuario.php/datosproyecto');			
//			  addTab(n.text,URL_AGILHU+n.id,n.attributes.iconCls);   
		        },
		 
		  delay: 10    
	        },
	        selectable: true,
	        singleSelect: true,
	        root: new Ext.tree.AsyncTreeNode({
	          expanded: true,
	          text: 'Procesos',
	          draggable: false,
	          children: jsonMenuOpciProy,
	        }),
	        layoutConfig:{
	          animate: true
	        }
		}); 			
		
		
		   agMenuPanel = new Ext.Panel({
				//frame: true,
                                border:false,
				id: 'agMenuPanel',
	        		title: 'Menu Inicio',
	        		items: [agTreeProy] 
				});			
		
		   agMenuPanelProyecto = new Ext.Panel({
				//frame: true,
                                border:false,
				id: 'agMenuPanelProyecto',
	        		title: 'Menu Proyecto',hidden :true,
	        		items: [agTreeOpciProy],
				listeners:{
				show: function(tc) {
				    
					var n=agTreeOpciProy.getNodeById('pusuario.php/datosproyecto');			
					  addTab(n.text,URL_AGILHU+n.id,n.attributes.iconCls);   
					},
				}
				});			
	
		    menuPanel = new Ext.Panel({
				id:'menuPanel',
			 	region:'west',
				title: 'Opciones',
				split: true,
				width: 160,
                               // frame:true,
				collapsible: true,
				layoutConfig:{
				  animate: true
				},
				tbar: [{
						iconCls: 'home',
						scale:'large',
						tooltip: 'Inicio',
						handler:function(){
						Ext.getCmp('agPrinCentro').removeAll();
						Ext.getCmp('agMenuPanel').show();
						
						Ext.getCmp('agMenuPanelProyecto').hide();
						//mostrando de nuevo el tab de proyecto
						var n=agTreeProy.getNodeById('pusuario.php/listaproyectos');		
			  			addTab(n.text,URL_AGILHU+n.id,n.attributes.iconCls);   
		
						}
					},
          				{
						iconCls: 'ayuda',
                                                scale:'large',
						id: 'help-button',
						tooltip: 'Ayuda',
						handler:function(){
                                                var panelAyuda=new Ext.Panel({
							 title: 'Ayuda rapida',
						         closable: true,
							 autoScroll: true,
						         margins:'0 5 5 0',
							 iconCls: 'ayuda',
						         bodyStyle: Ext.isIE ? 'padding:0 0 15px 15px;' : 'padding:10px 15px;',
						         items:[
						                { xtype:'panel',border:false,
								 autoLoad: {url: URL_AGILHU+'/ayuda/ayuda.html' ,scripts: true, scope: this},
								}
						              ]
							});

                                                agPrinCentro.add(panelAyuda).show(); 
						}
					}
        			],
				items: [agMenuPanel,agMenuPanelProyecto]
			});      
	      
		var agContenedor = new Ext.Viewport({
		        id: 'agContenedor',
				renderTo:document.body,
				width:800,
				height:500,
				defaults:{split:true},
			layout: 'border',
			items: [
				   {              
				   id:'agprinnorte',
				    xtype:'box',
				    height: 45,  
				    el:'header',
				    region: 'north',
				    border:false,
				    anchor: 'none -25'
				   },
				   agPrinCentro,
				   menuPanel,
				  
		]
		});
	   
	//addTab('Proyectos','listaproyectos','proyecto');
	ponEstilo();
	widthCentro=(agPrinCentro.getSize().width)-50;
	heightCentro=(agPrinCentro.getSize().height)-68;
	


	}//hata aqui las llaves obligatorias 
//}}();
