/* function listar() {
	console.log('ejecutandose');
	$('#tabla').DataTable({
		"language": {
			"sProcessing": "Procesando...",
			"sLengthMenu": "Mostrar _MENU_ registros",
			"sZeroRecords": "No se encontraron resultados",
			"sEmptyTable": "Ningún dato disponible en esta tabla",
			"sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			"sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
			"sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix": "",
			"sSearch": "Buscar Usuario:",
			"sUrl": "",
			"sInfoThousands": ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
				"sFirst": "Primero",
				"sLast": "Último",
				"sNext": "Siguiente",
				"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending": ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}
		},
		"ajax":
		{
			url: '../Controlador/gestion_docente_controlador.php?op=listar',
			type: "get",
			dataType: "json",
			error: function (e) {
				console.log(e.responseText);
			}
		}
	});
} */
/* //FECHA MAXIMA HOY
let today = new Date();
let dd = today.getDate();
let mm = today.getMonth() + 1; //January is 0!
let yyyy = today.getFullYear();
if (dd < 10) {
	dd = '0' + dd;
}
if (mm < 10) {
	mm = '0' + mm;
}

today = yyyy + '-' + mm + '-' + dd;

let minimum = '1970-01-01';

let search_date = document.getElementById('fecha_ingreso');

search_date.max = today;
search_date.min = minimum; */


/* var hoy = new Date();
fecha = hoy.getDate() + '-' + ( hoy.getMonth() + 1 ) + '-' + hoy.getFullYear();
hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
fechaYHora = fecha + ' ' + hora;
var table; */

/* function select_periodo() {
	$.post(
		"../Controlador/reporte_docente_controlador.php?op=select_periodo",
		function (data, status) {
			data = JSON.parse(data);
			// console.log(data);
			//mostrarform(true);
			$("#txt_periodo").val(data.num_periodo);
			$("#txt_año").val(data.num_anno);
		}
	);
} */

