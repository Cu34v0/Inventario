let tblUsuarios,
  tblClientes,
  tblEstaciones,
  tblMedidas,
  tblAlmacenes,
  tblExistencias,
  tblHistorial,
  tblInventario,
  tblProveedores;
document.addEventListener("DOMContentLoaded", function () {
  tblUsuarios = $("#tblUsuarios").DataTable({
    ajax: {
      url: base_url + "Usuarios/listar",
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
      },
      {
        data: "usuario",
      },
      {
        data: "nombre",
      },
      {
        data: "estacion",
      },
      {
        data: "acciones",
      },
    ],
  });
});

// Inicio usuarios

function frmLogin(e) {
  e.preventDefault();
  const usuario = document.getElementById("usuario");
  const clave = document.getElementById("clave");
  if (usuario.value == "") {
    clave.classList.remove("is-invalid");
    usuario.classList.add("is-invalid");
    usuario.focus();
  } else if (clave.value == "") {
    usuario.classList.remove("is-invalid");
    clave.classList.add("is-invalid");
    clave.focus();
  } else {
    const url = base_url + "Usuarios/validar";
    const frm = document.getElementById("frmLogin");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        if (res == "ok") {
          window.location = base_url + "Usuarios";
        } else {
          document.getElementById("alerta").classList.remove("d-none");
          document.getElementById("alerta").innerHTML = res;
        }
      }
    };
  }
}

function frmUsuario() {
  document.getElementById("title").innerHTML = "Nuevo Usuario";
  document.getElementById("btnAccion").innerHTML = "Registrar";
  document.getElementById("claves").classList.remove("d-none");
  document.getElementById("frmUsuario").reset();
  $("#nuevo_usuario").modal("show");
  document.getElementById("id").value = "";
}

function registrarUser(e) {
  e.preventDefault();
  const usuario = document.getElementById("usuario");
  const nombre = document.getElementById("nombre");
  const clave = document.getElementById("clave");
  const confirmar = document.getElementById("confirmar");
  const estacion = document.getElementById("estacion");
  if (usuario.value == "" || nombre.value == "" || estacion.value == "") {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "Todos los datos son obligatorios",
    });
  } else {
    const url = base_url + "Usuarios/registrar";
    const frm = document.getElementById("frmUsuario");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        if (res == "si") {
          Swal.fire({
            position: "center",
            icon: "success",
            title: "Usuario registrado con éxito",
            showConfirmButton: false,
            timer: 2000,
          });
          frm.reset();
          $("#nuevo_usuario").modal("hide");
          tblUsuarios.ajax.reload();
        } else if (res == "modificado") {
          Swal.fire({
            position: "center",
            icon: "success",
            title: "Usuario modificado con éxito",
            showConfirmButton: false,
            timer: 2000,
          });
          $("#nuevo_usuario").modal("hide");
          tblUsuarios.ajax.reload();
        } else {
          Swal.fire({
            position: "center",
            icon: "error",
            title: res,
            showConfirmButton: false,
            timer: 2000,
          });
        }
      }
    };
  }
}

function btnEditarUser(id) {
  document.getElementById("title").innerHTML = "Actualizar Usuario";
  document.getElementById("btnAccion").innerHTML = "Modificar";
  const url = base_url + "Usuarios/editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById("id").value = res.id;
      document.getElementById("usuario").value = res.usuario;
      document.getElementById("nombre").value = res.nombre;
      document.getElementById("estacion").value = res.id_estacion;
      document.getElementById("claves").classList.add("d-none");
      $("#nuevo_usuario").modal("show");
    }
  };
}

function btnEliminarUser(id) {
  Swal.fire({
    title: "¿Estás seguro de eliminar?",
    text: "¡No podrás revertir esta acción!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Usuarios/eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          if (res == "ok") {
            Swal.fire("Eliminado!", "El usuario ha sido eliminado", "success");
            tblUsuarios.ajax.reload();
          } else {
            Swal.fire("Error!", "res", "error");
          }
        }
      };
    }
  });
}
// Fin usuarios
//-----------------------------------------------------------

// Inicio cliente

