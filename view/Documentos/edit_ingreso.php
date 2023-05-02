<?php 
include("../../sidebar.php");
require_once("c://xampp/htdocs/sistemainventario/controller/controlPedidos.php");
$obj = new controlPedido(); 
$pedidos = $obj->index();
require_once("c://xampp/htdocs/sistemainventario/controller/controladorBodega.php");
$obj = new controladorBodega(); 
$bodegas = $obj->index();
require_once("c://xampp/htdocs/sistemainventario/controller/controladorProductos.php");
$obj = new controladorProducto(); 
$productos = $obj->index();
require_once("c://xampp/htdocs/sistemainventario/controller/controladorIngreso.php");
$obj = new controladorIngreso(); 
$ingtValues = $obj->getIngreso($_GET['id_ingreso']);
$ingItems = $obj->getIngresoItems($_GET['id_ingreso']);
?>


<div>
    <h5>Editar Recibo de Ingreso #<?php echo $ingtValues['id_ingreso'] ?></h5>
    <form action="edit.php" method="POST" >
        <input type="hidden" name="id_ingreso" value="<?= $ingtValues['id_ingreso'] ?>">
        <div class="col-4">
            <div class="mb-">
                <label for="Marca" class="form-label">Pedido Relacionado:</label>
                <select class="form-select" name="id_pedido" aria-label="Disabled select example" required>
                    <option value="">Seleccionar:</option>
                    <!-- Ciclo para mostrar los pedido -->
                    <?php foreach ($pedidos as $pedido) :
                        // Si el proveedor seleccionado es igual al proveedor en el ciclo, se selecciona
                        if($pedido['id'] == $ingtValues['id_pedido']){?>
                            <option value="<?php echo $pedido['id']; ?>" selected><?php echo $pedido['id']; ?></option>
                        <?php
                        } else{
                        // Si no, se muestra como opción normal
                        ?>
                            <option value="<?php echo $pedido['id']; ?>"><?php echo $pedido['id']; ?></option>
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
                        if($bodega['id'] == $ingtValues['id_bodega']){?>
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
                    <option value="1" <?= $ingtValues['estado']=='1'? 'selected' : ''?>>En proceso</option>
                    <option value="2" <?= $ingtValues['estado']=='2'? 'selected' : ''?>>Finalizado</option>
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
                foreach ($ingItems as $ingItem) {
                    $count++;
                    $id_producto = $ingItem["id_producto"];
                    $cantidad_ingreso = $ingItem["cantidad_ingreso"];
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
                    <td><input type="number" value="<?php echo $cantidad_ingreso;?>" name="cantidad_ingreso[]" id="cantidad_ingreso_<?php echo $count; ?>" class="form-control cantidad_ingreso" autocomplete="off" min="1" step="1" required></td>
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
            htmlRows += '<td><input type="number" name="cantidad_ingreso[]" id="cantidad_ingreso_'+count+'" class="form-control cantidad_ingreso" autocomplete="off" min="1" step="1" required></td>';           
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
