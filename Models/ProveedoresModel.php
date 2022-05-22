<?php
class ProveedoresModel extends Query
{
    private $nombre, $id;

    public function __construct()
    {
        parent:: __construct();
    }

    public function getProveedores()
    {
        $sql = "SELECT * FROM proveedores";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function registrarProveedor(string $nombre)
    {
        $this->nombre = $nombre;
        
        $verificar = "SELECT * FROM proveedores WHERE nombre = '$this->nombre'";
        $existe = $this->select($verificar);

        if (empty($existe)) {
            
            $sql = "INSERT INTO proveedores(nombre) VALUES (?)";
            $datos = array($this->nombre);

            $data = $this->save($sql, $datos);

            if ($data == 1) {
                $res = "ok";
            }else{
                $res = "error";
            }
        } else {
            $res = "existe";
        }
        
        return $res;
    }

    public function editarProv(int $id)
    {
        $sql = "SELECT * FROM proveedores WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }

    public function modificarProveedor(string $nombre, int $id)
    {
        $this->nombre = $nombre;
        $this->id = $id;

        $sql = "UPDATE proveedores SET nombre = ? WHERE id = ?";
        $datos = array($this->nombre, $this->id);
        $data = $this->save($sql, $datos);

        if ($data == 1) {
            $res = "modificado";
        }else{
            $res = "error";
        }

        return $res;
    }

    public function eliminarProv(int $id)
    {
        $this->id = $id;
        $sql = "DELETE FROM proveedores WHERE id = ?";
        $datos = array($this->id);
        $data = $this->save($sql, $datos);
        return $data;
    }

    public function getDatos(int $id)
    {
        $sql = "SELECT * FROM proveedores WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }
}
?>