document.addEventListener("DOMContentLoaded", function () {
  tblClientes = $("#tblClientes").DataTable({
    ajax: {
      url: base_url + "Clientes/listar",
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
      },
      {
        data: "nombre",
      },
      {
        data: "acciones",
      },
    ],
  });
});

function frmCliente() {
  document.getElementById("title").innerHTML = "Nuevo Cliente";
  document.getElementById("btnAccion").innerHTML = "Registrar";
  document.getElementById("frmCliente").reset();
  $("#nuevo_cliente").modal("show");
  document.getElementById("id").value = "";
}

function registrarCli(e) {
  e.preventDefault();
  const nombre = document.getElementById("nombre");
  if (nombre.value == "") {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "Todos los datos son obligatorios",
    });
  } else {
    const url = base_url + "Clientes/registrar";
    const frm = document.getElementById("frmCliente");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        if (res == "si") {
          Swal.fire({
            position: "center",
            icon: "success",
            title: "Cliente registrado con éxito",
            showConfirmButton: false,
            timer: 2000,
          });
          frm.reset();
          $("#nuevo_cliente").modal("hide");
          tblClientes.ajax.reload();
        } else if (res == "modificado") {
          Swal.fire({
            position: "center",
            icon: "success",
            title: "Cliente modificado con éxito",
            showConfirmButton: false,
            timer: 2000,
          });
          $("#nuevo_cliente").modal("hide");
          tblClientes.ajax.reload();
        } else {
          Swal.fire({
            position: "center",
            icon: "error",
            title: res,
            showConfirmButton: false,
            timer: 2000,
          });
        }
      }
    };
  }
}

function btnEditarCli(id) {
  document.getElementById("title").innerHTML = "Actualizar Cliente";
  document.getElementById("btnAccion").innerHTML = "Modificar";
  const url = base_url + "Clientes/editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById("id").value = res.id;
      document.getElementById("nombre").value = res.nombre;
      $("#nuevo_cliente").modal("show");
    }
  };
}

function btnEliminarCli(id) {
  Swal.fire({
    title: "¿Estás seguro de eliminar?",
    text: "¡No podrás revertir esta acción!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Clientes/eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          if (res == "ok") {
            Swal.fire("Eliminado!", "El cliente ha sido eliminado", "success");
            tblClientes.ajax.reload();
          } else {
            Swal.fire("Error!", "res", "error");
          }
        }
      };
    }
  });
}

// Fin clientes
//-----------------------------------------------------------

// Inicio estaciones

document.addEventListener("DOMContentLoaded", function () {
  tblEstaciones = $("#tblEstaciones").DataTable({
    ajax: {
      url: base_url + "Estaciones/listar",
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
      },
      {
        data: "estacion",
      },
      {
        data: "acciones",
      },
    ],
  });
});

function frmEstacion() {
  document.getElementById("title").innerHTML = "Nueva Estación";
  document.getElementById("btnAccion").innerHTML = "Registrar";
  document.getElementById("frmEstacion").reset();
  $("#nueva_estacion").modal("show");
  document.getElementById("id").value = "";
}

function registrarEst(e) {
  e.preventDefault();
  const estacion = document.getElementById("estacion");
  if (estacion.value == "") {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "Todos los datos son obligatorios",
    });
  } else {
    const url = base_url + "Estaciones/registrar";
    const frm = document.getElementById("frmEstacion");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        if (res == "si") {
          Swal.fire({
            position: "center",
            icon: "success",
            title: "Estación registrada con éxito",
            showConfirmButton: false,
            timer: 2000,
          });
          frm.reset();
          $("#nueva_estacion").modal("hide");
          tblEstaciones.ajax.reload();
        } else if (res == "modificado") {
          Swal.fire({
            position: "center",
            icon: "success",
            title: "Estación modificada con éxito",
            showConfirmButton: false,
            timer: 2000,
          });
          $("#nueva_estacion").modal("hide");
          tblEstaciones.ajax.reload();
        } else {
          Swal.fire({
            position: "center",
            icon: "error",
            title: res,
            showConfirmButton: false,
            timer: 2000,
          });
        }
      }
    };
  }
}

