<?php
class EstacionesModel extends Query{
    private $estacion, $id;
    public function __construct()
    {
        parent:: __construct();
    }


    public function getEstaciones()
    {
        $sql = "SELECT * FROM estacion";
        $data = $this->selectAll($sql);
        return $data;

    }

    public function registrarEstacion(string $estacion)
    {
        $this->estacion = $estacion;

        $verificar = "SELECT * FROM estacion WHERE estacion = '$this->estacion'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            
        $sql = "INSERT INTO estacion(estacion) VALUES (?)";
        $datos = array($this->estacion);

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

    public function modificarEstacion(string $estacion, int $id)
    {
        $this->estacion = $estacion;
        $this->id = $id;

        $sql = "UPDATE estacion SET estacion = ? WHERE id = ?";
        $datos = array($this->estacion, $this->id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
        }else {
            $res = "error";
        }
        
        return $res;
    }

    public function editarEst(int $id)
    {
        $sql = "SELECT * FROM estacion WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }

    public function eliminarEst(int $id)
    {
        $this->id = $id;
        $sql = "DELETE FROM estacion WHERE id = ?";
        $datos = array($this->id);
        $data = $this->save($sql, $datos);
        return $data;

    }
}