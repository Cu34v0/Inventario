<?php include "Views/Templates/header.php" ?>
<ol class="breadcrumb">
    <b>
        <li class="breadcrumb-item active">Cambio de contraseña de: <?php echo $_SESSION['usuario'] ?></li>
    </b>
</ol>

<main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-body">
                                    <form id="frmPass">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="passActual" name="passActual" type="password"
                                                placeholder="Ingrese su usuario" autocomplete="off" autofocus/>
                                            <label for="passActual"><i class="fas fa-key"></i> Contraseña Actual</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="nuevaPass" name="nuevaPass" type="password"
                                                placeholder="Ingrese su contraseña" />
                                            <label for="nuevaPass"><i class="fas fa-lock-open"></i> Nueva Contraseña</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" id="confirmar" name="confirmar" placeholder="Confirmar">
                                            <label for="confirmar"><i class="fas fa-lock"></i> Confirmar</label>
                                        </div>
                                        <div class="alert alert-danger text-center d-none" id="alerta" role="alert">
                                            
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button class="btn btn-primary" type="submit" onclick="changePass(event);">Ingresar</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </main>


<?php include 'Views/Templates/footer.php'; ?>