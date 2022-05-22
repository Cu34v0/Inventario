<?php
class Venta extends Controller
{
    public function __construct()
    {
        session_start();
        parent::__construct();
    }

    public function index()
    {
        if (empty($_SESSION['activo'])) {
            header('Location: ' . base_url);
        }
        $data['clientes'] = $this->model->getClientes();
        $this->views->getView($this, "index", $data);
    }

    public function ingresar()
    {
        $fecha = $_POST['fecha'];
        $_SESSION['fecha'] = $fecha;
        $folio = $_POST['folio'];
        $_SESSION['folio'] = $folio;
        $respaldoIdCliente = $_POST['respaldoIdCliente'];

        $respaldoTexCliente = $_POST['respaldoTexCliente'];

        $idUsuario = $_SESSION['id_usuario'];
        $idCliente = $_POST['idCliente'];
        $idExistencia = $_POST['idExistencia'];
        $precio = $_POST['precio'];
        $cantidad = $_POST['cantidad'];
        $subTotal = $_POST['subTotal'];

        if (!empty($idCliente) && !empty($respaldoIdCliente) && !empty($respaldoTexCliente)) {
            $_SESSION['respaldoIdCliente'] = $respaldoIdCliente;
            $_SESSION['respaldoTexCliente'] = $respaldoTexCliente;
        } else {

            $idCliente = $_SESSION['respaldoIdCliente'];
        }

        if (empty($fecha) || empty($folio) || empty($idCliente) || empty($idExistencia) || empty($precio) || empty($cantidad) || empty($subTotal) || empty($idUsuario)) {
            $msg = "error";
        } else {
            $data = $this->model->registrarDetalle($idCliente, $idExistencia,$precio, $cantidad, $subTotal, $idUsuario);
            if ($data == "ok") {
                $msg = "ok";
            } else {
                $msg = "error";
            }
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function listar()
    {
        $id_usuario = $_SESSION['id_usuario'];
        $data['detalle'] = $this->model->getDetalle($id_usuario);
        $data['totalPagar'] = $this->model->calcularTotal($id_usuario);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function delete($id)
    {
        $data = $this->model->deleteDetalle($id);
        if ($data == 'ok') {
            $msg = 'ok';
        } else {
            $msg = 'error';
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrarVenta()
    {
        $fecha = $_SESSION['fecha'];
        $folio = $_SESSION['folio'];
        $id_cliente = $_SESSION['respaldoIdCliente'];
        $id_usuario = $_SESSION['id_usuario'];
        $total = $this->model->calcularTotal($id_usuario);

        if (empty($fecha) || empty($folio) || empty($id_cliente) || empty($total['total'])) {
            $msg = "No se está recibiendo nada" . $id_cliente;
        } else {
            $data = $this->model->registrarVenta($fecha, $folio, $id_cliente, $total['total']);
            if ($data == 'ok') {
                $detalle = $this->model->getDetalle($id_usuario);
                $id_venta = $this->model->id_venta();
                foreach ($detalle as $row) {
                    $id_existencia = $row['id_existencia'];
                    $medida = $row['medida'];
                    $tipoMaterial = $row['tipoMaterial'];
                    $precio = $row['precio'];
                    $cantidad = $row['cantidad'];
                    $subTotal = $cantidad * $precio;
                    $this->model->registrarDetalleVenta($id_venta['id'], $medida, $tipoMaterial, $precio, $cantidad, $subTotal);
                    $this->model->restarExistencia($id_existencia, $cantidad);
                }
                $this->model->vaciarDetalle($id_usuario);
                $_SESSION['folio'] = '';
                $_SESSION['fecha'] = '';
                $_SESSION['respaldoIdCliente'] = '';
                $_SESSION['respaldoTexCliente'] = '';
                $msg = 'ok';
            } else if ($data == 'existe') {
                $msg = 'existe';
            } else {
                $msg = 'Error al registrar la venta';
            }
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
