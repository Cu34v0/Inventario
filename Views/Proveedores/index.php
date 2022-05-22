<?php include "Views/Templates/header.php"; ?>
<ol class="breadcrumb mb-4">
    <b><li class="breadcrumb-item active">Proveedores</li></b>
</ol>
<button class="btn btn-primary mb-2" type="button" onclick="frmProveedor();"><i class="fas fa-plus"></i></button>
<table class="table table-hover table-dark" id="tblProveedores">
    <thead>
        <tr>
            <th>ID</th>
            <th>Proveedor</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<div id="nuevo_proveedor" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Nuevo Proveedor</h5>
            </div>
            <div class="modal-body">
                <form method="POST" id="frmProveedor">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="hidden" id="id" name="id">
                        <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre del proveedor" autocomplete="off">
                    </div>
                    
                    <br>
                    <button class="btn btn-primary" type="button" onclick="registrarProv(event);" id="btnAccion">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>