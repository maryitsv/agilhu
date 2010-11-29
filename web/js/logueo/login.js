    //  var URL_AGILHU='http://vmlabs04.eisc.univalle.edu.co/~maryitsv/agilhu/web/'; 
//ya esta incluida en la carpeta auxiliares/funciones
	
var Login = function () 
{

return { 
		init: function () {

			
          	var agdescripcion='<div style="height:600px;background:white url(../images/fondo.gif);">'
		+'<div id="descripcion" style="background:transparent url(../images/imagenfondo.png);">'
		+'<font style="font-family: Times, serif;font-size:13.5pt; color:black;">'		
		+'<p>Agilhu es una herramienta que permite la gesti&oacute;n de historias de usuario de forma fac&iacute;l. Te permite crear tus proyectos, modulos, e historias de usuario, controla de forma automatica las versiones de tus HU, puedes invitar a otros miembros de la comunidad a hacer parte de tu proyecto y puedes asociarlos sus roles de forma clara.</p>'
		+'<br/>'		
		+'<p>A demas nos preocupaos por la calidad de tu documentaci&oacute;n y te damos una forma de evaluarlas antes de implementar.</p>'
		+'<p>Actualmente es un proyecto desarrollado por estudiantes de la esic de la Universidad del Valle en el laboratorio CEDESOFT</p>'
		+'<p>Esta aplicai&oacute;n es soportada en los siguientes navegadores web:</p>'
		+'<br/>'		
			+'<img src="../images/ff.png"><a href="http://www.mozilla-europe.org/es/firefox/">Firefox 3.0</a><br/>'
			+'<img src="../images/chr.png"><a href="http://www.google.com/chrome?hl=es">Google Chrome</a><br/>'
			+'<img src="../images/op.png"><a href="http://www.opera.com/">Opera</a><br/><br/>'
		+'<font>Descargar el manual <a href="http://vmlabs04.eisc.univalle.edu.co/~maryitsv/agilhu-manual.pdf">aqu&iacute;</a> </font>'
		+'</div>'
		+'</div>';
		
		
		var agFormAutenticacion=new Ext.FormPanel({
					url:'autenticacion/cargar',
					layout: 'form',
					frame:true,
					title: 'Iniciar sesi&oacute;n',
					id:'agFormAutenticacion',
					monitorValid:true,
					stateId :'agFormAutenticacion-stateid',
		           		stateful : true,
					labelWidth :120,
                                         width: 320,
					bodyStyle:'padding:15px',
					defaults:{xtype: 'textfield',width:160,allowBlank:false},
					items: [
						{id:'agUsu_usuario',name:'agUsu_usuario',fieldLabel:'Nombre de usuario',allowBlank:false,
							tooltip: {text:'Digite su nombre de usuario: ejemplo juanitafl', title:'Nombre de usuario', autoHide:true},
							value:leerGalleta('agUsuarioAcceso')
						},
						{id:'agUsu_clave',name:'agUsu_clave',fieldLabel:'Clave de usuario', inputType:'password',allowBlank:false,
							tooltip: {text:'Digite su clave de acceso: ejemplo ****', title:'Contrase�a', autoHide:true},
							value:leerGalleta('agContrasenaAcceso')
						},
						{xtype: 'checkbox',fieldLabel: 'Recordarme',name: 'agUsu_recordarme',id: 'agUsu_recordarme',
							handler:function(){
							   	if(Ext.getCmp('agUsu_recordarme').isDirty() && Ext.getCmp('agUsu_usuario').getValue()!="" && Ext.getCmp('agUsu_clave').getValue()!="")
							   	{		
									crearRecordatorio('agUsuarioAcceso',Ext.getCmp('agUsu_usuario').getValue());
							   		crearRecordatorio('agContrasenaAcceso',Ext.getCmp('agUsu_clave').getValue());
							   	}
						    }
						}  
						],
					buttons:[{text:'Acceder', formBind: true, handler:autenticar}]
					});
		
			var agContenedor = new Ext.Viewport({
			        id: 'agContenedor',
					renderTo:document.body,
					width:800,
					height:500,
			defaults:{collapsible:true,
				  split:true
				},
			layout: 'border',
			items: [
		           {              
		            xtype:'box',height: 45,  
		            el:'header',region: 'north',border:false,
		            anchor: 'none -25'
		           },
		            {
					xtype: 'panel',
					region:'center',  
					title: '<h2>Descripcion de AGILHU</h2>',
					layout:'fit',	
					bodyStyle:'padding:15px',
					html:agdescripcion
					},
					{
					 region:'east',
					 xtype: 'panel',
					 layout: 'column',
					 width: 360,
				         bodyStyle:'padding:15px',
					// height: 260,
					 items: [agFormAutenticacion,
						{
						xtype: 'panel',
						layout:'fit',
                                                 width: 320,
						border:false,
						bodyStyle:'padding:15px 40px 25px 40px',
						items: [{id:'botonka',xtype:'button',
						        scale:'large',
								text:"<font style='font-size:13.5pt;color:#484848;'>Registrarse Aqui!</font>",
								maxWidth:250,minWidth:250,							
								height:53,minHeight:50,
								handler:function()
										    { 
										     Ext.Ajax.request({
											waitMsg: 'Por Favor Espere...',
											url: 'autenticacion/imagen',
											method: 'GET',
											params: {
											},
											success: function(response, action)
											{
											    cadena = response.responseText;
											    ventanaRegistroUsuario1 = new ventanaRegistroUsuario();
											    ventanaRegistroUsuario1.show();
											},
											failure: function(action, response)
											{
											      var result=response.responseText;
											      if(action.failureType == 'server')
											      { 
											      agerror('No se pudo conectar con la base de datos');
											      
											      }
											}
										      });
										    }
								}]
						},
						{
						xtype: 'panel',
						layout:'fit',
						//frame:true, //causa problemas no se por que
                                                width: 320,
                                               // autoWidth:true,
						border:true,
						bodyStyle:'padding:15px 30px 25px 30px',
						html:"<font style='font-size:10.5pt;'>Si aun no lo ha probado registrese lo invitamos a ser parte de esta comunidad</font>"
						}
						]
					}
				]
			});

		function autenticar()
		{
		
			agFormAutenticacion.getForm().submit({
			method: 'POST',
			params: {
			task: 'BUSCARUSUARIO'
			},
			waitTitle: 'Enviando',
			waitMsg: 'Enviando datos...',
			success: function(response, action)
			{
			    obj = Ext.util.JSON.decode(action.response.responseText);
            
					if (obj.success)
					{
                                          // agadvertencia(obj.success);      
                                         //  agadvertencia(obj.mensaje);
				           if(obj.mensaje=='admin')//me toco quitarle el .value
                      	  		   { window.location = URL_AGILHU+'padmin.php/principal';}
				           else
				           { window.location = URL_AGILHU+'pusuario.php/principal';}
						
					}
					else if (obj.errors)
					{
					   agadvertencia(obj.errors.reason);
					}
		  
            
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
		
		
var cadena;		
//********************************//
ventanaRegistroUsuario = Ext.extend(Ext.Window,{
  onActionFailed : function(f,a){
      this.onCapthaChange();
      var form = this.loginPanel.getForm();
      alert(a.result.errors.msg);
      if (a.result.errors.id){
        var f = form.findField(a.result.errors.id);
        if(f){f.focus();}
      }
  },
  onCapthaChange : function(){
	Ext.Ajax.request({
        waitMsg: 'Por Favor Espere...',
        url: 'autenticacion/imagen',
        method: 'GET',
        params: {
        },
        success: function(response, action){
			cadena = response.responseText;
			var captchaURL = "../images/captcha/CaptchaSecurityImages.php?width=160&height=80&characters=4&cadena="+cadena+"&t=";
        	var curr = Ext.get('activateCodeImg');
        	curr.slideOut('b', {callback: function(){
              Ext.get( 'activateCodeImg' ).dom.src= captchaURL+new Date().getTime();
              curr.slideIn('t');
        }},this); 
        },
        failure: function(action, response){
          	var result=response.responseText;
          	if(action.failureType == 'server')
          	{agerror('No se pudo conectar con la base de datos');}
        }
      });
  },
    initComponent:function()
    {            
      this.captchaURL = "../images/captcha/CaptchaSecurityImages.php?width=160&height=80&characters=4&cadena="+cadena+"&t=";
        var boxCaptcha =  new Ext.BoxComponent({
                  columnWidth:.35,

                  autoEl: {
                    tag:'img'
                    ,id: 'activateCodeImg'
                    ,title : 'Click para actualizar la imagen'
                    ,src:this.captchaURL+new Date().getTime()
                  }
                  ,listeners : {
                      'click' : function () {alert('test');}
                    }
        });
        boxCaptcha.on('render',function (){
          var curr = Ext.get('activateCodeImg');
          curr.on('click',this.onCapthaChange,this);
        },this);

      Ext.apply(this,{
      layout:'form',
      xtype: 'fieldset',
      name: 'formRegistroUsuario',
      id:  'formRegistroUsuario',
      frame: true,
      modal: true,
      bodyStyle:'background:#fFfFfF;',
      deferredRender:false,
      title: 'Registrarse',
      width: 350,
      height: 460,
      items: [{
            layout:'form',
            xtype: 'fieldset',
            labelWidth: 90,
            autoHeight : true,
	        width: 330,
            bodyStyle: Ext.isIE ? 'padding:0 0 15px 15px;' : 'padding:15px 15px;',
            border: false,
            style: {
              "margin-left": "10px",
            },
            defaults:{width: 180,allowBlank:false,xtype:'textfield'},
            items: [
              {
              xtype:'panel',height: 30,width: 278,border:false,
              items:
	              [{
	                xtype: 'label', text:  'Todos los campos son obligatorios',
	                style: 'font-size:8.5pt; color:#484848;font-weight: bold;',
	              }]
              },{
                fieldLabel: 'Nombres(*)', name: 'usuNombres',id: 'usuNombres',
                blankText: 'El Nombre es obligatorio'
              },{
                fieldLabel: 'Apellidos(*)',name: 'usuApellidos',id: 'usuApellidos',
                blankText: 'El Apellido es obligatorio'
              },{
                fieldLabel: 'Correo(*)', name: 'usuCorreo', id: 'usuCorreo',vtype:  'email',
                minLength : 5,// maxLength : 30,
                blankText: 'El Email es obligatorio'
              },{
                fieldLabel: 'Usuario(*)',name: 'usuUsuario',id: 'usuUsuario',
                blankText: 'El Login es obligatorio'
              },{
                fieldLabel: 'Clave(*)',name: 'usuClave',id: 'usuClave',inputType:'password',
                blankText: 'La clave es obligatoria, sera usara por usted para acceder a este servicio'
              },{
                fieldLabel: 'ReClave(*)', name: 'usuReClave', id: 'usuReClave',
                initialPassField: 'usu_contrasena', inputType:'password',
                blankText: 'La Repetici&oacute;n de la clave es obligatoria'
              },{
                xtype:'panel',border:false,height:15
              },{
		    	xtype:'fieldset', title:'Código de Seguridad',
		    	width: 235, defaultType: 'textfield',items:[boxCaptcha]
			  },{
                fieldLabel: 'Código',name: 'IDusuarios',id: 'idCaptcha',
                blankText: 'El codigo del captcha es obligatorio'
              }]
          }],
          buttons: [{
            text: 'Registrar',
            id     : 'btnAccept1_registro',
            iconCls:  'salvar',
            align:'center',
            handler:   function (){
    
				var registraValidada = verificaCamposRegistro();
				if(registraValidada)
				{
					Ext.Ajax.request({
						url: "autenticacion/cargar",
						params: { 
							task: "CREATEUSUARIO",
							nombres: Ext.getCmp('usuNombres').getValue(),
							apellidos: Ext.getCmp('usuApellidos').getValue(),
						    correo: Ext.getCmp('usuCorreo').getValue(),
						    usuario: Ext.getCmp('usuUsuario').getValue(),
						    clave: Ext.getCmp('usuClave').getValue()
						},
						success: function(response, action){
							obj = Ext.util.JSON.decode(response.responseText);
							if (obj.success)
							{   
								Ext.getCmp('agUsu_usuario').setValue(Ext.getCmp('usuUsuario').getValue());
								Ext.getCmp('agUsu_clave').setValue('');
							
							       //agalerta(obj.mensaje);
								ventanaRegistroUsuario1.close();
							}
							else if (obj.errors)
							{
								agadvertencia(obj.errors.reason);
								ventanaRegistroUsuario
								ventanaRegistroUsuario1.close();
							}
						},
						failure: function(action, response){
							var result=response.responseText;
							if(action.failureType == 'server')
							{
								agerror('No se pudo conectar con la base de datos');
								ventanaRegistroUsuario1.close();
							}
						}
					});
				}	
					
		    }
            },{
            text     : 'Cancelar',
            iconCls:  'cancelar',
            align:'center',
            handler  : function (){ventanaRegistroUsuario1.close();}
            }]
              });
              ventanaRegistroUsuario.superclass.initComponent.apply(this,arguments);
            }
  });


 

	function verificaCamposRegistro()
	{
	salida=true;
		
		if(!(Ext.getCmp('usuNombres').isValid() &&
		     Ext.getCmp('usuApellidos').isValid() &&
		     Ext.getCmp('usuCorreo').isValid() &&
		     Ext.getCmp('usuUsuario').isValid()  && 
		     Ext.getCmp('usuClave').isValid() &&
		     Ext.getCmp('usuReClave').isValid() )) 
	 	{
	 		agerror('Faltan campos por llenar');
	 		return false;
	 	}
		
		if(!(Ext.getCmp('usuClave').getValue() == Ext.getCmp('usuReClave').getValue())) 
	 	{agerror('La clave y la reclave deben ser iguales');
	 	return false;}
		

		if((Ext.getCmp('usuClave').getValue()).length < 8) 
	 	{
	 	agerror('La clave debe tener minimo 8 digitos');
	 	return false;
	 	}
	 	
	 	if(Ext.getCmp('idCaptcha').getValue() != cadena)
		{
		agerror('El codigo que introdujo en el captcha no es igual al de la imagen');
		return false;
		}
	 	
	return salida;
	}
			   		//ponEstilo();

  }//hasta qui van las llaves
  }
}();
