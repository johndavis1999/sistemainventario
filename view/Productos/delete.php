<?php
    require_once("c://xampp/htdocs/sistemainventario/controller/controladorProductos.php");
    $obj = new controladorProducto();
    $obj->delete($_GET['id']);

?>