function TablaDocente() {
	table = $('#tabladocentes').DataTable({
		paging: true,
		lengthChange: true,
		ordering: true,
		info: true,
		autoWidth: true,
		responsive: true,
		ordering: true,
		// LengthChange: false,
		searching: { regex: true },
		lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
		sortable: false,
		/* pageLength: 15, */
		
		destroy: true,
		async: false,
		processing: true,
		ajax: {
			url: '../Controlador/tabla_docente_controlador.php',
			type: 'POST'
		},
		
		dom: "Bfrtilp",
		"buttons": [


			{
		 
				 "extend":'excelHtml5',
				 "text":   'Excel  <i class = "fa fa-print"></i>',
				 "title": 'Reporte de docentes',
				 "titleAttr":'Exportar a Excel',
				 "className":'btn btn-success',
				 "message": '    FECHA: '+  ((new Date().getDate()+'-'+(new Date().getMonth()+1)+'-'+new Date().getFullYear()).toString()
				 ) +'    HORA: '+ (new Date().getHours()+':'+new Date().getMinutes()+':'+new Date().getSeconds()).toString(), 
				 
				 
				 "exportOptions": {
					columns: [1, 2, 3, 4, 7, 8, 9, 10],
								 modifier: {
								 page: 'current'
										 }
		 
								  },
		 
		 
					   
		 
		 customize:  function (xlsx) {  
		 
		 
		 
		 function _createNode(doc, nodeName, opts) { 
			 var tempNode = doc.createElement(nodeName);
		 
			 if (opts) {
				 if (opts.attr) {
					 $(tempNode).attr(opts.attr);
				 }
		 
				 if (opts.children) {
					 $.each(opts.children, function (key, value) {
						 tempNode.appendChild(value);
					 });
				 }
		 
				 if (opts.text !== null && opts.text !== undefined) {
					 tempNode.appendChild(doc.createTextNode(opts.text));
				 }
			 }
		 
			 return tempNode;
		 }
		 var sheet = xlsx.xl.worksheets['sheet1.xml'];
		 var mergeCells = $('mergeCells', sheet);
		 mergeCells[0].children[0].remove(); // remove merge cell 1st row
		 
		 var rows = $('row', sheet);
		 rows[0].children[0].remove();
		  // clear header cell
		 
		 // create new cell
		 rows[0].appendChild(_createNode(sheet, 'c', {
			 attr: {
				 t: 'inlineStr',
				 r: 'A1', //address of new cell
				 s: 51 // center style - https://www.datatables.net/reference/button/excelHtml5
			 },
			 children: {
				 row: _createNode(sheet, 'is', {
					 children: {
						 row: _createNode(sheet, 't', {
		 
		 
							 text: '           DEPARTAMENTO DE INFORMÁTICA, UNAH - REPORTE DE DOCENTES ',
							
							
						 })
					 }
				 })
			 }
		 }));
		 
		 
		 
		 mergeCells[0].appendChild(_createNode(sheet, 'mergeCell', {
			 attr: {
				 ref: 'A1:G1' // merge address
			 }
		 }));
		 
		 mergeCells.attr('count', mergeCells.attr('count') + 1);
		 
		 
		 },
		 
		 
				 
		   },
		 
			 {
			   
				 "extend":'pdfHtml5',
				  /* "download": 'open', */
				 "pageSize": 'legal',
				 "orientation": 'landscape',
				 "title": 'Reporte de docentes',  
				 "text":   'PDF <i class = "fa fa-print"></i>',
				 "titleAttr":'Exportar a PDF',
				 "className":'btn btn-danger',
				
				
				 "exportOptions": {
					columns: [1, 2, 3, 4, 7, 8, 9, 10],
		 
								
		 
								 modifier: {
								 page: 'current'
										 }
										 
		 
								  },
								 
								 
								  messageTop: '    FECHA: '+  ((new Date().getDate()+'-'+(new Date().getMonth()+1)+'-'+new Date().getFullYear()).toString()
								  ) +'    HORA: '+ (new Date().getHours()+':'+new Date().getMinutes()+':'+new Date().getSeconds()).toString() + '                                                                                                                        REPORTE DE DOCENTES ', 
								 
								  
								  
		 
							   
								  
		 
		 
		 
		 
		 
		 
		 
		 customize: function(doc) {
		 doc.content[2].margin = [ 150, 0, 150, 0 ], //left, top, right, bottom
		 doc.content[2].margin = [0, 15, 100, 0]
		 doc.content[2].table.widths = ["15%", "20%","11%","10%","10%","7%","22%","16%"];
		   doc.styles.tableBodyEven.alignment = 'center';
		   doc.styles.tableBodyOdd.alignment = 'center'; 
		 
		 
		 
		 
		 
		 // Eliminar el título creado por datatTables
				 doc.content.splice(0,1,)
		 
		 // Crea una cadena de fecha que usamos en el pie de página. El formato es dd-mm-yyyy
				 var now = new Date();
				 var jsDate = now.getDate()+'-'+(now.getMonth()+1)+'-'+now.getFullYear();
				 var tiempo = now.getHours()+':'+now.getMinutes()+':'+now.getSeconds();
				 
		 
													 
				 var logo='data:image/png;base64,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';
		 
		 
		 // Se puede encontrar una referencia de documentación en
		 // https://github.com/bpampuch/pdfmake#getting-started
		 // Establecer márgenes de página [izquierda, arriba, derecha, abajo] u [horizontal, vertical]
		 // o un número para un diferencial igual
		 // ¡Es importante crear suficiente espacio en la parte superior para un encabezado!
				 doc.pageMargins = [30,100,20,25];
				 // Establece el tamaño de fuente para todo el documento
				 doc.defaultStyle.fontSize = 10;
				 // Establecer el tamaño de fuente para el encabezado de la tabla
				 doc.styles.tableHeader.fontSize =10;
			   
				 
		 // Crear un objeto de encabezado con 3 columnas
		 // Lado izquierdo: logotipo
		 // Medio: nombre de marca
		 // Lado derecho: título de un documento
				 doc['header']=(function() {
				   return {
					 columns: [
						{
										   
						 image: logo,
		 
						 
						 width: 60,
									   height: 60,
									   right:40,
									   
						 
					   },
					  /*  {
						 
					   }, */
					   
						  
		 
						{
						 alignment: 'center', 
						 
						 text:['UNIVERSIDAD NACIONAL AUTÓNOMA DE HONDURAS                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           FACULTAD DE CIENCIAS ECONÓMICAS, ADMINISTRATIVAS Y CONTABLES                                                                                                                                                                                                                                    DEPARTAMENTO DE INFORMÁTICA ',],
						/* fontSize: 9, */
									   bold: true,
		 
									   
								   
		 
									  
									   
					   },
					   /*  {
						 
					   }, */
						  
					   
						  
						 
						/*  {
						 alignment: 'center',
						 fontSize: 11,
						 text: ['Fecha: ', { text: jsDate.toString() },'    Hora: ', {text: tiempo.toString() }]
					   }, */
		 
					   
		 
		 
		 
					 ],
					 
		 
		 
					 margin:[15, 30], 
				   }
				   
				 });
			   
				 
		 
		 // Crear un objeto de pie de página con 2 columnas
		 // Lado izquierdo: fecha de creación del informe
		 // Lado derecho: página actual y páginas totales
				 doc['footer']=(function(page, pages) {
				   return {
					 columns: [
		 
					   {
						 alignment: 'center',
						 fontSize: 11,
						 text: ['página ', { text: page.toString() },  ' de ', { text: pages.toString() },]
					   }
					 ],
					 margin: [10, 0],
				   }
					 });
				 
		 // Cambiar diseño de tabla de datos (estilo de tabla)
		 // Para usar diseños predefinidos, descomente la línea a continuación y comente las líneas personalizadas a continuación
		 // doc.content [0] .layout = 'lightHorizontalLines'; // noBorders, headerLineOnly
				 
				 var objLayout = {};
				 objLayout['hLineWidth'] = function(i) { return .5; };
				 objLayout['vLineWidth'] = function(i) { return .5; };
				 objLayout['hLineColor'] = function(i) { return '#aaa'; };
				 objLayout['vLineColor'] = function(i) { return '#aaa'; };
				 objLayout['paddingLeft'] = function(i) { return 4; };
				 objLayout['paddingRight'] = function(i) { return 4; };
				 doc.content[1].layout = objLayout;
				 
			 
		 
		 },
					   },
				
		 
		 
		 
			 ],
			 columns: [
				{ data: 'id_persona' },
				{ data: 'numero_empleado' },
				{ data: 'nombre' },
				{ data: 'identidad' },
				{ data: 'fecha_ingreso' },
				{ data: 'jornada' },
				{ data: 'hr_inicial' },
				{ data: 'hr_final' },
				{ data: 'categoria' },
				{ data: 'sued' },
				{ data: 'Comisiones_Actividades' },
				/* { data: 'actividad' }, */
				{ data: 'correos' },
				{ data: 'contactos' },
				/* { data: 'foto' },
				{ data: 'curriculum' }, */
				{data: 'Estado',
					render: function(data, type, row) {
						if (data == 'ACTIVO') {
							return "<span class='label label-success'>" +data+ '</span>';
						} else {
							return "<span class='label label-danger'>" +data+ '</span>';
						}
					}
					
				},
				/* {defaultContent:
					"<div class=''> <button style='font-size:13px;' type='button' class='editar btn btn-primary btn-m '<i class='fas fa-edit'></i></button><button style='font-size:13px;' type='button' class='desactivar btn btn-danger'><i class='fa fa-trash'></i></button>&nbsp;<button style='font-size:13px;' type='button' class='activar btn btn-success'><i class='fa fa-check'></i></button> </div>"
					
				} */
				{
					"defaultContent": "<button style='font-size:13px;' type='button' class='desactivar btn btn-danger'></i><i class='fas fa-ban'></i></button>&nbsp;<button style='font-size:13px;' type='button' class='activar btn btn-success'><i class='fa fa-check-circle'></i></button>"
				
				},
				{
					"defaultContent": "<button style='font-size:13px;' type='button' class='editar btn btn-primary '><i class='fas fa-edit'></i></button>"
				
				} 
	
					
				
				
			],
	
			language: idioma_espanol,
			select: true
			 
		 
		 
		 
		 });
		 
		 
		 
		 document.getElementById("tabladocentes_filter").style.display = "none";
		 $('input.global_filter').on( 'keyup click', function () {
			  filterGlobal();
		  } );
		  $('input.column_filter').on( 'keyup click', function () {
			  filterColumn( $(this).parents('tr').attr('data-column') );
		  });
		 } 
		 function filterGlobal() {
		 $("#tabladocentes").DataTable().search($("#global_filter").val()).draw();
		 }
		