function btnEditarEst(id) {
  document.getElementById("title").innerHTML = "Actualizar Estación";
  document.getElementById("btnAccion").innerHTML = "Modificar";
  const url = base_url + "Estaciones/editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById("id").value = res.id;
      document.getElementById("estacion").value = res.estacion;
      $("#nueva_estacion").modal("show");
    }
  };
}

function btnEliminarEst(id) {
  Swal.fire({
    title: "¿Estás seguro de eliminar?",
    text: "¡No podrás revertir esta acción!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Estaciones/eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          if (res == "ok") {
            Swal.fire("Eliminado!", "La estación ha sido eliminada", "success");
            tblEstaciones.ajax.reload();
          } else {
            Swal.fire("Error!", "res", "error");
          }
        }
      };
    }
  });
}

// Fin estaciones
//-----------------------------------------------------------

// Inicio Medidas

document.addEventListener("DOMContentLoaded", function () {
  tblMedidas = $("#tblMedidas").DataTable({
    ajax: {
      url: base_url + "Medidas/listar",
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
      },
      {
        data: "descripcion",
      },
      {
        data: "medida",
      },
      {
        data: "tamCaja",
      },
      {
        data: "acciones",
      },
    ],
  });
});

function frmMedida() {
  document.getElementById("title").innerHTML = "Nueva Medida";
  document.getElementById("btnAccion").innerHTML = "Registrar";
  document.getElementById("frmMedida").reset();
  $("#nueva_medida").modal("show");
  document.getElementById("id").value = "";
}

function registrarMed(e) {
  e.preventDefault();
  const descripcion = document.getElementById("descripcion");
  const medida = document.getElementById("medida");
  const tamCaja = document.getElementById("tamCaja");
  if (descripcion.value == "" || medida.value == "" || tamCaja.value == "") {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "Todos los datos son obligatorios",
    });
  } else {
    const url = base_url + "Medidas/registrar";
    const frm = document.getElementById("frmMedida");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        if (res == "si") {
          Swal.fire({
            position: "center",
            icon: "success",
            title: "Medida registrada con éxito",
            showConfirmButton: false,
            timer: 2000,
          });
          frm.reset();
          $("#nueva_medida").modal("hide");
          tblMedidas.ajax.reload();
        } else if (res == "modificado") {
          Swal.fire({
            position: "center",
            icon: "success",
            title: "Medida modificada con éxito",
            showConfirmButton: false,
            timer: 2000,
          });
          $("#nueva_medida").modal("hide");
          tblMedidas.ajax.reload();
        } else {
          Swal.fire({
            position: "center",
            icon: "error",
            title: res,
            showConfirmButton: false,
            timer: 2000,
          });
        }
      }
    };
  }
}

function btnEditarMed(id) {
  document.getElementById("title").innerHTML = "Actualizar Medida";
  document.getElementById("btnAccion").innerHTML = "Modificar";
  const url = base_url + "Medidas/editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById("id").value = res.id;
      document.getElementById("descripcion").value = res.descripcion;
      document.getElementById("medida").value = res.medida;
      document.getElementById("tamCaja").value = res.tamCaja;
      $("#nueva_medida").modal("show");
    }
  };
}

function btnEliminarMed(id) {
  Swal.fire({
    title: "¿Estás seguro de eliminar?",
    text: "¡No podrás revertir esta acción!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Medidas/eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          if (res == "ok") {
            Swal.fire("Eliminado!", "La estación ha sido eliminada", "success");
            tblMedidas.ajax.reload();
          } else {
            Swal.fire("Error!", "res", "error");
          }
        }
      };
    }
  });
}

// Fin Medidas
//-----------------------------------------------------------

// Inicio almacenes

document.addEventListener("DOMContentLoaded", function () {
  tblAlmacenes = $("#tblAlmacenes").DataTable({
    ajax: {
      url: base_url + "Almacenes/listar",
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
      },
      {
        data: "medida",
      },
      {
        data: "tamCaja",
      },
      {
        data: "tipoMaterial",
      },
      {
        data: "remision",
      },
      {
        data: "fecha",
      },
      {
        data: "nombre",
      },
      {
        data: "cantidad",
      },
      {
        data: "precioCompra",
      },
      {
        data: "acciones",
      },
    ],
  });
});

