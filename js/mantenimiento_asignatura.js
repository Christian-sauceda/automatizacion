//llena el plan de asignatura
function llenar_plan() {
  var cadena = "&activar=activar";
  $.ajax({
    url: "../Controlador/plan_estudio_controlador.php?op=plan",
    type: "POST",
    data: cadena,
    success: function (r) {
      $("#cbm_plan").html(r).fadeIn();
      var o = new Option("SELECCIONAR", 0);

      $("#cbm_plan").append(o);
      $("#cbm_plan").val(0);
    },
  });
}
llenar_plan();
//llena el area de asignatura

function llenar_area() {
  var cadena = "&activar=activar";
  $.ajax({
    url: "../Controlador/plan_estudio_controlador.php?op=area",
    type: "POST",
    data: cadena,
    success: function (r) {
      $("#cbm_area").html(r).fadeIn();
      var o = new Option("SELECCIONAR", 0);

      $("#cbm_area").append(o);
      $("#cbm_area").val(0);
    },
  });
}
llenar_area();

//lena perido de asignatura
function llenar_periodo() {
  var cadena = "&activar=activar";
  $.ajax({
    url: "../Controlador/plan_estudio_controlador.php?op=periodo",
    type: "POST",
    data: cadena,
    success: function (r) {
      $("#cbm_periodo").html(r).fadeIn();
      var o = new Option("SELECCIONAR", 0);

      $("#cbm_periodo").append(o);
      $("#cbm_periodo").val(0);
    },
  });
}
llenar_periodo();

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

//llenar plan para requisito
function llenar_plan2() {
  var cadena = "&activar=activar";
  $.ajax({
    url: "../Controlador/plan_estudio_controlador.php?op=plan",
    type: "POST",
    data: cadena,
    success: function (r) {
      $("#cbm_plan_requisito").html(r).fadeIn();
      var o = new Option("SELECCIONAR", 0);

      $("#cbm_plan_requisito").append(o);
      $("#cbm_plan_requisito").val(0);
    },
  });
}
llenar_plan2();

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

//llena las asignaturas para requisito de ella
$("#cbm_plan_requisito").change(function () {
  var id_plan_estudio = $(this).val();
  console.log(id_plan_estudio);
  //  document.getElementById("txt_capacidad_edita").value = "";
  // Lista deaulas
  $.post("../Controlador/plan_estudio_controlador.php?op=id_plan", {
    id_plan_estudio: id_plan_estudio,
  }).done(function (respuesta) {
    $("#cbm_asignaturas_requisito").html(respuesta);

    // $("#cbm_requisito_asignaturas").html(respuesta);
    console.log(respuesta);
  });
});

//trae los creditos del plan
$("#cbm_plan").change(function () {
  var id_plan = $(this).val();
  var txt_uv = $("#txt_uv").val();
  console.log(id_plan);

  $.post(
    "../Controlador/plan_estudio_controlador.php?op=UVplan",
    { id_plan_estudio: id_plan },
    function (data_, status) {
      data_ = JSON.parse(data_);

      $("#txt_uv_plan").val(data_.creditos_plan);
      $("#num_clases_plan").val(data_.num_clases);
    }
  );
  $.post(
    "../Controlador/plan_estudio_controlador.php?op=contarAsignaturas",
    { id_plan_estudio: id_plan },
    function (data, status) {
      data = JSON.parse(data);
      $("#suma_clases_plan").val(data.suma);
      // var a = $("#suma_clases_plan").val();
      //   console.log(a);
    }
  );
});

//validar que solo acepte archivos pdf
function Validar() {
  var archivo = $("#txt_silabo").val();
  var extensiones = archivo.substring(archivo.lastIndexOf("."));
  console.log(extensiones);
  if (extensiones != ".pdf") {
    alert("El archivo de tipo " + extensiones + " no es válido");
    document.getElementById("txt_silabo").value = "";
  }
}

