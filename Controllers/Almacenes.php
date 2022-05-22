<?php
class Almacenes extends Controller
{
    public function __construct()
    {
        session_start();
        parent::__construct();
    }

    public function index()
    {
        if (empty($_SESSION['activo'])) {
            header('Location: '.base_url);
        }
        $data['medidas'] = $this->model->getMedidas();
        $data['proveedores'] = $this->model->getProveedores();
        $this->views->getView($this, "index", $data);
    }

    public function listar()
    {
        $data = $this->model->getAlmacenes();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['acciones'] = '<div>
            <button class="btn btn-primary" type="button" onclick="btnEditarAlm(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger" type="button" onclick="btnEliminarAlm(' . $data[$i]['id'] . ')"><i class="fas fa-trash-alt"></i></button>
            </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }


    public function registrar()
    {
        $id_medida = $_POST['id_medida'];
        $tipoMaterial = $_POST['tipoMaterial'];
        $remision = $_POST['remision'];
        $fecha = $_POST['fecha'];
        $cantidad = $_POST['cantidad'];
        $proveedor = $_POST['proveedor'];
        $precioCompra = $_POST['precioCompra'];
        $id = $_POST['id'];
        if (empty($id_medida) || empty($tipoMaterial) || empty($remision) || empty($fecha)
         || empty($cantidad) || empty($proveedor) || empty($precioCompra)) {
            $msg = "Todos los campos son obligatorios";
        } else {
            if ($id == "") {
                    $data = $this->model->registrarAlmacen($id_medida, $tipoMaterial, $remision, $fecha
                    , $cantidad, $proveedor, $precioCompra);
                    if ($data == "ok") {
                        $msg = "si";
                    } else if ($data == "existe") {
                        $msg = "El almacen ya existe";
                    } else {
                        $msg = "Error en registrar el almacen";
                    }
            } else {
                $data = $this->model->modificarAlmacen($id_medida, $tipoMaterial, $remision, $fecha
                , $cantidad, $proveedor, $precioCompra, $id);
                if ($data == "modificado") {
                    $msg = "modificado";
                }else {
                    $msg = "Error al modificar el usuario";
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar(int $id)
    {
        $data = $this->model->editarAlm($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function busqueda(int $id)
    {
        $data = $this->model->editarMedida($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function eliminar(int $id)
    {
        $data = $this->model->eliminarAlm($id);
        if ($data == 1) {
            $msg = "ok";
        }else {
            $msg = "Error al eliminar el almacen";
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function salir()
    {
        session_destroy();
        header('location: ' . base_url);
    }

}
