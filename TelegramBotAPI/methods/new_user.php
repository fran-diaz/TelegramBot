<?php
namespace TelegramBotAPI\methods;

trait new_user {
     public function new_user(){
        global $_ITE;
        
        $values = [];

        if( empty( $this -> input ) ) {
            return false;
        }

        if( $this -> input["message"]["chat"]["type"] === 'group' ){
            if( $this -> check_groups_table() ) {
                if( $this -> db -> has( 'TelegramBot__groups', ['chat_id' => $this -> input["message"]["chat"]["id"]] ) ){
                    return true;
                } else {
                    $values['chat_id'] = $this -> input["message"]["chat"]["id"];
                    $values['title'] = $this -> input["message"]["chat"]["title"];
                
                    return $this -> db -> insert( 'TelegramBot__groups', $values );
                }
            } else {
                return false;
            }
        }

        if( $this -> check_users_table() ) {
            if( $this -> db -> has( 'TelegramBot__users', ['user' => $this -> input["message"]["from"]["first_name"]] ) ){
                return true;
            } else {
                $values['chat_id'] = $this -> input["message"]["from"]["id"];
                $values['user'] = $this -> input["message"]["from"]["first_name"];
                $values['name'] = $this -> input["message"]["from"]["first_name"];
            
                return $this -> db -> insert( 'TelegramBot__users', $values );
            }
        } else {
            return false;
        }
    }

    private function check_users_table(){
        if( empty( $this -> db ) ){
            return false;
        }   

        // Registro los nuevos usuarios
        $aux = $this -> db -> query("SHOW TABLES LIKE 'TelegramBot__users'") -> fetchAll();

        if( empty( $aux ) ) {
            $this -> db -> query('SET FOREIGN_KEY_CHECKS=0; CREATE TABLE `TelegramBot__users` ( '."
                `TelegramBot__users_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'column:no,form:no',
                  `user` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL DEFAULT NULL,
                  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL DEFAULT NULL,
                  `chat_id` int(11) UNSIGNED NOT NULL,
                  `active` bit(1) NULL DEFAULT b'0',
                  PRIMARY KEY (`TelegramBot__users_id`) USING BTREE
                ".' ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;SET FOREIGN_KEY_CHECKS=1;') -> fetchAll();
        }

        return true;
    }

    private function check_groups_table(){
        if( empty( $this -> db ) ){
            return false;
        }   

        // Registro los nuevos grupos
        $aux = $this -> db -> query("SHOW TABLES LIKE 'TelegramBot__groups'") -> fetchAll();

        if( empty( $aux ) ) {
            $this -> db -> query('SET FOREIGN_KEY_CHECKS=0; CREATE TABLE `TelegramBot__groups` ( '."
                `TelegramBot__groups_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'column:no,form:no',
                  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL DEFAULT NULL,
                  `chat_id` int(11) NOT NULL,
                  `active` bit(1) NULL DEFAULT b'0',
                  PRIMARY KEY (`TelegramBot__groups_id`) USING BTREE
                ".' ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;SET FOREIGN_KEY_CHECKS=1;') -> fetchAll();
        }

        return true;
    }
}
