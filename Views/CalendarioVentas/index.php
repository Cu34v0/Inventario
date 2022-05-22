<?php include "Views/Templates/header.php"; ?>
<ol class="breadcrumb mb-4">
    <b>
        <li class="breadcrumb-item active">Calendario de salidas (Ventas)</li>
    </b>
</ol>

<div class="card">
    <div class="card-body">
        <form id="frmCalendarioVentas">
            <div class="row">
                <div class="col-md-4">
                    <label for="form-group">Cliente</label>
                    <select name="cliente" id="cliente" class="form-control">
                        <option value="">------</option>
                        <?php foreach ($data['clientes'] as $row) { ?>

                            <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>

                        <?php } ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="form-group">Número de Caja</label>
                    <select name="numCaja" id="numCaja" class="form-control">
                        <option value="">------</option>
                        <?php foreach ($data['numCaja'] as $row) { ?>

                            <option value="<?php echo $row['id']; ?>"><?php echo $row['medida'] ?></option>

                            <?php } ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="form-group">Material</label>
                    <select name="material" id="material" class="form-control">
                        <option value="Blanca">Blanca</option>
                        <option value="Kraft">Kraft</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">

                </div>

                <div class="col-md-4">
                    <label for="form-group">Mes</label>
                    <select name="mes" id="mes" class="form-control">
                        <option value="1">Enero</option>
                        <option value="2">Febrero</option>
                        <option value="3">Marzo</option>
                        <option value="4">Abril</option>
                        <option value="5">Mayo</option>
                        <option value="6">Junio</option>
                        <option value="7">Julio</option>
                        <option value="8">Agosto</option>
                        <option value="9">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="form-group">Año</label>
                    <input type="number" name="anio" id="anio" class="form-control" placeholder="Año" onclick="return selectAnio(event);" value="<?php echo date("Y"); ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">

                </div>
                <div class="col-md-4">
                    <div class="d-grid">
                        <button class="btn btn-danger mt-4" type="button" onclick="generarReporteV(event)">Generar Reporte</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>