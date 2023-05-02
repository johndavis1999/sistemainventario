<?php
    // Definición de la clase controladorTipo
    class controladorTipo{
        private $model;
        // Constructor de la clase que incluye el archivo de la clase Tipo y crea una instancia de la misma
        public function __construct()
        {
            require_once("c://xampp/htdocs/sistemainventario/model/Tipo.php");
            $this->model = new Tipo();
        }
        // Función para guardar un nuevo tipo de producto en la base de datos
        public function guardar($descripcion){
            $id = $this->model->insertar($descripcion);
            return header("Location:index.php");
        }
        // Función para obtener todos los tipos de productos de la base de datos
        public function index(){
            return ($this->model->index()) ? $this->model->index() : false;
        }
    }
?>