<?php
namespace TelegramBotAPI\commands;

/**
 * Description of help
 *
 * @author Fran Díaz <fran.diaz.gonzalez@gmail.com>
 */
trait help {

    public function help(){
        $reply = "";
        $reply .= "Soy el <strong>asistente de Brain Hardware</strong>, estoy para ayudarte con la información de la APP.\n\n";
        $reply .= "Puedes interaccionar conmigo empleando los siguientes comandos:\n\n";
        $reply .= "/info X - Solicitar información de una intervencion\n";
        $reply .= "/help - Visualizar de nuevo esta ayuda\n";
        $reply .= "";

        $this -> sendMessage( $reply );
    }
}
