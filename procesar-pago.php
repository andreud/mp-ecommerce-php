<?php 


switch($_POST['payment_status']) :

	case 'pending' :

		echo '<h1>Tu pago esta pendiente</h1>';
		echo '<p>Referencia del pedido: ' . $_POST["external_reference"] . '</p>';
		echo 'ID del pago: ' . $_POST["payment_id"];
		break;

	case 'approved' :
		echo '<h1>Tu pago ha sido aprobado</h1>';
		echo '<p>Referencia del pedido: ' . $_POST["external_reference"] . '</p>';
		echo 'ID del pago: ' . $_POST["payment_id"];
		break;

	case 'rejected' :
		echo '<h1>Tu pago ha sido rechazado</h1>';
		echo '<p>Referencia del pedido: ' . $_POST["external_reference"]. '</p>';
		//echo 'ID del pago: ' . $_POST["payment_id"];
		break;

endswitch;


//var_dump($_POST);


 ?>