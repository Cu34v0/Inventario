<?php include "Views/Templates/header.php"; ?>
<ol class="breadcrumb mb-4">
    <b><li class="breadcrumb-item active">Clientes</li></b>
</ol>
<button class="btn btn-primary mb-2" type="button" onclick="frmCliente();"><i class="fas fa-plus"></i></button>
<table class="table table-hover table-dark" id="tblClientes">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre Cliente</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<div id="nuevo_cliente" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Nuevo Cliente</h5>
            </div>
            <div class="modal-body">
                <form method="POST" id="frmCliente">
                    <div class="form-group">
                        <label for="nombre">Nombre Cliente</label>
                        <input type="hidden" id="id" name="id">
                        <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre Cliente" autocomplete="off">
                    </div>
                    <br>
                    <button class="btn btn-primary" type="button" onclick="registrarCli(event);" id="btnAccion">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>