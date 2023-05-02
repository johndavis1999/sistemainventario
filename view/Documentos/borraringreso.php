<?php
    require_once("c://xampp/htdocs/sistemainventario/controller/controladorIngreso.php");
    $obj = new controladorIngreso(); 
    //$obj->deleteIngreso($_GET['id_ingreso']);
    $obj->deleteIngresoLogico($_GET['id_ingreso']);
?>