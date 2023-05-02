<?php
require_once("c://xampp/htdocs/sistemainventario/controller/controladorEgreso.php");
$obj = new controladorEgreso(); 
    $id_egreso = $_POST['id_egreso'];
    $id_jefebodega = $_POST['id_jefebodega'];;
    $estado = $_POST['estado'];
    $id_factura = $_POST['id_factura'];
    $id_bodega = $_POST['id_bodega'];
    $obj->updateEgr($id_egreso, $id_jefebodega, $estado, $id_factura, $id_bodega);