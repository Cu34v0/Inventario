<?php

class Home extends Controller
{
    public function __construct()
    {
        session_start();

        if (!empty($_SESSION['activo'])) {
            header('Location: ' . base_url . "Usuarios");
        }
        parent::__construct();
    }
    public function index()
    {
        $this->views->getView($this, "index");
    }
}
