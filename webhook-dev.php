<?php

//use TelegramBot\TelegramBot;

require('config/development.php');
require('TelegramBotAPI/providers/serviceProvider.php');
require('ITE/iteLite.php');
require('ITE/dbInterface.php');
require('ITE/mysql.php');

$_ITE = new ITE\ite();
$_ITE->bdd = new ITE\db\mysql($_ITE);

$bot = TelegramBotAPI\providers\serviceProvider::init();
$bot->init();