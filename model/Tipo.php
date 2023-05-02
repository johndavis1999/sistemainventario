<?php
    class Tipo{
        private $PDO;
        public function __construct()
        {
            require_once("c://xampp/htdocs/sistemainventario/config/config.php"); // Se requiere el archivo config.php que contiene las credenciales de la base de datos.
            $con = new config(); // Se instancia la clase config para obtener la conexión a la base de datos.
            $this->PDO = $con->conexion(); // Se guarda la conexión en una variable privada para ser usada en los métodos de la clase.
        }

        // Este método permite insertar un nuevo tipo en la tabla tipo.
        public function insertar($Descripcion){
            $stament = $this->PDO->prepare("INSERT INTO tipo (Descripcion) VALUES (:Descripcion)"); // Se prepara la consulta SQL para insertar un nuevo tipo en la tabla tipo.
            $stament->bindParam(":Descripcion",$Descripcion); // Se vincula el valor de la variable $Descripcion al parámetro :Descripcion en la consulta SQL.
            return ($stament->execute()) ? $this->PDO->lastInsertId() : false ; // Se ejecuta la consulta SQL y si es exitosa, se retorna el último ID insertado en la tabla tipo, de lo contrario se retorna false.
        }

        // Este método devuelve todos los registros de la tabla tipo en orden ascendente por el ID.
        public function index(){
            $stament = $this->PDO->prepare("SELECT * FROM tipo ORDER BY id ASC"); // Se prepara la consulta SQL para seleccionar todos los registros de la tabla tipo ordenados de manera ascendente por el ID.
            return ($stament->execute()) ? $stament->fetchAll() : false; // Se ejecuta la consulta SQL y si es exitosa, se retorna todos los registros obtenidos, de lo contrario se retorna false.
        }
    }
?>
