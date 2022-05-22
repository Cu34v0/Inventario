<?php
class Inventario extends Controller
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
        $data['medidas'] = $this->model->getMedidas();
        $this->views->getView($this, "index", $data);
    }

    public function listar()
    {
        $data = $this->model->getInventario();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['acciones'] = '<div>
            <button class="btn btn-primary" type="button" onclick="btnEditarEst(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger" type="button" onclick="btnEliminarEst(' . $data[$i]['id'] . ')"><i class="fas fa-trash-alt"></i></button>
            </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function generarReporte()
    {
        $mes = $_POST['mes'];
        $anio = $_POST['anio'];
        $material = $_POST['material'];
        $medida = $_POST['medida'];
        if (empty($mes) || empty($anio) || empty($material) || empty($medida)) {
            $msg = "No se está recibiendo nada";
        } else {
            $data = $this->model->validar($mes, $anio);
            if ($data) {
                $msg = "si";
                $_SESSION['mesInv'] = $mes;
                $_SESSION['anioInv'] = $anio;
                $_SESSION['materialV'] = $material;
                $_SESSION['medidaV'] = $medida;
            }else {
                $msg = "no";
            }
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
    }

    public function pdf()
    {
        require('Libraries/fpdf/fpdf.php');

        // Variables de sesión
        $mes = $_SESSION['mesInv'];
        $anio = $_SESSION['anioInv'];
        $material = $_SESSION['materialV'];
        $medida = $_SESSION['medidaV'];

        // Obtención de datos
        $mesT = $this->model->getMes($mes);
        $datos = $this->model->getDatos($mes, $anio, $material, $medida);

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetMargins(5, 0, 0);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 0, utf8_decode('Reporte de salidas por tipo de Caja y Material'), 0, 1, 'C');
        $pdf->SetTitle("Reporte de salidas");

        // Mes y año de generación
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(15, 25, utf8_decode('Mes y Año:'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(45, 25, utf8_decode($mesT.' - '. $anio), 0, 0, 'R');

        $pdf->Ln(7);
        
        // Material
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20, 25, utf8_decode('Material:'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(18, 25, utf8_decode($material), 0, 0, 'R');

        $pdf->Ln(7);

        // Medida
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(15, 25, utf8_decode('Medida: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(45, 25, utf8_decode($medida), 0, 0, 'R');

        $pdf->Ln(-5);

        // Encabezado reportes de salida
        $pdf->SetFillColor(0, 0, 0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(200, 5, utf8_decode('Cantidades Vendidas'), 0, 0, 'C', true);

        // Relleno de información
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln();
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        foreach ($datos as $row) {
            $pdf->Ln(4);
            $pdf->Cell(200, 5, utf8_decode($row['totalV'] . " pieza(s)"), 0, 0, 'C');
        }

        $name = "Reporte de salidas " . $mesT . " - " . $anio . " (" . $medida . " - " . $material.")";

        $pdf->Output('', $name, '.pdf');
    }
}
