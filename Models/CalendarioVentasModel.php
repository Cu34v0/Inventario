<?php 
class CalendarioVentasModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getClientes()
    {
        $sql = "SELECT * FROM clientes";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getNumCaja()
    {
        $sql = "SELECT * FROM medidas";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function buscarVenta(int $cliente, string $mes, int $anio)
    {
        $sql = "SELECT * FROM ventas WHERE MONTH(fecha) = '$mes' AND YEAR(fecha) = $anio AND id_cliente = $cliente";
        $data = $this->select($sql);
        return $data;
    }

    public function getCliente(int $idCliente)
    {
        $sql = "SELECT * FROM clientes WHERE id = $idCliente";
        $data = $this->select($sql);
        return $data;
    }

    public function getCaja(int $idMedida)
    {
        $sql = "SELECT * FROM medidas WHERE id = $idMedida";
        $data = $this->select($sql);
        return $data;
    }

    public function getMes(int $num)
    {
        switch ($num) {
            case '1':
                $mesT = 'Enero';
                break;
            case '2':
                $mesT = 'Febrero';
                break;
            case '3':
                $mesT = 'Marzo';
                break;
            case '4':
                $mesT = 'Abril';
                break;
            case '5':
                $mesT = 'Mayo';
                break;
            case '6':
                $mesT = 'Junio';
                break;
            case '7':
                $mesT = 'Julio';
                break;
            case '8':
                $mesT = 'Agosto';
                break;
            case '9':
                $mesT = 'Septiembre';
                break;
            case '10':
                $mesT = 'Octubre';
                break;
            case '11':
                $mesT = 'Noviembre';
                break;
            case '12':
                $mesT = 'Diciembre';
                break;

            default:
                $mesT = 'No se ingreso un mes válido';
                break;
        }
        return $mesT;
    }

    public function getDatosV(int $mes, int $anio, int $cliente, string $medida)
    {
        $sql = "SELECT * FROM ventas v, detalle_ventas dv WHERE MONTH(v.fecha) = $mes AND YEAR(v.fecha) = $anio AND v.id = dv.id_venta AND v.id_cliente = $cliente AND dv.medida = '$medida'";
        $data = $this->selectAll($sql);
        return $data;
    }
}
?>