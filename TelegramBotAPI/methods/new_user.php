<?php
namespace TelegramBotAPI\methods;

trait new_user {
     public function new_user(){
        global $_ITE;
        
        $values = [];

        if( $this -> check_users_table() ) {
            if( empty( $this -> input ) ) {
                return false;
            }

            if( $this -> db -> has( 'TelegramBot__users', ['user' => $this -> input["message"]["from"]["first_name"]] ) ){
                return true;
            } else {
                $values['chat_id'] = $this -> input["message"]["from"]["id"];
                $values['user'] = $this -> input["message"]["from"]["first_name"];
            
                return $this -> db -> insert( 'TelegramBot__users_id', $values );
            }
        } else {
            return false;
        }
    }

    private function check_users_table(){
        if( empty( $this -> db ) ){
            throw new exception('Base de datos inaccesible');
        }   

        // Registro los nuevos usuarios
        $aux = $this -> db -> query("SHOW TABLES LIKE 'TelegramBot__users_id'") -> fetchAll();

        if( empty( $aux ) ) {
            $this -> db -> query('SET FOREIGN_KEY_CHECKS=0; CREATE TABLE `TelegramBot__users` ( '."
                `TelegramBot__users_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'column:no,form:no',
                `user` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
                `chat_id` int(11) unsigned NOT NULL,
                PRIMARY KEY (`TelegramBot__users_id`)
                ".' ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;SET FOREIGN_KEY_CHECKS=1;') -> fetchAll();
        }

        return true;
    }
}
