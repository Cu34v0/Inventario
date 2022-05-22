<?php
class HistorialVentas extends Controller
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
        $this->views->getView($this, "index");
    }

    public function listar()
    {
        $data = $this->model->getHistorial();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['acciones'] = '<div>
            <button class="btn btn-danger" type="button" onclick="btnGenerarPDF(' . $data[$i]['id'] . ');" title="Generar PDF"><i class="fas fa-file-pdf"></i></button>
            </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function generarPDF($id_venta)
    {
        require('Libraries/fpdf/fpdf.php');

        $datos = $this->model->getDatos($id_venta);
        $productos = $this->model->getDetalles($id_venta);

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetMargins(5, 0, 0);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 0, utf8_decode('Cajas y Cartones VCC.'), 0, 1, 'C');

        $pdf->SetTitle('Reporte de venta');

        // Nombre del cliente
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(30, 25, 'Cliente: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(40, 25, utf8_decode($datos['nombre']), 0, 0, 'C');

        $pdf->Ln();

        // Folio
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(15, -10, 'Folio: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(35, -10, utf8_decode($datos['folio']), 0, 0, 'C');

        $pdf->Ln();

        // Folio
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(15, 25, 'Fecha: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(36, 25, utf8_decode($datos['fecha']), 0, 0, 'C');

        $name = $datos['folio'];

        // Encabezado de productos
        $pdf->SetFillColor(0,0,0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(40, 5, utf8_decode('Medida'), 0, 0, 'C', true);
        $pdf->Cell(40, 5, 'Material', 0, 0, 'C', true);
        $pdf->Cell(40, 5, 'Precio', 0, 0, 'C', true);
        $pdf->Cell(40, 5, 'Cantidad', 0, 0, 'C', true);
        $pdf->Cell(40, 5, 'SubTotal', 0, 1, 'C', true);

        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln();
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        foreach ($productos as $row) {
            $pdf->Cell(40, 5, utf8_decode($row['medida']), 0, 0, 'C');
            $pdf->Cell(40, 5, utf8_decode($row['tipoMaterial']), 0, 0, 'C');
            $pdf->Cell(40, 5, '$' . number_format($row['precio'], 2, '.', ','), 0, 0, 'C');
            $pdf->Cell(40, 5, utf8_decode($row['cantidad'] . " pieza(s)"), 0, 0, 'C');
            $pdf->Cell(40, 5, '$'. number_format($row['subTotal'], 2, '.', ','), 0, 1, 'C');
            $pdf->Ln();
        }

        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(155, 5, 'Total: ', 0, 0, 'R');
        $pdf->SetFont('Arial', '', 14);
        $pdf->Cell(25, 5, '$'. number_format($datos['total'], 2, '.', ','), 0, 0, 'R');


        $pdf->Output('', $name . '.pdf');
    }
}
