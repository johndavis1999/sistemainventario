<?php
    // Definición de la clase controladorIngreso
    class controladorIngreso{
        // Atributos
        private $model;

        // Constructor
        public function __construct()
        {
            // Se requiere el archivo de la clase Ingreso
            require_once("c://xampp/htdocs/sistemainventario/model/ingreso.php");
            // Se crea una instancia de la clase Ingreso
            $this->model = new Ingreso();
        }

        // Método index
        public function index(){
            // Si el método index de la clase Ingreso devuelve true, se devuelve el resultado, sino se devuelve false
            return ($this->model->index()) ? $this->model->index() : false;
        }
        
        // Método guardarIngreso
        public function guardarIngreso($id_jefebodega, $estado, $id_pedido, $id_bodega){
            // Se define un arreglo POST con los valores necesarios para guardar un ingreso
            $POST = array(
                'id_jefebodega' => $id_jefebodega,
                'estado' => $estado,
                'id_pedido' => $id_pedido,
                'id_bodega' => $id_bodega,
                'id_producto' => $_POST['id_producto'],
                'cantidad_ingreso' => $_POST['cantidad_ingreso']
            );
            if(($_POST['id_producto']==null)&&($_POST['cantidad_ingreso']==null)){
                return header("Location:error1.php");
            }else{
                // Se llama al método guardarIngreso de la clase Ingreso con el arreglo POST como parámetro
                $this->model->guardarIngreso($POST);
                // Se redirecciona al usuario a la página de reciboingreso.php
                return header("Location:reciboingreso.php");
            }
        }
        
        // Método deleteIngreso
        public function deleteIngreso($id_recibo_ingreso){
            // Si el método deleteIngreso de la clase Ingreso devuelve true, se redirecciona al usuario a la página reciboingreso.php, sino se redirecciona al usuario a la misma página
            return ($this->model->deleteIngreso($id_recibo_ingreso)) ? header("Location:reciboingreso.php") : header("Location:reciboingreso.php") ;
        }
        
        // Método deleteIngresoLogico
        public function deleteIngresoLogico($id_recibo_ingreso){
            // Si el método deleteIngresoLogico de la clase Ingreso devuelve true, se redirecciona al usuario a la página reciboingreso.php, sino se redirecciona al usuario a la misma página
            return ($this->model->deleteIngresoLogico($id_recibo_ingreso)) ? header("Location:reciboingreso.php") : header("Location:reciboingreso.php") ;
        }

        public function getIngreso($id_ingreso){
            // Devuelve el resultado de la consulta
            return $this->model->getIngreso($id_ingreso);
        }

        public function getIngresoItems($id_ingreso){
            // Devuelve el resultado de la consulta
            return $this->model->getIngresoItems($id_ingreso);
        }
        public function updateIng($id_ingreso, $id_jefebodega, $estado, $id_pedido, $id_bodega){
            // Creando un array POST con los datos actualizados de la cotización y el producto
            $POST = array(
                'id_ingreso' => $id_ingreso,
                'id_jefebodega' => $id_jefebodega,
                'estado' => $estado,
                'id_pedido' => $id_pedido,
                'id_bodega' => $id_bodega,
                'id_producto' => $_POST['id_producto'],
                'cantidad_ingreso' => $_POST['cantidad_ingreso']
            );
            if(($_POST['id_producto'] == null)&&($_POST['cantidad_ingreso']==null)){
                header("Location:edit_ingreso.php?id_ingreso=$id_ingreso");
                exit;
            } else {
                $this->model->updateIng($POST);
                return header("Location:reciboingreso.php");
            }
        }
    }
?>
