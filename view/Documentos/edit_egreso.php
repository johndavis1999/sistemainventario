<?php 
include("../../sidebar.php");
require_once("c://xampp/htdocs/sistemainventario/controller/controlFactura.php");
$obj = new controlFactura(); 
$facturas = $obj->index();
require_once("c://xampp/htdocs/sistemainventario/controller/controladorBodega.php");
$obj = new controladorBodega(); 
$bodegas = $obj->index();
require_once("c://xampp/htdocs/sistemainventario/controller/controladorProductos.php");
$obj = new controladorProducto(); 
$productos = $obj->index();
require_once("c://xampp/htdocs/sistemainventario/controller/controladorEgreso.php");
$obj = new controladorEgreso(); 
$egrValues = $obj->getEgreso($_GET['id_egreso']);
$egrItems = $obj->getEgresoItems($_GET['id_egreso']);
?>


<div>
    <h5>Editar Recibo de Egreso #<?php echo $egrValues['id_egreso'] ?></h5>
    <form action="edit_eg.php" method="POST" >
        <input type="hidden" name="id_egreso" value="<?= $egrValues['id_egreso'] ?>">
        <div class="col-4">
            <div class="mb-">
                <label for="Marca" class="form-label">Factura Relacionada:</label>
                <select class="form-select" name="id_factura" aria-label="Disabled select example" required>
                    <option value="">Seleccionar:</option>
                    <!-- Ciclo para mostrar los factura -->
                    <?php foreach ($facturas as $factura) :
                        // Si el proveedor seleccionado es igual al proveedor en el ciclo, se selecciona
                        if($factura['num_fact'] == $egrValues['id_factura']){?>
                            <option value="<?php echo $factura['num_fact']; ?>" selected><?php echo $egrValues['id_factura']; ?></option>
                        <?php
                        } else{
                        // Si no, se muestra como opción normal
                        ?>
                            <option value="<?php echo $factura['num_fact']; ?>"><?php echo $factura['num_fact']; ?></option>
                        <?php
                        }
                        ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="Marca" class="form-label">Jefe de Bodega:</label>
                <select class="form-select"  disabled>
                    <option >Seleccionar Jefe de Bodega</option>
                    <option selected value="1">Angel Cruz</option>
                    <option value="2">Manuel Orellana</option>
                    <option value="3">Victor Pezo</option>
                </select>
                <input type="hidden" name="id_jefebodega" value="1">
            </div>
            <div class="form-group row">
                <label for="Marca" class="form-label">Bodega:</label>
                <select class="form-control" name="id_bodega" autocomplete="off"  required>
                    <option value="">Seleccionar:</option>
                    <?php foreach ($bodegas as $bodega): 
                        if($bodega['id'] == $egrValues['id_bodega']){?>
                            <option value="<?php echo $bodega['id']; ?>" selected><?php echo $bodega['nombre']; ?></option>
                        <?php
                        } else{
                        // Si no, se muestra como opción normal
                        ?>
                            <option value="<?php echo $bodega['id']; ?>"><?php echo $bodega['nombre']; ?></option>
                        <?php
                        }
                        ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3 col-4">
                <label for="Marca" class="form-label">Estado:</label>
                <select class="form-select" name="estado" id="estado" aria-label="Disabled select example" required>
                    <option value="1" <?= $egrValues['estado']=='1'? 'selected' : ''?>>En proceso</option>
                    <option value="2" <?= $egrValues['estado']=='2'? 'selected' : ''?>>Finalizado</option>
                </select>
            </div>
        </div>
        <div>
            <?php
                //Se recorre el arreglo de productos para construir las opciones del select
                $optionsHtml = '';
                foreach ($productos as $producto) {
                    $optionsHtml .= '<option value="' . $producto['id'] . '">' . $producto['nombre'] . ' / Stock: ' . $producto['stock'] . '</option>';
                }
            ?>
            <div class="">
                <button class="btn btn-danger delete" id="removeRows" type="button">Eliminar</button>
                <button class="btn btn-primary" id="addRows" type="button">Agregar producto</button>
            </div>
            <table class="table" id="ingresoItem">
                <tr>
                    <!--Checkbox para seleccionar todas las filas de la tabla-->
                    <th><input id="checkAll" class="formcontrol" type="checkbox"></th>
                    <th>Producto</th>    
                    <th>Cantidad</th>
                </tr>
                <!--Primera fila de la tabla con los campos del primer producto-->
                
                <?php
                            // Iteramos a través de la lista de elementos de la cotización
                            
                $count = 0;
                foreach ($egrItems as $egrItem) {
                    $count++;
                    $id_producto = $egrItem["id_producto"];
                    $cantidad_egreso = $egrItem["cantidad_egreso"];
                ?>
                <tr>
                    <td><input class="itemRow" type="checkbox"></td>
                    <td>
                        <!-- Creamos un menú desplegable para seleccionar el producto -->
                        <select class="form-select" name="id_producto[]" id="id_producto_<?php echo $count; ?>" aria-label="Disabled select example" required>
                            <option value="" selected>Seleccionar producto</option>
                            <!-- Iteramos a través de la lista de productos y creamos una opción para cada uno -->
                            <?php foreach ($productos as $producto): ?>
                            <option value="<?php echo $producto['id']; ?>" <?php if ($id_producto == $producto['id']) { echo 'selected'; } ?>><?php echo ' ID:' . $producto['id'] . ' - '. $producto['nombre'] . ' - Stock:' . $producto['stock']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <!-- Creamos un campo de entrada para la cantidad de producto -->
                    <td><input type="number" value="<?php echo $cantidad_egreso;?>" name="cantidad_egreso[]" id="cantidad_egreso_<?php echo $count; ?>" class="form-control cantidad_egreso" autocomplete="off" min="1" step="1" required></td>
                </tr>
                <?php } ?>
            </table>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Recibo Ingreso</button>
    </form>
