<?php
class CambioPassModel extends Query{
    private $usuario, $hash1;

    public function __construct()
    {
        parent:: __construct();
    }

    public function getUsuario(int $id_usuario, $hash1)
    {           
        $sql = "SELECT * FROM usuarios WHERE id = '$id_usuario' AND clave = '$hash1'";
        $data = $this->select($sql);
        return $data;
    }

    public function cambioContra(string $hash3, int $id)
    {
        $this->hash3 = $hash3;
        $this->id = $id;


        $sql = "UPDATE usuarios SET clave = ? WHERE id = ?";
        $datos = array($this->hash3, $this->id);
        $data = $this->save($sql, $datos);

        if ($data == 1) {
            $res = "modificada";
        }else{
            $res = "error";
        }

        return $res;

    }
}