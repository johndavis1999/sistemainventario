<?php
    class controladorProducto{
        private $model;
        public function __construct()
        {
            // Incluye el archivo que contiene la clase Producto
            require_once("c://xampp/htdocs/sistemainventario/model/Producto.php");
            // Crea una instancia de la clase Producto
            $this->model = new Producto();
        }
        public function guardar($nombre, $precio, $stock, $estado, $marca, $idTipo, $codigo){
            // Inserta un nuevo producto en la base de datos
            $id = $this->model->insertar($nombre, $precio, $stock, $estado, $marca, $idTipo, $codigo);
            // Redirige a la página principal
            return header("Location:index.php");
        }
        public function index(){
            // Muestra todos los productos en la base de datos
            return ($this->model->index()) ? $this->model->index() : false;
        }
        public function update($id, $nombre, $precio, $stock, $estado, $marca, $idTipo, $codigo) {
            // Actualiza un producto existente en la base de datos
            $result = $this->model->update($id, $nombre, $precio, $stock, $estado, $marca, $idTipo, $codigo);
            // Redirige a la página principal
            return header("Location:index.php");
        }
        public function delete($id){
            // Elimina un producto existente de la base de datos
            return ($this->model->delete($id)) ? header("Location:index.php") : header("Location:show.php?id=".$id) ;
        }
    }
?>
