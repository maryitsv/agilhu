/*!
 * Ext JS Library 3.2.1
 * Copyright(c) 2006-2010 Ext JS, Inc.
 * licensing@extjs.com
 * http://www.extjs.com/license
 */

Ext.ns('agilhu.wammetEstimacion');

/**
* Función para hacer el calculo de la estimación, recibe dos parametros y
* muestra la ventana para estimar la historia de usuario.
* @author Luis Armando Nuñez Sanchez
* @since  18/08/2010 
* @param  idHistoria : identificador de la historia de usario
* @param  nameHistoria : nombre de la historia de usuario
*/

agilhu.wammetEstimacion = function(idHistoria,nameHistoria){
     
	 Ext.QuickTips.init();
	 
	
     //entradas de para la evaluación
     var inEstimacion = [
      ["Entradas al Sistema",0.0,0.0,0.0,0.0,1.0,0.0],
      ["Salidas del Sistema",0.0,0.0,0.0,0.0,1.5,0.0],
      ["Entidades del Modelo Relacional",0.0,0.0,0.0,0.0,2.0,0.0],
      ["Interfases Sistemas Externos API",0.0,0.0,0.0,0.0,1.0,0.0],
      ["Interfases Sistemas Protocolo",0.0,0.0,0.0,0.0,1.5,0.0]
     ];
    
    var storeEstimacion = new Ext.data.ArrayStore({
		id : 'idstestimacion',
        fields: [
           'nombre',
           {name: 'probable',  type: 'float'},
           {name: 'optimista', type: 'float'},
           {name: 'pesimista', type: 'float'},
           {name: 'cantidad',  type: 'float'},
           {name: 'peso',      type: 'float'},
           {name: 'valor',     type: 'float'}
        ]
    });

    storeEstimacion.loadData(inEstimacion);

    var cmEstimacion = new Ext.grid.ColumnModel([
      { id: 'idMetrica', header: "Metrica",dataIndex: 'nombre', hideable: false},
      { header: "Probable", width: 40, dataIndex:'probable', hideable: false,
		editor: new Ext.form.NumberField({
                    allowBlank: false,
					allowNegative: false,
					allowDecimals: false
                })
	  },
      { header: "Optimista",width: 40, dataIndex:'optimista', hideable: false,
		editor: new Ext.form.NumberField({
                    allowBlank: false,
					allowNegative: false,
					allowDecimals: false
				})
	  },
      { header: "Pesimista",width: 40, dataIndex:'pesimista', hideable: false,
		editor: new Ext.form.NumberField({
                    allowBlank: false,
					allowNegative: false,
					allowDecimals: false
				})
	  },
      { header: "Cantidad",width: 40, dataIndex:'cantidad', hideable: false,renderer: renRojo},
      { header: "Peso", width: 40, dataIndex:'peso', hideable: false, renderer:renRojo},
      { header: "Valor",width: 40, dataIndex:'valor', hideable: false,renderer:renRojo}
    ]);
	
	function renRojo(val){
		var arr = ['red','green','blue'];
		return '<span style="color:'+arr[Math.floor(Math.random()*3)]+';">' + val + '</span>';
	}
	
    
    //panel intereacción funcional y persistencia
    var pnfuncionalPersistencia = new Ext.form.FieldSet({  
      title: 'Interaccion Funcional y Persistencia',
      height: 390,
      layout: 'border',
      items: [
	{
	  id : 'idgriditf',
	  region: 'center',
	  xtype: 'editorgrid',
	  store: storeEstimacion,
	  cm: cmEstimacion,
	  autoExpandColumn: 'idMetrica',
	  clicksToEdit: 1,
	  stripeRows: true,
	  border: false,
	  frame: true,
	  listeners : {
		'afteredit' : actualizarGrid
	  }
	},
	{
	  region: 'south',
	  layout: 'form',
	  height: 200,
	  defaults: {width: 50},
	  labelWidth: 355,
	  autoScroll: true,
	  border: false,
	  frame: true,
	  items:[
	    {
	      id : 'idtifpsa',
		  xtype: 'textfield',
	      fieldLabel: 'Total Integracion Funcional - Persistencia Sin Ajustar',
	      disabled: true,
	      name: 'TIFPSA'
	    },
		{
		  xtype: 'fieldset',
	      title: 'Ajuste de complejidad',		  
		  width: '100%',
		  height: 120,
		  defaults: {
			xtype : 'radiogroup'
		  },
		  items: [
		     {
			   id : 'lognegasociada',
			   fieldLabel : 'Logica de negocio asociada',
			   items: [
			    {boxLabel: 'Muy Alta 2', name: 'logNegocio', inputValue: 2},
				{boxLabel: 'Alta 1', name: 'logNegocio', inputValue: 1},
				{boxLabel: 'Media 0,5', name: 'logNegocio', inputValue: 0.5},
				{boxLabel: 'Baja 0,1', name: 'logNegocio', inputValue: 0.1, checked: true}
			   ]
			 },
			 {
			   id : 'aygencodigo',
			   fieldLabel : 'Ayuda mediante Generador Codigo',
			   items: [
				{boxLabel: 'Alta 0,5', name: 'ayuGenCodigo', inputValue: 0.5},
				{boxLabel: 'Media 0,75', name: 'ayuGenCodigo', inputValue: 0.75},
				{boxLabel: 'Baja 0,95', name: 'ayuGenCodigo', inputValue: 0.95, checked: true}
			   ]
			 }
		  ]
		},
		{
		  id: 'idtifp',
		  xtype: 'textfield',
	      fieldLabel: 'Total Integracion Funcional - Persistencia',
	      disabled: true,
	      name: 'TIFP'
		}
	  ]
	}
      ]
    });

	//panel tipo de pantalla
	var pntipoPantalla= new Ext.form.FieldSet({
	  title: 'Tipo Pantalla',
      height: 300,
	  labelWidth: 5,
	  defaults : {
		xtype : 'radiogroup',
		listeners : {
			'change' : actualizarFTP
		}
	  },
	  items:[
		{
		  items: [
		    {boxLabel: 'No Aplica(1)', name:'tipPantalla', inputValue:1, checked: true},
			{xtype: 'label', text: 'Baja', cls:'x-form-check-group-label'},
			{xtype: 'label', text: 'Media', cls:'x-form-check-group-label'},
			{xtype: 'label', text: 'Alta', cls:'x-form-check-group-label'}
		  ]
		},
		{
		  items: [
			{xtype: 'label', text: 'Maestro', cls:'x-form-check-group-label'},
			{boxLabel: '1,08',   name: 'tipPantalla', inputValue: 1.08},
			{boxLabel: '1,2',    name: 'tipPantalla',  inputValue: 1.2},
			{boxLabel: '1,3',    name: 'tipPantalla',  inputValue: 1.3}
		  ]		  
		},
		{
		  items: [
			{xtype: 'label', text: 'Maestro-Detalle', cls:'x-form-check-group-label'},
			{boxLabel: '1,1', name: 'tipPantalla', inputValue: 1.1},
			{boxLabel: '1,3', name: 'tipPantalla', inputValue: 1.3},
			{boxLabel: '1,5', name: 'tipPantalla', inputValue: 1.5}
		  ]		  
		},
		{
		  items: [
			{xtype: 'label', text: 'Proceso', cls:'x-form-check-group-label'},
			{boxLabel: '1,08', name: 'tipPantalla', inputValue: 1.08},
			{boxLabel: '1,2', name: 'tipPantalla', inputValue: 1.2},
			{boxLabel: '1,5', name: 'tipPantalla', inputValue: 1.5}
		  ]		  
		},
		{
		  items: [
			{xtype: 'label', text: 'Interactiva grafica', cls:'x-form-check-group-label'},
			{boxLabel: '1,3', name: 'tipPantalla', inputValue: 1.3},
			{boxLabel: '1,5', name: 'tipPantalla', inputValue: 1.5},
			{boxLabel: '1,8', name: 'tipPantalla', inputValue: 1.8}
		  ]		  
		},
		{
		  items: [
			{xtype: 'label', text: 'Reporte Basico', cls:'x-form-check-group-label'},
			{boxLabel: '1,03', name: 'tipPantalla', inputValue: 1.03},
			{boxLabel: '1,1', name: 'tipPantalla', inputValue: 1.1},
			{boxLabel: '1,3', name: 'tipPantalla', inputValue: 1.3}
		  ]		  
		},
		{
		  items: [
			{xtype: 'label', text: 'Reporte Grafico', cls:'x-form-check-group-label'},
			{boxLabel: '1,3', name: 'tipPantalla', inputValue: 1.3},
			{boxLabel: '1,5', name: 'tipPantalla', inputValue: 1.5},
			{boxLabel: '1,8', name: 'tipPantalla', inputValue: 1.8}
		  ]		  
		},
		{
		  items: [
			{xtype: 'label', text: 'Reporte Mixto', cls:'x-form-check-group-label'},
			{boxLabel: '1,4',  name: 'tipPantalla', inputValue: 1.4},
			{boxLabel: '1,6', name: 'tipPantalla', inputValue: 1.6},
			{boxLabel: '2', name: 'tipPantalla', inputValue: 2}
		  ]		  
		},
		{
		  xtype:'fieldset',
		  width:'100%',
		  labelWidth: 200,
		  border: false,
		  items:[
		    {
			  id : 'idftp',
			  xtype:'textfield',
		      fieldLabel: 'Factor Complejidad Pantalla',
			  width: 50,
			  disabled: true,
		      name: 'FTP',
			  value : 1
			}
		  ]
		}
	  ]
	});
    
	//panel salvar y calcular esfuerzo
	var pnsalvarCalcularEsfuerzo= new Ext.form.FormPanel({
      height: 130,
	  frame: true,
	  border: false,
	  defaultType: 'numberfield',
	  defaults: {width: 100,readOnly:true, allowBlank: false},
	  labelWidth: 200,
	  items: [
	    {
		  id : 'idreut',
		  fieldLabel: 'Porcentaje de reutilizacion (%)',
		  name: 'REUT',
		  readOnly:false,
		  disabled: false,
		  allowDecimals: false,
		  allowNegative: false,
		  maxValue : 100,
		  minValue : 0,
		  value: 0
		},
		{
		  id : 'idpw', 
		  fieldLabel: 'Puntos Web totales',
		  name: 'PW'
		},
		{
		  id : 'idesfuerzo',
		  fieldLabel: 'Esfuerzo',
		  name: 'esfuerzo'
		}
	  ],
	  buttonAlign: 'right',
	  buttons: [
	    {text:'Calcular esfuerzo', handler : calcularEsfuerzo},
		{text:'Aplicar', handler : aplicarEsfuerzo}
	  ]
	});
	
	
	/*
	* Esta función envia los "Puntos Web totales" y el "Esfuerzo" al servidor
	* para que sean aplicados a la historia de usuario identificada con idHistoria
	*/
	function aplicarEsfuerzo(){
		if(pnsalvarCalcularEsfuerzo.getForm().isValid())
		{
			//envio la información al servidor
			pnsalvarCalcularEsfuerzo.getForm().submit({
				url: 'historiasusuario/guardar',//Cambiar por la url al action encargada de procesar la peticion
				method: 'POST',
				waitTitle: 'Aplicar esfuerzo',
				waitMsg: 'Enviando datos...',
				params: {
					his_id : idHistoria, //envio el identificador de la historia a estimar
					task : 'Estimar'
				},
				success: function(fm,at)
				{
					//cierro la ventana despues de enviados
					// y procesados los datos.				
					Ext.Msg.alert('Resultado',at.result.msg, function(){
							win.close();//cierro la ventana
					});	
				},
				failure: function(fm,at)
				{
					//muestro el error y dejo la ventana abierta
					//dando la posibilidad al usuario de corregirlo
					switch (at.failureType) {
					case Ext.form.Action.CLIENT_INVALID:
						Ext.Msg.alert('Error', 'Los campos del formulario no pueden ser enviados con valores invalidos');
					break;
					case Ext.form.Action.CONNECT_FAILURE:
						Ext.Msg.alert('Error', 'Ajax fallo la comunicacion');
					break;
					case Ext.form.Action.SERVER_INVALID:
						Ext.Msg.alert('Error', at.result.msg);
					}
				}
			});
			
		}else{
			Ext.Msg.show({
			   title:'Aplicar esfuerzo',
			   msg: 'Debes calcular el esfuerzo',
			   buttons: Ext.Msg.OK,
			   icon: Ext.MessageBox.WARNING
			});
		}
	}
	
	
    var win = new Ext.Window({
      title: nameHistoria,//nombre de la historia de usuario
      width: 500,
      height:600,
      autoScroll: true,
	  modal: true,
      items: [pnfuncionalPersistencia,pntipoPantalla,pnsalvarCalcularEsfuerzo]
    });

	function actualizarGrid(obj){
		var reg = obj.record; //obtengo el registro editado
		
		//cantidad = (sopt + 4*spro + spes)/6
		var valCantida = (reg.data.optimista + reg.data.pesimista + (4*reg.data.probable))/6;
		var valValor   = reg.data.peso * valCantida;
		reg.set('cantidad',valCantida);
		reg.set('valor',valValor);
		reg.commit();

		//Hago la suma de la columna valor al campo tifpsa
		var stEstimacion = Ext.getCmp('idgriditf').getStore();
		Ext.getCmp('idtifpsa').setValue(stEstimacion.sum('valor'));
	}

	function actualizarFTP(rg,r){
		Ext.getCmp('idftp').setValue(r.getRawValue());
	}
  
  
  /**
  * Función que calcula el esfuerzo para una historia de usuario
  * esta función es llamada cuando se presiona el boton "Calcular esfuerzo"
  */
  function calcularEsfuerzo(b,e){
	var tifpsa = Ext.getCmp('idtifpsa').getValue();
	var rlna = Ext.getCmp('lognegasociada').getValue(); //logica de negocio asociada
	var rgnc = Ext.getCmp('aygencodigo').getValue(); //ayuda generador de codigo
	
	//calculo el tifp
	var tifp = tifpsa;
	tifp *= (Ext.isEmpty(rlna))? 1: rlna.getRawValue();
	tifp *= (Ext.isEmpty(rgnc))? 1: rgnc.getRawValue();
	Ext.getCmp('idtifp').setValue(tifp);
	
	//hago uso del ftp
	var ftp= Ext.getCmp('idftp').getValue();
	var reut = Ext.getCmp('idreut').getValue();
	
	//calculo los puntos web.
	var pw = (tifp * ftp) * ((100-reut)/100);
	Ext.getCmp('idpw').setValue(pw);
	
	//Calculo del esfuerzo
	var A = 14.95;
	var B = 0.66;
	var esfuerzo = A * Math.pow(pw,B);
	Ext.getCmp('idesfuerzo').setValue(esfuerzo);
  }
  
  
  //la ventana donde se despliegan los campos para hacer la estimación
  return win;
  
}

	


