<?php
class AlmacenesModel extends Query
{
    private $id_medida, $tipoMaterial, $remision, $fecha, $cantidad, $proveedor, $precioCompra, $id;
    public function __construct()
    {
        parent::__construct();
    }

    public function getMedidas()
    {
        $sql = "SELECT * FROM medidas";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getProveedores()
    {
        $sql = "SELECT * FROM proveedores";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getAlmacenes()
    {
        $sql = "SELECT a.id, m.medida, m.tamCaja, a.tipoMaterial, a.remision, a.fecha, p.nombre, a.cantidad, a.precioCompra FROM almacenes a, medidas m, proveedores p WHERE a.id_medida = m.id AND a.proveedor = p.id;";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function registrarAlmacen(
        int $id_medida,
        string $tipoMaterial,
        string $remision,
        string $fecha,
        int $cantidad,
        int $proveedor,
        string $precioCompra,
    ) {
        $this->id_medida = $id_medida;
        $this->tipoMaterial = $tipoMaterial;
        $this->remision = $remision;
        $this->fecha = $fecha;
        $this->cantidad = $cantidad;
        $this->proveedor = $proveedor;
        $this->precioCompra = $precioCompra;

        $verificar = "SELECT * FROM almacenes WHERE remision = '$this->remision' AND id_medida = '$this->id_medida' AND tipoMaterial = '$this->tipoMaterial'";
        $verificarEx = "SELECT * FROM existencias WHERE id_medida = '$this->id_medida' AND tipoMaterial = '$this->tipoMaterial'";
        $existe = $this->select($verificar);
        $existeEx = $this->select($verificarEx);

        if (empty($existe)) {

            $sql = "INSERT INTO almacenes(id_medida, remision, fecha, proveedor, tipoMaterial, cantidad,
                precioCompra) VALUES (?,?,?,?,?,?,?)";
            $datos = array(
                $this->id_medida, $this->remision, $this->fecha, $this->proveedor, $this->tipoMaterial, $this->cantidad, $this->precioCompra);

            $data = $this->save($sql, $datos);

            if ($data == 1) {
                $res = "ok";
            } else {
                $res = "error";
            }

            if (empty($existeEx)) {

                $sql = "INSERT INTO existencias(id_medida, tipoMaterial, disponibleAlmacen, cantidades, vendidas) VALUES (?, ?, ?, ?, ?)";
                $datos = array($this->id_medida, $this->tipoMaterial, $this->cantidad, 0, 0);
                $data = $this->save($sql, $datos);
            } else {

                $sql = "UPDATE existencias SET disponibleAlmacen = disponibleAlmacen + ? WHERE id_medida = '$this->id_medida' AND tipoMaterial = '$this->tipoMaterial'";
                $datos = array($this->cantidad);
                $data = $this->save($sql, $datos);
            }
        } else {
            $res = "existe";
        }


        return $res;
    }

    public function modificarAlmacen(
        int $id_medida,
        string $tipoMaterial,
        string $remision,
        string $fecha,
        int $cantidad,
        string $proveedor,
        string $precioCompra,
        int $id
    ) {
        $this->id_medida = $id_medida;
        $this->tipoMaterial = $tipoMaterial;
        $this->remision = $remision;
        $this->fecha = $fecha;
        $this->cantidad = $cantidad;
        $this->proveedor = $proveedor;
        $this->precioCompra = $precioCompra;
        $this->id = $id;

        $sql = "UPDATE almacenes SET id_medida = ?, tipoMaterial = ?, remision = ?,
               fecha = ?, cantidad = ?, proveedor = ?, precioCompra = ? WHERE id = ?";
        $datos = array(
            $this->id_medida, $this->tipoMaterial, $this->remision, $this->fecha,
            $this->cantidad, $this->proveedor, $this->precioCompra, $this->id
        );
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }

        return $res;
    }

    public function editarAlm(int $id)
    {
        $sql = "SELECT * FROM almacenes WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }

    public function eliminarAlm(int $id)
    {
        $this->id = $id;
        $sql = "DELETE FROM almacenes WHERE id = ?";
        $datos = array($this->id);
        $data = $this->save($sql, $datos);
        return $data;
    }

    public function editarMedida(int $id)
    {
        $sql = "SELECT * FROM medidas WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }
}
