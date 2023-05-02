<?php
    class Producto{
        private $PDO;
        public function __construct()
        {
            require_once("c://xampp/htdocs/sistemainventario/config/config.php");
            $con = new config();
            $this->PDO = $con->conexion();
        }
        
        public function insertar($nombre, $precio, $stock, $estado, $marca, $idTipo, $codigo){
            // Preparamos la consulta SQL para insertar un nuevo producto en la tabla 'producto'
            $stament = $this->PDO->prepare("INSERT INTO producto (nombre, precio, stock, estado, marca, idTipo, codigo) VALUES (:nombre, :precio, :stock, :estado, :marca, :idTipo, :codigo)");
            // Ligamos los valores de los parámetros a los marcadores de posición en la consulta SQL
            $stament->bindParam(":nombre",$nombre);
            $stament->bindParam(":precio",$precio);
            $stament->bindParam(":stock",$stock);
            $stament->bindParam(":estado",$estado);
            $stament->bindParam(":marca",$marca);
            $stament->bindParam(":idTipo",$idTipo);
            $stament->bindParam(":codigo",$codigo);
            // Ejecutamos la consulta SQL y retornamos el ID del nuevo producto insertado si la consulta se ejecutó correctamente, de lo contrario, retornamos 'false'
            return ($stament->execute()) ? $this->PDO->lastInsertId() : false ;
        }

        public function index(){
            // Preparar la consulta SQL para seleccionar todos los productos junto con la descripción del tipo al que pertenecen
            $statement = $this->PDO->prepare("SELECT p.*, t.descripcion as tipo_descripcion 
                                              FROM producto p 
                                              left JOIN Tipo t ON p.idtipo = t.id 
                                              ORDER BY p.id DESC");
            // Ejecutar la consulta SQL y devolver los resultados o false si falla
            return ($statement->execute()) ? $statement->fetchAll() : false;
        }
        
        public function update($id, $nombre, $precio, $stock, $estado, $marca, $idTipo, $codigo) {
            // Preparar la consulta SQL para actualizar un producto
            $stament = $this->PDO->prepare("UPDATE producto SET nombre = :nombre, precio = :precio, stock = :stock,
            estado = :estado, marca = :marca, idTipo = :idTipo, codigo = :codigo WHERE id = :id");
            // Vincular los parámetros de la consulta SQL con los valores proporcionados
            $stament->bindParam(":nombre",$nombre);
            $stament->bindParam(":precio",$precio);
            $stament->bindParam(":stock",$stock);
            $stament->bindParam(":estado",$estado);
            $stament->bindParam(":marca",$marca);
            $stament->bindParam(":idTipo",$idTipo);
            $stament->bindParam(":codigo",$codigo);
            $stament->bindParam(":id", $id);
            // Ejecutar la consulta SQL y devolver el ID del producto actualizado o false si falla
            return ($stament->execute()) ? $id : false;
        }

        public function delete($id){
            $stament = $this->PDO->prepare("DELETE FROM producto WHERE id = :id"); // Prepara la sentencia SQL para eliminar un producto de la tabla producto según el id proporcionado
            $stament->bindParam(":id",$id); // Vincula el valor del parámetro :id con la variable $id proporcionada al método
            return ($stament->execute()) ? true : false; // Ejecuta la sentencia SQL y devuelve true si se eliminó el producto correctamente, o false en caso contrario
        }
        
    }

?>