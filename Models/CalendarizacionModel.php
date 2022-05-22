<?php
class CalendarizacionModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getProveedores()
    {
        $sql = "SELECT * FROM proveedores";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getProveedor($id_proveedor)
    {
        $sql = "SELECT * FROM proveedores WHERE id = $id_proveedor";
        $data = $this->select($sql);
        return $data;
    }

    public function buscar(int $proveedor, string $tipoMaterial, int $mes, int $anio)
    {
        $sql = "SELECT * FROM almacenes WHERE proveedor = $proveedor AND tipoMaterial = '$tipoMaterial' AND MONTH(fecha) = $mes AND YEAR(fecha) = $anio";
        $data = $this->select($sql);
        return $data;
    }

    public function getDatos(int $proveedor, string $tipoMaterial, int $mes, int $anio)
    {
        $sql = "SELECT a.*, m.* FROM almacenes a, medidas m WHERE a.proveedor = $proveedor AND a.tipoMaterial = '$tipoMaterial' AND MONTH(a.fecha) = $mes AND YEAR(a.fecha) = $anio AND a.id_medida = m.id";
        $data = $this->selectAll($sql);
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
}
