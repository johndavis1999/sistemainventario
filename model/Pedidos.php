<?php
    class Pedido{
        private $PDO;

        public function __construct()
        {
            // Se requiere el archivo de configuración que establece la conexión a la base de datos
            require_once("c://xampp/htdocs/sistemainventario/config/config.php");
            $con = new config(); // Se instancia la clase config
            $this->PDO = $con->conexion(); // Se establece la conexión a la base de datos y se guarda en la variable PDO
        }

        public function index(){
            $stament = $this->PDO->prepare("SELECT * FROM pedido ORDER BY id ASC"); // Se prepara la consulta SQL para obtener todos los registros de la tabla "pedido" ordenados por "id" de forma ascendente
            return ($stament->execute()) ? $stament->fetchAll() : false; // Se ejecuta la consulta y si tiene éxito, se retornan todos los resultados como un arreglo. De lo contrario, se retorna "false".
        }
    }
?>
