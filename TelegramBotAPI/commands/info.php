<?php
namespace TelegramBotAPI\commands;

trait info {
    public function info( $id = null ){
        if( is_null( $id ) ){
            $this -> sendMessage( 'Tienes que ser más específico.' );
            return false;
        }

        $user_info = $this -> db -> get('TelegramBot__users','*',['user' => $this -> input["message"]["from"]["first_name"]]);
        if( ! $user_info ){
            $this -> sendMessage( 'No nos consta que estés registrado.' );
            return false;
        }

        $info = $this -> db -> get('_intervenciones','*',['id_intervencion' => $id, 'telegram_user_id' => $user_info['TelegramBot__users_id']]);
        
        if( $info ){
            $reply = "";
            $reply .= "Intervención número <strong>".$info['id_intervencion']."</strong>, ".$info['estado'].".\n\n";
            $reply .= "Información por completar...\n";
            $reply .= "";
            $this -> sendMessage( $reply );
        } else {
            $this -> sendMessage( 'No estas autorizado a recibir esta información.' );
            return false;
        }
    }
}
