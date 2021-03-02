<?php
namespace TelegramBotAPI\providers;

use TelegramBotAPI\providers\serviceProviderInterface;
/**
 * Description of cacheServiceProvider
 *
 * @author Fran Díaz <fran.diaz.gonzalez@gmail.com>
 */

class commandsServiceProvider implements serviceProviderInterface{

    public static function init(\TelegramBotAPI\TelegramBot $instance) {
        
        /*return new class($instance)
        { 
            private $container;
            
            public function __construct($container) {
                $this->container = $container;
            }
            
            public function __call($name, $params) {

                $this->container->commands = new \TelegramBotAPI\command($this->container);
                
                return call_user_func_array(array($this->container->commands, $name), $params);
            }
        }*/
        
        return new \TelegramBotAPI\command($instance);
    }
}