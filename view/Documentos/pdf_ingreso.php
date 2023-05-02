<?php
require_once("c://xampp/htdocs/sistemainventario/controller/controladorIngreso.php");
$obj = new controladorIngreso(); 
$ingtValues = $obj->getIngreso($_GET['id_ingreso']);
$ingItems = $obj->getIngresoItems($_GET['id_ingreso']);


$output = '';
$output .= '<table width="100%" border="1" cellpadding="5" cellspacing="0">
	<tr>
	<td colspan="2" align="center" style="font-size:18px"><b>INGRESO DE MERCADERIA</b></td>
	</tr>
	<tr>
	<td colspan="2">
	<table width="100%" cellpadding="5">
	<tr>
	<td width="65%">
	<b>Recibido por:</b><br />
	Jefe de bodega : ' . $ingtValues['id_ingreso']  . $ingtValues['id_ingreso'] .' <br /> 
	Cedula : ' . '0' . $ingtValues['id_ingreso'] . '<br />
	</td>
	<td width="70%">         
	Pedido relacionado: #' . $ingtValues['id_ingreso'] . '<br />
	Fecha de ingreso: ' . $ingtValues['id_ingreso'] . '<br />
	Bodega de ingreso: ' . $ingtValues['id_ingreso'] . '<br />
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
foreach ($ingItems as $ingItem) {
	$count++;
	$output .= '
	<tr>
	<td align="left">' . $count . '</td>
	<td align="left">' . $ingItem["nombre"] . '</td>
	<td align="left">' . $ingItem["cantidad_ingreso"] . '</td>
	</tr>';
}

$output .= '
	</table>
	</td>
	</tr>
	</table>';
// create pdf of invoice	
$invoiceFileName = 'movimiento de inventario' . $ingtValues['id_ingreso'] . '.pdf';
require_once '../../dompdf/src/Autoloader.php';
Dompdf\Autoloader::register();

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->loadHtml(html_entity_decode($output));
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream($invoiceFileName, array("Attachment" => false));
