<?php
class InventarioModel extends Query{
    public function __construct()
    {
        parent:: __construct();
    }

    public function getInventario()
    {
        $sql = "SELECT e.id, m.medida, e.tipoMaterial, e.cantidades, e.disponibleAlmacen FROM medidas m, existencias e WHERE e.id_medida = m.id";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function validar(int $mes, int $anio)
    {
        $sql = "SELECT * FROM ventas v, detalle_ventas dv WHERE MONTH(v.fecha) = $mes AND YEAR(v.fecha) = $anio AND v.id = dv.id_venta";
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

    public function getMedidas()
    {
        $sql = "SELECT * FROM medidas";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getDatos(int $mes, int $anio, string $material, string $medida)
    {
        $sql = "SELECT *, SUM(dv.cantidad) AS totalV FROM ventas v, detalle_ventas dv WHERE MONTH(v.fecha) = $mes AND YEAR(v.fecha) = $anio AND v.id = dv.id_venta AND dv.tipoMaterial = '$material' AND dv.medida = '$medida'";
        $data = $this->selectAll($sql);
        return $data;
    }

}
