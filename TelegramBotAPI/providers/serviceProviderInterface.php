<?php
namespace TelegramBotAPI\providers;

/**
 *
 * @author Fran Díaz <fran.diaz.gonzalez@gmail.com>
 */

interface serviceProviderInterface {
    public static function init(\TelegramBotAPI\TelegramBot $instance);
}
