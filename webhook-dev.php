<?php
require('config/development.php');
require('TelegramBotAPI/TelegramBot.php');

use TelegramBotAPI\TelegramBot;

$bot = new TelegramBot();
$bot -> init( 'webhook' );