var num_periodo = document.getElementById('txt_periodo').value;
var num_año = document.getElementById('txt_anno').value;

//funciones de activar usuario
$('#tabladocentes').on('click', '.activar', function () {
	var data = table.row($(this).parents('tr')).data();
	if (table.row(this).child.isShown()) {
		var data = table.row(this).data();
	}
	if (data.Estado == 'ACTIVO') {
		mensaje = "ya se encuentra activo";
		swal(
			"Alert", "El usuario " + mensaje + "", "warning");
	} else {
	swal({
		title: "Alerta!",
		text:
			"Esta seguro de activar el docente ?",
		icon: "warning",
		buttons: true,
		dangerMode: false,
	}).then((willDelete) => {
		if (willDelete) {

			Modificar_Estatus(data.id_persona, 'ACTIVO');
			/* table.ajax.reload();  */

		}
	});
	}
})

$('#tabladocentes').on('click','.desactivar',function(){
    var data = table.row($(this).parents('tr')).data();
    if(table.row(this).child.isShown()){
		var data = table.row(this).data();
		
	}
	if (data.Estado == 'INACTIVO') {
		mensaje = "ya se encuentra inactivo";
		swal(
			"Alert", "El usuario " + mensaje + " ", "warning");
	} else {
		
	
	swal({
		title: "Alerta!",
		text:
			"Esta seguro de desactivar el docente ?",
		icon: "warning",
		buttons: true,
		dangerMode: false,
	}).then((willDelete) => {
		if (willDelete) {
			
		 	Modificar_Estatus(data.id_persona, 'INACTIVO');
			 /* table.ajax.reload();  */ 
			
		} 
	});

	}
})

