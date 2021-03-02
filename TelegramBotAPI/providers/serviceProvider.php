<?php

namespace TelegramBotAPI\providers;

/**
 * Description of cacheServiceProvider
 *
 * @author Fran Díaz <fran.diaz.gonzalez@gmail.com>
 */
class serviceProvider{

    public static function init() {
        spl_autoload_register(function($class) {
            $pos = strrpos($class, '\\');
            $class_file = ($pos !== false) ? substr($class, $pos + 1) : $class;
            $class_namespace = substr($class, 0, $pos);
            $temp = explode('\\', $class_namespace);
            array_walk($temp, function(&$element, $index) {
                $element = md5($element);
            });
            $temp = implode('\\', $temp);
            if (file_exists(str_replace('\\', '/', ROOT_PATH . $class_namespace . DIRECTORY_SEPARATOR . $class_file . '.php'))) {
                
                $filename = str_replace('\\', '/', ROOT_PATH . $class_namespace . DIRECTORY_SEPARATOR . $class_file . '.php');
                require_once($filename);
            } else {
                return false;
            }
        });

        return \TelegramBotAPI\TelegramBot::singleton();
    }

}
