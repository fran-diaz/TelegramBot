<?php
require('config/development.php');
require('TelegramBotAPI/TelegramBot.php');

use TelegramBotAPI\TelegramBot;

$bot = new TelegramBot();
$bot -> init( 'webhook' );

ob_start();
require('../../app/config/db.php');
var_dump(get_defined_constants(true)['user'],$_ITEC);
$buffer = ob_get_contents();
ob_end_clean();

file_put_contents( 'prueba-log.txt',  $buffer ."\n", FILE_APPEND );