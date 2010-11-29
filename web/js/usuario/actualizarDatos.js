//obtener los datos actuales del usuario,esto se usa aqui y en cambiar claves
      var datosUsuarioRegistrado= new Ext.data.Store({
        id: 'datosUsuarioRegistrado',
        proxy: new Ext.data.HttpProxy({
                url: 'usuario/cargar', //cambiar
                method: 'POST'
        }),
        baseParams:{task: 'OBTENERDATOSUSUARIO'}, 
        reader: new Ext.data.JsonReader({
                root: 'results',
                totalProperty: 'total',
                id: 'id'
                },[ 
                  {name: 'usu_id', type: 'int'},	    
                  {name: 'usu_usuario', type: 'string'},
                  {name: 'usu_nombres', type: 'string'},
                  {name: 'usu_apellidos', type: 'string'},
                  {name: 'usu_correo', type: 'string'}
        ]),
         sortInfo:{field: 'usu_id', direction: "ASC"}
      });
   

   function ventActualiDatosUsuario(){
 
//crear el panel
        var panelDatosUsuario;
        panelDatosUsuario=new Ext.FormPanel({
            layout:'form',
            buttonAlign:'center',
            name:'panelDatosUsuario',
            url:'usuario/cargar',
            frame:true,	
            defaults:{xtype: 'textfield',allowBlank:false},
            items:[
                  {
                  xtype:'panel',
                  name:'panelActuUsu',
                  layout:'fit',
                  anchor:'',
                  isFormField:true,
                  width:48,height:48,
                  items:[
                       {xtype:'box',
                        name:'boximagen',
                       autoEl:{tag:'img',
                          qtip:'Cambie sus datos personales y pulse le botón guardar',
                          src:'../images/iconos/usuario/edit.png'
                          }
                       }
                       ]
                 },
                 {name:'usu_nombres',fieldLabel:'Nombres ',blankText:'Nombres del usuario',anchor:'100%'},
                 {name:'usu_apellidos',fieldLabel:'Apellidos ',blankText:'Apellidos del usuario',anchor:'100%'},
                 {name:'usu_correo',fieldLabel:'Correo ',blankText:'Correo del usuario',anchor:'100%',vtype:  'email',minLength:5},	
                 {name:'usu_id',fieldLabel:'',blankText:'identificador del usuario',hidden:true},
                 {name:'usu_usuario',fieldLabel:'',blankText:'usuario',hidden:true},		
                 ],
           buttons:[{text:'Guardar',
                     handler: actualizarDatosUsuario
                    },
                    {text:'Cancelar',
                      handler: function(){windowDatosUsuario.close();}
                    }
                   ]   
          });
			
         //cargar los datos de usuario en el formulario
      datosUsuarioRegistrado.load({
	  callback: function() {
	    var record = datosUsuarioRegistrado.getAt(0);
	    panelDatosUsuario.getForm().loadRecord(record);
            windowDatosUsuario.setTitle('Actualizar datos de usuario '+record.data.usu_usuario);
	  }
	});

         //crear la ventana emergente
          var windowDatosUsuario = new Ext.Window({
                title: 'Actualizar datos de usuario',
                width:320,
                height:260,
                plain:true,
                layout: 'fit',
                modal :true,
                items: panelDatosUsuario
                });

          windowDatosUsuario.show();
      
		//end paneles usuario

    var verificarCamposUsuario=function ()
    {
      var llenadoValido=false;

      if(panelDatosUsuario.getForm().isValid())
      {
      llenadoValido=true;
      }
      else
      {
        agerror('Verifique que todos los campos se hayan llenado correctamente, y que el correo tenga el formato algo@algo.com');
      }
      return llenadoValido;
    }

    function actualizarDatosUsuario()
    {
          var verificacion =verificarCamposUsuario();
	  
	  if(verificacion)
	  {
		 panelDatosUsuario.getForm().submit({
		  method: 'POST',
		  url:'usuario/cargar',
		  params: {
		  task: 'CAMBIARDATOS'
		  },
		  waitTitle: 'Enviando',
		  waitMsg: 'Enviando datos...',
		  success: function(response, action)
		  {
			  obj = Ext.util.JSON.decode(action.response.responseText);
			  agaviso(obj.mensaje);
			  windowDatosUsuario.close();
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
}
