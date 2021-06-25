//cargar tabla equivalencia

var table;
function TablaPlanEstudio() {
  table = $("#tabla_equivalencia").DataTable({
    paging: true,
    lengthChange: true,
    ordering: true,
    info: true,
    autoWidth: true,
    responsive: true,
    // LengthChange: false,
    searching: { regex: true },
    lengthMenu: [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "All"],
    ],
    sortable: false,
    pageLength: 15,
    destroy: true,
    async: false,
    processing: true,
    ajax: {
      url: "../Controlador/tabla_equivalencia_plan_controlador.php",
      type: "POST",
    },
    columns: [
      {
        defaultContent:
          "<button style='font-size:13px;' type='button' class='editar btn btn-primary '><i class='fas fa-edit'></i></button>",
      },

      { data: "asignatura" },
      { data: "equivalencia" },
    ],

    language: idioma_espanol,
    select: true,
  });
}

///abrir modal de tabla equivalencia
$("#tabla_equivalencia").on("click", ".editar", function () {
  

  var data = table.row($(this).parents("tr")).data();
  if (table.row(this).child.isShown()) {
    var data = table.row(this).data();
    }
	$("#modal_editar").modal({ backdrop: "static", keyboard: false });
    $("#modal_editar").modal("show");
    $("#txt_id_asignatura").val(data.id_asignatura);
    $("#txt_asignatura").val(data.asignatura);
    $("#txt_equivalencias").val(data.equivalencia);
    $("#cbm_plan1").val(data.id_plan_estudio).trigger("change");
	equivalencias();

 
});

function id_asignatura() {
	document.getElementById('txt_id_asignatura1').value = document.getElementById('txt_id_asignatura').value;
}
//llena el plan para equivalencia
function llenar_plan1() {
  var cadena = "&activar=activar";
  $.ajax({
    url: "../Controlador/plan_estudio_controlador.php?op=plan",
    type: "POST",
    data: cadena,
    success: function (r) {
      
      $("#cbm_plan1").html(r).fadeIn();
      var o = new Option("SELECCIONAR", 0);

      $("#cbm_plan1").append(o);
      $("#cbm_plan1").val(0);

    },
  });
}
llenar_plan1();

//llena en cascada equivalencia que selecciona del plan
$("#cbm_plan1").change(function () {
  var id_plan_estudio = $(this).val();
  console.log(id_plan_estudio);
  //  document.getElementById("txt_capacidad_edita").value = "";
  // Lista deaulas
  $.post("../Controlador/plan_estudio_controlador.php?op=id_plan", {
    id_plan_estudio: id_plan_estudio,
  }).done(function (respuesta) {
    $("#cbm_asignaturas").html(respuesta);

   // $("#cbm_requisito_asignaturas").html(respuesta);
    console.log(respuesta);
  });
});

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

	equivalencias();
});

function equivalencias() {
	var id_asignatura = $('#txt_id_asignatura').val();

	$.post('../Controlador/equivalencia_plan_controlador.php?op=id_asignatura', { id_asignatura: id_asignatura }, function(
		data,
		status
	) {
		data = JSON.parse(data);
		console.log(data);
		for (i = 0; i < data.equivalencias.length; i++) {
			$('#tbl_equivalencias').append(
				'<tr id="row' +
					i +
					'">' +
					'<td id="celda' +
					i +
					'"><input maxlength="9" hidden readonly onkeyup="javascript:mascara()" id="tel' +
					i +
					'" type="tel" name="tel" class="form-control name_list" value="' +
					data['equivalencias'][i].id_equivalencia +
					'" placeholder="___-___"/></td>' +
					'<td>' +
					data['equivalencias'][i].equivalencia +
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

//equivalencias
var sendData3 = {};
var list3 = [];
var asignatura = document.getElementById('cbm_asignaturas');
var id_asignatura1 = document.getElementById('txt_id_asignatura1');

var tbl_equivalencias = document.getElementById('tbl_equivalencias');
var asignatura1 = document.getElementById('cbm_asignaturas');
var addTask3 = () => {
	var item3 = {
		id_asignatura1: id_asignatura1.value,
		asignatura: asignatura.value,

		muestra_asignatura: cbm_asignaturas.options[cbm_asignaturas.selectedIndex].text,
		
	};

	equivalencias();

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
			viewItem3 += `<td>${item3.muestra_asignatura}</td>`;
			viewItem3 += `<td><button type="button" name="remove" id="' + n + '" class="btn btn-danger btn_remove">X</button> </td>`;

			viewItem3 += `</tr>`;
		});
		tbl_equivalencias.innerHTML = viewItem3;

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

	var equivalencia1_ = asignatura1.value;
	var id_asignatura1_ = id_asignatura1.value;
	$.post(
		"../Controlador/gestion_docente_controlador.php?op=existe_actividad",
		{ id_equivalencia: equivalencia1_, id_asignatura1: id_asignatura1_ },

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
			
				limpiar();
				
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