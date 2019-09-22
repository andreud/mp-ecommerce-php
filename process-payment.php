<?php 
require __DIR__  . '/vendor/autoload.php';
//use \MercadoPago;

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();
$MP_ClientId = getenv('MERCADOPAGO_CLIENT_ID');
$MP_ClientSecret = getenv('MERCADOPAGO_CLIENT_SECRET');

# For API or custom checkout:
//\MercadoPago\SDK::setAccessToken("YOUR_ACCESS_TOKEN");      // On Production
//\MercadoPago\SDK::setAccessToken("YOUR_TEST_ACCESS_TOKEN"); // On Sandbox

# For Web-checkout:
\MercadoPago\SDK::setClientId($MP_ClientId);
\MercadoPago\SDK::setClientSecret($MP_ClientSecret);

# Generar preferencia de pago a partir del form recibido
$preferece = new \MercadoPago\Preference();
$preferece->items = [
	[
		"title" => $_POST['title'],
        "description" => $_POST['title'],
        "quantity" => (int)$_POST['unit'],
        "currency_id" => "ARS",
        "unit_price" => (float)$_POST['price'] 
    ]
];
$preferece->save();

if($preferece->sandbox_init_point){
	echo $preferece->sandbox_init_point;
	//header("Location: ".$preferece->sandbox_init_point);
	//die();
} else {
	echo '<p>No se pudo generar la url para pagar</p>';
}

?>

<?
/*
<pre><?php //var_dump($MP_ClientSecret); ?></pre>
<pre> <?php //var_dump($_POST);  ?></pre>
<pre> <?php //var_dump($preferece); ?></pre>
<pre> <?php //var_dump($preferece->sandbox_init_point); ?></pre>
*/
?>