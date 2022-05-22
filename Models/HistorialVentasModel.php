<?php
class HistorialVentasModel extends Query{
    
    public function __construct()
    {
        parent:: __construct();
    }

    public function getHistorial()
    {
        $sql = "SELECT v.id, v.fecha, v.folio, c.nombre, v.total FROM ventas v, clientes c WHERE v.id_cliente = c.id";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getDatos(int $id)
    {
        $sql = "SELECT v.id, v.fecha, v.folio, c.nombre, v.total FROM ventas v, clientes c WHERE v.id_cliente = c.id AND v.id = $id";
        $data = $this->select($sql);
        return $data;
    }

    public function getDetalles(int $id)
    {
        $sql = "SELECT * FROM detalle_ventas WHERE id_venta = $id";
        $data = $this->selectAll($sql);
        return $data;
    }
}
