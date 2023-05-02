<?php
    class controlFactura{
        private $model;

        // Constructor de function que carga el modelo Factura
        public function __construct()
        {
            require_once("c://xampp/htdocs/sistemainventario/model/Factura.php");
            $this->model = new Factura();
        }

        // funcion index que  devuelve todos los datos de Factura
        public function index(){
            return ($this->model->index()) ? $this->model->index() : false;
        }
    }
?>