function frmAlmacen() {
  document.getElementById("title").innerHTML = "Nuevo Almacen";
  document.getElementById("btnAccion").innerHTML = "Registrar";
  document.getElementById("frmAlmacen").reset();
  $("#nuevo_almacen").modal("show");
  document.getElementById("id").value = "";
}

function buscar() {
  const id_medida = document.getElementById("id_medida").value;
  const medida = document.getElementById("medida");
  const tamCaja = document.getElementById("tamCaja");
  const url = base_url + "Almacenes/busqueda/" + id_medida;
  const http = new XMLHttpRequest();
  medida.value = "";
  tamCaja.value = "";
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      medida.value = res.medida;
      tamCaja.value = res.tamCaja;
    }
  };
}

function registrarAlm(e) {
  e.preventDefault();
  const id_medida = document.getElementById("id_medida");
  const tipoMaterial = document.getElementById("tipoMaterial");
  const remision = document.getElementById("remision");
  // Construcción de fechas
  var date = new Date(document.getElementById("fecha").value);
  var day = date.getDate() + 1;
  var month = date.getMonth() + 1;
  var year = date.getFullYear();
  const fecha = [day, month, year].join("/");
  // Fin construcción de fechas
  const cantidad = document.getElementById("cantidad");
  const proveedor = document.getElementById("proveedor");
  const precioCompra = document.getElementById("precioCompra");

  if (
    id_medida.value == "" ||
    tipoMaterial.value == "" ||
    remision.value == "" ||
    fecha.value == "" ||
    cantidad.value == "" ||
    proveedor.value == "" ||
    precioCompra.value == ""
  ) {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "Todos los datos son obligatorios",
    });
  } else {
    const url = base_url + "Almacenes/registrar";
    const frm = document.getElementById("frmAlmacen");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        if (res == "si") {
          Swal.fire({
            position: "center",
            icon: "success",
            title: "Almacen registrado con éxito",
            showConfirmButton: false,
            timer: 2000,
          });
          frm.reset();
          $("#nuevo_almacen").modal("hide");
          tblAlmacenes.ajax.reload();
        } else if (res == "modificado") {
          Swal.fire({
            position: "center",
            icon: "success",
            title: "Almacen modificado con éxito",
            showConfirmButton: false,
            timer: 2000,
          });
          $("#nuevo_almacen").modal("hide");
          tblAlmacenes.ajax.reload();
        } else {
          Swal.fire({
            position: "center",
            icon: "error",
            title: res,
            showConfirmButton: false,
            timer: 2000,
          });
        }
      }
    };
  }
}

function prueba() {
  const proveedor = document.getElementById("proveedor").value;
  console.log(proveedor);
}

function btnEditarAlm(id) {
  document.getElementById("title").innerHTML = "Actualizar Almacen";
  document.getElementById("btnAccion").innerHTML = "Modificar";
  const url = base_url + "Almacenes/editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById("id").value = res.id;
      document.getElementById("id_medida").value = res.id_medida;
      buscar(document.getElementById("id_medida").value);
      document.getElementById("tipoMaterial").value = res.tipoMaterial;
      document.getElementById("remision").value = res.remision;
      document.getElementById("fecha").value = res.fecha;
      document.getElementById("cantidad").value = res.cantidad;
      document.getElementById("proveedor").value = res.proveedor;
      document.getElementById("precioCompra").value = res.precioCompra;
      $("#nuevo_almacen").modal("show");
    }
  };
}

function btnEliminarAlm(id) {
  Swal.fire({
    title: "¿Estás seguro de eliminar?",
    text: "¡No podrás revertir esta acción!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Almacenes/eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          if (res == "ok") {
            Swal.fire("Eliminado!", "El almacen ha sido eliminada", "success");
            tblAlmacenes.ajax.reload();
          } else {
            Swal.fire("Error!", "res", "error");
          }
        }
      };
    }
  });
}

// Fin Almacenes
//-----------------------------------------------------------

// Inicio existencias

