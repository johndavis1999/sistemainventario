<?php
    /**
     * La clase Bodega define los métodos para interactuar con la tabla "bodega" en la base de datos.
     */
    class Bodega{
        private $PDO;

        /**
         * Crea una instancia de la clase Bodega y establece una conexión a la base de datos.
         */
        public function __construct()
        {
            require_once("c://xampp/htdocs/sistemainventario/config/config.php");
            $con = new config();
            $this->PDO = $con->conexion();
        }

        /**
         * Inserta una nueva bodega en la tabla "bodega".
         *  $nombre - El nombre de la bodega a insertar.
         *  $direccion - La dirección de la bodega a insertar.
         *  $estado - El estado de la bodega a insertar (1 para activo, 0 para inactivo).
         *  El ID de la bodega recién insertada o false si no se pudo insertar.
         */
        public function insertar($nombre, $direccion, $estado){
            // Preparar la consulta SQL para insertar en la tabla "bodega"
            $stament = $this->PDO->prepare("INSERT INTO bodega (nombre, direccion, estado) VALUES (:nombre, :direccion, :estado)");
            
            // Vincular los parámetros de la consulta con los valores proporcionados
            $stament->bindParam(":nombre",$nombre);
            $stament->bindParam(":direccion",$direccion);
            $stament->bindParam(":estado",$estado);
            
            // Ejecutar la consulta y verificar si tuvo éxito
            // Si tuvo éxito, devolver el ID del último registro insertado en la tabla
            // De lo contrario, devolver false
            return ($stament->execute()) ? $this->PDO->lastInsertId() : false ;
        }
        
        /**
         * Obtiene todos las bodegas de la tabla "bodega".
         * devuelve Un arreglo con todas las bodegas de la tabla o false si no se encontró ninguna bodega.
         */
        public function index(){
            $stament = $this->PDO->prepare("SELECT * FROM bodega ORDER BY id DESC");
            return ($stament->execute()) ? $stament->fetchAll() : false;
        }
        
        /**
         * Actualiza una bodega específica en la tabla "bodega".
         * $id - El ID de la bodega que se quiere actualizar.
         * $nombre - El nuevo nombre para la bodega.
         * $direccion - La nueva dirección para la bodega.
         * $estado - El nuevo estado para la bodega (1 para activo, 0 para inactivo).
         * El ID de la bodega actualizada o false si no se pudo actualizar.
         */
        public function update($id, $nombre, $direccion, $estado) {
            // Prepara una sentencia SQL para actualizar una fila en la tabla 'bodega', con los valores proporcionados como parámetros
            $stament = $this->PDO->prepare("UPDATE bodega SET nombre = :nombre, direccion = :direccion, estado = :estado WHERE id = :id");
        
            // Asocia los valores proporcionados como parámetros con los marcadores de posición en la sentencia SQL preparada
            $stament->bindParam(":nombre", $nombre);
            $stament->bindParam(":direccion", $direccion);
            $stament->bindParam(":estado", $estado);
            $stament->bindParam(":id", $id);
        
            // Ejecuta la sentencia SQL preparada con los valores asociados
            // Devuelve el id de la fila actualizada si la ejecución de la sentencia tiene éxito, de lo contrario devuelve falso
            return ($stament->execute()) ? $id : false;
        }
        
        /*
         * Elimina una bodega específica en la tabla "bodega".
         * $id - El ID de la bodega que se quiere actualizar.
        */
        public function delete($id){
            $stament = $this->PDO->prepare("DELETE FROM bodega WHERE id = :id"); // Se prepara la consulta SQL para eliminar el registro con el id especificado
            $stament->bindParam(":id",$id); // Se bindea el parámetro id con el valor proporcionado
            return ($stament->execute()) ? true : false; // Se ejecuta la consulta SQL y se retorna true si se eliminó el registro correctamente, false en caso contrario
        }
        
    }

?>