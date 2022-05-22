<?php
class ClientesModel extends Query{
    private $nombre, $id;
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

    public function registrarCliente(string $nombre)
    {
        $this->nombre = $nombre;

        $verificar = "SELECT * FROM clientes WHERE nombre = '$this->nombre'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            
        $sql = "INSERT INTO clientes(nombre) VALUES (?)";
        $datos = array($this->nombre);

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

    public function modificarCliente(string $nombre, int $id)
    {
        $this->nombre = $nombre;
        $this->id = $id;

        $sql = "UPDATE clientes SET nombre = ? WHERE id = ?";
        $datos = array($this->nombre, $this->id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
        }else {
            $res = "error";
        }
        
        return $res;
    }

    public function editarCli(int $id)
    {
        $sql = "SELECT * FROM clientes WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }

    public function eliminarCli(int $id)
    {
        $this->id = $id;
        $sql = "DELETE FROM clientes WHERE id = ?";
        $datos = array($this->id);
        $data = $this->save($sql, $datos);
        return $data;

    }
}