</div>
</body>
</html>
<script>
     $(document).ready(function(){
        // evento al hacer click en el botón "checkAll"
        $(document).on('click', '#checkAll', function() {          	
            $(".itemRow").prop("checked", this.checked);
        });	
        // evento al hacer click en cualquier casilla "itemRow"
        $(document).on('click', '.itemRow', function() {  	
            // si todas las casillas "itemRow" están seleccionadas, se marca la casilla "checkAll"
            if ($('.itemRow:checked').length == $('.itemRow').length) {
                $('#checkAll').prop('checked', true);
            } else {
                // de lo contrario, se desmarca la casilla "checkAll"
                $('#checkAll').prop('checked', false);
            }
        });  
        // se obtiene la cantidad de filas con clase "itemRow"
        var count = $(".itemRow").length;
        // se obtiene el HTML con las opciones de productos
        var optionsHtml = '<?php echo $optionsHtml; ?>';

        // evento al hacer click en el botón "addRows"
        $(document).on('click', '#addRows', function() { 
            count++;
            // se crea un nuevo HTML para la fila a agregar
            var htmlRows = '';
            htmlRows += '<tr>';
            htmlRows += '<td><input class="itemRow" type="checkbox"></td>';          
            htmlRows += '<td><select class="form-select" name="id_producto[]" id="id_producto_'+count+'" aria-label="Disabled select example" required>';
            htmlRows += '<option value="" selected>Seleccionar producto</option>' + optionsHtml;
            htmlRows += '</select></td>';            
            htmlRows += '<td><input type="number" name="cantidad_egreso[]" id="cantidad_egreso_'+count+'" class="form-control cantidad_egreso" autocomplete="off" min="1" step="1" required></td>';           
            htmlRows += '</tr>';
            // se agrega el HTML al final de la tabla con id "ingresoItem"
            $('#ingresoItem').append(htmlRows);
        }); 
        // evento al hacer click en el botón "removeRows"
        $(document).on('click', '#removeRows', function(){
            // se eliminan todas las filas con la clase "itemRow" seleccionadas
            $(".itemRow:checked").each(function() {
                $(this).closest('tr').remove();
            });
            // se desmarca la casilla "checkAll"
            $('#checkAll').prop('checked', false);
        });
    });	
</script>
