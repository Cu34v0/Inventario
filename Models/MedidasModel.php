<?php
class MedidasModel extends Query{
    private $descripcion, $medida, $tamCaja, $id;
    public function __construct()
    {
        parent:: __construct();
    }


    public function getMedidas()
    {
        $sql = "SELECT * FROM medidas";
        $data = $this->selectAll($sql);
        return $data;

    }

    public function registrarMedida(string $descripcion, string $medida, string $tamCaja)
    {
        $this->descripcion = $descripcion;
        $this->medida = $medida;
        $this->tamCaja = $tamCaja;

        $verificar = "SELECT * FROM medidas WHERE medida = '$this->medida' AND tamCaja = '$this->tamCaja'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            
        $sql = "INSERT INTO medidas(descripcion, medida, tamCaja) VALUES (?, ?, ?)";
        $datos = array($this->descripcion, $this->medida, $this->tamCaja);

        $data = $this->save($sql, $datos);

        if ($data == 1) {
            $res = "ok";
        }else{
            $res = "error";
        }

        }else{
            $res = "existe";
        }

        
        return $res;
    }

    public function modificarMedida(string $descripcion, string $medida, string $tamCaja, int $id)
    {
        $this->descripcion = $descripcion;
        $this->medida = $medida;
        $this->tamCaja = $tamCaja;
        $this->id = $id;

        $sql = "UPDATE medidas SET descripcion = ?, medida = ?, tamCaja = ? WHERE id = ?";
        $datos = array($this->descripcion, $this->medida, $this->tamCaja, $this->id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
        }else {
            $res = "error";
        }
        
        return $res;
    }

    public function editarMed(int $id)
    {
        $sql = "SELECT * FROM medidas WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }

    public function eliminarMed(int $id)
    {
        $this->id = $id;
        $sql = "DELETE FROM medidas WHERE id = ?";
        $datos = array($this->id);
        $data = $this->save($sql, $datos);
        return $data;

    }
}