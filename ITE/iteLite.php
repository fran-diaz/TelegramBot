<?php

namespace ITE;

/**
 * ***** BEGIN LICENSE BLOCK *****
 *  
 *  The MIT License (MIT)
 *
 *  Copyright (c) 2014 Fran Díaz
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the "Software"), to deal
 *  in the Software without restriction, including without limitation the rights
 *  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  copies of the Software, and to permit persons to whom the Software is
 *  furnished to do so, subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in all
 *  copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 *  SOFTWARE.
 * 
 * ***** END LICENSE BLOCK *****
 * 
 * @copyright   Copyright © 2014 Fran Díaz
 * @author      Fran Díaz <fran.diaz.gonzalez@gmail.com>
 * @license     http://opensource.org/licenses/MIT
 * @version     4.5b
 * @package     ITE
 * @access      public
 * 
 */

/**
 * Main class to provide MVC Controller functionality. Based on Singleton pattern.
 * 
 * @copyright   Copyright © 2014 Fran Díaz
 * @author      Fran Díaz <fran.diaz.gonzalez@gmail.com>
 * @license     http://opensource.org/licenses/MIT
 * @version     4.5b
 * @package     ITE
 * @access      public
 * 
 */

class ite {

    /**
     * @property $instance ite
     */
    private static $instance;

    /**
     * @property $funcs functions 
     */
    public $funcs;

    /**
     * @property $files files 
     */
    public $files;

    /**
     * @property $cache cache 
     */
    public $cache;

    /**
     * @property $lang lang
     */
    public $lang;

    /**
     * @property $bdd mysql
     */
    public $bdd;

    

    /**
     * @property $debug FirePHP
     */
    public $debug = null;

    /**
     * @property $auth auth
     */
    public $auth;
    public $url_extension;

    /**
     * Protected constructor to prevent creating a new instance of the *Singleton* via the `new` operator from outside of this class.
     * Registers an custom autoloader function to load the rest of ITE classes (asuming that each class name space matches his respective path situation)
     */
    public function __construct() {
        
    }

    /**
     * Private clone method to prevent cloning of the instance of the *Singleton* instance.
     *
     * @return void
     */
    private function __clone() {
        $this->__error("Clonado del objeto no permitido.");
    }

    /**
     * Private unserialize method to prevent unserializing of the *Singleton* instance.
     *
     * @return void
     */
    private function __wakeup() {
        
    }

    /**
     * Checks if DEBUG constant is defined is active
     * 
     * @staticvar boolean DEBUG Assumed that is previusly defined in the bootstrap file (settings)
     * @return boolean
     */
    public function __debug() {
        /*if (defined("DEBUG")) {
            return DEBUG;
        }else{
            return false;
        }*/
        return false;
    }

    /**
     * Trigger error message and shows it over FirePHP if debug is true or Error Log if false
     * 
     * @param string $msg Error message sent to the user
     */
    public function __error($msg, $context = []) {
        if ($this->__debug()) {
            if (is_string($msg)) {
                $this->debug->error($msg, $context);
            } elseif (is_bool($msg)) {
                $this->debug->info(($msg) ? 'true' : 'false', $context);
            } else {
                $this->debug->error('', $msg);
            }
        } else {
            \trigger_error('**'.$msg, E_USER_ERROR);
        }
    }

    /**
     * Trigger warning message and shows it over FirePHP if debug is true or Error Log if false
     * 
     * @param string $msg
     */
    public function __warn($msg, $context = []) {
        if ($this->__debug()) {
            if (is_string($msg)) {
                $this->debug->warning($msg, $context);
            } elseif (is_bool($msg)) {
                $this->debug->info(($msg) ? 'true' : 'false', $context);
            } else {
                $this->debug->warning('', $msg);
            }
        } else {
            \trigger_error('**'.$msg, E_USER_WARNING);
        }
    }

    /**
     * Trigger information message and shows it over FirePHP if debug is true or Error Log if false
     * 
     * @param string $msg
     */
    public function __info($msg, $context = []) {
        if ($this->__debug()) {
            if (is_string($msg)) {
                $this->debug->info($msg, $context);
            } elseif (is_bool($msg)) {
                $this->debug->info(($msg) ? 'true' : 'false', $context);
            } else {
                $this->debug->info('', $msg);
            }
        } else {
            \trigger_error('**'.$msg, E_USER_NOTICE);
        }
    }

    /**
     * Function that sets intantiates database library core
     * 
     * @var string $type Final name of the desired data base class to load. (namespace + class name)
     * @param string $type Name of the data base controller class
     * @return boolean
     */
    public static function set_db_controller($type = "mysql") {
        $type = __NAMESPACE__ . '\db\\' . $type;

        if (class_exists($type)) {
            //self::$instance->bdd = new $type(self::$instance);
            self::$instance->bdd = \ITE\db\serviceProvider::init(self::$instance, $type);
        } else {
            $this->__error("Controllador de base de datos no disponible, la clase no existe.");
            return false;
        }
    }
}
