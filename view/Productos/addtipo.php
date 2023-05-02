<?php
    require_once("c://xampp/htdocs/sistemainventario/controller/controladorTipo.php");
    $obj = new controladorTipo();
    $Descripcion = $_POST['Descripcion'];
    $obj->guardar($Descripcion);
?>
