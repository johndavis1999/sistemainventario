<?php
    class controladorEgreso{
        private $model;
        public function __construct()
        {
            require_once("c://xampp/htdocs/sistemainventario/model/egreso.php");
            // Se requiere el archivo que contiene la clase "Egreso"
            $this->model = new Egreso();
            // Se crea una nueva instancia de la clase "Egreso"
        }
        public function index(){
            return ($this->model->index()) ? $this->model->index() : false;
            // Si el método "index" del modelo retorna un valor distinto a false, se retorna ese valor. En caso contrario, se retorna false.
        }
        
        public function guardarEgreso($id_jefebodega, $estado, $id_factura, $id_bodega){
            $POST = array(
                'id_jefebodega' => $id_jefebodega,
                'estado' => $estado,
                'id_factura' => $id_factura,
                'id_bodega' => $id_bodega,
                'id_producto' => $_POST['id_producto'],
                'cantidad_egreso' => $_POST['cantidad_egreso']
            );
            if($_POST['id_producto']== null){
                header("Location:error1.php");
            }else{
                
            // Se crea un arreglo con los datos que se van a guardar en el egreso
            $this->model->guardarEgreso($POST);
            // Se llama al método "guardarEgreso" del modelo, pasándole el arreglo de datos
            return header("Location:reciboegreso.php");
            // Se redirige al usuario a la página "reciboegreso.php"
            }
        }

        public function getEgreso($id_egreso){
            // Devuelve el resultado de la consulta
            return $this->model->getEgreso($id_egreso);
        }

        public function getEgresoItems($id_egreso){
            // Devuelve el resultado de la consulta
            return $this->model->getEgresoItems($id_egreso);
        }

        // Método deleteEgreso
        public function deleteEgreso($id_recibo_egreso){
            // Si el método deleteEgreso de la clase Ingreso devuelve true, se redirecciona al usuario a la página reciboegreso.php, sino se redirecciona al usuario a la misma página
            return ($this->model->deleteEgreso($id_recibo_egreso)) ? header("Location:reciboegreso.php") : header("Location:reciboegreso.php") ;
        }

        // Método deleteEgresoLogico
        public function deleteEgresoLogico($id_recibo_egreso){
            // Si el método deleteEgresoLogico de la clase Ingreso devuelve true, se redirecciona al usuario a la página reciboegreso.php, sino se redirecciona al usuario a la misma página
            return ($this->model->deleteEgresoLogico($id_recibo_egreso)) ? header("Location:reciboegreso.php") : header("Location:reciboegreso.php") ;
        }

        public function updateEgr($id_egreso, $id_jefebodega, $estado, $id_factura, $id_bodega){
            // Creando un array POST con los datos actualizados de la cotización y el producto
            $POST = array(
                'id_egreso' => $id_egreso,
                'id_jefebodega' => $id_jefebodega,
                'estado' => $estado,
                'id_factura' => $id_factura,
                'id_bodega' => $id_bodega,
                'id_producto' => $_POST['id_producto'],
                'cantidad_egreso' => $_POST['cantidad_egreso']
            );
            if(($_POST['id_producto'] == null)&&($_POST['cantidad_egreso']==null)){
                header("Location:edit_egreso.php?id_egreso=$id_egreso");
                exit;
            } else {
                $this->model->updateEgr($POST);
                return header("Location:reciboegreso.php");
            }
        }
    }
?>