document.addEventListener("DOMContentLoaded", function () {
  tblExistencias = $("#tblExistencias").DataTable({
    ajax: {
      url: base_url + "Existencias/listar",
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
      },
      {
        data: "medida",
      },
      {
        data: "tipoMaterial",
      },
      {
        data: "disponibleAlmacen",
      },
      {
        data: "cantidades",
      },
      {
        data: "acciones",
      },
    ],
  });
});

function frmExistencia(id) {
  document.getElementById("title").innerHTML = "Actualizar Existencia";
  document.getElementById("btnAccion").innerHTML = "Actualizar";
  document.getElementById("frmExistencia").reset();
  $("#modificar_existencia").modal("show");

  const url = base_url + "Existencias/editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById("id").value = res.id;
      document.getElementById("disponibleAlmacen").value =
        res.disponibleAlmacen;
      document.getElementById("precioVenta").value = res.precioVenta;
    }
  };
}

function operacionExis(e) {
  e.preventDefault();
  let disponibleAlmacen = parseInt(
    document.getElementById("disponibleAlmacen").value
  );
  let cantidades = parseInt(document.getElementById("cantidades").value);
  if (cantidades > disponibleAlmacen) {
    document.getElementById("cantidades").classList.add("text-danger");
  } else {
    document.getElementById("cantidades").classList.remove("text-danger");
    $("#disponibleAlmacen").val(disponibleAlmacen - cantidades);
  }
}

function registrarExistencia(e) {
  e.preventDefault();
  const cantidades = document.getElementById("cantidades");
  const precioVenta = document.getElementById("precioVenta");
  if (cantidades.value == "" || precioVenta == "") {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Todos los datos son obligatorios.",
      showConfirmButton: false,
      timer: 2000,
    });
  } else {
    const url = base_url + "Existencias/registrar";
    const frm = document.getElementById("frmExistencia");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        if (res == "modificadae") {
          Swal.fire({
            position: "center",
            icon: "success",
            title: "Cambios realizados con éxito",
            showConfirmButton: false,
            timer: 1500,
          });
          $("#modificar_existencia").modal("hide");
          tblExistencias.ajax.reload();
        }
      }
    };
  }
}

function seleccionarCantidades(e) {
  e.preventDefault();
  $("#cantidades").select();
}

function seleccionarPrecio(e) {
  e.preventDefault();
  $("#precioVenta").select();
}

function alerta() {
  const url = base_url + "Existencias/alerta";
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      if (res != "") {
        Swal.fire({
          position: "center",
          icon: "error",
          title: "Alerta, piezas por debajo de 1,000",
          text:
            "Caja " +
            res[0]["tamCaja"] +
            " " +
            res[0]["tipoMaterial"] +
            " " +
            " -- Disponible: " +
            res[0]["disponibleAlmacen"],
          showConfirmButton: true,
        });
      }
    }
  };
}

function btnEliminarExi(id) {
  Swal.fire({
    title: "¿Estás seguro de eliminar?",
    text: "¡No podrás revertir esta acción!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Existencias/eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          if (res == "ok") {
            Swal.fire(
              "Eliminado!",
              "La existencia ha sido eliminada con éxito",
              "success"
            );
            tblExistencias.ajax.reload();
          } else {
            Swal.fire("Error!", "res", "error");
          }
        }
      };
    }
  });
}

// Inicio cambio de contraseña

function changePass(e) {
  e.preventDefault();
  const passActual = document.getElementById("passActual");
  const nuevaPass = document.getElementById("nuevaPass");
  const confirmar = document.getElementById("confirmar");

  if (passActual.value == "") {
    nuevaPass.classList.remove("is-invalid");
    confirmar.classList.remove("is-invalid");
    passActual.classList.add("is-invalid");
    passActual.focus();
  } else if (nuevaPass.value == "") {
    passActual.classList.remove("is-invalid");
    confirmar.classList.remove("is-invalid");
    nuevaPass.classList.add("is-invalid");
    nuevaPass.focus();
  } else if (confirmar.value == "") {
    passActual.classList.remove("is-invalid");
    nuevaPass.classList.remove("is-invalid");
    confirmar.classList.add("is-invalid");
    confirmar.focus();
  } else {
    const url = base_url + "CambioPass/changePass";
    const frm = document.getElementById("frmPass");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        if (res == "actualizada") {
          Swal.fire({
            title: "Cambio de contraseña exitoso!",
            text: "El sistema cerrará sesión para que ingrese con su nueva contraseña",
            icon: "success",
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Ok!",
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.replace(base_url + "Usuarios/salir");
            }
          });
        } else if (res == "error") {
          Swal.fire({
            position: "center",
            icon: "error",
            title: "No se ha podido cambiar la contraseña.",
            showConfirmButton: false,
            timer: 2000,
          });
        } else if (res == "diferentes") {
          Swal.fire({
            position: "center",
            icon: "error",
            title: "Las contraseñas no coinciden.",
            showConfirmButton: false,
            timer: 2000,
          });
        } else if (res == "no existe") {
          Swal.fire({
            position: "center",
            icon: "error",
            title: "La contraseña no corresponde al usuario",
            showConfirmButton: false,
            timer: 2000,
          });
        }
      }
    };
  }
}