function Modificar_Estatus(id_persona_,Estado){
     var mensaje ="";
    if(Estado=='INACTIVO'){
        mensaje="desactivó"; 
    }else{
        mensaje="activó";
    }
    $.ajax({
		"url": "../Controlador/actualizar_estado_controlador.php",
        type:'POST',
        data:{
            id_persona:id_persona_,
            Estado:Estado
        }
    }).done(function(resp){
        if(resp>0){
			swal(
				"Buen trabajo!", "El usuario se " + mensaje + " con exito", "success"
			);
			table.ajax.reload();
		} else {
			swal(
				"Buen trabajo!", "ERROR TONTA", "success"
			);
		}
		
		
    })


}
function llenar_selectJOR() {
	var cadena = '&activar=activar';
	$.ajax({
		url: '../Controlador/gestion_docente_controlador.php?op=selectJOR',
		type: 'POST',
		data: cadena,
		success: function(r) {
			// console.log(r);

			$('#jornada_edita').html(r).fadeIn();
		}
	});
}
llenar_selectJOR();

function llenar_selectNACI() {
	var cadena = '&activar=activar';
	$.ajax({
		url: '../Controlador/gestion_docente_controlador.php?op=selectNACI',
		type: 'POST',
		data: cadena,
		success: function(r) {
			//  console.log(r);

			$('#nacionalidad_edita').html(r).fadeIn();
		}
	});
}
llenar_selectNACI();

function llenar_selectCAT() {
	var cadena = '&activar=activar';
	$.ajax({
		url: '../Controlador/gestion_docente_controlador.php?op=selectCAT',
		type: 'POST',
		data: cadena,
		success: function(r) {
			// console.log(r);

			$('#categoria_edita').html(r).fadeIn();
		}
	});
}
llenar_selectCAT();

function llenar_selectHEN() {
	var cadena = '&activar=activar';
	$.ajax({
		url: '../Controlador/gestion_docente_controlador.php?op=selectHEN',
		type: 'POST',
		data: cadena,
		success: function(r) {
			console.log(r);

			$('#hr_inicio_edita').html(r).fadeIn();
		}
	});
}
llenar_selectHEN();
function llenar_selectHSAL() {
	var cadena = '&activar=activar';
	$.ajax({
		url: '../Controlador/gestion_docente_controlador.php?op=selectHSAL',
		type: 'POST',
		data: cadena,
		success: function(r) {
			console.log(r);

			$('#hr_final_edita').html(r).fadeIn();
		}
	});
}
llenar_selectHSAL();



