<?php

/**
 * WEBHOOK URI: https://api.telegram.org/bot247358546:AAEMWPYAgO5J4AiNV-01GA1kO8lAkhitQKs/setWebhook?url=https://www.elenafuente.com/bot/webhook.php
 */

define("BOT_NAME", "@rolgamemaster_bot");
define('BOT_TOKEN', '247358546:AAEMWPYAgO5J4AiNV-01GA1kO8lAkhitQKs');
define('BOT_WEBHOOK', 'https://www.elenafuente.com/bot/webhook.php');
define('API_URL', 'https://api.telegram.org/bot' . BOT_TOKEN . '/');
define("DEBUG", true);

define("DBSERVER", "rds-01.cdykkjmajcea.eu-west-1.rds.amazonaws.com");
define("DBUSER", "elenafuente");
define("DBPASS", "Elena2016");
define("DB", "wp_elenafuente");

$Medoo_config = [
	// required
	'database_type' => 'mysql',
	'database_name' => DB,
	'server' => DBSERVER,
	'username' => DBUSER,
	'password' => DBPASS,
 
	// [optional]
	'charset' => 'utf8mb4',
	'collation' => 'utf8mb4_general_ci',
	'port' => 3306,
 
	// [optional] Table prefix
	'prefix' => 'rol_',
];