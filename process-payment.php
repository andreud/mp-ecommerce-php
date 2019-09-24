<?php 
require __DIR__  . '/vendor/autoload.php';
//use \MercadoPago;

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();
$BASE_URL = $_ENV['BASE_URL'];
$MP_ClientId = $_ENV['MERCADOPAGO_CLIENT_ID'];
$MP_ClientSecret = $_ENV['MERCADOPAGO_CLIENT_SECRET'];

$MP_PublicKey = $_ENV['MERCADOPAGO_PUBLIC_KEY'];
$MP_AccessToken = $_ENV['MERCADOPAGO_ACCESS_TOKEN'];

# For API or custom checkout:
//\MercadoPago\SDK::setAccessToken($MP_AccessToken);      // On Production
\MercadoPago\SDK::setAccessToken($MP_AccessToken); // On Sandbox

# For Web-checkout:
\MercadoPago\SDK::setClientId($MP_ClientId);
\MercadoPago\SDK::setClientSecret($MP_ClientSecret);

# Generar preferencia de pago a partir del form recibido
$preference = new \MercadoPago\Preference();
$preference->items = [
	[
		"title" => $_POST['title'],
        "description" => $_POST['title'],
        "quantity" => (int)$_POST['unit'],
        "currency_id" => "ARS",
        "unit_price" => (float)$_POST['price'] 
    ]
];
// Payer:
$payer = new stdClass();
$payer->email = 'andresxv@gmail.com';
$preference->payer = $payer;
//$preference->payer = ['email' => 'andresxv@gmail.com']; // asi esta en el ejemplo de github
//$preference->payer->email = 'andresxv@gmail.com';

$preference->back_urls = [
	'success' => $BASE_URL . 'back_urls/success.php',
	'pending' => $BASE_URL . 'back_urls/pending.php',
	'failure' => $BASE_URL . 'back_urls/failure.php',
];
$preference->notification_url = $BASE_URL . 'notification_url.php';
$preference->save();

if($preference->sandbox_init_point){
	//echo $preference->sandbox_init_point;
	
	?>

	<form action="/procesar-pago" method="POST"><!-- me devuelve a esta url despues de pago exitoso -->
	  <script
	   src="https://www.mercadopago.com.ar/integrations/v1/web-payment-checkout.js"
	   data-preference-id="<?php echo $preference->id; ?>">
	  </script>
	</form>

	<?php

} else {
	echo '<p>No se pudo generar la url para pagar</p>';
}

?>

<?
/*
<pre><?php //var_dump($MP_ClientSecret); ?></pre>
<pre> <?php //var_dump($_POST);  ?></pre>
<pre> <?php //var_dump($preference); ?></pre>
<pre> <?php //var_dump($preference->sandbox_init_point); ?></pre>
*/
?>