//VALIDAR HORARIOS
function valida_horario_edita() {
	var hora_inicial = document.getElementById('hr_inicio_edita').value;
	var hora_final = document.getElementById('hr_final_edita').value;

	if (hora_inicial > hora_final) {
		//alert("Hora inicial incorrecta");
		swal({
			title: 'alerta',
			text: 'Hora incorrecta',
			type: 'warning',
			showConfirmButton: true,
			timer: 20000
		});
		document.getElementById('hr_inicio_edita').value = '';
		document.getElementById('hr_final_edita').value = '';
	} else {
		if (hora_inicial == hora_final) {
			swal({
				title: 'alerta',
				text: 'Las horas son iguales',
				type: 'warning',
				showConfirmButton: true,
				timer: 20000
			});
			// alert("Las horas son iguales");
			document.getElementById('hr_inicio_edita').value = '';
			document.getElementById('hr_final_edita').value = '';
		}
	}
}
$('#jornada_edita').change(function() {
	var jornada = $(this).val();
	console.log(jornada);

	$.post('../Controlador/registro_docente_controlador.php?op=descripcion', { id_jornada: jornada }, function(
		data_,
		status
	) {
		data_ = JSON.parse(data_);

		// console.log(data_.capacidad);
		$('#jornada_id').val(data_.jornada);
	});
});

// para borrar horas al seleccionar nueva jornada
$("#jornada_edita").change(function () {
  var selected_jornada = jornada_edita.options[jornada_edita.selectedIndex].text;

	if (selected_jornada == "TIEMPO COMPLETO") {

		document.getElementById("hr_inicio_edita").value = "";
		document.getElementById("hr_final_edita").value = "";
  
    
	} else if (selected_jornada == "MEDIO TIEMPO") {

	document.getElementById("hr_inicio_edita").value = "";
	document.getElementById("hr_final_edita").value = "";
    	
   
	} else if (selected_jornada == "POR HORA") {

		document.getElementById("hr_inicio_edita").value = "";
		document.getElementById("hr_final_edita").value = "";
	}

});

function valida_jornada_hora() {
	var jornada = $('#jornada_id').val();
	var hora_entrada = $('#hr_inicio_edita').val();
	var hora_salida = $('#hr_final_edita').val();

	if (jornada == 'TIEMPO COMPLETO' && ((hora_salida - hora_entrada) < 600)) {
		swal({
			title: 'Alerta',
			text: 'Deben ser al menos 6 horas laborales para jornada completa',
			type: 'warning',
			showConfirmButton: true,
			timer: 10000
		});
		document.getElementById('hr_inicio_edita').value = '';
		document.getElementById('hr_final_edita').value = '';
	} else if (jornada == 'MEDIO TIEMPO' && ((hora_salida - hora_entrada) < 300)) {
		swal({
			title: 'Alerta',
			text: 'Deben ser al menos 3 horas laborales para media jornada',
			type: 'warning',
			showConfirmButton: true,
			timer: 20000
		});
		document.getElementById('hr_inicio_edita').value = '';
		document.getElementById('hr_final_edita').value = '';
	} else {
	}
}


$('#tabladocentes').on('click', '.editar', function() {
	var data = table.row($(this).parents('tr')).data();
	if (table.row(this).child.isShown()) {
		var data = table.row(this).data();
	}

	$('#modal_editar').modal({ backdrop: 'static', keyboard: false });
	$('#modal_editar').modal('show');
	$('#txt_id_persona').val(data.id_persona);
	$('#txt_nombre_docente').val(data.nombre);
	$('#nempleado_edita').val(data.numero_empleado);
	$("#jornada_edita").val(data.id_jornada).trigger("change");
	$("#categoria_edita").val(data.id_categoria).trigger("change");
	$("#hr_inicio_edita").val(data.hr_inicial).trigger("change");
	$("#hr_final_edita").val(data.hr_final).trigger("change");
	$("#sued").val(data.sued).trigger("change");
	$("#fecha_ingreso").val(data.fecha_ingreso);
	$("#identidad_edita").val(data.identidad);
	$("#nacionalidad_edita").val(data.nacionalidad).trigger("change");
	
	

	//var id_persona=$("#txt_id_persona").val();

	Actividades();
});

