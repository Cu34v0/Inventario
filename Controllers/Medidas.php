<?php
class Medidas extends Controller
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo'])) {
            header('Location: ' . base_url);
        }
        parent::__construct();
    }

    public function index()
    {
        $this->views->getView($this, "index");
    }

    public function listar()
    {
        $data = $this->model->getMedidas();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['acciones'] = '<div>
            <button class="btn btn-primary" type="button" onclick="btnEditarMed(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger" type="button" onclick="btnEliminarMed(' . $data[$i]['id'] . ')"><i class="fas fa-trash-alt"></i></button>
            </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrar()
    {
        $descripcion = $_POST['descripcion'];
        $medida = $_POST['medida'];
        $tamCaja = $_POST['tamCaja'];
        $id = $_POST['id'];
        if (empty($descripcion) || empty($medida) || empty($tamCaja)) {
            $msg = "Todos los campos son obligatorios";
        } else {
            if ($id == "") {
                $data = $this->model->registrarMedida($descripcion, $medida, $tamCaja);
                if ($data == "ok") {
                    $msg = "si";
                } else if ($data == "existe") {
                    $msg = "La medida ya existe";
                } else {
                    $msg = "Error al registrar la medida";
                }
            } else {
                $data = $this->model->modificarMedida($descripcion, $medida, $tamCaja, $id);
                if ($data == "modificado") {
                    $msg = "modificado";
                } else {
                    $msg = "Error al modificar la medida";
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar(int $id)
    {
        $data = $this->model->editarMed($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function eliminar(int $id)
    {
        $data = $this->model->eliminarMed($id);
        if ($data == 1) {
            $msg = "ok";
        } else {
            $msg = "Error al eliminar la Medida";
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
