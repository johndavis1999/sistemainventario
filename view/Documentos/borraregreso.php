<?php
    require_once("c://xampp/htdocs/sistemainventario/controller/controladorEgreso.php");
    $obj = new controladorEgreso(); 
    //$obj->deleteEgreso($_GET['id_egreso']);
    $obj->deleteEgresoLogico($_GET['id_egreso']);
?>