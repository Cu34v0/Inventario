<?php include "Views/Templates/header.php"; ?>
<ol class="breadcrumb mb-4">
    <b><li class="breadcrumb-item active">Medidas</li></b>
</ol>
<button class="btn btn-primary mb-2" type="button" onclick="frmMedida();"><i class="fas fa-plus"></i></button>
<table class="table table-hover table-dark" id="tblMedidas">
    <thead>
        <tr>
            <th>ID</th>
            <th>Descripción</th>
            <th>Medida</th>
            <th>Tamaño de Caja</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<div id="nueva_medida" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Nueva Medida</h5>
            </div>
            <div class="modal-body">
                <form method="POST" id="frmMedida">
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <input type="hidden" id="id" name="id">
                        <input id="descripcion" class="form-control" type="text" name="descripcion" placeholder="Una pequeña descripción" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label for="medida">Medida</label>
                        <input id="medida" class="form-control" type="text" name="medida" placeholder="Número de la caja" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label for="tamCaja">Tamaño de Caja</label>
                        <input id="tamCaja" class="form-control" type="text" name="tamCaja" placeholder="nn x nn" autocomplete="off">
                    </div>
                    
                    <br>
                    <button class="btn btn-primary" type="button" onclick="registrarMed(event);" id="btnAccion">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>