<?php
    class Factura{
        private $PDO; // Variable privada para guardar la conexión a la base de datos

        public function __construct() // Constructor de la clase
        {
            require_once("c://xampp/htdocs/sistemainventario/config/config.php"); // Se requiere el archivo de configuración de la base de datos
            $con = new config(); // Se crea una instancia de la clase "config" que contiene los datos de conexión a la base de datos
            $this->PDO = $con->conexion(); // Se guarda la conexión en la variable privada "PDO"
        }

        public function index(){ // Función que devuelve todas las facturas ordenadas por número ascendente
            $stament = $this->PDO->prepare("SELECT * FROM factura ORDER BY num_fact ASC"); // Se prepara la consulta SQL
            return ($stament->execute()) ? $stament->fetchAll() : false; // Se ejecuta la consulta y se devuelve un arreglo con los resultados o "false" en caso de error
        }
    }
?>
