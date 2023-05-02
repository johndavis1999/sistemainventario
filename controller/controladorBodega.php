<?php
    // Definición de la clase ControladorBodega
    class controladorBodega{
        // Atributos de la clase
        private $model;
        
        // Constructor de la clase
        public function __construct()
        {
            // Se importa el archivo Bodega.php que contiene la clase Bodega
            require_once("c://xampp/htdocs/sistemainventario/model/Bodega.php");
            // Se instancia la clase Bodega
            $this->model = new Bodega();
        }
        
        // Método para guardar una nueva bodega
        public function guardar($nombre, $direccion, $estado){
            // Se inserta la bodega y se guarda su id en una variable
            $id = $this->model->insertar($nombre, $direccion, $estado);
            // Se redirecciona a la página de inicio
            return header("Location:index.php");
        }
        
        // Método para mostrar una bodega
        public function show($id){
            // Si la bodega existe, se retorna su información, de lo contrario se redirecciona a la página de inicio
            return ($this->model->show($id) != false) ? $this->model->show($id) : header("Location:index.php");
        }
        
        // Método para mostrar el listado de bodegas
        public function index(){
            // Si existen bodegas, se retorna el listado de las mismas, de lo contrario se retorna false
            return ($this->model->index()) ? $this->model->index() : false;
        }
        
        // Método para actualizar los datos de una bodega
        public function update($id, $nombre, $direccion, $estado) {
            // Se actualizan los datos de la bodega
            $result = $this->model->update($id, $nombre, $direccion, $estado);
            // Se redirecciona a la página de inicio
            return header("Location:index.php");
        }
        
        // Método para eliminar una bodega
        public function delete($id){
            // Si se eliminó la bodega, se redirecciona a la página de inicio, de lo contrario se redirecciona a la página de la bodega eliminada
            return ($this->model->delete($id)) ? header("Location:index.php") : header("Location:show.php?id=".$id) ;
        }
    }
?>