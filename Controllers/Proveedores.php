<?php 
class Proveedores extends Controller 
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
        $data = $this->model->getProveedores();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['acciones'] = '<div>
            <button class="btn btn-primary" type="button" onclick="btnEditarProv(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger" type="button" onclick="btnEliminarProv(' . $data[$i]['id'] . ')"><i class="fas fa-trash-alt"></i></button>
            </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrar()
    {
        $nombre = $_POST['nombre'];
        $id = $_POST['id'];
        if (empty($nombre)) {
            $msg = "Todos los campos son obligatorios.";
        }else{
            if ($id == "") {
                $data = $this->model->registrarProveedor($nombre);
                if ($data == 'ok') {
                    $msg = "si";
                }else{
                    $msg = $data;
                }
            } else {
                $data = $this->model->modificarProveedor($nombre, $id);
                if ($data == "modificado") {
                    $msg = "modificado";
                }else {
                    $msg = "Ha ocurrido un error al modificar al proveedor";
                }
            }
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
    }

    public function editar(int $id)
    {
        $data = $this->model->editarProv($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function eliminar(int $id)
    {
        $data = $this->model->eliminarProv($id);
        if ($data == 1) {
            $msg = "ok";
        } else {
            $msg = "error";
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function PDFBlancas($id)
    {
        require('Libraries/fpdf/fpdf.php');

        $datos = $this->model->getDatos($id);
        $productos = $this->model->getDetalles($id);
        
        
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetMargins(5, 0, 0);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 0, utf8_decode('REPORTE DE ENTRADAS'), 0, 1, 'C');

        $pdf->SetTitle("Reporte de entradas");

        // Nombre del proveedor
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(15, 25, 'Proveedor: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(40, 25, utf8_decode($datos['nombre']), 0, 0, 'C');

        $name = $datos['nombre'];

        // Encabezado de reporte
        $pdf->SetFillColor(0,0,0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(40, 5, utf8_decode('Tamaño'), 0, 0, 'C', true);
        $pdf->Cell(40, 5, 'Material', 0, 0, 'C', true);
        $pdf->Cell(40, 5, 'Fecha', 0, 0, 'C', true);
        $pdf->Cell(40, 5, utf8_decode('Remisión'), 0, 0, 'C', true);
        $pdf->Cell(40, 5, 'Cantidad', 0, 0, 'C', true);

        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln();
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        foreach ($productos as $row) {
            $pdf->Ln();
            $pdf->Cell(40, 5, utf8_decode($row['tamCaja']), 0, 0, 'C');
            $pdf->Cell(40, 5, utf8_decode($row['tipoMaterial']), 0, 0, 'C');
            $pdf->Cell(40, 5, utf8_decode($row['fecha']), 0, 0, 'C');
            $pdf->Cell(40, 5, utf8_decode($row['remision']), 0, 0, 'C');
            $pdf->Cell(40, 5, utf8_decode($row['cantidad']), 0, 0, 'C');
            $pdf->Ln();
        }

        $pdf->Output('', $name . '.pdf');
    }

    public function PDFKraft($id)
    {
        require('Libraries/fpdf/fpdf.php');

        $datos = $this->model->getDatos($id);
        $productos = $this->model->getDetallesK($id);
        
        
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetMargins(5, 0, 0);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 0, utf8_decode('REPORTE DE ENTRADAS'), 0, 1, 'C');

        $pdf->SetTitle("Reporte de entradas");

        // Nombre del proveedor
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(15, 25, 'Proveedor: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(40, 25, utf8_decode($datos['nombre']), 0, 0, 'C');

        $name = $datos['nombre'];

        // Encabezado de reporte
        $pdf->SetFillColor(0,0,0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(40, 5, utf8_decode('Tamaño'), 0, 0, 'C', true);
        $pdf->Cell(40, 5, 'Material', 0, 0, 'C', true);
        $pdf->Cell(40, 5, 'Fecha', 0, 0, 'C', true);
        $pdf->Cell(40, 5, utf8_decode('Remisión'), 0, 0, 'C', true);
        $pdf->Cell(40, 5, 'Cantidad', 0, 0, 'C', true);

        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln();
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        foreach ($productos as $row) {
            $pdf->Ln();
            $pdf->Cell(40, 5, utf8_decode($row['tamCaja']), 0, 0, 'C');
            $pdf->Cell(40, 5, utf8_decode($row['tipoMaterial']), 0, 0, 'C');
            $pdf->Cell(40, 5, utf8_decode($row['fecha']), 0, 0, 'C');
            $pdf->Cell(40, 5, utf8_decode($row['remision']), 0, 0, 'C');
            $pdf->Cell(40, 5, utf8_decode($row['cantidad']), 0, 0, 'C');
            $pdf->Ln();
        }

        $pdf->Output('', $name . '.pdf');
    }
}

?>
