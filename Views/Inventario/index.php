<?php include "Views/Templates/header.php"; ?>
<ol class="breadcrumb mb-4">
    <b>
        <li class="breadcrumb-item active">Inventario</li>
    </b>
</ol>
<form id="frmInventario">
    <div class="row">
        <div class="col-md-3">
            <label for="form-group">Medida</label>
            <select name="medida" id="medida" class="form-control">
                <option value="">------</option>
                <?php foreach ($data['medidas'] as $row) { ?>
                    <option value="<?php echo $row['medida']; ?>"><?php echo $row['medida']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="form-group">Material</label>
            <select name="material" id="material" class="form-control">
                <option value="Blanca">Blanca</option>
                <option value="Kraft">Kraft</option>
            </select>
        </div>
        <div class="col-md-3">
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

        <div class="col-md-3">
            <label for="form-group">Año</label>
            <input type="number" name="anio" id="anio" class="form-control" value="<?php echo date('Y'); ?>" onclick="return selectAnio(event);">
        </div>
    </div>
</form>
<button class="btn btn-danger mt-3" type="button" onclick="historialVentas()"><i class="fas fa-file-pdf"></i></button>
<table class="table table-hover table-dark" id="tblInventario">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tamaño</th>
            <th>Material</th>
            <th>Disponible en Almacén</th>
            <th>Cantidades</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<?php include "Views/Templates/footer.php"; ?>