function ValidarIdentidad(identidad) {
	//console.log(n);
	var n = identidad.search('_');
	console.log(n);
	
	var depto = identidad.substring(0, 4);
	var contar = depto;

	console.log(contar);

	if (n == 5) {
		var ver = false;
		$.post('../Controlador/registro_docente_controlador.php?op=validar_depto', { codigo: contar }, function(
			data,
			status
		) {
			console.log(data);
			data = JSON.parse(data);
			console.log(data);
			/*si no tiene datos va copiar  */
			//$("#contar_depto").val(data.regis);

			if (data.regis == 0) {
				var ver = true;

				if (ver == true) {
					swal(
						'Datos incorrectos',
						'Asegurese de Introducir los digitos correspondientes a su departamento y municipio',
						'warning'
					);
					//$('#contar_depto').val('');
					$('#identidad_edita').val('');
					$('#identidad_edita').attr('placeholder', '____-____-_____');
				}
			}
		});
	}

	if (n == 10) {
		var currentTime = new Date();
		//var year = currentTime.getFullYear();
		var anio = identidad.substring(5, 9);
		//console.log(year-anio);

		if (anio == '0000') {
			swal('Aviso', 'Año invalido', 'warning');
			$('#identidad_edita').val('');
			$('#identidad_edita').attr('placeholder', '____-____-_____');
		} else {
		}
	}

	if (n == -1) {
		var ultimo = identidad.substring(10, 15);
		// console.log(anio);
		if (ultimo == '00000') {
			swal('Aviso', 'no se permiten 5 ceros', 'warning');
			$('#identidad_edita').val('');
			$('#identidad_edita').attr('placeholder', '____-____-_____');
		} else {
		}
	}
}
function persona() {
	document.getElementById('txt_id_persona1').value = document.getElementById('txt_id_persona').value;

	/* $.post("../Controlador/actividades.php", { id_comisiones: la_comision }, function (data, status) {
		//console.log(data);
		data = JSON.parse(data);
		console.log(data); */
	/* $("#txt_actividad").val(data.id_actividad); */

	/* }); */
}

//CARGAR TABLA DE ACTIVIDADES
/* function TraerDatos() {
	var id_persona = $("#txt_id_persona").val();

	$.post("../Controlador/perfil_docente_controlador.php?op=Actividades", { id_persona: id_persona }, function (data, status) {
		//console.log(data);
		data = JSON.parse(data);
		console.log(data);
		for (var i = 0; i < data.actividades.length; ++i) {

			let n = 1 + i;

			$('#tbl_comisiones').append(
				'<tr id="row">' +
				'<td> </td>' +
				'<td>' + data['actividades'][i].comision + '</td>' +
				'<td>' + data['actividades'][i].actividad + '</td>' +
				'<td><button type="button" name="remove" id="' + n + '" class="btn btn-danger btn_remove">X</button></td>' +
				'</tr>');
		}

	})
} */
$(document).ready(function() {
	function eliminar() {
		var confirmLeave = confirm('¿Desea eliminar actividad del docente?');
		if (confirmLeave == true) {
			var id = $(this).attr('id');
			var eliminar_actividad = document.getElementById('tel' + id).value;
			console.log(eliminar_actividad);
			$('#row' + id).remove();
			console.log(id);
			$.post(
				'../Controlador/gestion_docente_controlador.php?op=eliminar_actividad',
				{ eliminar_actividad: eliminar_actividad },
				function(e) {}
			);

			swal('Buen trabajo!', '¡ Se eliminaron comisiones y actividades!', 'success');
		}
	}

	$(document).on('click', '.btn_remove', eliminar);

	Actividades();
});

