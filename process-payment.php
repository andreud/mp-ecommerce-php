<?php 
require __DIR__  . '/vendor/autoload.php';

// Usar la libreira DotEnv si hay un .env
if( file_exists(__DIR__ . '/.env') ) :
	$dotenv = Dotenv\Dotenv::create(__DIR__);
	$dotenv->load();
endif;


$BASE_URL = getenv('BASE_URL');
//$MP_ClientId = getenv('MERCADOPAGO_CLIENT_ID');
//$MP_ClientSecret = getenv('MERCADOPAGO_CLIENT_SECRET');
$MP_PublicKey = getenv('MERCADOPAGO_PUBLIC_KEY');
$MP_AccessToken = getenv('MERCADOPAGO_ACCESS_TOKEN');

# For API or custom checkout:
\MercadoPago\SDK::setAccessToken($MP_AccessToken);
# For Web-checkout:
//\MercadoPago\SDK::setClientId($MP_ClientId);
//\MercadoPago\SDK::setClientSecret($MP_ClientSecret);

# Generar preferencia de pago a partir del form recibido
$preference = new \MercadoPago\Preference();
// Items y pedido
$preference->items = [
	[
		"title" => $_POST['title'],
        "description" => $_POST['title'],
        "quantity" => (int)$_POST['unit'],
        "currency_id" => "ARS",
        "unit_price" => (float)$_POST['price'] 
    ]
];
$preference->external_reference = 'ABCD1234';
// Payer:
$payer = new stdClass();
$payer->email = 'test_user_63274575@testuser.com';
$payer->name = 'Lalo';
$payer->surname = 'Landa';

$payer_identification = new stdClass();
$payer_identification->type = 'dni';
$payer_identification->number = '22333444';
$payer->identification = $payer_identification;

$payer_phone = new stdClass();
$payer_phone->area_code = '011';
$payer_phone->number = '2222-3333';
$payer->phone = $payer_phone;

$preference->payer = $payer;

// Medios de pago
$payment_methods = new stdClass();
$payment_methods->installments = 6;
$payment_methods->excluded_payment_methods = array(array("id" => "amex"));
$payment_methods->excluded_payment_types = array(array("id" => "atm"));
$preference->payment_methods = $payment_methods;

// URLs
$preference->back_urls = array(
	'success' => $BASE_URL . 'back_urls/success.php',
	'pending' => $BASE_URL . 'back_urls/pending.php',
	'failure' => $BASE_URL . 'back_urls/failure.php'
);
$preference->notification_url = $BASE_URL . 'notification_url.php';
$preference->auto_return = 'approved';
$preference->save();

if($preference->id){
	//echo $preference->sandbox_init_point;
	?>
	<h1>Checkout</h1>
	<form action="/procesar-pago.php" method="POST"><!-- me devuelve a esta url despues de pago exitoso -->
	  <script
	   src="https://www.mercadopago.com.ar/integrations/v1/web-payment-checkout.js"
	   data-preference-id="<?php echo $preference->id; ?>"
	   data-button-label="Pagar la compra"
	   data-elements-color="#2D3277" 
	   data-header-color="#2D3277"
	  >
	  </script>
	</form>

	<?php

} else {
	echo '<p>No se pudo generar la preferencia</p>';
}


// 
?>

<?
/*
<pre><?php //var_dump($MP_ClientSecret); ?></pre>
<pre> <?php //var_dump($_POST);  ?></pre>
<pre> <?php //var_dump($preference); ?></pre>
<pre> <?php //var_dump($preference->sandbox_init_point); ?></pre>
*/
?>