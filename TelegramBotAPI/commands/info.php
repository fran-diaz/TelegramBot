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

        $info = $this -> db -> get('_intervenciones_full','*',['id_intervencion' => $id, 'telegram_user_id' => $user_info['TelegramBot__users_id']]);
        
        if( $info ){
            $reply = "";
            $reply .= "Intervención <strong>".htmlentities($info['id_intervencion'])."</strong>, ".htmlentities($info['tipo_intervencion']).":\n";
            $reply .= "· Estado: ".htmlentities($info['estado'])."\n";
            $reply .= "· Iniciada: ".htmlentities($info['fecha_finalizacion']).' '.htmlentities($info['hora_inicio'])."\n";
            $reply .= "· Finalizada: ".htmlentities($info['fecha_finalizacion']).' '.htmlentities($info['hora_fin'])."\n";
            $reply .= "· Centro de trabajo: ".htmlentities($info['centro_trabajo']).' (<a href="https://maps.google.com/?q='.urlencode($info['direccion']).'" target="_blank">Dirección</a>)'."\n";
            $reply .= "· Técnico: ".htmlentities($info['tecnico'])."\n";
            $reply .= '· <a href="https://app.brainhardware.es/resources/dropbox-files/BRAIN-APP/Intervenciones/'.$id.'%20('.$info['_intervenciones_id'].')/parte-digital-'.$id.'.pdf">Parte de trabajo</a>'."\n";
            $reply .= '· <a href="https://app.brainhardware.es/resources/dropbox-files/BRAIN-APP/Intervenciones/'.$id.'%20('.$info['_intervenciones_id'].')/archivos-'.$id.'.zip">Archivos de la intervención</a>'."\n";
            $reply .= "";
            $this -> sendMessage( $reply );
        } else {
            $this -> sendMessage( 'No estas autorizado a recibir esta información.' );
            return false;
        }
    }
}
