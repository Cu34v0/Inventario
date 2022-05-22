<?php include "Views/Templates/header.php"; ?>
<ol class="breadcrumb mb-4">
    <b>
        <li class="breadcrumb-item active">Nueva Venta</li>
    </b>
</ol>

<div class="card">
    <div class="card-body">
        <form id="frmVenta">
            <div class="row">
                <div class="col align-self-center">
                    <div class="form-group">
                        <label for="fecha">Fecha</label>
                        <input id="fecha" class="form-control" type="date" name="fecha" placeholder="Fecha" value="<?php echo $_SESSION['fecha']; ?>">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="folio">Folio de Remisión</label>
                        <input id="folio" class="form-control" type="text" name="folio" placeholder="Folio de Remisión" autocomplete="off" value="<?php echo $_SESSION['folio']; ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="hidden" id="id" name="id">
                        <input type="hidden" id="respaldoIdCliente" name="respaldoIdCliente">
                        <input type="hidden" id="respaldoTexCliente" name="respaldoTexCliente">
                        <label for="form-group">Cliente</label>
                        <select id="idCliente" class="form-control" name="idCliente">
                            <option value="<?php echo $_SESSION['respaldoIdCliente']; ?>"><?php echo $_SESSION['respaldoTexCliente']; ?></option>
                            <?php foreach ($data['clientes'] as $row) { ?>

                                <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>

                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="idExistencia">ID Existencia</label>
                        <input id="idExistencia" class="form-control" type="number" name="idExistencia" placeholder="ID Existencia" onkeyup="buscarExi(event);">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tamCaja">Medida</label>
                        <input id="medida" class="form-control" type="text" name="medida" placeholder="Medida" disabled>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tipoMaterial">Material</label>
                        <input id="tipoMaterial" class="form-control" type="text" name="tipoMaterial" placeholder="Material" disabled>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="disponible">Disponible</label>
                        <input id="disponible" class="form-control" type="number" name="disponible" placeholder="Disponible" disabled>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input id="precio" class="form-control" type="number" name="precio" placeholder="Precio">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input id="cantidad" class="form-control" type="number" name="cantidad" placeholder="Cantidad" onkeyup="operacion(event);">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="subTotal">Sub Total</label>
                        <input id="subTotal" class="form-control" type="number" name="subTotal" placeholder="Sub Total" readonly>
                    </div>
                </div>
            </div>

            <div class="row">

            </div>
        </form>
    </div>
</div>
<table class="table table-dark">
    <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Medida</th>
            <th>Material</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Sub Total</th>
            <th></th>
        </tr>
    </thead>
    <tbody id="tblDetalle">
    </tbody>
</table>
<div class="row">
    <div class="col-md-4 ms-auto">
        <div class="col-md-12">
            <div class="form-group">
                <label for="total" class="fw-bold">Total:</label>
                <input id="total" class="form-control" type="number" name="total" placeholder="Total" disabled>
                <div class="d-grid">
                    <button class="btn btn-primary mt-2" type="button" onclick="generarCompra()">Generar Venta</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>
