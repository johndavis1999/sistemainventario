<?php
    require_once("c://xampp/htdocs/sistemainventario/controller/controladorBodega.php");
    $obj = new controladorBodega();
    $obj->delete($_GET['id']);

?>