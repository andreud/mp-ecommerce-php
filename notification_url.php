<?php 

require __DIR__  . '/vendor/autoload.php';

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
$log = new Logger('debug');
$log->pushHandler(new StreamHandler("php://stderr", Logger::DEBUG));

$log->info($_POST);

?>