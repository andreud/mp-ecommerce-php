<?php 

require __DIR__  . '/vendor/autoload.php';
//use \MercadoPago;

# For API or custom checkout:
//\MercadoPago\SDK::setAccessToken("YOUR_ACCESS_TOKEN");      // On Production
//\MercadoPago\SDK::setAccessToken("YOUR_TEST_ACCESS_TOKEN"); // On Sandbox

# For Web-checkout:
\MercadoPago\SDK::setClientId("1639199754827910");//ENV_CLIENT_ID
//\MercadoPago\SDK::setClientSecret("");

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
} else {
	echo '<p>No se pudo generar la url para pagar</p>';
}



?>

<pre> <?php var_dump($_POST);  ?></pre>
<pre> <?php var_dump($preferece); ?></pre>
<pre> <?php var_dump($preferece->sandbox_init_point); ?></pre>

 