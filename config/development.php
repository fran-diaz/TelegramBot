<?php

/**
 * WEBHOOK URI: https://api.telegram.org/bot1689780893:AAHG36iUBXO5EJlhD4PMwzwtgR1Zc98wHE0/setWebhook?url=https://app1.brainhardware.es/resources/TelegramBot/webhook-dev.php
 */

function decode($data) {
    return json_decode(gzinflate(base64_decode(strtr($data, '-_,', '+/='))),true);
}

define("BOT_NAME", decode('U3JwDAiIdypKzMyLT8ovUQIA'));
define('BOT_TOKEN', decode('UzI0s7A0tzCwsDS2cnT0cDc2ywx1ivA3dfXKyXAxCfAtryovSQ8yjEq2tCj3cDVQAgA,'));
define('BOT_WEBHOOK', 'https://'.DOMAIN.'/resources/TelegramBot/webhook-dev.php');
define('API_URL', 'https://api.telegram.org/bot' . BOT_TOKEN . '/');