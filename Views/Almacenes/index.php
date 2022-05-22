<?php include "Views/Templates/header.php"; ?>
<ol class="breadcrumb mb-4">
    <b>
        <li class="breadcrumb-item active">Almacenes</li>
    </b>
</ol>
<button class="btn btn-primary mb-2" type="button" onclick="frmAlmacen();"><i class="fas fa-plus"></i></button>
<table class="table table-hover table-dark" id="tblAlmacenes">
    <thead>
        <tr>
            <th>ID</th>
            <th>Medida</th>
            <th>Tamaño Caja</th>
            <th>Material</th>
            <th>Remisión</th>
            <th>Fecha</th>
            <th>Proveedor</th>
            <th>Cantidad</th>
            <th>Precio Compra</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<div id="nuevo_almacen" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Nuevo Almacen</h5>
            </div>
            <div class="modal-body">
                <form method="POST" id="frmAlmacen">
                    <input type="hidden" id="id" name="id">
                    <label for="form-group">Descripción</label>
                    <select id="id_medida" class="form-control" name="id_medida" onchange="return buscar();">
                        <option value="0">-----</option>
                        <?php foreach ($data['medidas'] as $row) { ?>

                            <option value="<?php echo $row['id']; ?>"><?php echo $row['descripcion']; ?></option>

                        <?php } ?>
                    </select>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="medida">Medida</label>
                                <input id="medida" class="form-control" type="text" name="medida" placeholder="Medida" autocomplete="off" disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tamCaja">Tamaño de Caja</label>
                                <input id="tamCaja" class="form-control" type="text" name="tamCaja" placeholder="Tamaño de Caja" autocomplete="off" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="form-group">Material</label>
                            <div class="form-group">
                                <select name="tipoMaterial" id="tipoMaterial" class="form-control" required>
                                    <option value="No seleccionado">------</option>
                                    <option value="Blanca">Blanca</option>
                                    <option value="Kraft">Kraft</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="remision">Remisión</label>
                                <input id="remision" class="form-control" type="text" name="remision" placeholder="Remisión" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha">Fecha</label>
                                <input id="fecha" class="form-control" type="date" name="fecha" placeholder="Fecha">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cantidad">Cantidad</label>
                                <input id="cantidad" class="form-control" type="number" name="cantidad" placeholder="Cantidad" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <label for="form-group">Proveedores</label>
                    <select id="proveedor" class="form-control" name="proveedor" onchange="return prueba(); ">
                        <option value="0">-----</option>
                        <?php foreach ($data['proveedores'] as $row) { ?>

                            <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>

                        <?php } ?>
                    </select>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="precioCompra">Precio Compra</label>
                                <input id="precioCompra" class="form-control" type="number" name="precioCompra" placeholder="Precio Compra" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <br>
                    <button class="btn btn-primary" type="button" onclick="registrarAlm(event);" id="btnAccion">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>
