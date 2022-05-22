<?php
class ExistenciasModel extends Query{

    public function __construct()
    {
        parent:: __construct();
    }


    public function getExistencias()
    {
        $sql = "SELECT m.medida, e.* FROM medidas m, existencias e WHERE e.id_medida = m.id";
        $data = $this->selectAll($sql);
        return $data;

    }

    public function editarExistencia(int $id)
    {
        $sql = "SELECT * FROM existencias WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }

    public function registrarExistencia(int $id, int $disponibleAlmacen, int $cantidades)
    {
        $this->id = $id;
        $this->disponibleAlmacen = $disponibleAlmacen;
        $this->cantidades = $cantidades;

        $sql = "UPDATE existencias SET disponibleAlmacen = ?, cantidades = cantidades + ? WHERE id = ?";
        $datos = array($this->disponibleAlmacen, $this->cantidades, $this->id);
        $data = $this->save($sql, $datos);

        if ($data == 1) {
            $res = "ok";
        }else{
            $res = "error";
        }
        return $res;
    }

    public function buscarExistencia(int $id)
    {
        $sql = "SELECT m.medida, e.* FROM medidas m, existencias e WHERE e.id = '$id' AND m.id = e.id_medida";
        $data = $this->select($sql);
        return $data;
    }

    public function alerta()
    {
        $sql = "SELECT m.tamCaja, e.tipoMaterial, e.cantidades, e.disponibleAlmacen FROM existencias e, medidas m WHERE e.disponibleAlmacen <= 1000 AND e.id_medida = m.id";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function eliminarExistencia(int $id)
    {
        $this->id = $id;
        $sql = "DELETE FROM existencias WHERE id = ?";
        $datos = array($this->id);
        $data = $this->save($sql, $datos);
        return $data;
    }
}
