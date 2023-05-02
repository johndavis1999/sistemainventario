<?php
    class Ingreso{
        private $PDO;
        //Atributos factura
        private $id_jefebodega; // ID del jefe de bodega que realiza el ingreso
        private $estado; // Estado del recibo de ingreso (pendiente, aprobado, rechazado, etc.)
        private $id_pedido; // ID del pedido asociado al recibo de ingreso (en caso de que exista)
        private $id_bodega; // ID de la bodega donde se realiza el ingreso
        //atributos detalle
        private $id_ingreso; // ID del ingreso
        private $id_recibo_ingreso; // ID del recibo de ingreso al que pertenece el detalle
        private $id_producto; // ID del producto que se ingresa
        private $cantidad_ingreso; // Cantidad de unidades del producto que se ingresa

        public function __construct()
        {
            require_once("c://xampp/htdocs/sistemainventario/config/config.php");
            $con = new config();
            $this->PDO = $con->conexion();
        }
        
        /**
         * Obtiene todos los recibos de ingreso registrados en la base de datos, junto con información adicional
         * de las tablas jefebodega y bodega (nombre y apellido del jefe de bodega, y nombre de la bodega).
         *
         *Retorna un array de registros con la información de los recibos de ingreso, o false si no hay registros.
         */
        
        /*public function index(){
            $statement = $this->PDO->prepare("SELECT ri.*, jb.nombre AS nombre_jefe, jb.apellido AS apellido_jefe, 
                                                            b.nombre AS nombre_bodega 
                                                            FROM recibo_ingreso ri 
                                                            LEFT JOIN jefebodega jb ON ri.id_jefebodega = jb.id 
                                                            LEFT JOIN bodega b ON ri.id_bodega = b.id");
            return ($statement->execute()) ? $statement->fetchAll() : false;
        }*/
        
        public function index(){
            $statement = $this->PDO->prepare("SELECT ri.*, jb.nombre AS nombre_jefe, jb.apellido AS apellido_jefe, 
                                                            b.nombre AS nombre_bodega 
                                                            FROM recibo_ingreso ri 
                                                            LEFT JOIN jefebodega jb ON ri.id_jefebodega = jb.id 
                                                            LEFT JOIN bodega b ON ri.id_bodega = b.id
                                                            WHERE ri.estado != 1000");
            return ($statement->execute()) ? $statement->fetchAll() : false;
        }

        public function guardarIngreso($POST) {
            // Se asignan los valores del formulario a los atributos de la clase
            $this->id_jefebodega = $POST['id_jefebodega'];
            $this->estado = $POST['estado'];
            $this->id_pedido = $POST['id_pedido'];
            $this->id_bodega = $POST['id_bodega'];
        
            // Se prepara la consulta para insertar un nuevo ingreso en la tabla "recibo_ingreso"
            $stament = $this->PDO->prepare("INSERT INTO recibo_ingreso (id_jefebodega, estado, id_pedido, id_bodega) 
                                            VALUES (:id_jefebodega, :estado, :id_pedido, :id_bodega)");
            // Se asignan los valores de los atributos de la clase a los parámetros de la consulta
            $stament->bindParam(':id_jefebodega', $this->id_jefebodega);
            $stament->bindParam(':estado', $this->estado);
            $stament->bindParam(':id_pedido', $this->id_pedido);
            $stament->bindParam(':id_bodega', $this->id_bodega);
            // Se ejecuta la consulta
            $stament->execute();
            // Se obtiene el último ID insertado en la tabla "recibo_ingreso"
            $lastInsertId = $this->PDO->lastInsertId();
            // Se llama a la función "guardarDetalleIngreso" para insertar los detalles del ingreso
            $this->guardarDetalleIngreso($lastInsertId, $POST);
            // Se llama a la función "aumentarStockProductos" para aumentar el stock de los productos
            $this->aumentarStockProductos($lastInsertId);
            // Se devuelve el último ID insertado en la tabla "recibo_ingreso"
            return $lastInsertId;
        }

        /**
         * Función que se encarga de guardar los detalles de un ingreso en la tabla detalle_ingreso.
         * Recibe como parámetros el último ID insertado en la tabla recibo_ingreso y el array $POST.
         * $POST contiene los datos necesarios para guardar los detalles del ingreso, como el id_producto y la cantidad_ingreso.
         */
        private function guardarDetalleIngreso($lastInsertId, $POST) {
            // Recorremos los detalles de ingreso y los guardamos en la base de datos
            for ($i = 0; $i < count($POST['id_producto']); $i++) {
                $statement = $this->PDO->prepare("INSERT INTO detalle_ingreso (id_recibo_ingreso, id_producto, cantidad_ingreso) 
                                VALUES (:id_recibo_ingreso, :id_producto, :cantidad_ingreso)");
                // Asignamos los valores a los parámetros
                $statement->bindParam(':id_recibo_ingreso', $lastInsertId);
                $statement->bindParam(':id_producto', $POST['id_producto'][$i]);
                $statement->bindParam(':cantidad_ingreso', $POST['cantidad_ingreso'][$i]);
                // Ejecutamos la consulta
                $statement->execute();
            }
        }


        private function aumentarStockProductos($id_recibo_ingreso) {
            // Selecciona los productos y las cantidades que se ingresaron en el recibo de ingreso
            $statement = $this->PDO->prepare("SELECT id_producto, cantidad_ingreso FROM detalle_ingreso WHERE id_recibo_ingreso = :id_recibo_ingreso");
            $statement->bindParam(':id_recibo_ingreso', $id_recibo_ingreso);
            $statement->execute();
            $detalle_ingreso = $statement->fetchAll();
            
            // Incrementa el stock de cada producto ingresado capturando 'cantidad_ingreso' de cada producto
            foreach ($detalle_ingreso as $detalle) {
                $statement = $this->PDO->prepare("UPDATE producto SET stock = stock + :cantidad_ingreso WHERE id = :id_producto");
                $statement->bindParam(':cantidad_ingreso', $detalle['cantidad_ingreso']);
                $statement->bindParam(':id_producto', $detalle['id_producto']);
                $statement->execute();
            }
        }
        
        public function deleteIngreso($id_ingreso){

            // Se incluye el archivo de configuración para obtener la conexión a la base de datos
            require_once("c://xampp/htdocs/sistemainventario/config/config.php");
            $con = new config();
            $PDO = $con->conexion();
        
            // Se prepara la consulta para eliminar el recibo de ingreso correspondiente
            $stament = $PDO->prepare("DELETE FROM recibo_ingreso WHERE id_ingreso = :id_ingreso");
            $stament->bindParam(":id_ingreso",$id_ingreso);
        
            // Se verifica si se ejecutó correctamente la consulta para eliminar el recibo de ingreso
            if ($stament->execute()) {
        
                // Si se eliminó el recibo de ingreso se procede a reversar el stock de los productos correspondientes
                // llamando a la función reversarStockProductos()
                $this->reversarStockProductos($id_ingreso, $PDO);
        
                // Se eliminan los detalles del recibo de ingreso correspondiente llamando a la función deleteIngresoDetalle()
                $this->deleteIngresoDetalle($id_ingreso, $PDO);
        
                return true;
            } else {
                return false;
            }
        }
        
        public function deleteIngresoLogico($id_ingreso){
            // Se incluye el archivo de configuración para obtener la conexión a la base de datos
            require_once("c://xampp/htdocs/sistemainventario/config/config.php");
            $con = new config();
            $PDO = $con->conexion();
            // Se prepara la consulta para eliminar el recibo de ingreso correspondiente
            $stament = $PDO->prepare("UPDATE recibo_ingreso SET estado = 1000 WHERE id_ingreso = :id_ingreso");
            $stament->bindParam(":id_ingreso",$id_ingreso);
            $this->reversarStockProductos($id_ingreso, $PDO);
    
            // Se eliminan los detalles del recibo de ingreso correspondiente llamando a la función deleteIngresoDetalle()
            $this->deleteIngresoDetalle($id_ingreso, $PDO);
            // Se verifica si se ejecutó correctamente la consulta para eliminar el recibo de ingreso
            if ($stament->execute()) {
                return true;
            } else {
                return false;
            }
        }
        
        /*

        Revierte el stock de los productos asociados a un recibo de ingreso

        Resta las cantidades del ingreso al stock de cada producto

        int $id_recibo_ingreso ID del recibo de ingreso asociado a los productos

        PDO $PDO Objeto PDO para la conexión a la base de datos
        */
        private function reversarStockProductos($id_recibo_ingreso, $PDO) {
            // Selecciona los detalles de ingreso asociados a este recibo
            $statement = $PDO->prepare("SELECT id_producto, cantidad_ingreso FROM detalle_ingreso WHERE id_recibo_ingreso = :id_recibo_ingreso");
            $statement->bindParam(':id_recibo_ingreso', $id_recibo_ingreso);
            $statement->execute();
            $detalle_ingreso = $statement->fetchAll();
            
            // Recorre los detalles de ingreso y resta las cantidades al stock de cada producto
            foreach ($detalle_ingreso as $detalle) {
            $statement = $this->PDO->prepare("UPDATE producto SET stock = stock - :cantidad_ingreso WHERE id = :id_producto");
            $statement->bindParam(':cantidad_ingreso', $detalle['cantidad_ingreso']);
            $statement->bindParam(':id_producto', $detalle['id_producto']);
            $statement->execute();
            }
        }
        
        
        /*

        Función encargada de eliminar los detalles de un recibo de ingreso específico en la base de datos.
        int $id_recibo_ingreso Identificador del recibo de ingreso del cual se eliminarán los detalles.
        PDO $PDO Objeto PDO para la conexión a la base de datos.
        */
        public function deleteIngresoDetalle($id_recibo_ingreso, $PDO){
            // Se prepara la sentencia SQL para eliminar los detalles del recibo de ingreso en la tabla detalle_ingreso.
            $stament = $PDO->prepare("
            DELETE FROM detalle_ingreso
            WHERE id_recibo_ingreso = :id_recibo_ingreso");
            // Se vincula el parámetro :id_recibo_ingreso con el valor del identificador del recibo de ingreso a eliminar.
            $stament->bindParam(":id_recibo_ingreso",$id_recibo_ingreso);
            // Se ejecuta la sentencia SQL preparada y se verifica si se eliminaron los detalles correctamente.
            if ($stament->execute()) {
                return true;
            } else {
                return false;
            }
        }

        
        
        public function getIngreso($id_ingreso){
            $statement = $this->PDO->prepare("SELECT ri.*, jb.nombre AS nombre_jefe, jb.apellido AS apellido_jefe, jb.cedula AS cedula, 
                                                b.nombre AS nombre_bodega
                                                FROM recibo_ingreso ri 
                                                LEFT JOIN jefebodega jb ON ri.id_jefebodega = jb.id 
                                                LEFT JOIN bodega b ON ri.id_bodega = b.id
                                                WHERE id_ingreso  = :id_ingreso ");
            $statement->bindParam(":id_ingreso",$id_ingreso);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        }

        public function getIngresoItems($id_ingreso){
            $statement = $this->PDO->prepare("SELECT d.*, p.nombre 
                                                FROM detalle_ingreso d 
                                                LEFT JOIN producto p ON d.id_producto = p.id 
                                                WHERE d.id_recibo_ingreso = :id_recibo_ingreso");
            $statement->bindParam(":id_recibo_ingreso", $id_ingreso);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function updateIng($POST){
            $con = new config();
            $PDO = $con->conexion();
            $this->id_jefebodega = $POST['id_jefebodega'];
            $this->estado = $POST['estado'];
            $this->id_pedido = $POST['id_pedido'];
            $this->id_bodega = $POST['id_bodega'];
            $id_ingreso = $POST['id_ingreso'];
            // Preparar la consulta SQL para actualizar la cotización en la base de datos
            $stament = $this->PDO->prepare("UPDATE recibo_ingreso SET 
                id_jefebodega = :id_jefebodega, estado = :estado, id_pedido = :id_pedido, id_bodega = :id_bodega
                WHERE id_ingreso = :id_ingreso");
            // Vincular los parámetros con los valores correspondientes
            $stament->bindParam(':id_jefebodega', $POST['id_jefebodega']);
            $stament->bindParam(':estado', $POST['estado']);
            $stament->bindParam(':id_pedido', $POST['id_pedido']);
            $stament->bindParam(':id_bodega', $POST['id_bodega']);
            $stament->bindParam(':id_ingreso', $id_ingreso);
            $this->reversarStockProductos($id_ingreso, $PDO);
            $this->deleteIngresoDetalle($id_ingreso, $PDO);
            $lastInsertId = $id_ingreso;
            // Ejecutar la consulta SQL
            $stament->execute(); 
            //seccion para manipular detalles
            for ($i = 0; $i < count($POST['id_producto']); $i++) {
                $stament = $this->PDO->prepare("INSERT INTO detalle_ingreso (id_recibo_ingreso, id_producto, cantidad_ingreso) 
                VALUES (". $POST['id_ingreso'] .", '" . $POST['id_producto'][$i] . "', '" . $POST['cantidad_ingreso'][$i] . "')");
                $stament->execute();
            }
            $this->aumentarStockProductos($lastInsertId);
        }
    }
?>