//las equivalencias de la asignatura
function insertarEquivalencias() {
  var cbm_asignaturas = $("#cbm_asignaturas").val();

  console.log(cbm_asignaturas);
  $.ajax({
    type: "POST",
    url: "../Controlador/equivalencia_asignatura_plan_controlador.php",
    //  data: { array: id_area}, //capturo array
    data: {
      array: JSON.stringify(cbm_asignaturas),
    },
    success: function (data) {
      // swal("Ingresado!", "Datos ingresados correctamente!", "success");
      console.log("equivalencia");
    },
  });
}
//las equivalencias de la asignatura
function insertarRequisitos() {
  var cbm_asignaturas_requisito = $("#cbm_asignaturas_requisito").val();

  console.log(cbm_asignaturas);
  $.ajax({
    type: "POST",
    url: "../Controlador/requisito_asignatura_plan_controlador.php",
    //  data: { array: id_area}, //capturo array
    data: {
      array1: JSON.stringify(cbm_asignaturas_requisito),
    },
    success: function (data) {
      // swal("Ingresado!", "Datos ingresados correctamente!", "success");
      console.log("requisito");
    },
  });
}

//el documento de la asignatura silabo
function Registrarcurriculum() {
  var formData = new FormData();
  var curriculum = $("#txt_silabo")[0].files[0];
  formData.append("c", curriculum);
  //formData.append('nombrearchivo',nombrearchivo);

  $.ajax({
    url: "../Controlador/silabo_asignatura_controlador.php",
    type: "post",
    data: formData,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      if (respuesta != 0) {
        // Swal(
        //   "Mensaje De Confirmacion",
        //   "Se subio el curriculum con exito",
        //   "success"
        // );
        console.log("silabo");
      }
    },
  });
  return false;
}

//insertar asignatura
function insertarAsignatura() {
  var cbm_plan = $("#cbm_plan").val();
  var cbm_periodo = $("#cbm_periodo").val();
  var cbm_area = $("#cbm_area").val();
  var txt_uv = $("#txt_uv").val();
  var txt_codigo_asignatura = $("#txt_codigo_asignatura").val();
  var txt_nombre_asignatura = $("#txt_nombre_asignatura").val();
  var cbm_reposicion = $("#cbm_reposicion").val();
  var cbm_suficiencia = $("#cbm_suficiencia").val();
  var txt_silabo = $("#txt_silabo").val();
  var estado = 0;
  var tipo_asignatura = 1;

  if (cbm_plan == null ||
    txt_uv.length == 0 || cbm_periodo == null ||
    txt_codigo_asignatura.length == 0 || cbm_area == null ||
    txt_nombre_asignatura.length == 0 || cbm_reposicion == null ||
    txt_silabo.length == 0 || cbm_suficiencia == null) {

    alert("no se permiten campos vacios");

  } else if (
    cbm_plan == 0 ||
    cbm_periodo == 0 ||
    cbm_area == 0 ||
    cbm_reposicion == 0 ||
    cbm_suficiencia == 0
  ) {
    alert("seleccione una opcion valida");
  } else {

    var clases_plan = $("suma_clases_plan").val();
    var num_clases_plan = $("num_clases_plan").val();

    if (clases_plan + 1 > num_clases_plan) {
      alert("La asignatura excede el numero de clases asignadas al plan!");
    } else {
      $.post(
        "../Controlador/plan_estudio_controlador.php?op=registrarAsignatura",
        {
          id_plan_estudio: cbm_plan,
          id_periodo_plan: cbm_periodo,
          id_area: cbm_area,
          uv: txt_uv,
          codigo: txt_codigo_asignatura,
          asignatura: txt_nombre_asignatura,
          reposicion: cbm_reposicion,
          suficiencia: cbm_suficiencia,
          estado: estado,
          id_tipo_asignatura: tipo_asignatura,
        },

        function (e) {
          Registrarcurriculum();
          insertarRequisitos();
          insertarEquivalencias();
        }
      );
      swal({
        title: "alerta",
        text: "Por favor espere un momento",
        type: "warning",
        showConfirmButton: false,
        timer: 8000,
      });
      refrescar(10000);
      mensaje();
    }
  }
}

//FUNCION PARA ACTUALIZAR PAGINA DESPUES DE 10 SEGUNDOS DE HABER GUARDADO
function refrescar(tiempo) {
	setTimeout('location.reload(true);', tiempo);


}

function mensaje() {
	setTimeout(function() {
		swal('Buen trabajo!', 'Los datos se insertaron correctamente!', 'success');
	 }, 9000);
}
