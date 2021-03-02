<?php

require_once 'PollBot.php';
define("BOT_NAME", "@rolgamemaster_bot");
define('BOT_TOKEN', '247358546:AAEMWPYAgO5J4AiNV-01GA1kO8lAkhitQKs');
define('BOT_WEBHOOK', 'https://www.elenafuente.com/bot/poll-bot-worker.php');

$bot = new PollBot(BOT_TOKEN, 'PollBotChat');

if (php_sapi_name() == 'cli') {
  if ($argv[1] == 'set') {
    $bot->setWebhook(BOT_WEBHOOK);
  } else if ($argv[1] == 'remove') {
    $bot->removeWebhook();
  }
  exit;
}

$response = file_get_contents('php://input');
$update = json_decode($response, true);

$bot->init();
$bot->onUpdateReceived($update);
