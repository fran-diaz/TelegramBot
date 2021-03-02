<?php

set_time_limit(0);

require_once 'PollBot.php';

define('BOT_TOKEN', '247358546:AAEMWPYAgO5J4AiNV-01GA1kO8lAkhitQKs');

$bot = new PollBot(BOT_TOKEN, 'PollBotChat');
$bot->runLongpoll();