// Fin cambio de contraseña

// Inicio Buscar existencias
function buscarExi(e) {
  e.preventDefault();
  const idExistencia = document.getElementById("idExistencia").value;
  if (e.which == 13) {
    const url = base_url + "Existencias/buscar/" + idExistencia;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        if (res) {
          document.getElementById("medida").value = res.medida;
          document.getElementById("tipoMaterial").value = res.tipoMaterial;
          document.getElementById("disponible").value = res.cantidades;
          document.getElementById("precio").focus();
        } else {
          document.getElementById("medida").value = "";
          document.getElementById("tipoMaterial").value = "";
          document.getElementById("disponible").value = "";
          document.getElementById("precio").value = "";
          Swal.fire({
            position: "center",
            icon: "error",
            title: "No se ha encontrado la existencia.",
            showConfirmButton: false,
            timer: 2000,
          });
        }
      }
    };
  }
}
// Fin Buscar existencias

// Inicio Operación
function operacion(e) {
  e.preventDefault();
  const precio = document.getElementById("precio").value;
  const disponible = document.getElementById("disponible").value;
  let cantidad = parseInt(document.getElementById("cantidad").value);
  let total = precio * cantidad;
  document.getElementById("subTotal").value = total.toFixed(2);
  if (e.which == 13) {
    if (cantidad > disponible) {
      Swal.fire({
        position: "center",
        icon: "error",
        title:
          "La cantidad que está ingresando es mayor a la disponible. Verifique los almacenes y las existencias.",
        showConfirmButton: false,
        timer: 4000,
      });
      cantidad.focus();
    } else {
      if (cantidad > 0) {
        const url = base_url + "Venta/ingresar";
        const frm = document.getElementById("frmVenta");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            if (res == "ok") {
              location.reload();
              frm.reset();
              cargarDetalles();
            } else {
              Swal.fire({
                position: "center",
                icon: "error",
                title: "Ha ocurrido un error!",
                showConfirmButton: false,
                timer: 2000,
              });
            }
          }
        };
      }
    }
  }
}
cargarDetalles();
// Fin Operación

// Inicio carga detalles
function cargarDetalles() {
  const url = base_url + "Venta/listar";
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      let html = "";
      res["detalle"].forEach((row) => {
        html += `<tr>
        <td>${row["id"]}</td>
        <td>${row["medida"]}</td>
        <td>${row["tipoMaterial"]}</td>
        <td>${row["precio"]}</td>
        <td>${row["cantidad"]}</td>
        <td>${row["subTotal"]}</td>
        <td>
        <button class="btn btn-danger" type="button" onclick="deleteDetalle(${row["id"]})"><i class="fas fa-trash-alt"></i></button>
        </td>
        </tr>`;
      });
      document.getElementById("tblDetalle").innerHTML = html;
      document.getElementById("total").value = res["totalPagar"].total;
    }
  };
}

function deleteDetalle(id) {
  const url = base_url + "Venta/delete/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      if (res == "ok") {
        Swal.fire({
          position: "top-end",
          icon: "success",
          title: "Producto descartado",
          showConfirmButton: false,
          timer: 2000,
        });
        cargarDetalles();
      } else {
        Swal.fire({
          position: "top-end",
          icon: "error",
          title: "Ha ocurrido un error al descartar el producto",
          showConfirmButton: false,
          timer: 2000,
        });
      }
    }
  };
}

