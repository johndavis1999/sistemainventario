<?php
    class controlPedido{
        private $model;

        // Constructor de la clase, que inicializa el modelo necesario
        public function __construct()
        {
            require_once("c://xampp/htdocs/sistemainventario/model/Pedidos.php");
            $this->model = new Pedido();
        }

        // Función para obtener el listado de todos los pedidos
        public function index(){
            return ($this->model->index()) ? $this->model->index() : false;
        }
    }
?>
