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
            $this -> sendMessage( 'No me consta que estés registrado.' );
            return false;
        } elseif( $user_info['active'] === '0'){
            $this -> sendMessage( 'Tu nivel de autorización no te permite solicitar esa información.' );
            return false;
        }

        $info = $this -> db -> get('_intervenciones_full','*',['id_intervencion' => $id, 'telegram_user_id' => $user_info['TelegramBot__users_id']]);
        
        if( $info ){
            $reply = "";
            $reply .= "<b><u>INTERVENCIÓN ".htmlentities($info['id_intervencion'])." (".$info['tipo_intervencion']."):</u></b>\n";
            $reply .= "<strong>· Estado:</strong> ".htmlentities($info['estado'])."\n";
            $reply .= "<strong>· Iniciada:</strong> ".date( 'd-m-Y', strtotime( $info['fecha_finalizacion'] ) ).' '.htmlentities($info['hora_inicio'])."\n";
            $reply .= "<strong>· Finalizada:</strong> ".date( 'd-m-Y', strtotime( $info['fecha_finalizacion'] ) ).' '.htmlentities($info['hora_fin'])."\n";
            $reply .= "<strong>· Centro de trabajo:</strong> ".htmlentities($info['centro_trabajo']).' (<a href="https://maps.google.com/?q='.urlencode($info['direccion']).'" target="_blank">Dirección</a>)'."\n";
            $reply .= "<strong>· Técnico:</strong> ".htmlentities($info['tecnico']).' ('.htmlentities($info['telefono_tecnico']).")\n";
            $reply .= '* <a href="https://app.brainhardware.es/resources/dropbox-files/BRAIN-APP/Intervenciones/'.$id.'%20('.$info['_intervenciones_id'].')/parte-digital-'.$id.'.pdf">Parte de trabajo</a>'."\n";
            $reply .= '* <a href="https://app.brainhardware.es/resources/dropbox-files/BRAIN-APP/Intervenciones/'.$id.'%20('.$info['_intervenciones_id'].')/archivos-'.$id.'.zip">Archivos de la intervención</a>'."\n";
            $reply .= "";
            $this -> sendMessage( $reply );
        } else {
            $this -> sendMessage( 'Tu nivel de autorización no te permite solicitar esa información.' );
            return false;
        }
    }
}
