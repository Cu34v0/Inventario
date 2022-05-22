<?php
class CalendarioVentas extends Controller
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
        $data['numCaja'] = $this->model->getNumCaja();
        $this->views->getView($this, "index", $data);
    }

    public function generarReporte()
    {
        $cliente = $_POST['cliente'];
        $numCaja = $_POST['numCaja'];
        $material = $_POST['material'];
        $mes = $_POST['mes'];
        $anio = $_POST['anio'];


        if (empty($cliente) || empty($numCaja) || empty($material) || empty($mes) || empty($anio)) {
            $msg = "No se está recibiendo nada";
        }else {
            $data = $this->model->buscarVenta($cliente, $mes, $anio);
           if ($data) {
               /*
               $msg = "si";
               $_SESSION['numCaja'] = $numCaja;
               $_SESSION['material'] = $material;
               $_SESSION['mes'] = $mes;
               $_SESSION['anio'] = $anio;
               $_SESSION['cliente'] = $cliente;
               */
              $numCajaDatos = $this->model->getCaja($numCaja);
              $data = $this->model->getDatosV($mes, $anio, $cliente, $numCajaDatos['medida']);
              if ($data) {
                    $msg = "si";
                    $_SESSION['numCaja'] = $numCaja;
                    $_SESSION['material'] = $material;
                    $_SESSION['mes'] = $mes;
                    $_SESSION['anio'] = $anio;
                    $_SESSION['cliente'] = $cliente;
              } else {
                  $msg = "no";
              }
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
        $numCaja = $_SESSION['numCaja'];
        $material = $_SESSION['material'];
        $mes = $_SESSION['mes'];
        $anio = $_SESSION['anio'];
        $cliente = $_SESSION['cliente'];

        // Obtención de datos
        $clienteDatos = $this->model->getCliente($cliente);
        $numCajaDatos = $this->model->getCaja($numCaja);
        $mesT = $this->model->getMes($mes);
        $datosVenta = $this->model->getDatosV($mes, $anio, $cliente, $numCajaDatos['medida']);

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetMargins(5, 0, 0);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 0, utf8_decode('Reporte de salidas'), 0, 1, 'C');

        $pdf->SetTitle('Reporte de salidas');

        // Nombre del cliente
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(25, 25, 'Cliente: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(45, 25, utf8_decode($clienteDatos['nombre']), 0, 0, 'C');

        $pdf->Ln();

        // Número de Caja
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(15, -10, utf8_decode('Número de Caja: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(80, -10, utf8_decode($numCajaDatos['medida']), 0, 0, 'C');

        $pdf->Ln();

        // Material
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(15, 25, 'Material: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(25, 25, utf8_decode($material), 0, 0, 'C');

        $pdf->Ln(7);

        // Mes
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(15, 25, 'Mes: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(15, 25, utf8_decode($mesT), 0, 0, 'C');

        $pdf->Ln(7);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(15, 25, utf8_decode('Año: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(10, 25, $anio, 0, 0, 'C');

        $pdf->Ln(-5);

        // Encabezado de reporte de entradas
        $pdf->SetFillColor(0, 0, 0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(15, 5, utf8_decode('ID'), 0, 0, 'C', true);
        $pdf->Cell(62, 5, 'Fecha', 0, 0, 'C', true);
        $pdf->Cell(62, 5, utf8_decode('Cantidad'), 0, 0, 'C', true);
        $pdf->Cell(62, 5, 'Precio', 0, 0, 'C', true);

        // Relleno de información
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln();
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        foreach ($datosVenta as $row) {
            $pdf->Cell(15, 10, utf8_decode($row['id']), 0, 0, 'C');
            $pdf->Cell(62, 10, utf8_decode($row['fecha']), 0, 0, 'C');
            $pdf->Cell(62, 10, utf8_decode($row['cantidad']) . ' pieza(s)', 0, 0, 'C');
            $pdf->Cell(62, 10, '$' . number_format($row['precio'], 2, '.', ','), 0, 0, 'C');
            $pdf->Ln();
        }

        $name = "Reporte de entradas - ";
        

        $pdf->Output('', $name . ' '. $mesT . '.pdf');
    }
    
public function salir()
    {
        session_destroy();
        header('location: ' . base_url);
    }
}