function Actividades() {
	var id_persona = $('#txt_id_persona').val();

	$.post('../Controlador/gestion_docente_controlador.php?op=Actividades', { id_persona: id_persona }, function(
		data,
		status
	) {
		data = JSON.parse(data);
		console.log(data);
		for (i = 0; i < data.actividades.length; i++) {
			$('#tbl_comisiones').append(
				'<tr id="row' +
					i +
					'">' +
					'<td id="celda' +
					i +
					'"><input maxlength="9" hidden readonly onkeyup="javascript:mascara()" id="tel' +
					i +
					'" type="tel" name="tel" class="form-control name_list" value="' +
					data['actividades'][i].id_act_persona +
					'" placeholder="___-___"/></td>' +
					'<td>' +
					data['actividades'][i].comision +
					'</td>' +
					'<td>' +
					data['actividades'][i].actividad +
					'</td>' +
					'<td><button type="button" name="remove" id="' +
					i +
					'" class="btn btn-danger btn_remove">X</button></td>' +
					'</tr>'
			);
		}
	});
	limpiar();
}

//Comisiones y actividades
var sendData3 = {};
var list3 = [];
var actividades = document.getElementById('actividades');
var comisiones = document.getElementById('comisiones');
var id_persona = document.getElementById('txt_id_persona1');

var tbl_comisiones = document.getElementById('tbl_comisiones');
var actividades1 = document.getElementById('actividades');
var addTask3 = () => {
	var item3 = {
		id_persona: id_persona.value,
		actividades: actividades.value,
		comisiones: comisiones.value,

		muestra_actividad: actividades.options[actividades.selectedIndex].text,
		muestra_comision: comisiones.options[comisiones.selectedIndex].text
	};

	Actividades();

	list3.push(item3);
	viewlist3();
};


var viewlist3 = () => {
	if (list3.length > 0) {
		var viewItem3 = '';
		list3.map((item3, index) => {
			item3.id = index + 1;
			viewItem3 += `<tr>`;
			viewItem3 += `<td></td>`;
			viewItem3 += `<td>${item3.muestra_comision}</td>`;
			viewItem3 += `<td>${item3.muestra_actividad}</td>`;
			viewItem3 += `<td><button type="button" name="remove" id="' + n + '" class="btn btn-danger btn_remove">X</button> </td>`;

			viewItem3 += `</tr>`;
		});
		tbl_comisiones.innerHTML = viewItem3;

		$('#ModalTask2').modal('hide');
	}
};
function limpiar_arreglo() {
	list3.pop();
}
function actualizar_tabla() {
	table.ajax.reload();
}
function saveAll3 () {

	var actividades1_ = actividades1.value;
	var id_persona1 = id_persona.value;
	$.post(
		"../Controlador/gestion_docente_controlador.php?op=existe_actividad",
		{ id_actividad: actividades1_, id_persona1: id_persona1 },

		function (data, status) {
			console.log(data);
			data = JSON.parse(data);

			if (data == null  ) {
			
				insert_actividades();

			} else {
				swal({
					title: "Alerta",
					text: "El docente ya cuenta con esta actividad!",
					icon: "warning",
					showConfirmButton: true,
					timer: 20000,
				});
				document.getElementById("actividades").value = "";
				$('#ModalTask2').modal('hide');
			
				/* limpiar(); */
				
			}
			});

	
}
function insert_actividades() {
	var id_persona = document.getElementById('txt_id_persona1');
	var actividades1 = document.getElementById('actividades');
	var actividades1_ = actividades1.value;
	var id_persona1 = id_persona.value;
	$.post(
		"../Controlador/gestion_docente_controlador.php?op=insertar_actividades",
		{ id_actividad: actividades1_, id_persona1: id_persona1 },

		function (data, status) {
			console.log(data);
			data = JSON.parse(data);
			swal('Buen trabajo!', '¡ Se insertaron nuevas comisiones y actividades!', 'success');
			limpiar_arreglo();
			Actividades();
			/* tbl_comisiones.reload(); */
		});
	
}
function eliminar() {
	// let i = ContarTel();
	var confirmLeave = confirm('¿Esta seguro de eliminar la actividad del docente?');
	if (confirmLeave == true) {
		var id = $(this).attr('id');
		var eliminar_tel = document.getElementById('tel' + id).value;
		//console.log(eliminar_tel);
		$('#row' + id).remove();
		// console.log(id);
		$.post(
			'../Controlador/perfil_docente_controlador.php?op=EliminarTelefono',
			{ eliminar_tel: eliminar_tel },
			function(e) {}
		);
		i--;
	}
}

