<?php
require('config/development.php');
require('TelegramBotAPI/TelegramBot.php');
require('../../app/config/db.php');
require('../../vendor/fran-diaz/ite/ITE/db/Medoo.php');

use TelegramBotAPI\TelegramBot;
use Medoo\Medoo;

$bot = new TelegramBot();
$bot -> init( 'webhook' );

ob_start();

$db = new Medoo([
    'database_type' => 'mysql',
    'database_name' => DB,
    'server' => DBSERVER,
    'username' => DBUSER,
    'password' => DBPASS
]);

var_dump($db -> info();

$buffer = ob_get_contents();
ob_end_clean();

file_put_contents( 'prueba-log.txt',  $buffer ."\n", FILE_APPEND );