	/*Paneles de usuario item superio*/
      function ventActualiClaveUsuario(){

         var panelClaveUsuario;
         panelClaveUsuario=new Ext.FormPanel({
         layout:'form',
         buttonAlign:'center',
         name:'panelClaveUsuario',
         url:'usuario/cargar',
         frame:true,	
         bodyStyle: Ext.isIE ? 'padding:0 0 15px 15px;' : 'padding:15px 15px;',
         	defaults:{xtype: 'textfield',allowBlank:false},
         items: [
                {
                 xtype:'panel',
                 layout:'fit',
                 anchor:'',
                 isFormField:true,
                 width:58,height:58,
                 items:[
                         {xtype:'box',
                         autoEl:{tag:'img',
                           qtip:'Digite su clave actual, su nueva clave y repita su nueva clave, pulse guardar o cancelar segun desee',
                           src:'../images/iconos/usuario/candado.png'
                           }
                         }
                       ]
              },
              {name:'usu_clave',id:'usu_clave_cambio',fieldLabel:'Clave actual',blankText:'Digite su clave actual',anchor:'100%',inputType:'password',minLength:8},
              {name:'usu_nueva_clave',id:'usu_nueva_clave_cambio',fieldLabel:'Nueva clave',blankText:'Digite la nueva clave',anchor:'100%',inputType:'password',minLength:8},
              {name:'usu_re_nueva_clave',id:'usu_re_nueva_clave_cambio',fieldLabel:'Re clave ',blankText:'Repita la nueva clave',inputType:'password',anchor:'100%',minLength:8},	
              {name:'usu_id',fieldLabel:'',blankText:'identificador del usuario',hidden:true},
              {name:'usu_usuario',fieldLabel:'',blankText:'usuario',hidden:true},		
                 			
              ],
              buttons:[{text:'Guardar',
              		handler: actualizarClaveUsuario
                       },{text:'Cancelar',
              	         handler: function(){windowClaveUsuario.close();}
               }]   
         });
		
        datosUsuarioRegistrado.load({
	  callback: function() {
	    var record = datosUsuarioRegistrado.getAt(0);
             panelClaveUsuario.getForm().loadRecord(record);
            windowClaveUsuario.setTitle('Cambio clave de usuario '+record.data.usu_usuario);
	  }
	});
		
              var windowClaveUsuario = new Ext.Window({
                title: 'Cambio Clave Usuario',
                width:320,
                height:260,
                frame:true,
                plain:true,
                layout: 'fit',
                modal :true,
                items: panelClaveUsuario
              });
              windowClaveUsuario.show();


    var verificarCamposClaveUsuario=function ()
    {
      var llenadoValido=false;

      if(panelClaveUsuario.getForm().isValid())
      {
      llenadoValido=true;
      }
      else
      {
        agerror('Verifique que todos los campos se hayan llenado correctamente, la nueva clave deben tener minimo 8 caracteres');
      }

      if(!(Ext.getCmp('usu_nueva_clave_cambio').getValue() == Ext.getCmp('usu_re_nueva_clave_cambio').getValue())) 
      {
       agerror('La clave y la reclave deben ser iguales');
       return false;
      }
		

      if((Ext.getCmp('usu_nueva_clave_cambio').getValue()).length < 8) 
      {
       agerror('La nueva clave debe tener minimo 8 digitos');
       return false;
      }
     
      return llenadoValido;
    }

    function actualizarClaveUsuario()
    {
          var verificacion =verificarCamposClaveUsuario();
	  
	  if(verificacion)
	  {
		 panelClaveUsuario.getForm().submit({
		  method: 'POST',
		  url:'usuario/cargar',
		  params: {
		  task: 'CAMBIARCLAVE'
		  },
		  waitTitle: 'Enviando',
		  waitMsg: 'Enviando datos...',
		  success: function(response, action)
		  {
			  obj = Ext.util.JSON.decode(action.response.responseText);
			  agaviso(obj.mensaje);
			  windowClaveUsuario.close();
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
	

