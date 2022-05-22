<?php
class VentaModel extends Query{

    public function __construct()
    {
        parent:: __construct();
    }


    public function getClientes()
    {
        $sql = "SELECT * FROM clientes";
        $data = $this->selectAll($sql);
        return $data;

    }

    public function getExistencia(int $id)
    {
        $sql = "SELECT * FROM existencias WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }

    public function registrarDetalle(int $idCliente,int $idExistencia, string $precio, int $cantidad, string $subTotal, int $idUsuario)
    {
        $verificar = "SELECT * FROM detalle WHERE id_cliente = $idCliente AND id_existencia = $idExistencia AND id_usuario = $idUsuario";
        $existe = $this->select($verificar);

        if ($existe) {
            $sql = "UPDATE detalle SET cantidad = cantidad + ?, subTotal = subTotal + ? WHERE id_cliente = ? AND id_existencia = ? AND id_usuario = ?";
            $datos = array($cantidad, $subTotal, $idCliente, $idExistencia, $idUsuario);
            $data = $this->save($sql, $datos);
        }else{
            $sql = "INSERT INTO detalle(id_cliente, id_existencia, precio , cantidad, subTotal, id_usuario) VALUES (?, ?, ?, ?, ?, ?)";
            $datos = array($idCliente, $idExistencia, $precio , $cantidad, $subTotal, $idUsuario);
            $data = $this->save($sql, $datos);
        }

        if ($data == 1) {
            $res = "ok";
        }else{
            $res = "error";
        }
        return $res;
    }

    public function getDetalle(int $id_usuario)
    {
        $sql = "SELECT d.id, m.medida, e.tipoMaterial, d.precio, d.cantidad, d.subTotal, d.id_existencia FROM detalle d, medidas m, existencias e WHERE d.id_usuario = $id_usuario AND d.id_existencia = e.id AND e.id_medida = m.id ORDER BY d.id;";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function calcularTotal(int $id_usuario)
    {
        $sql = "SELECT SUM(subTotal) AS total FROM detalle WHERE id_usuario = $id_usuario";
        $data = $this->select($sql);
        return $data;
    }

    public function deleteDetalle(int $id)
    {
        $sql = "DELETE FROM detalle WHERE id = ?";
        $datos = array($id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        }else{
            $res = "error";
        }
        return $res;
    }

    public function registrarVenta(string $fecha, string $folio, int $id_cliente, string $total)
    {
        $this->fecha = $fecha;
        $this->folio = $folio;
        $this->id_cliente = $id_cliente;
        $this->total = $total;

        $verificar = "SELECT * FROM ventas WHERE folio = '$this->folio'";
        $existe = $this->select($verificar);

        if (empty($existe)) {
            $sql = "INSERT INTO ventas(fecha, folio, id_cliente, total) VALUES (?, ?, ?, ?)";
            $datos = array($this->fecha, $this->folio, $this->id_cliente, $this->total);
            $data = $this->save($sql, $datos);

            if ($data == 1) {
                $res = "ok";
            } else {
                $res = "error";
            }
        } else {
            $res = "existe";
        }
        return $res;
    }

    public function id_venta()
    {
        $sql = "SELECT MAX(id) AS id FROM ventas";
        $data = $this->select($sql);
        return $data;
    }

    public function registrarDetalleVenta(int $id_venta, string $medida, string $tipoMaterial, string $precio, int $cantidad, string $subTotal)
    {
        $this->id_venta = $id_venta;
        $this->medida = $medida;
        $this->tipoMaterial = $tipoMaterial;
        $this->precio = $precio;
        $this->cantidad = $cantidad;
        $this->subTotal = $subTotal;

        $sql = "INSERT INTO detalle_ventas(id_venta, medida, tipoMaterial, precio, cantidad, subTotal) VALUES (?, ?, ?, ?, ?, ?)";
        $datos = array($this->id_venta, $this->medida, $this->tipoMaterial, $this->precio, $this->cantidad, $this->subTotal);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        }else {
            $res = "error";
        }

        return $res;
    }

    public function vaciarDetalle($id_usuario)
    {
        $sql = "DELETE FROM detalle WHERE id_usuario = ?";
        $datos = array($id_usuario);
        $data = $this->save($sql, $datos);

        if ($data == 1) {
            $res = "ok";
        }else{
            $res = "error";
        }
        return $res;
    }

    public function restarExistencia(int $id_existencia, int $cantidad)
    {
        $sql = "UPDATE existencias SET cantidades = cantidades - ?, vendidas = vendidas + ? WHERE id = ?";
        $datos = array($cantidad, $cantidad , $id_existencia);
        $data = $this->save($sql, $datos);

        if ($data == 1) {
            $res = "ok";
        }else{
            $res = "error";
        }
        return $res;
    }
}