$("#idCliente").change(function () {
  var idCliente = $("#idCliente").val();
  var respaldoID = document.getElementById("respaldoIdCliente").value;
  respaldoID = idCliente;
  console.log(respaldoID);
  $("#respaldoIdCliente").val(respaldoID);

  //Capturamos el texto seleccionado
  var clienteTex = $("select option:selected").text();
  var respaldoTexCliente = document.getElementById("respaldoTexCliente").value;
  respaldoTexCliente = clienteTex;
  console.log(respaldoTexCliente);
  $("#respaldoTexCliente").val(respaldoTexCliente);
});

function generarCompra() {
  Swal.fire({
    title: "¿Confirmar la compra?",
    text: "Esta acción confirmará la compra y se registrará en la base de datos del sistema.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, confirmar",
    cancelButtonText: "No, cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Venta/registrarVenta";
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          if (res == "ok") {
            Swal.fire({
              position: "center",
              icon: "success",
              title: "La compra se ha registrado correctamente",
              showConfirmButton: true,
              timer: 2000,
            }).then((result) => {
              if (result.isConfirmed) {
                location.reload();
              }
            });
            cargarDetalles();
          } else if (res == "existe") {
            Swal.fire({
              position: "center",
              icon: "error",
              title: "Esta venta ya existe y no se permiten datos duplicados.",
              showConfirmButton: false,
              timer: 2000,
            });
          } else {
            Swal.fire({
              position: "center",
              icon: "error",
              title: res,
              showConfirmButton: false,
              timer: 2000,
            });
          }
        }
      };
    }
  });
}

// Fin Venta

// Inicio HistorialVentas

document.addEventListener("DOMContentLoaded", function () {
  tblHistorial = $("#tblHistorial").DataTable({
    ajax: {
      url: base_url + "HistorialVentas/listar",
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
      },
      {
        data: "fecha",
      },
      {
        data: "folio",
      },
      {
        data: "nombre",
      },
      {
        data: "total",
      },
      {
        data: "acciones",
      },
    ],
  });
});

function btnGenerarPDF(id) {
  var url = base_url + "HistorialVentas/generarPDF/" + id;
  var win = window.open(url, "_blank");
  win.focus;
}

// Fin Historial Ventas

// Inicio Inventario
document.addEventListener("DOMContentLoaded", function () {
  tblInventario = $("#tblInventario").DataTable({
    ajax: {
      url: base_url + "Inventario/listar",
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
      },
      {
        data: "medida",
      },
      {
        data: "tipoMaterial",
      },
      {
        data: "disponibleAlmacen",
      },
      {
        data: "cantidades",
      },
    ],
  });
});

// Fin Inventario

// Inicio Proveedores
document.addEventListener("DOMContentLoaded", function () {
  tblProveedores = $("#tblProveedores").DataTable({
    ajax: {
      url: base_url + "Proveedores/listar",
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
      },
      {
        data: "nombre",
      },
      {
        data: "acciones",
      },
    ],
  });
});

function frmProveedor() {
  document.getElementById("title").innerHTML = "Nuevo Proveedor";
  document.getElementById("btnAccion").innerHTML = "Registrar";
  document.getElementById("frmProveedor").reset();
  $("#nuevo_proveedor").modal("show");
  document.getElementById("id").value = "";
}

function registrarProv(e) {
  e.preventDefault();
  const nombre = document.getElementById("nombre");
  if (nombre.value == "") {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "Todos los datos son obligatorios",
    });
  } else {
    const url = base_url + "Proveedores/registrar";
    const frm = document.getElementById("frmProveedor");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        if (res == "si") {
          Swal.fire({
            position: "center",
            icon: "success",
            title: "Proveedor registrado con éxito!",
            showConfirmButton: false,
            timer: 2000,
          });
          frm.reset();
          $("#nuevo_proveedor").modal("hide");
          tblProveedores.ajax.reload();
        } else if (res == "existe") {
          Swal.fire({
            position: "center",
            icon: "error",
            title: "Este proveedor ya ha sido registrado",
            showConfirmButton: false,
            timer: 3000,
          });
        } else if (res == "modificado") {
          Swal.fire({
            position: "center",
            icon: "success",
            title: "Proveedor modificado con éxito!",
            showConfirmButton: false,
            timer: 2000,
          });
          frm.reset();
          $("#nuevo_proveedor").modal("hide");
          tblProveedores.ajax.reload();
        }
      }
    };
  }
}

