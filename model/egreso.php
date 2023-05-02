<?php
    class Egreso{
        private $PDO;
        //Atributos factura
        private $id_jefebodega;
        private $estado;
        private $id_factura;
        private $id_bodega;
        //atributos detalle
        private $id_egreso;
        private $id_recibo_egreso;
        private $id_producto;
        private $cantidad_egreso;

        public function __construct()
        {
            require_once("c://xampp/htdocs/sistemainventario/config/config.php");
            $con = new config();
            $this->PDO = $con->conexion();
        }
        
        /*public function index(){
            $statement = $this->PDO->prepare("SELECT re.*, jb.nombre AS nombre_jefe, jb.apellido AS apellido_jefe, 
                                                            b.nombre AS nombre_bodega 
                                                            FROM recibo_egreso re 
                                                            LEFT JOIN jefebodega jb ON re.id_jefebodega = jb.id 
                                                            LEFT JOIN bodega b ON re.id_bodega = b.id");
            return ($statement->execute()) ? $statement->fetchAll() : false;
        }*/
        
        public function index(){
            $statement = $this->PDO->prepare("SELECT re.*, jb.nombre AS nombre_jefe, jb.apellido AS apellido_jefe, 
                                                            b.nombre AS nombre_bodega 
                                                            FROM recibo_egreso re 
                                                            LEFT JOIN jefebodega jb ON re.id_jefebodega = jb.id 
                                                            LEFT JOIN bodega b ON re.id_bodega = b.id
                                                            WHERE re.estado != 1000");
            return ($statement->execute()) ? $statement->fetchAll() : false;
        }
        
        public function guardarEgreso($POST) {
            $this->id_jefebodega = $POST['id_jefebodega'];
            $this->estado = $POST['estado'];
            $this->id_factura = $POST['id_factura'];
            $this->id_bodega = $POST['id_bodega'];
            $id_producto = $POST['id_producto'];
            $cantidad_egreso = $POST['cantidad_egreso'];
        
            if($this->validarStockProducto($id_producto, $cantidad_egreso) == true){
                $stament = $this->PDO->prepare("INSERT INTO recibo_egreso (id_jefebodega, estado, id_factura, id_bodega) 
                            VALUES (:id_jefebodega, :estado, :id_factura, :id_bodega)");
                $stament->bindParam(':id_jefebodega', $this->id_jefebodega);
                $stament->bindParam(':estado', $this->estado);
                $stament->bindParam(':id_factura', $this->id_factura);
                $stament->bindParam(':id_bodega', $this->id_bodega);
                $stament->execute();
                $lastInsertId = $this->PDO->lastInsertId();
                $this->guardarDetalleEgreso($lastInsertId, $POST);
                $this->restarStockProductos($lastInsertId);
                return $lastInsertId;
            } else {
                header("Location:error_egreso.php");
                exit();
            }
        }
        
        
        public function validarStockProducto($id_productos, $cantidades_egreso) {
            $validacion_exitosa = true;
            for ($i = 0; $i < count($id_productos); $i++) {
                $id_producto = $id_productos[$i];
                $cantidad_egreso = $cantidades_egreso[$i];
                
                $statement = $this->PDO->prepare("SELECT stock FROM producto WHERE id=:id_producto");
                $statement->bindParam(':id_producto', $id_producto);
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_ASSOC);
                $stock = $result['stock'];
                
                if ($cantidad_egreso >= $stock) {
                    $validacion_exitosa = false;
                    break;
                }
            }
            return $validacion_exitosa;
        }
        
        
        
        
        

        private function guardarDetalleEgreso($lastInsertId, $POST) {
            for ($i = 0; $i < count($POST['id_producto']); $i++) {
                $statement = $this->PDO->prepare("INSERT INTO detalle_egreso (id_recibo_egreso, id_producto, cantidad_egreso) 
                                VALUES (:id_recibo_egreso, :id_producto, :cantidad_egreso)");
                $statement->bindParam(':id_recibo_egreso', $lastInsertId);
                $statement->bindParam(':id_producto', $POST['id_producto'][$i]);
                $statement->bindParam(':cantidad_egreso', $POST['cantidad_egreso'][$i]);
                $statement->execute();
            }
        }

        private function restarStockProductos($id_recibo_egreso) {
            $statement = $this->PDO->prepare("SELECT id_producto, cantidad_egreso FROM detalle_egreso WHERE id_recibo_egreso = :id_recibo_egreso");
            $statement->bindParam(':id_recibo_egreso', $id_recibo_egreso);
            $statement->execute();
            $detalle_egreso = $statement->fetchAll();
            
            foreach ($detalle_egreso as $detalle) {
                $statement = $this->PDO->prepare("UPDATE producto SET stock = stock - :cantidad_egreso WHERE id = :id_producto");
                $statement->bindParam(':cantidad_egreso', $detalle['cantidad_egreso']);
                $statement->bindParam(':id_producto', $detalle['id_producto']);
                $statement->execute();
            }
        }
        
        private function aumentarStockProductos($id_recibo_egreso) {
            $statement = $this->PDO->prepare("SELECT id_producto, cantidad_egreso FROM detalle_egreso WHERE id_recibo_egreso = :id_recibo_egreso");
            $statement->bindParam(':id_recibo_egreso', $id_recibo_egreso);
            $statement->execute();
            $detalle_egreso = $statement->fetchAll();
            
            foreach ($detalle_egreso as $detalle) {
                $statement = $this->PDO->prepare("UPDATE producto SET stock = stock + :cantidad_egreso WHERE id = :id_producto");
                $statement->bindParam(':cantidad_egreso', $detalle['cantidad_egreso']);
                $statement->bindParam(':id_producto', $detalle['id_producto']);
                $statement->execute();
            }
        }
        
        public function getEgreso($id_egreso){
            $statement = $this->PDO->prepare("SELECT re.*, jb.nombre AS nombre_jefe, jb.apellido AS apellido_jefe, jb.cedula AS cedula, 
                                                b.nombre AS nombre_bodega
                                                FROM recibo_egreso re 
                                                LEFT JOIN jefebodega jb ON re.id_jefebodega = jb.id 
                                                LEFT JOIN bodega b ON re.id_bodega = b.id
                                                WHERE id_egreso  = :id_egreso");
            $statement->bindParam(":id_egreso",$id_egreso);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        }

        public function getEgresoItems($id_egreso){
            $statement = $this->PDO->prepare("SELECT de.*, p.nombre
                                                FROM detalle_egreso de
                                                LEFT JOIN producto p ON de.id_producto = p.id
                                                WHERE de.id_recibo_egreso = :id_recibo_egreso");
            $statement->bindParam(":id_recibo_egreso", $id_egreso);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function deleteEgresoLogico($id_egreso){
            // Se incluye el archivo de configuración para obtener la conexión a la base de datos
            require_once("c://xampp/htdocs/sistemainventario/config/config.php");
            $con = new config();
            $PDO = $con->conexion();
            // Se prepara la consulta para eliminar el recibo de ingreso correspondiente
            $stament = $PDO->prepare("UPDATE recibo_egreso SET estado = 1000 WHERE id_egreso = :id_egreso");
            $stament->bindParam(":id_egreso",$id_egreso);
            // Se verifica si se ejecutó correctamente la consulta para eliminar el recibo de ingreso
            if ($stament->execute()) {
                return true;
            } else {
                return false;
            }
        }
        
        public function updateEgr($POST){
            $con = new config();
            $PDO = $con->conexion();
            $this->id_jefebodega = $POST['id_jefebodega'];
            $this->estado = $POST['estado'];
            $this->id_factura = $POST['id_factura'];
            $this->id_bodega = $POST['id_bodega'];
            $id_egreso = $POST['id_egreso'];
            // Preparar la consulta SQL para actualizar la cotización en la base de datos
            $stament = $this->PDO->prepare("UPDATE recibo_egreso SET 
                id_jefebodega = :id_jefebodega, estado = :estado, id_factura = :id_factura, id_bodega = :id_bodega
                WHERE id_egreso = :id_egreso");
            // Vincular los parámetros con los valores correspondientes
            $stament->bindParam(':id_jefebodega', $POST['id_jefebodega']);
            $stament->bindParam(':estado', $POST['estado']);
            $stament->bindParam(':id_factura', $POST['id_factura']);
            $stament->bindParam(':id_bodega', $POST['id_bodega']);
            $stament->bindParam(':id_egreso', $id_egreso);
            $this->reversarStockProductos($id_egreso, $PDO);
            $this->deleteEgresoDetalle($id_egreso, $PDO);
            $lastInsertId = $id_egreso;
            // Ejecutar la consulta SQL
            $stament->execute(); 
            //seccion para manipular detalles
            for ($i = 0; $i < count($POST['id_producto']); $i++) {
                $stament = $this->PDO->prepare("INSERT INTO detalle_egreso (id_recibo_egreso, id_producto, cantidad_egreso) 
                VALUES (". $POST['id_egreso'] .", '" . $POST['id_producto'][$i] . "', '" . $POST['cantidad_egreso'][$i] . "')");
                $stament->execute();
            }
            $this->restarStockProductos($lastInsertId);
        }

        public function deleteEgresoDetalle($id_recibo_egreso, $PDO){
            // Se prepara la sentencia SQL para eliminar los detalles del recibo de egreso en la tabla detalle_egreso.
            $stament = $PDO->prepare("
            DELETE FROM detalle_egreso
            WHERE id_recibo_egreso = :id_recibo_egreso");
            // Se vincula el parámetro :id_recibo_egreso con el valor del identificador del recibo de egreso a eliminar.
            $stament->bindParam(":id_recibo_egreso",$id_recibo_egreso);
            // Se ejecuta la sentencia SQL preparada y se verifica si se eliminaron los detalles correctamente.
            if ($stament->execute()) {
                return true;
            } else {
                return false;
            }
        }

        private function reversarStockProductos($id_recibo_egreso, $PDO) {
            // Selecciona los detalles de ingreso asociados a este recibo
            $statement = $PDO->prepare("SELECT id_producto, cantidad_egreso FROM detalle_egreso WHERE id_recibo_egreso = :id_recibo_egreso");
            $statement->bindParam(':id_recibo_egreso', $id_recibo_egreso);
            $statement->execute();
            $detalle_egreso = $statement->fetchAll();
            
            // Recorre los detalles de ingreso y resta las cantidades al stock de cada producto
            foreach ($detalle_egreso as $detalle) {
            $statement = $this->PDO->prepare("UPDATE producto SET stock = stock + :cantidad_egreso WHERE id = :id_producto");
            $statement->bindParam(':cantidad_egreso', $detalle['cantidad_egreso']);
            $statement->bindParam(':id_producto', $detalle['id_producto']);
            $statement->execute();
            }
        }
        
    }
?>