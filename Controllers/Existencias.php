<?php
class Existencias extends Controller
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

    public function registrar()
    {
    	$id = $_POST['id'];
    	$disponibleAlmacen = $_POST['disponibleAlmacen'];
    	$cantidades = $_POST['cantidades'];
    	if (empty($id) || empty($cantidades)) {
    		$msg = "No se está recibiendo nada";
    	}else{
    		$data = $this->model->registrarExistencia($id, $disponibleAlmacen, $cantidades);
    		if ($data == "ok") {
    			$msg = "modificadae";
    		}else{
    			$msg = "error";
    		}
    	}

    	echo json_encode($msg, JSON_UNESCAPED_UNICODE);
    	die();
    }

    public function listar()
    {
        $data = $this->model->getExistencias();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['acciones'] = '<div>
            <button class="btn btn-primary" type="button" onclick="frmExistencia(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger" type="button" onclick="btnEliminarExi(' . $data[$i]['id'] . ')"><i class="fas fa-trash-alt"></i></button>
            </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar(int $id)
    {
    	$data = $this->model->editarExistencia($id);
    	echo json_encode($data, JSON_UNESCAPED_UNICODE);
    	die();
    }

    public function buscar(int $id)
    {
        $data = $this->model->buscarExistencia($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function alerta()
    {
        $data = $this->model->alerta();

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function eliminar(int $id)
    {
        $data = $this->model->eliminarExistencia($id);
        if ($data == 1) {
            $msg = "ok";
        }else{
            $msg = "error";
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
