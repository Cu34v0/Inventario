<?php include "Views/Templates/header.php"; ?>
<ol class="breadcrumb mb-4">
    <b>
        <li class="breadcrumb-item active">Existencias</li>
    </b>
</ol>

<body onload="alerta();">

</body>

<table class="table table-hover table-dark" id="tblExistencias">
    <thead>
        <tr>
            <th>ID</th>
            <th>Medida</th>
            <th>Material</th>
            <th>Disponible en Almacen</th>
            <th>Existente</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<div id="modificar_existencia" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Nueva Estacion</h5>
            </div>
            <div class="modal-body">
                <form method="POST" id="frmExistencia">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="disponibleAlmacen">Disponible en Almacen</label>
                                <input type="hidden" id="id" name="id">
                                <input type="number" id="disponibleAlmacen" class="form-control" name="disponibleAlmacen" placeholder="Disponible en Almacen" readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cantidades">Cantidades</label>
                                <input type="number" id="cantidades" class="form-control" name="cantidades" placeholder="Cantidades" onchange="return operacionExis(event);" onclick="return seleccionarCantidades(event);">
                            </div>
                        </div>
                    </div>
                    <br>
                    <button class="btn btn-primary" type="button" onclick="registrarExistencia(event);" id="btnAccion">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>
