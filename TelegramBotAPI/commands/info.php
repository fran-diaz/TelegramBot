<?php
namespace TelegramBotAPI\commands;

trait info {
    public function info( $args = 1 ){
        $user_info = $this -> db -> select('TelegramBot__users','*',['user' => $this -> input["message"]["from"]["first_name"]]);
        if( ! $user_info ){
            $this -> sendMessage( 'No nos consta que estés registrado.' );
            return false;
        }

        $info = $this -> db -> select('_intervenciones','*',['id_intervencion' => $args, 'telegram_usr_id' => $user_info['TelegramBot__users_id']]);
        if( $interv_info ){
            $reply = "";
            $reply .= "Intervención número <strong>".$info['id_intervencion']."</strong>, ".$info['estado'].".\n";
            $reply .= "Por hacer...\n";
            $reply .= "";
        } else {
            $this -> sendMessage( 'No estas autorizado a recibir esta información.' );
            return false;
        }
    }
}
