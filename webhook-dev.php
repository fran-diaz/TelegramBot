<?php
require('../../app/kernel/functions.php');
require('../../app/config/db.php');
require('../../vendor/fran-diaz/ite/ITE/db/Medoo.php');
require('config/development.php');

// Required files
foreach ( rglob( "TelegramBotAPI/*.php" ) as $filename ) {
	require( $filename );
}

// Bot initializing
use TelegramBotAPI\TelegramBot;

$bot = new TelegramBot();
$bot -> init( 'webhook' );

/*ob_start();

var_dump($db -> info());

$buffer = ob_get_contents();
ob_end_clean();

file_put_contents( 'prueba-log.txt',  $buffer ."\n", FILE_APPEND );*/