function btnEditarProv(id) {
  document.getElementById("title").innerHTML = "Actualizar Proveedor";
  document.getElementById("btnAccion").innerHTML = "Modificar";
  const url = base_url + "Proveedores/editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById("id").value = res.id;
      document.getElementById("nombre").value = res.nombre;
      $("#nuevo_proveedor").modal("show");
    }
  };
}

function btnEliminarProv(id) {
  Swal.fire({
    title: "¿Estás seguro de eliminar?",
    text: "¡No podrás revertir esta acción!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Proveedores/eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          if (res == "ok") {
            Swal.fire(
              "Eliminado!",
              "El proveedor ha sido eliminado",
              "success"
            );
            tblProveedores.ajax.reload();
          } else {
            Swal.fire("Error!", "res", "error");
          }
        }
      };
    }
  });
}
// Fin proveedores

// Inicio calendarizacion
function selectAnio(e) {
  e.preventDefault();
  $("#anio").select();
}

function generarReporte(e) {
  e.preventDefault();
  const proveedor = document.getElementById("proveedor");
  const anio = document.getElementById("anio");
  if (proveedor.value == "" || anio.value == "") {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Todos los campos son necesarios",
      showConfirmButton: false,
      timer: 3000,
    });
  } else {
    const url = base_url + "Calendarizacion/generarReporte";
    const frm = document.getElementById("frmCalendario");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        if (res == "si") {
          var url = base_url + "Calendarizacion/pdf";
          var win = window.open(url, "_blank");
          win.focus;
        } else if (res == "no") {
          Swal.fire({
            position: "center",
            icon: "error",
            title: "No se ha encontrado",
            showConfirmButton: false,
            timer: 3000,
          });
        } else {
          Swal.fire({
            position: "center",
            icon: "warning",
            title: res,
            showConfirmButton: false,
            timer: 3000,
          });
        }
      }
    };
  }
}
// Fin calendarizacion

// Inicio calendario ventas
function generarReporteV(e) {
  e.preventDefault();
  const cliente = document.getElementById("cliente");
  const numCaja = document.getElementById("numCaja");
  const anio = document.getElementById("anio");

  if (cliente.value == "" || numCaja.value == "" || anio.value == "") {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Todos los campos son necesarios",
      showConfirmButton: false,
      timer: 2500,
    });
  } else {
    const url = base_url + "CalendarioVentas/generarReporte";
    const frm = document.getElementById("frmCalendarioVentas");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        if (res == "si") {
          var url = base_url + "CalendarioVentas/pdf";
          var win = window.open(url, "_blank");
          win.focus;
        } else if(res == "no") {
          Swal.fire({
            position: "center",
            icon: "error",
            title: "No se han encontrado registros.",
            showConfirmButton: false,
            timer: 3000,
          });
        } else {
          Swal.fire({
            position: "center",
            icon: "warning",
            title: res,
            showConfirmButton: false,
            timer: 3000,
          });
        }
      }
    };
  }
}
// Fin calendario ventas

// Inicio Calendario Inventario
function historialVentas() {
  const anio = document.getElementById("anio");
  const medida = document.getElementById("medida");
  if (anio.value == "" || medida.value == "") {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Todos los campos son necesarios",
      showConfirmButton: false,
      timer: 2500,
    });
  } else {
    const url = base_url + "Inventario/generarReporte";
    const frm = document.getElementById("frmInventario");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        if (res == "si") {
          var url = base_url + "Inventario/pdf";
          var win = window.open(url, "_blank");
          win.focus;
        }else{
          Swal.fire({
            position: "center",
            icon: "error",
            title: "No se ha encontrado un registro válido.",
            showConfirmButton: false,
            timer: 3000,
          });
        }
      }
    }
  }
}

// Fin Calendario Inventario
