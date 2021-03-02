<?php

/**
 * WEBHOOK URI: https://api.telegram.org/bot278013742:AAF6srwVOrM76IDf7rTxtdUgaQeyfn3_PaM/setWebhook?url=https://www.elenafuente.com/bot/webhook-dev.php
 */

define("BOT_NAME", "@rolgamemasterdev_bot");
define('BOT_TOKEN', '278013742:AAF6srwVOrM76IDf7rTxtdUgaQeyfn3_PaM');
define('BOT_WEBHOOK', 'https://www.elenafuente.com/bot/webhook-dev.php');
define('API_URL', 'https://api.telegram.org/bot' . BOT_TOKEN . '/');
define("DEBUG", true);

if(!defined('ROOT_PATH')){
    define("ROOT_PATH", dirname( dirname(__FILE__)).DIRECTORY_SEPARATOR);
}

define("DBSERVER", "rds-01.cdykkjmajcea.eu-west-1.rds.amazonaws.com");
define("DBUSER", "elenafuente");
define("DBPASS", "Elena2016");
define("DB", "wp_elenafuente");