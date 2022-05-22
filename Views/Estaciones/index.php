<?php include "Views/Templates/header.php"; ?>
<ol class="breadcrumb mb-4">
    <b><li class="breadcrumb-item active">Estaciones</li></b>
</ol>
<button class="btn btn-primary mb-2" type="button" onclick="frmEstacion();"><i class="fas fa-plus"></i></button>
<table class="table table-hover table-dark" id="tblEstaciones">
    <thead>
        <tr>
            <th>ID</th>
            <th>Estacion</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<div id="nueva_estacion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Nueva Estacion</h5>
            </div>
            <div class="modal-body">
                <form method="POST" id="frmEstacion">
                    <div class="form-group">
                        <label for="estacion">Estacion</label>
                        <input type="hidden" id="id" name="id">
                        <input id="estacion" class="form-control" type="text" name="estacion" placeholder="Nombre de la estación" autocomplete="off">
                    </div>
                    
                    <br>
                    <button class="btn btn-primary" type="button" onclick="registrarEst(event);" id="btnAccion">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>