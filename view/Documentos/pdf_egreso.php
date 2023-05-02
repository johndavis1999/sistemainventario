<?php
require_once("c://xampp/htdocs/sistemainventario/controller/controladorEgreso.php");
$obj = new controladorEgreso();
$egrValues = $obj->getEgreso($_GET['id_egreso']);
$egrItems = $obj->getEgresoItems($_GET['id_egreso']);


$output = '';
$output .= '<table width="100%" border="1" cellpadding="5" cellspacing="0">
	<td width="70%">         
	Jefe de bodega: ' . $egrValues['nombre_jefe'] . ' ' .  $egrValues['apellido_jefe']  . '<br />
	Fecha de egreso: ' . $egrValues['fechahora'] . '<br />
	Bodega de egreso: ' . $egrValues['nombre_bodega'] . '<br />
	</td>
	<td width="70%">         
	Factura relacionada: #' . $egrValues['id_factura'] . '<br />
	</td>
	</td>
	</tr>
	</table>
	<br />
	<table width="100%" border="1" cellpadding="5" cellspacing="0">
	<tr>
	<th align="left">No.</th>
	<th align="left">Producto</th>
	<th align="left">Cantidad</th>
	</tr>';
	$count = 0;
	foreach ($egrItems as $egrItem) {
		$count++;
		$output .= '
		<tr>
		<td align="left">' . $count . '</td>
		<td align="left">' . $egrItem["nombre"] . '</td>
		<td align="left">' . $egrItem["cantidad_egreso"] . '</td>
		</tr>';
	}
$output .= '
	</table>
	</td>
	</tr>
	</table>';
// create pdf of invoice	
$invoiceFileName = 'movimiento de inventario' . $egrValues['id_egreso'] . '.pdf';
require_once '../../dompdf/src/Autoloader.php';
Dompdf\Autoloader::register();

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->loadHtml(html_entity_decode($output));
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream($invoiceFileName, array("Attachment" => false));
