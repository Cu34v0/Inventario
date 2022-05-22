<?php
class Calendarizacion extends Controller
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
        $data['proveedores'] = $this->model->getProveedores();
        $this->views->getView($this, "index", $data);
    }

    public function generarReporte()
    {
        $proveedor = $_POST['proveedor'];
        $tipoMaterial = $_POST['tipoMaterial'];
        $mes = $_POST['mes'];
        $anio = $_POST['anio'];

        if (empty($proveedor) || empty($tipoMaterial) || empty($mes) || empty($anio)) {
            $msg = "No se está recibiendo nada";
        } else {
            $data = $this->model->buscar($proveedor, $tipoMaterial, $mes, $anio);
            if ($data) {
                $msg = "si";
                $_SESSION['proveedor'] = $proveedor;
                $_SESSION['tipoMaterial'] = $tipoMaterial;
                $_SESSION['mes'] = $mes;
                $_SESSION['anio'] = $anio;
            } else {
                $msg = "no";
            }
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
    }

    public function pdf()
    {
        require('Libraries/fpdf/fpdf.php');

        // Variables de sesión
        $idProveedor = $_SESSION['proveedor'];
        $material = $_SESSION['tipoMaterial'];
        $mes = $_SESSION['mes'];
        $anio = $_SESSION['anio'];

        $mesT = $this->model->getMes($mes);

        $proveedor = $this->model->getProveedor($idProveedor);
        $datos = $this->model->getDatos($idProveedor, $material, $mes, $anio);

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetMargins(5, 0, 0);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 0, utf8_decode('Reporte de entradas'), 0, 1, 'C');

        $pdf->SetTitle('Reporte de entradas');

        // Nombre del proveedor
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(15, 25, 'Proveedor: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(60, 25, utf8_decode($proveedor['nombre']), 0, 0, 'C');

        $pdf->Ln();

        // Tipo de material
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(15, -10, 'Material: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(40, -10, utf8_decode($material), 0, 0, 'C');

        $pdf->Ln();

        // Mes
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(15, 25, 'Mes: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(42, 25, utf8_decode($mesT), 0, 0, 'C');

        $pdf->Ln();

        // Año
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(15, -10, utf8_decode('Año:'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(36, -10, utf8_decode($anio), 0, 0, 'C');

        $pdf->Ln(12);

        // Encabezado de reporte de entradas
        $pdf->SetFillColor(0, 0, 0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(15, 5, utf8_decode('ID'), 0, 0, 'C', true);
        $pdf->Cell(20, 5, 'Medida', 0, 0, 'C', true);
        $pdf->Cell(40, 5, utf8_decode('Remisión'), 0, 0, 'C', true);
        $pdf->Cell(40, 5, 'Fecha', 0, 0, 'C', true);
        $pdf->Cell(40, 5, 'Cantidad', 0, 0, 'C', true);
        $pdf->Cell(40, 5, 'Precio de Compra', 0, 1, 'C', true);

        // Relleno de información
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln();
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        foreach ($datos as $row) {
            $pdf->Cell(15, 5, utf8_decode($row['id']), 0, 0, 'C');
            $pdf->Cell(20, 5, utf8_decode($row['tamCaja']), 0, 0, 'C');
            $pdf->Cell(40, 5, utf8_decode($row['remision']), 0, 0, 'C');
            $pdf->Cell(40, 5, utf8_decode($row['fecha']), 0, 0, 'C');
            $pdf->Cell(40, 5, utf8_decode($row['cantidad']), 0, 0, 'C');
            $pdf->Cell(40, 5, '$' . number_format($row['precioCompra'], 2, '.', ','), 0, 0, 'C');
            $pdf->Ln();
        }

        $name = "Reporte de entradas-" . $mesT;

        $pdf->Output('', $name . '.pdf');
    }

    public function salir()
    {
        session_destroy();
        header('location: ' . base_url);
    }
}
