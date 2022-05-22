<?php
class UsuariosModel extends Query{
    private $usuario, $nombre, $clave, $id_estacion, $id;
    public function __construct()
    {
        parent:: __construct();
    }

    public function getUsuario(string $usuario, string $clave)
    {
        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND clave = '$clave'";
        $data = $this->select($sql);
        return $data;

    }

    public function getEstaciones()
    {
        $sql = "SELECT * FROM estacion";
        $data = $this->selectAll($sql);
        return $data;

    }

    public function getUsuarios()
    {
        $sql = "SELECT u.*, e.id AS id_estacion, e.estacion FROM usuarios u INNER JOIN estacion e WHERE u.id_estacion = e.id";
        $data = $this->selectAll($sql);
        return $data;

    }

    public function registrarUsuario(string $usuario, string $nombre, string $clave, int $id_estacion)
    {
        $this->usuario = $usuario;
        $this->nombre = $nombre;
        $this->clave = $clave;
        $this->id_estacion = $id_estacion;

        $verificar = "SELECT * FROM usuarios WHERE usuario = '$this->usuario'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            
        $sql = "INSERT INTO usuarios(usuario, nombre, clave, id_estacion) VALUES (?,?,?,?)";
        $datos = array($this->usuario, $this->nombre, $this->clave, $this->id_estacion);

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

    public function modificarUsuario(string $usuario, string $nombre, int $id_estacion, int $id)
    {
        $this->usuario = $usuario;
        $this->nombre = $nombre;
        $this->id = $id;
        $this->id_estacion = $id_estacion;

        $sql = "UPDATE usuarios SET usuario = ?, nombre = ?, id_estacion = ? WHERE id = ?";
        $datos = array($this->usuario, $this->nombre, $this->id_estacion, $this->id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
        }else {
            $res = "error";
        }
        
        return $res;
    }

    public function editarUser(int $id)
    {
        $sql = "SELECT * FROM usuarios WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }

    public function eliminarUser(int $id)
    {
        $this->id = $id;
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $datos = array($this->id);
        $data = $this->save($sql, $datos);
        return $data;

    }
}