function limpiar() {
	$('#tbl_comisiones').empty();
}
function actualizar_modal() {
	$('#tbl_comisiones').reload();
}

//FUNCION DE LAS COMISIONES Y ACTIVIDADES
$(function() {
	// Lista de comisiones
	$.post('../Controlador/comisiones.php').done(function(respuesta) {
		$('#comisiones').html(respuesta);
	});

	// lista de actividades
	$('#comisiones').change(function() {
		var la_comision = $(this).val();
		console.log(la_comision);

		// Lista de actividades
		$.post('../Controlador/actividades.php', {
			id_comisiones: la_comision
		}).done(function(respuesta) {
			$('#actividades').html(respuesta);
			$('#id_actividad').val(id_actividad);
		});
	});
});
function actualizar_pagina() {
	windows.location.href = windows.location.href;
}

/* $("#actividades").change(function () {
	var id_tipo_periodo = $(this).val();

	$("#txt_actividad").val(id_tipo_periodo);
}); */
function modificar_gestion() {
	var fecha_ingreso = $('#fecha_ingreso').val();
	console.log(fecha_ingreso);

	var identidad = $('#identidad_edita').val();
	console.log(identidad);
	
	var num_empleado = $('#nempleado_edita').val();
	console.log(num_empleado);

	var sued = $('#sued').val();
	
	var jornada1 = $("#jornada_edita").val();
	var categoria1 = $("#categoria_edita").val();
	
	var jornada = document.getElementById('jornada_edita');
	var jornada_ = jornada.value;
	console.log(jornada_);

	var categoria = document.getElementById('categoria_edita');
	var categoria_ = categoria.value;
	console.log(categoria_);
	
	var hra_inicio = $("#hr_inicio_edita").val();
	var hra_final = $("#hr_final_edita").val();
	console.log(hra_inicio);
	console.log(hra_final);

	var id_persona__ = $('#txt_id_persona').val();
	console.log(id_persona__);
	
	
	if (	

		hra_inicio == null ||
		hra_final == null ||
		jornada1 == null ||
		categoria1 == null ||
		fecha_ingreso.length == 0 |
		num_empleado.length == 0 ||
		sued == null


		
	) {
		swal({
			title: "alerta",
			text: "Llene o seleccione los campos vacios",
			type: "warning",
			showConfirmButton: true,
			timer: 15000,
		});

	} 
	else {
		swal({
			title: "alerta",
			text: "Por favor espere",
			type: "warning",
			showConfirmButton: false,
			timer: 20000,
		});	
						
							
			
				$.ajax({
					url: "../Controlador/gestion_docente_controlador.php?op=modificar_gestion",
					type: "POST",
					data: {
						sued:sued,
						num_empleado: num_empleado,
						fecha_ingreso: fecha_ingreso,
						identidad: identidad,
						hra_inicio: hra_inicio,
						hra_final: hra_final,
						jornada_: jornada_,
						categoria_: categoria_,	
						id_persona__: id_persona__
					},
				}).done(function (resp) {
					if (resp > 0) {
						$("#modal_editar").modal("hide");
						swal(
							"Buen trabajo!",
							"datos actualizados correctamente!",
							"success"
						);
						document.getElementById('hr_inicio_edita').value = '';
						document.getElementById('hr_final_edita').value = '';
						document.getElementById('jornada_edita').value = '';
						document.getElementById('categoria_edita').value = '';

						table.ajax.reload();
					} else {
						swal("Alerta!", "No se pudo completar la actualización", "warning");
						
					}
				});
			

			//  } else { */
			/* toda la validacion de existe, y modificar */
	}
}
/* function ver_sued() {
  var id_persona = $('#txt_id_persona').val();

  $.post("../Controlador/perfil_docente_controlador.php?op=ver_sued", { id_persona: id_persona }, function (data, status) {
    data = JSON.parse(data);

    $("#sued").val(data.valor)

  });
} */


	